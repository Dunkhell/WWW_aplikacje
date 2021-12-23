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

// Sprawdzam dane przesłane przez użytkownika formularzem logowania, jeżeli hasło i logn zgadzają się z kontem admina, ustawiam flagę "loginFailed" na 0, zaznaczając że logowanie się powiodło.

$login = $_POST['login_email'];
$password = $_POST['login_password'];
// W pierwszym if sprawdzam, czy loginFailed, nie jest juz ustawiony na 0, co wskazuje że użytkownik podczas tej sesji wykonał juz poprawne logowanie.
if ((empty($login) || empty($password)) && $_SESSION['loginFailed'] != 0) {
    $_SESSION['loginFailed'] = 1;
}else if ($login == "root" && $password == "root") {
    $_SESSION['loginFailed'] = 0;
}else if ($_SESSION['loginFailed'] != 0) { // Ostanti if jest kontrolny, gdyby z powodu jakiegoś błędu nasza flaga nie byłaby równa zero to automatycznie ustawaimy ją na 1, czyli niepoprawne logowanie (uchroni nas to gdy np. ktoś ustawi przez hackowanie flagę na wartość inną niż 0/1
    $_SESSION['loginFailed'] = 1;
}

