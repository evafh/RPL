<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Buat Akun</title>
        <link rel="stylesheet" href="../css/register.css">
    </head>
    <body class="flex">
        <div class="something-placeholder float-left">
            <div class="something-content">
                <div class="flex">
                    <img src="..\css\wallet.svg" alt="wallet" width="150" height="150" class="item-x">
                    <div class="item-x">Mamoy</div>
                </div>
                <div class="br"></div>
                <p>Manage Money (Mamoy) adalah Website pencatat dan pengatur keuangan, ini didasarkan pada kebutuhan akan alat yang efektif dalam mengelola keuangan pribadi.</p>
                <a href="index.php">Lihat fitur</a>
            </div>
        </div>

        <div class="float-right login-container">
            <br>
            <h1 class="item-y item-x">Buat Akun</h1>
            <form action="proses_Buat_Akun.php" method="post" id="buat_Akun">
                
                <!-- <div class="buat_Akun-field"> -->
                    <input class="buat_Akun-field" type="text" id="nama_pengguna" name="nama_pengguna" autofocus pattern="[a-z\s]+{1,128}" placeholder="Nama Pengguna" required>
                <!-- </div> -->

                <!-- <div class="buat_Akun-field"> -->
                    <input class="buat_Akun-field" type="text" id="email" name="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Email tidak valid!">
                <!-- </div> -->

                <!-- <div class="buat_Akun-field"> -->
                    <input class="buat_Akun-field" type="password" id="kata_sandi" name="kata_sandi" placeholder="Kata Sandi" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,225}" autocomplete="off" title="Password harus berisi minimal 8 atau lebih karakter yang mengandung satu angka, satu huruf kapital, dan satu huruf kecil.">
                <!-- </div> -->

                <!-- <div class="buat_Akun-field"> -->
                    <input class="buat_Akun-field" type="password" id="konfirmasi_kata_sandi" name="konfirmasi_kata_sandi" placeholder="Konfirmasi Kata Sandi" required autocomplete="off">
                <!-- </div> -->

                <!-- <div class="buat_Akun-submit"> -->
                    <input class="buat_Akun-submit" type="submit" name="submit" value="Register" style="color: white;">
                <!-- </div> -->

                
                
                

            </form>

            <p class="item-x">Sudah Memiliki Akun? <a href="masuk.php">Masuk</a></p>
        </div>

        <script>
            function validatePassword(){
                if(kata_sandi.value != konfirmasi_kata_sandi.value) {
                    konfirmasi_kata_sandi.setCustomValidity("Passwords Tidak Sama!");
                } else {
                    konfirmasi_kata_sandi.setCustomValidity('');
                }
            }
            kata_sandi.onchange = validatePassword;
            konfirmasi_kata_sandi.onkeyup = validatePassword;
        </script>
    </body>
</html>