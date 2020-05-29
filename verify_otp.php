<?php
    session_start();
    $otp = $_POST['otp'];
    $otpsent = $_SESSION['otp'];
    $otptime = $_SESSION['otptime'];
    $time = new DateTime(date("Y-m-d H:i:s"));
    $diff = $otptime->diff($time);
    $min = $diff->i;
    if(isset($_SESSION['counter'])){
        $counter = $_SESSION['counter'] + 1;
    }
    else{
        $counter = 1;
    }
    if($otp == $otpsent && $min <= 30 && $min >= 0 && $counter <= 5){
        $_SESSION['otpverify'] = 1;
        header("location: registration.php");
    }
    else{
        if($min > 30 || $min < 0){
            header("location: verify_email.php?msg=te");
        }
        else if($counter > 5){
            header("location: verify_email.php?msg=mt");
        }
        else{
            header("location: verify_email.php?msg=nm");
        }
        
    }
?>