<?php

/**
* qbrt_EXIT object
*
* @author       Richard E. Dye
* @copyright    3/31/2004
* @package      qbrt
*/
class qbrt_EXIT {

    /**
    * Output from the object...
    *
    * This is a bit non-typical, as it includes the destroy functionality.
    * @param    $inparms    array input parameters
    * @return   string  HTML for output
    */
    function output($inparms) {
        session_destroy();
        return "<center><h3>Thank you for using Q*Bert</h3></center>\n";
    }

}

?>
