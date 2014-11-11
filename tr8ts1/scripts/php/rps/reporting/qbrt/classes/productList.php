<?php

require_once('DB.php');
require_once(getcwd().'/classes/checkboxList.php');

class productList extends checkboxList{

    /**
    * Constructor
    *
    * @param    $inparms    array of input parameters
    */
    function productList($inparms){
        global $qbrt_settings;

   	    $this->checkboxList($inparms);

        $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);

        if (!DB::isError($db)) {
            $result =& $db->query('select description, product_id from products group by description, product_id order by description asc');

            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $this->_items[] = new clbItem($dbrow['DESCRIPTION'], $dbrow['PRODUCT_ID']);
			}
        } else {
            $this->_error=$db->getMessage();
        }
    }
}


?>
