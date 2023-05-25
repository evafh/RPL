<?php
include("config.php");

if(isset($_POST['submit'])){

	$email 					= $_POST['email'];
	$kata_sandi 			= md5($_POST['kata_sandi']);
	$konfirmasi_kata_sandi 	= md5($_POST['konfirmasi_kata_sandi']);
	$token 					= $_POST['token'];

	$sql 					= "SELECT * FROM pengguna WHERE email='$email' AND token_reset='$token'";
	$result 				= pg_query($db, $sql);
	$cek 					= pg_num_rows($result);

	if ($cek > 0) {
			$row = pg_fetch_assoc($result);

			$query = "UPDATE pengguna SET kata_sandi='$kata_sandi', token_reset=NULL WHERE email='$email'";
			$result = pg_query($db, $query);

			header("Location: masuk.php");
			
	} else {
		echo "Token reset password tidak valid.";
	}

} else {
	die("Akses dilarang...");
}

?>
