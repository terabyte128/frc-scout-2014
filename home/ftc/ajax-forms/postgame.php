<div class="container">
    <div class="row">
        <div class="span4 offset4">
            <h3 class="text-center">Post-Game</h3>
            <!--
            misc_dead_robot boolean,
            misc_match_outcome varchar (64),
            misc_minor_fouls int (64),
            misc_major_fouls int (64)
            misc_comments text
            -->
            <br />
            <button data-toggle="button" id="deadRobot" class="btn btn-danger">Dead Robot</button>
            <br /><br />
            <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                <label class="btn btn-success">
                    <input type="radio" name="options" id="option1">Win
                </label>
                <label class="btn btn-danger">
                    <input type="radio" name="options" id="option2">Lose
                </label>
                <label class="btn btn-warning">
                    <input type="radio" name="options" id="option3">Tie
                </label>
            </div>
            <br />
            <form role="form" class="align-center" style="max-width: 200px;">
                <br />
                <label for="majorFouls">Major fouls:</label>
                <input class="form-control" type="number" id="majorFouls" placeholder="major fouls">
                <br />
                <label for="minorFouls">Minor fouls:</label>
                <input class="form-control" type="number" id="minorFouls" placeholder="minor fouls">
                <br />
                <label for="comments">Comments:</label>
                <textarea class="form-control" height="4" id="comments" placeholder="comments"></textarea>
            </form>
            <br />
            <button class="btn btn-lg btn-success" onclick="submit()">Finish</button>
        </div>
    </div>

    <script>


        //variables to hold things
        var deadRobot = false;
        var matchOutcome = "Lose";
        var minorFouls = 0;
        var majorFouls = 0;
        var comments;
        
        function submit() {
            
            
            $.ajax({
                url: 'ajax-submit.php',
                type: "POST",
                data: {
                    'page': 'post',
                    'deadRobot': $("#deadRobot").hasClass("active"),
                    'matchOutcome': $("#matchOutcome .active").val(),
                    'minorFouls': $("#minorFouls").val(),
                    'majorFouls': $("#majorFouls").val(),
                    'comments': $("#comments").val()
                },
                success: function(response, textStatus, jqXHR) {
                    processResponse(response);
                }
            });
        }

    </script>
</div>