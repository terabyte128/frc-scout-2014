<?php
require 'headers.php';
if ($_SESSION['isAdmin'] == false) {
    echo '<script type="text/javascript">',
         'loadPageWithMessage("../home", "You need to be logged in as an administrator to access that.", "danger");',
         '</script>';
}
?>