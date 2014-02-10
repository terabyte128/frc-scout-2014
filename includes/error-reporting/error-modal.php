<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="errorTitle">Report An Error</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="authAsAdmin" onsubmit="sendErrorReport();
                        return false;">
                    <div class="form-group">
                        <textarea class="form-control" id="errorText" placeholder="what's wrong" rows='5' required></textarea>
                    </div>                        
                    <button type='submit' id="reportSubmit" class="btn btn-default btn-success">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
                    function openReportErrorModal() {
                        $('#errorModal').modal('show');
                        $('#errorModal').on('shown.bs.modal', function() {
                            $('#errorText').focus();
                        })
                    }

                    function sendErrorReport() {
                        $("#reportSubmit").button('loading');
                        $.ajax({
                            url: '/includes/error-reporting/send-error-report.php',
                            type: "POST",
                            data: {
                                'errorMessage': $("#errorText").val(),
                                'error': "<?php echo $error; ?>"
                            },
                            success: function(response, textStatus, jqXHR) {
                                $("#reportSubmit").button('reset');
                                $('#errorModal').modal('hide');
                                if (response === "200") {
                                    showMessage("Error report submitted successfully.", "success");
                                    $('#errorReportButton').prop('disabled', true);
                                    $("#errorReportButton").text("Error submitted");
                                } else {
                                    showMessage(response, "danger");
                                }
                            }
                        });
                    }
</script>