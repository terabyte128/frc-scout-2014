    <div style="margin-top: 10px; padding: 10px 10px 10px 10px; display: none;" class="alert <?php if (isset($_GET["type"])) echo "alert-" . stripcslashes($_GET['type']); ?>" id="inputError">
        <button type="button" class="close" onclick="$('.alert').slideUp(250);">&times;</button>
        <strong id='alertError'><?php if (isset($_GET['message'])) echo stripcslashes($_GET['message']); ?></strong>
    </div>
<script type="text/javascript">

        $(function() {
            
            if ($("#alertError").text() !== "") {
                $('#inputError').slideDown(250);
            }
        });

</script>