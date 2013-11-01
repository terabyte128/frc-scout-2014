<?php
if(isset($_FILES)) {
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include 'includes/headers.php'; ?>
        <title>Camera Access</title>
    </head>
    <body>
        <h1>Upload picture from camera:</h1>
        <form action="getimage.php" method="post"
              <input type="file" accept="image/*" capture="camera" name="pic" />
            <button class="btn" type="submit">Upload!!</button>
        </form>
    </body>
</html>
