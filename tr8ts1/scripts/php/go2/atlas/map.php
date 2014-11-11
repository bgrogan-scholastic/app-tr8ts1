<?php
// turn on gzip compression
ob_start("ob_gzhandler");

// get the required include code libraries
define('SERVER_PHP_INCLUDE_HOME', $_SERVER['PHP_INCLUDE_HOME']);

require_once('./atlasDB.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/cs/client/CS_Client.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_getVariable.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_Hash.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Base/package.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/auth/GI_AuthPreferences.php');

// define some atlas constants
//require_once('./constants.php');


/**
 * This class provides the basic and common map object.
 * It retrieves map assets from the Content Server and saves
 * them locally for display, and uses the local copy if it 
 * has one. It provides the common API methods of the map
 * and is the parent class for all other derived classes of map 
 * objects, which can provide additional/different processing.
 * The entire reason for this class existing is to provide the image
 * that is called by the map <img src=" ... "> tag in the atlas
 * program.
 *
 * Name       : MapBase
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * 
 * 12/05/2006 SJF PHP 5 conversion
 * 
 */
class MapBase extends GI_Base {
	
	/**
	 * This is an instance of a database connection
	 * @param     $_csClient
	 * @access protected enforced 12/05/2006 SJF- if accessed directly it can be changed to public
	 */
	protected $_db;
	
	/**
	 * This is an instance of a Content Server connection
	 * @param     $_csClient
	 * @access protected enforced 12/05/2006 SJF- if accessed directly it can be changed to public
	 */
	protected $_csClient = null;
	
	/**
	 * This is the params array, which holds the $_GET stuff, avoiding xemacs issues
	 * @param      $_params
	 * @access protected enforced 12/05/2006 SJF- if accessed directly it can be changed to public
	 */
	protected $_mapData = array();
	
	/**
	 * This is the filename of the atlas map asset
	 * @param     $_filename     string containing filename of the atlas map asset
	 * @access protected enforced 12/05/2006 SJF- if accessed directly it can be changed to public
	 */
	
	protected $_filename = null;
	/**
	 * This is the pathname of the atlas map asset
	 * @param     $_pathname     string containing pathname of the atlas map asset
	 * @access protected enforced 12/05/2006 SJF- if accessed directly it can be changed to public
	 */
	protected $_filepath = null;
		
	/**
	 * Constructor
	 *
	 * This method intializes the class and actually gets the map
	 * assets from the content server and saves it locally to disk.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @access public
	 */
	public function __construct() {
		// call parent constructor
		parent::__construct();
	    // set the logging levels and file
    	$this->setDebugLogLevels(1);
		// create an AtlasDB object
		$this->_db = & new AtlasDB();
		// initialize the parameters variable
		$this->_params = array();
		$this->_params[PRODUCTID] = GI_getVariable(PRODUCTID) != null ? GI_getVariable(PRODUCTID) : GO_PRODUCT_ID;
		$this->_params[ASSET_ID]  = GI_getVariable(ASSET_ID) != null ? GI_getVariable(ASSET_ID) : ROOTMAP;
		$this->_params[OPTION]    = GI_getVariable(OPTION) != null ? GI_getVariable(OPTION) : null;
		$this->_params[TYPE]      = GI_getVariable(TYPE) != null ? GI_getVariable(TYPE) : null;
		$this->_params[POI_ID]    = GI_getVariable(POI_ID) != null ? GI_getVariable(POI_ID): null;
		$this->_params[SPOT_ID]   = GI_getVariable(SPOT_ID) != null ? GI_getVariable(SPOT_ID): null;
		$this->_params[SPOT_ID_ONE]  = GI_getVariable(SPOT_ID_ONE) != null ? GI_getVariable(SPOT_ID_ONE): null;
		$this->_params[SPOT_ID_TWO]  = GI_getVariable(SPOT_ID_TWO) != null ? GI_getVariable(SPOT_ID_TWO): null;
		// create authentication object here
		$this->_auth = & new GI_AuthPreferences();
		// get some data about the assetid
		$data = $this->_db->query(sprintf("select * from assets where asset_id='%s'", $this->_params[ASSET_ID]));
		// didn't get back and error did we?
		if(!DB::isError($data)) {
			// iterate over the data and put it into our array
			foreach($data[0] as $key => $value) {
				$this->_mapData[$key] = $value;
			}
		}
		// set the header information appropriately for the map type
		if($this->_mapData[MAP_FEXT] == "png") {
			header("Content-type: image/png");
		} else {
			header("Content-type: image/jpg");
		}
		// get the map asset file information
		$this->_filename = $this->_mapData[MAP_ASSET_ID] . "." . $this->_mapData[MAP_FEXT];
		$docRoot = $_SERVER['DOCUMENT_ROOT'];
		$this->_fullpath = GI_hashFilename($this->_filename, $docRoot . MAP_DOC_ROOT);
		$this->_filepath = substr($this->_fullpath, strlen($docRoot), strlen($this->_fullpath) - strlen($docRoot));
		// can we get the asset from the content server?
		if(array_key_exists(PRODUCTID, $this->_params) && array_key_exists(ASSET_ID, $this->_params)) {
			// are we rebuilding or does the asset not exist locally?
			$rebuild = GI_getVariable(GI_REBUILD);
			if(($rebuild != null and $rebuild == GI_YES) or !file_exists($this->_fullpath)) {
				// only require GI_MediaAsset when needed
				require_once(SERVER_PHP_INCLUDE_HOME . 'common/article/GI_MediaAsset.php');
				// get the map image asset
				$mapImage = new GI_MediaAsset(array(CS_PRODUCTID => $this->_params[PRODUCTID], CS_ASSETID => $this->_mapData[MAP_ASSET_ID], MAP_FEXT => $this->_mapData[MAP_FEXT]));
				if(GI_Base::isError($mapImage)) {
					$this->_raiseError(sprintf('%s failed to connect to Content Server, message is : %s', __CLASS__, $this->_csClient->getMessage()), 4, 4);
				}
			}
		// otherwise, invalid or missing parameters in $params
		} else {
			$this->_raiseError(sprintf('Invalid parameters in %s constructore', __CLASS__), 4, 4);
		}
	}

	
	/**
	 * destructor
	 *
	 * This is the 'destructor' for the class, basically cleaning up anything,
	 * mostly the database
	 *
	 * @access public 12/05/2006 SJF The previous doc has this as private, but it is called
	 * by code outside of thic class.  This is a candidate to become a true PHP 5 destructor.
	 */
	public function destructor() {
		$this->_db->disconnect();
	}

	
	/**
	 * get the file name.
	 *
	 * @return unknown
	 * @access public
	 */
	public function getFilename() {
		$retval = NULL;
		// do we have a valid filename?
		if($this->_filename != NULL) {
		// otherwise, not initialized yet
		} else {
			$this->_raiseError(sprintf("%s object not initialized yet", __CLASS__), 4, 4);
		}
		return $retval;
	}

	/**
	 * get thefile path
	 *
	 * @return unknown
	 * @access public
	 */
	public function getFilepath() {
		$retval = NULL;
		// do we have a valid filepath?
		if($this->_filepath != NULL) {
			$retval = $this->_filepath;
		// otherwise, not initialized yet
		} else {
			$this->_raiseError(sprintf("%s object not initialized yet", __CLASS__), 4, 4);
		}
		return $retval;
	}

	/**
	 * get the full path
	 *
	 * @return unknown
	 * @access public
	 */
	public function getFullpath() {
		$retval = NULL;
		// do we have a valid fullpath?
		if($this->_fullpath != NULL) {
			$retval = $this->_fullpath;
		// otherwise, not initialized yet
		} else {
			$this->_raiseError(sprintf("%s object not initialized yet", __CLASS__), 4, 4);
		}
		return $retval;
	}
	
	/**
	 * output
	 *
	 * This method performs the actual output of the map asset image.
	 * Internally it calls the _processImage() function to do any
	 * image processing relative to the params passed in on the URL.
	 * The derived classes override this method to provide their unique
	 * image processing
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @return		: returns nothing, as there is no one after this to catch anything
	 * @access public
	 */
	public function output() {
		// is the map asset image a png?
		$image = null;
		//$mapImage = null;
		if($this->_mapData[MAP_FEXT] == "png") {
			// get the map image into memory
			$map = imagecreatefrompng($this->_fullpath);
			//$image = imagecreatefrompng($this->_fullpath);
			// create a true color image work area
			$image = imagecreatetruecolor(imagesx($map), imagesy($map));
			// copy the map into the true color work area
			imagecopy($image, $map, 0, 0, 0, 0, imagesx($map), imagesy($map));
			// destroy the temporary map image
			imagedestroy($map);
		// otherwise, it's a jpg
		} else {
			$map = imagecreatefromjpg($this->_fullpath);
			// create a true color image work area
			$image = imagecreatetruecolor(imageSX($map), imageSY($map));
			// copy the map into the true color work area
			imagecopy($image, $map, 0, 0, 0, 0, imageSX($map), imageSY($map));
			// destroy the temporary map image
			imagedestroy($map);
		}
		// did we process the image correctly?
		if(GI_Base::isError($this->_processImage($image))) {
			$this->_raiseError(sprintf("%s : error processing map image", __CLASS__), 4, 4);
		}
		// convert the true color image to a pallete image
		imagetruecolortopalette($image, false, 256);
		// output the image
		imagepng($image);
		// destroy the images and clean up
		imagedestroy($image);
	}

	/**
	 * _processImage
	 *
	 * This method performs the actual image processing for each
	 * type of map to display. It is overridden in derived classes
	 * to provide the unique processing type.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @return		: true if successful, GI_Error object if not
	 * @access public SJF 12/05/2006  
	 */
	public function _processImage(& $image) {
		$retval = true;
		// put up the POI images
		$this->_processPOI($image);
		// do we need to highlight a spot as a result of search?
		if($this->_params[SPOT_ID] != null) {
			$this->_processSpot($image);
		}
		return $retval;
	}
	
	/**
	 * _processPOI
	 *
	 * This method paints the POI cameras on the image
	 * in the right location according to the database.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @access public
	 */
	public function _processPOI(& $image) {
		// define some constants for this function
		define('X1', 0);
		define('Y1', 1);
		// query the database for point of interest spots
		$sql  = "SELECT coords ";
		$sql .= "FROM spots, spot_relations ";
		$sql .= "WHERE spots.asset_id='%s' ";
		$sql .= "AND spots.spot_id=spot_relations.spot_id ";
		$sql .= "AND spot_type='p'";
		$data = $this->_db->query(sprintf($sql, $this->_params[ASSET_ID]));
		// did we get data?
		if(!DB::isError($data)) {
			// get the camera image into memory
			$camera = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/images/atlas/camera.gif');
			// output the POI camera icons
			foreach($data as $row) {
				// build array of points
				$points = explode(" ", $row["coords"]);
				// paint the camera onto the map
				imagecopy($image, $camera, $points[X1], $points[Y1], 0, 0, imagesx($camera), imagesy($camera));
			}
		// otherwise, failed to get data
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get poi spots"), 4, 4);
		}
      $relatedFormat = '%s: <a class="ilist" href="%s">%s</a><br>';
		// otherwise, got an error on the related assets
		
	}

	/**
	 * _processSpot
	 *
	 * This method highlights a spot as a result of spid being specified 
	 * in the URL.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @access public
	 */
	public function _processSpot(& $image) {
		define('X1', 0);
		define('Y1', 1);
		// query the database for the search spot
		$sql  = "SELECT coords ";
		$sql .= "FROM spots ";
		$sql .= "WHERE spot_id='%s'";
		$data = $this->_db->query(sprintf($sql, $this->_params[SPOT_ID]));
		// did we get data?
		if(!DB::isError($data)) {
			// get the data instance
			$spot = $data[0];
			// build array of coordinates
			$poly = explode(" ", $spot[SPOTS_COORDS]);
			// get our yellow highlight color
		  $fillColor = imagecolorallocatealpha($image, 255, 255, 0, 90);
		  // did we allocate the color?
		  if($fillColor) {
		  	// do we have enough points for a polygon?
		  	$count = count($poly) / 2;
		  	if($count > 2) {
			  	// paint the spot on the map
			  	$ret = imagefilledpolygon($image, $poly, count($poly) / 2, $fillColor);
			  // otherwise, nope, use a rectangle
		  	} else {
			  	$ret = imagefilledrectangle($image, $poly[0], $poly[1], $poly[2], $poly[3], $fillColor);
		  	}
		  	// deallocate the color
		  	$ret = imagecolordeallocate($image, $fillColor);
		  } else {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to allocate spot color"), 4, 4);
		  }
		// otherwise, failed to get data
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get spot_id data"), 4, 4);
		}
	}
}	
	
/**
 * This class provides the basic (simplist) map functionality
 *
 * Name       : MapBasic
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * 
 * 12/05/2006 SJF PHP 5 Conversion
 * 
 */
class MapBasic extends MapBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @access public
	 */
	public function __construct() {
		// initialize base class
		parent::__construct();
	}
}

/**
 * This class provides the lats/longs map functionality
 *
 * Name       : MapBasic
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * 
 * 12/05/2006 SJF PHP 5 Conversion
 * 
 */
class MapLatsLongs extends MapBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @access public
	 */
	public function __construct() {
		// initialize base class
		parent::__construct();
	}
}

/**
 * This class provides the local distance map functionality
 *
 * Name       : MapLocalDistance
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * 
 * 12/05/2006 SJF PHP 5 Conversion
 * 
 */
class MapLocalDistance extends MapBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @access public
	 */
	public function __construct() {
		// initialize base class
		parent::__construct();
	}
	
	/**
	 * _processImage
	 *
	 * This method performs the actual image processing for each
	 * type of map to display. It is overridden in derived classes
	 * to provide the unique processing type.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @return		: true if successful, GI_Error object if not
	 * @access public
	 */
	public function _processImage(& $image) {
		$retval = true;
		// do we need to highlight local distance spots?
		if($this->_params[SPOT_ID_ONE] != null and $this->_params[SPOT_ID_TWO] != null) {
			$this->_processLocalDistanceSpots($image);
		}
		return $retval;
	}

	/**
	 * _processLocalDistanceSpots
	 *
	 * This method highlights the local distance spots 
	 * that have been selected by the user.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @access public
	 */
	public function _processLocalDistanceSpots(& $image) {
		define('X1', 0);
		define('Y1', 1);
		// build the query
		$sql  = "SELECT coords ";
		$sql .= "FROM spots ";
		$sql .= "WHERE spot_id='%s'";
		// query the database for spot_id_one
		$spot_one = $this->_db->query(sprintf($sql, $this->_params[SPOT_ID_ONE]));
		// query the database for spot_id_two
		$spot_two = $this->_db->query(sprintf($sql, $this->_params[SPOT_ID_TWO]));
		// did we get data?
		if(!DB::isError($spot_one) and !DB::isError($spot_two)) {
			// get the data instance
			$spot_one = $spot_one[0];
			$spot_two = $spot_two[0];
			// build array of coordinates
			$poly_one = explode(" ", $spot_one[SPOTS_COORDS]);
			$poly_two = explode(" ", $spot_two[SPOTS_COORDS]);
			// get our yellow highlight color
		  $fillColor = imagecolorallocatealpha($image, 255, 255, 0, 90);
		  // did we allocate the color?
		  if($fillColor) {
		  	// do we have enough points for a polygon?
		  	$count = count($poly_one) / 2;
		  	if($count > 2) {
			  	// paint spot_one on the map
			  	$ret = imagefilledpolygon($image, $poly_one, count($poly_one) / 2, $fillColor);
			  // otherwise, nope, use a rectangle
		  	} else {
			  	$ret = imagefilledrectangle($image, $poly_one[0], $poly_one[1], $poly_one[2], $poly_one[3], $fillColor);
		  	}
		  	// do we have enough points for a polygon?
		  	$count = count($poly_two) / 2;
		  	if($count > 2) {
			  	// paint spot_two on the map
			  	$ret = imagefilledpolygon($image, $poly_two, count($poly_two) / 2, $fillColor);
			  // otherwise, nope, use a rectangle
		  	} else {
			  	$ret = imagefilledrectangle($image, $poly_two[0], $poly_two[1], $poly_two[2], $poly_two[3], $fillColor);
		  	}
		  	// deallocate the color
		  	$ret = imagecolordeallocate($image, $fillColor);
		  } else {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to allocate spot color"), 4, 4);
		  }
		// failed to get the data
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get spot_id data"), 4, 4);
		}
	}
}

/**
 * This class provides the printer friendly map functionality
 *
 * Name       : MapPrinterFriendly
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * 
 * 12/05/2006 SJF PHP 5 Conversion
 * 
 */
class MapPrinterFriendly extends MapBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @access public
	 */
	public function __construct() {
		// initialize base class
		parent::__construct();
	}
	/**
	 * _processImage
	 *
	 * This method overrides the base class functionality,
	 * essentially providing no image process for 
	 * the printer friendly version of the map
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  1/13/2005
	 * @params    : $image - reference to the image to process
	 * @return		: true if successful, GI_Error object if not
	 * @access public
	 */
	public function _processImage(& $image) {
		$retval = true;
		return $retval;
	}
}

/*
 * 12/05/2006 The following function stands alone...
 *
 */

/**
 * This is the mapFactory function. This function creates
 * the various MapBase dervied objects that control the look and
 * feel and functionality of the map image.
 *
 * Name       : mapFactory
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 */
function & mapFactory($params) {
	// the return value of the function
	$retval = NULL;
	// is the url parameter 'option' defined?
	if(array_key_exists(OPTION, $params)) {
		// determine what kind of map object to create
		switch($params[OPTION]) {
		case LATSLONGS:
			$retval = & new MapLatsLongs();
			break;
		case LOCALDIST:
			$retval = & new MapLocalDistance();
			break;
		case GLOBALDIST:
			$retval = & new MapBasic();
			break;
		case PRINTERFRIENDLY:
			$retval = & new AtlasPrinterFriendly();
			break;
		case UNDEFINED:
		default:
			// generate error object
			$retval = GI_Base::raiseError(sprintf("Undefined atlas type in call to %s, at line %d", __FUNCTION__, __LINE__), 4, 4);
		}
	// otherwise, create an atlasbasic object
	} else {
		$retval = & new MapBasic();
	}
	return $retval;
}


function main() {
	// create a map object
	$map = mapFactory($_GET);
	// output the map
	$map->output();
	// call the map destructor
	$map->destructor();
}

// call the main entry point
main();
?>
