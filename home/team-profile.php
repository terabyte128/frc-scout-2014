<?php
require '../includes/setup-session.php';
require '../includes/db-connect.php';

try {
    $request = $db->prepare('SELECT team_name, description, team_picture FROM ' . $teamTable . ' WHERE team_number=?');
    $request->execute(array($teamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}

# this needs to be here to ensure correct headers in team-profile-backend.php
# both will return the $request variable
$isLoggedInTeam = true;

include '../includes/team-profile-backend.php';
?>
