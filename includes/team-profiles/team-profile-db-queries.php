<?php
require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

try {
    $request = $db->prepare('SELECT team_name, description, team_picture, website FROM ' . $teamTable . ' WHERE team_number=?');
    $request->execute(array($otherTeamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to get values from database.");
}
?>
