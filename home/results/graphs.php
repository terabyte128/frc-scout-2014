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
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Team Average Graphs</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <p><i>This displays <strong>potential scores</strong> based on assists being worth 10 points apiece. For more detailed statistics, enter a team number:</i></p>

                <form class='form-inline' onsubmit="window.location = '/team/' + $('#teamNumberInput').val();
                        return false;">
                    <div class='form-group'>
                        <input type="number" id="teamNumberInput" class='form-control' required>
                    </div>
                    <div class='form-group'>
                        <button class="btn btn-default" type='submit'>Go</button>
                    </div>
                </form>
                <!-- ~ page content goes here ~ -->
                <br />
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


                    var responseArray;

                    $(function() {
                        $("#loading").show();
                        $.ajax({
                            url: '/ajax-handlers/load-frc-averages-for-graphs.php',
                            success: function(response) {
                                console.log(response);
                                responseArray = JSON.parse(response);
                                if (responseArray[0].length > 0) {
                                    var height = (responseArray[0].length * 30) + 100;
                                    $("#graph").css("height", height + "px");
                                    loadGraph(responseArray[0], responseArray[1], responseArray[2]);
                                } else {
                                    $("#graph").html("<i>No match scouting data has been entered for this location yet.</i>");
                                }
                                $("#loading").hide();
                            }
                        });
                    });

                    function loadGraph(teamNumbers, autonomousScores, teleopScores) {
                        $('#graph').highcharts({
                            chart: {
                                type: 'bar'
                            },
                            title: {
                                text: 'Average Overall Score'
                            },
                            xAxis: {
                                categories: teamNumbers,
                                title: {
                                    text: "Team Number"
                                }
                            },
                            yAxis: {
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
                                    data: autonomousScores
                                }, {
                                    name: 'Teleoperated Score',
                                    data: teleopScores
                                }]
                        });
                    }

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
