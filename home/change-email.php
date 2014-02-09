<?php
require_once '../includes/setup-session.php';
require_once '../includes/admin-required.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change Password</title>
        <?php include '../includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="title">
                    <?php include '../includes/messages.php' ?>
                    <h2>Change Email</h2>
                </div>
                <p style="color: red;">This will change the password for <strong>all scouts on this team!</strong></p>
                <div class='login-form align-center' onsubmit="confirmReset();
                        return false;" style='width: 250px;'>
                    <form role="form">
                        <div class="form-group">
                            <label for="teamPassword">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" placeholder="Admin Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">New Team Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="New Team Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">Re-enter New Password</label>
                            <input type="password" class="form-control" id="newPasswordRepeat" placeholder="Re-enter New Password" required>
                        </div>

                        <button type="submit" id="submitButton" class="btn btn-default btn-success">Change Password</button>
                        <button type="button" onclick="document.location = 'index.php'" class ="btn btn-default btn-danger">Return</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>
        <script type="text/javascript">
                    function confirmReset() {
                        var confirmed = confirm("Are you sure you wish to change the password for ALL USERS?");
                        if (confirmed) {
                            requestReset();
                        } else {
                            window.location = "index.php";
                        }
                    }

                    function requestReset() {
                        var adminPassword = $("#adminPassword").val();
                        var newPassword = $("#newPassword").val();
                        var newPasswordRepeat = $("#newPasswordRepeat").val();
                        $("#submitButton").button('loading');
                        if (newPassword !== newPasswordRepeat) {
                            showMessage("Your passwords do not match, please try again.", 'danger');
                            $("#submitButton").button('reset');
                            return;
                        }

                        $.ajax({
                            url: '../ajax-handlers/change-password-ajax-submit.php',
                            type: "POST",
                            data: {
                                'adminPassword': adminPassword,
                                'newPassword': newPassword
                            },
                            success: function(response, textStatus, jqXHR) {
                                $("#submitButton").button('reset');
                                if (response.indexOf("successfully") !== -1) {
                                    loadPageWithMessage("index.php", response, "success");
                                } else {
                                    showMessage(response, 'danger');
                                }
                            }
                        });
                    }
        </script>
    </body>
</html>
