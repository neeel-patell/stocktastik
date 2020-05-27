<?php
    session_start();
    session_unset();
    header("location: verify_email.php");
?>