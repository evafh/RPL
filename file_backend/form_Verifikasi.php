<!DOCTYPE html>
<html>
<head>
	<title>Manage Money - Verifikasi Akun</title>
</head>
<body>
	<h1>Verifikasi Akun</h1>
	<p>Silakan masukkan kode verifikasi yang telah dikirimkan ke email Anda.</p>
	<form method="post" action="proses_Verifikasi.php">
		<label>Kode Verifikasi:</label>
		<input type="text" name="kode_verifikasi" required><br><br>
		<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
		<input type="submit" name="submit" value="Verifikasi">
	</form>
</body>
</html>
