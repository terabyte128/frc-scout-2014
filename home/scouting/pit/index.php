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
        <title>Pit Scouting Data Entry</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <style type="text/css">
            .typeahead-hint {
                font-style: italic;
                font-size: 10pt;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h1><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial;"> <span id="pageNameTitle">Pit Scouting</span><span id="teamNumberTitle"></span></h1>
                <button id="homeButton" class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <div id="content-holder">
                </div>
                <div id="nextPhaseButtonContainer">
                    <br />
                    <button id="nextPhaseButton" style="width: 250px;" class="btn btn-lg btn-success" onclick="pushToLocalStorage();" data-basic-text="Continue" data-physical-text="Continue" data-strategy-text="Continue" data-comments-text="Finish" data-review-text="Do not press this button">Start scouting</button>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">

    var currentPhase = "basic";
    var loggedInTeam = <?php echo $teamNumber; ?>;


    $(function() {
        if (window.location.hash) {
            currentPhase = window.location.hash.substring(1);
        } else {
            window.location.hash = currentPhase;
        }

        loadContainer();
    });

    function changePhase(hash) {
        window.location.hash = hash;
    }

    window.onhashchange = function() {
        currentPhase = window.location.hash.substring(1);
        console.log("called onhashchange with hash " + currentPhase);
        loadContainer();
    };

    var ids = {
        "basic": "physical",
        "physical": "strategy",
        "strategy": "comments",
        "comments": "review",
        "review": "physical"
    };

    function loadContainer() {
        console.log("called loadContainer()");

        $("#nextPhaseButton").button('loading');

        $("#loading").show();

        $('#content-holder').load(
                "forms/" + currentPhase + ".php",
                function() {
                    $("#loading").hide();
                    pullFromLocalStorage();

                    if (currentPhase === "basic") {
                        if ("<?= $_GET['team'] ?>" !== "") {
                            $("#teamNumber").val(<?= $_GET['team'] ?>);
                            updateTeamNumber(<?= $_GET['team'] ?>);
                        }
                    }

                    if (currentPhase === "review") {
                        $("#nextPhaseButtonContainer").hide();
                    } else {
                        $("#nextPhaseButtonContainer").show();
                    }

                    $("#nextPhaseButton").button(currentPhase);

                    console.log("forms/" + currentPhase + ".php");
                });
        if (currentPhase !== "basic") {
            $("#homeButton").hide();
        } else {
            $("#homeButton").show();
        }


    }

</script>
