<?php
if (isset($_GET['id'])) {
    $requestMade = true;
    $resetId = $_GET['id'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Recover Password</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>

    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;">Recover Password</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <br />


                <?php if (!isset($requestMade)) { ?>
                    <!-- ~ page content goes here ~ -->
                    <p>
                        <span style='color: firebrick;' class="glyphicon glyphicon-exclamation-sign"></span>
                        If you are a team member, ask your team administrator for your password.
                        <br />
                        This page is only for use by administrators in the case that they forget the team's password.
                    </p>


                    <form role='form' class='scouting-form' method="post" action="/ajax-handlers/recover-password-ajax.php">
                        <label for="teamNumber">Team Number</label>
                        <input type="number" name="teamNumber" id="teamNumber" class="form-control">

                        <Br /><br />
                        <label for="adminEmail">Admin Email</label>
                        <input type="email" name="adminEmail" id="adminEmail" class="form-control">

                        <Br /><br />
                        <label>Reset:</label>
                        <br />
                        <label style="font-weight: normal;">
                            <input type="radio" name="adminPasswordReset" value="false"> Team Password
                        </label>
                        <br>
                        <label style="font-weight: normal;">
                            <input type="radio" name="adminPasswordReset" value="true"> Admin Password
                        </label>
                        <br /><br />
                        <button type="submit" class="btn btn-warning btn-lg">Request Reset</button>
                    </form>
                <?php } else { ?>
                    <br />
                    <form role="form" class="scouting-form" onsubmit="resetPassword(); return false;">
                        <label for="newPassword">New Password</label>
                        <input id="newPassword" class="form-control" type="password">
                        <Br />
                        <button type="submit" class="btn btn-lg btn-success">Reset Password</button>
                    </form>
                    <script type="text/javascript">
                        function resetPassword() {
                            $.ajax({
                                url: '/ajax-handlers/reset-password-ajax.php',
                                type: "POST",
                                data: {
                                    'newPassword': CryptoJS.MD5($("#newPassword").val()).toString(),
                                    'resetId': "<?php echo $resetId; ?>"
                                },
                                success: function(response) {
                                    if (response === "") {
                                        loadPageWithMessage("/", "Password reset successfully.", "success");
                                    } else {
                                        showMessage(response, "danger");
                                    }
                                }
                            }
                            );
                        }
                    </script>
                <?php } ?>
                <Br />
                <br />
            </div>
        </div>
    </body>
</html>
