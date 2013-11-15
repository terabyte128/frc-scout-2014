<?php
require_once 'setup-session.php';
require_once 'message-control.php';
if (!$isAdmin) {
    echo '<script type="text/javascript">',
         'loadPageWithMessage("../home", "You need to be logged in as an administrator to access that.", "danger");',
         '</script>';
}
?>