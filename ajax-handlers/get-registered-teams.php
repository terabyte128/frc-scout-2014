<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].  '/includes/db-connect.php';


try {
    $query = $db->prepare('SELECT count(*) as `count` FROM `frc_team_accounts`');
    $query->execute(array($teamNumber, $teamPassword));
    $count = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to update database.");
}

echo $count['count'];

?>

