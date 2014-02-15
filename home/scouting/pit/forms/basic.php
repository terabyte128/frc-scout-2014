<form class="scouting-form">
    <span class="glyphicon glyphicon-info-sign"></span> When pit scouting, all fields are optional except for the team number. If you can't get a certain piece of information, you can just leave it blank.
    <br /><br />
    <label for="teamNumber">Team number:</label>
    <input type="number" class="form-control" placeholder="Team number" id="teamNumber" onblur="updateTeamNumber($('#teamNumber').val());">
    <br />
    <label for="teamCoach">Team coach name:</label>
    <input type="text" class="form-control" placeholder="Team coach name" id="teamCoach">
    <br />
    <label for="teamCoach">Who on&nbsp;<span id="thisText">this&nbsp;</span>team&nbsp;<span id="teamNumberText"></span>did you get this information from?</label>
    <input type="text" class="form-control" placeholder="Information provider" id="infoProvider">
    <br />
</form>

<script type="text/javascript">

    $(function() {
        $('#pageNameTitle').text("Basic Information");
    });

    function pullFromLocalStorage() {
        $("#teamNumber").val(localStorage.teamNumber);
        $("#teamCoach").val(localStorage.teamCoach);
        $("#infoProvider").val(localStorage.infoProvider);
        updateTeamNumber(localStorage.teamNumber);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "") {
            $('#teamNumberTitle').text(": " + teamNumber);
            $('#thisText').text("");
            $('#teamNumberText').text(teamNumber + " ");
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