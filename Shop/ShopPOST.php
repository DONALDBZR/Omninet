<?php
// Importing Cart
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Cart.php';
// Instantiating Cart
$Cart = new Cart();
// If-Statement to verify whether there is a JSON
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify whether the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->amount)) {
        // Adding the item in the cart
        $Cart->putItIn();
    } else {
        // Message to be encoded and sent
        $message = array(
            "success" => "failure",
            "url" => $Item->domain . "/Omninet/Shop",
            "message" => "The form must be filled completely"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
}
?>