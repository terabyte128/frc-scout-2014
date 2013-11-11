<div>
    <br />
    <?php if (!$isAdmin && $_SERVER['PHP_SELF'] === "/home/index.php") { ?>
        <span><a href="#" id="optionAuthAsAdmin" onclick="$('#authAsAdmin').slideToggle(250);
                                $('#adminPassword').focus()" style="float: right; font-size: 10pt">Authenticate as administrator</a>
        </span>
    <?php } ?>
    <span style="color: #868686; float: left; font-size: 10pt; margin-bottom: 5px;"><?php if ($isAdmin) { ?> <span style="color: firebrick">administrator</span> | <?php } ?> <?php echo $scoutName ?> | team <?php echo $teamNumber ?> | <?php echo $location ?></span>
</div>