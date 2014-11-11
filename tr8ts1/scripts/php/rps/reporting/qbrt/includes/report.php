<?php
/**
* Report class
*
* This class contains an array of rows returned by
* a database query, and some information about the
* columns.
*
* @author       Richard E. Dye
* @copyright    4/30/2004
* @package      qbrt
*/
class report{
    var $_columns=array();
    var $_header;
    var $_rows=array();

    /**
    * The constructor
    *
    * An associative array describing the columns of the report
    * is passed in as a parameter.  This array has column IDs as
    * keys, and human-readable column titles as values.
    * The keys are used to construct the '_columns' array.
    *
    * @param    $inHeader   array   Header array
    * @return   report object
    */
    function report($inHeader){
        $this->_header = $inHeader;

        foreach ($inHeader as $key=>$value) {
            $this->_columns[] = $key;
        }

    }

    /**
    * Add a row of data to the report
    *
    * Given a row of data in the form of an associative array, where
    * the keys are the header keys, add a row to the report
    *
    * @param    $inRow  array   Row of data
    */
    function addRow($inRow){
        $headcount = sizeof($this->_columns);

        if ($headcount) {
            $feeder = array();
            for ($i=0; $i<$headcount; $i++) {
                if (isset($inRow[$this->_columns[$i]])) {
                    $feeder[$this->_columns[$i]] = $inRow[$this->_columns[$i]];
                }
            }
            $this->_rows[]=$feeder;
        }
    }

    /**
    * Get the number of rows in this report
    *
    * @return   number  row count
    */
    function sizeof(){
        return sizeof($this->_rows);
    }

    /**
    * Get a row of data
    *
    * @param    $inIndex    number  Row to retrieve
    * @return   array   report row
    */
    function getRow($inIndex){
        return $this->_rows[$inIndex];
    }

    /**
    * Get the report header
    *
    * @return   array   report header
    */
    function getHeader(){
        return $this->_header;
    }

}

?>
