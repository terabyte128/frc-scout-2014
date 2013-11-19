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
                    <h3 class="text-center">Driver Controlled: 7462</h3>
                    <h4 class="text-center">Record points for each goal</h4>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Outer Pendulum<br>+3</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Inner Pendulum<br>+2</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <div class="btn-group">
                        <button class="btn buttonGroupLeft btn-primary">Floor Goal<br>+1</button>
                        <button class="btn buttonGroupRight btn-warning">-</button>
                    </div>
                    <p class="totalSize">0</p>
                    <p class="textToButton">Total Points:</p>
                    <p class="totalSize">0</p>
                    <p></p>
                    <div class="btn-group">
                        <button type="button" class="btn buttonGroupFull btn-primary">Can Block</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">Can Push</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">Un-Pushable</button>
                    </div>
                    <p></p>
                    <div class="btn-group">
                        <button type="button" class="btn buttonGroupFull btn-primary">Slow</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">Average</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">Fast</button>
                    </div>
                    <p></p>
                    <p class="text-center">Carrying Capacity</p>
                    <div class="btn-group">
                        <button type="button" class="btn buttonGroupFull btn-primary">Less Blocks</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">4 Blocks</button>
                        <button type="button" class="btn buttonGroupFull btn-primary">More Blocks</button>
                    </div>
                    <p></p>
                    <p><button class="btn btn-large fullButton btn-success" type="button">Continue To End Game</button></p>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>