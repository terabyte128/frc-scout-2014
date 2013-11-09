<?php

$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

require '../includes/db-connect.php';

try {
    $changePassRequest = $db->prepare('UPDATE team_accounts SET team_password=md5(?) WHERE team_password=md5(?)');
    $changePassRequest->execute(array($newPassword, $currentPassword));
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if ($changePassRequest->rowCount() == 1) {
    //success
    echo 'Password changed successfully.';
} else {
    echo 'Your current password was entered incorrectly.';
}
?>
