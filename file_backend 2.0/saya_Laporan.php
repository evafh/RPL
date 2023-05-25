<?php
    include("config.php");

    session_start();
    if (!isset($_SESSION["masuk"])) {
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
            $filter = " AND total_transaksi.id_dompet = '$id_dompet'";
        }
    }

    // Filter bulan
    $filter_tanggal = "";
    if (isset($_GET['bulan'])) {
        $bulan = $_GET['bulan'];
        if (!empty($bulan)) {
            // Ubah format bulan menjadi YYYY-MM
            $bulan_tahun = date('Y-m', strtotime($bulan));
            $filter_tanggal = " AND DATE_TRUNC('month', total_transaksi.bulan) = DATE_TRUNC('month', DATE '$bulan_tahun-01')";
        }
    }

    // Query untuk mengambil data dari database dengan filter
    $query = "SELECT * FROM total_transaksi 
              INNER JOIN dompet ON total_transaksi.id_dompet = dompet.id_dompet 
              WHERE total_transaksi.id_pengguna='$id_pengguna'" . $filter . $filter_tanggal;
    $result = pg_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Money - Laporan Saya</title>

</head>
<body>
    <p><a href="index.php"><button class="button">Halaman Utama</button></a></p>
    <h1>Laporan Saya</h1>
    <p><input type="checkbox" name="form" value="Filter">Filter </p>

    <form method="GET" id="form-filter" style="display: none;"> 

    <div class="filter-field">
    <label for="id_dompet">Dompet: </label>
    <select name="id_dompet" id="id_dompet">
    <option value=""></option>
    <?php
        while($row = pg_fetch_assoc($dompet)) {
            echo "<option value=".$row['id_dompet'].">".$row['nama_dompet']."</option>";
        }
    ?>
    </select>
    </div>

    <div class="filter-field">
        <label for="bulan">Bulan</label>
        <input type="month" min="01" max="12" name="bulan" required>
    </div>

    <div class="filter-field">
        <button name="submit" type="submit">Filter</button>
    </div>
    
  </form>

  <div id="tabel-container">
        <table>
            <table border="1">
            <tr>
                <th>Dompet</th>
                <th>Total Pemasukan</th>
                <th>Total Pengeluaran</th>
            </tr>
    <?php
        // Tampilkan data dalam tabel HTML

        while ($row = pg_fetch_assoc($result)) {
            // Menampilkan data transaksi sesuai dengan kebutuhan
            echo "<tr>
                    <td>" . $row['nama_dompet'] . "</td>
                    <td>" . $row['total_pemasukan'] . "</td>
                    <td>" . $row['total_pengeluaran'] . "</td>
                </tr>";
        }

        echo "</table>";
    ?>
  </div>
  <script>
  var checkboxes = document.getElementsByName('form');
  var formFilter = document.getElementById('form-filter');

  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function() {
      if (this.checked && this.value === 'Filter') {
        formFilter.style.display = 'block';
      } else {
        formFilter.style.display = 'none';
      }
    });
  }
</script>

</body>
</html>


