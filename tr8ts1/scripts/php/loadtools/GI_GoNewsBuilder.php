<?php

// Create db connection and grab the appropriate titles and ids             
require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Base/package.php');

/**
* Go2.0 news builder for AP daily news
*
* @author Lori Hongach <lhongach@scholastic.com>
* @version $Revision: 1.6 $
* @date $Date: 2004/12/06 20:17:29 $
* @public
* 
* 12/13/2006 SJF PHP 5 Conversion
*/

define('BREAKING',     'breaking_story');
define('BYLINE',       'byline');
define('BYLINE2',      'byline2');
define('CONTENT',      'content');
define('ID',           'id');
define('PRIORITY',     'priority');
define('TITLE',        'title');
define('APMARQUEE',    '/data/go2-passport/docs/newsnow/marquee.js');
define('SPLASHMARQUEE', '/data/go2-passport/docs/splashfiles/marquee.js');
define('APTEMPLATE',   '/newsnow/apnews.html');

class GI_GoNewsBuilder extends GI_Base
{

  /**
    * Action the user is requesting
    *
    * @access public
    * @var string
    */
    public $action;

  /**
    * Story content 
    *
    * @access public
    * @var array 
    */
    public $story = array();

    /**
     * A reference to an open database resource.
     *
     * @access private
     * @var ref
     */
    public $_db;
    

    /**
    * @name Constructor
    * @access public
    */
    public function __construct(&$db) {
      // Set up variables
      $this->_db    =& $db;
      $this->action = $this->_getQueryValue('useraction');

      $this->story[TITLE]    = $this->_getQueryValue(TITLE);
      $this->story[CONTENT]  = $this->_getQueryValue(CONTENT);
      $this->story[ID]       = $this->_getQueryValue(ID);
      $this->story[PRIORITY] = $this->_getQueryValue(PRIORITY);
      $this->story[BYLINE]   = $this->_getQueryValue(BYLINE);
      $this->story[BYLINE2]  = $this->_getQueryValue(BYLINE2);
      $this->story[BREAKING] = $this->_getQueryValue(BREAKING);

      $this->_makePublic('action', 'story');

    } // end func go2newsbuilder


    /**
    * Return the requested month.
    *
    * @access private SJF - previous doc said private and I agree.  Outside code should not have access.
    * @param string  - Name of query string arg
    * @return string - Value of query string arg
    */
    public function _getQueryValue($name) {
	
    	if(array_key_exists($name, $_GET)) {
			return $_GET[$name];
      	} 
      	else if(array_key_exists($name, $_POST)) {
				return $_POST[$name];
      		 }
        else {
			return "";
      	}
    }

    
    /**
    * Load the values stored in the database for the record requested
    *
    * @access public
    * @param 
    * @return 
    */
    public function loadEditValues() {
		$sql = "SELECT * FROM apnews WHERE id = \"" . 
		$this->_getQueryValue('editstory') . "\"";
      	$result = $this->_db->getAll($sql, DB_FETCHMODE_ASSOC); 
      	$this->story = $result[0];
      
    } // end func loadEditValues


    /**
    * Delete the record(s) specified from the database and remove the t
    * ext file(s)
    *
    * @access public
    * @param 
    * @return 1/0 - Success or failure
    */
    public function deleteRecords() {

      $sql    = "";
      $return = 0;   

      // Delete a single record
      if ($this->action == "delete") { 
        $sql = "DELETE FROM apnews WHERE id = \"" . 
	  $this->_getQueryValue('deletestory') . "\"";
	
      // Delete all records
      } else if ($this->action == "new") {
        $sql = "DELETE FROM apnews";
      }	

      // Execute deletion
      if ($sql != "") {
	$result = $this->_db->query($sql); 

        // Error check 
        if (! DB::isError($result)) {
	  if ($this->action == "delete") {
	    if ($this->_buildMarquee() != 1) {
	      // Build all of the news pages
	      system('/data/stage/utils/go2/build_newsnow_ap.sh > /dev/null');
	      return 0;
	    }
	  } else {
	    @unlink(APMARQUEE);
	    @unlink(SPLASHMARQUEE);
	    return 0;
	  }
	}
      }
      return 1;
    
    } // end func deleteRecords


    /**
    * Insert a record 
    *
    * @access public
    * @param 
    * @return 1/0 - Success or failure
    */
    public function insertRecord() {

      // Insert a single record
      if ($this->action == "new" || $this->action == "add") { 
	$date = date('ndyhms');
	
	// We want to default the second byline if nothing is specified
	// lah - 5/19 - barbara asked to have this removed
	//	if (trim($this->story[BYLINE2]) == "")
	//	  $this->story[BYLINE2] = "Associated Press Writer"; 

        $sql = "INSERT INTO apnews (id, title, content, priority, byline, byline2, breaking_story) VALUES (\"$date\", \"" . $this->story[TITLE] . "\", \"" . $this->story[CONTENT] . "\", \"" . $this->story[PRIORITY] . "\", \"" . $this->story[BYLINE] . "\", \"" . $this->story[BYLINE2] . "\", \"" . $this->story[BREAKING] . "\")";

	$result = $this->_db->query($sql); 

        // Error check 
        if (! DB::isError($result)) {
	  $this->_buildMarquee();

          // Build all of the news pages
	  system('/data/stage/utils/go2/build_newsnow_ap.sh > /dev/null');
	  return 0;
	  
	}

      }
      return 1;
    
    } // end func insertRecord


    /**
    * Update the record specified
    *
    * @access public
    * @param 
    * @return 1/0 - Success or failure
    */
    public function updateRecord() {

      // Update the database record
      $sql = "UPDATE apnews SET title=\"" . $this->story[TITLE] . "\", content=\"" . $this->story[CONTENT] . "\", priority=\"" . $this->story[PRIORITY] . "\", byline=\"" . $this->story[BYLINE] . "\", byline2=\"" . $this->story[BYLINE2] ."\", breaking_story=\"" . $this->story[BREAKING] . "\" WHERE id = \"" . $this->story[ID]. "\"";


      $result = $this->_db->query($sql); 

      // Error check 
      if (! DB::isError($result)) {
	$this->_buildMarquee();

	// Build all of the news pages
	system('/data/stage/utils/go2/build_newsnow_ap.sh > /dev/null');
	return 0;
	
      }

      return 1;
      
    } // end func updateRecord


    /**
    * Update the record specified
    *
    * @access public
    * @param 
    * @return 1/0 - Success or failure
    */
    public function getPriorities() {

      $sql    = "select distinct priority from apnews";
      $result = $this->_db->getAll($sql, DB_FETCHMODE_ASSOC); 

      if (! DB::isError($result)) {
	return $result;
      }	else {
	return "";
      }
    }


    /**
    * Create the javascript text file for the marquee
    *
    * @access private 12/13/2006 SJF Enforced as per previous doc
    * @param 
    * @return 1/0 - Success or failure
    */
    private function _buildMarquee() {
      
      $sql = "SELECT priority, title, breaking_story FROM apnews"; 
      $result = $this->_db->getAll($sql, DB_FETCHMODE_ASSOC); 

      // Error check                                                          
      if (DB::isError($result))
      	return 1;       

      // Open file for writing
      $fp = @fopen(APMARQUEE, "w");
      foreach($result as $row) {
	$url = "/page?tn=" . APTEMPLATE . "&seq=";
	@fwrite($fp, "myScroller1.addItem(\"<a class=");
	
	if ($row[BREAKING] == "1")
	  @fwrite($fp, "'breakingnews'");
	else
	  @fwrite($fp, "'marquee'");

	@fwrite($fp, " href='$url" . $row['priority'] . "'>" . $row['title'] . 
		"</a>\");");
      }
      fclose($fp);

    // 3/16/2005: R.E. Dye: Added for the splash page version of the marquee.
      // Open file for writing
      $fp = @fopen(SPLASHMARQUEE, "w");
      foreach($result as $row) {
      
	    @fwrite($fp, 'myScroller1.addItem("<a class=');
	
	    if ($row[BREAKING] == "1")
	        @fwrite($fp, '\\"breakingnews\\"');
	    else
	        @fwrite($fp, '\\"marquee\\"');

	@fwrite($fp, ' href=\\"javascript:thePopup.newWindow(\'/page?tn=/newsnow/apnews.html&seq='
	    . $row['priority']
	    . '\', \'750\', \'420\', \'NewsNow\', \'yes\', \'yes\', \'no\', \'yes\', \'yes\', \'yes\');\\">'
	    . $row['title'] . "</a>\");\n");
      }
      fclose($fp);
    }

} // end class 

?>
