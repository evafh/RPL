<?php

include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer-master/src/Exception.php');
require_once('PHPMailer-master/src/PHPMailer.php');
require_once('PHPMailer-master/src/SMTP.php');

if(isset($_POST['submit'])){

        $nama_pengguna          = $_POST['nama_pengguna'];
        $email                  = $_POST['email'];
        $kata_sandi             = md5($_POST['kata_sandi']);
        $konfirmasi_kata_sandi  = md5($_POST['konfirmasi_kata_sandi']);
        $kode_verifikasi        = rand(100000, 999999);
        $saldo_total            = 0;

        $sql_nama_pengguna      ="select * from pengguna where nama_pengguna = '".pg_escape_string($_POST['nama_pengguna'])."'";
        $data_nama_pengguna     = pg_query($db,$sql_nama_pengguna); 
        $cek_nama_pengguna      = pg_num_rows($data_nama_pengguna);

        $sql_email              ="select * from pengguna where email = '".pg_escape_string($_POST['email'])."'";
        $data_email             = pg_query($db,$sql_email); 
        $cek_email              = pg_num_rows($data_email);

        if(($cek_nama_pengguna > 0) || ($cek_email > 0)){
            $row_nama_pengguna  = pg_fetch_assoc($data);
            $row_email          = pg_fetch_assoc($edata);

            if($_POST["nama_pengguna"]==isset($row_nama_pengguna['nama_pengguna'])){
                echo"<script>alert('Username Sudah Terdaftar'); window.location='form_Buat_Akun.php';</script>";
            }
            if($_POST["email"]==isset($row_email['email'])){
                echo"<script>alert('Email Sudah Terdaftar'); window.location='form_Buat_Akun.php';</script>";
            }
        }
        else{
            $query = pg_query("INSERT INTO pengguna (nama_pengguna, email, saldo_total, kata_sandi, kode_verifikasi) VALUEs ('$nama_pengguna', '$email', '$saldo_total', '$kata_sandi', '$kode_verifikasi')");

            if( $query==TRUE ) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'nrizkiansyah@gmail.com';
                    $mail->Password = 'makwkneyrjfxjtdt';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
    
                    $mail->setFrom('nrizkiansyah@gmail.com', 'Manage Money');
                    $mail->addAddress($email, $username);
                    $mail->isHTML(true);
                    $mail->Subject = 'Verifikasi Akun';
                    $mail->Body = "
                    Kode OTP Mamoy

                    Halo $nama_pengguna,
                    Berikut kode OTP untuk login ke akun Mamoy kamu:

                    $kode_verifikasi

                    Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari Mamoy.

                    Jika kamu tidak mencoba login, segera ubah Password & PIN melalui website Mamoy atau hubungi Customer Service untuk menjaga akunmu tetap aman.

                    --Ubah Password & PIN--


                    Salam hangat,


                    Mamoy";

                    // Memisahkan paragraf menjadi elemen-elemen array
                    $paragraf = explode("\n", $mail->Body);

                    // Menghapus spasi tambahan pada setiap elemen array
                    $paragraf = array_map('trim', $paragraf);

                    // Menghapus elemen kosong dari array
                    $paragraf = array_filter($paragraf);

                    // Menggabungkan paragraf kembali dengan tanda baris baru (<br>) di antara mereka
                    $body = implode("<br>", $paragraf);

                    // Set body email yang telah dimodifikasi
                    $mail->Body = $body;

                    $mail->send();

                    header("Location: form_Verifikasi.php?email=$email");
                } catch (Exception $e) {
                    echo "Gagal mengirim email: {$mail->ErrorInfo}";
                }

            } else {
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }
        }

} else {
	die("Akses dilarang...");
}
?>
