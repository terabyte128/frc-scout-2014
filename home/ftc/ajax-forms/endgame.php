<?php require_once '../../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bootstrap 101 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="bootstrap.css" rel="stylesheet" media="screen">
        <link href="ftc.css" rel="stylesheet" media="screen">
        <?php include '../../includes/headers.php'; ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="span4 offset4">
                    <h3 class="text-center">End Game: 7462</h3>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Flag High<br>+35</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Flag Low<br>+20</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Robot Hang<br>+50</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <p></p>
                    <p>  <button class="btn btn-large fullButton btn-primary" type="button">Balanced Pendulum?</button>
                    </p>
                    <p></p>
                    <p><button class="btn btn-large fullButton btn-success" type="button">To Match Outcome</button></p>
                </div>
            </div>
    </body>
</html>