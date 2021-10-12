<?php
include_once "php/connectDb.php";
include_once "php/cart.php";
?>

<!doctype html>
<html lang="en">
<!-- main page -->

<head>
    <script src="js/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> IntelliBook - Checkout</title>
    <!-- <script src="js/checkout.js"></script> -->
    <link rel="stylesheet" href="checkout.css">
    <script src="js/checkout.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class='checkout-header'>
        <div class='company-info'>
            <img class='icon' src='./img/logo.svg'>
        </div>
    </div>
    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            echo "<div id='loggedin' style='display:none'></div>";
        }
    ?>
    <div class='checkout-content'>
        <div class='checkout-inner'>
            <div class='new-customer-dialog'>
                <div class='new-heading'>
                    I'm a new customer
                </div>
                <div class='new-cust-form'>
                    <form class='new-cust' action='./invoice.php' method='POST'>
                        <div class='new-cust-cred'>
                            <legend class='new-cust-heading'> Create Account: </legend>
                            <div class='new-cust-item'>
                                <label> Username </label>
                                <input type='text' id='user' class="new-cust-control" name='user' placeholder='Desired Username'>
                            </div>
                            <div class='new-cust-item'>
                                <label> Password </label>
                                <input type='text' id='password' class="new-cust-control" name='password' placeholder='Desired Password'>
                            </div>
                        </div>
                        <div class='new-cust-addr'>
                            <legend class='new-cust-addr-heading'> Delivery Address: </legend>
                            <div class='new-cust-item'>
                                <label> Full Name </label>
                                <input type='text' id='full_name' class="new-cust-control" name='Full Name' placeholder='Required'>
                            </div>
                            <div class='new-cust-item'>
                                <label> Company Name </label>
                                <input type='text' class="new-cust-control" name='Company Name' placeholder=''>
                            </div>
                            <div class='new-cust-item'>
                                <label> Address Line 1 </label>
                                <input type='text' id="addr_1" class="new-cust-control" name='Address Line 1' placeholder='Required'>
                            </div>
                            <div class='new-cust-item'>
                                <label> Address Line 2 </label>
                                <input type='text' class="new-cust-control" name='Address Line 2' placeholder=''>
                            </div>
                            <div class='new-cust-item'>
                                <label> City </label>
                                <input type='text' id="city" class="new-cust-control" name='City' placeholder='Required'>
                            </div>
                            <div class='new-cust-item'>
                                <label> Region/State/District </label>
                                <input type='text' class="new-cust-control" name='Region/State/District' placeholder=''>
                            </div>
                            <div class='new-cust-item'>
                                <label> Country </label>
                                <input type='text' id="country" class="new-cust-control" name='Country' placeholder='Required'>
                            </div>
                            <div class='new-cust-item'>
                                <label> Postcode Zip Code </label>
                                <input type='text' id="zip" class="new-cust-control" name='Postcode Zip Code' placeholder='Required'>
                            </div>
                        </div>
                        <!-- <input type='hidden' name="redirect" value="./invoice.php"> -->
                        <!-- <input type='hidden' name='check_duplicated'> -->
                        <div class='new-cust-btn-container'>
                            <button class="create-btn" type="button">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class='exist-customer-dialog'>
                <div class='exist-heading'>
                    I'm already a customer
                </div>
                </br>
                <a href="./login.php?login=1&redirect=viewCart.php">
                    <button class="login-btn" type="button">
                        Sign In
                    </button>
                </a>

            </div>
        </div>
        <div class='checkout-summary'>
            <div class='summary-heading'>
                <span class="material-icons">
                    info
                </span>
                <span> Order Summary </span>

            </div>
            <div class='change-cart'>
                <a class='change-cart-text' href='./viewCart.php'>
                    <span class="material-icons">
                        mode_edit_outline
                    </span>
                    <span>Change </span>
                </a>
            </div>
            <br>
            <table class='summary-table'>
                <thead>
                    <tr>
                        <th> Book Titles </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> Subtotal </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    Cart::getCheckoutItems();
                    ?>
                </tbody>
            </table>
            <div class='total-price'>
                Total: $<?php Cart::getCartPriceSum();?>
            </div>
        </div>
    </div>


</body>