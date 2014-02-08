<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2>Team Averages</h2>
                <label>View data collected by:</label><br />
                <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                    <label class="btn btn-default active" style="width: 130px;" id="all" onclick="window.location.hash = 'all'">
                        <input type="radio">All Teams
                    </label>
                    <label class="btn btn-default" style="width: 130px;" id="only" onclick="window.location.hash = 'only'">
                        <input type="radio">Only <?php echo $teamNumber ?>
                    </label>
                </div>
                <div class="table-responsive">
                    <table id="averagesTable" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th>Team Number</th>
                                <th>Total Points</th>
                                <th>Autonomous Points</th>
                                <th>Teleop Points</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">

                        </tbody>
                    </table>
                </div>
                * Note: for scoring purposes, all assists are counted as being worth 10 points.
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                if (window.location.hash === "#only") {
                    loadTable(true);
                    $("#all").removeClass("active");
                    $("#only").addClass("active");
                } else {
                    loadTable(false);
                }
            });

            window.onhashchange = function() {
                if (window.location.hash === "#only") {
                    loadTable(true);
                } else {
                    loadTable(false);
                }
            }


            function loadTable(onlyLoggedInTeam) {
                $.ajax({
                    url: '/ajax-handlers/load-team-averages.php',
                    data: {
                        'onlyLoggedInTeam': onlyLoggedInTeam
                    },
                    success: function(response) {
                        $("#tableBody").html(response);
                        $("#averagesTable").tablesorter({
                            sortList: [[1, 1]]
                        });
                    }
                })
            }
        </script>
    </body>
</html>
