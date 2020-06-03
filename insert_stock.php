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
    $total = $price * $quantity;
    
    $query = "select sum(amount)'diposite' from passbook where user_id=$login and method=0";
    $result = $conn->query($query);
    $bank = $result->fetch_array();
    $query = "select sum(amount)'balance' from passbook where user_id=$login and method=1";
    $result = $conn->query($query);
    $stock = $result->fetch_array();
    $bank = $bank['diposite'] - $stock['balance'];
    echo $bank;

    if($total > $bank){
        header("location: journal.php?msg=nobal");
    }
    else{
        $query = "insert into journal(name,price,quantity,date,time,rule_follow,user_id) values('$name',$price,$quantity,'$date','$time',$rule,$login);
                  insert into passbook(amount,method,user_id) values($total,1,$login)";
        if($conn->multi_query($query) == true){
            header("location: journal.php?msg=added");
            echo "Added";
        }
        else{
            header("location: journal.php?msg=notadded");
        }
    }

?>