<!DOCTYPE html>
<html>
    <head>
        <?php if ($isLoggedInTeam) { ?>
            <title>Your Team Profile</title>
        <?php } else { ?>
            <title>Team <?php echo $otherTeamNumber; ?>'s Profile</title>
        <?php } ?>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php';
        ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php' ?>
                <?php if ($isLoggedInTeam) { ?>
                    <h2>Your Team Profile & Statistics</h2>
                <?php } else { ?>
                    <h2><?php if ($isRegistered) { ?> Profile &<?php } ?> Statistics for Team <?php echo $otherTeamNumber; ?></h2>
                <?php } ?>
                <button class="btn btn-default" onclick="window.location = '/'">Return Home</button>
                <?php if ($isRegistered) { ?>
                    <br />
                    <font style="color: #868686; float: right; font-size: 10pt;">Team Profile</font>
                    <hr style="border-top: 1px solid #bbb">
                    <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                        <?php if ($isLoggedInTeam && $isAdmin) { ?>
                            <a href="#" onclick="$('#submitTeamPicture').slideToggle(200);">Change team picture</a>
                            <form id="submitTeamPicture" action="../uploads/uploader.php" method="post" enctype="multipart/form-data" style="display: none;">
                                <input class="form-control" type="file" size="60" name="teamPicture" value="Update team picture">
                                <button class="form-control btn btn-sm" id="percent">Update</button>
                            </form>
                            <br /><br />
                        <?php } ?>
                        <?php if (!empty($response['team_picture'])) { ?>
                            <img class="img-rounded img-responsive" src="../uploads/<?php echo $response['team_picture'] ?>" style="margin-left: auto; margin-right: auto;">
                        <?php } ?>

                        <br />
                        <div>
                            <?php if ($isLoggedInTeam && $isAdmin) { ?>
                                <a href="#" class="editable editable-team-info" style="font-size: 20pt; margin-bottom: 0px;" id="team_name" data-emptytext="Click to edit team name"><?php echo $response['team_name']; ?></a>
                                <br />
                                <a href="#" class="editable editable-team-info" style="white-space: pre-wrap" data-type="textarea" id="description" data-emptytext="Click to edit team description"><?php echo $response['description']; ?></a>
                                <br />
                                <br />
                                <strong>Website: </strong><a href="#" class="editable editable-team-info" id="website" data-emptytext="Click to add (don't enter http://)"><?php echo $response['website']; ?></a>
                            <?php } else { ?>
                                <p style="font-size: 20pt; margin-bottom: 0px;"><?php echo $response['team_name']; ?></p>
                                <p style="white-space: pre-wrap"><?php echo $response['description']; ?></p>
                                <?php if (!empty($response['website'])) { ?>
                                    <strong>Website: </strong><a target='_blank' href="http://<?php echo $response['website']; ?>"><?php echo $response['website']; ?></a><br />
                                <?php } ?>
                                <?php if ($stats['contributions'] > 0 || $pit['contributions'] > 0) { ?>
                                    <br /><?php if (!$isLoggedInTeam) { ?>This<?php } else { ?>Your<?php } ?> team has
                                    <?php if ($stats['contributions'] > 0) { ?>match scouted <strong><?= $stats['contributions'] ?> time<?php if ($stats['contributions'] > 1) { ?>s<?php } ?></strong><?php if ($pit['contributions'] <= 0) { ?>.
                                        <?php } else { ?> and <?php
                                        }
                                    }
                                    ?><?php if ($pit['contributions'] > 0) { ?>pit scouted
                                        <?php if ($pit['contributions'] <= $pit['narcissism']) { ?>
                                            <?php if ($isLoggedInTeam) { ?>
                                                <strong>itself</strong>.
                                            <?php } else { ?>
                                                <strong>themselves</strong>.
                                            <?php } ?>
                                        <?php } else { ?>
                                            <strong><?= $pit['contributions'] ?> team<?php if ($pit['contributions'] > 1) { ?>s<?php } ?></strong>.
                                            <?php
                                        }
                                    }
                                    ?>Good job, team<?php if (!$isLoggedInTeam) { ?>&nbsp;<?= $otherTeamNumber ?><?php } ?>!
                                <?php } else { ?>
                                    <br />This team has not scouted any matches, for shame.
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <p style="margin: 10px 0 0 0;"><i>This team is not currently registered with FIRST Scout.</i></p>
                <?php } ?>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Robot Statistics</font>
                <hr style="border-top: 1px solid #bbb">
                <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                    <div id="pitScouting">
                        <em>loading...</em>
                    </div>
                </div>
                <br />
                <?php
                $statsAvailable = false;
                if (!empty($stats['attendance']) || !empty($stats['teleAverageHigh']) ||
                        !empty($stats['percentageOfShotsMade'])) {
                    $statsAvailable = true;
                }
                if ($statsAvailable) {
                    ?>
                    <font style="color: #868686; float: right; font-size: 10pt;">Match Statistics</font>
                    <hr style="border-top: 1px solid #bbb">
                    <!--<div class="table-wrapper table-responsive">-->
                    <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                        <!-- other stats will go here once they exist -->
                        <?php if ($teamType === "FTC") { ?>
                            <!-- ftc stuff, I don't really know how the game works, whoops -->
                        <?php } ?>
                        <?php if ($teamType === "FRC") { ?>
                            <div style="text-align:center;">
                                <strong><a href="/team/<?php echo $otherTeamNumber; ?>/matches/">View individual matches for this team</a></strong>
                                <?php if ($isAdmin) { ?>
                                    <br />As an administrator, use this page to manage data on this team's matches that your team has scouted.
                                <?php } ?>
                            </div><br />
                            <div class="comment-wrapper">
                                <div class="comment-commenter"><strong>General</strong></div>
                                <div class="comment-text">
                                    <hr class="comment-divider-hr" />
                                    <?php if (!empty($stats['attendance'])) { ?>
                                        Attendance Rate: <strong><?php echo $stats['attendance']; ?>%</strong><br />
                                    <?php } ?>
                                    <?php if ($stats['attendance'] > 0) { ?>
                                        <?php if (!empty($stats['winRate'])) { ?>
                                            Win Rate: <strong><?php echo $stats['winRate']; ?>%</strong><br />
                                        <?php } ?>
                                        <?php if (!empty($stats['total_points'])) { ?>
                                            Average Potential Match Score: <strong><?= $stats['total_points'] ?></strong>
                                        <?php } ?>
                                        <?php if (!empty($stats['alliance_score_percent'])) { ?>
                                            (<strong><?= $stats['alliance_score_percent'] ?>%</strong> of actual alliance score)<br />
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($stats['attendance'] > 0) { ?>
                                <div class="comment-wrapper">
                                    <div class="comment-commenter"><strong>Autonomous</strong></div>
                                    <div class="comment-text">
                                        <hr class="comment-divider-hr" />
                                        <?php if (!empty($stats['auto_points'])) { ?>
                                            Average Potential Autonomous Score: <strong><?= $stats['auto_points'] ?></strong><br />
                                        <?php } ?>
                                        <!--
                                        <?php if (!empty($stats['autoAccuracy'])) { ?>
                                                                                                                                Autonomous Accuracy: <strong><?= $stats['autoAccuracy'] ?>%</strong><br />
                                        <?php } ?>
                                        <?php if (!empty($stats['autoHotGoalPercent'])) { ?>
                                                                                                                                Hot Goal Shots: <strong><?= $stats['autoHotGoalPercent'] ?>%</strong><br />
                                        <?php } ?>
                                        -->
                                        <?php if (!empty($stats['autoMovedZonePercent'])) { ?>
                                            Moved to Alliance Zone: <strong><?= $stats['autoMovedZonePercent'] ?>%</strong> of the time<br />
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="comment-wrapper">
                                    <div class="comment-commenter"><strong>Teleoperated</strong></div>
                                    <div class="comment-text">
                                        <hr class="comment-divider-hr" />
                                        <?php if (!empty($stats['tele_points'])) { ?>
                                            Average Potential Teleop Score: <strong><?= $stats['tele_points'] ?></strong><br />
                                        <?php } ?>
                                        <?php if (!empty($stats['percentageOfShotsMade'])) { ?>
                                            High Goal Accuracy: <strong><?php echo $stats['percentageOfShotsMade']; ?>%</strong><br />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleAverageHigh']) || !empty($stats['teleAverageLow'])) { ?>
                                            <hr class="comment-divider-hr" />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleAverageHigh'])) { ?>
                                            Average High Goals: <strong><?php echo $stats['teleAverageHigh']; ?></strong> per match<br />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleAverageLow'])) { ?>
                                            Average Low Goals: <strong><?php echo $stats['teleAverageLow']; ?></strong> per match<br />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleRecvdAssists']) || !empty($stats['telePassedAssists'])) { ?>
                                            <hr class="comment-divider-hr" />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleRecvdAssists'])) { ?>
                                            Average Balls Possessed: <strong><?php echo $stats['teleRecvdAssists']; ?></strong> per match<br />
                                        <?php } ?>
                                        <?php if (!empty($stats['telePassedAssists'])) { ?>
                                            Average Balls Passed: <strong><?php echo $stats['telePassedAssists']; ?></strong> per match<br />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleTrussThrow']) || !empty($stats['teleTrussCatch'])) { ?>
                                            <hr class="comment-divider-hr" />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleTrussThrow'])) { ?>
                                            Average Truss Throws: <strong><?php echo $stats['teleTrussThrow']; ?></strong> per match<br />
                                        <?php } ?>
                                        <?php if (!empty($stats['teleTrussCatch'])) { ?>
                                            Average Truss Catches: <strong><?php echo $stats['teleTrussCatch']; ?></strong> per match<br />
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <em>This team has not shown up to any matches.</em>
                            <?php } ?>
                        <?php } else { ?>
                            <em>no data available</em>

                        <?php } ?>
                    </div>
                <?php } ?>
                <br />
                <span id="matchCommentsTitle" style="display:none;">
                    <font style="color: #868686; float: right; font-size: 10pt;">Match Comments</font>
                    <hr style="border-top: 1px solid #bbb">
                </span>

                <!-- match comments -->
                <div id="matchComments">

                </div>

                <!-- driver comments -->
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Driver and Coach Comments</font>
                <hr style="border-top: 1px solid #bbb">
                <div class="comment-wrapper">
                    <div class="comment-commenter"><strong>Driver 1</strong></div>
                    <div class="comment-text">
                        <hr class="comment-divider-hr" />
                        <span>Name: <a href="#" onclick="return false;" class="editable editable-drive-team" id="driver_1_name"><?php echo $driverData['driver_1_name']; ?></a></span>
                        <br />
                        <span>Comments: <a href="#" onclick="return false;" class="editable editable-drive-team" id="driver_1_description" data-type="text"><?php echo $driverData['driver_1_description']; ?></a></span>
                    </div>
                </div>
                <div class="comment-wrapper">
                    <div class="comment-commenter"><strong>Driver 2</strong></div>
                    <div class="comment-text">
                        <hr class="comment-divider-hr" />
                        <span>Name: <a href="#" onclick="return false;" class="editable editable-drive-team" id="driver_2_name"><?php echo $driverData['driver_2_name']; ?></a></span>
                        <br />
                        <span>Comments: <a href="#" onclick="return false;" class="editable editable-drive-team" id="driver_2_description" data-type="text"><?php echo $driverData['driver_2_description']; ?></a></span>
                    </div>
                </div>
                <div class="comment-wrapper">
                    <div class="comment-commenter"><strong>Coach</strong></div>
                    <div class="comment-text">
                        <hr class="comment-divider-hr" />
                        <span>Name: <a href="#" onclick="return false;" class="editable editable-drive-team" id="coach_name"><?php echo $driverData['coach_name']; ?></a></span>
                        <br />
                        <span>Comments: <a href="#" onclick="return false;" class="editable editable-drive-team" id="coach_description" data-type="text"><?php echo $driverData['coach_description']; ?></a></span>
                    </div>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
    </div>
</body>



<?php if ($isAdmin && $isLoggedInTeam) { ?>

    <script type="text/javascript">

                        $(function() {
                            if ("<?php echo $response['robot_shifters']; ?>" === "1") {
                                $("#lowSpeed").show(100);
                            } else {
                                $("#lowSpeed").hide();
                            }

                            $("#robot_shifters").editable({
                                value: null,
                                source: [
                                    {value: 0, text: 'No'},
                                    {value: 1, text: 'Yes'}
                                ],
                                showbuttons: false,
                                pk: '<?php echo $teamNumber ?>',
                                url: "/ajax-handlers/change-profile-ajax-submit.php",
                                success: function(response, newVal) {
                                    if (response.indexOf("success") === -1) {
                                        showMessage(response, 'warning');
                                    }
                                    if (newVal === "1") {
                                        $("#lowSpeed").show(100);
                                        $("#highText").show(100);
                                    } else {
                                        $("#lowSpeed").hide(100);
                                        $("#highText").hide(100);
                                    }
                                }
                            });

                            $(".editable-team-info").editable({
                                pk: '<?php echo $otherTeamNumber ?>',
                                url: "/ajax-handlers/change-profile-ajax-submit.php",
                                success: function(response, newVal) {
                                    if (response.indexOf("success") === -1) {
                                        showMessage(response, 'warning');
                                    }
                                    console.log(newVal);
                                }
                            });


                            var options = {
                                beforeSend: function()
                                {
                                    $("#progress").show();
                                    //clear everything
                                    $("#bar").width('0%');
                                    $("#message").html("");
                                    $("#percent").html("0%");
                                },
                                uploadProgress: function(event, position, total, percentComplete)
                                {
                                    $("#percent").html('Uploading ' + percentComplete + '%');

                                },
                                success: function(response)
                                {
                                    $("#percent").html('Upload complete!');
                                    console.log("got a response: " + response);
                                    if (response === "Success") {
                                        location.reload();
                                    } else {
                                        showMessage(response, "danger");
                                    }

                                },
                                complete: function(response)
                                {

                                },
                                error: function()
                                {

                                }

                            };

                            $("#submitTeamPicture").ajaxForm(options);
                        });

    </script>
<?php } ?>

<script type="text/javascript">

    $(function() {
        loadAverages();
        loadComments();
        loadPitScouting();
    });

    $(".editable-drive-team").editable({
        pk: '<?php echo $otherTeamNumber ?>',
        mode: 'inline',
        url: "/ajax-handlers/change-drive-team-info.php",
        success: function(response, newVal) {
            if (response.indexOf("success") === -1) {
                showMessage(response, 'warning');
            }
            console.log(newVal);
        }
    });


    function loadComments() {
        $.ajax({
            url: '/ajax-handlers/load-frc-profile-info.php',
            type: "POST",
            data: {
                'teamNumber': '<?php echo $otherTeamNumber ?>',
                'thingToLoad': 'comments'
            },
            success: function(response, textStatus, jqXHR) {
                $("#matchComments").html(response);

                if (response !== "") {
                    $("#matchCommentsTitle").show();
                }
                //$("#commentsTable").tablesorter();
            }
        });
    }
    ;

    function loadAverages() {
        $.ajax({
            url: '/ajax-handlers/load-frc-team-averages.php',
            type: "POST",
            data: {
                'teamNumber': '<?php echo $otherTeamNumber ?>'
            },
            success: function(response, textStatus, jqXHR) {
                $("#averages").html(response);
                $("#tablesorter").tablesorter();
            }
        });
    }
    ;

    function loadPitScouting() {
        $.ajax({
            url: '../../ajax-handlers/load-frc-profile-info.php',
            type: 'POST',
            data: {
                'teamNumber': '<?= $otherTeamNumber ?>',
                'thingToLoad': 'pit'
            },
            success: function(response, textStatus, jqXHR) {
                $("#pitScouting").html(response);
            }
        });
    }

</script>
</body>
</html>
