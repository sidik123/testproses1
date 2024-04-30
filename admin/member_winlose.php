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

// Cek apakah parameter username, strDate, dan endDate sudah diset
if (isset($_GET['username']) && isset($_GET['strDate']) && isset($_GET['endDate'])) {
  $username = $_GET['username'];
  $strDate = $_GET['strDate'];
  $endDate = $_GET['endDate'];

  // Query untuk mengambil data dari bet_history sesuai dengan username, strDate, dan endDate
  $query_bet_history = "SELECT * FROM bet_history WHERE Username = '$username' AND tanggal_masuk >= '$strDate' AND tanggal_masuk <= '$endDate 23:59:59'";
$result_bet_history = $koneksi->query($query_bet_history);

  if ($result_bet_history) {
      // Array untuk menyimpan total turnover dan total bet-payout dari setiap provider
      $total_turnover_per_provider = array();
      $total_bet_payout_per_provider = array();
      $total_bet_payout_per_provider_win = array();
      $total_bet_payout_per_provider_Company = array();


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


          
// Hitung total bet-payout win dan tambahkan ke total per provider
if (!isset($total_bet_payout_per_provider_win[$provider])) {
  $total_bet_payout_per_provider_win[$provider] = 0;
}
// Tentukan persentase penyesuaian berdasarkan provider
$adjustment_percentage = ($provider === "Pragmatic Play" || $provider === "PGSOFT") ? 0.07 : ($provider === "MicroGaming" ? 0.10 : ($provider === "JokerGaming" ? 0.07 : ($provider === "SpadeGaming" || $provider === "HabaNero" ? 0.10 : ($provider === "SBOSports" ? 0.15 : 0))));
// Hitung nilai total_bet_payout_per_provider_Company berdasarkan persentase penyesuaian
if (!isset($total_bet_payout_per_provider_Company[$provider])) {
  $total_bet_payout_per_provider_Company[$provider] = 0;
}
// Tentukan persentase penyesuaian untuk Company berdasarkan provider
$company_adjustment_percentage = ($provider === "Pragmatic Play" || $provider === "PGSOFT") ? 0.07 : ($provider === "MicroGaming" ? 0.10 : ($provider === "JokerGaming" ? 0.07 : ($provider === "SpadeGaming" || $provider === "HabaNero" ? 0.10 : ($provider === "SBOSports" ? 0.15 : 0))));
// Jika total bet-payout positif, kurangi persentase penyesuaian, jika negatif, kurangi juga
if ($total_bet_payout >= 0) {
  $total_bet_payout_per_provider_win[$provider] += $total_bet_payout * (1 - $adjustment_percentage);
  $company_adjusted_value = $total_bet_payout * $company_adjustment_percentage;
} else {
  // Jika hasilnya negatif atau lebih kecil dari 0, kurangi persentase penyesuaian
  $total_bet_payout_per_provider_win[$provider] += $total_bet_payout * (1 - $adjustment_percentage);
  $company_adjusted_value = $total_bet_payout * $company_adjustment_percentage; // Kurangi 10% dari nilai total
}
// Tambahkan persentase penyesuaian untuk Company jika total bet-payout kurang dari 0
$total_bet_payout_per_provider_Company[$provider] += $company_adjusted_value;


    }
  }
}
?>

<style>
ion-icon {
  font-size: 34px;
}

.formtable{
    padding: 0;
    display: block;
}

/* Gaya untuk tabel responsif */
.table-responsive {
  overflow-x: auto;
}

.table-responsive table{
  border: 1px solid black;
}

/* Gaya untuk sel header dengan class "table-info" */
.table #info {
  text-align: center;
  justify-content: center;
  font-size: 13px;
  font-weight: bold;
}

/* Gaya untuk checkbox-container */
.checkbox-container {
  align-items: center;
  margin-top: -5px;
  margin-bottom: -5px;
  font-size: 12px;
  font-weight: bold;
}

.table-primary th {
  color: #333;
  text-align: center;
  margin-bottom: 0px;
  font-size: 15px;
}

.monitor {
  text-align: center;
  justify-content: center;
  margin: 0px;
  padding: 0px;
}

#dataContainer {
  color: #333;
  text-align: center;
  margin-bottom: 0px;
  font-size: 13px;
}

#dataContainer tr {
  border-bottom: 1px solid black;
  padding: 0px;
  margin: 0px;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 15px;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-success {
  color: #fff;
  background-color: #28a745;
  border-color: #28a745;
  margin-right: 10px;
  width: 100px;
}

.btn-danger {
  color: #fff;
  background-color: #dc3545;
  border-color: #dc3545;
  width: 100px;
}

.btn-secondary {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
}

#infoTable th{
  padding-top: 1px;
  font-size: 12px;
  position: relative;
  text-align: center;
  justify-content: center;
  padding-bottom: -2px;
}

@media (max-width: 1091px) {
  .btn-success,
  .btn-danger {
    margin-top: 5px;
  }
  .btn-danger {
    margin-top: 5px;
    margin-right: 10px;
  }
  .btn-secondary {
    margin-top: 25px;
  }
}

@media (max-width: 440px) {
.select-all{
    font-size: 9px;
}

.btn-secondary {
    margin-top: 25px;
  }
}
</style>

<?php include("header.php") ?>

<div class="row pb-2" style="padding-top: 80px;">
	<div class="col-sm-9">
		<h4 class="page-title"> Report Win Lose Player </h4>
	</div>
</div>

					<table class="table table-bordered max-width-900px ">
						<tbody>
							<tr>
								<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Tanggal</th>
								<td colspan="2">
									  <div id="daterange-picker" class="col-sm-4 col-md-12 padding-0 min-width-350px">
										<div class="input-daterange input-group">
											<input type="date" class="form-control max-width-150px" name="strDate" id="strDate" placeholder="Start Date" value="<?php echo $current_date ?>">
											<div class="input-group-prepend"> <span class="input-group-text font-size-12px"> Sampai </span>
											</div>
											<input type="date" class="form-control max-width-150px" name="endDate" id="endDate" placeholder="End Date" value="<?php echo $current_date ?>">
										</div>
									</div>
								</td>
							</tr>
							<tr class="search-pl filter-order-lmt ">
								<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Type</th>
								<td colspan="2">       
									<select id="orderBy" class="form-control max-width-200px inline-block">
										<option selected="" value="--">Default</option>
										<option value="Turnover">Turnover</option>
										<option value="Winlose"> Member WL</option>
									</select>
			 					</td>	
							</tr>
							<tr class="search-pl filter-order-lmt ">
								<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Total Per Page</th>
								<td colspan="2">
									<select id="limitData" class="form-control max-width-200px">
										<option selected="" value="100">100</option>
										<option value="250">250</option>
										<option value="500">500</option>
										
									</select>
								</td>
							</tr>
							<tr class="search-pl filter-ref">
								<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Username</th>
								<td id="byusnm" colspan="2">
								<div class="col-sm-4 col-md-12 padding-0">
									<input type="text" class="form-control max-width-200px" id="username" placeholder="">
									<div id="usernameref"></div>
									</div>
								</td>
							</tr>
							<tr>
								<td scope="col" class="padding-10 uppercase form-caption"></td>
								<td colspan="2">
									<button type="button" id="searchButton" class="btn btn-primary waves-effect waves-light">Search</button>
								</td>
							</tr>
						</tbody>
					</table>

          <div class="table-responsive">
<table id="dataList" user-lvl="5" data-report="pl" class="table table-hover table-bordered" data-tier="2" style="border: 1px;">
          <thead id="ag-head" class="table-dark" style="border-color: white;">
								<tr class="header-sub ">
                    <th scope="col" rowspan="2" style="text-align: center;"> No </th>
                    <th scope="col" rowspan="2" id="ag-title" style="text-align: center;"> Game</th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Turnover </th>
                    <th scope="col" class="trth_pl" colspan="2" style="text-align: center;">Member </th>
                    <th th scope="col" class="trth_ag" colspan="2" style="text-align: center;">Agen </th>
                    <th scope="col" class="trth_co_main" colspan="3" rowspan="2" style="text-align: center;"> Company </th>
								</tr>
								<tr class="header-sub ">
										<th class="trth_ag align-center border-1px width-100px" style="text-align: center;"> Win Lose </th>
										<th class="trth_ag align-center border-1px width-100px" style="text-align: center;"> Total </th>
										<th class="trth_ag align-center border-1px width-100px" style="text-align: center;"> Win Lose </th>
										<th class="trth_ag align-center border-1px width-100px" style="text-align: center;"> Total </th>
								</tr>
          </thead>
        <tbody>
          <?php
$count = 1;
$total_turnover_all = 0;
$total_bet_payout_all = 0;
$total_bet_payout_win_all = 0;
$total_bet_payout_company_all = 0;

// Tampilkan baris untuk setiap provider
if (!empty($total_turnover_per_provider) && !empty($total_bet_payout_per_provider)) {
    foreach ($total_turnover_per_provider as $provider => $total_turnover) {
        // Tentukan warna teks berdasarkan nilai Bet-Payout
        $text_color = ($total_bet_payout_per_provider[$provider] < 0) ? 'red' : 'black';
        $text_color_win = ($total_bet_payout_per_provider[$provider] < 0) ? 'black' : 'red';
        $text_color_style = isset($text_color) ? 'color:' . $text_color : '';
        $text_color_style_win = isset($text_color_win) ? 'color:' . $text_color_win : '';

        echo '<tr>';
        echo '<td class="align-center border-1px" style="text-align: center;">' . $count++ . '</td>';
        echo isset($provider) ? '<td class="form-caption" style="text-align: center;"><a href="Member-WinLose-Provider?username=' . urlencode($_GET['username']) . '&provider=' . urlencode($provider) . '&strDate=' . urlencode($_GET['strDate']) . '&endDate=' . urlencode($_GET['endDate']) . '">' . $provider . '</a></td>' : '';
        echo '<td class="align-right" style="text-align: center;">' . number_format($total_turnover) . ' <i></i></td>';
        echo '<td class="align-right" style="text-align: center;"><span style="' . $text_color_style . '">' . formatRupiah($total_bet_payout_per_provider[$provider]) . '</span> <i></i></td>';
        echo '<td class="align-right" style="text-align: center;"><span style="' . $text_color_style . '">' . formatRupiah($total_bet_payout_per_provider[$provider]) . '</span> <i></i></td>';
        echo '<td class="align-right" style="text-align: center;"><span style="' . $text_color_style_win . '">' . formatRupiah($total_bet_payout_per_provider_win[$provider]) . '</span> <i></i></td>';
        echo '<td class="align-right" style="text-align: center;"><span style="' . $text_color_style_win . '">' . formatRupiah($total_bet_payout_per_provider_win[$provider]) . '</span> <i></i></td>';
        echo '<td class="align-right" style="text-align: center;"><span style="' . $text_color_style_win . '">' . formatRupiah($total_bet_payout_per_provider_Company[$provider]) . '</span> <i></i></td>';
        echo '</tr>';

        // Tambahkan nilai ke total keseluruhan
        $total_turnover_all += $total_turnover;
        $total_bet_payout_all += $total_bet_payout_per_provider[$provider];
        $total_bet_payout_win_all += $total_bet_payout_per_provider_win[$provider];
        $total_bet_payout_company_all += $total_bet_payout_per_provider_Company[$provider];
    }
      } else {
      // Jika tidak ada data, tampilkan baris kosong
      echo '<tr>';
      echo '<td colspan="8" class="text-center">Tidak ada data</td>';
      echo '</tr>';
    }

    $text_color_all = ($total_bet_payout_all < 0) ? 'red' : 'black';
    $text_color_win_all = ($total_bet_payout_win_all < 0) ? 'red' : 'black';
    $text_color_win_company = ($total_bet_payout_win_all < 0) ? 'red' : 'black';
    $text_color_style_all = isset($text_color_all) ? 'color:' . $text_color_all : '';
    $text_color_style_win_all = isset($text_color_win_all) ? 'color:' . $text_color_win_all : '';
    $text_color_style_company = isset($text_color_win_company) ? 'color:' . $text_color_win_company : '';

        // Tampilkan total keseluruhan di bagian footer
        echo '<tfoot>';
        echo '<tr>';
        echo '<td colspan="2" class="align-center" style="text-align: center;"><strong>Total</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong>' . number_format($total_turnover_all) . '</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong style="' . $text_color_style_all . '">' . formatRupiah($total_bet_payout_all) . '</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong style="' . $text_color_style_all . '">' . formatRupiah($total_bet_payout_all) . '</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong style="' . $text_color_style_win_all . '">' . formatRupiah($total_bet_payout_win_all) . '</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong style="' . $text_color_style_win_all . '">' . formatRupiah($total_bet_payout_win_all) . '</strong></td>';
        echo '<td class="align-right" style="text-align: center;"><strong style="' . $text_color_style_company . '">' . formatRupiah($total_bet_payout_company_all) . '</strong></td>';
        echo '</tr>';
        echo '</tfoot>';
?>
        </tbody>
</table>
          </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan elemen-elemen yang dibutuhkan
    var usernameInput = document.getElementById('username');
    var strDateInput = document.getElementById('strDate');
    var endDateInput = document.getElementById('endDate');
    var searchButton = document.getElementById('searchButton');

    // Menambahkan event listener pada tombol pencarian
    searchButton.addEventListener('click', function () {
        // Mendapatkan nilai dari input username, strDate, dan endDate
        var username = usernameInput.value.trim();
        var strDate = strDateInput.value;
        var endDate = endDateInput.value;

        // Membuat URL baru dengan menambahkan parameter username, strDate, dan endDate
        var newUrl = window.location.origin + window.location.pathname + '?username=' + encodeURIComponent(username) + '&strDate=' + encodeURIComponent(strDate) + '&endDate=' + encodeURIComponent(endDate);

        // Mengarahkan ke URL baru
        window.location.href = newUrl;
    });

    // Mengambil nilai parameter username, strDate, dan endDate dari URL (jika ada)
    var urlParams = new URLSearchParams(window.location.search);
    var usernameParam = urlParams.get('username');
    var strDateParam = urlParams.get('strDate');
    var endDateParam = urlParams.get('endDate');

    // Jika parameter username, strDate, dan endDate ada, set nilai input sesuai dengan nilai parameter
    if (usernameParam) {
        usernameInput.value = usernameParam;
    }
    if (strDateParam) {
        strDateInput.value = strDateParam;
    }
    if (endDateParam) {
        endDateInput.value = endDateParam;
    }
});
</script>

<?php include("footer.php"); ?>