<?php
/*
robot_weight' class="editable"><?php echo $response['robot_weight']; ?></a></p>
                        <p id="drivetrain"><strong>Drivetrain: </strong><a href='#' id='robot_drivetrain_type' class="editable"><?php echo $response['robot_drivetrain_type']; ?></a></p>
                        <p id="wheelType"><strong>Wheel Type: </strong><a href='#' id='robot_wheel_type' class="editable"><?php echo $response['robot_wheel_type']; ?></a></p>
                        <p id="shifters"><strong>Shifters: </strong><a href='#' id='robot_shifters' class="editable"><?php echo $response['robot_shifters'] === "1" ? "yes" : "no"; ?></a></p>

                        <p id="lowSpeed"><strong>Low Speed: </strong><a href='#' id='robot_low_speed' class="editable"><?php echo $response['robot_low_speed']; ?></a></p>
                        <p id="highSpeed"><strong>High Speed: </strong><a href='#' id='robot_high_speed' class="editable"><?php echo $response['robot_high_speed']; ?></a></p>
                        <p id="startingPosition"><strong>Starting Position: </strong><a href='#' id='robot_starting_position' class="editable"><?php echo $response['robot_starting_position']; ?></a></p>
                        <p id="role"><strong>Role: </strong><a href='#' id='robot_role' class="editable"><?php echo $response['robot_role']; ?></a></p>
                        <p id="comments"><strong>Comments: </strong><a href='#' id='robot_comments'/>*/

$whitelist = array('team_name', 'description', 'website', 'robot_weight', 
    'robot_drivetrain_type', 'robot_wheel_type','robot_shifters', 'robot_low_speed',
    'robot_high_speed', 'robot_starting_position', 'robot_role', 'robot_comments');

require_once '../includes/setup-session.php';
require_once '../includes/admin-required.php';
$colName = $_POST['name'];
$value = strip_tags($_POST['value']);
$value = trim($value);

if ($isAdmin) {
    if (!in_array($colName, $whitelist)) {
        die('hacker!!');
    }

    require_once '../includes/db-connect.php';
    try {
        $request = $db->prepare("UPDATE $teamTable SET $colName=? WHERE team_number=?");
        $request->execute(array($value, $teamNumber));
    } catch (PDOException $e) {
        die("Unable to update database.");
    }
    if ($request->rowCount() != 1) {
        echo 'Failed to change values.';
    } else {
        echo 'foobar';
    }
} else {
    echo 'Only administrators may do that.';
}

?>