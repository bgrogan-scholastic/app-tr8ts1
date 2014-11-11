<?php

require_once("DB.php");
require_once($_SERVER["PHP_SCRIPTS"] . "/common/utils/GI_Hash.php");

// set up some global function references
$retavl = "";
$imagecreate = imagecreatefromgif;
$imageoutput = imagepng;

function getMapFilepath($assetid) {
  global $imagecreate;
  global $image;

  $db = DB::connect('mysql://cs:cs@localhost/cs');

  // if no db error
  if (!DB::isError($db)) {
    $sql = sprintf("select * from assets where assetid='%s'", $assetid);

    $data = $db->getRow($sql, DB_FETCHMODE_ASSOC);

    // if no error
    if(!DB::isError($maps)) {
      
      // build the filepath to the asset
      $hash = new GI_Hash("/data/cs/docs/go/assets");

      $retval = $hash->get($assetid . "." . $data["fext"]);

      // set up the graphic function references
      if($data["fext"] == "jpg") {
	$imagecreate = imagecreatefromjpeg;
	$imageoutput = imagejpeg;
	header("Content-type: image/jpg");
      } else {
	header("Content-type: image/png");
      }
    } else {
      die($db->getMessage());
    }
  } else {
    die($db->getMessage());
  }
  $db->disconnect();

  return $retval;
}

function getMapHotspots($mapid) {
  global $imagecreate;
  global $image;

  $retval = "";

  $db = DB::connect('mysql://atlas:atlas@localhost/atlas');

  // if no db error
  if (!DB::isError($db)) {
    $sql = sprintf("select * from spots where mapid='%s'", $mapid);

    $spots = $db->getAll($sql, DB_FETCHMODE_ASSOC);

    // if no error
    if(!DB::isError($maps)) {
      
      // return the list of spots
      $retval = $spots;
      
    } else {
      die($db->getMessage());
    }
  } else {
    die($db->getMessage());
  }
  $db->disconnect();

  return $retval;
}


function drawHotspots($image, $spots) {

  $black = imagecolorallocate($image, 0, 0, 0);
  $yellow = imagecolorallocate($image, 0xff, 0xff, 0x42);
  $white = imagecolorallocate($image, 255, 255, 255);

  // iterate through the list of spots
  foreach($spots as $spot) {

    // do we have any coordinates?
    if($spot["coords"] != None) {

      // build array for polygon
      $coords = buildPolygonArray($spot["coords"]);

      // outline the polygon
      imagesetthickness($image, 3);
      imagepolygon($image, $coords, count($coords) / 2, $black);
      imagesetthickness($image, 1);
      imagepolygon($image, $coords, count($coords) / 2, $yellow);

      // draw the type text
      $fontfile = "/data/go2/fonts/texs.ttf";
      $box = imagettfbbox(10, 0, $fontfile, $spot["type"]);
      $box[0] += $coords[0] + 2;
      $box[1] += $coords[1] + 14;
      $box[2] += $coords[0] + 4;
      $box[3] += $coords[1] + 13;
      $box[4] += $coords[0] + 4;
      $box[5] += $coords[1] + 11;
      $box[6] += $coords[0] + 2;
      $box[7] += $coords[1] + 11;
      if($spot["type"] == "n") {
	imagefilledrectangle($image, $box[6], $box[7], $box[2], $box[3], $black);
	imagettftext($image, 
		   10, 
		   0, 
		   $coords[0] + 3, $coords[1] + 12, 
		   $white, 
		   $fontfile, 
		   $spot["type"]);
      } else {
	imagefilledrectangle($image, $box[6], $box[7], $box[2], $box[3], $white);
	imagettftext($image, 
		   10, 
		   0, 
		   $coords[0] + 3, $coords[1] + 12, 
		   $black, 
		   $fontfile, 
		   $spot["type"]);
      }
    }
  }
}


function buildPolygonArray($coords) {
  $retval = array();

  // clean out the extra spaces
  $pattern = '/\s+/';
  $coords = preg_replace($pattern, ' ', $coords);

  // split up the coordinates
  $temp = explode(" ", $coords);
  foreach($temp as $coord) {
    $retval[] = intval($coord);
  }
  return $retval;
}


// build the filename
$mapid = $_GET["mapid"];

// get path to map image based on mapid
$filepath = getMapFilepath($mapid);

// create image
$mapImage = $imagecreate($filepath);

// get the list of hotspots
$spots = getMapHotspots($mapid);

// build the hotspots on this map image
drawHotspots($mapImage, $spots);

// output the image
$imageoutput($mapImage);

// destroy the images and clean up
imagedestroy($mapImage);

?>