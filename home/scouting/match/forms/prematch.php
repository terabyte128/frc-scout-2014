<form class="scouting-form">
    <label for="teamNumber">Team number:</label>
    <input type="number" class="form-control" placeholder="Team number" id="teamNumber" onblur="updateTeamNumber($('#teamNumber').val());">
    <br />
    <label for="matchNumber">Match number:</label>
    <input type="number" class="form-control" placeholder="Match number" id="matchNumber">
    <br />
    <label for='selectAlliance'>Alliance color:</label>
    <br />
    <div class="btn-group" data-toggle="buttons" id='selectAlliance'>
        <label class="btn btn-danger btn-lg" onclick="updateAlliance('red');" style="width: 100px;" id="red">
            <input type="radio" name="options">Red
        </label>
        <label class="btn btn-blue-selection btn-lg" onclick="updateAlliance('blue');" style="width: 100px;" id="blue">
            <input type="radio" name="options">Blue
        </label>
    </div>
    <br /><br/> 
    <button id="absentButton" class="btn btn-lg btn-warning next-page-button" type="button" onclick="showAbsentModal();">Team Absent</button>
</form>

<!-- Modal -->
<form role="form" onsubmit="cancel();
            return false;">
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 16px;">
                    Marking this team as absent will terminate this scouting session. Are you sure?
                    <br /><br/> 
                    <textarea class="form-control" placeholder="Please leave a comment." rows="4" id="absentComments" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-warning btn-lg">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">

        var allianceColor = "";
        var borderColor = "";
        var teamPresent = true;

        $(function() {
            $('#pageNameTitle').text("Pre-Match Information")
            //document.location.hash = "prematch";
        });

        function updateAlliance(color) {

            if (color === "red") {
                borderColor = "#d2322d";
            } else {
                borderColor = "rgb(0, 82, 255)";
            }

            $(".container").css({
                'border-top': '5px solid ' + borderColor,
                'border-bottom': '5px solid ' + borderColor
            });


            $("#movedToAllianceZone").css({
                'background-color': borderColor
            });

            allianceColor = color;
        }

        function updatePresent() {
            teamPresent = !teamPresent;
        }

        function pullFromLocalStorage() {
            $("#teamNumber").val(localStorage.teamNumber);
            $("#matchNumber").val(localStorage.matchNumber);

            if (localStorage.allianceColor !== undefined && localStorage.allianceColor !== "undefined") {
                allianceColor = localStorage.allianceColor;
            }

            if (allianceColor !== null) {
                $("#" + allianceColor).addClass('active');
            }
        }

        function pushToLocalStorage() {
            var errorMessage = "";
            var errors = false;
            var teamNumber = $("#teamNumber").val();
            var matchNumber = $("#matchNumber").val();

            if (teamNumber === "") {
                errorMessage += "&bull; Enter a team number.<br />";
                errors = true;
            }
            if (matchNumber === "") {
                errorMessage += "&bull; Enter a match number.<br />";
                errors = true;
            }

            if (allianceColor === "") {
                errorMessage += "&bull; Select an alliance color.";
                errors = true;
            }

            if (!errors) {
                localStorage.teamPresent = teamPresent;
                localStorage.allianceColorId = borderColor;
                localStorage.allianceColor = allianceColor;
                localStorage.teamNumber = $("#teamNumber").val();
                localStorage.matchNumber = $("#matchNumber").val();
                hideMessage();
                //nextPhase();
                changePhase("autonomous");
            } else {
                showMessage("Please correct the following errors:<br />" + errorMessage, "danger");
            }
        }

        function showAbsentModal() {
            var errorMessage = "";
            var errors = false;
            var teamNumber = $("#teamNumber").val();
            var matchNumber = $("#matchNumber").val();

            if (teamNumber === "") {
                errorMessage += "&bull; Enter a team number.<br />";
                errors = true;
            }

            if (matchNumber === "") {
                errorMessage += "&bull; Enter a match number.<br />";
                errors = true;
            }

            if (!errors) {
                $("#cancelModal").modal('toggle');
                hideMessage();
            } else {
                showMessage("Please correct the following errors:<br />" + errorMessage, "danger");
            }
        }

        function updateTeamNumber(teamNumber) {
            $('#teamNumberTitle').text(": " + teamNumber);
        }

        function cancel() {
            var teamNumber = $("#teamNumber").val();
            var matchNumber = $("#matchNumber").val();

            var absentComments = $("#absentComments").val();
            $.ajax({
                url: 'push-absence-to-database.php',
                type: "POST",
                data: {
                    'teamNumber': teamNumber,
                    'matchNumber': matchNumber,
                    'absentComments': absentComments
                },
                success: function(response) {
                    localStorage.clear();
                    if (response.indexOf("Success") !== -1) {
                        loadPageWithMessage("/", "Team marked as absent.", "warning");
                    } else {
                        showMessage("Unable to add values to database.", "danger");
                    }
                }
            })
        }

</script>