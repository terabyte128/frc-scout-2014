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
        <textarea class='form-control' placeholder='Miscellaneous comments.' rows='6'></textarea>
    </div>
</form>
<script type="text/javascript">
    $('#pageNameTitle').text("Post-Game")
    $('#nextPhaseButton').text('Review Match');


    $("#causedFouls").click(function() {
        $("#foulCommentsWrapper").slideToggle(200);
        $("#foulComments")
    });
9
</script>