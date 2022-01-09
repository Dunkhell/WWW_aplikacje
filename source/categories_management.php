<?php
session_start();

function list_products($category_id) {
    include ("cfg.php");

    $query="SELECT * FROM product WHERE kategoria = $category_id";
    $result_set=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $opis = $row['opis'];
        $data_utworzenia = $row['data_utworzenia'];
        $data_wygasniecia = $row['data_wygasniecia'];
        $cena_netto = $row['cena_netto'];
        $vat = $row['vat'];
        $ilosc = $row['ilosc'];
        $status_dostepnosci = $row['status_dostepnosci'];
        $kategoria = $row['kategoria'];
        $gabaryt = $row['gabaryt'];
        $zdjecie = base64_encode($row['zdjecie']);
        $buyable = true;

        if(date("Y-m-d", strtotime($data_wygasniecia)) < date("Y-m-d") || $ilosc <= 0 || $status_dostepnosci == 0) {
            $buyable = false;
        }

        $color = "white";
        if (!$buyable) {
            $color = "red";
        }

        $page_result  = "
        <div >
        <div>
            <table >
                <thead>
                    <th><span>ID</span></th>
                    <th><span>opis</span></th>
                    <th><span>data utworzenia</span></th>
                    <th><span>data wygasniecia</span></th>
                    <th><span>cena netto</span></th>
                    <th><span>podatek vat</span></th>
                    <th><span>ilosc</span></th>
                    <th><span>status dostepnosci</span></th>
                    <th><span>kategoria</span></th>
                    <th><span>gabaryt</span></th>
                    <th><span>zdjecie</span></th>
                    <th><span>akcje</span></th>
                </thead>
                <tbody style='color: $color'>
                    <tr> 
                    <td>".$id."</td>
                    <td>$opis</td>    
                    <td>$data_utworzenia</td>
                    <td>$data_wygasniecia</td> 
                    <td>$cena_netto</td>
                    <td>$vat</td>
                    <td>$ilosc</td>
                    <td>$status_dostepnosci</td>
                    <td>$kategoria</td>
                    <td>$gabaryt</td>
                    <td><img style='width: 75px; height: 75px' src='data:image/jpeg;base64, $zdjecie'/></td>
                    <td><form method='post'>
                        <input type='hidden' name='product_update_id' value='".$id."'/>
                        <input type='submit' name='update_product' value='Edit'/>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='product_to_delete_id' value='".$id."'/>
                        <input type='submit' name='delete' value='Delete'/>
                    </form></td>
                    </tr>       
                </tbody>
            </table>
            
        </div>
        
        </div>
        ";
        echo $page_result;

    }
}

function list_categories() {
    include "cfg.php";

    $query="SELECT * FROM category WHERE parent = 0";
    $result=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result)) {
        $id=$row['id'];
        $parent = $row['parent'];
        $name=$row['name'];

        $child_query = "SELECT * FROM category WHERE parent = $id";
        $child_categories = mysqli_query($link, $child_query);


        $page_result  = "
        <div >
        <div>
            <table>
                <thead>
                    <th><span>ID</span></th>
                    <th><span>name</span></th>
                    <th><span>actions</span></th>
                </thead>
                <tbody>
                    <tr> 
                    <td>".$id."</td>
                    <td>".$name."</td>
                    <td><form method='post'>
                        <input type='hidden' name='category_id' value='".$id."'/>
                        <input type='hidden' name='category_parent' value='".$parent."'/>
                        <input type='hidden' name='category_name' value='".$name."'/>
                        <input type='submit' name='edit' value='Edit'/>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='category_to_delete_id' value='".$id."'/>
                        <input type='submit' name='delete' value='Delete'/>
                    </form></td>
                    </tr>       
                </tbody>
            </table>
            
        </div>
        
        </div>
        <br>
        ";
        echo $page_result;
        while ($child_row = mysqli_fetch_array($child_categories)) {

            $child_id = $child_row['id'];
            $child_parent = $child_row['parent'];
            $child_name = $child_row['name'];

            $children_result = "
            <div >
            <div >
                <table>
                    <thead>
                        <th><span >ID</span></th>
                        <th><span >parent</span></th>
                        <th><span >name</span></th>
                        <th><span>actions</span></th>
                    </thead>
                    <tbody>
                        <tr> 
                        <td >".$child_id."</td> 
                        <td >".$child_parent." ".$name."</td>
                        <td >".$child_name."</td>
                        <td><form method='post'>
                            <input type='hidden' name='category_id' value='".$child_id."'/>
                            <input type='hidden' name='category_parent' value='".$child_parent."'/>
                            <input type='hidden' name='category_name' value='".$child_name."'/>
                            <input type='submit' name='edit' value='Edit'/>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='category_to_delete_id' value='".$child_id."'/>
                            <input type='submit' name='delete' value='Delete'/>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='product_category' value='".$child_id."'/>
                            <input type='submit' name='new_product' value='Add product'/>
                        </form>
                        </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
           
            </div>
            <br>
        ";

        echo $children_result;
        list_products($child_id);
        echo "<br>";
        }
        echo "<br><hr style='height: 2px; background: red'><br>";

    }
}

function add_category_form() {
    $new_page_form = "
        <div>
        <div>
            <h1>Add new category</h1>
            <form method='post'>
            <table style='width: 100%'>
                <thead>
                    <th style='width: 50%'><span>parent</span></th>
                    <th  style='width: 50%'><span>name</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td>
                    <input style='width: 99%' type='text' name='new_category_parent' placeholder='Your category parent id here..'/>
                    </td>
                    <td>
                    <input style='width: 99%' type='text' name='new_category_name' placeholder='Your category name goes here...'/>
                    </td>
                    </tr>       
                </tbody>
            </table>
            <button type='submit'>Save</button>
            </form>
        </div>
        </div>
        ";
    return $new_page_form;
}

function edit_category_form() {
    include('cfg.php');

    $id = $_POST['category_id'];
    $parent = $_POST['category_parent'];
    $name = $_POST['category_name'];


    $edit_form = "
        <div>
        <div>
            <h1>Edit category ".$name." #".$id."</h1>
            <form method='post'>
            <table style='width:100%; height: 400px'>
                <thead>
                    <th><span>ID</span></th>
                    <th><span>parent</span></th>
                    <th><span>name</span></th>
                </thead>
                <tbody>
                <tr>
                     <td><input type='text' readonly value='".$id."' name='edit_id'/></td>
                     <td><input type='text' name='edit_parent' value='".$parent."'/></td>
                     <td><input type='text' name='edit_name' value='".$name."'></td> 
                 </tr>       
                </tbody>
            </table>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        <br><br>
        ";
    echo $edit_form;
}

function new_product_form() {
    $category = $_POST['product_category'];

    $new_product_form = "
        <div>
        <div>
            <h1>Add new product to category # $category</h1>
            <form method='post' enctype='multipart/form-data'>
            <table style='width: 100%'>
            <thead>
                    <th><span>opis</span></th>
                    <th><span>data utworzenia</span></th>
                    <th><span>data wygasniecia</span></th>
                    <th><span>cena netto</span></th>
                    <th><span>podatek vat</span></th>
                    <th><span>ilosc</span></th>
                    <th><span>status dostepnosci</span></th>
                    <th><span>kategoria</span></th>
                    <th><span>gabaryt</span></th>
                    <th><span>zdjecie</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td>
                    <input style='width: 95%' type='text' name='new_product_opis' placeholder='Your category description goes here..'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='date' name='new_product_date'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='date' name='new_product_expiration'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='new_product_netto'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='new_product_vat'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='new_product_ilosc'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='text' name='new_product_status' value=''/>
                    </td>
                    <td>
                    <input style='width: 95%' type='text' name='new_product_category' value='$category' readonly/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='new_product_gabaryt'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='file' name='newproductphoto'/>
                    </td>
                    
                    </tr> 
                </tbody>
                </table>
            <button type='submit'>Save</button>
            </form>
        </div>
        </div>
        <br>
        ";
    return $new_product_form;
}

function edit_product_form() {
    include("cfg.php");
    $product_id = $_POST['product_update_id'];


    $query="SELECT * FROM product WHERE id = $product_id LIMIT 1";
    $result_set=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $opis = $row['opis'];
        $data_utworzenia = $row['data_utworzenia'];
        $data_wygasniecia = $row['data_wygasniecia'];
        $cena_netto = $row['cena_netto'];
        $vat = $row['vat'];
        $ilosc = $row['ilosc'];
        $status_dostepnosci = $row['status_dostepnosci'];
        $kategoria = $row['kategoria'];
        $gabaryt = $row['gabaryt'];
        $zdjecie = base64_encode($row['zdjecie']);

        $edit_product_form = "
        <div>
        <div>
            <h1>Edit product # $id</h1>
            <form method='post' enctype='multipart/form-data'>
            <table style='width: 100%'>
            <thead>
                    <td><span>ID</span></td>
                    <th><span>opis</span></th>
                    <th><span>data utworzenia</span></th>
                    <th><span>data wygasniecia</span></th>
                    <th><span>cena netto</span></th>
                    <th><span>podatek vat</span></th>
                    <th><span>ilosc</span></th>
                    <th><span>status dostepnosci</span></th>
                    <th><span>kategoria</span></th>
                    <th><span>gabaryt</span></th>
                    <th><span>zdjecie</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td>
                    <input type='text' name='update_product_id' value='$id' readonly/>
                    </td>
                    <td>
                    <input style='width: 95%' type='text' name='update_product_opis' value='$opis'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='date' name='update_product_date' value='$data_utworzenia'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='date' name='update_product_expiration' value='$data_wygasniecia'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='update_product_netto' value='$cena_netto'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='update_product_vat' value='$vat'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='update_product_ilosc' value='$ilosc'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='text' name='update_product_status' value='$status_dostepnosci'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='text' name='update_product_category' value='$kategoria'/>
                    </td>
                    <td>
                    <input style='width: 95%' type='number' name='update_product_gabaryt' value='$gabaryt'/>
                    </td>
                    <td>
                    <img src='data:image/jpeg;base64, $zdjecie'/>
                    <input type='hidden' name='defaultphoto' value='$zdjecie'>
                    <input type='file' name='updateproductphoto' value='$zdjecie'/>
                    </td>
                    </tr>                     
                </tbody>
                </table>
            <button type='submit'>Save</button>
            </form>
        </div>
        </div>
        <br>
        ";
        return $edit_product_form;
    }
    return "Error parsing product from given id {$product_id}";
}

include("cfg.php");

echo "<button onclick=location.href='?idp=' type='button'>
    Back
    </button>";

if($_SESSION['loginFailed'] == 0) {
    echo "<form method='post'>
    <input type='submit' name='add_new' id='add_new' value='add new category' /><br/>
    </form>";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['category_id'])) {
            edit_category_form();
        }

        if(array_key_exists('new_product',$_POST)){
            echo new_product_form();
        }

        if(array_key_exists('add_new',$_POST)){
            echo add_category_form();
        }

        if(array_key_exists('update_product', $_POST)) {
            echo edit_product_form();
        }

        include_once("categories_functions.php");
        include_once("product_functions.php");

        if(isset($_POST['new_category_parent']) || isset($_POST['new_category_name'])) {
            $message = handle_add_category();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }


        if(isset($_POST['category_to_delete_id'])) {
            $message = handle_delete_category();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }

        if(isset($_POST['edit_id'])) {
            $message = handle_edit_category();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }

        if(isset($_POST['new_product_category'])) {
            $message = handle_add_product();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }

        if(isset($_POST['product_to_delete_id'])) {
            $message = handle_delete_product();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }

        if(isset($_POST['update_product_id'])) {
            $message = handle_edit_product();
            $_SESSION['message'] = $message;
            header("Location: ?idp=shop");
            exit;
        }
     }


    list_categories();
} else {
    echo "User not logged in";
}