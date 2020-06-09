<?php
    session_start();
    require 'connection.php';
    $conn = getConn();
    $login = $_SESSION['login'];

    $name = $_POST['name'];
    $price = $_POST['rupees'].".".$_POST['paisa'];
    $quantity = $_POST['quantity'];
    $date = date('Y-m-d',strtotime($_POST['stock_date']));
    $time = date('H:i:s',strtotime($_POST['stock_time']));
    $rule = $_POST['rule'];
    $description = $_POST['description'];
    $total = $price * $quantity;
    
    $query = "select sum(amount)'diposite' from passbook where user_id=$login and method=0";
    $result = $conn->query($query);
    $bank = $result->fetch_array();
    $query = "select sum(amount)'balance' from passbook where user_id=$login and method=1";
    $result = $conn->query($query);
    $stock = $result->fetch_array();
    $bank = $bank['diposite'] - $stock['balance'];
    $timestamp = date('Y-m-d H:i:s',strtotime($date." ".$time));
    
    if($total > $bank){
        header("location: journal.php?msg=nobal");
    }
    else{
        $query = "insert into journal(name,price,quantity,date,time,rule_follow,description,user_id) values('$name',$price,$quantity,'$date','$time',$rule,'$description',$login);
                  insert into passbook(`date`,amount,method,user_id) values('$timestamp',$total,1,$login);";
        if($conn->multi_query($query) == true){
            header("location: journal.php?msg=added");
        }
        else{
            header("location: journal.php?msg=notadded");
        }
    }

?>