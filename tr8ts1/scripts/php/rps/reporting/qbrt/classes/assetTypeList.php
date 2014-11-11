<?php

require_once('DB.php');
require_once(getcwd().'/classes/checkboxList.php');

class assetTypeList extends checkboxList{

    /**
    * Constructor
    *
    * @param    $inparms    array of input parameters
    */
    function assetTypeList($inparms){
        global $qbrt_settings;

   	    $this->checkboxList($inparms);

        $db = DB::connect($qbrt_settings['DB_CONNECT_STRING']);

        if (!DB::isError($db)) {
            $result =& $db->query('select short_desc, asset_type from asset_types group by short_desc, asset_type order by short_desc asc');

            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $this->_items[] = new clbItem($dbrow['SHORT_DESC'], $dbrow['ASSET_TYPE']);
			}
        } else {
            $this->_error=$db->getMessage();
        }
    }
}


?>
