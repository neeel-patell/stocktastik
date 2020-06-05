<?php
    session_start();
    $_SESSION['stock'] = $_GET['id'];
    header('location: sell_stock.php');
?>