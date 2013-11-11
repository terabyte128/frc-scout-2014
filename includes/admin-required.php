<?php
require 'setup-session.php';
require 'message-control.php';
if (!$isAdmin) {
    echo '<script type="text/javascript">',
         'loadPageWithMessage("../home", "You need to be logged in as an administrator to access that.", "danger");',
         '</script>';
}
?>