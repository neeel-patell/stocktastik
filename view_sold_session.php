<?php
    session_start();
    require 'connection.php';
    $conn = getConn();
    $stock = $_GET['id'];
    $query = "select user_id from journal where id=$stock";
    $result = $conn->query($query);
    $row = $result->fetch_array();
    if(isset($_SESSION['login']) == true){
        if($row['user_id'] != $_SESSION['login']){
            unset($_SESSION['login']);
            header("location: user_login.php");
        }
        else{
            $_SESSION['view_stock'] = $stock;
            header('location: sold_stock.php');
        }
    }
    else{
        session_unset();
        header('location: user_login.php');
    }
?>