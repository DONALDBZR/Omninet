<?php
// Importing the Login
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/User.php";
// Login class
class Login extends User {
    // Class variables
    private int $id;
    private string $user;
    private string $date;
    // Constructor method
    public function __construct() {
        // Instantiating API
        $this->API = new API();
    }
    // Id accessor method
    public function getId() {
        return $this->id;
    }
    // User accessor method
    public function getUser() {
        return $this->user;
    }
    // Date accessor method
    public function getDate() {
        return $this->date;
    }
    // Id mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // User mutator method
    public function setUser($user) {
        $this->user = $user;
    }
    // Date mutator method
    public function setDate() {
        // Setting the default Timezone to UTC + 4
        date_default_timezone_set("Indian/Mauritius");
        $this->date = date("Y-m-d H:i:s");
    }
    // Track method
    public function track() {
        // Retrieving and decoding the JSON from the client
        $json = json_decode(file_get_contents('php://input'));
        // Selecting the data from the database
        $this->API->query("SELECT * FROM Omninet.User WHERE UserMailAddress = :UserMailAddress");
        $this->API->bind(":UserMailAddress", $json->mailAddress);
        $this->API->execute();
        // Storing the data for further processing
        $this->setUser($this->API->resultSet()[0]['UserMailAddress']);
        $this->setDate();
        // Inserting the data in the database
        $this->API->query("INSERT INTO Omninet.Login (LoginUser, LoginDate) VALUES (:LoginUser, :LoginDate)");
        $this->API->bind(":LoginUser", $this->getUser());
        $this->API->bind(":LoginDate", $this->getDate());
        $this->API->execute();
    }
}
?>