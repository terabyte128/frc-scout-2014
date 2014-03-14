<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

#require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/load-frc-average-throws-catches-goals.php';

try {
    //get team attributes
    $request = $db->prepare('SELECT * FROM ' . $teamTable . ' WHERE team_number=?');

    $request->execute(array($otherTeamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);

    //get statistics
    $request = $db->prepare("select
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND team_absent=0) as matchesPresent,
    (SELECT COUNT(*) FROM frc_match_data WHERE scouting_team=?) as contributions,

    (SELECT sum(`tele_high_goals`+`tele_missed_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsAttempted,
    (SELECT sum(`tele_high_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsMade,
    (SELECT format((shotsMade / shotsAttempted) * 100, 1)) as percentageOfShotsMade,
    
    format((1 - (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND team_absent=true) /
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?)) * 100, 1) AS 'attendance',
    
    format((1 - (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND auto_missed_goal=1 AND team_absent=0) /
    (SELECT matchesPresent)) * 100, 1) as autoAccuracy,
    
    format(((SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND auto_moved_to_alliance_zone=1 AND team_absent=0) /
    (SELECT matchesPresent)) * 100, 1) as autoMovedZonePercent,
    format(((SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=0) /
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?))* 100, 1) as winRate,
    format(avg(`tele_high_goals`), 1) as 'teleAverageHigh',
    format(avg(`tele_low_goals`), 1) as 'teleAverageLow',
    
    format(avg(`tele_truss_throws`), 1) as 'teleTrussThrow',
    format(avg(`tele_truss_catches`), 1) as 'teleTrussCatch',
    format(avg(tele_received_assists), 1) as 'teleRecvdAssists',
    format(avg(tele_passed_assists), 1) as 'telePassedAssists',
    
    format(AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_hot_goals * 5)
    + (auto_moved_to_alliance_zone * 5)), 1) AS auto_points,
    
    format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10)
    + (tele_truss_catches * 10)), 1) AS tele_points,
    
    format(AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_high_goals * 5)
    + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10)
    + (tele_truss_catches * 10)), 1) AS total_points,
    
    format((AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_high_goals * 5)
    + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10)
    + (tele_truss_catches * 10)) / (AVG(total_match_points))) * 100, 1) AS alliance_score_percent
    
    FROM frc_match_data WHERE scouted_team=?");

    $request->execute(array($otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber));

    $stats = $request->fetch(PDO::FETCH_ASSOC);

    $request = $db->prepare("SELECT COUNT(*) AS contributions, (SELECT COUNT(*) FROM frc_pit_scouting_data WHERE scouted_team=?) AS narcissism FROM frc_pit_scouting_data WHERE scouting_team=? ");

    $request->execute(array($otherTeamNumber, $otherTeamNumber));

    $pit = $request->fetch(PDO::FETCH_ASSOC);
    
    #get values for driver data
    $request = $db->prepare("SELECT * FROM frc_driver_data WHERE scouting_team=? AND scouted_team=?");
    
    $request->execute(array($teamNumber, $otherTeamNumber));
    
    $driverData = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to get values from database: " . $e->getMessage());
}
?>
