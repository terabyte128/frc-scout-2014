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

                <h2><img id="loading" name="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Alliance Builder</h2>
                <button class="btn btn-default" onclick="window.location = '/alliances'" style="margin-bottom: 10px;">Back to Alliance Tools</button>
                <br />
                <div style="margin:auto;">
                    <div style="max-width: 600px; margin: auto;" class="form-group">
                        <form action="/alliances/builder/results" method="post" >
                            <label>Find robots that:</label><br />
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canExtend" name="canExtend">Can extend beyond height limit</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="isSwerve" name="isSwerve">Have swerve drive</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canPass" name="canPass">Can eject balls (pass)</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canCollect" name="canCollect">Can collect balls from the ground</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canThrow" name="canThrow">Can throw over truss</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canCatch" name="canCatch">Can catch from truss</button>
                            <button data-toggle="button" style="width: 250px; margin: 5px;" class="btn btn-info" id="canBlock" name="canBlock">Can block shots</button><br />
                            <!-- these are because bootstrap buttons don't work as form inputs -->
                            <input type="text" style="display: none;" id="canExtendInput" name="canExtend" />
                            <input type="text" style="display: none;" id="isSwerveInput" name="isSwerve" />
                            <input type="text" style="display: none;" id="canPassInput" name="canPass" />
                            <input type="text" style="display: none;" id="canCollectInput" name="canCollect" />
                            <input type="text" style="display: none;" id="canThrowInput" name="canThrow" />
                            <input type="text" style="display: none;" id="canCatchInput" name="canCatch" />
                            <input type="text" style="display: none;" id="canBlockInput" name="canBlock" />

                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px; max-width: 250px;">With this type of wheels:</label><br />
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto; display:inline-block;" id="wheelType" name="wheelType" placeholder="Optional" />
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for='wheelNum' style="margin-bottom: 10px; max-width: 250px;">This many wheels:</label><br />
                                <div class="btn-group" data-toggle="buttons" id='wheelNum' style="width: 250px; display:inline-block;">
                                    <label class="btn btn-info active" style='width: 40%;' id="dontCareWheels">
                                        <input type="radio" name="wheelNum" value='' checked>Don't care
                                    </label>
                                    <label class="btn btn-info" style='width: 30%;' id="fourWheels">
                                        <input type="radio" name="wheelNum" value='4'>Four
                                    </label>
                                    <label class="btn btn-info" style='width: 30%;' id="sixWheels">
                                        <input type="radio" name="wheelNum" value='6'>Six
                                    </label>
                                </div>
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">And this type of shooter:</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="shooterType" name="shooterType" placeholder="Optional" />
                            </div><br />
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">With this strategic role:</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="role" name="role" name="role" placeholder="Optional" />
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">And this starting position:</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="startPosition" name="startPosition" placeholder="Optional" />
                            </div>
                            <hr class="comment-divider-hr" style="margin: 10px auto;" />
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">Taller than this (in):</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="minHeight" name="minHeight" placeholder="Min. height (optional)" />
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">Or shorter than this (in):</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="maxHeight" name="maxHeight" placeholder="Max. height (optional)" />
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">Heavier than this (lb):</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="minWeight" name="minWeight" placeholder="Min. weight (optional)" />
                            </div>
                            <div style="display: inline-block; margin: 5px;">
                                <label for="wheelType" style="margin-top: 10px;">Or lighter than this (lb):</label>
                                <input type="text" class="form-control" style="width: 250px; margin: 5px auto;" id="maxWeight" name="maxWeight" placeholder="Max. weight (optional)" />
                            </div>
                            <hr class="comment-divider-hr" style="margin: 10px auto;" />
                            <label>Restrict to only results that were:</label><br />
                            <button data-toggle="button" style="width: 250px; margin:5px;" class="btn btn-primary" id="scoutedBy" name="scoutedBy">Scouted by team <?= $teamNumber ?></button>
                            <button data-toggle="button" style="width: 250px; margin:5px;" class="btn btn-primary" id="here" name="here">Scouted at <?= $location ?></button>
                            <button data-toggle="button" style="width: 250px; margin:5px;" class="btn btn-primary" id="noteam" name="noteam">Not scouted by their own team</button>
                            <!-- bootstrap hrngh -->
                            <input type="text" style="display: none;" id="scoutedByInput" name="scoutedBy" />
                            <input type="text" style="display: none;" id="hereInput" name="here" />
                            <input type="text" style="display: none;" id="noteamInput" name="noteam" />
                            <br /><br />
                            <button class="btn btn-success btn-lg" type='submit' style="width: 250px;">Search</button>
                        </form>
                    </div>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            var parameters = {
                scoutedBy: ['only', 'all'],
                here: ['here', 'global'],
                noteam: ['noteam', 'oktm'],
                canExtend: ['extend', 'noex'],
                canCollect: ['collect', 'nocoll'],
                isSwerve: ['swerve', 'nosw'],
                canPass: ['pass', 'nopss'],
                canThrow: ['throw', 'nothr'],
                canCatch: ['catch', 'noctch'],
                canBlock: ['block', 'noblck']
            };
            function javascript_is_dumb(i) {
                //setFilterHash(parameters[i][0], "+");
                //the important part is here
                if ($("#" + i + "Input").val() === "") {
                    $("#" + i + "Input").val(parameters[i][0]);
                } else {
                    $("#" + i + "Input").val("");
                }
            }
            $(function() {
                console.log($("#canCollectInput").val());
                for (var i in parameters) {
                    document.getElementById(i).setAttribute("onclick", "javascript_is_dumb('" + i.toString() + "')");
                    /*if (window.location.hash.indexOf(parameters[i][0].toString()) !== -1) {
                        console.log("contains " + parameters[i][0].toString());
                        $("#" + i.toString()).addClass("active");
                    } else {
                        console.log("doesn't contain " + parameters[i][0].toString());
                        $("#" + i.toString()).removeClass("active");
                    }*/
                }
            });

            // actually there's really no reason for this function, but it's SO COOL
            /*var setFilterHash = function(thingToChangeTo, delimiter) {
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
                if (window.location.hash.charAt(1) === delimiter) {
                    window.location.hash = window.location.hash.substring(2);
                }
            };*/

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
