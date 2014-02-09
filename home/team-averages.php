<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';

try {
    $query = $db->prepare('SELECT scouted_team, '
            . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5)), 1) AS auto_points, '
            . 'format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) '
            . '+ (tele_truss_catches * 10)), 1) AS tele_points, '
            . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + '
            . '(tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)), 1) AS total_points '
            . 'FROM `frc_match_data` GROUP BY scouted_team');
    $query->execute(array());
} catch (PDOException $e) {
    print_r($e->getMessage());
}

print_r($results);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
<?php include $docRoot . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
<?php include $docRoot . '/includes/messages.php'; ?>
                <h2>Team Averages</h2>
                <label>View data collected by:</label><br />
                <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                    <label class="btn btn-default active" style="width: 130px;" id="win">
                        <input type="radio">All Teams
                    </label>
                    <label class="btn btn-default" style="width: 130px;" id="lose">
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
                        <tbody>
<?php while ($results = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><a href="/team/<?php echo $results['scouted_team']; ?>">
    <?php echo $results['scouted_team']; ?>
                                    </a></td>
                                    <td>
    <?php echo $results['total_points']; ?>
                                    </td>
                                    <td>
    <?php echo $results['auto_points']; ?>
                                    </td>
                                    <td>
    <?php echo $results['tele_points']; ?>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
                * Note: for scoring purposes, all assists are counted as being worth 10 points.
<?php include $docRoot . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#averagesTable").tablesorter({
                    sortList: [[1, 1]]
                });
            });
        </script>
    </body>
</html>
