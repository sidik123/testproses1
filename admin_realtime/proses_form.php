<?php
include("../fungsi/koneksi.php");

session_start();

function addHyphens($str) {
    // Helper function to add hyphens to a string after every three characters
    if (strlen($str) === 10) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 3) . "-" . substr($str, 6);
 } else if (strlen($str) === 15) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 4) . "-" . substr($str, 7, 4) . "-" . substr($str, 11);
 } else if (strlen($str) === 13) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 3) . "-" . substr($str, 6, 3) . "-" . substr($str, 9);
 } else if (strlen($str) === 12) {
     $str = substr($str, 0, 4) . "-" . substr($str, 4, 4) . "-" . substr($str, 8, 4);
 } else if (strlen($str) > 15) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 4) . "-" . substr($str, 7, 4) . "-" . substr($str, 11, 4) . "-" . substr($str, 15);
 } else if (strlen($str) > 13) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 3) . "-" . substr($str, 6, 3) . "-" . substr($str, 9, 4) . "-" . substr($str, 13);
 } else if (strlen($str) > 12) {
     $str = substr($str, 0, 4) . "-" . substr($str, 4, 4) . "-" . substr($str, 8, 4) . "-" . substr($str, 12);
 } else if (strlen($str) > 10) {
     $str = substr($str, 0, 3) . "-" . substr($str, 3, 3) . "-" . substr($str, 6, 4) . "-" . substr($str, 10);
 }
 return $str;
}

$status = $_POST['status'];
$id = $_POST['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $id = $_POST['id'];

    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_update = date('Y-m-d H:i:s');

    // Memperbarui status dan tanggal_update di database
    $query = "UPDATE panelformdeposit SET status='$status', tanggal_update='$tanggal_update'";

    // Jika status adalah "tolak", tambahkan juga pembaruan untuk admin_note
    if ($status === 'tolak') {
        $adminNote = $_POST['admin_note'];
        $query .= ", admin_note='$adminNote'";
    }

    $query .= " WHERE id='$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "Status berhasil diperbarui";

        // Menyimpan isi form ke dalam database dp_history
        $formQuery = "SELECT * FROM panelformdeposit WHERE id='$id'";
        $formResult = mysqli_query($koneksi, $formQuery);

        if ($formResult && mysqli_num_rows($formResult) > 0) {
            $formData = mysqli_fetch_assoc($formResult);

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
            $insertQuery .= "('".$formData['id']."', '".$formData['username']."', '".$formData['bank']."', '".$formData['nama_bank']."', '".$formData['norek']."', '".$formData['tujuan_admin_bank']."', '".$formData['tujuan_admin_namabank']."', '".$formData['tujuan_admin_norek']."', '".$nominal."', '".$formData['note']."', '".$formData['tanggal_masuk']."', '$tanggal_update', '$status', '$adminNote', 'deposit', '$processedBy', '".$formData['potongan']."', '".$formData['dicek_oleh']."', '".$formData['promo_id']."', '".$formData['promotiontitle']."', '".$formData['promotiondp']."')";

            if (mysqli_query($koneksi, $insertQuery)) {
                echo "Data form berhasil disimpan ke dalam dp_history";

                // MEMASUKAN DATA KE GOOGLE SHEET
                if (isset($formData['bank'])) {
                    $bank = $formData['bank'];

                        // Query untuk memilih data dari tabel google_sheet dimana nama adalah 'BANK', 'EWALLET', atau 'PULSA'
                        $google_sheet_combined = "SELECT * FROM google_sheet WHERE nama IN ('BANK', 'EWALLET', 'PULSA', 'WITHDRAW', 'BONUS')";
                        $Resultgoogle_sheet_combined = mysqli_query($koneksi, $google_sheet_combined);

                        // Loop melalui hasil query
                        while ($row_combined = mysqli_fetch_assoc($Resultgoogle_sheet_combined)) {
                        // Simpan nilai 'api' sesuai dengan nama
                        $sheet_data[$row_combined['nama']] = $row_combined['api'];
                        }

                        // Fungsi untuk melakukan request cURL
                        function performCurlRequest($url, $data) {
                            $curl = curl_init();
                            curl_setopt_array($curl, [
                                CURLOPT_URL => $url,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => json_encode($data),
                                CURLOPT_HTTPHEADER => [
                                    "Content-Type: application/json"
                                ],
                            ]);
                            $response = curl_exec($curl);
                            curl_close($curl);
                            return $response;
                        }

                        // Memeriksa jenis bank
                        if (in_array($bank, ['BCA', 'JAGO', 'MANDIRI', 'BNI', 'BRI', 'CIMB', 'PERMATA', 'BANK LAIN', 'BSI', 'DANAMON', 'SEABANK', 'JENIUS', 'PANIN', 'BNC', 'SAKUKU'])) {
                            // Memisahkan tanggal dari $formData['tanggal_masuk']
                            if (isset($formData['tanggal_masuk'])) {
                                $tanggalMasuk = $formData['tanggal_masuk'];
                                list($tanggal, $waktu) = explode(' ', $tanggalMasuk); // Memisahkan berdasarkan spasi menjadi array [tanggal, waktu]
                    
                                // URL Endpoint API dari SheetDB
                                $sheetdb_api_url = $sheet_data['BANK'];

                                // Mengatur data untuk dikirim
                                $data = [
                                    "NAMA REKENING" => $formData['nama_bank'],
                                    "NOMOR REKENING" => addHyphens($formData['norek']),
                                    "USERNAME" => $formData['username'],
                                    "DEPO" => $nominal,
                                    "BANK" => $bank,
                                    "JAM" => $waktu,
                                    "DATE" => $tanggal,
                                ];

                                // Melakukan request cURL
                                $response = performCurlRequest($sheetdb_api_url, $data);
                            }
                        } elseif (in_array($bank, ['DANA', 'GOPAY', 'OVO', 'LINKAJA'])) {
                            // Memisahkan tanggal dari $formData['tanggal_masuk']
                            if (isset($formData['tanggal_masuk'])) {
                                $tanggalMasuk = $formData['tanggal_masuk'];
                                list($tanggal, $waktu) = explode(' ', $tanggalMasuk); // Memisahkan berdasarkan spasi menjadi array [tanggal, waktu]
        
                            // URL Endpoint API dari SheetDB untuk e-wallet
                            $sheetdb_api_url_ewallet = $sheet_data['EWALLET'];

                            // Mengatur data untuk dikirim
                            $data = [
                                "NAMA REKENING" => $formData['nama_bank'],
                                "NOMOR REKENING" => addHyphens($formData['norek']),
                                "USERNAME" => $formData['username'],
                                "DEPO" => $nominal,
                                "BANK" => $bank,
                                "JAM" => $waktu,
                                "DATE" => $tanggal,
                            ];

                            // Melakukan request cURL
                            $response = performCurlRequest($sheetdb_api_url_ewallet, $data);
                        }}
                    }


                // Jika ada promo_id, simpan ke database turnover_member
                if (!empty($formData['promo_id'])) {
                    $promo_id = $formData['promo_id'];
                    $promotiontitle = $formData['promotiontitle'];
                    $promotiondp = $formData['promotiondp'];

                    // Ambil min_to dari database promodepo
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
                            $turnoverQuery = "UPDATE turnover_member SET id_transaksi = '$id', deposit = '$nominal', promo_id = '$promo_id', promo_title = '$promotiontitle', jumlah_promo = '$promotiondp', turnover = '$turnover', status = 'belum tercapai' WHERE username = '".$formData['username']."'";
                        } else {
                            // Jika hasilnya kosong, lakukan operasi INSERT
                            $turnoverQuery = "INSERT INTO turnover_member (id_transaksi, username, deposit, promo_id, promo_title, jumlah_promo, turnover, status) VALUES ('$id', '".$formData['username']."', '$nominal', '$promo_id', '$promotiontitle', '$promotiondp', '$turnover', 'belum tercapai')";
                        }
                        
                        // Menghitung nilai tambahan dari promotiondp
                        $additionalPromotion = $nominal * ($formData['promotiondp'] / 100);

                        // Jika additionalPromotion melebihi max_bonus, ubah menjadi max_bonus
                        if ($additionalPromotion > $max_bonus) {
                            $additionalPromotion = $max_bonus;
                        }    
                            // Menambahkan nilai promotiondp ke nominal
                            $nominal += $additionalPromotion;

                        if (mysqli_query($koneksi, $turnoverQuery)) {
                            echo "Data berhasil disimpan ke database turnover_member";
                            
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
                        echo "Error: Data promo tidak ditemukan";
                    }
                }

                // Mengurangi coin dari nominal yang sudah diproses di database master_admin hanya jika statusnya adalah "proses" dan username bukan admin
                if ($status === 'proses') {
                    
                    $updateMasterAdminQuery = "UPDATE master_admin SET coin = coin - '".$nominal."'";

                    // Cek apakah username yang sedang diproses adalah admin
                    if ($formData['username'] !== 'admin') {
                        $updateMasterAdminQuery .= " WHERE id = 1";
                    } else {
                        $updateMasterAdminQuery .= " WHERE username = 'admin'";
                    }

                    if (mysqli_query($koneksi, $updateMasterAdminQuery)) {
                        echo "Coin berhasil dikurangi dari nominal yang sudah diproses di database master_admin";

                        // Update coin value in member's database
                        $updateMemberQuery = "UPDATE member SET coin = coin + '".$nominal."' WHERE username = '".$formData['username']."'";
                        if (mysqli_query($koneksi, $updateMemberQuery)) {
                            echo "Coin berhasil diperbarui di database member";
                        } else {
                            echo "Error saat memperbarui coin di database member: " . mysqli_error($koneksi);
                        }
                    } else {
                        echo "Error saat mengurangi coin dari nominal yang sudah diproses: " . mysqli_error($koneksi);
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
    $deleteQuery = "DELETE FROM panelformdeposit WHERE id='$id'";
    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "Form berhasil dihapus";
    } else {
        echo "Error saat menghapus form: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
