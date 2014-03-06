<?php

if ($_REQUEST['writeTable'] === "true") {
    $writeTable = true;
}

if ($_REQUEST['onlyLoggedInTeam'] === "true") {
    $onlyLoggedInTeam = true;
} else {
    $onlyLoggedInTeam = false;
}

if ($_REQUEST['onlyThisLocation'] === "true") {
    $onlyThisLocation = true;
} else {
    $onlyThisLocation = false;
}

if (isset($_REQUEST['scoutedTeam'])) {
    $scoutedTeamNumber = $_REQUEST['scoutedTeam'];
}

$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/ajax-handlers/load-frc-team-averages-as-variable.php';

$query = Averages::getAverages($scoutedTeamNumber, $onlyLoggedInTeam, $onlyThisLocation);

while ($averages = $query->fetch(PDO::FETCH_ASSOC)) {
//write the table in PHP instead of HTML
    echo "<tr>";
    echo "<td><a href=\"/team/" . $averages['scouted_team'] . "\">";
    echo $averages['scouted_team'];
    echo "</a></td>";
    echo "<td>";
    echo $averages['total_points'];
    echo "</td>";
    echo "<td>";
    echo $averages['auto_points'];
    echo "</td>";
    echo "<td>";
    echo $averages['tele_points'];
    echo "</td>";
    echo "</tr>";
}
?>