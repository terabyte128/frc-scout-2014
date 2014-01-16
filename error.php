<?php
if (isset($_REQUEST['error'])) {
    $error = intval($_REQUEST['error']);
}

$errorMessages = [
    404 => "Page not found. Are you lost?",
    500 => "Internal server error. You (or we) must have done something horribly wrong.",
    200 => "That means \"success,\" not sure how you ended up here..."
];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Error <?php echo $error; ?></title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <img style='margin: 20px auto 2px auto; max-width: 275px' src="/images/logo_earfuzz_hat.png" alt="header logo" id="main-title-image" />
                    <h2 style='margin-top: 2px;'>Oh, snap! You've encountered an error!</h2>
                </div>
                <div>
                    <p>If you're curious, the specific error is as follows:</p>
                    <div class='well' style='margin-bottom: 10px; background-color: #f9f2f4;'>
                        <code style='white-space: normal;'>
                            <?php
                            echo 'Error ' . $error . ": ";
                            if (array_key_exists($error, $errorMessages)) {
                                echo $errorMessages[$error];
                            } else {
                                echo 'Making up errors, are we? I see you trying to find my error page -_-';
                            }
                            ?>
                        </code>
                    </div>
                    <p>You may ask, what can  I do at this point? Well, there are a few options:</p>
                    <button onclick="history.go(-1)" class="btn btn-lg btn-success btn-home-selections">Return to safety (go back)</button>
                    <button onclick="window.location = '/';" class="btn btn-lg btn-info btn-home-selections">Go home</button>
                    <button id='errorReportButton' onclick="openReportErrorModal();" class="btn btn-lg btn-danger btn-home-selections">Report this error</button>
                    <br />
                    <br />
                    <?php require $_SERVER['DOCUMENT_ROOT'] . "/includes/error-reporting/error-modal.php"; ?>
                </div>
            </div>
        </div>
        
    </body>
</html>