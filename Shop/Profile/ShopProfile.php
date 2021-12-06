<?php
// Starting Session
session_start();
// Importing User
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Instantiating User
$User = new User();
// Fetching the profile of the user
$User->showProfile();
?>