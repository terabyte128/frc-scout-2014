<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];
require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/constants.php';
require_once $docRoot . '/includes/db-connect.php';

$otherTeamNumber = $_GET['team'];
$queryString = "SELECT *, "
        . "(15*auto_high_goals + 6*auto_low_goals + 5*auto_hot_goals + 5*auto_moved_to_alliance_zone) AS `auto_total_points`, "
        . "(tele_low_goals + 10*tele_high_goals + 10*tele_truss_throws + 10*tele_truss_catches + 10*tele_received_assists) AS `tele_total_points`, "
        . "format((tele_high_goals / (tele_high_goals + tele_missed_goals)) * 100, 1) AS tele_accuracy, "
        . "(tele_high_goals + tele_missed_goals) AS tele_total_shots, "
        . "(SELECT (15*auto_high_goals + 6*auto_low_goals + 5*auto_hot_goals + 5*auto_moved_to_alliance_zone + "
        . "tele_low_goals + 10*tele_high_goals + 10*tele_truss_throws + 10*tele_truss_catches + "
        . "10*tele_received_assists)) AS total_points, "
        . "(SELECT format((total_points / total_match_points) * 100, 0)) AS proportion, "
        . "died_during_match "
        . "FROM frc_match_data WHERE scouted_team=? "
        . "ORDER BY timestamp, match_number";
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
        <title>Matches for Team <?= $otherTeamNumber ?></title>
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
                <button class="btn btn-default" onclick="window.location = '/team/<?= $otherTeamNumber ?>'" style="margin-bottom: 10px;">Back to Profile</button>
                <br />
                <a href="#" onclick="expandAll();
                        return false;" id="expandLink">Expand all matches</a>
                <br /><br />
                <?php while ($match = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                    <?php
                    if ($match['scouting_team'] === $teamNumber && $isAdmin) {
                        $canDeleteData = true;
                    } else {
                        $canDeleteData = false;
                    }
                    ?>
                    <div class="comment-wrapper" id="section<?= $listNum ?>">
                        <div class="comment-timestamp">
                            <?= $match['location'] ?>, <?= $match['timestamp'] ?>, match <?= $match['match_number'] ?>
                            <?php if ($match['team_absent'] !== "1") { ?>
                                (<a id="expander<?= $listNum ?>" href="#">more</a>)
                            <?php } ?>
                        </div>
                        <div class="comment-commenter">
                            <?php if ($teamNumber !== $match['scouting_team'] || $match['scout_name'] === "") { ?>
                                Scouted by <a href="/team/<?= $match['scouting_team'] ?>">team <?= $match['scouting_team'] ?></a>
                            <?php } else { ?>
                                Scouted by <strong><?= $match['scout_name'] ?></strong> (<a href="/team/<?= $match['scouting_team'] ?>">team <?= $match['scouting_team'] ?></a>)
                            <?php } ?>
                        </div>
                        <div class="comment-text">
                            <hr class="comment-divider-hr" />
                            <?php if ($match['team_absent'] !== "1") { ?>
                                <span class="comment-commenter"><strong>General</strong></span><br />
                                Total potential score: <strong><?= $match['total_points'] ?></strong> (<strong><?= $match['proportion']; ?>%</strong> of actual alliance score)<br />
                                Match outcome: <strong><?php if ($match['match_outcome'] === "0") { ?>
                                        <span style="color: #468847;">Win</span>
                                    <?php } else if ($match['match_outcome'] === "1") { ?>
                                        <span style="color: #a9302a;">Lose</span>
                                    <?php } else if ($match['match_outcome'] === "2") { ?>
                                        <span style="color: #d0a305;">Tie</span>
                                    <?php } ?></strong>
                                <div id="moreGeneralData<?= $listNum ?>" style="display:none;">
                                    Alliance color: <strong><?php if ($match['alliance_color'] === "1") { ?>
                                            <span style="color: #0044cc;">Blue</span>
                                        <?php } else { ?>
                                            <span style="color: #a9302a;">Red</span>
                                        <?php } ?></strong><br />
                                    Alliance total score: <strong><?= $match['total_match_points']; ?></strong>
                                </div>
                                <hr class="comment-divider-hr" />
                                <span class="comment-commenter"><strong>Autonomous</strong></span><br />
                                Potential score: <strong><?= $match['auto_total_points'] ?></strong>
                                <div id="moreAutoData<?= $listNum ?>" style="display:none;">
                                    <?php if ($match['auto_low_goals'] + $match['auto_high_goals'] + $match['auto_missed_goals'] <= 1) { ?>
                                        Goal scored: <strong><?php
                                            if ($match['auto_missed_goals'] === "1") {
                                                echo '<span style="color: #a9302a;">Missed</span>';
                                            } else if ($match['auto_low_goals'] === "1") {
                                                echo 'Low';
                                            } else if ($match['auto_high_goals'] === "1") {
                                                echo 'High';
                                            } else {
                                                echo "Didn't shoot";
                                            }
                                            ?></strong><br />
                                        Shot to hot goal: <strong><?php echo $match['auto_hot_goals'] === "1" ? 'Yes' : 'No'; ?></strong><br />
                                    <?php } else { ?>
                                        <strong>Multiple goals scored</strong><br />
                                        Accuracy: <strong><?= ($match['auto_high_goals'] + $match['auto_low_goals']) /
                                        ($match['auto_high_goals'] + $match['auto_low_goals'] + $match['auto_missed_goals']) * 100 ?>%</strong><br />
                                        High goals scored: <strong><?= $match['auto_high_goals'] ?></strong><br />
                                        Low goals scored: <strong><?= $match['auto_low_goals'] ?></strong><br />
                                        Hot goals: <strong><?= $match['auto_hot_goals'] ?></strong><br />
                                        Goals missed: <strong><?= $match['auto_missed_goals'] ?></strong><br />
                                    <?php } ?>
                                    Moved to <?php if($match['alliance_color'] === "1") { ?>blue<?php } else { ?>red<?php } ?> zone: <strong><?php echo $match['auto_moved_to_alliance_zone'] === "1" ? 'Yes' : 'No'; ?></strong>
                                </div>
                                <hr class="comment-divider-hr" />
                                <span class="comment-commenter"><strong>Teleoperated</strong></span><br />
                                Potential score: <strong><?= $match['tele_total_points'] ?></strong><br />
                                High goal accuracy:
                                <?php if ($match['tele_total_shots'] !== "0") { ?><strong><?= $match['tele_accuracy'] ?>%</strong>
                                <?php } else { ?><em>(no shots attempted)</em><?php } ?>
                                <div id="moreTeleData<?= $listNum ?>" style="display:none;">
                                    <div style="display:table; width:100%">
                                        <div style="display:table-cell; width:50%;">
                                            Throws over truss: <strong><?= $match['tele_truss_throws'] ?></strong><br />
                                            Catches from truss: <strong><?= $match['tele_truss_catches'] ?></strong><br />
                                            Balls received: <strong><?= $match['tele_received_assists'] ?></strong><br />
                                            Balls passed: <strong><?= $match['tele_passed_assists'] ?></strong>
                                        </div><div style="display:table-cell; width: 50%;">
                                            <span class='comment-commenter'><strong>Goals</strong></span><br />
                                            High goals scored: <strong><?= $match['tele_high_goals'] ?></strong><br />
                                            Low goals scored: <strong><?= $match['tele_low_goals'] ?></strong><br />
                                            Goals missed: <strong><?= $match['tele_missed_goals'] ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <em>Team was absent for this match.</em>
                            <?php } ?>

                            <?php if (!empty($match['misc_comments'])) { ?>
                                <hr class="comment-divider-hr" />
                                <div<?php if ($canDeleteData && $match['caused_fouls'] !== "1" && $match['died_during_match'] !== "1") { ?> style="float:left;"<?php } ?>>
                                    <?= nl2br($match['misc_comments'], true) ?><br />
                                </div>
                            <?php } ?>

                            <?php if ($match['caused_fouls'] === "1") { ?>
                                <div<?php if ($canDeleteData && $match['died_during_match'] !== "1") { ?> style="float:left;"<?php } ?>>
                                    <strong>Caused fouls<?php if ($match['foul_comments'] === "") { ?>.<?php } else { ?>:
                                        <?php } ?> </strong><?= nl2br($match['foul_comments'], true) ?><br />
                                </div>
                            <?php } ?>

                            <?php if ($match['died_during_match'] === "1") { ?>
                                <div<?php if ($canDeleteData) { ?> style="float:left;"<?php } ?>>
                                    <em>Died during match.</em><br />
                                </div>
                            <?php } ?>

                            <?php if ($canDeleteData) { ?>
                                <div class="comment-timestamp">(<a href="#" style="color: #a9302a;" onclick="deleteMatch<?= $listNum ?>()">delete</a>)</div><br />
                            <?php } ?>
                            <script type="text/javascript">
                                $("#expander<?= $listNum ?>").click(function() {
                                    $("#moreAutoData<?= $listNum ?>").slideToggle(200);
                                    $("#moreTeleData<?= $listNum ?>").slideToggle(200);
                                    $("#moreGeneralData<?= $listNum ?>").slideToggle(200);
                                    if ($("#expander<?= $listNum ?>").text() === "more") {
                                        $("#expander<?= $listNum ?>").text("less");
                                    } else {
                                        $("#expander<?= $listNum ?>").text("more");
                                    }
                                    return false;
                                });

    <?php if ($canDeleteData) { ?>
                                    deleteMatch<?= $listNum ?> = function() {
                                        $('#section<?= $listNum ?>').css('background-color', '#ffc7c7');
                                        if (confirm("Are you sure you want to delete this match data? This cannot be undone!")) {
                                            $.ajax({
                                                url: '/ajax-handlers/delete-data.php',
                                                type: 'POST',
                                                data: {
                                                    'idToDelete': <?= $match['uid'] ?>,
                                                    'type': 'match'
                                                },
                                                success: function(response, textStatus, jqXHR) {
                                                    if (response.indexOf("Successfully") !== -1) {
                                                        loadPageWithMessage("/team/<?= $otherTeamNumber ?>/matches/", "Match data deleted successfully.", "warning");
                                                    } else {
                                                        showMessage("Database error.", "danger");
                                                    }
                                                }
                                            });
                                        } else {
                                            $('#section<?= $listNum ?>').css('background-color', '#eee');
                                            return false;
                                        }
                                    };
    <?php } ?>
                            </script>
                            <?php $listNum++; ?>
                        </div>
                    </div>
                <?php } # end of while loop ?>
                <strong><?= $listNum ?> matches total</strong>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
            function expandAll() {
                if ($("#expandLink").text() === "Expand all matches") {
                    $("#expandLink").text("Shrink all matches");
<?php for ($i = 0; $i < $listNum; $i++) { ?>
                        $("#moreGeneralData<?= $i ?>").slideDown(200);
                        $("#moreAutoData<?= $i ?>").slideDown(200);
                        $("#moreTeleData<?= $i ?>").slideDown(200);
                        $("#expander<?= $i ?>").text("less");
<?php } ?>
                } else {
                    $("#expandLink").text("Expand all matches");
<?php for ($i = 0; $i < $listNum; $i++) { ?>
                        $("#moreGeneralData<?= $i ?>").slideUp(200);
                        $("#moreAutoData<?= $i ?>").slideUp(200);
                        $("#moreTeleData<?= $i ?>").slideUp(200);
                        $("#expander<?= $i ?>").text("more");
<?php } ?>
                }
            }
        </script>
    </body>
</html>
