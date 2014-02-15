<form class="scouting-form">
    <label for="startPosition">Autonomous start position:</label>
    <input type="text" class="form-control" placeholder="Autonomous start position" id="startPosition" />
    <span class="typeahead-hint">anywhere | goalie zone | center | side | left | right</span><br />
    <br />
    <label for="role">Robot role:</label>
    <input type="text" class="form-control" placeholder="Robot role" id="role" />
    <span class="typeahead-hint">shooter | passer | blocker | goalie | thrower | catcher<br />offense | defense | balanced</span><br />
    <br />
    <label for="canCollect">Robot abilities:</label>
    <button data-toggle="button" class="btn btn-lg btn-warning btn-no-border" id="canCollect" style='margin-top: 10px; width: 250px;'>Can collect ball</button>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-primary btn-no-border" id="canPass" style='margin-top: 10px; width: 250px;'>Can eject ball (pass)</button>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-info btn-no-border" id="canHighGoal" style='margin-top: 10px; width: 250px;'>Can shoot to high goal</button>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-default btn-no-border" id="canThrow" style='margin-top: 10px; width: 250px;'>Can throw over truss</button>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-default btn-no-border" id="canCatch" style='margin-top: 10px; width: 250px;'>Can catch from truss</button>
    <br />
    <button data-toggle="button" class="btn btn-lg btn-danger btn-no-border" id="canBlock" style='margin-top: 10px; width: 250px;'>Can block shots</button>
    <br /><br />
</form>

<script type="text/javascript">

    var canCollect = false;
    var canThrow = false;
    var canCatch = false;
    var canPass = false;
    var canHighGoal = false;
    var canBlock = false;

    $(function() {
        $('#pageNameTitle').text("Strategic Information");
        $('#startPosition').typeahead({
            'local': ['Goalie zone', 'Left', 'Center', 'Right', 'Anywhere', 'Side']
        });
        $('#role').typeahead({
            'local': ['Offense', 'Defense', 'Shooter', 'Passer', 'Blocker', 'Goalie', 'Thrower', 'Catcher', 'Balanced']
        });
        //document.location.hash = "prematch";
    });

    $("#canCollect").click(function() {
        canCollect = !canCollect;
    });
    $("#canPass").click(function() {
        canPass = !canPass;
    });
    $("#canThrow").click(function() {
        canThrow = !canThrow;
    });
    $("#canCatch").click(function() {
        canCatch = !canCatch;
    });
    $("#canHighGoal").click(function() {
        canHighGoal = !canHighGoal;
    });
    $("#canBlock").click(function() {
        canBlock = !canBlock;
    });

    function pullFromLocalStorage() {
        $('#startPosition').val(localStorage.startPosition);
        $('#role').val(localStorage.role);
        if (localStorage.canCollect === "true") {
            $("#canCollect").addClass("active");
            canCollect = !canCollect;
        }
        if (localStorage.canPass === "true") {
            $("#canPass").addClass("active");
            canPass = !canPass;
        }
        if (localStorage.canThrow === "true") {
            $("#canThrow").addClass("active");
            canThrow = !canThrow;
        }
        if (localStorage.canCatch === "true") {
            $("#canCatch").addClass("active");
            canCatch = !canCatch;
        }
        if (localStorage.canHighGoal === "true") {
            $("#canHighGoal").addClass("active");
            canHighGoal = !canHighGoal;
        }
        if (localStorage.canBlock === "true") {
            $("#canBlock").addClass("active");
            canBlock = !canBlock;
        }
        updateTeamNumber(localStorage.teamNumber);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "") {
            $('#teamNumberTitle').text(": " + teamNumber);
        }
    }

    function pushToLocalStorage() {
        localStorage.startPosition = $('#startPosition').val();
        localStorage.role = $('#role').val();
        localStorage.canCollect = canCollect;
        localStorage.canPass = canPass;
        localStorage.canThrow = canThrow;
        localStorage.canCatch = canCatch;
        localStorage.canHighGoal = canHighGoal;
        localStorage.canBlock = canBlock;
        hideMessage();
        //nextPhase();
        changePhase("comments");
    }

</script>