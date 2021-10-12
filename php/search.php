<?php
    include_once "./connectDb.php";
    // print_r($_POST);
    if (isset($_POST['search'])) {
        $keywords = $_POST['search'];
        $query = "SELECT * FROM `books` WHERE ";
        foreach ($keywords as $value) {
            // echo "value:". $value. "\n";
            $query .= "BINARY book_name LIKE '%$value%' OR BINARY author LIKE '%$value%' OR ";
        }
        $query = substr($query, 0, -3);
        // echo $query. "\n";
        $result = mysqli_query($db, $query);
        $output = "";
        $rows = array();
        if (mysqli_num_rows($result) > 0){
            while ($r = mysqli_fetch_assoc($result)){
                $rows['books'][] = $r;
            }
        } else {
            $rows['books'] = [];
        }
        echo json_encode($rows);
    } else if (isset($_POST['searchPending'])) {
        $keywords = $_POST['searchPending'];
        $_SESSION['searchPending'] = $keywords;
        
        echo "received";
        // print_r ($_SESSION);
    } else {
        echo "NOT FOUND";
    }
?>