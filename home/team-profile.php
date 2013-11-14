<?php
require '../includes/setup-session.php';
require '../includes/db-connect.php';
try {
    $request = $db->prepare('SELECT team_name, description, team_picture FROM ' . $teamTable . ' WHERE team_number=?');
    $request->execute(array($teamNumber));
    $response = $request->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php' ?>
        <title>Your Team Profile</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>Your Team's Profile</h2>
                <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                    <?php if ($isAdmin) { ?>
                        <div>
                            <img class="img-rounded img-responsive" src="../uploads/<?php echo $response['team_picture'] ?>" style="margin-left: auto; margin-right: auto;">
                            <form id="submitTeamPicture" action="../uploads/uploader.php" method="post" enctype="multipart/form-data">
                                <label for="teamPicture">Update team picture: </label>
                                <input class="form-control" type="file" size="60" name="teamPicture">
                                <button class="form-control btn btn-sm" id="percent">Update</button>
                            </form>
                        </div>
                        <br />
                        <span>Team Name: <a href="#" class="editable" data-type="text" id="team_name" title="Update team name"><?php echo $response['team_name'] ?></a></span>
                        <br />
                        <span>Team Description: <a href="#" class="editable" data-type="textarea" id="description" title="Update team description"><?php echo $response['description'] ?></a></span>
                    <?php } else { ?>
                        <?php if (!empty($response['team_picture'])) { ?>
                            <img class="img-rounded img-responsive" alt="This team has not yet uploaded a photo." src="../uploads/<?php echo $response['team_picture'] ?>" style="margin-left: auto; margin-right: auto;">
                        <?php } ?>
                        <br />
                        <span>Team Name: <?php echo $response['team_name'] ?></span>
                        <br />
                        <span>Team Description: <?php echo $response['description'] ?></span>
                    <?php } ?>
                </div>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
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
    </body>
</html>
