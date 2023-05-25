<?php
    include("config.php");

    session_start();
?>

<?php if (isset($_SESSION['masuk'])): ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Manage Money</title>
    </head>
    <body>
        <h1>Manage Money</h1>
        <a href="keluar.php"><button class="button">Keluar?</button></a>
        <a href="saya_Profil.php"><button class="button">Profil Saya</button></a>
        <a href="saya_Dompet.php"><button class="button">Dompet Saya</button></a>
        <a href="saya_Transaksi.php"><button class="button">Transaksi Saya</button></a>
        <?php
            $id_pengguna = $_SESSION['id_pengguna'];
            $buatdompet = "SELECT id_dompet FROM dompet WHERE id_pengguna = $id_pengguna";
            $resultdompet = pg_query($db, $buatdompet);

            $buatbulan = "SELECT EXTRACT(YEAR FROM bulan) AS tahun, EXTRACT(MONTH FROM bulan) AS bulan FROM total_transaksi WHERE id_pengguna = $id_pengguna";
            $resultbulan = pg_query($db, $buatbulan);

            $dompetRow = pg_fetch_assoc($resultdompet);
            
            if (($dompetRow) && ($bulanRow = pg_fetch_assoc($resultbulan))) {
                $idDompet = $dompetRow['id_dompet'];
                $tahun = $bulanRow['tahun'];
                $bulan = $bulanRow['bulan'];
                echo "<a href='saya_Rencana.php?id_dompet=" . $idDompet . "&bulan=" . $tahun . "-" . $bulan . "'><button class='button'>Rencana Saya</button></a>";
            } elseif ( $dompetRow ) {
                $idDompet = $dompetRow['id_dompet'];
                echo "<a href='saya_Transaksi.php'><button class='button'>Rencana Saya</button></a>";
            } else {
                echo "<a href='saya_Dompet.php'><button class='button'>Rencana Saya</button></a>";
            }
            
        ?>
        <a href="saya_laporan.php"><button class="button">Laporan Saya</button></a>
    </body>
    </html>


<?php else: ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Manage Money</title>
        </head>
            <h1>Manage Money</h1>
            <a href="masuk.php"><button class="button">Profil Saya</button></a>
            <a href="masuk.php"><button class="button">Dompet Saya</button></a>
            <a href="masuk.php"><button class="button">Transaksi Saya</button></a>
            <a href="masuk.php"><button class="button">Rencana Saya</button></a>
            <a href="masuk.php"><button class="button">Laporan Saya</button></a>
        </body>
    </html>

<?php endif; ?>