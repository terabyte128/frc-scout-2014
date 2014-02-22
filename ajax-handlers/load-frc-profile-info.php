<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

$thingToLoad = $_POST['thingToLoad'];

if ($thingToLoad === "comments") {
    $params = array($_POST['teamNumber']);

    $query = 'SELECT `team_absent`, `scout_name`, `scouting_team`, `timestamp`, `match_number`, `misc_comments`, `location` FROM `frc_match_data` WHERE `scouted_team`=?';

    try {
        $response = $db->prepare($query);
        $response->execute($params);
    } catch (PDOException $e) {
        echo 'something went wrong: ' . $e->getMessage();
    }

    while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['misc_comments'])) {
            echo '<div class="comment-wrapper">';

            echo '<div class="comment-timestamp">';
            echo $row['location'] . ', ' . $row['timestamp'] . ', match ' . $row['match_number'];
            echo '</div>';

            echo '<div class="comment-commenter">';
            if (empty($row['scout_name']) || $row['scouting_team'] !== $teamNumber) {
                echo '<a href="/team/' . $row['scouting_team'] . '">Team ' . $row['scouting_team'] . '</a>';
            } else {
                echo '<strong>' . $row['scout_name'] . '</strong> (<a href="/team/' . $row['scouting_team'] . '">team ' . $row['scouting_team'] . '</a>)';
            }
            echo ' said:</div>';

            echo '<div class="comment-text">';
            echo '<hr class="comment-divider-hr" />';

            echo nl2br($row['misc_comments'], true);
            echo '</div>';
            if ($row['team_absent'] === "1") {
                echo '<div style="text-align:left;"><strong><em>Team was absent for this match.</em></strong></div>';
            }
            echo '</div>';
        }
    }
}

if ($thingToLoad === "pit") {
    $params = array($_POST['teamNumber'], $teamNumber);

    $query = "SELECT * FROM frc_pit_scouting_data WHERE scouted_team = ? AND scouting_team = ? ORDER BY timestamp DESC, uid DESC LIMIT 1";

    try {
        $response = $db->prepare($query);
        $response->execute($params);
    } catch (PDOException $e) {
        echo 'something went wrong: ' . $e->getMessage();
    }

    $row = $response->fetch(PDO::FETCH_ASSOC);

    if (!empty($row)) {
        $finalRow = $row;
    } else {
        if ($teamNumber === $_POST['teamNumber']) {
            if ($isAdmin) {
            echo '<em>You can set up this section of your team profile to provide your own information about your team to other teams, through the '
            . '<a href="/home/scouting/pit/'. $teamNumber . '">Pit Scouting</a> page.</em>';
            } else {
                echo '<em>No one has pit scouted your team yet! Perhaps you\'d like to <a href="/home/scouting/pit/'. $teamNumber . '">do it yourself?</a></em>';
            }
        }
        $params2 = array($_POST['teamNumber'], $_POST['teamNumber']);
        try {
            $response = $db->prepare($query);
            $response->execute($params2);
        } catch (PDOException $e) {
            echo 'something went wrong: ' . $e->getMessage();
        }
    }

    if (empty($finalRow)) {
        $row = $response->fetch(PDO::FETCH_ASSOC);

        if (!empty($row)) {
            $finalRow = $row;
        } else {
            $query = "SELECT * FROM frc_pit_scouting_data WHERE scouted_team = ? ORDER BY timestamp DESC, uid DESC LIMIT 1";

            try {
                $response = $db->prepare($query);
                $response->execute(array($_POST['teamNumber']));
            } catch (PDOException $e) {
                echo 'something went wrong: ' . $e->getMessage();
            }

            $row = $response->fetch(PDO::FETCH_ASSOC);

            $finalRow = $row;
        }
    }

    if (empty($finalRow)) {
        if ($teamNumber !== $_POST['teamNumber']) {
            echo "<em>It doesn't look like anyone has pit scouted this team yet. <a href='/home/scouting/pit'>Be the first.</a>";
        }
    } else {
        echo '<div style="text-align: center;"><strong><a href="/team/' . $finalRow['scouted_team'] . '/robot">View all pit scouting data for this team'
        . '</a></strong>';
        if ($isAdmin) {
            echo "<br />As an administrator, use this page to manage ";
            if ($teamNumber === $finalRow['scouted_team']) {
                echo "team " . $finalRow['scouted_team'] . "'s pit scouting data for itself.";
            } else {
                echo "your team's pit scouting data for team " . $finalRow['scouted_team'] . ".";
            }
        }
        echo '</div><br />';
        printPSData($finalRow, false, 0, $teamNumber);
    }
}

if ($thingToLoad === "allpit") {
    $onlyHere = $_POST['onlyHere'] === "true" ? true : false;
    $onlyUs = $_POST['onlyUs'] === "true" ? true : false;

    $listNum = 0;

    $params = array($_POST['teamNumber']);

    $query = "SELECT * FROM frc_pit_scouting_data WHERE scouted_team = ?";

    if ($onlyHere) {
        $query .= " AND location = ?";
        array_push($params, $location);
    }

    if ($onlyUs) {
        $query .= " AND scouting_team = ?";
        array_push($params, $teamNumber);
    }

    $query .= " ORDER BY timestamp DESC, uid DESC";

    try {
        $response = $db->prepare($query);
        $response->execute($params);
    } catch (PDOException $e) {
        echo 'something went wrong: ' . $e->getMessage();
    }

    while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
        if ($row['scouting_team'] === $teamNumber && $isAdmin) {
            $canDeleteData = true;
        } else {
            $canDeleteData = false;
        }

        printPSData($row, $canDeleteData, $listNum, $teamNumber);

        $listNum++;
    }

    echo '<strong>Scouted ' . $listNum . ' times in total</strong>';
}

function printPSData($finalRow, $canDeleteData, $listNum, $teamNumber) {
    echo '<div class="comment-wrapper" id="section' . $listNum . '">';
    echo '<div class="comment-timestamp">' . $finalRow['location'] . ', ' . $finalRow['timestamp'] . '</div>';
    echo '<div class="comment-commenter">Collected by ';
    if ($finalRow ['scouting_team'] === $teamNumber) {
        echo '<strong>' . $finalRow['scout_name'] . '</strong> (<a href="/team/' . $finalRow['scouting_team'] . '">team '
        . $finalRow ['scouting_team'] . '</a>)';
    } else {
        echo '<a href="/team/' . $finalRow['scouting_team'] . '">team ' . $finalRow['scouting_team'] . '</a>';
    }
    echo '</div>';
    echo '<div class="comment-text">';
    echo '<em>';
    if ($finalRow['scouting_team'] === $finalRow['scouted_team']) {
        if ($finalRow['scouting_team'] === $teamNumber) {
            echo '<hr class="comment-divider-hr" />';
            echo 'This is public data that your team provides to other teams.<br />';
        } else {
            echo '<hr class="comment-divider-hr" />';
            echo 'This data is provided by <strong>team ' . $finalRow['scouting_team']
            . ' themselves</strong>.';
        }
    } else {
        if (!empty($finalRow ['info_provider'])) {
            // ehh screw you netbeans
            if ($finalRow ['scouting_team'] === $teamNumber) {
                echo '<hr class="comment-divider-hr" />';
                echo 'Information provided by <strong>' . $finalRow['info_provider'] . '</strong> on team ' . $finalRow['scouted_team'];
            } else if ($finalRow['scouted_team'] === $teamNumber) {
                echo '<hr class="comment-divider-hr" />';
                echo '<strong>' . $finalRow['info_provider'] . '</strong> on your team provided this info.';
            }
        }
    }
    echo '</em>';
    if (!empty($finalRow['team_coach'])) {
        echo '<hr class="comment-divider-hr" />';
        echo 'Team coach: <strong>' . $finalRow['team_coach'] . '</strong><br />';
    }
    if (!empty($finalRow['shooter_type']) || !empty($finalRow['robot_weight']) || !empty($finalRow['robot_weight']) || $finalRow['can_extend'] === "1" || !empty($finalRow['wheel_type']) || !empty($finalRow['wheel_num'])) {
        echo '<hr class="comment-divider-hr" /><div class="comment-commenter"><strong>Physical information</strong></div><br />';
    }
    if (!empty($finalRow['robot_weight'])) {
        echo 'Robot weight: <strong>' . $finalRow ['robot_weight'] . ' lbs.</strong><br />';
    }
    if (!empty($finalRow ['robot_weight'])) {
        echo 'Robot height: <strong>' . $finalRow['robot_height'] . ' in.</strong>';
        if ($finalRow['can_extend'] === "1") {
            echo ' &mdash; can extend<br />';
        } else {
            echo '<br />';
        }
    } else {
        if ($finalRow['can_extend'] === "1") {
            echo 'Can extend';
        }
    }
    if (!empty($finalRow['wheel_type'])) {
        echo 'Wheels: <strong>' . $finalRow['wheel_type'] . '</strong>';
        if (!empty($finalRow['wheel_num'])) {
            echo ' <strong>(x' . $finalRow['wheel_num'] . ')</strong>';
        }
        if ($finalRow['is_swerve'] === "1") {
            echo ' &mdash; has swerve drive';
        }
        echo '<br />';
    } else {
        if (!empty($finalRow['wheel_num'])) {
            echo 'Wheels: <strong>' . $finalRow ['wheel_num'] . '</strong>';
            if ($finalRow['is_swerve'] === "1") {
                echo ' &mdash; has swerve drive';
            }
            echo '<br />';
        } else {
            echo 'Has <strong>swerve drive</strong><br />';
        }
    }

    if (!empty($finalRow['shooter_type'])) {
        echo 'Shooter type: <strong>' . $finalRow ['shooter_type'] . '</strong><br />';
    }
    if (!empty($finalRow ['start_position']) || !empty($finalRow ['role']) || $finalRow['can_collect'] === "1" || $finalRow ['can_pass'] === "1" || $finalRow['can_throw'] === "1" || $finalRow['can_catch'] === "1" || $finalRow['can_high_goal'] === "1" || $finalRow['can_block'] === "1") {
        echo '<hr class="comment-divider-hr" />';
        echo '<div class="comment-commenter"><strong>Strategic information</strong></div><br />';
    }
    if (!empty($finalRow['start_position'])) {
        echo 'Autonomous start position: <strong>' . $finalRow ['start_position'] . '</strong><br />';
    }
    if (!empty($finalRow['role'])) {
        echo 'Robot role: <strong>' . $finalRow['role'] . '</strong><br />';
    }
    if ($finalRow['can_collect'] === "1") {
        echo 'Can <strong>collect ball</strong> from ground<br />';
    }
    if ($finalRow['can_pass'] === "1") {
        echo 'Can <strong>eject ball (pass)</strong><br />';
    }
    if ($finalRow['can_throw'] === "1") {
        echo 'Can <strong>throw ball</strong> over truss<br />';
    }
    if ($finalRow['can_catch'] === "1") {
        echo 'Can <strong>catch ball</strong> from truss<br />';
    }
    if ($finalRow['can_high_goal'] === "1") {
        echo 'Can <strong>shoot to high goal</strong><br />';
    }
    if ($finalRow['can_block'] === "1") {
        echo 'Can <strong>block shots</strong><br />';
    }
    if (!empty($finalRow['strength'])) {
        echo '<hr class="comment-divider-hr" />';
        echo '<div class="comment-commenter"><strong>Biggest strength:</strong></div><br />';
        if ($canDeleteData && empty($finalRow['comments']) && empty($finalRow['problems'])) {
            echo '<div style="float:left;">';
        }
        echo nl2br($finalRow['strength'], true);
        if ($canDeleteData && empty($finalRow['comments']) && empty($finalRow['problems'])) {
            echo '</div>';
        }
    }
    if (!empty($finalRow['problems'])) {
        echo '<hr class="comment-divider-hr" />';
        echo '<div class="comment-commenter"><strong>Known problems:</strong></div><br />';
        if ($canDeleteData && empty($finalRow['comments'])) {
            echo '<div style="float:left;">';
        }
        echo nl2br($finalRow['problems'], true);
        if ($canDeleteData && empty($finalRow['comments'])) {
            echo '</div>';
        }
    }
    if (!empty($finalRow['comments'])) {
        echo '<hr class="comment-divider-hr" />';
        echo '<div class="comment-commenter"><strong>Miscellaneous comments:</strong></div><br />';
        if ($canDeleteData) {
            echo '<div style="float:left;">';
        }
        echo nl2br($finalRow['comments'], true);
        if ($canDeleteData) {
            echo '</div>';
        }
    }

    if ($canDeleteData) {
        echo '<div class="comment-timestamp">(<a href="#" style="color: #a9302a;" onclick="deleteMatch' . $listNum . '()">delete</a>)</div><br />';
    }
    echo '<div style="clear:both;"></div></div></div>';

    if ($canDeleteData) {
        echo '<script type="text/javascript">
                deleteMatch' . $listNum . " = function() {
                    $('#section" . $listNum . "').css('background-color', '#ffc7c7');
                                        if (confirm('Are you sure you want to delete this scouting data? This cannot be undone!')) {
                                            $.ajax({
                                                url: '/ajax-handlers/delete-data.php',
                                                type: 'POST',
                                                data: {
                                                    'idToDelete':" . $finalRow['uid'] . ",
                                                    'type': 'pit'
                                                },
                                                success: function(response, textStatus, jqXHR) {
                                                    if (response.indexOf('Successfully') !== -1) {
                                                        loadPageWithMessage('/team/" . $finalRow['scouted_team'] . "/robot', 'Scouting data deleted successfully.', 'warning');
                                                    } else {
                                                        showMessage('Database error.', 'danger');
                                                    }
                                                }
                                            });
                                        } else {
                                            $('#section" . $listNum . "').css('background-color', '#eee');
                                            return false;
                                        }
                                    };
                                    
                                    </script>";
    }
}

?>
