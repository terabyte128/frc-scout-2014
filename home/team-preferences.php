<?php
require_once '../includes/setup-session.php';
require_once '../includes/admin-required.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change Team Preferences</title>
        <?php include '../includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="title">
                    <?php include '../includes/messages.php' ?>
                    <h2>Change Team Preferences</h2>
                    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
                </div>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <form role="form" onsubmit='requestReset();
                        return false;' class='scouting-form'>
                    <div class="form-group">
                        <label for="currentAdminPassword">To update team preferences, enter your current admin password:</label>
                        <input type="password" class="form-control" id="currentAdminPassword" placeholder="Current Admin Password" required>
                    </div>                
                    <hr>
                    <div class="form-group">
                        <label for="newPassword">Update Team Password</label>
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="newPasswordRepeat">Re-enter Team Password</label>
                        <input type="password" class="form-control" id="newPasswordRepeat" placeholder="Re-enter New Password">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="newAdminPassword">Update Admin Password</label>
                        <input type="password" class="form-control" id="newAdminPassword" placeholder="New Admin Password">
                    </div>                        
                    <div class="form-group">
                        <label for="newAdminPasswordRepeat">Re-enter Admin Password</label>
                        <input type="password" class="form-control" id="newAdminPasswordRepeat" placeholder="Re-enter New Admin Password">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="newTeamEmail">Update Team Email</label>
                        <input type="email" class="form-control" id="newTeamEmail" placeholder="Enter New Email">
                    </div>
                    <br />
                    <button type="submit" id="submitButton" class="btn btn-default btn-success">Update Preferences</button>
                </form>
                <br />
            </div>
        </div>
        <script type="text/javascript">

            function requestReset() {

                var currentAdminPassword = $("#currentAdminPassword").val();

                var newPassword = $("#newPassword").val();
                var newPasswordRepeat = $("#newPasswordRepeat").val();

                var newAdminPassword = $("#newAdminPassword").val();
                var newAdminPasswordRepeat = $("#newAdminPasswordRepeat").val();

                var newTeamEmail = $("#newTeamEmail").val();

                if (newPassword !== newPasswordRepeat) {
                    showMessage('Your new team passwords do not match, please try again.', 'danger');
                    $("#submitButton").button('reset');
                    return;
                }

                if (newAdminPassword !== newAdminPasswordRepeat) {
                    showMessage('Your new admin passwords do not match, please try again.', 'danger');
                    $("#submitButton").button('reset');
                    return;
                }

                $("#submitButton").button('loading');

                $.ajax({
                    url: '/ajax-handlers/update-preferences-ajax.php',
                    type: "POST",
                    data: {
                        'currentAdminPassword': CryptoJS.MD5(currentAdminPassword).toString(),
                        'newPassword': CryptoJS.MD5(newPassword).toString(),
                        'newAdminPassword': CryptoJS.MD5(newAdminPassword).toString(),
                        'newTeamEmail': newTeamEmail
                    },
                    success: function(response, textStatus, jqXHR) {
                        $("#submitButton").button('reset');
                        if (response.indexOf("success") !== -1) {
                            showMessage(response, 'success');
                        } else {
                            showMessage(response, 'danger');
                        }
                    }
                });
            }
        </script>
    </body>
</html>
