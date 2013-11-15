<?php include 'includes/redirect-if-session-exists.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Login</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <br />
                <form>
                    <div class="form-group">
                        <label for="test">Location: </label>
                        <input type="text" id="test" placeholder="enter a location" class="form-control" required>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#test").typeahead({
                    'local': ["floop", "flerp", "herp", "derp"]
                });
            });
        </script>
    </body>
</html>
