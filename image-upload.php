<?php
if (!empty($_FILES)) {

    $file = $_FILES['image'];

# check if it's allowed 
    $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
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
    imagejpeg($image_p, $_SERVER['DOCUMENT_ROOT'] . '/testfiles/image.jpg', 100);
}
?>

<form action="" method="POST" enctype="multipart/form-data" >
    <input type="file" name="image">
    <button type="submit">Upload</button>
</form>