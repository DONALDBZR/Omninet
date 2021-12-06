<?php
// Starting Session
session_start();
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/User.php';
// Instantiating User
$User = new User();
// Importing Item.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Item.php';
// Instantiating Item
$Item = new Item();
// Importing Cart.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Omninet/Cart.php';
// Instantiating Cart
$Cart = new Cart();
// Checking the session ID
$User->checkSession();
// Starting Output Buffer
ob_start();
?>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="author" content="Andy Ewen Gaspard" />
        <meta
            name="repository"
            content="https://github.com/DONALDBZR/Omninet"
        />
        <title>Omninet</title>
        <link rel="stylesheet" href="../public/Stylesheets/Shop.css" />
        <link
            rel="shortcut icon"
            href="http://stormysystem.ddns.net/StormySystems2/public/Images/Logo.ico"
            type="image/x-icon"
        />
        <script src="../public/Scripts/React/Font-Awesome.js"></script>
        <script src="../public/Scripts/Front-End/Shop.js"></script>
    </head>
    <body id="app">
        <header>
            <div id="logo">
                <a href="./">Omninet</a>
            </div>
            <nav>
                <div>
                    <a href="./Profile" class="fas fa-user faUser"></a>
                </div>
                <div>
                    <a
                        href="./Logout"
                        class="fas fa-sign-out-alt faLogout"
                    ></a>
                </div>
            </nav>
        </header>
        <main>
            <div id="serverRendering">
                <div id="data">
                    <?php
                    // Showing the items from the database
                    $Item->showItemForShop();
                    // If-statement to verify whether the add button is pressed
                    if (isset($_POST["add"])) {
                        // Adding the item in the cart
                        $Cart->putItIn();
                    }
                    ?>
                </div>
            </div>
        </main>
        <footer>Omninet</footer>
    </body>
</html>

<?php
// Storing the contents of the output buffer into a variable
$html = ob_get_contents();
// Deleting the contents of the output buffer.
ob_end_clean();
// Printing the html page
echo $html;
?>