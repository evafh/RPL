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
    $bulan_transaksi_awal   = date('Y-m', strtotime($transaksi['tanggal_transaksi']));

    $id_pengguna 			= $_SESSION["id_pengguna"];
    $query_pengguna_awal	= pg_query($db, "SELECT * FROM pengguna WHERE id_pengguna=$id_pengguna");
    $pengguna 				= pg_fetch_array($query_pengguna_awal);
    $saldo_total_awal		= $pengguna['saldo_total'];

    $query_dompet_awal		= pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$dompet_transaksi_awal");
    $dompet 				= pg_fetch_array($query_dompet_awal);
    $saldo_awal				= $dompet['saldo'];

    $query_total_transaksi  = pg_query($db, "SELECT * FROM total_transaksi WHERE id_dompet=$dompet_transaksi_awal AND bulan ='$bulan_transaksi_awal-01' ");
    $total_transaksi 		= pg_fetch_array($query_total_transaksi);
    $total_pemasukan    	= $total_transaksi['total_pemasukan'];
    $total_pengeluaran  	= $total_transaksi['total_pengeluaran'];

    if($jenis_transaksi_awal == 'Pengeluaran' ){
        $saldo_sementara        = $saldo_awal + $jumlah_transaksi_awal;
        $saldo_total_sementara  = $saldo_total_awal + $jumlah_transaksi_awal;
        $total_transaksi_sementara = $total_pengeluaran - $jumlah_transaksi_awal;
        $update_total_transaksi = "UPDATE total_transaksi SET total_pengeluaran='$total_transaksi_sementara' WHERE id_dompet=$dompet_transaksi_awal AND bulan ='$bulan_transaksi_awal-01'";
        pg_query($db, $update_total_transaksi);
    } else {
        $saldo_sementara        = $saldo_awal - $jumlah_transaksi_awal;
        $saldo_total_sementara  = $saldo_total_awal - $jumlah_transaksi_awal;
        $total_transaksi_sementara = $total_pemasukan - $jumlah_transaksi_awal;
        $update_total_transaksi = "UPDATE total_transaksi SET total_pemasukan='$total_transaksi_sementara' WHERE id_dompet$dompet_transaksi_awal AND bulan ='$bulan_transaksi_awal-01'";
        pg_query($db, $update_total_transaksi);
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
    $bulan                  = date('Y-m', strtotime($tanggal_transaksi));



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

        $query_total_transaksi      = pg_query($db, "SELECT * FROM total_transaksi WHERE id_dompet=$id_dompet AND bulan ='$bulan-01' ");
        if($total_transaksi         = pg_fetch_assoc($query_total_transaksi)){
            $total_pengeluaran  	= $total_transaksi['total_pengeluaran'];
            $total_pengeluaran      = $total_pengeluaran + $jumlah_transaksi;
            $update_total_transaksi = "UPDATE total_transaksi SET total_pengeluaran='$total_pengeluaran' WHERE id_dompet=$id_dompet AND bulan ='$bulan-01'";
            pg_query($db, $update_total_transaksi);
        } else{
            $queryTotalTransaksi = "INSERT INTO total_transaksi (id_dompet, id_pengguna, bulan, tahun, total_pemasukan, total_pengeluaran)
                                    VALUES (
                                        $id_dompet,
                                        $id_pengguna,
                                        DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE)),
                                        DATE_TRUNC('year', CAST('$tanggal_transaksi' AS DATE)),
                                        (
                                            SELECT SUM(CASE WHEN jenis_transaksi = 'Pemasukan' THEN jumlah_transaksi ELSE 0 END)
                                            FROM transaksi
                                            WHERE id_dompet = $id_dompet AND DATE_TRUNC('month', CAST(tanggal_transaksi AS DATE)) = DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE))
                                        ),
                                        (
                                            SELECT SUM(CASE WHEN jenis_transaksi = 'Pengeluaran' THEN jumlah_transaksi ELSE 0 END)
                                            FROM transaksi
                                            WHERE id_dompet = $id_dompet AND DATE_TRUNC('month', CAST(tanggal_transaksi AS DATE)) = DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE))
                                        )
                                    )
                                    ON CONFLICT (id_dompet, bulan, tahun) DO UPDATE
                                    SET total_pemasukan = excluded.total_pemasukan, total_pengeluaran = excluded.total_pengeluaran
                                    WHERE total_transaksi.id_dompet = excluded.id_dompet
                                        AND total_transaksi.bulan = excluded.bulan
                                        AND total_transaksi.tahun = excluded.tahun";

            $queryResult = pg_query($db, $queryTotalTransaksi);
            if ($queryResult === false) {
            die("Error executing query: " . pg_last_error($db));
            }
        }

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

        $query_total_transaksi  = pg_query($db, "SELECT * FROM total_transaksi WHERE id_dompet=$id_dompet AND bulan ='$bulan-01' ");
        if($total_transaksi = pg_fetch_assoc($query_total_transaksi)){
            $total_pemasukan    = $total_transaksi['total_pemasukan'];
            $total_pemasukan    = $total_pemasukan + $jumlah_transaksi;
            $update_total_transaksi = "UPDATE total_transaksi SET total_pemasukan='$total_pemasukan' WHERE id_dompet=$id_dompet AND bulan ='$bulan-01'";
            pg_query($db, $update_total_transaksi);
        } else {
            $queryTotalTransaksi = "INSERT INTO total_transaksi (id_dompet, id_pengguna, bulan, tahun, total_pemasukan, total_pengeluaran)
                                    VALUES (
                                        $id_dompet,
                                        $id_pengguna,
                                        DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE)),
                                        DATE_TRUNC('year', CAST('$tanggal_transaksi' AS DATE)),
                                        (
                                            SELECT SUM(CASE WHEN jenis_transaksi = 'Pemasukan' THEN jumlah_transaksi ELSE 0 END)
                                            FROM transaksi
                                            WHERE id_dompet = $id_dompet AND DATE_TRUNC('month', CAST(tanggal_transaksi AS DATE)) = DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE))
                                        ),
                                        (
                                            SELECT SUM(CASE WHEN jenis_transaksi = 'Pengeluaran' THEN jumlah_transaksi ELSE 0 END)
                                            FROM transaksi
                                            WHERE id_dompet = $id_dompet AND DATE_TRUNC('month', CAST(tanggal_transaksi AS DATE)) = DATE_TRUNC('month', CAST('$tanggal_transaksi' AS DATE))
                                        )
                                    )
                                    ON CONFLICT (id_dompet, bulan, tahun) DO UPDATE
                                    SET total_pemasukan = excluded.total_pemasukan, total_pengeluaran = excluded.total_pengeluaran
                                    WHERE total_transaksi.id_dompet = excluded.id_dompet
                                        AND total_transaksi.bulan = excluded.bulan
                                        AND total_transaksi.tahun = excluded.tahun";

            $queryResult = pg_query($db, $queryTotalTransaksi);
            if ($queryResult === false) {
            die("Error executing query: " . pg_last_error($db));
            }
        }

        if( $query==TRUE ) {
            header('Location: saya_Transaksi.php?status=sukses');
        } else {
            header('Location: saya_Transaksi.php?status=gagal');
        }
    }
} else {
	die("Akses dilarang...");
}