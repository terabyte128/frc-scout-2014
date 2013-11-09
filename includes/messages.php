    <div style="margin-top: 10px; padding: 10px 10px 10px 10px; display: none;" id="inputError">
        <button type="button" class="close" onclick="$('.alert').slideUp(250);">&times;</button>
        <strong id='alertError'></strong>
    </div>
<script type="text/javascript">

        $(function() {
            
            if (localStorage.message !== undefined) {
                $('#alertError').html(localStorage.message);
                $('#inputError').attr("class","alert alert-" + localStorage.type);
                delete(localStorage.message);
                delete(localStorage.type);
                $('#inputError').slideDown(250);
            }
        });

</script>