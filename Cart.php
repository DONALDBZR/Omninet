<?php
// Importing User
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/User.php";
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/API.php";
// Importing Item
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/Item.php";
// Cart class
class Cart {
    // Class variables
    private int $id;
    private string $user;
    private int $item;
    private int $amount;
    private float $price;
    private float $netValue = 0.00;
    protected User $User;
    protected Item $Item;
    protected API $API;
    // Constructor method
    public function __construct() {
        // Instantiating the user
        $this->User = new User();
        // Instantiating the item
        $this->Item = new Item();
        // Instantiating the API
        $this->API = new API();
    }
    // ID accessor method
    public function getId() {
        return $this->id;
    }
    // ID mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // User accessor method
    public function getUser() {
        return $this->user;
    }
    // User mutator method
    public function setUser($user) {
        $this->user = $user;
    }
    // Item accessor method
    public function getItem() {
        return $this->item;
    }
    // Item mutator method
    public function setItem($item) {
        $this->item = $item;
    }
    // Amount accessor method
    public function getAmount() {
        return $this->amount;
    }
    // Amount mutator method
    public function setAmount($amount) {
        $this->amount = $amount;
    }
    // Price accessor method
    public function getPrice() {
        return $this->price;
    }
    // Price mutator method
    public function setPrice($price) {
        $this->price = $price;
    }
    // Net Value accessor method
    public function getNetValue() {
        return $this->netValue;
    }
    // Net Value mutator method
    public function setNetValue($netValue) {
        $this->netValue = $netValue;
    }
    // Put It In method
    public function putItIn() {
        // Retrieving the data needed from the cookie
        $this->Item->setId($_COOKIE["itemId"]);
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.Item WHERE ItemId = :ItemId");
        $this->API->bind(":ItemId", $this->Item->getId());
        $this->API->execute();
        // Storing the data needed for further processing
        $this->setAmount($_POST['amount']);
        $this->setItem($this->API->resultSet()[0]['ItemId']);
        $this->setUser($_SESSION['mailAddress']);
        $this->setPrice($this->API->resultSet()[0]['ItemPrice']);
        $this->Item->setQuantity($this->API->resultSet()[0]['ItemQuantity']);
        // If-statement to verify that the amount of items ordered are less than the quantity of items
        if ($this->Item->getQuantity() >= $this->getAmount()) {
            // Selecting data from the database
            $this->API->query("SELECT * FROM Omninet.Cart WHERE CartUser = :CartUser");
            $this->API->bind(":CartUser", $this->getUser());
            $this->API->execute();
            // For-loop to iterate over the cart's items to obtain its worth
            for ($index = 0; $index < count($this->API->resultSet()); $index++) { 
                $this->setNetValue($this->getNetValue() + ($this->API->resultSet()[$index]['CartAmount'] * $this->API->resultSet()[$index]['CartPrice']));
            }
            // Storing the cumulative amount from the cart stored in the database with the addition of the cart that is just filled by the user
            $this->setNetValue($this->getNetValue() + ($this->getAmount() * $this->getPrice()));
            // If-statement to verify whether the net value of the cart is less than 1000
            if ($this->getNetValue() < 1000) {
                // Inserting data in the database
                $this->API->query("INSERT INTO Omninet.Cart (CartAmount, CartItem, CartUser, CartPrice) VALUES (:CartAmount, :CartItem, :CartUser, :CartPrice)");
                $this->API->bind(":CartAmount", $this->getAmount());
                $this->API->bind(":CartItem", $this->getItem());
                $this->API->bind(":CartUser", $this->getUser());
                $this->API->bind(":CartPrice", $this->getPrice());
                $this->API->execute();
                // Removing the amount that was added to the cart from the item's table
                $this->Item->setQuantity($this->Item->getQuantity() - $this->getAmount());
                // Updating the Item's table
                $this->API->query("UPDATE Omninet.Item SET ItemQuantity = :ItemQuantity WHERE ItemId = :ItemId");
                $this->API->bind(":ItemQuantity", $this->Item->getQuantity());
                $this->API->bind(":ItemId", $this->getItem());
                $this->API->execute();
                // Printing the message
                echo "<h1 id='success'>Your cart has been stored!</h1>";
                // Redirecting the user after a timer
                header("refresh: 3.467; url=" . $this->User->domain . "/Omninet/Shop/Cart");
            } else {
                // Printing the message
                echo "<h1 id='failure'>Your cart is too expensive!  Please check out with the amount that you already have</h1>";
                // Redirecting the user after a timer
                header("refresh: 3.467; url=" . $this->User->domain . "/Omninet/Shop/Cart");
            }
        } else {
            // Printing the message
            echo "<h1 id='failure'>This item is out of stock!</h1>";
            // Redirecting the user after a timer
            header("refresh: 3.467; url=" . $this->User->domain . "/Omninet/Shop/Cart");
        }
    }
}
?>