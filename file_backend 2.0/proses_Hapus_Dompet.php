<?php
include("config.php");

session_start();
	
if( !isset($_SESSION["masuk"]) ){
	header("Location: masuk.php");
	exit;
}

if( isset($_GET['id_dompet']) ){

    $id_dompet              = $_GET['id_dompet'];
    $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$id_dompet");
    $dompet 				= pg_fetch_array($query_dompet_awal);
	$saldo_awal				= $dompet['saldo'];

	$id_pengguna            = $_SESSION["id_pengguna"];
    $query_awal_pengguna	= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
    $pengguna 				= pg_fetch_array($query_awal_pengguna);
	$saldo_total_awal		= $pengguna['saldo_total'];

	$saldo_total_akhir 		= $saldo_total_awal - $saldo_awal;

    $query = pg_query("DELETE FROM dompet WHERE id_dompet=$id_dompet");

    if( $query ){
		$query = "UPDATE pengguna SET saldo_total='$saldo_total_akhir'WHERE id_pengguna=$id_pengguna";
		pg_query($db, $query);
        header('Location: saya_Dompet.php');
    } else {
        header('Location: saya_Dompet.php');
    }

} else {
    die("akses dilarang...");
}
?>