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
                margin: 2px 5px 2px 5px;
                color: white;
            }
        </style>
        <div class="wrapper">
            <div class="container" style="border-left: 5px solid #d2322d; border-right: 5px solid rgb(0, 82, 255);">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php' ?>
                <h2>Compare Alliances</h2>
                <div style="display: inline;" id="selectAlliances">
                    <label>Select buttons to enter team numbers</label>
                    <br />
                    <div style="display: inline-table;">
                        <div style="display: table-row;">
                            <div style="display: table-cell;">
                                <button id="red1" class="btn btn-danger btn-lg btn-editable"></button>
                                <br />
                                <button id="red2" class="btn btn-danger btn-lg btn-editable"></button>
                                <br />
                                <button id="red3" class="btn btn-danger btn-lg btn-editable"></button>
                                <br />
                            </div>
                            <div style="display: table-cell; padding-left: 15px; padding-right: 15px; vertical-align: middle; line-height: 10px;">
                                <p style="font-size: 50px;">vs</p>
                            </div>
                            <div style="display: table-cell;">
                                <button id="blue1" class="btn btn-blue-selection btn-lg btn-editable"></button>
                                <br />
                                <button id="blue2" class="btn btn-blue-selection btn-lg btn-editable"></button>
                                <br />
                                <button id="blue3" class="btn btn-blue-selection btn-lg btn-editable"></button>
                                <br />
                            </div>
                        </div>
                        <br />


                    </div>
                    <div>
                        <button class="btn btn-lg btn-success" style="width: 288px;" onclick="compare()">Compare</button>
                    </div>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ?>
            </div>
        </div>
        <script type="text/javascript">
            $(".btn-editable").editable({
                mode: 'inline',
                type: 'number'
            });

            function compare() {
                $("#selectAlliances").slideUp(200);
            }
        </script>
    </body>
</html>