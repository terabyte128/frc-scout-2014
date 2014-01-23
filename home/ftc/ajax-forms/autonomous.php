<?php require_once '../../../includes/setup-session.php'; ?>

<div class="container">
    <div class="span4 offset4">
        <h3 class="text-center">Autonomous</h3>
        <form role="form" onsubmit="submitData();
                return false;">
            <h4 class="text-center">Record points for each goal</h4>
<!--            <p><button class="btn btn-large fullButton btn-primary" data-toggle="button">Can delay start?</button></p>-->
            <div class="btn-group">
                <button type="button" class="btn buttonGroupLeft btn-primary" id="addIrBeacon">IR Beacon<br>+40</button>
                <button type="button" class="btn buttonGroupRight btn-warning" id="removeIrBeacon"><i class="icon-minus-sign icon-white"></i></button>
            </div>
            <p class="totalSize" id="irBeaconTotal">0</p>
            <br />
            <div class="btn-group">
                <button type="button" class="btn buttonGroupLeft btn-primary" id="addPendulum">Non-Beacon Pendulum Goal<br>+20</button>
                <button type="button" class="btn buttonGroupRight btn-warning"id="removePendulum">-</button>
            </div>
            <p class="totalSize" id="pendulumTotal">0</p>
            <br />
            <div class="btn-group">
                <button type="button" class="btn buttonGroupLeft btn-primary"id="addFloor">Floor Goal<br>+5</button>
                <button type="button" class="btn buttonGroupRight btn-warning"id="removeFloor">-</button>
            </div>
            <p class="totalSize" id="floorTotal">0</p>
            <br /><br />
            <p>Robot On Bridge</p>
            <div class="btn-group" data-toggle="buttons" id="robotOnBridge">
                <label class="btn btn-primary btn-lg">
                    <input type="radio" id="no">No
                </label>
                <label class="btn btn-primary btn-lg">
                    <input type="radio" id="partially">Partially
                </label>
                <label class="btn btn-primary btn-lg">
                    <input type="radio" id="completely">Completely
                </label>
            </div><br />
            <p class="textToButton">Total Points:</p>
            <p class="totalSize" id="totalPoints">0</p>
            <p></p>
            <div class="btn-group" data-toggle="buttons">
                <button type="checkbox" class="btn buttonGroup2Full btn-primary" id="blockScoreAssist">Block Score Assist</button>
            </div>            
            <div class="btn-group" data-toggle="buttons">
                <button type="checkbox" class="btn buttonGroup2Full btn-primary" id="rampAssist">Ramp Assist</button>
            </div>
    </div>
    <p></p>
    <p><button class="btn btn-large fullButton btn-success">Continue to Driver Controlled</button>
        <br />
        </form>
</div>
<script type="text/javascript">
            var irBeaconGoal = 0;
            var pendulumGoal = 0;
            var floorGoal = 0;
            var robotOnBridge = "No";
            var blockScoreAssist = false;
            var rampAssist = false;

            function submitData() {
                $.ajax({
                    url: 'ajax-submit.php',
                    type: "POST",
                    data: {
                        'page': 'auto',
                        'irBeaconGoal': irBeaconGoal,
                        'pendulumGoal': pendulumGoal,
                        'floorGoal': floorGoal,
                        'robotOnBridge': $("#robotOnBridge .active").text().trim(),
                        'blockScoreAssist': blockScoreAssist,
                        'rampAssist': rampAssist
                    },
                    success: function(response, textStatus, jqXHR) {
                        processResponse(response);
                    }
                });
            }

            $("#blockScoreAssist").click(function() {
                blockScoreAssist = !blockScoreAssist;
            });

            $("#rampAssist").click(function() {
                rampAssist = !rampAssist;
            });

            $(function() {
                $("#addIrBeacon").click(function() {
                    irBeaconGoal++;
                    $("#irBeaconTotal").text(irBeaconGoal);
                    updateTotals();
                });
            });

            $(function() {
                $("#removeIrBeacon").click(function() {
                    if (irBeaconGoal > 0) {
                        irBeaconGoal--;
                        $("#irBeaconTotal").text(irBeaconGoal);
                        updateTotals();
                    }
                });
            });

            $(function() {
                $("#addPendulum").click(function() {
                    pendulumGoal++;
                    $("#pendulumTotal").text(pendulumGoal);
                    updateTotals();
                });
            });

            $(function() {
                $("#removePendulum").click(function() {
                    if (pendulumGoal > 0) {
                        pendulumGoal--;
                        $("#pendulumTotal").text(pendulumGoal);
                        updateTotals();
                    }
                });
            });

            $(function() {
                $("#addFloor").click(function() {
                    floorGoal++;
                    $("#floorTotal").text(floorGoal);
                    updateTotals();
                });
            });

            $(function() {
                $("#removeFloor").click(function() {
                    if (floorGoal > 0) {
                        floorGoal--;
                        $("#floorTotal").text(floorGoal);
                        updateTotals();
                    }
                });
            });

            function updateTotals() {
                $("#totalPoints").text(irBeaconGoal * 40 + pendulumGoal * 20 + floorGoal * 5);
            }

</script>
</div>

