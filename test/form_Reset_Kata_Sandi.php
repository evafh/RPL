<!DOCTYPE html>
<html>
<head>
	<title>Manage Money - Reset Kata Sandi</title>
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
		<div class="bg-violet-50 p-20 w-[40%] h-3/5 rounded-[48px] drop-shadow-2xl">
			<h1 class="text-center text-5xl mb-10">Reset Kata Sandi</h1>
			<form class="mx-7 flex flex-col items-center" method="post" action="proses_Reset_Kata_Sandi.php">
				<div class="Reset_Kata_Sandi-field">
					<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" readonly>
				</div>

				<div class="Reset_Kata_Sandi-field mt-5">
					<p class="text-xl">Kata sandi baru:</p>
					<p>
					<input class="px-2 text-2xl w-64 rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" type="password" id="kata_sandi" name="kata_sandi" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,225}" autocomplete="off" title="Password harus berisi minimal 8 atau lebih karakter yang mengandung satu angka, satu huruf kapital, dan satu huruf kecil.">
					</p>
				</div>

				<div class="Reset_Kata_Sandi-field mt-5">
					<p class="text-xl">Konfirmasi kata sandi baru:</p>
					<p>
					<input class=" px-2 text-2xl w-64 rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" type="password" id="konfirmasi_kata_sandi" name="konfirmasi_kata_sandi" required autocomplete="off">
					</p>
					<br>
					<br>
				</div>

				<div class="Reset_Kata_Sandi-field">
					<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
				</div>

				<input class="px-7 py-3 hover:cursor-pointer hover:bg-green-900 text-3xl rounded-2xl shadow-lg bg-green-800 text-white" type="submit" name="submit" value="Reset Kata Sandi">
			</form>
		</div>
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
