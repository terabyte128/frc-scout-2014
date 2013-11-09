<?php
session_start();

//connect to the database
require '../includes/db-connect.php';

if (isset($_GET['logout'])) {
    unset($_SESSION['teamNumber']);
    unset($_SESSION['scoutName']);
    unset($_SESSION['location']);
    unset($_SESSION['isAdmin']);
    header('location: /index.php');
    exit();
}

$teamNumber = $_POST['teamNumber'];
$teamPassword = $_POST['teamPassword'];
$scoutName = $_POST['scoutName'];
//$location = $_POST['location'];

//TODO: integrate actual locations
$location = "TEST LOCATION";

try {
    $authenticate = $db->prepare('SELECT team_number FROM team_accounts WHERE team_number = ? AND team_password = md5(?)');
    $authenticate->execute(array($teamNumber, $teamPassword));
    $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if (key_exists('team_number', $teams)) {
    # Login success
    # Regenerate the session ID to avoid session fixation
    session_regenerate_id();

    # Store the team/user data. $userID is not validated. $teamID was verified via auth query.
    $_SESSION['teamNumber'] = $teamNumber;
    $_SESSION['scoutName'] = $scoutName;
    $_SESSION['location'] = $location;

    # Redirect to the post-login page
    //header('location: home');
} else {
    unset($_SESSION['teamNumber']);
    unset($_SESSION['scoutName']);
    unset($_SESSION['location']);
    unset($_SESSION['isAdmin']);
    echo 'Your username, password, or team number are incorrect.';
}
?>
