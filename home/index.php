<?php
require '../includes/setup-session.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php' ?>
        <title>FRC Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>FRC Scout: Home</h2>
                <p>You are logged in as <?php echo $scoutName ?> for team <?php echo $teamNumber ?> in <?php echo $location ?>.</p>
                <button onclick="window.location = 'change-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Team Password</button>
                <button onclick="window.location = 'change-admin-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Admin Password</button>
                <button onclick="window.location = '../login.php?logout';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>
                <br />

                <a href="#" id="optionAuthAsAdmin" onclick="$('#authAsAdmin').show(200);">Authenticate as administrator</a>
                <br />

                <div class='login-form align-center' id="authAsAdmin" onsubmit="loginAdmin();
                        return false;" style='width: 250px; display: none;'>
                    <form role="form">
                        <div class="form-group">
                            <label for="adminPassword">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" placeholder="Admin Password" required>
                        </div>                        
                        <button type="submit" id="authButton" class="btn btn-default btn-success">Authenticate</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>

        <script type="text/javascript">
                    function loginAdmin() {
                        $("#authButton").button('loading');
                        var adminPassword = $("#adminPassword").val();
                        $.ajax({
                            url: 'auth-as-admin.php',
                            type: "POST",
                            data: {
                                'adminPassword': adminPassword
                            },
                            success: function(response, textStatus, jqXHR) {
                                $("#authButton").button('reset');
                                $("#inputError").show();
                                $("#submitButton").button('reset');
                                $("#alertError").text(response);
                                if (response.indexOf("Successfully") !== -1) {
                                    $("#inputError").addClass("alert-success");
                                    $("#authAsAdmin").hide();
                                    $("#optionAuthAsAdmin").hide();
                                } else {
                                    $("#inputError").addClass("alert-danger");
                                }
                            }
                        });
                    }
        </script>    
    </body>
</html>
