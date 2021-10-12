<?php
include_once "./template/header.php";
?>
<!-- VIEW CART PAGE -->

<script src="js/cart.js"></script>

<div class='checkout-panel'>
    <h1 class='checkout-title'> My Shopping Cart </h1>
    <div class='checkout-inner'>
        <table id='checkout-table'>
            <thead>
                <tr>
                    <th> Book Name</th>
                    <th> Quantity </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum = 0;
                $_SESSION['checkout-cart'] = array();
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                    $user = $_SESSION['username'];
                    $query = "SELECT book_id,quantity FROM `carts` WHERE user_id='$user'";
                    // echo $query . "\n";
                    $result = mysqli_query($db, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $book_id = $row['book_id'];
                        $quantity = $row['quantity'];
                        $query2 = "SELECT book_id,book_name,price FROM `books` WHERE book_id='$book_id'";
                        // echo $query2 . "\n";
                        $result2 = mysqli_query($db, $query2);
                        $row2 = mysqli_fetch_array($result2);
                        $book_id = $row2['book_id'];
                        $book_name = $row2['book_name'];
                        $price = $row2['price'] * $quantity;
                        $sum += $row2['price'] * $quantity;
                        echo "<tr>
                            <td> $book_name </td>
                            <td> $quantity </td>
                            <td> <button onclick=deleteCartItem(this)> Cancel </button></td>
                            <td style='display: none;' data-id='$book_id'></td>
                            </tr>";
                        $_SESSION['checkout-cart'][$book_id] = array();
                        $_SESSION['checkout-cart'][$book_id]['book_name'] = $book_name;
                        $_SESSION['checkout-cart'][$book_id]['quantity'] = $quantity;
                        $_SESSION['checkout-cart'][$book_id]['price_1'] = $row2['price'];
                        $_SESSION['checkout-cart'][$book_id]['price'] = $price;
                    }
                    $_SESSION['checkout-cart-total'] = $sum;
                    // var_dump($_SESSION['checkout-cart']); 
                    if ($result->num_rows == 0){
                        echo "<script> clearCartTable(); </script>";
                    }
                } else if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $book_id => $quantity) {
                        $query = "SELECT book_name,price FROM `books` WHERE book_id='$book_id'";
                        $result = mysqli_query($db, $query);
                        $row = mysqli_fetch_array($result);
                        if (count($row) > 0) {
                            $price = $row['price'] * $quantity;
                            $sum += $row['price'] * $quantity;
                            $book_name = $row['book_name'];
                            echo "<tr>
                                    <td> $book_name</td>
                                    <td> $quantity </td>
                                    <td> <button onclick=deleteCartItem(this)> Cancel </button></td>
                                    <td style='display: none;' data-id='$book_id'></td>
                                    </tr>
                                    ";
                            $_SESSION['checkout-cart'][$book_id] = array();
                            $_SESSION['checkout-cart'][$book_id]['book_name'] = $book_name;
                            $_SESSION['checkout-cart'][$book_id]['quantity'] = $quantity;
                            $_SESSION['checkout-cart'][$book_id]['price_1'] = $row['price'];
                            $_SESSION['checkout-cart'][$book_id]['price'] = $price;
                        }
                        $_SESSION['checkout-cart-total'] = $sum;
                    }
                    if (count($_SESSION['cart']) == 0){
                        echo "<script> clearCartTable(); </script>";
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="checkout-bottom">
            <div class="checkout-sum">
                <span class='checkout-sum-prefix' style="font-size: 0.85em; color:#808080;"> <?php if ($sum > 0) {echo "Subtotal:";} ?> </span>
                <span class='checkout-sum-val'> <?php if ($sum > 0) { echo "$" . $sum . ".00"; }?></span>
            </div>

            <div class='checkout-buttons'>
                <?php if ($sum > 0) {
                    echo "<a href='./checkout.php'><button id='checkout-checkout'> Checkout </button></a>";
                } ?>
                <a href="./index.php">
                    <button id='checkout-back'> Back </button>
                </a>
            </div>
        </div>
    </div>
</div>  


</body>