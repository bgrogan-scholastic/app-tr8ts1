
<?php

/*+ ---------------------------------------------------------------
 * This PHP list program will read the original contents of 
 * /cgi-bin/cgilist (that has been renamed from list) and
 * look for a <!-- insert citation --> comment tag and replace it with
 * the output generated from citation.php.
 * This program is useful for bridging PHP with our legacy list
 * CGI.
 * ---------------------------------------------------------------- -*/

//because we have to support solaris ...
//require_once("../../common/GI_SolarisEnvironment.php");

require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlcontent.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlfile.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/common/utils/GI_Citation.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/common/article/GI_Content.php");

require_once('DB.php');



/*+ ***********************************************************
 * Name         : GI_List
 * Created      : 03-13-06
 * Created by   : Diane Langlois
 * Comments     : This class is the entry point to the cgi to
 * php list wrapper.  This class gets the contant from
 * a url lookup to the old list cgi (that's been renamed)
 * and replaces the "insert citation" comment with the citation
 * data formatted by the citation class.
 ************************************************************** -*/

 /**
  * Class UrlContent
  * 
  * 12/06/2006 SJF PHP 5 Conversion.
  * 
  */
class UrlContent extends GI_Content {
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @return UrlContent
	 */
	public function __construct() {
	    // -----------------------------------------------------
	    // call base class
	    // -----------------------------------------------------
	    parent::__construct();
	
	    // -----------------------------------------------------
	    // build the url to the old article cgi
	    // -----------------------------------------------------
	    $theQueryString = $_SERVER['QUERY_STRING'];
	    if ($theQueryString == "") {
	    	//We're probably on a Solaris redirect where the QUERY_STRING gets 
	    	//zapped.  Will need to rebuild from the $_GET array - ugh!
			while (list($k, $v) = each($_GET)) $theQueryString = $theQueryString . $k . '=' . $v . '&';
	    }
	   	$url = "/cgi-bin-unauth/cgiarticle?" . $theQueryString;
	   
	    if ($_GET["url"] == "on") {
	      echo $url;
	    }
	    // -----------------------------------------------------
	    // get the content from the url
	    // -----------------------------------------------------
	    $httpFile = new GI_urlHttpFile("http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $url);
	    $this->_content = $httpFile->read();
  	}
}

class GI_List {
 /**
   * 
   * 
   * cmd 5/3/7  Modified to work with PHP 5
   *
   * 
   *  constructor for class, takes in the paramerter array
   * and builds the necessary stuff for a list
   * 
   * @access public
   * @return Article
   */

  	public function __construct() {
    $contentObject = new UrlContent();
	$usePFEurl = false; //set to true in printemail pages.
    $citationObject = new CitationContent($usePFEurl);
    // -----------------------------------------------------
    // replace the <!-- insert citation --> comment with
    // actual citation contents
    // -----------------------------------------------------
      $this->_content = preg_replace('#<!-- insert citation -->#', 
			$citationObject->get(), $contentObject->get());



  }
  	public function get() {
  		return $this->_content;
  	}

}


// -------------------------------------------------------
// create a new list object
// -------------------------------------------------------
$page = new GI_List();
echo $page->get();

?>
