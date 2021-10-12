<?php
session_start();

if (!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
if (!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = False;
}

// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = array();
// }
