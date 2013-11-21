<div class="container">
    <div class="row">
        <div class="span4 offset4">
            <h3 class="text-center">End Game: 7462</h3>
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn buttonGroupFull btn-primary" id="flagHigh">Flag High<br>+35</button>
                <button type="button" class="btn buttonGroupFull btn-primary" id="flagLow">Flag Low<br>+20</button>
                <button type="button" class="btn buttonGroupFull btn-warning" id="flagNone">No Flag<br>Score</button>
            </div>
            <span id="flagScore" style="display:none;">0</span>


            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn buttonGroupLeft btn-primary" id="hang">Robot Hang<br>+50</button>
                <button class="btn buttonGroupRight btn-warning" id="noHang">No Hang<br>0</button>
            </div>
            <p class="totalSize" id="hangScore" style="display:none;">0</p><br>

            <p>Page Total: <span id="endgameTotal">0</span></p><br>
            

            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn buttonGroupLeft btn-primary" id="balanced">Pendulum is<br>Balanced</button>
                <button class="btn buttonGroupRight btn-warning" id="unbalanced">Pendulum is<br>Not Balanced</button>
            </div>
            <br><br>
            <p><button class="btn btn-large fullButton btn-success" type="button">To Match Outcome</button></p>
        </div>
    </div>

    <script>

    $(document).ready(function(){

        // Variables to hold scores
        var flagScore = 0;
        var hangScore = 0;
        var endgameScore  = 0; // for display only - do not send to database

        // Variables to hold booleans
        var balanced = false;

        //funciton calls to attach click listeners to buttons

        getPageScore('flagHigh', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 35);
        getPageScore('flagLow', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 20);
        getPageScore('flagNone', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 0);

        getPageScore('hang', hangScore, 'hangScore', 'flagScore', 'endgameTotal', endgameScore, 50);
        getPageScore('noHang', hangScore, 'hangScore', 'flagScore', 'endgameTotal', endgameScore, 0);

        getBoolean('balanced', balanced, true);
        getBoolean('unbalanced', balanced, false);

        // A function that adds click listeners to the robot hang buttons
        function getBoolean(buttonID, boolVariable, boolVal) {
            $('#' + buttonID).click(function() {
                boolVariable = boolVal;
            })
        };

        function getPageScore(buttonID, buttonTotal, buttonTotalID, otherButtonGroupTotalID, pageTotalID, pageTotal, score) {
            $('#' + buttonID).click(function() {
                buttonTotal = score;
                pageTotal = parseInt( $('#' + otherButtonGroupTotalID).text() ) + score;
                $('#' + buttonTotalID).text(buttonTotal);
                $('#' + pageTotalID).text(pageTotal);
            }) // End click listener
        }; // End getPageScore function
    }); // End document.ready
    </script>
</div>