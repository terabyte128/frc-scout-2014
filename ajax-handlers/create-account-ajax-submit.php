<?php

require '../includes/redirect-if-session-exists.php';
if (isset($_POST['teamNumber'])) {

    //create db or die
    require_once '../includes/db-connect.php';

    //grab values from POST
    $teamNumber = $_POST['teamNumber'];
    $adminEmail = $_POST['adminEmail'];
    $teamPassword = $_POST['teamPassword'];
    $adminPassword = $_POST['adminPassword'];

    //try and add account
    $stmt = $db->prepare('INSERT INTO `team_accounts` (team_number, team_password, admin_email, admin_password) VALUES (?, md5(?), ?, md5(?))');
    try {
        $stmt->execute(array($teamNumber, $teamPassword, $adminEmail, $adminPassword));
        header('location:index.php?message=' . urlencode("Account created sucessfully! You may now log in.") . "&type=success");
    } catch (PDOException $e) {
        $message = $e->getMessage();
        //check if error means team number already exists
        if (strpos($message, "Duplicate entry") !== false) {
            echo "That team number has been taken! If you believe this is in error, please <a href='mailto:sam@ingrahamrobotics.org'>contact me</a> and we'll get it sorted out.";
        } else {
            echo "Something went wrong, but we're unsure of what it is. Please try again.";
        }
    }
}
?>