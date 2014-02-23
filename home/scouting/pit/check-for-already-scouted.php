<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$scoutedTeam = $_POST['scouted_team'];

$params = array($scoutedTeam, $teamNumber, $location);

$queryString = "SELECT (SELECT COUNT(*) as howMany) FROM frc_pit_scouting_data WHERE scouted_team=? AND scouting_team=? AND location=?";

try {
    $response = $db->prepare($queryString);
    $response->execute($params);
    $thing = $response->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

echo $thing;
if (intval($thing['howMany']) > 0) {
    echo $thing['howMany'];
}