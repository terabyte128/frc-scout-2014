<?php
if (isset($_POST['teamNumber'])) {

    //create db or die
    require_once 'includes/db-connect.php';

    //grab values from POST
    $teamNumber = $_POST['teamNumber'];
    $adminEmail = $_POST['adminEmail'];
    $teamPassword = $_POST['teamPassword'];
    $checkPassword = $_POST['checkPassword'];

    //make sure passwords match
    if (strcmp($teamPassword, $checkPassword) != 0) {
        header('location:create-account.php?message=' . urlencode("Your passwords did not match, please try again.") . "&type=danger");
    } else {

        //try and add account
        $stmt = $db->prepare('INSERT INTO `team_accounts` (team_number, team_password, admin_email) VALUES (?, md5(?), ?)');
        try {
            $stmt->execute(array($teamNumber, $teamPassword, $adminEmail));
            header('location:index.php?message=' . urlencode("Account created sucessfully! You may now log in.") . "&type=success");
        } catch (PDOException $e) {
            $message = $e->getMessage();
            //check if error means team number already exists
            if (strpos($message, "Duplicate entry") !== false) {
                header('location:create-account.php?message=' . urlencode("That team number has been taken! If you believe this is in error, please <?php href='mailto:sam@ingrahamrobotics.org'>contact me</a> and we'll get it sorted out.") . "&type=danger");
            } else {
                header('location:create-account.php?message=' . urlencode("Something went wrong, but we're unsure of what it is. Please try again.") . "&type=danger");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create An Account</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <h2>Create An Account</h2>
                    <form style='max-width: 500px; margin: 5px auto 5px auto'>
                        <a href='#' id='learnHow' style='margin-bottom: 16px;' onclick='$("#step1").show();'><span class="glyphicon glyphicon-question-sign"></span> How does FRC Scout work?</a>
                    </p>
                    <p>
                        <span id="step1">FRC Scout accounts are shared, team-wide. When you create an account here, your team's entire army of scouts will use it. <a href='#' onclick='$("#step1").hide(); $("#step2").show();'>Learn more.</a></span>
                        <span id="step2">When logging in, a scout will enter their name in addition to their team number, to help track who scouted what teams. <a href='#' onclick='$("#step2").hide(); $("#step3").show();'>Learn even more!</a></span>
                        <span id='step3'>The team's admin email is just the email of whoever makes the account, in case they need a password reset or other support. <a href='#' onclick='$("#step3").hide(); $("#learnHow").hide();'>Let's get started!</a></span>
                    </p>
                </div>
                <div class='login-form align-center' style='width: 250px;'>
                    <form role="form" method="post" action="create-account.php">
                        <div class="form-group">
                            <label for="teamNumber">FRC Team Number</label>
                            <input type="number" class="form-control" id="teamNumber" name="teamNumber" placeholder="FRC Team Number" required>
                        </div>
                        <div class="form-group">
                            <label for="adminEmail">FRC Scout Administrator Email</label>
                            <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="Admin Email" required>
                        </div>
                        <div class="form-group">
                            <label for="teamPassword">Team Password</label>
                            <input type="password" class="form-control" id="teamPassword" name="teamPassword" placeholder="Team Password" required>
                        </div>
                        <div class="form-group">
                            <label for="checkPassword">Re-enter Password</label>
                            <input type="password" class="form-control" id="checkPassword" name="checkPassword" placeholder="Re-enter Password" required>
                        </div>
                        <button type="submit" class="btn btn-default btn-success">Create Account</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>
        <script type='text/javascript'>
        $(function() {
           $("#step1").hide(); 
           $("#step2").hide(); 
           $("#step3").hide(); 
        });
        </script>
    </body>
</html>
