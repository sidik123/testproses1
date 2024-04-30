const { spawn } = require('child_process');

// Jalankan server_coin.js
const coinServer = spawn('node', ['server_coin.js']);

coinServer.stdout.on('data', (data) => {
  console.log(`[server_coin.js] ${data}`);
});

coinServer.stderr.on('data', (data) => {
  console.error(`[server_coin.js] ${data}`);
});

coinServer.on('close', (code) => {
  console.log(`[server_coin.js] Proses berhenti dengan kode keluar: ${code}`);
});

// Jalankan server_dp.js
const dpServer = spawn('node', ['server_dp.js']);

dpServer.stdout.on('data', (data) => {
  console.log(`[server_dp.js] ${data}`);
});

dpServer.stderr.on('data', (data) => {
  console.error(`[server_dp.js] ${data}`);
});

dpServer.on('close', (code) => {
  console.log(`[server_dp.js] Proses berhenti dengan kode keluar: ${code}`);
});

// Jalankan server_wd.js
const wdServer = spawn('node', ['server_wd.js']);

wdServer.stdout.on('data', (data) => {
  console.log(`[server_wd.js] ${data}`);
});

wdServer.stderr.on('data', (data) => {
  console.error(`[server_wd.js] ${data}`);
});

wdServer.on('close', (code) => {
  console.log(`[server_wd.js] Proses berhenti dengan kode keluar: ${code}`);
});
