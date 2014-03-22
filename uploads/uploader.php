<?php

require_once '../includes/setup-session-no-js.php';
require_once '../includes/db-connect.php';

if (!$isAdmin) {
    die("You must be an administrator to do that!");
}

if (!empty($_FILES)) {

    $file = $_FILES['teamPicture'];

# check if it's allowed 
    $allowedTypes = array(IMAGETYPE_JPEG);
    $fileType = exif_imagetype($file['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        die("That filetype is not allowed.");
    }

// The file
    $filename = $file['tmp_name'];

// Set a maximum height and width
    $width = 600;
    $height = 600;

// Content type
    header('Content-Type: image/jpeg');

// Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);

    $ratio_orig = $width_orig / $height_orig;

    if ($width / $height > $ratio_orig) {
        $width = $height * $ratio_orig;
    } else {
        $height = $width / $ratio_orig;
    }

// Resample
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// Output
    imagejpeg($image_p, $_SERVER['DOCUMENT_ROOT'] . "/uploads/$teamNumber.jpg", 100);

    $request = $db->prepare('UPDATE ' . $teamTable . ' SET team_picture=? WHERE team_number=?');
    $request->execute(array("$teamNumber.jpg", $teamNumber));


    // update file definition in database
    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);
    echo 'Success';
} else {
    echo 'You did not submit a file.';
}