<?php
$db=pg_connect('host=localhost dbname=butuhuang user=postgres password=mikej');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}
?>