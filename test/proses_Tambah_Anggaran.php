<?php
include("config.php");

session_start();
if (!isset($_SESSION["masuk"])) {
    header("Location: masuk.php");
    exit;
}

if (isset($_POST['submit'])) {

    $id_pengguna         = $_SESSION['id_pengguna'];
    $id_tipe             = $_POST['id_tipe'];
    $id_dompet           = $_POST['id_dompet'];
    $bulan               = $_POST['bulan'];
    $nominal_anggaran    = $_POST['nominal_anggaran'];

    $query = pg_query("INSERT INTO anggaran (id_dompet, id_pengguna, bulan, tahun, kategori_anggaran, nominal_anggaran) 
                    VALUES ('$id_dompet', '$id_pengguna', to_date('$bulan-01', 'YYYY-MM-DD'), DATE_TRUNC('year', to_date('$bulan-01', 'YYYY-MM-DD')), $id_tipe, $nominal_anggaran);");

    $queryTotalAnggaran = pg_query("INSERT INTO total_anggaran (id_dompet, id_pengguna, bulan, tahun, nominal_anggaran)
                    VALUES ('$id_dompet', '$id_pengguna', to_date('$bulan-01', 'YYYY-MM-DD'), DATE_TRUNC('year', to_date('$bulan-01', 'YYYY-MM-DD')), $nominal_anggaran)
                    ON CONFLICT (id_dompet, bulan, tahun) DO UPDATE
                    SET nominal_anggaran = total_anggaran.nominal_anggaran + $nominal_anggaran;");

    if ($queryTotalAnggaran) {
        header("Location: saya_Rencana.php?id_dompet=$id_dompet&bulan=$bulan");
    } else {
        header('Location: saya_Dompet.php');
    }
} else {
    die("Akses dilarang...");
}
?>