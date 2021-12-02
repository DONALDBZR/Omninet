<?php
// Importing User
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Instantiating User
$User = new User();
// If-Statement to verify whether there is a JSON
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify whether the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->mailAddress) && !empty(json_decode(file_get_contents("php://input"))->password) && !empty(json_decode(file_get_contents("php://input"))->firstName) && !empty(json_decode(file_get_contents("php://input"))->lastName)) {
        // Calling User::register()
        $User->register();
    } else {
        // Message to be encoded and sent
        $message = array(
            "success" => "failure",
            "url" => $User->domain . "/Omninet/Register",
            "message" => "The form must be completely filled!"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
}
?>