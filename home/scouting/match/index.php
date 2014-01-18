<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';

if($teamType === "FTC") {
    header('location: /home/ftc/container.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Match Data Entry</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h1>Match Data Entry</h1>
                <br>
                <div id="content-holder">
                </div>
                <br>
                <button id="phasebutton" class="btn btn-lg btn-success" onclick="nextPhase()">Start scouting</button>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    $('#content-holder').load('forms/prematch.php');
    var currentPhase = "prematch";
        var ids = {
            "prematch": "autonomous",
            "autonomous": "teleoperated",
            "teleoperated": "postmatch",
            "postmatch": "prematch"
        }
    var nextPhase = function() {
        currentPhase = ids[currentPhase];
        $('#content-holder').load("forms/" + currentPhase + ".php");
    }
</script>