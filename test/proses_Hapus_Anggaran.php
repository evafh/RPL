<?php
include("config.php");

session_start();
	
if( !isset($_SESSION["masuk"]) ){
	header("Location: masuk.php");
	exit;
}

if( isset($_GET['id_tipe']) ){

    $id_tipe             = $_GET['id_tipe'];
    $id_dompet           = $_GET['id_dompet'];
    $bulan               = $_GET['bulan'];

    $query_anggaran_awal	= pg_query($db, "SELECT * FROM anggaran WHERE id_dompet=$id_dompet AND kategori_anggaran=$id_tipe AND bulan='$bulan-01'");
    $anggaran 				= pg_fetch_array($query_anggaran_awal);
	$anggaran_awal			= $anggaran['nominal_anggaran'];

    $query_total_anggaran_awal	= pg_query($db, "SELECT * FROM total_anggaran WHERE id_dompet=$id_dompet AND bulan='$bulan-01'");
    $total_anggaran 		    = pg_fetch_array($query_total_anggaran_awal);
	$total_anggaran_awal	    = $total_anggaran['nominal_anggaran'];

	$anggaran_sementara 	= $total_anggaran_awal - $anggaran_awal;

    $query = pg_query("DELETE FROM anggaran WHERE kategori_anggaran=$id_tipe AND bulan='$bulan-01'");

    if( $query ){
		$query = "UPDATE total_anggaran SET nominal_anggaran='$anggaran_sementara' WHERE id_dompet=$id_dompet AND bulan='$bulan-01'";
		pg_query($db, $query);
        header("Location: saya_Rencana.php?id_dompet=$id_dompet&bulan=$bulan");
    } else {
        header('Location: saya_Dompet.php');
    }

} else {
    die("akses dilarang...");
}
?>