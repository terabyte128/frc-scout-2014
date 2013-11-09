<?php
session_start();

if (isset($_SESSION['teamNumber'])) {
    header('location: home/index.php');
}
?>
