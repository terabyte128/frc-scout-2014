<?php

require_once '../includes/setup-session.php';
require_once '../includes/db-connect.php';

$_SESSION['isAdmin'] = false;
echo 'Successfully de-authenticated as administrator.';
?>