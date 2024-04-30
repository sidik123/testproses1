<?php
session_start();

include("../fungsi/koneksi.php");

$status = $_POST['status'];
$id = $_POST['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $id = $_POST['id'];

    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_update = date('Y-m-d H:i:s');

    $dicekOleh = $_SESSION['admin_username'];

    // Memperbarui status dan tanggal_update di database
    $query = "UPDATE panelformdeposit SET status='$status', tanggal_update='$tanggal_update', dicek_oleh='$dicekOleh'";

    // Jika status adalah "tolak", tambahkan juga pembaruan untuk admin_note
    if ($status === 'tolak') {
        $adminNote = $_POST['admin_note'];
        $query .= ", admin_note='$adminNote'";
    }

    $query .= " WHERE id='$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "Status berhasil diperbarui";
    } else {
        echo "Error saat memperbarui status: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
