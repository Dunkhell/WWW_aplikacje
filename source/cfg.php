<?php
session_start();
if(!isset($_SESSION['loginFailed']))
{
    $_SESSION['loginFailed'] = 1;
}
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$baza="my_site";
 
// Create connection
$link =mysqli_connect($dbhost,$dbuser,$dbpass);
if(!$link) echo '<b>Connection abrupted</b>';
if(!mysqli_select_db($link, $baza)) echo 'no database.';


$login = $_POST['login_email'];
$password = $_POST['login_password'];
if ((empty($login) || empty($password)) && $_SESSION['loginFailed'] != 0) {
    $_SESSION['loginFailed'] = 1;
}else if ($login == "root" && $password == "root") {
    $_SESSION['loginFailed'] = 0;
}else if ($_SESSION['loginFailed'] != 0) {
    $_SESSION['loginFailed'] = 1;
}

