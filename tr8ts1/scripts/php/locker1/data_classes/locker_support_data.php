<?php

class Locker_Support_Data
{
	private $_id;
	private $_description;
	private $_url;
	private $_displaytext;
	
	/**
	* __construct
	*
	* Create a support data object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data
	* 
	* @param 	int $id
	* @param 	string $description
	* @param 	string $url
	*/
	public function __construct($id = NULL, $description = NULL, $url = NULL, $displaytext = NULL)
	{		
		$this->setid($id);
		$this->setdescription($description);
		$this->seturl($url);
		$this->setdisplaytext($displaytext);
	}
   
	/**
	* getid
	*
	* Returns id.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getid()
	{
		return $this->_id;
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
	* geturl
	*
	* Returns url.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function geturl()
	{
		return $this->_url;
	}	

	/**
	* getdisplaytext
	*
	* Returns displaytext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getdisplaytext()
	{
		return $this->_displaytext;
	}
		
	/**
	* setid
	*
	* Sets id.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $id
	*/	
	public function setid($id)
	{
		$this->_id = $id;
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
	* seturl
	*
	* Sets url.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   string $url
	*/	
	public function seturl($url)
	{
		$this->_url = $url;
	}	
	
	/**
	* setdisplaytext
	*
	* Sets displaytext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $value
	*/	
	public function setdisplaytext($value)
	{
		$this->_displaytext = $value;
	}	
}

?>