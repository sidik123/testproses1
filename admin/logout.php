<?php
session_start();
include("../fungsi/koneksi.php");

// Mendapatkan username dari sesi
$username = $_SESSION['admin_username'];

// Menghapus status_login di database
$sql3 = "UPDATE master_admin SET status_login = '' WHERE username = '$username'";
mysqli_query($koneksi, $sql3);

// Menghapus semua data sesi
session_unset();
// Menghancurkan sesi
session_destroy();

// Menghapus cookie sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Mengarahkan pengguna ke halaman login
header("Location: ../admin/login.php");
exit;
?>
