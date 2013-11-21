<div class="container" align="center">
    <h2 align="center"> Pre-Match Information </h2>
    <br>
    <form>
        <fieldset>
            <label align="center"> Scouted Team Number: </label>
            <input type="text" class="full" placeholder="Team Number" id="scoutedTeam">
            <br><br><label align="center"> Match Number: </label>
            <input type="text" class="full" placeholder="Match Number" id="matchNumber">
        </fieldset>
        <br><br> 
        <div class="btn-group">
            <button class="btn btn-danger btn-small half" type="button"> Red Alliance </button>
            <button class="btn btn-primary btn-small half" type="button"> Blue Alliance </button>
        </div>
        <br><br><br><br>
        <a class="btn btn-success full" href="#" type="button" id="toAuto"> Continue to Autonomous </a>
    </form>

    <script>
        var scoutedTeam, matchNumber;
        $(document).ready(function() {

            function myValue(theButton, theValue) {
                return $(theButton).click(function() {
                    $(theValue).val()
                });
            }

            scoutedTeam = myValue('#toAuto', '#scoutedTeam');
            matchNumber = myValue('#toAuto', '#matchNumber');
        });

        function submit() {
            $.ajax({
                url: 'ajax-submit.php',
                type: "POST",
                data: {
                    'page' : 'pre',
                    'scoutedTeamNumber': scoutedTeam,
                    'matchNumber': matchNumber
                },
                success: function(response, textStatus, jqXHR) {
                    processResponse(response);
                }
            });
        }

    </script>
</div>