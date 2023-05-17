<?php
    include("config.php");

    session_start();
?>

<?php if (isset($_SESSION['id_pengguna'])): ?>

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
            <a href="saya_Rencana.php"><button class="button">Rencana Saya</button></a>
            <a href="saya_laporan.php"><button class="button">Laporan Saya</button></a>
        </body>
    </html>

<?php else: ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Manage Money</title>
        </head>
        <body>
            <h1>Manage Money</h1>
            <a href="masuk.php"><button class="button">Profil Saya</button></a>
            <a href="masuk.php"><button class="button">Dompet Saya</button></a>
            <a href="masuk.php"><button class="button">Transaksi Saya</button></a>
            <a href="masuk.php"><button class="button">Rencana Saya</button></a>
            <a href="masuk.php"><button class="button">Laporan Saya</button></a>
        </body>
    </html>

<?php endif; ?>