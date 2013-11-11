<?php
require '../includes/setup-session.php';
require '../includes/db-connect.php';
$request = $db->prepare('SELECT team_name, description FROM team_accounts WHERE team_number=?');
$request->execute(array($teamNumber));
$response = $request->fetch(PDO::FETCH_ASSOC);
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
                    <div style="height: 300px; border: 2px solid black;">team picture will go here in the future</div>
                    <br />
                    <?php if ($isAdmin) { ?>
                        <span>Team Name: <a href="#" class="editable" data-type="text" id="team_name" title="Update team name"><?php echo $response['team_name'] ?></a></span>
                        <br />
                        <span>Team Description: <a href="#" class="editable" data-type="textarea" id="description" title="Update team description"><?php echo $response['description'] ?></a></span>
                    <?php } else { ?>
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
            });
        </script>
    </body>
</html>
