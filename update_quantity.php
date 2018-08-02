<?php
session_start();
 
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";

// make quantity a minimum of 1
$quantity=$quantity<=0 ? 1 : $quantity;
$updated_cart=$_SESSION['cart'][$id];
// print_r($updated_cart);
$updated_cart['quantity']=$quantity;

// remove the item from the array
unset($_SESSION['cart'][$id]);

// add the item with updated quantity
$_SESSION['cart'][$id]=$updated_cart;

// print_r($_SESSION['cart'][$id]);
// redirect to product list and tell the user it was added to cart
header('Location: cart.php?action=quantity_updated&id=' . $id);
?>