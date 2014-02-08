<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$params = array();

array_push($params, intval($_POST['teamNumber']));

/* $query = "SELECT
  `scouted_team`,
  format(AVG((`auto_ir_beacon_goal` * 40) + (`auto_pendulum_goal` * 20) + (`auto_floor_goal` * 10)),1) AS `avg_auto_block_score`,
  format(AVG((`tele_outer_pendulum` * 3) + (`tele_inner_pendulum` * 2) + (`tele_floor_goal` * 1)),1) AS `avg_tele_block_score`,
  format(AVG(`end_balanced`* 100),1) AS `avg_end_balanced`,
  format(AVG(`end_flag_score`),1) AS `avg_end_flag_score`,
  format(AVG(`end_hang_score`),1) AS `avg_end_hang_score` */
$query = 'SELECT '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5)),0) AS auto_points, '
        . 'format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)),0) AS tele_points, '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5) + '
        . '(tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)), 0) AS total_points, '
        . 'tele_received_assists, `match_number` '
        . 'FROM `frc_match_data` WHERE `scouted_team` = ? GROUP BY `match_number`';


/* if ($_GET['teamNumber']) {
  $query .= " AND `scouted_team`=?";
  } else {
  $query .= ' GROUP BY `scouted_team`';
  } */

$query .= " ORDER BY `match_number`";

try {
    $response = $db->prepare($query);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

//while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
//}
//echo '<table>';
while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>';
    echo $row['match_number'];
    echo '</td>';
    echo '<td>';
    echo $row['total_points'];
    echo '</td>';
    echo '<td>';
    echo $row['auto_points'];
    echo '</td>';
    echo '<td>';
    echo $row['tele_points'];
    echo '</td>';
    echo '<td>';
    echo $row['tele_received_assists'];
    echo '</td>';
    /* echo '<td>';
      echo $row['avg_end_hang_score'];
      echo '</td>'; */
    echo '</tr>';
}
//echo '</table>';
?>
