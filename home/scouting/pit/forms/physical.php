<form class="scouting-form">
    <label for="robotWeight">Robot weight (lbs):</label>
    <input type="number" class="form-control" placeholder="Robot weight" id="robotWeight">
    <br />
    <label for="robotWeight">Robot height (in):</label>
    <br />
    <div style="display:table;">
        <div style="display:table-row;">
            <div style="display:table-cell; width: 60%;">
                <input type="number" class="form-control" style="margin-bottom: 0px;" placeholder="Robot height" id="robotHeight">
            </div><div style="display:table-cell; width: 40%;">
                <button data-toggle="button" class="btn btn-success btn-no-border" id="canExtend" style='width:100%; margin-top: 0px; margin-left: 5px;' onclick='updateCanExtend();'>Can extend</button>
            </div>
        </div>
    </div>
    <br /><br />
    <label for="shooterType">Shooter type:</label>
    <input type="text" class="form-control" placeholder="Shooter type" id="shooterType">
    <span class="typeahead-hint">[electric | pneumatic | spring] [catapult | ram] <br /> slingshot | hammer | other</span>
    <br /><br />
    <label for="wheelType">Wheel type:</label>
    <input type="text" class="form-control" placeholder="Wheel type" id="wheelType">
    <span class="typeahead-hint">high-traction | mecanum | omni | plaction <br /> caster | pneumatic | other</span>
    <br /><br />
    <button data-toggle="button" class="btn btn-info btn-no-border btn-lg" style="width:250px;" id="swerve" onclick="updateSwerve()">Has Swerve Drive</button>
    <br /><br />
    <label for="wheelType">Number of wheels:</label>
    <input type="number" class="form-control" placeholder="Number of wheels" id="wheelNum">
    <br /><br />
    <label for="driveMotors">Number of drive motors:</label>
    <input type="number" class="form-control" placeholder="Number of drive motors" id="driveMotors">
    
    <br /><br />
</form>

<script type="text/javascript">

    var canExtend = false;
    var swerve = false;

    $(function() {
        $('#pageNameTitle').text("Physical Information");
        $("#shooterType").typeahead({
            'local': ["Electric Catapult", "Pneumatic Catapult", "Spring Catapult",
                "Electric Ram", "Pneumatic Ram", "Spring Ram", "Slingshot", "Hammer"]
        });
        $('#wheelType').typeahead({
            'local': ["Plaction", "High-Traction", "Mecanum", "Omni", "Caster", "Pneumatic"]
        });
        //document.location.hash = "prematch";
    });

    function updateCanExtend() {
        canExtend = !canExtend;
    }

    function updateSwerve() {
        swerve = !swerve;
    }

    function pullFromLocalStorage() {
        $("#driveMotors").val(localStorage.driveMotors);
        $("#robotWeight").val(localStorage.robotWeight);
        $("#robotHeight").val(localStorage.robotHeight);
        $("#shooterType").val(localStorage.shooterType);
        $("#wheelType").val(localStorage.wheelType);
        $("#wheelNum").val(localStorage.wheelNum);

        if (localStorage.canExtend === "true") {
            updateCanExtend();
            $("#canExtend").addClass("active");
        }
        if (localStorage.swerve === "true") {
            updateSwerve();
            $("#swerve").addClass("active");
        }
        updateTeamNumber(localStorage.teamNumber);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "") {
            $('#teamNumberTitle').text(": " + teamNumber);
        }
    }

    function pushToLocalStorage() {
        localStorage.driveMotors = $("#driveMotors").val();
        localStorage.robotWeight = $("#robotWeight").val();
        localStorage.robotHeight = $("#robotHeight").val();
        localStorage.canExtend = canExtend;
        localStorage.shooterType = $("#shooterType").val();
        localStorage.swerve = swerve;
        localStorage.wheelType = $("#wheelType").val();
        localStorage.wheelNum = $("#wheelNum").val();
        hideMessage();
        //nextPhase();
        changePhase("strategy");
    }

</script>