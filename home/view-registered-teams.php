<?php require_once '../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include '../includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
        <title>FIRST Scout: Home</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include '../includes/messages.php' ?>
                <h2><img class="loading" id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> View Registered Teams</h2>
                <div style="max-width: 800px;" class="align-center">
                    <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                    <br />
                    <form role="form" onsubmit="return false;">
                        <label for="teamSearch">Search by name or number:
                            <input id="teamSearch" class="form-control" style="width: 200px;" placeholder="Search for team" onkeyup="search();" onblur="search();">
                        </label>
                    </form>
                    <div class="table-wrapper">
                        <table class="table table-striped table-bordered table-hover tablesorter">
                            <thead>
                                <tr>
                                    <th>Team Number</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody id="teamBody">
                            </tbody>
                        </table>
                    </div>
                    <p>(<?php include $_SERVER['DOCUMENT_ROOT'] . '/ajax-handlers/get-registered-teams.php'; ?> teams total)</p>

                </div>

                <?php include '../includes/footer.php' ?>
            </div>
        </div>
        <script type="text/javascript">
            search();

            function search() {
                $(".loading").show();
                $.ajax({
                    url: '/ajax-handlers/get-registered-team-numbers.php',
                    type: "POST",
                    data: {
                        query: $("#teamSearch").val()
                    },
                    success: function(response) {
                        $("#teamBody").html(response);
                        $(".tablesorter").tablesorter();
                        $(".loading").hide();
                    }
                })
            }
        </script>
    </body>
</html>
