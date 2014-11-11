<?php



$mid = $_GET["mid"];
$sid = $_GET["sid"];
$ssid = $_GET["ssid"];
$dsid = $_GET["dsid"];
$act = $_GET["act"];


// set up the spots array, this relates spotid to spot name and it's coordinates
//                          name       x1   y1   x2   y2   lat    long   map 
//                            0         1    2    3    4     5       6    7
$spots = array(1 => array("Albany",    370, 200, 450, 220, 42.75, 73.80, "mgus032"),
               2 => array("Syracuse",  280, 171, 350, 190, 43.12, 76.12, "mgus032"),
               3 => array("Rochester", 188, 156, 276, 181, 43.12, 77.67, "mgus032"),
	       4 => array("New York",  423, 372, 501, 396, 40.77, 73.98, "mgus032"),
	       5 => array("Hartford",  323, 117, 402, 133, 41.73, 72.65, "mgus007"), 
	       6 => array("Long Island",
			  424, 388,
			  432, 368,
			  483, 355,
			  516, 352,
			  528, 342,
			  566, 342,
			  516, 372,
			  430, 392));

$pois = array(1 => array(311, 261 + 50, 322, 270 + 50, "Binghamton totally rocks!"), 
	      2 => array(418, 219 + 50, 429, 228 + 50, "Albany, you just can't get enough of it!"),
	      3 => array(106, 161 + 50, 117, 170 + 50, "Niagara Falls is a drip"),
	      4 => array(297, 174 + 50, 308, 183 + 50, "Syracuse, what can you say about endless snow"));

// global variables
$offset = 50;
$fontsize = 15;

// insert a spot legend on the map
function spotLegend($image, $id, $posx, $posy) {
  global $spots;
  global $offset;
  global $fontsize;

  // set up the font
  $fontColor = imagecolorallocate($image, 0, 0, 0);
  $fontfile = "/data/go2/fonts/texs.ttf";
  
  // get the spot name
  $spotText = $spots[$id][0];
  
  // get bounding box dimensions
  $box = imagettfbbox($fontsize, 0, $fontfile, $spotText);

  // translate box
  $box[0] = $posx - 4;                       // lower left x
  $box[1] = $posy + $fontsize + 4;           // lower left y
  $box[2] = $box[2] + $posx + 4;             // lower right x
  $box[3] = $posy + $fontsize + 4;           // lower right y
  $box[4] = $box[4] + $posx + 4;             // upper right x
  $box[5] = $posy  - 4;                      // upper right y
  $box[6] = $posx - 4;                       // upper left x
  $box[7] = $posy - 4;                       // upper left y

  // fill the bounding box
  $fillColor = imagecolorallocate($image, 240, 248, 115);
  imagefilledrectangle($image, $box[6], $box[7], $box[2], $box[3], $fillColor);

  // draw the bounding box
  imagerectangle($image, $box[6], $box[7], $box[2], $box[3], $color);

  // output the spot name
  imagettftext($image, 
	       $fontsize, 
	       0, 
  	       $posx, $posy + 15, 
	       $fontColor, 
	       $fontfile, 
	       $spotText);

  return array($box[6], $box[7], $box[2], $box[3]);
}

// insert a spot legend on the map
function distanceLegend($image, $distance, $posx, $posy) {
  global $spots;
  global $offset;
  global $fontsize;

  // set up the font
  $fontColor = imagecolorallocate($image, 0, 0, 0);
  $fontfile = "/data/go2/fonts/texs.ttf";
  
  // get the spot name
  $spotText = sprintf("%3.2f miles", $distance);
  
  // get bounding box dimensions
  $box = imagettfbbox($fontsize, 0, $fontfile, $spotText);

  // translate box
  $box[0] = $posx - 4;                       // lower left x
  $box[1] = $posy + $fontsize + 4;           // lower left y
  $box[2] = $box[2] + $posx + 4;             // lower right x
  $box[3] = $posy + $fontsize + 4;           // lower right y
  $box[4] = $box[4] + $posx + 4;             // upper right x
  $box[5] = $posy  - 4;                      // upper right y
  $box[6] = $posx - 4;                       // upper left x
  $box[7] = $posy - 4;                       // upper left y

  // draw the bounding box
  $fillColor = imagecolorallocate($image, 240, 248, 115);
  imagefilledrectangle($image, $box[6], $box[7], $box[2], $box[3], $fillColor);

  imagerectangle($image, $box[6], $box[7], $box[2], $box[3], $fontColor);

  // output the spot name
  imagettftext($image, 
	       $fontsize, 
	       0, 
  	       $posx, $posy + 15, 
	       $fontColor, 
	       $fontfile, 
	       $spotText);

  return array($box[6], $box[7], $box[2], $box[3]);
}


// highlight a city on the map
function highlightSpot($image, $id, $posx, $posy) {
  global $spots;
  global $offset;

  //imagesetthickness($image, 3);


  // add a spot legend to the map
  $box = spotLegend($image, $id, $posx, $posy);

  // get the spot information
  $spot = $spots[$id];

  // highlight the spot on the map
  $rectImage = imagecreatetruecolor($spot[3] - $spot[1], $spot[4] - $spot[2]);
  // copy section of image to new image
  imagecopy($rectImage, $image, 0, 0, $spot[1], $spot[2] + $offset, imageSX($rectImage), imageSY($rectImage));

  // turn on alpha blending
  imagealphablending($rectImage, true);

  // fill image with transparent color
  $fillColor = imagecolorallocatealpha($image, 240, 248, 115, 90);
  imagefilledrectangle($rectImage, 0, 0, imageSX($rectImage), imageSY($rectImage), $fillColor);

  // merge highlight onto map
  imagecopymerge($image, $rectImage, $spot[1], $spot[2] + $offset, 0, 0, imageSX($rectImage), imageSY($rectImage), 100); 
  imagerectangle($image, $spot[1], $spot[2] + $offset, $spot[3], $spot[4] + $offset, imagecolorallocate($image, 0, 0, 0));

  // draw a line between the legend and the city
  imageline($image,
	    $box[0] + (($box[2] - $box[0]) / 2), $box[3],
	    $spot[1] + (($spot[3] - $spot[1]) / 2), $spot[2] + $offset,
	    imagecolorallocate($image, 0, 0, 0));

  // clean up
  imagedestroy($rectImage);
}


// highlight a city on the map
function highlightPoly($image, $id, $posx, $posy) {
  global $spots;
  global $offset;


  // add a spot legend to the map
  $box = spotLegend($image, $id, $posx, $posy);

  // get the spot information
  $spot = $spots[$id];

  // build array of polygon vertices with y-axis offset
  $poly = array(424, 388 + 50,
		432, 368 + 50,
		483, 355 + 50,
		516, 352 + 50,
		528, 342 + 50,
		566, 342 + 50,
		516, 372 + 50,
		430, 392 + 50,
		424, 388 + 50);


  // get the enclosing rectangle for the polygon
  $x1 = 424;
  $y1 = 342 + 50;
  $x2 = 566;
  $y2 = 392 + 50;

  // highlight the spot on the map

  // fill image with transparent color
  $fillColor = imagecolorallocatealpha($image, 240, 248, 115, 90);
  imagefilledpolygon($image, $poly, 9, $fillColor);

  // merge highlight onto map
  imagepolygon($image, $poly, 9, imagecolorallocate($image, 0, 0, 0));

  // draw a line between the legend and the city
  imageline($image,
  	    $box[0] + (($box[2] - $box[0]) / 2), $box[3],
  	    $poly[2], $poly[3],
  	    imagecolorallocate($image, 0, 0, 0));
}

function poi($image) {
  global $pois;

  // get the camera gif into memory
  $tmp = imagecreatefromgif("/data/go2/docs/maps/camera1.gif");
  $camera = imagecreatetruecolor(imageSX($tmp), imageSY($tmp));
  imagecopy($camera, $tmp, 0, 0, 0, 0, imageSX($tmp), imageSY($tmp));
  imagedestroy($tmp);

  // set the black color to be transparent
  imagecolortransparent($camera, imagecolorallocate($camera, 0, 0, 0));

  // loop through the pois and paint the camera on the map
  foreach($pois as $poi) {
    imagecopymerge($image, $camera, $poi[0], $poi[1], 0, 0, imageSX($camera), imageSY($camera), 100);
  }

  // destroy the temporary camera image
  imagedestroy($camera);
}


function distance($id1, $id2) {
  global $spots;

  $lat1 = deg2rad($spots[$id1][5]);
  $lat2 = deg2rad($spots[$id2][5]);
  $long1 = deg2rad($spots[$id1][6]);
  $long2 = deg2rad($spots[$id2][6]);
  $dlat = abs($lat2 - $lat1);
  $dlong = abs($long2 - $long1);
  
  $l = ($lat1 + $lat2) / 2;
  $a = 6378;
  $b = 6357;
  $e = sqrt(1 - ($b * $b)/($a * $a));
  
  $r1 = ($a * (1 - ($e * $e))) / pow((1 - ($e * $e) * (sin($l) * sin($l))), 3/2);
  $r2 = $a / sqrt(1 - ($e * $e) * (sin($l) * sin($l)));
  $ravg = ($r1 * ($dlat / ($dlat + $dlong))) + ($r2 * ($dlong / ($dlat + $dlong)));

  $sinlat = sin($dlat / 2);
  $sinlon = sin($dlong / 2);
  $a = pow($sinlat, 2) + cos($lat1) * cos($lat2) * pow($sinlon, 2);
  $c = 2 * asin(min(1, sqrt($a)));
  $d = $ravg * $c; 

  // convert kilometers to miles
  $d = $d * 0.62;
  return $d;
}


function doTwoMapDistance($image, $ssid, $dsid) {
  global $spots;

  $ssidSpot = &$spots[$ssid];
  $dsidSpot = &$spots[$dsid];
  $ssidImage = imagecreatefrompng("/data/go2/docs/maps/" . $spots[$ssid][7] . ".png");
  $dsidImage = imagecreatefrompng("/data/go2/docs/maps/" . $spots[$dsid][7] . ".png");

  // blank out the existing image
  imagefilledrectangle($image, 0, 0, imageSX($image), imageSY($image), imagecolorallocate($image, 255,255,255));

  // copy relevant section of ssid map to image
  $dx = $ssidSpot[3] - (($ssidSpot[3] - $ssidSpot[1]) / 2);
  $dx = $dx - imageSX($ssidImage) / 2 / 2 - 5;
  if($dx < 0) {
    $dx = 0;
  }
  imagecopy($image, $ssidImage, 0, 50, $dx, 0, (imageSX($ssidImage) / 2 - 5), imageSY($ssidImage));
  imagerectangle($image, 0, 50, (imageSX($ssidImage) / 2 - 5), imageSY($ssidImage) + 50, imagecolorallocate($image, 0,0,0));

  // highlight spot on ssid
  $ssidSpot[1] = $ssidSpot[1] - $dx;
  $ssidSpot[3] = $ssidSpot[3] - $dx;
  $box1 = highlightSpot($image, $ssid, 20, 10);

  // copy relevant section of dsid map to image
  $dx = $dsidSpot[3] - (($dsidSpot[3] - $dsidSpot[1]) / 2);
  $dx = $dx - imageSX($dsidImage) / 2 / 2 - 5;
  if($dx < 0) {
    $dx = 0;
  }
  imagecopy($image, $dsidImage, (imageSX($dsidImage) / 2 + 5), 50, $dx, 0, (imageSX($dsidImage) / 2 - 5), imageSY($dsidImage));
  imagerectangle($image, (imageSX($dsidImage) / 2 + 5), 50, imageSX($dsidImage) - 1, imageSY($dsidImage) + 50, imagecolorallocate($image, 0,0,0));
  // highlight spot on dsid
  $dsidSpot[1] = $dsidSpot[1] - $dx + (imageSX($dsidImage) / 2 + 5);
  $dsidSpot[3] = $dsidSpot[3] - $dx + (imageSX($dsidImage) / 2 + 5);
  $box1 = highlightSpot($image, $dsid, 500, 10);

  // clean up
  imagedestroy($ssidImage);
  imagedestroy($dsidImage);

  // calculate the distance
  $d = distance($ssid, $dsid);

  // put up the distance legend
  distanceLegend($image, $d, 230, 10);
}


// *************************************************************************
// ** start of main code **
// *************************************************************************

  
// get the map to modify
$mapImageFilepath = "/data/go2/docs/maps/mgus032.png";
$mapImagedata = getimagesize($mapImageFilepath);
$mapImage = imagecreatefrompng($mapImageFilepath);

// create new image work area
$newImage = imagecreatetruecolor($mapImagedata[0], $mapImagedata[1] + $offset);
$fillColor = imagecolorallocate($newImage, 255, 255, 255);
imagefill($newImage, 0, 0, $fillColor);

// copy the map into the new image
imagecopy($newImage, $mapImage, 0, $offset, 0, 0, $mapImagedata[0], $mapImagedata[1]);

// should we draw on the map?
if($act != "") {
  if($act == "search") {
    highlightSpot($newImage, $sid, 20, 10);
  }
  if($act == "distance") {
    // are the spots on the same maps?
    if($spots[$ssid][7] == $spots[$dsid][7]) {
      $box1 = highlightSpot($newImage, $ssid, 20, 10);
      $box2 = highlightSpot($newImage, $dsid, 500, 10);

      // calculate the distance
      $d = distance($ssid, $dsid);

      // put up the distance legend
      distanceLegend($newImage, $d, 230, 10);
     
    // otherwise, nope different maps
    } else {
      doTwoMapDistance($newImage, $ssid, $dsid);
    }
  }
  if($act == "Long Island") {
    highlightPoly($newImage, 6, 20, 10);
  }
  if($act == "poi") {
    poi($newImage);
  }
}


header("Content-type: image/png");

// output the image
imagepng($newImage);

// destroy the images and clean up
$imagedestroy($newImage);
$imagedestroy($mapImage);


?>

