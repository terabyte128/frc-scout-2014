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
        (SELECT sum(`tele_high_goals`+`tele_missed_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsAttempted,
        (SELECT sum(`tele_high_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsMade,
        (SELECT format((shotsMade / shotsAttempted) * 100, 1)) as percentageOfShotsMade,

        format((1 - (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND team_absent=true) /
        (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?)) * 100, 1) AS 'attendance',
        
        format(((SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=0) /
        (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?))* 100, 1) as winRate,
        
        format(avg(`tele_high_goals`), 1) as 'teleAverageHigh',
        format(avg(`tele_low_goals`), 1) as 'teleAverageLow',

        format(avg(`tele_truss_throws`), 1) as 'teleTrussThrow',
        format(avg(`tele_truss_catches`), 1) as 'teleTrussCatch' FROM frc_match_data WHERE scouted_team=?");

    $request->execute(array($otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber));

    $stats = $request->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Unable to get values from database: " . $e->getMessage());
}
?>
