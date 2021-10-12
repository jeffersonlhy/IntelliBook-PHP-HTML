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
    <title> IntelliBook - Invoice</title>
    <link rel="stylesheet" href="checkout.css">
    <script src="js/invoice.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class='checkout-header'>
        <div class='company-info'>
            <img class='icon' src='./img/logo.svg'>
        </div>
    </div>

    <div class='invoice-center'>
        <div class='invoice-inner'>
            <div class='invoice-heading'>
                Invoice
            </div>
            <div class='address-summary'>
                <div class='summary-heading'>
                    <span class="material-icons">
                        info
                    </span>
                    <span> Shipping Details </span>
                </div>
                <table class='address-table'>
                    <tr class='table-control'></tr>
                    <?php
                    function getName($raw)
                    {
                        return str_replace('_', ' ', $raw);
                    }
                    foreach ($_POST as $key => $value) {
                        if ($value != "" && $key != "user" && $key != "password") {
                            echo "<tr>
                                <td>" .  getName($key) . "</td>
                                <td> $value </td>
                                </tr>";
                        }
                    }
                    ?>
                    <tr class='table-control'></tr>
                </table>
            </div>
            <div class='checkout-summary'>
                <div class='summary-heading'>
                    <span class="material-icons">
                        info
                    </span>
                    <span> Order Summary </span>

                </div>

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
        <div class="thank-you"> Thanks for ordering. Your books will be delivered within 7 working days. </div>
        <button class='back-main'> OK </button>
        <div class='page-control' style='height: 60px'></div>
    </div>
</body>