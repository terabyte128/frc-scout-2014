<!DOCTYPE html>
<meta charset="UTF-8">
<html>
    <head>
        <title>Password Reset</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="title">
                    <h2>Forgot Your Password?</h2>
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
                            <label for="adminEmail">FRC Scout Administrator Email</label>
                            <input type="email" class="form-control" id="adminEmail" placeholder="Admin Email" required>
                        </div>
                        <div class="form-group">
                            <label for="teamPassword">Desired Password</label>
                            <input type="password" class="form-control" id="teamPassword" placeholder="New Password" required>
                        </div>

                        <button type="submit" class="btn btn-default btn-success">Request Reset</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>
    </body>
</html>
