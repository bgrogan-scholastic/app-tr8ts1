<?php

class Locker_Saved_Asset
{

	private $_profileid;
	private $_assignmentid;
	private $_savedassetid;
	private $_title;
	private $_type;
	private $_digitallockerfoldertypeid;
	private $_digitallockerfoldertitle;
	private $_assetid;
	private $_productid;
	private $_creationdate;
	private $_modifieddate;
	private $_sort;
	private $_url;
	private $_uid;
	
	/**
	* __construct
	*
	* Create a Locker_Saved_Asset object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Saved_Asset
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $savedassetid
	* @param 	string $title
	* @param 	string $url
	* @param 	string $type
	* @param	int $digitallockerfoldertypeid
	* @param	string $digitallockerfoldertitle
	* @param 	string $assetid
	* @param 	string $productid
	* @param 	string $creationdate
	* @param 	string $modifieddate
	*/
	public function __construct($profileid = NULL, $assignmentid = NULL, $savedassetid = NULL, $title = NULL, $url = NULL, $type = NULL, $digitallockerfoldertypeid = NULL, $digitallockerfoldertitle = NULL, $assetid = NULL, $productid = NULL, $creationdate = NULL, $modifieddate = NULL, $uid = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setassignmentid($assignmentid);
		$this->setsavedassetid($savedassetid);
		$this->settitle($title);
		$this->seturl($url);
		$this->settype($type);
		$this->setdigitallockerfoldertypeid($digitallockerfoldertypeid);
		$this->setdigitallockerfoldertitle($digitallockerfoldertitle);
		$this->setassetid($assetid);
		$this->setproductid($productid);		
		$this->setcreationdate($creationdate);
		$this->setmodifieddate($modifieddate);
		$this->setuid($uid);
		$this->_sort = NULL;
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
	* getdigitallockerfoldertypeid
	*
	* Returns digitallockerfoldertypeid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getdigitallockerfoldertypeid()
	{
		return $this->_digitallockerfoldertypeid;
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
	* getsavedassetid
	*
	* Returns savedassetid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getsavedassetid()
	{
		return $this->_savedassetid;
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
	* gettype
	*
	* Returns type.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function gettype()
	{
		return $this->_type;
	}
	
	/**
	* getassetid
	*
	* Returns assetid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getassetid()
	{
		return $this->_assetid;
	}	
	
	/**
	* getuid
	*
	* Returns uid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getuid()
	{
		return $this->_uid;
	}	

	/**
	* getproductid
	*
	* Returns productid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getproductid()
	{
		return $this->_productid;
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
	* seturl
	*
	* Sets the url
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
	* setdigitallockerfoldertypeid
	*
	* Sets the digitallockerfoldertypeid
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   int $digitallockerfoldertypeid
	*/	
	public function setdigitallockerfoldertypeid($digitallockerfoldertypeid)
	{
		$this->_digitallockerfoldertypeid = $digitallockerfoldertypeid;
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
	* setsavedassetid
	*
	* Sets savedassetid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $savedassetid
	*/	
	public function setsavedassetid($savedassetid)
	{
		$this->_savedassetid = $savedassetid;
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
	* settype
	*
	* Sets type.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $type
	*/	
	public function settype($type)
	{
		$this->_type = $type;
	}
	
	/**
	* setassetid
	*
	* Sets assetid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $assetid
	*/	
	public function setassetid($assetid)
	{
		$this->_assetid = $assetid;
	}	
	
	/**
	* setuid
	*
	* Sets uid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   string $uid
	*/	
	public function setuid($uid)
	{
		$this->_uid = $uid;
	}		
	
	/**
	* setproductid
	*
	* Sets productid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $productid
	*/	
	public function setproductid($productid)
	{
		$this->_productid = $productid;
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