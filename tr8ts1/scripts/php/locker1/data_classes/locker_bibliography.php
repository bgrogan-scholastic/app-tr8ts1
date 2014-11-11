<?php

class Locker_Bibliography
{

	private $_profileid;
	private $_assignmentid;
	private $_bibliographyid;
	private $_creationdate;
	private $_modifieddate;
	private $_citationarray;
	
	/**
	* __construct
	*
	* Create a Locker_Bibliography object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Bibliography
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $bibliographyid
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $bibliographyid = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setbibliographyid($bibliographyid);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_citationarray = array();
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
	* getbibliographyid
	*
	* Returns bibliographyid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getbibliographyid()
	{
		return $this->_bibliographyid;
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
	* addcitation
	*
	* Add citation to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Citation $citation
	*/	
	public function addcitation($citation)
	{
		$this->_citationarray[] = $citation;
	}
}
?>