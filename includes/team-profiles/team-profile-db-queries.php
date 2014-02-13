<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/load-frc-average-throws-catches-goals.php';

try {
    //get team attributes
    $request = $db->prepare('SELECT * FROM ' . $teamTable . ' WHERE team_number=?');

    $request->execute(array($otherTeamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);

    //get statistics
    $request = $db->prepare("select
        (SELECT sum(`tele_high_goals`+`tele_low_goals`+`tele_missed_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsAttempted,
        (SELECT sum(`tele_high_goals`+`tele_low_goals`) FROM frc_match_data WHERE scouted_team=?) as shotsMade,
        (SELECT format((shotsMade / shotsAttempted) * 100, 1)) as percentageOfShotsMade,

        format((1 - (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND team_absent=true) /
        (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?)) * 100, 1) AS 'attendance'");

    $request->execute(array($otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber));

    $stats = $request->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Unable to get values from database: " . $e->getMessage());
}
?>
