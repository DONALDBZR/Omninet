<?php
// Starting Session
session_start();
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Instantiating User
$User = new User();
// Checking the session ID
$User->checkSession();
// Importing the front-end
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/public/Pages/ShopProfile.html';
?>