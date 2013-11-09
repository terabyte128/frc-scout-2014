<?php include 'includes/redirect-if-session-exists.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>FRC Scout: Login</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <img style='margin: 20px 2px 2px 2px; max-width: 300px' src="images/logo_earfuzz_hat.png" alt="header logo" />
                    <h2 style='margin-top: 2px;'>FRC Scout: Login</h2>
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
                            <label for="teamPassword">Password</label>
                            <input type="password" class="form-control" id="teamPassword" placeholder="Team Password" required>
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

                            $.ajax({
                                url: 'login.php',
                                type: "POST",
                                data: {
                                    'teamNumber': teamNumber,
                                    'scoutName': scoutName,
                                    'teamPassword': teamPassword
                                },
                                success: function(response, textStatus, jqXHR) {
                                    if (response !== "") {
                                        $("#loginButton").button('reset');
                                        $("#alertError").text(response);
                                        $("#inputError").addClass("alert-danger");
                                        $("#inputError").slideDown(250);
                                    } else {
                                        location.reload();
                                    }
                                }
                            });
                        }
        </script>
    </body>
</html>
