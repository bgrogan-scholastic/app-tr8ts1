<?php
    include_once($_SERVER["PHP_INCLUDE_HOME"]."stats/statsrep2.0/Report.php");

/**
* Class for gathering usage for a recipient ID and its children.
* 
* 12/06/2006 SJF PHP 5 Conversion
*/
class IndinstReport extends Report {

    /**
    * The constructor
    * @access   public
    */
    public function __construct($inID, $startDate, $endDate, $prodFilter=""){
    	
    	// Call the parent constructor
        parent::__construct($inID, $startDate, $endDate, $prodFilter);
    }


    /**
    * _fetchUsage()
    *
    * Perform the actual query, saving the results in a hash.
    * @access public 12/05/2006 Made public as this class is not calling it.
    * This is an overide of parent::_fetchUsage and it is run in the parent
    * constructor.  Making it protected would allow for that functionality,
    * but this may be called from somewhere outside this class.
    */
	public function _fetchUsage(){
        $queryString = "select product_code PRODUCT, sum(activity_onsite_cnt) OACTIVITY, ";
        $queryString .= "sum(session_onsite_cnt) OSESSIONS, sum(activity_remote_cnt) RACTIVITY, ";
        $queryString .= "sum(session_remote_cnt) RSESSIONS ";
        $queryString .= "from recipient_agg ";
        $queryString .= "where agg_date between '" . $this->_startDate."' and '" . $this->_endDate . "' ";
        $queryString .= "and recipient_id in (";
        $queryString .= "select cid from customer_tree ";
        $queryString .= "start with pid = '".$this->_CUID."' ";
        $queryString .= "connect by prior pid = cid ";
        $queryString .= "union ";
        $queryString .= "select '".$this->_CUID."' from dual";
        $queryString .= ") ";

        if ($this->_prodfilter != "") {
            $queryString .= "and product_code='$this->_prodfilter' ";
        }

        $queryString .= "group by product_code";
        #print "<!-- Query:  " . $queryString . " -->\n";

        $this->_dataSet =& $this->_db->query($queryString);
        if (PEAR::isError($this->_dataSet)) {
            print "\n<p>" . $this->_dataSet->getMessage()."\n</p>\n";
            return false;
        }  else {
            $this->_parseResults();
            return true;
        }
    }
}

?>
