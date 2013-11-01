<?php
session_start();

if (!isset($_SESSION['teamNumber'])) {
    header('location: ../index.php?message=' . urlencode("Your session timed out or you forgot to log in, please try again.") . "&type=danger");
}

$teamNumber = $_SESSION['teamNumber'];
$scoutName = $_SESSION['scoutName'];
$location = $_SESSION['location'];
?>
