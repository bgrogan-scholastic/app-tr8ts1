<?php

class Locker_Notecard
{

	private $_profileid;
	private $_assignmentid;
	private $_notecardid;
	private $_title;
	private $_directquote;
	private $_paraphrase;
	private $_charcountdirectquote;
	private $_charcountparaphrase;
	private $_citationid;
	private $_groupid;
	private $_creationdate;
	private $_modifieddate;
	private $_sort;	
	
	/**
	* __construct
	*
	* Create a notecard object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Notecard
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $notecardid
	* @param 	string $title
	* @param 	string $directquote
	* @param 	string $paraphrase
	* @param 	int $charcountdirectquote
	* @param 	int $charcountparaphrase
	* @param 	int $citationid
	* @param 	int $groupid
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $notecardid = NULL, $title = NULL, $directquote = NULL, $paraphrase = NULL, $charcountdirectquote = NULL, 
								$charcountparaphrase = NULL, $citationid = NULL, $groupid = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setnotecardid($notecardid);
		$this->settitle($title);
		$this->setdirectquote($directquote);
		$this->setparaphrase($paraphrase);
		$this->setcharcountdirectquote($charcountdirectquote);
		$this->setcharcountparaphrase($charcountparaphrase);
		$this->setcitationid($citationid);
		$this->setgroupid($groupid);		
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_sort = NULL;
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
	* getnotecardid
	*
	* Returns notecardid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getnotecardid()
	{
		return $this->_notecardid;
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
	* getdirectquote
	*
	* Returns directquote.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getdirectquote()
	{
		return $this->_directquote;
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
	* getcharcountdirectquote
	*
	* Returns charcountdirectquote.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcharcountdirectquote()
	{
		return $this->_charcountdirectquote;
	}
	
	/**
	* getcharcountparaphrase
	*
	* Returns charcountparaphrase.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcharcountparaphrase()
	{
		return $this->_charcountparaphrase;
	}
	
	/**
	* getcitationid
	*
	* Returns citation.
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
	* getgroupid
	*
	* Returns group.
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
	* setnotecardid
	*
	* Sets notecard id.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $notecardid
	*/	
	public function setnotecardid($notecardid)
	{
		$this->_notecardid = $notecardid;
	}
		
	/**
	* settitle
	*
	* Sets title.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	string $title
	*/	
	public function settitle($title)
	{
		$this->_title = $title;
	}

	/**
	* setdirectquote
	*
	* Sets directquote.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $directquote
	*/	
	public function setdirectquote($directquote)
	{
		$this->_directquote = $directquote;
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
	* setcharcountdirectquote
	*
	* Sets charcountdirectquote.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $charcountdirectquote
	*/	
	public function setcharcountdirectquote($charcountdirectquote)
	{
		$this->_charcountdirectquote = $charcountdirectquote;
	}

	/**
	* setcharcountparaphrase
	*
	* Sets charcountparaphrase.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $charcountparaphrase
	*/	
	public function setcharcountparaphrase($charcountparaphrase)
	{
		$this->_charcountparaphrase = $charcountparaphrase;
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
	* setactive
	*
	* Sets active.
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
}

?>