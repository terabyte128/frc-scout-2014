<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];
require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$otherTeamNumber = $_GET['team'];
$queryString = "SELECT *, "
        . "(auto_goal_value + 5*auto_hot_goal + 5*auto_moved_to_alliance_zone) AS `auto_total_points`, "
        . "(tele_low_goals + 10*tele_high_goals + 10*tele_truss_throws + 10*tele_truss_catches + 10*tele_received_assists) AS `tele_total_points`, "
        . "format((tele_high_goals / (tele_high_goals + tele_missed_goals)) * 100, 1) AS tele_accuracy, "
        . "(tele_high_goals + tele_missed_goals) AS tele_total_shots, "
        . "(SELECT (auto_goal_value + 5*auto_hot_goal + 5*auto_moved_to_alliance_zone + "
        . "tele_low_goals + 10*tele_high_goals + 10*tele_truss_throws + 10*tele_truss_catches + "
        . "10*tele_received_assists)) AS total_points, "
        . "(SELECT format((total_points / total_match_points) * 100, 0)) AS proportion "
        . "FROM frc_match_data WHERE scouted_team=?";
$params = array($otherTeamNumber);
try {
    $query = $db->prepare($queryString);
    $query->execute($params);
} catch (PDOException $e) {
    print_r($e->getMessage());
}

$listNum = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Matches for Team <?php echo $otherTeamNumber; ?></title>
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
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Team <?php echo $otherTeamNumber ?>'s Matches</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <br />
                <?php while ($match = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="comment-wrapper">
                        <div class="comment-timestamp">
                            <?php echo $match['location']; ?>, <?php echo $match['timestamp']; ?>, match <?php echo $match['match_number']; ?>
                            <?php if ($match['team_absent'] !== "1") { ?>
                                (<a id="expander<?php echo $listNum; ?>" href="#">more</a>)
                            <?php } ?>
                        </div>
                        <div class="comment-commenter">
                            <?php if ($teamNumber !== $match['scouting_team'] || $match['scout_name'] === "") { ?>
                                Scouted by <a href="/team/<?php echo $match['scouting_team']; ?>">team <?php echo $match['scouting_team']; ?></a>
                            <?php } else { ?>
                                Scouted by <strong><?php echo $match['scout_name']; ?></strong> (<a href="/team/<?php echo $match['scouting_team']; ?>">team <?php echo $match['scouting_team']; ?></a>)
                            <?php } ?>
                        </div>
                        <div class="comment-text">
                            <hr class="comment-divider-hr" />
                            <?php if ($match['team_absent'] !== "1") { ?>
                                <span class="comment-commenter"><strong>General</strong></span><br />
                                Total score: <strong><?php echo $match['total_points']; ?></strong> (<strong><?= $match['proportion']; ?>%</strong> of alliance score)<br />
                                Match outcome: <strong><?php if ($match['match_outcome'] === "0") { ?>
                                        <span style="color: #468847;">Win</span>
                                    <?php } else if ($match['match_outcome'] === "1") { ?>
                                        <span style="color: #a9302a;">Lose</span>
                                    <?php } else if ($match['match_outcome'] === "2") { ?>
                                        <span style="color: #d0a305;">Tie</span>
                                    <?php } ?></strong>
                                <div id="moreGeneralData<?php echo $listNum; ?>" style="display:none;">
                                    Alliance color: <strong><?php if ($match['alliance_color'] === "1") { ?>
                                            <span style="color: #0044cc;">Blue</span>
                                        <?php } else { ?>
                                            <span style="color: #a9302a;">Red</span>
                                        <?php } ?></strong><br />
                                    Alliance total score: <strong><?= $match['total_match_points']; ?></strong>
                                </div>
                                <hr class="comment-divider-hr" />
                                <span class="comment-commenter"><strong>Autonomous</strong></span><br />
                                Points scored: <strong><?php echo $match['auto_total_points']; ?></strong>
                                <div id="moreAutoData<?php echo $listNum; ?>" style="display:none;">
                                    Goal scored: <strong><?php
                                        if ($match['auto_missed_goal'] === "1") {
                                            echo '<span style="color: #a9302a;">Missed</span>';
                                        } else if ($match['auto_goal_value'] === "6") {
                                            echo 'Low';
                                        } else if ($match['auto_goal_value'] === "15") {
                                            echo 'High';
                                        } else {
                                            echo "Didn't shoot";
                                        }
                                        ?></strong><br />
                                    Shot to hot goal: <strong><?php echo $match['auto_hot_goal'] === "1" ? 'Yes' : 'No'; ?></strong><br />
                                    Moved to alliance zone: <strong><?php echo $match['auto_moved_to_alliance_zone'] === "1" ? 'Yes' : 'No'; ?></strong>
                                </div>
                                <hr class="comment-divider-hr" />
                                <span class="comment-commenter"><strong>Teleoperated</strong></span><br />
                                Points scored: <strong><?php echo $match['tele_total_points']; ?></strong><br />
                                High goal accuracy: 
                                <?php if ($match['tele_total_shots'] !== "0") { ?><strong><?php echo $match['tele_accuracy']; ?>%</strong>
                                <?php } else { ?><em>(no shots attempted)</em><?php } ?>
                                <div id="moreTeleData<?php echo $listNum; ?>" style="display:none;">
                                    <div style="display:table; width:100%">
                                        <div style="display:table-cell; width:50%;">
                                            Throws over truss: <strong><?php echo $match['tele_truss_throws']; ?></strong><br />
                                            Catches from truss: <strong><?php echo $match['tele_truss_catches']; ?></strong><br />
                                            Balls received: <strong><?php echo $match['tele_received_assists']; ?></strong><br />
                                            Balls passed: <strong><?php echo $match['tele_passed_assists']; ?></strong>
                                        </div><div style="display:table-cell; width: 50%;">
                                            <span class='comment-commenter'><strong>Goals</strong></span><br />
                                            High goals scored: <strong><?php echo $match['tele_high_goals']; ?></strong><br />
                                            Low goals scored: <strong><?php echo $match['tele_low_goals']; ?></strong><br />
                                            Goals missed: <strong><?php echo $match['tele_missed_goals']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <em>Team was absent for this match.</em>
                            <?php } ?>

                            <?php if (!empty($match['misc_comments'])) { ?>
                                <hr class="comment-divider-hr" />
                                <?php echo $match['misc_comments']; ?><br />
                                <?php if ($match['caused_fouls'] === "1") { ?>
                                    <strong>Caused fouls: </strong><?php echo $match['foul_comments']; ?><br />
                                <?php } ?>
                            <?php } ?>
                            <script type="text/javascript">
                                $("#expander<?php echo $listNum; ?>").click(function() {
                                    $("#moreAutoData<?php echo $listNum; ?>").slideToggle(200);
                                    $("#moreTeleData<?php echo $listNum; ?>").slideToggle(200);
                                    $("#moreGeneralData<?php echo $listNum; ?>").slideToggle(200);
                                    if ($("#expander<?php echo $listNum; ?>").text() === "more") {
                                        $("#expander<?php echo $listNum; ?>").text("less");
                                    } else {
                                        $("#expander<?php echo $listNum; ?>").text("more");
                                    }
                                    return false;
                                });
                            </script>
                            <?php $listNum++; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>