<?php
session_start();
include 'headers.php';

if (!isset($_SESSION['teamNumber'])) {
    echo '<script type="text/javascript">',
         'loadPageWithMessage("/", "Your session timed out or you forgot to log in, please try again.", "danger");',
         '</script>';
}

$teamNumber = $_SESSION['teamNumber'];
$scoutName = $_SESSION['scoutName'];
$location = $_SESSION['location'];
?>
