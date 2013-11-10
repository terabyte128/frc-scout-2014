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

                <button onclick="window.location = 'logout.php';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>

                <?php if ($_SESSION['isAdmin'] == true) { ?>
                    <br>
                    <font style="color: #bbb; float: right; font-size: 10pt;">Admin Tools</font>
                    <hr style="border-top: 1px solid #bbb">
                    <button onclick="$('#fileUploadWrapper').show();" class="btn btn-lg btn-info btn-home-selections">Change Team Picture</button>
                    <button onclick="window.location = 'change-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Team Password</button>
                    <button onclick="window.location = 'change-admin-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Admin Password</button>
                    <div style="display: none;" id="fileUploadWrapper">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="files[]" data-url="team-photos">
                        </span>
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 0%;"></div>
                        </div>
                        <div id="files" class="files"></div>
                    </div>
                <?php } ?>

                <br />

                <?php if ($_SESSION['isAdmin'] == false) { ?>
                    <a href="#" id="optionAuthAsAdmin" onclick="$('#authAsAdmin').toggle(150);
                            $('#adminPassword').focus()" style="float: right; margin-bottom: 8px;">Authenticate as administrator</a>
                   <?php } ?>

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

                    $(function() {
                        $('#fileupload').fileupload({
                            dataType: 'json',
                            done: function(e, data) {
                                $.each(data.result.files, function(index, file) {
                                    $('<p/>').text(file.name).appendTo('#files');
                                });
                            },
                            progressall: function(e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('#progress .progress-bar').css(
                                        'width',
                                        progress + '%'
                                        );
                            }
                        }).prop('disabled', !$.support.fileInput)
                                .parent().addClass($.support.fileInput ? undefined : 'disabled');
                    });

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
