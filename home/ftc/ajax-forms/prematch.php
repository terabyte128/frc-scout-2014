<div class="container" align="center">
	<h2 align="center"> Pre-Match Information </h2>
	<br>
    <form>
        <fieldset>
            <label align="center"> Scouted Team Number: </label>
            <input type="text" class="full" placeholder="Team Number" id="scoutedTeam">
            <br><br><label align="center"> Match Number: </label>
            <input type="text" class="full" placeholder="Match Number" id="matchNumber">
        </fieldset>
        <br><br> 
        <div class="btn-group">
            <button class="btn btn-danger btn-small half" type="button"> Red Alliance </button>
            <button class="btn btn-primary btn-small half" type="button"> Blue Alliance </button>
        </div>
        <br><br><br><br>
        <a class="btn btn-success full" href="#" type="button" id="toAuto"> Continue to Autonomous </a>
    </form>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
    $(document).ready(function(){

    	function myValue(theButton, theValue) {
    		return $(theButton).click(function() { $(theValue).val() });
    	}

    	var scoutedTeam = myValue('#toAuto', '#scoutedTeam');
    	var matchNumber = myValue('#toAuto', '#matchNumber');
    });

    </script>
</div>