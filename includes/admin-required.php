<?php
if ($_SESSION['isAdmin'] == false) {
    header('location: index.php?message=' . urlencode("You need to be logged in as an administrator to access that page.") . "&type=danger");
}
?>