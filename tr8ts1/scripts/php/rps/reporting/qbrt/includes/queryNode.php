<?php

require_once('queryElement.php');

/**
* An node element of a boolean query
*
* This is a special case of the boolean query element.
* It has the additional property of a classification ID.
*
* @author       Richard E. Dye
* @copyright    4/7/2004
* @package      qbrt
*/
class queryNode extends queryElement{

    var $_id;

    /**
    * Constructor
    *
    * @param    $inTitle    string  The human readable name of this element
    * @param    $inID       number  the classification ID for this element.
    * @return   queryNode
    */
    function queryNode($inTitle, $inID){
        $this->queryElement($inTitle, 'n');

        $this->_id = $inID;
    }

    /**
    * get this nodes classification ID
    *
    * @return   number  classification ID
    */
    function getID(){
        return $this->_id;
    }

}

?>
