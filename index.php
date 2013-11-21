<?php include 'includes/redirect-if-session-exists.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Login</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <img style='margin: 20px auto 2px auto; max-width: 275px' src="images/logo_earfuzz_hat.png" alt="header logo" id="main-title-image" />
                    <h2 style='margin-top: 2px;'>FIRST Scout: Login</h2>
                </div>
                <div class='login-form align-center' style='width: 250px;'>
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
                        <div class="form-group">
                            <label for="teamType">Team Type</label>
                            <select class="form-control" id="teamType">
                                <option selected id="frc">FRC (big robots)</option>
                                <option id="ftc">FTC (small robots)</option>                           
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label><br />
                            <input type="text" id="location" placeholder="Location" class="form-control" required style="width: 100%;">
                        </div>
                        <button type="submit" id="loginButton" class="btn btn-default btn-success">Login</button>
                    </form>
                    <br />
                    <a href="create-account.php">Create an account</a>
                    <br />
                    <a href="forgot-password.php">Recover your password</a>
                    <br /><br />
                </div>
            </div>
        </div>
        <script type="text/javascript">
                        function login() {
                            $("#loginButton").button('loading');
                            var teamNumber = $("#teamNumber").val();
                            var scoutName = $("#scoutName").val();
                            var teamPassword = $("#teamPassword").val();
                            var teamType = $('#teamType').find('option:selected').attr('id');
                            var location = $("#location").val();

                            var locationsFromJSON = $.getJSON('includes/locations.json');

                            if ($.inArray(locationsFromJSON.responseJSON, location) === -1) {
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
                                    'teamPassword': teamPassword,
                                    'teamType': teamType
                                },
                                success: function(response, textStatus, jqXHR) {
                                    if (response !== "") {
                                        showMessage(response, 'danger');
                                        $("#loginButton").button('reset');
                                    } else {
                                        location.reload();
                                    }
                                }
                            });
                        }

                        $(function() {

                            $("#location").typeahead({
                                name: 'locations',
                                prefetch: 'includes/locations.json',
                                limit: 10
                            });
                        });
        </script>
    </body>
</html>
