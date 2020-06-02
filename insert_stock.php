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
    
    $query = "select bank_balance,stock_balance from login where id=$login";
    $result = $conn->query($query);
    $row = $result->fetch_array();
    $bank = $row['bank_balance'];
    $stock = $row['stock_balance'];

    if($total > $bank){
        header("location: journal.php?msg=nobal");
    }
    else{
        $query = "insert into journal(name,price,quantity,date,time,rule_follow,user_id) values('$name',$price,$quantity,'$date','$time',$rule,$login)";
        if($conn->query($query) == true){
            $bank = $bank - $total;
            $stock = $stock + $total;
            $query = "UPDATE login set bank_balance=$bank, stock_balance=$stock where id=$login";
            $conn->query($query);
            header("location: journal.php?msg=added");
        }
        else{
            header("location: journal.php?msg=notadded");
        }
    }

?>