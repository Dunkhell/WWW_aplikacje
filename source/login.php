<?php

function LoginForm() {

    $form = '
    <div class="logowanie">
        <h1 class="heading">Panel admin:</h1>
            <div class="logowanie">
                <form method="post" name="LoginForm">
                <table class="logowanie">
                    <tr><td class=""log4_t>[login]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                    <tr><td class=""log4_t>[haslo]</td><td><input type="text" name="login_password" class="logowanie" /></td></tr>
                    <tr><td class=""log4_t>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';

    return $form;
}

include 'cfg.php';
echo LoginForm();


if($_SESSION['loginFailed'] == 0) {
    echo "HERE";
    header("Location: http://localhost/php/lab1/source/?idp=admin");
    exit();
}