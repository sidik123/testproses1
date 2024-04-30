<?php
session_start();
if (empty($_SESSION['admin_username'])){
    header("Location: ../admin/login.php");
    exit();
}
include("../fungsi/koneksi.php");

date_default_timezone_set('Asia/Jakarta');
$current_date = date("Y-m-d");

// Mengambil username dari $_SESSION
$admin_username = $_SESSION['admin_username'];

// Mencari username di tabel master_admin
$query = "SELECT name FROM master_admin WHERE username = '$admin_username'";
$result = $koneksi->query($query);

// Memeriksa apakah query berhasil dieksekusi
if ($result) {
    // Memeriksa apakah ada baris data yang ditemukan
    if ($result->num_rows > 0) {
        // Mengambil data dari baris pertama
        $row = $result->fetch_assoc();
        $admin_name = $row['name'];

        // Menampilkan nama admin
    } else {
        echo "Tidak ada data yang ditemukan dalam tabel master_admin.";
    }
} else {
    echo "Terjadi kesalahan dalam menjalankan query: " . $koneksi;
}

// Mendapatkan data bank dari tabel bank_list dengan status aktif
$sqlBank = "SELECT * FROM bank_list";
$resultBank = $koneksi->query($sqlBank);

$bankOptions = array();

if ($resultBank->num_rows > 0) {
    while ($rowBank = $resultBank->fetch_assoc()) {
        $adminBank = $rowBank["admin_bank"];
        $adminNamaBank = $rowBank["admin_namabank"];
        $adminNorek = $rowBank["admin_norek"];

        // Tambahkan opsi bank ke array bankOptions
        $bankOptions[$adminBank] = array(
            "admin_bank" => $adminBank,
            "admin_namabank" => $adminNamaBank,
            "admin_norek" => $adminNorek
        );
    }
} else {
    // Jika tidak ada data bank aktif ditemukan, tampilkan notifikasi kosong
    echo "Data bank tidak ditemukan";
}

// Mendapatkan data dompet utama dari tabel member
$sqlDompet = "SELECT coin FROM member";
$resultDompet = $koneksi->query($sqlDompet);

$queryWebsite = mysqli_query($koneksi, "SELECT * FROM website");
if($rowWebsite = mysqli_fetch_assoc($queryWebsite)) {
    $Marquee = $rowWebsite['Marquee'];
    $alamat_website = $rowWebsite['WebUrl'];
    $alamat_websitePanel = $rowWebsite['WebUrlPanel'];
    $websiteIcon = $rowWebsite['icon'];
    $namaWebsite = $rowWebsite['namaWebsite'];
    $websiteDescription = $rowWebsite['description'];
    $websiteMetaHeader = $rowWebsite['MetaHeader'];
    $websiteMetaHeaderWeb = $rowWebsite['MetaHeaderWeb'];
    $websiteFooterHeader = $rowWebsite['FooterHeader'];
    $websiteFooterWebsite = $rowWebsite['Footer'];
    $LiveChatDesktop = $rowWebsite['LiveChatDesktop'];
    $LiveChatMobile = $rowWebsite['LiveChatMobile'];
    $GoogleAnalytic	 = $rowWebsite['GoogleAnalytic'];
    $websiteKeyword = $rowWebsite['Keyword'];
    $websiteTitle = $rowWebsite['Title'];
    $websiteFooter = $rowWebsite['Footer'];
    $websiteTransaksiInfoDP = $rowWebsite['transaksiInfoDP'];
    $websiteTransaksiInfoWD = $rowWebsite['transaksiInfoWD'];
}

$queryWebsitekontakkami = mysqli_query($koneksi, "SELECT * FROM kontakkami");
if($rowWebsiteKontakKami = mysqli_fetch_assoc($queryWebsitekontakkami)) {
    $Whatsapp = $rowWebsiteKontakKami['Whatsapp'];
    $Telegram = $rowWebsiteKontakKami['Telegram'];
    $Facebook = $rowWebsiteKontakKami['Facebook'];
    $Twitter = $rowWebsiteKontakKami['Twitter'];
    $Youtube = $rowWebsiteKontakKami['Youtube'];
}

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

$query_master_admin = "SELECT coin FROM master_admin WHERE name = 'MASTER ADMIN'";
$result_master_admin = mysqli_query($koneksi, $query_master_admin);

while ($row_master_admin = mysqli_fetch_assoc($result_master_admin)) {
    $coin_admin = $row_master_admin['coin'];
}

    $sql_total_member = "SELECT COUNT(*) AS total FROM member";
    $result_total_member = $koneksi->query($sql_total_member);

    if ($result_total_member->num_rows > 0) {
        $row_total_member = $result_total_member->fetch_assoc();
        $total_member = $row_total_member["total"];
    }

    $sql_total_Nominal_deposit = "SELECT SUM(nominal) AS total_nominal_dp FROM dp_history WHERE status = 'proses'";
    $result_total_Nominal_deposit = $koneksi->query($sql_total_Nominal_deposit);
    
    if ($result_total_Nominal_deposit->num_rows > 0) {
      $row_total_Nominal_deposit = $result_total_Nominal_deposit->fetch_assoc();
      $total_nominal_deposit = $row_total_Nominal_deposit["total_nominal_dp"];
    }

    $sql_total_Nominal_wd = "SELECT SUM(nominal) AS total_nominal_wd FROM wd_history WHERE status = 'proses'";
    $result_total_Nominal_wd = $koneksi->query($sql_total_Nominal_wd);
    
    if ($result_total_Nominal_wd->num_rows > 0) {
      $row_total_Nominal_wd = $result_total_Nominal_wd->fetch_assoc();
      $total_nominal_wd = $row_total_Nominal_wd["total_nominal_wd"];
    }

    ////
    $daily_total_member = "SELECT COUNT(*) AS total_member_daily FROM member WHERE DATE(tanggal_daftar) = '$current_date'";
    $daily_total_member = $koneksi->query($daily_total_member);

    if ($daily_total_member->num_rows > 0) {
        $daily_total_member = $daily_total_member->fetch_assoc();
        $daily_member = $daily_total_member["total_member_daily"];
    }

    $daily_total_Nominal_deposit = "SELECT SUM(nominal) AS daily_nominal_dp FROM dp_history WHERE DATE(tanggal_masuk) = '$current_date' AND status = 'proses'";
    $daily_total_Nominal_deposit = $koneksi->query($daily_total_Nominal_deposit);
    
    if ($daily_total_Nominal_deposit->num_rows > 0) {
      $daily_total_Nominal_deposit = $daily_total_Nominal_deposit->fetch_assoc();
      $daily_nominal_deposit = $daily_total_Nominal_deposit["daily_nominal_dp"];
    }

    $daily_total_Nominal_wd = "SELECT SUM(nominal) AS daily_nominal_wd FROM wd_history WHERE DATE(tanggal_masuk) = '$current_date' AND status = 'proses'";
    $daily_total_Nominal_wd = $koneksi->query($daily_total_Nominal_wd);
    
    if ($daily_total_Nominal_wd->num_rows > 0) {
      $daily_total_Nominal_wd = $daily_total_Nominal_wd->fetch_assoc();
      $daily_nominal_wd = $daily_total_Nominal_wd["daily_nominal_wd"];
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<?php echo $websiteMetaHeader ?>
</head>

<body>
  <a href="Dashboard">
    <div class="sidebar close">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
  </a>
  <?php echo '<span class="logo_name"> CYBER PANEL </span>'; ?>
    </div>
<?php echo '<div class="announcement" style="color: white; background-color: black; font-size: 15px;"><marquee>SELAMAT DATANG DI CYBER PANEL ' . $admin_name . '</marquee></div>'	?>
  <ul class="nav-links" style="z-index: 9999;">
  <li>
  <div class="iocn-link">
    <a href="javaScript:void();" id="dashboardLink">
      <i class='bx bx-grid-alt'></i>
      <span class="link_name">Dashboard</span>
    </a>
  </div>
</li>
    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
        <i class="fas fa-globe"></i>
          <span class="link_name">Website Manage</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Website Management</a></li>
        <li><a href="Promotion">[ Promotion ]</a></li>
        <li><a href="Web-Setting">[ Website Setting ]</a></li>
        <li><a href="contactus">[ Contact Us ]</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
          <i class="fas fa-users"></i>
          <span class="link_name">Member Manage</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Member Manage</a></li>
        <li><a href="Member-List">[ Member Monitor ]</a></li>
        <li><a href="Member-WinLose">[ Member Win Lose ]</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
        <i class="fas fa-university"></i>
          <span class="link_name">Bank Manage</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Bank Management</a></li>
        <li><a href="Bank-List">[ Bank List Monitor ]</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
        <i class="far fa-arrow-alt-circle-down"></i>
          <span class="link_name">DP Monitor</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Monitoring Deposit</a></li>
        <li><a href="Depo-Monitor">[ Deposit Monitor ]</a></li>
        <li><a href="Manual-Depo">[ Deposit Manual ]</a></li>
        <li><a href="Depo-History">[ Deposit History ]</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
         <i class="far fa-arrow-alt-circle-up"></i>
          <span class="link_name">WD Monitor</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Withdraw Monitor</a></li>
        <li><a href="Wd-Monitor">[ Withdraw Monitor ]</a></li>
        <li><a href="Manual-Withdraw">[ Withdraw Manual ]</a></li>
        <li><a href="Withdraw-History">[ Withdraw History ]</a></li>
      </ul>
    </li>

    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
          <i class="fas fa-chart-line"></i>
          <span class="link_name">Provider Report</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name">Provider Report</a></li>
        <li><a href="Provider-Win-Lose">[ Report Provider ]</a></li>
      </ul>
    </li>

    <li>
      <div class="iocn-link">
        <a href="javaScript:void();">
         <i class="far fa-user"></i>
          <span class="link_name">User Manage</span>
        </a>
        <i class='bx bxs-chevron-left arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">User Manage</a></li>
        <li><a href="#">[ User Setting ]</a></li>
        <li><a href="Logout">[ Logout ]</a></li>
      </ul>
    </li>
  </ul>
</div>

<section class="home-section">
    <div class="home-content" style="border-bottom: 1px solid black;">
        <div class="d-flex justify-content-between align-items-center">
            <i class='bx bx-menu'></i>
            <ul class="nav">
                <li class="nav-item d-none d-sm-block">
                    <div class="btn-group group-top m-1">
                        <div class="btn btn-primary font-size-11px">
                            <i class="zmdi zmdi-account"></i>
                            <?php echo '<span>Username : ' . $admin_name . '</span>'; ?>
                        </div>
                        <div class="btn btn-primary font-size-11px" onclick="window.location.href='Depo-Monitor';">
                            <span> Dp : <a style="color: white;" id="tpdp"></a></span>
                        </div>
                        <div class="btn btn-primary font-size-11px " onclick="window.location.href='Wd-Monitor';">
                            <span> Wd : <a style="color: white;" id="tpwd"></a></span>
                        </div>
                        <div class="btn btn-primary font-size-11px" title="Credit Used">
                            <i class="fa fa-usd"></i> <span>Balance: <a style="color: white;"><span id="coin"></span></a>
                        </div>
                        <a href="" class="btn btn-primary user-info-balance" style="padding: 1px; font-size: 22px" title="Refresh_Balance">
                            <span id="buttonRefresh" class="buttonRefresh">
                                <ion-icon id="ion" name="refresh-circle-outline"></ion-icon>
                            </span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="logout-btn" style="margin-left: auto; margin-right: 0px; ">
          <a href="logout.php">
            <button type="button" id="logout" class="btn btn-danger waves-effect waves-light m-1"><i class="fas fa-sign-out-alt"></i> Log Out </button>
          </a>
        </div>
    </div>
    <audio id="sound" src="../coin.mp3"></audio>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // Ambil elemen link dashboard
  var dashboardLink = document.getElementById("dashboardLink");
  
  // Tambahkan event listener untuk menangani klik
  dashboardLink.addEventListener("click", function(event) {
    // Hentikan perilaku bawaan dari tautan
    event.preventDefault();
    
    // Redirect ke halaman "Dashboard"
    window.location.href = "Dashboard";
  });
});
</script>

    <script>
// Membuat koneksi WebSocket ke server
const ws = new WebSocket('ws://localhost:3000');

// Event listener saat koneksi terbuka
ws.addEventListener('open', function(event) {
  console.log('Connected to server');
});

// Event listener saat menerima pesan dari server
ws.addEventListener('message', function(event) {
  var coin = event.data;

  // Memformat nilai coin (contoh: formatRupiah adalah fungsi yang belum ditentukan)
  var formattedCoin = formatRupiah(coin);

  // Menampilkan nilai coin
  $('#coin').text(formattedCoin);
});

// Event listener saat koneksi ditutup
ws.addEventListener('close', function(event) {
  console.log('Disconnected from server');
});

// Event listener saat terjadi kesalahan
ws.addEventListener('error', function(event) {
  console.log('Error:', event.error);
});

                                // Function to format the nominal value as Indonesian Rupiah
                                function formatRupiah(nominal) {
                                    var rupiah = '';
                                    var numberString = nominal.toString();
                                    var sisa = numberString.length % 3;
                                    var thousandsSeparator = '.';
                                    for (var i = 0; i < numberString.length; i++) {
                                        rupiah += numberString[i];
                                        if (i < numberString.length - 1) {
                                            if ((i + 1) % 3 === sisa) {
                                                rupiah += thousandsSeparator;
                                            }
                                        }
                                    }
                                    return 'Rp ' + rupiah;
                                }
                                
$(document).ready(function () {
  var storedCount = localStorage.getItem('dataCount');
  var sound = document.getElementById('sound');
  var ws = new WebSocket('ws://localhost:8080');

  function updateDataCount() {
    // Mengirim pesan ke server WebSocket untuk meminta data terbaru
    ws.send('getLatestData');
  }

  // Mengatur event listener untuk menerima pesan dari server WebSocket
  ws.onmessage = function (event) {
    var data = JSON.parse(event.data);
    var count = data.length;

    $('#tpdp').text(count);

    // Memeriksa apakah nilai lebih besar dari 0
    if (count > 0) {
      // Memainkan suara
      sound.play();

      // Mengatur waktu tunda 1 menit sebelum memainkan suara lagi
      setTimeout(function () {
        sound.play();
      }, 60000); // 60000 milidetik = 1 menit
    }

    // Menyimpan nilai terbaru ke LocalStorage
    storedCount = count;
    localStorage.setItem('dataCount', count);
  };

  // Memanggil fungsi updateDataCount saat halaman pertama kali dimuat
  updateDataCount();
});

$(document).ready(function () {
  var storedCount = localStorage.getItem('dataCount');
  var sound = document.getElementById('sound');
  var ws = new WebSocket('ws://localhost:6060');

  function updateDataCount() {
    // Mengirim pesan ke server WebSocket untuk meminta data terbaru
    ws.send('getLatestData');
  }

  // Mengatur event listener untuk menerima pesan dari server WebSocket
  ws.onmessage = function (event) {
    var data = JSON.parse(event.data);
    var count = data.length;

    $('#tpwd').text(count);

    // Memeriksa apakah nilai lebih besar dari 0
    if (count > 0) {
      // Memainkan suara
      sound.play();

      // Mengatur waktu tunda 1 menit sebelum memainkan suara lagi
      setTimeout(function () {
        sound.play();
      }, 60000); // 60000 milidetik = 1 menit
    }

    // Menyimpan nilai terbaru ke LocalStorage
    storedCount = count;
    localStorage.setItem('dataCount', count);
  };

  // Memanggil fungsi updateDataCount saat halaman pertama kali dimuat
  updateDataCount();
});
    </script>
    