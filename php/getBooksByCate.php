<?php
    include_once "./connectDb.php";
    if (isset($_POST['category'])) {
        $db = Database::getConnection();
        $cate = $_POST['category'];
        $query = "SELECT * FROM `books` WHERE category='$cate'";
        $result = mysqli_query($db, $query);
        $output = "";
        $rows = array();
        if ($result){
            while ($r = mysqli_fetch_assoc($result)){
                $rows['books'][] = $r;
            }
            echo json_encode($rows);
        }
    } else if (isset($_POST['all']) && $_POST['all']){
        $db = Database::getConnection();
        $query = "SELECT * FROM `books`";
        $result = mysqli_query($db, $query);
        $output = "";
        $rows = array();
        if ($result){
            while ($r = mysqli_fetch_assoc($result)){
                $rows['books'][] = $r;
            }
            // echo $rows;
            echo json_encode($rows);
        }
    }
?>