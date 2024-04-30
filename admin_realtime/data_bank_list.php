<?php
include("../fungsi/koneksi.php");

$query = "SELECT * FROM bank_list";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    $data = array();
}

mysqli_close($koneksi);

header('Content-Type: application/json');
echo json_encode($data);
?>
