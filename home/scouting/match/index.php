<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';

if ($teamType === "FTC") {
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
                <h1><span id="pageNameTitle">Scouting</span><span id="teamNumberTitle"></span></h1>
                <div id="content-holder">
                </div>
                <br />
                <button id="nextPhaseButton" class="btn btn-lg btn-success" onclick="pushToLocalStorage();">Start scouting</button>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
                    $('#content-holder').load('forms/teleoperated.php');
                    var currentPhase = "prematch";
                    var ids = {
                        "prematch": "autonomous",
                        "autonomous": "teleoperated",
                        "teleoperated": "postmatch",
                        "postmatch": "prematch"
                    }
                    function nextPhase() {
                        currentPhase = ids[currentPhase];
                        $("#nextPhaseButton").button('loading');
                        $('#content-holder').load("forms/" + currentPhase + ".php");
                        if(currentPhase !== "prematch") {
                            $("#absentButton").hide();
                        }
                        $("#nextPhaseButton").button('reset');
                    }

</script>