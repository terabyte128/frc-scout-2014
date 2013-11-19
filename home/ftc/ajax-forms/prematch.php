<?php require_once '../../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pre-match Info</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="ftc.css">
        <?php include '../../includes/headers.php'; ?>

    </head>
    <body>
        <h2 align="center"> Pre-Match Information </h2>
        <br>
        <div class="container" align="center">
            <form>
                <fieldset>
                    <label align="center"> Scouted Team Number: </label>
                    <input type="text" class="full" placeholder="Team Number">
                    <br><br><label align="center"> Match Number: </label>
                    <input type="text" class="full" placeholder="Match Number">
                </fieldset>
                <br><br> 
                <div class="btn-group">
                    <button class="btn btn-danger btn-small half" type="button"> Red Alliance </button>
                    <button class="btn btn-primary btn-small half" type="button"> Blue Alliance </button>
                </div>
                <br><br><br><br>
                <a class="btn btn-success full" href="scout_page_3_auto.html" type="button"> Continue to Autonomous </a>
        </div>
    </form>

</body>
</html>
