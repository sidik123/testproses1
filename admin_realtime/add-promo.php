<?php
session_start();
include("../fungsi/koneksi.php");

$admin_username = $_SESSION['admin_username'];

$queryWebsite = mysqli_query($koneksi, "SELECT * FROM website");
if($rowWebsite = mysqli_fetch_assoc($queryWebsite)) {
    $Marquee = $rowWebsite['Marquee'];
    $alamat_website = $rowWebsite['WebUrl'];
    $alamat_websitePanel = $rowWebsite['WebUrlPanel'];
    $alamat_websitePane2 = 'kapten777.promotionspin.my.id';
    $websiteIcon = $rowWebsite['icon'];
    $namaWebsite = $rowWebsite['namaWebsite'];
    $websiteDescription = $rowWebsite['description'];
    $websiteKeyword = $rowWebsite['Keyword'];
    $websiteTitle = $rowWebsite['Title'];
    $websiteFooter = $rowWebsite['Footer'];
    $websiteTransaksiInfoDP = $rowWebsite['transaksiInfoDP'];
    $websiteTransaksiInfoWD = $rowWebsite['transaksiInfoWD'];
    $namaWebsite = $rowWebsite['namaWebsite'];
    $posisi_banner = $rowWebsite['posisi_banner'];
}

    $users = $admin_username;
    $author = $admin_username;
    $title = str_replace(array( "’","'" ),"&apos;",$_POST['title']);
    $slugs = preg_replace("/[^a-zA-Z0-9]/", "-", $title);
    $slug = strtolower($slugs);
    $content = str_replace(array( "’","'" ),"&apos;",$_POST['content']);
    $persen = $_POST['persen'];
    $min_to = $_POST['min_to'];
    $max_bonus = $_POST['max_bonus'];
    $status = $_POST['status'];
    $status_Banner = $_POST['status_Banner'];
    $posisi_banner1 = $_POST['posisi_banner'];
    $satuan = $_POST['satuan'];
    $kategori = $_POST['kategori'];
    $postID = $_POST['postID'];
    $date = date('Y-m-d');
    $kode = date('YdmHis');
    $tipe_gambar = array('image/jpg', 'image/jpeg', 'image/bmp', 'image/x-png', 'image/png', 'image/webp');
    $gbr = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $tipe = $_FILES['image']['type'];
    $error = $_FILES['image']['error'];
    $explode = explode('.',$gbr);
    $extensi  = $explode[count($explode)-1];
    $newname = 'kapten777_promo_'.$users.'_'.$kode.'.'.$extensi;
    $upload_dir = "../../kapten777/assets/image/promosi/";
    if($postID == ''){
        if($gbr !=="" && $error == 0){
            if(in_array(strtolower($tipe), $tipe_gambar)){
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $newname);
                $query = mysqli_query($koneksi,"INSERT INTO `promodepo` (`slug`, `title`, `persen`, `min_to`, `max_bonus`, `satuan`, `image`, `content`, `author`, `kategori`, `created_date`, `last_update`, `user`, `status` , `banner_status`, `posisi_banner`) VALUES ('$slug','$title','$persen','$min_to','$max_bonus','$satuan','$newname','$content','$author','$kategori','$date','$date','$users', '$status', `$status_Banner`, `$posisi_banner1`)");
                header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&notif=1');
                exit();
            }
            else {
                header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&notif=3');
                exit();
            } 
        }
        else {
            $query = mysqli_query($koneksi,"INSERT INTO `promodepo` (`slug`, `title`, `persen`, `min_to`,  `max_bonus`, `satuan`, `image`, `content`, `author`, `kategori`, `created_date`, `last_update`, `user`, `status`, `banner_status`, `posisi_banner`) VALUES ('$slug','$title','$persen','$min_to','$max_bonus','$satuan','no-photo.jpg','$content','$author','$kategori','$date','$date','$users', '$status', `$status_Banner`, `$posisi_banner1`)");
            header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&notif=1');
                exit();
        }
    }
    else {
        if($gbr !=="" && $error == 0){
            if(in_array(strtolower($tipe), $tipe_gambar)){
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $newname);
                $query = mysqli_query($koneksi,"UPDATE `promodepo` SET `slug` = '$slug', `title` = '$title', `persen` = '$persen', `min_to` = '$min_to', `max_bonus` = '$max_bonus', `satuan` = '$satuan', `image` = '$newname', `content` = '$content', `author` = '$author', `kategori` = '$kategori', `last_update` = '$date', `user` = '$users', `status` = '$status', `banner_status` = '$status_Banner', `posisi_banner` = '$posisi_banner1' WHERE cuid = '$postID'");
                header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&postID='.$postID.'&notif=1');
                exit();
            }
            else {
                header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&postID='.$postID.'&notif=3');
                exit();
            } 
        }
        else {
            $query = mysqli_query($koneksi,"UPDATE `promodepo` SET `slug` = '$slug', `title` = '$title', `persen` = '$persen', `min_to` = '$min_to', `max_bonus` = '$max_bonus', `satuan` = '$satuan', `content` = '$content', `author` = '$author', `kategori` = '$kategori', `last_update` = '$date', `user` = '$users', `status` = '$status', `banner_status` = '$status_Banner', `posisi_banner` = '$posisi_banner1' WHERE cuid = '$postID'");
            header('location:' . $alamat_websitePanel . '/admin/Promotion?do=add&postID='.$postID.'&notif=1');
            exit();
        } 
    }
?>