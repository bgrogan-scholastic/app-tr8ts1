<?php

class Locker_Group
{
	private $_profileid;
	private $_assignmentid;
	private $_groupid;
	private $_title;
	private $_creationdate;
	private $_modifieddate;
	private $_sort;
	
	/**
	* __construct
	*
	* Create a group object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Group
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $groupid
	* @param 	string $title
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $groupid = NULL, $title = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setgroupid($groupid);
		$this->settitle($title);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_sort = NULL;
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
	* getsort
	*
	* Returns sort.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getsort()
	{
		return $this->_sort;
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
	* getgroupid
	*
	* Returns groupid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getgroupid()
	{
		return $this->_groupid;
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
	* getcreationdate
	*
	* Returns creationdate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getcreationdate()
	{
		return $this->_creationdate;
	}

	/**
	* getmodifieddate
	*
	* Returns modifieddate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getmodifieddate()
	{
		return $this->_modifieddate;
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
	* setsort
	*
	* Set sort
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $sort
	*/	
	public function setsort($sort)
	{
		$this->_sort = $sort;
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
	* setgroupid
	*
	* Sets groupid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $groupid
	*/	
	public function setgroupid($groupid)
	{
		$this->_groupid = $groupid;
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
	* setcreationdate
	*
	* Sets creationdate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $creationdate
	*/	
	public function setcreationdate($creationdate)
	{
		$this->_creationdate = $creationdate;
	}

	/**
	* setmodifieddate
	*
	* Sets string $modifieddate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   modifieddate
	*/	
	public function setmodifieddate($modifieddate)
	{
		$this->_modifieddate = $modifieddate;
	}	
}

?>