<?php
$db=pg_connect('host=localhost dbname=manage_money user=postgres password=T00thless');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}
?>