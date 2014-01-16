<?php

require $_SERVER['DOCUMENT_ROOT'] . "/includes/constants.php";

if (!isset($_POST['error']) || !isset($_POST['errorMessage'])) {
    die("You did not submit an error, fiend!");
} else {
    session_start();

    $emailMessage = "An error was encountered on FRC Scout.\n\n";

    if (isset($_SESSION['teamNumber'])) {
//user is logged in
        $tablesToTypes = array(FTC_TEAM_ACCOUNTS => 'FTC', FRC_TEAM_ACCOUNTS => 'FRC');
        $teamNumber = $_SESSION['teamNumber'];
        $scoutName = $_SESSION['scoutName'];
        $location = $_SESSION['location'];
        $isAdmin = $_SESSION['isAdmin'];
        $teamTable = $_SESSION['teamTable'];
        $teamType = $tablesToTypes[$teamTable];
        $dataTable = $_SESSION['dataTable'];

        $adminString = $isAdmin ? "true" : "false";
        
        $emailMessage .=
                "Team number: $teamNumber\n" .
                "Scout name: $scoutName\n" .
                "Location: $location\n" .
                "Admin: $adminString\n" .
                "Team Type: $teamType\n"
        ;
    } else {
        $emailMessage .= "User was not logged in.\n";
    }

    $error = $_POST['error'];
    $errorMessage = $_POST['errorMessage'];

    $emailMessage .= "Error code: $error\n";
    
    $emailMessage .= "\nUser left error message: $errorMessage";
    
    mail("terabyte128@gmail.com", "Error encountered on FRC Scout", $emailMessage);
    
    echo '200';
}
?>
