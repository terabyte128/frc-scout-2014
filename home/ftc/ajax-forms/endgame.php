<div class="container">
    <div class="row">
        <div class="span4 offset4">
            <form role="form" onsubmit="submitData();
                    return false;">
                <h3 class="text-center">End Game</h3>
                <div class="btn-group" data-toggle="buttons" id="flagScore">
                    <label class="btn btn-success btn-lg" id="35">
                        <input type="radio" id="35">Flag High +35
                    </label>
                    <label class="btn btn-warning btn-lg" id="20">
                        <input type="radio" id="20">Flag Low +20
                    </label>
                    <label class="btn btn-danger btn-lg" id="0">
                        <input type="radio" id="0">No score
                    </label>
                </div>
                <span id="flagScore" style="display:none;">0</span>
                <br />
                <br /> 
                <div class="btn-group" data-toggle="buttons" id="hangScore">
                    <label class="btn btn-lg btn-success" id="50">
                        <input type="radio" id="50">Robot Hang +50
                    </label>
                    <label class="btn btn-lg btn-danger" id="0">
                        <input type="radio" id="0">No Hang
                    </label>
                </div>
                <p class="totalSize" id="hangScore" style="display:none;">0</p><br>
                <br />


                <div class="btn-group" data-toggle="buttons" id="balanced">
                    <label class="btn btn-primary btn-lg" id="false">
                        <input type="radio" name="options" id="false">Pendulum Unbalanced
                    </label>
                    <label class="btn btn-primary btn-lg" id="true">
                        <input type="radio" name="options" id="true">Pendulum Balanced
                    </label>
                </div>
                <br><br>
                <p><button class="btn btn-large fullButton btn-success">To Match Outcome</button></p>
            </form>
        </div>
    </div>

    <script>

                var flagScore = 0;
                var hangScore = 0; 
                var endgameScore = 0;
                var balanced = false;

                function submitData() {
                    $.ajax({
                        url: 'ajax-submit.php',
                        type: "POST",
                        data: {
                            'page': 'end',
                            'flagScore': $("#flagScore .active").attr("id"),
                            'hangScore': $("#hangScore .active").attr('id'),
                            'balanced': $("#balanced .active").attr('id')
                        },
                        success: function(response, textStatus, jqXHR) {
                            processResponse(response);
                        }
                    });
                }
               
                

//                $(document).ready(function() {
//
//                    // Variables to hold scores
//                    flagScore = 0;
//                    hangScore = 0;
//                    endgameScore = 0; // for display only - do not send to database
//
//                    // Variables to hold booleans
//                    balanced = false;
//
//                    //function calls to attach click listeners to buttons
//
//                    getPageScore('flagHigh', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 35);
//                    getPageScore('flagLow', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 20);
//                    getPageScore('flagNone', flagScore, 'flagScore', 'hangScore', 'endgameTotal', endgameScore, 0);
//
//                    getPageScore('hang', hangScore, 'hangScore', 'flagScore', 'endgameTotal', endgameScore, 50);
//                    getPageScore('noHang', hangScore, 'hangScore', 'flagScore', 'endgameTotal', endgameScore, 0);
//
//                    getBoolean('balanced', balanced, true);
//                    getBoolean('unbalanced', balanced, false);
//
//                    // A function that adds click listeners to the robot hang buttons
//                    function getBoolean(buttonID, boolVariable, boolVal) {
//                        $('#' + buttonID).click(function() {
//                            boolVariable = boolVal;
//                        })
//                    }
//                    ;
//
//                    function getPageScore(buttonID, buttonTotal, buttonTotalID, otherButtonGroupTotalID, pageTotalID, pageTotal, score) {
//                        $('#' + buttonID).click(function() {
//                            buttonTotal = score;
//                            pageTotal = parseInt($('#' + otherButtonGroupTotalID).text()) + score;
//                            $('#' + buttonTotalID).text(buttonTotal);
//                            $('#' + pageTotalID).text(pageTotal);
//                        }) // End click listener
//                    }
//                    ; // End getPageScore function
//                }); // End document.ready
    </script>
</div>