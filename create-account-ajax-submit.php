<?php
include 'includes/redirect-if-session-exists.php';
if (isset($_POST['teamNumber'])) {

    //create db or die
    require_once 'includes/db-connect.php';

    //grab values from POST
    $teamNumber = $_POST['teamNumber'];
    $adminEmail = $_POST['adminEmail'];
    $teamPassword = $_POST['teamPassword'];
    $checkPassword = $_POST['checkPassword'];
    $adminPassword = $_POST['adminPassword'];
    $checkAdminPassword = $_POST['checkAdminPassword'];

    //make sure passwords match
    if (strcmp($teamPassword, $checkPassword) != 0) {
        header('location:create-account.php?message=' . urlencode("Your passwords did not match, please try again.") . "&type=danger");
    } else if (strcmp ($adminPassword, $checkAdminPassword) != 0){
        header('location:create-account.php?message=' . urlencode("Your admin passwords did not match, please try again.") . "&type=danger");
    } else {

        //try and add account
        $stmt = $db->prepare('INSERT INTO `team_accounts` (team_number, team_password, admin_email, admin_password) VALUES (?, md5(?), ?, md5(?))');
        try {
            $stmt->execute(array($teamNumber, $teamPassword, $adminEmail, $adminPassword));
            header('location:index.php?message=' . urlencode("Account created sucessfully! You may now log in.") . "&type=success");
        } catch (PDOException $e) {
            $message = $e->getMessage();
            //check if error means team number already exists
            if (strpos($message, "Duplicate entry") !== false) {
                header('location:create-account.php?message=' . urlencode("That team number has been taken! If you believe this is in error, please <a href='mailto:sam@ingrahamrobotics.org'>contact me</a> and we'll get it sorted out.") . "&type=danger");
            } else {
                header('location:create-account.php?message=' . urlencode("Something went wrong, but we're unsure of what it is. Please try again.") . "&type=danger");
            }
        }
    }
}
?>