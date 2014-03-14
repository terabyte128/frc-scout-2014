<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

$otherTeamNumber = $_POST['pk'];
$column = $_POST['name'];
$value = $_POST['value'];

if (!in_array($column, array("driver_1_name", "driver_2_name", "driver_1_description", "driver_2_description", "coach_name", "coach_description"))) {
    die($column . " is invalid");
    
}

# check if an entry already exists


try {
    $query = $db->prepare("SELECT scouted_team FROM frc_driver_data WHERE scouting_team=? AND scouted_team=?");
    $query->execute(array($teamNumber, $otherTeamNumber));
    if ($query->rowCount() === 0) {
        $exists = false;
    } else {
        $exists = true;
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

try {
    if ($exists) {
        $queryString = "UPDATE frc_driver_data SET $column=? WHERE scouting_team=? AND scouted_team=?";
        $params = array($value, $teamNumber, $otherTeamNumber);
    } else {
        $queryString = "INSERT INTO frc_driver_data (scouting_team, scouted_team, $column) VALUES (?, ?, ?)";
        $params = array($teamNumber, $otherTeamNumber, $value);
    }
    $query = $db->prepare($queryString);
    $query->execute($params);
} catch (PDOException $e) {
    die($e->getMessage());
}

echo "success";

?>
