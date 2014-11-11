<?php

class Locker_Citation_Content_Type
{
	private $_citationcontenttypeid;
	private $_description;
	private $_pubmediumid;
	
	/**
	* __construct
	*
	* Create a support data object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Citation_Content_Type
	* 
	* @param 	int $citationcontenttypeid
	* @param 	int $pubmediumid
	* @param 	string $description
	*/
	public function __construct($citationcontenttypeid = NULL, $pubmediumid = NULL, $description = NULL)
	{		
		$this->setcitationcontenttypeid($citationcontenttypeid);
		$this->setpubmediumid($pubmediumid);
		$this->setdescription($description);
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
	* getpubmediumid
	*
	* Returns pubmediumid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getpubmediumid()
	{
		return $this->_pubmediumid;
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
	* setpubmediumid
	*
	* Sets pubmediumid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   string $pubmediumid
	*/	
	public function setpubmediumid($pubmediumid)
	{
		$this->_pubmediumid = $pubmediumid;
	}	
}

?>