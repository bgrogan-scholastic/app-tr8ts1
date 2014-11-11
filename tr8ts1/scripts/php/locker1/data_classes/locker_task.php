<?php

class Locker_Task
{

	private $_profileid;
	private $_assignmentid;
	private $_taskid;
	private $_tasktype;
	private $_title;
	private $_description;
	private $_duedate;
	private $_completiondate;
	private $_creationdate;
	private $_modifieddate;
	private $_rubricanswerarray;
	private $_sort;	
	
	/**
	* __construct
	*
	* Create a task object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Task
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $taskid
	* @param 	int $tasktype
	* @param 	string $title
	* @param 	string $description
	* @param 	string $duedate
	* @param 	string $completiondate
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $taskid = NULL, $tasktype = NULL, $title = NULL, $description = NULL, $duedate = NULL, 
								$completiondate = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->settaskid($taskid);
		$this->settasktype($tasktype);
		$this->settitle($title);
		$this->setdescription($description);
		$this->setduedate($duedate);
		$this->setcompletiondate($completiondate);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_rubricanswerarray = array();
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
	* gettaskid
	*
	* Returns taskid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettaskid()
	{
		return $this->_taskid;
	}
		
	/**
	* gettasktype
	*
	* Returns tasktype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettasktype()
	{
		return $this->_tasktype;
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
	* getduedate
	*
	* Returns duedate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getduedate()
	{
		return $this->_duedate;
	}

	/**
	* getcompletiondate
	*
	* Returns completiondate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getcompletiondate()
	{
		return $this->_completiondate;
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
	* getrubricanswerarray
	*
	* Returns rubricanswerarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getrubricanswerarray()
	{
		return $this->_rubricanswerarray;
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
	* settaskid
	*
	* Sets taskid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $taskid
	*/	
	public function settaskid($taskid)
	{
		$this->_taskid = $taskid;
	}
		
	/**
	* settasktype
	*
	* Sets tasktype.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	int $tasktype
	*/	
	public function settasktype($tasktype)
	{
		$this->_tasktype = $tasktype;
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
	* setduedate
	*
	* Sets duedate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $duedate
	*/	
	public function setduedate($duedate)
	{
		$this->_duedate = $duedate;
	}

	/**
	* setcompletiondate
	*
	* Sets completiondate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $completiondate
	*/	
	public function setcompletiondate($completiondate)
	{
		$this->_completiondate = $completiondate;
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
	* Sets modifieddate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $modifieddate
	*/	
	public function setmodifieddate($modifieddate)
	{
		$this->_modifieddate = $modifieddate;
	}

	/**
	* addrubricanswer
	*
	* Add rubricanswer to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Rubric_Answer $rubricanswer
	*/	
	public function addrubricanswer($rubricanswer)
	{
		$this->_rubricanswerarray[] = $rubricanswer;
	}
}

?>