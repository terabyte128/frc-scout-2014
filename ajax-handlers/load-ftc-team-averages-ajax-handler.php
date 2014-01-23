<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$params = array();

if ($_GET['teamNumber']) {
    array_push($params, $_GET['teamNumber']);
}
$query = "SELECT
`scouted_team`,
format(AVG((`auto_ir_beacon_goal` * 40) + (`auto_pendulum_goal` * 20) + (`auto_floor_goal` * 10)),1) AS `avg_auto_block_score`,
format(AVG((`tele_outer_pendulum` * 3) + (`tele_inner_pendulum` * 2) + (`tele_floor_goal` * 1)),1) AS `avg_tele_block_score`,
format(AVG(`end_balanced`* 100),1) AS `avg_end_balanced`,
format(AVG(`end_flag_score`),1) AS `avg_end_flag_score`,
format(AVG(`end_hang_score`),1) AS `avg_end_hang_score`

FROM `ftc_scouting_data` WHERE `complete`=1";

if ($_GET['teamNumber']) {
    $query .= " AND `scouted_team`=?";
} else {
    $query .= ' GROUP BY `scouted_team`';
}

$query .= " ORDER BY `scouted_team`";

try {
    $response = $db->prepare($query);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

//while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
//}

echo '<table>';
while ($row = $response->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>';
    echo $row['scouted_team'];
    echo '</td>';
    echo '<td>';
    echo $row['avg_auto_block_score'];
    echo '</td>';
    echo '<td>';
    echo $row['avg_tele_block_score'];
    echo '</td>';
    echo '<td>';
    echo $row['avg_end_balanced'];
    echo '</td>';
    echo '<td>';
    echo $row['avg_end_flag_score'];
    echo '</td>';
    echo '<td>';
    echo $row['avg_end_hang_score'];
    echo '</td>';
    echo '</tr>';
}
echo '</table>';

?>