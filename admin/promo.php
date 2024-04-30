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

    <div class="" style="padding-top: 60px; padding-bottom: 50px;">
              <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Information /</span> Promotion
              </h4>
              <div class="row">
                <div class="col-sm-5">
                  <div class="card">
                    <div class="card-body">
                      <?php
                              include("../fungsi/koneksi.php");
                        error_reporting(0);
                        if (!empty($_GET['notif'])) {
                          if ($_GET['notif'] == 1) {
                            echo '
                              <div class="alert alert-success d-flex align-items-center" role="alert">
                                <span class="alert-icon text-success me-2">
                                  <i class="ti ti-check ti-xs"></i>
                                </span>
                                <span><strong>Well Done!</strong> Promotion Saved!</span>
                              </div>
                            ';
                          }
                          if ($_GET['notif'] == 2) {
                            echo '
                              <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <span class="alert-icon text-warning me-2">
                                  <i class="ti ti-bell ti-xs"></i>
                                </span>
                                <span><strong>Warning!</strong> Max Image Size 2MB!</span>
                              </div>
                            ';
                          }
                          if ($_GET['notif'] == 3) {
                            echo '
                              <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <span class="alert-icon text-warning me-2">
                                  <i class="ti ti-bell ti-xs"></i>
                                </span>
                                <span><strong>Warning!</strong> Only JPG atau PNG!</span>
                              </div>
                            ';
                          }
                        }
                        if(isset($_GET['postID'])){
                          $catID = $_GET['postID'];
                          $sql_2 = mysqli_query($koneksi,"SELECT * FROM `promodepo` WHERE cuid = '$catID'");
                          $s2 = mysqli_fetch_array($sql_2);
                        }
                      ?>
                      <form role="form" action="<?php echo $alamat_websitePanel; ?>/admin_realtime/add-promo.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                          <label class="form-label">Upload Image ( 900 X 180 ):</label>
                          <input class="form-control" type="file" name="image">
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Promotion Title :</label>
                          <input class="form-control" type="text" name="title" value="<?php if(isset($_GET['postID'])) { echo $s2['title']; } ?>" required>
                          <input class="form-control" type="hidden" name="postID" value="<?php if(isset($_GET['postID'])) { echo $s2['cuid']; } ?>" required>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Description :</label>
                          <textarea class="form-control summernote" id="summernote" type="text" name="content"><?php if(isset($_GET['postID'])) { echo $s2['content']; } ?></textarea>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Jenis Promo :</label>
                          <select name="kategori" class="form-control" required>
                            <option> Pilih </option>
                            <option value="0"<?php if(isset($_GET['postID'])) { if($s2['kategori'] == 0){ echo ' selected=selected'; } } ?>> Deposit </option>
                            <option value="2"<?php if(isset($_GET['postID'])) { if($s2['kategori'] == 2){ echo ' selected=selected'; } } ?>> Next Deposit </option>
                            <option value="1"<?php if(isset($_GET['postID'])) { if($s2['kategori'] == 1){ echo ' selected=selected'; } } ?>> Lainnya </option>
                          </select>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Percentage (%) :</label>
                          <input class="form-control" type="number" name="persen" value="<?php if(isset($_GET['postID'])) { echo $s2['persen']; } ?>">
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Satuan Turn Over :</label>
                          <select name="satuan" class="form-control" required>
                            <option> Pilih </option>
                            <option value="0"<?php if(isset($_GET['postID'])) { if($s2['satuan'] == 0){ echo ' selected=selected'; } } ?>> kali </option>
                            <option value="1"<?php if(isset($_GET['postID'])) { if($s2['satuan'] == 1){ echo ' selected=selected'; } } ?>> Rupiah </option>
                          </select>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Minimal Turn Over :</label>
                          <input class="form-control" type="number" name="min_to" value="<?php if(isset($_GET['postID'])) { echo $s2['min_to']; } ?>" required>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Max Bonus :</label>
                          <input class="form-control" type="number" name="max_bonus" value="<?php if(isset($_GET['postID'])) { echo $s2['max_bonus']; } ?>">
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Posisi Banner</label>
                          <input class="form-control" type="number" name="posisi_banner" value="<?php if(isset($_GET['postID'])) { echo $s2['posisi_banner']; } ?>" required>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Status Promo :</label>
                          <select name="status" class="form-control" required>
                            <option> Pilih </option>
                            <option value="1"<?php if(isset($_GET['postID'])) { if($s2['status'] == 1){ echo ' selected=selected'; } } ?>> Aktif </option>
                            <option value="0"<?php if(isset($_GET['postID'])) { if($s2['status'] == 0){ echo ' selected=selected'; } } ?>> Tidak Aktif </option>
                          </select>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-label">Status Banner :</label>
                          <select name="status_Banner" class="form-control" required>
                            <option> Pilih </option>
                            <option value="1"<?php if(isset($_GET['postID'])) { if($s2['banner_status'] == 1){ echo ' selected=selected'; } } ?>> Aktif </option>
                            <option value="0"<?php if(isset($_GET['postID'])) { if($s2['banner_status'] == 0){ echo ' selected=selected'; } } ?>> Tidak Aktif </option>
                          </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 30px;">Publish</button>
                        <a href="<?php echo $alamat_websitePanel; ?>/admin/Promotion" class="btn btn-light" style="margin-top: 30px;">Cancel</a>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-sm-7">
                  <!-- Invoice List Table -->
                  <div class="card">
                    <div class="card-datatable table-responsive">
                      <table id="default-datatable" class="invoice-list-table table border-top">
                        <thead>
                          <tr class="bg-info">
                            <th class="text-center">#</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Promotion Title</th>
                            <th class="text-center">Promotion Jenis</th>
                            <th class="text-center">Min Turn Over</th>
                            <th class="text-center">Max Bonus</th>
                            <th class="text-center">Status Promo</th>
                            <th class="text-center">Status Banner</th>
                            <th class="text-center">Posisi Banner</th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
          // Lakukan koneksi ke database
          $sql_1 = mysqli_query($koneksi,"SELECT * FROM `promodepo` WHERE kategori != 5 ORDER BY cuid ASC");
          $no = 0;
          while($s1 = mysqli_fetch_array($sql_1)){
            $no++;
            $idkategori = $s1['cuid'];
            ?>
              <tr>
                <td class="text-center"><?php echo $no; ?></td>
            <td class="text-center">
<?php
// Periksa apakah ada nama file gambar dan bukan 'no-photo.jpg'
if (!empty($s1['image']) && $s1['image'] !== 'no-photo.jpg') {
?>
    <img src="<?php echo $alamat_website; ?>/assets/image/promosi/<?php echo $s1['image']; ?>" style="display: block; margin: 0 auto; width: 250px; height: auto;">
<?php 
} 
?>
                </td>
            <td class="text-left"><?php echo $s1['title']; ?></td>
            <td class="text-center">
    <?php
    if ($s1['kategori'] == 1) {
        echo "Banner Website";
    } elseif ($s1['kategori'] == 2) {
        echo "Next Deposit";
    } elseif ($s1['kategori'] == 0) {
        echo "Deposit";
    } else {
        // Jika nilai kategori tidak sesuai dengan kriteria di atas
        echo "kategori tidak valid";
    }
    ?>
</td>

            <td class="text-center">
            <?php
if ($s1['satuan'] == 0) {
    echo $s1['min_to'].' Kali';
} elseif ($s1['satuan'] == 1) {
    echo $s1['min_to'].' Rupiah';
} else {
    // Jika nilai satuan tidak sesuai dengan kriteria di atas
    echo "Satuan tidak valid";
}
?>

                </td>
            <td class="text-center"><?php echo ($s1['max_bonus']); ?></td>
            <td class="text-center"><?php echo ($s1['status'] == 0) ? 'Tidak Aktif' : 'Aktif'; ?></td>
            <td class="text-center"><?php echo ($s1['banner_status'] == 0) ? 'Unpublished' : 'Published'; ?></td>
            <td class="text-center"><?php echo ($s1['posisi_banner']) ?></td>
            <td class="text-center">
    <div class="d-flex justify-content-end">
        <a href="<?php echo $alamat_websitePanel; ?>/admin/Promotion?postID=<?php echo $s1['cuid']; ?>" class="btn btn-primary btn-sm mr-2">
            <i class="fa fa-edit"></i>
        </a>
        <a href="<?php echo $alamat_websitePanel; ?>/admin_realtime/del-post.php?cuid=<?php echo $s1['cuid']; ?>&jenis=1" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</td>

        </tr>
        <?php } ?>
        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

<?php include("footer.php"); ?>