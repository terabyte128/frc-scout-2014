<?php require_once '../../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html
    <head>

        <?php include '../../includes/headers.php'; ?>
        <title>FIRST Scout: Home</title>
        <script type="text/javascript" src="../../includes/jquery.tablesorter.js"></script>
        <link rel="stylesheet" href="../../css/theme.default.css">

    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../../includes/messages.php' ?>
                <h2>FTC Team Averages</h2>
                <br />
                <table class="table table-striped" id="tablesorter">
                    <thead>
                    <th>Team Number</th>
                    <th>Average Auto Score</th>
                    <th>Average End Balanced</th>
                    <th>Average Tele Score</th>
                    <th>Average Flag Score</th>
                    <th>Average Hang Score</th>
                    </thead>
                    <tbody id="averages">

                    </tbody>
                </table>
                <?php include '../../includes/footer.php' ?>
            </div>
        </div> 
    </body>
    <script type="text/javascript">
        $(function() {
            loadAverages();
        });

        function loadAverages() {
            $.ajax({
                url: '../../ajax-handlers/load-ftc-team-averages-ajax-handler.php',
                type: "POST",
                success: function(response, textStatus, jqXHR) {
                    $("#averages").html(response);
                    $("#tablesorter").tablesorter();
                }
            });
        }
    </script>
</html>

