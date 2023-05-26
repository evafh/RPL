<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_pengguna = $_SESSION["id_pengguna"];
    $result = "SELECT * FROM dompet WHERE id_pengguna='$id_pengguna'";
    $dompet = pg_query($db, $result);

    $pengeluaran = pg_query("SELECT * FROM tipe_pengeluaran");
    $pemasukan = pg_query("SELECT * FROM tipe_pemasukan");

    $filter = "";
    if (isset($_GET['id_dompet'])) {
        $id_dompet = $_GET['id_dompet'];
        if (!empty($id_dompet)) {
            $filter = " AND anggaran.id_dompet = '$id_dompet'";
        }
    }

    // Filter bulan
    $filter_tanggal = "";
    if (isset($_GET['bulan'])) {
        $bulan = $_GET['bulan'];
        if (!empty($bulan)) {
            // Ubah format bulan menjadi YYYY-MM
            $bulan_tahun = date('Y-m', strtotime($bulan));
            $filter_tanggal = " AND DATE_TRUNC('month', anggaran.bulan) = DATE_TRUNC('month', DATE '$bulan_tahun-01')";
        }
    }



    // Query untuk mengambil data dari database dengan filter
    $query = "SELECT * FROM anggaran 
               INNER JOIN dompet ON anggaran.id_dompet = dompet.id_dompet 
               WHERE anggaran.id_pengguna='$id_pengguna'" . $filter . $filter_tanggal;
    $result = pg_query($db, $query);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Money - Rencana Saya</title>
</head>


<body>
    <p><a href="index.php"><button class="button">Halaman Utama</button></a></p>
    <div>
        <h1>Rencana Saya</h1>
    </div>

    <p><div>
        <form method="GET" id="form-filter"> 
        <label for="id_dompet">Dompet: </label>
        <select name="id_dompet" id="id_dompet" value="<?php echo $_GET['id_dompet']; ?>" required>
        <?php
            while($row = pg_fetch_assoc($dompet)) {
                echo "<option value=".$row['id_dompet'].">".$row['nama_dompet']."</option>";
            }
        ?>
        </select>
        <label for="bulan">Bulan</label>
        <input type="month" min="01" max="12" name="bulan" value="<?php echo $_GET['bulan']; ?>" required>
        <button name="submit" type="submit">Show</button>
        </form>
    </div></p>

    <p><div>
    <label for="total_anggaran"> Total Anggaran : </label>
        <?php
            $dompet = $_GET['id_dompet'];
            $bulan = $_GET['bulan'];
            $query_total_anggaran = "SELECT * FROM total_anggaran WHERE id_dompet=$dompet AND bulan='$bulan-01'";
            $result_total_anggaran = pg_query($db, $query_total_anggaran);
            if($row_total_anggaran = pg_fetch_assoc($result_total_anggaran)){
                echo $row_total_anggaran["nominal_anggaran"];
            } else {
                echo "0";
            }
        ?>
    </div>

    <div>
        <label for="total_pengeluaran"> Total Pengeluaran : </label>
        <?php
            $dompet = $_GET['id_dompet'];
            $bulan = $_GET['bulan'];
            $query_total_pengeluaran = "SELECT * FROM total_transaksi WHERE id_dompet=$dompet AND bulan='$bulan-01'";
            $result_total_pengeluaran = pg_query($db, $query_total_pengeluaran);
            if($row_total_pengeluaran = pg_fetch_assoc($result_total_pengeluaran)){
                echo $row_total_pengeluaran["total_pengeluaran"];
            } else {
                echo "0";
            }
        ?>
    </div>

    <div>
        <label for="sisa_anggaran"> Sisa Anggaran : </label>
        <?php
            $dompet = $_GET['id_dompet'];
            $bulan = $_GET['bulan'];
            $query_total_pengeluaran = "SELECT * FROM total_transaksi WHERE id_dompet=$dompet AND bulan='$bulan-01'";
            $result_total_pengeluaran = pg_query($db, $query_total_pengeluaran);
            $query_total_anggaran = "SELECT * FROM total_anggaran WHERE id_dompet=$dompet AND bulan='$bulan-01'";
            $result_total_anggaran = pg_query($db, $query_total_anggaran);
            if(($row_total_anggaran = pg_fetch_assoc($result_total_anggaran)) && ($row_total_pengeluaran = pg_fetch_assoc($result_total_pengeluaran))){
                $sisa = $row_total_anggaran["nominal_anggaran"] -  $row_total_pengeluaran["total_pengeluaran"];
                echo $sisa;
            } elseif($row_total_anggaran = pg_fetch_assoc($result_total_anggaran)) {
                echo $row_total_anggaran["nominal_anggaran"];
            } elseif($row_total_pengeluaran = pg_fetch_assoc($result_total_pengeluaran)){
                echo "-";
                echo $row_total_pengeluaran['total_pengeluaran'];
            }
        ?>
    </div></p>

<div id="tabel-container">
        <table id="tabel-pengeluaran" border="1">
            <tr>
                <th>Kategori</th>
                <th>Anggaran</th>
                <th>Tindakan</th>
            </tr>
            <?php
                if($result == TRUE){
                    while ($row_pengeluaran = pg_fetch_assoc($pengeluaran)) {

                        $idDompet = isset($_GET['id_dompet']) ? $_GET['id_dompet'] : '';
                        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
            
                        $kategori_anggaran          = $row_pengeluaran['id_tipe'];
                        $sql_anggaran               = "SELECT * FROM anggaran WHERE kategori_anggaran = $kategori_anggaran AND id_pengguna = $id_pengguna AND bulan = '$bulan-01' AND id_dompet = $idDompet";
                        $result_anggaran            = pg_query($db, $sql_anggaran);
                        $cek_anggaran               = pg_num_rows($result_anggaran);
            
                        echo "<tr>";
                            echo "<td>".$row_pengeluaran["nama_tipe"]."</td>";
                        echo "<td>";
                        
                        if ($row_anggaran = pg_fetch_assoc($result_anggaran)) {
                            // Jika ada anggaran, tampilkan jumlah anggaran
                            echo $row_anggaran["nominal_anggaran"];
                        } else {
                            // Jika tidak ada anggaran, tampilkan tanda tambah
                            echo "<a href='form_Tambah_Anggaran.php?id_tipe=" . $row_pengeluaran['id_tipe'] . "&id_dompet=" . $idDompet . "&bulan=" . $bulan . "'>[+]</a>";
                        }
                        
                        $row_anggaran = pg_fetch_assoc($result_anggaran);
                        if ($cek_anggaran){
                            echo "<td>";
                                echo "<a href='proses_Hapus_Anggaran.php?id_tipe=" . $row_pengeluaran['id_tipe'] . "&id_dompet=" . $idDompet . "&bulan=" . $bulan . "'>Hapus</a>";
                            echo "<a> | </a>";
                                echo "<a href='form_Edit_Anggaran.php?id_tipe=" . $row_pengeluaran['id_tipe'] . "&id_dompet=" . $idDompet . "&bulan=" . $bulan . "'>Edit</a>";
                            echo "</td>";
                        } else {
                            echo "<td>";
                                echo "<a href='form_Tambah_Anggaran.php?id_tipe=" . $row_pengeluaran['id_tipe'] . "&id_dompet=" . $idDompet . "&bulan=" . $bulan . "'>Hapus</a>";
                            echo "<a> | </a>";
                                echo "<a href='form_Tambah_Anggaran.php?id_tipe=" . $row_pengeluaran['id_tipe'] . "&id_dompet=" . $idDompet . "&bulan=" . $bulan . "'>Edit</a>";
                            echo "</td>"; 
                        }
                        

                    }   
                }  
            ?>
        </table>
</div>

</body>
</html>
