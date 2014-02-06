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
                <h1><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial;"> <span id="pageNameTitle">Scouting</span><span id="teamNumberTitle"></span></h1>
                <div id="content-holder">
                </div>
                <div id="nextPhaseButtonContainer">
                    <br />
                    <button id="nextPhaseButton" class="btn btn-lg btn-success" onclick="pushToLocalStorage();" data-prematch-text="Start scouting" data-autonomous-text="Continue to teleoperated" data-teleoperated-text="Finish" data-postmatch-text="Review match" data-review-text="Do not press this button">Start scouting</button>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">


    //var currentPhase = "prematch";
    if (window.location.hash) {
        var currentPhase = window.location.hash.substring(1);
    } else {
        var currentPhase = "prematch";
    }

    $(function() {
        nextPhase();
    })

    window.onhashchange = function() {
        console.log("called onhashchange");
        var currentPhase = window.location.hash.substring(1);
        updateContainer();
    }

    var ids = {
        "prematch": "autonomous",
        "autonomous": "teleoperated",
        "teleoperated": "postmatch",
        "postmatch": "review",
        "review": "prematch"
    }
    
    function nextPhase() {
        window.location.hash = currentPhase;
        updateContainer();
        console.log("called nextPhase()");
    }
    
    function updateContainer() {
        console.log("called updateContainer()");
        $("#nextPhaseButton").button('loading');

        $("#loading").show();

        $('#content-holder').load(
                "forms/" + currentPhase + ".php",
                function() {
                    $("#loading").hide();
                    pullFromLocalStorage();

                    if (localStorage.allianceColorId) {
                        $(".container").css({
                            'border-top': '5px solid ' + localStorage.allianceColorId,
                            'border-bottom': '5px solid ' + localStorage.allianceColorId
                        });
                    }

                    $("#nextPhaseButton").button(currentPhase);
                    // currentPhase now holds the next phase
                    currentPhase = ids[currentPhase];
                });

        if (currentPhase !== "prematch") {
            $("#absentButton").hide();
        }
    }


</script>