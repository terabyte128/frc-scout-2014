<?php
require '../includes/setup-session.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <? include '../includes/headers.php' ?>
        <title>FRC Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <? include '../includes/messages.php' ?>
                <h2>FRC Scout: Home</h2>
                <p>You are logged in as <? echo $scoutName ?> for team <? echo $teamNumber ?> in <? echo $location ?>.</p>
                <button onclick="window.location = '#';" class="btn btn-lg btn-warning btn-home-selections disabled" disabled>Change Password</button>
                <button onclick="window.location = '../login.php?logout';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>
                <br />
                <br />
            </div>
    </body>
</html>