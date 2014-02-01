<form id="autonomous">
    <label for='scoredGoal'>Scored goal:</label>
    <br />
    <div class="btn-group" data-toggle="buttons" id='scoredGoal'>
        <label class="btn btn-danger btn-lg" onclick='goalValue = 0;
                updateTotals();'>
            <input type="radio" name="options" id="noGoal">None
        </label>
        <label class="btn btn-blue-selection btn-lg" onclick='goalValue = 6;
                updateTotals();'>
            <input type="radio" name="options" id="lowGoal">Low
        </label>
        <label class="btn btn-success btn-lg" onclick='goalValue = 15;
                updateTotals();'>
            <input type="radio" name="options" id="highGoal">High
        </label>
    </div>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-warning" id="hotGoal" style='margin-top: 10px; width: 212px;' onclick='updateHotGoal();
                updateTotals();' disabled>Hot Goal</button>
    <br />
    <br />
    <button data-toggle="button" class="btn btn-lg btn-info btn-no-border" id="movedToAllianceZone" style='margin-top: 10px; width: 212px;' onclick='updateMovedToAllianceZone();
                updateTotals();'>Moved to <span id='allianceColor'></span> zone</button>
    <br />
    <br />
    <h4><strong>Total Points: <span id='totalPoints'>0</span></strong></h4>

</form>
<script type="text/javascript">
            $(function() {
                $("#pageNameTitle").text("Autonomous");
                $('#nextPhaseButton').text('Continue to teleoperated');
                $("#allianceColor").text(localStorage.allianceColor);
                $("#movedToAllianceZone").css({
                    "background-color": localStorage.allianceColorId,
                    "text-color": "white"
                });
                document.location.hash = "autonomous";

            });

            var goalValue = undefined;

            var hotGoal = false;
            var movedToAllianceZone = false;

            function updateHotGoal() {
                hotGoal = !hotGoal;
            }

            function updateMovedToAllianceZone() {
                movedToAllianceZone = !movedToAllianceZone;
            }

            function updateTotals() {
                totalPoints = 0;

                if (goalValue !== undefined) {
                    totalPoints += goalValue;
                }

                if (hotGoal) {
                    totalPoints += 5;
                }

                if (movedToAllianceZone) {
                    totalPoints += 5;
                }

                $("#totalPoints").text(totalPoints);
                if (goalValue !== 0 && goalValue !== undefined) {
                    $("#hotGoal").prop("disabled", false);
                } else {
                    if (hotGoal) {
                        $("#hotGoal").click();
                        $("#hotGoal").removeClass("active");
                    }
                    $("#hotGoal").prop("disabled", true);
                }
            }

            function pushToLocalStorage() {
                if (!(goalValue === undefined)) {
                    localStorage.autoGoalValue = goalValue;
                    localStorage.autoHotGoal = hotGoal;
                    localStorage.autoMovedToAllianceZone = movedToAllianceZone;
                    hideMessage();
                    nextPhase();
                } else {
                    showMessage("Please select goal scored.", "danger");
                }
            }
</script>