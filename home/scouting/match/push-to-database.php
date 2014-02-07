<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$matchData = json_decode($_POST['matchData'], true);

try {
    $query = $db->prepare("INSERT INTO match_data ("
            //prematch
            . "timestamp, scouting_team, scouted_team, alliance_color, team_absent, "

            //autonomous
            . "auto_hot_goal, auto_goal_value, auto_moved_to_alliance_zone, "

            //teleoperated
            . "tele_received_assists, tele_passed_assists, tele_high_goals, "
            . "tele_low_goals, tele_missed_goals, tele_truss_throws, tele_truss_catches, "

            //postmatch
            . "died_during_match, caused_fouls, foul_comments, misc_comments) VALUES ("

            //dem values doe
            . "now(), ?, ?, ?, ?,"
            . " ?, ?, ?,"
            . " ?, ?, ?,"
            . " ?, ?, ?, ?,"
            . " ?, ?, ?, ?,"
            . ")");
} catch (PDOException $e) {
    die($e->getMessage());
}


$params = array(
    //prematch
    $teamNumber, $matchData['teamNumber'], $matchData['allianceColor'] == "red" ? 0 : 1, !$matchData['teamPresent'],
    //autonomous
    $matchData['autoHotGoal'] === "true" ? 1 : 0, $matchData['autoGoalValue'], $matchData['autoMovedToAllianceZone'] === "true" ? 1 : 0,
    //teleoperated
    $matchData['teleReceivedAssists'], $matchData['telePassedAssists'], $matchData['teleHighGoals'],
    $matchData['teleLowGoals'], $matchData['teleMissedGoals'], $matchData['teleTrussThrows'], $matchData['teleTrussCatches'],
    //postmatch
    $matchData['diedDuringMatch'] === "true" ? 1 : 0, $matchData['causedFouls'] === "true" ? 1 : 0,
    //comments
    $matchData['foulComments'], $matchData['miscComments']
);


/*
  allianceColor: "blue"
  allianceColorId: "rgb(0, 82, 255)"
  autoGoalValue: "15"
  autoHotGoal: "true"
  autoMovedToAllianceZone: "true"
  causedFouls: "true"
  diedDuringMatch: "true"
  foulComments: "FOULS"
  length: 19
  matchNumber: "0"
  miscComments: "COMMENTS"
  teamNumber: "0"
  teamPresent: "true"
  teleHighGoals: "1"
  teleLowGoals: "1"
  teleMissedGoals: "1"
  telePassedAssists: "1"
  teleReceivedAssists: "1"
  teleTrussCatches: "1"
  teleTrussThrows: "1"
 */

echo 'SUCCESS';
?>