<?php

$otherTeamNumber = $_GET['team'];
require '../includes/setup-session.php';
require '../includes/db-connect.php';

$request = $db->prepare('SELECT team_name, description, team_picture FROM ' . $teamTable . ' WHERE team_number=?');
$request->execute(array($otherTeamNumber));
$response = $request->fetch(PDO::FETCH_ASSOC);
if (empty($response)) {
    $isRegistered = false;
} else {
    $isRegistered = true;
}

# this needs to be here to ensure correct headers in team-profile-backend.php
# both will return the $request variable
# return $isRegistered to tell team-profile-backend.php whether or not to try and load name, photo and description
$isLoggedInTeam = false;

include '../includes/team-profile-backend.php';
?>
