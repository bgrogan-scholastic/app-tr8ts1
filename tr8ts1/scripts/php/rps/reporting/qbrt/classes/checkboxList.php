<?php

require_once(getcwd().'/includes/cblItem.php');

/**
* Checkbox List object
*
* @author       Richard E. Dye
* @copyright    3/31/2004
* @package      qbrt
*/
class checkboxList{
    var $_title = '';
    var $_items = array();
    var $_error = '';

    /**
    * Constructor
    *
    * @param    $inparms    array of input parameters
    */
    function checkboxList($inparms){
        $this->_title = $inparms['title'];
        #$this->_title = $inparms['class'].':'.$inparms['instance'];
    }

    /**
    * Fetch the number of elements in the list
    *
    * @return   number  number of elements
    */
    function sizeof(){
        return sizeof($this->_items);
    }

    /**
    * Fetch the state of one of our items by index
    *
    * @param    $inIndex    number  item to retrieve
    * @return   boolean state of item
    */
    function getState($inIndex){
        return $this->_items[$inIndex]->getState();
    }

    /**
    * Fetch the ID of one of our items by index
    *
    * @param    $inIndex    number  item to retrieve
    * @return   string  ID of the item
    */
    function getID($inIndex){
        return $this->_items[$inIndex]->getID();
    }

    /**
    * Fetch the title of one of our items by index
    *
    * @param    $inIndex    number  item to retrieve
    * @return   string  Item title
    */
    function getTitle($inIndex){
        return $this->_items[$inIndex]->getTitle();
    }

    /**
    * Toggle one of our checkboxes
    *
    * @param    $inparms    arrary of input parameters
    */
    function toggleCheckbox($inparms){
        $inIndex = $inparms['index'];

        if ($inIndex < sizeof($this->_items)) {
            $this->_items[$inIndex]->toggle();
        }

        return $this->output($inparms);
    }



    /**
    * Output the Checkbox list
    *
    * @param    $inparms    array input parameters
    * @return   string      HTML for the output
    */
    function output($inparms){
        if ($this->_error != '') {
            return "<p>$this->_error</p>\n";
        }

 
        $outstring = "\n".'<script language="javascript">'."\n";
        $outstring .= "function toggleCheck(inIndex){\n";
        $outstring .= "    this.location='".$_SERVER['PHP_SELF']."?class=".$inparms['class'];
        if (isset($inparms['instance'])) {
            $outstring .= "&instance=".$inparms['instance'];
        }
        $outstring .= "&method=toggleCheckbox&parm_index='+inIndex;\n";
        #$outstring .= "    alert(newOperator);\n";
        $outstring .= "}\n";
        $outstring .= "</script>\n\n";

        $size = sizeof($this->_items);

        $outstring .= '<font size="-2" face="Arial, helvetica">'."\n";
        $outstring .= '<form action="nothing" method="post">'."\n";
        $outstring .= '<table width="100%" border="0" bgcolor="#ffffff">'."\n";
        $outstring .= "<tr><th>".$this->_title."</th></tr>\n";
        if ($size) {
            for ($i=0; $i<$size; $i++) {
                $outstring .= "<tr><td nowrap>";
                $outstring .= '<input type="checkbox"';
                if ($this->_items[$i]->getState()) {
                    $outstring .= ' checked';
                }
                $outstring .= ' onClick="javascript:toggleCheck('.$i.')">';
                $outstring .= $this->_items[$i]->getTitle()."</td></tr>\n";
            }
        }

        $outstring .= '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?class='.$inparms['class'];
        if (isset($inparms['instance'])) {
            $outstring .= '&instance='.$inparms['instance'];
        }
        $outstring .= '&method=checkall">Check all</a></td></tr>'."\n";
        
        $outstring .= '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?class='.$inparms['class'];
        if (isset($inparms['instance'])) {
            $outstring .= '&instance='.$inparms['instance'];
        }
        $outstring .= '&method=uncheckall">Uncheck all</a></td></tr>'."\n";
        

        $outstring .= "</table>\n";
        $outstring .= "</form>\n";
        $outstring .= "</font>\n";
        return $outstring;
    }

    /**
    * Check all the boxes
    *
    * @param    $inparms    array input parameters
    * @return   string      HTML for the output
    */
    function checkall($inparms){
        $size = sizeof($this->_items);
        if ($size) {
            for ($i=0; $i<$size; $i++) {
                $this->_items[$i]->setState(true);
            }
        }

        return $this->output($inparms);
    }

    /**
    * Uncheck all the boxes
    *
    * @param    $inparms    array input parameters
    * @return   string      HTML for the output
    */
    function uncheckall($inparms){
        $size = sizeof($this->_items);
        if ($size) {
            for ($i=0; $i<$size; $i++) {
                $this->_items[$i]->setState(false);
            }
        }

        return $this->output($inparms);
    }
}

?>
