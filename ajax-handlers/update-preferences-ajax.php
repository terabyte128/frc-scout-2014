<?php

$currentAdminPassword = $_POST['currentAdminPassword'];
$newPassword = $_POST['newPassword'];
$newAdminPassword = $_POST['newAdminPassword'];
$newEmail = $_POST['newTeamEmail'];

require_once '../includes/setup-session.php';
require_once '../includes/admin-required.php';
require_once '../includes/db-connect.php';

$params = array();
$queryString = "UPDATE " . $teamTable . " SET ";

$first = true;

if (!empty($newPassword)) {
    $queryString .= " `team_password`=? ";
    array_push($params, $newPassword);
    $first = false;
}

if (!empty($newAdminPassword)) {
    if (!$first) {
        $queryString .= ", ";
    }
    $queryString .= " `admin_password`=? ";
    array_push($params, $newAdminPassword);
    $first = false;
}

if (!empty($newEmail)) {
    if (!$first) {
        $queryString .= ", ";
    }
    $queryString .= " `admin_email`=? ";
    array_push($params, $newEmail);
}

$queryString .= " WHERE `team_number`=? AND `admin_password`=?";

array_push($params, $teamNumber);
array_push($params, $currentAdminPassword);

try {
    $request = $db->prepare($queryString);
    $request->execute($params);
} catch (PDOException $ex) {
//    echo $queryString;
//    echo "<BR>";
//    echo "<BR>";
//    print_r($_POST);
//    echo "<BR>";
//    echo "<BR>";
//    die("Unable to update database: " . $ex->getMessage());
    die("You did not specify anything to change.");
}

if ($request->rowCount() !== 0) {
    echo 'Preferences updated successfully.';
} else {
//    echo $queryString;
//    echo "<BR>";
//    echo "<BR>";
//    print_r($params);
//    echo "<BR>";
//    echo "<BR>";
    echo 'Either the admin password was entered incorrectly, or nothing was changed.';
}
?>
