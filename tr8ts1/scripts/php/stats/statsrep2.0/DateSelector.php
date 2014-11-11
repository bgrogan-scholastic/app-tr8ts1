<?php

    require_once('DB.php');

/**
* Class for wrangling a date range selector
* 
* 12/06/2006 SJF PHP 5 Conversion
* 
*/
class DateSelector {

    /**
    * hash of valid dates
    *
    * The key is the human friendly date, and the value is the Oracle date.
    * @var  string array
    * @access public 
    */    
    public $_dates = array();

    /**
    * The constructor
    *
    * @access   public
    * @param    string  Customer ID for which to find the valid dates.
    */
    public function __construct($inCUID){
        $db = DB::connect($_SERVER['STATS_CONNECT_STRING']);
        if (PEAR::isError($db)) {
            return;
        }

        $queryString = "select agg_date, to_char(agg_date, 'Month(MM) YYYY') THEDATE ";
        $queryString .= "from recipient_agg ";
        $queryString .= "where ";
        $queryString .= "recipient_id in (";
        $queryString .= "select cid from customer_tree ";
        $queryString .= "start with pid = '$inCUID' ";
        $queryString .= "connect by prior pid = cid ";
        $queryString .= "union ";
        $queryString .= "select '$inCUID' from dual ";
        $queryString .= ")";
        $queryString .= "group by agg_date";

        $result =& $db->query($queryString);
	    if (PEAR::isError($result)) {
            return;
	    }

        while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $this->_dates[$dbrow['THEDATE']] = $dbrow['AGG_DATE'];
        }

        $result->free();
        $db->disconnect();
    }

    /**
    * Output the HTML formatted result
    *
    * @access   public
    * @param    enum    Should the first date, last date, or no date be selected
    * @return   string  HTML formatted selector, or empty string.
    */
    public function output($name, $firstlast=NULL){
        $numDates = count($this->_dates);
        $firstDate = $numDates-1;

        $outString = '<select name="'.$name.'">'."\n";
        foreach ($this->_dates as $human=>$oracle) {
            $numDates--;
            $outString .= '<option value="'.$oracle.'"';
            
            if (($numDates == 0 && $firstlast == 'last')
                    || ($numDates == $firstDate && $firstlast == 'first')) {
                $outString .= ' selected="selected"';
            }
            
            $outString .= '>'.$human."</option>\n";
        }
        $outString .= "</select>\n";

        return $outString;
    }

}


?>
