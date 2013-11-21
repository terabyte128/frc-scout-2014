<?php

require_once '../../includes/setup-session.php';

/**
 * timestamp
 * scouting_team int (64),
  scout_name varchar (64),
 * location
 * match_number
  scouted_team varchar (64),
  auto_block_score int (64),
  auto_ramp_score int (64),
  auto_assist_score int (64),
  tele_outer_pendulum int (64),
  tele_inner_pendulum int (64),
  tele_floor int (64),
  tele_can_block boolean,
  tele_speed varchar (64),
  tele_capacity varchar (64),
  end_flag_score int (64),
  end_hang_score int (64),
  end_balanced boolean,
  misc_dead_robot boolean,
  misc_match_outcome varchar (64),
  misc_minor_fouls int (64),
  misc_major_fouls int (64)
  misc_comments text
 */
require_once '../../includes/db-connect.php';

$page = $_POST['page'];
$response = array();

if ($page === "pre") {
    $scoutedTeamNumber = $_POST['scoutedTeamNumber'];
    $matchNumber = $_POST['matchNumber'];

    $stmtString = "INSERT INTO " . $teamTable . " (timestamp, scouting_team, scouted_team, scout_name, location, match_number) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array(time(), $teamNumber, $scoutedTeamNumber, $scoutName, $location, $matchNumber);
    $stmt = $db->prepare($stmtString);
    $stmt->execute();
    $_SESSION['matchID'] = $db->lastInsertId();
    if (!$_SESSION['matchID']) {
        throw new PDOException();
        array_push($response, "Unable to establish a match ID.");
        die();
    }
    $nextPage = "autonomous.php";
} else {
    if ($page === "auto") {
        $autoIrBeaconGoal = $_POST['irBeaconGoal'];
        $autoPendulumGoal = $_POST['pendulumGoal'];
        $autoFloorGoal = $_POST['floorGoal'];
        $autoRobotOnBridge = $_POST['robotOnBridge'];

        $stmtString = "UPDATE " . $teamTable . " SET auto_ir_beacon_goal=?, auto_pendulum_goal=?, auto_floor_goal=?, auto_robot_on_bridge=?";
        $params = array($autoIrBeaconGoal, $autoPendulumGoal, $autoFloorGoal, $autoRobotOnBridge);
    }

    if ($page === "tele") {
        
    }

    if ($page === "end") {
        
    }

    if ($page === "post") {
        
    }

    if ($_SESSION['matchID'] && $stmtString !== null) {
        $dbRequest = $db->prepare($stmtString + " WHERE uid=?");
        array_push($params, $_SESSION['matchID']);
        $dbRequest->execute($params);

        if ($dbRequest->rowCount() !== 1) {
            array_push($response, "Failed to update database.");
        } else {
            array_push($response, "Success");
        }
    }
}

array_push($response, $nextPage);
echo json_encode($response);
?>
