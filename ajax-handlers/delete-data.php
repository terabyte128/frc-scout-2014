<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';

$thingToDelete = $_POST['idToDelete'];
$type = $_POST['type'];

if ($type === "match") {
    $queryString = "DELETE FROM frc_match_data WHERE uid=?";
    $params = array($thingToDelete);

    try {
        $query = $db->prepare($queryString);
        $query->execute($params);
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }

    echo "Successfully";
}

if ($type === "pit") {
    $queryString = "DELETE FROM frc_pit_scouting_data WHERE uid=?";
    $params = array($thingToDelete);

    try {
        $query = $db->prepare($queryString);
        $query->execute($params);
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }

    echo "Successfully";
}
?>