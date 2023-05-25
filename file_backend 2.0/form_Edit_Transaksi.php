<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_transaksi   = $_GET['id_transaksi'];
    $query 		    = pg_query($db, "SELECT * FROM transaksi WHERE id_transaksi=$id_transaksi");
    $transaksi 		= pg_fetch_array($query);

    $id_pengguna    = $_SESSION["id_pengguna"];
	$result         = "SELECT * FROM dompet WHERE id_pengguna='$id_pengguna'";
	$dompet         = pg_query($db, $result);

    $pengeluaran    = pg_query("SELECT * FROM tipe_pengeluaran");
    $pemasukan      = pg_query("SELECT * FROM tipe_pemasukan");
    function active_radio_button($value,$input){
        $result =  $value==$input?'checked':'';
        return $result;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Edit Transaksi</title>
    </head>
    <body>
        <a href="index.php"><button class="button">Halaman Utama</button></a>
        <h2>Transaksi</h2>
            <form method="post" action="proses_Edit_Transaksi.php?id_transaksi=<?php echo $transaksi['id_transaksi'];?>">

                <div class="Edit_Transaksi-field">
                    <label for="jumlah_transaksi">Jumlah: </label>
                    <input type="text" value="<?php echo $transaksi['jumlah_transaksi'];?>" name="jumlah_transaksi" autofocus required pattern="([1-9])[0-9]{2,20}">
                </div>

                <div class="Edit_Transaksi-field">
                    <label for="jenis_transaksi">Jenis Transaksi: </label>
                    <input type="radio" name="jenis_transaksi" value="Pemasukan" <?php echo active_radio_button("Pemasukan", $transaksi['jenis_transaksi'])?> required> Pemasukan 
                    <input type="radio" name="jenis_transaksi" value="Pengeluaran" <?php echo active_radio_button("Pengeluaran", $transaksi['jenis_transaksi'])?> required> Pengeluaran 
                </div>

                <select id="pilihan_pengeluaran" value="<?php echo $transaksi['kategori_transaksi'];?>" name="pilihan_pengeluaran" style="display: none;" required>
                    <option disabled selected value="holder">Kategori Transaksi: </option>
                    <?php
                        while($row = pg_fetch_assoc($pengeluaran)) {
                            $selected = ($row['id_tipe_transaksi'] == $transaksi['kategori_transaksi']) ? 'selected' : '';
                            echo "<option value=".$row['id_tipe_transaksi']." $selected>".$row['nama_tipe']."</option>";
                        }
                    ?>
                </select>

                <select id="pilihan_pemasukan" value="<?php echo $transaksi['kategori_transaksi'];?>" name="pilihan_pemasukan" style="display: none;" required>
                    <option disabled selected value="holder">Kategori Transaksi: </option>
                    <?php
                        while($row = pg_fetch_assoc($pemasukan)) {
                            $selected = ($row['id_tipe_transaksi'] == $transaksi['kategori_transaksi']) ? 'selected' : '';
                            echo "<option value=".$row['id_tipe_transaksi']." $selected>".$row['nama_tipe']."</option>";
                        }
                    ?>
                </select>
                
                <div class="Edit_Transaksi-field">
                    <label for="tanggal_transaksi">Tanggal Transaksi: </label>
                    <input type="date" name="tanggal_transaksi" value="<?php echo $transaksi['tanggal_transaksi'];?>"required>
                </div>

                <div class="Edit_Transaksi-field">
                    <label for="catatan_transaksi">Catatan: </label>
                    <textarea name="catatan_transaksi"><?php echo $transaksi['catatan_transaksi'];?></textarea>
                </div>

                <div class="Edit_Transaksi-field">
                    <label for="id_dompet">Dompet: </label>
                        <select name="id_dompet" id="id_dompet" required>
                        <option disabled selected value="holder">Pilih Dompet</option>
                        <?php
                            while($row = pg_fetch_assoc($dompet)) {
                                $selected = ($row['id_dompet'] == $transaksi['id_dompet']) ? 'selected' : '';
                                echo "<option value=".$row['id_dompet']." $selected>".$row['nama_dompet']."</option>";
                            }
                        ?>
                        
                        </select>
                </div>
                <input type="submit" value="Simpan" name="submit">
            </form>
            <script>
            // Mendapatkan referensi ke radio button dan select dropdown
            var radioButtons        = document.getElementsByName('jenis_transaksi');
            var dropdownTransaksi   = document.getElementById('pilihan_pengeluaran');
            var dropdownPemasukan   = document.getElementById('pilihan_pemasukan');

            if (radioButtons[0].checked) {
                dropdownPemasukan.style.display = 'block';  // Menampilkan dropdown jika pilihan 2 dipilih
            } else {
                dropdownTransaksi.style.display = 'block';   // Menyembunyikan dropdown untuk pilihan lainnya
            }

            // Editkan event listener pada setiap radio button
            for (var i = 0; i < radioButtons.length; i++) {
                radioButtons[i].addEventListener('change', function() {
                if (this.value === 'Pengeluaran') {
                    dropdownTransaksi.style.display = 'block';
                    dropdownPemasukan.style.display = 'none'
                } else {
                    dropdownTransaksi.style.display = 'none'
                    dropdownPemasukan.style.display = 'block';  
                }
                });
            }
            </script>
    </body>
</html>