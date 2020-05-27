<?php
    session_start();
    $otp = $_POST['otp'];
    $otpsent = $_SESSION['otp'];
    if($otp == $otpsent){
        $_SESSION['otpverify'] = 1;
        header("location: registration.php");
    }
    else{
        if(isset($_SESSION['counter'])){
            $_SESSION['counter'] = $_SESSION['counter'] + 1;
        }
        else{
            $_SESSION['counter'] = 1;
        }
        header("location: verify_email.php?msg=nm");
    }
?>