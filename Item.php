<?php
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . "/Omninet/API.php";
// Item class
class Item {
    // Class variables
    private int $id;
    private string $name;
    private float $price;
    private int $quantity;
    private string $imageUniformResourceLocator;
    public string $domain = "http://stormysystem.ddns.net";
    protected $API;
    // Constructor method
    public function __construct() {
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
    // Name accessor method
    public function getName() {
        return $this->name;
    }
    // Name mutator method
    public function setName($name) {
        $this->name = $name;
    }
    // Price accessor method
    public function getPrice() {
        return $this->price;
    }
    // Price mutator method
    public function setPrice($price) {
        $this->price = $price;
    }
    // Quantity accessor method
    public function getQuantity() {
        return $this->quantity;
    }
    // Quantity mutator method
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    // Image Uniform Resource Locator accessor method
    public function getImageUniformResourceLocator() {
        return $this->imageUniformResourceLocator;
    }
    // Image Uniform Resource Locator mutator method
    public function setImageUniformResourceLocator($imageUniformResourceLocator) {
        $this->imageUniformResourceLocator = $imageUniformResourceLocator;
    }
    // Random Number Generator method
    public function randomNumberGenerator(int $minimum, int $maximum) {
        return rand($minimum, $maximum);
    }
    // Check Item method
    public function checkItem() {
        // Generating the 
        $this->setId($this->randomNumberGenerator(0, 99999));
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.Item WHERE ItemId = :ItemId");
        $this->API->bind(":ItemId", $this->getId());
        $this->API->execute();
        // If-statement to verify whether that ID does not exist
        if (empty($this->API->resultSet())) {
            // Handling the price
            $this->handlePrice();
        } else {
            // Repeat the process until a unique ID is generated
            $this->checkItem();
        }
    }
    // Price handler method
    public function handlePrice() {
        // Local variable
        $value = $this->getId() / 100;
        // If-statement to verify that the calculated value is more than 100
        if ($value >= 100) {
            // Calculating the price of the item and storing it for further processing
            $this->setPrice($this->getId() / 100);
            // Adding the item
            $this->add();
        } else {
            $this->setPrice(1.00);
            // Adding the item
            $this->add();
        }
    }
    // Add method
    public function add() {
        // Retrieving and decoding the JSON from the client
        $json = json_decode(file_get_contents("php://input"));
        // Storing data for further processing
        $this->setName($json->name);
        // Inserting data in the database
        $this->API->query("INSERT INTO Omninet.Item (ItemId, ItemName, ItemPrice) VALUES (:ItemId, :ItemName, :ItemPrice)");
        $this->API->bind(":ItemId", $this->getId());
        $this->API->bind(":ItemName", $this->getName());
        $this->API->bind(":ItemPrice", $this->getPrice());
        $this->API->execute();
        // Message to be encoded and sent
        $message = array(
            "success" => "success",
            "url" => $this->domain . "/Omninet/Seller",
            "message" => $this->getName() . " has been added!"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($message);
    }
    // Show Item method
    public function showItem() {
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.Item");
        $this->API->execute();
        // If-statement to verify whether there an ietm in the database
        if (!empty($this->API->resultSet())) {
            // Message to be encoded and sent
            $message = array(
                "content" => "data",
                "data" => $this->API->resultSet()
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        } else {
            // Message to be encoded and sent
            $message = array(
                "content" => "empty",
                "data" => "There is no item in the shop!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($message);
        }
    }
    // Homepage Show Item Method
    public function homepageShowItem(){
        // Local variables
        $price = 0.00;
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.Item");
        $this->API->execute();
        // For-loop to iterate over all the items to find the item with the highest price
        for ($index = 0; $index < count($this->API->resultSet()); $index++) { 
            // If-statement to verify whether the item has the highest price
            if ($this->API->resultSet()[$index]['ItemPrice'] > $price) {
                $price = $this->API->resultSet()[$index]['ItemPrice'];
            }
        }
        // Selecting the data from the database
        $this->API->query("SELECT * FROM Omninet.Item WHERE ItemPrice = :ItemPrice");
        $this->API->bind(":ItemPrice", $price);
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
    // Show Item For Shop method
    public function showItemForShop() {
        // Selecting data from the database
        $this->API->query("SELECT * FROM Omninet.Item");
        $this->API->execute();
        // If-statement to verify whether there an ietm in the database
        if (!empty($this->API->resultSet())) {
            // For-Each loop to iterate over the result set of PDO
            foreach ($this->API->resultSet() as $result) {
                echo ("
                    <form method='POST'>
                        <div class='dataItem'>
                            <img src={$result['ItemImage']} alt={$result['ItemId']} />
                        </div>
                        <div class='dataItemName'>{$result['ItemName']}</div>
                        <div class='dataItemData'>
                            <div>
                                <h1>$ {$result['ItemPrice']}</h1>
                            </div>
                            <div>
                                <h1>Amount: {$result['ItemQuantity']}</h1>
                            </div>
                        </div>
                        <div class='cartAction'>
                            <div>
                                <input type='number' name='amount' placeholder='1' />
                            </div>
                            <div>
                                <button type='submit' name='add' id={$result['ItemId']} onClick='requestServerAttention(this.id)'>Add to Cart</button>
                            </div>
                        </div>
                    </form>
                ");
            }
        } else {
            // The message to be printed on the client
            echo "<h1>There is no item in the shop!</h1>";
        }
    }
}
?>