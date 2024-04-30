<?php
include("../fungsi/koneksi.php");

?>
<style>
	ion-icon {
		font-size: 34px;
	}
  .modal-body{
    height: 400px;
  }

  .modal-body #tambah{
    margin-top: 3%;
  }
</style>
<?php include("header.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div class="col-sm-8" id="bankList" style="padding-top: 60px">
	<h4 class="page-title"> Bank Manage </h4>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Bank List</li>
	</ol>
</div>

<form class="dataBank">
<div class="row pt-2 pb-2">
				<div class="col-sm-6">
					<div class="table-responsive test">
						<table class="table table-bordered ">
                    <thead>
                        <tr class="table-dark" style="text-align: center;">
                            <th colspan="5">Bank List Filter</th>
                        </tr>
                    </thead>
							<tbody>
								<tr>
									<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Bank</th>
									<td colspan="2">
										<select class="form-control" id="selectBnk" name="bnk">
							           		<option selected="" value="all">All</option>
                              <?php
                                foreach ($bankOptions as $bankCode => $bankData) {
                                  $adminBank = $bankData["admin_bank"];
                                    echo '<option value="' . $adminBank . '">' . $adminBank . '</option>';
                                }
                              ?>
										</select>
									</td>
								</tr>
								<tr class="search-pl filter-order-lmt">
									<th scope="col" class="padding-10 uppercase font-bold font-size-10px form-caption">Status</th>
									<td colspan="2">
										<select id="status-filter" class="form-control">
											<option selected="" value="all">All</option>
											<option value="Aktif">Aktif</option>
											<option value="Tidak Aktif">Tidak Aktif</option>
										</select>
									</td>
								</tr>
								<tr>
									<td scope="col" class="padding-10 uppercase form-caption">
									<button type="button" class="btn btn-primary btnTambah" data-toggle="modal" data-target="#editPopup">Tambah</button>

									</td>
									<td colspan="2">
										<button type="button" id="searchButton" class="btn btn-primary waves-effect waves-light">Search</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					</div>
						<div class="col-sm-6 align-right export-to-pdf display-none">
							
						</div>
					</div>

	<div class="table-responsive">
		<table class="table table-bordered table table-hover mt-4" style="font-size: 15px; width: 100%;">
			<thead class="table-dark" style="text-align: center;">
				<tr>
					<th>No</th>
					<th>Bank</th>
					<th>No Rek</th>
					<th>Nama Bank</th>
					<th>potongan</th>
					<th>Status</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody id="dataBankList" style="text-align: center;">
				<!-- Data dari database akan dimuat di sini -->
        </tbody>
		</table>
	</div>
</form>
</section>

<!-- Popup untuk mengubah data -->
<div class="modal fade" id="editPopup" tabindex="-1" role="dialog" aria-labelledby="editPopupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPopupLabel">Edit Data Bank</h5>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <div class="form-group">
            <label for="editBank">Bank:</label>
            <select class="form-control" id="editBank" name="editBank">
            <option value="" selected disabled>-- Pilih Bank --</option>
              <?php
                foreach ($bankOptions as $bankCode => $bankData) {
                  $adminBank = $bankData["admin_bank"];
                  echo '<option value="' . $adminBank . '">' . $adminBank . '</option>';
                }
              ?>
						</select>
          </div>
          <div class="form-group">
            <label for="editNoRek">No Rek:</label>
            <input type="number" class="form-control" id="editNoRek" name="editNoRek">
          </div>
          <div class="form-group">
            <label for="editNamaBank">Nama Bank:</label>
            <input type="text" class="form-control" id="editNamaBank" name="editNamaBank">
          </div>
          <div class="form-group">
            <label for="potongan">Potongan:</label>
            <input type="number" class="form-control" id="potongan" name="potongan">
          </div>
		      <div class="form-group">
            <label for="editStatus">Status:</label>
              <select class="form-control" id="editStatus" name="editStatus">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
                <option value="delete">Delete</option>
              </select>
          </div>
          <button type="submit" id="tambah" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="../admin/assets/js/sidebar.js"></script>

<script>
  // Fungsi untuk mengambil data dari data_bank_list.php
  function fetchData() {
    $.ajax({
      url: '../admin_realtime/data_bank_list.php', // Ubah sesuai dengan URL yang benar
      method: 'GET', // Sesuaikan dengan metode yang digunakan pada data_bank_list.php
      dataType: 'json', // Sesuaikan dengan tipe data yang diterima dari data_bank_list.php
      success: function(data) {
        // Menghapus isi tbody sebelumnya (jika ada)
        $('#dataBankList').empty();

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

        // Variabel untuk menyimpan nomor urutan
        var count = 1;

        // Iterasi melalui data yang diterima
        $.each(data, function(index, item) {
			var formattedNoRek = addHyphens(item.admin_norek);

          // Membuat baris baru untuk setiap item data
          var row = '<tr data-id="' + item.id + '">' +
            '<td>' + count + '</td>' +
            '<td>' + item.admin_bank + '</td>' +
            '<td>' + formattedNoRek + '</td>' +
            '<td>' + item.admin_namabank + '</td>' +
            '<td>' + item.potongan + '%' + '</td>' +
            '<td>' + item.status + '</td>' +
            '<td>' +
            '<button type="button" style="padding: 0px;" class="btn btn-primary btnEdit btn-sm" data-toggle="modal" data-target="#editPopup" ' +
            'data-row="' + index + '">' +
            '<ion-icon name="create-outline" size="small"></ion-icon> Edit' +
            '</button>' +
            '</td>' +
            '</tr>';

          // Menambahkan baris ke dalam tbody
          $('#dataBankList').append(row);

          // Menambahkan 1 ke nomor urutan
          count++;
        });
      },
      error: function() {
        // Menangani jika terjadi kesalahan saat mengambil data
        alert('Error: Failed to fetch data from data_bank_list.php');
      }
    });
  }

  // Mengatur event click pada tombol Search
  $('#searchButton').click(function() {
    $('#status-filter').val('all'); // Set the value of the status-filter input to 'all'
    $('#selectBnk').val('all'); // Set the value of the selectBnk select element to 'all'
    fetchData();
  });

  // Menampilkan popup saat tombol "Edit" diklik
  $(document).on('click', '.btnEdit', function() {
    var rowToUpdate = $(this).data('row');
    var row = $('#dataBankList').find('tr').eq(rowToUpdate);
    var id = row.data('id');
    var bank = row.find('td:nth-child(2)').text();
    var noRek = row.find('td:nth-child(3)').text().replace(/[^a-zA-Z0-9]/g, '');
    var namaBank = row.find('td:nth-child(4)').text();
    var potongan = row.find('td:nth-child(5)').text().replace(/[^a-zA-Z0-9]/g, '');
    var status = row.find('td:nth-child(6)').text();

    $('#editBank').val(bank);
    $('#editNoRek').val(noRek);
    $('#editNamaBank').val(namaBank);
    $('#potongan').val(potongan);
    $('#editStatus').val(status);

  // Mengatur event submit form pada form edit
$('#editForm').off('submit').on('submit', function(event) {
  event.preventDefault();

  var updatedBank = $('#editBank').val();
  var updatedNoRek = $('#editNoRek').val();
  var updatedNamaBank = $('#editNamaBank').val();
  var updatePotongan = $('#potongan').val();
  var updatedStatus = $('#editStatus').val();

  // Mendapatkan ID dari data yang akan diubah
  var id = row.data('id');

  if (updatedStatus === 'delete') {
  // SweetAlert untuk konfirmasi pengguna sebelum menghapus data
  Swal.fire({
    title: 'Apakah Anda yakin ingin menghapus data ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Kirim permintaan untuk menghapus data ke server (misalnya menggunakan AJAX)
      $.ajax({
        url: '../admin_realtime/data_bank_list_delet.php',
        method: 'POST',
        data: {
          id: id
        },
        success: function(response) {
          // Handle the response from the server
          console.log(response);

          // Hide the popup after the data deletion is completed
          $('#editPopup').modal('hide');

          // Remove the deleted row from the table
          row.remove();
        },
        error: function(xhr, status, error) {
          // Handle the error when sending data to the server
          console.log(error);

          // Display an error message as needed
        }
      });
    }
  });
} else {
    // Kirim data yang diubah ke server untuk memperbarui database (misalnya menggunakan AJAX)
    $.ajax({
      url: '../admin_realtime/data_bank_list_update.php',
      method: 'POST',
      data: {
        id: id,
        bank: updatedBank,
        noRek: updatedNoRek.replace(/-/g, ''),
        namaBank: updatedNamaBank,
        potongan: updatePotongan,
        status: updatedStatus
      },
      success: function(response) {
        // Handle the response from the server
        console.log(response);

        // Hide the popup after the data update is completed
        $('#editPopup').modal('hide');

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

        // Perbarui data di tabel setelah berhasil memperbarui data di server
        row.find('td:nth-child(2)').text(updatedBank);
        row.find('td:nth-child(3)').text(addHyphens(updatedNoRek)); // Add hyphens to updatedNoRek
        row.find('td:nth-child(4)').text(updatedNamaBank);
        row.find('td:nth-child(5)').text(updatePotongan + "%");
        row.find('td:nth-child(6)').text(updatedStatus);
      },
      error: function(xhr, status, error) {
        // Handle the error when sending data to the server
        console.log(error);

        // Display an error message as needed
      }
    });
  }
});

    $('#editPopup').modal('show');
  });

// Menampilkan popup saat tombol "Tambah" diklik
$(document).on('click', '.btnTambah', function() {
  $('#editBank').val('');
  $('#editNoRek').val('');
  $('#editNamaBank').val('');
  $('#potongan').val('0');
  $('#editStatus').val('');

    // Mengatur event input pada input nomor rekening
	$('#editNoRek').off('input').on('input', function(event) {
    var input = $(this).val();
    var onlyDigits = input.replace(/\D/g, ''); // Menghapus semua karakter non-angka

    $(this).val(onlyDigits); // Mengganti isi input dengan angka saja
  });

  // Mengatur event submit form pada form tambah
  $('#editForm').off('submit').on('submit', function(event) {
    event.preventDefault();

    var newBank = $('#editBank').val();
    var newNoRek = $('#editNoRek').val();
    var newNamaBank = $('#editNamaBank').val();
    var newPotongan = $('#potongan').val();
    var newStatus = $('#editStatus').val();

    // Validasi input
    if (newBank === '' || newNoRek === '' || newStatus === '') {
      toastr.error('Harap lengkapi semua field sebelum menyimpan data.');
      return;
    }

	// Mengubah teks menjadi huruf besar
	  newBank = newBank.toUpperCase();
    newNoRek = newNoRek.toUpperCase();
    newNamaBank = newNamaBank.toUpperCase();

    // Kirim data baru ke server untuk disimpan ke database (misalnya menggunakan AJAX)
    $.ajax({
      url: '../admin_realtime/data_bank_list_insert.php',
      method: 'POST',
      data: {
        bank: newBank,
        noRek: newNoRek,
        namaBank: newNamaBank,
        potongan: newPotongan,
        status: newStatus
      },
      success: function(response) {
        // Handle the response from the server
        console.log(response);

        // Hide the popup after the data insertion is completed
        $('#editPopup').modal('hide');

        // Clear the input fields after successful submission
        $('#editBank').val('');
        $('#editNoRek').val('');
        $('#editNamaBank').val('');
        $('#potongan').val('');
        $('#editStatus').val('');

        // Clear the table data before fetching and appending the updated data
        $('#dataBankList').empty();

        // Fetch and display the updated data
        fetchData();
      },
      error: function(xhr, status, error) {
        // Handle the error when sending data to the server
        console.log(error);

        // Display an error message as needed
      }
    });
  });

  $('#editPopup').modal('show');
});

$('#status-filter, #selectBnk').change(function() {
  var selectedStatus = $('#status-filter').val();
  var selectedBank = $('#selectBnk').val();
  filterData(selectedStatus, selectedBank);
});

function filterData(status, bank) {
  var rows = $('#dataBankList tr');

  rows.hide().filter(function() {
    var rowStatus = $(this).find('td:nth-child(6)').text().trim();
    var rowBank = $(this).find('td:nth-child(2)').text().trim();

    var statusMatch = (status === 'all' || rowStatus === status);
    var bankMatch = (bank === 'all' || rowBank === bank);

    return statusMatch && bankMatch;
  }).each(function(index) {
    $(this).find('td:first-child').text(index + 1);
    $(this).show();
  });
}
</script>
