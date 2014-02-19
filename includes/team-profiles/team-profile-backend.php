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
                <?php include '../messages.php' ?>
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
                        <a href="#" class="editable" style="font-size: 20pt; margin-bottom: 0px;" id="team_name" data-emptytext="Click to edit team name"><?php echo $response['team_name']; ?></a>
                        <br />
                        <a href="#" class="editable" style="white-space: pre-wrap" data-type="textarea" id="description" data-emptytext="Click to edit team description"><?php echo $response['description']; ?></a>
                        <br />
                        <br />
                        <strong>Website: </strong><a href="#" class="editable" id="website" data-emptytext="Click to add (don't enter http://)"><?php echo $response['website']; ?></a>
                        <?php } else { ?>
                        <p style="font-size: 20pt; margin-bottom: 0px;"><?php echo $response['team_name']; ?></p>
                        <p style="white-space: pre-wrap"><?php echo $response['description']; ?></p>
                        <?php if (!empty($response['website'])) { ?>
                        <strong>Website: </strong><a target='_blank' href="http://<?php echo $response['website']; ?>"><?php echo $response['website']; ?></a>
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
                    <?php if ($isAdmin && $isLoggedInTeam) { ?>

    <!--<p id="dimensions"><strong>Dimensions: </strong>
    <a href='#' id='robot_length' class="editable"><?php echo $response['robot_length']; ?></a> length x
    <a href='#' id='robot_width' class="editable"><?php echo $response['robot_width']; ?></a> width x
    <a href='#' id='robot_height' class="editable"><?php echo $response['robot_height']; ?></a> height
    </p>
    <p id="weight"><strong>Weight: </strong><a href='#' id='robot_weight' class="editable"><?php echo $response['robot_weight']; ?></a></p>
    <p id="drivetrain"><strong>Drivetrain: </strong><a href='#' id='robot_drivetrain_type' class="editable"><?php echo $response['robot_drivetrain_type']; ?></a></p>
    <p id="wheelType"><strong>Wheel Type: </strong><a href='#' id='robot_wheel_type' class="editable"><?php echo $response['robot_wheel_type']; ?></a></p>
    <p id="shifters"><strong>Shifters: </strong><a href='#' id='robot_shifters' data-type="select" class="editable">
                    <?php
                    if ($response['robot_shifters'] === "0") {
                    echo "No";
                    } else if ($response['robot_shifters'] === "1") {
                    echo "Yes";
                    } else {
                    echo "Choose an option";
                    }
                    ?></a></p>
    <p id="lowSpeed"><strong>Low Speed: </strong><a href='#' id='robot_low_speed' class="editable"><?php echo $response['robot_low_speed']; ?></a></p>
    <p id="highSpeed"><strong><span id='highText' style='display:inline;'><?php if ($response['robot_shifters'] === "1") { ?>High&nbsp;<?php } ?></span>Speed: </strong><a href='#' id='robot_high_speed' class="editable"><?php echo $response['robot_high_speed']; ?></a></p>
    <p id="startingPosition"><strong>Starting Position: </strong><a href='#' id='robot_starting_position' class="editable"><?php echo $response['robot_starting_position']; ?></a></p>
    <p id="role"><strong>Role: </strong><a href='#' id='robot_role' class="editable"><?php echo $response['robot_role']; ?></a></p>
    <p id="comments"><strong>Comments: </strong><a href='#' id='robot_comments' class="editable" data-type="textarea"><?php echo $response['robot_comments']; ?></a></p>-->

                    <?php } else { ?>
                    <!--<div>
                    <?php if (!empty($response['robot_length'])) { ?>
                        <p id="dimensions"><strong>Dimensions: </strong><?php echo $response['robot_length']; ?> length x <?php echo $response['robot_width']; ?> width x <?php echo $response['robot_height']; ?> height</p>
                    <?php } ?>
                    <?php if (!empty($response['robot_weight'])) { ?>
                        <p id="weight"><strong>Weight: </strong><?php echo $response['robot_weight']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_drivetrain'])) { ?>
                        <p id="drivetrain"><strong>Drivetrain: </strong><?php echo $response['robot_drivetrain_type']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_wheel_type'])) { ?>
                        <p id="wheelType"><strong>Wheel Type: </strong><?php echo $response['robot_wheel_type']; ?></p>
                    <?php } ?>
                    <?php if ($response['robot_shifters'] !== null) { ?>
                        <p id="shifters"><strong>Shifters: </strong><?php echo $response['robot_shifters'] === "1" ? "Yes" : "No"; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_low_speed']) && $response['robot_shifters'] === "1") { ?>
                        <p id="lowSpeed"><strong>Low Speed: </strong><?php echo $response['robot_low_speed']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_high_speed'])) { ?>
                        <p id="highSpeed"><strong><?php if ($response['robot_shifters'] === "1") { ?>High <?php } ?>Speed: </strong><?php echo $response['robot_high_speed']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_starting_position'])) { ?>
                        <p id="startingPosition"><strong>Starting Position: </strong><?php echo $response['robot_starting_position']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_role'])) { ?>
                        <p id="role"><strong>Role: </strong><?php echo $response['robot_role']; ?></p>
                    <?php } ?>
                    <?php if (!empty($response['robot_comments'])) { ?>
                        <p id="comments" style="white-space: pre-wrap;"><strong>Comments: </strong><?php echo $response['robot_comments']; ?></p>
                    <?php } ?>
                    </div> -->
                    <?php } ?>
                    <div id="pitScouting">
                        <em>loading...</em>
                    </div>
                </div>
                <br />
                <?php
                $statsAvailable = false;
                if (!empty($stats['attendance']) ||!empty($stats['teleAverageHigh']) ||
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
                    <!--
                    <table class="table table-striped table-bordered table-hover tablesorter" id="tablesorter">
                    <thead>
                    <th>Event</th>
                    <th>Match Number</th>
                    <th>Total Score</th>
                    <th>Auto Score</th>
                    <th>Teleop Score</th>
                    <th>Assists Received</th>
                    </thead>
                    <tbody id="averages">
                    
                    </tbody>
                    </table>
                    -->
                    <!--<h3>Percentages</h3>
                    <ul>
                    <li><strong>Attendance Rate: </strong><?php echo $stats['attendance']; ?>%</li>
                    <li><strong>Teleop Goal Scoring Rate: </strong><?php echo $stats['percentageOfShotsMade']; ?>%</li>
                    </ul>
                    
                    <h3>Averages</h3>
                    <ul>
                    <li><strong>Teleop High Goals: </strong><?php echo $averageGoals['teleAverageHigh']; ?></li>
                    <li><strong>Teleop Low Goals: </strong><?php echo $averageGoals['teleAverageLow']; ?></li>
                    <li><strong>Teleop Truss Throws: </strong><?php echo $averageGoals['teleTrussThrow']; ?></li>
                    <li><strong>Teleop Truss Catches: </strong><?php echo $averageGoals['teleTrussCatch']; ?></li>
                    </ul>-->

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
                                Attendance rate: <strong><?php echo $stats['attendance']; ?>%</strong><br />
                            <?php } ?>
                            <?php if ($stats['attendance'] > 0) { ?>
                                <?php if (!empty($stats['winRate'])) { ?>
                                    Win rate: <strong><?php echo $stats['winRate']; ?>%</strong><br />
                                <?php } ?>
                                <?php if(!empty($stats['total_points'])) { ?>
                                    Average match score: <strong><?= $stats['total_points'] ?></strong>
                                <?php } ?>
                                <?php if (!empty($stats['alliance_score_percent'])) { ?>
                                    (<strong><?= $stats['alliance_score_percent'] ?>%</strong> of alliance score)<br />
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
                            Average Autonomous Score: <strong><?= $stats['auto_points'] ?></strong><br />
                            <?php } ?>
                            <?php if (!empty($stats['autoAccuracy'])) { ?>
                            Autonomous Accuracy: <strong><?= $stats['autoAccuracy'] ?>%</strong><br />
                            <?php } ?>
                            <?php if (!empty($stats['autoHotGoalPercent'])) { ?>
                            Hot Goal Shots: <strong><?= $stats['autoHotGoalPercent'] ?>%</strong><br />
                            <?php } ?>
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
                            Average Teleop Score: <strong><?= $stats['tele_points'] ?></strong><br />
                            <?php } ?>
                            <?php if (!empty($stats['percentageOfShotsMade'])) { ?>
                            High Goal Accuracy: <strong><?php echo $stats['percentageOfShotsMade']; ?>%</strong><br />
                            <?php } ?>
                            <?php if (!empty($stats['teleAverageHigh']) ||!empty($stats['teleAverageLow'])) { ?>
                            <hr class="comment-divider-hr" />
                            <?php } ?>
                            <?php if (!empty($stats['teleAverageHigh'])) { ?>
                            Average High Goals: <strong><?php echo $stats['teleAverageHigh']; ?></strong> per match<br />
                            <?php } ?>
                            <?php if (!empty($stats['teleAverageLow'])) { ?>
                            Average Low Goals: <strong><?php echo $stats['teleAverageLow']; ?></strong> per match<br />
                            <?php } ?>
                            <?php if (!empty($stats['teleRecvdAssists']) ||!empty($stats['telePassedAssists'])) { ?>
                            <hr class="comment-divider-hr" />
                            <?php } ?>
                            <?php if (!empty($stats['teleRecvdAssists'])) { ?>
                            Average Balls Possessed: <strong><?php echo $stats['teleRecvdAssists']; ?></strong> per match<br />
                            <?php } ?>
                            <?php if (!empty($stats['telePassedAssists'])) { ?>
                            Average Balls Passed: <strong><?php echo $stats['telePassedAssists']; ?></strong> per match<br />
                            <?php } ?>
                            <?php if (!empty($stats['teleTrussThrow']) ||!empty($stats['teleTrussCatch'])) { ?>
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
<?php } ?>
                </div>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Match Comments</font>
                <hr style="border-top: 1px solid #bbb">
                <div id="matchComments">

                </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
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

            $(".editable").editable({
                pk: '<?php echo $teamNumber ?>',
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

        function loadComments() {
            $.ajax({
                url: '../../ajax-handlers/load-frc-profile-info.php',
                type: "POST",
                data: {
                    'teamNumber': '<?php echo $otherTeamNumber ?>',
                    'thingToLoad': 'comments'
                },
                success: function(response, textStatus, jqXHR) {
                    $("#matchComments").html(response);
                    //$("#commentsTable").tablesorter();
                }
            });
        }
        ;

        function loadAverages() {
            $.ajax({
                url: '../../ajax-handlers/load-frc-team-averages-ajax-handler.php',
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
