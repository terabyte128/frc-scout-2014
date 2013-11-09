<?php
require '../includes/setup-session.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php' ?>
        <title>FRC Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>FRC Scout: Home</h2>
                <p>You are logged in as <?php echo $scoutName ?> for team <?php echo $teamNumber ?> in <?php echo $location ?>.</p>
                <button onclick="window.location = 'change-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Password</button>
                <button onclick="window.location = '../login.php?logout';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>
                <br />
                <br />
            </div>
    </body>
</html>