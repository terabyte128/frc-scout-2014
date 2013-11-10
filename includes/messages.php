    <div style="margin-top: 10px; padding: 10px 10px 10px 10px; display: none;" id="inputError">
        <button type="button" class="close" onclick="hideMessage();">&times;</button>
        <strong id='alertError'></strong>
    </div>
<script type="text/javascript">

        $(function() {
            
            if (localStorage.message !== undefined) {
                showMessage(localStorage.message, localStorage.type);
                delete(localStorage.message);
                delete(localStorage.type);
            }
        });

</script>
