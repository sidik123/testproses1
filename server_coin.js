// // Import library WebSocket
// const WebSocket = require('ws');
// const mysql = require('mysql');
// require('dotenv').config(); // Mengimpor modul dotenv

// // Buat koneksi WebSocket server
// const wss = new WebSocket.Server({ port: 3000 });

// // Fungsi untuk mengirim data ke semua klien yang terhubung
// function sendDataToClients(data) {
// wss.clients.forEach(client => {
// if (client.readyState === WebSocket.OPEN) {
// client.send(JSON.stringify(data));
// }
// });
// }

// // Fungsi untuk mengambil data coin dari database
// function getCoinData() {
// const dbHost = process.env.DB_HOST;
// const dbUser = process.env.DB_USER;
// const dbPassword = process.env.DB_PASSWORD;
// const dbDatabase = process.env.DB_DATABASE;

// // Buat koneksi MySQL
// const connection = mysql.createConnection({
// host: dbHost,
// user: dbUser,
// password: dbPassword,
// database: dbDatabase
// });

// // Lakukan koneksi ke database
// connection.connect();

// // Query untuk mengambil data coin dari tabel master_admin dengan username 'admin'
// const query = `SELECT coin FROM master_admin WHERE username = 'admin'`;

// // Eksekusi query
// connection.query(query, (error, results) => {
// if (error) {
// console.error('Error executing query:', error);
// return;
// }

// // Ambil nilai coin dari hasil query
// const coin = results[0]?.coin || 0;

// // Kirim nilai coin ke semua klien yang terhubung
// sendDataToClients(parseInt(coin, 10));

// // Tutup koneksi ke database
// connection.end();
// });
// }

// // Event handler saat ada koneksi baru
// wss.on('connection', ws => {
// console.log('Client connected');

// // Event handler saat koneksi ditutup
// ws.on('close', () => {
// console.log('Client disconnected');
// });
// });

// // Panggil fungsi getCoinData setiap beberapa detik (misalnya setiap 5 detik)
// setInterval(getCoinData, 1000);


// MENGAMBIL DATA COIN DARI WEB ASLI
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
    fetch('https://testproses1.cyberpannel.biz.id/admin_realtime/realtime_coin.php') // Replace with the correct URL of your realtime_member.php file
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
const port = 3000; // You can change this to any port number you prefer
server.listen(port, () => {
  console.log(`Server started on port ${port}`);
});