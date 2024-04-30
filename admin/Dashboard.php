<?php
include("../fungsi/koneksi.php");

date_default_timezone_set('Asia/Jakarta');
$current_date = date("Y-m-d");

// Periksa apakah ada permintaan POST dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim dari formulir
    $whatsapp = $_POST['whatsapp'];
    $youtube = $_POST['youtube'];
    $twitter = $_POST['twitter'];
    $telegram = $_POST['telegram'];
    $facebook  = $_POST['facebook'];
    // tambahkan kolom lainnya di sini sesuai dengan formulir Anda

    // Siapkan query SQL untuk memperbarui data
    $sql = "UPDATE kontakkami SET Whatsapp=?, Telegram=?, Facebook=?, Twitter=?, Youtube=?";

    // Persiapkan statement SQL
    $stmt = $koneksi->prepare($sql);

    // Bind parameter ke statement
    $stmt->bind_param("sssss", $whatsapp, $telegram, $facebook, $twitter, $youtube);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Data berhasil diperbarui di database
        // Set pesan notifikasi
        $pesan = 'Data Berhasil Di Perbaharui.';
    } else {
        // Gagal memperbarui data di database
        $pesan = 'Gagal memperbarui data di database: ' . $koneksi->error;
    }

    // Tutup statement
    $stmt->close();

}

function formatRupiah($nominal) {
  $formattedNominal = "Rp " . number_format($nominal, 0, ',', '.');
  return $formattedNominal;
}

  // Query untuk mengambil data dari bet_history sesuai dengan strDate dan endDate
  $query_bet_provider = "SELECT * FROM bet_history WHERE DATE(tanggal_masuk) = '$current_date'";
  $result_bet_provider = $koneksi->query($query_bet_provider);

  if ($result_bet_provider) {
      // Array untuk menyimpan total turnover dan total bet-payout dari setiap provider
      $total_turnover_per_provider = array();
      $total_bet_payout_per_provider = array();
      $total_bet_payout_per_provider_win = array();
      $total_bet_payout_per_provider_Company = array();


      // Iterasi melalui hasil query bet_history
      while ($row = $result_bet_provider->fetch_assoc()) {
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

            <div class="">
              <div class="row">
                <!-- Statistics -->
                <div class="col-sm-8" style="padding-top: 60px;">
  <h4 class="page-title"> CYBERPANEL Management List </h4>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Dashboard</li>
  </ol>
</div>
                <div class="col-xl-12 mb-4 col-lg-12 col-12">
                  <div class="card h-100">
                    <div class="card-header">
                      <h5 class="card-title">Total Report</h5>
                    </div>
                    <div class="card-body border 1px">
                      <div class="row gy-3">
                        <div class="col-md-3 col-6 mt-3">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-success me-3 p-2">
                              <i class="fas fa-dollar-sign fa-3x" style="color: #63E6BE;"></i>
                            </div>
                            <div class="card-info d-flex justify-content-between">
                              <div style="padding-right: 10px;">
                                <h5 class="mb-0">Rp: <?php echo number_format($coin_admin); ?></h5>
                                <small>Coin Website</small>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                              <i class="fas fa-dollar-sign fa-3x" style="color: #63E6BE;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">Rp: <?php echo number_format($coin_kios); ?></h5>
                              <small>Coin Provider</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body">
                      <div class="row gy-3">
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-info me-3 p-2">
                            <i class="fas fa-users fa-2x" style="color: #74C0FC;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0"> <?php echo number_format($total_member); ?></h5>
                              <small>Total Member</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                            <i class="fas fa-shopping-cart fa-2x" style="color: #ff0000;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0"> <?php echo number_format($total_nominal_deposit); ?></h5>
                              <small>Total Deposit</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                            <i class="fas fa-chart-pie fa-2x" style="color: #B197FC;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0 text-danger">Rp. <?php echo number_format($total_nominal_wd); ?></h5>
                              <small>Total Withdraw</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge bg-label-success me-3 p-2">
                              <i class="fas fa-wallet fa-2x" style="color: #212121;;"></i>
                            </div>
                            <div class="card-info">
                              <?php 
                              $difference = $total_nominal_deposit - $total_nominal_wd;
                              $formatted_difference = number_format($difference);
                                if ($difference > 0) {
                                  echo '<h5 class="mb-0">Rp. '.$formatted_difference.'</h5>';
                                } elseif ($difference < 0) {
                                  echo '<h5 class="mb-0 text-danger">Rp. '.$formatted_difference.'</h5>';
                                } else {
                                  echo '<h5 class="mb-0">Rp. '.$formatted_difference.'</h5>';
                                }
                              ?>
                              <small>Total Income</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  
                <!-- Statistics -->
                <div class="col-xl-12 mb-4 col-lg-12 col-12">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">Daily Report</h5>
                        <!--<small class="text-muted">Daily Report</small>-->
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row gy-3">
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-info me-3 p-2">
                            <i class="fas fa-users fa-2x" style="color: #74C0FC;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0"> <?php echo number_format($daily_member); ?></h5>
                              <small>New Member</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                            <i class="fas fa-shopping-cart fa-2x" style="color: #ff0000;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">Rp. <?php echo number_format($daily_nominal_deposit); ?></h5>
                              <small>Today Deposit</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                            <i class="fas fa-chart-pie fa-2x" style="color: #B197FC;"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0 text-danger">Rp. <?php echo number_format($daily_nominal_wd); ?></h5>
                              <small>Today Withdraw</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge bg-label-success me-3 p-2">
                              <i class="fas fa-wallet fa-2x" style="color: #212121;;"></i>
                            </div>
                            <div class="card-info">
                            <?php 
                              $difference_daily = $daily_nominal_deposit - $daily_nominal_wd;
                              $formatted_difference_daily = number_format($difference_daily);
                                if ($difference_daily > 0) {
                                  echo '<h5 class="mb-0">Rp. '.$formatted_difference_daily.'</h5>';
                                } elseif ($difference_daily < 0) {
                                  echo '<h5 class="mb-0 text-danger">Rp. '.$formatted_difference_daily.'</h5>';
                                } else {
                                  echo '<h5 class="mb-0">Rp. '.$formatted_difference_daily.'</h5>';
                                }
                              ?>
                              <small>Today Income</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!--/ Statistics -->

                <!-- Revenue Report -->
                <div class="">
                  <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                      <div class="card-title mb-0">
                        <h5 class="mb-3">Weekly Earning Reports</h5>
                        <!-- <small class="text-muted">Penghasilan Dalam 1 Bulan</small> -->
                      </div>
                      <!-- </div> -->
                    </div>
                      <!--<div class="row">-->
                        <!--<div class="col-12 col-md-4 d-flex flex-column align-self-end">-->
                      <!--    <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">-->
                      <!--      <h1 class="mb-0 mt-4 <?php echo ($s1['deposit'] < $s2['withdraw']) ? 'text-danger' : ''; ?>">-->
                      <!--          Rp. <?php echo number_format($s1['deposit'] - $s2['withdraw']); ?>-->
                      <!--      </h1>-->
                      <!--      <div class="badge rounded bg-label-success"></div>-->
                      <!--    </div>-->
                      <!--    <small class="text-muted"></small>-->
                      <!--</div>-->
                      <div class="border rounded p-3">
                        <div class="row gap-4 gap-sm-0">
                          <!--<div class="col-6 col-sm-6">-->
                          <!--  <div class="d-flex gap-2 align-items-center">-->
                          <!--    <div class="badge rounded bg-label-primary p-1">-->
                          <!--      <i class="ti ti-currency-dollar ti-sm"></i>-->
                          <!--    </div>-->
                          <!--    <h6 class="mb-0">Total Deposit</h6>-->
                          <!--  </div>-->
                          <!--  <h4 class="my-2">Rp. <?php echo number_format($s1['deposit']); ?></h4>-->
                            <!--<div class="progress w-75" style="height: 4px">-->
                            <!--  <div-->
                            <!--    class="progress-bar"-->
                            <!--    role="progressbar"-->
                            <!--    style="width: 65%"-->
                            <!--    aria-valuenow="65"-->
                            <!--    aria-valuemin="0"-->
                            <!--    aria-valuemax="100"-->
                            <!--  ></div>-->
                            <!--</div>-->
                          <!--</div>-->
                          <!--<div class="col-6 col-sm-6">-->
                          <!--  <div class="d-flex gap-2 align-items-center">-->
                          <!--    <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i></div>-->
                          <!--    <h6 class="mb-0">Total Withdraw</h6>-->
                          <!--  </div>-->
                          <!--  <h4 class="my-2 text-danger">Rp. -<?php echo number_format($s2['withdraw']); ?></h4>-->
                            <!--<div class="progress w-75" style="height: 4px">-->
                            <!--  <div-->
                            <!--    class="progress-bar bg-info"-->
                            <!--    role="progressbar"-->
                            <!--    style="width: 50%"-->
                            <!--    aria-valuenow="50"-->
                            <!--    aria-valuemin="0"-->
                            <!--    aria-valuemax="100"-->
                            <!--  ></div>-->
                            <!--</div>-->
                          <!--</div>-->
                        </div>
                        <div class="datacontainer">
                            <!-- <h5 class="mb-3">Weekly Earning Reports</h5> -->
                            <div id="weeklyEarningReports"></div>
                            <canvas id="myChart" width="100" height="50"></canvas>
                        </div>
                        </div>
                    </div>
                  </div>


                  <div class="col-xl-12 mb-4 col-lg-12 col-12">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">Daily Report Provider</h5>
                        <!--<small class="text-muted">Daily Report</small>-->
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row gy-3">
                      <div class="table-responsive">
<table id="dataList" user-lvl="5" data-report="pl" class="table table-hover table-bordered" data-tier="2" style="border: 1px;">
          <thead id="ag-head" class="table-dark" style="border-color: white;">
								<tr class="header-sub ">
                    <th scope="col" rowspan="2" style="text-align: center;"> No </th>
                    <th scope="col" rowspan="2" id="ag-title" style="text-align: center;"> Provider</th>
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
        echo isset($provider) ? '<td class="form-caption" style="text-align: center;">' . $provider . '</td>' : '<td class="form-caption" style="text-align: center;">-</td>';
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
      echo '<td colspan="8" class="text-center">Tidak Ada Data Untuk Hari Ini</td>';
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
                    </div>
                  </div>
                </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
async function fetchDailyData() {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../admin_realtime/get-daily-data.php', true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                resolve(JSON.parse(xhr.responseText));
            } else {
                reject(xhr.statusText);
            }
        };

        xhr.onerror = function () {
            reject(xhr.statusText);
        };

        xhr.send();
    });
}

async function createChart() {
    try {
        const data = await fetchDailyData();

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data.deposit),
                datasets: [{
                    label: 'Deposit',
                    data: Object.values(data.deposit),
                    backgroundColor: 'rgba(19, 255, 0)',
          borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Withdraw',
                    data: Object.values(data.withdraw),
                    backgroundColor: 'rgba(255, 0, 0)',
          borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error creating chart:', error);
    }
}

createChart();
</script>


<?php include("footer.php"); ?>