<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

try {
    //get team attributes
    $request = $db->prepare('SELECT * FROM ' . $teamTable . ' WHERE team_number=?');

    $request->execute(array($otherTeamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);

    //get statistics
    $request = $db->prepare("select 
    format((1 - (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND team_absent=true) /
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?)) * 100, 1) AS 'attendance'");


    $request->execute(array($otherTeamNumber, $otherTeamNumber));

    $stats = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to get values from database: " . $e->getMessage());
}
?>
