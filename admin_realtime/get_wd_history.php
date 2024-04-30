<?php
// Menginclude file koneksi.php
include "../fungsi/koneksi.php";

// Query untuk mengambil data dari tabel dp_history
$sql = "SELECT username, bank, nama_bank, norek, nominal, note, tanggal_masuk, tanggal_update, status, admin_note, jenis_form, proses_oleh, dicek_oleh FROM wd_history";
$result = $koneksi->query($sql);

// Membuat array kosong untuk menyimpan data
$data = array();

// Memeriksa apakah terdapat data yang ditemukan
if ($result->num_rows > 0) {
    // Loop melalui setiap baris data dan menambahkannya ke array data
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Menutup koneksi database
$koneksi->close();

// Mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
