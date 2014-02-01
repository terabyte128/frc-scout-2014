<form id="teleoperated" class="scouting-form">
    <label for='assists'>Assists</label>
    <div id='assists'>
        <div>
            <button type="button" id="receivedAdd" class="btn btn-lg btn-default btn-add-score">Received</button>
            <button type="button" id="receivedRemove" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='receivedTotal' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" class="btn btn-lg btn-default btn-add-score">Passed</button>
            <button type="button" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='passedTotal' class='score-tally'>0</span>
        </div>
    </div>
    <br />
    <label for='goals'>Goals</label>
    <div id='goals'>
        <div>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">High</button>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">Low</button>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">Miss</button>
        </div>
        <div>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">&mdash;</button>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">&mdash;</button>
            <button type="button" class="btn btn-lg btn-default btn-mini-change-score">&mdash;</button>
        </div>
        <div>
            <span id='highTotal' class="score-tally mini-score-tally">0</span>
            <span id='lowTotal' class="score-tally mini-score-tally">0</span>
            <span id='missTotal' class="score-tally mini-score-tally">0</span>
        </div>
    </div>
    <br />
    <label for='truss'>Truss</label>
    <div id='truss'>
        <div>
            <button type="button" class="btn btn-lg btn-default btn-add-score">Threw Over</button>
            <button type="button" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='trussThrew' class='score-tally'>0</span>
        </div>
        <div>
            <button type="button" class="btn btn-lg btn-default btn-add-score">Caught From</button>
            <button type="button" class="btn btn-lg btn-default btn-remove-score">&mdash;</button>
            <span id='trussCaught' class='score-tally'>0</span>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('#pageNameTitle').text("Teleoperated")
    $('#nextPhaseButton').text('Finish');

    var highGoals = 0;
    var lowGoals = 0;
    var missedGoals = 0;

    var receivedAssists = 0;
    var passedAssists = 0;

    var trussThrows = 0;
    var trussCatches = 0;

    $("#receivedAdd").click(function() {
        update(receivedAssists, 'receivedTotal', false);
    });

    function add1(foo) {
        foo++; 
        return foo;
    }

    function update(variable, countId, subtract) {
        if (subtract) {
            if (variable > 0) {
                variable--;
            }
        } else {
            variable++;
        }
        
        //$("'#" + countId + "'").text(variable);
    }
</script>