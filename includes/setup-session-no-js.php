<?php

session_start();

require 'constants.php';


if (!isset($_SESSION['teamNumber'])) {
    die('Your session timed out or you forgot to login, please <a href="/index.php">try again.</a>');
} else {
    $tablesToTypes = array(FTC_TEAM_ACCOUNTS => 'FTC', FRC_TEAM_ACCOUNTS => 'FRC');
    $teamNumber = $_SESSION['teamNumber'];
    $scoutName = $_SESSION['scoutName'];
    $location = $_SESSION['location'];
    $isAdmin = $_SESSION['isAdmin'];
    $teamTable = $_SESSION['teamTable'];
    $teamType = $tablesToTypes[$teamTable];
}
?>
