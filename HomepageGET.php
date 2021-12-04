<?php
// Importing Item
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Item.php';
// Instantiating Item
$Item = new Item();
// Fetching the item with the highest price
$Item->homepageShowItem();
?>