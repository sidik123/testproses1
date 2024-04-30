<?php
include("../fungsi/koneksi.php");

session_start();

$status = $_POST['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_update = date('Y-m-d H:i:s');

    if ($status === 'proses') {
        $query = "UPDATE panelformdeposit SET status='proses', tanggal_update='$tanggal_update' WHERE status='tahan'";

        if (mysqli_query($koneksi, $query)) {
            // Proses setiap form yang memiliki status "proses"
            $selectQuery = "SELECT * FROM panelformdeposit WHERE status='proses'";
            $selectResult = mysqli_query($koneksi, $selectQuery);

            if ($selectResult && mysqli_num_rows($selectResult) > 0) {
                while ($formData = mysqli_fetch_assoc($selectResult)) {
                    // Mengambil data form
                    $id = $formData['id'];
                    $adminNote = $_POST['admin_note'];

                    // Mengambil username dari session login
                    $processedBy = $_SESSION['admin_username'];
                    $dicekOleh = $_SESSION['admin_username'];

                    // Tentukan nominal yang akan dikirim
                    if (!empty($formData['promotiontitle']) && $formData['promotiontitle'] === "DEPOSIT PULSA TANPA POTONGAN") {
                        $nominal = $formData['nominal'];
                    } else {
                        $nominal = ($formData['potongan'] > 1) ? $formData['nominal'] - ($formData['nominal'] * $formData['potongan'] / 100) : $formData['nominal'];
                    }

                    // Simpan isi form ke dalam database dp_history
                    $insertQuery = "INSERT INTO dp_history (id_transaksi, username, bank, nama_bank, norek, tujuan_admin_bank, tujuan_admin_namabank, tujuan_admin_norek, nominal, note, tanggal_masuk, tanggal_update, status, admin_note, jenis_form, proses_oleh, potongan, dicek_oleh, promo_id, promotiontitle, promotiondp) VALUES ";
                    $insertQuery .= "('".$formData['id']."', '".$formData['username']."', '".$formData['bank']."', '".$formData['nama_bank']."', '".$formData['norek']."', '".$formData['tujuan_admin_bank']."', '".$formData['tujuan_admin_namabank']."', '".$formData['tujuan_admin_norek']."', '".$nominal."', '".$formData['note']."', '".$formData['tanggal_masuk']."', '$tanggal_update', '$status', '$adminNote', 'deposit', '$processedBy', '".$formData['potongan']."', '$dicekOleh', '".$formData['promo_id']."', '".$formData['promotiontitle']."', '".$formData['promotiondp']."')";
        
                    if (mysqli_query($koneksi, $insertQuery)) {
                        // Check if promo_id matches cuid in promodepo table
                        $promo_id = $formData['promo_id'];
                        $promotiondp = $formData['promotiondp'];
                        $promotiontitle = $formData['promotiontitle'];

                        $promoQuery = "SELECT * FROM promodepo WHERE cuid = '$promo_id'";
                        $promoResult = mysqli_query($koneksi, $promoQuery);

                        if ($promoResult && mysqli_num_rows($promoResult) > 0) {
                            $promoData = mysqli_fetch_assoc($promoResult);
                            $min_to = $promoData['min_to'];
                            $max_bonus = $promoData['max_bonus'];
                            
                            // Hitung turnover
                            $turnover = $nominal * $min_to;

                        // Lakukan SELECT query untuk memeriksa apakah username sudah ada di database turnover_member
                        $checkQuery = "SELECT * FROM turnover_member WHERE username = '".$formData['username']."'";
                        $checkResult = mysqli_query($koneksi, $checkQuery);

                        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                            // Jika hasilnya tidak kosong, lakukan operasi UPDATE
                            $insertTurnoverQuery = "UPDATE turnover_member SET id_transaksi = '$id', deposit = '$nominal', promo_id = '$promo_id', promo_title = '$promotiontitle', jumlah_promo = '$promotiondp', turnover = '$turnover', status = 'belum tercapai' WHERE username = '".$formData['username']."'";
                        } else {
                            // Jika hasilnya kosong, lakukan operasi INSERT
                            $insertTurnoverQuery = "INSERT INTO turnover_member (id_transaksi, username, deposit, promo_id, promo_title, jumlah_promo, turnover, status) VALUES ('$id', '".$formData['username']."', '$nominal', '$promo_id', '$promotiontitle', '$promotiondp', '$turnover', 'belum tercapai')";
                        }

                            // Menghitung nilai tambahan dari promotiondp, kecuali jika promotiontitle adalah 'DEPOSIT PULSA TANPA POTONGAN'
                            $additionalPromotion = 0;
                            if ($formData['promotiontitle'] !== "DEPOSIT PULSA TANPA POTONGAN") {
                                $additionalPromotion = $nominal * ($formData['promotiondp'] / 100);

                                // Jika additionalPromotion melebihi max_bonus, ubah menjadi max_bonus
                                if ($additionalPromotion > $max_bonus) {
                                    $additionalPromotion = $max_bonus;
                                }

                                // Menambahkan nilai promotiondp ke nominal
                                $nominal += $additionalPromotion;
                            }
                            
                            if (mysqli_query($koneksi, $insertTurnoverQuery)) {

                                // Update kolom nominal di dp_history jika id_transaksi sama dengan id di panelformdeposit
                                $updateNominalQuery = "UPDATE dp_history SET nominal = '$nominal' WHERE id_transaksi = '$id'";
                                if (mysqli_query($koneksi, $updateNominalQuery)) {
                                    echo "Kolom nominal di dp_history berhasil diperbarui";
                                } else {
                                    echo "Error saat memperbarui kolom nominal di dp_history: " . mysqli_error($koneksi);
                                }
                            } else {
                                echo "Error saat menyimpan data ke database turnover_member: " . mysqli_error($koneksi);
                            }
                        } else {
                            echo "Error: Tidak dapat menemukan promo_id yang cocok";
                        }

                        // Mengurangi coin dari nominal yang sudah diproses di database master_admin
                        $updateMasterAdminQuery = "UPDATE master_admin SET coin = coin - '".$nominal."'";

                        // Cek apakah username yang sedang diproses adalah admin
                        if ($formData['username'] !== 'admin') {
                            $updateMasterAdminQuery .= " WHERE id = 1";
                        } else {
                            $updateMasterAdminQuery .= " WHERE username = 'admin'";
                        }

                        if (mysqli_query($koneksi, $updateMasterAdminQuery)) {
                            // Update coin value in member's database
                            $updateMemberQuery = "UPDATE member SET coin = coin + '".$nominal."' WHERE username = '".$formData['username']."'";
                            if (mysqli_query($koneksi, $updateMemberQuery)) {
                                // Hapus form yang telah diproses
                                $deleteQuery = "DELETE FROM panelformdeposit WHERE id='$id'";
                                if (mysqli_query($koneksi, $deleteQuery)) {
                                    continue; // Lanjut ke form berikutnya
                                } else {
                                    echo "Error saat menghapus form: " . mysqli_error($koneksi);
                                    break; // Keluar dari loop jika terjadi kesalahan
                                }
                            } else {
                                echo "Error saat memperbarui coin di database member: " . mysqli_error($koneksi);
                                break; // Keluar dari loop jika terjadi kesalahan
                            }
                        } else {
                            echo "Error saat mengurangi coin dari nominal yang sudah diproses: " . mysqli_error($koneksi);
                            break; // Keluar dari loop jika terjadi kesalahan
                        }
                    } else {
                        echo "Error saat menyimpan data form: " . mysqli_error($koneksi);
                        break; // Keluar dari loop jika terjadi kesalahan
                    }
                }
            }

            echo "Semua form berhasil diproses.";
        } else {
            echo "Error saat memperbarui status: " . mysqli_error($koneksi);
        }
    }
    
    mysqli_close($koneksi);
}
?>
