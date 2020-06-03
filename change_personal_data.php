<?php 
    require 'connection.php';
    session_start();
    $login = $_SESSION['login'];
    $conn = getConn();

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $dob = str_replace("/","-",$dob);
    $dob = date('Y-m-d',strtotime($dob));
    $city = explode("-",$_POST['city']);
    $query = "select id from city where name='".$city[0]."' and state='".$city[1]."'";
    $city = $conn->query($query);
    $city = $city->fetch_array();
    $city = $city['id'];

    $query = "update login set
              first_name='$first_name',last_name='$last_name',mobile=$mobile,dob='$dob',city=$city
              where id=$login";

    if($conn->query($query) == true){
        header('location: profile.php?msg=done'); 
    }
    else{
        header('location: profile.php?msg=fail'); 
    }

?>