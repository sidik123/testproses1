<?php
include("../fungsi/koneksi.php");
?>

  <style>
ion-icon {
  font-size: 34px;
}

    .formtable{
      padding: 0;
      display: block;
    }

    #filterbank{
      text-align: center;
      justify-content: center;
      font-size: 15px;
    }

    #table-responsive-test{
      margin-bottom: -12px;
      height: 120px;
    }

    .filter-container{
      border: 1px solid black;
      padding: 0px;
    }

    .status{
      margin-bottom: -10px;
    }

    .status th{
      font-size: 13px;
    }

    #statushistory{
      text-align: center;
      justify-content: center;
    }

    #tgl{
      text-align: center;
      justify-content: center;
    }

    .table-responsive{
      margin-top: -20px;
    }

   .table-responsive tr{
     text-align: center;
      justify-content: center;
      padding: 0;
     font-size: 12px;
    }

    .tanggalhistory th{
      font-size: 13px;
    }

    #filterbank{
      font-size: 13px;
    }
  </style>

  <?php include("header.php") ?>

  <div class="col-sm-8" style="padding-top: 60px;">
    <h4 class="page-title"> Deposit History </h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">History</li>
    </ol>
  </div>
  <form class="formtable">
  <div class="table-responsive" id="table-responsive-test">
      <table class="table table-bordered mt-4" id="dataSortList">
        <thead class="table-dark">
          <tr>
              <td class="table-dark" style="font-weight: bold;" id="filterbank" colspan="20">
                FILTER BANK
              </td>
            </tr>
          </thead>
          <tbody class="formfilter">
            <tr class="filter-container">
              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="select-all" checked>
                  <label class="form-check-label" for="select-all">Select All</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="bca" checked>
                  <label class="form-check-label" for="bca">BCA</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="bri" checked>
                  <label class="form-check-label" for="bri">BRI</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="bni" checked>
                  <label class="form-check-label" for="bni">BNI</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="mandiri" checked>
                  <label class="form-check-label" for="mandiri">Mandiri</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="cimbniaga" checked>
                  <label class="form-check-label" for="cimbniaga">Cimb Niaga</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="danamon" checked>
                  <label class="form-check-label" for="danamon">Danamon</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="permata" checked>
                  <label class="form-check-label" for="permata">Permata</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="neobank" checked>
                  <label class="form-check-label" for="neobank">Neo Bank</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="jago" checked>
                  <label class="form-check-label" for="jago">Jago</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="sakuku" checked>
                  <label class="form-check-label" for="sakuku">Sakuku</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="bsi" checked>
                  <label class="form-check-label" for="bsi">BSI</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="panin" checked>
                  <label class="form-check-label" for="panin">Panin</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="ovo" checked>
                  <label class="form-check-label" for="ovo">Ovo</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="dana" checked>
                  <label class="form-check-label" for="dana">Dana</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="linkaja" checked>
                  <label class="form-check-label" for="linkaja">Link Aja</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="gopay" checked>
                  <label class="form-check-label" for="gopay">Gopay</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="xl" checked>
                  <label class="form-check-label" for="xl">XL</label>
                </div>
              </td>

              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="simpati" checked>
                  <label class="form-check-label" for="simpati">Simpati</label>
                </div>
              </td>

            </tr>
          </tbody>
        </table>
      </div>
      </form>

      <div class="status">
      <table class="table table-bordered mt-4">
        <thead>
          <tr class="table-dark" id="statushistory">
            <th colspan="2">STATUS HISTORY</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <select class="form-select" id="statusFilter">
                <option value="all">All</option>
                <option value="proses">Proses</option>
                <option value="tolak">Tolak</option>
              </select>
            </td>
            <td>
              <select class="form-select" id="typeFilter">
                <option value="all">All</option>
                <option value="withdraw">Withdraw</option>
                <option value="manual_withdraw">Manual Withdraw</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="tanggalhistory">
      <table class="table table-bordered mt-4">
        <thead>
          <tr class="table-dark">
            <th colspan="2" id="tgl">TANGGAL HISTORY</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="tanggalawal">
                <label for="startDate" class="form-label">Tanggal Kemarin</label>
                <input type="date" id="startDate" class="form-control" value="">
              </div>
            </td>
            <td>
              <div class="tanggalakhir">
                <label for="endDate" class="form-label">Tanggal Sekarang</label>
                <input type="date" id="endDate" class="form-control" value="">
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="search">
        <button type="button" class="btn btn-primary" onclick="search()"><i class="fas fa-search"></i> Search</button>
    </div>

    <div class="input-group mt-4 mb-1" style="border: 1px solid #000000;">
      <input type="text" class="form-control" id="usernameInput" placeholder="Search Username..." oninput="search()">
    </div>


    <div class="table-responsive">
      <table class="table table-bordered table-hover mt-4" id="dpHistoryTable">
      <thead class="table-dark" style="text-align: center;">
          <tr>
            <th>No</th>
            <th>Form</th>
            <th>Username</th>
            <th>User Bank</th>
            <th>User Nama Bank</th>
            <th>User No Rek</th>
            <th>Status</th>
            <th>Proses Oleh</th>
            <th>Di Cek Oleh</th>
            <th>Nominal</th>
            <th>Total</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Proses</th>
            <th>Member Note</th>
            <th>Admin Note</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data dari database akan dimuat di sini -->
          
        </tbody>
      </table>
    </div>

    <script src="../admin/assets/js/sidebar.js"></script>

<script>
var currentRow = 0;

function search() {
  var startDate = new Date(document.getElementById('startDate').value);
  var endDate = new Date(document.getElementById('endDate').value);
  var statusFilter = document.getElementById('statusFilter').value;
  var typeFilter = document.getElementById('typeFilter').value;
  var usernameInput = document.getElementById('usernameInput').value; // Mengambil nilai username dari input

  var bcaChecked = document.getElementById('bca').checked;
  var briChecked = document.getElementById('bri').checked;
  var bniChecked = document.getElementById('bni').checked;
  var mandiriChecked = document.getElementById('mandiri').checked;
  var cimbniagaChecked = document.getElementById('cimbniaga').checked;
  var danamonChecked = document.getElementById('danamon').checked;
  var permataChecked = document.getElementById('permata').checked;
  var neobankChecked = document.getElementById('neobank').checked;
  var jagoChecked = document.getElementById('jago').checked;
  var sakukuChecked = document.getElementById('sakuku').checked;
  var bsiChecked = document.getElementById('bsi').checked;
  var paninChecked = document.getElementById('panin').checked;
  var ovoChecked = document.getElementById('ovo').checked;
  var danaChecked = document.getElementById('dana').checked;
  var linkajaChecked = document.getElementById('linkaja').checked;
  var gopayChecked = document.getElementById('gopay').checked;
  var xlChecked = document.getElementById('xl').checked;
  var simpatiChecked = document.getElementById('simpati').checked;


  $.ajax({
    url: '../admin_realtime/get_wd_history.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      var filteredData = data.filter(function(item) {
  var tanggalMasuk = new Date(item.tanggal_masuk);

  if (startDate.getDate() === endDate.getDate()) {
    // Jika startDate dan endDate sama
    return tanggalMasuk.getDate() === startDate.getDate();
  } else {
  // Jika startDate dan endDate adalah tanggal yang sama
  if (startDate.getTime() === endDate.getTime()) {
    return tanggalMasuk.getTime() === startDate.getTime();
  }
  
  // Jika startDate dan endDate adalah tanggal yang berbeda
  return tanggalMasuk.getDate() >= startDate.getDate() && tanggalMasuk <= endDate;
  }
}).filter(function(item) {
        if (statusFilter === 'proses') {
          return item.status === 'proses';
        } else if (statusFilter === 'tolak') {
          return item.status === 'tolak';
        } else {
          return true;
        }
      }).filter(function(item) {
        if (typeFilter === 'withdraw') {
          return item.jenis_form === 'withdraw';
        } else if (typeFilter === 'manual_withdraw') {
          return item.jenis_form === 'manual_withdraw';
        } else {
          return true;
        }
      }).filter(function(item) {
         if (bcaChecked && briChecked && bniChecked && mandiriChecked && cimbniagaChecked && danamonChecked && permataChecked && neobankChecked && jagoChecked && sakukuChecked && bsiChecked && paninChecked && ovoChecked && danaChecked && linkajaChecked && gopayChecked && xlChecked && simpatiChecked) {
          return true;
        } else if (bcaChecked && item.bank === 'BCA') {
          return true;
        } else if (briChecked && item.bank === 'BRI') {
          return true;
        } else if (bniChecked && item.bank === 'BNI') {
         return true;
       } else if (mandiriChecked && item.bank === 'MANDIRI') {
         return true;
       } else if (cimbniagaChecked && item.bank === 'CIMBNIAGA') {
         return true;
        } else if (danamonChecked && item.bank === 'DANAMON') {
         return true;
       } else if (permataChecked && item.bank === 'PERMATA') {
         return true;
       } else if (neobankChecked && item.bank === 'NEOBANK') {
         return true;
       } else if (jagoChecked && item.bank === 'JAGO') {
         return true;
       } else if (sakukuChecked && item.bank === 'SAKUKU') {
         return true;
       } else if (bsiChecked && item.bank === 'BSI') {
          return true;
       } else if (paninChecked && item.bank === 'PANIN') {
          return true;
       } else if (ovoChecked && item.bank === 'OVO') {
         return true;
       } else if (danaChecked && item.bank === 'DANA') {
          return true;
       } else if (linkajaChecked && item.bank === 'LINKAJA') {
         return true;
       } else if (gopayChecked && item.bank === 'GOPAY') {
         return true;
       } else if (xlChecked && item.bank === 'XL') {
         return true;
       } else if (simpatiChecked && item.bank === 'SIMPATI') {
          return true;
       } else {
         return false;
       }
      }).filter(function(item) {
        // Filter berdasarkan username
        return item.username.toLowerCase().includes(usernameInput.toLowerCase());
      });

      filteredData.sort(function(a, b) {
        return new Date(b.tanggal_masuk) - new Date(a.tanggal_masuk);
      });

      var totalNominal = 0;
      var balance = 0;
      var tableBody = '';

      for (var i = currentRow; i < Math.min(currentRow + 200, filteredData.length); i++) {
        var no = i + 1;
        var norek = filteredData[i].norek;
        var nominal = formatCurrency(filteredData[i].nominal);

        var row = "<tr>";
        row += "<td>" + no + "</td>";
        row += "<td>" + filteredData[i].jenis_form + "</td>";
        row += "<td>" + filteredData[i].username + "</td>";
        row += "<td>" + filteredData[i].bank + "</td>";
        row += "<td>" + filteredData[i].nama_bank + "</td>";
        row += "<td>" + norek + "</td>";

        var statusColor = filteredData[i].status === 'tolak' ? 'red' : 'green';
        row += "<td style='color: " + statusColor + ";'>" + filteredData[i].status + "</td>";

        row += "<td style='color: blue; font-weight: bold'>" + filteredData[i].proses_oleh + "</td>";
        row += "<td style='color: green; font-weight: bold'>" + filteredData[i].dicek_oleh + "</td>";
        row += "<td>" + nominal + "</td>";

        if (filteredData[i].status === 'tolak') {
          row += "<td style='font-weight: bold;'>" + formatCurrency(balance.toFixed(2)) + "</td>";
        } else {
          totalNominal += parseFloat(filteredData[i].nominal);
          balance += parseFloat(filteredData[i].nominal);
          row += "<td style='font-weight: bold;'>" + formatCurrency(balance.toFixed(2)) + "</td>";
        }

        row += "<td>" + filteredData[i].tanggal_masuk + "</td>";
        row += "<td>" + filteredData[i].tanggal_update + "</td>";
        row += "<td>" + filteredData[i].note + "</td>";
        row += "<td>" + filteredData[i].admin_note + "</td>";
        row += "</tr>";

        tableBody += row;
      }

      $('#dpHistoryTable tbody').html(tableBody);

      var totalRow = "<tr class='table-info' style='font-size: 13px; font-weight: bold;'>";
      totalRow += "<td colspan='9'>TOTAL</td>";
      totalRow += "<td>" + formatCurrency(totalNominal.toFixed(2)) + "</td>";
      totalRow += "<td colspan='12'></td>";
      totalRow += "</tr>";

      $('#dpHistoryTable tbody').append(totalRow);

      var hasNext = filteredData.length > currentRow + 200;
      var hasPrev = currentRow > 0;

      var startRow = currentRow + 1;
      var endRow = Math.min(currentRow + 200, filteredData.length);
      var rowRange = " Data " + startRow + " Sampai " + endRow + " Dari " + filteredData.length;

      var nextLink = hasNext ? '<a href="#" onclick="showNextRows(' + (currentRow + 200) + ')">Next</a>' : '';
      var prevLink = hasPrev ? '<a href="#" onclick="showPrevRows(' + (currentRow - 200) + ')">Previous</a>' : '';

      var navigationRow = '<tr><td colspan="20" align="center">' + prevLink + ' ( ' + rowRange + ' ) ' + nextLink + '</td></tr>';

      $('#dpHistoryTable tbody').append(navigationRow);
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}

function showNextRows(nextRow) {
  currentRow = nextRow;
  search();
}

function showPrevRows(prevRow) {
  currentRow = prevRow;
  search();
}

// Panggil search() saat usernameInput mengalami perubahan
document.getElementById('usernameInput').addEventListener('input', function() {
  search();
});

$(document).ready(function() {
  // Add event listener to the "Select All" checkbox
  $('#select-all').change(function() {
    var isChecked = $(this).prop('checked');
    $('#bca, #bri, #bni, #mandiri, #cimbniaga, #danamon, #permata, #neobank, #jago, #sakuku, #bsi, #panin, #ovo, #dana, #linkaja, #gopay, #xl, #simpati').prop('checked', isChecked);
  });

  // Add event listener to individual checkboxes
  $('#bca, #bri, #bni, #mandiri, #cimbniaga, #danamon, #permata, #neobank, #jago, #sakuku, #bsi, #panin, #ovo, #dana, #linkaja, #gopay, #xl, #simpati').change(function() {
    var isAllChecked = ($('#bca:checked').length > 0 && $('#bri:checked').length > 0 && $('#bni:checked').length > 0 && $('#mandiri:checked').length > 0 && $('#cimbniaga:checked').length > 0 && $('#danamon:checked').length > 0 && $('#permata:checked').length > 0 && $('#neobank:checked').length > 0 && $('#jago:checked').length > 0 && $('#sakuku:checked').length > 0 && $('#bsi:checked').length > 0 && $('#panin:checked').length > 0 && $('#ovo:checked').length > 0 && $('#dana:checked').length > 0 && $('#linkaja:checked').length > 0 && $('#gopay:checked').length > 0 && $('#xl:checked').length > 0 && $('#simpati:checked').length > 0);
    $('#select-all').prop('checked', isAllChecked);
  });

  // Rest of your code...
});

		// Helper function to add hyphens to a string after every three characters
    function addHyphens(str) {
  if (str.length === 10) {
    str = str.substr(0, 3) + "-" + str.substr(3, 3) + "-" + str.substr(6);
  } else if (str.length === 15) {
    str = str.substr(0, 3) + "-" + str.substr(3, 4) + "-" + str.substr(7, 4) + "-" + str.substr(11);
  } else if (str.length === 13) {
    str = str.substr(0, 3) + "-" + str.substr(3, 3) + "-" + str.substr(6, 3) + "-" + str.substr(9);
  } else if (str.length === 12) {
    str = str.substr(0, 4) + "-" + str.substr(4, 4) + "-" + str.substr(8, 4);
  } else if (str.length > 15) {
    str = str.substr(0, 3) + "-" + str.substr(3, 4) + "-" + str.substr(7, 4) + "-" + str.substr(11, 4) + "-" + str.substr(15);
  } else if (str.length > 13) {
    str = str.substr(0, 3) + "-" + str.substr(3, 3) + "-" + str.substr(6, 3) + "-" + str.substr(9, 4) + "-" + str.substr(13);
  } else if (str.length > 12) {
    str = str.substr(0, 4) + "-" + str.substr(4, 4) + "-" + str.substr(8, 4) + "-" + str.substr(12);
  } else if (str.length > 10) {
    str = str.substr(0, 3) + "-" + str.substr(3, 3) + "-" + str.substr(6, 4) + "-" + str.substr(10);
  }
  return str;
}

// Helper function to format a number as currency (rupiah)
function formatCurrency(amount) {
  var formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  });
  return formatter.format(amount);
}

  // Mendapatkan tanggal saat ini
  var today = new Date();

  // Mengatur nilai default untuk startDate
  var startDateInput = document.getElementById('startDate');
  startDateInput.value = formatDate(getYesterday());

  // Mengatur nilai default untuk endDate
  var endDateInput = document.getElementById('endDate');
  endDateInput.value = formatDate(today);

  // Fungsi untuk mendapatkan tanggal kemarin
  function getYesterday() {
    var yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 0);
    return yesterday;
  }

  // Fungsi untuk memformat tanggal menjadi format 'YYYY-MM-DD'
  function formatDate(date) {
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    return year + '-' + month + '-' + day;
  }
    </script>