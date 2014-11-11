<?php
    include_once($_SERVER["PHP_INCLUDE_HOME"]."stats/statsrep2.0/Report.php");

/**
* Class for gathering usage for a recipient ID and its children.
* 
* 12/06/2006 PHP 5 Conversion.
* 
*/
class SummaryReport extends Report {

    /**
    * include child institutions in total?
    * @var boolean
    * @access public 12/06/2006 No getter was in place.  It may be accessed 
    * from outside the class.
    */
    public $_skipkids;

    /**
    * The constructor
    * @access   public
    */
    public function __construct($inID, $startDate, $endDate, $skipkidsFlag, $prodFilter=""){
        
    	//  assign member property
    	$this->_skipkids = $skipkidsFlag;
        
        //  call the parent constructor
        parent::__construct($inID, $startDate, $endDate, $prodFilter);
    }


    /**
    * _fetchUsage()
    *
    * Perform the actual query, saving the results in a hash.
    * @access public 12/06/2006 Public in parent, public here.  May be accessed elsewhere.
    */
    public function _fetchUsage(){
        $queryString = "select product_code PRODUCT, sum(activity_onsite_cnt) OACTIVITY, ";
        $queryString .= "sum(session_onsite_cnt) OSESSIONS, sum(activity_remote_cnt) RACTIVITY, ";
        $queryString .= "sum(session_remote_cnt) RSESSIONS ";
        $queryString .= "from recipient_agg ";
        $queryString .= "where agg_date between '" . $this->_startDate."' and '" . $this->_endDate . "' ";

        if ($this->_skipkids) {
            $queryString .= "and recipient_id='".$this->_CUID."' ";
        } else {
            $queryString .= "and recipient_id in (";
            $queryString .= "select cid from customer_tree ";
            $queryString .= "start with pid = '".$this->_CUID."' ";
            $queryString .= "connect by prior pid = cid ";
            $queryString .= "union ";
            $queryString .= "select '".$this->_CUID."' from dual";
            $queryString .= ") ";
        }

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


    /**
    * __fetchDateBounds()
    *
    * Fetch the first and last dates, within the requested range, which
    * actually have usage.
    *
    * Override of the base class's function, so that the 'skipchildren' flag
    * can be handled
    * 
    * @access public 12/06/2006 Public in parent, public here.  May be accessed elsewhere.
    */
    public function _fetchDateBounds(){
        $queryString = "select agg_date, to_char(agg_date, 'MM/YYYY') THEDATE from recipient_agg ";
        $queryString .= "where ";
        $queryString .= "agg_date between '".$this->_startDate."' and '".$this->_endDate."' ";

        if ($this->_skipkids) {
            $queryString .= "and recipient_id='".$this->_CUID."' ";
        } else {
            $queryString .= "and recipient_id in (";
            $queryString .= "select cid from customer_tree ";
            $queryString .= "start with pid = '".$this->_CUID."' ";
            $queryString .= "connect by prior pid = cid ";
            $queryString .= "union ";
            $queryString .= "select '".$this->_CUID."' from dual";
            $queryString .= ") ";
        }

        if ($this->_prodfilter != "") {
            $queryString .= "and product_code='$this->_prodfilter' ";
        }

        $queryString .= "and ";
        $queryString .= "(activity_remote_cnt+activity_onsite_cnt+session_remote_cnt+session_onsite_cnt) > 0 ";
        $queryString .= "group by agg_date ";
        $this->_parseDateBounds($queryString);
    }



}

?>
