<?php

require_once('DB.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'common/GI_Base/package.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'common/utils/GI_getVariable.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'common/utils/GI_SubTemplate.php');

/**
* Retrieve a database record
*
* A class intended to retrieve a single row from the database,
* and return individual column values on demand.
* @author       Richard E. Dye
* @copyright    3/3/2004
* @package      database
*/
   class GI_DBRecord extends GI_Base {

    /**
    * Array of data values
    * @access   private
    * @var      array
    */
    private $_keyArray = array();

        /**
        * Constructor
        *
        * The query passed as a parameter may contain 'bind' variables
        * in the form ##VARNAME##.  This will be substituted using the
        * GI_GetVariable() utility function.
        *
        * @param    string  $inQuery The query to perform
        */
		public function __construct($inQuery){
    	    parent::__construct();
            # create a subtemplate object and retrieve its keys
            $mySubtemplate = new GI_SubTemplate($inQuery);
            $this->_keyArray = $mySubtemplate->getKeys();

            # populate the keys array with 'getvariable'
            foreach ($this->_keyArray as $key=>$value)
                $this->_keyArray[$key] = GI_GetVariable($key);

            # perform the query using the populated query string
			$db = DB::connect($_SERVER["DB_CONNECT_STRING"]);

            if (!PEAR::isError($db)) {
    			$result =& $db->query($mySubtemplate->toString($this->_keyArray));

                # add one database row's key/value pairs to the keys array.
                if (!DB::isError($result)) {
                    if ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                        foreach ($dbrow as $key=>$value)
                            $this->_keyArray[$key] = $value;
                    }
                } else {
                    $this->_raiseError('Unable to fetch row from database.', 8, 3, TRUE);
                }
            } else {
                $this->_raiseError('Unable to connect to the database.', 8, 1, TRUE);
            }
		}

        /**
        * Get data value
        *
        * Retrieve a column value from the query result, or the value
        * of one of the 'bind' variables used in the query.
        * @param    string  $inKey The column or 'bind' variable name
        * @return   string  The value of the column or 'bind' variable
        */
		public function getValue($inKey){
		    if (isset($this->_keyArray[$inKey]))
                return $this->_keyArray[$inKey];
            else
                return $this->_raiseError('No data for '.$inKey.' column', 1, 3);
        }


    }

?>

