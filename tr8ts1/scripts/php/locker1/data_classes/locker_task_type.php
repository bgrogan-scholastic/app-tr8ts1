<?php

class Locker_Task_Type
{
	private $_tasktypeid;
	private $_title;
	private $_description;
	private $_sortpriority;
	private $_skillbuilderarray;
	private $_tooltypearray;

	
	/**
	* __construct
	*
	* Create a task type object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	Locker_Task_Type
	* 
	* @param 	int $tasktypeid
	* @param 	string $title
	* @param 	string $description
	* @param 	int $sortpriority
	*/
	public function __construct($tasktypeid = NULL, $title = NULL, $description = NULL, $sortpriority = NULL)
	{		
		$this->settasktypeid($tasktypeid);
		$this->settitle($title);
		$this->setdescription($description);
		$this->setsortpriority($sortpriority);
		
		$this->_skillbuilderarray = array();
		$this->_tooltypearray = array();		
	}
   
	/**
	* gettasktypeid
	*
	* Returns tasktypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettasktypeid()
	{
		return $this->_tasktypeid;
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
	* getsortpriority
	*
	* Returns sortpriority.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getsortpriority()
	{
		return $this->_sortpriority;
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
	* gettooltypearray
	*
	* Returns tooltypearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function gettooltypearray()
	{
		return $this->_tooltypearray;
	}
		
	/**
	* settasktypeid
	*
	* Sets tasktypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $tasktypeid
	*/	
	public function settasktypeid($tasktypeid)
	{
		$this->_tasktypeid = $tasktypeid;
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
	* setsortpriority
	*
	* Sets sortpriority.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $sortpriority
	*/	
	public function setsortpriority($sortpriority)
	{
		$this->_sortpriority = $sortpriority;
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
		$this->_skillbuilderarray = $skillbuilder;
	}

	/**
	* addtooltype
	*
	* Add tooltype to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Tool_Type $tooltype
	*/	
	public function addtooltype($tooltype)
	{
		$this->_tooltypearray = $tooltype;
	}	
}

?>