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
<form class="formtable" style="padding-top: 60px;">
    <div class="col-sm-8">
            <h4 class="page-title"> Deposit Monitor </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Deposit</li>
            </ol>
        </div>

        <div class="table-responsive test">
            <table id="dataSortList" class="table table-bordered ">
                <thead>
                    <tr>
                        <td class="table-dark" id="info" colspan="99">
						FILTER BANK
					</td>
                </tr>
            </thead> 
            <tbody class="preset-pt-header">
                <tr class="filter-container">
                    <td colspan="1" class="label-button cursor-pointer uppercase align-center ">
                    <div class="checkbox-container">
                          <input type="checkbox" id="select-all" onchange="toggleCheckboxes()" checked>
                           <label class="select-all" id="select-all" for="select-all">Select All</label>
                    </div>
                    </td> 
                    <td>
                         <div class="checkbox-container">
                            <input type="checkbox" id="bca" checked>
                            <label for="bca">BCA</label>
                        </div>
                    </td> 
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="bri" checked>
                            <label for="bri">BRI</label>
                        </div>
                    </td> 
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="bni" checked>
                            <label for="bni">BNI</label>
                        </div>
                    </td> 
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="mandiri" checked>
                            <label for="mandiri">Mandiri</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="cimbniaga" checked>
                            <label for="cimbniaga">Cimb Niaga</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="danamon" checked>
                            <label for="danamon">Danamon</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="permata" checked>
                            <label for="permata">Permata</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="neobank" checked>
                            <label for="neobank">Neo Bank</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="jago" checked>
                            <label for="jago">Jago</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="sakuku" checked>
                            <label for="sakuku">Sakuku</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="bsi" checked>
                            <label for="bsi">BSI</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="panin" checked>
                            <label for="panin">Panin</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="jenius" checked>
                            <label for="jenius">Jenius</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="ovo" checked>
                            <label for="ovo">Ovo</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="dana" checked>
                            <label for="dana">Dana</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="linkaja" checked>
                            <label for="linkaja">Link Aja</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="gopay" checked>
                            <label for="gopay">Gopay</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="xl" checked>
                            <label for="xl">XL</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="simpati" checked>
                            <label for="simpati">Simpati</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="banklain" checked>
                            <label for="banklain">Bank Lain</label>
                        </div>
                    </td>
                    <tr>
                        <td colspan="50">
                            <div class="search">
                            <button type="button" class="btn btn-primary" onclick="search()">Search</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

<div class="monitor">
<div class="tableproses" id=tableproses>
<div id="info" class="table-responsive" style="min-height: 300px;">
<table id="dataList" class="monitor table table-hover table-list">
    <thead>
    <tr class="table-dark" id="infoTable">
        <th>No</th>
        <th>COPY</th>
        <th>WAKTU MASUK</th>
        <th>USERNAME</th>
        <th>BANK</th>
        <th>TUJUAN</th>
        <th>POTONGAN</th>
        <th>NOMINAL</th>
        <th>CATATAN</th>
        <th>PROMOTION</th>
        <th>TOTAL PROMO</th>
        <th>AKSI</th>
        <th><button type="button" class="btn btn-success"style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"onclick="processAll()">PROSESALL</button></th>
    </tr>
    </thead> 
    <div class="bodyTable">
        <tbody id="dataContainer">
         <!-- FORM MUNCUL DI SINI -->
    </tbody> 
    </div>
    </div>
    </div>
</table>
</div>
</section>
</form>

<?php include("footer.php"); ?>

<script>
  $(document).ready(function() {
      // Buat koneksi WebSocket ke server
      const socket = new WebSocket('ws://localhost:8080/');

      // Fungsi untuk mengubah format tanggal
function formatDate(dateString) {
  var date = new Date(dateString);
  var year = date.getFullYear();
  var month = ("0" + (date.getMonth() + 1)).slice(-2);
  var day = ("0" + date.getDate()).slice(-2);
  var hours = ("0" + date.getHours()).slice(-2);
  var minutes = ("0" + date.getMinutes()).slice(-2);
  var seconds = ("0" + date.getSeconds()).slice(-2);
  return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
}

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

      // Event handler saat koneksi terbuka
      socket.onopen = () => {
        console.log('Connected to WebSocket server');
      };

      // Event handler saat menerima pesan dari server
      socket.onmessage = event => {
        const response = JSON.parse(event.data);
        console.log('Received data:', response);

        // Tampilkan data dalam tabel
        if (response.length > 0) {
          var html = '';
          var no = 1;
          $.each(response, function(index, row) {
            if (row.status !== 'Tahan') {
                            html += '<tr id="formDp_' + row.id + '" name="formDp">';
                            html += '<td style="padding: 0px; padding-top: 20px; font-size: 15px;">' + no + '</td>';
                            html += '<td style="padding: 0px; padding-top: 12px;"><button type="button" class="btn btn-light" onclick="copyRowData(' + row.id + ')""><i class="fas fa-copy" style="font-size: 25px;"></i></button></td>';
                            html += '<td style="padding: 0px; padding-top: 20px; cursor: pointer;" onclick="copyText(this, \'tanggal_masuk\')">' + formatDate(row.tanggal_masuk) + '</td>';
                            html += '<td style="padding: 0px; padding-top: 20px; cursor: pointer;" onclick="copyText(this, \'username\')">' + row.username + '</td>';
                            html += '<td style="padding: 0px; padding-top: 5px; cursor: pointer;" onclick="copyText(this, \'bank\')">';
                            if (row.bank.includes('BCA')) {
                                html += '<img src="../assets/img/bank/bca.png" alt="BCA">';
                            } else if (row.bank.includes('BRI')) {
                                html += '<img src="../assets/img/bank/bri.png" alt="BRI">';
                            } else if (row.bank.includes('BNI')) {
                                html += '<img src="../assets/img/bank/bni.png" alt="BNI">';
                            } else if (row.bank.includes('MANDIRI')) {
                                html += '<img src="../assets/img/bank/mandiri.png" alt="Mandiri">';
                            } else if (row.bank.includes('BSI')) {
                                html += '<img src="../assets/img/bank/bsi.png" alt="BSI">';
                            } else if (row.bank.includes('JENIUS')) {
                                html += '<img src="../assets/img/bank/jenius.png" alt="JENIUS">';
                            } else if (row.bank.includes('PANIN')) {
                                html += '<img src="../assets/img/bank/panin.png" alt="PANIN">';
                            } else if (row.bank.includes('PERMATA')) {
                                html += '<img src="../assets/img/bank/permata.png" alt="PERMATA">';
                            } else if (row.bank.includes('DANA')) {
                                html += '<img src="../assets/img/bank/dana.png" alt="DANA">';
                            } else if (row.bank.includes('OVO')) {
                                html += '<img src="../assets/img/bank/ovo.png" alt="OVO">';
                            } else if (row.bank.includes('GOPAY')) {
                                html += '<img src="../assets/img/bank/gopay.png" alt="GOPAY">';
                            } else if (row.bank.includes('BNC')) {
                                html += '<img src="../assets/img/bank/bnc.png" alt="BNC">';
                            } else if (row.bank.includes('LINKAJA')) {
                                html += '<img src="../assets/img/bank/linkaja.png" alt="LINKAJA">';
                            } else if (row.bank.includes('JAGO')) {
                                html += '<img src="../assets/img/bank/jago.png" alt="JAGO">';
                            } else if (row.bank.includes('SEABANK')) {
                                html += '<img src="../assets/img/bank/seabank.png" alt="SEABANK">';
                            } else if (row.bank.includes('CMB')) {
                                html += '<img src="../assets/img/bank/cmb.png" alt="CMB">';
                            } else if (row.bank.includes('OTHERBANK')) {
                                html += '<img src="../assets/img/bank/otherbank.png" alt="OTHERBANK">';
                            }
                            html += "<br>" + row.nama_bank + " " + "[" + addHyphens(row.norek) + "]" + '</td>';

                            html += '<td style="padding: 0px; padding-top: 5px;" id="tujuanadmin" name="tujuanadmin">';
                            if (row.tujuan_admin_bank.includes('BCA')) {
                                html += '<img src="../assets/img/bank/bca.png" id="tujuanbca" alt="BCA">';
                            } else if (row.tujuan_admin_bank.includes('BRI')) {
                                html += '<img src="../assets/img/bank/bri.png" id="tujuanbri" alt="BRI">';
                            } else if (row.tujuan_admin_bank.includes('BNI')) {
                                html += '<img src="../assets/img/bank/bni.png" id="tujuanbni" alt="BNI">';
                            } else if (row.tujuan_admin_bank.includes('MANDIRI')) {
                                html += '<img src="../assets/img/bank/mandiri.png" id="tujuanmandiri" alt="Mandiri">';
                            } else if (row.tujuan_admin_bank.includes('BSI')) {
                                html += '<img src="../assets/img/bank/bsi.png" id="tujuannsi" alt="BSI">';
                            } else if (row.tujuan_admin_bank.includes('JENIUS')) {
                                html += '<img src="../assets/img/bank/jenius.png" id="tujuanjenius" alt="JENIUS">';
                            } else if (row.tujuan_admin_bank.includes('PANIN')) {
                                html += '<img src="../assets/img/bank/panin.png" id="tujuanpanin" alt="PANIN">';
                            } else if (row.tujuan_admin_bank.includes('PERMATA')) {
                                html += '<img src="../assets/img/bank/permata.png" id="tujuanpermata" alt="PERMATA">';
                            } else if (row.tujuan_admin_bank.includes('SIMPATI')) {
                                html += '<img src="../assets/img/bank/simpati.png" id="tujuansimpati" alt="SIMPATI">';
                            } else if (row.tujuan_admin_bank.includes('DANA')) {
                                html += '<img src="../assets/img/bank/dana.png" id="tujuandana" alt="DANA">';
                            } else if (row.tujuan_admin_bank.includes('BNC')) {
                                html += '<img src="../assets/img/bank/bnc.png" id="tujuanbnc" alt="BNC">';
                            } else if (row.tujuan_admin_bank.includes('LINKAJA')) {
                                html += '<img src="../assets/img/bank/linkaja.png" id="tujuanlinkaja" alt="LINKAJA">';
                            } else if (row.tujuan_admin_bank.includes('JAGO')) {
                                html += '<img src="../assets/img/bank/jago.png" id="tujuanjago" alt="JAGO">';
                            } else if (row.tujuan_admin_bank.includes('SEABANK')) {
                                html += '<img src="../assets/img/bank/seabank.png" id="tujuanseabank" alt="SEABANK">';
                            } else if (row.tujuan_admin_bank.includes('CMB')) {
                                html += '<img src="../assets/img/bank/cmb.png" id="tujuancmb" alt="CMB">';
                            } else if (row.tujuan_admin_bank.includes('OTHERBANK')) {
                                html += '<img src="../assets/img/bank/otherbank.png" id="tujuanotherbank" alt="OTHERBANK">';
                            } else if (row.tujuan_admin_bank.includes('GOPAY')) {
                                html += '<img src="../assets/img/bank/gopay.png" id="tujuangopay" alt="GOPAY">';
                            } else if (row.tujuan_admin_bank.includes('OVO')) {
                                html += '<img src="../assets/img/bank/ovo.png" id="tujuanovo" alt="OVO">';
                            }
                            html += "<br>" + row.tujuan_admin_namabank + " " + "[" + (addHyphens(row.tujuan_admin_norek)) + "]" +'</td>';

                            html += '<td style="padding: 0px; padding-top: 20px;">' + row.potongan +'%</td>';
                            html += '<td style="padding: 0px; padding-top: 20px;">';

                            if (row.potongan > 1 && row.promotiontitle !== "DEPOSIT PULSA TANPA POTONGAN") {
                              var potongan = row.potongan; // Ambil nilai potongan dari data
                              var nominalDipotong = row.nominal - (row.nominal * potongan / 100);
                              html += '<span class="nominal-asli" style="color: blue;">' + "Real:" + " " +formatRupiah(row.nominal) + '</span><br>';
                              html += '<span class="nominal-potong" style="color: red;">' + formatRupiah(nominalDipotong) + '</span>';
                            } else {
                              html += '<span class="nominal-asli" style="padding: 0px; padding-top: 20px;">' + formatRupiah(row.nominal) + '</span>';
                            }

                            html += '</td>';
                            html += '<td style="padding: 0px; padding-top: 20px;">' + row.note + '</td>';
                            html += '<td style="padding: 0px; padding-top: 20px;">' + row.promotiontitle + '</td>';
                            html += '<td style="padding: 0px; padding-top: 20px;">' + row.promotiondp + '%</td>';
                            html += '<td style="style="margin-top: 8px;";" class="align-left">';
                            html += '<button type="button" class="btn btn-success" onclick="updateStatus(\'proses\', ' + row.id + ', \'' + row.username + '\', \'' + row.nama_bank + '\', \'' + row.bank + '\', \'' + row.norek + '\', ' + row.nominal +')">PROSES</button>';
                            html += '<button type="button" class="btn btn-danger" onclick="rejectRequest(' + row.id +')">TOLAK</button>';
                            html += '</td>';
                            if (!isButtonHidden(row.id)) {
                                html += '<td>';
                                html += '<button id="holdButton_' + row.id +'" type="button" class="btn btn-secondary" onclick="holdRequest(' + row.id +')">TAHAN</button>';
                                html += '</td>';
                            }
              html += '</tr>';
              no++;
            }
          });
          $('#dataContainer').html(html);
        } else {
          $('#dataContainer').html('<tr><td colspan="15">Tidak ada data yang tersedia</td></tr>');
        }
      };

      // Event handler saat koneksi ditutup
      socket.onclose = () => {
        console.log('Disconnected from WebSocket server');
      };
    });
    
    function copyRowData(rowId) {
    var row = $('#formDp_' + rowId);
    var rowData = '';

    row.find('td').each(function() {
        rowData += $(this).text() + '\t'; // Using tab as a separator between values
    });

    // Copy data to clipboard
    var tempTextarea = document.createElement('textarea');
    tempTextarea.value = rowData.trim();
    document.body.appendChild(tempTextarea);
    tempTextarea.select();
    document.execCommand('copy');
    document.body.removeChild(tempTextarea);

    // Show notification or perform other actions
    toastr.success('Data from selected row has been copied.');
}

                                // Fungsi Filter Bank
                                function toggleCheckboxes() {
                                    var checkboxes = document.querySelectorAll(".filter-container input[type='checkbox']");
                                    var selectAllCheckbox = document.getElementById("select-all");
                                    checkboxes.forEach(function (checkbox) {
                                        checkbox.checked = selectAllCheckbox.checked;
                                    });
                                }
                                function search() {
                                    var checkedCheckboxes = document.querySelectorAll(".filter-container input[type='checkbox']:checked");
                                    var selectedBanks = [];
                                    checkedCheckboxes.forEach(function (checkbox) {
                                        if (checkbox.id !== "select-all") {
                                            selectedBanks.push(checkbox.id.toUpperCase());
                                        }
                                    });
                                    filterData(selectedBanks);
                                }
                                function filterData(selectedBanks) {
                                    var tableRows = document.querySelectorAll("#dataContainer tr");
                                    tableRows.forEach(function (row) {
                                        var bankColumn = row.querySelector("td[name='tujuanadmin']");
                                        var bankImage = bankColumn.querySelector("img");
                                        var bank = bankImage ? bankImage.alt.toUpperCase() : "";

                                        if (selectedBanks.includes(bank) || selectedBanks.length === 0) {
                                            row.style.display = "table-row";
                                        } else {
                                            row.style.display = "none";
                                        }
                                    });
                                }

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

                                // Function to format copy all
                                function copyText(element, type, bankName = '', bankAccount = '') {
                                    var text = $(element).text().trim();
                                    var tempInput = $('<input>').val(text).appendTo('body').select();
                                    document.execCommand('copy');
                                    tempInput.remove();
                                    // Menentukan pesan notifikasi berdasarkan jenis data yang diklik
                                    var message = '';
                                    switch (type) {
                                        case 'no':
                                        message = 'Nomor berhasil disalin';
                                            break;
                                        case 'tanggal_masuk':
                                        message = 'Tanggal masuk ' + text + ' berhasil disalin';
                                            break;
                                        case 'username':
                                        message = 'Username ' + text + ' berhasil disalin';
                                            break;
                                        case 'bank':
                                        message = 'Bank ' + text + ' berhasil disalin';
                                            break;
                                        case 'tujuan_admin_bank':
                                        message = 'Tujuan Admin Bank berhasil disalin';
                                            break;
                                        case 'tujuan_admin_norek':
                                        message = 'Nomor Rekening Tujuan Admin berhasil disalin';
                                            break;
                                        case 'nominal':
                                        message = 'Nominal berhasil disalin';
                                            break;
                                        case 'note':
                                        message = 'Catatan berhasil disalin';
                                             break;
                                        default:
                                        message = 'Teks berhasil disalin ke clipboard';
                                        }
                                    // Menampilkan notifikasi
                                    toastr.success(message);
                                }

  // Function to update status via AJAX
  function updateStatus(status, id, username, namaBank, bank, norek, nominal) {
    // Display confirmation dialog
    Swal.fire({
      title: "Apakah Anda ingin memproses form berikut?",
      html:
        "Username: " + username +
        "<br>Nama Bank: " + namaBank +
        "<br>Nominal: " + formatRupiah(nominal),
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Proses",
      cancelButtonText: "Batal",
      customClass: { 
        container: 'swal-responsive',
        popup: 'swal-popup',
        content: 'swal-content'
      },
      width: '400px',
    }).then((result) => {
      if (result.isConfirmed) {
        // Perform AJAX request to update status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin_realtime/proses_form.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Show success notification using Toastr
            toastr.success("Status berhasil diperbarui.", "Sukses", {
              closeButton: true,
              timeOut: 3000,
              positionClass: "toast-top-right",
            });
            // Handle response
            console.log(xhr.responseText);
            // You can perform additional actions here if needed
            hideHoldButton(id); // Hide the "Tahan" button

          }
        };
        xhr.send("status=" + status + "&id=" + id);
        // Remove data from local storage for holdButton
        localStorage.removeItem("holdButton_" + id);
      }
    });
  }

  // Function to update all statuses to "all proses"
  function processAll() {
    // Show confirmation notification
    Swal.fire({
      title: "Apakah Anda ingin memproseskan semua yang sudah ditahan?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Proses",
      cancelButtonText: "Batal",
      customClass: { 
        container: 'swal-responsive',
        popup: 'swal-popup',
        content: 'swal-content'
      },
      width: '400px',
    }).then((result) => {
      if (result.isConfirmed) {
        // Perform AJAX request to update all statuses
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin_realtime/proses_all_form.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle response
            console.log(xhr.responseText);
            // Reload the page to reflect the updated statuses
          }
        };
        xhr.send("status=proses");
                // Remove data from local storage for holdButton
                localStorage.removeItem("holdButton_" + id);
      }
    });
  }

  // Function to update all statuses to "tolak"
  function rejectRequest(id) {
    // Display prompt dialog for admin note
    Swal.fire({
      title: "Masukkan catatan admin untuk penolakan:",
      icon: "warning",
      input: "text",
      showCancelButton: true,
      confirmButtonText: "Kirim",
      cancelButtonText: "Batal",
      customClass: { 
        container: 'swal-responsive',
        popup: 'swal-popup',
        content: 'swal-content'
      },
      width: '400px',
      inputValidator: (value) => {
      },
    }).then((result) => {
      if (result.isConfirmed) {
        var adminNote = result.value;
        // Perform AJAX request to update status and admin note
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin_realtime/proses_form.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Show success notification using Toastr
            toastr.error("Permintaan berhasil ditolak.", "Informasi", {
              closeButton: true,
              timeOut: 3000,
              positionClass: "toast-top-right",
            });
            // Handle response
            console.log(xhr.responseText);
            // You can perform additional actions here if needed
            hideHoldButton(id); // Hide the "Tahan" button

          }
        };
        xhr.send("status=tolak&id=" + id + "&admin_note=" + encodeURIComponent(adminNote));
        // Remove data from local storage for holdButton
        localStorage.removeItem("holdButton_" + id);
      }
    });
  }

  // Function to update status to "Tahan"
  function holdRequest(id) {
    // Perform AJAX request to update status to "Tahan"
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin_realtime/tahan_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        toastr.info("Permintaan berhasil ditahan.", "Informasi", {
        });
        // Handle response
        console.log(xhr.responseText);
        // Hide the "Tahan" button
        hideHoldButton(id);
        // Show success notification using Toastr
      }
    };
    xhr.send("status=tahan&id=" + id);
    // Store data in local storage for holdButton
    localStorage.setItem("holdButton_" + id, "hidden");
  }
  // Function to check if the "Tahan" button should be hidden
  function isButtonHidden(id) {
    var isHidden = localStorage.getItem("holdButton_" + id);
    return isHidden === "hidden";
  }
  // Function to remove data from local storage for holdButton when the request is processed
  function removeHoldButtonData(id) {
    localStorage.removeItem("holdButton_" + id);
  }
  // Event listener for processing request
  $(document).on("click", ".btn-success", function() {
    var id = $(this).data("id");
    removeHoldButtonData(id);
  });
  // Event listener for rejecting request
  $(document).on("click", ".btn-danger", function() {
    var id = $(this).data("id");
    removeHoldButtonData(id);
  });

  // FUNGSI UNTUK LOGOUT OTOMATIS SAAT TIDAK ADA AKTIFITAS DI PANEL DEPOSIT
var idleTimeout = 600000; // 1 menit dalam milidetik
var logoutTimer;
function resetTimer() {
  clearTimeout(logoutTimer);
  logoutTimer = setTimeout(logout, idleTimeout);
}
function logout() {
  // Lakukan tindakan logout di sini
  window.location.href = "../admin/logout.php"; // Ganti dengan URL logout sesuai kebutuhan
}
// Panggil fungsi resetTimer() saat tidak terjadi aktivitas pengguna
document.addEventListener("mousemove", resetTimer);
document.addEventListener("keydown", resetTimer);
document.addEventListener("click", resetTimer);
// Tambahkan jenis aktivitas lainnya yang ingin Anda pantau
</script>

