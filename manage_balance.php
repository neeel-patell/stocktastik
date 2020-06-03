<?php
    require 'connection.php';
    session_start();
    $login = $_SESSION['login'];
    $conn = getConn();
    
    $mode = $_POST['mode'];
    $amount = $_POST['rupees'].".".$_POST['paisa'];
    
    if($mode === "Withdraw"){
        $amount = 0 - $amount;
    }

    $query = "insert into passbook(amount,method,user_id) values($amount,0,$login)";
    
    if($conn->query($query) == true){
        header('location: profile.php?msg=baldone');
    }
    else{
        header('location: profile.php?msg=balfail');
    }

?>