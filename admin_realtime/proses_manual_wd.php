<?php
session_start();
include("../fungsi/koneksi.php");

    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_update = date('Y-m-d H:i:s');

// Ambil nilai dari form
$username = $_POST['usernameInput'] ?? '';
$bank = $_POST['userBank'] ?? '';
$namaBank = $_POST['userNamaBank'] ?? '';
$norek = $_POST['userNorek'] ?? '';
$nominal = $_POST['nominalInput'] ?? '';
$adminNote = $_POST['noteAdmin'] ?? '';

// Set nilai lainnya
$jenisForm = 'manual_withdraw';
$prosesOleh = $_SESSION['admin_username'];
$status = 'proses';
$tanggalMasuk = $tanggal_update;
$tanggalUpdate = $tanggal_update;


// Periksa apakah semua input terisi
if (empty($username) || empty($nominal)) {
    die('Mohon lengkapi semua isian form.');
}

// Query INSERT INTO
$query = "INSERT INTO wd_history (username, bank, nama_bank, norek, nominal, admin_note, jenis_form, proses_oleh, status, tanggal_masuk, tanggal_update, dicek_oleh) VALUES ('$username', '$bank', '$namaBank', '$norek', '$nominal', '$adminNote', '$jenisForm', '$prosesOleh', '$status', '$tanggalMasuk', '$tanggalUpdate', '$prosesOleh')";

// Query untuk mengambil data member berdasarkan usernames
$query_member = "SELECT * FROM member WHERE username = '$username'";
$result_member = $koneksi->query($query_member);

// Periksa apakah data member ditemukan
if ($result_member->num_rows > 0) {
    // Mendapatkan data member
    $row_member = $result_member->fetch_assoc();
    
    // Mendapatkan nilai coin dari data member
    $coin = $row_member['coin'];
    
    // Menambahkan nilai coin berdasarkan nominal yang dikirim
    $coin -= $nominal;
    
    // Update nilai coin ke dalam database member
    $query_update_coin = "UPDATE member SET coin = '$coin' WHERE username = '$username'";
    $koneksi->query($query_update_coin);
} else {
    die('Username tidak ditemukan.');
}

// Query untuk mengambil data admin berdasarkan username
$query_admin = "SELECT * FROM master_admin WHERE username = 'admin'";
$result_admin = $koneksi->query($query_admin);

// Periksa apakah data admin ditemukan
if ($result_admin->num_rows > 0) {
    // Mendapatkan data admin
    $row_admin = $result_admin->fetch_assoc();
    
    // Mendapatkan nilai coin dari data admin
    $admin_coin = $row_admin['coin'];
    
    // Mengurangi nilai coin dengan nominal yang dikirim
    $admin_coin += $nominal;
    
    // Update nilai coin admin ke dalam database master_admin
    $query_update_admin_coin = "UPDATE master_admin SET coin = '$admin_coin' WHERE username = 'admin'";
    $koneksi->query($query_update_admin_coin);
} else {
    die('Data admin tidak ditemukan.');
}

// Menjalankan query
$result = $koneksi->query($query);

// Menutup koneksi database
$koneksi->close();
?>
