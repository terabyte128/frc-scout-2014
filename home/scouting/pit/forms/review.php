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
        <button class="btn btn-lg btn-info submit-data" type="button" style="width: 250px;" onclick="updateDatabase(true);">Go to scouting home</button>
    </div>
    <div class="form-group">
        <button class="btn btn-lg btn-success submit-data" type="button" style="width: 250px;" onclick="updateDatabase(false);">Scout another team</button>
    </div>
    <br />
    <br />
    <div class="form-group">
        <button class="btn btn-lg btn-danger" type="button" style="width: 250px;" id="discardData">Discard this data</button>
    </div>

</form>

<script type="text/javascript">

            $('#pageNameTitle').text("Finish Scouting")
            //document.location.hash = "review";

            $("#discardData").click(function() {
                if (confirm("This will discard all the data for this scouting session! Are you sure you wish to continue?")) {
                    localStorage.discardedMatch = JSON.stringify(localStorage);
                    localStorage.clear();
                    loadPageWithMessage("/home", "Scouting data discarded.", "danger");
                }
            });

            function pushToLocalStorage() {
                changePhase("basic");
            }

            function pullFromLocalStorage() {
                //dummy function
            }

            function updateDatabase(goHome) {
                $(".submit-data").button('loading');
                $.ajax({
                    url: 'push-to-database.php',
                    type: "POST",
                    data: {
                        'teamData': JSON.stringify(localStorage)
                    },
                    success: function(response) {
                        if (response === "200 Success") {
                            localStorage.teamNumber = "";
                            localStorage.clear();
                            if (goHome) {
                                loadPageWithMessage("/", "Scouting data submitted.", "success");
                            } else {
                                $("#teamNumberTitle").text("");
                                window.location = "#basic";
                                loadPageWithMessage("#basic", "Scouting data submitted.", "success");
                            }
                        } else {
                            //showMessage(response, "danger");
                            showMessage("You must start scouting from the beginning. <a href='#basic' onclick='hideMessage();'>Go there.</a>", "danger");
                        }
                    }
                })
            }
</script>