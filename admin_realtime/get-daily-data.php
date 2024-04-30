<?php
include "../fungsi/koneksi.php";

// Set timezone ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Ambil tanggal hari ini
$current_date = date("Y-m-d");

// Hitung tanggal tujuh hari ke belakang
$seven_days_ago = date("Y-m-d", strtotime("-7 days", strtotime($current_date)));

// Query untuk mengambil total deposit per hari untuk 7 hari terakhir sampai hari ini
$sql_deposit_per_day = "SELECT DATE(tanggal_masuk) AS tanggal, SUM(nominal) AS total_nominal_dp FROM dp_history WHERE status = 'proses' AND DATE(tanggal_masuk) BETWEEN '$seven_days_ago' AND '$current_date' GROUP BY DATE(tanggal_masuk) ORDER BY tanggal_masuk ASC";

// Query untuk mengambil total withdraw per hari untuk 7 hari terakhir sampai hari ini
$sql_withdraw_per_day = "SELECT DATE(tanggal_masuk) AS tanggal, SUM(nominal) AS total_nominal_wd FROM wd_history WHERE status = 'proses' AND DATE(tanggal_masuk) BETWEEN '$seven_days_ago' AND '$current_date' GROUP BY DATE(tanggal_masuk) ORDER BY tanggal_masuk ASC";

$result_deposit_per_day = $koneksi->query($sql_deposit_per_day);
$result_withdraw_per_day = $koneksi->query($sql_withdraw_per_day);

$deposit_data = [];
$withdraw_data = [];

// Mengambil data deposit
if ($result_deposit_per_day->num_rows > 0) {
    while ($row = $result_deposit_per_day->fetch_assoc()) {
        $deposit_data[$row['tanggal']] = $row['total_nominal_dp'];
    }
}

// Mengambil data withdraw
if ($result_withdraw_per_day->num_rows > 0) {
    while ($row = $result_withdraw_per_day->fetch_assoc()) {
        $withdraw_data[$row['tanggal']] = $row['total_nominal_wd'];
    }
}

// Mengirim data dalam format JSON
$data = [
    'deposit' => $deposit_data,
    'withdraw' => $withdraw_data
];

header('Content-Type: application/json');
echo json_encode($data);

// Tutup koneksi database
$koneksi->close();
?>
