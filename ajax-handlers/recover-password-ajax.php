<?php

include $_SERVER['DOCUMENT_ROOT'] . "/includes/message-control.php";

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

$teamNumber = $_POST['teamNumber'];
$adminEmail = $_POST['adminEmail'];
$isAdminPasswordReset = $_POST['adminPasswordReset'] === "true" ? true : false; 
$passwordName = $isAdminPasswordReset ? "an administrator" : "a team";

$resetId = uniqid();

$resetPage = "http://" . $_SERVER['HTTP_HOST'] . "/recover/$resetId";

echo '<script type="text/javascript">';

try {
    $request = $db->prepare("UPDATE frc_team_accounts SET password_reset_time=unix_timestamp(), password_reset_id=?, reset_admin_password=? WHERE team_number=? AND admin_email=?");
    $request->execute(array($resetId, $isAdminPasswordReset, $teamNumber, $adminEmail));
} catch (PDOException $ex) {
    die("loadPageWithMessage('/recover', 'Could not connect to database.', 'danger');</script>");
}

if ($request->rowCount() === 0) {
    die("loadPageWithMessage( '/recover', 'Your admin email or team number was entered incorrectly.', 'danger');</script>");
}

$message = <<<MSG
        You requested $passwordName password reset for FIRST Scout.
                
        In order to complete this request, please click the following link:
        $resetPage
        
        This page will expire after 20 minutes.
MSG;

mail($adminEmail, "Password reset requested on FRC Scout", $message, 'From: noreply@frcscout.com');

echo 'loadPageWithMessage("/", "Request sent successfully, check your email.", "success")';

echo '</script>';
?>