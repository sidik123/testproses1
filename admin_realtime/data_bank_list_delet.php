<?php
include("../fungsi/koneksi.php");

// Ambil data yang dikirim melalui POST
$id = $_POST['id'];

// Query untuk menghapus data dari tabel bank_list
$sql = "DELETE FROM bank_list WHERE id = '$id'";

// Jalankan query
if ($koneksi->query($sql) === TRUE) {
    echo 'Data deleted successfully.';
} else {
    echo 'Error: ' . $sql . '<br>' . $koneksi;
}

// Tutup koneksi database
$koneksi->close();
?>
