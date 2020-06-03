<?php 
    require 'connection.php';
    session_start();
    $login = $_SESSION['login'];
    $conn = getConn();

    $password = hash('sha256',$_POST['password']);
    
    $query = "update login set
              `password`='$password'
              where id=$login";

    if($conn->query($query) == true){
        header('location: profile.php?msg=passdone'); 
    }
    else{
        header('location: profile.php?msg=passfail'); 
    }

?>