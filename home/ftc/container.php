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
            <div class="container" id="outer">
                <div id="container"></div>
                <br /><br />
            </div>
        </div>
        <script type='text/javascript'>

            function setBorderColor(color) {
                var colorString = '5px solid ' + color;
                $("#outer").css({
                    'border-top': colorString,
                    'border-bottom': colorString
                })
            }
            $(function() {
                $("#container").load("ajax-forms/prematch.php", function() {
                    window.scrollTo(0, 1);
                });
            });

            function processResponse(response) {
                if (response[0] !== "Success") {
                    showMessage(response[0]);
                } else {
                    $("#container").load("ajax-forms/" + response[1], function() {
                        window.scrollTo(0, 1);
                    });
                }
            }
        </script>
    </body>
</html>
