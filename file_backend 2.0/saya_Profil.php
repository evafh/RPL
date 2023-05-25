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
        <title>Manage Money - Profil Saya</title>
    </head>

    <body>
    <a href="index.php"><button class="button">Halaman Utama</button></a>
    <a href="saya_Dompet.php"><button class="button">Dompet Saya</button></a>
    
    <div class="profil">
        <table border="1">
        <h2>Profil Saya</h2>
            <thead>
                <tr>
                    <th>Nama Pengguna</th>  
                    <th>Email</th>  
                </tr>
            </thead>
            <tbody>
                <?php
                    $id_pengguna    = $_SESSION["id_pengguna"];
                    $sql            = "SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna'";
                    $result         = pg_query($db, $sql);
                    $cek            = pg_num_rows($result);
                    $counter        = 0;
                    while($counter < $cek){
                        if ($cek > 0) {
                            $row = pg_fetch_assoc($result);

                            $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
                            $_SESSION["email"] = $row["email"];

                            echo "<tr>";

                            echo "<td>".$_SESSION["nama_pengguna"]."</td>";
                            echo "<td>".$_SESSION["email"]."</td>";

                            echo "</tr>";
                            
                            $counter = $counter + 1;
                            }
                    }
                ?>
            </tbody>
        </table>
        </div>

        <div class="dompet">    
        <table border="1">
        <h2>Data Dompet</h2>
        <nav>
            <a href="form_Tambah_Dompet.php">[+] Tambah Dompet</a>
        </nav>
        <thead>
            <tr>
                <th>Nama Dompet</th>  
                <th>Saldo</th>  
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

                        $_SESSION['nama_dompet'] = $row['nama_dompet'];
                        $_SESSION['saldo'] = $row["saldo"];

                        echo "<tr>";

                        echo "<td>".$_SESSION["nama_dompet"]."</td>";
                        echo "<td>".$_SESSION["saldo"]."</td>";

                        echo "</tr>";
                        
                        $counter = $counter + 1;
                    }
                }
            ?>
        </table>
        </div>
            
        <div>
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
        </div>

        <a href="form_Tambah_Transaksi.php">[+] Tambah Transaksi</a>
        
    </body>
</html>