<?php
class Locker_Assignment
{

	private $_profileid;
	private $_assignmentid;
	private $_productid;
	private $_assignmenttype;
	private $_title;
	private $_duedate;
	private $_completiondate;
	private $_active;
	private $_creationdate;
	private $_paraphrase;
	private $_finaldraftformatid;
	private $_lengthoffinaldraft;
	private $_numofsources;
	private $_status;
	private $_othercitationsource;
	private $_citationtypeid;
	private $_citationsourcearray;
	private $_taskarray;
	private $_notecardarray;
	private $_grouparray;
	private $_citationarray;
	private $_sort;
	private $_outlineid;
	private $_bibliographyid;
	private $_progress;
	private $_daysleft;
	private $_nexttaskobj;	
	
	/**
	* __construct
	*
	* Create an assignment object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Assignment
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	string $productid
	* @param 	int $assignmenttype
	* @param 	string $title
	* @param 	string $duedate
	* @param 	string $completiondate
	* @param 	string $active
	* @param 	string $creationdate
	* @param 	string $paraphrase
	* @param 	int $finaldraftformatid
	* @param 	string $lengthoffinaldraft
	* @param 	int $numofsources
	* @param 	int $status
	* @param 	string $othercitationsource
	* @param 	int $citationtypeid
	* @param 	array $citationsourcearray
	* @param 	array $taskarray
	* @param 	array $notecardarray
	* @param 	array $grouparray
	* @param 	array $citationarray
	* @param 	int $outlineid
	* @param 	int $bibliographyid
	* @param 	int $progress
	* @param 	int $daysleft
	* @param 	object $nexttaskobj
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $productid = NULL, $assignmenttype = NULL, $title = NULL, $duedate = NULL, $completiondate = NULL, 
	$active = NULL, $creationdate = NULL, $paraphrase = NULL, $finaldraftformatid = NULL, $lengthoffinaldraft = NULL, $numofsources = NULL, $status = NULL, 
	$othercitationsource = NULL, $citationtypeid = NULL, $citationsourcearray = NULL, $taskarray = NULL, $notecardarray = NULL,
	$grouparray = NULL, $citationarray = NULL, $outlineid = NULL, $bibliographyid = NULL, $progress = NULL, $daysleft = NULL, $nexttaskobj = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setproductid($productid);
		$this->setassignmenttype($assignmenttype);
		$this->settitle($title);
		$this->setduedate($duedate);
		$this->setcompletiondate($completiondate);
		$this->setactive($active);		
		$this->setcreationdate($creationdate);
		$this->setparaphrase($paraphrase);
		$this->setfinaldraftformatid($finaldraftformatid);
		$this->setlengthoffinaldraft($lengthoffinaldraft);
		$this->setnumofsources($numofsources);
		$this->setstatus($status);
		$this->setothercitationsource($othercitationsource);
		$this->setcitationtypeid($citationtypeid);		
		$this->setoutlineid($outlineid);	
		$this->setbibliographyid($bibliographyid);	

		$this->setprogress($progress);		
		$this->setdaysleft($daysleft);	
		$this->setnexttaskobj($nexttaskobj);
				
		if(is_null($citationsourcearray))
		{
			$this->_citationsourcearray = array();	
		}
		else 
		{
			$this->setcitationsourcearray($citationsourcearray);
		}

		if(is_null($taskarray))
		{
			$this->_taskarray = array();	
		}
		else 
		{
			$this->settaskarray($taskarray);
		}

		if(is_null($notecardarray))
		{
			$this->_notecardarray = array();
		}
		else 
		{
			$this->setnotearray($notecardarray);
		}

		if(is_null($grouparray))
		{
			$this->_grouparray = array();
		}
		else 
		{
			$this->setgrouparray($grouparray);
		}
		
		if(is_null($citationarray))
		{
			$this->_citationarray = array();
		}
		else 
		{
			$this->setcitationarray($citationarray);
		}		
		
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
	* getassignmentid
	*
	* Returns productid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getproductid()
	{
		return $this->_productid;
	}

	/**
	* getassignmenttype
	*
	* Returns assignmenttype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getassignmenttype()
	{
		return $this->_assignmenttype;
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
	* isactive
	*
	* Returns active.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function isactive()
	{
		return $this->_active;
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
	* getparaphrase
	*
	* Returns paraphrase.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getparaphrase()
	{
		return $this->_paraphrase;
	}
	
	/**
	* getfinaldraftformatid
	*
	* Returns finaldraftformatid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getfinaldraftformatid()
	{
		return $this->_finaldraftformatid;
	}	
	
	/**
	* getlengthoffinaldraft
	*
	* Returns lengthoffinaldraft.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getlengthoffinaldraft()
	{
		return $this->_lengthoffinaldraft;
	}	
		
	/**
	* getnumofsources
	*
	* Returns numofsources.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getnumofsources()
	{
		return $this->_numofsources;
	}
	
	/**
	* getstatus
	*
	* Returns status.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getstatus()
	{
		return $this->_status;
	}

	/**
	* getothercitationsource
	*
	* Returns othercitationsource.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getothercitationsource()
	{
		return $this->_othercitationsource;
	}	
	
	/**
	* getcitationtypeid
	*
	* Returns citationtypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcitationtypeid()
	{
		return $this->_citationtypeid;
	}
	
	/**
	* getcitationsourcearray
	*
	* Returns citationsourcearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getcitationsourcearray()
	{
		return $this->_citationsourcearray;
	}
	  
	/**
	* getgrouparray
	*
	* Returns grouparray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getgrouparray()
	{
		return $this->_grouparray;
	}

	/**
	* getnotecardarray
	*
	* Returns notecardarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getnotecardarray()
	{
		return $this->_notecardarray;
	}

	/**
	* gettaskarray
	*
	* Returns taskarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function gettaskarray()
	{
		return $this->_taskarray;
	}

	/**
	* getcitationarray
	*
	* Returns citationarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getcitationarray()
	{
		return $this->_citationarray;
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
	* getbibliography
	*
	* Returns bibliography.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getbibliography()
	{
		return $this->_bibliography;
	}
	

	/**
	* getoutline
	*
	* Returns bibliography.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getoutline()
	{
		return $this->_outlineid;
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
	* @return  object
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
	* @param  int $profileid
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
	* @param  int $assignmentid
	*/	
	public function setassignmentid($assignmentid)
	{
		$this->_assignmentid = $assignmentid;
	}
	
	/**
	* setassignmentid
	*
	* Sets productid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $productid
	*/	
	public function setproductid($productid)
	{
		$this->_productid = $productid;
	}

	/**
	* setassignmenttype
	*
	* Sets assignmenttype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $assignmenttype
	*/	
	public function setassignmenttype($assignmenttype)
	{
		$this->_assignmenttype = $assignmenttype;
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
	* setactive
	*
	* Sets active.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $active
	*/	
	public function setactive($active)
	{
		$this->_active = $active;
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
	* setparaphrase
	*
	* Sets paraphrase.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $paraphrase
	*/	
	public function setparaphrase($paraphrase)
	{
		$this->_paraphrase = $paraphrase;
	}
	
	/**
	* setfinaldraftformatid
	*
	* Sets finaldraftformatid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $finaldraftformatid
	*/	
	public function setfinaldraftformatid($finaldraftformatid)
	{
		$this->_finaldraftformatid = $finaldraftformatid;
	}	
	
	/**
	* setlengthoffinaldraft
	*
	* Sets lengthoffinaldraft.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $lengthoffinaldraft
	*/	
	public function setlengthoffinaldraft($lengthoffinaldraft)
	{
		$this->_lengthoffinaldraft = $lengthoffinaldraft;
	}	
		
	/**
	* setnumofsources
	*
	* Sets numofsources.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $numofsources
	*/	
	public function setnumofsources($numofsources)
	{
		$this->_numofsources = $numofsources;
	}
	
	/**
	* setstatus
	*
	* Sets status.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $status
	*/	
	public function setstatus($status)
	{
		$this->_status = $status;
	}

	/**
	* setothercitationsource
	*
	* Sets othercitationsource.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $othercitationsource
	*/	
	public function setothercitationsource($othercitationsource)
	{
		$this->_othercitationsource = $othercitationsource;
	}	
	
	/**
	* setcitationtypeid
	*
	* Sets citationtypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citationtypeid
	*/	
	public function setcitationtypeid($citationtypeid)
	{
		$this->_citationtypeid = $citationtypeid;
	}

	/**
	* setoutlineid
	*
	* Sets outlineid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $outlineid
	*/	
	public function setoutlineid($outlineid)
	{
		$this->_outlineid = $outlineid;
	}

	/**
	* setbibliographyid
	*
	* Sets bibliographyid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $bibliographyid
	*/	
	public function setbibliographyid($bibliographyid)
	{
		$this->_bibliographyid = $bibliographyid;
	}
	
	/**
	* setcitationsourcearray
	*
	* Set citationsourcearray
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $citationsourcearray
	*/	
	public function setcitationsourcearray($citationsourcearray)
	{
		$this->_citationsourcearray = $citationsourcearray;
	}

	/**
	* settaskarray
	*
	* Set taskarray
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $taskarray
	*/	
	public function settaskarray($taskarray)
	{
		$this->_taskarray = $taskarray;
	}

	/**
	* setnotecardarray
	*
	* Set notecardarray
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $notecardarray
	*/	
	public function setnotecardarray($notecardarray)
	{
		$this->_notecardarray = $notecardarray;
	}

	/**
	* setgrouparray
	*
	* Set grouparray
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $grouparray
	*/	
	public function setgrouparray($grouparray)
	{
		$this->_grouparray = $grouparray;
	}
	
	/**
	* setcitationarray
	*
	* Set citationarray
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $citationarray
	*/	
	public function setcitationarray($citationarray)
	{
		$this->_citationarray = $citationarray;
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
	* @param	object $nexttaskobj
	*/	
	public function setnexttaskobj($nexttaskobj)
	{
		$this->_nexttaskobj = $nexttaskobj;
	}
		
	/**
	* addcitationsource
	*
	* Add citationsource to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citationsource
	*/	
	public function addcitationsource($citationsource)
	{
		$this->_citationsourcearray[] = $citationsource;
	}

	/**
	* addgroup
	*
	* Add group to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $group
	*/	
	public function addgroup($group)
	{
		$this->_grouparray[] = $group;
	}

	/**
	* addnotecard
	*
	* Add notecard to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $notecard
	*/	
	public function addnotecard($notecard)
	{
		$this->_notecardarray[] = $notecard;
	}

	/**
	* addtask
	*
	* Add task to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $task
	*/	
	public function addtask($task)
	{
		$this->_taskarray[] = $task;
	}	
	
	/**
	* addcitation
	*
	* Add citation to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citation
	*/	
	public function addcitation($citation)
	{
		$this->_citationarray[] = $citation;
	}	
}
?>