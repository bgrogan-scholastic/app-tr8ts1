<?php
$flag = 0;
// get the image
$image = imagecreatefrompng("/data/go2/docs/images/gimp.png");


function drawBox($image, $x, $y, $size) {
 $color = imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), rand(0,255));

	imagerectangle($image, $x, $y, $x + $size - 1, $y + $size - 1, $color);

}

function drawGrid($image) {
  // do the grid loop
  $size = 3;

  for ($row = 0; $row < 200; $row++) {
    for($col = 0; $col < 200; $col++) {
	drawBox($image, $row * $size, $col * $size, $size);

   }
  }

}

// draw the grid
drawGrid($image);

// output the image to the browser
header("Content-type: image/png");

if ($flag !== -1)
	imagepng($image);
imagedestroy($image);

?>
