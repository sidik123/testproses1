<?php
include("../fungsi/koneksi.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan status dan id ada dalam $_POST
    if (isset($_POST['status'], $_POST['id'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];

        // Mendapatkan tanggal dan waktu saat ini
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_update = date('Y-m-d H:i:s');

        // Memperbarui status dan tanggal_update di database
        $query = "UPDATE panelformwd SET status='$status', tanggal_update='$tanggal_update'";

        // Jika status adalah "tolak", tambahkan juga pembaruan untuk admin_note
        if ($status === 'tolak') {
            // Pastikan admin_note ada dalam $_POST
            if (isset($_POST['admin_note'])) {
                $adminNote = $_POST['admin_note'];
                $query .= ", admin_note='$adminNote'";
            } else {
                echo "Error: admin_note tidak ditemukan dalam POST data";
                exit; // Hentikan eksekusi skrip jika admin_note tidak ditemukan
            }
        }

        $query .= " WHERE id='$id'";

        if (mysqli_query($koneksi, $query)) {
            echo "Status berhasil diperbarui";

            // Menyimpan isi form ke dalam database dp_history
            $formQuery = "SELECT * FROM panelformwd WHERE id='$id'";
            $formResult = mysqli_query($koneksi, $formQuery);

            if ($formResult && mysqli_num_rows($formResult) > 0) {
                $formData = mysqli_fetch_assoc($formResult);

                // Tentukan nominal yang akan dikirim
                $nominal = $formData['nominal'];

                // Simpan isi form ke dalam database dp_history
                $insertQuery = "INSERT INTO wd_history (username, bank, nama_bank, norek, nominal, note, tanggal_masuk, tanggal_update, status, admin_note, jenis_form, proses_oleh, dicek_oleh) VALUES ";
                $insertQuery .= "('".$formData['username']."', '".$formData['bank']."', '".$formData['nama_bank']."', '".$formData['norek']."', '".$nominal."', '".$formData['note']."', '".$formData['tanggal_masuk']."', '$tanggal_update', '$status', '$adminNote', 'withdraw', '".$_SESSION['admin_username']."', '".$formData['dicek_oleh']."')";

                if (mysqli_query($koneksi, $insertQuery)) {
                    echo "Data form berhasil disimpan ke dalam dp_history";

                    // Update database master_admin hanya jika status adalah 'setujui'
                    if ($status === 'proses') {
                        $updateMasterAdminQuery = "UPDATE master_admin SET coin = coin + '$nominal' WHERE name = 'MASTER ADMIN'";
                        if (mysqli_query($koneksi, $updateMasterAdminQuery)) {
                            echo "Data MASTER ADMIN berhasil diperbarui dengan coin tambahan";
                        } else {
                            echo "Error saat memperbarui data MASTER ADMIN: " . mysqli_error($koneksi);
                        }
                    } elseif ($status === 'tolak') {
                        // Jika status adalah "tolak", tambahkan juga pembaruan untuk member
                        $returnCoinQuery = "UPDATE member SET coin = coin + '$nominal' WHERE username = '".$formData['username']."'";
                        if (mysqli_query($koneksi, $returnCoinQuery)) {
                            echo "Nilai nominal berhasil dikembalikan ke dalam koin.";
                        } else {
                            echo "Error saat mengembalikan nilai nominal ke dalam koin: " . mysqli_error($koneksi);
                        }
                    }
                } else {
                    echo "Error saat menyimpan data form: " . mysqli_error($koneksi);
                }
            } else {
                echo "Form tidak ditemukan";
            }
        } else {
            echo "Error saat memperbarui status: " . mysqli_error($koneksi);
        }

        // Menghapus form yang telah diupdate
        $deleteQuery = "DELETE FROM panelformwd WHERE id='$id'";
        if (mysqli_query($koneksi, $deleteQuery)) {
            echo "Form berhasil dihapus";
        } else {
            echo "Error saat menghapus form: " . mysqli_error($koneksi);
        }

        mysqli_close($koneksi);
    } else {
        echo "Error: Data yang dibutuhkan tidak tersedia dalam POST";
    }
}
?>
