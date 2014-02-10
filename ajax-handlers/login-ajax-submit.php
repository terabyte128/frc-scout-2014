<?php

session_start();

//connect to the database
require_once '../includes/db-connect.php';

$teamNumber = $_POST['teamNumber'];
$teamPassword = $_POST['teamPassword'];
$scoutName = $_POST['scoutName'];
$teamType = $_POST['teamType'];
$location = $_POST['location'];

$typesToTableNames = array("ftc" => FTC_TEAM_ACCOUNTS, 'frc' => FRC_TEAM_ACCOUNTS);
$typesToDataTableNames = array("ftc" => FTC_SCOUTING_DATA, 'frc' => FRC_SCOUTING_DATA);

$dataTable = $typesToDataTableNames[$teamType];

$teamTable = $typesToTableNames[$teamType];

//this checks tables against a whitelist to circumvent HACKERS!
$tableWhitelist = array(FRC_TEAM_ACCOUNTS, FTC_TEAM_ACCOUNTS);

if (!in_array($teamTable, $tableWhitelist)) {
    die("Hacker!!! " . $teamTable);
}

try {
    $authenticate = $db->prepare('SELECT team_number FROM ' . $teamTable . ' WHERE team_number = ? AND team_password = md5(?)');
    $authenticate->execute(array($teamNumber, $teamPassword));
    $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to update database.");
}

if (key_exists('team_number', $teams)) {
    # Login success
    # Regenerate the session ID to avoid session fixation
    session_regenerate_id();

    # Store the team/user data. $userID is not validated. $teamID was verified via auth query.
    $_SESSION['teamNumber'] = $teamNumber;
    $_SESSION['scoutName'] = $scoutName;
    $_SESSION['location'] = $location;
    $_SESSION['isAdmin'] = false;
    $_SESSION['teamTable'] = $teamTable;
    $_SESSION['dataTable'] = $dataTable;


    # Redirect to the post-login page
    //header('location: home');
} else {
    unset($_SESSION['teamNumber']);
    unset($_SESSION['scoutName']);
    unset($_SESSION['location']);
    unset($_SESSION['isAdmin']);
    unset($_SESSION['teamTable']);
    echo "Your username, password, or team number are incorrect. Contact your team administrator for your team's password.";
}
?>
