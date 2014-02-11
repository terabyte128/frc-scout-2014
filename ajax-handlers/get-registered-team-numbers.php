<?php

session_start();

if (!empty($_POST['query'])) {
    $queryExists = true;
    $query = $_POST['query'];
} else {
    $queryExists = false;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';


try {
    $params = array();
    $queryString = 'SELECT team_number, team_name, website FROM `frc_team_accounts` ';

    if ($queryExists) {
        $queryString .= "WHERE `team_number` LIKE ? OR `team_name` LIKE ? ";
        $params = array("%$query%", "%$query%");
    }


    $queryString .= "ORDER BY `team_number` asc";

    $query = $db->prepare($queryString);
    $query->execute($params);
} catch (PDOException $ex) {
    echo $queryString;
    die($ex->getMessage());
}

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>";
    echo "<a href=\"/team/" . $row['team_number'] . "\">";
    echo $row['team_number'];
    echo "</a>";
    echo '</td>';
    echo "<td>";
    echo $row['team_name'];
    echo '</td>';
    echo "<td>";
    echo "<a target=\"blank\" href=\"http://" . $row['website'] . "\">";
    echo $row['website'];
    echo "</a>";
    echo '</td>';
    echo '</tr>';
}
?>

