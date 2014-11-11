<?php
class Locker_DB_Connect
{
	private $hostname = '';
	private $username = '';
	private $password = '';
	private $database = '';
	private $port = '';
	
	/**
	* __construct
	*
	* Create an Locker_DB_Connect object
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  DBConnect
	* 
	* @param 	string $hostname
	* @param 	string $username
	* @param 	string $password
	* @param 	string $database
	* @param 	string $port
	*/	
	public function __construct($hostname, $username, $password, $database, $port)
	{		
		$this->sethostname($hostname);
		$this->setusername($username);
		$this->setpassword($password);
		$this->setdatabase($database);
		$this->setport($port);
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