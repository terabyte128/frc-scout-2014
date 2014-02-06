<form id="review" class="scouting-form">
    <!-- 
    <label for="teamNumber">Team Number:
        <a href="#" id="teamNumber" class="editable"></a>
    </label>
    <br/> 
    <label for="teamNumber">Match Number:
        <a href="#" id="matchNumber" class="editable"></a>
    </label>
    <label for="allianceColor">
        
    </label>
    -->

    <label>Submit data to the database and:</label>
    <div class="form-group">
        <button class="btn btn-lg btn-info" type="button" style="width: 250px;">Go to scouting home</button>
    </div>
    <div class="form-group">
        <button class="btn btn-lg btn-success" type="button" style="width: 250px;">Scout another match</button>
    </div>
    <br />
    <br />
    <div class="form-group">
        <button class="btn btn-lg btn-danger" type="button" style="width: 250px;">Discard this data</button>
    </div>

</form>

<script type="text/javascript">

    $('#pageNameTitle').text("Finish Scouting")
    document.location.hash = "review";
    $("#nextPhaseButtonContainer").hide();

    /*
     $("#teamNumber").text(localStorage.teamNumber);
     $("#matchNumber").text(localStorage.matchNumber);
     $(".editable").editable({
     type: 'number',
     success: function(response, newValue) {
     switch (this.id) {
     case "teamNumber":
     localStorage.teamNumber = newValue;
     break;
     case "matchNumber":
     localStorage.matchNumber = newValue;
     break;
     }
     }
     });
     */

    function pushToLocalStorage() {
        nextPhase();
    }
</script>