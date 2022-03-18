import axios from 'axios';
import * as winston from 'winston';
import 'winston-daily-rotate-file';
import path from 'path';
import express from 'express';
import { generatePID, wait, logError } from './utils.js';
import net from 'net';
const { combine, timestamp, label, printf } = winston.format;

const app = express();

const myFormat = printf(({ level, message, label, timestamp }) => {
  return `${timestamp} [${label}] ${level}: ${message}`;
});

process.env.YELP_API_KEY = 'zDT978N3XYa88JnNYdI33IzROBCJAxOdMjB2_obzH8IrYGRe_Z6iF05rWZJRH4aG4HXoomSq_1KaqW6JcqbSTN9AbeDsLpPC7pZqZoEmxxaVvG7w1EUym7OqSPwqYnYx';
process.env.LOCATION = 'nantes';

const PID = process.env.PID || generatePID();

// Create a logger who will log in file (json format) and console
const logger = winston.createLogger({
  format: combine(
    label({ label: PID }),
    timestamp(),
    myFormat
  ),
  defaultMeta: {
    pid: PID
  },
  transports: [
    new winston.transports.DailyRotateFile({
      filename: path.resolve(`./logs/yelp_%DATE%.log`),
      datePattern: 'YYYY-MM-DD',
      zippedArchive: false,
      maxSize: '10m'
    }),
    new winston.transports.Console({ format: winston.format.simple() }),
  ],
});

// Create a health check endpoint
app.use('/', (req, res) => {
  res.sendStatus(200);
})

app.listen(PID, () => {
  logger.info(`Health check of process is running on port 80`);
})

// Check if needed environment variable are sets
const envVarsNeeded = ['YELP_API_KEY', 'LOCATION'];
for (let i = 0; i < envVarsNeeded.length; i++) {
  if (!process.env[envVarsNeeded[i]]) {
    await logError(logger,`${envVarsNeeded[i]} environment variable is not set`);
  }
}

logger.info(`${envVarsNeeded.join(', ')} environment variables are set`);

let offset = 0;

const server = net.createServer(async function(c) { //'connection' listener
  while(true) {
    try {
      const yelp = axios.create({
        baseURL: 'https://api.yelp.com/v3/businesses',
        headers: {
          Authorization: `Bearer ${process.env.YELP_API_KEY}`,
        },
      });
  
      logger.info(`Fetch /search?location=${process.env.LOCATION}&limit=50&offset=${offset}`);
  
      const res = await yelp.get('/search', {
        params: {
          location: process.env.LOCATION,
          limit: 50,
        },
      });
  
      logger.info(`${res.data.businesses.length} businesses found`);

      c.write(JSON.stringify(res.data) + '\r\n');
      c.pipe(c);
      
      if (res.data.businesses.length < 50) {
        logger.info('No more businesses to fetch');
        offset = 0;
      } else {
        offset += 50;
      }
  
      await wait(2);
    } catch (error) {
      await logError(logger, error);
    }
  }
});
server.listen(9999, function() { //'listening' listener
  console.log('server bound');
});