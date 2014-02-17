<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$scoutedTeamNumber = $_POST['teamNumber'];
$matchNumber = $_POST['matchNumber'];
$absentComments = $_POST['absentComments'];

$queryString = "INSERT INTO `frc_match_data` 
    (location, timestamp, scout_name, scouting_team, scouted_team, match_number, team_absent, misc_comments) 
    VALUES (?, now(), ?, ?, ?, ?, ?, ?)";

$params = array($location, $scoutName, $teamNumber, $scoutedTeamNumber, $matchNumber, true, $absentComments);

try {
    $query = $db->prepare($queryString);
    $query->execute($params);
} catch (PDOException $e) {
    die($e->getMessage());
}

echo "200 Success";
?>
