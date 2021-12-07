<?php
// Starting Session
session_start();
// Importing User
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Cart.php';
// Instantiating Cart
$Cart = new Cart();
// Fetching the items from the cart
$Cart->showContent();
?>