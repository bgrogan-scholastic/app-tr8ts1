<?php
    include_once($_SERVER["PHP_INCLUDE_HOME"]."stats/statsrep2.0/Report.php");

/**
* Class for gathering usage for all of the children of a master
* customer id with a given aggregate code.
* 
* 12/06/2006 SJF PHP 5 Conversion.
* 
*/
class AggregateReport extends Report {

    /**
    * Aggregate code (and name) for this report
    * @var  string
    * @access public
    */
    public $_aggName;

    /**
    * The constructor
    * @access   public
    */
    public function __construct($inAggregate, $inID, $startDate, $endDate, $prodFilter=""){
        $this->_aggName = $inAggregate;
        $this->Report($inID, $startDate, $endDate, $prodFilter);
    }


    /**
    * _fetchUsage()
    *
    * Perform the actual query, saving the results in a hash.
    * @access public 12/06/2006 SJF I made it public even though is looks like a method
    * this class should call (underscore in it's name, what it does....).  It is not called
    * by this class.  Someone else may call it.
    */
    public function _fetchUsage(){
        $queryString = "select ra.product_code PRODUCT, ";
        $queryString .= "sum(ra.activity_onsite_cnt) OACTIVITY, sum(ra.session_onsite_cnt) OSESSIONS, ";
        $queryString .= "sum(ra.activity_remote_cnt) RACTIVITY, sum(ra.session_remote_cnt) RSESSIONS ";
        $queryString .= "from recipient_agg ra, customer c ";
        $queryString .= "where ra.recipient_id = c.customer_id ";
        $queryString .= "and c.AGGREGATE = '".$this->_aggName."' ";
        $queryString .= "and ra.agg_date between '" . $this->_startDate."' and '" . $this->_endDate . "' ";
        $queryString .= "and ra.recipient_id in ";
        $queryString .= "(";
        $queryString .= "select cid from customer_tree ";
        $queryString .= "start with pid = '".$this->_CUID."' ";
        $queryString .= "connect by prior pid = cid ";
        $queryString .= "union ";
        $queryString .= "select '".$this->_CUID."' from dual";
        $queryString .= ") ";

        if ($this->_prodfilter != "") {
            $queryString .= "and ra.product_code='$this->_prodfilter' ";
        }

        $queryString .= "group by ra.product_code";
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
    * @access public
    */
    public function _fetchDateBounds(){
        $queryString = "select agg_date, to_char(agg_date, 'MM/YYYY') THEDATE ";
        $queryString .= "from recipient_agg ra, customer c ";
        $queryString .= "where agg_date between '" . $this->_startDate."' and '" . $this->_endDate . "' ";
        $queryString .= "and ra.recipient_id = c.customer_id ";
        $queryString .= "and c.AGGREGATE = '".$this->_aggName."' ";
        $queryString .= "and ";
        $queryString .= "ra.recipient_id in (";
        $queryString .= "select cid from customer_tree ";
        $queryString .= "start with pid = '".$this->_CUID."' ";
        $queryString .= "connect by prior pid = cid ";
        $queryString .= "union ";
        $queryString .= "select '".$this->_CUID."' from dual";
        $queryString .= ") ";
        $queryString .= "and ";
        $queryString .= "(activity_remote_cnt+activity_onsite_cnt+session_remote_cnt+session_onsite_cnt) > 0 ";
        $queryString .= "group by agg_date";
        $this->_parseDateBounds($queryString);
    }

    /**
    * getName()
    *
    * hand back this report's title.
    * @access public
    */
    public function getName(){
        return $this->_aggName;
    }
}

?>
