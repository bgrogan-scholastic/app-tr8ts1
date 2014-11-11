<?php
// turn on gzip compression
ob_start("ob_gzhandler");

// get the required include code libraries
require_once('./atlasDB.php');
require_once('./constants.php');
require_once($_SERVER["CONFIG_HOME"] . '/GI_BaseHref.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/cs/client/CS_Client.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_getVariable.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_SubTemplate.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/database/GI_List.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Base/package.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/auth/GI_AuthPreferences.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_TWrapper.php');

 
 function inTemplateToUppercaseCallback($matches) {
		return strtoupper($matches[0]);
 
 }
// define the debug mode for the application
define('__DEBUG__', false);

if(__DEBUG__) {
	require_once(SERVER_PHP_INCLUDE_HOME . 'common/utils/GI_MicroTimer.php');
}

/**
 * Base class for all of the various map options
 *
 * Name       : AtlasBase
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004 - Revised for NGO 11/12/2008 by PK
 * @param     : None
 * @return    : None
 */
class AtlasBase extends GI_Base {
	/**
	 * This is an instance of the AtlasDB object
	 * @param      $_db
	 */
	public $_db;
	/**
	 * This is the params array, which holds the $_GET stuff, avoiding xemacs issues
	 * @param      $_params
	 */
	public $_params;
	/**
	 * This is the params array, which holds the $_GET stuff, avoiding xemacs issues
	 * @param      $_params
	 */
	public $_mapData = array();
		
		
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004 - Revised for NGO 11/12/2008 by PK
	 * @param     : ?
	 * @return    : ?
	 */
	 

 
	public function __construct() { 

	parent::__construct(); 
	 
		 
       // set the logging levels and file
    $this->setDebugLogLevels(1);
		// create an AtlasDB object
		$this->_db = & new AtlasDB();
		// initialize the parameters variable
		$this->_params = array();
		$this->_params[PRODUCTID]    = GI_getVariable(PRODUCTID) != null ? GI_getVariable(PRODUCTID) : GO_PRODUCT_ID;
		$this->_params[ASSET_ID]     = GI_getVariable(ASSET_ID) != null ? GI_getVariable(ASSET_ID) : ROOTMAP;
		$this->_params[OPTION]       = GI_getVariable(OPTION) != null ? GI_getVariable(OPTION) : null;
		$this->_params[TYPE]         = GI_getVariable(TYPE) != null ? GI_getVariable(TYPE) : null;
		$this->_params[POI_ID]       = GI_getVariable(POI_ID) != null ? GI_getVariable(POI_ID) : null;
		$this->_params[SPOT_ID]      = GI_getVariable(SPOT_ID) != null ? GI_getVariable(SPOT_ID) : null;
		$this->_params[SPOT_ID_ONE]  = GI_getVariable(SPOT_ID_ONE) != null ? GI_getVariable(SPOT_ID_ONE) : null;
		$this->_params[SPOT_ID_TWO]  = GI_getVariable(SPOT_ID_TWO) != null ? GI_getVariable(SPOT_ID_TWO) : null;
		$this->_params[TEMPLATENAME] = GI_getVariable(TEMPLATENAME) != null ? GI_getVariable(TEMPLATENAME) : null;
		// get some data about the asset_id
		 
		$data = $this->_db->query(sprintf("select * from assets where asset_id='%s'", $this->_params[ASSET_ID]));
		 
		 
		 
		// didn't get back and error did we?
		if(!DB::isError($data)) {
			// iterate over the data and put it into our array
			foreach($data[0] as $key => $value) {
				$this->_mapData[$key] = $value;
			}
			//$this->_mapData = & $data;
		}
		// set the sort priority for the atlas
		$this->_sortPriority = PCODE == "go2-passport" ? "p_priority" : "k_priority";
		// create authentication object here
		$this->_auth = & new GI_AuthPreferences();
		// create the string of authenticated products, which always includes 'go'
		$products = $this->_auth->getAuthProducts();
			 
		
	
		/*   bypassing authentication for products...always assuming product is GO
		
		// do we have any products at all authenticated?
		if(count($products) >= 1) {
			// replace strange last item '0' with 'go'
			if(count($products) == 0) {
				$products[count($products) - 1] = "go";
			// otherwise, just append 'go' on there
			} else {
				$products[] = "go";
			}
			$this->_productsList = sprintf("'%s'", implode("', '", $products));
		// otherwise, just make sure 'go' is in there
		} else {
			$this->_productsList = "'gme'";
		}
		*/
		 $products = array();
		 $this->_productsList = "'go'";
		 $products[] = "go";
		 
		 
	 
		
		// is debug mode on?
		if(__DEBUG__) {
			// force authentication of all products
			$this->_productsList = "'gme', 'ea', 'eas', 'nbk', 'nbps', 'nec', 'lp', 'atb', 'go'";
			//$this->_productsList = "'gme', 'go'";
			// create a microtimer for debugging/optimization
			$this->_microTimer = & new GI_MicroTimer();
		}
		
 }
 
 
  	public function destructor() {
		$this->_db->disconnect();
	}

	/**
	 * Execute function for logging.
	 *
	 * @access private
	 * @param array Associative array of arguments.
	 * @return mixed Either nothing on success or a GI_Error object on errors.
	 * @throws GI_Error
	 */
	public function _execute_log($args) {
		$retval = null;
		$this->_debug->add('Starting behavior: log', GI_DEBUG_EVENT);
		$logMsg = '<'.date('Y/m/d H:i:s').'> ';
		$logMsg .= $args['message']."\n";
		if ($args['includeErrors'] == 'TRUE') {
			$logMsg .= $this->errorManager->getErrorSummary();
		}
		if (isset($args['file'])) {
			if (!error_log($logMsg, 3, $args['file'])) {
				$retval = $this->_raiseError('Could not log to file: '.$args['file'], 7, 1);
			}
		} elseif (!error_log($logMsg, 0)) {
			$retval = $this->_raiseError('Could not log to standard log file.', 7, 1);
		}
		$this->_debug->add('Finished behavior: log', GI_DEBUG_EVENT);
		return $retval;
	} // end func _execute_log

	/**
	 * getParam
	 *
	 * This method provides access to the URL parameters passed
	 * to the class.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @params    : string - look up hash value into $this->_params array
	 * @return    : string - value associated with array
	 */
	public function & getParam($key="") {
		return (array_key_exists($key, $this->_params) ? $this->_params[$key] : NULL);
	}

	/**
	 * getProductID
	 *
	 * This method provides access to the product id currently
	 * configured as the selected product cookie
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @return    : string - auth string representing the product name
	 */
	public function & getProductID() {
		static $retval = NULL;
		$retval = $_SERVER[GI_AUTH_PCODE];
		return $retval;
	}

	/**
	 * getMapData
	 *
	 * This method provides access to the map data associated with the
	 * asset_id of the map. For valid keys it will return the associated value
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $key         - string key to look up in the map data array
	 * @param     : $subTemplate - string containing the subtemplate to format with
	 * @return    : string value of valid key, GI_Error object if not
	 */
	public function & getMapData($key="", $subTemplate="") {
		$retval = "";
		// get an alias to the data
		$data = & $this->_mapData;
		// do we have a sub template?
		if($subTemplate != "") {
			// are the parameters valid?
			if($key != "" and array_key_exists($key, $data)) {
				$retval = GI_SubTemplate::toString(array('title' => $data[$key]), $subTemplate, "##");
				// otherwise, nope, invalid key
			} else {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "invalid key passed"), 4, 4);
			}
		// otherwise, no subtemplate, so just hand back the data
		} else {
			// are the parameters valid?
			if($key != "" and array_key_exists($key, $data)) {
				$retval = $data[$key];
				// otherwise, nope, invalid key
			} else {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "invalid key passed"), 4, 4);
			}
		}
		return $retval;
	}
		
	/**
	 * getJavascript
	 *
	 * This is a virtual method and will be overridden in the classes that
	 * need the actual javascript code. For all other classes, they get an
	 * empty string.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 */
	public function & getJavascript() {
		return null;
	}
	
	/**
	 * getActiveJavascript
	 *
	 * This is a virtual method and will be overridden in the classes that
	 * need the actual javascript code. For all other classes, they get an
	 * empty string.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 */
	public function & getActiveJavascript() {
		return null;
	}

	/**
	 * getBackLink
	 *
	 * This is a method inserts a BACK link into a page if we need one
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template  -  string subtemplate that defines the BACK link
	 * @return    : ?
	 */
	public function & getBackLink($template) {
		$retval = "";
		// figure out if we should go back a page
		if(stristr($_SERVER['HTTP_REFERER'], 'atlas')) {
			$retval = $template;
		}
		return $retval;
	}

	/**
	 * getTemplateString
	 *
	 * This is a method inserts a template string in place
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template  -  string subtemplate that defines the CLOSE link
	 * @return    : ?
	 */
	public function & getTemplateString($template) {
		$template = $template;
		return $template;
	}

	/**
	 * getZoomURL
	 *
	 * This is a virtual method and will be overridden in the classes that
	 * need the actual javascript code. For all other classes, they get a null.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @return    : string containing the url of the zoom out map, empty if nothing
	 */
	public function getZoomURL($template) {
		return null;
	}
	
	/**
	 * getZoomOutAreaMap
	 *
	 * This is a virtual method and will be overridden in the classes that
	 * need the actual javascript code. For all other classes, they get a null.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  4/12/2005
	 * @return    : string containing the area map HTML string data
	 */
	public function & getZoomOutAreaMap($subTemplate="") {
		return null;
	}

	/**
	 * getRelatedArticles
	 *
	 * This is a virtual method provides a list of related assets
	 * based on a query. This method can be overridden in dervived code
	 * to provide some functionality, for all others it returns an null.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @params    : $listArray - the array structure that defines the list
	 * @return    : string containing the related assets list
	 */
	public function getRelatedArticles($template) {
		return null;
	}
	
	/**
	 * getNavBar
	 *
	 * This method paints the atlas navigation bar, setting the menu highlights depending on state
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - array of strings containing 'look and feel' of the navigation bar
	 * @return    : string that contains the fully formated and completed navigation menu bar
	 */
	public function getNavBar($template) {
		$retval = "";
		// output the header
		$retval .= $template["header"];
		// build the query
		$sql  = "SELECT asset_id, type ";
		$sql .= "FROM assets, map_relations ";
		$sql .= "WHERE parent_id='%s' ";
		$sql .= "AND child_id=asset_id ";
		$sql .= "AND type LIKE '0mm_'";
		$sql = sprintf($sql, $this->_params[ASSET_ID]);
		// query the database for other types of maps
		$maps = $this->_db->query($sql);
		// did we successfully get back data?
		if(!DB::isError($maps)) {
			// set up some constants
			define('FEATURESON', 'featureson');
			define('FEATURES', 'features');
			// put current map type into the maps array, faking some data
			$maps[] = array(MAP_ASSET_ID => $this->_mapData[MAP_ASSET_ID], MAP_TYPE => $this->_mapData[MAP_TYPE]);
			// build the array of map types
			$mapTypes = array();
			foreach($maps as $map) {
				// build the keys array
				$keys = array();
				switch($map[MAP_TYPE]) {
					case ATLAS_GEOPOLITICAL:
						$keys["geo_asset_id"] = $map[MAP_ASSET_ID];
						$keys["geo_feature"]  = ($map[MAP_ASSET_ID] == ($this->_params[ASSET_ID]) and $this->_params[OPTION] == null) ? FEATURESON : FEATURES;
						$mapTypes[ATLAS_GEOPOLITICAL] = GI_SubTemplate::toString($keys, $template["geopolitical"], "##");
						break;
					case ATLAS_THEMATIC:
						$keys["the_asset_id"] = $map[MAP_ASSET_ID];
						$keys["the_feature"]  = ($map[MAP_ASSET_ID] == $this->_params[ASSET_ID]) ? FEATURESON : FEATURES;
						$mapTypes[ATLAS_THEMATIC] = GI_SubTemplate::toString($keys, $template["thematic"], "##");
						break;
					case ATLAS_HISTORICAL:
						$keys["his_asset_id"] = $map[MAP_ASSET_ID];
						$keys["his_feature"]  = ($map[MAP_ASSET_ID] == $this->_params[ASSET_ID]) ? FEATURESON : FEATURES;
						$mapTypes[ATLAS_HISTORICAL] = GI_SubTemplate::toString($keys, $template["historical"], "##");
						break;
					case ATLAS_EXPLORERS:
						$keys["exp_asset_id"] = $map[MAP_ASSET_ID];
						$keys["exp_feature"]  = ($map[MAP_ASSET_ID] == $this->_params[ASSET_ID]) ? FEATURESON : FEATURES;
						$mapTypes[ATLAS_EXPLORERS] = GI_SubTemplate::toString($keys, $template["explorers"], "##");
						break;
				}
			}
			// set up a flag to indicate that a previous link has been set
			$previousLinkSet = false;
			// this isn't the global distance finder is it?
			if($this->_params[OPTION] != GLOBALDIST) {
				// output the map links in the correct order and state
				if(array_key_exists(ATLAS_GEOPOLITICAL, $mapTypes)) {
					$retval .= $mapTypes[ATLAS_GEOPOLITICAL];
					$previousLinkSet = true;
				}
				if(array_key_exists(ATLAS_HISTORICAL, $mapTypes)) {
					// is there a previous caption?
					$retval .= $previousLinkSet ? $template["separator"] : "";
					$retval .= $mapTypes[ATLAS_HISTORICAL];
					$previousLinkSet = true;
				}
				if(array_key_exists(ATLAS_THEMATIC, $mapTypes)) {
					$retval .= $previousLinkSet ? $template["separator"] : "";
					$retval .= $mapTypes[ATLAS_THEMATIC];
					$previousLinkSet = true;
				}
				if(array_key_exists(ATLAS_EXPLORERS, $mapTypes)) {
					$retval .= $previousLinkSet ? $template["separator"] : "";
					$retval .= $mapTypes[ATLAS_EXPLORERS];
					$previousLinkSet = true;
				}
			// otherwise, put up the Atlas Home item
			} else {
				$retval .= $template["atlashome"];
				$previousLinkSet = true;
			}
		// otherwise, failed to get data about the linked maps
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get thematic maps"), 4, 4);
		}
		// are we in the GO product?
		if( $this->_params[OPTION] != GLOBALDIST) {
			
			//removed $_SERVER[GI_AUTH_PCODE] == GO_PRODUCT_ID from the above if statment for the NGO atlas 
			
			// build the query for maps with longs/lats
			$sql  = sprintf("SELECT COUNT(lats) lats FROM spots WHERE asset_id='%s' AND lats<>''", $this->_params[ASSET_ID]);
			// query the database
			$latslongs = $this->_db->query($sql);
			// did we successfully get back data?
			if(!DB::isError($latslongs)) {
				// are there lats/longs associated with this map?
				if(intval($latslongs[0]["lats"]) != 0) {
					// did we previously find any other sort of map?
					$retval .= $previousLinkSet ? $template["separator"] : "";
					// output the lats/longs
					$keys = array(MAP_ASSET_ID => $this->_params[ASSET_ID], "ll_feature" => ($this->_params[OPTION] != null and $this->_params[OPTION] == LATSLONGS) ? FEATURESON : FEATURES);
					$retval .= GI_SubTemplate::toString($keys, $template["latslongs"], "##");
					$previousLinkSet = true;
				}
				// are there more than 1 lats/longs on this map?
				if(intval($latslongs[0]["lats"]) > 1) {
					// did we previously find any other sort of map?
					$retval .= $previousLinkSet ? $template["separator"] : "";
					// output the local distance
					$keys = array(MAP_ASSET_ID => $this->_params[ASSET_ID], "ld_feature" => ($this->_params[OPTION] != null and $this->_params[OPTION] == LOCALDIST) ? FEATURESON : FEATURES);
					$retval .= GI_SubTemplate::toString($keys, $template["localdistance"], "##");
					$previousLinkSet = true;
				}
				// otherwise, failed to get data
			} else {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get map lats/longs"), 4, 4);
			}
		}
		// output the spacer to global distance and help
		$retval .= $template["spacer"];
		// should we output the global distance finder?
		if($this->_params[PRODUCTID] == GO_PRODUCT_ID) {
			$keys = array(MAP_ASSET_ID => $this->_params[ASSET_ID], "gd_feature" => ($this->_params[OPTION] != null and $this->_params[OPTION] == GLOBALDIST) ? FEATURESON : FEATURES);
			$retval .= GI_SubTemplate::toString($keys, $template["globaldistance"], "##");
		}
		// output the map help link
		$retval .= $template["maphelp"];
		// output the footer
		$retval .= $template["footer"];
		// return output string
		return $retval;
	}
	
	/**
	 * getMapGraphic
	 *
	 * This method builds string to access the map graphic and
	 * inserts it into the passed in template string
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string   localized full filepath to the map to display
	 */
	function getMapGraphic($subTemplate) {
		$retval = NULL;
		// do we have any parameters?
		if(isset($this->_params)) {
			// do we have expected parameters?
			if(array_key_exists(ASSET_ID, $this->_params) and isset($this->_params[ASSET_ID])) {
				$url = sprintf("/map?%s=%s", ASSET_ID, $this->_params[ASSET_ID]);
			}
			if(array_key_exists(OPTION, $this->_params) and isset($this->_params[OPTION])) {
				$url .= sprintf("&amp;%s=%s", OPTION, $this->_params[OPTION]);
			}
			if(array_key_exists(PRODUCTID, $this->_params) and isset($this->_params[PRODUCTID])) {
				$url .= sprintf("&amp;%s=%s", PRODUCTID, $this->_params[PRODUCTID]);
			}
			if(array_key_exists(SPOT_ID, $this->_params) and isset($this->_params[SPOT_ID])) {
				$url .= sprintf("&amp;%s=%s", SPOT_ID, $this->_params[SPOT_ID]);
			}
			if(array_key_exists(SPOT_ID_ONE, $this->_params) and isset($this->_params[SPOT_ID_ONE])) {
				$url .= sprintf("&amp;%s=%s", SPOT_ID_ONE, $this->_params[SPOT_ID_ONE]);
			}
			if(array_key_exists(SPOT_ID_TWO, $this->_params) and isset($this->_params[SPOT_ID_TWO])) {
				$url .= sprintf("&amp;%s=%s", SPOT_ID_TWO, $this->_params[SPOT_ID_TWO]);
			}
			// put the url together with the subtemplate
			$retval = GI_SubTemplate::toString(array('map_url' => $url, 'title' => $this->getMapData('title')), $subTemplate, "##");
		}	
	return $retval;
	}

	/**
	 * getLatsLongs
	 *
	 * This is a virtual method that will be overridden in the AtlasLatsLongs
	 * derived class. Here it does nothing, which is intended.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string   localized full filepath to the map to display
	 */
	public function getLatsLongs($template) {
		return null;
	}
	 
	 /**
	 * getLocalDistance
	 *
	 * This is a virtual method that will be overridden in the AtlasLocalDistance
	 * derived class. Here it does nothing, which is intended.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string   localized full filepath to the map to display
	 */
	public function getLocalDistance($template) {
		return null;
	}
}

/**
 * This class provides the basic (simplist) atlas functionality
 *
 * Name       : AtlasBasic
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 */
class AtlasBasic extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 */
	public function __construct() { 

	parent::__construct();  
	}
	
	/**
	 * getJavascript
	 *
	 * This method returns a string containing the necessary javascript to
	 * perform the AtlasBasic specific javascript for the atlas. It overriddes
	 * the base class method to provide additional functionality.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string which is the contents of the returned javascript file
	 */
	public function & getJavascript() {
		$retval = NULL;
		$retval = $retval;
		return $retval;
	}

	/**
	 * getZoomURL
	 *
	 * This method provides the graphical zoom out link if the map requires it
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @return    : string containing the url of the zoom out map, empty if nothing
	 */
	public function & getZoomURL($subTemplate="") {
		$retval = "";
		// does the map have a zoom id?
		if($subTemplate != "" and $this->_mapData[MAP_ZOOM_ID] != "") {
			// build zoom out url
			$retval = GI_SubTemplate::toString(array('asset_id' => $this->_mapData[MAP_ZOOM_ID]), $subTemplate, "##");
		}
		return $retval;
	}

	/**
	 * getZoomOutAreaMap
	 *
	 * This method provies the correct area map href for the zoom out linke if 
	 * the map requires it.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  4/12/2005
	 * @return    : string containing the area map HTML string data
	 */
	public function & getZoomOutAreaMap($subTemplate="") {
		$retval = "";
		// does the map have a zoom id?
		if($subTemplate != "" and $this->_mapData[MAP_ZOOM_ID] != "") {
			// build the array of data for subtemplate
			$params = array('zoom_out_id' => $this->_mapData[MAP_ZOOM_ID],
											'template_param' => ($this->_params[TEMPLATENAME] !=null) ? sprintf("&tn=%s", $this->_params[TEMPLATENAME]) : "",
											'world_map_id' => ($this->_mapData[MAP_LANGUAGE] == "spanish") ? ROOTMAP_NEC : ROOTMAP);
			// build zoom out url
			$retval = GI_SubTemplate::toString($params, $subTemplate, "##");
		}
		return $retval;
	}

	/**
	 * getHotSpots
	 *
	 * This is a virtual method and will be overridden by the
	 * classes that need different hotspot information. This is set up
	 * this way because depending on the type of atlas class this
	 * is, the hotspot information will vary.
	 *
	 * In this instance this is used by the AtlasBasic to provide regular hotspot navigation
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - array of strings that defines what a hotspot will look like
	 * @return    : string representing the area map of the hotspots
	 */
	function & getHotSpots($template) {
		$retval = "";
		// add the <map...> 
		$retval .= $template["start"];
		// build the sql query to get the other hotspots
		$sql  = "SELECT SR.asset_id, SR.product_id, S.spot_id, S.title, S.spot_type, PU.url, S.coords, COUNT(SR2.spot_id) AS spot_id_count, SR.priority ";
		$sql .= "FROM spots AS S ";
		$sql .= "LEFT JOIN spot_relations AS SR ON S.spot_id=SR.spot_id ";
		$sql .= "LEFT JOIN assets AS A ON A.asset_id=SR.asset_id ";
		$sql .= "LEFT JOIN product_versions AS PV ON SR.product_id=PV.product_id ";
		$sql .= "LEFT OUTER JOIN product_urls AS PU ON PV.product_version=PU.product_version AND A.type=PU.type ";
		$sql .= "LEFT JOIN spot_relations as SR2 on SR.spot_id=SR2.spot_id ";
		$sql .= "WHERE S.asset_id='%s' ";
		$sql .= "AND SR.product_id IN (%s) ";
		$sql .= "AND SR2.product_id IN (%s) ";
		$sql .= "GROUP BY SR.asset_id, SR.product_id, S.spot_id, S.title, S.spot_type, PU.url, S.coords ";
		$sql .= "ORDER BY SR.priority, S.spot_id";
		// query the database
		$hotspots = $this->_db->query(sprintf($sql, $this->_params[ASSET_ID], $this->_productsList, $this->_productsList));
		// did we get data?
		
	
				
		if(!DB::isError($hotspots)) {
			// iterate over the list of hotspots, outputing the <area ..> as appropriate
			$spot_id = null;
			
			
			foreach($hotspots as $hotspot) {
				// has the spot_id changed?
			 
			 
				if($spot_id != $hotspot[MAP_SPOT_ID]) {
					// update the spot_id value
					$spot_id = $hotspot[MAP_SPOT_ID];
					// is this a single asset spot?
					if($hotspot["spot_id_count"] == 1) {
						// do the right thing for the kind of spot
						switch($hotspot[SPOT_TYPE]) {
							case SPOT_TYPE_HOT:
							case SPOT_TYPE_NAV:
								// is this a map navigation spot?
								if($hotspot[MAP_PRODUCT_ID] == GO_PRODUCT_ID) {
									$hotspot["basehref"] = GI_BaseHref($hotspot[MAP_PRODUCT_ID]);
									$hotspot["shape"] = ((count(explode(" ", $hotspot[SPOTS_COORDS])) / 2) > 2) ? "poly" : "rect";
									$retval .= GI_SubTemplate::toString($hotspot, $template["mapspot"], "##");
								// otherwise, asset navigations spot
								} else {
									// are we in an ADA template?
									if(stristr($this->_params[TEMPLATENAME], ADA) != false) {
										$hotspot["basehref"] = GI_BaseHref($hotspot[MAP_PRODUCT_ID] . "-ada");
										// did GI_BaseHref find an ada verion?
										if($hotspot["basehref"] == "") {
											$hotspot["basehref"] = GI_BaseHref($hotspot[MAP_PRODUCT_ID]);
										}
									// otherwise, it's a graphical product, no ada extension
									} else {
										$hotspot["basehref"] = GI_BaseHref($hotspot[MAP_PRODUCT_ID]);
									}
									$hotspot["url"] = GI_SubTemplate::toString(array(MAP_ASSET_ID => $hotspot[MAP_ASSET_ID]), $hotspot["url"], "##");
									$hotspot["shape"] = ((count(explode(" ", $hotspot[SPOTS_COORDS])) / 2) > 2) ? "poly" : "rect";
									$retval .= GI_SubTemplate::toString($hotspot, $template["hotspot"], "##");
								}
								break;
							case SPOT_TYPE_POI:
								$hotspot["basehref"] = GI_BaseHref($hotspot[MAP_PRODUCT_ID]);
								$hotspot["shape"] = ((count(explode(" ", $hotspot[SPOTS_COORDS])) / 2) > 2) ? "poly" : "rect";
								$retval .= GI_SubTemplate::toString($hotspot, $template["poispot"], "##");
								break;
						}
					// otherwise, handle multiple assets hotspot
					} else {
						$hotspot["shape"] = ((count(explode(" ", $hotspot[SPOTS_COORDS])) / 2) > 2) ? "poly" : "rect";
						$retval .= GI_SubTemplate::toString($hotspot, $template["popspot"], "##");
					}
				}
			}
		// otherwise, got an error on the related hotspots
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get related spots"), 4, 4);
		}
		// add the </map>
		$retval .= $template["end"];
		return $retval;
	}

	/**
	 * getAssetLinks
	 *
	 * This is a method retrieves the assets links associated
	 * with a hotspot that has multiple assets linked to it. This
	 * is used by the assetlist.html popup off of a multiple link hotspot.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - the template string that defines what an asset link looks like
	 * @return    : string representing the asset links of a hotspot in the assetlist.html file
	 */
	public function & getAssetLinks($template) {
		$retval = "";
		// build the sql query to get the other hotspots
		$sql  = "SELECT SR.asset_id, A.title, SR.product_id, url, PR.description, PR.%s ";
		$sql .= "FROM spots AS S, spot_relations AS SR, product_versions AS PV, product_urls AS PU, products AS PR, assets AS A ";
		$sql .= "WHERE S.spot_id='%s' ";
		$sql .= "AND S.spot_id=SR.spot_id ";
		$sql .= "AND SR.asset_id=A.asset_id ";
		$sql .= "AND SR.product_id in (%s) ";
		$sql .= "AND SR.product_id=PV.product_id ";
		$sql .= "AND SR.product_id=PR.product_id ";
		$sql .= "AND PV.product_version=PU.product_version ";
		$sql .= "AND PU.type=A.type ";
		$sql .= "ORDER BY PR.%s";
		// query the database
		$assetLinksData = $this->_db->query(sprintf($sql, $this->_sortPriority, $this->_params[SPOT_ID], $this->_productsList, $this->_sortPriority));
		// did we get data?
		if(!DB::isError($assetLinksData)) {
			foreach($assetLinksData as $assetLinkData) {
				// are we in an ADA template?
				if(stristr($this->_params[TEMPLATENAME], ADA) != false) {
					$assetLinkData["basehref"] = GI_BaseHref($assetLinkData[MAP_PRODUCT_ID] . "-ada");
					// did GI_BaseHref find an ada verion?
					if($assetLinkData["basehref"] == "") {
						$assetLinkData["basehref"] = GI_BaseHref($assetLinkData[MAP_PRODUCT_ID]);
					}
				// otherwise, it's a graphical product, no ada extension
				} else {
					$assetLinkData["basehref"] = GI_BaseHref($assetLinkData[MAP_PRODUCT_ID]);
				}
				$assetLinkData["url"] = GI_SubTemplate::toString(array(MAP_ASSET_ID => $assetLinkData[MAP_ASSET_ID]), $assetLinkData["url"], "##");
				$retval .= GI_SubTemplate::toString($assetLinkData, $template, "##");
			}
		// otherwise, failed to get related assets links
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get asset links"), 4, 4);
		}
		return $retval;
	}

	/**
	 * getRelatedArticles
	 *
	 * This is a virtual method provides a list of related assets
	 * based on a query. This method can be overridden in dervived code
	 * to provide something different, or nothing at all if necessary.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @params    : $listArray - the array structure that defines the list
	 * @return    : string containing the related assets list
	 */
	public function & getRelatedArticles($listArray="") {
		$retval = "";
		// build the product list array
		$inKeys = array('asset_id' => $this->_params[ASSET_ID], 
										'product_list' => $this->_productsList,
										'priority' => $this->_sortPriority);
		// replace ##PRODUCT_LIST## with product list 
		$listArray[0]['query'] = GI_SubTemplate::toString($inKeys, $listArray[0]['query'], "##");
		// create list object
		$list = & new GI_List($listArray);
		$list->create();
		// output the data
		$retval .= $list->output();
		// did we get anything back?
		if($retval == "") {
			$retval = "&nbsp;";
		}
		return $retval;
	}
}


/**
 * This function is the callback function that getRelatedArticles()
 * uses to output a related assets link
 *
 * Name       : outputRelatedArticleLink
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : $keyArray - partially populated key/value array for GI_List
 * @param     : $formatString - string passed in from sub-template array
 * @param     : $dbRow - row of data we are currently dealing with
 * @return    : string completed output of the $formatString from GI_SubTemplate
 */
function outputRelatedArticleLink($keyArray, $formatString, $dbRow) {
	$retval = "";
	// is the product_id set?
	if($dbRow["product_id"] != null) {
		// are we in an ada template
		if(stristr($_GET["tn"], "ada") != false) {
			$keyArray["basehref"] = GI_BaseHref(strtolower($dbRow["product_id"] . "-ada"));
			// did GI_BaseHref return an ada basehref?
			if($keyArray["basehref"] == "") {
				$keyArray["basehref"] = GI_BaseHref(strtolower($dbRow["product_id"]));
			}
		// otherwise, nope, in a graphical template
		} else {
			$keyArray["basehref"] = GI_BaseHref(strtolower($dbRow["product_id"]));
		}
		$keyArray["url"] = GI_SubTemplate::toString(array("asset_id" => $dbRow[MAP_ASSET_ID]), $dbRow["url"], "##");
		$keyArray[MAP_ASSET_ID] = $dbRow[MAP_ASSET_ID];
		$retval = GI_SubTemplate::toString($keyArray, $formatString, "##");
	// otherwise, no product_id set
	} else {
		$retval = $this->_raiseError(sprintf("%s error : %s", __FUNCTION__, "called without product_id value"), 4, 4);
	}
	return $retval;
}

/**
 * This class provides the atlas lats/longs functionality
 *
 * Name       : AtlasLatsLongs
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 */
class AtlasLatsLongs extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 */
	public function __construct() { 

	parent::__construct();  
	}
	
	/**
	 * getJavascript
	 *
	 * This method returns a string containing the necessary javascript to
	 * perform the lats/longs calculations for the atlas. It is meant to be
	 * and overridden method in that only some of the derived classes actuall
	 * need this code.
	 *
	 * This version is used in the AtlasLatsLongs class
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string which is the contents of the returned javascript file
	 */
	public function & getJavascript() {
		$retval = null;
		// read the atlas specific javascript file into a string
		$retval = file_get_contents($_SERVER["JAVASCRIPT_INCLUDE_HOME"] . "ngo1/atlas/distance.js");
		// did we fail to get the file?
		if(!$retval) {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to retrieve distance.js file"), 4, 4);
		}
		return $retval;
	}

	/**
	 * getHotSpots
	 *
	 * This method retrieves the lats/longs data for the lats/longs display. Essentially
	 * adding the necessary information for the display of latitude and longitude information
	 * by some javascript.
	 *
	 * In this instance this is used by the AtlasLatsLongs to provide lats/longs action
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - array of strings that defines what a hotspot will look like
	 * @return    : string representing the area map of the hotspots
	 */
	public function & getHotSpots($template) {
		$retval = "";
		// add the <map...> 
		$retval .= $template["start"];
		// build the sql query to get the other hotspots
		$sql  = "SELECT title, lats, longs, coords ";
		$sql .= "FROM spots ";
		$sql .= "WHERE asset_id='%s' ";
		$sql .= "AND lats<>'' ";
		$sql .= "AND longs<>''";		
		// query the database
		$hotspots = $this->_db->query(sprintf($sql, $this->_params[ASSET_ID]));
		// did we get data?
		if(!DB::isError($hotspots)) {
			// iterate over the list of hotspots, outputing the <area ..> as appropriate
			foreach($hotspots as $hotspot) {
				// create an array of the coords
				$points = explode(" ", $hotspot[SPOTS_COORDS]);
				// do we need to create an area shape of poly or rect?
				$hotspot["shape"] = (count($points) / 2 > 2) ? "poly" : "rect";
				// clean up the titles with embedded single quotes in them
				$hotspot["newtitle"] = str_replace("'", "\'", html_entity_decode($hotspot["title"]));
				// fill in the template
				$retval .= GI_SubTemplate::toString($hotspot, $template["hotspot"], "##");
			}
		// otherwise, got an error on the related hotspots
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get related spots"), 4, 4);
		}
		// add the </map>
		$retval .= $template["end"];
		return $retval;
	}
	
	/**
	 * getLatsLongs
	 *
	 * This is a virtual method that will be overridden in the AtlasLatsLongs
	 * derived class. Here it does the lats/longs stuff.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string   localized full filepath to the map to display
	 */
	public function getLatsLongs($template) {
		$retval = null;
		// are we on the local distance page?
		if($this->_params[OPTION] == LATSLONGS) {
			$retval = $template;
		// otherwise, do nothing
		} else {
			$retval = null;
		}
		return $retval;
	}
	
}

/**
 * This class provides the atlas local distance functionality
 *
 * Name       : AtlasLocalDistance
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 */
class AtlasLocalDistance extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 */
	public function __construct() { 

	parent::__construct(); 

	}
	
	/**
	 * getJavascript
	 *
	 * This method returns a string containing the necessary javascript to
	 * perform the local distance calculations for the atlas. 
	 *
	 * This version is used in the AtlasLatsLongs class
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string which is the contents of the returned javascript file
	 */
	public function & getJavascript() {
		$retval = null;
		// read the atlas specific javascript file into a string
		$retval = file_get_contents($_SERVER["JAVASCRIPT_INCLUDE_HOME"] . "ngo1/atlas/distance.js");
		// did we fail to get the file?
		if(!$retval) {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to retrieve distance.js file"), 4, 4);
		}
		return $retval;
	}

	/**
	 * getActiveJavascript1
	 *
	 * This method returns a string containing the necessary javascript to
	 * initialize the local distance variables and call the function to 
	 * calculate the distance and display it.
	 *
	 * This version is used in the AtlasLatsLongs class
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string which is the contents of the returned javascript file
	 */
	public function & getActiveJavascript1() {
		$retval = "";
		// are we on the local distance page?
		if($this->_params[OPTION] == LOCALDIST) {
			// do we have two spot_id's?
			if($this->_params[SPOT_ID_ONE] != null and $this->_params[SPOT_ID_TWO] != null) {
				// build the query
				$sql  = "SELECT lats, longs, title ";
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
					// format the active javascript
					$spot_one["title"] = str_replace("'", "\'", html_entity_decode($spot_one["title"]));
					$retval .= sprintf("location0 = new Location('%s', %-4.4f, %-4.4f);\n", $spot_one["title"], $spot_one["lats"], $spot_one["longs"]);
					$spot_two["title"] = str_replace("'", "\'", html_entity_decode($spot_two["title"]));
					$retval .= sprintf("location1 = new Location('%s', %-4.4f, %-4.4f);\n", $spot_two["title"], $spot_two["lats"], $spot_two["longs"]);
					$retval .= "schedule('display', 'displayDistance(location0, location1);');\n";
				// otherwise, didn't get the spot_id data
				} else {
					$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get spot_id data"), 4, 4);
				}
			}
		}
		return $retval;
	}
	
	/**
	 * getHotSpots
	 *
	 * This is a virtual method and will be overridden by the
	 * classes that need the hotspot information. This is set up
	 * this way because depending on the type of atlas class this
	 * is, the hotspot information will vary.
	 *
	 * In this instance this is used by the AtlasLocalDistance to provide location distance action
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - array of strings that defines what a hotspot will look like
	 * @return    : string representing the area map of the hotspots
	 */
	public function & getHotSpots($template) {
		$retval = "";
		// add the <map...> 
		$retval .= $template["start"];
		// build the sql query to get the other hotspots
		$sql  = "SELECT title, lats, longs, spot_id, coords ";
		$sql .= "FROM spots ";
		$sql .= "WHERE asset_id='%s' ";
		$sql .= "AND lats<>'' ";
		$sql .= "AND longs<>''";		
		// query the database
		$hotspots = $this->_db->query(sprintf($sql, $this->_params[ASSET_ID]));
		// did we get data?
		if(!DB::isError($hotspots)) {
			// iterate over the list of hotspots, outputing the <area ..> as appropriate
			foreach($hotspots as $hotspot) {
				// create an array of the coords
				$points = explode(" ", $hotspot[SPOTS_COORDS]);
				// do we need to create an area shape of poly or rect?
				$hotspot["shape"] = (count($points) / 2 > 2) ? "poly" : "rect";
				// add the current asset_id into the record
				$hotspot[MAP_ASSET_ID] = $this->_params[ASSET_ID];
				// clean up the titles with embedded single quotes in them
				$hotspot["newtitle"] = str_replace("'", "\'", $hotspot["title"]);
				// fill in the template
				$retval .= GI_SubTemplate::toString($hotspot, $template["hotspot"], "##");
			}
		// otherwise, got an error on the related hotspots
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get related spots"), 4, 4);
		}
		// add the </map>
		$retval .= $template["end"];
		return $retval;
	}

	
  /**
	 * _calculateDistance
	 *
	 * This function does the actual calculation of the distance between two points
	 * This is based on spherical geometry with a bit of compensation because the earth
	 * isn't really round, it's a little squashed.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : points - array of points (x1, y1, x2, y2), each point is a floating point number
	 * @return    : array  - distance in miles between the two points (miles, kilometers)
	 */
	public function & _calculateDistance($points) {
		// create return object
		$retval = array();
		// latitude/longitude for first point
		$lat1 = deg2rad($points[0]);
		$long1 = deg2rad($points[1]);
	
		// latitude/longitude for second point
		$lat2 = deg2rad($points[2]);
		$long2 = deg2rad($points[3]);
	
		// delta between the points
		$dlat = abs($lat2 - $lat1);
		$dlong = abs($long2 - $long1);
	  
		// do the calculation to determine the distance
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
		// save the kilometers
		$retval["kilometers"] = $d;
		// convert to miles and save
		$retval["miles"] = $d * 0.62111802;
		// return the array of values
		return $retval;
	}

  /**
	 * getLocalDistance
	 *
	 * This is a virtual method that will be overridden in the AtlasLocalDistance
	 * derived class. Here it does nothing.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string   localized full filepath to the map to display
	 */
	public function getLocalDistance($template) {
		$retval = "";
		// are we on the local distance page?
		if($this->_params[OPTION] == LOCALDIST) {
			// do we have two spot_id's?
			if($this->_params[SPOT_ID_ONE] != null and $this->_params[SPOT_ID_TWO] != null) {
				// build the query
				$sql  = "SELECT lats, longs, title ";
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
					// calculate the distance between the two spots
					$distance = $this->_calculateDistance(array($spot_one["lats"], $spot_one["longs"], $spot_two["lats"], $spot_two["longs"]));
					// build the output template
					$displayText = sprintf("Distance from %s to %s\nMiles = %-1.1f, Kilometers = %-1.1f", $spot_one["title"], $spot_two["title"], $distance["miles"], $distance["kilometers"]);
					$retval = GI_SubTemplate::toString(array("display_text" => $displayText), $template, "##");
				// otherwise, didn't get the spot_id data
				} else {
					$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get spot_id data"), 4, 4);
				}
			// don't have the spot_ids yet
			} else {
				$displayText = "Click on two cities to find the distance between them.";
				$retval = GI_SubTemplate::toString(array("display_text" => $displayText), $template, "##");
			}
		}
		return $retval;
	}
}

/**
 * This class provides the atlas global distance functionality
 *
 * Name       : AtlasGlobalDistance
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 */
class AtlasGlobalDistance extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 */
	public function __construct() { 

	parent::__construct(); 
	
		// build the query
		$this->_cities = $this->_db->query("SELECT * FROM spots WHERE title2 <> '' AND lats<>'' AND longs<>'' ORDER BY substring_index(replace(title2, '-', ' '), ',', 1), substring_index(title2, ',', -1)");
		// did we get data back?
		if(DB::isError($this->_cities)) {
			$this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get global distance data"), 4, 4);
		}
	}
	
	/**
	 * getJavascript
	 *
	 * This method returns a string containing the necessary javascript to
	 * perform the lats/longs calculations for the atlas. It is meant to be
	 * and overridden method in that only some of the derived classes actuall
	 * need this code.
	 *
	 * This version is used in the AtlasGlobalDistance class
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : string which is the contents of the returned javascript file
	 */
	public function & getJavascript() {
		$retval = NULL;
		// read the atlas specific javascript file into a string
		
		$retval = file_get_contents($_SERVER["JAVASCRIPT_INCLUDE_HOME"] . "ngo1/atlas/distance.js");
		// did we fail to get the file?
		if(!$retval) {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to retrieve distance.js file"), 4, 4);
		}
		return $retval;
	}

	/**
	 * getCityList
	 *
	 * This is a method retrieves all the hotspots on all the maps that have lats/longs defined
	 * and builds and <option>... list for them.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : NONE
	 * @return    : string representing <option>... list for the cities
	 */
	public function getCityList() {
		static $retval = null;
		// have we already built the list?
		if($retval == null and isset($this->_cities)) {
			// iterator over the dataList
			foreach($this->_cities as $city) {
				$retval .= sprintf("<option>%s\n", $city[SPOTS_TITLE2]);
			}
		}
		return $retval;
	}

	/**
	 * getCityDataList
	 *
	 * This is a method retrieves all the hotspots on all the maps that have lats/longs defined
	 * and builds and <option>... list for them.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : NONE
	 * @return    : string representing <option>... list for the cities
	 */
	public function getCityDataList() {
		$retval = null;
		// do we have a dataset?
		if(isset($this->_cities)) {
			// build the locations list of data
			foreach($this->_cities as $city) {
				$retval .= sprintf("locations[i++] = new Location(\"%s\", %s, %s);\n", $city[SPOTS_TITLE2], $city[SPOTS_LATS], $city[SPOTS_LONGS]);
			}
		}
		return $retval;
	}
}

		
/**
 * This class provides the atlas printer friendly functionality
 *
 * Name       : AtlasPrinterFriendly
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 */
class AtlasPrinterFriendly extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 */
	public function __construct() { 

	parent::__construct(); 
	}
}

/**
 * This class provides the atlas handler for POI
 *
 * Name       : AtlasPOI
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 */
class AtlasPOI extends AtlasBase {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 */
	public function __construct() { 

	parent::__construct(); 
		// build the poi query
		$sql = sprintf("SELECT * FROM assets WHERE asset_id='%s'", $this->_params[POI_ID]);
				
		$poiAsset = $this->_db->query($sql);
		// did we get data successfully?

		if(!DB::isError($poiAsset)) {
			// get actual instance of the data
			$this->_poiAsset = $poiAsset[0];
			// get the hashing code
			require_once(SERVER_PHP_INCLUDE_HOME . '/common/utils/GI_Hash.php');
			// build the poi imagefilepath
			$this->_poiFilename = $this->_poiAsset[ASSETS_ASSET_ID] . ".jpg";
			$this->_poiFilepath = GI_hashFilename($this->_poiFilename, $_SERVER['CS_DOCS_ROOT'] . "/media");
			
			
			
			// get the rebuild flag
			$rebuild = GI_getVariable(GI_REBUILD);
			// do we need to get the POI picture asset?
			if(($rebuild != null and $rebuild == GI_YES) or !file_exists($this->_poiFilepath)) {
				// need the GI_MediaAsset class here
				require_once(SERVER_PHP_INCLUDE_HOME . 'common/article/GI_MediaAsset.php');
				// get the POI image and caption asset
				$this->_poiImage = new GI_MediaAsset(array(CS_PRODUCTID => $this->_params[PRODUCTID], CS_ASSETID => $this->_poiAsset[ASSETS_ASSET_ID], MAP_FEXT => $this->_poiAsset[ASSETS_FEXT]));
				// did we get the poi image asset?
				if(GI_Base::isError($this->_poiImage)) {
					$this->_raiseError(sprintf('%s failed to get POI image', __CLASS__), 4, 4);
				}
			}
		 					
			// build the caption text filepath
			$this->_captionFilename = $this->_poiAsset[ASSETS_CAPTION_ID] . ".html";
			$this->_captionFilepath = GI_hashFilename($this->_captionFilename, $_SERVER['CS_DOCS_ROOT'] . "/text");
			// do we have to get the caption text from the content server?
			if(($rebuild != null and $rebuild == GI_YES) or !file_exists($this->_captionFilepath)) {
				// get the POI caption asset
				$csClient = & new CS_Client();
				// did we successfully create the content server client?
				if(!GI_Base::isError($csClient)) {
					$poiCaption = $csClient->getText(array(CS_PRODUCTID => $this->_params[PRODUCTID], CS_ASSETID => $this->_poiAsset[ASSETS_CAPTION_ID]));
					// did we succeed in getting a content server object?
					if(!GI_Base::isError($poiCaption)) {
						// write the caption out to disk
						$pathInfo = pathinfo($this->_captionFilepath);
						// does the directory exist?
						if(!file_exists($pathInfo['dirname'])) {
							mkdir($pathInfo['dirname']);
						}
						$handle = fopen($this->_captionFilepath, 'w');
						fwrite($handle, $poiCaption->getText());
						fclose($handle);
					// otherwise, failed to get connection to content server
					} else {
						$this->_raiseError(sprintf('%s error : %s' . __CLASSS__, $this->_csClient->getMessage()), 4, 4);
					}
				// otherwise, failed to create CS_Client object
				} else {
					$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to create CS_Client object"), 4, 4);
				}
			}
			
			 
		// otherwise, failed to get the data
		} else {
			$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, "failed to get poi data"), 4, 4);
		}
	}
	/**
	 * getImage
	 *
	 * This is a method retrieves the POI image information and returns
	 * it in the proper form for inclusion in the html
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - the template string that defines what an image link looks like
	 * @return    : string representing the <img src=...> tage in the poi.html file
	 */
	public function getImage($template) {
		
			
		$retval = null;
		// build the key array
		$keys = array();
		$keys["urlfilepath"] = substr($this->_poiFilepath, strlen($_SERVER['CS_DOCS_ROOT']));
		
		$imageInfo = getimagesize($this->_poiFilepath);
		$keys["width"] = $imageInfo[0];
		$keys["height"] = $imageInfo[1];
		$keys["title"] = $this->_poiAsset["title"];
		$keys["ASSET_ID"] = $this->_params[POI_ID];
		$keys["ext"] = $this->_poiAsset[ASSETS_FEXT];
		// insert the url filepath into the poi images subtemplate
		$retval = GI_SubTemplate::toString($keys, $template, "##");
		
		
		 
		
		return $retval;
		
 

 

	}
	/**
	 * getCaption
	 *
	 * This is method retrieves POI caption text for inclusion in
	 * the POI popup box.
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : $template - the template string that defines what a POI caption looks like
	 * @return    : string representing the caption information formatted in the poi.html file
	 */
 
	
	public function getCaption($template) {
		
		$retval = null;
		// build the keys
		$keys = array();
		$keys["caption"] = GI_SubTemplate::toString(array(ASSETS_CREDIT => $this->_poiAsset[ASSETS_CREDIT]), file_get_contents($this->_captionFilepath), "##", true);
		// insert the caption and credit into the poi text subtemplate		
		$retval = GI_SubTemplate::toString($keys, $template, "##");
		return $retval;
	 
	  
		
	 
		
	}
}

/**
 * This is the atlasFactory function. This function creates
 * the various AtlasBase derived objects that control the look and
 * feel and functionality of the Atlas pages.
 *
 * Name       : atlasFactory
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 */
function & atlasFactory($params) {
	// the return value of the function
	$retval = NULL;
	// is the url parameter 'option' defined?
	if(array_key_exists(OPTION, $params)) {
		// determine what kind of map object to create
		switch($params[OPTION]) {
		case LATSLONGS:
			$retval = & new AtlasLatsLongs();
			break;
		case LOCALDIST:
			$retval = & new AtlasLocalDistance();
			break;
		case GLOBALDIST:
			$retval = & new AtlasGlobalDistance();
			break;
		case PRINTERFRIENDLY:
			$retval = & new AtlasPrinterFriendly();
			break;
		// to handle the popup for multiple assets on a hotspot
		case ASSETLIST:
			$retval = & new AtlasBasic();
			break;
		case POI:
			$retval = & new AtlasPOI();
			break;
		default:
			// generate error object
			$retval = GI_Base::raiseError(sprintf("Undefined atlas type in call to %s, at line %d", __FUNCTION__, __LINE__), 4, 4);
		}
	// otherwise, create an atlasbasic object
	} else {
		$retval = & new AtlasBasic();
	}
	return $retval;
}


class ErrorManager extends GI_ErrorManager {

	public function __construct() { 
	parent::__construct(); 
	
		$GLOBALS["errorManager"] = $errMgr;
		$this->_buildresult = GI_BUILD_STATUS_SUCCESS;
		$this->_fatalerror = false;
	}
	function setBuildresult($value) {
		$this->_buildresult = $value;
	}
	function setFatalerror($value) {
		$this->_fatalerror = $value;
	}
}
 


/**
 * This function is the main entry point for the program. It is 
 * responsible for pulling in the appropriate template and having
 * that template call back into this code to fill out the various
 * dynamic portions of the template.
 *
 * Name       : main
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004 - Revised for NGO 11/12/2008 by PK
 * @param     : None
 * @return    : None
 */
 
 function main() {
	//initialize the error manager
	$errMgr = new ErrorManager();
	// create an instance of the atlas object that will be relevant for the template
	$atlas = & atlasFactory($_GET);
	// process the template, calling back into the $atlas object defined above


	
	require_once($_SERVER['TEMPLATE_HOME'] . (GI_getVariable(GI_TEMPLATENAME) != NULL ? GI_getVariable(GI_TEMPLATENAME) : "atlas/atlas.html"));
	// call the atlas destructor
	$atlas->destructor();
	
}

/**
 * beginning of the actual program
 */
main();

 


?>