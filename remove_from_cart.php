<?php
// start session
session_start();
 
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : "";
 
// remove the item from the array
unset($_SESSION['cart'][$id]);
unset( $_SESSION['id'][$id]);
// redirect to product list and tell the user it was added to cart
header('Location: cart.php?action=removed&id=' . $id);
?>