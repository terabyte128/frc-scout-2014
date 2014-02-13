<div class='footer'>
    <br />
    <span class='footer-left'>
        <?php if ($isAdmin) { ?> <span style="color: firebrick;">Administrator</span> | <?php } ?> 
        <span style="color: royalblue; font-weight: 500;"><?php echo $teamType ?></span> | 
        <?php echo $scoutName ?> | Team 
        <?php echo $teamNumber ?> | 
        <?php echo $location ?>
    </span>
    <?php if (!$isAdmin) { ?>

        <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: center;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="authTitle">Authenticate as administrator</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="authAsAdmin" onsubmit="loginAdmin();
                                    return false;">
                            <div class="form-group">
                                <label for="adminPassword">Admin Password</label>
                                <input type="password" class="form-control" id="adminPassword" placeholder="Admin Password" required>
                            </div>                        
                            <button type="submit" id="authButton" class="btn btn-default btn-success">Authenticate</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class='login-form align-center' id="authAsAdmin" onsubmit="loginAdmin();
                                    return false;" style='width: 250px; display: none; margin-top: 20px;'>
            <br />

        </div>
    <?php } ?>
    <?php if ($_SERVER['PHP_SELF'] === "/home/index.php" || $_SERVER['PHP_SELF'] === "/home/team-profile.php") { ?>
        <?php if (!$isAdmin) { ?>
            <span><a href="#" id="optionAuthAsAdmin" onclick="$('#authModal').modal('show'); return false;" class='footer-right'>Authenticate as administrator</a>
            </span>
        <?php } else { ?>
            <span><a href="#" id="optionDeauthAsAdmin" onclick="logoutAdmin(); return false;" class='footer-right'>De-authenticate as administrator</a>
            </span>
            <?php
        }
    }
    ?>

    <script type="text/javascript">

                            $("#authModal").on('show.bs.modal'), function() {
                                $('#adminPassword').focus();
                            }


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
                                            $('#authModal').modal('dismiss');
                                        } else {
                                            $("#authTitle").html("<font style='color: firebrick;'>Incorrect password, please try again.</font>");
                                        }
                                    }
                                });
                            }

                            function logoutAdmin() {
                                $.ajax({
                                    url: '../ajax-handlers/deauth-as-admin-ajax-submit.php',
                                    type: "POST",
                                    success: function(response, textStatus, jqXHR) {
                                        location.reload();
                                    }
                                });
                            }
    </script>
</div>