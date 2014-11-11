
<?php

/*+ ---------------------------------------------------------------
 * This is the picture_popup program PHP file. This program retrieves
 * remote url popup page contents and reformats them for use in the
 * American Presidency system. This requires a couple of things:
 * Get the url contents
 * get the title and caption from the remote page
 * build a popup html file
 * save it locally as a static html page
 * 
 * The program consists of a number of things, calling on classes
 * and sub-routines to do it's work.
 * This program expects to be called with a URL like this:
 * picture_popup?productid=gme&assetid=pr39&templatename=/article/picture_popup.html
 * ---------------------------------------------------------------- -*/

require_once('DB.php');
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/common/utils/hash.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlcontent.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/ap/common/servers.php");


class Content {
  function Content($params) {
    $this->_content = "";
    $this->_productid = $params['productid'];
    $this->_assetid = $params['assetid'];
    $this->_templatefile = $params['templatefile'];
    $this->_servers = new GI_getServers('AP', $this->_productid);
    $this->_productName = $this->_servers->name();
  }
  function get() {
    return $this->_content;
  }
  function productname() {
    return $this->_productname;
  }
  function productid() {
    return $this->_productid;
  }
  function productName() {
    return $this->_productName;
  }
  function assetid() {
    return $this->_assetid;
  }
  function templatefile() {
    return $this->_templatefile;
  }
  function servers() {
    return $this->_servers;
  }
}


class UrlContent extends Content {
  function UrlContent($params) {
    // -----------------------------------------------------
    // call base class
    // -----------------------------------------------------
    $this->Content($params);

    // -----------------------------------------------------
    // build the url to the server
    // -----------------------------------------------------
    $url = "http://" . $this->_servers->domain(0) . ":" . $this->_servers->port(0) . "/cgi-bin/media?assetid=" . $this->_assetid . "&templatename=/ap/media.html";
    if ($_GET["url"] == "on") {
      echo $url;
    }
    // -----------------------------------------------------
    // get the content from the url
    // -----------------------------------------------------
    $httpFile = new GI_urlHttpFile($url);
    $this->_content = $httpFile->read();
  }
}


/*+ ***********************************************************
 * Name         : PicturePopup
 * Created      : 11-3-2003
 * Created by   : Doug Farrell
 * Comments     : This class creates the static html picture
 * popup file from the productid and assetid fields
 ************************************************************** -*/
class PicturePopup {
  // -------------------------------------------------------
  // constructor for class, takes in the paramerter array
  // and builds the necessary stuff for an article
  // -------------------------------------------------------
  function PicturePopup($params) {
    $this->_productid = $params['productid'];
    $this->_assetid = $params['assetid'];
    $this->_templatefile = $params['templatefile'];

    // -----------------------------------------------------
    // get a content object and read the raw content text
    // -----------------------------------------------------
    $contentObject = new UrlContent($params);
    $this->_productName = $contentObject->productName();
    $rawtext = $contentObject->get();

    // -----------------------------------------------------
    // get the content by sections
    // -----------------------------------------------------
    $this->_xmlcontent = new GI_xmlContent($rawtext);
  }
  // -------------------------------------------------------
  // get the fully qualified product id characters
  // -------------------------------------------------------
  function productID() {
    return $this->_productid;
  }
  // -------------------------------------------------------
  // get the product name
  // -------------------------------------------------------
  function productName() {
    return $this->_productName;
  }
  // -------------------------------------------------------
  // get the product name
  // -------------------------------------------------------
  function assetTitle() {
    return $this->_xmlcontent->getOne("assettitle");
  }
  // -------------------------------------------------------
  // get the cleaned up text from the raw content
  // -------------------------------------------------------
  function text() {
    $text =  $this->_xmlcontent->getOne("caption");
    
    // -----------------------------------------------------
    // redirect the entities 
    // -----------------------------------------------------
    $text = preg_replace('#<img src="(/.*?ol/media/.*?/)(.*?)">#is', '<img src="/images/entities/$2">', $text);

    // -----------------------------------------------------
    // get rid of hrefs
    // -----------------------------------------------------
    $text = preg_replace("#<a href=.*?>(.*?)</a>#is", "$1", $text);

    return $text;
  }
  // -------------------------------------------------------
  // get the list of assets into the page with the correct
  // pathing. This also sizes the images dynamically based
  // on the image size and the destination size (150).
  // -------------------------------------------------------
  function picture() {
    // -----------------------------------------------------
    // create the thumbnail hash object
    // -----------------------------------------------------
    $hash = new GI_Hash($_SERVER["PICTURES_CACHE_HOME"]);

    // -----------------------------------------------------
    // calculate the dynamic image size
    // -----------------------------------------------------
    $imageinfo = getimagesize($hash->get($this->_assetid . ".jpg"));
    $width  = $imageinfo[0];
    $height = $imageinfo[1];

    // -----------------------------------------------------
    // get the img src stuff from the product
    // -----------------------------------------------------
    $image = $this->_xmlcontent->getOne("picture");

    // -----------------------------------------------------
    // rebuild the path for AP
    // -----------------------------------------------------
    $replacement = '$1/images/cache/' . $hash->hval($this->_assetid . ".jpg") . '/$3';
    $image = preg_replace('#(<img src=")(/.*?ol/media/.*?/)(.*?">)#i', $replacement, $image);

    return $image;
  }
}



/*+ ***********************************************************
 * Name         : Page
 * Created      : 10-27-2003
 * Created by   : Doug Farrell
 * Comments     : This class manages the actual page. It will
 * build the page from scratch if necessary, or get it from the
 * cache system if it can. 
 ************************************************************** -*/
class Page {
  // -------------------------------------------------------
  // this is the constructor for the object
  // -------------------------------------------------------
  function Page() {
    $this->_productid    = $_GET["productid"];
    $this->_assetid      = $_GET["assetid"];
    $this->_templatefile = $_SERVER["TEMPLATE_HOME"] . $_GET["templatename"];
  }
  // -------------------------------------------------------
  // this method builds the page from scratch
  // -------------------------------------------------------
  function build() {
    // -----------------------------------------------------
    // build a hash object to the text cache
    // -----------------------------------------------------
    $hash = new GI_Hash($_SERVER["DOCUMENT_ROOT"] . "/text/cache");
    $filepath = $hash->get($this->_assetid . ".html");

    // -----------------------------------------------------
    // are we using the cache system?
    // -----------------------------------------------------
    $cache = strtolower($_GET["cache"]);
    if (($cache == "on" || $cache == "") && file_exists($filepath)) {
      readfile($filepath);
      
    // -----------------------------------------------------
    // otherwise, nope, so build the popup from scratch
    // -----------------------------------------------------
    } else {
      // ---------------------------------------------------
      // build the article object
      // ---------------------------------------------------
      $article = new PicturePopup(array("productid" => $this->_productid,
					"assetid" => $this->_assetid, 
					"templatefile" => $this->_templatefile));

      // ---------------------------------------------------
      // turn on output buffering
      // ---------------------------------------------------
      ob_start();
      
      // ---------------------------------------------------
      // output the picture popup template
      // ---------------------------------------------------
      require($this->_templatefile);

      // ---------------------------------------------------
      // write buffer to a cache file
      // ---------------------------------------------------
      $filename = $this->_assetid . ".html";
      $hash = new GI_Hash($_SERVER["TEXT_CACHE_HOME"]);
      $pageHandle = fopen($hash->get($filename), "w");
      fwrite($pageHandle, ob_get_contents());
      fclose($pageHandle);

      // ---------------------------------------------------
      // output stored buffer
      // ---------------------------------------------------
      ob_end_flush();
    }
  }
}


// -------------------------------------------------------
// create a new page object
// -------------------------------------------------------
$page = new Page();

// -------------------------------------------------------
// build the page
// -------------------------------------------------------
$page->build();


?>
