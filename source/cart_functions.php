<?php
session_start();

function updateItemQuantity($id, $item_stock) {
    include("cfg.php");

    $query="UPDATE `product` SET `ilosc` = $item_stock WHERE `id` = $id ";
    echo $query;
    $result=mysqli_query($link, $query);
    if($result) {
        return true;
    } else {
        return false;
    }
}

function addToCart() {

    if (!isset($_SESSION['items_count'])) {
        $_SESSION['items_count'] = 1;
    } else {
        $_SESSION['items_count'] ++;
    }
    $item_no = $_SESSION['items_count'];

    $item_id = $_POST['add_to_cart_id'];
    $item_stock = $_POST['add_to_cart_quantity_left'] - 1;

    $update = updateItemQuantity($item_id, $item_stock);

    if (!$update) {
        return "Failed adding item to cart";
    }

    $exists = false;
    for ($i = 1; $i <= $item_no; $i++) {
        if($_SESSION['cart'][$i]["id"]==$item_id){
            $_SESSION['cart'][$i]["quantity"] ++;
            $exists = true;
            break;
        }
    }
    if(!$exists) {
        $_SESSION['cart'][$item_no] = array('id' => $item_id, 'quantity' => 1);
    }

    return  "Item added to cart!";
}

function removeFromCart() {


    $current_id = $_POST['cart_product_delete_id'];
    $products = $_SESSION['cart'];

    $delete = null;

    foreach ($products as $product) {
        if ($product['id'] == $current_id) {
            $delete = $product;
        }
    }

    if ($delete == null) {
        return "Failed removing from cart!";
    }

    $item_no = array_search($delete, $products);

    $new_quantity = $_POST['cart_product_delete_quantity']+1;
    $current_id = $_SESSION['cart'][$item_no]["id"];

    if(!updateItemQuantity($current_id, $new_quantity)) {
        return "Failed removing from cart!";
    }

    $_SESSION['cart'][$item_no]['quantity']--;
    $_SESSION['items_count']--;


    if ($_SESSION['cart'][$item_no]['quantity'] == 0) {
        unset( $_SESSION['cart'][$item_no]);
    }

    return "Removed item from cart!";
}

function showCartContent() {
    $item_count = $_SESSION['items_count'];
    $cena_all = 0;
    $site_result = "";
    $site_result .= "<div >
        <div>
            <table >
                <thead>                   
                   
                    <th><span>zdjecie</span></th>
                    <th><span>cena brutto za sztuke</span></th>
                    <th><span>ilosc</span></th>
                    <th><span>akcje</span></th>
                </thead>";

    if($item_count == 0) {
        return "Empty cart, Try adding some product in the shop page!";
    }

    $products = $_SESSION['cart'];

    foreach ($products as $product) {
        $current_id = $product["id"];
        $quantity_in_cart = $product["quantity"];

        include("cfg.php");


        $query="SELECT * FROM `product` WHERE id = $current_id LIMIT 1";
        $result=mysqli_query($link, $query);

        while($row = mysqli_fetch_array($result)) {
            $zdjecie = base64_encode($row['zdjecie']);
            $cena_netto = $row['cena_netto'];
            $vat = $row['vat'];
            $ilosc = $row['ilosc'];
            $brutto = round($cena_netto + $cena_netto * ($vat/100), 2);
            $zdjecie = base64_encode($row['zdjecie']);

            $cena_all += $brutto * $quantity_in_cart;

            $site_result .=  "        
                <tbody'>
                    <tr> 
                    <td><img style='width: 75px; height: 75px' src='data:image/jpeg;base64, $zdjecie'/></td>
                    <td>$brutto</td>
                    <td>$quantity_in_cart</td>
                    <td>
                    <form method='post'>
                        <input type='hidden' name='cart_product_delete_id' value='". $current_id ."'/>
                        <input type='hidden' name='cart_product_delete_quantity' value='".$ilosc."'/>
                        <input type='submit' name='delete' value='Usun z koszyka'/>
                    </form>
                    </td>
                    </tr>       
                </tbody>
            
        ";
        }
    }

    $site_result .= "</table>
            
        </div>
        
        </div>
        
        <h3>Cena: $cena_all ZŁ</h3>
        ";

    return $site_result;
}

