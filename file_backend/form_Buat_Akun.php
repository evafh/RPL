<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Buat Akun</title>
    </head>
    <body>
        <h1>Buat Akun</h1>
        <form action="proses_Buat_Akun.php" method="post" id="buat_Akun">
            
            <div class="buat_Akun-field">
                <label for="nama_pengguna">Nama Pengguna</label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" autofocus pattern="[a-z\s]+{1,128}" required>
                <br>Contoh: bingo123
            </div>

            <div class="buat_Akun-field">
                <p>
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Email tidak valid!">
                <br>Contoh: bingo@gmail.com
                </p>
            </div>

            <div class="buat_Akun-field">
                <p>
                <label for="kata_sandi">Kata Sandi</label>
                <input type="password" id="kata_sandi" name="kata_sandi" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,225}" autocomplete="off" title="Password harus berisi minimal 8 atau lebih karakter yang mengandung satu angka, satu huruf kapital, dan satu huruf kecil.">
                </p>
            </div>

            <div class="buat_Akun-field">
                <p>
                <label for="konfirmasi_kata_sandi">Konfirmasi Password</label>
                <input type="password" id="konfirmasi_kata_sandi" name="konfirmasi_kata_sandi" required autocomplete="off">
                </p>
            </div>

            <a href="form_Verifikasi.php"><input type="submit" name="submit" value="Register"></a>

        </form>

        <p>Sudah Memiliki Akun? <a href="masuk.php">Masuk</a></p>

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