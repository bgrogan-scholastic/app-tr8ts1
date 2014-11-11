<?php

require_once('DB.php');
require_once(getcwd().'/classes/assetTypeList.php');
require_once(getcwd().'/classes/productList.php');
require_once(getcwd().'/classes/queryDisplay.php');
require_once(getcwd().'/includes/report.php');

/**
* Perform the query.
*
* This class performs the query and builds the report for output.
*
* @author       Richard E. Dye
* @copyright    4/29/2004
* @package      qbrt
*/
class queryPerform{

    var $_queryString;
    var $_error;
    var $_report;
    var $_query;    # name of queryDisplay object in $_SESSION
    var $_products; # name of the products checkbox list in $_SESSION
    var $_assets;   # name of the asset type checkbox list in $_SESSION

    /**
    * Create the report
    *
    * @param    $inparms    array   input parameters
    */
    function createReport($inparms){
        global $qbrt_settings;

        $operators = array('OR' => ' union ', 'AND' => ' intersect ', 'NOT' => ' minus ');
        
        $this->_error = '';
        $qString = '';

        $this->_report = new report(array('ID'=>'Asset ID', 'TITLE'=>'Asset Title',
                            'TYPE'=>'Asset type', 'PRODUCT'=>'Product'));

        $this->_query = $inparms['query'];
        $this->_products = $inparms['products'];
        $this->_assets = $inparms['assets'];

        $boolQ = $_SESSION[$this->_query]->getBooleanQuery();

        # Construct the query...
        $numnodes = $boolQ->sizeof();

        if ($numnodes) {
            $qString .= 'select slp_asset_id ID, lower(online_title) SORTTITLE, online_title TITLE, asset_type TYPE, products PRODUCT ';
            $qString .= 'from assets where asset_id in (';
            for ($i=0; $i<$numnodes; $i++) {
                $type = $boolQ->getType($i);
                if ($type == 'p') {
                    $qString .= $boolQ->getTitle($i);
                } else if ($type == 'o') {
                    $qString .= $operators[$boolQ->getTitle($i)];
                } else if ($type == 'n') {
                    $qString .= 'select asset_id from classification_assets where classification_id='
                        .$boolQ->getID($i);
                }
            }
            $qString .= ')';

            $numitems=$_SESSION[$this->_products]->sizeof();
            if ($numitems) {
                $qString .= " and products in (";
                $sepflag=false;
                for ($i=0; $i<$numitems; $i++) {
                    if ($_SESSION[$this->_products]->getState($i)) {
                        if ($sepflag) {
                            $qString .= ", ";
                        }
                        $qString .= "'".$_SESSION[$this->_products]->getID($i)."'";
                        $sepflag = true;
                    }
                }
                $qString .= ")";
            }

            $numitems=$_SESSION[$this->_assets]->sizeof();
            if ($numitems) {
                $qString .= " and asset_type in (";
                $sepflag=false;
                for ($i=0; $i<$numitems; $i++) {
                    if ($_SESSION[$this->_assets]->getState($i)) {
                        if ($sepflag) {
                            $qString .= ", ";
                        }
                        $qString .= "'".$_SESSION[$this->_assets]->getID($i)."'";
                        $sepflag = true;
                    }
                }
                $qString .= ")";
            }

            $qString .= " order by SORTTITLE";
            $this->_queryString = $qString;

            # I do believe that we are ready to perform the query...
            $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);

            if (!DB::isError($db)) {
                $result =& $db->query($qString);
                if (!DB::isError($result)) {
                    while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                        $this->_report->addRow($dbrow);
        			}
                } else {
                    $this->_error=$result->getMessage();
                }
            } else {
                $this->_error=$db->getMessage();
            }


        } else {
            $this->_error = "Empty Query!";
        }

        $this->_queryString = $qString;

        return $this->output($inparms);
    }

    /**
    * Output the report
    *
    * @param    $inparms    array input parameters
    * @return   string  HTML for the output
    */
    function output($inparms){
        if ($this->_error != '') {
            return "<b>ERROR:</b> ".$this->_error."<!-- qstring:\n".$this->_queryString."\n-->\n";
        }

        $outstring = "<center><h3><u>Classification Tool Report</u></h3></center>\n";

        $outstring .= "<!-- qstring:\n".$this->_queryString."\n-->\n";

        
        # Display the query...
        $boolQ = $_SESSION[$this->_query]->getBooleanQuery();
        $numnodes = $boolQ->sizeof();

        if ($numnodes) {
            $outstring .= '<table border = "1" cellpadding="4" width="100%" bgcolor="#ffffff">'."\n";

            $outstring .= "<tr><td><b><u>Query:</u></b></td></tr>\n<tr><td>";
            for ($i=0; $i<$numnodes; $i++) {
                $type = $boolQ->getType($i);
                if ($type == 'p') {
                    $outstring .= $boolQ->getTitle($i);
                } else if ($type == 'o') {
                    $outstring .= "</td></tr><tr><td>".$boolQ->getTitle($i)."</td></tr>\n<tr><td>";
                } else if ($type == 'n') {
                    $outstring .= $boolQ->getTitle($i);
                }
            }
            $outstring .= "</td></tr></table>\n";
        }

        # Output the information about products
        $numnodes = $_SESSION[$this->_products]->sizeof();
        if ($numnodes) {

            $outstring .= '<table border = "1" cellpadding="4" width="100%" bgcolor="#ffffff">'."\n";

            $outstring .= '<tr><td nowrap="nowrap">Product(s):</td>'."\n".'<td width="100%">';
            for ($i=0; $i<$numnodes; $i++) {
                if ($_SESSION[$this->_products]->getState($i)) {
                    $outstring .= $_SESSION[$this->_products]->getID($i)
                                ."&nbsp;&nbsp;&nbsp;";
                }
            }
            $outstring .= "</td></tr></table>\n";
        }


        # Output the information about asset types
        $numnodes = $_SESSION[$this->_assets]->sizeof();
        if ($numnodes) {

            $outstring .= '<table border = "1" cellpadding="4" width="100%" bgcolor="#ffffff">'."\n";

            $outstring .= '<tr><td nowrap="nowrap">Asset types:</td>'."\n".'<td width="100%">';
            for ($i=0; $i<$numnodes; $i++) {
                if ($_SESSION[$this->_assets]->getState($i)) {
                    $outstring .= $_SESSION[$this->_assets]->getTitle($i)
                                ."&nbsp;&nbsp;&nbsp;";
                }
            }
            $outstring .= "</td></tr></table>\n";
        }



        $numrows = $this->_report->sizeof();
        $outstring .= "<p><b>Number of Assets in Results List: $numrows </b></p>\n";

        if ($numrows) {
            $outstring .= '<table width="100%" bgcolor="#ffffff">'."\n";
            $outstring .= "<tr>\n";
            $outstring .= '<td colspan="4"><b>Query Results</b></td>'."\n";
            $outstring .= "</tr>\n";

            $outstring .= "<tr>\n";
            $header = $this->_report->getHeader();
            foreach ($header as $key=>$value) {
                $outstring .= "<td><b><u>$value</u></b></td>\n";
            }
            $outstring .= "</tr>\n";

            for ($i=0; $i<$numrows; $i++) {
                $outstring .= "<tr>\n";
                $row = $this->_report->getRow($i);
                foreach ($header as $key=>$value) {
                    if (isset($row[$key])) {
                        $outstring .= "<td>".$row[$key]."</td>\n";
                    } else {
                        $outstring .= "<td>&nbsp;</td>\n";
                    }
                }
                $outstring .= "</tr>\n";
            }

            $outstring .= "</table>\n";
        }

        $outstring .= '<center><a href="./">Back</a></center>'."\n";
        return $outstring;
    }

}
?>
