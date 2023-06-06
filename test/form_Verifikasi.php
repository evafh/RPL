<!DOCTYPE html>
<html>
<head>
	<title>Manage Money - Verifikasi Akun</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Athiti:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					fontFamily: {
						sans: ['Athiti'],
					}
				}
			}
		}
	</script>
</head>
<body class="bg-green-800">
	<div class="grid h-screen place-items-center">
		<div class="bg-violet-50 p-20 w-[40%] h-4/5 rounded-[48px] drop-shadow-2xl">
			<img class="w-40 h-40 mx-auto mb-10" src="https://cdn.icon-icons.com/icons2/2741/PNG/512/cloud_two_step_verification_icon_175852.png" alt="Verification">
			<h1 class="text-center text-5xl mb-10">Verifikasi Akun</h1>
			<p class="mx-7 text-2xl text-center">Silakan masukkan kode verifikasi yang telah dikirimkan ke email Anda.</p>
			<form class="mx-7 flex flex-col items-center" method="post" action="proses_Verifikasi.php">
				<input class="mt-5 px-2 text-2xl w-32 rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" type="text" name="kode_verifikasi" required><br><br>
				<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
				<input class="px-7 py-3 hover:cursor-pointer hover:bg-green-900 text-3xl rounded-2xl shadow-lg bg-green-800 text-white" type="submit" name="submit" value="Verifikasi">
			</form>
		</div>
	</div>
	
</body>
</html>
