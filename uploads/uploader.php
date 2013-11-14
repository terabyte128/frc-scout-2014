<?php

require '../includes/setup-session-no-js.php';
require '../includes/db-connect.php';

if(!$isAdmin) {
    die("You must be an administrator to do that!");
}

define("UPLOAD_DIR", "./");
if (!empty($_FILES["teamPicture"])) {
    $myFile = $_FILES["teamPicture"];
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "An error occurred.";
        exit;
    }

    $maxSize = 1048576;
    if($myFile['size'] >= $maxSize) {
        die("Your photo cannot be larger than 1 MB.");
    }

    $fileType = exif_imagetype($myFile["tmp_name"]);
    $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

    if (!in_array($fileType, $allowed)) {
        die("You can only upload image files (gif, jpg, and png).");
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

    // don't overwrite an existing file
    $parts = pathinfo($name);

    $name = $teamNumber . '.' . $parts['extension'];

    if (file_exists(UPLOAD_DIR . $name)) {
        unlink(UPLOAD_DIR . $name);
        //$name = $teamNumber . "-" . $i . "." . $parts["extension"];
    }


    // preserve file from temporary directory
    $success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
    if (!$success) {
        echo "Unable to save file.";
        exit;
    }
    
    $request = $db->prepare('UPDATE ' . $teamTable . ' SET team_picture=? WHERE team_number=?');
    $request->execute(array($name, $teamNumber));
    
    
    // update file definition in database

    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);
    echo 'Success';
} else {
    echo 'Something went wrong.';
}