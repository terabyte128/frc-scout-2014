<?php

$adminPassword = $_POST['adminPassword'];
$newPassword = $_POST['newPassword'];

require '../includes/db-connect.php';

try {
    $changePassRequest = $db->prepare('UPDATE team_accounts SET admin_password=md5(?) WHERE admin_password=md5(?)');
    $changePassRequest->execute(array($newPassword, $adminPassword));
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if ($changePassRequest->rowCount() == 1) {
    //success
    echo 'Password changed successfully.';
} else {
    echo 'The admin password was entered incorrectly.';
}
?>
