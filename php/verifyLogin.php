<?php
include_once "./connectDb.php";
include_once "cart.php";

if (isset($_POST['login'])) {
    $db = Database::getConnection();
    $user = $_POST['user'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE user_id='$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) == 1 && $password == $row['password']){
        echo "<html>
        <style>
            * {
                font-family: system-ui;
            }
        
            div.container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
            }
        
            h1 {
                color: #2f989f;
                font-size: 2em;
                text-align: center;
                margin-bottom: 2px;
            }
        
            p {
                text-align: center;
            }
        </style>
        <div class='container'>
            <h1> Login Successful </h1>
            <p> Redirect to main page after 1 seconds...</p>
        </div>
        
        </html>";
        // echo "<p>Redirect to main page after 1 seconds...</p>";
        $_SESSION['loggedin'] = True;
        $_SESSION['username'] = $user;
        $redirect_url = "index.php";
        Cart::insertAllCartItems();
        if (isset($_POST['redirect'])){
            $redirect_url = $_POST['redirect'];
        }
        header("refresh:1 url=../$redirect_url");
        // Redirect
    } else {
        echo "<html>
        <style>
            * {
                font-family: system-ui;
            }
        
            div.container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
            }
        
            h1 {
                color: #2f989f;
                font-size: 2em;
                text-align: center;
                margin-bottom: 2px;
            }
        
            p {
                text-align: center;
            }
        </style>
        <div class='container'>
            
            <h1> Invalid login, please login again. </h1>
            <p> Redirect to login page after 3 seconds... </p>
        </div>
        
        </html>";
        header("refresh:3; url= ../login.php");
    }
} else {
    echo "Not found";
}

