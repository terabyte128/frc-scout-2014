<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$redAlliance = $_POST['redAlliance'];
$blueAlliance = $_POST['blueAlliance'];
$onlyHere = $_POST['onlyHere'];

$redAllianceResults = array();
$blueAllianceResults = array();

$queryString = ('SELECT scouted_team, '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5)), 1) AS auto_points, '
        . 'format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) '
        . '+ (tele_truss_catches * 10)), 1) AS tele_points, '
        . 'format(AVG(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + '
        . '(tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)), 1) AS total_points '
        #  . 'STDDEV POP(auto_goal_value + (auto_hot_goal * 5) + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + '
        #  . '(tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)) AS total_points_stdev '
        . 'FROM `frc_match_data` WHERE `scouted_team`=?');


if ($onlyHere === "true") {
    $queryString .= ' AND location=?';
}

# print out the alliances and also grab their data in one fell swoop
# red
echo '<strong>Alliances:</strong><br /><div style="vertical-align:middle; display:table; margin: auto;"><div style="display:table-row">'
 . '<div style="display:table-cell; width:100px; text-align:right;" class="red"><strong>';
foreach ($redAlliance as $value) {
    echo '<a href="/team/' . $value . '" class="red">' . $value . '</a><br />';
    $params = array($value);
    if($onlyHere === "true") {
        array_push($params, $location);
    }
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
echo '</strong></div>';
# vs
echo '<div style="display:table-cell; width:50px; text-align:center; vertical-align:middle;"><strong>VS</strong></div>';
# blue
echo '<div style="display:table-cell; width:100px; text-align:left;" class="blue"><strong>';
foreach ($blueAlliance as $value) {
    echo '<a href="/team/' . $value . '" class="blue">' . $value . '</a><br />';
    $params = array($value);
    if($onlyHere === "true") {
        array_push($params, $location);
    }
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
echo '</strong></div></div></div>';

# calculate total scores
$redTotal = 0;
foreach ($redAllianceResults as $value) {
    $redTotal += $value['total_points'];
}
$blueTotal = 0;
foreach ($blueAllianceResults as $value) {
    $blueTotal += $value['total_points'];
}

# print out the scores
echo '<div style="padding:0px;"><br /><strong>Projected Score:</strong></div>';
echo '<div style="display:inline-block; padding: 0px 10px 10px 10px; font-size:20pt;">';
echo '<span class="red"><strong><em>'
 . $redTotal . '</em></strong></span> &mdash; ';
echo '<span class="blue" font-size:20pt;"><strong><em>'
 . $blueTotal . '</em></strong></span></div><br />';

# print out the winner
echo '<div style="font-size:16pt;">';
if ($blueTotal < $redTotal) {
    echo 'Winner: <span class="red"><strong><em>Red Alliance</em></strong></span>';
} else if ($redTotal < $blueTotal) {
    echo 'Winner: <span class="blue"><strong><em>Blue Alliance</em></strong></span>';
} else {
    echo 'Tie';
}
echo '</div>';

# view score breakdown
echo '<br /><a href="#" onclick="$(\'#breakdown\').slideToggle(200);"><strong>View score breakdown</strong></a>';

# score breakdown
echo '<div style="display:none;" id="breakdown">';
# red alliance div
echo '<div style="display:inline-block; padding: 10px;">';
echo '<span style="color: #d2322d; font-size:20pt;"><strong><em>Red Alliance</em></strong></span><br />';
echo '<table class="table table-striped table-bordered table-hover"><thead><th></th>';
# team names
foreach ($redAllianceResults as $value) {
    echo '<th><span style="color: #d2322d;"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
# auto points
echo '</thead><tbody><tr><td style="text-align: right;">Auto Points</td>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['auto_points'] . '</td>';
}
# tele points
echo '<tr><td style="text-align: right;">Tele Points</td>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['tele_points'] . '</td>';
}
# total points
echo '<tr><td style="text-align: right;"><strong>Total Points</strong></td>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . $value['total_points'] . '</td>';
}
echo '</tbody></table></div>';

# blue alliance div
echo '<div style="display:inline-block; padding: 10px;"><span style="color: rgb(0, 82, 255); font-size:20pt;"><strong><em>Blue Alliance</em></strong></span><br />';
echo '<table class="table table-striped table-bordered table-hover"><thead><th></th>';
# team names
foreach ($blueAllianceResults as $value) {
    echo '<th><span style="color: rgb(0, 82, 255);"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
# auto points
echo '</thead><tbody><tr><td style="text-align: right;">Auto Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['auto_points'] . '</td>';
}
# tele points
echo '<tr><td style="text-align: right;">Tele Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['tele_points'] . '</td>';
}
# total points
echo '<tr><td style="text-align: right;"><strong>Total Points</strong></td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . $value['total_points'] . '</td>';
}
echo '</tbody></table></div>';
# end score breakdown
echo '</div>';
?>