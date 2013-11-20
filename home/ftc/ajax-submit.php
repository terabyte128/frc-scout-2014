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

require_once '../../db-connect.php';

$page = $_POST['page'];

if ($page === "pre") {
    $scoutedTeamNumber = $_POST['scoutedTeamNumber'];
    $matchNumber = $_POST['matchNumber'];
    
    $statement = "INSERT INTO " . $teamTable . " (timestamp, scouting_team, scouted_team, scout_name, location, match_number) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array(time(), $teamNumber, $scoutedTeamNumber, $scoutName, $location, $matchNumber);
    $nextPage = "autonomous.php";
}

if ($page === "auto") {
    
}

if ($page === "tele") {
    
}

if ($page === "end") {
    
}

if ($page === "post") {
    
}

$dbRequest = $db->prepare($statement);
$dbRequest->execute($params);

if($dbRequest -> rowCount() !== 1) {
    die("failure");
} else {
    echo $nextPage;
    exit();
}

?>
