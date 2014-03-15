<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';
require_once $docRoot . '/ajax-handlers/load-frc-team-averages-as-variable.php';

$query = Averages::getAverages($db, null, false, $teamNumber, true, $location, true);

$teamNumber = array();
$autonomousScore = array();
$teleopScore = array();

$bigArray = array();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    
    $thisTeamNumber = intval($row['scouted_team']);
    $thisAutoScore = doubleval($row['auto_average']);
    $thisTeleopScore = doubleval($row['teleop_average']);
            
    array_push($teamNumber, $thisTeamNumber);
    array_push($autonomousScore, doubleval(number_format($thisAutoScore, 1)));
    array_push($teleopScore, doubleval(number_format($thisTeleopScore, 1)));
}

array_push($bigArray, $teamNumber);
array_push($bigArray, $autonomousScore);
array_push($bigArray, $teleopScore);

print_r(json_encode($bigArray));
?>
