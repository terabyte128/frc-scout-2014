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

                <button onclick="window.location = 'logout.php';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>

                <?php if ($isAdmin) { ?>
                    <br />
                    <font style="color: #868686; float: right; font-size: 10pt;">Admin Tools</font>
                    <hr style="border-top: 1px solid #868686">
                    <button onclick="window.location = 'change-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Team Password</button>
                    <button onclick="window.location = 'change-admin-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Admin Password</button>
                    <br />

                <?php } ?>


                <?php if (!$isAdmin) { ?>
                    <p><a href="#" id="optionAuthAsAdmin" onclick="$('#authAsAdmin').toggle(150);
                            $('#adminPassword').focus()" style="float: right; margin-bottom: 8px;">Authenticate as administrator</a>
                    </p>
                    <br />
                <?php } ?>

                <?php if (!$isAdmin) { ?>
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
                <?php } ?>
                <?php include '../includes/footer.php' ?>
            </div>
        </div>

        <script type="text/javascript">
                    function loginAdmin() {
                        $("#authButton").button('loading');
                        var adminPassword = $("#adminPassword").val();
                        $.ajax({
                            url: '../ajax-handlers/auth-as-admin-ajax-submit.php',
                            type: "POST",
                            data: {
                                'adminPassword': adminPassword
                            },
                            success: function(response, textStatus, jqXHR) {
                                $("#authButton").button('reset');
                                if (response.indexOf("Successfully") !== -1) {
                                    location.reload();
                                } else {
                                    showMessage(response, 'danger');
                                }
                            }
                        });
                    }
        </script>  
    </body>
</html>
