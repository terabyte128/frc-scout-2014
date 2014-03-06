<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/ajax-handlers/load-frc-team-averages-as-variable.php';

$query = Averages::getAverages(null, false, false, true);


$teamNumber = array();
$autonomousScore = array();
$teleopScore = array();

$bigArray = array();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    array_push($teamNumber, $row['scouted_team']);
    array_push($autonomousScore, $row['auto_points']);
    array_push($teleopScore, $row['tele_points']);
}

array_push($bigArray, $teamNumber);
array_push($bigArray, $autonomousScore);
array_push($bigArray, $teleopScore);

print_r(json_encode($bigArray));
?>
