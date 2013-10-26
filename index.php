<html>
    <head>
        <title>FRC Scout: Login</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <img style='margin-bottom: 2px;' src="/images/logo.png" alt="header logo" />
                    <h2 style='margin-top: 2px;'>FRC Scout: Login</h2>
                </div>
                <div class='login-form align-center' style='width: 250px;'>
                    <form role="form">
                        <div class="form-group">
                            <label for="teamNumber">Team Number</label>
                            <input type="number" class="form-control" id="teamNumber" placeholder="Team Number" required>
                        </div>
                        <div class="form-group">
                            <label for="scoutName">Your Name</label>
                            <input type="text" class="form-control" id="scoutName" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="teamPassword">Password</label>
                            <input type="password" class="form-control" id="teamPassword" placeholder="Team Password" required>
                        </div>

                        <button type="submit" class="btn btn-default btn-success">Login</button>
                    </form>
                    <a href="create-account.php">Create an account</a>
                    <br />
                    <a href="password-reset.php">Recover your password</a>
                    <br /><br />
                </div>
            </div>
        </div>
    </body>
</html>
