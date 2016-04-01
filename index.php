<?php

function watermarkMe($wm_img, $wm_txt){
  list($width, $height) = getimagesize($wm_img);
  
  $image_p = imagecreatetruecolor($width, $height);
  $image = imagecreatefromjpeg($wm_img);
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
  
  $black = imagecolorallocate($image_p, 0, 0, 0);
  $font = 'CourierNewBold.ttf';
  $fontsize = 50;

  imagettftext($image_p, $fontsize, 0, 10, ($height / 2), $black, $font, $wm_txt);
  if (isset($wm_img) && isset($wm_txt)) {
    header('Content-Type: image/jpeg');
    imagejpeg($image_p, null, 100);
  }

  imagedestroy($image);
  imagedestroy($image_p);
}

if (isset($_POST['submit'])) {
  $wm_img = $_FILES['wm_img']['tmp_name'];
  $wm_txt = $_POST['wm_txt'];
  watermarkMe($wm_img, $wm_txt);
}

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Watermark Me</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/app.css" />
  </head>
  <body>

    <div class="row">
      <div class="large-12 columns">
        <h1>Add a watermark to your image</h1>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <label for="wm_txt">Text to watermark image with:</label>
          <input type="text" id="wm_txt" name="wm_txt" value="<?php if(!empty($wm_txt)) { echo $wm_txt; } ?>"></input>
          <label for="wm_img">Image (jpg only for now!) you want to watermark:</label>
          <input type="file" id="wm_img" name="wm_img"></input>
          <input class="button" type="submit" name="submit" value="Watermark Me!"></input>
        </form>
      </div>
    </div>

    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/what-input.min.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
