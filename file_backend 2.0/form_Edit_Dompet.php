<?php
    include("config.php");
    session_start();
        
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_dompet       = $_GET['id_dompet'];
    $query 		     = pg_query($db, "SELECT * FROM dompet WHERE id_dompet=$id_dompet");
    $dompet 		 = pg_fetch_array($query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Edit Dompet</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h2>Edit Dompet</h2>
        <form method="post" action="proses_Edit_Dompet.php?id_dompet=<?php echo $dompet['id_dompet'];?>">

            <div class="Edit_Dompet-field">
                <label for="nama_dompet">Nama Dompet</label>
                <input type="text" value="<?php echo $dompet['nama_dompet'];?>" name="nama_dompet" autofocus required pattern="([A-Z])[A-Z/a-z\s]{1,128}">
            </div>

            <div class="Edit_Dompet-field">
                <label for="saldo">Saldo</label>
                <input type="text" value="<?php echo $dompet['saldo'];?>" name="saldo" required pattern="[0-9\s]{3,20}">
            </div>

            <input type="submit" value="Simpan" name="submit">

        </form>
    </body>
</html>