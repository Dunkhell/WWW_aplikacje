<?php

function selectSite($id, $link)
{

    $id_clear=htmlspecialchars($id);
    $query="SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link ,$query);
    $row=mysqli_fetch_array($result);
    if(empty($row['id']))
    {
        $web='[no_page_found]';
    }
    else
    {
        $web=$row['page_content'];
    }
    return $web;
}



$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$baza="my_site";

$link =mysqli_connect($dbhost,$dbuser,$dbpass);
if(!$link) echo '<b>Connection abrupted</b>';
if(!mysqli_select_db($link, $baza)) echo 'no database.';



$given_id = $_GET["id"];
print selectSite($given_id, $link);


