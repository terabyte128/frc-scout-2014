<?php

//connects you to the database as defined by constants.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/constants.php';

try {
    $db = new PDO(DSN, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB \n " . $ex->getMessage());
}
?>
