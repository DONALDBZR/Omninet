<?php
// Importing all the dependencies of PHPMAiler
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/PHPMailer/src/PHPMailer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/PHPMailer/src/Exception.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/PHPMailer/src/SMTP.php";
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/API.php";
// User class
class User {
    // Class variables
    private string $mailAddress;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $type;
    public string $domain = "http://stormysystem.ddns.net";
    protected $PHPMailer;
    protected $API;
    // Constructor method
    public function __construct() {
        // Instantiating API
        $this->API = new API();
        // Instantiating PHPMailer
        $this->PHPMailer = new PHPMailer\PHPMailer\PHPMailer(true);
    }
    // Mail Address accessor method
    public function getMailAddress() {
        return $this->mailAddress;
    }
    // Password accessor method
    public function getPassword() {
        return $this->password;
    }
    // First Name accessor method
    public function getFirstName() {
        return $this->firstName;
    }
    // Last Name accessor method
    public function getLastName() {
        return $this->lastName;
    }
    // Type accessor method
    public function getType() {
        return $this->type;
    }
    // Mail Address mutator method
    public function setMailAddress($mailAddress) {
        $this->mailAddress = $mailAddress;
    }
    // Password mutator method
    public function setPassword($password) {
        $this->password = $password;
    }
    // First Name mutator method
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    // Last Name mutator method
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    // Type mutator method
    public function setType($type) {
        $this->type = $type;
    }
    // Login method
    public function login() {
        // Retrieving and decoding the JSON from the client
        $json = json_decode(file_get_contents('php://input'));
        // Selecting the data from the database
        $this->API->query("SELECT  * FROM Omninet.User WHERE UserMailAddress = :UserMailAddress");
        $this->API->bind(":UserMailAddress", $json->mailAddress);
        $this->API->execute();
        // If-statement to verify whether the user exists
        if (!empty($this->API->resultSet())) {
            // Storing the data for further processing
            $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
            // If-statement to verify whether the passwords are identical
            if (password_verify($json->password, $this->API->resultSet()[0]['UserPassword'])) {
                // Storing the data for further processing
                $this->setPassword($json->password);
                $this->setFirstName($this->API->resultSet()[0]['UserFirstName']);
                $this->setLastName($this->API->resultSet()[0]['UserLastName']);
                $this->setType($this->API->resultSet()[0]['UserType']);
                // Starting session
                session_start();
                // Assigning the Session variable to be the username of the user
                $_SESSION['mailAddress'] = $this->getMailAddress();
                // Switch-statement to check for the type of the user
                switch ($this->getType()) {
                    case 'buyer':
                        // JSON to be encoded and to be sent to the client
                        $message = array(
                            "success" => "success",
                            "url" => $this->domain . "/Omninet/Shop",
                            "message" => "You will have access to the shop!"
                        );
                        // Preparing the header for the JSON
                        header('Content-Type: application/json');
                        // Sending the JSON
                        echo json_encode($message);
                        break;
                    case 'seller':
                        // JSON to be encoded and to be sent to the client
                        $message = array(
                            "success" => "success",
                            "url" => $this->domain . "/Omninet/Seller",
                            "message" => "You will have access to the shop!"
                        );
                        // Preparing the header for the JSON
                        header('Content-Type: application/json');
                        // Sending the JSON
                        echo json_encode($message);
                        break;
                    default:
                        // JSON to be encoded and to be sent to the client
                        $message = array(
                            "success" => "failure",
                            "url" => $this->domain . "/Omninet",
                            "message" => "System Error 404: Not found"
                        );
                        // Preparing the header for the JSON
                        header('Content-Type: application/json');
                        // Sending the JSON
                        echo json_encode($message);
                        break;
                }
            } else {
                // JSON to be encoded and to be sent to the client
                $message = array(
                    "success" => "failure",
                    "url" => $this->domain . "/Omninet/User",
                    "message" => "Your password is incorrect!"
                );
                // Preparing the header for the JSON
                header('Content-Type: application/json');
                // Sending the JSON
                echo json_encode($message);
            }
        } else {
            // JSON to be encoded and to be sent to the client
            $message = array(
                "success" => "failure",
                "url" => $this->domain . "/Omninet/User",
                "message" => "You do not have an account in Omninet!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        }
    }
    // Register method
    public function register() {
        // Retrieving and decoding the JSON from the client
        $json = json_decode(file_get_contents('php://input'));
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.User WHERE UserMailAddress = :UserMailAddress");
        $this->API->bind(":UserMailAddress", $json->mailAddress);
        $this->API->execute();
        // If-statement to verify that there is no account with that mail address in the database
        if (empty($this->API->resultSet())) {
            // Storing data from the JSON for further processing
            $this->setMailAddress($json->mailAddress);
            $this->setPassword($json->password);
            $this->setFirstName($json->firstName);
            $this->setLastName($json->lastName);
            $this->setType("buyer");
            // Inserting data in the database
            $this->API->query("INSERT INTO Omninet.User (UserFirstName, UserLastName, UserMailAddress, UserPassword, UserType) VALUES (:UserFirstName, :UserLastName, :UserMailAddress, :UserPassword, :UserType)");
            $this->API->bind(":UserFirstName", $this->getFirstName());
            $this->API->bind(":UserLastName", $this->getLastName());
            $this->API->bind(":UserMailAddress", $this->getMailAddress());
            $this->API->bind(":UserType", $this->getType());
            $this->API->bind(":UserPassword", password_hash($this->getPassword(), PASSWORD_DEFAULT));
            $this->API->execute();
            // Calling Is SMTP function from PHPMailer.
            $this->PHPMailer->IsSMTP();
            // Assigning "UTF-8" as the value for the charset.
            $this->PHPMailer->CharSet = "UTF-8";
            // Assigning the host for gmail's SMTP.
            $this->PHPMailer->Host = "ssl://smtp.gmail.com";
            // Setting the debug mode to 0.
            $this->PHPMailer->SMTPDebug = 0;
            // Assigning the Port to 465 as GMail uses 465 as it also means that port 465 has been forwarded for its use.
            $this->PHPMailer->Port = 465;
            // Securing the SMTP connection by using SSL.
            $this->PHPMailer->SMTPSecure = 'ssl';
            // Enabling authorization for SMTP.
            $this->PHPMailer->SMTPAuth = true;
            // Ensuring that PHPMailer is called from a .html file.
            $this->PHPMailer->IsHTML(true);
            // Sender's mail address.
            $this->PHPMailer->Username = "1111MailAddress";
            // Sender's password
            $this->PHPMailer->Password = "mailAddress_password";
            // Assigning sender as a parameter in the sender's zone.
            $this->PHPMailer->setFrom($this->PHPMailer->Username);
            // Assinging the receiver mail's address which is retrieved from the User class.
            $this->PHPMailer->addAddress($this->getMailAddress());
            $this->PHPMailer->Subject = "Omninet: Registration Complete!";
            $this->PHPMailer->Body = "You have been successfully registered into the system!";
            // Sending the mail.
            $this->PHPMailer->send();
            // Message to be encoded and sent to the client
            $message = array(
                "success" => "success",
                "url" => $this->domain . "/Omninet/User",
                "message" => "You have been successfully registered into the system and a mail has been sent to you!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        } else {
            // Message to be encoded and sent to the client
            $message = array(
                "success" => "failure",
                "url" => $this->domain . "/Omninet/User",
                "message" => "There is already an account with this mail address!  Please log into your account!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        }
    }
    // Generate Password method
    public function generatePassword() {
        return uniqid();
    }
    // Reset Password method
    public function resetPassword() {
        // Retrieving and decoding the JSON from the client
        $json = json_decode(file_get_contents('php://input'));
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.User WHERE UserMailAddress = :UserMailAddress");
        $this->API->bind(":UserMailAddress", $json->mailAddress);
        $this->API->execute();
        // If-statement to verify that there is an account with this mail address
        if (!empty($this->API->resultSet())) {
            // Storing data for further processing
            $this->setPassword($this->generatePassword());
            // Updating the data in the database
            $this->API->query("UPDATE Omninet.User SET UserPassword = :UserPassword WHERE UserMailAddress = :UserMailAddress");
            $this->API->bind(":UserMailAddress", $this->getMailAddress());
            $this->API->bind(":UserPassword", $this->getPassword());
            $this->API->execute();
            // Executing the query
            $this->API->execute();
            // Calling PHPMailer::IsSMTP()
            $this->Mail->IsSMTP();
            // Setting the charset to be UTF-8
            $this->Mail->CharSet = "UTF-8";
            // Setting the host according to the Mail service provider
            $this->Mail->Host = "ssl://smtp.gmail.com";
            // Setting the SMTP Debugging mode to off
            $this->Mail->SMTPDebug = 0;
            // Setting the port of the mail service provider to TCP 465 port
            $this->Mail->Port = 465;
            // Setting the SMTP Secure mode to SSL connection
            $this->Mail->SMTPSecure = 'ssl';
            // Enablig the SMTP Authorization mode
            $this->Mail->SMTPAuth = true;
            // Assuring that the mail is sent from HTML mode
            $this->Mail->IsHTML(true);
            // Setting the sender's mail address
            $this->Mail->Username = "1111MailAddress";
            // Setting the sender's password
            $this->Mail->Password = "mailAddress_password";
            // Assigning the sender's mail address from PHPMailer::Username
            $this->Mail->setFrom($this->Mail->Username);
            // Assigning the recipient address from User::getMailAddress()
            $this->Mail->addAddress($this->getMailAddress());
            // Setting the subject
            $this->Mail->Subject = "Omninet: Password reset";
            // Setting the body
            $this->Mail->Body = "Your password has been resetted.  Your new password is " . $this->getPassword() . ".";
            // Sending the mail
            $this->Mail->send();
            // Message to be encoded and sent to the client
            $message = array(
                "success" => "success",
                "url" => $this->domain . "/Omninet",
                "message" => "Your password has been reset and sent to your mail!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        } else {
            // Message to be encoded and sent to the client
            $message = array(
                "success" => "failure",
                "url" => $this->domain . "/Omninet",
                "message" => "That account does not exist!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        }
    }
    // Check Session method
    public function checkSession() {
        // If-statement to verify the user is logged in
        if (!isset($_SESSION['mailAddress'])) {
            // Redirecting the user
            header('Location:' . $this->domain . '/Omninet');
        }
    }
    // Show Profile method
    public function showProfile() {
        // Storing the data for further processing
        $this->setMailAddress($_SESSION['mailAddress']);
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.User WHERE UserMailAddress = :UserMailAddress");
        $this->API->bind(":UserMailAddress", $this->getMailAddress());
        $this->API->execute();
        // Message to be encoded and sent
        $message = array(
            "content" => "data",
            "data" => $this->API->resultSet()[0]
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
}
?>