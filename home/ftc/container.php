<?php require_once '../../includes/setup-session.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Match Entry</title>
        <?php include '../../includes/headers.php'; ?>
        <link type='text/css' rel='stylesheet' href='ftc.css'>
    </head>
    <body>
        <div class="wrapper">
            <div class="container" id='container'>

            </div>
        </div>
        <script type='text/javascript'>
            $(function() {
                $("#container").load("ajax-forms/autonomous.php", function() {
                    window.scrollTo(0, 1);
                });
            });
        </script>
    </body>
</html>
