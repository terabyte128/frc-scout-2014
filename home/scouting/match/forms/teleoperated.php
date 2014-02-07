<form id="teleoperated" class="scouting-form">
    <label for='assists'>Assists</label>
    <div id='assists'>
        <div>
            <button type="button" id="receivedAdd" class="btn btn-lg btn-default btn-add-score">Received</button>
            <button type="button" id="receivedSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='receivedTotal' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" id="passedAdd" class="btn btn-lg btn-default btn-add-score">Passed</button>
            <button type="button" id="passedSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='passedTotal' class='score-tally'>0</span>
        </div>
    </div>
    <br />
    <label for='goals'>Goals</label>
    <div id='goals'>
        <div>
            <button type="button" id="highGoalAdd" class="btn btn-lg btn-default btn-add-score">High</button>
            <button type="button" id="highGoalSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='highGoalTotal' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" id="lowGoalAdd" class="btn btn-lg btn-default btn-add-score">Low</button>
            <button type="button" id="lowGoalSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='lowGoalTotal' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" id="missedGoalAdd" class="btn btn-lg btn-default btn-add-score">Miss</button>
            <button type="button" id="missedGoalSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='missedGoalTotal' class='score-tally'>0</span>
        </div>
    </div>
    <br />
    <label for='truss'>Truss</label>
    <div id='truss'>
        <div>
            <button type="button" id="threwOverTrussAdd" class="btn btn-lg btn-default btn-add-score">Threw Over</button>
            <button type="button" id="threwOverTrussSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='trussThrew' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" id="caughtFromTrussAdd" class="btn btn-lg btn-default btn-add-score">Caught From</button>
            <button type="button" id="caughtFromTrussSubtract" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='trussCaught' class='score-tally'>0</span>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('#pageNameTitle').text("Teleoperated")
    //document.location.hash = "teleoperated";

    var highGoals = 0;
    var lowGoals = 0;
    var missedGoals = 0;

    var receivedAssists = 0;
    var passedAssists = 0;

    var trussThrows = 0;
    var trussCatches = 0;

    $("button").click(function() {
        switch (this.id) {
            case "receivedAdd":
                receivedAssists = update(receivedAssists, 'receivedTotal', false);
                break;
            case "receivedSubtract":
                receivedAssists = update(receivedAssists, 'receivedTotal', true);
                break;

            case "passedAdd":
                passedAssists = update(passedAssists, 'passedTotal', false);
                break;
            case "passedSubtract":
                passedAssists = update(passedAssists, 'passedTotal', true);
                break;

            case "highGoalAdd":
                highGoals = update(highGoals, 'highGoalTotal', false);
                break;
            case "highGoalSubtract":
                highGoals = update(highGoals, 'highGoalTotal', true);
                break;

            case "lowGoalAdd":
                lowGoals = update(lowGoals, 'lowGoalTotal', false);
                break;
            case "lowGoalSubtract":
                lowGoals = update(lowGoals, 'lowGoalTotal', true);
                break;

            case "missedGoalAdd":
                missedGoals = update(missedGoals, 'missedGoalTotal', false);
                break;
            case "missedGoalSubtract":
                missedGoals = update(missedGoals, 'missedGoalTotal', true);
                break;

            case "threwOverTrussAdd":
                trussThrows = update(trussThrows, 'trussThrew', false);
                break;
            case "threwOverTrussSubtract":
                trussThrows = update(trussThrows, 'trussThrew', true);
                break;

            case "caughtFromTrussAdd":
                trussCatches = update(trussCatches, 'trussCaught', false);
                break;
            case "caughtFromTrussSubtract":
                trussCatches = update(trussCatches, 'trussCaught', true);
                break;
        }
    });

    function update(variable, countId, subtract) {
        if (subtract) {
            if (variable > 0) {
                variable--;
            }
        } else {
            variable++;
        }

        $("#" + countId + "").text(variable);
        return variable;
    }

    function pushToLocalStorage() {
        //assists
        localStorage.teleReceivedAssists = receivedAssists;
        localStorage.telePassedAssists = passedAssists;

        //goals
        localStorage.teleHighGoals = highGoals;
        localStorage.teleLowGoals = lowGoals;
        localStorage.teleMissedGoals = missedGoals;

        //truss
        localStorage.teleTrussThrows = trussThrows;
        localStorage.teleTrussCatches = trussCatches;

        //nextPhase();
        changePhase("postmatch");
    }
    
    function pullFromLocalStorage() {
        if(localStorage.teleReceivedAssists !== undefined) {
            receivedAssists = localStorage.teleReceivedAssists;
            $("#receivedTotal").text(receivedAssists);
        }
        if(localStorage.telePassedAssists !== undefined) {
            passedAssists = localStorage.telePassedAssists;
            $("#passedTotal").text(passedAssists);
        }
        
        if(localStorage.teleHighGoals !== undefined) {
            highGoals = localStorage.teleHighGoals;
            $("#highGoalTotal").text(highGoals);
        }
        if(localStorage.teleLowGoals !== undefined) {
            lowGoals = localStorage.teleLowGoals;
            $("#lowGoalTotal").text(lowGoals);
        }
        if(localStorage.teleMissedGoals !== undefined) {
            missedGoals = localStorage.teleMissedGoals;
            $("#missedGoalTotal").text(missedGoals);
        }
        
        if(localStorage.teleTrussThrows !== undefined) {
            trussThrows = localStorage.teleTrussThrows;
            $("#trussThrew").text(trussThrows);
        }
        if(localStorage.teleTrussCatches !== undefined) {
            trussCatches = localStorage.teleTrussCatches;
            $("#trussCaught").text(trussCatches);
        }
    }
</script>