<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];
require_once $docRoot . '/includes/setup-session.php';
$otherTeamNumber = $_GET['team'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Pit Scouting for Team <?= $otherTeamNumber ?></title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;">Team <?= $otherTeamNumber ?>'s Robot Info</h2>
                <button class="btn btn-default" onclick="window.location = '/team/<?= $otherTeamNumber ?>'" style="margin-bottom: 10px;">Back to Profile</button>
                <br />
                <a href="#" onclick="$('#filterOptions').slideToggle(200);
                        return false;">Filter these results</a>
                <br />
                <div id="filterOptions" style="display:none;">
                    <label>View data collected by:</label><br />
                    <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                        <label class="btn btn-default active" style="width: 130px;" id="all" onclick="setFilterHash('only', 'all');">
                            <input type="radio">All Teams
                        </label>
                        <label class="btn btn-default" style="width: 130px;" id="only" onclick="setFilterHash('all', 'only');">
                            <input type="radio">Only <?php echo $teamNumber; ?>
                        </label>
                    </div><br /><br />
                    <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                        <label>View data from:</label><br />
                        <label class="btn btn-default active" style="width: 130px;" id="global" onclick="setFilterHash('here', 'global');">
                            <input type="radio">Everywhere
                        </label>
                        <label class="btn btn-default" style="width: 130px;" id="here" onclick="setFilterHash('global', 'here');">
                            <input type="radio">Here<!--<?php echo $location; ?>-->
                        </label>
                    </div>
                    <br />
                </div>

                <br />
                <div id="scoutingData">

                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            var onlyHere = false;
            var onlyUs = false;

            $(function() {
                if (window.location.hash.indexOf("only") !== -1) {
                    onlyUs = true;
                    $("#only").addClass("active");
                    $("#all").removeClass("active");
                } else {
                    onlyUs = false;
                }
                if (window.location.hash.indexOf("here") !== -1) {
                    onlyHere = true;
                    $("#global").removeClass("active");
                    $("#here").addClass("active");
                } else {
                    onlyHere = false;
                }
                loadData(onlyHere, onlyUs);
            });

            var setFilterHash = function(thingToChange, thingToChangeTo) {
                if (window.location.hash.indexOf(thingToChange) !== -1) {
                    window.location.hash = window.location.hash.replace(thingToChange, thingToChangeTo);
                } else if (window.location.hash.indexOf(thingToChangeTo) === -1) {
                    if (window.location.hash === "") {
                        window.location.hash = thingToChangeTo;
                    } else {
                        window.location.hash = window.location.hash + "," + thingToChangeTo;
                    }
                }
            };

            window.onhashchange = function() {
                if (window.location.hash.indexOf("only") !== -1) {
                    onlyUs = true;
                } else {
                    onlyUs = false;
                }
                if (window.location.hash.indexOf("global") !== -1) {
                    onlyHere = false;
                } else {
                    onlyHere = true;
                }
                loadData(onlyHere, onlyUs);
            };

            loadData = function(here, us) {
                $.ajax({
                    url: '../../ajax-handlers/load-frc-profile-info.php',
                    type: 'POST',
                    data: {
                        'teamNumber': '<?= $otherTeamNumber ?>',
                        'thingToLoad': 'allpit',
                        'onlyHere': here,
                        'onlyUs': us
                    },
                    success: function(response, textStatus, jqXHR) {
                        $("#scoutingData").html(response);
                    }
                })
            }
        </script>
    </body>
</html>