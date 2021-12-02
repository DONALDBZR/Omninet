<?php
// Importing User
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Importing Login
require $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Login.php';
// Instantiating User
$User = new User();
// Instantiating Login
$Login = new Login();
// If-Statement to verify whether there is a JSON
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify whether the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->mailAddress) && !empty(json_decode(file_get_contents("php://input"))->password)) {
        // Calling User::login()
        $User->login();
        // Calling Login::track()
        $Login->track();
    } else {
        // Message to be encoded and sent
        $message = array(
            "success" => "failure",
            "url" => $User->domain . "/StormySystems2/Login",
            "message" => "The form must be filled completely"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
}
?>