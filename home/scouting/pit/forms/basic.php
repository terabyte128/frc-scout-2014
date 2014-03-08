<form class="scouting-form">
    <span class="glyphicon glyphicon-info-sign"></span> When pit scouting, all fields are optional except for the team number. If you can't get a certain piece of information, you can just leave it blank.
    <br /><br />
    <label for='teamName'>Team name:</label>
    <input type='text' class='form-control' placeholder='Team name' id='teamName'>
    <br />
    <label for="teamNumber">Team number:</label>
    <input type="number" class="form-control" placeholder="Team number" id="teamNumber" onblur="updateTeamNumber($('#teamNumber').val());">
    <br />
    <label for="teamCoach">Team coach name:</label>
    <input type="text" class="form-control" placeholder="Team coach name" id="teamCoach">
    <br />
    <label for="teamCoach">Who on&nbsp;<span id="thisText">this&nbsp;</span>team&nbsp;<span id="teamNumberText"></span>did you get this information from?</label>
    <input type="text" class="form-control" placeholder="Information provider" id="infoProvider">
    <br />
    <div id="warningAlreadyScouted" style="display: none; background: #ffff99; padding: 5px; padding-right:0; border-radius: 5px; position: relative;">
        <div style="display: inline-block; max-width: 10%; height: 100%; position: absolute; top: 0; left: -5px; bottom: 0; right: 0; margin-top: auto; margin-bottom: auto;">
            <span class="glyphicon glyphicon-exclamation-sign" style="position: absolute; top: 35%;"></span>
        </div>
        <div style="display: inline-block; max-width: 90%; padding-left: 15px;">This team has already been scouted at this location by your team.</div>
    </div>
    <br />
</form>

<script type="text/javascript">

    $(function() {
        $('#pageNameTitle').text("Basic Information");
    });

    function pullFromLocalStorage() {
        $("#teamName").val(localStorage.teamName);
        $("#teamNumber").val(localStorage.teamNumber);
        $("#teamCoach").val(localStorage.teamCoach);
        $("#infoProvider").val(localStorage.infoProvider);
        updateTeamNumber(localStorage.teamNumber);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "" && teamNumber !== undefined) {
            $('#teamNumberTitle').text(": " + teamNumber);
            $('#thisText').text("");
            $('#teamNumberText').text(teamNumber + " ");
            $.ajax({
                url: 'check-for-already-scouted.php',
                method: 'POST',
                data: {
                    'scoutedTeam': teamNumber
                },
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                    if (response !== "") {
                        $("#warningAlreadyScouted").show();
                    } else {
                        $("#warningAlreadyScouted").hide();
                    }
                }
            });
        }
    }

    function pushToLocalStorage() {
        var errorMessage = "";
        var errors = false;
        var teamNumber = $("#teamNumber").val();

        if (teamNumber === "") {
            errorMessage += "Please enter a team number.<br />";
            errors = true;
        }

        if (!errors) {
            localStorage.teamNumber = $("#teamNumber").val();
            localStorage.teamName = $("#teamName").val();
            localStorage.teamCoach = $("#teamCoach").val();
            localStorage.infoProvider = $("#infoProvider").val();
            hideMessage();
            //nextPhase();
            changePhase("physical");
        } else {
            showMessage(errorMessage, "danger");
        }
    }

</script>