<?php
    require 'mail/mail_sender.php';
    require 'connection.php';
    session_start();
    $conn = getConn();
    
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $query = "select id from login where email='$email' or mobile=$mobile";
    $result = $conn->query($query);
    if(mysqli_num_rows($result) == 0){
        $_SESSION = $_POST;
        $otp = rand(100000,999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otptime'] = new DateTime(date("Y-m-d H:i:s"));
        $body = "The One time password for verification is <font color='blue' size='2'><u>$otp</u></font> which is valid for 30 Minutes.";
        sendMail($email,"One Time Password for Verification",$body);
        header("location: verify_email.php");
    }
    else{
        header("location: verify_email.php?msg=ee");
    }

?>