<?php
require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$adminPassword = $_POST['adminPassword'];


try {
    $authenticate = $db->prepare('SELECT team_number FROM '. $teamTable .' WHERE team_number = ? AND admin_password = md5(?)');
    $authenticate->execute(array($teamNumber, $adminPassword));
    $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to update database.");
}

if (key_exists('team_number', $teams)) {
    $_SESSION['isAdmin'] = true;
    echo 'Successfully authenticated as administrator.';
} else {
    echo 'Authentication failure, please check your password and try again.';
}
?>