<?php

    require_once('DB.php');

/**
* Base class for formatting output
* 
* 12/06/2006 SJF PHP 5 Conversion
* 
* I made all methods and properties public altough they look like they 
* should be protected.  We have come across code that has attributes
* access directly.  Don't want to break anything.
* 
*/
class Formatter {

    /**
    * hash of product
    * @var  DB connection
    * @access public
    */
    public $_prodNames = array();

    /**
    * Constructor
    *
    * Perform the initial functions common to all output formats.
    * @access protected 12/05/2006 If code outside of this class accesses this
    * directly, make it public.
    */
    public function __construct(){
        $this->_fetchProdNames();
    }

    /**
    * _fetchProdNames()
    *
    * Retrieve a list of human-readable product names from the database.
    * @access public
    */
    public function _fetchProdNames(){
        $db = DB::connect($_SERVER['AUTH_CONNECT_STRING']);
        if (!PEAR::isError($db)) {
            #print "<p>_fetchProdNames() connected</p>\n";
            $queryString = "select product_code PCODE, product_name PNAME from product group by product_code, product_name order by product_name";

            $dataSet =& $db->query($queryString);
            if (!PEAR::isError($dataSet)) {
                #print "<p>_fetchProdNames() query succeeded</p>\n";
                while ($dbrow =& $dataSet->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_prodNames[$dbrow['PCODE']] = $dbrow['PNAME'];
                }
                $dataSet->free();
            }
            $this->_prodNames['zzzallprods'] = "All databases";

            $db->disconnect();
        }
    }

    /**
    * _prodSort()
    *
    * Sort the entries in a results set by product in an arbitrary order
    * @access public
    */
    public function _prodSort($inResultset){
        $prodOrder = array('go', 'srch', 'ea', 'gme', 'nbk', 'nec', 'atb', 'eas', 'lp', 'nbps');
        $outResult = array();
        foreach ($prodOrder as $prodCode) {
            if (isset($inResultset[$prodCode])) {
                $outResult[$prodCode] = $inResultset[$prodCode];
                unset($inResultset[$prodCode]);
            }
        }

        # sweep up any missed items (including the totals)
        foreach ($inResultset as $prodCode => $hitCounts) {
            $outResult[$prodCode] = $hitCounts;
        }
        return $outResult;
    }

}
