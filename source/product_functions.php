<?php
session_start();

function handle_add_product() {
    include('cfg.php');

    $opis = $_POST['new_product_opis'];
    $data_utworzenia = date('Y-m-d', strtotime($_POST['new_product_date']));
    $data_wygasniecia = date('Y-m-d', strtotime($_POST['new_product_expiration']));
    $cena_netto = $_POST['new_product_netto'];
    $vat = $_POST['new_product_vat'];
    $category = $_POST['new_product_category'];
    $ilosc = $_POST['new_product_ilosc'];
    $status_dostepnosci = $_POST['new_product_status'];
    $gabaryt = $_POST['new_product_gabaryt'];
    $zdjecie_dane = bin2hex(file_get_contents($_FILES['newproductphoto']['tmp_name']));


    $query = "INSERT INTO `product` (`opis`, `data_utworzenia`, `data_wygasniecia`, `cena_netto`, `vat`, `ilosc`, `status_dostepnosci`, `kategoria`, `gabaryt`, `zdjecie`) VALUES 
            ('$opis', '$data_utworzenia', '$data_wygasniecia', $cena_netto, $vat, $ilosc, $status_dostepnosci, $category, $gabaryt, 0x$zdjecie_dane)";
    $result = mysqli_query($link, $query);

    $_SESSION['query'] = $query;

    if($result) {
        return 'Added successfully';
    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}

function handle_edit_product() {
    include('cfg.php');

    $id = $_POST['update_product_id'];
    $opis = $_POST['update_product_opis'];
    $data_utworzenia = date('Y-m-d', strtotime($_POST['update_product_date']));
    $data_wygasniecia = date('Y-m-d', strtotime($_POST['update_product_expiration']));
    $cena_netto = $_POST['update_product_netto'];
    $vat = $_POST['update_product_vat'];
    $category = $_POST['update_product_category'];
    $ilosc = $_POST['update_product_ilosc'];
    $status_dostepnosci = $_POST['update_product_status'];
    $gabaryt = $_POST['update_product_gabaryt'];
    if(isset($_FILES['updateproductphoto']['tmp_name']) && $_FILES['updateproductphoto']['tmp_name'] != "") {
        $zdjecie_dane = bin2hex(file_get_contents($_FILES['updateproductphoto']['tmp_name']));
    } else {
        $zdjecie_dane = bin2hex(base64_decode($_POST['defaultphoto']));
    }
    $query ="UPDATE `product` SET `opis` = '$opis', `data_utworzenia` = '$data_utworzenia', `data_wygasniecia` = '$data_wygasniecia', `cena_netto` = $cena_netto, `vat` = $vat, `kategoria` = $category, `ilosc` = $ilosc, 
            `status_dostepnosci` = $status_dostepnosci, `gabaryt` = $gabaryt, `zdjecie` = 0x$zdjecie_dane WHERE id = $id ";
    $result = mysqli_query($link, $query);

    if($result) {
        return 'Update successful';
    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}


function handle_delete_product() {
    include('cfg.php');
    $deleteId = $_POST['product_to_delete_id'];

    $query = "DELETE FROM `product` where id = $deleteId LIMIT 1";
    $result = mysqli_query($link, $query);

    if($result) {
        return 'Deleted successfully';

    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}
