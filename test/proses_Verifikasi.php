<?php
include("config.php");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $kode_verifikasi = $_POST['kode_verifikasi'];

    $query = "SELECT * FROM pengguna WHERE email='$email' AND kode_verifikasi='$kode_verifikasi'";
    $result = pg_query($db, $query);

    if (pg_num_rows($result) > 0) {
        $query = "UPDATE pengguna SET status_verifikasi=true WHERE email='$email'";
        $result = pg_query($db, $query);
        if ($result) {
            header("Location: masuk.php");
        } else {
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }
    } else {
        echo "Kode verifikasi salah. Silakan coba lagi.";
    }
} else {
    die("Akses dilarang...");
}
?>