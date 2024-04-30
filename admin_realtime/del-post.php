<?php
include("../fungsi/koneksi.php");
$queryWebsite = mysqli_query($koneksi, "SELECT * FROM website");
if($rowWebsite = mysqli_fetch_assoc($queryWebsite)) {
    $Marquee = $rowWebsite['Marquee'];
    $alamat_website = $rowWebsite['WebUrl'];
    $alamat_websitePanel = $rowWebsite['WebUrlPanel'];
    $websiteIcon = $rowWebsite['icon'];
    $namaWebsite = $rowWebsite['namaWebsite'];
    $websiteDescription = $rowWebsite['description'];
    $websiteKeyword = $rowWebsite['Keyword'];
    $websiteTitle = $rowWebsite['Title'];
    $websiteFooter = $rowWebsite['Footer'];
    $websiteTransaksiInfoDP = $rowWebsite['transaksiInfoDP'];
    $websiteTransaksiInfoWD = $rowWebsite['transaksiInfoWD'];
}

	$id = $_GET['cuid'];
	$jenis = $_GET['jenis'];
    $query = mysqli_query($koneksi,"DELETE FROM `promodepo` WHERE cuid = '$id'");
    if($jenis == 0){
    	header('location:' . $alamat_websitePanel . '/admin/Promotion');
    }
    else {
    	header('location:' . $alamat_websitePanel . '/admin/Promotion');
    }
    
?>