<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <title>Compare Alliances</title>
    </head>
    <body>
        <style type="text/css">
            .btn-editable {
                border: 1px solid #ccc;
                width: 100px;
                margin: 2px 0px 2px 0px;
                color: white;
                cursor: text;
            }
            .btn-blue-selection {
                background-color: rgb(0, 82, 255); 
                border-color: rgb(0, 82, 255);
                color: white;
            }
            .red {
                color: #d2322d;
            }
            .blue {
                color: rgb(0, 82, 255);
            }
        </style>
        <div class="wrapper">
            <div class="container" style="border-left: 5px solid #d2322d; border-right: 5px solid rgb(0, 82, 255);">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php' ?>
                <h2>Compare Alliances</h2>
                <div style="display: inline; padding-left: auto; padding-right: auto;" id="selectAlliances">
                    <label>Select buttons to enter team numbers</label>
                    <br />
                    <div style="display: inline-table;">
                        <div style="display: table-row;">
                            <div style="display: table-cell;">
                                <input id="red1" placeholder="#1" type="number" class="btn-editable btn-danger btn-lg">
                                <br />
                                <input id="red2" placeholder="#2" type="number" class="btn-editable btn-danger btn-lg">
                                <br />
                                <input id="red3" placeholder="#3" type="number" class="btn-editable btn-danger btn-lg">
                                <br />
                            </div>
                            <div style="display: table-cell; padding-left: 15px; padding-right: 15px; vertical-align: middle; line-height: 10px;">
                                <p style="font-size: 50px;">vs</p>
                            </div>
                            <div style="display: table-cell;">
                                <input id="blue1" placeholder="#1" type="text" class="btn-editable btn-blue-selection btn-lg">
                                <br />
                                <input id="blue2" placeholder="#2" type="text" class="btn-editable btn-blue-selection btn-lg">
                                <br />
                                <input id="blue3" placeholder="#3" type="text" class="btn-editable btn-blue-selection btn-lg">
                                <br />
                            </div>
                        </div>
                        <br />


                    </div>
                    <div>
                        <button data-toggle="button" class="btn btn-lg btn-default" id="onlyHere" style="width: 278px;">Only <?php echo $location ?></button><br /><br />
                        <button id="compareButton" class="btn btn-lg btn-success" style="width: 278px;" onclick="compare()">Compare Alliances</button>
                    </div>
                </div>
                <div style='display:none;' id='showResults'>
                    <div id='resultsHolder'></div>
                    <br /><button id="resetButton" class="btn btn-success" style="width: 150px;" onclick="reset()">Compare Again</button>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
        <script type="text/javascript">
            /*$(".btn-editable").editable({
             mode: 'inline',
             type: 'number'
             });*/

            var onlyHere = false;

            $(".btn-editable").focus(function() {
                this.select();
            });

            $("#onlyHere").click(function() {
                onlyHere = !onlyHere;
            });

            var redAlliance, blueAlliance;

            function compare() {
                var nope = false;
                redAlliance = [
                    parseInt($("#red1").val()),
                    parseInt($("#red2").val()),
                    parseInt($("#red3").val())
                ];
                blueAlliance = [
                    parseInt($("#blue1").val()),
                    parseInt($("#blue2").val()),
                    parseInt($("#blue3").val())
                ];
                // why doesn't this work wtf
                for (var i in redAlliance) {
                    if (isNaN(i)) {
                        nope = true;
                    }
                }
                for (var i in blueAlliance) {
                    if (isNaN(i)) {
                        nope = true;
                    }
                }
                if (nope) {
                    showMessage("You must enter six teams!", "danger");
                } else {
                    $("#compareButton").button("loading");
                    $.ajax({
                        url: '/ajax-handlers/compare-alliances-ajax-submit.php',
                        type: 'POST',
                        data: {
                            'redAlliance': redAlliance,
                            'blueAlliance': blueAlliance,
                            'onlyHere': onlyHere
                        },
                        success: function(response, textStatus, jqXHR) {
                            $("#resultsHolder").html(response);
                            $("#selectAlliances").slideUp(200, function() {
                                $("#showResults").slideDown(200);
                            });
                        }
                    });
                }
            }

            function reset() {
                $("#compareButton").button("reset");
                $("input").text("");
                $("#showResults").slideUp(200, function() {
                    $("#selectAlliances").slideDown(200);
                });
            }
        </script>
    </body>
</html>