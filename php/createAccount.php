<?php
include_once "./connectDb.php";

if (isset($_POST['sign_up'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE user_id='$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) > 0){
        echo "<h1>Account already existed</h1>";
        echo "<p>Redirect to create account page after 3 seconds...</p>";
        header("refresh:3; url= ./create.php");
    } else {
        $query = "INSERT INTO `users` (user_id, password) VALUES ('$user', '$password')";
        $result = mysqli_query($db, $query);
        if ($result){
            $_SESSION['loggedin'] = true;
            echo "<h1>Account created! Welcome</h1>";
            echo "<p>Redirect to login page after 3 seconds...</p>";
            header("refresh:3; url= ../login.php");
        } else {
            echo "<h1>Unknown error is occured.</h1>";
            echo "<p>Redirect to create account page after 3 seconds...</p>";
            header("refresh:3; url= ../create.php");
        }
    }
} else if (isset($_POST['check_duplicated'])){
    $user = $_POST['user'];
    $query = "SELECT * FROM users WHERE user_id='$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    $array = ['duplicated' => false];
    if (mysqli_num_rows($result) > 0){
        $array['duplicated'] = true;
    }
    echo json_encode($array);
} 
else {
    echo "Not found";
}
