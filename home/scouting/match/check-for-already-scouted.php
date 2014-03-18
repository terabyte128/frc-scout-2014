<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$scoutedTeam = $_POST['scoutedTeam'];

$params = array($scoutedTeam, $teamNumber, $location);

$queryString = "SELECT COUNT(*) WHERE scouted_team=? AND scouting_team=? AND location=? as times FROM frc_pit_scouting_data";

try {
    $response = $db->prepare($queryString);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

$row = $response->fetch(PDO::FETCH_ASSOC);

if ($row['times'] !== "0") {
    echo "Scouted here " . $row['times'] . " times";
}