<!DOCTYPE html>
<html>
    <head>
        <title>File Upload Tester</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <style type="text/css">
            .bar {
                height: 18px;
                background: green;
            }
        </style>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <h2>File Upload Tester</h2>
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Select files...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple="" data-url="uploaded-files/upload-handler.php">
                </span>
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <div id="files" class="files"></div>
            </div>
        </div>
        <script type="text/javascript">

            /*jslint unparam: true */
            /*global window, $ */
            $(function() {
                'use strict';
                // Change this to the location of your server-side upload handler:
                $('#fileupload').fileupload({
                    dataType: 'json',
                    done: function(e, data) {
                        $.each(data.result.files, function(index, file) {
                            $('<p/>').text(file.name).appendTo('#files');
                        });
                    },
                    progressall: function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                                );
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        </script>
    </body>
</html>
