<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$matchData = json_decode($_POST['matchData'], true);


$params = array(
    //prematch
    $location, $teamNumber, $matchData['teamNumber'], $matchData['matchNumber'], $matchData['allianceColor'] == "red" ? 0 : 1, !$matchData['teamPresent'],
    //autonomous
    $matchData['autoHotGoal'] === "true" ? 1 : 0, $matchData['autoGoalValue'], $matchData['autoMovedToAllianceZone'] === "true" ? 1 : 0,
    //teleoperated
    $matchData['teleReceivedAssists'], $matchData['telePassedAssists'], $matchData['teleHighGoals'],
    $matchData['teleLowGoals'], $matchData['teleMissedGoals'], $matchData['teleTrussThrows'], $matchData['teleTrussCatches'],
    //postmatch
    $matchData['matchOutcome'], $matchData['totalMatchPoints'], $matchData['diedDuringMatch'] === "true" ? 1 : 0, $matchData['causedFouls'] === "true" ? 1 : 0,
    //comments
    $matchData['foulComments'], $matchData['miscComments']
);

try {
    $query = $db->prepare("INSERT INTO frc_match_data ("
            //prematch 
           . "location, timestamp, scouting_team, scouted_team, match_number, alliance_color, team_absent, "

            //autonomous
            . "auto_hot_goal, auto_goal_value, auto_moved_to_alliance_zone, "

            //teleoperated
            . "tele_received_assists, tele_passed_assists, tele_high_goals, "
            . "tele_low_goals, tele_missed_goals, tele_truss_throws, tele_truss_catches, "

            //postmatch
            . "match_outcome, total_match_points, died_during_match, caused_fouls, foul_comments, misc_comments) VALUES ("

            //dem values doe
            . "?, now(), ?, ?, ?, ?, ?,"
            . " ?, ?, ?,"
            . " ?, ?, ?,"
            . " ?, ?, ?, ?,"
            . " ?, ?, ?, ?, ?, ?"
            . ")");
    
    $query->execute($params);
} catch (PDOException $e) {
    die($e->getMessage());
}



echo "200 Success";
?>