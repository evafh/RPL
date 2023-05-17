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
        <title>Manage Money - Tambah Wallet</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h1>Tambah Wallet</h1>
        <form method="post" action="proses_Tambah_Dompet.php">

            <div class="Tambah_Dompet-field">
                <label for="nama_dompet">Nama Dompet</label>
                <input type="text" name="nama_dompet" autofocus required pattern="([A-Z])[A-Z/a-z\s]{1,128}">
            </div>

            <div class="Tambah_Dompet-field">
                <label for="saldo">Saldo</label>
                <input type="money" name="saldo" required pattern="[0-9\s]{3,20}">
            </div>

            <input type="submit" value="Tambah" name="submit">
        </form>
    </body>
</html>


