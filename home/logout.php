<?php
    session_start();
    
    unset($_SESSION['teamNumber']);
    unset($_SESSION['scoutName']);
    unset($_SESSION['location']);
    unset($_SESSION['isAdmin']);
    header('location: /index.php');
    exit();
?>