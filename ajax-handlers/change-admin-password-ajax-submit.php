<?php

$adminPassword = $_POST['adminPassword'];
$newPassword = $_POST['newPassword'];

require '../includes/setup-session.php';
require '../includes/db-connect.php';

try {
    $changePassRequest = $db->prepare('UPDATE team_accounts SET admin_password=md5(?) WHERE admin_password=md5(?) AND team_number=?');
    $changePassRequest->execute(array($newPassword, $adminPassword, $teamNumber));
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if ($changePassRequest->rowCount() !== 0) {
    echo 'Admin password changed successfully.';
} else {
    echo 'The admin password was entered incorrectly.';
}
?>
