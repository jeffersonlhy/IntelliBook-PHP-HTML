<?php
include_once "connectDb.php";

class Cart
{
    public static function route()
    {
        if (isset($_POST['quantity'])) {
            Cart::updateCart();
        }
        if (isset($_GET['action']) && isset($_GET['bookid'])) {
            Cart::deleteCartItem();
        }
        if (isset($_POST['massDelete'])) {
            Cart::deleteAfterPurchase();
        }
        if (isset($_GET['getCartCount'])) {
            echo Cart::getCartCount();
        }
        if (isset($_GET['getCartPriceSum'])){
            Cart::getCartPriceSum();
        }
        if (isset($_GET['getCheckoutItems'])){
            Cart::getCheckoutItems();
        }
    }

    public static function updateCart()
    {
        if (isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
            $book_id = $_GET['book_id'];
            $db = Database::getConnection();
            $rows = array();
            if ($_SESSION['loggedin']) {
                // echo 'loggedin'. "\n";
                $user = $_SESSION['username'];
                $query = "UPDATE `carts` SET quantity=quantity+'$quantity' WHERE user_id='$user' AND book_id='$book_id'";
                echo $query . "\n";
                $result = mysqli_query($db, $query);
                $count = mysqli_affected_rows($db);
                if ($count > 0) {
                    $rows['status'] = 'success';
                    $rows['book_id'] = $book_id;
                    $rows['action'] = 'Update';
                    $rows['added'] = $quantity;
                } else {
                    $query = "INSERT INTO `carts` (book_id,user_id,quantity) VALUES ('$book_id','$user','$quantity')";
                    $result = mysqli_query($db, $query);
                    $count = mysqli_affected_rows($db);
                    if ($count > 0) {
                        $rows['status'] = 'success';
                        $rows['book_id'] = $book_id;
                        $rows['action'] = 'Insert';
                        $rows['added'] = $quantity;
                    }
                }
                echo json_encode($rows);
            } else {
                if (!isset($_SESSION['cart'][$book_id])) {
                    $_SESSION['cart'][$book_id] = (int) $quantity;
                } else {
                    $_SESSION['cart'][$book_id] += $quantity;
                }
                $rows['status'] = 'success';
                $rows['added'] = $_SESSION['cart'];
                echo json_encode($rows);
            }
        }
    }

    public static function getCartCount()
    {
        $db = Database::getConnection();
        // Logged in
        if (isset($_SESSION['username'])){
            $user = $_SESSION['username'];
            $query = "SELECT SUM(quantity) FROM `carts` WHERE user_id='$user'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);
            if ($row[0] == NULL) {
                return 0;
            }
            return ($row[0]);
        } else {
            return array_sum($_SESSION['cart']);
        }
        // var_dump($row);
    }

    // When login is successful, all item will be added to the Cart
    public static function insertAllCartItems()
    {
        $db = Database::getConnection();
        $user = $_SESSION['username'];
        $cartItems = $_SESSION['cart'];
        foreach ($cartItems as $book_id => $quantity) {
            $query = "UPDATE `carts` SET quantity=quantity+'$quantity' WHERE user_id='$user' AND book_id='$book_id'";
            $result = mysqli_query($db, $query);
            // echo $query . "|\n";
            if (mysqli_affected_rows($db) == 0) {
                $query = "INSERT INTO `carts` (user_id,book_id,quantity) VALUES ('$user','$book_id','$quantity')";
                $result = mysqli_query($db, $query);
                if (mysqli_affected_rows($db) > 0) {
                    // echo "Success INSERT " . "Book_id " . $book_id . " : " . "$quantity" . " \n";
                }
            }
        }
        unset($_SESSION['cart']);
    }

    public static function deleteCartItem()
    {
        $db = Database::getConnection();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            $result = "";
            $userid = $_SESSION['username'];
            $bookid = $_GET['bookid'];
            $query = "DELETE FROM `carts` WHERE book_id='$bookid' && user_id='$userid'";
            echo $query . "\n";
            $result = mysqli_query($db, $query);
            if (mysqli_affected_rows($db) == 1) {
                echo "success";
                // header("Location: ../viewCart.php");
            } else {
                echo "error";
            }
        } else {
            if (isset($_SESSION['cart'][$_GET['bookid']])) {
                unset($_SESSION['cart'][$_GET['bookid']]);
                echo "success";
                // header("Location: ../viewCart.php");
            } else {
                echo "error";
            }
        }
    }

    public static function deleteAfterPurchase()
    {
        $db = Database::getConnection();
        if (isset($_SESSION['checkout-cart']) && $_SESSION['loggedin']) {
            $massResult = array();
            foreach ($_SESSION['checkout-cart'] as $key => $value) {
                $bookid = $key;
                $userid = $_SESSION['username'];
                $query = "DELETE FROM `carts` WHERE book_id='$bookid' && user_id='$userid'";
                $result = "";
                $result = mysqli_query($db, $query);
                if (mysqli_affected_rows($db) == 1){
                    $massResult[strval($bookid)] = 'success';
                }
            }
            echo json_encode($massResult);
        }
    }

    public static function getCartPriceSum(){
        $db = Database::getConnection();
        $sum = 0;
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            $user = $_SESSION['username'];
            $query = "SELECT book_id,quantity FROM `carts` WHERE user_id='$user'";
            // echo $query . "\n";
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_array($result)) {
                $book_id = $row['book_id'];
                $quantity = $row['quantity'];
                $query2 = "SELECT price FROM `books` WHERE book_id='$book_id'";
                $result2 = mysqli_query($db, $query2);
                $row2 = mysqli_fetch_array($result2);
                $sum += $row2['price'] * $quantity;
            }
        } else if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $book_id => $quantity) {
                $query = "SELECT price FROM `books` WHERE book_id='$book_id'";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_array($result);
                if (count($row) > 0) {
                    $sum += $row['price'] * $quantity;
                }
            }
        }
        echo $sum;
    }

    public static function getCheckoutItems(){
        $db = Database::getConnection();
        $sum = 0;
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
                $single_price = $row2['price'];
                $price = $row2['price'] * $quantity;
                $sum += $row2['price'] * $quantity;
                echo "<tr>
                    <td> $book_name </td>
                    <td> $quantity </td>
                    <td> $$single_price </td>
                    <td> $$price </td>
                    </tr>";
            }
        } else if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $book_id => $quantity) {
                $query = "SELECT book_name,price FROM `books` WHERE book_id='$book_id'";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_array($result);
                if (count($row) > 0) {
                    $price = $row['price'] * $quantity;
                    $book_name = $row['book_name'];
                    $single_price = $row['price'];
                    $price = $row['price'] * $quantity;
                    $sum += $row['price'] * $quantity;
                    echo "<tr>
                            <td> $book_name</td>
                            <td> $quantity </td>
                            <td> $$single_price </td>
                            <td> $$price </td>
                            </tr>
                            ";
                }
            }
        }
    }
}

Cart::route();
