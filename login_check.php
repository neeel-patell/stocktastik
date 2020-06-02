<?php
    require_once 'connection.php';
    session_start();
    $conn = getConn();
    $login = 0; 
    if(isset($_SESSION['login']) == false){
        header('location: user_login.php');
    }
    else{
        $login = $_SESSION['login'];
        if(!($login > 0)){
            header('location: user_login.php');
        }
    }
    $result = $conn->query("select first_name,last_name from login where id=$login");
    $row = $result->fetch_array();
    $name = $row['first_name']." ".$row['last_name'];
?>