<?php

/**
* An index branch object
*
* @author       Richard E. Dye
* @copyright    4/7/2004
* @package      qbrt
*/
class classDex{

    var $_nodeID;
    var $_title;
    var $_type;
    var $_queryTarget;
    var $_parent;
    var $_parentTitle;
    var $_expanded = 0;
    var $_expandable = true;
    var $_branches = array();

    /**
    * constructor
    *
    * @param    $inNodeID   mixed   ID for this new node
    * @param    $inTitle    string  Title for this new node
    * @param    $inParent   string  fully qualified ID for this node's parent.
    */
    function classDex($inNodeID, $inTitle, $inType, $inTarget, $inParent='', $inParentTitle=''){
        $this->_nodeID = $inNodeID;
        $this->_title = $inTitle;
        $this->_type = $inType;
        $this->_queryTarget = $inTarget;
        $this->_parent = $inParent;
        $this->_parentTitle = $inParentTitle;
        $this->_expandable = $this->_checkExpandable();
    }



    /**
    * Construct the HTML for displaying this node.
    *
    * This will include all the children of this node.
    *
    * @return   string  HTML
    */
    function output($inIndex, $tabbing=''){
        $outstring = '<nobr>'.$tabbing;

        if ($this->_expandable) {
            $outstring .= '<a name="'.$this->_nodeID.'" href="'.$_SERVER['PHP_SELF'].'?class=indexBrowser&method=toggle&parm_NodeID=';
            if ($this->_parent != '') {
                $outstring .= $this->_parent.'_';
            }
        
            $outstring .= $this->_nodeID.'&asf='.$this->_expanded.'#'.$this->_nodeID.'">';

            $outstring .= '<font size="+1"><b>';
            if ($this->_expanded)
                $outstring .= "-";
            else
                $outstring .= '+';

            $outstring .= '</b></font>';
        } else {
            $outstring .= '<a name="'.$this->_nodeID.'">&nbsp;';
        }
        $outstring .= '</a>&nbsp;';
        

        # Here we must construct the link to the 'addnode' method in the query
        # display frame's object.
        if ($this->_parent != '') {
            $outstring .= '<a href="'.$_SERVER['PHP_SELF'].'?class=queryDisplay&method=addNode&parm_title=';
            if ($this->_parentTitle != '') {
                $outstring .= urlencode($this->_parentTitle.' : ');
            }
            $outstring .= urlencode($this->_title).'&parm_id='.$this->_nodeID.'#bottom" target="'.$this->_queryTarget.'">';
            $outstring .= $this->_title;
            $outstring .= '</a>';
        } else {
            $outstring .=$this->_title;
        }


        $outstring .="</nobr><br />\n";

        foreach ($this->_branches as $key=>$index) {
            $outstring .= $index->output($key, $tabbing.'&nbsp;&nbsp;&nbsp;')."\n";
        }

        return $outstring;
    }

    /**
    * toggle the expanded/collapsed state of a node.
    *
    * The node may be this node, or a child somewhere
    * further down the branch.
    *
    * @param    $inNodeID   string  node ID
    */
    function toggle($inNodeID){
        if ($this->_nodeID == $inNodeID) {
            # we want to toggle this node
            $this->_expanded = 1 - $this->_expanded;
            if ($this->_expanded) {
                $this->_expand();
            } else {
                $this->_collapse();
            }
        } else {
            $snip=strpos($inNodeID, '_');
            if ($snip === false) {
                $this->_branches[$inNodeID]->toggle($inNodeID);
            } else {
                # we want to toggle a node further down.
                $branch = substr($inNodeID, 0, $snip);
                $newID = substr($inNodeID, $snip+1);
                $this->_branches[$branch]->toggle($newID);
             }
        }
    }


    /**
    * Expand this node
    *
    * Query the database, and build an array of child classDex
    * objects if there are any children of this node.
    * Otherwise, mark this node as unexpandable.
    */
    function _expand(){
        global $qbrt_settings;

        $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);

        if (!DB::isError($db)) {
            $querystring = "select * from standard_classification where type='".$this->_type."' and parent_id='".(integer)$this->_nodeID."'";
            $result =& $db->query($querystring);

            if (!DB::isError($result)) {
                $rowcount = 0;
                while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $branchid = $dbrow['CLASSIFICATION_ID'];
                    $myID = $this->_nodeID;
                    $myTitle = $this->_title;
                    if ($this->_parent != '') {
                        $myID = $this->_parent.'_'.$myID;
                        $myTitle = $this->_parentTitle.' : '.$myTitle;
                    }
                    $this->_branches[$branchid] = new classDex($branchid, ucfirst($dbrow['NAME']), $this->_type, $this->_queryTarget, $myID, $myTitle);
                    $rowcount++;
                }
                if (!$rowcount) {
                    $this->_expandable=false;
                }
			}
        }


    }


    /**
    * Collapse this node
    *
    * Discard all of the node's children
    *
    */
    function _collapse(){
        foreach ($this->_branches as $key=>$value) {
            # $this->_branches[$key]->destroy();
            unset($this->_branches[$key]);
        }

    }


    /**
    * Check to see if this node has any children
    *
    * @return   boolean true means it has children
    *
    */
    function _checkExpandable(){
        global $qbrt_settings;
        $outresult = false;
        $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);
        if (!DB::isError($db)) {
            $querystring = "select count(*) MYCOUNT from standard_classification where type='".$this->_type."' and parent_id='".(integer)$this->_nodeID."'";
            if ($db->getOne($querystring)) {
                $outresult=true;
            }
        }
        return $outresult;
    }

}

?>
