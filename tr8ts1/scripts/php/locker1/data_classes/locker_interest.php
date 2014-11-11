<?php

class Locker_Interest
{
	private $_interestid;
	private $_description;
	private $_interesttypeid;
	
	/**
	* __construct
	*
	* Create a task object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Interest
	* 
	* @param 	int $interestid
	* @param 	string $description
	* @param 	int $interesttypeid
	*/
	public function __construct($interestid = NULL, $interesttypeid = NULL, $description = NULL)
	{		
		$this->setinterestid($interestid);
		$this->setdescription($description);
		$this->setinteresttypeid($interesttypeid);
	}
   
	/**
	* getinterestid
	*
	* Returns interestid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getinterestid()
	{
		return $this->_interestid;
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
	* getinteresttypeid
	*
	* Returns interesttypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getinteresttypeid()
	{
		return $this->_interesttypeid;
	}
		
	/**
	* setinterestid
	*
	* Sets interestid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $interestid
	*/	
	public function setinterestid($interestid)
	{
		$this->_interestid = $interestid;
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
	* setinteresttypeid
	*
	* Sets interesttypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $interesttypeid
	*/	
	public function setinteresttypeid($interesttypeid)
	{
		$this->_interesttypeid = $interesttypeid;
	}	
}

?>