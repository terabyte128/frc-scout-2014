<?php
require '../includes/setup-session.php';

$adminPassword = $_POST['adminPassword'];

require '../includes/db-connect.php';

try {
    $authenticate = $db->prepare('SELECT team_number FROM team_accounts WHERE team_number = ? AND admin_password = md5(?)');
    $authenticate->execute(array($teamNumber, $adminPassword));
    $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if (key_exists('team_number', $teams)) {
    $_SESSION['isAdmin'] = true;
    echo 'Successfully authenticated as administrator.';
} else {
    echo 'Authentication failure, please check your password and try again.';
}
?>