<form class="scouting-form">
    <label for="strength">Robot's biggest strength:</label>
    <textarea class="form-control" placeholder="Biggest strength" rows="3" id="strength"></textarea>
    <br />
    <label for="problems">Known problems:</label>
    <textarea class="form-control" placeholder="Known problems" rows="3" id="problems"></textarea>
    <br />
    <label for="comments">General comments:</label>
    <textarea class="form-control" placeholder="General comments" rows="6" id="comments"></textarea>
    <br />
</form>

<script type="text/javascript">
    
    $(function() {
        $('#pageNameTitle').text("Comments");
        //document.location.hash = "prematch";
    });

    function pullFromLocalStorage() {
        $("#strength").val(localStorage.strength);
        $("#problems").val(localStorage.problems);
        $("#comments").val(localStorage.comments);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "") {
            $('#teamNumberTitle').text(": " + teamNumber);
        }
    }

    function pushToLocalStorage() {
        localStorage.strength = $("#robotWeight").val();
        localStorage.problems = $("#robotHeight").val();
        localStorage.comments = $("#comments").val();
        hideMessage();
        //nextPhase();
        changePhase("review");
    }

</script>