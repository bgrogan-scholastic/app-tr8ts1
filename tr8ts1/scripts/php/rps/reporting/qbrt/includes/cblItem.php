<?php

/**
* An item in an checkbox list
*
* @author       Richard E. Dye
* @copyright    4/19/2004
* @package      qbrt
*/
class clbItem{

    var $_title='';
    var $_id='';
    var $_state=true;

    /**
    * Constructor
    *
    * @param    $inTitle    string  the name of this item
    * @param    $inID       string  ID of this item
    * @param    $inState    boolean checked?
    */
    function clbItem($inTitle, $inID, $inState=true){
        $this->_title = $inTitle;
        $this->_id = $inID;
        $this->_state = $inState;
    }

    /**
    * Toggle the state of this checkbox
    */
    function toggle(){
        if ($this->_state)
            $this->_state=false;
        else
            $this->_state=true;
    }

    /**
    * get the title of this item
    *
    * @return   string  title
    */
    function getTitle(){
        return $this->_title;
    }

    /**
    * get the state of this item
    *
    * @return   boolean state
    */
    function getState(){
        return $this->_state;
    }

    /**
    * get the id of this item
    *
    * @return   string  ID
    */
    function getID(){
        return $this->_id;
    }

    /**
    * set the state of this item
    *
    * @param    $inState    boolean state
    */
    function setState($inState){
        $this->_state=$inState;
    }

}

?>
