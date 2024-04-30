<?php
session_start();
include("../fungsi/koneksi.php");

// Set zona waktu ke "Asia/Jakarta"
date_default_timezone_set('Asia/Jakarta');

$username = "";
$password = "";
$err = "";

if (isset($_POST['Login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        $err = "Silahkan Masukan User Name Dan Password.";
    } else {
        $sql1 = "SELECT * FROM master_admin WHERE username = '$username'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);
        $n1 = mysqli_num_rows($q1);

        if ($n1 < 1) {
            $err = "Username tidak ditemukan";
        } elseif ($r1['password'] != md5($password)) {
            $err = "Password yang kamu masukkan tidak sesuai";
        } elseif ($r1['status_login'] == 'login') {
            $err = "Akun sedang digunakan";
        } else {
                // Login berhasil, simpan username ke dalam sesi
                $_SESSION['admin_username'] = $username;

                // Tambahkan tanggal dan waktu saat login
                $tanggal_login = date('Y-m-d H:i:s');

                // Update last_login di database
                $sql3 = "UPDATE master_admin SET last_login = '$tanggal_login' WHERE username = '$username'";
                mysqli_query($koneksi, $sql3);

                // Update status_login di database menjadi "login"
                $sql2 = "UPDATE master_admin SET status_login = 'login' WHERE username = '$username'";
                mysqli_query($koneksi, $sql2);

                // Arahkan pengguna ke halaman index
                header("Location: Dashboard");
                exit();
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Login Admin</title>
    
        <script>
        function handleInputFocus(input) {
            const label = input.nextElementSibling;
            label.style.top = '-6px';
        }
        
        function handleInputBlur(input) {
            const label = input.nextElementSibling;
            if (input.value === '') {
                label.style.top = '60%';
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* PEMBUNGKUS KOTAK */
        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: url("../assets/img/bgbg.jpg") no-repeat;
            background-position: center;
            background-size: cover;
        }

        /* KOTAK YANG DI DALAM SEMUA ELEMENT */
        .form-box {
            background: transparent;
            width: 400px;
            height: 400px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 5px solid white;
            border-radius: 30px;
            backdrop-filter: blur(20px);
        }

        /* H2 LOGIN ADMIN */
        h2 {
            font-size: 2em;
            color: white;
            text-align: center;
            border-top: 3px solid black;
            border-bottom: 3px solid black;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                border-bottom-color: rgb(255, 255, 255);
                border-top-color: rgb(255, 255, 255);
            }

            50% {
                border-bottom-color: black;
                border-top-color: black;
            }

            100% {
                border-bottom-color: rgb(255, 255, 255);
                border-top-color: rgb(255, 255, 255);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        ion-icon[name="logo-electron"] {
            animation: spin 2s linear infinite;
        }

        /* INPUTBOX LOGIN */
        .inputbox {
            position: relative;
            margin: 50px 0px;
            border-bottom: 3px solid black;
        }

        .inputbox label {
            position: absolute;
            top: 60%;
            left: 5px;
            color: white;
            transform: translatey(-50%);
            font-size: 1.3em;
            pointer-events: none;
            transition: 0.3s;
            /* JEDA SAAT DI KLICK TRANSISI */
        }

        .inputbox input:focus + label,
        .inputbox input:valid + label {
            top: 60%;
        }

        /* INPUT USERNAME DAN PASSWORD */
        .inputbox input {
            width: 85%;
            height: 30px;
            background-color: transparent;
            outline: none;
            /* kotak input yang bersinar */
            border: none;
            /* kotak input kotak hitam */
            padding: 0 35px 0 5px;
            color: white;
        }

        .inputbox ion-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            color: white;
        }

        .form-box button {
            position: relative;
            width: 70%;
            left: 30%;
            height: 40px;
            border-radius: 60px;
            background-color: white;
            color: black;
            font-size: 20px;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            cursor: pointer;
            transition: 0.5s;
        }

        .form-box button:hover {
            position: relative;
            width: 70%;
            left: 30%;
            height: 40px;
            border: 2px solid white;
            border-radius: 60px;
            background-color: black;
            color: white;
            font-size: 23px;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            cursor: pointer;
        }

        .copyright {
            font-size: 1em;
            color: #ADFF2F	;
            text-align: center;
            position: relative;
            padding-top: 30px;
        }

        .alert {
            position: fixed;
            top: 15%;
            left: 50%;
            width: 350px;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background-color: red;
            color: white;
            padding: 10px 20px;
            font-family: Arial, sans-serif;
            font-size: 20px;
            transition: opacity 0.7s ease-in-out;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .user,
        .pw {
            position: relative;
            left: 15px;
        }
    </style>

</head>

<body>
    <div class="notification">
        <form action="" method="POST">
            <?php 
    if($err){
    ?>
            <div class="alert alert-danger">
                <?php echo $err ?>
            </div>
            <?php
    }
    ?>
    </div>

    <section>
        <div class="form-box">
            <div class="from-value">
                <form action="">
                    <h2>
                        <ion-icon name="logo-electron"></ion-icon> LOGIN * ADMIN <ion-icon name="logo-electron">
                        </ion-icon>
                    </h2>
                    <div class="inputbox">
                        <ion-icon name="person"></ion-icon>
                        <input type="text" id="username" name="username" value="<?php echo $username?>" onfocus="handleInputFocus(this)" onblur="handleInputBlur(this)"/>
                        <label for="username">Username</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="key"></ion-icon>
                        <input type="password" id="password" name="password" onfocus="handleInputFocus(this)" onblur="handleInputBlur(this)"/>
                        <label for="password">Password</label>
                    </div>
                    <button class="button" name="Login">Sign In</button>
                    <div class="copyright">
                        <h4>2023@ Copyright By Izuna.</h4>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var notification = document.querySelector('.notification');
            notification.style.display = 'block';
            setTimeout(function () {
                notification.style.display = 'none';
            }, 3000);
        });
    </script>

</body>

</html>