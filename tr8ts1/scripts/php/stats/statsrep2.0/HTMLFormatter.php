<?php

    include_once($_SERVER["PHP_INCLUDE_HOME"]."stats/statsrep2.0/Formatter.php");

/**
* Class for outputting a report in basic HTML
* 
* 12/06/2006 SJF PHP 5 Conversion
*
*/
class HTMLFormatter extends Formatter {

    /**
    * The constructor
    * @access   public
    */
    public function __construct(){
    	
    	//  call parent constructor
        parent::__construct();
    }

    /**
    * Output the HTML formatted result
    *
    * @access   public
    */
    public function output(&$report, $title) {
        $resultSet = $this->_prodSort($report->getResults());
        $lowerBound = $report->getLowerBound();
        $upperBound = $report->getUpperBound();

        print '<hr width="80%" />'."\n";

        print '<table border="0" callpadding="3">'."\n";

        print '<tr><td align="center" rowspan="2"><b>'.$title.'</b></td><td>&nbsp;</td><th colspan="2">On-site</th><td>&nbsp;</td><th colspan="2">Remote</th><td>&nbsp;</td><th colspan="2">Total</th><td>&nbsp;</td></tr>'."\n";
        print "<tr><td>&nbsp;</td><td align=\"center\">Views</td><td align=\"center\">Sessions</td><td>&nbsp;</td><td align=\"center\">Views</td><td align=\"center\">Sessions</td><td>&nbsp;</td><td align=\"center\">Views</td><td align=\"center\">Sessions</td><td>&nbsp;</td></tr>\n";
        foreach ($resultSet as $product => $counts) {
            if (isset($this->_prodNames[$product])){
                $displayName = $this->_prodNames[$product];
            } else {
                $displayName = $product;
            }
            print "<tr><td>$displayName</td><td>&nbsp;</td>";
            $evenFlag = 0;
            foreach ($counts as $count) {
                print "<td align=\"right\">$count</td>";
                $evenFlag++;
                if ($evenFlag % 2 == 0){
                    print "<td>&nbsp;</td>";
                }
            }
            print "</tr>\n";
        }
        if ($lowerBound <> "") {
            print '<tr><td colspan="11"><b>Active date range: </b>'.$lowerBound." to ".$upperBound."</td></td>\n";

        }
        print "</table>\n";
    }

    /**
    * Output the checkbox selection form list of aggregates, if any.
    *
    * @access   public
    */
    public function listAggregates($inCUID, $startDate, $endDate) {
        $db = DB::connect($_SERVER['STATS_CONNECT_STRING']);
        if (!PEAR::isError($db)) {
            $queryString = "select aggregate AGG from customer where customer_id in (select cid from customer_tree where pid='$inCUID') group by aggregate order by aggregate";
            $dataSet =& $db->query($queryString);
            if (!PEAR::isError($dataSet)) {
                $aggregates = array();
                while ($dbrow =& $dataSet->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $newaggcode = trim($dbrow['AGG']);
                    if ($newaggcode <> "") {
                        $aggregates[] = $newaggcode;
                    }
                }
                $dataSet->free();

                if (count($aggregates) > 0) {
                    print "<hr>\n";
                    print "<b>Show usage for the following access groups:</b><br />\n";
                    print "<a href=javascript:checkall(document.aggregates.aggregate)>Check all</a> | <a href=javascript:uncheckall(document.aggregates.aggregate)>Uncheck all</a><br />\n";
                    print '<form name="aggregates" action="'. $GLOBALS['PHP_SELF'] .'" method="POST">'."\n";
                    print '<input type="hidden" name="customerid" value="'.$inCUID.'" />'."\n";
                    print '<input type="hidden" name="startdate" value="'.$startDate.'" />'."\n";
                    print '<input type="hidden" name="enddate" value="'.$endDate.'" />'."\n";
                    foreach ($aggregates as $aggregate) {
                        print '<input type="checkbox" name="aggregate" value="'.$aggregate.'" />';
                        print $aggregate."<br />\n";
                    }
                    print '<input type="submit" name="submit" value="Generate reports" /><br />'."\n";
                    print "</form>\n";
                    print "<a href=javascript:checkall(document.aggregates.aggregate)>Check all</a> | <a href=javascript:uncheckall(document.aggregates.aggregate)>Uncheck all</a><br />\n";
                }
            }

            $db->disconnect();
        }

    }


    /**
    * Output the checkbox selection form list of child institutions, if any.
    *
    * @access   public
    */
    public function listIndinsts($inCUID, $startDate, $endDate) {
        $db = DB::connect($_SERVER['STATS_CONNECT_STRING']);
        if (!PEAR::isError($db)) {
            $queryString = "select customer_id CUID, name from customer where customer_id in (select cid from customer_tree where pid='$inCUID') group by customer_id, name order by name";
            $dataSet =& $db->query($queryString);
            if (!PEAR::isError($dataSet)) {
                $indinsts = array();
                while ($dbrow =& $dataSet->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $indinsts[$dbrow['CUID']] = $dbrow['NAME'];
                }
                $dataSet->free();

                if (count($indinsts) > 0) {
                    print "<hr>\n";
                    print "<b>Show individual usage for the following institutions:</b><br />\n";
                    print "<a href=javascript:checkall(document.indinsts.indinst)>Check all</a> | <a href=javascript:uncheckall(document.indinsts.indinst)>Uncheck all</a><br />\n";
                    print '<form name="indinsts" action="'. $GLOBALS['PHP_SELF'] .'" method="POST">'."\n";
                    print '<input type="hidden" name="customerid" value="'.$inCUID.'" />'."\n";
                    print '<input type="hidden" name="startdate" value="'.$startDate.'" />'."\n";
                    print '<input type="hidden" name="enddate" value="'.$endDate.'" />'."\n";
                    foreach ($indinsts as $instid=>$instname) {
                        print '<input type="checkbox" name="indinst" value="'.$instid.'" />';
                        print $instname."<br />\n";
                    }
                    print '<input type="submit" name="submit" value="Generate reports" /><br />'."\n";
                    print "</form>\n";
                    print "<a href=javascript:checkall(document.indinsts.indinst)>Check all</a> | <a href=javascript:uncheckall(document.indinsts.indinst)>Uncheck all</a><br />\n";
                }
            }

            $db->disconnect();
        }


    }
}


?>
