<div class="container">
    <div class="row">
        <div class="span4 offset4">
            <h3 class="text-center">Driver Controlled</h3>
            <h4 class="text-center">Record points for each goal</h4>

            <div class="btn-group" id="outerPendulum">
                <button class="btn buttonGroupLeft btn-primary add">Outer Pendulum<br>+3</button>
                <button class="btn buttonGroupRight btn-warning subtract">-</button>
            </div>
            <p class="totalSize" id="outerPendulumTotal">0</p>
            <br />
            <div class="btn-group" id="innerPendulum">
                <button class="btn buttonGroupLeft btn-primary add">Inner Pendulum<br>+2</button>
                <button class="btn buttonGroupRight btn-warning subtract">-</button>
            </div>
            <p class="totalSize" id="innerPendulumTotal">0</p>
            <br />
            <div class="btn-group" id="floorGoal">
                <button class="btn buttonGroupLeft btn-primary add">Floor Goal<br>+1</button>
                <button class="btn buttonGroupRight btn-warning subtract">-</button>
            </div>
            <p class="totalSize" id="floorGoalTotal">0</p>
            <br />
            <p class="textToButton">Total Points: <span class="totalSize" id="teleopTotal">0</span></p>
            <p></p>
            <div class="btn-group" data-toggle="buttons">
                <button type="button" class="btn buttonGroupFull btn-primary" id="canBlock">Can Block</button>
                <button type="button" class="btn buttonGroupFull btn-primary" id="canPush">Can Push</button>
                <button type="button" class="btn buttonGroupFull btn-primary" id="unpushable">Un-Pushable</button>
            </div>
            <p></p>
            <div class="btn-group">
                <button type="radio" class="btn buttonGroupFull btn-primary" id="slow">Slow</button>
                <button type="radio" class="btn buttonGroupFull btn-primary" id="average">Average</button>
                <button type="radio" class="btn buttonGroupFull btn-primary" id="fast">Fast</button>
            </div>
            <p></p>
            <p class="text-center">Carrying Capacity</p>
            <div class="btn-group">
                <button type="radio" class="btn buttonGroupFull btn-primary" id="under4">Less Blocks</button>
                <button type="radio" class="btn buttonGroupFull btn-primary" id="exactly4">4 Blocks</button>
                <button type="radio" class="btn buttonGroupFull btn-primary" id="over4">More Blocks</button>
            </div>
            <p></p>
            <p><button class="btn btn-large fullButton btn-success" type="button" onclick="submit()">Continue To End Game</button></p>
            <br />
        </div>
    </div>

    <script>

        // Variables to hold scores
        var outerPendulum = 0;
        var innerPendulum = 0;
        var floorGoal = 0;
        var teleopTotal = 0;

        // Variables to hold boolean values
        var canBlock = false;
        var canPush = false;
        var unpushable = false;

        // Variables to hold strings
        var robotSpeed = '';
        var blockCapacity = '';


        function submit() {
            $.ajax({
                url: 'ajax-submit.php',
                type: "POST",
                data: {
                    'page': 'tele',
                    'outerPendulum': outerPendulum,
                    'innerPendulum': innerPendulum,
                    'floorGoal': floorGoal,
                    'canBlock': canBlock,
                    'canPush': canPush,
                    'unpushable': unpushable,
                    'robotSpeed' : robotSpeed,
                    'blockCapacity' : blockCapacity
                },
                success: function(response, textStatus, jqXHR) {
                    processResponse(response);
                }
            });
        }


        $(document).ready(function() {
            // Function calls to attach click listeners
            addScore('outerPendulum', outerPendulum, 'teleopTotal', teleopTotal, 3);
            addScore('innerPendulum', innerPendulum, 'teleopTotal', teleopTotal, 2);
            addScore('floorGoal', floorGoal, 'teleopTotal', teleopTotal, 1);

            getBoolean('canBlock', canBlock);
            getBoolean('canPush', canPush);
            getBoolean('unpushable', unpushable);

            getString('slow', robotSpeed);
            getString('average', robotSpeed);
            getString('fast', robotSpeed);

            getString('under4', blockCapacity);
            getString('exactly4', blockCapacity);
            getString('over4', blockCapacity);



            // A function that adds click listeners to buttons that return strings
            function getString(buttonID, stringVariable) {
                $('#' + buttonID).click(function() {
                    stringVariable = buttonID;
                });
            }
            ;


            // A function that adds click listeners to the boolean buttons
            function getBoolean(buttonID, boolValue) {
                $('#' + buttonID).click(function() {
                    boolValue = true;
                })
            }
            ;


            // A function that adds click listeners to the adder and subtractor for each
            // button group that represents a scoring opportunity
            function addScore(buttonGroupID, buttonGroupTotal, pageTotalID, pageTotal, points) {
                $('#' + buttonGroupID + ' .add').click(function() {
                    buttonGroupTotal++;
                    pageTotal = parseInt($('#' + pageTotalID).text()) + points;
                    $('#' + buttonGroupID + 'Total').text(buttonGroupTotal);
                    $('#' + pageTotalID).text(pageTotal);
                });

                $('#' + buttonGroupID + ' .subtract').click(function() {
                    if (buttonGroupTotal > 0) {
                        buttonGroupTotal--;
                        pageTotal = parseInt($('#' + pageTotalID).text()) - points;
                        $('#' + buttonGroupID + 'Total').text(buttonGroupTotal);
                        $('#' + pageTotalID).text(pageTotal);
                    }
                });
            }
            ;

        }) // end document.ready function
    </script>
</div>