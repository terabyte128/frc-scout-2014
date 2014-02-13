<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';


try {
    $query = $db->prepare("SELECT 

format(avg(`tele_high_goals`), 1) as 'teleAverageHigh',
format(avg(`tele_low_goals`), 1) as 'teleAverageLow',

format(avg(`tele_truss_throws`), 1) as 'teleTrussThrow',
format(avg(`tele_truss_catches`), 1) as 'teleTrussCatch'

FROM frc_match_data WHERE scouted_team=?");
    
    $query->execute(array($otherTeamNumber));
    $averageGoals = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to get values from database");
}


?>
