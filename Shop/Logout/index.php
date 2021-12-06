<?php
// Importing the front-end
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/public/Pages/Logout.html';
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Instantiating User
$User = new User();
// Starting session which is related to its session ID.
session_start();
// Destroying the session that was started.
session_destroy();
// It will redirect the user after printing that message that was stored earlier.
header('refresh:3.4; url=' . $User->domain . '/Omninet');
?>