<?php

require 'includes/headers.php';
require_once 'includes/db-connect.php';

$resetID = $_GET['id'];
$teamType = $_POST['teamType'];

$typesToTableNames = array("ftc" => FTC_TEAM_ACCOUNTS, 'frc' => FRC_TEAM_ACCOUNTS);
$teamTable = $typesToTableNames[$teamType];


$stmt = $db->prepare('SELECT reset_time, pending_password, password_type FROM ' . $teamTable . ' WHERE reset_id=?');
$stmt->execute(array($resetID));
$results = $stmt->fetch();
$resetTime = $results[0];
$newPassword = $results[1];
$passwordType = $results[2];
if ($resetTime == "") {
    echo '<script type="text/javascript">',
    'loadPageWithMessage("index.php","Invalid password reset request ID.","danger");',
    '</script>';
} else if ($resetTime + 1800 < time()) {
    echo '<script type="text/javascript">',
    'loadPageWithMessage("index.php","Password reset request expired.","danger");',
    '</script>';
} else {
    $stmt = $db->prepare('UPDATE ' . $teamTable . ' SET reset_id="", reset_time="", pending_password="", ' . $passwordType . '=? WHERE reset_id=?');
    $stmt->execute(array($newPassword, $resetID));
    echo '<script type="text/javascript">',
    'loadPageWithMessage("index.php","Password changed.","success");',
    '</script>';
}
?>