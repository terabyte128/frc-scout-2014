<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'];

require_once $docRoot . '/includes/setup-session.php';
require_once $docRoot . '/includes/db-connect.php';

try {
    $query = $db->prepare('SELECT team_number, team_name, team_picture FROM `frc_team_accounts` ORDER BY team_number');
    $query->execute(array());
} catch (PDOException $e) {
    print_r($e->getMessage());
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Registered Teams</title>
        <?php include '../includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">

    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $docRoot . '/includes/messages.php'; ?>
                <h2>Registered Teams</h2>
                <button class="btn btn-default" onclick="window.location = '/'">Return Home</button>
                <div style="max-width: 500px; text-align: left; margin: 2px auto 2px auto">
                    <?php while ($results = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                        <a href="/team/<?php echo $results['team_number']; ?>">
                            <div style="display: inline-block; width: 50px; height: 50px; background-color:#333333;
                                 background: url('/uploads/<?php echo $results['team_picture']; ?>') center; 
                                 border-radius: 5px; vertical-align: middle; background-size: 100% auto;
                                 background-repeat: no-repeat; margin-right: 10px;"></div>
                            <div style="display:inline-block; font-size:12pt; vertical-align:middle;">
                                <?php
                                echo '<strong>Team ' . $results['team_number'] . '</strong>';
                                if (!empty($results['team_name'])) {
                                    echo '<br /><em>' . $results['team_name'] . '</em>';
                                }
                                ?>
                            </div></a><br /><br />
                    <?php } ?>
                </div>
                <?php include $docRoot . "/includes/footer.php"; ?>
            </div>
        </div>
    </body>
</html>