<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

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
        // NOTE ON THINGS I'M NOT SURE ABOUT:
        // IS IT OKAY TO SHOW SCOUTS' NAMES FROM TEAMS YOU'RE NOT LOGGED IN AS?
        // I'M GOING TO ERR ON THE SIDE OF "NO" FOR SAFETY, BUT I AM NOT SURE.
        // I WILL CONSULT WITH MORE PEOPLE LATER.
        if (empty($row['scout_name']) || $row['scouting_team'] !== $teamNumber) {
            echo '<a href="/team/' . $row['scouting_team'] . '">Team ' . $row['scouting_team'] . '</a>';
        } else {
            echo '<strong>' . $row['scout_name'] . '</strong> (<a href="/team/' . $row['scouting_team'] . '">team ' . $row['scouting_team'] . '</a>)';
        }
        echo ' said:</div>';

        echo '<div class="comment-text">';
        echo '<hr class="comment-divider-hr" />';

        echo $row['misc_comments'];
        echo '</div>';
        if ($row['team_absent'] === "1") {
            echo '<div style="border-radius:3px; margin-top:2px; padding:2px; background:#fdd; color:#a00; text-align:center; font-size:10pt;">(Team was absent for this match)</div>';
        }   
        echo '</div>';
    }
}
?>
