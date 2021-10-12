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
    <title>IntelliBook Book Store</title>
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
</head>

<body>
    <div class='main-search-panel'>
        <div class='search-bar'>
            <form class='search-bar'>
                <div class='inner-form'>
                    <button class="btn-search" type="button">
                        <svg xmlns="" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                        </svg>
                    </button>
                    <script type="text/javascript">
                        $("div.inner-form").on('click', "button.btn-search", function() {
                            searchBarRoute();
                        })
                        $('div.inner-form').on('keydown', "input[id*='search']", function(e) {
                            if (e.code === "Enter") {
                                searchBarRoute();
                            }
                        })
                        $(function() {
                            $("form.search-bar").submit(function() {
                                return false;
                            });
                        });
                        $('div.inner-form').on('focus', "input#search", function() {
                            $('input#search').css({
                                "background": "#fff",
                                "color": "rgb(31, 31, 31)",
                                "box-shadow": "1px 4px 10px 4px rgb(65 69 73 / 30%), 0px -3px 7px 1px rgb(65 69 73 / 15%)",
                            })
                        })
                        $('div.inner-form').on('blur', "input#search", function() {
                            console.log("LEave")
                            $('input#search').css({
                                "background": "rgb(218, 218, 218)",
                                "color": "#666",
                                "box-shadow": "none",
                            })
                        })
                    </script>
                    <?php
                        $searchStr = "";
                        if (isset($_SESSION['searchPending'])) {
                            foreach ($_SESSION['searchPending'] as $key => $value) {
                                $searchStr .= $value;
                                $searchStr .= " ";
                            }
                            unset($_SESSION['searchPending']);
                        }
                        echo "<div class='search-bar-0'>
                        <input id='search' type='text' placeholder='Keyword(s)' value='$searchStr'></div>";
                    ?>
                </div>
            </form>
        </div>
        <div class="button-panel">
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                // echo $_SESSION['loggedin'];
                echo '<button id="logout-btn" class="top logout">Logout</button>';
                echo '<button id="cart-btn" class="top cart"> Cart <span id="cart-counter">' . Cart::getCartCount() . '</span>
                    </button>';
            } else {
                echo '<button id="sign-in-btn" class="top sign-in">Sign In</button>
                    <button id="register-btn" class="top create-acct">Register</button>';
                echo '<button id="cart-btn" class="top cart">Cart
                    <span id="cart-counter">' . array_sum($_SESSION['cart']) . '</span>
                    </button>';
            }
            // print_r ($_SESSION['cart']);
            ?>
            <script type="text/javascript">
                $("div.button-panel").on('click', "button#cart-btn", function() {
                    document.location.href = "./viewCart.php";
                })
                $("div.button-panel").on('click', "button#sign-in-btn", function() {
                    document.location.href = "./login.php";
                })
                $("div.button-panel").on('click', "button#register-btn", function() {
                    document.location.href = "./create.php";
                })
                $("div.button-panel").on('click', "button#logout-btn", function() {
                    document.location.href = "./php/logout.php";
                })
            </script>
        </div>
    </div>