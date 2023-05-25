<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Tambah Anggaran</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h1>Tambah Anggaran</h1>
        <form method="post" action="proses_Tambah_Anggaran.php">

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
                <input type="money" name="nominal_anggaran" required pattern="[0-9\s]{3,20}">
            </div>

            <input type="submit" value="Tambah" name="submit">
        </form>
    </body>
</html>