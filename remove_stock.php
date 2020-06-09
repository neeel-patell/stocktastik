<?php
    session_start();
    if(isset($_SESSION['stock']) == false){
        header('location: journal.php?msg=stockfail');
    }
    else{
        $stock = $_SESSION['stock'];
        unset($_SESSION['stock']);
    }
    $login = $_SESSION['login'];
    require 'connection.php';
    $conn = getConn();
    
    $date = str_replace("/","-",$_POST['stock_date']);
    $date = date('Y-m-d',strtotime($date));

    $time = date("H:i:s",strtotime($_POST['stock_time']));
    $price = $_POST['rupees'].".".$_POST['paisa'];

    $quantity = $_POST['quantity'];
    $rule = $_POST['rule'];
    $description = $_POST['description'];
    $total = -($quantity * $price);
    $timestamp = date('Y-m-d H:i:s',strtotime($date." ".$time));
    
    $query = "INSERT INTO sold_stock(stock_id,date,time,price,quantity,rule_follow,description) 
              values($stock,'$date','$time',$price,$quantity,$rule,'$description');
              INSERT INTO passbook(`date`,amount,method,user_id) values('$timestamp',$total,1,$login);";

    if($conn->multi_query($query)){
        header('location: journal.php?msg=stocksold');
    }
    else{
        header('location: journal.php?msg=stockfail');
    }
    
?>