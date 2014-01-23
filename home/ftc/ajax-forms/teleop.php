<div class="container">
    <div class="row">
        <div class="span4 offset4">
            <form role="form" onsubmit="submitData();
                    return false;">
                <h3 class="text-center">Driver Controlled</h3>
                <h4 class="text-center">Record points for each goal</h4>

                <div class="btn-group" id="outerPendulum">
                    <button type="button" class="btn buttonGroupLeft btn-primary add" onclick="addOuter(false);">Outer Pendulum<br>+3</button>
                    <button type="button" class="btn buttonGroupRight btn-warning subtract" onclick="addOuter(true);">-</button>
                </div>
                <p class="totalSize" id="outerPendulumTotal">0</p>
                <br />
                <div class="btn-group" id="innerPendulum">
                    <button type="button" class="btn buttonGroupLeft btn-primary add" onclick="addInner(false);">Inner Pendulum<br>+2</button>
                    <button type="button" class="btn buttonGroupRight btn-warning subtract"onclick="addInner(true);">-</button>
                </div>
                <p class="totalSize" id="innerPendulumTotal">0</p>
                <br />
                <div class="btn-group" id="floorGoal">
                    <button type="button" class="btn buttonGroupLeft btn-primary add" onclick="addFloorGoal(false);">Floor Goal<br>+1</button>
                    <button type="button" class="btn buttonGroupRight btn-warning subtract" onclick="addFloorGoal(true);">-</button>
                </div>
                <p class="totalSize" id="floorGoalTotal">0</p>
                <br />
                <p class="textToButton">Total Points: <span class="totalSize" id="teleopTotal">0</span></p>
                <p></p>
                <div class="btn-group" data-toggle="buttons">
                    <button type="checkbox" class="btn buttonGroup2Full btn-primary" id="canBlock">Can block</button>
                </div><br><br>
                <div class="btn-group" data-toggle="buttons">
                    <button type="checkbox" class="btn buttonGroup2Full btn-primary" id="canPush">Can push</button>
                </div><br><br>
                <div class="btn-group" data-toggle="buttons">
                    <button type="checkbox" class="btn buttonGroup2Full btn-primary" id="unpushable">Unpushable</button>
                </div>
                <p></p>
                <div class="btn-group" data-toggle="buttons" id="robotSpeed">
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" id="slow">Slow
                    </label>
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" id="average">Average
                    </label>
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" id="fast">Fast
                    </label>
                </div>
                <p></p>
                <p class="text-center">Carrying Capacity</p>
                <div class="btn-group" data-toggle="buttons" id="robotCapacity">
                    <label class="btn btn-primary btn-lg" id="lessThan4">
                        <input type="radio" id="lessThan4">Less than 4
                    </label>
                    <label class="btn btn-primary btn-lg" id="4">
                        <input type="radio" id="exactly4">4 blocks
                    </label>
                    <label class="btn btn-primary btn-lg" id="moreThan4">
                        <input type="radio" id="moreThan4">More than 4
                    </label>
                </div>
                <p></p>
                <p><button class="btn btn-large fullButton btn-success">Continue To End Game</button></p>
                <br />
            </form>
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

                $("#canBlock").click(function() {
                    canBlock = !canBlock;
                });

                $("#canPush").click(function() {
                    canPush = !canPush;
                });

                $("#unpushable").click(function() {
                    unpushable = !unpushable;
                });

                function addInner(minus) {
                    if (minus && innerPendulum > 0) {
                        innerPendulum--;
                    } else if(!minus) {
                        innerPendulum++;
                    }
                    $("#innerPendulumTotal").text(innerPendulum);
                    updateTotal();
                }

                function addOuter(minus) {
                    if (minus && outerPendulum > 0) {
                        outerPendulum--;
                    } else if(!minus) {
                        outerPendulum++;
                    }
                    $("#outerPendulumTotal").text(outerPendulum);
                    updateTotal();
                }

                function addFloorGoal(minus) {
                    if (minus) {
                        floorGoal--;
                    } else {
                        floorGoal++;
                    }
                    $("#floorGoalTotal").text(floorGoal);
                    updateTotal();
                }
                
                function updateTotal() {
                    $("#teleopTotal").text(outerPendulum * 3 + innerPendulum * 2 + floorGoal);
                }

                function submitData() {
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
                            'robotSpeed': $("#robotSpeed .active").text().trim(),
                            'robotCapacity': $("#robotCapacity .active").attr("id")
                        },
                        success: function(response, textStatus, jqXHR) {
                            processResponse(response);
                        }
                    });
                }

    </script>
</div>