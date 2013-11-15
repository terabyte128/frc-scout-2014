<?php include 'includes/redirect-if-session-exists.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Your Password?</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="title">
                    <?php include 'includes/messages.php' ?>
                    <h2>Forgot Your Password?</h2>
                </div>
                <div class='login-form align-center' style='width: 250px;'>
                    <div class="form-group">
                        <label for="teamNumber">Team Number</label>
                        <input type="number" class="form-control" id="teamNumber" name="teamNumber" placeholder="Team Number" require_onced>
                    </div>
                    <div class="form-group">
                        <label for="adminEmail">Administrator Email</label>
                        <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="Admin Email" require_onced>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" require_onced>
                    </div>
                    <div class="form-group">
                        <label for="passwordType">Password Type</label>
                        <br>
                        <label style="font-weight: normal"><input type="radio" class="form-control" style="width: 50px" name="passwordType" value="team_password" require_onced>Team</label>
                        <label style="font-weight: normal"><input type="radio" class="form-control" style="width: 50px" name="passwordType" value="admin_password" require_onced>Admin</label>
                    </div>
                    <div class="form-group">
                        <label for="teamType">Team Type</label>
                        <select class="form-control" id="teamType">
                            <option selected id="frc">FRC (big robots)</option>
                            <option id="ftc">FTC (small robots)</option>                           
                        </select>
                    </div>
                    <button type="button" onclick="sendResetMail();" id="submitButton" class="btn btn-default btn-success">Request Reset</button>
                    <br><br>
                </div>
            </div>
        </div>
        <script type="text/javascript">
                        function sendResetMail() {
                            $("#submitButton").button('loading');
                            var teamNumber = $("#teamNumber").val();
                            var adminEmail = $("#adminEmail").val();
                            var newPassword = $("#newPassword").val();
                            var passwordType = $('input[type="radio"]:checked').val();
                            var teamType = $('#teamType').find('option:selected').attr('id');

                            $.ajax({
                                url: 'ajax-handlers/forgot-password-ajax-submit.php',
                                type: "POST",
                                data: {
                                    'teamNumber': teamNumber,
                                    'adminEmail': adminEmail,
                                    'newPassword': newPassword,
                                    'passwordType': passwordType,
                                    'teamType' : teamType
                                },
                                success: function(response, textStatus, jqXHR) {
                                    if (response.indexOf("sent") === -1) {
                                        $("#submitButton").button('reset');
                                        showMessage(response, 'danger');
                                    } else {
                                        loadPageWithMessage("index.php", response, "success");
                                    }
                                }
                            });
                        }
        </script>
    </body>
</html>
