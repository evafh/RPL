<?php
include("config.php");

session_start();
if( !isset($_SESSION["masuk"]) ){
    header("Location: masuk.php");
    exit;
}

if(isset($_POST['submit'])){
    
    $id_pengguna         = $_SESSION['id_pengguna'];
    $saldo_total_awal    = $_SESSION['saldo_total'];
    $nama_dompet         = $_POST['nama_dompet'];
    $saldo               = $_POST['saldo'];
    $saldo_total         = $saldo + $saldo_total_awal;


    $query = pg_query("INSERT INTO dompet (id_pengguna, nama_dompet, saldo) VALUES ('$id_pengguna', '$nama_dompet', '$saldo');");

    if( $query==TRUE ) {
        $query = "UPDATE pengguna SET saldo_total='$saldo_total'WHERE id_pengguna=$id_pengguna";
        pg_query($db, $query);

        header('Location: saya_Dompet.php');
    } else {
        header('Location: saya_Dompet.php');
    }

} else {
	die("Akses dilarang...");
}
?>