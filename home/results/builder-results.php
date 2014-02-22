<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];
require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';

$queryString = "SELECT * FROM frc_pit_scouting_data WHERE 1 ";

$params = array();

if (!empty($_POST['canExtend'])) {
    array_push($params, "1");
    $queryString .= 'AND can_extend=? ';
}

if (!empty($_POST['isSwerve'])) {
    array_push($params, "1");
    $queryString .= 'AND is_swerve=? ';
}

if (!empty($_POST['canPass'])) {
    array_push($params, "1");
    $queryString .= 'AND can_pass=? ';
}

if (!empty($_POST['canCollect'])) {
    array_push($params, "1");
    $queryString .= 'AND can_collect=? ';
}

if (!empty($_POST['canThrow'])) {
    array_push($params, "1");
    $queryString .= 'AND can_throw=? ';
}

if (!empty($_POST['canCatch'])) {
    array_push($params, "1");
    $queryString .= 'AND can_catch=? ';
}

if (!empty($_POST['canBlock'])) {
    array_push($params, "1");
    $queryString .= 'AND can_block=? ';
}

if (!empty($_POST['wheelNum'])) {
    array_push($params, $_POST['wheelNum']);
    $queryString .= 'AND wheel_num=? ';
}

if (!empty($_POST['wheelType'])) {
    array_push($params, $_POST['wheelType']);
    $queryString .= 'AND wheel_type=? ';
}

if (!empty($_POST['shooterType'])) {
    array_push($params, $_POST['shooterType']);
    $queryString .= 'AND shooter_type=? ';
}

if (!empty($_POST['role'])) {
    array_push($params, $_POST['role']);
    $queryString .= 'AND role=? ';
}

if (!empty($_POST['startPosition'])) {
    array_push($params, $_POST['startPosition']);
    $queryString .= 'AND start_position=? ';
}

if (!empty($_POST['minHeight'])) {
    array_push($params, $_POST['minHeight']);
    $queryString .= 'AND robot_height>? ';
}

if (!empty($_POST['maxHeight'])) {
    array_push($params, $_POST['maxHeight']);
    $queryString .= 'AND robot_height<? ';
}

if (!empty($_POST['minWeight'])) {
    array_push($params, $_POST['minWeight']);
    $queryString .= 'AND robot_weight>? ';
}

if (!empty($_POST['maxWeight'])) {
    array_push($params, $_POST['maxWeight']);
    $queryString .= 'AND robot_weight<? ';
}

if (!empty($_POST['here'])) {
    array_push($params, $location);
    $queryString .= 'AND location=? ';
}

if (!empty($_POST['scoutedBy'])) {
    array_push($params, $teamNumber);
    $queryString .= 'AND scouting_team=? ';
}

if (!empty($_POST['noteam'])) {
    $queryString .= 'AND scouting_team!=scouted_team ';
}

$queryString .= 'GROUP BY scouted_team';

try {
    $response = $db->prepare($queryString);
    $response->execute($params);
} catch (PDOException $e) {
    echo 'something went wrong: ' . $e->getMessage();
}
$listNum = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Page Title</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Search Results</h2>
                <button class="btn btn-default" onclick="window.location = '/alliances/builder'" style="margin-bottom: 10px;">Search Again</button>
                <br />
                <div style='max-width: 500px; text-align: left; margin: auto;'>
                    <?php
                    while ($results = $response->fetch(PDO::FETCH_ASSOC)) {
                        // now get the team data
                        try {
                            $query = $db->prepare('SELECT team_number, team_name, team_picture FROM `frc_team_accounts` WHERE team_number=?');
                            $query->execute(array($results['scouted_team']));
                            $info = $query->fetch(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            print_r($e->getMessage());
                        }
                        ?>
                        <a href="/team/<?= $results['scouted_team']; ?>">
                            <div style="display: inline-block; width: 50px; height: 50px;
                                 background: <?php if (!empty($info['team_picture'])) { ?>
                                     url('/uploads/<?php echo $info['team_picture']; ?>')
                                 <?php } ?>
                                 #aaa center; 
                                 border-radius: 5px; vertical-align: middle;
                                 <?php if($info['team_picture'] !== 'default_profile_photo.png') { ?>
                                     background-size: auto 100%;
                                 <?php } else { ?>
                                     background-size: 100% auto;
                                 <?php } ?>
                                 background-repeat: no-repeat; margin-right: 10px;"></div>
                            <div style="display:inline-block; font-size:12pt; vertical-align:middle;">
                                <?php
                                echo '<strong>Team ' . $results['scouted_team'] . '</strong>';
                                if (!empty($info['team_name'])) {
                                    echo '<br /><em>' . $info['team_name'] . '</em>';
                                } else if (empty($info['team_picture'])) {
                                    // this is a good indicator of whether or not they are registered
                                    echo '<span style="font-size: 8pt;"><br /><em>Not registered</em></span>';
                                }
                                ?>
                            </div></a><br /><br />
                        <?php $listNum++; ?>
                    <?php } ?>
                    <div style='text-align: center;'><strong>
                            <?php if ($listNum > 0) { ?>
                                (<?= $listNum ?> results total)
                            <?php } else { ?>
                                No results found. :(
                            <?php } ?>
                        </strong></div>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">

        </script>
    </body>
</html>
