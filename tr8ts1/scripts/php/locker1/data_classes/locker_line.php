<?php

class Locker_Line
{

	private $_outlineid;
	private $_lineid;
	private $_parentid;
	private $_linetext;
	private $_indentlevel;
	private $_creationdate;
	private $_modifieddate;
	private $_sort;
	
	/**
	* __construct
	*
	* Create a Locker_Line object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Line
	* 
	* @param 	int $outlineid
	* @param 	int $lineid
	* @param 	int $parentid
	* @param 	string $linetext
	* @param 	int $indentlevel
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($outlineid = NULL, $lineid = NULL, $parentid = NULL, $linetext = NULL, $indentlevel = NULL, $creationdate = NULL, $modifieddate = NULL)
	{		
		$this->setoutlineid($outlineid);
		$this->setlineid($lineid);
		$this->setparentid($parentid);
		$this->setlinetext($linetext);
		$this->setindentlevel($indentlevel);
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->_sort = NULL;
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
	* getlineid
	*
	* Returns lineid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getlineid()
	{
		return $this->_lineid;
	}
	
	/**
	* getparentid
	*
	* Returns parentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getparentid()
	{
		return $this->_parentid;
	}
		
	/**
	* getlinetext
	*
	* Returns linetext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getlinetext()
	{
		return $this->_linetext;
	}

	/**
	* getindentlevel
	*
	* Returns indentlevel.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getindentlevel()
	{
		return $this->_indentlevel;
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
	* setlineid
	*
	* Sets lineid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $lineid
	*/	
	public function setlineid($lineid)
	{
		$this->_lineid = $lineid;
	}
	
	/**
	* setparentid
	*
	* Sets parentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $parentid
	*/	
	public function setparentid($parentid)
	{
		$this->_parentid = $parentid;
	}
		
	/**
	* setlinetext
	*
	* Sets linetext.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	string $linetext
	*/	
	public function setlinetext($linetext)
	{
		$this->_linetext = $linetext;
	}

	/**
	* setindentlevel
	*
	* Sets indentlevel.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $indentlevel
	*/	
	public function setindentlevel($indentlevel)
	{
		$this->_indentlevel = $indentlevel;
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