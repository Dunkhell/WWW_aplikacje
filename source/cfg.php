<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$baza="my_site";
 
// Create connection
$link =mysqli_connect($dbhost,$dbuser,$dbpass);
if(!$link) echo '<b>Connection abrupted</b>';
if(!mysqli_select_db($link, $baza)) echo 'no database.';

