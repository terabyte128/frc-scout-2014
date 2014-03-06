<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Team Average Graphs</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>

        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;">Team Average Graphs</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <br />

                <!-- ~ page content goes here ~ -->

                <div id="graph"></div>

                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            /*
             * auto_points
             * tele_points
             * total_points
             */
        

            $(function() {
                $('#graph').highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Average Overall Score'
                    },
                    xAxis: {
                        categories: [
                            '4030',
                            '5481',
                            '1253'
                        ],
                        title: {
                            text: "Team Number"
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total Score'
                        }
                    },
                    legend: {
                        backgroundColor: '#FFFFFF',
                        reversed: true
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },
                    series: [{
                            name: 'Autonomous Score',
                            data: [5, 3, 4,]
                        }, {
                            name: 'Teleoperated Score',
                            data: [2, 2, 3]
                        }]
                });
            });
            
            function loadTable(onlyLoggedInTeam, onlyThisLocation) {
                $("#loading").show();
                $.ajax({
                    url: '/ajax-handlers/load-frc-team-averages.php',
                    data: {
                        'onlyLoggedInTeam': onlyLoggedInTeam,
                        'onlyThisLocation': onlyThisLocation
                    },
                    success: function(response) {
                        $("#loading").hide();
                        $("#tableBody").html(response);
                        $("#averagesTable").trigger("update");
                        var sorting = [[1, 1]];
                        $("#averagesTable").trigger("sorton", [sorting]);
                    }
                });
            }</script>
    </body>
</html>
