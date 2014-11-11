<?php

require_once('queryElement.php');
require_once('queryNode.php');

/**
* booleanQuery object
*
* This object basically holds and maniplates an array of elements
* needed to construct a boolean query, either in text form for
* display, or for submitting to a database.
*
* @author       Richard E. Dye
* @copyright    4/7/2004
* @package      qbrt
*/
class booleanQuery{
    var $_elements = array();


    /**
    * Fetch the number of elements in the boolean query object
    *
    * @return   number  number of elements
    */
    function sizeof(){
        return sizeof($this->_elements);
    }

    /**
    * Get the title of one of the elements held in this boolean query
    *
    * @param    $inIndex    number  Index of the element for which to get the title
    * @return               string  the title of the requested element
    */
    function getTitle($inIndex){
        return $this->_elements[$inIndex]->getTitle();
    }

    /**
    * Get the type of one of the elements held in this boolean query
    *
    * @param    $inIndex    number  Index of the element for which to get the type
    * @return               char    one-letter type code for the requested element
    */
    function getType($inIndex){
        if (isset($this->_elements[$inIndex])) {
            return $this->_elements[$inIndex]->getType();
        } else {
            return '';
        }
    }

    /**
    * Set the title of a node
    *
    * @param    $inIndex    number  Index of the element for which to set the title
    * @param    $inTitle    string  New title
    */
    function setTitle($inIndex, $inTitle){
        $this->_elements[$inIndex]->setTitle($inTitle);
    }

    /**
    * Get the id of a node element held in this boolean query
    *
    * Note that not all elements have ids, only nodes do.
    * Return an null if this is not a node.
    *
    * @param    $inIndex    number  index of the element for which to get the ID
    * @return               number  The node ID, or null if this is not a node.
    */
    function getId($inIndex){
        if ($this->_elements[$inIndex]->getType() == 'n')
            return $this->_elements[$inIndex]->getID();
        else
            return null;
    }


    /**
    * Insert an element into the boolean query array
    *
    * @param $inElement queryElement    Element to insert
    * @param $inIndex   number  slot where element is to be inserted.
    */
    function insert($inElement, $inIndex){
        $size = $this->sizeof();

        if ($inIndex >= $size) {
            $this->append($inElement);
        } else {
            for ($i=$size; $i>$inIndex; $i--) {
                $this->_elements[$i] = $this->_elements[$i-1];
            }
            $this->_elements[$inIndex] = $inElement;
        }
    }


    /**
    * remove an element into the boolean query array
    *
    * @param $inIndex   number  slot to delete.
    */
    function delete($inIndex){
        $size = $this->sizeof();

        if ($inIndex <= $size-1 && $inIndex >= 0) {
            if ($inIndex < $size-1) {
                for ($i=$inIndex; $i<$size-1; $i++) {
                    $this->_elements[$i] = $this->_elements[$i+1];
                }
            }
            unset($this->_elements[$size-1]);        
        }
    }


    /**
    * append an element to the boolean query array
    *
    */
    function append($inElement){
        $this->_elements[] = $inElement;
    }

}

?>
