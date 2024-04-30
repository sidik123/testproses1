<?php
include("../fungsi/koneksi.php");

// Ambil data yang dikirim melalui POST
$bank = $_POST['bank'];
$noRek = $_POST['noRek'];
$namaBank = $_POST['namaBank'];
$potongan = $_POST['potongan'];
$status = $_POST['status'];

// Query untuk menyimpan data baru ke dalam tabel bank_list
$sql = "INSERT INTO bank_list (admin_bank, admin_norek, admin_namabank, potongan, status) VALUES ('$bank', '$noRek', '$namaBank', '$potongan', '$status')";

// Jalankan query
if ($koneksi->query($sql) === TRUE) {
    echo 'Data inserted successfully.';
} else {
    echo 'Error: ' . $sql . '<br>' . $koneksi;
}

// Tutup koneksi database
$koneksi->close();
?>
