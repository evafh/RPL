<?php
include("config.php");

session_start();
if( !isset($_SESSION["masuk"]) ){
    header("Location: masuk.php");
    exit;
}

if(isset($_POST['submit'])){
	
	$id_pengguna         = $_SESSION['id_pengguna'];
    $id_tipe             = $_POST['id_tipe'];
    $id_dompet           = $_POST['id_dompet'];
    $bulan               = $_POST['bulan'];
    $nominal_anggaran    = $_POST['nominal_anggaran'];

    $query_anggaran_awal	= pg_query($db, "SELECT * FROM anggaran WHERE id_dompet=$id_dompet AND kategori_anggaran=$id_tipe AND bulan='$bulan-01'");
    $anggaran 				= pg_fetch_array($query_anggaran_awal);
	$anggaran_awal			= $anggaran['nominal_anggaran'];

    $query_total_anggaran_awal	= pg_query($db, "SELECT * FROM total_anggaran WHERE id_dompet=$id_dompet AND bulan='$bulan-01'");
    $total_anggaran 		    = pg_fetch_array($query_total_anggaran_awal);
	$total_anggaran_awal	    = $total_anggaran['nominal_anggaran'];

	$anggaran_sementara 	= $total_anggaran_awal - $anggaran_awal;

	$saldo_total_akhir 		= $anggaran_sementara + $nominal_anggaran;

    $query = "UPDATE anggaran SET nominal_anggaran='$nominal_anggaran' WHERE kategori_anggaran=$id_tipe AND bulan='$bulan-01'";
    pg_query($db, $query);
    
	if( $query==TRUE ) {
		$query = "UPDATE total_anggaran SET nominal_anggaran='$saldo_total_akhir' WHERE id_dompet=$id_dompet AND bulan='$bulan-01'";
		pg_query($db, $query);
		header("Location: saya_Rencana.php?id_dompet=$id_dompet&bulan=$bulan");
	} else {
		header('Location: saya_Dompet.php');
	}

} else {
	die("Akses dilarang...");
}
?>