<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$baza="my_site";
 
// Create connection
$link =mysql_connect($dbhost,$dbuser,$dbpass);
if(!$link) echo '<b>Connetion abrupted</b>';
if(!mysql_select_db($baza)) echo 'no database.';
 
?>