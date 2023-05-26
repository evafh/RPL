<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_pengguna    = $_SESSION["id_pengguna"];
    $result         = "SELECT * FROM dompet WHERE id_pengguna='$id_pengguna'";
    $dompet         = pg_query($db, $result);
  
    $pengeluaran    = pg_query("SELECT * FROM tipe_pengeluaran");
    $pemasukan      = pg_query("SELECT * FROM tipe_pemasukan");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Money - Transaksi Saya</title>

</head>
<body>
    <p><a href="index.php"><button class="button">Halaman Utama</button></a></p>
    <h1>Transaksi Saya</h1>
    <p><input type="checkbox" name="form" value="Filter" >Filter </p>

    <form method="GET" id="form-filter" style="display: none;"> 
    <label for="id_dompet">Dompet: </label>
    <select name="id_dompet" id="id_dompet">
    <option value=""></option>
    <?php
        while($row = pg_fetch_assoc($dompet)) {
            echo "<option value=".$row['id_dompet'].">".$row['nama_dompet']."</option>";
        }
    ?>
    </select>
    
    <div class="Tambah_Transaksi-field">
        <label for="jenis_transaksi">Jenis Transaksi: </label>
        <input type="radio" name="jenis_transaksi" value="Pemasukan" > Pemasukan 
        <input type="radio" name="jenis_transaksi" value="Pengeluaran"> Pengeluaran 
    </div>

    <select id="pilihan_pengeluaran" name="pilihan_pengeluaran" style="display: none;" >
        <option value=""> </opyion>
        <?php
            while($row = pg_fetch_assoc($pengeluaran)) {
                echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
            }
        ?>
    </select>

    <select id="pilihan_pemasukan" name="pilihan_pemasukan" style="display: none;" >
        <option value=""> </opyion>
        <?php
            while($row = pg_fetch_assoc($pemasukan)) {
                echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
            }
        ?>
    </select>

    <div class="Tambah_Transaksi-field">
        <label for="tanggal_awal">Tanggal Awal:</label>
        <input type="date" name="tanggal_awal">
        <label for="tanggal_akhir">Tanggal Akhir:</label>
        <input type="date" name="tanggal_akhir">
    </div>
    
    <div class="Tambah_Transaksi-field">
        <label for="jumlah_min">Jumlah Minimum:</label>
        <input type="number" name="jumlah_min">
        <label for="jumlah_max">Jumlah Maksimum:</label>
        <input type="number" name="jumlah_max">
    </div>

    <div class="Tambah_Transaksi-field">
        <button name="submit" type="submit">Filter</button>
    </div>
    
  </form>

  <a href="form_Tambah_Transaksi.php">[+] Tambah Transaksi</a>

  <div id="tabel-container">
    <?php
        // Periksa apakah ada filter kategori yang diberikan
        $filter = "";
        if (isset($_GET['id_dompet'])) {
            $id_dompet = $_GET['id_dompet'];
            if (!empty($id_dompet)) {
                $filter = " AND transaksi.id_dompet = '$id_dompet'";
            }
        }
    
        // Periksa apakah ada filter jenis transaksi yang diberikan
        if (isset($_GET['jenis_transaksi'])) {
            $jenis_transaksi = $_GET['jenis_transaksi'];
            if (!empty($jenis_transaksi)) {
                if ($jenis_transaksi == 'Pemasukan') {
                    $pilihan_transaksi = $_GET['pilihan_pemasukan'];
                    $filter .= " AND transaksi.jenis_transaksi = '$jenis_transaksi'";
                    if (!empty($pilihan_transaksi)) {
                        $filter .= " AND transaksi.jenis_transaksi = '$jenis_transaksi' AND transaksi.kategori_transaksi = '$pilihan_transaksi'";
                    }
                } elseif ($jenis_transaksi == 'Pengeluaran') {
                    $pilihan_transaksi = $_GET['pilihan_pengeluaran'];
                    $filter .= " AND transaksi.jenis_transaksi = '$jenis_transaksi'";
                    if (!empty($pilihan_transaksi)) {
                        $filter .= " AND transaksi.jenis_transaksi = '$jenis_transaksi' AND transaksi.kategori_transaksi = '$pilihan_transaksi'";
                    }
                }
            }
        }

        $filter_tanggal = "";
        if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
            $tanggal_awal = $_GET['tanggal_awal'];
            $tanggal_akhir = $_GET['tanggal_akhir'];
            if (!empty($tanggal_awal) || !empty($tanggal_akhir)) {
                // Tambahkan filter rentang tanggal ke query
                $filter_tanggal = " AND transaksi.tanggal_transaksi >= '$tanggal_awal' AND transaksi.tanggal_transaksi <= '$tanggal_akhir'";
            }
        }

        $filter_jumlah = "";
        if (isset($_GET['jumlah_min']) && isset($_GET['jumlah_max'])) {
            $jumlah_min = $_GET['jumlah_min'];
            $jumlah_max = $_GET['jumlah_max'];
            if (!empty($jumlah_min) && !empty($jumlah_max)) {
                // Tambahkan filter jumlah transaksi ke query
                $filter_jumlah = " AND transaksi.jumlah_transaksi >= $jumlah_min AND transaksi.jumlah_transaksi <= $jumlah_max";
            }
            else if (!empty($jumlah_min)){
                $jumlah_max = 999999999999999999999999999999;
                $filter_jumlah = " AND transaksi.jumlah_transaksi >= $jumlah_min AND transaksi.jumlah_transaksi <= $jumlah_max";
            }
            else if (!empty($jumlah_max)) {
                $jumlah_min = 0;
                $filter_jumlah = " AND transaksi.jumlah_transaksi >= $jumlah_min AND transaksi.jumlah_transaksi <= $jumlah_max";
            }
        }
    
        // Query untuk mengambil data dari database dengan filter
        $query = "SELECT * FROM transaksi 
                INNER JOIN dompet ON transaksi.id_dompet = dompet.id_dompet 
                WHERE transaksi.id_pengguna='$id_pengguna'" . $filter . $filter_tanggal . $filter_jumlah;
        $result = pg_query($db, $query);
    
        // Tampilkan data dalam tabel HTML
        echo "<table>
            <tr>
            <th>Dompet</th>
            <th>Tanggal Transaksi</th>
            <th>Jumlah Transaksi</th>
            <th>Jenis Transaksi</th>
            <th>Kategori Transaksi</th>
            <th>Catatan Transaksi</th>
            <th>Tindakan</th>
            </tr>";
    
        while ($row = pg_fetch_assoc($result)) {
            // Menampilkan data transaksi sesuai dengan kebutuhan
            $query_tipe = "SELECT nama_tipe FROM tipe_transaksi WHERE id_tipe = '".$row['kategori_transaksi']."'";
            $result_tipe = pg_query($db, $query_tipe);
            $tipe = pg_fetch_assoc($result_tipe);
    
            echo "<tr>
                    <td>" . $row['nama_dompet'] . "</td>
                    <td>" . $row['tanggal_transaksi'] . "</td>
                    <td>" . $row['jumlah_transaksi'] . "</td>
                    <td>" . $row['jenis_transaksi'] . "</td>
                    <td>" . $tipe['nama_tipe'] . "</td>
                    <td>" . $row['catatan_transaksi'] . "</td>
                    <td>
                    <a href='proses_Hapus_Transaksi.php?id_transaksi=".$row['id_transaksi']."'>Hapus</a> |
                    <a href='form_Edit_Transaksi.php?id_transaksi=".$row['id_transaksi']."'>Edit</a>
                    </td>
                </tr>";
        }
    
        echo "</table>";
    ?>
  </div>
  <script>
  // Mendapatkan referensi ke radio button dan select dropdown
  var radioButtons_jenis_transaksi        = document.getElementsByName('jenis_transaksi');
  var dropdownTransaksi                   = document.getElementById('pilihan_pengeluaran');
  var dropdownPemasukan                   = document.getElementById('pilihan_pemasukan');
  var radioButtons_jenis_transaksi        = document.getElementsByName('jenis_transaksi');
  var formFilter = document.getElementById('form-filter');

  // Tambahkan event listener pada setiap radio button
  for (var i = 0; i < radioButtons_jenis_transaksi.length; i++) {
      radioButtons[i].addEventListener('change', function() {
      if (this.value === 'Pengeluaran') {
          dropdownTransaksi.style.display = 'block'; 
      } else {
          dropdownTransaksi.style.display = 'none'
      }
      if (this.value === 'Pemasukan'){
          dropdownPemasukan.style.display = 'block';  
      } else {
          dropdownPemasukan.style.display = 'none'
      }
      });
  }
  </script>
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