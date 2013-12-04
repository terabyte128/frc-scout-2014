<?php

require_once '../../includes/setup-session.php';
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
        $autoBlockScoreAssist = $_POST['blockScoreAssist']  === "true" ? true : false;
        $autoRampAssist = $_POST['rampAssist']  === "true" ? true : false;

        $stmtString = "auto_ir_beacon_goal=?, auto_pendulum_goal=?, auto_floor_goal=?, auto_robot_on_bridge=?, auto_block_score_assist=?, auto_ramp_assist=?";
        $params = array($autoIrBeaconGoal, $autoPendulumGoal, $autoFloorGoal, $autoRobotOnBridge, $autoBlockScoreAssist, $autoRampAssist);
        $nextPage = "teleop.php";
    } else if ($page === "tele") {
        $outerPendulum = $_POST['outerPendulum'];
        $innerPendulum = $_POST['innerPendulum'];
        $floorGoal = $_POST['floorGoal'];
        $canBlock = $_POST['canBlock'] === "true" ? true : false;
        $canPush = $_POST['canPush'] === "true" ? true : false;
        $unpushable = $_POST['unpushable'] === "true" ? true : false;
        $blockSpeed = $_POST['robotSpeed'];
        $blockCapacity = $_POST['robotCapacity'];

        $stmtString = 'tele_outer_pendulum=?, tele_inner_pendulum=?, tele_floor_goal=?, tele_can_block=?, tele_can_push=?, tele_unpushable=?, tele_robot_speed=?, tele_robot_capacity=?';
        $params = array($outerPendulum, $innerPendulum, $floorGoal, $canBlock, $canPush, $unpushable, $blockSpeed, $blockCapacity);
        $nextPage = "endgame.php";
    } else if ($page === "end") {
        $endFlagScore = intval($_POST['flagScore']);
        $endHangScore = intval($_POST['hangScore']);
        $endBalanced = $_POST['balanced'] === "true" ? true : false;;

        $stmtString = 'end_flag_score=?, end_hang_score=?, end_balanced=?';
        $params = array($endFlagScore, $endHangScore, $endBalanced);
        $nextPage = 'postgame.php';
        
    } else if ($page === "post") { 
        $deadRobot = $_POST['deadRobot'] === "true" ? true : false;;
        $matchOutcome = $_POST['matchOutcome'];
        $minorFouls = $_POST['minorFouls'];
        $majorFouls = $_POST['majorFouls'];
        $comments = $_POST['comments'];

        $stmtString = 'dead_robot=?, match_outcome=?, major_fouls=?, minor_fouls=?, comments=?, complete=?';
        $params = array($deadRobot, $matchOutcome, $majorFouls, $minorFouls, $comments, true);
        $nextPage = "Finished";
    }

    if ($_SESSION['matchID'] && $stmtString !== null) {
        $fullStmtString = "UPDATE " . $dataTable . " SET " . $stmtString . " WHERE uid=?";
        $dbRequest = $db->prepare($fullStmtString);
        array_push($params, $_SESSION['matchID']);
        try {
            $dbRequest->execute($params);
        } catch (PDOException $e) {
            array_push($response, $e->getMessage());
        }

        if ($dbRequest->rowCount() == 0) {
            array_push($response, $fullStmtString);
            array_push($response, $params);
        } else {
            array_push($response, "Success");
        }
    }
}

array_push($response, $nextPage);
if($nextPage == null) {
}

echo json_encode($response);
?>