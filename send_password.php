<?php
    require 'connection.php';
    require 'mail/mail_sender.php';
    $conn = getConn();
    $email = $_POST['email'];
    $query = "select id from login where email='$email'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result) == 0){
        header("location: forgot_password.php?msg=noemail");
    }
    else{
        $string = getRandom();
        $query = "update login set password='".hash('sha256',$string)."' where email='$email'";
        if($conn->query($query) == true){
            $body = "Your new Password to login is <font color='red' size=2><b>$string</b></font>. You can use it as your password for login";
            sendMail($email,"New Password for login",$body);
            header('location: index.php?msg=pr');
        }
    }

    function getRandom() { 
        $characters = '@!#$%^&*0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
        for ($i = 0; $i < 8; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
        return $randomString; 
    } 
?>