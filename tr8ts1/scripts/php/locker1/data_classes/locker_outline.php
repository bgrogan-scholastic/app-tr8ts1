<?php

class Locker_Outline
{

	private $_profileid;
	private $_assignmentid;
	private $_outlineid;
	private $_creationdate;
	private $_modifieddate;
	private $_linearray;
	
	/**
	* __construct
	*
	* Create a Locker_Outline object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Outline
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $outlineid
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $outlineid = NULL, $creationdate = NULL, $modifieddate = NULL, $linearray = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setoutlineid($outlineid);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
				
		if(is_null($linearray))
		{
			$this->_linearray = array();
		}
		else 
		{
			$this->setlinearray($linearray);
		}	
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
	* getoutlineid
	*
	* Returns outlineid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getoutlineid()
	{
		return $this->_outlineid;
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
	* getlinearray
	*
	* Returns linearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getlinearray()
	{
		return $this->_linearray;
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
	* setlinearray
	*
	* Sets linearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array $linearray
	*/	
	public function setlinearray($linearray)
	{
		$this->_linearray = $linearray;
	}
	
	/**
	* addline
	*
	* Add line to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Line $line
	*/	
	public function addline($line)
	{
		$this->_linearray[] = $line;
	}
}
?>