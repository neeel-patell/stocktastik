<?php
    require 'connection.php';
    session_start();
    $conn = getConn();

    $email = $_POST['email'];
    $password = hash("sha256",$_POST['password']);

    $query = "select id from login where email = '$email' and password = '$password'";
    $result = $conn->query($query);
    
    if(mysqli_num_rows($result) != 0){
        $row = $result->fetch_array();
        $_SESSION['login'] = $row['id'];
        header("location: index.php");
    }
    else{
        $result = $conn->query("select id from login where email = '$email'");
        if(mysqli_num_rows($result) == 0){
            header("location: user_login.php?msg=noemail");
        }
        else{
            header("location: user_login.php?msg=wrongpass");
        }
    }
?>