<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/load-frc-team-averages-as-variable.php';

$redAlliance = $_POST['redAlliance'];
$blueAlliance = $_POST['blueAlliance'];
$onlyHere = $_POST['onlyHere'];
$lastFive = $_POST['lastFive'];

$redAllianceResults = array();
$blueAllianceResults = array();


if ($onlyHere === "true") {
    $queryString .= ' AND location=?';
}

$queryString .= '  ORDER BY `uid` DESC';

# print out the alliances and also grab their data in one fell swoop
# red
echo '<strong>Alliances:</strong><br /><div style="vertical-align:middle; display:table; margin: auto;"><div style="display:table-row">'
 . '<div style="display:table-cell; width:100px; text-align:right;" class="red"><strong>';

$loop = 0;
foreach ($redAlliance as $value) {
    $loop++;
    if ($loop > 5 && $lastFive === "true") {
        break;
    }
    echo '<a href="/team/' . $value . '" class="red">' . $value . '</a><br />';
    if ($onlyHere === "true") {
        $query = Averages::getAverages($db, $value, false, $teamNumber, true, $location, false);
    } else {
        $query = Averages::getAverages($db, $value, false, $teamNumber, false, $location, false);
    }
    $row = $query->fetch(PDO::FETCH_ASSOC);
    array_push($redAllianceResults, $row);
}
echo '</strong></div>';
# vs
echo '<div style="display:table-cell; width:50px; text-align:center; vertical-align:middle;"><strong>VS</strong></div>';
# blue
echo '<div style="display:table-cell; width:100px; text-align:left;" class="blue"><strong>';

$loop = 0;
foreach ($blueAlliance as $value) {
    $loop++;
    if ($loop > 5 && $lastFive === "true") {
        break;
    }
    echo '<a href="/team/' . $value . '" class="blue">' . $value . '</a><br />';
    if ($onlyHere === "true") {
        $query = Averages::getAverages($db, $value, false, $teamNumber, true, $location, false);
    } else {
        $query = Averages::getAverages($db, $value, false, $teamNumber, false, $location, false);
    }
    $row = $query->fetch(PDO::FETCH_ASSOC);
    array_push($blueAllianceResults, $row);
}
echo '</strong></div></div></div>';

# calculate total scores
$redTotal = 0;
foreach ($redAllianceResults as $value) {
    $redTotal += $value['total_average'];
}
$blueTotal = 0;
foreach ($blueAllianceResults as $value) {
    $blueTotal += $value['total_average'];
}

# print out the scores
echo '<div style="padding:0px;"><br /><strong>Projected Score:</strong></div>';
echo '<div style="display:inline-block; padding: 0px 10px 10px 10px; font-size:20pt;">';
echo '<span class="red"><strong><em>'
 . number_format($redTotal, 1) . '</em></strong></span> &mdash; ';
echo '<span class="blue" font-size:20pt;"><strong><em>'
 . number_format($blueTotal, 1) . '</em></strong></span></div><br />';

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
#echo '<div style="display:inline-block; padding: 10px;">';
#echo '<span style="color: #d2322d; font-size:20pt;"><strong><em>Red Alliance</em></strong></span><br />';
echo '<table style="max-width: 500px; margin: auto;" class="table table-striped table-bordered table-hover tablesorter"><thead>';
# team names
foreach ($redAllianceResults as $value) {
    echo '<th style="text-align:right; max-width: 66px;"><span class="red"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
echo '<th style="width: 100px;"></th>';
foreach ($blueAllianceResults as $value) {
    echo '<th style="text-align:left; max-width: 66px;"><span class="blue"><strong>' . $value['scouted_team'] . '</strong></span></th>';
}
# auto points
echo '</thead><tbody><tr>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . number_format($value['auto_average'], 1) . '</td>';
}
echo '<td style="text-align: center;">Auto Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . number_format($value['auto_average'], 1) . '</td>';
}
echo '</tr>';
# tele points
echo '<tr>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . number_format($value['teleop_average'], 1) . '</td>';
}
echo '<td style="text-align: center;">Tele Points</td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . number_format($value['teleop_average'], 1) . '</td>';
}
echo '</tr>';
# total points
echo '<tr>';
foreach ($redAllianceResults as $value) {
    echo '<td>' . number_format($value['total_average'], 1) . '</td>';
}
echo '<td style="text-align: center;"><strong>Total Points</strong></td>';
foreach ($blueAllianceResults as $value) {
    echo '<td>' . number_format($value['total_average'], 1) . '</td>';
}
echo '</tr>';
echo '</tbody></table></div>';
?>