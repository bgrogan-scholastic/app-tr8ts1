<?php
// include the required libraries
require_once('DB.php');
require_once('./constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . '/common/GI_Constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . '/common/GI_Base/package.php');

 
 
 
/**
 * Somewhat generalized database class for the atlas feature
 *
 * Name       : AtlasDB
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.1  10/2008 - Revised for NGO 11/12/2008 by PK
 * @param     : ?
 * @return    : ?
 */
class AtlasDB extends GI_Base {
	/**
	 * Constructor
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : None
	 * @return    : None
	 * 				
	 */
		public function __construct() {

		parent::__construct();
		
 
		// get a connection to the database
		$this->_db = DB::connect($this->getProductDB());
		
	 
		
		// did we successfully get a connection to the database?
		if(DB::isError($this->_db)) {
			$this->_raiseError(sprintf("%s error : %s", __CLASS__, $this->_db->getMessage()), 4, 4);
		}
	}
	

public function getProductDB(){
		$this->_db= DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($this->_db)) {
			echo "Error: Could not retrieve mysql connect string for $this->_productID";
		}
		$sql = sprintf("select value from appenv where app='go' and key_name='product_db';");
		$this->_productDB = $this->_db->getOne($sql);
		$this->_db->disconnect;
		return $this->_productDB;
	}
	
	
	/**
	 * query
	 *
	 * This method provides access to general SQL queries
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @param     : query   string that contains a vaild SQL query
	 * @return    : returns a reference to an associative array containing the results of the query
	 *              on error returns a error class
	 */
	public function & query($sql = "") {
	
 
		$retval = NULL;
		// do we have a query?
		if($sql != "") {
			// run the query
			$retval = $this->_db->getAll($sql, DB_FETCHMODE_ASSOC);
			// did we get an error?
			if(DB::isError($retval)) {
				$retval = $this->_raiseError(sprintf("%s error : %s", __CLASS__, $retval->getMessage()), 4, 4);
			}
		}
		// return the data to the user
		return $retval;
	}

	/**
	 * object
	 *
	 * This method provides access to the underlying database object
	 * in case the API provided here isn't enough
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004
	 * @return    : returns a reference to the underlying $this->_db object
	 */
	public function & object() {
		return $this->_db;
	}

	/**
	 * disconnect
	 *
	 * This method disconnects from the database
	 *
	 * @author    : Doug Farrell dfarrell@scholastic.com
	 * @package   : GI
	 * @version   : v 1.0  12/4/2004 - Revised for NGO 11/12/2008 by PK
	 * @param     : ?
	 * @return    : ?
	 */
	public function disconnect() {
	 
		$this->_db->disconnect();
	}
}


?>