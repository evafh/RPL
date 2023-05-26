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
        <title>Manage Money - Dompet Saya</title>
    </head>

    <body>
    <a href="index.php"><button class="button">Halaman Utama</button></a>
        <div class="dompet">    
        <table border="1">
        <h1>Dompet Saya</h1>
        <p>
            <a href="form_Tambah_Dompet.php">[+] Tambah Wallet</a>
        <p>
        <thead>
            <tr>
                <th>Nama Dompet</th>  
                <th>Saldo</th>  
                <th>Tindakan</th>  

            </tr>
        </thead>
        <tbody>
            <?php
                $id_pengguna        = $_SESSION["id_pengguna"];
                $sql                = "SELECT * FROM dompet WHERE id_pengguna='$id_pengguna'";
                $result             = pg_query($db, $sql);
                $cek                = pg_num_rows($result);
                $counter            = 0;
                while($counter < $cek){
                    if ($cek > 0) {
                        $row = pg_fetch_assoc($result);

                        $_SESSION['id_dompet']      = $row['id_dompet'];
                        $_SESSION['nama_dompet']    = $row['nama_dompet'];
                        $_SESSION['saldo']          = $row["saldo"];

                        echo "<tr>";

                        echo "<td>".$_SESSION["nama_dompet"]."</td>";
                        echo "<td>".$_SESSION["saldo"]."</td>";

                        echo "<td>";
                        echo "<a href='proses_Hapus_Dompet.php?id_dompet=".$_SESSION['id_dompet']."'>Hapus</a>";
                        echo "<a ".$_SESSION['id_dompet']."'> | </a>";
                        echo "<a href='form_Edit_Dompet.php?id_dompet=".$_SESSION['id_dompet']."'>Edit</a>";
                        echo "</td>";

                        echo "</tr>";
                        
                        $counter = $counter + 1;
                    }
                }
            ?>
        </table>
        </div>
            
        <p><div>
        <table border="1">
        <thead>
            <tr>
                <th>Saldo Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $id_pengguna        = $_SESSION["id_pengguna"];
                $sql                = "SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna'";
                $result             = pg_query($db, $sql);
                $cek                = pg_num_rows($result);
                if ($cek > 0) {
                    $row = pg_fetch_assoc($result);

                    $_SESSION['saldo_total'] = $row["saldo_total"];

                    echo "<tr>";
                    echo "<td>".$_SESSION["saldo_total"]."</td>";
                    echo "</tr>";
                    
                }
            ?>
        </tbody>
        </table>
        </div></p>

        <p><a href="form_Tambah_Transaksi.php">[+] Tambah Transaksi</a></p>

    </body>
</html>