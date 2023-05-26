<!DOCTYPE html>
<html>
<head>
	<title>Manage Money - Reset Kata Sandi</title>
</head>
<body>
	<h1>Reset Kata Sandi</h1>
	<form method="post" action="proses_Reset_Kata_Sandi.php">
		<div class="Reset_Kata_Sandi-field">
			<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" readonly>
		</div>
		
		<label>Kata Sandi Baru:</label>

		<div class="Reset_Kata_Sandi-field">
			<p>
			<label for="kata_sandi">Kata Sandi</label>
			<input type="password" id="kata_sandi" name="kata_sandi" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,225}" autocomplete="off" title="Password harus berisi minimal 8 atau lebih karakter yang mengandung satu angka, satu huruf kapital, dan satu huruf kecil.">
			</p>
		</div>

		<div class="Reset_Kata_Sandi-field">
			<p>
			<label for="konfirmasi_kata_sandi">Konfirmasi Password</label>
			<input type="password" id="konfirmasi_kata_sandi" name="konfirmasi_kata_sandi" required autocomplete="off">
			</p>
		</div>

		<div class="Reset_Kata_Sandi-field">
			<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
		</div>

		<input type="submit" name="submit" value="Kirim">
	</form>
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
