<?php require_once '../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php'; ?>
        <title>FIRST Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>FIRST Scout: Home</h2>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Scouting Tools</font>
                <hr style="border-top: 1px solid #bbb">

                <?php if ($teamType === "FTC") { ?>

                    <button onclick='window.location = "ftc/container.php";' class="btn btn-lg btn-success btn-home-selections">Scout a New Team</button>
                    <button onclick='window.location = "ftc/ftc-team-averages.php";' class="btn btn-lg btn-info btn-home-selections">View Team Averages</button>
                <?php } ?>
                <?php if ($teamType === "FRC") { ?>
                    <button onclick='window.location = "scouting/match";' class="btn btn-lg btn-success btn-home-selections">Scout a Match</button>
                    <button onclick='window.location = "scouting/pit";' class="btn btn-lg btn-success btn-home-selections">Pit Scout a Team</button>

                    <br /><br />
                    <font style="color: #868686; float: right; font-size: 10pt;">Results</font>
                    <hr style="border-top: 1px solid #bbb">
                    <button onclick="window.location = '/team';" class="btn btn-lg btn-info btn-home-selections">Team Profile</button>
                    <div style="display: inline;">
                        <div style="display: inline-table;">
                            <div style="display: table-row">
                                <form onsubmit="goToTeamProfile();
                                return false;" style="display: inline;">
                                    <div style="display: table-cell">

                                        <input type="number" class="form-control" style="display: inline; height: 50px; border-radius: 6px; width: 175px; height: 48px; font-size: 18px; text-align: center; margin-right: 4px;" placeholder="Find Team Profile" id="searchForTeam">
                                    </div>
                                    <div style="display: table-cell">
                                        <button class="btn btn-lg btn-info btn-home-selections" style="width: 60px; display: inline; text-align: center;" id="searchButton">Go</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button onclick='window.location = "/home/averages";' class="btn btn-lg btn-info btn-home-selections">View Team Averages</button>
                <?php } ?>



                <br /><br />
                <font style="color: #868686; float: right; font-size: 10pt;">Account Tools</font>
                <hr style="border-top: 1px solid #bbb">
                <?php if ($isAdmin) { ?>

                    <button onclick="window.location = 'change-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Team Password</button>
                    <button onclick="window.location = 'change-admin-password.php';" class="btn btn-lg btn-warning btn-home-selections">Change Admin Password</button>

                <?php } ?>
                <button onclick="window.location = 'logout.php';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>

                <?php if (!$isAdmin) { ?>

                    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
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
                <?php include '../includes/footer.php' ?>
            </div>
        </div>

        <script type="text/javascript">
                        $('#authModal').on('shown.bs.modal', function() {
                            $('#adminPassword').focus();
                        })

                        $('#authModal').on('hidden.bs.modal', function() {
                            $("#authTitle").text("Authenticate as administrator");
                            $("#adminPassword").val('');
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
                                        $('#authModal').modal('dismiss');
                                    } else {
                                        $("#authTitle").html("<font style='color: firebrick;'>Incorrect password, please try again.</font>");
                                    }
                                }
                            });
                        }

                        function goToTeamProfile() {
                            var otherTeamNumber = $("#searchForTeam").val();
                            if (otherTeamNumber == <?php echo $teamNumber ?>) {
                                window.location = 'team-profile.php';
                            } else if (otherTeamNumber === "") {
                                showMessage("Please enter a team number.", 'warning');
                            } else if (isNaN(otherTeamNumber)) {
                                showMessage("That's not a number!", 'danger');
                            } else if (otherTeamNumber < 0) {
                                showMessage("That's not a valid team number!", 'danger');
                            } else {
                                window.location = '/team/' + otherTeamNumber;
                            }
                        }
                        
                        /*
                         * Called when a user decides that they were stupid and didn't
                         * in fact want to delete their match data, restores it from
                         * a localStorage array back as before
                         */
                        function restore() {
                            alert("This feature will be added soon");
                        }
        </script>  
    </body>
</html>
