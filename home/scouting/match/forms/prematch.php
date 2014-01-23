<form class="scouting-form">    
    <label for="teamNumber">Team number</label>
    <input type="number" class="form-control" placeholder="Team number" id="teamNumber" onkeyup="updateTeamNumber($('#teamNumber').val());">
    <br />
    <label for="teamNumber">Match number</label>
    <input type="number" class="form-control" placeholder="Match number" id="matchNumber">
    <br />
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-danger" onclick="updateAlliance('red');">
            <input type="radio" name="options" id="redAlliance">Red Alliance
        </label>
        <label class="btn btn-blue-selection" onclick="updateAlliance('blue');">
            <input type="radio" name="options" id="blueAlliance"> Blue Alliance
        </label>
    </div>
</form>
<script type="text/javascript">

    var allianceColor = "";

    $(function() {
        $('#nextPhaseButton').text('Start scouting')
        $('#pageNameTitle').text("Pre-Match Information")
    });

    function updateAlliance(color) {

        var borderColor;
        if (color === "red") {
            borderColor = "#d2322d";
        } else {
            borderColor = "rgb(0, 82, 255)";
        }

        $(".container").css({
            'border-top': '5px solid ' + borderColor,
            'border-bottom': '5px solid ' + borderColor
        });

        allianceColor = color;
    }

    function pushToLocalStorage() {
        var errorMessage = "";
        var errors = false;
        teamNumber = $("#teamNumber").val();
        matchNumber = $("#matchNumber").val();

        if (teamNumber === "") {
            errorMessage += "&bull; Enter a team number.<br />";
            errors = true;
        }
        if (matchNumber === "") {
            errorMessage += "&bull; Enter a match number.<br />";
            errors = true;
        }

        if (allianceColor === "") {
            errorMessage += "&bull; Select an alliance color.";
            errors = true;
        }

        if (!errors) {
            localStorage.allianceColor = allianceColor;
            localStorage.teamNumber = $("#teamNumber").val();
            localStorage.matchNumber = $("#matchNumber").val();
            hideMessage();
            nextPhase();
        } else {
            showMessage("Please correct the following errors:<br />" + errorMessage, "danger");
        }
    }

    function updateTeamNumber(teamNumber) {
        $('#teamNumberTitle').text(": " + teamNumber);
    }
</script>