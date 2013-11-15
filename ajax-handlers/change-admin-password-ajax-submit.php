<?php

$adminPassword = $_POST['adminPassword'];
$newPassword = $_POST['newPassword'];

require_once '../includes/setup-session.php';
require_once '../includes/admin-required.php';
require_once '../includes/db-connect.php';

try {
    $changePassRequest = $db->prepare('UPDATE ' . $teamTable . ' SET admin_password=md5(?) WHERE admin_password=md5(?) AND team_number=?');
    $changePassRequest->execute(array($newPassword, $adminPassword, $teamNumber));
} catch (PDOException $ex) {
    die("Unable to update database.");
}

if ($changePassRequest->rowCount() !== 0) {
    echo 'Admin password changed successfully.';
} else {
    echo 'The admin password was entered incorrectly.';
}
?>
