<?php
    include("config.php");

    session_start();

    error_reporting(0);

    if (isset($_SESSION['masuk'])) {
        header("Location: index.php");
    }

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $kata_sandi = md5($_POST['kata_sandi']);

        $sql = "SELECT * FROM pengguna WHERE email='$email' AND kata_sandi='$kata_sandi'";
        $result = pg_query($db, $sql);
        $login_check = pg_num_rows($result);
        if ($login_check > 0) {
            $row = pg_fetch_assoc($result);
            if ($row['status_verifikasi'] == 't') {
                $_SESSION['masuk'] = true;
                $_SESSION['id_pengguna'] = $row['id_pengguna'];
                $id_pengguna = $_SESSION['id_pengguna'];

                $buatdompet = "SELECT id_dompet FROM dompet WHERE id_pengguna = $id_pengguna";
                $resultdompet = pg_query($db, $buatdompet);

                if($dompetRow = pg_fetch_assoc($resultdompet))
                    header("Location: index.php");
                else{
                    header("Location: form_Tambah_Dompet.php");
                }
            } else {
                echo "<script>alert('Email belum terverifikasi. Silakan verifikasi terlebih dahulu.')</script>";
            }
            
        } else {
                echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Masuk</title>
        <link rel="stylesheet" href="../css/register.css">
    </head>
    <body>

        <div class="flex">
            <div class="something-placeholder float-left">
                <div class="something-content">
                    <div class="flex">
                        <img src="..\css\wallet.svg" alt="wallet" width="150" height="150" class="item-x">
                        <div class="item-x">Mamoy</div>
                    </div>
                    <div class="br"></div>
                    <p>Manage Money (Mamoy) adalah Website pencatat dan pengatur keuangan, ini didasarkan pada kebutuhan akan alat yang efektif dalam mengelola keuangan pribadi.</p>
                    <a href="index.php">Lihat fitur</a>
                </div>
            </div>
            <div class="float-right login-container">
                <br>
                <h1>Login</h1>
                <form method="post">
                    <!-- <div class="buat_Akun-field"> -->
                        <input class="buat_Akun-field" type="email" id="email" name="email" placeholder="Email" required>
                    <!-- </div> -->

                    <!-- <div class="buat_Akun-field"> -->
                        <input class="buat_Akun-field" type="password" id="kata_sandi" name="kata_sandi" placeholder="Kata Sandi"required>
                    <!-- </div> -->

                    <!-- <div class="buat_Akun-submit"> -->
                        <input class="buat_Akun-submit" type="submit" name="submit" value="Masuk" style="color: white;">
                    <!-- </div> -->
                </form>
                <div class="login-signup">
                    Tidak Memiliki Akun? <a href="form_Buat_Akun.php">Daftar</a>
                    <br>
                    <a href="form_Lupa_Kata_Sandi.php">Lupa Kata Sandi?</a>
                </div>
            </div>
        </div>
        
    </body>
</html>
