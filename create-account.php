<html>
    <head>
        <title>Create An Account</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h2>Create An Account</h2>
                <p style='max-width: 500px; margin: 5px auto 5px auto'>
                    FIRST Scout accounts are shared, team-wide. Each team has a 
                    shared team password. Scouts log in using their team number 
                    and shared password.
                    <br /><br />
                    When logging in, a scout will enter a User ID in addition 
                    to the Team ID and team password. The User ID is not stored 
                    as part of your team's information - it is simply used so 
                    that you can track who scouted what match.
                    <br /><br />
                    The account's admin email should be the email address of 
                    whoever is head of scouting for your team. It would only be 
                    used in case we need to contact you about something, it is 
                    never shared. 
                    <br /><br />
                </p>
            </div>
            <div class='login-form align-center' style='width: 250px;'>
                <form role="form">
                    <div class="form-group">
                        <label for="teamNumber">FRC Team Number</label>
                        <input type="number" class="form-control" id="teamNumber" placeholder="FRC Team Number" required>
                    </div>
                    <div class="form-group">
                        <label for="adminEmail">FRC Scout Administrator Email</label>
                        <input type="email" class="form-control" id="adminEmail" placeholder="Admin Email" required>
                    </div>
                    <div class="form-group">
                        <label for="teamPassword">Team Password</label>
                        <input type="password" class="form-control" id="teamPassword" placeholder="Team Password" required>
                    </div>

                    <button type="submit" class="btn btn-default btn-success">Create Account</button>
                </form>

            </div>
        </div>
    </body>
</html>
