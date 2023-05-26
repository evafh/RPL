<?php
include("config.php");

session_start();
if( !isset($_SESSION["masuk"]) ){
    header("Location: masuk.php");
    exit;
}

if(isset($_POST['submit'])){
	
	$nama_dompet 			= $_POST['nama_dompet'];
    $saldo_akhir 			= $_POST['saldo'];

	$id_dompet       		= $_GET['id_dompet'];
    $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$id_dompet");
    $dompet 				= pg_fetch_array($query_dompet_awal);
	$saldo_awal				= $dompet['saldo'];

	$id_pengguna 			= $_SESSION["id_pengguna"];
    $query_user_awal		= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
    $pengguna 				= pg_fetch_array($query_user_awal);
	$saldo_total_awal		= $pengguna['saldo_total'];

	$saldo_sementara 		= $saldo_total_awal - $saldo_awal;

	$saldo_total_akhir 		= $saldo_sementara + $saldo_akhir;

    $query = "UPDATE dompet SET nama_dompet='$nama_dompet',saldo='$saldo_akhir' WHERE id_pengguna=$id_pengguna";
    pg_query($db, $query);
    
	if( $query==TRUE ) {
		$query = "UPDATE pengguna SET saldo_total='$saldo_total_akhir'WHERE id_pengguna=$id_pengguna";
		pg_query($db, $query);
		header('Location: saya_Dompet.php');
	} else {
		header('Location: saya_Dompet.php');
	}

} else {
	die("Akses dilarang...");
}
?>