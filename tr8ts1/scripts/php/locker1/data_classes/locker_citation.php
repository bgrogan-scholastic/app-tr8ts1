<?php
class Locker_Citation
{

	private $_profileid;
	private $_assignmentid;
	private $_citationid;
	private $_autocite;
	private $_citationtext;
	private $_pubmediumid;
	private $_citationcontenttypeid;
	private $_creationdate;
	private $_modifieddate;
	private $_citationtextarray;
	private $_sort;	
	
	
	/**
	* __construct
	*
	* Create a citation object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Citation
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $citationid
	* @param 	string $autocite
	* @param 	string $citationtext
	* @param 	int $pubmediumid
	* @param 	int $citationcontenttypeid
	* @param 	string $creationdate
	* @param 	string $modifieddate
	* @param 	array $citationtextarray
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $citationid = NULL, $autocite = NULL, $citationtext = NULL, $pubmediumid = NULL, 
								$citationcontenttypeid = NULL, $creationdate = NULL, $modifieddate = NULL, $citationtextarray = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setcitationid($citationid);
		$this->setautocite($autocite);
		$this->setcitationtext($citationtext);
		$this->setpubmediumid($pubmediumid);
		$this->setcitationcontenttypeid($citationcontenttypeid);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_sort = NULL;
		
		
		if(is_null($citationtextarray))
		{
			$this->_citationtextarray = array();
		}
		else 
		{
			$this->setcitationtextarray($citationtextarray);
		}		
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
	* getcitationid
	*
	* Returns citationid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcitationid()
	{
		return $this->_citationid;
	}
		
	/**
	* getautocite
	*
	* Returns autocite.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getautocite()
	{
		return $this->_autocite;
	}
	
	/**
	* getcitationtext
	*
	* Returns citationtext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getcitationtext()
	{
		return $this->_citationtext;
	}

	/**
	* getpubmediumid
	*
	* Returns pubmediumid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getpubmediumid()
	{
		return $this->_pubmediumid;
	}

	/**
	* getcitationcontenttypeid
	*
	* Returns citationcontenttypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcitationcontenttypeid()
	{
		return $this->_citationcontenttypeid;
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
	* getcitationtextarray
	*
	* Returns citationtextarray.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getcitationtextarray()
	{
		return $this->_citationtextarray;
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
	* setcitationid
	*
	* Sets citationid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citationid
	*/	
	public function setcitationid($citationid)
	{
		$this->_citationid = $citationid;
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
	* setautocite
	*
	* Sets autocite.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $autocite
	*/	
	public function setautocite($autocite)
	{
		$this->_autocite = $autocite;
	}
		
	/**
	* setcitationtext
	*
	* Sets citationtext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $citationtext
	*/	
	public function setcitationtext($citationtext)
	{
		$this->_citationtext = $citationtext;
	}

	/**
	* setpubmediumid
	*
	* Sets pubmediumid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $pubmediumid
	*/	
	public function setpubmediumid($pubmediumid)
	{
		$this->_pubmediumid = $pubmediumid;
	}

	/**
	* setcitationcontenttypeid
	*
	* Sets citationcontenttypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citationcontenttypeid
	*/	
	public function setcitationcontenttypeid($citationcontenttypeid)
	{
		$this->_citationcontenttypeid = $citationcontenttypeid;
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
	* setcitationtextarray
	*
	* Set setcitationtextarray
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   array $citationtextarray
	*/	
	public function setcitationtextarray($citationtextarray)
	{
		$this->_citationtextarray = $citationtextarray;
	}	
}
?>