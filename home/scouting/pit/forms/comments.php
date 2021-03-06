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
    <!--
    <a href="#" onclick="$('#photoUpload').slideToggle(200); return false;"><strong>Upload a photo</strong></a>
    -->
</form>
<!--
<div style="display: none; margin-top: 5px;" id="photoUpload">
    <form class="scouting-form" action="/uploads/uploader.php" method="post" enctype="multipart/form-data">
        <input class="btn btn-info" type="file" id="robotPhoto">
        <br />
        <button type="submit" class="btn btn-default" style="width: 75%;">Submit</button>
    </form>
</div>
-->

<script type="text/javascript">

    $(function() {
        $('#pageNameTitle').text("Comments");
        //document.location.hash = "prematch";
    });

    function pullFromLocalStorage() {
        $("#strength").val(localStorage.strength);
        $("#problems").val(localStorage.problems);
        $("#comments").val(localStorage.comments);
        updateTeamNumber(localStorage.teamNumber);
    }

    function updateTeamNumber(teamNumber) {
        if (teamNumber !== "") {
            $('#teamNumberTitle').text(": " + teamNumber);
        }
    }

    function pushToLocalStorage() {
        localStorage.strength = $("#strength").val();
        localStorage.problems = $("#problems").val();
        localStorage.comments = $("#comments").val();
        hideMessage();
        //nextPhase();
        changePhase("review");
    }

</script>