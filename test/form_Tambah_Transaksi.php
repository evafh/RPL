<?php
    include("config.php");

    session_start();
    if( !isset($_SESSION["masuk"]) ){
        header("Location: masuk.php");
        exit;
    }

    $id_pengguna    = $_SESSION["id_pengguna"];
	$result         = "SELECT * FROM dompet WHERE id_pengguna='$id_pengguna'";
	$dompet         = pg_query($db, $result);

    $pengeluaran    = pg_query("SELECT * FROM tipe_pengeluaran");
    $pemasukan      = pg_query("SELECT * FROM tipe_pemasukan");

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Money - Tambah Transaksi</title>
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
    <body>
    <div class="flex">
            <div id="Main" class="xl:rounded-r transform  xl:translate-x-0  ease-in-out transition duration-1000 flex justify-between items-start h-screen  w-1/5 bg-green-900 flex-col text-gray-100 sticky top-0">
                <div class="flex flex-col justify-start items-center w-full ">
                    <a href="index.php" class="mb-10">    
                        <div class="mx-auto flex jusitfy-start items-center w-full py-3 mt-12 space-x-3 focus:outline-none text-gray-200 rounded">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="w-20 h-20 fill-gray-200" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M47,40L47,40c0,2.762-2.238,5-5,5l0,0H6l0,0c-2.762,0-5-2.238-5-5V11
                                c0-2.209,1.791-4,4-4l0,0h20.171l8.099-2.934c0.513-0.187,1.081,0.078,1.268,0.589L35.391,7H39c2.209,0,4,1.791,4,4v2l0,0
                                c2.209,0,4,1.791,4,4V40z M5,9L5,9c-1.104,0-2,0.896-2,2s0.896,2,2,2h3.445l0,0h0.189c0.013-0.005,0.021-0.016,0.034-0.021L19.65,9
                                H5z M34.078,9.181l-1.062-2.924l-0.001,0v0L30.964,7h0.003l-5.514,2h-0.01l-11.039,4h21.062L34.078,9.181z M41,11
                                c0-1.104-0.896-2-2-2h-2.883l1.454,4H41l0,0V11z M43,15H5l0,0c-0.732,0-1.41-0.211-2-0.555V40c0,1.657,1.344,3,3,3h36
                                c1.657,0,3-1.343,3-3v-7h-4c-2.209,0-4-1.791-4-4s1.791-4,4-4h4v-8C45,15.896,44.104,15,43,15z M45,31v-4h-4c-1.104,0-2,0.896-2,2
                                s0.896,2,2,2H45z M41,28h2v2h-2V28z"/>
                            </svg>
                            <p class="text-gray-200 text-4xl pr-3 pt-1">Mamoy</p>
                        </div>
                    </a>
                    <a href="saya_Profil.php" class="flex jusitfy-start items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200">
                        <svg class="w-8 h-8 fill-gray-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 21V19C6 17.9391 6.42143 16.9217 7.17157 16.1716C7.92172 15.4214 8.93913 15 10 15H14C15.0609 15 16.0783 15.4214 16.8284 16.1716C17.5786 16.9217 18 17.9391 18 19V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-xl leading-4">Profil</p>
                    </a>
                    <a href="saya_Dompet.php" class="flex jusitfy-start items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200">
                    <svg class="w-8 h-8 fill-gray-200" viewBox="0 0 23.46 19.02" xmlns="http://www.w3.org/2000/svg">
                    <title/><g data-name="Camada 2" id="Camada_2"><g data-name="Camada 1" id="Camada_1-2">
                    <path d="M22.17,7.53V2a2,2,0,0,0-2-2H2A2,2,0,0,0,0,2V17.05a2,2,0,0,0,2,2H20.2a2,2,0,0,0,2-2V13.51a1.41,1.41,0,0,0,1.29-1.4V8.94A1.41,1.41,0,0,0,22.17,7.53ZM2,1H20.2a1,1,0,0,1,1,1v.32a1.94,1.94,0,0,0-1-.27H2a1.94,1.94,0,0,0-1,.27V2A1,1,0,0,1,2,1ZM20.2,18H2a1,1,0,0,1-1-1V4A1,1,0,0,1,2,3H20.2a1,1,0,0,1,1,1V7.52H16.46a3,3,0,0,0,0,6h4.71v3.53A1,1,0,0,1,20.2,18Zm2.26-5.92a.42.42,0,0,1-.42.42H16.46a2,2,0,0,1,0-4H22a.42.42,0,0,1,.42.42Z"/><circle cx="16.5" cy="10.42" r="0.82"/></g></g>
                    </svg>
                        <p class="text-xl leading-4">Dompet</p>
                    </a>
                    <a href="saya_Transaksi.php" class="flex jusitfy-start items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200">
                    <svg class="w-8 h-8 fill-gray-200" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g data-name="18. Bill" id="_18._Bill"><path d="M16,7h2a1,1,0,0,0,0-2H17a1,1,0,0,0-2,0v.18A3,3,0,0,0,16,11a1,1,0,0,1,0,2H14a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,16,9a1,1,0,0,1,0-2Z"/><path d="M31,24H28V3a3,3,0,0,0-3-3H3A3,3,0,0,0,0,3V9a1,1,0,0,0,1,1H4V29a3,3,0,0,0,3,3H29a3,3,0,0,0,3-3V25A1,1,0,0,0,31,24ZM2,3A1,1,0,0,1,4,3V8H2ZM8,25v4a1,1,0,0,1-.31.71A.93.93,0,0,1,7,30a1,1,0,0,1-1-1V3a3,3,0,0,0-.18-1H25a1,1,0,0,1,1,1V24H9A1,1,0,0,0,8,25Zm22,4a1,1,0,0,1-.31.71A.93.93,0,0,1,29,30H9.83A3,3,0,0,0,10,29V26H30Z"/><path d="M17,19H9a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"/><path d="M23,19H21a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"/></g></svg>
                        <p class="text-xl leading-4">Transaksi</p>
                    </a>

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
                        if($bulan < 10){
                            $bulan = "0$bulan";
                        }
                        $bulan_final = "$tahun-$bulan";
                        echo '<a href="saya_Rencana.php?id_dompet=' . $idDompet . '&bulan=' . $bulan_final . '"class="flex jusitfy-start items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200">
                        <svg class="w-8 h-8 fill-gray-200" viewBox="0 0 22.591 22.582" xmlns="http://www.w3.org/2000/svg"><g data-name="Layer 2" id="Layer_2"><g data-name="Layer 1" id="Layer_1-2"><path d="M20.705,10.611A3.548,3.548,0,0,0,19.63,6.66V3.635h2.61a.343.343,0,0,0,.342-.343A3.3,3.3,0,0,0,19.287,0H3.3A3.3,3.3,0,0,0,0,3.292V22.24a.342.342,0,0,0,.342.342H19.287a.343.343,0,0,0,.343-.342V13.729l.421.423a1.483,1.483,0,0,0,2.1-2.1Zm-.464-1.218a2.851,2.851,0,0,1-5.7,0A2.851,2.851,0,0,1,20.241,9.393ZM14.38,12.324a.343.343,0,0,0-.343.342v6.6h-1.6v-4.52A.343.343,0,0,0,12.1,14.4H9.817a.343.343,0,0,0-.342.343v4.52h-1.6V17.029a.342.342,0,0,0-.342-.342H5.254a.342.342,0,0,0-.342.342v2.238h-1.6V14.89l2.861-2.816,1.487.813a.34.34,0,0,0,.406-.059l2.154-2.152,2.2.93a.344.344,0,0,0,.392-.091L13.951,10.2a3.546,3.546,0,0,0,2.367,2.559v6.508h-1.6v-6.6A.342.342,0,0,0,14.38,12.324Zm-2.624,2.765v4.178h-1.6V15.089ZM7.193,17.371v1.9H5.6v-1.9ZM19.287.684A2.615,2.615,0,0,1,21.876,2.95H6.573A3.289,3.289,0,0,0,5.3.684ZM18.945,21.9H.684V3.292a2.611,2.611,0,0,1,5.222,0,.344.344,0,0,0,.343.343h12.7V6.223a3.55,3.55,0,0,0-5.084,3.035l-1.4,1.621-2.18-.923a.345.345,0,0,0-.376.073L7.767,12.164l-1.486-.813a.344.344,0,0,0-.4.056L3.315,13.93V5.923a.342.342,0,0,0-.684,0V19.609a.343.343,0,0,0,.342.343H16.661A.343.343,0,0,0,17,19.609v-6.7a3.456,3.456,0,0,0,1.605-.2l.337.337Zm2.719-8.231a.8.8,0,0,1-1.129,0L19.258,12.39a3.569,3.569,0,0,0,1.129-1.129l1.277,1.277A.8.8,0,0,1,21.664,13.667ZM17.732,7.8a.342.342,0,0,1-.342.341,1.256,1.256,0,0,0-1.255,1.255.342.342,0,0,1-.684,0A1.941,1.941,0,0,1,17.39,7.454.343.343,0,0,1,17.732,7.8ZM9.353,5.923A.342.342,0,0,1,9.7,5.581h3.072a.342.342,0,1,1,0,.684H9.7A.342.342,0,0,1,9.353,5.923Zm-4.441,0a.342.342,0,0,1,.342-.342H7.871a.342.342,0,0,1,0,.684H5.254A.342.342,0,0,1,4.912,5.923Zm0,2.281a.342.342,0,0,1,.342-.342h5.233a.342.342,0,1,1,0,.684H5.254A.342.342,0,0,1,4.912,8.2Z" data-name="financial market research" id="financial_market_research"/></g></g></svg>
                            <p class="text-xl leading-4">Rencana</p>
                        </a>';
                    } elseif ( $dompetRow ) {
                        $idDompet = $dompetRow['id_dompet'];
                        echo "<a href='saya_Transaksi.php'><button class='button'>Rencana</button></a>";
                    } else {
                        echo "<a href='saya_Dompet.php'><button class='button'>Rencana</button></a>";
                    }
                    
                ?>
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
                        if($bulan < 10){
                            $bulan = "0$bulan";
                        }
                        $bulan_final = "$tahun-$bulan";
                        echo '<a href="saya_laporan.php?id_dompet=' . $idDompet . '&bulan=' . $bulan_final . '"class="flex jusitfy-start items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200">
                        <svg class="w-8 h-8 fill-gray-200" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 553.65 561.52" style="enable-background:new 0 0 553.65 561.52;"
                                xml:space="preserve">
                            <style type="text/css">
                                .st0{clip-path:url(#SVGID_7_);}
                                .st1{clip-path:url(#SVGID_8_);}
                                .st2{clip-path:url(#SVGID_9_);}
                                .st3{clip-path:url(#SVGID_10_);}
                                .st4{clip-path:url(#SVGID_11_);}
                                .st5{clip-path:url(#SVGID_12_);}
                            </style>
                            <g>
                                <defs>
                                    <path id="SVGID_1_" d="M423.95,18.66c29.23,0.01,58.08-0.04,86.92,0.06c7.72,0.03,14.51,2.45,19.68,8.68
                                        c3.29,3.97,4.65,8.42,4.65,13.46c-0.02,73.86-0.05,147.72-0.05,221.58c0.01,86.24,0.02,172.47,0.09,258.71
                                        c0.01,8.9-3.4,15.69-11.52,19.48c-2.92,1.36-6.38,2.2-9.6,2.2c-54.73,0.08-109.45-0.04-164.18-0.05
                                        c-51.38-0.02-102.75,0.06-154.13,0.05c-45.97-0.01-91.94-0.07-137.91-0.16c-7.2-0.01-14.41,0.01-21.59-0.45
                                        c-8.75-0.56-17.39-9.06-17.39-18.42c-0.02-22.81-0.11-45.62-0.11-68.44c0.01-88.94,0.11-177.88,0.06-266.82
                                        c-0.03-47.69-0.26-95.38-0.48-143.07c-0.05-10.93,2.87-20.24,13.8-24.69c3.79-1.54,8.23-2.03,12.38-2.03
                                        C170.91,18.65,297.24,18.67,423.95,18.66z M230.83,325.24c2.02-0.68,4.04-1.94,6.06-1.95c18.93-0.11,37.85-0.05,56.78,0.08
                                        c5.34,0.04,9.25,3.45,9.87,8.83c0.53,4.59,0.49,9.25,0.55,13.88c0.08,5.74,0.02,11.48,0.02,17.05c15.43,0,30.29,0,45,0
                                        c0-19.83-0.02-39.27,0.01-58.71c0.01-7.99,4.1-12,12.05-12.01c19.7-0.03,39.4-0.07,59.11-0.06c1.76,0,3.63,0.08,5.27,0.64
                                        c5.36,1.81,7.07,4.96,7.07,12.94c0.01,66.25,0,132.51-0.01,198.76c0,6.53,0,13.07,0,19.64c28.58,0,56.58,0,84.61,0
                                        c0-137.24,0-274.2,0-411.36c-160.23,0-320.21,0-480.21,0c0,137.18,0,274.24,0,411.3c8.31,0,16.24,0,24.5,0c0-1.63,0-3.02,0-4.42
                                        c0.01-19.85,0.04-39.7,0.03-59.55c-0.01-19.46-0.08-38.93-0.07-58.39c0-4.86,2.07-7.35,6.36-7.37c20.86-0.07,41.72-0.1,62.58,0.03
                                        c5.98,0.04,10.46,4.58,10.45,10.05c-0.09,38.92-0.19,77.84-0.28,116.77c0,0.99,0.14,1.97,0.2,2.88c9.24,0,18.19,0,27.4,0
                                        c0-1.44,0-2.58,0-3.72c0-26.55,0.01-53.11,0-79.66c0-6.42,1.99-8.54,8.46-8.55c15.45-0.03,30.91,0.02,46.36,0.04
                                        c1.49,0,2.98,0,4.7,0c0-1.71,0-2.86,0-4.01c-0.02-31.45-0.04-62.9-0.09-94.36C227.6,330.87,227.47,327.77,230.83,325.24z
                                        M493.88,94.45c7.79,0,15.59,0,23.31,0c0-19.59,0-38.59,0-57.77c-160.23,0-320.18,0-480.18,0c0,19.37,0,38.47,0,57.77
                                        C189.28,94.45,341.2,94.45,493.88,94.45z M366.36,392.44c0,43.9,0,87.8,0,131.67c16.36,0,32.23,0,48.02,0
                                        c0-71.47,0-142.54,0-213.75c-16.12,0-32,0-48,0C366.38,337.71,366.38,364.73,366.36,392.44z M285.8,400.32
                                        c0-20.06,0-40.13,0-60.42c-13.84,0-27.39,0-40.79,0c0,61.69,0,123.07,0,184.3c13.65,0,26.99,0,40.79,0
                                        C285.8,482.96,285.8,442.03,285.8,400.32z M79.41,507.05c0,5.74,0,11.49,0,17.15c14.73,0,28.95,0,43.1,0c0-37.63,0-74.91,0-112.42
                                        c-14.55,0-28.74,0-43.1,0C79.42,443.47,79.42,474.87,79.41,507.05z M304.05,416.56c0,12.16,0,24.33,0,36.4c15.31,0,30.04,0,44.7,0
                                        c0-24.22,0-48.11,0-72.15c-14.98,0-29.69,0-44.7,0C304.05,392.65,304.05,404.22,304.05,416.56z M227.52,488.49
                                        c0-13.21,0-26.43,0-39.87c-14.07,0-27.65,0-41.31,0c0,25.34,0,50.4,0,75.64c13.78,0,27.34,0,41.3,0
                                        C227.52,512.4,227.52,500.83,227.52,488.49z M318.48,471.07c-4.72,0-9.44,0-14.23,0c0,18.02,0,35.57,0,53.11
                                        c15.04,0,29.77,0,44.51,0c0-17.79,0-35.23,0-53.11C338.76,471.07,329.01,471.07,318.48,471.07z"/>
                                </defs>
                                <defs>
                                    <path id="SVGID_2_" d="M135.69,285.45c11.04-23.89,51.38-27.48,68.86,0.94c25.79-15.28,51.59-30.57,77.66-46.01
                                        c-1.48-12.22-0.63-24.27,8.27-34.33c6.8-7.69,15.29-12.39,25.54-13.32c18.68-1.7,43.1,11.97,42.4,41.18
                                        c11.56,6.6,23.38,13.34,35.53,20.28c4.55-5.46,9-10.71,13.34-16.06c11.8-14.53,23.57-29.1,35.33-43.67
                                        c6.12-7.59,12.26-15.16,18.23-22.86c1.01-1.3,1.58-3.2,1.7-4.87c0.45-6,5.45-11.04,11.81-11.57c5.7-0.48,11.67,3.84,12.75,9.47
                                        c0.77,4.02-1.42,7.09-3.84,10.01c-14.29,17.3-28.57,34.61-42.82,51.94c-8.47,10.3-16.92,20.62-25.3,30.99
                                        c-2.65,3.28-5.15,6.7-7.57,10.15c-4.29,6.13-12.52,8.32-19.57,3.99c-9.9-6.08-20.15-11.6-30.25-17.34
                                        c-1.41-0.8-2.85-1.56-4.25-2.32c-16.08,23.65-45.93,24.72-61.77,4.26c-27.28,15.98-54.63,32.01-82.59,48.39
                                        c-0.54,12.77-6.47,23.41-17.44,30.95c-7.3,5.02-15.46,7.61-24.51,7.03c-13.92-0.89-33.72-12.01-33.4-33.09
                                        c-8.67,5.47-17.1,10.7-25.43,16.07c-11.81,7.6-23.54,15.32-35.32,22.97c-3.08,2-6.24,3.55-10.04,1.79
                                        c-3.69-1.7-5.97-4.58-6.36-8.51c-0.37-3.67,1.33-6.74,4.51-8.72c13.24-8.23,26.51-16.41,39.76-24.62
                                        c8.8-5.45,17.57-10.94,26.4-16.33c1.82-1.11,3.87-1.86,6.14-2.92C134.04,288.37,134.82,287.04,135.69,285.45z M305.36,216.63
                                        c-5.82,5.75-7.43,12.76-5.49,20.47c2.09,8.34,10.83,14.71,19.14,15.16c10.95,0.59,19.06-7.08,21.19-14.1
                                        c2.63-8.66,0.44-18.16-8.4-23.89C323.1,208.62,314.74,209.01,305.36,216.63z M175.69,323.23c0.47-0.2,0.94-0.41,1.41-0.6
                                        c12.66-4.89,17.5-18.3,10.31-29.35c-4.68-7.18-11.95-9.05-20.1-8.7c-8.72,0.38-15.4,5.73-17.94,14.6
                                        c-2.1,7.32,1.75,16.69,8.26,21.19C163.06,324.12,168.98,323.8,175.69,323.23z"/>
                                </defs>
                                <defs>
                                    <path id="SVGID_3_" d="M402.9,74.52c-4.47-4.75-5.49-10.04-3.11-15.31c2.07-4.6,6.37-7.08,12.2-6.69
                                        c5.82,0.39,10.2,3.22,12.52,8.66c1.87,4.39-0.16,9.94-4.77,13.9c-4.08,3.51-9.34,4.13-13.8,1.58
                                        C404.94,76.1,404.04,75.37,402.9,74.52z"/>
                                </defs>
                                <defs>
                                    <path id="SVGID_4_" d="M456.47,59.11c6.1-9.62,16.91-7.43,22.1-0.77c3.67,4.71,2.87,12.35-1.45,16.49
                                        c-4.51,4.32-12.36,4.43-17.23,0.25C454.54,70.49,453.57,66.21,456.47,59.11z"/>
                                </defs>
                                <defs>
                                    <path id="SVGID_5_" d="M366.92,78.2c-7.43-1.08-12.59-6.68-12.39-13.12c0.19-6.28,5.73-12.06,11.91-12.43
                                        c7.18-0.43,14.05,5.57,14.17,12.6C380.74,72.32,373.3,79.2,366.92,78.2z"/>
                                </defs>
                                <defs>
                                    <path id="SVGID_6_" d="M303.04,59.49c3.56-5.69,8.1-7.87,13.21-6.51c6.59,1.76,10.9,6.48,11.03,12.06
                                        c0.14,6.23-6.04,12.96-12.07,13.14c-6.69,0.2-13.07-5.48-13.28-12.09C301.86,63.99,302.52,61.85,303.04,59.49z"/>
                                </defs>
                                <use xlink:href="#SVGID_1_"  style="overflow:visible;"/>
                                <use xlink:href="#SVGID_2_"  style="overflow:visible;"/>
                                <use xlink:href="#SVGID_3_"  style="overflow:visible;"/>
                                <use xlink:href="#SVGID_4_"  style="overflow:visible;"/>
                                <use xlink:href="#SVGID_5_"  style="overflow:visible;"/>
                                <use xlink:href="#SVGID_6_"  style="overflow:visible;"/>
                                <clipPath id="SVGID_7_">
                                    <use xlink:href="#SVGID_1_"  style="overflow:visible;"/>
                                </clipPath>
                                <clipPath id="SVGID_8_" class="st0">
                                    <use xlink:href="#SVGID_2_"  style="overflow:visible;"/>
                                </clipPath>
                                <clipPath id="SVGID_9_" class="st1">
                                    <use xlink:href="#SVGID_3_"  style="overflow:visible;"/>
                                </clipPath>
                                <clipPath id="SVGID_10_" class="st2">
                                    <use xlink:href="#SVGID_4_"  style="overflow:visible;"/>
                                </clipPath>
                                <clipPath id="SVGID_11_" class="st3">
                                    <use xlink:href="#SVGID_5_"  style="overflow:visible;"/>
                                </clipPath>
                                <clipPath id="SVGID_12_" class="st4">
                                    <use xlink:href="#SVGID_6_"  style="overflow:visible;"/>
                                </clipPath>
                                <rect x="0" y="0" class="st5" width="553.65" height="561.52"/>
                            </g>
                            </svg>
                            <p class="text-xl leading-4">Laporan</p>
                        </a>';
                    } elseif ( $dompetRow ) {
                        $idDompet = $dompetRow['id_dompet'];
                        echo "<a href='saya_Transaksi.php'><button class='button'>Laporan</button></a>";
                    } else {
                        echo "<a href='saya_Dompet.php'><button class='button'>Laporan</button></a>";
                    }
                    
                ?>
                
                </div>
                <a href="keluar.php" class="flex items-center w-full py-3 pl-12 space-x-8 focus:outline-none text-gray-200 rounded-xl hover:bg-green-950 duration-200 mb-14">
                    <svg class="fill-stroke" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6 21V19C6 17.9391 6.42143 16.9217 7.17157 16.1716C7.92172 15.4214 8.93913 15 10 15H14C15.0609 15 16.0783 15.4214 16.8284 16.1716C17.5786 16.9217 18 17.9391 18 19V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="text-xl leading-4">Keluar</p>
                </a>
            </div>

            <div class='text-2xl mx-auto w-3/5'>
                <div class="grid h-screen place-items-center">
                    <div class="bg-green-800 p-20 w-4/5 h-5/6 rounded-3xl drop-shadow-2xl text-green-50">
                        <h1 class="text-center text-5xl mb-10">Tambah Transaksi</h1>
                        <form method="post" action="proses_Tambah_Transaksi.php" class="mx-7 flex flex-col">

                            <div class="Tambah_Transaksi-field">
                                <label for="jumlah_transaksi">Jumlah: </label>
                                <input class="mt-5 px-2 text-black text-2xl 48 rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" type="text" name="jumlah_transaksi" autofocus required pattern="([1-9])[0-9]{2,20}">
                            </div>

                            <div class="Tambah_Transaksi-field">
                                <label for="jenis_transaksi">Jenis Transaksi: </label>
                                <input type="radio" name="jenis_transaksi" value="Pemasukan" required> Pemasukan 
                                <input type="radio" name="jenis_transaksi" value="Pengeluaran" required> Pengeluaran 
                            </div>

                            <select id="pilihan_pengeluaran" name="pilihan_pengeluaran" style="display: none; color: black;" class="rounded-xl m-2" required>
                                <option disabled selected value="holder">Kategori Transaksi: </opyion>
                                <?php
                                    while($row = pg_fetch_assoc($pengeluaran)) {
                                        echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
                                    }
                                ?>
                            </select>

                            <select id="pilihan_pemasukan" name="pilihan_pemasukan" style="display: none; color: black;" required class="rounded-xl m-2">
                                <option disabled selected value="holder">Kategori Transaksi: </opyion>
                                <?php
                                    while($row = pg_fetch_assoc($pemasukan)) {
                                        echo "<option value=".$row['id_tipe_transaksi'].">".$row['nama_tipe']."</option>";
                                    }
                                ?>
                            </select>
                            
                            <div class="Tambah_Transaksi-field">
                                <label for="tanggal_transaksi">Tanggal Transaksi: </label>
                                <input class="text-black" type="date" name="tanggal_transaksi" required>
                            </div>

                            <div class="Tambah_Transaksi-field">
                                <label for="catatan_transaksi">Catatan: </label>
                                <textarea class="text-black mt-5 px-2 text-2xl rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" name="catatan_transaksi"></textarea>
                            </div>

                            <div class="Tambah_Transaksi-field">
                                <label for="id_dompet">Dompet: </label>
                                    <select class="mt-5 px-2 text-2xl text-black rounded-lg bg-gray-100 border-gray-300 border-2 focus:outline-none" name="id_dompet" id="id_dompet" required>
                                    <option disabled selected value="holder" >Pilih Dompet</opyion>
                                    <?php
                                        while($row = pg_fetch_assoc($dompet)) {
                                            echo "<option class='text-black' value=".$row['id_dompet'].">".$row['nama_dompet']."</option>";
                                        }
                                    ?>
                                    </select>
                            </div>
                            <input class="px-7 mt-10 py-3 hover:cursor-pointer text-3xl rounded-2xl self-center shadow-lg hover:bg-green-100 bg-green-50 text-black" type="submit" value="Tambah" name="submit">
                        </form>
                    </div>
                </div>
                
            </div>

            
            <script>
            // Mendapatkan referensi ke radio button dan select dropdown
            var radioButtons        = document.getElementsByName('jenis_transaksi');
            var dropdownTransaksi   = document.getElementById('pilihan_pengeluaran');
            var dropdownPemasukan   = document.getElementById('pilihan_pemasukan');

            // Tambahkan event listener pada setiap radio button
            for (var i = 0; i < radioButtons.length; i++) {
                radioButtons[i].addEventListener('change', function() {
                if (this.value === 'Pengeluaran') {
                    dropdownTransaksi.style.display = 'block'; 
                } else {
                    dropdownTransaksi.style.display = 'none'
                }
                if (this.value === 'Pemasukan'){
                    dropdownPemasukan.style.display = 'block';  
                } else {
                    dropdownPemasukan.style.display = 'none'
                }
                });
            }
            </script>
        </div>
    </body>
</html>