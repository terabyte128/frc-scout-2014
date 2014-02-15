<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$teamData = json_decode($_POST['teamData'], true);


$params = array(
    //stuff
    $location, $scoutName, $teamNumber,
    //basic
    $teamData['teamNumber'], $teamData['teamCoach'], $teamData['infoProvider'],
    //physical
    $teamData['robotWeight'], $teamData['robotHeight'], $teamData['canExtend'] === "true" ? 1 : 0, $teamData['shooterType'],
    $teamData['wheelType'], $teamData['wheelNum'],
    //strategy
    $teamData['startPosition'], $teamData['role'], $teamData['canCollect'] === "true" ? 1 : 0, $teamData['canPass'] === "true" ? 1 : 0,
    $teamData['canThrow'] === "true" ? 1 : 0, $teamData['canCatch'] === "true" ? 1 : 0, $teamData['canHighGoal'] === "true" ? 1 : 0,
    $teamData['canBlock'] === "true" ? 1 : 0,
    //comments
    $teamData['strength'], $teamData['problems'], $teamData['comments']
);

try {
    $query = $db->prepare("INSERT INTO frc_pit_scouting_data ("
            //prematch 
            . "location, timestamp, `scout_name`, scouting_team, "

            //basic
            . "scouted_team, team_coach, info_provider, "

            //physical
            . "robot_weight, robot_height, can_extend, shooter_type, "
            . "wheel_type, wheel_num, "

            //strategy
            . "start_position, role, can_collect, can_pass, "
            . "can_throw, can_catch, can_high_goal, can_block, "

            // comments
            . "strength, problems, comments) VALUES ("

            //dem values doe
            . "?, now(), ?, ?,"
            . " ?, ?, ?,"
            . " ?, ?, ?, ?, ?, ?,"
            . " ?, ?, ?, ?, ?, ?, ?, ?,"
            . " ?, ?, ?"
            . ")");

    $query->execute($params);
} catch (PDOException $e) {
    die($e->getMessage());
}



echo "200 Success";
?>