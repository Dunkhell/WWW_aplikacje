<?php
session_start();
echo 'include – includes external file in specified location. Useful for making templates such as footer or header so we can include them in every file instead of copying/ rewirting them everytime';
echo "<br>";
echo "<br>";
include 'labor_156031_1.php';

echo "<br>";
echo 'require_once() - same as include() but doesnt allow duplicate includes so we wont include the same file multiple times by mistake.';
echo "<br>";
echo "<br>";

include_once 'labor_156031_1.php';
echo "This include doesn't work unless we remove/ comment out the first include.";
echo "<br>";
echo "<br>";
echo 'if - if statments are useful tool that allows us to check if something is true or false and add code that executes in either case.';
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

echo 'else - else statement comes in pair with If, its the code block that executes in case of if statemnt failur.';
echo "<br>";
echo "<br>";
echo 'else if - else if statement allows us to allocate another check for values in case of first if statment failur, the difference between else if and else is that we can set another boolean check for else if.';
echo "<br>";
echo "<br>";
if (1 < 2) {
    echo "You're going to see this text becase 1 is smaller than 2";
} else if (1 == 1) {
    echo "1 is also equal 1 but the first if statement has already ran so we can't get to this codeblock";
} else {
    echo "If all of the above failed, this codeblock would have executed but that's not the case this time";
}
echo "<br>";
echo "<br>";


echo 'switch - special kind of if/else if/ else statment that combines them all in one function. switch statments take any value as an argument and allows us to check them in many cases and if all of them fail, deafult statement is run if included. ';
echo "<br>";
echo "<br>";
switch (4) {
    case 1:
        echo "You'll see this text only if the given value is equal:  1";
        break;
    case 2:
        echo "You'll see this text only if the given value is equal:  2";
        break;
    case 3:
        echo "You'll see this text only if the given value is equal:  3";
        break;
    case 4:
        echo "You'll see this text only if the given value is equal:  4";
        break;
}
echo "<br>";
echo "<br>";
echo ' while - While is a first loop function existing in all common programming languages, it runs given codeblock untill given boolean is true, for ex. if we re checking if 1<2 then it would be always true thus while loop would run infinitly.';
echo "<br>";
echo "<br>";
$x = 0;
while ($x < 4) {
    echo "This loop will run " . (3 - $x) . " more times";
    echo "<br>";
    $x++;
}

echo "<br>";
echo "<br>";
echo 'for - is a loop used if we know how many times we would wish our codeblock to execute, for ex. if we wanted to print every item in a list of given size, then for loop is our simplest choice.';
echo "<br>";
echo "<br>";

for ($i = 0; $i < $x; $i++) {
    echo "This loop will run for " . (3 - $i) . " more times";
    echo "<br>";
}
echo "<br>";
echo "<br>";
echo '$ _GET - used to send variables from URL';
echo "<br>";
echo "<br>";
if ($_GET["name"] || $_GET["age"]) {
    echo "Hi! " . $_GET['name'] . "<br />";
    echo "You're " . $_GET['age'] . " years old.";

    exit();
}

echo "<form action = '$_PHP_SELF' method = 'GET'>
Name: <input type = 'text' name = 'name' /> Age: <input type = 'text' name = 'age' />
<input type = 'submit' /></form>";


echo "<br>";
echo "<br>";
echo '$ _POST - used for sending variables invisible to user in url ';
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

if ($_POST["name"] || $_POST["age"]) {
    if (preg_match("/[^A-Za-z'-]/", $_POST['name'])) {
        die("invalid name and name should be alpha");
    }
    echo "Hi " . $_POST['name'] . "<br />";
    echo "You're " . $_POST['age'] . " years old.";

    exit();
}

echo "<form action = '$_PHP_SELF' method = 'POST'>
Name: <input type = 'text' name = 'name' /> Age: <input type = 'text' name = 'age' />
<input type = 'submit' /></form>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

echo '$_SESSION - saves varaiables set in our session.';
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

$_SESSION["favcolor"] = "blue";
print_r($_SESSION);
