<?php
$otherTeamNumber = $_GET['team'];
require '../includes/setup-session.php';
require '../includes/db-connect.php';
$request = $db->prepare('SELECT team_name, description, team_picture FROM ' . $teamTable . ' WHERE team_number=?');
$request->execute(array($otherTeamNumber));
$response = $request->fetch(PDO::FETCH_ASSOC);
if (empty($response)) {
    $unregistered = true;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php' ?>
        <title>Team <?php echo $otherTeamNumber ?>'s Profile</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>Team <?php echo $otherTeamNumber ?>'s Profile</h2>
                <?php if ($unregistered) { ?>
                    <h5>This team has not yet registered for FRC Scout!</h5>
                <?php } else { ?>
                    <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                        <div>
                            <?php if (!empty($response['team_picture'])) { ?>
                                <img class="img-rounded img-responsive" alt="This team has not yet uploaded a photo." src="../uploads/<?php echo $response['team_picture'] ?>">
                                <br />
                            <?php } ?>
                        </div>
                        <span>Team Name: <?php echo $response['team_name'] ?></span>
                        <br />
                        <span>Team Description: <?php echo $response['description'] ?></span>
                    </div>
                <?php } ?>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>
