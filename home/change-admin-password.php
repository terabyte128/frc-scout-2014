<?php
require '../includes/setup-session.php';
require '../includes/admin-required.php';
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
                    <h2>Change Password</h2>
                </div>
                <div class='login-form align-center' onsubmit="requestReset();
                        return false;" style='width: 250px;'>
                    <form role="form">
                        <div class="form-group">
                            <label for="teamPassword">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" placeholder="Current Admin Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">New Admin Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="New Admin Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">Re-enter Password</label>
                            <input type="password" class="form-control" id="newPasswordRepeat" placeholder="Re-enter New Password" required>
                        </div>

                        <button type="submit" id="submitButton" class="btn btn-default btn-success">Change Admin Password</button>
                        <button type="button" onclick="document.location = 'index.php'" class ="btn btn-default btn-danger">Return</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>
        <script type="text/javascript">

                    function requestReset() {
                        var adminPassword = $("#adminPassword").val();
                        var newPassword = $("#newPassword").val();
                        var newPasswordRepeat = $("#newPasswordRepeat").val();
                        $("#submitButton").button('loading');
                        if (newPassword !== newPasswordRepeat) {
                            $("#inputError").show();
                            $("#inputError").addClass("alert-danger");
                            $("#alertError").text("Your passwords do not match, please try again.");
                            $("#submitButton").button('reset');
                            return;
                        }

                        $.ajax({
                            url: '../ajax-handlers/change-admin-password-ajax-submit.php',
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
                                    showMessage(reponse, 'danger');
                                }
                            }
                        });
                    }
        </script>
    </body>
</html>
