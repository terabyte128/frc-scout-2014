<!DOCTYPE html>
<html>
    <head>
        <?php if ($isLoggedInTeam) { ?>
            <title>Your Team Profile</title>
        <?php } else { ?>
            <title>Team <?php echo $otherTeamNumber; ?>'s Profile</title>
        <?php } ?>
        <?php include '../includes/headers.php'; ?>
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
                            <?php } else { ?>
                                <p style="font-size: 20pt; margin-bottom: 0px;"><?php echo $response['team_name']; ?></p>
                                <p style="white-space: pre-wrap"><?php echo $response['description']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <p style="margin: 10px 0 0 0;"><i>This team is not currently registered with FIRST Scout.</i></p>
                <?php } ?>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Robot Statistics</font>
                <hr style="border-top: 1px solid #bbb">
                <div class="table-wrapper" style="text-align:left; margin:2px auto 2px auto">
                    <!-- other stats will go here once they exist -->
                    <?php if ($teamType === "FTC") { ?>
                        <!-- ftc stuff, I don't really know how the game works, whoops --> 
                    <?php } ?>
                    <?php if ($teamType === "FRC") { ?>
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
                    <?php } ?>
                </div>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Comments</font>
                <hr style="border-top: 1px solid #bbb">
                <div class="table-wrapper" style="text-align:left; margin:2px auto 2px auto" id="comments">
                    <table class="table table-striped table-bordered table-hover tablesorter" id="commentsTable">
                        <thead>
                        <th>Event</th>
                        <th>Match Number</th>
                        <th>Comment</th>
                        </thead>
                        <tbody id="commentBody">
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div> 
        </div>
    </body>

    <?php if ($isAdmin && $isLoggedInTeam) { ?>
        <script type="text/javascript">
                    $(function() {
                        $(".editable").editable({
                            pk: '<?php echo $teamNumber ?>',
                            url: "/ajax-handlers/change-profile-ajax-submit.php",
                            success: function(response, newVal) {
                                if (response.indexOf("success") === -1) {
                                    showMessage(response, 'warning');
                                }
                                showMessage(newVal, "danger");
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
        });

        function loadComments() {
            $.ajax({
                url: '../../ajax-handlers/load-frc-comments.php',
                type: "POST",
                data: {
                    'teamNumber': '<?php echo $otherTeamNumber ?>'
                },
                success: function(response, textStatus, jqXHR) {
                    $("#commentBody").html(response);
                    $("#commentsTable").tablesorter();
                }
            });
        }

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
    </script>
</body>
</html>