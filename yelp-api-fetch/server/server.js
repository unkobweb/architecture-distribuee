import net from 'net';

const sockets = [];

const server = net.createServer(function(socket) { //'connection' listener
  
  socket.name = socket.remoteAddress + ":" + socket.remotePort 

  sockets.push(socket);

  console.log(socket.name + ' joined to broadcasr.');

  // When client leaves
  socket.on('end', function() {
      console.log(socket.name + " left the broadcast.\n");
      // Remove client from socket array
      sockets.splice(sockets.indexOf(socket), 1);
  });

  socket.on('error', function(error) {
    console.log('Socket got problems: ', error.message);
  });

  socket.on('data', function(chunk) {
    // Broadcast to all clients
    for (let i = 0; i < sockets.length; i++) {
      sockets[i].write(chunk+'\r\n');
    }
  })
});

server.listen(9999, function() { //'listening' listener
  console.log('server bound');
});