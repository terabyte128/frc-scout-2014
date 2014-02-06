<form id="postmatch" role="form" class="scouting-form">
    <label for="matchOutcome">Match Outcome</label>
    <div class="form-group">
        <div class="btn-group" data-toggle="buttons" id="matchOutcome">
            <label class="btn btn-success btn-lg" style="width: 67px;" id="win">
                <input type="radio">Win
            </label>
            <label class="btn btn-danger btn-lg" style="width: 67px;" id="lose">
                <input type="radio">Lose
            </label>
            <label class="btn btn-warning btn-lg" style="width: 67px;" id="tie">
                <input type="radio">Tie
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="matchPoints">Total Match Points
            <input type="number" class="form-control" id="matchPoints" style="width: 200px;">
        </label>
    </div>
    <div class="form-group">
        <button data-toggle="button" class="btn btn-lg btn-danger" id="diedDuringMatch" style="width: 200px;">Died During Match</button>
    </div>
    <div class="form-group">
        <button data-toggle="button" class="btn btn-lg btn-warning" id="causedFouls" style="width: 200px;">Caused Fouls</button>
    </div>
    <div class="form-group" id='foulCommentsWrapper' style='display: none;'>
        <textarea class='form-control' placeholder="Please comment on fouls caused." rows='6' id='foulComments'></textarea>
    </div>
    <div class='form-group'>
        <textarea class='form-control' placeholder='Miscellaneous comments.' rows='6' id="miscComments"></textarea>
    </div>
</form>
<script type="text/javascript">

    var diedDuringMatch = false;
    var causedFouls = false;
    var matchOutcome = undefined;
    //document.location.hash = "postmatch";


    $("button").click(function() {
        switch (this.id) {
            case "diedDuringMatch":
                diedDuringMatch = !diedDuringMatch;
                break;
            case "causedFouls":
                causedFouls = !causedFouls;
                break;
        }
    });

    $("label").click(function() {
        switch (this.id) {
            case "win":
                matchOutcome = 0;
                break;
            case "lose":
                matchOutcome = 1;
                break;
            case "tie":
                matchOutcome = 2;
                break;
        }
    })


    $('#pageNameTitle').text("Post-Game")

    $("#causedFouls").click(function() {
        $("#foulCommentsWrapper").slideToggle(200);
    });

    function pushToLocalStorage() {

        var errorMessage = "";

        var matchPoints = $("#matchPoints").val();

        if (matchOutcome === undefined) {
            errorMessage += "&bull; Select a match outcome.<br />";
        }
        if (matchPoints === "") {
            errorMessage += "&bull; Enter total match points.<br />";
        }

        if (errorMessage !== "") {
            showMessage("Please correct the following errors:<br />" + errorMessage, "danger");
        } else {
            var foulComments = $("#foulComments").val();
            var miscComments = $("#miscComments").val();

            hideMessage();
            localStorage.diedDuringMatch = diedDuringMatch;
            localStorage.causedFouls = causedFouls;
            localStorage.foulComments = foulComments;
            localStorage.miscComments = miscComments;
            nextPhase();
        }
    }
</script>