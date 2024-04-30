<?php
include("../fungsi/koneksi.php");

date_default_timezone_set('Asia/Jakarta');
$current_date = date("Y-m-d");

function formatRupiah($nominal) {
    $formattedNominal = "Rp " . number_format($nominal, 0, ',', '.');
    return $formattedNominal;
}

function addHyphens($str) {
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

// Query untuk mengambil data dari bet_history sesuai dengan username
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $query_bet_history = "SELECT * FROM bet_history WHERE Username = '$username' AND DATE(tanggal_masuk) = '$current_date'";
    $result_bet_history = $koneksi->query($query_bet_history);

    if ($result_bet_history) {
        // Array untuk menyimpan total turnover dan total bet-payout dari setiap provider
        $total_turnover_per_provider = array();
        $total_bet_payout_per_provider = array();

        // Iterasi melalui hasil query bet_history
        while ($row = $result_bet_history->fetch_assoc()) {
            // Ambil nilai Provider, Turnover, Bet, dan Payout dari setiap baris
            $provider = $row['Provider'];
            $turnover = $row['Turnover'];
            $bet = $row['Bet'];
            $payout = $row['Payout'];

            // Tambahkan turnover ke total per provider
            if (!isset($total_turnover_per_provider[$provider])) {
                $total_turnover_per_provider[$provider] = 0;
            }
            $total_turnover_per_provider[$provider] += $turnover;

            // Hitung total bet-payout dan tambahkan ke total per provider
            $total_bet_payout = $bet - $payout;
            if (!isset($total_bet_payout_per_provider[$provider])) {
                $total_bet_payout_per_provider[$provider] = 0;
            }
            $total_bet_payout_per_provider[$provider] -= $total_bet_payout;
        }
    }
}

// Mendapatkan nilai parameter username dari URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Melakukan query ke database untuk mencari data berdasarkan username
    $sql = "SELECT * FROM member WHERE username = '$username'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        // Menampilkan data jika ditemukan
        while ($row = $result->fetch_assoc()) {
            $status_akun = $row["status_akun"];
            $usernameMember = $row["username"];
            $bank = $row["bank"];
            $nama_bank = $row["nama_bank"];
            $norek = $row["norek"];
            $tanggal_daftar = $row["tanggal_daftar"];
            $referral_player = $row["referral_player"];
            $coin = $row["coin"];
            $password = $row["password"];
            $last_login = $row["last_login"];
            // Tampilkan data di sini
        }

        // Lakukan curl hanya jika username ditemukan
        $query_provider = "SELECT * FROM apigameprovider";
        $result_provider = mysqli_query($koneksi, $query_provider);
        while ($row_provider = mysqli_fetch_assoc($result_provider)) {
            // Lakukan sesuatu dengan data yang diambil, misalnya tampilkan
            $operator_code1 = $row_provider['operator_code'];
            $secret_key1 = $row_provider['secret_key'];
            $api_url1 = $row_provider['api_url'];
            $LOG_URL1 = $row_provider['LOG_URL'];
            $coin_kios = $row_provider['coin_kios'];
            // print_r($row_provider);
        }

        // Lakukan curl hanya jika username ditemukan
        $provider_PR = 'PR';
        $provider_PG = 'PG';
        $provider_HB = 'HB';

        $provider_code = $provider_PR;
        $operator_code = $operator_code1;
        $secret_key = $secret_key1;
        $api_url = $api_url1;
        $endpoint_getBalance = "getBalance.aspx";
        $endpoint_makeTransfer = "makeTransfer.aspx";

        // Parameter-parameter untuk URL getBalance
        $parameters_getBalance = array(
            "operatorcode" => $operator_code,
            "providercode" => $provider_code,
            "username" => $usernameMember,
            "password" => $password,
        );

        // Urutkan parameter berdasarkan kunci
        ksort($parameters_getBalance);

        // Gabungkan parameter menjadi string query
        $query_string_getBalance = http_build_query($parameters_getBalance);

        // Hitung signature menggunakan MD5
        $signature_getBalance = strtoupper(md5($operator_code . $password . $provider_code . $usernameMember . $secret_key));

        // Menginisialisasi cURL untuk getBalance
        $curl_getBalance = curl_init();

        // Mengatur URL API untuk getBalance
        curl_setopt($curl_getBalance, CURLOPT_URL, $api_url.'/'.$endpoint_getBalance.'?'.$query_string_getBalance.'&signature='.$signature_getBalance);

        // Mengatur opsi lainnya untuk getBalance
        curl_setopt_array($curl_getBalance, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cache-Control: no-cache"
            ),
        ));

        // Eksekusi permintaan cURL untuk getBalance dan menyimpan respons
        $response_getBalance = curl_exec($curl_getBalance);

        // Tutup sambungan cURL untuk getBalance
        curl_close($curl_getBalance);

        // Decode the response to an associative array
        $response_data_getBalance = json_decode($response_getBalance, true);
        $errMsg_getBalance = $response_data_getBalance['errMsg'];
        $balance_PR = $response_data_getBalance['balance'];

        // echo "Get Balance Response: $response_getBalance<br>";
        // echo "Get Balance Response: $errMsg_getBalance<br>";
        // echo "Get Balance Response: $balance_PR<br>";

        // Hanya lakukan curl ke provider_PG jika username ditemukan
        $parameters_getBalance_PG = array(
            "operatorcode" => $operator_code,
            "providercode" => $provider_PG,
            "username" => $usernameMember,
            "password" => $password,
        );

        // Urutkan parameter berdasarkan kunci
        ksort($parameters_getBalance_PG);

        // Gabungkan parameter menjadi string query
        $query_string_getBalance_PG = http_build_query($parameters_getBalance_PG);

        // Hitung signature menggunakan MD5 untuk provider_PG
        $signature_getBalance_PG = strtoupper(md5($operator_code . $password . $provider_PG . $usernameMember . $secret_key));

        // Menginisialisasi cURL untuk getBalance ke provider_PG
        $curl_getBalance_PG = curl_init();

        // Mengatur URL API untuk getBalance ke provider_PG
        curl_setopt($curl_getBalance_PG, CURLOPT_URL, $api_url.'/'.$endpoint_getBalance.'?'.$query_string_getBalance_PG.'&signature='.$signature_getBalance_PG);

        // Mengatur opsi lainnya untuk getBalance ke provider_PG
        curl_setopt_array($curl_getBalance_PG, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cache-Control: no-cache"
            ),
        ));

        // Eksekusi permintaan cURL untuk getBalance ke provider_PG dan menyimpan respons
        $response_getBalance_PG = curl_exec($curl_getBalance_PG);

        // Tutup sambungan cURL untuk getBalance ke provider_PG
        curl_close($curl_getBalance_PG);

        // Decode the response to an associative array
        $response_data_getBalance_PG = json_decode($response_getBalance_PG, true);
        $errMsg_getBalance_PG = $response_data_getBalance_PG['errMsg'];
        $balance_PG = $response_data_getBalance_PG['balance'];

        // // Gunakan data yang diperoleh dari respons provider_PG sesuai kebutuhan
        // echo "Get Balance Response (Provider PG): $response_getBalance_PG<br>";
        // echo "Get Balance Response (Provider PG): $errMsg_getBalance_PG<br>";
        // echo "Get Balance Response (Provider PG): $balance_PG<br>";

        // Hanya lakukan curl ke provider_HB jika username ditemukan
        $parameters_getBalance_HB = array(
            "operatorcode" => $operator_code,
            "providercode" => $provider_HB,
            "username" => $usernameMember,
            "password" => $password,
        );

        // Urutkan parameter berdasarkan kunci
        ksort($parameters_getBalance_HB);

        // Gabungkan parameter menjadi string query
        $query_string_getBalance_HB = http_build_query($parameters_getBalance_HB);

        // Hitung signature menggunakan MD5 untuk provider_HB
        $signature_getBalance_HB = strtoupper(md5($operator_code . $password . $provider_HB . $usernameMember . $secret_key));

        // Menginisialisasi cURL untuk getBalance ke provider_HB
        $curl_getBalance_HB = curl_init();

        // Mengatur URL API untuk getBalance ke provider_HB
        curl_setopt($curl_getBalance_HB, CURLOPT_URL, $api_url.'/'.$endpoint_getBalance.'?'.$query_string_getBalance_HB.'&signature='.$signature_getBalance_HB);

        // Mengatur opsi lainnya untuk getBalance ke provider_HB
        curl_setopt_array($curl_getBalance_HB, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cache-Control: no-cache"
            ),
        ));

        // Eksekusi permintaan cURL untuk getBalance ke provider_HB dan menyimpan respons
        $response_getBalance_HB = curl_exec($curl_getBalance_HB);

        // Tutup sambungan cURL untuk getBalance ke provider_HB
        curl_close($curl_getBalance_HB);

        // Decode the response to an associative array
        $response_data_getBalance_HB = json_decode($response_getBalance_HB, true);
        $errMsg_getBalance_HB = $response_data_getBalance_HB['errMsg'];
        $balance_HB = $response_data_getBalance_HB['balance'];

        // // Gunakan data yang diperoleh dari respons provider_HB sesuai kebutuhan
        // echo "Get Balance Response (Provider HB): $response_getBalance_HB<br>";
        // echo "Get Balance Response (Provider HB): $errMsg_getBalance_HB<br>";
        // echo "Get Balance Response (Provider HB): $balance_HB<br>";
        // Hitung total
        $total = $balance_PR + $balance_PG + $balance_HB;
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error menggunakan toastr
        echo "<script>toastr.error('Username tidak ditemukan');</script>";
    }
} else {
}

?>
<style>
    ion-icon {
  font-size: 34px;
}
</style>
<?php include("header.php") ?>

<div class="col-sm-8" style="padding-top: 60px;">
    <h4 class="page-title"> Member Profil </h4>
  </div>

                <div class="table-responsive test">
					<table class="table table-bordered max-width-900px">
						<tbody>
							<tr>
								<td id="byusnm">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="height: 40px;"><i class="fas fa-users fa-lg"></i></span>
                                    </div>
                                        <input type="text" class="form-control min-width-150px" id="search" placeholder="Username">
                                    </div>
								</td>
                                <td>
                                    <a type="button" id="searchButton" class="btn btn-primary"><i class="fas fa-search"></i> Search</a>
                                </td>
							</tr>
						</tbody>
					</table>
				</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var searchButton = document.getElementById("searchButton");
    var searchInput = document.getElementById("search");

    searchButton.addEventListener("click", function() {
        var username = searchInput.value.trim();
        if (username !== "") {
            window.location.href = "?username=" + encodeURIComponent(username);
        }
    });
});
</script>

            <div id="information" style="display: none;">
                <div class="row information">
					<div class="margin-top-10 col-lg-6 col-sm-12">
                    <div id="info" class="table-responsive">
						
                        <table id="personalInfoTable" class="table table-hover table-bordered">
                            <thead class="form-caption">
                                <tr>
                                    <th scope="col" colspan="3" class="align-center table-dark" style="text-align: center;">Profil Information User
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Current Status</td>
                                    <td id="currentStatus" colspan="2"><?php echo isset($status_akun) ? $status_akun: '-' ?></td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td id="Username"><?php echo isset($usernameMember) ? $usernameMember: '-' ?></td>
                                    
                                </tr>
                                <tr>
                                    <td>Referral</td>
                                    <td id="Referral" colspan="2"><?php echo isset($referral_player) ? $referral_player : '-'  ?></td>
                                </tr>
                                <tr>
                                    <td>Bank</td>
                                    <td id="bank" colspan="2"><?php echo isset($bank) ? $bank : '-' ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        Bank No Rekening 
                                    </td>
                                    <td id="bankNoRek"><?php echo isset($norek) ? addHyphens($norek) : '-' ?></td>
                                </tr>
                                <tr>
                                    <td>Bank Nama Bank</td>
                                    <td id="bankName" colspan="2"><?php echo isset($nama_bank) ? $nama_bank : '-' ?></td>
                                </tr>
                                <tr>
                                    <td>Last Update Date</td>
                                    <td id="lasuUpdate" colspan="2">-</td>
                                </tr>
                                <tr>
                                    <td>Last Update By</td>
                                    <td id="lasuUpdateBy" colspan="2">-</td>
                                </tr>
                                <tr>
                                    <td>Register Date</td>
                                    <td id="regisDate" colspan="2"><?php echo isset($tanggal_daftar) ? $tanggal_daftar : '-'  ?></td>
                                </tr>
                                <tr>
                                    <td>Last Login IP</td>
                                    <td id="lastLogin" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>Last Login Date</td>
                                    <td id="lastLoginDate" colspan="2"><?php echo isset($last_login) ? $last_login : '-'  ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
					</div>

                    

					<div class="margin-top-10 col-lg-6 col-sm-12">
						<div id="info" class="table-responsive">
							<table id="balanceTable" class="table table-hover table-bordered">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="2" class="align-center table-dark" style="text-align: center;">Balance
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="width-50px">Main Balance</td>
										<td class="width-50px align-right" id="mainBalance"><?php echo isset($coin) ? formatRupiah($coin) : '-'; ?></td>
									</tr>
									<tr>
										<td>Pindahkan Ke Main Balance</td>
										<td id="transferMainBalance" class="align-right">
                                            <i class="fas fa-share-square" onclick="checkBalance(true)" style="cursor: pointer; margin-left: 10px; font-size: 18px; position: relative; top: 2px;"></i>
                                        </td>
									</tr>
									<tr>
										<td>Balance On Provider </td>
										<td id="balanceOnProvider" class="align-right">
                                            <span id="countDownArea"></span>&nbsp;&nbsp;
                                                <i class="fa fa-tasks" onclick="toggleBalanceTable()" style="cursor: pointer; margin-left: 10px; font-size: 18px; position: relative; top: 2px;"></i>
                                        </td>
									</tr>
								</tbody>
							</table>
							<table id="balanceOnProvider-table" class="table modal-table table-sm table-hover table-bordered" style="display: none;">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="3" class="align-center table-dark" style="text-align: center;">Balance On Provider
										</th>
									</tr>
								</thead>
								<tbody>
<?php
// Misalkan Anda memiliki array $balances dengan struktur yang sesuai
$balances = array(
    'Pragmatic Play' => isset($balance_PR) ? $balance_PR : null,
    'Pocket Game Soft' => isset($balance_PG) ? $balance_PG : null,
    'Habanero' => isset($balance_HB) ? $balance_HB : null,
);

// Lakukan perulangan untuk setiap elemen dalam $balances
foreach ($balances as $provider => $balance) {
    // Periksa apakah saldo lebih besar dari 0 sebelum menampilkan baris HTML
    if ($balance !== null && $balance > 0) {
        // Output baris HTML untuk setiap provider dan saldonya
        echo '<tr>';
        echo '<td scope="row" class="form-caption">' . $provider . '</td>';
        echo '<td class="align-right balancePR">' . formatRupiah($balance) . '</td>';
        echo '<td id="" class="align-right balancePR"></td>'; // Ini mungkin perlu diisi dengan data tertentu, seperti perubahan saldo
        echo '</tr>';
    }
}
?>
                                    <tr>
                                        <td scope="row" class="form-caption align-right">Total</td>
                                        <td id="" class="align-right"></td>
                                        <td class="align-right"><?php echo isset($total) ? formatRupiah($total) : '-' ?></td>
                                    </tr>
                                </tbody>
							</table>
                            
							<table id="transaksiHistoryTable" class="table table-hover table-bordered">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="3" class="align-center table-dark" style="text-align: center;">Transaksi History
										</th>
									</tr>
								</thead>
								<tbody>
<?php
// Lakukan query ke database untuk mengambil total deposit hari ini berdasarkan username
if(isset($usernameMember)) {
    // Query untuk mengambil total deposit hari ini dari dp_history
    $query_total_deposit_hari_ini = "SELECT SUM(nominal) AS total_deposit FROM dp_history WHERE username = '$usernameMember' AND DATE(tanggal_masuk) = '$current_date'";
    $result_total_deposit_hari_ini = $koneksi->query($query_total_deposit_hari_ini);

    if ($result_total_deposit_hari_ini->num_rows > 0) {
        // Jika ditemukan data total deposit hari ini, ambil nilainya
        $row_total_deposit_hari_ini = $result_total_deposit_hari_ini->fetch_assoc();
        $total_deposit_hari_ini = $row_total_deposit_hari_ini["total_deposit"];
    } else {
        // Jika tidak ditemukan data total deposit hari ini, set nilai total deposit menjadi 0
        $total_deposit_hari_ini = 0;
    }

    // Query untuk mengambil total penarikan hari ini dari wd_history
    $query_total_penarikan_hari_ini = "SELECT SUM(nominal) AS total_penarikan FROM wd_history WHERE username = '$usernameMember' AND DATE(tanggal_masuk) = '$current_date'";
    $result_total_penarikan_hari_ini = $koneksi->query($query_total_penarikan_hari_ini);

    if ($result_total_penarikan_hari_ini->num_rows > 0) {
        // Jika ditemukan data total penarikan hari ini, ambil nilainya
        $row_total_penarikan_hari_ini = $result_total_penarikan_hari_ini->fetch_assoc();
        $total_penarikan_hari_ini = $row_total_penarikan_hari_ini["total_penarikan"];
    } else {
        // Jika tidak ditemukan data total penarikan hari ini, set nilai total penarikan menjadi 0
        $total_penarikan_hari_ini = 0;
    }

        // Query untuk mengambil total nominal dari dp_history
        $query_total_nominal_dp = "SELECT SUM(nominal) AS total_nominal FROM dp_history WHERE username = '$usernameMember'";
        $result_total_nominal_dp = $koneksi->query($query_total_nominal_dp);
    
        if ($result_total_nominal_dp->num_rows > 0) {
            // Jika ditemukan data total nominal dari dp_history, ambil nilainya
            $row_total_nominal_dp = $result_total_nominal_dp->fetch_assoc();
            $total_nominal_dp = $row_total_nominal_dp["total_nominal"];
        } else {
            // Jika tidak ditemukan data total nominal dari dp_history, set nilai total nominal menjadi 0
            $total_nominal_dp = 0;
        }

            // Query untuk mengambil total nominal dari wd_history
    $query_total_nominal_wd = "SELECT SUM(nominal) AS total_nominal FROM wd_history WHERE username = '$usernameMember'";
    $result_total_nominal_wd = $koneksi->query($query_total_nominal_wd);

    if ($result_total_nominal_wd->num_rows > 0) {
        // Jika ditemukan data total nominal dari wd_history, ambil nilainya
        $row_total_nominal_wd = $result_total_nominal_wd->fetch_assoc();
        $total_nominal_wd = $row_total_nominal_wd["total_nominal"];
    } else {
        // Jika tidak ditemukan data total nominal dari wd_history, set nilai total nominal menjadi 0
        $total_nominal_wd = 0;
    }

    // Menghitung total winlose
$total_winlose = $total_nominal_dp - $total_nominal_wd;
    // Menghitung today total winlose
$today_total_winlose = $total_deposit_hari_ini - $total_penarikan_hari_ini;


$query_total_win_lose = "SELECT SUM(Bet) AS total_bet, SUM(Payout) AS total_payout FROM bet_history WHERE Username = '$usernameMember' AND DATE(tanggal_masuk) = '$current_date'";
$result_total_win_lose  = $koneksi->query($query_total_win_lose);

// Inisialisasi total_bet dan total_payout
$total_bet = 0;
$total_payout = 0;

if ($result_total_win_lose->num_rows > 0) {
    // Jika ditemukan data total bet dan total payout, ambil nilainya
    $row_total_win_lose = $result_total_win_lose->fetch_assoc();
    $total_bet = $row_total_win_lose["total_bet"];
    $total_payout = $row_total_win_lose["total_payout"];
}

// Menghitung total winlose
$total_WL = $total_payout - $total_bet;

// Menentukan warna teks berdasarkan nilai total_bet dan total_payout
$text_color = $total_payout > $total_bet ? 'black' : 'red';
}
?>
									<tr>
										<td class="width-50px">Today WinLose</td>
										<td id="" class="align-right"></td>
										<td class="width-50px align-right" id="tdwl"><?php echo isset($total_WL) ? '<span style="color: ' . $text_color . '">' . formatRupiah($total_WL) . '</span>' : '-'; ?>
                                            <i class="fa fa-tasks" onclick="toggleWinLossTable()" style="cursor: pointer; margin-left: 5px; font-size: 18px; position: relative; top: 2px;"></i>
                                        </td>
									</tr>

									<tr>
										<td>Today Deposit</td>
										<td id="" class="align-right"></td>
										<td id="todayDeposit" class="align-right"><?php echo isset($total_deposit_hari_ini) ? formatRupiah($total_deposit_hari_ini) : '-'; ?></td>
									</tr>
									<tr>
										<td>Today Withdraw</td>
										<td id="" class="align-right"></td>
										<td id="todayWithdraw" class="align-right" style="color: red;"><?php echo isset($total_penarikan_hari_ini) ? formatRupiah($total_penarikan_hari_ini) : '-'; ?></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Deposit</td>
										<td id="totalDeposit" class="align-right"><?php echo isset($total_nominal_dp) ? formatRupiah($total_nominal_dp) : '-'; ?></td>
										<td id="" class="align-right"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Withdraw</td>
										<td id="ototalWithdrawvwd" class="align-right"><?php echo isset($total_nominal_wd) ? formatRupiah($total_nominal_wd) : '-'; ?></td>
										<td id="" class="align-right"></td>
									</tr>
									<tr>
										<td>Total Winlose</td>
										<td id="" class="align-right"></td>
										<td id="totalWinlose" class="align-right">
<?php 
// Inisialisasi variabel total_winlose_formatted
$total_winlose_formatted = isset($total_winlose_formatted) ? $total_winlose_formatted : '-';

// Inisialisasi variabel total_winlose
$total_winlose = isset($total_winlose) ? $total_winlose : 0;

// Menentukan warna dan tanda minus jika total_winlose negatif
if (isset($total_winlose) && $total_winlose < 0) {
    $total_winlose_formatted = '<span style="color: red;">' . formatRupiah(abs($total_winlose)) . '</span>';
} else {
    $total_winlose_formatted = formatRupiah($total_winlose);
} 

// Menampilkan total_winlose_formatted
echo $total_winlose_formatted;
?>

                                        </td>
									</tr>
									<tr>
										<td>Total Bonus</td>
										<td id="" class="align-right"></td>
										<td id="totalBonus" class="align-right"></td>
									</tr>
									
								</tbody>
							</table>

							<table id="winLoss-table" class="table table-hover" style="display: none;">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="6" class="align-center table-dark" style="text-align: center;">Today WinLose
										</th>
									</tr>
									<tr class="table-info">
										<th scope="col" class="align-center">Provider
										</th>
										<th scope="col" class="align-center">
										</th>
										<th scope="col" class="align-center">Winlose
										</th>
										<th scope="col" class="align-center">
										</th>
										<th scope="col" class="align-center">Bonus
										</th>
										<th scope="col" class="align-center">
										</th>
									</tr>
								</thead>
								<tbody>
<?php
// Tampilkan baris untuk setiap provider
if (!empty($total_turnover_per_provider) && !empty($total_bet_payout_per_provider)) {
    foreach ($total_turnover_per_provider as $provider => $total_turnover) {
        // Tentukan warna teks berdasarkan nilai Bet-Payout
        $text_color = ($total_bet_payout_per_provider[$provider] < 0) ? 'red' : 'black';

        echo '<tr>';
        echo '<td class="form-caption">' . $provider . '</td>';
        echo '<td class="align-right">' . number_format($total_turnover) . ' <i></i></td>';
        echo '<td class="align-right"><span style="color:' . $text_color . '">' . formatRupiah($total_bet_payout_per_provider[$provider]) . '</span> <i></i></td>';
        echo '<td class="align-right">0.00 <i></i></td>';
        echo '<td class="align-right">0.00 <i></i></td>';
        echo '<td class="align-center">';
        echo '</td>';
        echo '</tr>';
    }
} else {
    // Jika tidak ada data, tampilkan baris kosong
    echo '<tr>';
    echo '<td colspan="6" class="text-center">Tidak ada data</td>';
    echo '</tr>';
}
?>

                                </tbody>
							</table>
						</div>
					</div>

						<div id="infoTransaksi" class="table-responsive" style="margin-left: 5px;">
							<table id="dataListTransaksi" class="table table-hover">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="6" class="align-center table-dark" style="text-align: center;">Transaksi Trakhir
										</th>
									</tr>
									<tr class="table-info">
										<th scope="col">Time</th>
										<th scope="col" class="align-center">Jenis Form
										</th>
										<th scope="col" class="align-center">Nominal
										</th>
										<th scope="col" class="align-center">Potongan
										</th>
										<th scope="col" class="align-center">Proses Oleh
										</th>
										<th scope="col" class="align-center">Status
										</th>
										
									</tr>
								</thead>
								<tbody style="display: none;">
                                <?php
// Lakukan query ke database untuk mengambil 10 data terbaru dari dp_history berdasarkan username
if(isset($usernameMember)) {
    $query_dp_history = "SELECT * FROM dp_history WHERE username = '$usernameMember' ORDER BY tanggal_masuk DESC LIMIT 10";
    $result_dp_history = $koneksi->query($query_dp_history);

    if ($result_dp_history->num_rows > 0) {
        // Jika ditemukan data dp_history, tampilkan dalam bentuk tabel
        while ($row_dp_history = $result_dp_history->fetch_assoc()) {
            $tanggal_masuk = $row_dp_history["tanggal_masuk"];
            $jenis_form = $row_dp_history["jenis_form"];
            $nominal = $row_dp_history["nominal"];
            $potongan = $row_dp_history["potongan"];
            $proses_oleh = $row_dp_history["proses_oleh"];
            $status = $row_dp_history["status"];
?>
            <tr>
                <td><?php echo $tanggal_masuk; ?></td>
                <td class="align-center"><?php echo $jenis_form; ?></td>
                <td class="align-right"><?php echo formatRupiah($nominal); ?></td>
                <td class="align-right"><?php echo $potongan; ?></td>
                <td class="align-center"><?php echo $proses_oleh; ?></td>
                <td class="align-center"><?php echo $status; ?></td>
            </tr>
<?php
        }
    } else {
        // Jika tidak ditemukan data dp_history untuk username tersebut
        echo "<tr><td colspan='6' class='align-center'>Tidak ada data</td></tr>";
    }
}
?>

                                </tbody>
							</table>
						</div>
						<div class="row pt-2 pb-2">
							<div class="col-sm-9">
								<button type="button" id="transaksiTrakhir" onclick="transaksiTrakhir()" class="btn btn-primary waves-effect waves-light" style="margin-left: 10px;">Check Last Transaction</button>
							</div>
							<div class="col-sm-3 align-right ">
							</div>
						</div>
                    
					<!-- <div class="margin-top-10 col-lg-6 col-sm-12">
						<div id="info" class="table-responsive">
							<table id="dataListSess" class="table table-hover-list table-list">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="3" class="align-center">
											Last Login
										</th>
									</tr>
									<tr>
										<th scope="col">
											Time
										</th>
										<th scope="col" class="align-center">IP
										</th>
										<th scope="col" class="align-center">Machine Info
										</th>
									</tr>
								</thead>
								<tbody>
                                    <tr>
                                        <td class="width-25P">18-04-2024 00:45:28</td>
                                        <td class="width-25P align-center userSessionRecordIp3278306636">114.79.4.181</td>
                                        <td>Android : Chrome-123.0.0.0</td>
                                    </tr>
                                </tbody>
							</table>
						</div>
						<div class="row pt-2 pb-2">
							<div class="col-sm-9">
								<button type="button" id="checkLastLogin" onclick="checkLastLogin()" class="btn btn-primary waves-effect waves-light" style="margin-left: 10px;">Check Last Login</button>
							</div>
							<div class="col-sm-3 align-right ">
							</div>
						</div>
					</div>
					<div class="margin-top-10 col-lg-6 col-sm-12">
						<div id="info" class="table-responsive">
							<table id="dataLast10pass" class="table table-hover-list table-list">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="2" class="align-center">Last 10 Change Password
										</th>
									</tr>
									<tr>
										<th scope="col">Time</th>
										<th scope="col" class="align-center">Update By
										</th>
									</tr>
								</thead>
								<tbody><tr><td class="width-25P">29-12-2023 19:03:19</td><td class="width-25P align-center">wbuana88@palaksepor</td></tr></tbody>
							</table>
						</div>
						<div class="row pt-2 pb-2">
							<div class="col-sm-9">
								<button type="button" id="checkLastChPass" onclick="checkLastChPwd()" class="btn btn-primary waves-effect waves-light" style="margin-left: 10px;">Check Password Change</button>
							</div>
							<div class="col-sm-3 align-right ">
							</div>
						</div>
					</div>
					<div class="margin-top-10 col-lg-6 col-sm-12">
						<div id="info" class="table-responsive">
							<table id="dataLast10st" class="table table-hover-list table-list">
								<thead class="form-caption">
									<tr>
										<th scope="col" colspan="3" class="align-center">Last 10 Change Status
										</th>
									</tr>
									<tr>
										<th scope="col">Time</th>
										<th scope="col" class="align-center">Update By
										</th>
										<th scope="col" class="align-center">Status
										</th>
									</tr>
								</thead>
								<tbody><tr><td class="width-25P">29-12-2023 19:03:19</td><td class=" align-center">wbuana88@palaksepor</td><td class=" align-center">Active</td></tr></tbody>
							</table>
						</div>
						<div class="row pt-2 pb-2">
							<div class="col-sm-9">
								<button type="button" id="checkLastChSt" onclick="checkLastChSt()" class="btn btn-primary waves-effect waves-light" style="margin-left: 10px;">Check Status Change</button>
							</div>
							<div class="col-sm-3 align-right ">
							</div>
						</div>
					</div> -->
				</div>
			</div>

<?php include("footer.php"); ?>
<script>
    
    function toggleBalanceTable() {
        var table = document.getElementById("balanceOnProvider-table");
        if (table.style.display === "none") {
            table.style.display = "table";
        } else {
            table.style.display = "none";
        }
    }

    function transaksiTrakhir() {
        var tbody = document.querySelector('#dataListTransaksi tbody');
        if (tbody.style.display === "none") {
            tbody.style.display = "table-row-group";
        } else {
            tbody.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
    var informationDiv = document.querySelector("#information");

    // Fungsi untuk memeriksa apakah parameter username ada dalam URL
    function checkURL() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('username')) {
            informationDiv.style.display = "block";
        }
    }

    // Jalankan fungsi checkURL saat halaman dimuat
    checkURL();

    var searchButton = document.getElementById("searchButton");
    var searchInput = document.getElementById("search");

    searchButton.addEventListener("click", function() {
        var username = searchInput.value.trim();
        if (username !== "") {
            // Navigasi ke URL dengan parameter username
            window.location.href = "?username=" + encodeURIComponent(username);
        } else {
            // Jika input kosong, tampilkan pesan peringatan menggunakan toastr
            toastr.error("Silakan masukkan username.");
        }
    });
});

function toggleWinLossTable() {
        var winLossTable = document.getElementById("winLoss-table");
        if (winLossTable.style.display === "none") {
            winLossTable.style.display = "table";
        } else {
            winLossTable.style.display = "none";
        }
    }
</script>