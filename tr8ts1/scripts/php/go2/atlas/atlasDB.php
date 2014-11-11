<?php
// include the required libraries
require_once('DB.php');
//require_once('./constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Constants.php');
require_once(SERVER_PHP_INCLUDE_HOME . 'common/GI_Base/package.php');

/**
 * Somewhat generalized database class for the atlas feature
 *
 * Name       : AtlasDB
 * @author    : Doug Farrell dfarrell@scholastic.com
 * @package   : GI
 * @version   : v 1.0  12/4/2004
 * @param     : ?
 * @return    : ?
 * 
 * 12/05/2006 SJF PHP 5 Conversion
 * 
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
	 * @access public
	 * 
	 */
	public function __construct() {
		// call parent constructor
		parent::__construct();
		// get a connection to the database
		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		// did we successfully get a connection to the database?
		if(DB::isError($this->_db)) {
			$this->_raiseError(sprintf("%s error : %s", __CLASS__, $this->_db->getMessage()), 4, 4);
		}
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
	 * @access public
	 */
	public function & query($sql = "") {
		$retval = NULL;
		// do we have a query?
		if($sql != "") {
			// run the query
			//
			//  12/12/2006 SJF unit testing threw a fatal error: 
			//  Call to undefined method DBError::getAll.
			//  $this->_db could be a DBError or a DB.
			//  We'll check for $this->_db being an occurrence of DB
			//  Further analysis shows that the atlas php file has
			//  executable code.  The environment was not being set 
			//  up completely as the this class was being instantiated
			//  and used.
			//
			//  I took the check back out so that the code is unchanged.
			//  the comment stays.
			
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
	 * @access public SJF: I am concerned with letting this be public, but since it
	 * is coded as a getter, someplace else expects it, I assume.
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
	 * @version   : v 1.0  12/4/2004
	 * @param     : ?
	 * @return    : ?
	 * @access public
	 */
	public function disconnect() {
		$this->_db->disconnect();
	}
}


?>