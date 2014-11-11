<?php

class Locker_Skillbuilder
{

	private $_skillbuilderid;
	private $_title;
	private $_description;
	private $_sortpriority;
	private $_lessonplanid;
	private $_tasktypearray;
	private $_tooltypearray;
	
	/**
	* __construct
	*
	* Create a skillbuilder object
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return 	Locker_Skillbuilder
	* 
	* @param 	int $skillbuilderid
	* @param 	string $title
	* @param 	string $description
	* @param 	int $sortpriority
	* @param 	int $lessonplanid
	*/
	public function __construct($skillbuilderid = NULL, $title = NULL, $description = NULL, $sortpriority = NULL, $lessonplanid = NULL)
	{		
		$this->setskillbuilderid($skillbuilderid);
		$this->settitle($title);
		$this->setdescription($description);
		$this->setsortpriority($sortpriority);
		$this->setlessonplanid($lessonplanid);
		
		$this->_tasktypearray = array();
		$this->_tooltypearray = array();
	}
   
	/**
	* getskillbuilderid
	*
	* Returns skillbuilderid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getskillbuilderid()
	{
		return $this->_skillbuilderid;
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
	* getlessonplanid
	*
	* Returns lessonplanid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getlessonplanid()
	{
		return $this->_lessonplanid;
	}
	
	/**
	* gettasktypearray
	*
	* Returns tasktypearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function gettasktypearray()
	{
		return $this->_tasktype;
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
	* setskillbuilderid
	*
	* Sets skillbuilderid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $skillbuilderid
	*/	
	public function setskillbuilderid($skillbuilderid)
	{
		$this->_skillbuilderid = $skillbuilderid;
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
	* setlessonplanid
	*
	* Sets lessonplanid.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	int $lessonplanid
	*/	
	public function setlessonplanid($lessonplanid)
	{
		$this->_lessonplanid = $lessonplanid;
	}	

	/**
	* addtasktype
	*
	* Add tasktype to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Task_Type $tasktype
	*/	
	public function addtasktype($tasktype)
	{
		$this->_tasktypearray[] = $tasktype;
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
		$this->_tooltypearray[] = $tooltype;
	}
}

?>