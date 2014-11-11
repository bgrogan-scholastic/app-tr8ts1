<?php

/**
* An element of a boolean query
*
* This may be a parenthesis, a node, or a logical operator
*
* @author       Richard E. Dye
* @copyright    4/7/2004
* @package      qbrt
*/
class queryElement{

    var $_title='';
    var $type='';

    /**
    * Constructor
    *
    * @param    $inTitle    string  The human readable name of this element
    * @param    $inType     char    p, o, or n (parenthesis, operator, or node.
    * @return   queryElement
    */
    function queryElement($inTitle, $inType){
        $this->_title = $inTitle;
        $this->type = $inType;
    }


    /**
    * Get the human readable title of this element
    *
    * @return   string  human readable title of this element
    */
    function getTitle(){
        return $this->_title;
    }

    /**
    * Get the one-letter type code for this element.
    *
    * @return   char    the type (p, o, or n) of this element
    */
    function getType(){
        return $this->type;
    }

    /**
    * Set the human readable title of this element
    *
    * @param   $inTitle string  human readable title of this element
    */
    function setTitle($inTitle){
        $this->_title=$inTitle;
    }

}

?>
