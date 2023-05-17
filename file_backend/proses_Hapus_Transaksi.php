<?php
include("config.php");

session_start();
	
if( !isset($_SESSION["masuk"]) ){
	header("Location: masuk.php");
	exit;
}

if( isset($_GET['id_transaksi']) ){

    $id_transaksi           = $_GET['id_transaksi'];
    $query_transaksi        = pg_query($db, "SELECT * FROM transaksi WHERE id_transaksi=$id_transaksi");
    $transaksi 				= pg_fetch_array($query_transaksi);
    $jumlah_transaksi_awal  = $transaksi['jumlah_transaksi'];
    $jenis_transaksi_awal   = $transaksi['jenis_transaksi'];
    $dompet_transaksi_awal  = $transaksi['id_dompet'];

    $id_pengguna 			= $_SESSION["id_pengguna"];
    $query_pengguna_awal	= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
    $pengguna 				= pg_fetch_array($query_pengguna_awal);
    $saldo_total_awal		= $pengguna['saldo_total'];

    $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$dompet_transaksi_awal");
    $dompet 				= pg_fetch_array($query_dompet_awal);
    $saldo_awal				= $dompet['saldo'];

    if($jenis_transaksi_awal == 'Pengeluaran' ){
        $saldo_sementara        = $saldo_awal + $jumlah_transaksi_awal;
        $saldo_total_sementara  = $saldo_total_awal + $jumlah_transaksi_awal;
    } else {
        $saldo_sementara        = $saldo_awal - $jumlah_transaksi_awal;
        $saldo_total_sementara  = $saldo_total_awal - $jumlah_transaksi_awal;
    }

    $query = pg_query("DELETE FROM transaksi WHERE id_transaksi=$id_transaksi");

    if( $query ){
        $update_dompet = "UPDATE dompet SET saldo='$saldo_sementara'WHERE id_dompet=$dompet_transaksi_awal";
        pg_query($db, $update_dompet);
        $update_pengguna = "UPDATE pengguna SET saldo_total='$saldo_total_sementara'WHERE id_pengguna=$id_pengguna";
        pg_query($db, $update_pengguna);
        header('Location: saya_Transaksi.php');
    } else {
        header('Location: saya_Transaksi.php');
    }

} else {
    die("akses dilarang...");
}
?>