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


    var currentPhase = "prematch";
    var loggedInTeam = <?php echo $teamNumber; ?>;


    $(function() {
        if (window.location.hash) {
            currentPhase = window.location.hash.substring(1);
        } else {
            window.location.hash = currentPhase;
        }

        loadContainer();
    })

    function changePhase(hash) {
        window.location.hash = hash;
    }

    window.onhashchange = function() {
        currentPhase = window.location.hash.substring(1);
        console.log("called onhashchange with hash " + currentPhase);
        loadContainer();
    }

    var ids = {
        "prematch": "autonomous",
        "autonomous": "teleoperated",
        "teleoperated": "postmatch",
        "postmatch": "review",
        "review": "prematch"
    }

    function loadContainer() {
        console.log("called loadContainer()");



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

                    if (currentPhase === "review") {
                        $("#nextPhaseButtonContainer").hide();
                    } else {
                        $("#nextPhaseButtonContainer").show();
                    }

                    $("#nextPhaseButton").button(currentPhase);

                    console.log("forms/" + currentPhase + ".php")
                });

        if (currentPhase !== "prematch") {
            $("#absentButton").hide();
        }
    }


</script>