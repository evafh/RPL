<?php
include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer-master/src/Exception.php');
require_once('PHPMailer-master/src/PHPMailer.php');
require_once('PHPMailer-master/src/SMTP.php');

if(isset($_POST['submit'])){
    $email      = $_POST['email'];

    $sql        = "SELECT * FROM pengguna WHERE email='$email'";
    $result     = pg_query($db, $sql);
    $cek        = pg_num_rows($result);

    if ($cek > 0) {
        $row = pg_fetch_assoc($result);

        $token = bin2hex(random_bytes(16));

        $query = "UPDATE pengguna SET token_reset='$token' WHERE email='$email'";
        $result = pg_query($db, $query);

        $reset_link = "localhost/manage_money/form_Reset_Kata_Sandi.php?email=$email&token=$token";

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

                // Konfigurasi email
                $mail->setFrom('nrizkiansyah@gmail.com', 'Manage Money');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Reset Kata Sandi';
                $mail->Body = "
                    Kode OTP Mamoy

                    Halo,
                    Berikut link untuk mereset password akun Mamoy Anda:

                    $reset_link

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

                // Kirim email
                $mail->send();

                echo "Email dengan link reset password telah dikirim ke $email.";
            } catch (Exception $e) {
                echo "Gagal mengirim email: {$mail->ErrorInfo}";
            }

        } else {
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }

    } else {
        echo "Email tidak terdaftar. Silakan coba lagi.";
    }
} else {
	die("Akses dilarang...");
}

?>

