<?php
require '../includes/setup-session.php';
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
                <h2>Team <?php echo $teamNumber ?>'s Profile</h2>
                <a href="#" id="teamName" data-type="text" data-url="../ajax-handlers/change-profile-ajax-submit.php" data-id="team_name" data-title="Update team name">team name</a>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#teamName").editable();
            });
        </script>
    </body>
</html>
