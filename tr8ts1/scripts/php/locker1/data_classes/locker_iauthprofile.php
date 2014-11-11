<?php

class Locker_IAuthProfile
{

	private $_isvalid;
	private $_auarray;
	private $_profilecookiearray;
	private $_profileid;
	private $_userid;
	private $_recipientid;
	private $_password;
	private $_parentid;
	
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
	* @param 	bool $isvalid
	* @param 	array[int]Locker_AU $auarray
	* @param 	array[int] $profilecookiearray
	* @param 	string $profileid
	* @param 	string $userid
	* @param 	string $recipientid
	* @param 	string $password
	* @param 	string $parentid
	*/
	public function __construct($isvalid = NULL, $auarray = NULL, $profilecookiearray = NULL, $profileid = NULL, $userid = NULL, $recipientid = NULL, $password = NULL, $parentid = NULL)
	{		
		$this->setisvalid($isvalid);

		$this->setprofileid($profileid);
		$this->setuserid($userid);
		$this->setrecipientid($recipientid);
		$this->setpassword($password);
		$this->setparentid($parentid);
			
		if(is_null($auarray))
		{
			$this->_auarray = array();
		}
		else 
		{
			$this->setauarray($auarray);
		}	

		if(is_null($profilecookiearray))
		{
			$this->_profilecookiearray = array();
		}
		else 
		{
			$this->setprofilecookiearray($profilecookiearray);
		}	
		
	}
   
	/**
	* getisvalid
	*
	* Returns isvalid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  bool
	*/	
	public function getisvalid()
	{
		return $this->_isvalid;
	}

	/**
	* getprofileid
	*
	* Returns profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getprofileid()
	{
		return $this->_profileid;
	}
	
	/**
	* getuserid
	*
	* Returns userid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getuserid()
	{
		return $this->_userid;
	}

	/**
	* getrecipientid
	*
	* Returns recipientid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getrecipientid()
	{
		return $this->_recipientid;
	}	
	
	/**
	* getpassword
	*
	* Returns password.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getpassword()
	{
		return $this->_password;
	}	

	/**
	* getparentid
	*
	* Returns parentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getparentid()
	{
		return $this->_parentid;
	}
		
	/**
	* getauarray
	*
	* Returns auarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_AU $var
	*/	
	public function getauarray()
	{
		return $this->_auarray;
	}	
	
	/**
	* getprofilecookiearray
	*
	* Returns profilecookiearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int] $var
	*/	
	public function getprofilecookiearray()
	{
		return $this->_profilecookiearray;
	}
		
	/**
	* setisvalid
	*
	* Sets isvalid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   bool $isvalid
	*/	
	public function setisvalid($isvalid)
	{
		$this->_isvalid = $isvalid;
	}
	
	/**
	* setprofileid
	*
	* Sets profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $profileid
	*/	
	public function setprofileid($profileid)
	{
		$this->_profileid = $profileid;
	}

	/**
	* setuserid
	*
	* Sets userid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $userid
	*/	
	public function setuserid($userid)
	{
		$this->_userid = $userid;
	}

	/**
	* setrecipientid
	*
	* Sets recipientid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $recipientid
	*/	
	public function setrecipientid($recipientid)
	{
		$this->_recipientid = $recipientid;
	}

	/**
	* setpassword
	*
	* Sets password.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $password
	*/	
	public function setpassword($password)
	{
		$this->_password = $password;
	}

	/**
	* setparentid
	*
	* Sets parentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $parentid
	*/	
	public function setparentid($parentid)
	{
		$this->_parentid = $parentid;
	}
		
	/**
	* setauarray
	*
	* Sets auarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int]Locker_AU $auarray
	*/	
	public function setauarray($auarray)
	{
		$this->_auarray = $auarray;
	}
	
	/**
	* setprofilecookiearray
	*
	* Sets profilecookiearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int] $profilecookiearray
	*/	
	public function setprofilecookiearray($profilecookiearray)
	{
		$this->_profilecookiearray = $profilecookiearray;
	}
	
	/**
	* addau
	*
	* Add au to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_AU $au
	*/	
	public function addau($au)
	{
		$this->_auarray[] = $au;
	}
		
	/**
	* addprofilecookie
	*
	* Add profilecookie to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int] $profilecookie
	*/	
	public function addprofilecookie($profilecookie)
	{
		$this->_profilecookiearray[] = $profilecookie;
	}
}
?>