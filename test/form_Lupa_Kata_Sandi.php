<!DOCTYPE html>
<html>
<head>
	<title>Manage Money - Lupa Kata Sandi</title>
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
		<div class="bg-violet-50 p-20 w-1/3 h-3/5 rounded-[48px] drop-shadow-2xl">
			<h1 class="text-center text-5xl mb-10">Reset Kata Sandi</h1>
			<p class="mx-7 text-2xl text-center">Email yang digunakan</p>
			<form class="mx-7 flex flex-col items-center" method="post" action="proses_Lupa_Kata_Sandi.php">
				<input class="mt-5 px-2 text-xl w-64 rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" type="email" name="email" required><br><br>
				<input class="px-7 py-3 hover:cursor-pointer hover:bg-green-900 text-3xl rounded-2xl shadow-lg bg-green-800 text-white" type="submit" name="submit" value="Reset Password">
			</form>
		</div>
	</div>
	
</body>
</html>
