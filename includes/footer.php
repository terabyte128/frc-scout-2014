<div class='footer'>
    <br />
    <span class='footer-left'>
        <?php if ($isAdmin) { ?> <span style="color: firebrick;">administrator</span> | <?php } ?> 
        <span style="color: royalblue; font-weight: 500;"><?php echo $teamType ?></span> | 
        <?php echo $scoutName ?> | Team 
        <?php echo $teamNumber ?> | 
        <?php echo $location ?>
    </span>
    <?php if (!$isAdmin && $_SERVER['PHP_SELF'] === "/home/index.php") { ?>
        <span><a href="#" id="optionAuthAsAdmin" onclick="$('#authModal').modal('show');
                $('#adminPassword').focus();" class='footer-right'>Authenticate as administrator</a>
        </span>
    <?php } ?>
</div>