<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

$params = array($_POST['teamNumber']);

$query = 'SELECT `timestamp`, `match_number`, `misc_comments`, `location` FROM `frc_match_data` WHERE `scouted_team`=?';

try {
    $response = $db->prepare($query);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}

while($row = $response->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>';
    echo $row['location'] . ', ' . $row['timestamp'];
    echo '</td>';
        echo '<td>';
    echo $row['match_number'];
    echo '</td>';
        echo '<td>';
    echo $row['misc_comments'];
    echo '</td>';
    echo '</tr>';
}
?>
