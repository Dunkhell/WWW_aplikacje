<?php

echo "<button onclick=location.href='?idp=admin' type='button'>
Back to admin
</button>";

function PokazKontakt(){
    echo '<form method="post" name="mail">
    <div>
        <p>Email <input type="text" name="email"></p>
        <p>Temat<input type="text" name="temat"></p>
        <p>Treść</p>
        <textarea name="tresc" cols="20" rows="10"></textarea><br>
        <input type="submit" value="OK">
    </div>';

    if (isset($_POST['email'])){
        WyslijMailaKontakt("ciemnoki12@gmail.com");
    }
}
function WyslijMailaKontakt ($odbiorca)
{
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
    {
        echo '[nie_wypelniles_pola]';
    }
    else
    {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] =  $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['reciptient'] = $odbiorca;

        $header = "From: Formularz kontaktowy <". $mail['sender']."\n";
        $header .= "MIME-Version: 1.0\ncontent-Type: text/plain; charset=utf-8\ncontent-Transfer-Encoding:";
        $header .= "X-Sender: <". $mail['sender'].">\n";
        $header .= "X-Mailer: PRapwww mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <". $mail['sender'].">\n";

        mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}
function PrzypomnijHaslo($odbiorca){
    include("cfg.php");
    $mail['subject'] = "Przypomnienie hasła do admina";
    $mail['body'] =  $password;
    $mail['sender'] = $_POST['przypomnnienie_hasla@gmail.com'];
    $mail['reciptient'] = $odbiorca; //czyli my jestesmy odbiorca, jezeli tworzymy formularz kontaktowy

    $header = "From: Przypomnienie hasla <". $mail['sender']."\n";
    $header .= "MIME-Version: 1.0\ncontent-Type: text/plain; charset=utf-8\ncontent-Transfer-Encoding:";
    $header .= "X-Sender: <". $mail['sender'].">\n";
    $header .= "X-Mailer: PRapwww mail 1.2\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <". $mail['sender'].">\n";

    mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

    echo '[haslo wyslane na email:'.$mail["reciptient"].']';
}
Pokazkontakt();

echo '<br /><br /><br /><br /><br />';
echo '<p>Email do przypomnienia hasla<input type="text" name="email2"></p>';
echo '<form action="" method="post"><button name="haslo">Przypomnij haslo</button></form>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['haslo'])) {
        PrzypomnijHaslo($_POST['email2']);
    }
}
?>