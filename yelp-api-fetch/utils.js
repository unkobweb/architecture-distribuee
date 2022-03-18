function generatePID() {
  return Math.floor(Math.random() * 10000);
}

function wait(seconds) {
  return new Promise(resolve => setTimeout(resolve, seconds * 1000));
}

function logError(logger, message) {
  return new Promise(resolve => {
    logger.error(message, {timestamp: new Date().toISOString()});
    setInterval(() => {
      process.exit(1);
    }, 1000);
  })
}

module.exports = {generatePID, wait, logError};