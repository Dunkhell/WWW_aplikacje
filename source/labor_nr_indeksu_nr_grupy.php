<html>
<body>

<form action="labor_nr_indeksu_nr_grupy.php" method="post">
    Name: <input type="text" name="name"><br>
<input type="submit">
</form>

</body>
</html>

<?php
    session_start();
    $nr_indeksu = 156031;
    $nrGrupy = "X";
    echo "Kacper Gruszczyński ".$nr_indeksu." grupa ".$nrGrupy." <br /><br />";
    
    echo "Zastosowanie metody include() <br />";
    include "apples.php";
    echo "An apple of your choice could be either ".$sour. " or ".$sweet.".<br /> <br />";

    echo "Zastosowanie metody require_once() <br />";
    require_once "cheese.php";
    echo "Types of cheese: <br/>";
    echo $mozzarella."<br/>";
    echo $gouda."<br/>";
    echo $feta."<br/>";
    require_once "cheese.php";
    echo "Mein am liebstiein sind ".$feta."<br/><br/>";

    echo "Zasotoswanie metody if, else, elseif, switch<br/>";
    $my_age = 21;
    $when_adult = 18;

    if ($my_age > $when_adult) {
        echo "I'm an adult ";
    } elseif ($my_age == $when_adult){
        echo "I'll be an adult this year";
    } else {
        echo "I'm too young to be an adult";
    }
    echo "<br/>Same thing but with switch now:<br/>";

    $my_age = 15;

    switch($my_age){
        case $my_age > $when_adult:
            echo "I'm an adult ";
            break;
        case $my_age == $when_adult:
            echo "I'll be an adult this year";
            break;
        default:
            echo "I'm too young to be an adult";
            break;
    }
    echo "<br/><br/>";
    echo "Zasotoswanie metody while() i for()<br/>";

    $years_left = 0;
    while (($my_age + $years_left) <= 18) {
        $years_left++;
    }
    echo "I've got ".$years_left." years untill I'm an adult!<br/>";

    for ($i = 0; $i <= 10 ; $i++) {
        echo "".$i." ";
    }
    echo "<br/><br/>Zasotoswanie metody _GET, _POST, _SESSION<br/>";
    
    echo "Hello ". htmlspecialchars($_GET["name"]) . "!<br/>";
    $_SESSION["name"] = "Kacper";
    echo "Your name is ".$_SESSION["name"]."!<br/><br/>";

?>