<?php

class Locker_Tool_Type
{
	private $_tooltypeid;
	private $_title;
	private $_description;
	private $_skillbuilderarray;
	
	/**
	* __construct
	*
	* Create a tool type object.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Tool_Type
	* 
	* @param 	int $tooltypeid
	* @param 	string $title
	* @param 	string $description
	*/
	public function __construct($tooltypeid = NULL, $title = NULL, $description = NULL)
	{		
		$this->settooltypeid($tooltypeid);
		$this->settitle($title);
		$this->setdescription($description);
		
		$this->_skillbuilderarray = array();		
	}
   
	/**
	* gettooltypeid
	*
	* Returns tooltypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettooltypeid()
	{
		return $this->_tooltypeid;
	}

	/**
	* gettitle
	*
	* Returns title.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function gettitle()
	{
		return $this->_title;
	}

	/**
	* getdescription
	*
	* Returns description.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getdescription()
	{
		return $this->_description;
	}	
	
	/**
	* getskillbuilderarray
	*
	* Returns skillbuilderarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getskillbuilderarray()
	{
		return $this->_skillbuilder;
	}
			
	/**
	* settooltypeid
	*
	* Sets tooltypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $tooltypeid
	*/	
	public function settooltypeid($tooltypeid)
	{
		$this->_tooltypeid = $tooltypeid;
	}
	
	/**
	* settitle
	*
	* Sets title.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $title
	*/	
	public function settitle($title)
	{
		$this->_title = $title;
	}

	/**
	* setdescription
	*
	* Sets description.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $description
	*/	
	public function setdescription($description)
	{
		$this->_description = $description;
	}	

	/**
	* addskillbuilder
	*
	* Add skillbuilder to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Skillbuilder $skillbuilder
	*/	
	public function addskillbuilder($skillbuilder)
	{
		$this->_skillbuilderarray[] = $skillbuilder;
	}	
}

?>