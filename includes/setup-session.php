<?php

session_start();

require_once 'constants.php';


if (!isset($_SESSION['teamNumber'])) {
    require_once 'message-control.php';
    echo '<script type="text/javascript">',
    'loadPageWithMessage("/", "Your session timed out or you forgot to log in, please try again.", "danger");',
    '</script>';
} else {
    $tablesToTypes = array(FTC_TEAM_ACCOUNTS => 'FTC', FRC_TEAM_ACCOUNTS => 'FRC');
    $teamNumber = $_SESSION['teamNumber'];
    $scoutName = $_SESSION['scoutName'];
    $location = $_SESSION['location'];
    $isAdmin = $_SESSION['isAdmin'];
    $teamTable = $_SESSION['teamTable'];
    $teamType = $tablesToTypes[$teamTable];
    $dataTable = $_SESSION['dataTable'];
}
?>
