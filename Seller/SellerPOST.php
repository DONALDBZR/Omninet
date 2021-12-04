<?php
// Importing Item
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Item.php';
// Instantiating Item
$Item = new Item();
// If-Statement to verify whether there is a JSON
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify whether the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->name)) {
        // Calling Item::checkItem()
        $Item->checkItem();
    } else {
        // Message to be encoded and sent
        $message = array(
            "success" => "failure",
            "url" => $Item->domain . "/Omninet/Seller",
            "message" => "The form must be filled completely"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
}
?>