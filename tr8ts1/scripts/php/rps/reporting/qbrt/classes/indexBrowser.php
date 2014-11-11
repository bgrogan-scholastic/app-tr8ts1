<?php

require_once('DB.php');
require_once(getcwd().'/includes/classDex.php');

/**
* Index browser object
*
* @author       Richard E. Dye
* @copyright    3/31/2004
* @package      qbrt
*/
class indexBrowser{
    var $_queryTarget = '';
    var $_trees = array();
    var $_error = '';

    /**
    * constructor
    *
    * @param    $inparms    array input parameters
    */
    function indexBrowser($inparms){
        global $qbrt_settings;

        $this->_queryTarget = $inparms['target'];
        $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);

        if (!DB::isError($db)) {
            $result =& $db->query('select type from standard_classification group by type order by type asc');

            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $branchid = $dbrow['TYPE'];
                $this->_trees[$branchid] = new classDex($branchid, ucfirst($branchid), $branchid, $this->_queryTarget);
			}
        } else {
            $this->_error=$db->getMessage();
        }

        # For testing purposes, I now wish to unset the classDex critters I just created...
        #foreach ($this->_trees as $key => $value) {
        #    unset($this->_trees[$key]);
        #}

    }


    /**
    * toggle the expanded/collapsed state of a node.
    *
    * The node may be a top-level tree, or one of the
    * branches.  It must be in a fully-qualified form of:
    *
    * tree_nodeID_nodeID_nodeID
    *
    * @param    $inparms    array input parameters
    * @return   string  HTML for the output
    */
    function toggle($inparms){
        $nodeID = $inparms['NodeID'];

        $snip=strpos($nodeID, '_');

        if ($snip === false) {
            # we want to toggle a top-level tree
            $this->_trees[$nodeID]->toggle($nodeID);
        } else {
            # we want to toggle a node further down a tree
            $tree = substr($nodeID, 0, $snip);
            $newID = substr($nodeID, $snip+1);
            $this->_trees[$tree]->toggle($newID);
        }

        return $this->output(null);
    }

    /**
    * Output the index browse tree
    *
    * @param    $inparms    array input parameters
    * @return   string  HTML for the output
    */
    function output($inparms){
        if ($this->_error != '') {
            return "<p>$this->_error</p>\n";
        }

        #$outstring = "<p>Index browser</p>\n";
        $outstring = '';

        foreach ($this->_trees as $key=>$index) {
            $outstring .= $index->output($key)."\n";
        }

        return $outstring;
    }
}
?>
