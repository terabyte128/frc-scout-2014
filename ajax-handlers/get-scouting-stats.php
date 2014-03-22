<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';


try {
    $query = $db->prepare('SELECT
        (SELECT count(*) FROM `frc_match_data`) AS `matchScouted`,
        (SELECT count(*) FROM `frc_pit_scouting_data`) AS `pitScouted`
    ');
    $query->execute(array());
    $scoutCount = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Unable to update database.");
}


?>
