<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/ajax-handlers/load-frc-team-averages-as-variable.php';

$query = Averages::getAverages(null, false, $teamNumber, true, $location, true);


$teamNumber = array();
$autonomousScore = array();
$teleopScore = array();

$bigArray = array();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    array_push($teamNumber, doubleval($row['scouted_team']));
    array_push($autonomousScore, doubleval($row['auto_points']));
    array_push($teleopScore, doubleval($row['tele_points']));
}

array_push($bigArray, $teamNumber);
array_push($bigArray, $autonomousScore);
array_push($bigArray, $teleopScore);

print_r(json_encode($bigArray));
?>
