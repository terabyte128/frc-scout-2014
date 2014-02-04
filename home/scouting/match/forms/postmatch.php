<form id="postmatch" role="form" class="scouting-form">
    <div>
        <button data-toggle="button" class="btn btn-lg btn-danger" id="diedDuringMatch" style="width: 200px;">Died During Match</button>
    </div>
    <br />
    <div>
        <button data-toggle="button" class="btn btn-lg btn-warning" id="causedFouls" style="width: 200px;">Caused Fouls</button>
    </div>
    <div class="form-group" id='foulCommentsWrapper' style='display: none;'>
        <br />
        <textarea class='form-control' placeholder="Please comment on fouls caused." rows='6' id='foulComments'></textarea>
    </div>

    <div class='form-group'>
        <br />
        <textarea class='form-control' placeholder='Miscellaneous comments.' rows='6' id="miscComments"></textarea>
    </div>
</form>
<script type="text/javascript">

    var diedDuringMatch = false;
    var causedFouls = false;

    $("button").click(function() {
        switch (this.id) {
            case "diedDuringMatch":
                diedDuringMatch = !diedDuringMatch;
                break;
            case "causedFouls":
                causedFouls = !causedFouls;
                break;
            default:
                break;

        }
    });



    $('#pageNameTitle').text("Post-Game")

    $("#causedFouls").click(function() {
        $("#foulCommentsWrapper").slideToggle(200);
    });

    function pushToLocalStorage() {
        var foulComments = $("#foulComments").val();
        var miscComments = $("#miscComments").val();

        hideMessage();
        localStorage.diedDuringMatch = diedDuringMatch;
        localStorage.causedFouls = causedFouls;
        localStorage.foulComments = foulComments;
        localStorage.miscComments = miscComments;
        nextPhase();

    }
</script>