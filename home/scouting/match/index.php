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
                <button id="nextPhaseButton" class="btn btn-lg btn-success" onclick="pushToLocalStorage();" data-prematch-text="Start scouting" data-autonomous-text="Continue to teleoperated" data-teleoperated-text="Finish" data-postmatch-text="Review match" data-review-text="Submit">Start scouting</button>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">

    var currentPhase = "prematch";

    $(function() {
        nextPhase();
    })

    var ids = {
        "prematch": "autonomous",
        "autonomous": "teleoperated",
        "teleoperated": "postmatch",
        "postmatch": "review",
        "review": "prematch"
    }
    function nextPhase() {
        $("#nextPhaseButton").button('loading');
        $('#content-holder').load(
                "forms/" + currentPhase + ".php",
                function() {
                    $("#nextPhaseButton").button(currentPhase);
                    // currentPhase now holds the next phase
                    currentPhase = ids[currentPhase];
                });
        if (currentPhase !== "prematch") {
            $("#absentButton").hide();
        }
    }

</script>