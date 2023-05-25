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
        <title>Manage Money - Tambah Transaksi</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h2>Transaksi</h2>
            <form method="post" action="proses_Tambah_Transaksi.php">

                <div class="Tambah_Transaksi-field">
                    <label for="jumlah_transaksi">Jumlah: </label>
                    <input type="text" name="jumlah_transaksi" autofocus required pattern="([1-9])[0-9]{2,20}">
                </div>

                <div class="Tambah_Transaksi-field">
                    <label for="jenis_transaksi">Jenis Transaksi: </label>
                    <input type="radio" name="jenis_transaksi" value="Pemasukan" required> Pemasukan 
                    <input type="radio" name="jenis_transaksi" value="Pengeluaran" required> Pengeluaran 
                </div>

                <select id="pilihan_pengeluaran" name="pilihan_pengeluaran" style="display: none;" required>
                    <option disabled selected value="holder">Kategori Transaksi: </opyion>
                    <?php
                        while($row = pg_fetch_assoc($pengeluaran)) {
                            echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
                        }
                    ?>
                </select>

                <select id="pilihan_pemasukan" name="pilihan_pemasukan" style="display: none;" required>
                    <option disabled selected value="holder">Kategori Transaksi: </opyion>
                    <?php
                        while($row = pg_fetch_assoc($pemasukan)) {
                            echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
                        }
                    ?>
                </select>
                
                <div class="Tambah_Transaksi-field">
                    <label for="tanggal_transaksi">Tanggal Transaksi: </label>
                    <input type="date" name="tanggal_transaksi" required>
                </div>

                <div class="Tambah_Transaksi-field">
                    <label for="catatan_transaksi">Catatan: </label>
                    <textarea name="catatan_transaksi"></textarea>
                </div>

                <div class="Tambah_Transaksi-field">
                    <label for="id_dompet">Dompet: </label>
                        <select name="id_dompet" id="id_dompet" required>
                        <option disabled selected value="holder">Pilih Dompet</opyion>
                        <?php
                            while($row = pg_fetch_assoc($dompet)) {
                                echo "<option value=".$row['id_dompet'].">".$row['nama_dompet']."</option>";
                            }
                        ?>
                        </select>
                </div>
                <input type="submit" value="Tambah" name="submit">
            </form>
            <script>
            // Mendapatkan referensi ke radio button dan select dropdown
            var radioButtons        = document.getElementsByName('jenis_transaksi');
            var dropdownTransaksi   = document.getElementById('pilihan_pengeluaran');
            var dropdownPemasukan   = document.getElementById('pilihan_pemasukan');

            // Tambahkan event listener pada setiap radio button
            for (var i = 0; i < radioButtons.length; i++) {
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
    </body>
</html>