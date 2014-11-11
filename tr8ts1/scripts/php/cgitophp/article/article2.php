?php

/**
 * This PHP article program will read the original contents of 
 * /cgi-bin/cgiarticle (that has been renamed from article) and
 * look for a <!-- insert citation --> comment tag and replace it with
 * the output generated from citation.php.
 * This program is useful for bridging PHP with our legacy article
 * CGI.
 */

//because we have to support solaris ...
//require_once("../../common/GI_SolarisEnvironment.php");

require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlcontent2.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlfile.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/common/utils/GI_Citation.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/common/article/GI_Content.php");
require_once('DB.php');

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
	    $httpFile = new GI_urlHttpFile($url);
	    $this->_content = $httpFile->read();
  	}
}

/**
 * Name         : Article
 * Created      : 03-13-06
 * Created by   : Diane Langlois
 * Comments     : This class is the entry point to the cgi to
 * php article wrapper.  This class gets the contant from
 * a url lookup to the old article cgi (that's been renamed)
 * and replaces the "insert citation" comment with the citation
 * data formatted by the citation class.
 */
class Article {
  
  /**
   * constructor for class, takes in the paramerter array
   * and builds the necessary stuff for an article
   * 
   * @access public
   * @return Article
   */

  	public function __construct() {

	$contentObject = new UrlContent();
	//-----------------------------------------------------
	// I need to look for the title override comment.
	// If found, it will be passed to the citation class
	// to be used instead of the asset title from the 
	// database.
	//-----------------------------------------------------
	$title = "";
   	if (preg_match('#<!-- citation_title=(.+?) -->#', $contentObject->get(), $matches)) {
   		$title = $matches[1];
   	}

    // -----------------------------------------------------
    // look for the <!-- exclude citation --> If found
    // ignore any <!-- insert citation --> flag.
    // -----------------------------------------------------
    if (strpos($contentObject->get(), '<!-- exclude citation -->')) {
    	//Exclude the citation generation content.
    	$this->_content = $contentObject->get();
    }
    
   else if (strpos($contentObject->get(), '<!-- insert citation -->')){
	$usePFEurl = false; //set to true in printemail pages.
    	$citationObject = new CitationContent($usePFEurl, $title);
 		// -----------------------------------------------------
    	// replace the <!-- insert citation --> comment with
    	// actual citation contents
    	// -----------------------------------------------------
    	$this->_content = preg_replace('#<!-- insert citation -->#', 
    		$citationObject->get(), $contentObject->get());
    }

   //else if (strpos($contentObject->get(), '<!-- insert citation rps -->')){
   else {	
	$usePFEurl = false; //set to true in printemail pages.
	$rpsFlag = true;
    	$citationObject = new CitationContent($usePFEurl, $title, $rpsFlag);
 		// -----------------------------------------------------
    	// replace the <!-- insert citation --> comment with
    	// actual citation contents
    	// -----------------------------------------------------
    	$this->_content = preg_replace('#<!-- insert citation rps -->#', 
    		$citationObject->get(), $contentObject->get());
    }

  }
  
	/**
	 * _content getter
	 *  @access public
	 *  @return unknown
	 */
	public function get() {
  		return $this->_content;
	}

}


// -------------------------------------------------------
// create a new article object
// -------------------------------------------------------
$page = new Article();
echo $page->get();

?>
