export function generatePID() {
  return Math.floor(Math.random() * 10000);
}

export function wait(seconds) {
  return new Promise(resolve => setTimeout(resolve, seconds * 1000));
}

export function logError(logger, message) {
  return new Promise(resolve => {
    logger.error(message, {timestamp: new Date().toISOString()});
    setInterval(() => {
      process.exit(1);
    }, 1000);
  })
}