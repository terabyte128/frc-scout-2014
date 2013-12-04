<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php' ?>
        <?php if ($isLoggedInTeam) { ?>
            <title>Your Team Profile</title>
        <?php } else { ?>
            <title>Team <?php echo $otherTeamNumber; ?>'s Profile</title>
        <?php } ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">             
                <?php include '../includes/messages.php' ?>
                <?php if ($isLoggedInTeam) { ?>
                    <h2>Your Team Profile</h2>
                <?php } else { ?>
                    <h2>Team <?php echo $otherTeamNumber; ?>'s Profile</h2>
                <?php } ?>                
                <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                    <?php if ($isRegistered) { ?>          
                        <?php if (!empty($response['team_picture'])) { ?>
                            <img class="img-rounded img-responsive" src="../uploads/<?php echo $response['team_picture'] ?>" style="margin-left: auto; margin-right: auto;">
                        <?php } ?>
                        <?php if ($isLoggedInTeam && $isAdmin) { ?>
                            <form id="submitTeamPicture" action="../uploads/uploader.php" method="post" enctype="multipart/form-data">
                                <label for="teamPicture">Update team picture: </label>
                                <input class="form-control" type="file" size="60" name="teamPicture">
                                <button class="form-control btn btn-sm" id="percent">Update</button>
                            </form>
                        <?php } ?>
                        <br />
                        <div>
                            <span style="font-weight: 600;">Team Name: </span>
                            <?php if ($isAdmin && $isLoggedInTeam) { ?>
                                <a href="#" class="editable" data-type="text" id="team_name" title="Update team name">
                                <?php } ?>
                                <span><?php
                                    if (!empty($response['team_name']))
                                        echo $response['team_name'];
                                    else
                                        echo "<i>&mdash; none &mdash;</i>";
                                    ?></span>
                                <?php if ($isAdmin && $isLoggedInTeam) { ?>
                                </a>
                            <?php } ?>
                            <br />
                            <span style="font-weight: 600;">Team Description: </span><br />
                            <?php if ($isAdmin && $isLoggedInTeam) { ?>
                                <a href="#" class="editable" data-type="textarea" style="white-space: normal;" id="description" title="Update team description">
                                <?php } ?>                           
                                <span><?php
                                    if (!empty($response['description']))
                                        echo $response['description'];
                                    else
                                        echo "<i>&mdash; none &mdash;</i>";
                                    ?></span>
                                <?php if ($isAdmin && $isLoggedInTeam) { ?>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <h3>This team has not yet registered for FIRST Scout!</h3>
                    <?php } ?>
                    <!-- other stats will go here once they exist -->
                    <?php if ($teamType === "FTC") { ?>
                    
                    <?php } ?>
                </div>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
        <?php if ($isAdmin && $isLoggedInTeam) { ?>
            <script type="text/javascript">
                $(function() {
                    $(".editable").editable({
                        pk: '<?php echo $teamNumber ?>',
                        url: "../ajax-handlers/change-profile-ajax-submit.php",
                        success: function(response, newVal) {
                            if (response.indexOf("success") === -1) {
                                showMessage(response, 'warning');
                            }
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
    </body>
</html>
