<?php
    session_start();
    require 'connection.php';
    $conn = getConn();
    $login = $_SESSION['login'];

    $name = $_POST['name'];
    $price = $_POST['rupees'].".".$_POST['paisa'];
    $quantity = $_POST['quantity'];
    $total = $price*$quantity;

    $query = "select bank_balance,stock_balance from login where id=$login";
    $result = $conn->query($query);
    $row = $result->fetch_array();
    $bank = $row['bank_balance'];
    $stock = $row['stock_balance'];

    if($total > $bank){
        header("location: add_stock.php?msg=nobal");
    }

    else{
        $query = "insert into stock(name,price,quantity,method,user_id) values('$name',$price,$quantity,0,$login)";
        if($conn->query($query) == true){
            $bank = $bank - $total;
            $stock = $stock + $total;
            $query = "UPDATE login set bank_balance=$bank, stock_balance=$stock where id=$login";
            if($conn->query($query))
                header("location: add_stock.php?msg=added");
        }
        else{
            header("location: add_stock.php?msg=notadded");
        }
    }

?>