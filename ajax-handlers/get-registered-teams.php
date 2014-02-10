<?php

session_start();

//connect to the database
require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';


try {
    $query = $db->prepare('SELECT count(*) as `count` FROM `frc_team_accounts`');
    $query->execute(array($teamNumber, $teamPassword));
    $count = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to update database.");
}

echo $count['count'];

?>

