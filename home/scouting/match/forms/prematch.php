<form class="scouting-form">
    <button data-toggle="button" class="btn btn-lg btn-success active" id="teamPresent" style='width: 200px;' onclick='updatePresent();'>Team Present</button>
    <br /><br />
    <label for="teamNumber">Team number:</label>
    <input type="number" class="form-control" placeholder="Team number" id="teamNumber" onblur="updateTeamNumber($('#teamNumber').val());">
    <br />
    <label for="teamNumber">Match number:</label>
    <input type="number" class="form-control" placeholder="Match number" id="matchNumber">
    <br />
    <label for='selectAlliance'>Alliance color:</label>
    <br />
    <div class="btn-group" data-toggle="buttons" id='selectAlliance'>
        <label class="btn btn-danger btn-lg" onclick="updateAlliance('red');" style="width: 100px;">
            <input type="radio" name="options" id="redAlliance">Red
        </label>
        <label class="btn btn-blue-selection btn-lg" onclick="updateAlliance('blue');"  style="width: 100px;">
            <input type="radio" name="options" id="blueAlliance">Blue
        </label>
    </div>
</form>
<script type="text/javascript">

    var allianceColor = "";
    var borderColor = "";
    var teamPresent = true;

    $(function() {
        $('#nextPhaseButton').text('Start scouting')
        $('#pageNameTitle').text("Pre-Match Information")
    });

    function updateAlliance(color) {

        if (color === "red") {
            borderColor = "#d2322d";
        } else {
            borderColor = "rgb(0, 82, 255)";
        }

        $(".container").css({
            'border-top': '5px solid ' + borderColor,
            'border-bottom': '5px solid ' + borderColor
        });


        $("#movedToAllianceZone").css({
            'background-color' : borderColor
        });
        
        allianceColor = color;
    }

    function updatePresent() {
        teamPresent = !teamPresent;
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
            localStorage.teamPresent = teamPresent;
            localStorage.allianceColorId = borderColor;
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