<form id="autonomous">
    <label for='scoredGoal'>Scored goal:</label>
    <br />
    <div class="btn-group" data-toggle="buttons" id='scoredGoal1'>
        <label class="btn btn-warning btn-lg" id="0-0" onclick='goalValues[0] = 0;
                updateTotals();
                updateMissed(false);'>
            <input type="radio" name="options" id="noGoal1">None
        </label>
        <label class="btn btn-danger btn-lg" id="0-m" onclick='goalValues[0] = 0;
                updateTotals();
                updateMissed(true);'>
            <input type="radio" name="options" id="missedGoal1">Missed
        </label>
        <label class="btn btn-blue-selection btn-lg" id="0-6" onclick='goalValues[0] = 6;
                updateTotals();
                updateMissed(false);'>
            <input type="radio" name="options" id="lowGoal1">Low
        </label>
        <label class="btn btn-success btn-lg" id="0-15" onclick='goalValues[0] = 15;
                updateTotals();
                updateMissed(false);'>
            <input type="radio" name="options" id="highGoal1">High
        </label>
    </div>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-warning" id="hotGoal1" style='margin: 10px auto; width: 212px;' onclick='updateHotGoal(0);
            updateTotals();' disabled>Hot Goal</button>
    <br />
    <div id="multiButtons" style='display:none;'>
        <div class="btn-group" data-toggle="buttons" id='scoredGoal2'>
            <label class="btn btn-warning btn-lg" id="1-0" onclick='goalValues[1] = 0;
                    updateTotals();
                    updateMissed(false, 1);'>
                <input type="radio" name="options" id="noGoal2">None
            </label>
            <label class="btn btn-danger btn-lg" id="1-m" onclick='goalValues[1] = 0;
                    updateTotals();
                    updateMissed(true, 1);'>
                <input type="radio" name="options" id="missedGoal2">Missed
            </label>
            <label class="btn btn-blue-selection btn-lg" id="1-6" onclick='goalValues[1] = 6;
                    updateTotals();
                    updateMissed(false, 1);'>
                <input type="radio" name="options" id="lowGoal2">Low
            </label>
            <label class="btn btn-success btn-lg" id="1-15" onclick='goalValues[1] = 15;
                    updateTotals();
                    updateMissed(false, 1);'>
                <input type="radio" name="options" id="highGoal2">High
            </label>
        </div>
        <br />
        <button data-toggle="button" class="btn btn-lg btn-warning" id="hotGoal2" style='margin: 10px auto; width: 212px;' onclick='updateHotGoal(1);
                updateTotals();' disabled>Hot Goal</button>
        <br />
        <div class="btn-group" data-toggle="buttons" id='scoredGoal3'>
            <label class="btn btn-warning btn-lg" id="2-0" onclick='goalValues[2] = 0;
                    updateTotals();
                    updateMissed(false, 2);'>
                <input type="radio" name="options" id="noGoal3">None
            </label>
            <label class="btn btn-danger btn-lg" id="2-m" onclick='goalValues[2] = 0;
                    updateTotals();
                    updateMissed(true, 2);'>
                <input type="radio" name="options" id="missedGoal3">Missed
            </label>
            <label class="btn btn-blue-selection btn-lg" id="2-6" onclick='goalValues[2] = 6;
                    updateTotals();
                    updateMissed(false, 2);'>
                <input type="radio" name="options" id="lowGoal3">Low
            </label>
            <label class="btn btn-success btn-lg" id="2-15" onclick='goalValues[2] = 15;
                    updateTotals();
                    updateMissed(false, 2);'>
                <input type="radio" name="options" id="highGoal3">High
            </label>
        </div>
        <br />
        <button data-toggle="button" class="btn btn-lg btn-warning" id="hotGoal3" style='margin: 10px auto; width: 212px;' onclick='updateHotGoal(2);
                updateTotals();' disabled>Hot Goal</button>
    </div>
    <button data-toggle="button" class="btn btn-lg btn-info" id="multiGoals" style="margin-top: 10px; width: 212px;"
            onclick="updateMulti();">Multiple Shots</button>
    <br />
    <br />
    <button data-toggle="button" class="btn btn-lg btn-info btn-no-border" id="movedToAllianceZone" style='margin-top: 10px; width: 212px;' onclick='updateMovedToAllianceZone();
            updateTotals();'>Moved to <span id='allianceColor'></span> zone</button>
    <br /><span class='typeahead-hint'><em>Mobility bonus</em></span>
    <br />
    <br />
    <h4><strong>Total Points: <span id='totalPoints'>0</span></strong></h4>

</form>
<script type="text/javascript">
    $(function() {
        $("#pageNameTitle").text("Autonomous");
        $("#allianceColor").text(localStorage.allianceColor);
        $("#movedToAllianceZone").css({
            "background-color": localStorage.allianceColorId,
            "text-color": "white"
        });
        //document.location.hash = "autonomous";

    });

    var goalValues = [undefined, undefined, undefined];

    var missedGoals = [false, false, false];

    function updateMissed(missed, n) {
        missedGoals[n] = missed;
    }

    var hotGoals = [false, false, false];

    var multi = false;

    var movedToAllianceZone = false;

    function updateMulti() {
        multi = !multi;
        $('#multiButtons').slideToggle(200);
        updateTotals();
    }

    function updateHotGoal(n) {
        hotGoals[n] = !hotGoals[n];
    }

    function updateMovedToAllianceZone() {
        movedToAllianceZone = !movedToAllianceZone;
    }

    function updateTotals() {
        totalPoints = 0;

        if (goalValues[0] !== undefined) {
            totalPoints += goalValues[0];
        }

        if (multi) {
            if (goalValues[1] !== undefined) {
                totalPoints += goalValues[1];
            }

            if (goalValues[2] !== undefined) {
                totalPoints += goalValues[2];
            }
        }

        if (hotGoals[0]) {
            totalPoints += 5;
        }

        if (multi) {
            if (hotGoals[1]) {
                totalPoints += 5;
            }

            if (hotGoals[2]) {
                totalPoints += 5;
            }
        }

        if (movedToAllianceZone) {
            totalPoints += 5;
        }

        $("#totalPoints").text(totalPoints);

        // yes this could be better shhhh
        if (goalValues[0] !== 0 && goalValues[0] !== undefined) {
            $("#hotGoal1").prop("disabled", false);
        } else {
            if (hotGoals[0]) {
                $("#hotGoal1").click();
                $("#hotGoal1").removeClass("active");
            }
            $("#hotGoal1").prop("disabled", true);
        }

        if (goalValues[1] !== 0 && goalValues[1] !== undefined) {
            $("#hotGoal2").prop("disabled", false);
        } else {
            if (hotGoals[1]) {
                $("#hotGoal2").click();
                $("#hotGoal2").removeClass("active");
            }
            $("#hotGoal2").prop("disabled", true);
        }

        if (goalValues[2] !== 0 && goalValues[2] !== undefined) {
            $("#hotGoal3").prop("disabled", false);
        } else {
            if (hotGoals[2]) {
                $("#hotGoal3").click();
                $("#hotGoal3").removeClass("active");
            }
            $("#hotGoal3").prop("disabled", true);
        }
    }

    function pushToLocalStorage() {
        var lowGoals = 0, highGoals = 0, missedGoalsCount = 0, hotGoalsCount = 0;

        for (var i in goalValues) {
            if (hotGoals[i] === true) {
                hotGoalsCount++;
            }
            if (goalValues[i] === 15) {
                highGoals++;
            } else if (goalValues[i] === 6) {
                lowGoals++;
            } else {
                if (missedGoals[i] === true) {
                    missedGoalsCount++;
                }
            }
        }

        if (!(goalValues[0] === undefined)) {
            localStorage.autoLowGoals = lowGoals;
            localStorage.autoHighGoals = highGoals;
            localStorage.autoMissedGoals = missedGoalsCount;
            localStorage.autoHotGoals = hotGoalsCount;
            localStorage.autoMovedToAllianceZone = movedToAllianceZone;

            // these are exclusively for the pull from localstorage
            localStorage.goalValues = JSON.stringify(goalValues);
            localStorage.hotGoals = JSON.stringify(hotGoals);
            localStorage.missedGoals = JSON.stringify(missedGoals);
            localStorage.multi = multi;

            hideMessage();
            //nextPhase();
            changePhase("teleoperated");
        } else {
            showMessage("Please select first goal scored.", "danger");
        }
    }

    function pullFromLocalStorage() {
        if (localStorage.goalValues !== undefined) {
            autoGoalValues = jQuery.parseJSON(localStorage.goalValues);
            autoHotGoals = jQuery.parseJSON(localStorage.hotGoals);
            autoMissedGoals = jQuery.parseJSON(localStorage.missedGoals);

            if (localStorage.multi === "true") {
                $("#multiButtons").show();
                $("#multiGoals").addClass("active");
                multi = true;
            } else {
                $("#multiButtons").hide();
                $("#multiGoals").removeClass("active");
                multi = false;
            }

            for (var i = 0; i < 3; i++) {
                if (autoGoalValues[i] !== undefined) {
                    goalValues[i] = parseInt(autoGoalValues[i]);
                    $("#" + i + "-" + goalValues[i]).addClass("active");
                }

                if (autoHotGoals[i] === true) {
                    updateHotGoal(i);
                    $("#hotGoal" + (i + 1)).addClass("active");
                }

                if (autoMissedGoals[i] === true) {
                    updateMissed(i);
                    $("#" + i + "-m").addClass("active");
                    $("#" + i + "-0").removeClass("active");
                }
            }
            
            goalValues = autoGoalValues;
            hotGoals = autoHotGoals;
            missedGoals = autoMissedGoals;

            if (localStorage.autoMovedToAllianceZone === "true") {
                updateMovedToAllianceZone();
                $("#movedToAllianceZone").addClass("active");

                $("#movedToAllianceZone").css({
                    "background-color": localStorage.allianceColorId,
                    "text-color": "white"
                });
            }

            updateTotals();
        }
    }
</script>