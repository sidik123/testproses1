const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const fetch = require('isomorphic-fetch');

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

// Handle HTTP requests
app.get('/', (req, res) => {
  res.send('WebSocket server is running.');
});

// WebSocket connection handling
wss.on('connection', (ws) => {
  console.log('Client connected.');

  let previousData = null; // Menyimpan data sebelumnya

  // Fungsi untuk mengirim data ke klien hanya 1x
  function sendDataToClient(data) {
    if (data !== previousData) {
      ws.send(data);
      previousData = data;
    }
  }

  // Example: Fetch data from realtime_member.php every 5 seconds and send it to the client
  const interval = setInterval(() => {
    fetch('https://testproses1.cyberpannel.biz.id/admin_realtime/realtime_formdepo.php') // Replace with the correct URL of your realtime_member.php file
    // fetch('https://testproses1.cyberpannel.biz.id/admin_realtime/realtime_formdepo.php') // Replace with the correct URL of your realtime_member.php file
      .then((response) => response.text())
      .then((data) => {
        if (!data && previousData) {
          // Jika data kosong setelah sebelumnya ada data, kirim ke klien hanya 1x
          sendDataToClient(data);
        } else if (data && !previousData) {
          // Jika ada data setelah sebelumnya kosong, kirim ke klien hanya 1x
          sendDataToClient(data);
        } else if (data && data !== previousData) {
          // Jika ada pembaharuan data, kirim ke klien hanya 1x
          sendDataToClient(data);
        }
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }, 500); // Ubah interval sesuai kebutuhan Anda, dalam milidetik (ms)

  // Event listener for WebSocket connection close
  ws.on('close', () => {
    console.log('Client disconnected.');
    clearInterval(interval); // Clear the interval when the client disconnects
  });
});

// Start the server
const port = 8080; // You can change this to any port number you prefer
server.listen(port, () => {
  console.log(`Server started on port ${port}`);
});


// UNTUK DI WEBSITE ASLI

// const express = require('express');
// const https = require('https');
// const WebSocket = require('ws');
// const fetch = require('isomorphic-fetch');
// const fs = require('fs');
// const agent = new https.Agent({ rejectUnauthorized: false, keepAlive: true });

// const app = express();
// const server = https.createServer({
//   cert: fs.readFileSync('/root/certificate.crt'), // Ganti dengan jalur file sertifikat Anda
//   key: fs.readFileSync('/root/private.key') // Ganti dengan jalur file kunci privat Anda
// }, app);
// const wss = new WebSocket.Server({ server });

// // Handle HTTP requests
// app.get('/', (req, res) => {
//   res.send('WebSocket server is running.');
// });

// // WebSocket connection handling
// wss.on('connection', (ws) => {
//   console.log('Client connected.');

//   let previousData = null; // Menyimpan data sebelumnya

//   // Fungsi untuk mengirim data ke klien hanya 1x
//   function sendDataToClient(data) {
//     if (data !== previousData) {
//       ws.send(data);
//       previousData = data;
//     }
//   }

//   // Example: Fetch data from realtime_member.php every 5 seconds and send it to the client
//   const interval = setInterval(() => {
//     fetch('https://testing2.b138gacor.online/admin_realtime/realtime_formdepo.php', { agent }) // Ganti dengan URL yang sesuai untuk realtime_member.php Anda
//       .then((response) => response.text())
//       .then((data) => {
//         if (!data && previousData) {
//           // Jika data kosong setelah sebelumnya ada data, kirim ke klien hanya 1x
//           sendDataToClient(data);
//         } else if (data && !previousData) {
//           // Jika ada data setelah sebelumnya kosong, kirim ke klien hanya 1x
//           sendDataToClient(data);
//         } else if (data && data !== previousData) {
//           // Jika ada pembaharuan data, kirim ke klien hanya 1x
//           sendDataToClient(data);
//         }
//       })
//       .catch((error) => {
//         console.error('Error:', error);
//       });
//   }, 500); // Ubah interval sesuai kebutuhan Anda, dalam milidetik (ms)

//   // Event listener for WebSocket connection close
//   ws.on('close', () => {
//     console.log('Client disconnected.');
//     clearInterval(interval); // Clear the interval when the client disconnects
//   });
// });

// // Start the server
// const port = 8080; // Anda dapat mengganti ini dengan nomor port yang diinginkan
// server.listen(port, () => {
//   console.log(`Server started on port ${port}`);
// });