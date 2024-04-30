<?php
include("../fungsi/koneksi.php");

$query_master_admin = "SELECT coin FROM master_admin WHERE name = 'MASTER ADMIN'";
$result_master_admin = mysqli_query($koneksi, $query_master_admin);

while ($row_master_admin = mysqli_fetch_assoc($result_master_admin)) {
    $coin_admin = $row_master_admin['coin'];
}
echo($coin_admin);

// $query_provider = "SELECT * FROM apigameprovider";
// $result_provider = mysqli_query($koneksi, $query_provider);

// while ($row_provider = mysqli_fetch_assoc($result_provider)) {
//     // Lakukan sesuatu dengan data yang diambil, misalnya tampilkan
//     $operator_code1 = $row_provider['operator_code'];
//     $secret_key1 = $row_provider['secret_key'];
//     $api_url1 = $row_provider['api_url'];
//     $LOG_URL1 = $row_provider['LOG_URL'];
//     // print_r($row_provider);
// }

// $operator_code = $operator_code1;
// $secret_key = $secret_key1;
// $api_url = $api_url1;
// $LOG_URL = $LOG_URL1;
// $endpoint = "checkAgentCredit.aspx";

// // Parameter-parameter untuk URL
// $parameters = array(
//     "operatorcode" => $operator_code,
// );

// // Urutkan parameter berdasarkan kunci
// ksort($parameters);

// // Gabungkan parameter menjadi string query
// $query_string = http_build_query($parameters);

// // Hitung signature menggunakan MD5
// $signature = strtoupper(md5($operator_code . $secret_key));

// // Menginisialisasi cURL
// $curl = curl_init();

// // Mengatur URL API
// curl_setopt($curl, CURLOPT_URL, $api_url.'/'.$endpoint.'?'.$query_string.'&signature='.$signature);

// // Mengatur opsi lainnya
// curl_setopt_array($curl, array(
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "GET",
//     CURLOPT_HTTPHEADER => array(
//         "Content-Type: application/x-www-form-urlencoded",
//         "Cache-Control: no-cache"
//     ),
// ));

// // Eksekusi permintaan cURL dan menyimpan respons
// $response = curl_exec($curl);

// // Cek apakah permintaan cURL berhasil
// if ($response === false) {
//     die(curl_error($curl));
// }

// // Menutup sambungan cURL
// curl_close($curl);

// // Mengubah respons JSON menjadi array
// $data = json_decode($response, true);

// // Jika respons tidak kosong
// if (!empty($data)) {
//     // Ambil nilai coin dari respons
//     $coin = $data['data'];

//     // Update nilai coin pada database
//     $query = "UPDATE master_admin SET coin = '$coin' WHERE username = 'admin'";
//     $result = mysqli_query($koneksi, $query);

//     if (!$result) {
//         die('Error updating database');
//     }
// }

// // Ambil nilai coin dari database setelah update
// $query = "SELECT coin FROM master_admin WHERE username = 'admin'";
// $result = mysqli_query($koneksi, $query);

// if ($result && mysqli_num_rows($result) > 0) {
//     $row = mysqli_fetch_assoc($result);
//     $coin = $row['coin'];
// } else {
//     $coin = 0; // Jika tidak ada data, set nilai coin ke 0
// }

// mysqli_close($koneksi);

// header('Content-Type: application/json');
// echo ($coin);
?>
