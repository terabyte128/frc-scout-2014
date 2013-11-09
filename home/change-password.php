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
                <p style="color: red;"><span class="glyphicon glyphicon-exclamation-sign"></span> <b>Warning: </b> this will change the password for <strong>all scouts on this team!</strong> <span class="glyphicon glyphicon-exclamation-sign"></span></p>
                <div class='login-form align-center' onsubmit="confirmReset();
                        return false;" style='width: 250px;'>
                    <form role="form">
                        <div class="form-group">
                            <label for="teamPassword">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">Desired New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="New Password" required>
                        </div>                        <div class="form-group">
                            <label for="teamPassword">Retype Password</label>
                            <input type="password" class="form-control" id="newPasswordRepeat" placeholder="Retype" required>
                        </div>

                        <button type="submit" id="submitButton" class="btn btn-default btn-success">Request Reset</button>
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
                        var currentPassword = $("#currentPassword").val();
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
                            url: '../includes/change-password-ajax-submit.php',
                            type: "POST",
                            data: {
                                'currentPassword': currentPassword,
                                'newPassword': newPassword
                            },
                            success: function(response, textStatus, jqXHR) {
                                $("#inputError").show();
                                $("#inputError").addClass("alert-danger");
                                $("#submitButton").button('reset');
                                $("#alertError").text(response);
                            }
                        });
                    }
        </script>
    </body>
</html>
