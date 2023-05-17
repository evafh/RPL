<?php
include("config.php");

session_start();
if( !isset($_SESSION["masuk"]) ){
    header("Location: masuk.php");
    exit;
}

if(isset($_POST['submit'])){
    
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

    $update_dompet = "UPDATE dompet SET saldo='$saldo_sementara'WHERE id_dompet=$dompet_transaksi_awal";
    pg_query($db, $update_dompet);
    $update_pengguna = "UPDATE pengguna SET saldo_total='$saldo_total_sementara'WHERE id_pengguna=$id_pengguna";
    pg_query($db, $update_pengguna);

    $jumlah_transaksi 		= $_POST['jumlah_transaksi'];
    $jenis_transaksi 		= $_POST['jenis_transaksi'];
    $pilihan_pengeluaran 	= $_POST['pilihan_pengeluaran'];
    $pilihan_pemasukan 		= $_POST['pilihan_pemasukan'];
    $catatan_transaksi 		= $_POST['catatan_transaksi'];
    $id_dompet    		    = $_POST['id_dompet'];
    $tanggal_transaksi    	= $_POST['tanggal_transaksi'];


    if($jenis_transaksi == 'Pengeluaran'){
        $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$id_dompet");
        $dompet 				= pg_fetch_array($query_dompet_awal);
        $saldo_awal				= $dompet['saldo'];

        $id_pengguna 			= $_SESSION["id_pengguna"];
        $query_pengguna_awal	= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
        $pengguna 				= pg_fetch_array($query_pengguna_awal);
        $saldo_total_awal		= $pengguna['saldo_total'];

        $saldo                  = $saldo_awal - $jumlah_transaksi;
        $saldo_total            = $saldo_total_awal - $jumlah_transaksi;

        $query = "UPDATE transaksi SET id_dompet='$id_dompet', id_pengguna='$id_pengguna', tanggal_transaksi='$tanggal_transaksi', jumlah_transaksi='$jumlah_transaksi', jenis_transaksi='$jenis_transaksi', kategori_transaksi='$pilihan_pengeluaran', catatan_transaksi='$catatan_transaksi' WHERE id_transaksi=$id_transaksi";
        pg_query($db, $query);
    
        if( $query==TRUE ) {
            $update_dompet = "UPDATE dompet SET saldo='$saldo'WHERE id_dompet=$id_dompet";
            pg_query($db, $update_dompet);
            $update_pengguna = "UPDATE pengguna SET saldo_total='$saldo_total'WHERE id_pengguna=$id_pengguna";
            pg_query($db, $update_pengguna);
            header('Location: saya_Transaksi.php');
        } else {
            header('Location: saya_Transaksi.php');
        }

    } else{
        $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$id_dompet");
        $dompet 				= pg_fetch_array($query_dompet_awal);
        $saldo_awal				= $dompet['saldo'];

        $id_pengguna 			= $_SESSION["id_pengguna"];
        $query_pengguna_awal	= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
        $pengguna 				= pg_fetch_array($query_pengguna_awal);
        $saldo_total_awal		= $pengguna['saldo_total'];

        $saldo                  = $saldo_awal + $jumlah_transaksi;
        $saldo_total            = $saldo_total_awal + $jumlah_transaksi;

        $query = "UPDATE transaksi SET id_dompet='$id_dompet', id_pengguna='$id_pengguna', tanggal_transaksi='$tanggal_transaksi', jumlah_transaksi='$jumlah_transaksi', jenis_transaksi='$jenis_transaksi', kategori_transaksi='$pilihan_pemasukan', catatan_transaksi='$catatan_transaksi' WHERE id_transaksi=$id_transaksi";
        pg_query($db, $query);

        if( $query==TRUE ) {
            $update_dompet = "UPDATE dompet SET saldo='$saldo'WHERE id_dompet=$id_dompet";
            pg_query($db, $update_dompet);
            $update_pengguna = "UPDATE pengguna SET saldo_total='$saldo_total'WHERE id_pengguna=$id_pengguna";
            pg_query($db, $update_pengguna);

            header('Location: saya_Transaksi.php?status=sukses');
        } else {
            header('Location: saya_Transaksi.php?status=gagal');
        }
    }
} else {
	die("Akses dilarang...");
}