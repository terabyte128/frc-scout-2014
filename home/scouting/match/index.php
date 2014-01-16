<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';

if($teamType === "FTC") {
    header('location: /home/ftc/container.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Match Data Entry</title>
        <?php include $docRoot . '/includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $docRoot . '/includes/messages.php'; ?>
                <div id="content-holder">
                    <h1>y u no work yo</h1>
                </div>
                <?php include $docRoot . '/includes/footer.php' ?>
            </div>
        </div>
    </body>
</html>

