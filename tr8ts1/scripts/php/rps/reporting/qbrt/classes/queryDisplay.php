<?php

require_once(getcwd().'/includes/booleanQuery.php');

/**
* Query display object
*
* @author       Richard E. Dye
* @copyright    3/31/2004
* @package      qbrt
*/
class queryDisplay{

    var $_query;
    var $selectedNode = -1;
    var $selectedOperator = -1;

    /**
    * Constructor
    *
    * @param    $inparms    array input parameters
    * @return   queryDisplay
    */
    function queryDisplay($inparms){
        $this->_query = new booleanQuery();
    }


    /**
    * clearQuery
    *
    * Discard the current query and start again.
    *
    * @param    $inparms    array input parameters
    */
    function clearQuery($inparms){
        unset($this->_query);
        $this->_query = new booleanQuery();
        $this->selectedNode = -1;
        $this->selectedOperator = -1;

        return $this->output(NULL);
    }

    /**
    * Output the Query
    *
    * @param    $inparms    array input parameters
    * @return   string  HTML for the output
    */
    function output($inparms){
        $outstring = '';

        $elements = $this->_query->sizeof();

        #$outstring .= "<p>Query display (current operator = ".$_SESSION['global_currentOperator'].")</p>\n";
        if (!$elements) {
            $outstring .= "<p>Query display</p>\n";
        }

        $outstring .= '<font size="-1" face="Arial, helvetica">'."\n";

        if ($elements) {
            $outstring .= '<table width="100%" bgcolor="white" border="1" cellpadding="10">
                    <tr><td nowrap>'."\n";
            for ($index=0; $index < $elements; $index++) {
                if ($index == $this->selectedNode || $index == $this->selectedOperator) {
                    $outstring .= '<b>';
                }
                $mytype = $this->_query->getType($index);
                if ($mytype == 'o') {
                    $outstring .= "<br />\n";
                }
                if ($mytype != 'p') {
                    $outstring .= '<a name="'.$index.'" href="'.$_SERVER['PHP_SELF'].'?class=queryDisplay&method=select&parm_element='.$index.'#'.$index.'">';
                } else {
                    $outstring .= '<font size="+1">';
                }
                $outstring .= $this->_query->getTitle($index);

                # Display the ID for testing purposes
                #if ($this->_query->getType($index) == 'n') {
                #    $outstring .= ' ['.$this->_query->getId($index).']';
                #}
                
                if ($index == $this->selectedNode || $index == $this->selectedOperator) {
                    $outstring .="</b></font>";
                }
                
                if ($mytype != 'p') {
                    $outstring .= "</a>";
                } else {
                    $outstring .= '</font>';
                }
                if ($mytype == 'o') {
                    $outstring .= "<br />\n";
                }
            }
            $outstring .= "</td></tr></table>\n";
        }
        $outstring .= "</font>\n";
        $outstring .= '<a name="bottom">&nbsp</a>'."\n";
        return $outstring;
    }

    /**
    * Add a node to the query
    *
    * @param    $inparms    array input parameters
    * @return   string      HTML for the output
    */
    function addNode($inparms){
        if ($this->_query->sizeof()) {
            $this->_query->append(new queryElement($_SESSION['global_currentOperator'], 'o'));
        }
        $this->_query->append(new queryNode($inparms['title'],$inparms['id']));

        return $this->output(NULL);
    }

    /**
    * Select a node or operator
    */
    function select($inparms){
        $index = $inparms['element'];
        $type=$this->_query->getType($index);
        if ($type == 'n')
            $this->selectedNode = $index;
        elseif ($type == 'o')
            $this->selectedOperator = $index;

        return $this->output(NULL);
    }

    /**
    * Change the currently selected logical operator
    */
    function changeOperator($inparms){
        if ($this->selectedOperator >= 0) {
            $this->_query->setTitle($this->selectedOperator, $inparms['operator']);
        }

        return $this->output(NULL);
    }

    /**
    * Insert a parenthesis element before or after the currently selected node
    */
    function insertparen($inparms){        
        if ($this->selectedNode >= 0) {
            if ($inparms['ptype'] == 'open') {
                $this->_query->insert(new queryElement('(', 'p'), $this->selectedNode);
                if ($this->selectedOperator > $this->selectedNode) {
                    $this->selectedOperator++;
                }
                $this->selectedNode++;
            } else {
                $this->_query->insert(new queryElement(')', 'p'), $this->selectedNode+1);
                if ($this->selectedOperator > $this->selectedNode) {
                    $this->selectedOperator++;
                } 
            }
        }

        return $this->output(NULL);
    }

    /**
    * Delete a parenthesis element before or after the currently selected node
    */
    function deleteparen($inparms){
        if ($this->selectedNode >= 0) {
            if ($inparms['ptype'] == 'open') {
                if ($this->_query->getType($this->selectedNode-1) == 'p') {
                    $this->_query->delete($this->selectedNode-1);
                    if ($this->selectedOperator > $this->selectedNode) {
                       $this->selectedOperator--;
                    }
                    $this->selectedNode--;
                }
            } else {
                if ($this->_query->getType($this->selectedNode+1) == 'p') {
                    $this->_query->delete($this->selectedNode+1);
                    if ($this->selectedOperator > $this->selectedNode) {
                       $this->selectedOperator--;
                    }
                }
            }
        }
        return $this->output(NULL);
    }

    /**
    * return this object's boolean query object.
    *
    * @return   booleanQuery
    */
    function getBooleanQuery(){
        return $this->_query;
    }
}
?>
