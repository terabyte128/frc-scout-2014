<?php
$otherTeamNumber = $_GET['team'];
require '../includes/setup-session.php';
require '../includes/db-connect.php';
$request = $db->prepare('SELECT team_name, description FROM ' . $teamTable . ' WHERE team_number=?');
$request->execute(array($otherTeamNumber));
$response = $request->fetch(PDO::FETCH_ASSOC);
if (empty($response)) {
    $unregisted = true;
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
                <?php if ($unregisted) { ?>
                    <h5>This team has not yet registered for FRC Scout!</h5>
                <?php } ?>
                <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                    <?php if (!$unregisted) { ?>
                        <div style="height: 300px; border: 2px solid black;">team picture will go here in the future</div>
                        <br />
                        <span>Team Name: <?php echo $response['team_name'] ?></span>
                        <br />
                        <span>Team Description: <?php echo $response['description'] ?></span>
                    <?php } ?>
                </div>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>
