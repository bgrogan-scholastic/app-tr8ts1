<?php

    require_once('DB.php');

/**
* Base class for all reports
* 12/06/2006 SJF PHP 5 conversion
* 
* I am making all properties and methods public.  This class
* has children with methods that overwrite the base class, never called
* in the child class, but called in the base class.  
* 
* I would set all to protected, but better to not have something unaccessible.
* 
*/
class Report {

    /**
    * database connection
    * @var  DB connection
    * @access public
    */
    public $_db = NULL;

    /**
    * Customer ID for this report
    * @var  string
    * @access public
    */
    public $_CUID;

    /**
    * The customer name for this report
    * @var  string
    * @access public
    */
    public $_name = "";

    /**
    * The result set (report contents) for this report
    * @var  hash
    * @access public
    */
    public $_resultSet = array();

    /**
    * Product filter to apply, if any.
    * @var  string
    * @access public
    */
    public $_prodfilter = "";

    /**
    * start of the date range
    * @var  date
    * @access public
    */
    public $_startDate = "";

    /**
    * end of the date range
    * @var  date
    * @access public
    */
    public $_endDate = "";

    /**
    * First date in the range with usage
    * @var  date
    * @access public
    */
    public $_upperBound;

    /**
    * Last date in the range with usage
    * @var  date
    * @access public
    */
    public $_lowerBound;

    /**
    * The result set from the database query.
    * @var  DB results set
    * @access public
    */
    public $_dataSet = NULL;

    /**
    * Constructor
    * @access public
    *
    */
    public function __construct($inID, $startDate, $endDate, $prodFilter=""){
        $this->_CUID = $inID;
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;
        $this->_prodfilter=$prodFilter;
        #print "<!-- The frapping prodfilter in Report() is $prodFilter -->\n";

        $this->_db = DB::connect($_SERVER['STATS_CONNECT_STRING']);
        if (PEAR::isError($this->_db)) {
            print "\n<p>".$this->_db->getMessage()."\n</p>\n";
        } else {
            $this->_fetchName();
            $this->_fetchUsage();
            $this->_fetchDateBounds();
            $this->_db->disconnect();
        }
    }


    /**
    * _fetchName()
    *
    * Retrieve the name for this customer id.
    * 
    * @access public
    */
    public function _fetchName(){
        $this->_name = $this->_db->getOne("select name from customer where customer_id='".$this->_CUID."'");
    }

    /**
    * __fetchDateBounds()
    *
    * Fetch the first and last dates, within the requested range, which
    * actually have usage.
    * Separate from the function which actually performs the query, so it
    * can easily be overridden in derived classes.
    * 
    * @access public
    */
    public function _fetchDateBounds(){
        $queryString = "select agg_date, to_char(agg_date, 'MM/YYYY') THEDATE from recipient_agg ";
        $queryString .= "where ";
        $queryString .= "agg_date between '".$this->_startDate."' and '".$this->_endDate."' ";

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

        $queryString .= "and ";
        $queryString .= "(activity_remote_cnt+activity_onsite_cnt+session_remote_cnt+session_onsite_cnt) > 0 ";
        $queryString .= "group by agg_date ";
        $this->_parseDateBounds($queryString);
    }


    /**
    * Fetch the upper and lower date bounds based on the passed query string
    *
    * @param    string  query string
    * @access public
    */
    public function _parseDateBounds($queryString) {
        $result =& $this->_db->query($queryString);
	    if (!PEAR::isError($result)) {
	        $currentRow = 0;
	        while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $currentRow++;
                if ($currentRow == 1) {
                    $this->_lowerBound = $dbrow['THEDATE'];
                }
                # Keep loading the upper bound, over and over, 'cause
                # Oracle doesn't know how many rows it's got.  @whee
                $this->_upperBound = $dbrow['THEDATE'];
	        }
            $result->free();
	    }
    }


    /**
    * _parseResults()
    *
    * Transfer the query results to the report results set.
    * 
    * @access public
    */
    public function _parseResults(){
        if ($this->_prodfilter == "") {
            $this->_resultSet['zzzallprods'] = array(0, 0, 0, 0, 0, 0);
        }
        while ($dbrow =& $this->_dataSet->fetchRow(DB_FETCHMODE_ASSOC)) {
            $this->_resultSet[$dbrow['PRODUCT']] = array($dbrow['OACTIVITY'], $dbrow['OSESSIONS'],$dbrow['RACTIVITY'],$dbrow['RSESSIONS'],$dbrow['OACTIVITY']+$dbrow['RACTIVITY'], $dbrow['OSESSIONS']+$dbrow['RSESSIONS']);
            if ($this->_prodfilter == "") {
                $this->_resultSet['zzzallprods'][0] += $dbrow['OACTIVITY'];
                $this->_resultSet['zzzallprods'][1] += $dbrow['OSESSIONS'];
                $this->_resultSet['zzzallprods'][2] += $dbrow['RACTIVITY'];
                $this->_resultSet['zzzallprods'][3] += $dbrow['RSESSIONS'];
                $this->_resultSet['zzzallprods'][4] += $dbrow['OACTIVITY']+$dbrow['RACTIVITY'];
                $this->_resultSet['zzzallprods'][5] += $dbrow['OSESSIONS']+$dbrow['RSESSIONS'];
            }
        }
        $this->_dataSet->free();
        ksort($this->_resultSet);
    }

    /**
    * getResults()
    *
    * Hand back my results set
    * @access public
    */
    public function getResults(){
        return $this->_resultSet;
    }

    /**
    * getName()
    *
    * hand back this report's title.
    * @access public
    */
    public function getName(){
        return $this->_name;
    }

    /**
    * getLowerBound()
    *
    * Hand back the lowest date for which there's usage
    * @access public
    */
    public function getLowerBound(){
        return $this->_lowerBound;
    }

    /**
    * getUpperBound()
    *
    * Hand back the latest date for which there's usage
    * @access public
    */
    public function getUpperBound(){
        return $this->_upperBound;
    }

}
