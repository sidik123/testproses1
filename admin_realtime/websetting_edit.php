<?php
include("../fungsi/koneksi.php");

// Pastikan bahwa request datang dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah data yang diterima sesuai dengan yang diharapkan
    if (isset($_POST['websiteTitle']) && isset($_POST['metaDescription']) && isset($_POST['metaKeyword']) && isset($_POST['MetaHeaderWeb']) && isset($_POST['googleAnalytic']) && isset($_POST['runningText']) && isset($_POST['footer']) && isset($_POST['liveChatDesktop']) && isset($_POST['liveChatMobile'])) {

        // Escape string untuk mencegah SQL Injection
        $websiteTitle = mysqli_real_escape_string($koneksi, $_POST['websiteTitle']);
        $metaDescription = mysqli_real_escape_string($koneksi, $_POST['metaDescription']);
        $metaKeyword = mysqli_real_escape_string($koneksi, $_POST['metaKeyword']);
        $MetaHeaderWeb = mysqli_real_escape_string($koneksi, $_POST['MetaHeaderWeb']);
        $googleAnalytic = mysqli_real_escape_string($koneksi, $_POST['googleAnalytic']);
        $runningText = mysqli_real_escape_string($koneksi, $_POST['runningText']);
        $footer = mysqli_real_escape_string($koneksi, $_POST['footer']);
        $liveChatDesktop = mysqli_real_escape_string($koneksi, $_POST['liveChatDesktop']);
        $liveChatMobile = mysqli_real_escape_string($koneksi, $_POST['liveChatMobile']);

        // Query SQL untuk menyimpan data ke dalam database
        $sql = "UPDATE website SET 
                Title = '$websiteTitle', 
                description = '$metaDescription', 
                Keyword = '$metaKeyword', 
                MetaHeaderWeb = '$MetaHeaderWeb', 
                GoogleAnalytic = '$googleAnalytic', 
                Marquee = '$runningText', 
                FooterHeader = '$footer', 
                LiveChatDesktop = '$liveChatDesktop', 
                LiveChatMobile = '$liveChatMobile'";

        if ($koneksi->query($sql) === TRUE) {
            echo "Data berhasil disimpan";
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi;
        }

        // Tutup koneksi
        $koneksi->close();
    } else {
        echo "Data tidak lengkap";
    }
} else {
    echo "Metode request tidak valid";
}
?>
