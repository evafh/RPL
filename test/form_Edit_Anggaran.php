<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_tipe         = $_GET['id_tipe'];
    $bulan           = $_GET['bulan'];
    $query 		     = pg_query($db, "SELECT * FROM anggaran WHERE kategori_anggaran=$id_tipe AND bulan = '$bulan-01'");
    $anggaran 		 = pg_fetch_array($query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Edit Anggaran</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h1>Edit Anggaran</h1>
        <form method="post" action="proses_Edit_Anggaran.php">

            <div class="Tambah_Anggaran-field">
                <input type="hidden" name="id_dompet" value="<?php echo $_GET['id_dompet']; ?>">
            </div>

            <div class="Tambah_Anggaran-field">
                <input type="hidden" name="id_tipe" value="<?php echo $_GET['id_tipe'] ?>">
            </div>

            <div class="Tambah_Anggaran-field">
                <input type="hidden" name="bulan" value="<?php echo $_GET['bulan']; ?>">
            </div>

            <div class="Tambah_Anggaran-field">
                <label for="nominal_anggaran">Saldo</label>
                <input type="money" name="nominal_anggaran" value="<?php echo $anggaran['nominal_anggaran']?>" required pattern="[0-9\s]{3,20}">
            </div>

            <input type="submit" value="Tambah" name="submit">
        </form>
    </body>
</html>