<?php

$resetID = uniqid();
$time = time();
$adminEmail = $_POST['adminEmail'];
$teamNumber = $_POST['teamNumber'];
$newPassword = $_POST['newPassword'];
$passwordType = $_POST['passwordType'];
$teamTable = $_POST['teamType'];

require '../includes/db-connect.php';
require '../includes/constants.php';


try {
    $changePassRequest = $db->prepare('UPDATE ' . $teamTable . ' SET reset_id=?, reset_time=?, pending_password=md5(?), password_type=? WHERE admin_email=? AND team_number=?');
    $changePassRequest->execute(array($resetID, $time, $newPassword, $passwordType, $adminEmail, $teamNumber));
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if ($changePassRequest->rowCount() === 0) {
    die("Please make sure you have entered the team number and admin email correctly.");
} 

try {
    $message = 'Please click the following link to reset the team password. This link will only work for 30 minutes. http://' . $_SERVER['HTTP_HOST'] . "/reset-password.php?id=" . $resetID . "&teamType=" . $teamType;
    mail($adminEmail, "FRC Scout password reset", $message, "From: do-not-reply@" . $_SERVER['HTTP_HOST']);
} catch (Exception $ex) {
    die("Unable to send reset email!\r\n" . $ex->getMessage());
}

die("An email has been sent to $adminEmail with a link to confirm the password reset.");


?>
