<?php
include("cart_functions.php");

echo "<button onclick=location.href='?idp=shop' type='button'>
    Shop
    </button>";

if($_SESSION['loginFailed'] == 0) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cart_product_delete_id'])) {
            $message = removeFromCart();
            $_SESSION['message'] = $message;
            header("Location: ?idp=cart");
            exit;
        }
    }

    echo showCartContent();

}
