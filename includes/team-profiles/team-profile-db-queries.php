<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

#require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/load-frc-average-throws-catches-goals.php';

try {
    //get team attributes
    $request = $db->prepare('SELECT * FROM ' . $teamTable . ' WHERE team_number=?');

    $request->execute(array($otherTeamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);

    //get statistics
    $request = $db->prepare("select
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?) AS totalMatches,

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

    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=0 AND location=?) as matchesWonAtLocation,
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=1 AND location=?) as matchesLostAtLocation,
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=2 AND location=?) as matchesTiedAtLocation,

    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=0) as matchesWon,
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=1) as matchesLost,
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND match_outcome=2) as matchesTied,

    format(((SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=? AND died_during_match=true) /
    (SELECT COUNT(*) FROM frc_match_data WHERE scouted_team=?)) * 100, 0) AS dieRate

    # averages are no longer done here :)

    FROM frc_match_data WHERE scouted_team=?");

    $request->execute(array($otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $location, $otherTeamNumber, $location, $otherTeamNumber,
        $location, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber,
        $otherTeamNumber, $otherTeamNumber, $otherTeamNumber));

    $stats = $request->fetch(PDO::FETCH_ASSOC);

    $request = $db->prepare("SELECT (SELECT COUNT(*) FROM frc_pit_scouting_data WHERE scouting_team=?) AS contributions,
        (SELECT COUNT(*) FROM frc_pit_scouting_data WHERE scouted_team=? AND scouting_team=?) AS narcissism,
        (SELECT COUNT(*) FROM frc_pit_scouting_data WHERE scouted_team=?) AS totalScouted
        FROM frc_pit_scouting_data ");

    $request->execute(array($otherTeamNumber, $otherTeamNumber, $otherTeamNumber, $otherTeamNumber));

    $pit = $request->fetch(PDO::FETCH_ASSOC);

    $request = $db->prepare("SELECT `team_name` FROM frc_pit_scouting_data WHERE scouted_team=? GROUP BY scouted_team");

    $request->execute(array($otherTeamNumber));

    $name = $request->fetch(PDO::FETCH_ASSOC);

    # get averages all nice and packaged

    require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/load-frc-team-averages-as-variable.php';
    $avgQuery = Averages::getAverages($db, $otherTeamNumber, false, $teamNumber, false, $location, false);
    $averages = $avgQuery->fetch(PDO::FETCH_ASSOC);



    #get values for driver data
    $request = $db->prepare("SELECT * FROM frc_driver_data WHERE scouting_team=? AND scouted_team=?");

    $request->execute(array($teamNumber, $otherTeamNumber));

    $driverData = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to get values from database: " . $e->getMessage());
}
?>
