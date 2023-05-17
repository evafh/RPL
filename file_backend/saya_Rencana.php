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
  <title>Manage Money - Rencana Saya</title>
</head>
<body>

    <div>
        <h3>Pengeluaran</h3>
        <table border="1">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Anggaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $id_pengguna           = $_SESSION["id_pengguna"];
                $sql_pengeluaran       = "SELECT * FROM tipe_pengeluaran";
                $result_pengeluaran    = pg_query($db, $sql_pengeluaran);
                $cek_pengeluaran       = pg_num_rows($result_pengeluaran);
                $counter_pengeluaran   = 0;
                while ($counter_pengeluaran < $cek_pengeluaran){
                    if ($cek_pengeluaran > 0) {
                        $row_pengeluaran = pg_fetch_assoc($result_pengeluaran);
                        echo "<tr>";
                        echo "<td>".$row_pengeluaran["nama_tipe"]."</td>";
                        echo "<td>";
                        echo "<a href='form_Tambah_Anggaran.php?id_tipe=".$row_pengeluaran['id_tipe']."'>[+]</a>";
                        echo "</td>";
                        echo "</tr>";
                        $counter_pengeluaran = $counter_pengeluaran + 1;
                    }
                }
            ?>
        </tbody>
        </table>
    </div>

</body>
</html>