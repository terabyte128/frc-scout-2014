<?php
require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$otherTeamNumber = $_GET['team'];

require '../includes/team-profiles/team-profile-db-queries.php';

if (empty($response)) {
    $isRegistered = false;
} else {
    $isRegistered = true;
}

# this needs to be here to ensure correct headers in team-profile-backend.php
# both will return the $request variable
# return $isRegistered to tell team-profile-backend.php whether or not to try and load name, photo and description
$isLoggedInTeam = false;

include '../includes/team-profiles/team-profile-backend.php';
?>
