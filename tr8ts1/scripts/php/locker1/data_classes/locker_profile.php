<?php

class Locker_Profile
{
	//data elements
	private $_profileid;
	private $_username;
	private $_password;
	private $_productid;
	private $_nickname;
	private $_currentassignmentid;
	private $_securityquestid;
	private $_lastlogindate;
	private $_creationdate;
	private $_active;
	private $_profiletype;
	private $_securityanswer;
	private $_emailaddress;
	private $_lexilerange;
	private $_interestarray;
	private $_gradearray;
	private $_marketingprefarray;
	private $_parentid;
	private $_shardid;
	
	/**
	* __construct
	*
	* Create an profile object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Profile
	* 
	* @param 	int $profileid
	* @param 	string $username
	* @param 	string $password
	* @param 	string $productid
	* @param 	string $nickname
	* @param 	int $securityquestid
	* @param 	string $securityanswer
	* @param 	int $profiletype
	* @param 	string $active
	* @param 	string $lastlogindate
	* @param 	string $creationdate
	* @param 	string $emailaddress
	* @param 	int $currentassignmentid
	* @param 	int $lexilerange	
	* @param 	int $profiletype
	* @param 	int $currentassignmentid
	* @param 	array $gradearray
	* @param 	array $interestarray
	* @param 	array $marketingprefarray
	* @param 	string $parentid
	* @param 	string $shardid 
	*/
	public function __construct($profileid = NULL, $username = NULL, $password = NULL, $productid = NULL, $nickname = NULL, $securityquestid = NULL, $securityanswer = NULL, $lastlogindate = NULL,
	$active = NULL, $creationdate = NULL, $emailaddress = NULL, $lexilerange = NULL, $profiletype = NULL, $currentassignmentid = NULL, $gradearray = NULL, $interestarray = NULL, $marketingprefarray = NULL, $parentid = NULL, $shardid = NULL)
	{		
		$this->setprofileid($profileid);
		$this->setusername($username);
		$this->setpassword($password);
		$this->setproductid($productid);
		$this->setnickname($nickname);
		$this->setsecurityquestid($securityquestid);
		$this->setsecurityanswer($securityanswer);
		$this->setprofiletype($profiletype);
		$this->setlexilerange($lexilerange);
		$this->setcreationdate($creationdate);
		
		$this->setactive($active);
		$this->setlastlogindate($lastlogindate);
		$this->setemailaddress($emailaddress);
		$this->setcurrentassignmentid($currentassignmentid);
		$this->setparentid($parentid);
		$this->setshardid($shardid);
		
		
		if(is_null($gradearray))
		{
			$this->_gradearray = array();	
		}
		else 
		{
			$this->setgradearray($gradearray);
		}
		
		if(is_null($marketingprefarray))
		{
			$this->_marketingprefarray = array();	
		}
		else 
		{
			$this->setmarketingprefarray($marketingprefarray);
		}

		if(is_null($interestarray))
		{
			$this->_interestarray = array();	
		}
		else 
		{
			$this->setinterestarray($interestarray);
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
	* getusername
	*
	* Returns username.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getusername()
	{
		return $this->_username;
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
	* getcurrentassignmentid
	*
	* Returns currentassignmentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getcurrentassignmentid()
	{
		return $this->_currentassignmentid;
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
	* getsecurityquestid
	*
	* Returns securityquestid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getsecurityquestid()
	{
		return $this->_securityquestid;
	}

	/**
	* getsecurityanswer
	*
	* Returns securityanswer.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getsecurityanswer()
	{
		return $this->_securityanswer;
	}	
	
	/**
	* getprofiletype
	*
	* Returns profiletype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getprofiletype()
	{
		return $this->_profiletype;
	}
	
	/**
	* getnickname
	*
	* Returns nickname.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getnickname()
	{
		return $this->_nickname;
	}

	/**
	* getlastlogindate
	*
	* Returns lastlogindate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getlastlogindate()
	{
		return $this->_lastlogindate;
	}

	/**
	* isactive
	*
	* Returns active.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function isactive()
	{
		return $this->_active;
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
	* getemailaddress
	*
	* Returns emailaddress.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getemailaddress()
	{
		return $this->_emailaddress;
	}
			
	/**
	* getlexilerange
	*
	* Returns lexilerange.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getlexilerange()
	{
		return $this->_lexilerange;
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
	* getshardid
	*
	* Returns shardid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function getshardid()
	{
		return $this->_shardid;
	}
		
	/**
	* getmarketingprefarray
	*
	* Returns marketingprefarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getmarketingprefarray()
	{
		return $this->_marketingprefarray;
	}

	/**
	* getgradearray
	*
	* Returns gradearray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getgradearray()
	{
		return $this->_gradearray;
	}

	/**
	* getinterestarray
	*
	* Returns interestarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array
	*/	
	public function getinterestarray()
	{
		return $this->_interestarray;
	}


	/**
	* setgradearray
	*
	* Set gradearray
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   array $gradearray
	*/	
	public function setgradearray($gradearray)
	{
		$this->_gradearray = $gradearray;
	}	
	
	/**
	* setinterestarray
	*
	* Set interestarray
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   array $interestarray
	*/	
	public function setinterestarray($interestarray)
	{
		$this->_interestarray = $interestarray;
	}	

	
	/**
	* setmarketingprefarray
	*
	* Set marketingprefarray
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param   array $marketingprefarray
	*/	
	public function setmarketingprefarray($marketingprefarray)
	{
		$this->_marketingprefarray = $marketingprefarray;
	}	

	/**
	* setprofileid
	*
	* Sets profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  int $profileid
	*/	
	public function setprofileid($profileid)
	{
		$this->_profileid = $profileid;
	}

	/**
	* setusername
	*
	* Sets username.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $username
	*/	
	public function setusername($username)
	{
		$this->_username = $username;
	}

	/**
	* setpassword
	*
	* Sets password.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $password
	*/	
	public function setpassword($password)
	{
		$this->_password = $password;
	}
		
	/**
	* setcurrentassignmentid
	*
	* Sets currentassignmentid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  int $currentassignmentid
	*/	
	public function setcurrentassignmentid($currentassignmentid)
	{
		$this->_currentassignmentid = $currentassignmentid;
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
	* setnickname
	*
	* Sets nickname.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $nickname
	*/	
	public function setnickname($nickname)
	{
		$this->_nickname = $nickname;
	}
	
	/**
	* setsecurityquestid
	*
	* Sets securityquestid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $securityquestid
	*/	
	public function setsecurityquestid($securityquestid)
	{
		$this->_securityquestid = $securityquestid;
	}

	/**
	* setsecurityanswer
	*
	* Sets securityanswer.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $securityanswer
	*/	
	public function setsecurityanswer($securityanswer)
	{
		$this->_securityanswer = $securityanswer;
	}
	
	/**
	* setprofiletype
	*
	* Sets profiletype.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $profiletype
	*/	
	public function setprofiletype($profiletype)
	{
		$this->_profiletype = $profiletype;
	}
		
	/**
	* setlastlogindate
	*
	* Sets lastlogindate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $lastlogindate
	*/	
	public function setlastlogindate($lastlogindate)
	{
		$this->_lastlogindate = $lastlogindate;
	}

	/**
	* setactive
	*
	* Sets active.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $active
	*/	
	public function setactive($active)
	{
		$this->_active = $active;
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
	* setemailaddress
	*
	* Sets emailaddress.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $emailaddress
	*/	
	public function setemailaddress($emailaddress)
	{
		$this->_emailaddress = $emailaddress;
	}
		
	/**
	* setlexilerange
	*
	* Sets lexilerange.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $lexilerange
	*/	
	public function setlexilerange($lexilerange)
	{
		$this->_lexilerange = $lexilerange;
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
	* setshardid
	*
	* Sets shardid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function setshardid($value)
	{
		$this->_shardid = $value;
	}
			
	/**
	* addmarketingpref
	*
	* Add marketingpref to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   Locker_Support_Data $marketingpref
	*/	
	public function addmarketingpref($marketingpref)
	{
		$this->_marketingprefarray[] = $marketingpref;
	}

	/**
	* addgrade
	*
	* Add grade to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $grade
	*/	
	public function addgrade($grade)
	{
		$this->_gradearray[] = $grade;
	}

	/**
	* addinterest
	*
	* Add interest to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $interest
	*/	
	public function addinterest($interest)
	{
		$this->_interestarray[] = $interest;
	}	
	
}

?>