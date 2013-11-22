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

$dataTable = 'ftc_scouting_data';

if ($page === "pre") {
    $scoutedTeamNumber = $_POST['scoutedTeamNumber'];
    $matchNumber = $_POST['matchNumber'];

    $stmtString = "INSERT INTO " . $dataTable . " (scouting_team, scouted_team, scout_name, location, match_number) VALUES (?, ?, ?, ?, ?)";
    $params = array($teamNumber, $scoutedTeamNumber, $scoutName, $location, $matchNumber);
    $stmt = $db->prepare($stmtString);
    $stmt->execute($params);
    $_SESSION['matchID'] = $db->lastInsertId();
    if (!$_SESSION['matchID']) {
        throw new PDOException();
        array_push($response, "Unable to establish a match ID.");
        die();
    } else {
        array_push($response, "Success");
    }
    $nextPage = "autonomous.php";
} else {
    if ($page === "auto") {
        $autoIrBeaconGoal = $_POST['irBeaconGoal'];
        $autoPendulumGoal = $_POST['pendulumGoal'];
        $autoFloorGoal = $_POST['floorGoal'];
        $autoRobotOnBridge = $_POST['robotOnBridge'];
        $autoBlockScoreAssist = $_POST['blockScoreAssist'];
        $autoRampAssist = $_POST['autoRampAssist'];

        $stmtString = "auto_ir_beacon_goal=?, auto_pendulum_goal=?, auto_floor_goal=?, auto_robot_on_bridge=?, auto_block_score_assist=?, auto_ramp_assist=?";
        $params = array($autoIrBeaconGoal, $autoPendulumGoal, $autoFloorGoal, $autoRobotOnBridge, $autoBlockScoreAssist, $autoRampAssist);
    }

    else if ($page === "tele") {
        $outerPendulum = $_POST['outerPendulum'];
        $innerPendulum = $_POST['innerPendulum'];
        $floorGoal = $_POST['floorGoal'];
        $canBlock = $_POST['canBlock'];
        $canPush = $_POST['canPush'] == 1 ? true : false;
        $unpushable = $_POST['unpushable'] == 1 ? true : false;
        $blockSpeed = $_POST['robotSpeed'];
        $blockCapacity = $_POST['robotCapacity'];
        
        $stmtString = 'tele_outer_pendulum=?, tele_inner_pendulum=?, tele_floor_goal=?, tele_can_block=?, tele_can_push=?, tele_unpushable=?, tele_robot_speed=?, tele_robot_capacity=?';
        $params = array($outerPendulum, $innerPendulum, $floorGoal, $canBlock, $canPush, $unpushable, $blockSpeed, $blockCapacity);
        $nextPage = "endgame.php";
    }

    else if ($page === "end") {
        $endFlagScore = $_POST['endFlagScore'];
        $engHangScore = $_POST['endHangScore'];
        $endBalanced = $_POST['endBalanced'];
        
        $stmtString = 'end_flag_score=?, end_hang_score=?, end_balanced=?';
        $params = array($flagScore, $endgameScore, $balanced);
        $nextPage = 'postgame.php';
    }

    else if ($page === "post") {
        $deadRobot = $_POST['deadRobot'];
        $matchOutcome = $_POST['matchOutcome'];
        $minorFouls = $_POST['minorFouls'];
        $majorFouls = $_POST['majorFouls'];
        $comments = $_POST['comments'];
        
        $stmtString = 'dead_robot=?, match_outcome=?, major_fouls=?, minor_fouls=?, comments=?';
        $params = array($deadRobot, $matchOutcome, $majorFouls, $minorFouls, $comments);
        
    }

    if ($_SESSION['matchID'] && $stmtString !== null) {
        $dbRequest = $db->prepare("UPDATE " . $dataTable .  " SET " . $stmtString + " WHERE uid=?");
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
