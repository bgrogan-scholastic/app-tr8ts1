<?php

class Locker_Saved_Weblink
{

	private $_profileid;
	private $_assignmentid;
	private $_savedweblinkid;
	private $_title;
	private $_digitallockerfoldertypeid;
	private $_digitallockerfoldertitle;
	private $_url;
	private $_location;
	private $_creationdate;
	private $_modifieddate;
	private $_sort;
	
	/**
	* __construct
	*
	* Create a Locker_Saved_Weblink object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Saved_Weblink
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $savedweblinkid
	* @param 	string $title
	* @param 	int $digitallockerfoldertypeid
	* @param	string $digitallockerfoldertitle
	* @param 	string $url
	* @param 	string $location
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $savedweblinkid = NULL, $title = NULL, $digitallockerfoldertypeid = NULL, $digitallockerfoldertitle = NULL, $url = NULL, $location = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setsavedweblinkid($savedweblinkid);
		$this->settitle($title);
		$this->setweblinktype($digitallockerfoldertypeid);
		$this->setdigitallockerfoldertitle($digitallockerfoldertitle);
		$this->seturl($url);
		$this->setlocation($location);		
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_sort = NULL;
	}
	
	/**
	* getdigitallockerfoldertypetitle
	*
	* Returns digitallockerfoldertitle.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getdigitallockerfoldertypetitle()
	{
		return $this->_digitallockerfoldertitle;
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
	* getsavedweblinkid
	*
	* Returns savedweblinkid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getsavedweblinkid()
	{
		return $this->_savedweblinkid;
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
	* getweblinktype
	*
	* Returns weblinktype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getweblinktype()
	{
		return $this->_digitallockerfoldertypeid;
	}
	
	/**
	* geturl
	*
	* Returns url.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function geturl()
	{
		return $this->_url;
	}	

	/**
	* getlocation
	*
	* Returns location.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getlocation()
	{
		return $this->_location;
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
	* setdigitallockerfoldertitle
	*
	* Sets the digitallockerfoldertypetitle
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   int $digitallockerfoldertitle
	*/	
	public function setdigitallockerfoldertitle($digitallockerfoldertitle)
	{
		$this->_digitallockerfoldertitle = $digitallockerfoldertitle;
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
	* setsavedweblinkid
	*
	* Sets savedweblinkid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $savedweblinkid
	*/	
	public function setsavedweblinkid($savedweblinkid)
	{
		$this->_savedweblinkid = $savedweblinkid;
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
	* setweblinktype
	*
	* Sets weblinktype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $digitallockerfoldertypeid
	*/	
	public function setweblinktype($digitallockerfoldertypeid)
	{
		$this->_digitallockerfoldertypeid = $digitallockerfoldertypeid;
	}
	
	/**
	* seturl
	*
	* Sets url.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $url
	*/	
	public function seturl($url)
	{
		$this->_url = $url;
	}	
	
	/**
	* setlocation
	*
	* Sets location.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $location
	*/	
	public function setlocation($location)
	{
		$this->_location = $location;
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
}
?>