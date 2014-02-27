<?php require_once '../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php'; ?>
        <title>FRC Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2>FRC Scout: Home</h2>
                <br />
                <font style="color: #868686; float: right; font-size: 10pt;">Scouting Tools</font>
                <hr style="border-top: 1px solid #bbb">

                <?php if ($teamType === "FTC") { ?>

                    <button onclick='window.location = "ftc/container.php";' class="btn btn-lg btn-success btn-home-selections">Scout a New Team</button>
                    <button onclick='window.location = "ftc/ftc-team-averages.php";' class="btn btn-lg btn-info btn-home-selections">View Team Averages</button>
                <?php } ?>
                <?php if ($teamType === "FRC") { ?>
                    <button onclick='localStorage.clear();
                            window.location = "scouting/match";' class="btn btn-lg btn-success btn-home-selections">Scout a Match</button>
                    <button onclick='localStorage.clear();
                            window.location = "scouting/pit";' class="btn btn-lg btn-success btn-home-selections">Pit Scout a Team</button>
                    <button onclick='window.location = "/teams";' class="btn btn-lg btn-success btn-home-selections">View Registered Teams</button>

                    <br /><br />
                    <font style="color: #868686; float: right; font-size: 10pt;">Results Tools</font>
                    <hr style="border-top: 1px solid #bbb">
                    <button onclick="window.location = '/team';" id="yourTeamProfile" class="btn btn-lg btn-info btn-home-selections"><?php if ($isAdmin) { ?>Edit<?php } else { ?>Your<?php } ?> Team Profile</button>
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

                    <button onclick='window.location = "/alliances";' class="btn btn-lg btn-info btn-home-selections">Alliance Tools</button>
                    <button onclick='window.location = "/home/results/averages";' class="btn btn-lg btn-info btn-home-selections">View Team Averages</button>
                <?php } ?>



                <br /><br />
                <font style="color: #868686; float: right; font-size: 10pt;">Account Tools</font>
                <hr style="border-top: 1px solid #bbb">
                <?php if ($isAdmin) { ?>

                    <button onclick="window.location = 'preferences';" class="btn btn-lg btn-warning btn-home-selections">Update Team Preferences</button>

                <?php } ?>
                <button onclick="window.location = 'logout.php';" class="btn btn-lg btn-warning btn-home-selections">Log Out</button>


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

                    if (localStorage.newAccount === "true") {

                        $("#optionAuthAsAdmin").popover({
                            content: "<font style='color: rgb(182, 19, 0); font-size:14px;'>Administrators can edit team profiles and passwords.</font>",
                            trigger: 'hover',
                            placement: 'top',
                            html: "true"
                        });

                        $("#yourTeamProfile").popover({
                            content: "Team profiles contain general information and statistics about your team.",
                            trigger: 'hover',
                            placement: 'top',
                            html: "true"
                        });

                        $("#optionAuthAsAdmin").popover({
                            content: "<span style='color: rgb(182, 19, 0)'>Administrators can edit team profiles and passwords.</span>",
                            trigger: 'hover',
                            placement: 'top',
                            html: "true"
                        });

                        $("#optionAuthAsAdmin").popover('show');

                        localStorage.newAccount = undefined;
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
