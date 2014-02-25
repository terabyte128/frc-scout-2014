<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$scoutedTeam = $_POST['scoutedTeam'];

$params = array($scoutedTeam, $teamNumber, $location);

$queryString = "SELECT uid FROM frc_pit_scouting_data WHERE scouted_team=? AND scouting_team=? AND location=?";

try {
    $response = $db->prepare($queryString);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

if ($response->rowCount() > 0) {
    echo "!";
}