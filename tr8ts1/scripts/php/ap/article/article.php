
<?php

/**
 * This is the article program PHP file. This program retrieves
 * remote url page contents and reformats them for use in the
 * American Presidency system. This requires a couple of things:
 * Get the url contents
 * strip out the <a href .. /a> links from the article
 * get the pictures from the remote server and save them locally
 * build the page
 * save it locally as a static html page
 * 
 * The program consists of a number of things, calling on classes
 * and sub-routines to do it's work.
 * 
 * 
 * 12/04/06 SJF: 
 * 
 * The previous version of this file is file contains many classes that define 
 * member variables by assignment.  I declared them as I found them.
 * 
 * There is a standalone function named getProductID() that assigns to 
 * $this->_servers.  I would assume that the function was to be a method
 * of the class defined before it.  It probably runs fine as standalone
 * anyway.
 * 
 * Several class also define getters in a non standard way:
 * 
 * eg, $protected ProductName;
 * 		public function ProductName() { return $this->ProductName; }
 * 
 * instead of
 * 		public function getProductName() { return $this->ProductName; }
 * 
 **/

require_once('DB.php');
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/common/utils/hash.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/utils/resizejpg.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlcontent.php");
require_once($_SERVER["PHP_INCLUDE_HOME"] . "/ap/common/network/urlfile.php");
require_once($_SERVER['PHP_INCLUDE_HOME'] . "/ap/common/servers.php");



/** 
 * Name         : Picture
 * Created      : 10-12-2003
 * Created by   : Doug Farrell
 * Comments     : This class handles information about the 
 * picture objects of the page. It saves the name, extension,
 * the hashed path of the image. It also gives access to the
 * thumbnail and the fullsize image with the new hashed pathname
 * and the alt text.
 * Parameters:
 *  $picInfo      This is the data returned from the content template
 * 
 * 12/4/2006 PHP 5 conversion.  Changed the doc to javadoc syntax
 *  
 * Note: The class defined had no member variables declared.  They 
 * were creating as needed by assignment.
 * 
 * There were no getters for these variables, missing the "get" prefix.
 * 
 * I am going to declare these member variables as protected.  I am 
 * assuing since the getters are here, that the are being retrieved 
 * by code using them.  If not, we should know where code exists
 * that know of member variables of a class that are not declared but
 * assumed.
 * 
 **/

class Picture {

	/**
	 * Creating during the PHP 5 conversion.  Previous did not declare it as a member.
	 * 
	 * @access protected
	 */
	protected $basename;
	
	/**
	 * Creating during the PHP 5 conversion.  Previous did not declare it as a member.
	 * 
	 * @access protected
	 */
	protected $_picfile;

	/**
	 * Creating during the PHP 5 conversion.  Previous did not declare it as a member.
	 * 
	 * @access protected
	 */
	protected $_thumbfile;
	
	/**
	 * Creating during the PHP 5 conversion.  Previous did not declare it as a member.
	 * 
	 * @access protected
	 */
	protected $_altText;
	
	
	
	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param unknown_type $domain
	 * @param unknown_type $port
	 * @param unknown_type $picInfo
	 * @return Picture
	 **/
	public function __construct($domain, $port, $picInfo) {
	// -----------------------------------------------------
	// create a hash object
	// -----------------------------------------------------
	$hash = new GI_Hash($_SERVER["PICTURES_CACHE_HOME"]);
	
	// -----------------------------------------------------
	// get the thumbnail picture info
	// -----------------------------------------------------
	preg_match('#(<img src=")(.*?)(" alt=")(.*?)">#is', $picInfo, $matches);
	$picpathinfo = pathinfo($matches[2]);
	
	// -----------------------------------------------------
	// get and save full size picture
	// -----------------------------------------------------
	$this->_basename = basename($picpathinfo["basename"], $picpathinfo["extension"]);
	$this->_basename = substr($this->_basename, 0, strlen($this->_basename) - 2);
	$filename = $this->_basename . "." . $picpathinfo["extension"];
	$full = new GI_urlFile("http://" . $domain . ":" . $port . $picpathinfo["dirname"] . "/" . $filename);
	$this->_picfile = $filename;
	$full->write($hash->get($this->_picfile));
	
	// -----------------------------------------------------
	// create the scaled values for width and height
	// -----------------------------------------------------
	$imageinfo = getimagesize($hash->get($this->_picfile));
	$width = 150;
	$height = (150 * $imageinfo[1]) / $imageinfo[0];
	
	// -----------------------------------------------------
	// create the thumbnail and save it
	// -----------------------------------------------------
	$thumbimg = resizejpg($hash->get($this->_picfile), $width, $height);
	$this->_thumbfile = basename($matches[2]);
	imagejpeg($thumbimg, $hash->get($this->_thumbfile));
	imagedestroy($thumbimg);
	
	// -----------------------------------------------------
	// get the alt text
	// -----------------------------------------------------
	 $this->_altText = $matches[4];
	}
  
	/**
	 * returns the picture assetid 
	 *
	 * @return unknown
	 * @access public
	 */
	public function assetid() {
		return $this->_basename;
	}
	
	/**
	 * returns the hashed thumbnail filepath
	 * @access public 
	 */
	  
	public function thumbfile() {
		return $this->_thumbfile;
	}
	  
	/**
	 * returns the hashed fullsize filepath
	 *
	 * @access public
	 */
	public function picfile() {
	  return $this->_picfile;
	}
	  
	/**
	 * returns the alt text 
	 *
	 * @return unknown
	 */
	public function altText() {
	    return $this->_altText;
	}
}


/**
 * Name         : Pictures
 * Created      : 10-27-2003
 * Created by   : Doug Farrell
 * Comments     : This is a collection class for Picture objects.
 * it will build the collectio of pictures based on the contents
 * of the <pictures>...</pictures> text section.
 * 12/4/2006 PHP 5 conversion.  Changed the doc to javadoc syntax
 *  
 * Note: The _pictures array was not declared as a member but is
 * used in that manner.  I added the declaration.
 * 
 *  
 */
class Pictures {
  
	/**
	 * array of pictures.  
	 * 
	 * Created 12/4/06 by SJF.  Previous version declared 
	 * the member by assignment.
	 * 
	 * @access protected
	 * 
	 */
	protected $_pictures = array();
	
  /**
   * Constructor
   *
   * @param unknown_type $domain
   * @param unknown_type $port
   * @param unknown_type $text
   * @return Pictures
   * @access public
   */
  
  public function __construct($domain, $port, &$text) {
    $pictext = trim($text);
		
    // -----------------------------------------------------
    // is there any picture content to process?
    // -----------------------------------------------------
    if (strlen($pictext) > 0) {
      $xmlcontent = new GI_xmlContent($pictext);
      $matches = $xmlcontent->getAll("picture");

      // ---------------------------------------------------
      // create hash for picture storage
      // ---------------------------------------------------
      $hash = new GI_Hash($_SERVER["PICTURES_CACHE_HOME"]);

      // ---------------------------------------------------
      // create picture object storage collection
      // ---------------------------------------------------
      $this->_pictures = array();

      // ---------------------------------------------------
      // are there any pictures to process?
      // ---------------------------------------------------
			if($matches == TRUE) {
    
				// -------------------------------------------------
				// loop through the list of pictures
				// -------------------------------------------------
				for($i = 0; $i < count($matches); ++$i) {

					// -----------------------------------------------
					// create the picture object in the collection
					// -----------------------------------------------
					$this->_pictures[] = new Picture($domain, $port, $matches[$i]);
				}
			}
    }
  }
  
  /**
   * Returns the element at $index from _pictures member.
   *
   * @param unknown_type $index
   * @return unknown
   * @access public
   */

  public function get($index) {
    if ($index >= 0 && $index < count($this->_pictures)) {
      $retval = $this->_pictures[$index];
    } else {
      $retval = 0;
    }
    return $retval;
  }

  /**
   * Returns the numner of elements in _pictures.
   *
   * @return unknown
   * @access public
   */
  public function count() {
    return count($this->_pictures);
  }
}


/**
 * Name         : Inaugural
 * Created      : 10-12-2003
 * Created by   : Doug Farrell
 * Comments     : This class handles retrieving the inaugural
 * text and provides the speeches() function to retrieve that
 * data so callers can determine if an inaugural speech exists.
 * Constructor  :
 *  $assetid      this is the assetid of the parent that has speeches
 *
 * 12/4/06 SJF PHP 5 conversion.  Created declaration of member variables.
 * They were created by assignment.
 * 
 * Concerns: The DB connection string is static.  The db connection is not 
 * a member and is created as needed by member functions.
 * 
 **/
class Inaugural {
	
	/**
	 * Asset ID
	 * 
	 * @access protected
	 */
	protected $_assetid;
	
	/**
	 * Speeches
	 * 
	 * @access protected
	 */
	protected $_speeches;
	
	/**
	 * Servers
	 * 
	 * @access protected
	 */
	protected $_servers;
	
	/**
	 * constructor for class, takes the assetid and gets the 
	 * speech information
	 *
	 * @param unknown_type $assetid
	 */
  public function __construct($assetid) {
		$this->_assetid = $assetid;

    // -----------------------------------------------------
    // connect to the database
    // -----------------------------------------------------
    $db = DB::connect('mysql://ap:ap@localhost/ap');
    
    // -----------------------------------------------------
    // did we get an error from the connection?
    // -----------------------------------------------------
    if (!DB::isError($db)) {
      $sql =  "select a2.id, a2.title ";
      $sql .= "from assets a1, assets a2, relations r ";
      $sql .= "where a1.id='" . $assetid . "' ";
      $sql .= "and a1.id=r.parent_id ";
      $sql .= "and a2.id=r.child_id ";
      $sql .= "and a2.type='0tas'";

      // ---------------------------------------------------
      // get the list back and put it in an array
      // ---------------------------------------------------
      $this->_speeches = $db->getAll($sql, DB_FETCHMODE_ASSOC);

      // ---------------------------------------------------
      // did we get an error on the query?
      // ---------------------------------------------------
      if (DB::isError($this->_speeches)) {
        echo $this->_servers->getDebugInfo() . "<br>";
      }
    // -----------------------------------------------------
    // otherwise, nope, didn't get a connection
    // -----------------------------------------------------
    } else {
      die ($db->getMessage());
    }
    $db->disconnect();
  }
  
  /**
   * Returns output.
   *
   * @param unknown_type $speechFormat
   * @param unknown_type $speechesFormat
   * @return unknown
   * @access public
   */
	public function output($speechFormat, $speechesFormat) {
    // -----------------------------------------------------
    // are we doing multiple speeches?
    // -----------------------------------------------------
		if(count($this->_speeches) > 1) {

			// ---------------------------------------------------
			// create a file to save the speeches data in
			// ---------------------------------------------------
			$hash = new GI_Hash($_SERVER["DOCUMENT_ROOT"] . "/text/cache");
			$filepath = $hash->get($this->_assetid . "_speeches.html");
			$handle = fopen($filepath, 'w');

			// ---------------------------------------------------
			// write a line to the file for each speech
			// ---------------------------------------------------
			foreach($this->_speeches as $speech) {
				$assetid = $speech['id'];
				$title   = $speech['title'];
				$buffer = sprintf($speechFormat . "\n", $assetid, $title);
				fwrite($handle, $buffer);
			}
			fclose($handle);

			// ---------------------------------------------------
			// output the button to access the list
			// ---------------------------------------------------
			return sprintf($speechesFormat, $this->_assetid);

    // -----------------------------------------------------
    // otherwise, single speech
    // -----------------------------------------------------
		} else if(count($this->_speeches) == 1) {
			$assetid = $this->_speeches[0]['id'];
			$template = '<a href="/article?assetid=%s&templatename=/article/article.html"><img src="/images/common/inaugural_btn.gif" width="150" height="17" border="0" alt="Inaugural Address" title="Inaugural Address"></a><br><br>';
			return sprintf($template, $assetid);
		}
	}
}


/**
 * Name         : getProductID
 * Created      : 10-12-2003
 * Created by   : Doug Farrell
 * Comments     : This function handles getting the product id
 * characters from the database based on the assetid passed in
 * Parameters   :
 *  $assetid       assetid of requested product
 * Returns      :
 *                 string containing the product id 
 * 
 * 12/04/06 SJF: No changes have been made to the following function.
 * 
 * It is not a method, it is a standalone function as it is not 
 * enclosed in a class definition.
 * 
 * I appears that it wants to be a method and I would assume of the
 * class defined above it as it want to to access the member variable
 * $_servers.
 * 
 */
function getProductID($assetid) {
  // -------------------------------------------------------
  // connect to the database
  // -------------------------------------------------------
  $db = DB::connect('mysql://ap:ap@localhost/ap');
    
  // -------------------------------------------------------
  // did we get an error from the connection?
  // -------------------------------------------------------
  if (!DB::isError($db)) {
    $sql = "select product_flag from assets where id='" . $assetid . "'";

    // -----------------------------------------------------
    // get the product id from the database
    // -----------------------------------------------------
    $product_flag= $db->getOne($sql, DB_FETCHMODE_ASSOC);
	
    // -----------------------------------------------------
    // did we get an error on the query?
    // -----------------------------------------------------
    if (DB::isError($this->_servers)) {
      echo $this->_servers->getDebugInfo() . "<br>";
    }
  // -------------------------------------------------------
  // otherwise, nope, didn't get a connection
  // -------------------------------------------------------
  } else {
    die ($db->getMessage());
  }
  $db->disconnect();
  return $product_flag;
}

/**
 * Content
 * 
 * 12/04/06 PHP 5 conversion.
 * 
 * Declared the member variables that were defined by assignment.  They are protected.
 * 
 * The descendents of Content defined by assignment $this->_content which was
 * also defined by assignment here.  Now it is declared in Content and not the 
 * descendents.
 * 
 */
class Content {
	
	/**
	 * @access protected
	 */
	protected $_content;
    
	/**
	 * @access protected
	 */
	protected $_productid;
    
	/**
	 * @access protected
	 */
	protected $_assetid;
    
	/**
	 * @access protected
	 */
	protected $_templatefile;
    
	/**
	 * @access protected
	 */
	protected $_servers;
    
	/**
	 * @access protected
	 */
	protected $_productName;
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $params
	 * @return Content
	 * @access public
	 */
	function __construct($params) {
    $this->_content = "";
    $this->_productid = strtoupper(getProductID($params['assetid']));
    $this->_assetid = $params['assetid'];
    $this->_templatefile = $params['templatefile'];
    $this->_servers = new GI_getServers('AP', $this->_productid);
    $this->_productName = $this->_servers->name();
  }
  function get() {
    return $this->_content;
  }
  
  
/* 12/04/06 SJF getting redeclaration error here uing ZEND
   code analysis.  I would comment it out, but some code 
   somewhere might be calling it.
*/
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
	
	/**
	 * Constructor
	 *
	 * @param unknown_type $params
	 * @return UrlContent
	 * @access public
	 */
  public function __construct($params) {
    // -----------------------------------------------------
    // call base class
    // -----------------------------------------------------
    parent::__construct($params);

    // -----------------------------------------------------
    // build the url to the server using article if not factbox
    // -----------------------------------------------------
		if(strstr($this->_assetid, "gefb") != TRUE) { 
			$url = "http://" . $this->_servers->domain(0) . ":" . $this->_servers->port(0) . "/cgi-bin/article?assetid=" . $this->_assetid . "&templatename=/ap/article.html";

    // -----------------------------------------------------
    // otherwise, use the list program
    // -----------------------------------------------------
		} else {
			$url = "http://" . $this->_servers->domain(0) . ":" . $this->_servers->port(0) . "/cgi-bin/list?assetid=" . $this->_assetid . "&assettype=0taf&templatename=/ap/asset.html";
		}
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

class DBContent extends Content {

	/**
	 * Constructor
	 *
	 * @param unknown_type $params
	 * @return DBContent
	 * @access public
	 */
	public function __construct($params) {
    // -----------------------------------------------------
    // call base class
    // -----------------------------------------------------
    parent::__construct($params);

    // -----------------------------------------------------
    // connect to the database
    // -----------------------------------------------------
    $db = DB::connect('mysql://ap:ap@localhost/ap');
    
    // -----------------------------------------------------
    // did we get an error from the connection?
    // -----------------------------------------------------
    if (!DB::isError($db)) {
      $sql = "select speech from assets where id='" . $this->_assetid . "' and type='0tas'";

      // ---------------------------------------------------
      // get the speech back and put it in the content
      // ---------------------------------------------------
      $this->_content = "<content><text>";
      $this->_content .= $db->getOne($sql, DB_FETCHMODE_ASSOC);
      $this->_content .= "</text></content>";

      // ---------------------------------------------------
      // did we get an error on the query?
      // ---------------------------------------------------
      if (DB::isError($this->_speeches)) {
        echo $this->_servers->getDebugInfo() . "<br>";
      }
    // -----------------------------------------------------
    // otherwise, nope, didn't get a connection
    // -----------------------------------------------------
    } else {
      die ($db->getMessage());
    }
    $db->disconnect();
  }
}


function contentFactory($productid, $params) {
  $contentObject = "";

  // -------------------------------------------------------
  // do we have a product id?
  // -------------------------------------------------------
  if (strlen($productid) >= 2) {
    $contentObject = new UrlContent($params);
  
  // -------------------------------------------------------
  // otherwise, nope, must be an inaugural
  // -------------------------------------------------------
  } else {
    $contentObject = new DBContent($params);
  }
  return $contentObject;
}


/**
 * Name         : Article
 * Created      : 10-9-2003
 * Created by   : Doug Farrell
 * Comments     : This class is the primary entry point for producing
 * the article page. It is also the used in the template itself 
 * to connect code content with template content. The constructor
 * of the class gets an array of parameters which it uses to 
 * initialize the class.
 * 
 * 12/04/06 SJF PHP 5 conversion.  
 * 
 * This class defined several member variables by assignment.  I declare them
 * as protected.
 * 
 */
class Article {
	
	/**
	 * Product ID
	 * @access protected
	 */
	protected $_productid;
	
	/**
	 * Asset ID
	 * @access protected
	 */
	protected $_assetid;
	
	/**
	 * Template file
	 * @access protected
	 */
	protected $_templatefile;
	
	/**
	 * Product Name
	 * @access protected
	 */
	protected $_productName;
	
	/**
	 * Text
	 * @access protected
	 */
	protected $_text;
	
	/**
	 * Pictures
	 * @access protected
	 */
	protected $_pictures;
	
	/**
	 * constructor for class, takes in the paramerter array
	 * and builds the necessary stuff for an article
	 */

  public function __construct($params) {
    $this->_productid = strtoupper(getProductID($params['assetid']));
    $this->_assetid = $params['assetid'];
    $this->_templatefile = $params['templatefile'];

    // -----------------------------------------------------
    // get a content object and read the raw content text
    // -----------------------------------------------------
    $contentObject = contentFactory($this->_productid, $params);
    $this->_productName = $contentObject->productName();
    $rawtext = $contentObject->get();

    // -----------------------------------------------------
    // *** KLUDGE ALERT ***
    // kludge for factboxes (yucky!!)
		// 'insert' the XML <pictures><picture>..</picture></pictures>
		// tags into the text for the factbox picture
    // -----------------------------------------------------
		$rawtext = preg_replace('#(<img src="/gme-ol/media/.*?/gefb.*?)(\.jpg")(.*?">)#is', '<pictures><picture>$1t$2 alt=" "$3</picture></pictures>' . "\n", $rawtext);

    // -----------------------------------------------------
    // get the content by sections
    // -----------------------------------------------------
    $xmlcontent = new GI_xmlContent($rawtext);
    $this->_text =  $xmlcontent->getOne("text");
    
    // -----------------------------------------------------
    // get the pictures object from the content
    // -----------------------------------------------------
    $servers = $contentObject->servers();
    $this->_pictures = new Pictures($servers->domain(0), $servers->port(0), $xmlcontent->getOne("pictures"));
  }
  
  /**
   * get the 'content provided by' stuff
   *
   * @return unknown
   * @access public
   */
  public function contentProvidedBy() {
		$retval = "";

		// -----------------------------------------------------
		// is this an innaugural speech?
		// -----------------------------------------------------
		if(!strstr($this->_assetid, "apia")) {
			$retval  = '<div class="iright">[Content provided by the <a href="';
			$retval .= 'javascript:thePopup.blurbWindow(\'http://go.grolier.com/go-ol/static/marketing/go_form.html?product=';
			$retval .= strtolower($this->productID());
			$retval .= '\', 400, 400, \'whoareyou\', \'off\');"><b>';
			$retval .= $this->productName();
			$retval .= "</b></a>]</div>\n";

		// -----------------------------------------------------
		// otherwise, output placeholding table cell
		// -----------------------------------------------------
		} else {
			$retval = "\n";
		}
		return $retval;
  }
  
  /**
   * get the fully path template filepath
   */
  public function templatefile() {
    return $this->_templatefile;
  }
  
  /**
   * get the fully qualified product name
   */
  public function productName() {
    return $this->_productName;
  }
  
  /**
   * get the the product_flag value
   */
  public function productID() {
    if (strlen($this->_productid) >= 2) {
      return $this->_productid;
    } else {
      return "ap" . $this->_productid;
    }
  }
  
  /**
   * 12/04/06 SJF This was commented out in the previous version
  // -------------------------------------------------------
  // get the fully qualified product link
  // -------------------------------------------------------
  //function productLink() {
  //  return "/help.html#" . strtolower($this->_productid);
  // }
  // -------------------------------------------------------
  // get the cleaned up text from the raw content
  // -------------------------------------------------------

  /**
   * Get text
   * @access public
   */
  public function text() {
    $text = $this->_text;
    
    // -----------------------------------------------------
    // redirect the entities for EAS
    // -----------------------------------------------------
		if($this->_productid == "EAS") {
			$text = preg_replace('#<img SRC="(/media/.*?/)(.*?)">#is', '<img src="/images/entities/$2">', $text);

    // -----------------------------------------------------
    // otherwise, do everyone else
    // -----------------------------------------------------
		} else {
			$text = preg_replace('#<img src="(/.*?ol/media/.*?/)(.*?)">#is', '<img src="/images/entities/$2">', $text);
		}
    // -----------------------------------------------------
    // *** KLUDGE ALERT ***
		// This is to fix the pathing for factbox picture
		// MUST follow redirect the entities code above
    // -----------------------------------------------------
		if(strstr($this->_assetid, "gefb")) {
			$hash = new GI_Hash($_SERVER["PICTURES_CACHE_HOME"]);
			$picture = $this->_pictures->get(0);
			$picfile = $picture->picfile();

			$text = preg_replace('#(<pictures><picture>)(<img src=")(/images/entities/gefb.*?)(".*?">)(</picture></pictures>)#is', "$2/images/cache/" . $hash->hval($picfile) . "/" . $picfile . "$4", $text);
		}
    // -----------------------------------------------------
    // get rid of EAS academic citation
    // -----------------------------------------------------
    if ($this->_productid == "EAS") {
      if (preg_match("#<p><hr.*?Academic Citation</.></span></b></p>#s", $text)) {
				$text = preg_replace("#<p><hr.*?Academic Citation</.></span></b></p>#s", "", $text);
      }
    }
    // -----------------------------------------------------
    // get rid of NBK further reading
    // -----------------------------------------------------
    if ($this->_productid == "NBK") {
				if (preg_match('#<a href="javascript:OpenBlurbWindow.*?Further Reading</a>#', $text)) {
				$text = preg_replace('#<a href="javascript:OpenBlurbWindow.*?Further Reading</a>#', "", $text);
      }
    }
    // -----------------------------------------------------
    // get rid of table of contents 
    // -----------------------------------------------------
    if ($this->_productid == "GME" || $this->_productid == "EAS") {
      if (preg_match("#<!--toc-popup-->.*?</p>#", $text)) {
				$text = preg_replace("#<!--toc-popup-->.*?</p>#", "<p></p>", $text);
      }
    } elseif ($this->_productid == "NBK") {
      if (preg_match("#<a href.*?Table of Contents</a><br>#", $text)) {
				$text = preg_replace("#<a href.*?Table of Contents</a><br>#", "", $text);
      }
		}
    // -----------------------------------------------------
    // get rid of embedded popups in EA
    // -----------------------------------------------------
    if ($this->_productid == "EA") {
			$text = preg_replace("#<a HREF=.javascript.*?</a>#is", "", $text);

      // ---------------------------------------------------
			// replace the 'runin' style with 'earunin'
      // ---------------------------------------------------
			$text = preg_replace('#<span class="runin">#is', '<span class="earunin">', $text);
		}
    // -----------------------------------------------------
    // get rid of hrefs
    // -----------------------------------------------------
    $text = preg_replace("#<a href=.*?>(.*?)</a>#is", "$1", $text);

    // -----------------------------------------------------
    // restore the 'top of page' links
    // -----------------------------------------------------
    if ($this->_productid == "NBK") {
			$text = preg_replace("#<p>Go to Top of Page</p>#", "<p><a href='#topOfpage'>Go to Top of Page</a></p>", $text);
    }
    if ($this->_productid == "ATB") {
			$text = preg_replace("#Back To Top#", "<a href='#topOfpage'>Top of Page</a>", $text);
    }
    // -----------------------------------------------------
    // return the completed text
    // -----------------------------------------------------
    return $text;
  }

  /**
   * get the list of assets into the page with the correct
   * pathing. This also sizes the images dynamically based
   * on the image size and the destination width (150).
   *
   * @param unknown_type $pictureTemplate
   * @param unknown_type $moreTemplate
   * @param unknown_type $maxpicture
   * @return unknown
   * @access public
   */
  public function pictures($pictureTemplate, $moreTemplate, $maxpicture) {
    $retval = "";

    // -----------------------------------------------------
    // *** KLUDGE ALERT ***
		// This is to prevent factbox pictures being presented
		// as an asset
    // -----------------------------------------------------
		if(strstr($this->_assetid, "gefb")) {
			return $retval;
		} 
    // -----------------------------------------------------
    // create the thumbnail hash object
    // -----------------------------------------------------
    $hash = new GI_Hash($_SERVER["PICTURES_CACHE_HOME"]);

    // -----------------------------------------------------
    // loop for max number of pictures
    // -----------------------------------------------------
    for($i = 0; $i < $this->_pictures->count() && $i < $maxpicture; ++$i) {
      $picture = $this->_pictures->get($i);
      $thumbfile = $picture->thumbfile();
      $altText = $picture->altText();
			
      // ---------------------------------------------------
      // calculate the dynamic image size
      // ---------------------------------------------------
      $imageinfo = getimagesize($hash->get($thumbfile));
      $width  = $imageinfo[0];
      $height = $imageinfo[1];

      // ---------------------------------------------------
      // output the image information
      // ---------------------------------------------------
      $retval .= sprintf($pictureTemplate . "\n", strtolower($this->_productid), $picture->assetid(), $picroot . "/images/cache/" . $hash->hval($thumbfile) . "/" . $thumbfile, $width, $height, $altText);
    }
    // -----------------------------------------------------
    // do we need to put up the more button?
    // -----------------------------------------------------
    if ($this->_pictures->count() > $maxpicture) {
			// ---------------------------------------------------
			// create a hash for the output file
			// ---------------------------------------------------
			$hash = new GI_Hash($_SERVER["DOCUMENT_ROOT"] . "/text/cache");
			$handle = fopen($hash->get($this->_assetid . "_pictures.html"), "w");

			// ---------------------------------------------------
			// create the format string
			// ---------------------------------------------------
			$popup = '<a href="/picturepopup?productid=%1$s&assetid=%2$s&templatename=/article/picturepopup.html">%3$s</a>' . "\n";

			// ---------------------------------------------------
			// loop through all the pictures
			// ---------------------------------------------------
			for($i = 0; $i < $this->_pictures->count(); ++$i) {
				$picture = $this->_pictures->get($i);
				fwrite($handle, sprintf($popup, strtolower($this->_productid), $picture->assetid(), $picture->altText()));
			}
			fclose($handle);

      $moreTemplate .= "\n";
      $retval .= sprintf($moreTemplate, strtolower($this->_productid), $this->_assetid);
    }
    return $retval;
  }
  
  /**
   * conditionally get the inaugural button
   *
   * @param unknown_type $inauguralSpeechButton
   * @param unknown_type $inauguralSpeechesButton
   * @return unknown
   * @access public
   */
  public function inaugural($inauguralSpeechButton, $inauguralSpeechesButton) {
    // -----------------------------------------------------
    // output the correct inaugural information
    // -----------------------------------------------------
    $inaugural = new Inaugural($this->_assetid);
		return $inaugural->output($inauguralSpeechButton, $inauguralSpeechesButton);
  }
  
  /**
   * build the list of related articles
   *
   * @param unknown_type $header
   * @param unknown_type $format
   * @return unknown
   * @access public
   */
  public function relatedArticles($header, $format) {
    $retval = "";

    // -----------------------------------------------------
    // connect to the database
    // -----------------------------------------------------
    $db = DB::connect('mysql://ap:ap@localhost/ap');
    
    // -----------------------------------------------------
    // did we get an error from the connection?
    // -----------------------------------------------------
    if (!DB::isError($db)) {
      $sql = "select a2.id, a2.title from assets a1, assets a2, relations r where a1.id='" . $this->_assetid . "' and a1.id=r.parent_id and a2.product_flag <> '' and r.child_id=a2.id";

      // ---------------------------------------------------
      // get the list back and put it in an array
      // ---------------------------------------------------
      $relatedArticles = $db->getAll($sql, DB_FETCHMODE_ASSOC);

      // ---------------------------------------------------
      // did we get an error on the query?
      // ---------------------------------------------------
      if (!DB::isError($this->_speeches)) {

	// -------------------------------------------------
	// are there any related articles?
	// -------------------------------------------------
	if (count($relatedArticles) > 0) {
	  $retval .= $header . "\n";

	  // -----------------------------------------------
	  // loop through the list of articles
	  // -----------------------------------------------
	  foreach($relatedArticles as $article) {
	    $retval .= sprintf($format . "\n", $article["id"], $article["title"]);
	  }
	}
      // ---------------------------------------------------
      // otherwise, yep, got an error
      // ---------------------------------------------------
      } else {
        echo $this->_servers->getDebugInfo() . "<br>";
      }
    // -----------------------------------------------------
    // otherwise, nope, didn't get a connection
    // -----------------------------------------------------
    } else {
      die ($db->getMessage());
    }
    $db->disconnect();

    // -----------------------------------------------------
    // return the related articles text
    // -----------------------------------------------------
    return $retval;
  }
}



/**
 * Name         : Page
 * Created      : 10-27-2003
 * Created by   : Doug Farrell
 * Comments     : This class manages the actual page. It will
 * build the page from scratch if necessary, or get it from the
 * cache system if it can. 
 *
 * 12/04/06 SJF PHP 5 conversion.
 */
class Page {

	/**
	 * Asset ID
	 * @access protected
	 */
	protected $_assetid;
	
	/**
	 * Template file
	 * @access protected
	 */
	protected $_templatefile;
	
  /**
   * this is the constructor for the object
   * @access public
   */
	public function __construct() {
   	 $this->_assetid      = $_GET["assetid"];
   	 $this->_templatefile = $_SERVER["TEMPLATE_HOME"] . $_GET["templatename"];
  }
  
  /**
   * this method builds the page from scratch
   * @access public
   */
  public function build() {
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
    // otherwise, nope, so build the contents from scratch
    // -----------------------------------------------------
    } else {
      // ---------------------------------------------------
      // build the article object
      // ---------------------------------------------------
      $article = new Article(array("assetid" => $this->_assetid, 
				   "templatefile" => $this->_templatefile));

      // ---------------------------------------------------
      // turn on output buffering
      // ---------------------------------------------------
      ob_start();
      
      // ---------------------------------------------------
      // output the article template
      // ---------------------------------------------------
      require($article->templatefile());

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
