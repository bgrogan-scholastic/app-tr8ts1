<?php

require_once("DB.php");
require_once($_SERVER['SCRIPTS_PHP'] . '/common/cs/client/CS_Client.php');

// create a global connection to the Content Server
$cs = new CS_Client();

/**
 * This class encapsultes one picture from the assets panel.
 * I created a separate class for this because I wanted to save
 * the assetid for later (the <a href="javascript call) and since this
 * is a filename based asset, it doesn't have an assetid. It's a 
 * composition object that delegates down to the underlying 
 * CS_Binary object.
 */
class Picture {
  function Picture($assetid) {
    global $cs;
    $this->_assetid = $assetid;
    $this->_picture = $cs->getBinary(array(CS_PRODUCTID => 'nec', CS_FILENAME => $assetid . "t.jpg"));

    // did we get the picture asset successfully?
    if (!PEAR::isError($picture)) {
      $this->_picture->write('/data/csclient/docs/images');
    } else {
      printf("Failed to get asset %s from Content Server", $assetid);
    }
  }
  function getAssetid() {
    return $this->_assetid;
  }
  function getFilename() {
    return $this->_picture->getFilename();
  }
}

/**
 * This is a collection class that builds the array of Picture objects.
 * It also provides the build() method the template calls in order to
 * build the asset panel of pictures. This class does the mysql work
 * to the Cumbre database and then builds the resulting list of
 * related assets to the pictures based on those assetids.
 */
class Pictures {
  function Pictures($assetid) {

    $db = DB::connect('mysql://nec2:nec2@localhost/nec2');

    // create a collection of pictures
    $this->pictures = array();

    // did we successfully connect to the database?
    if (!DB::isError($db)) {

      $sql = sprintf("select child_id from relations where parent_id='%s'", $assetid);
      $resultSet = $db->getAll($sql, DB_FETCHMODE_ASSOC);

      // did we get any results back?
      if (!DB::isError($resultSet)) {
	
	// loop through result set
	foreach($resultSet as $row) {
	  $picture = new Picture($row['child_id']);
	  $this->_pictures[] = $picture;
	}
      } else {
      	printf("Query %s failed", $sql);
      }
    } else {
      echo "Failed to connect to database";
    }
    $db->disconnect();
  }

  function build($subtemplate) {
    $output = "";

    // loop through pictures and output them
    foreach($this->_pictures as $pic) {
      $output .= sprintf($subtemplate, $pic->getAssetid(), '/images', $pic->getFilename());
    }
    return $output;
  }
}

/**
 * This class gets the text asset from the Content Server based on the assetid
 * from the URL. It also provides the text() method which the template uses
 * to display the actual asset text.
 */
class Article {
  function Article($assetid) {
    global $cs;
    $this->_asset = $cs->getText(array(CS_PRODUCTID => 'nec', CS_ASSETID => $assetid));
  }

  function text() {
    return $this->_asset->getText();
  }
}


// create an instance of the article
$article = new Article($_GET[CS_ASSETID]);

// create an instance of the picture assets
$pictures = new Pictures($_GET[CS_ASSETID]);

// process the template, which 'callsback' to the above objects
require_once('/data/csclient/templates/article/article.html');

?>