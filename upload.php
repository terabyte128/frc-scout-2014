<!DOCTYPE html>
<html>
    <head>
        <?php include 'includes/headers.php'; ?>
        <?php include 'includes/setup-session.php'; ?>
        <?php include 'includes/admin-require_onced.php'; ?>
        
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <title>
            Upload tester
        </title>
    </head>
    <body>
        <div>
            <form id="myForm" action="uploads/uploader.php" method="post" enctype="multipart/form-data">
                <input type="file" size="60" name="myfile">
                <input type="submit" value="Ajax File Upload">
            </form>

            <div id="progress">
                <div id="bar"></div>
                <div id="percent">0%</div >
            </div>
            <br/>

            <div id="message"></div>
            <br />
        </div>
        <script type="text/javascript">
            $(document).ready(function()
            {

                var options = {
                    beforeSend: function()
                    {
                        $("#progress").show();
                        //clear everything
                        $("#bar").width('0%');
                        $("#message").html("");
                        $("#percent").html("0%");
                    },
                    uploadProgress: function(event, position, total, percentComplete)
                    {
                        $("#bar").width(percentComplete + '%');
                        $("#percent").html(percentComplete + '%');

                    },
                    success: function()
                    {
                        $("#bar").width('100%');
                        $("#percent").html('100%');

                    },
                    complete: function(response)
                    {
                        $("#message").html("<font color='green'>" + response.responseText + "</font>");
                    },
                    error: function()
                    {
                        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");

                    }

                };

                $("#myForm").ajaxForm(options);

            });
        </script>
    </body>
</html>