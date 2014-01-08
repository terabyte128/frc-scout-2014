<?php
require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$otherTeamNumber = $teamNumber;

require '../includes/team-profiles/team-profile-db-queries.php';

# this needs to be here to ensure correct headers in team-profile-backend.php
# both will return the $request variable
$isLoggedInTeam = true;
$isRegistered = true;

include '../includes/team-profiles/team-profile-backend.php';
?>
