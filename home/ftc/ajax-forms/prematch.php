<div class="container" align="center">
    <h2 align="center"> Pre-Match Information </h2>
    <br>
    <form role="form" class="align-center" style="max-width: 300px;" onsubmit="submitData(); return false;">
        <div class="form-group">
            <label align="center"> Scouted Team Number: </label>
            <input type="number" class="form-control" placeholder="Team Number" id="scoutedTeam" required>
        </div>
        <div class="form-group">
            <label align="center"> Match Number: </label>
            <input type="number" class="form-control" placeholder="Match Number" id="matchNumber" required>
        </div>
        <br />
        <button id="toAuto" class="btn btn-default btn-success">Continue to autonomous</button>
    </form>
</div>

<script type="text/javascript">
        function submitData() {
            $("#toAuto").button('loading');
            $.ajax({
                url: 'ajax-submit.php',
                type: "POST",
                data: {
                    'page': 'pre',
                    'scoutedTeamNumber': $("#scoutedTeam").val(),
                    'matchNumber': $("#matchNumber").val()
                },
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                    processResponse(response);
                    $("#toAuto").button('reset');
                }
            });
        }



</script>