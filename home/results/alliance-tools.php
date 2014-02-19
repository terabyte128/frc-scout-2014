<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Alliance Tools</title>
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
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Alliance Tools</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <br /><br />
                <div style="margin:auto;"><strong>Tools to help you find that perfect elimination-round alliance.</strong></div>
                <br />
                <button class="btn btn-info btn-lg btn-home-selections" onclick="window.location='/alliances/builder/';">Alliance Builder</button><br />
                <div style="width:250px; margin:auto;">Sort teams based on data acquired through pit scouting.</div><br />
                <button class="btn btn-info btn-lg btn-home-selections" onclick="window.location='/alliances/compare/';">Compare Alliances</button><br />
                <div style="width:250px; margin:auto;">Calculate statistics to compare two alliances of three teams each.</div><br />
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
                    
        </script>
    </body>
</html>
