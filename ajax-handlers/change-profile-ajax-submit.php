<?php

$whitelist = array('team_name', 'description');
require '../includes/setup-session.php';
require '../includes/admin-required.php';
$colName = $_POST['name'];
$value = strip_tags($_POST['value']);
if ($isAdmin) {
    if (!in_array($colName, $whitelist)) {
        die('hacker!!');
    }

    require '../includes/db-connect.php';
    try {
        $request = $db->prepare("UPDATE $teamTable SET $colName=? WHERE team_number=?");
        $request->execute(array($value, $teamNumber));
    } catch (PDOException $e) {
        die("Unable to update database.");
    }
    if ($request->rowCount() != 1) {
        echo 'Failed to change values.';
    } else {
        echo 'success';
    }
} else {
    echo 'Only administrators may do that.';
}
?>