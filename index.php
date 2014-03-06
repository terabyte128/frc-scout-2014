<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/redirect-if-session-exists.php'; ?>
<?php include 'pwd-include.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>FRC Scout: Login</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <div class="title">
                    <img style='margin: 20px auto 2px auto; max-width: 275px' src="images/logo_earfuzz_hat.png" alt="header logo" id="main-title-image" />
                    <h2 style='margin-top: 2px;'>FRC Scout: Login</h2>
                </div>
                <div class='login-form align-center' style='max-width: 320px;'>
                    <form role="form" onsubmit="login();
                            return false;">
                        <div class="form-group">
                            <label for="teamNumber">Team Number</label>
                            <input type="number" class="form-control" id="teamNumber" placeholder="Team Number" required>
                        </div>
                        <div class="form-group">
                            <label for="scoutName">Your Name</label>
                            <input type="text" class="form-control" id="scoutName" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="teamPassword">Team Password</label>
                            <input type="password" class="form-control" id="teamPassword" placeholder="Team Password" required>
                        </div>       
                        <!--
                        <div class="form-group">
                            <label for="teamType">Team Type</label>
                            <select class="form-control" id="teamType">
                                <option selected id="frc">FRC (big robots)</option>
                                <option id="ftc">FTC (small robots)</option>                           
                            </select>
                        </div>
                        -->
                        <div class="form-group">
                            <label for="location">Location</label><br />
                            <input type="text" id="location" placeholder="Location" class="form-control" required style="width: 100%;">
                        </div>
                        <!--[if lt IE 10]>
                        <div id="warningAlreadyScouted" style="background: #ffff99; padding: 5px; padding-right:0; border-radius: 5px; position: relative;">
        <div style="display: inline-block; max-width: 10%; height: 100%; position: absolute; top: 0; left: -5px; bottom: 0; right: 0; margin-top: auto; margin-bottom: auto;">
            <span class="glyphicon glyphicon-exclamation-sign" style="position: absolute; top: 43%; left: 20px;"></span>
        </div>
        <div style="display: inline-block; max-width: 90%; padding-left: 15px;">This website is not guaranteed to look or work 100% correctly in your browser.<br />
                        Consider <a href='http://windows.microsoft.com/en-US/internet-explorer/download-ie'>updating Internet Explorer</a>, or 
                        <a href='http://chrome.google.com'>downloading</a> a <a href='http://www.mozilla.org/en-US/'>different browser</a>.</div>
    </div><br />
                        <![endif]-->
                        <button type="submit" id="loginButton" class="btn btn-default btn-success">Login</button>
                    </form> 
                    <br />
                    
                    <p>So far, <?php include $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/get-registered-teams.php'; ?> teams have registered on FRC Scout!</p>
                    
                    <p>
                        <em>
                            <strong>

                                <?php
                                if (strpos($_SERVER['HTTP_HOST'], "dev") !== FALSE) {
                                    echo '<span style="color:firebrick;"><span class="glyphicon glyphicon-exclamation-sign"></span> Warning: this site is under active development and may not work as expected. ';
                                    echo '<a href="http://frcscout.com">Click here</a> to go to the release site.</span>';
                                    echo "<br><br><span style='color:firebrick;'>development </span>";
                                };
                                ?>
                                v1.1.6
                            </strong>
                        </em>
                    </p>
                    
                    <a href="create-account.php">Create an account</a>
                    <br />
                    <a href="/recover">Recover your password</a>
                    <br /><br />
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var locationsFromJSON;

            function login() {
                $("#loginButton").button('loading');
                var teamNumber = $("#teamNumber").val();
                var scoutName = $("#scoutName").val();
                var teamPassword = $("#teamPassword").val();
                var teamType = "frc";
                var currentLocation = $("#location").val();

                if ($.inArray(currentLocation, locationsFromJSON) === -1) {
                    showMessage("Invalid location, please enter a different one.", "danger");
                    $("#loginButton").button('reset');
                    return;
                }


                $.ajax({
                    url: 'ajax-handlers/login-ajax-submit.php',
                    type: "POST",
                    data: {
                        'teamNumber': teamNumber,
                        'scoutName': scoutName,
                        'teamPassword': CryptoJS.MD5(teamPassword).toString(),
                        'teamType': teamType,
                        'location': currentLocation
                    },
                    success: function(response, textStatus, jqXHR) {
                        console.log(response);
                        if (response === "") {
                            if (localStorage.redirect && localStorage.redirect !== "undefined") {
                                var redirect = localStorage.redirect;
                                localStorage.redirect = undefined;
                                window.location = redirect;
                            } else {
                                location.reload();
                            }
                        } else {
                            showMessage(response, 'danger');
                            $("#loginButton").button('reset');
                        }
                    }
                });
            }

            $(function() {
                $.getJSON('includes/locations.json', function(data) {
                    locationsFromJSON = data;
                    $("#location").typeahead({
                        name: 'locations',
                        local: data
                    });

                });
            });
        </script>
    </body>
</html>
