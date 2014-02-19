<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Alliance Builder</title>
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

                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Alliance Builder</h2>
                <button class="btn btn-default" onclick="window.location = '/alliances'" style="margin-bottom: 10px;">Back to Alliance Tools</button>
                <br />
                <div style="margin:auto;">
                    <div style="max-width: 600px; margin: auto;" class="form-group">


                        <label>Find teams that:</label><br />
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="canExtend">Can extend beyond height limit</button>
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="isSwerve">Have swerve drive</button>
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="canPass">Can eject balls (pass)</button>
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="canCollect">Can collect balls from the ground</button>
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="canThrow">Can throw over truss</button>
                        <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-default" id="canCatch">Can catch from truss</button>
                        <div style="display: inline-block; margin: 5px;">
                            <label for="wheelType" style="margin-top: 10px; max-width: 250px;">With this type of wheels:</label><br />
                            <input type="text" class="form-control" style="width: 250px; margin: 5px auto; display:inline-block;" id="wheelType" placeholder="Optional" />
                        </div>
                        <div style="display: inline-block; margin: 5px;">
                            <label for='wheelNum' style="margin-bottom: 10px; max-width: 250px;">This many wheels:</label><br />
                            <div class="btn-group" data-toggle="buttons" id='wheelNum' style="width: 250px; display:inline-block;">
                                <label class="btn btn-info" style='width: 40%;'>
                                    <input type="radio" name="options" id="dontCareWheels">Don't care
                                </label>
                                <label class="btn btn-info" style='width: 30%;'>
                                    <input type="radio" name="options" id="fourWheels">Four
                                </label>
                                <label class="btn btn-info" style='width: 30%;'>
                                    <input type="radio" name="options" id="sixWheels">Six
                                </label>
                            </div>
                        </div>
                        <div style="display: inline-block; margin: 5px;">
                            <label for="wheelType" style="margin-top: 10px;">And this type of shooter:</label><br />
                            <input type="text" class="form-control" style="width: 250px; margin: 5px auto; display: inline-block;" id="wheelType" placeholder="Optional" />
                        </div><br />
                        <div style="display: inline-block; margin: 5px;">
                            <label for="wheelType" style="margin-top: 10px;">With this strategic role:</label>
                            <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="wheelType" placeholder="Optional" />
                        </div>
                        <div style="display: inline-block; margin: 5px;">
                            <label for="wheelType" style="margin-top: 10px;">And this starting position:</label>
                            <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="wheelType" placeholder="Optional" />
                        </div>
                        <hr class="comment-divider-hr" style="margin: 10px auto;" />
                        <label>Restrict to only teams that:</label><br />
                        <button data-toggle="button" style="width: 250px; margin:5px;" class="btn btn-primary" id="scoutedBy">Have been scouted by team <?= $teamNumber ?></button>
                        <button data-toggle="button" style="width: 250px; margin:5px;" class="btn btn-primary" id="here">Have been scouted here</button>
                        <br /><br />
                        <button class="btn btn-success btn-lg" style="width: 250px;">Search</button>
                    </div>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            var parameters = {
                scoutedBy: ['only', 'all'],
                here: ['here', 'global'],
                canExtend: ['extend', 'noex'],
                canCollect: ['collect', 'nocoll'],
                isSwerve: ['swerve', 'nosw'],
                canPass: ['pass', 'nopss'],
                canThrow: ['throw', 'nothr'],
                canCatch: ['catch', 'noctch']
            };
            function javascript_is_dumb(i) {
                setFilterHash(parameters[i][0], "+");
            }
            $(function() {
                for (var i in parameters) {
                    document.getElementById(i).setAttribute("onclick", "javascript_is_dumb('" + i.toString() + "')");
                    if (window.location.hash.indexOf(parameters[i][0].toString()) !== -1) {
                        console.log("contains " + parameters[i][0].toString());
                        $("#" + i.toString()).addClass("active");
                    } else {
                        console.log("doesn't contain " + parameters[i][0].toString());
                        $("#" + i.toString()).removeClass("active");
                    }
                }
                
                $('#dontCareWheels').addClass('active');
            });

            var setFilterHash = function(thingToChangeTo, delimiter) {
                if (window.location.hash.indexOf(thingToChangeTo) !== -1) {
                    window.location.hash = window.location.hash.replace(delimiter + thingToChangeTo, "");
                    // failing that...
                    window.location.hash = window.location.hash.replace(thingToChangeTo, "");
                } else {
                    if (window.location.hash === "") {
                        window.location.hash = thingToChangeTo;
                    } else {
                        window.location.hash = window.location.hash + delimiter + thingToChangeTo;
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
                loadTable(onlyUs, onlyHere);
            };


            function loadTable(onlyLoggedInTeam, onlyThisLocation) {
                $("#loading").show();
                $.ajax({
                    url: '/ajax-handlers/load-frc-team-averages.php',
                    data: {
                        'onlyLoggedInTeam': onlyLoggedInTeam,
                        'onlyThisLocation': onlyThisLocation
                    },
                    success: function(response) {
                        $("#loading").hide();
                        $("#tableBody").html(response);
                        $("#averagesTable").trigger("update");
                        var sorting = [[1, 1]];
                        $("#averagesTable").trigger("sorton", [sorting]);
                    }
                });
            }
        </script>
    </body>
</html>
