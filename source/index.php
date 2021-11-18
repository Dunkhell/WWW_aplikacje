<!DOCTYPE html>
<html>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="en" />
<meta name="Author" content="Kacper Gruszczynski" />
<link rel="stylesheet" href="css/style.css" />
<title>Tallest buildings in the world</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<body>
    <?php
    include("cfg.php");
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    if ($_GET['idp'] == "") $site = './html/main.html';
    if ($_GET['idp'] == "khalifa") $site = './html/khalifa.html';
    if ($_GET['idp'] == "al_bait") $site = './html/al_bait.html';
    if ($_GET['idp'] == "finance_centre") $site = './html/finance_centre.html';
    if ($_GET['idp'] == "shanghai") $site = './html/shanghai.html';
    if ($_GET['idp'] == "world_tower") $site = './html/world_tower.html';
    if ($_GET['idp'] == "videos") $site = './html/videos.html';

    if (file_exists($site)) {
        include($site);
    } else {
        throw new ErrorException($site . " doesn't exists!");
    }

    include("./php/labor_156031_1.php");
    ?>

</body>

</html>
