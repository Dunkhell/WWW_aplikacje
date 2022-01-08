<?php
session_start();

function handle_add_product() {
    include('cfg.php');


    $opis = $_GET['new_product_opis'];
    $data_utworzenia = $_GET['new_product_date'];
    $data_wygasniecia = $_GET['new_product_expiration'];
    $cena_netto = $_GET['new_product_netto'];
    $vat = $_GET['new_product_vat'];
    $category = $_GET['new_product_category'];
    $ilosc = $_GET['new_product_ilosc'];
    $status_dostepnosci = $_GET['new_product_status'];
    $gabaryt = $_GET['new_product_gabaryt'];
    $zdjecie_dane = file_get_contents($_FILES['newproductphoto']['tmp_name']);


    $query = "INSERT INTO `product` (`opis`, `data_utworzenia`, `data_wygasniecia`, `cena_netto`, `vat`, `ilosc`, `status_dostepnosci`, `kategoria`, `gabaryt`, `zdjecie`) VALUES 
            ($opis, $data_utworzenia, $data_wygasniecia, $cena_netto, $vat, $ilosc, $status_dostepnosci, $category, $gabaryt, $zdjecie_dane)";
    $result = mysqli_query($link, $query);

    if($result) {
        return 'Added successfully';
    }
    return 'Failed adding page';
}

function handle_edit_product() {
    include('cfg.php');

    $id = $_GET['product_update_id'];
    $opis = $_GET['new_product_opis'];
    $data_utworzenia = $_GET['new_product_date'];
    $data_wygasniecia = $_GET['new_product_expiration'];
    $cena_netto = $_GET['new_product_netto'];
    $vat = $_GET['new_product_vat'];
    $category = $_GET['new_product_category'];
    $ilosc = $_GET['new_product_ilosc'];
    $status_dostepnosci = $_GET['new_product_status'];
    $gabaryt = $_GET['new_product_gabaryt'];
    $zdjecie_dane = file_get_contents($_FILES['new_product_photo']);

    $query =" UPDATE `product` SET `opsis` = $opis, `data_utworzenia` = $data_utworzenia, `data_wygasniecia` = $data_wygasniecia, `cena_netto` = $cena_netto, `vat` = $vat, `kategoria` = $category, `ilosc` = $ilosc, 
            `status_dostepnosci` = $status_dostepnosci, `gabaryt` = $gabaryt, `zdjecie` = $zdjecie_dane WHERE id = $id";
    $result = mysqli_query($link, $query);

    if($result) {
        return 'Update successful';
    }
    return 'Failed updating record!';
}


function handle_delete_product() {
    include('cfg.php');
    $deleteId = $_POST['product_to_delete_id'];

    $query = "DELETE FROM `product` where id = $deleteId LIMIT 1";
    $result = mysqli_query($link, $query);

    if($result) {
        return 'Deleted successfully';

    }
    return 'Failed deleting record!';
}
