<?php

class Locker_Citation_Format_Example
{
	private $_citationformatexampleid;
	private $_citationtypeid;
	private $_citationcontenttypeid;
	private $_citationformat;
	private $_citationexample;
	
	/**
	* __construct
	*
	* Create a citation format example object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	Locker_Citation_Format_Example
	* 
	* @param 	int $citationformatexampleid
	* @param 	int $citationtypeid
	* @param 	int $citationcontenttypeid
	* @param 	string $citationformat
	* @param 	string $citationexample
	*/
	public function __construct($citationformatexampleid = NULL, $citationtypeid = NULL, $citationcontenttypeid = NULL, $citationformat = NULL, $citationexample = NULL)
	{		
		$this->setcitationformatexampleid($citationformatexampleid);
		$this->setcitationtypeid($citationtypeid);
		$this->setcitationcontenttypeid($citationcontenttypeid);
		$this->setcitationformat($citationformat);
		$this->setcitationexample($citationexample);
	}
   
	/**
	* getcitationformatexampleid
	*
	* Returns citationformatexampleid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcitationformatexampleid()
	{
		return $this->_citationformatexampleid;
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
	* getcitationformat
	*
	* Returns citationformat.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getcitationformat()
	{
		return $this->_citationformat;
	}

	/**
	* getcitationexample
	*
	* Returns citationexample.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getcitationexample()
	{
		return $this->_citationexample;
	}
			
	/**
	* setcitationformatexampleid
	*
	* Sets citationformatexampleid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $citationformatexampleid
	*/	
	public function setcitationformatexampleid($citationformatexampleid)
	{
		$this->_citationformatexampleid = $citationformatexampleid;
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
	* setcitationformat
	*
	* Sets citationformat.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $citationformat
	*/	
	public function setcitationformat($citationformat)
	{
		$this->_citationformat = $citationformat;
	}	

	/**
	* setcitationexample
	*
	* Sets citationexample.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $citationexample
	*/	
	public function setcitationexample($citationexample)
	{
		$this->_citationexample = $citationexample;
	}
}

?>