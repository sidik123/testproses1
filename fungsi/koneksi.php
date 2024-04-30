<?php
$host     = "localhost";
$user     = "root";
$pass     = "";
$db       = "testproses";

$koneksi  = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("gagal");
}else{
    echo "";
}