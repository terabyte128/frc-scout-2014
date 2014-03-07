<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/get-teams-at-location.php';

$query = Teams::getPitScoutedAtLocation($location);
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Teams Here</title>
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
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;">Teams At Your Location</h2>
                <p><i>All teams that have been pit scouted at your location</i></p>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <br />
                <!-- ~ page content goes here ~ -->
                <div class="table-wrapper table-responsive" style="max-width: 400px;">
                    <table id="averagesTable" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th>Team Number</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<a href=\"/team/" . $row['scouted_team'] . "\">";
                                echo $row['scouted_team'];
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
                    $("#averagesTable").tablesorter();
        </script>
    </body>
</html>

