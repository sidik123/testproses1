<?php
include("../fungsi/koneksi.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_update = date('Y-m-d H:i:s');

    if ($status === 'proses') {
        // Perbarui status form yang sedang dalam proses
        $updateQuery = "UPDATE panelformwd SET status='proses', tanggal_update='$tanggal_update' WHERE status='tahan'";
        if (mysqli_query($koneksi, $updateQuery)) {
            // Proses setiap form yang memiliki status "proses"
            $selectQuery = "SELECT * FROM panelformwd WHERE status='proses'";
            $selectResult = mysqli_query($koneksi, $selectQuery);

            if ($selectResult && mysqli_num_rows($selectResult) > 0) {
                while ($formData = mysqli_fetch_assoc($selectResult)) {
                    // Mengambil data form
                    $id = $formData['id'];
                    $adminNote = $_POST['admin_note'];

                    // Tentukan nominal yang akan dikirim
                    $processedBy = $_SESSION['admin_username'];
                    $nominal = $formData['nominal'];

                    // Simpan isi form ke dalam database wd_history
                    $insertQuery = "INSERT INTO wd_history (username, bank, nama_bank, norek, nominal, note, tanggal_masuk, tanggal_update, status, admin_note, jenis_form, proses_oleh, dicek_oleh) VALUES ";
                    $insertQuery .= "('".$formData['username']."', '".$formData['bank']."', '".$formData['nama_bank']."', '".$formData['norek']."', '".$nominal."', '".$formData['note']."', '".$formData['tanggal_masuk']."', '$tanggal_update', '$status', '$adminNote', 'withdraw', '$processedBy', '".$formData['dicek_oleh']."')";

                    if (mysqli_query($koneksi, $insertQuery)) {
                        echo "Form berhasil diproses dan disimpan dalam wd_history.";

                        $updateMasterAdminQuery = "UPDATE master_admin SET coin = coin + '$nominal' WHERE name = 'MASTER ADMIN'";
                        if (mysqli_query($koneksi, $updateMasterAdminQuery)) {
                            echo "Data MASTER ADMIN berhasil diperbarui dengan coin tambahan";
                        } else {
                            echo "Error saat memperbarui data MASTER ADMIN: " . mysqli_error($koneksi);
                        }

                        // Menghapus form yang telah diupdate
                        $deleteQuery = "DELETE FROM panelformwd WHERE id='$id'";
                        if (mysqli_query($koneksi, $deleteQuery)) {
                            echo "Form berhasil dihapus dari panelformwd.";
                        } else {
                            echo "Error saat menghapus form dari panelformwd: " . mysqli_error($koneksi);
                        }
                    } else {
                        echo "Error saat menyimpan form dalam wd_history: " . mysqli_error($koneksi);
                    }
                }
            } else {
                echo "Tidak ada form yang sedang dalam proses.";
            }
        } else {
            echo "Error saat memperbarui status form: " . mysqli_error($koneksi);
        }
    }
}

mysqli_close($koneksi);
?>
