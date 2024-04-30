<?php
// Koneksi ke database
include("../fungsi/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data yang dikirim dari AJAX
  $id = $_POST['id'];
  $updatedBank = $_POST['bank'];
  $updatedNoRek = $_POST['noRek'];
  $updatedNamaBank = $_POST['namaBank'];
  $updatedPotongan = $_POST['potongan']; // Add this line
  $updatedStatus = $_POST['status'];

  // Update data dalam database
  $query = "UPDATE bank_list SET admin_bank=?, admin_norek=?, admin_namabank=?, potongan=?, status=? WHERE id=?"; // Modify the query
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "sssssi", $updatedBank, $updatedNoRek, $updatedNamaBank, $updatedPotongan, $updatedStatus, $id); // Modify the parameter binding
  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    // Jika pembaruan berhasil
    $response = array('status' => 'success', 'message' => 'Data updated successfully');
    echo json_encode($response);
  } else {
    // Jika terjadi kesalahan saat pembaruan data
    $response = array('status' => 'error', 'message' => 'Failed to update data');
    echo json_encode($response);
  }

  mysqli_stmt_close($stmt);
}

?>
