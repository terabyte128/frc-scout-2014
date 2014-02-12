<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$redAlliance = $_POST['redAlliance'];
$blueAlliance = $_POST['blueAlliance'];

$redAllianceResults = array();
$blueAllianceResults = array();

$queryString = ('SELECT scouted_team, '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5)), 1) AS auto_points, '
        . 'format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) '
        . '+ (tele_truss_catches * 10)), 1) AS tele_points, '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + '
        . '(tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)), 1) AS total_points '
        . 'FROM `frc_match_data` WHERE `scouted_team`=?');

foreach ($redAlliance as $value) {
    $params = array($value);
    try {
        $query = $db->prepare($queryString);
        $query->execute($params);
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }
    while ($results = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($redAllianceResults, $results);
    }
}

foreach ($blueAlliance as $value) {
    $params = array($value);
    try {
        $query = $db->prepare($queryString);
        $query->execute($params);
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }
    while ($results = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($blueAllianceResults, $results);
    }
}
echo '<div style="display:inline-block; padding: 10px;"><span style="color: #d2322d; font-size:20pt;"><strong><em>Red Alliance</em></strong></span><br />';
echo '<table class="table table-striped table-bordered table-hover"><thead><th></th>';
foreach ($redAllianceResults as $value) {
    echo '<th><span style="color: #d2322d;"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
echo '</thead><tbody><tr><td style="text-align: right;">Auto Points</td>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['auto_points'] . '</td>';
}
echo '<tr><td style="text-align: right;">Tele Points</td>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['tele_points'] . '</td>';
}
echo '<tr><td style="text-align: right;"><strong>Total Points</strong></td>';
$redTotal = 0;
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['total_points'] . '</td>';
    $redTotal += $value['total_points'];
}
echo '</tbody></table><span style="color: #d2322d; font-size:20pt;"><strong><em>'
. $redTotal . '</em></strong></span></div>';

echo '<div style="display:inline-block; padding: 10px;"><span style="color: rgb(0, 82, 255); font-size:20pt;"><strong><em>Blue Alliance</em></strong></span><br />';
echo '<table class="table table-striped table-bordered table-hover"><thead><th></th>';
foreach ($blueAllianceResults as $value) {
    echo '<th><span style="color: rgb(0, 82, 255);"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
echo '</thead><tbody><tr><td style="text-align: right;">Auto Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['auto_points'] . '</td>';
}
echo '<tr><td style="text-align: right;">Tele Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['tele_points'] . '</td>';
}
echo '<tr><td style="text-align: right;"><strong>Total Points</strong></td>';
$blueTotal = 0;
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['total_points'] . '</td>';
    $blueTotal += $value['total_points'];
}
echo '</tbody></table><span style="color: rgb(0, 82, 255); font-size:20pt;"><strong><em>'
. $blueTotal . '</em></strong></span></div>';
?>