<?php

class Locker_Assignment_Stats
{

	private $_profileid;
	private $_assignmentid;
	private $_progress;
	private $_daysleft;
	private $_nexttaskobj;
	
	/**
	* __construct
	*
	* Create a task object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Assignment_Stats
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $progress
	* @param 	int $daysleft
	* @param 	Locker_Task $nexttaskobj	
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $progress = NULL, $daysleft = NULL, $nexttaskobj = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setprogress($progress);
		$this->setdaysleft($daysleft);
		$this->setnexttaskobj($nexttaskobj);
		
	}
   
	/**
	* getprofileid
	*
	* Returns profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getprofileid()
	{
		return $this->_profileid;
	}

	/**
	* getassignmentid
	*
	* Returns assignmentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getassignmentid()
	{
		return $this->_assignmentid;
	}
	
	/**
	* getprogress
	*
	* Returns progress.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getprogress()
	{
		return $this->_progress;
	}
		
	/**
	* getdaysleft
	*
	* Returns daysleft.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getdaysleft()
	{
		return $this->_daysleft;
	}
		
	/**
	* getnexttaskobj
	*
	* Returns nexttaskobj.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Task
	*/	
	public function getnexttaskobj()
	{
		return $this->_nexttaskobj;
	}
	
	/**
	* setprofileid
	*
	* Sets profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $profileid
	*/	
	public function setprofileid($profileid)
	{
		$this->_profileid = $profileid;
	}

	/**
	* setassignmentid
	*
	* Sets assignmentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $assignmentid
	*/	
	public function setassignmentid($assignmentid)
	{
		$this->_assignmentid = $assignmentid;
	}

	/**
	* setprogress
	*
	* Sets progress.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $progress
	*/	
	public function setprogress($progress)
	{
		$this->_progress = $progress;
	}
				
	/**
	* setdaysleft
	*
	* Sets daysleft.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $daysleft
	*/	
	public function setdaysleft($daysleft)
	{
		$this->_daysleft = $daysleft;
	}
		
	/**
	* setnexttaskobj
	*
	* Sets nexttaskobj.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	Locker_Task $nexttaskobj
	*/	
	public function setnexttaskobj($nexttaskobj)
	{
		$this->_nexttaskobj = $nexttaskobj;
	}
}

?>