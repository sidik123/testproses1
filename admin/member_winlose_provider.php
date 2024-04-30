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
  $provider = $_GET['provider'];
  $strDate = $_GET['strDate'];
  $endDate = $_GET['endDate'];

  // Query untuk mengambil data dari bet_history sesuai dengan username, strDate, dan endDate
  $query_bet_history = "SELECT * FROM bet_history WHERE provider = '$provider' AND Username = '$username' AND tanggal_masuk >= '$strDate' AND tanggal_masuk <= '$endDate 23:59:59' ORDER BY id DESC";
  $result_bet_history = $koneksi->query($query_bet_history);

  if ($result_bet_history) {
      // Iterasi melalui hasil query bet_history
      while ($row = $result_bet_history->fetch_assoc()) {
          // Ambil nilai Provider, Turnover, Bet, dan Payout dari setiap baris
          $provider = $row['Provider'];
          $turnover = $row['Turnover'];
          $bet = $row['Bet'];
          $payout = $row['Payout'];
          $Status = $row['Status'];
          $parent_bet_id = $row['parent_bet_id'];
          $row_version = $row['row_version'];
          $tanggal_masuk = $row['tanggal_masuk'];
          $Game_ID = $row['Game_ID'];
          $Game_Name = $row['Game_Name'];
          $Id_bet = $row['Id_bet'];
          $Ref_No = $row['Ref_No'];

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
											<input type="date" class="form-control max-width-150px" name="strDate" id="strDate" placeholder="Start Date" value="<?php echo $_GET['strDate']; ?>">
											<div class="input-group-prepend"> <span class="input-group-text font-size-12px"> Sampai </span>
											</div>
											<input type="date" class="form-control max-width-150px" name="endDate" id="endDate" placeholder="End Date" value="<?php echo $_GET['endDate']; ?>">
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
									<input type="text" class="form-control max-width-200px" id="username" placeholder="" value="<?php echo $_GET['username']; ?>">
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
<table id="dataListProvider" user-lvl="5" data-report="pl" class="table table-hover table-bordered" data-tier="2">
          <thead id="pl-head" class="table-dark" style="border-color: white;">
                <tr class="header-sub">
                    <th scope="col" rowspan="2" style="text-align: center;"> No </th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Time </th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Username </th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Information </th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Turnover </th>
                    <th scope="col" rowspan="2" style="text-align: center;"> Status </th>
                    <th scope="col" class="trth_pl" colspan="2" style="text-align: center;"> Member </th>
                </tr>
                <tr class="header-sub">
                    <th class="trth_ag" style="text-align: center;"> Win Lose </th>
                    <th class="trth_ag" style="text-align: center;"> Comm </th>
                </tr>
          </thead>
          <tbody>
          <?php
$counter = 1; // Counter untuk nomor urutan
// Periksa apakah hasil query bet_history tidak kosong
if ($result_bet_history && $result_bet_history->num_rows > 0) {
    // Iterasi melalui hasil query bet_history
    foreach ($result_bet_history as $row) {
        // Ambil nilai-nilai yang diperlukan dari setiap baris
        $tanggal_masuk = $row['tanggal_masuk'];
        $username = $row['Username'];
        $Id_bet = $row['Id_bet'];
        $Ref_No = $row['Ref_No'];
        $Game_ID = $row['Game_ID'];
        $Game_Name = $row['Game_Name'];
        $Type = $row['Type'];
        $Turnover = $row['Turnover'];
        $Payout = $row['Payout'];
        $bet = $row['Bet'];
        $total_bet_payout = $Payout - $bet;

        // Tentukan status berdasarkan nilai Payout dan Bet
        $status = '';
        $status_style = '';
        if ($Payout > $bet) {
            $status = 'Win';
            $status_style = 'color: green;'; // Warna hijau untuk Win
        } elseif ($Payout < $bet) {
            $status = 'Lose';
            $status_style = 'color: red;'; // Warna merah untuk Lose
        } else {
            $status = 'Draw';
        }

        // Tentukan warna teks berdasarkan nilai total_bet_payout
        $payout_color = $total_bet_payout >= 0 ? 'color: black;' : 'color: red;';

        // Tampilkan data dalam baris HTML
        echo '<tr>';
        echo '<td class="align-center border-1px">' . $counter . '</td>';
        echo '<td class="text-left border-1px">' . $tanggal_masuk . '</td>';
        echo '<td class="text-left border-1px">' . $username . '</td>';
        if ($provider === "PGSOFT") {
          echo '<td class="text-left border-1px">Id Bet :  ' . $Id_bet . '<br> Ref No :  ' . $Ref_No . '<br> Parameter Id :  ' . $parent_bet_id . '<br> Row Version :  ' . $row_version.'<br> Game Code :  ' . $Game_ID . '<br> Game Name :  [' . $Game_Name . ']</td>';
      } elseif ($provider === "SBOSports") {
          echo '<td class="text-left border-1px">Id Bet :  ' . $Id_bet . '<br> Ref No :  ' . $Ref_No . '<br> Game Code :  ' . $Type . '<br> Game Name :  [' . $Game_Name . ']<br> Game Info :  ' . $parent_bet_id . '</td>';
      } else {
          echo '<td class="text-left border-1px">Id Bet :  ' . $Id_bet . '<br> Ref No :  ' . $Ref_No . '<br> Game Code :  ' . $Game_ID . '<br> Game Name :  [' . $Game_Name . ']</td>';
      }      
        echo '<td class="text-right border-1px">' . number_format($Turnover) . '</td>';
        echo '<td class="text-right border-1px" style="' . $status_style . '">' . $status . '</td>';
        echo '<td class="text-right border-1px" style="' . $payout_color . '"><span>' . formatRupiah($total_bet_payout) . '</span></td>';
        echo '<td class="text-right border-1px trth_ss"></td>';
        echo '</tr>';

        $counter++; // Tingkatkan nomor urutan
    }
} else {
    // Jika tidak ada hasil dari query, tampilkan pesan kosong
    echo '<tr><td colspan="8" class="text-center">No records found</td></tr>';
}
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
        var newUrl = 'Member-WinLose' + '?username=' + encodeURIComponent(username) + '&strDate=' + encodeURIComponent(strDate) + '&endDate=' + encodeURIComponent(endDate);

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