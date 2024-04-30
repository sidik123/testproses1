<?php
include("../fungsi/koneksi.php");

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
        $pesan = 'Contactus Berhasil Di Perbaharui.';
    } else {
        // Gagal memperbarui data di database
        $pesan = 'Gagal memperbarui data di database: ' . $koneksi->error;
    }

    // Tutup statement
    $stmt->close();

    // Tutup koneksi
    $koneksi->close();
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

    <!-- Tampilkan notifikasi Toastr jika ada -->
    <?php if (!empty($pesan)) : ?>
        <script>
            // Tampilkan pesan notifikasi Toastr
            toastr.success('<?php echo $pesan; ?>');
        </script>
    <?php endif; ?>

<div class="container-fluid">
						
<!--Start Content-->
								
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
	<div class="col-sm-9 mt-5">
		<h4 class="page-title">Kontak Management System</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">Contact Us</li>
		</ol>
	</div>
	<div class="col-sm-3">
		<div class="btn-group float-sm-right">
		
		</div>
	</div>
</div>
<!-- End Breadcrumb-->
<!-- start of the row -->
<div class="row">
	<div class="col-lg-6 col-md-12">
		<div class="card">
			<div class="card-body">
				<form id="contact_us" action="contactus" method="post">
                    <table class="table-bordered table border-top">
						<thead>
							<tr>
								<td colspan="3" class="card-header padding-5 uppercase text-center" style="background-color: black; color: white;">Contact Us</td>
							</tr>
						</thead>
						<tbody>
<?php foreach ($rowWebsiteKontakKami as $key => $value): ?>
    <tr>
        <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption"><?php echo strtoupper($key); ?></td>
        <td>
            <input type="text" class="form-control" id="<?php echo strtolower($key); ?>" name="<?php echo strtolower($key); ?>" placeholder="<?php echo strtoupper($key); ?>" value="<?php echo $value; ?>" disabled="disabled">
        </td>
    </tr>
<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td scope="col" class="uppercase font-bold max-width-170px font-size-10px border-none"></td>
								<td class="border-none">
									<button type="button" id="contactusedit" class="btn btn-primary waves-effect waves-light float-right">
                                        <i class="fas fa-edit"></i> Edit
									</button>
									<button type="submit" id="contactussave" class="btn btn-primary waves-effect waves-light float-right" hidden="">
                                        <i class="fas fa-save"></i> Save
									</button>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end of the row -->

<script type="text/javascript">
$( document ).ready(function() {

});
$( "#contactusedit" ).click(function() {
	document.getElementById('contactusedit').setAttribute("hidden", true) ;
	document.getElementById('contactussave').removeAttribute("hidden") ;
	$('#whatsapp').prop('disabled', false);
	$('#sms').prop('disabled', false);
	$('#bb').prop('disabled', false);
	$('#youtube').prop('disabled', false);
	$('#twitter').prop('disabled', false);
	$('#telegram').prop('disabled', false);
	$('#facebook').prop('disabled', false);
});
</script>

</div>

<?php include("footer.php"); ?>