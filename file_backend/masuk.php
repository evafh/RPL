<?php
    include("config.php");

    error_reporting(0);

    session_start();

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
                header("Location: index.php");
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
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h1>Login</h1>
        <form method="post">
            <div class="login-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="login-field">
                <label for="kata_sandi">Kata Sandi</label>
                <input type="password" id="kata_sandi" name="kata_sandi" required>
            </div>

            <input type="submit" name="submit" value="Masuk">
        </form>
        <div class="login-signup">
                Tidak Memiliki Akun? <a href="form_Buat_Akun.php">Daftar</a>
                <br>
                <a href="form_Lupa_Kata_Sandi.php">Lupa Kata Sandi?</a>
        </div>
    </body>
</html>
