<?php
class Locker_Shard
{
	private $shardid = '';
	private $hostname = '';
	private $username = '';
	private $password = '';
	private $database = '';
	private $port = '';
	private $totalusers = 0;
	private $totalparents = 0;
	private $totalassignments = 0;
	private $totalgroups = 0;
	private $totalnotecards = 0;
	private $totalcitations = 0;
	private $totaltasks = 0;
	private $totalsavedassets = 0;
	
	
	/**
	* __construct
	*
	* Create an Locker_Shard object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Shard
	* 
	* @param 	string $shardid
	* @param 	string $hostname
	* @param 	string $username
	* @param 	string $password
	* @param 	string $database
	* @param 	string $port
	* @param 	int $totalusers
	* @param 	int $totalparents
	* @param 	int $totalassignments
	* @param 	int $totalgroups
	* @param 	int $totalnotecards
	* @param 	int $totalcitations
	* @param 	int $totaltasks
	* @param 	int $totalsavedassets
	* 
	*/	
	public function __construct($shardid = NULL, $hostname = NULL, $username = NULL, $password = NULL, $database = NULL, $port = NULL, $totalusers = 0, $totalparents = 0,
								$totalassignments = 0, $totalgroups = 0, $totalnotecards = 0, $totalcitations = 0, $totaltasks = 0, $totalsavedassets = 0)
	{		
		$this->setshardid($shardid);
		$this->sethostname($hostname);
		$this->setusername($username);
		$this->setpassword($password);
		$this->setdatabase($database);
		$this->setport($port);
		$this->settotalusers($totalusers);
		$this->settotalparents($totalparents);
		
		$this->settotalassignments($totalassignments);
		$this->settotalgroups($totalgroups);
		$this->settotalnotecards($totalnotecards);
		$this->settotalcitations($totalcitations);
		$this->settotaltasks($totaltasks);
		$this->settotalsavedassets($totalsavedassets);
	}

	/**
	* gettotalsavedassets
	*
	* Returns totalsavedassets.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalsavedassets()
	{
		return $this->totalsavedassets;
	}
	
	/**
	* settotalsavedassets
	*
	* Sets totalsavedassets.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalsavedassets($value)
	{
		$this->totalsavedassets = $value;
	}
	
	/**
	* gettotaltasks
	*
	* Returns totaltasks.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotaltasks()
	{
		return $this->totaltasks;
	}
	
	/**
	* settotaltasks
	*
	* Sets totaltasks.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotaltasks($value)
	{
		$this->totaltasks = $value;
	}
	
	/**
	* gettotalcitations
	*
	* Returns totalcitations.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalcitations()
	{
		return $this->totalcitations;
	}
	
	/**
	* settotalcitations
	*
	* Sets totalcitations.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalcitations($value)
	{
		$this->totalcitations = $value;
	}
	
	/**
	* gettotalnotecards
	*
	* Returns totalnotecards.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalnotecards()
	{
		return $this->totalnotecards;
	}
	
	/**
	* settotalnotecards
	*
	* Sets totalnotecards.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalnotecards($value)
	{
		$this->totalnotecards = $value;
	}
		
	/**
	* gettotalgroups
	*
	* Returns totalgroups.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalgroups()
	{
		return $this->totalgroups;
	}
	
	/**
	* settotalgroups
	*
	* Sets totalgroups.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalgroups($value)
	{
		$this->totalgroups = $value;
	}
	
	/**
	* gettotalassignments
	*
	* Returns totalassignments.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalassignments()
	{
		return $this->totalassignments;
	}
	
	/**
	* settotalassignments
	*
	* Sets totalassignments.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalassignments($value)
	{
		$this->totalassignments = $value;
	}
	
	/**
	* gettotalparents
	*
	* Returns totalparents.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalparents()
	{
		return $this->totalparents;
	}
	
	/**
	* settotalparents
	*
	* Sets totalparents.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalparents($value)
	{
		$this->totalparents = $value;
	}
		
	/**
	* gettotalusers
	*
	* Returns totalusers.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gettotalusers()
	{
		return $this->totalusers;
	}
	
	/**
	* settotalusers
	*
	* Sets totalusers.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function settotalusers($value)
	{
		$this->totalusers = $value;
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
		return $this->shardid;
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
		$this->shardid = $value;
	}
		
	/**
	* gethostname
	*
	* Returns hostname.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function gethostname()
	{
		return $this->hostname;
	}
	
	/**
	* sethostname
	*
	* Sets hostname.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function sethostname($value)
	{
		$this->hostname = $value;
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
		return $this->username;
	}
	
	/**
	* setusername
	*
	* Sets username.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function setusername($value)
	{
		$this->username = $value;
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
		return $this->password;
	}

	/**
	* setpassword
	*
	* Sets password.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function setpassword($value)
	{
		$this->password = $value;
	}		
	
	/**
	* getdatabase
	*
	* Returns database.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function getdatabase()
	{
		return $this->database;
	}
	
	/**
	* setdatabase
	*
	* Sets database.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/
	public function setdatabase($value)
	{
		$this->database = $value;
	}
	
	
	/**
	* getport
	*
	* Returns port.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/		
	public function getport()
	{
		return $this->port;
	}

	/**
	* setport
	*
	* Sets port.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $value
	*/	
	public function setport($value)
	{
		$this->port = $value;
	}	
}

?>