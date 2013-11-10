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
                
                <?php include '../includes/footer.php' ?>
            </div>
        </div>
    </div>  
</body>
</html>
