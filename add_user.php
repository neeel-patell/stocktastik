<?php
    require 'connection.php';
    session_start();

    $conn = getConn();
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_SESSION['email'];
    $mobile = $_SESSION['mobile'];
    session_unset();
    $dob = $_POST['dob'];
    $dob = str_replace("/","-",$dob);
    $dob = date('Y-m-d',strtotime($dob));
    $city = explode("-",$_POST['city']);
    $query = "select id from city where name='".$city[0]."' and state='".$city[1]."'";
    $city = $conn->query($query);
    $city = $city->fetch_array();
    $city = $city['id'];

    $bank = $_POST['bank_rupees'].".".$_POST['bank_paisa'];
    $password = $_POST['password'];
    $password = hash('sha256',$password);
    
    $query = "insert into login(first_name,last_name,email,mobile,dob,city,password,bank_balance) 
            values('$first_name','$last_name','$email',$mobile,'$dob',$city,'$password',$bank)";

    if($conn->query($query) == true){
        $query = "select id from login where mobile=$mobile";
        $result = $conn->query($query);
        $row = $result->fetch_array();
        $_SESSION['login'] = $row['id'];
        header('location: index.php');
    }
    else{
        header('location: verify_email.php?msg=ee');
    }

?>