<?php 
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_CompoundCookieManager.php');

class Locker_Client
{
	private $_client;
	
   	/**
	* Constructor
	*
	* This method just initializes the member variables for
	* the class.
	*
	* @author  John Palmer
	* @access  public 
	*/
	public function __construct() 
	{
	
	}

   	/**
	* getcurrentdate
	*
	* This function returns the current date.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string - current date
	* 
	*/
	public function getcurrentdate() 
	{
		require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");
		//COOKIE STUFF
		$cookiereader = new Cookie_Reader('xs');
		$profileid = $cookiereader->getprofileid();

		$this->writelog("getcurrentdate() -- ".$profileid."\n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcurrentdate();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
 	
	/**
	* createSAMuser
	*
	* Create a SAM users login.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  int
	* 
	* @param	string $guid
	* @param 	string $statecode
	* @param 	array $userdata
	* 
	*/
	public function createSAMuser($guid, $statecode, $userdata)
	{
		$this->writelog("createSAMuser($guid, $statecode, $userdata)) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->createSAMuser($guid, $statecode, $userdata);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;

	}	
	
	/**
	* create_sam_user_by_product
	*
	* Create a SAM users login.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  int
	* 
	* @param	string 	$guid
	* @param 	string 	$parentid
	* @param 	string 	$parent_auid
	* @param 	string 	$product_code
	* @param 	array 	$userdata
	* 
	*/
	public function create_sam_user_by_product($guid, $parentid, $parent_auid, $product_code, $userdata)
	{
		$this->writelog("create_sam_user_by_product($guid, $parentid, $parent_auid, $product_code, $userdata) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->create_sam_user_by_product($guid, $parentid, $parent_auid, $product_code, $userdata);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;

	}
		
 	/**
	* validatelogin
	*
	* Validate a users login.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  Locker_IAuthProfile object 
	* 
	* @param	string $username
	* @param 	string $password
	* @param 	string $productid
	* 
	*/
	public function validatelogin($username, $password, $productid)
	{			
		$this->writelog("validatelogin($username, $password, $productid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->validatelogin($username, $password, $productid);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
 	
	/**
	* validatesecurityquestion
	*
	* Validate a users security question and answer. Returns a profileid
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  int 
	* 
	* @param	string $username
	* @param 	int $securityquestionid
	* @param 	string $securityanswer
	* 
	*/
	public function validatesecurityquestion($username, $securityquestionid, $securityanswer)
	{			
		$this->writelog("validatelogin($username, $securityquestionid, $securityanswer) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->validatesecurityquestion($username, $securityquestionid, $securityanswer);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
	/**
	* updatepassword
	*
	* Updates a users password
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  int 
	* 
	* @param	string $username
	* @param 	string $password
	* 
	*/
	public function updatepassword($username, $password)
	{			
		$this->writelog("updatepassword($username, $password) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->updatepassword($username, $password);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

	/**
	* getlogininfo
	*
	* Returns a username and password for an email address.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  LOCKER_PROFILE object
	* 
	* @param 	string $emailaddress
	* 
	*/
	public function getlogininfo($emailaddress)
	{			
		$this->writelog("getlogininfo($emailaddress) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$CookieManager = new GI_CompoundCookieManager('auids');
			$CookieManager->retrieveCookie();
			$parent_auid = $CookieManager->getSubcookie('xs-auid');
			
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);

			$retVal = $this->_client->getlogininfo($emailaddress,$parent_auid);
			
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring}), $parent_auid";
		}
		
		return $retVal;
	}	
	
	/**
	* getbdportlogininfo
	*
	* Returns a username and password for an email address.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  LOCKER_PROFILE object
	* 
	* @param 	string $emailaddress
	* 
	*/
	public function getbdportlogininfo($emailaddress)
	{			
		
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$CookieManager = new GI_CompoundCookieManager('auids');
			$CookieManager->retrieveCookie();
			$parent_auid = $CookieManager->getSubcookie('bdport-auid');
			$this->writelog("getbdportlogininfo($emailaddress, $parent_auid) \n");
			
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);

			$retVal = $this->_client->getlogininfo($emailaddress,$parent_auid);
			
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring}), $parent_auid";
		}
		
		return $retVal;
	}
		
	/**
	* update_ecsstudent
	*
	* Update an ECS user by inserting into profile and profile details.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $teacher_profileid
	* @param 	string $student_profileid
	* @param 	string $fname
	* @param 	string $lname
	* @param 	string $middleinitial
	* @param 	string $studentid
	* @param 	string $gender
	* @param 	string $dateofbirth
	* @param 	string $homelanguage
	* @param 	string $specialnotes
	* @param 	string $iep
	* @param 	string $pg1_name
	* @param 	string $pg1_email
	* @param 	string $pg1_phone
	* @param 	string $pg2_name
	* @param 	string $pg2_email
	* @param 	string $pg2_phone
	* @param 	string $classid
	*/
	public function update_ecsstudent($teacher_profileid, $student_profileid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, 
									$specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone,$classid)
	{			
		$fname = htmlentities($fname);	
		$lname = htmlentities($lname);	
		$middleinitial = htmlentities($middleinitial);
		$specialnotes = htmlentities($specialnotes);
		$pg1_name = htmlentities($pg1_name);
		$pg2_name = htmlentities($pg2_name);
		
		
		$this->writelog("update_ecsstudent($teacher_profileid, $student_profileid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone,$classid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$retVal = $this->_client->update_ecsstudent($teacher_profileid, $student_profileid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone,$classid);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring}), $parent_auid";
		}
		
		return $retVal;
	}	
	/**
	* updateprofiledetails
	*
	* Updates profile details for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $productid
	* @param 	int $currentassignmentid
	* @param 	string $emailaddress
	* @param 	array $gradearray
	* @param 	array $interestarray
	* @param 	array $marketingprefarray
	* @param	int $lexilerange
	* @param	int $currentclassid
	* @param	string $pg1_name
	* @param	string $pg1_email
	* @param	string $pg1_phone
	* @param	string $pg2_name
	* @param	string $pg2_email
	* @param	string $pg2_phone
	* @param	string $specialnotes
	* @param	string $iep
	* @param	string $displayemail
	* @param	string $displaywc
	*/
	public function updateprofiledetails($profileid, $productid, $currentassignmentid, $emailaddress, $gradearray, $interestarray, $marketingprefarray, $lexilerange, $currentclassid, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $specialnotes, $iep, $displayemail, $displaywc)
	{			
		$emailaddress = strtolower($emailaddress);
		$this->writelog("updateprofiledetails($profileid, $productid, $currentassignmentid, $emailaddress, $gradearray, $interestarray, $marketingprefarray, $lexilerange, $currentclassid, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $specialnotes, $iep, $displayemail, $displaywc) \n");
		$retVal = false;
		try
		{
			$profilevalue = '';
			if($productid=="bdport"){
				
				//email address
				$profilevalue .= $emailaddress.'|';
				
				//marketing..
				for ($i = 0; $i < count($marketingprefarray); $i++)
				{
					$profilevalue .= $marketingprefarray[$i];
					if(($i+1) < count($marketingprefarray))
					{
						$profilevalue .= ',';
					}
				}		
				
				$profilevalue .= '|';
				
				//IEP
				$profilevalue .= $iep.'|';	
				
				//special notes
				$profilevalue .= $specialnotes.'|';
				
				//student id
				$profilevalue .= $studentid.'|';
				
				//home language
				$profilevalue .= $homelanguage.'|';
				
				$profilevalue .= $pg1_name.'|';
				
				$profilevalue .= $pg1_email.'|';
				
				$profilevalue .= $pg1_phone.'|';
				
				$profilevalue .= $pg2_name.'|';
				
				$profilevalue .= $pg2_email.'|';
				
				$profilevalue .= $pg2_phone.'|';
				
				$profilevalue .= $displayemail.'|';
				
				$profilevalue .= $displaywc;
	
				
			}else{
			
			
				//Check memcache
				// initialize class member variables
				//Create string
			
				$profilevalue .= $emailaddress.'|';
				for ($i = 0; $i < count($gradearray); $i++)
				{
					$profilevalue .= $gradearray[$i];
					if(($i+1) < count($gradearray))
					{
						$profilevalue .= ',';
					}
				}
				$profilevalue .= '|';
				for ($i = 0; $i < count($interestarray); $i++)
				{
					$profilevalue .= $interestarray[$i];
					if(($i+1) < count($interestarray))
					{
						$profilevalue .= ',';
					}
				}			
				$profilevalue .= '|';
				for ($i = 0; $i < count($marketingprefarray); $i++)
				{
					$profilevalue .= $marketingprefarray[$i];
					if(($i+1) < count($marketingprefarray))
					{
						$profilevalue .= ',';
					}
				}			
			
			}
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofiledetails($profileid, $productid, $currentassignmentid, $profilevalue, $lexilerange, $currentclassid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updateprofile
	*
	* Updates a profile for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $username
	* @param 	string $password
	* @param 	string $nickname
	* @param 	int $securityquestionid
	* @param 	string $securityanswer
	* @param 	int $profiletype
	* @param	string $title
	* @param	string $firstname
	* @param	string $lastname
	* @param	string $middleinitial
	* @param	string $gender
	* @param	string $dateofbirth
	*/
	public function updateprofile($profileid, $username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $title, $firstname, $lastname, $middleinitial, $gender, $dateofbirth)
	{			
		$firstname = htmlentities($firstname);	
		$lastname = htmlentities($lastname);	
		$securityanswer = htmlentities($securityanswer);
		$nickname = htmlentities($nickname);
		$title = htmlentities($title);
		$middleinitial = htmlentities($middleinitial);	
				
		$this->writelog("updateprofile($profileid, $username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $title, $firstname, $lastname, $middleinitial, $gender, $dateofbirth) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofile($profileid, $username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $title, $firstname, $lastname, $middleinitial, $gender, $dateofbirth);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
 	/**
	* updateprofilelastlogindate
	*
	* Updates the last login date for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $productid
	* 
	*/
	public function updateprofilelastlogindate($profileid, $productid)
	{			
		$this->writelog("updateprofilelastlogindate($profileid, $productid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofilelastlogindate($profileid, $productid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

 	/**
	* updateprofilelexilerange
	*
	* Updates the lexile level for a given user.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $lexilerange
	* 
	*/
	public function updateprofilelexilerange($profileid, $lexilerange)
	{			
		$this->writelog("updateprofilelexilerange($profileid, $lexilerange)\n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofilelexilerange($profileid, $lexilerange);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateprofilecurrentassignment
	*
	* Updates the current assignment for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $productid
	* @param 	int $currentassignmentid
	* 
	* 
	*/
	public function updateprofilecurrentassignment($profileid, $productid, $currentassignmentid)
	{			
		$this->writelog("updateprofilecurrentassignment($profileid, $productid, $currentassignmentid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofilecurrentassignment($profileid, $productid, $currentassignmentid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updateprofilecurrentclass
	*
	* Updates the current class for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	string $productid
	* @param 	string $currentclassid
	* 
	* 
	*/
	public function updateprofilecurrentclass($profileid, $productid, $currentclassid)
	{			
		$this->writelog("updateprofilecurrentclass($profileid, $productid, $currentclassid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateprofilecurrentclass($profileid, $productid, $currentclassid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateclasscurrentthemeweek
	*
	* Updates the current theme and week that the teacher is working on.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	string $productid
	* @param 	string $classid
	* @param 	string $currentthemeslpid
	* @param 	string $currentweekslpid
	* @param 	string $currentdayid
	* 
	*/
	public function updateclasscurrentthemeweek($profileid, $classid, $productid, $currentthemeslpid, $currentweekslpid, $currentdayid)
	{			
		$this->writelog("updateclasscurrentthemeweek($profileid, $classid, $productid, $currentthemeslpid, $currentweekslpid, $currentdayid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateclasscurrentthemeweek($profileid, $classid, $productid, $currentthemeslpid, $currentweekslpid, $currentdayid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateclass
	*
	* Updates the current theme and week that the teacher is working on.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $classid
	* @param 	string $classname
	* @param 	string $sessionid
	* @param 	string $sessionstartdate
	* @param 	string $sessionenddate
	* @param 	string $daysofweek
	* 
	*/
	public function updateclass($profileid, $classid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek)
	{			

		$classname = htmlentities($classname);
		
		$this->writelog("updateclass($profileid, $classid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateclass($profileid, $classid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
 	/**
	* updateclasscurrentfamilyinfo
	*
	* Updates the current theme, week, tip status and message for the families of a given class.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	string $productid
	* @param 	string $classid
	* @param 	string $currentclassthemeslpid
	* @param 	string $currentclassweekslpid
	* @param 	string $currentmessage
	* 
	*/
	public function updateclasscurrentfamilyinfo($profileid, $classid, $productid, $currentclassthemeslpid, $currentclassweekslpid, $currentmessage)
	{			
		$currentmessage = htmlentities($currentmessage);	
		$this->writelog("updateclasscurrentfamilyinfo($profileid, $classid, $productid, $currentclassthemeslpid, $currentclassweekslpid, $currentmessage) \n");

		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateclasscurrentfamilyinfo($profileid, $classid, $productid, $currentclassthemeslpid, $currentclassweekslpid, $currentmessage);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
	/**
	* getcurrentassignment
	*
	* Get the current assignment. This function returns an object of the current assignment for that user. 
	* The current assignment values that are returned are: profileid, assignmentid, title.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Assignment object
	* 
	* @param	int $profileid
	* @param	string $productid
	*/
	public function getcurrentassignment($profileid,$productid) 
	{
		$this->writelog("getcurrentassignment($profileid,$productid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcurrentassignment($profileid,$productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
	/**
	* getstuffcollectedcounts
	*
	* Get the counts of all the stuff a user collected for a given assignment.
	* The values that are returned are: type, count
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	*/
	public function getstuffcollectedcounts($profileid,$assignmentid) 
	{
		$this->writelog("getstuffcollectedcounts($profileid,$assignmentid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getstuffcollectedcounts($profileid,$assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getoutline	
	*
	* This function returns an array of Locker_Outline objects.
	* The list of possible values are:profileid, assignmentid, outlineid, creationdate, modifieddate, linearray.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Bibliography object
	* 
	* @param	int $profileid
	* @param	int $outlineid
	*/
	public function getoutline($profileid, $outlineid) 
	{
		$this->writelog("getoutline($profileid, $outlineid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getoutline($profileid, $outlineid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getoutlinelist	
	*
	* This function returns an array of Locker_Outline objects.
	* The list of possible values are:profileid, assignmentid, outlineid, creationdate, modifieddate.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Bibliography object
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	*/
	public function getoutlinelist($profileid, $assignmentid)
	{
		$this->writelog("getoutlinelist($profileid, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getoutlinelist($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* setoutline	
	*
	* This function returns an array of Locker_Outline objects.
	* The list of possible values are:profileid, assignmentid, outlineid, creationdate, modifieddate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	* @param	int $outlineid
	* @param	array[int]Locker_Line object
	*/
	public function setoutline($profileid, $assignmentid, $outlineid, $linearray)
	{
		$this->writelog("setoutline($profileid, $assignmentid, $outlineid, $linearray) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->setoutline($profileid, $assignmentid, $outlineid, $linearray);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* insertanecdotalrecord
	*
	* Insert an anecdotal record for a given student
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $teacherprofile
	* @param	string $profileid
	* @param	string $lessonlearningtext
	* @param 	string $observationtext
	* @param 	string $modifieddate
	* @param 	string $recorddate
	*/
	public function insertanecdotalrecord($teacherprofile, $profileid, $lessonlearningtext, $observationtext, $modifieddate, $recorddate)
	{			
		$this->writelog("insertanecdotalrecord($teacherprofile, $profileid, $lessonlearningtext, $observationtext, $modifieddate, $recorddate) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertanecdotalrecord($teacherprofile, $profileid, $lessonlearningtext, $observationtext, $modifieddate, $recorddate);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
 	/**
	* insertcustomlessonplanner
	*
	* Insert a custom lesson planner for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $title
	* @param 	string $language
	* @param 	string $weekslpid
	*/
	public function insertcustomlessonplanner($profileid, $title, $language, $weekslpid)
	{			
		$this->writelog("insertcustomlessonplanner($profileid, $title, $language, $weekslpid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertcustomlessonplanner($profileid, $title, $language, $weekslpid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
		
 	/**
	* insertsavedasset
	*
	* Insert a saved asset for a user\assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $assetid
	* @param 	string $sourceproductid
	* @param 	string $type
	* @param 	string $title
	* @param 	string $uid
	*/
	public function insertsavedasset($profileid, $assignmentid, $assetid, $sourceproductid, $type, $title, $uid)
	{			
		$this->writelog("insertsavedasset($profileid, $assignmentid, $assetid, $sourceproductid, $type, $title, $uid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertsavedasset($profileid, $assignmentid, $assetid, $sourceproductid, $type, $title, $uid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* insertsavedweblink
	*
	* Insert a saved weblink for a user\assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $url
	* @param 	string $weblinktype
	* @param 	string $title
	* @param 	string $location
	*/
	public function insertsavedweblink($profileid, $assignmentid, $url, $weblinktype, $title, $location)
	{			
		$this->writelog("insertsavedweblink($profileid, $assignmentid, $url, $weblinktype, $title, $location) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertsavedweblink($profileid, $assignmentid, $url, $weblinktype, $title, $location);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* movesavedcontent
	*
	* Move saved content to another assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param	int $id
	* @param 	int $contenttype
	* @param 	int $assignmentid
	*/
	public function movesavedcontent($profileid, $id, $contenttype, $assignmentid)
	{			
		$this->writelog("movesavedcontent($profileid, $id, $contenttype, $assignmentid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->movesavedcontent($profileid, $id, $contenttype, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* copysavedcontent
	*
	* copy saved content to another assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param	int $id
	* @param 	int $contenttype
	* @param 	int $assignmentid
	*/
	public function copysavedcontent($profileid, $id, $contenttype, $assignmentid)
	{			
		$this->writelog("copysavedcontent($profileid, $id, $contenttype, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->copysavedcontent($profileid, $id, $contenttype, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
	/**
	* insertassignment
	*
	* Insert an assignment for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  integer - new assignment id
	* 
	* @param	int $profileid
	* @param 	int $assignmenttype
	* @param 	string $title
	* @param 	string $productid
	* @param 	string $active
	* @param 	string $duedate
	* @param 	int $status
	*/
	public function insertassignment($profileid, $assignmenttype, $title, $productid, $active, $duedate, $status)
	{			
		$this->writelog("insertassignment($profileid, $assignmenttype, $title, $productid, $active, $duedate, $status) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertassignment($profileid, $assignmenttype, $title, $productid, $active, $duedate, $status);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	/**
	* getusernamecount
	*
	* Returns a 1 if the username is in use or a 0 if it is not in use.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param 	string $username
	* @param 	string $productid
	* @param 	int $parent_auid	
	*/
	public function getusernamecount($username, $productid = NULL)
	{

		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			//$parent_auid = '258';
			
			$CookieManager = new GI_CompoundCookieManager('auids');
			$CookieManager->retrieveCookie();
			if($productid=="bdport")
			{			
				$parent_auid = $CookieManager->getSubcookie('bdport-auid');
			}
			else
			{
				$parent_auid = $CookieManager->getSubcookie('xs-auid');
			}
			$this->writelog("getusernamecount($username, $productid, $parent_auid) \n");						
			$response = $this->_client->getusernamecount($username, $parent_auid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;		
	}
	/**
	* create_iauthrecord
	*
	* Create an ECS user by inserting into profile and profile details.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $username
	* @param 	string $password
	* @param 	string $parent_auid	
	*/
	public function create_iauthrecord($username, $password, $parent_auid)
	{
		$this->writelog("create_iauthrecord($username, $password, $parent_auid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->create_iauthrecord($username, $password, $parent_auid);
			$retVal = $response;
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;		
	}
	
	/**
	* createuser
	*
	* Create a user by inserting into profile and making a "My Stuff" an assignment. This function returns an assignmentid
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $username
	* @param 	string $password
	* @param	int $securityquestionid
	* @param 	int $profiletype
	* @param 	string $nickname
	* @param 	string $securityanswer
	* @param 	string $productcode
	*/
	public function createuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $productcode)
	{			
		$this->writelog("createuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $productcode) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			//$parent_auid = '258';
			
			$CookieManager = new GI_CompoundCookieManager('auids');
			$CookieManager->retrieveCookie();
			
			if(empty($productcode))
			{
				$productcode = 'xs';
			}
						
			if($productcode == 'xsc')
			{
				$parent_auid = $CookieManager->getSubcookie('xsc-auid');
			}
			else 
			{
				$parent_auid = $CookieManager->getSubcookie('xs-auid');
			}
						
			$response = $this->_client->createuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $parent_auid, $productcode);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* create_customlessonplan
	*
	* Create a custom lesson planner.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $profileid
	* @param 	string $title
	* @param	string $language
	* @param 	string $weekslpid
	* @param 	obj $lessonplannerobj
	* @param 	string $classid
	*/
	public function create_customlessonplan($profileid, $title, $language, $weekslpid, $lessonplannerobj, $classid)
	{			
		$title = htmlentities($title);
		$this->writelog("create_customlessonplan($profileid, $title, $language, $weekslpid, $classid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->create_customlessonplan($profileid, $title, $language, $weekslpid, $lessonplannerobj, $classid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* create_ecsuser
	*
	* Create an ECS user by inserting into profile and profile details.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $username
	* @param 	string $password
	* @param 	string $nickname
	* @param	int $securityquestionid
	* @param 	string $securityanswer
	* @param 	int $profiletype
	* @param 	string $title
	* @param 	string $fname
	* @param 	string $lname
	* @param 	string $middleinitial
	* @param 	string $studentid
	* @param 	string $gender
	* @param 	string $dateofbirth
	* @param 	string $homelanguage
	* @param 	string $email
	* @param 	string $sendupdates
	* @param 	string $specialnotes
	* @param 	string $iep
	* @param 	string $pg1_name
	* @param 	string $pg1_email
	* @param 	string $pg1_phone
	* @param 	string $pg2_name
	* @param 	string $pg2_email
	* @param 	string $pg2_phone	
	* @param 	string $displayemail
	* @param 	string $displaywc
	*/
	public function create_ecsuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $title,
	$fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $email, $sendupdates, $specialnotes, $iep,
	$pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $displayemail, $displaywc)
	{

		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			
			$CookieManager = new GI_CompoundCookieManager('auids');
			$CookieManager->retrieveCookie();
			$parent_auid = $CookieManager->getSubcookie('bdport-auid');

			$nickname = htmlentities($nickname);	
			$securityanswer = htmlentities($securityanswer);	
			$fname = htmlentities($fname);
			$lname = htmlentities($lname);
			$title = htmlentities($title);
			$middleinitial = htmlentities($middleinitial);
			$specialnotes = htmlentities($specialnotes);
			$pg1_name = htmlentities($pg1_name);
			$pg2_name = htmlentities($pg2_name);

			$this->writelog("create_ecsuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $parent_auid,
			$title, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $email, $sendupdates, $specialnotes, $iep,
			$pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $displayemail, $displaywc)\n");			
		
			$response = $this->_client->create_ecsuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $parent_auid,
			$title, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $email, $sendupdates, $specialnotes, $iep,
			$pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $displayemail, $displaywc);
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;		
	}
	
	/**
	* create_ecsstudent
	*
	* Create an ECS user by inserting into profile and profile details.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $parent_auid	
	* @param 	string $fname
	* @param 	string $lname
	* @param 	string $middleinitial
	* @param 	string $studentid
	* @param 	string $gender
	* @param 	string $dateofbirth
	* @param 	string $homelanguage
	* @param 	string $specialnotes
	* @param 	string $iep
	* @param 	string $pg1_name
	* @param 	string $pg1_email
	* @param 	string $pg1_phone
	* @param 	string $pg2_name
	* @param 	string $pg2_email
	* @param 	string $pg2_phone	
	* @param 	string $classid
	*/
	public function create_ecsstudent($parent_auid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, 
									$specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $classid)
	{
		
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			
			if(empty($parent_auid)){
				$CookieManager = new GI_CompoundCookieManager('auids');
				$CookieManager->retrieveCookie();
				$parent_auid = $CookieManager->getSubcookie('bdport-auid');
			}
			
			$fname = htmlentities($fname);	
			$lname = htmlentities($lname);	
			$middleinitial = htmlentities($middleinitial);
			$specialnotes = htmlentities($specialnotes);
			$pg1_name = htmlentities($pg1_name);
			$pg2_name = htmlentities($pg2_name);
	
			$this->writelog("create_ecsstudent($parent_auid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, $specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $classid)\n");
			
			$response = $this->_client->create_ecsstudent($parent_auid, $fname, $lname, $middleinitial, $studentid, $gender, $dateofbirth, $homelanguage, 
									$specialnotes, $iep, $pg1_name, $pg1_email, $pg1_phone, $pg2_name, $pg2_email, $pg2_phone, $classid);
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;		
	}	
	
 	/**
	* insert_seciresults
	*
	* Inserts the SECI results for a given student.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param 	string $profileid
	* @param 	string $secidomainresultsarray
	*/
	public function insert_seciresults($profileid, $secidomainresultsarray)
	{			
		$this->writelog("insert_seciresults($profileid, $secidomainresultsarray) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insert_seciresults($profileid, $secidomainresultsarray);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* createclass
	*
	* Insert a class for a teacher.
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $classname
	* @param 	string $sessionid
	* @param 	string $sessionstartdate
	* @param 	string $sessionenddate
	* @param 	string $daysofweek
	* @param 	string $username
	* @param 	string $password
	* @param 	string $productid
	* @param 	string $currentclassweekid
	* @param 	string $currentmsg
	* @param 	string $currentweekslpid
	* @param 	string $currentdayslpid
	* @param 	string $currentthemeslpid
	* @param 	string $currentclassthemeslpid
	*/
	public function createclass($profileid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek, $username, $password, $productid, $currentclassweekid, $currentmsg, $currentweekslpid, $currentdayslpid, $currentthemeslpid, $currentclassthemeslpid)
	{	
		$classname = htmlentities($classname);	
		$currentmsg = htmlentities($currentmsg);
		
		$this->writelog("createclass($profileid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek, $username, $password, $productid, $currentclassweekid, $currentmsg, $currentweekslpid, $currentdayslpid, $currentthemeslpid, $currentclassthemeslpid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);			
			$response = $this->_client->createclass($profileid, $classname, $sessionid, $sessionstartdate, $sessionenddate, $daysofweek, $username, $password, $parent_auid, $productid, $currentclassweekid, $currentmsg, $currentweekslpid, $currentdayslpid, $currentthemeslpid, $currentclassthemeslpid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;	
	
	}	
	
	/**
	* insertprofiledetails
	*
	* Insert profile details.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  int
	* 
	* @param	int $profileid
	* @param 	string $productid
	* @param 	string $emailaddress
	* @param 	array $gradearray
	* @param 	array $interestarray
	* @param 	array $marketingprefarray
	* @param 	int $currentassignmentid
	* @param 	int $lexilerange 
	*/
	public function insertprofiledetails($profileid, $productid, $emailaddress,$gradearray,$interestarray,$marketingprefarray, $currentassignmentid, $lexilerange)
	{			
		$emailaddress = strtolower($emailaddress);
		$this->writelog("insertprofiledetails($profileid, $productid, $emailaddress,$gradearray,$interestarray,$marketingprefarray, $currentassignmentid, $lexilerange) \n");
		$retVal = false;
		try
		{
			//Check memcache
			//Create string
			$profilevalue = '';
			$profilevalue .= $emailaddress.'|';
			for ($i = 0; $i < count($gradearray); $i++)
			{
				$profilevalue .= $gradearray[$i];
				if(($i+1) < count($gradearray))
				{
					$profilevalue .= ',';
				}
			}
			$profilevalue .= '|';
			for ($i = 0; $i < count($interestarray); $i++)
			{
				$profilevalue .= $interestarray[$i];
				if(($i+1) < count($interestarray))
				{
					$profilevalue .= ',';
				}
			}			
			$profilevalue .= '|';
			for ($i = 0; $i < count($marketingprefarray); $i++)
			{
				$profilevalue .= $marketingprefarray[$i];
				if(($i+1) < count($marketingprefarray))
				{
					$profilevalue .= ',';
				}
			}					
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertprofiledetails($profileid, $productid,$profilevalue, $currentassignmentid, $lexilerange);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* insertassignmentdetails
	*
	* Insert an assignment details for a given user. It returns the new assignment details id.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  integer - new assignment details id.
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $paraphrase
	* @param 	int $finaldraftformatid
	* @param 	string $lengthoffinaldraft
	* @param 	int $numofsources
	* @param	int $citationtypeid
	* @param	array $citationsourceidearray
	* @param	string $othercitationsource
	*/
	public function insertassignmentdetails($profileid, $assignmentid, $paraphrase, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $citationtypeid, $citationsourceidearray, $othercitationsource)
	{
		$this->writelog("insertassignmentdetails($profileid, $assignmentid, $paraphrase, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $citationtypeid, $citationsourceidearray, $othercitationsource) \n");
		$retVal = '';
		try
		{
			
			//citationsourceid|finaldraftformatid|lengthoffinaldraft|numofsources|othercitationsource|paraphrase
			
			//Check memcache
			//Create string
			$assignmentvalue = '';
			
			for ($i = 0; $i < count($citationsourceidearray); $i++)
			{
				$assignmentvalue .= $citationsourceidearray[$i];
				if(($i+1) < count($citationsourceidearray))
				{
					$assignmentvalue .= ',';
				}
			}
			$assignmentvalue .= '|';
			$assignmentvalue .= $finaldraftformatid.'|';
			$assignmentvalue .= $lengthoffinaldraft.'|';
			$assignmentvalue .= $numofsources.'|';
			$assignmentvalue .= $othercitationsource.'|';
			$assignmentvalue .= $paraphrase;
			
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertassignmentdetails($profileid,$assignmentid,$assignmentvalue,$citationtypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
			
 	/**
	* updateassignment
	*
	* Updates an assignment for a given user. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $title
	* @param 	string $duedate
	*/
	public function updateassignment($profileid, $assignmentid, $title, $duedate)
	{			
		$this->writelog("updateassignment($profileid, $assignmentid, $title, $duedate) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignment($profileid, $assignmentid, $title, $duedate);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updateactivelessonplan
	*
	* Update the active lesson plan for a given user, class, week, language.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	string $profileid
	* @param 	string $classid
	* @param 	string $weekslpid
	* @param 	string $lessonplannerid
	* @param 	string $lessonplannertype
	* @param 	string $language
	*/
	public function updateactivelessonplan($profileid, $classid, $weekslpid, $lessonplannerid, $lessonplannertype, $language)
	{			
		$this->writelog("updateactivelessonplan($profileid, $classid, $weekslpid, $lessonplannerid, $lessonplannertype, $language) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateactivelessonplan($profileid, $classid, $weekslpid, $lessonplannerid, $lessonplannertype, $language);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* insertdayblockobjectives
	*
	* Add objectives to a day block.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	string $profileid
	* @param 	string $dayblockid
	* @param 	string $objectiveid
	*/
	public function insertdayblockobjectives($profileid, $dayblockid, $objectiveid)
	{			
		$this->writelog("insertdayblockobjectives($profileid, $dayblockid, $objectiveid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertdayblockobjectives($profileid, $dayblockid, $objectiveid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* updateassignmentdetails
	*
	* Updates assignment details for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $paraphrase
	* @param 	int $finaldraftformatid
	* @param 	string $lengthoffinaldraft
	* @param 	int $numofsources
	* @param	int $citationtypeid
	* @param	array $citationsourceidearray
	* @param	string $othercitationsource
	*/
	public function updateassignmentdetails($profileid, $assignmentid, $paraphrase, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $citationtypeid, $citationsourceidearray, $othercitationsource)
	{			
		$this->writelog("updateassignmentdetails($profileid, $assignmentid, $paraphrase, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $citationtypeid, $citationsourceidearray, $othercitationsource) \n");
		$retVal = false;
		try
		{
			//Check memcache
			
			//Create string
			$assignmentvalue = '';
			
			for ($i = 0; $i < count($citationsourceidearray); $i++)
			{
				$assignmentvalue .= $citationsourceidearray[$i];
				if(($i+1) < count($citationsourceidearray))
				{
					$assignmentvalue .= ',';
				}
			}
			$assignmentvalue .= '|';
			$assignmentvalue .= $finaldraftformatid.'|';
			$assignmentvalue .= $lengthoffinaldraft.'|';
			$assignmentvalue .= $numofsources.'|';
			$assignmentvalue .= $othercitationsource.'|';
			$assignmentvalue .= $paraphrase;
						
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentdetails($profileid, $assignmentid, $citationtypeid, $assignmentvalue);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateassignmenttitle
	*
	* Updates the assignment title.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	string $title
	* @param 	int $assignmentid
	*/
	public function updateassignmenttitle($profileid, $assignmentid, $title)
	{			
		$this->writelog("updateassignmenttitle($profileid, $assignmentid, $title) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmenttitle($profileid, $assignmentid, $title);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* updateassignmentduedate
	*
	* Updates the assignment duedate.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $duedate
	*/
	public function updateassignmentduedate($profileid, $assignmentid, $duedate)
	{			
		$this->writelog("updateassignmentduedate($profileid, $assignmentid, $duedate) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentduedate($profileid, $assignmentid, $duedate);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* updateassignmentcompletiondate
	*
	* Updates an assignments task completion date and assignmentstatus for a given user.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	int $taskid
	* @param 	int $status
	*/
	public function updateassignmentcompletiondate($profileid, $assignmentid, $taskid, $status)
	{			
		$this->writelog("updateassignmentcompletiondate($profileid, $assignmentid, $taskid, $status) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentcompletiondate($profileid, $assignmentid, $taskid, $status);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
 	/**
	* updateassignmentstatus
	*
	* Updates the assignment status.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $status
	*/
	public function updateassignmentstatus($profileid, $assignmentid, $status)
	{			
		$this->writelog("updateassignmentstatus($profileid, $assignmentid, $status) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentstatus($profileid, $assignmentid, $status);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateassignmentactive
	*
	* Updates the assignment active state.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $active
	*/
	public function updateassignmentactive($profileid, $assignmentid, $active)
	{			
		$this->writelog("updateassignmentactive($profileid, $assignmentid, $active) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentactive($profileid, $assignmentid, $active);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updateassignmentcitationtype
	*
	* Updates the assignment's citation type.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	int $citationtypeid
	*/
	public function updateassignmentcitationtype($profileid, $assignmentid, $citationtypeid)
	{			
		$this->writelog("updateassignmentcitationtype($profileid, $assignmentid, $citationtypeid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updateassignmentcitationtype($profileid, $assignmentid, $citationtypeid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updatedayblock
	*
	* Update a day block title for a custom day block.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	string $profileid
	* @param 	string $dayblockid
	* @param 	string $title
	*/
	public function updatedayblock($profileid, $dayblockid, $title)
	{			
		$this->writelog("updatedayblock($profileid, $dayblockid, $title) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatedayblock($profileid, $dayblockid, $title);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* deletesavedcontent
	*
	* delete a saved content.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	int $profileid
	* @param	int $id
	* @param 	int $contenttype
	*/
	public function deletesavedcontent($profileid, $id, $contenttype)
	{			
		$this->writelog("deletesavedcontent($profileid, $id, $contenttype) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletesavedcontent($profileid, $id, $contenttype);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* deletedayblockobjectives
	*
	* delete an objective from a day block.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $dayblockid
	* @param 	int $objectiveid
	*/
	public function deletedayblockobjectives($profileid, $dayblockid, $objectiveid)
	{			
		$this->writelog("deletedayblockobjectives($profileid, $dayblockid, $objectiveid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletedayblockobjectives($profileid, $dayblockid, $objectiveid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
 	/**
	* deleteanecdotalrecord
	*
	* Deletes an anecdotalrecord for a given student
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $teacherprofileid
	* @param	string $profileid
	* @param 	string $anecdotalrecordid
	*/
	public function deleteanecdotalrecord($teacherprofileid, $profileid, $anecdotalrecordid)
	{			
		$this->writelog("deleteanecdotalrecord($teacherprofileid, $profileid, $anecdotalrecordid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deleteanecdotalrecord($teacherprofileid, $profileid, $anecdotalrecordid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
 	/**
	* deleteassignment
	*
	* Updates an assignment for a user to inactive.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function deleteassignment($profileid, $assignmentid)
	{			
		$this->writelog("deleteassignment($profileid, $assignmentid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deleteassignment($profileid, $assignmentid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
			
	/**
	* getassignment
	*
	* This function returns an assignment object.
	* The assignment values that are returned are: assignmenttype,productid,title,active,creationdate.
	* It also returns values from the assignmentdetails table if the user data for that value.
	* The list of possible values are:citationsourceid,citationtypeid,finaldraftformatid,lengthoffinaldraft,numofsources,othercitationsource,paraphrase,status.
	* 
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Assignment object
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getassignment($profileid, $assignmentid) 
	{
		$this->writelog("getassignment($profileid, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignment($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
	/**
	* getprofile
	*
	* This function returns a profile object
	* The profile values that are returned are: productid, currentassignmentid, lastlogindate, lexilerange, profilevalue, nickname, securityquestionid, securityanswer, creationdate, profiletype, active
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Profile object
	* 
	* @param 	int $profileid
	*/
	public function getprofile($profileid) 
	{
		$this->writelog("getprofile($profileid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getprofile($profileid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
   	/**
	* getstudent
	*
	* This function returns an Locker_Profile object.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Profile $var
	* 
	* @param 	string $profileid
	* @param 	string $studentprofileid
	*/
	public function getstudent($profileid, $studentprofileid)
	{
		$this->writelog("getstudent($profileid, $studentprofileid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getstudent($profileid, $studentprofileid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;		
	}
	
	/**
	* getclassstudentlist
	*
	* This function returns an array of profile objects
	* The profile values that are returned are: productid, currentassignmentid, lastlogindate, lexilerange, profilevalue, nickname, securityquestionid, securityanswer, creationdate, profiletype, active
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Profile object
	* 
	* @param 	int $profileid
	* @param 	string $classid
	* @param 	string $productid
	* @param 	string $active
	* 
	*/
	public function getclassstudentlist($profileid, $classid, $productid, $active) 
	{
		$this->writelog("getclassstudentlist($profileid, $classid, $productid, $active)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getclassstudentlist($profileid, $classid, $productid, $active);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
	/**
	* getanecdotalrecordlist
	*
	* This function returns an array of anecdotal record objects
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Anecdotal_Record $var
	* 
	* @param	string $teacherprofileid
	* @param 	int $profileid
	* 
	*/
	public function getanecdotalrecordlist($teacherprofileid, $profileid) 
	{
		$this->writelog("getanecdotalrecordlist($teacherprofileid, $profileid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getanecdotalrecordlist($teacherprofileid, $profileid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getstudentanecdotalrecordlist
	*
	* This function returns an array of anecdotal record objects
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Anecdotal_Record $var
	* 
	* @param 	string $profileid
	* @param 	string $productid
	* @param 	string $classid
	* 
	*/
	public function getstudentanecdotalrecordlist($profileid, $productid, $classid) 
	{
		$this->writelog("getstudentanecdotalrecordlist($profileid, $productid, $classid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getstudentanecdotalrecordlist($profileid, $productid, $classid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getuserlist
	*
	* This function returns an array of Locker_Profile object. 
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param 	string $parentid
	* 
	* @return  array[int] Locker_Profile $var
	* 
	*/
	public function getuserlist($parentid)
	{
		$this->writelog("getuserlist($parentid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getuserlist($parentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

   	/**
	* getallusers
	*
	* This function returns an array of Locker_Profile object. 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int] Locker_Profile $var
	* 
	*/
	public function getallusers()
	{
		$this->writelog("getallusers()  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getallusers();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
   	/**
	* searchuserlist
	*
	* This function returns an array of Locker_Profile object for a given user name string. 
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @param 	string $searchterm
	* 
	* @return  	array[int]Locker_IAuthProfile $var
	* 
	*/
	public function searchuserlist($searchterm)
	{			
		$this->writelog("searchuserlist($searchterm)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->searchuserlist($searchterm);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
    private function cmpString($a, $b){
    	
    	eval("\$var1 = \$a->_".$a->_sort.";");
    	eval("\$var2 = \$b->_".$b->_sort.";");

    	$al = strtolower($var1);
   		$bl = strtolower($var2);
   		
	    if ($al == $bl) {
	        return 0;
	    }
	    return ($al > $bl) ? +1 : -1;
    }
    
    private function cmpInt($a, $b){
	
		eval("\$var1 = \$a->_".$a->_sort.";");
		eval("\$var2 = \$b->_".$b->_sort.";");
	
		$al = $var1;
		$bl = $var2;
			
	    if ($al == $bl) {
	        return 0;
	    }
	    return ($al > $bl) ? +1 : -1;
    }
    
	/**
	* getassignmentlist
	*
	* This function returns an array of assignment objects.
	* The assignment values that are returned are: assignmentid, title, assignmenttype, duedate, completiondate 
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Assignment $var
	* 
	* @param	int $profileid
	* @param 	int $productid
	* @param 	int $active
	* @param 	string $sort
	*/
	public function getassignmentlist($profileid, $productid, $active, $sort) 
	{
		$this->writelog("getassignmentlist($profileid, $productid, $active, $sort)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignmentlist($profileid, $productid, $active, $sort);
			if($sort){
				usort($response, array("Locker_Client", "cmpString"));
			}


			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
	/**
	* getclasslist
	*
	* This function returns an array of class objects.
	* 	* Possible values are: classid, classname, sessionid, sessionstartdate, sessionenddate, active, daysofweek, creationdate, classprofileid, currentclassweekslpid, currentmessage, currentweekslpid, currentdayid, currentthemeslpid, currentclassthemeslpid  
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Class $var
	* 
	* @param	string $profileid
	* @param	string $productid
	*/
	public function getclasslist($profileid, $productid) 
	{
		$this->writelog("getclasslist($profileid, $productid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getclasslist($profileid, $productid);
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getclass
	*
	* This function returns a class object.
	* 	* Possible values are: classid, classname, sessionid, sessionstartdate, sessionenddate, active, daysofweek, creationdate, classprofileid, currentclassweekslpid, currentmessage, currentweekslpid, currentdayid, currentthemeslpid, currentclassthemeslpid  
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Class $var
	* 
	* @param	string $profileid
	* @param	string $classid
	* @param	string $productid
	*/
	public function getclass($profileid, $classid, $productid) 
	{
		$this->writelog("getclass($profileid, $classid, $productid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getclass($profileid, $classid, $productid);
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getassignmentassetlist
	*
	* Get a list of assignments that a particular asset has been saved in.
	* The assignment values that are returned are: assignmentid, title, profileid
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Assignment $var
	* 
	* @param	int $profileid
	* @param	string $assetid
	* @param 	string $productid
	* @param 	string $type
	* @param 	string $sort
	*/
	public function getassignmentassetlist($profileid, $assetid, $productid, $type, $sort) 
	{
		$this->writelog("getassignmentassetlist($profileid, $assetid, $productid, $type, $sort)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignmentassetlist($profileid, $assetid, $productid, $type, $sort);
			if($sort){
				usort($response, array("Locker_Client", "cmpString"));
			}


			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* isassignmenttitlevalid
	*
	* Checks to see if assignment title is valid.  The title is checked against all active assignments for a given product.
	* Returns true if the given title is valid. False if it is not valid.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	string $productid
	* @param 	string $title
	*/
	public function isassignmenttitlevalid($profileid, $productid, $title)
	{		
		$this->writelog("isassignmenttitlevalid($profileid, $productid, $title) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->isassignmenttitlevalid($profileid, $productid, $title);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
    /**
	* getnotecardcount
	*
	* This function returns the number of notecards for a given assignment.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  String
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getnotecardcount($profileid, $assignmentid)
	{			
		$this->writelog("getnotecardcount($profileid, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnotecardcount($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
    /**
	* getcitationcount
	*
	* This function returns the number of citations for a given assignment.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  String
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getcitationcount($profileid, $assignmentid)
	{			
		$this->writelog("getcitationcount($profileid, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcitationcount($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

    /**
	* getstuffcollected
	*
	* Get a list of the stuff a user collected for a particular assignment.  If type is null then you will get a list of all of the 'stuff' a user collected.  Otherwise you will get a list of only the type that is passed in.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array
	* 
	* @param 	int $profileid
	* @param 	int $assignmentid
	* @param 	int $type
	*/
	public function getstuffcollected($profileid, $assignmentid, $type)
	{			
		$this->writelog("getstuffcollected($profileid, $assignmentid, $type) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getstuffcollected($profileid, $assignmentid, $type);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

    /**
	* getassignmentstats
	*
	* This function returns an Locker_Assignment_Stats object.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Assignment_Stats object
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getassignmentstats($profileid,$assignmentid)
	{			
		$this->writelog("getassignmentstats($profileid,$assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignmentstats($profileid,$assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
 	/**
	* inserttask
	*
	* Insert a new task to an assignment for a given user. It returns the new task id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int - new task id.
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	int $tasktype
	* @param 	string $duedate
	* @param 	string $customdescription
	*/
	public function inserttask($profileid, $assignmentid, $tasktype, $duedate, $customdescription)
	{			
		$this->writelog("inserttask($profileid, $assignmentid, $tasktype, $duedate, $customdescription) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->inserttask($profileid, $assignmentid, $tasktype, $duedate, $customdescription);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

 	/**
	* updatetaskdescription
	*
	* Updates an assignment task due date for a given user.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	* @param 	string $customdescription
	*/
	public function updatetaskdescription($profileid, $taskid, $customdescription)
	{			
		$this->writelog("updatetaskdescription($profileid, $taskid, $customdescription) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatetaskdescription($profileid, $taskid, $customdescription);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updatetaskduedate
	*
	* Updates an assignment task due date for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	* @param 	string $duedate
	*/
	public function updatetaskduedate($profileid, $taskid, $duedate)
	{			
		$this->writelog("updatetaskduedate($profileid, $taskid, $duedate) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatetaskduedate($profileid, $taskid, $duedate);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updatetaskcompletiondate
	*
	* Updates an assignment task completion date for a given user.
	*
	* @author  	Diane Palmer
	* @access 	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	*/
	public function updatetaskcompletiondate($profileid, $taskid)
	{			
		$this->writelog("updatetaskcompletiondate($profileid, $taskid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatetaskcompletiondate($profileid, $taskid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	


 	/**
	* marktaskincomplete
	*
	* Updates an assignment task completion date to NULL.
	*
	* @author  	John Palmer
	* @access 	public 
	* 
	* @return  int 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	*/
	public function marktaskincomplete($profileid, $taskid)
	{			
		$this->writelog("marktaskincomplete($profileid, $taskid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->marktaskincomplete($profileid, $taskid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updatetaskmodifieddate
	*
	* Updates an assignment task modified date for a given user.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	*/
	public function updatetaskmodifieddate($profileid, $taskid)
	{			
		$this->writelog("updatetaskmodifieddate($profileid, $taskid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatetaskmodifieddate($profileid, $taskid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

 	/**
	* deletetask
	*
	* Delete a task from an assignment.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $taskid
	*/
	public function deletetask($profileid, $taskid)
	{			
		$this->writelog("deletetask($profileid, $taskid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletetask($profileid, $taskid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* removestudentfromclass
	*
	* Remove a student from a class.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	string $teacherprofileid
	* @param	string $profileid
	*/
	public function removestudentfromclass($teacherprofileid, $profileid)
	{			
		$this->writelog("removestudentfromclass($teacherprofileid, $profileid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->removestudentfromclass($teacherprofileid, $profileid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

	/**
	* gettask
	*
	* Get a task. This function a task object. 
	* The task values that are returned are: profileid,assignmentid,taskid,tasktype,duedate,completiondate,title,description.
	*
	* @author  	John Palmer
	* @access	public 
	* 
	* @return  	Locker_Task object
	* 
	* @param	int $profileid
	* @param	int $taskid
	*/
	public function gettask($profileid, $taskid) 
	{
		$this->writelog("gettask($profileid, $taskid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->gettask($profileid, $taskid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
	/**
	* gettasklist
	*
	* Get a list of tasks. This function returns an array of locker task objects. 
	* The task values that are returned are: profileid,assignmentid,taskid,tasktype,duedate,completiondate,title,description.
	*
	* @author  	Diane Palmer
	* @access	public 
	* 
	* @return  	array[int]Locker_Task $var
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $sort
	*/
	public function gettasklist($profileid,$assignmentid,$sort) 
	{
		$this->writelog("gettasklist($profileid,$assignmentid,$sort)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->gettasklist($profileid,$assignmentid,$sort);
			
			if($sort)
			{
				if($sort=="tasktype")
				{
					usort($response, array("Locker_Client", "cmpInt"));
				}
				elseif($sort=="duedate")
				{
				}
				else 
				{
					usort($response, array("Locker_Client", "cmpString"));
				}
				
			}
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
	/**
	* gettaskbytype
	*
	* Get a task by its type.  This function returns a task object.
	* The values returned are: taskid, duedate, completiondate, title, description
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Assignment object
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	* @param	int $tasktype
	*/
	public function gettaskbytype($profileid,$assignmentid,$tasktype) 
	{
		$this->writelog("gettaskbytype($profileid,$assignmentid,$tasktype)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->gettaskbytype($profileid,$assignmentid,$tasktype);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* insertnotecard
	*
	* Insert a new notecard to an assignment for a given user. It returns the new notecard id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int - new notecard id
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $title
	* @param 	string $directquote
	* @param 	string $paraphrase
	* @param 	int $charcountdirectquote
	* @param 	int $charcountparaphrase
	* @param 	int $citationid
	* @param 	int $groupid
	*/
	public function insertnotecard($profileid, $assignmentid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $citationid, $groupid)
	{			
		$this->writelog("insertnotecard($profileid, $assignmentid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $citationid, $groupid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertnotecard($profileid, $assignmentid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $citationid, $groupid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updatenotecard
	*
	* Updates a notecard for a given user. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	* @param 	string $title
	* @param 	string $directquote
	* @param 	string $paraphrase
	* @param 	int $charcountdirectquote
	* @param 	int $charcountparaphrase
	* @param	int $groupid
	*/
	public function updatenotecard($profileid, $notecardid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $groupid)
	{			
		$this->writelog("updatenotecard($profileid, $notecardid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $groupid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatenotecard($profileid, $notecardid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $groupid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
				
		}
		
		return $retVal;
	}

 	/**
	* updatenotecardgroup
	*
	* Updates a notecard group for a given user. 
	* NOTE: You can pass a null value for groupid to remove a notecard from a group.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	* @param 	int $groupid
	*/
	public function updatenotecardgroup($profileid, $notecardid, $groupid)
	{			
		$this->writelog("updatenotecardgroup($profileid, $notecardid, $groupid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatenotecardgroup($profileid, $notecardid, $groupid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
 	/**
	* updatenotecardcitation
	*
	* Updates a notecard citation.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	* @param 	int $citationid
	*/
	public function updatenotecardcitation($profileid, $notecardid, $citationid)
	{			
		$this->writelog("updatenotecardcitation($profileid, $notecardid, $citationid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatenotecardcitation($profileid, $notecardid, $citationid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updatenotecardmodifieddate
	*
	* Updates a notecard modified date.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	*/
	public function updatenotecardmodifieddate($profileid, $notecardid)
	{			
		$this->writelog("updatenotecardmodifieddate($profileid, $notecardid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatenotecardmodifieddate($profileid, $notecardid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
 	
	/**
	* deletenotecard
	*
	* Deletes a notecard.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	*/
	public function deletenotecard($profileid, $notecardid)
	{			
		$this->writelog("deletenotecard($profileid, $notecardid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletenotecard($profileid, $notecardid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

	/**
	* getnotecard
	*
	* Get an individual notecard. This function returns an object of an individual notecard. 
	* The notecard values that are returned are: profileid, assignmentid, notecardid, title, groupid, tags, quote, text, citationid.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Notecard object
	* 
	* @param	int $profileid
	* @param 	int $notecardid
	*/
	public function getnotecard($profileid, $notecardid) 
	{
		$this->writelog("getnotecard($profileid, $notecardid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnotecard($profileid, $notecardid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getnotecardlist
	*
	* Get a list of notecard for a particular user and assignment. This function returns an array of notecard objects. 
	* The notecardlist values that are returned are: notecardid, title, groupid, grouptitle.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Notecard $var
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $sort
	*/
	public function getnotecardlist($profileid,$assignmentid,$sort) 
	{
		$this->writelog("getnotecardlist($profileid,$assignmentid,$sort)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnotecardlist($profileid,$assignmentid,$sort);
			
			if($sort){
				if($sort=='title'){
					usort($response, array("Locker_Client", "cmpString"));	
				}else{
					usort($response, array("Locker_Client", "cmpInt"));	
					
				}
			}
			
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
 	/**
	* insertgroup
	*
	* Insert a new group to an assignment for a given user. It returns the new group id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int new group id
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $title
	*/
	public function insertgroup($profileid, $assignmentid, $title)
	{			
		$this->writelog("insertgroup($profileid, $assignmentid, $title) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertgroup($profileid, $assignmentid, $title);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
 	
	/**
	* updategroupmodifieddate
	*
	* Update a groups modifieddate.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	int $groupid
	*/
	public function updategroupmodifieddate($profileid, $groupid)
	{			
		$this->writelog("updategroupmodifieddate($profileid, $groupid) \n");
		$retVal = false;
		try
		{
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updategroupmodifieddate($profileid, $groupid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
			
 	/**
	* deletegroup
	*
	* Delete a group.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  boolean 
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	* @param	int $groupid
	*/
	public function deletegroup($profileid, $assignmentid, $groupid)
	{			
		$this->writelog("deletegroup($profileid, $assignmentid, $groupid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletegroup($profileid, $assignmentid, $groupid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

	/**
	* getgroup
	*
	* Get a group for a particular groupid. This function returns a group object. 
	* The group values that are returned are: groupid, title.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Group object
	* 
	* @param	int $profileid
	* @param	int $groupid
	*/
	public function getgroup($profileid, $groupid) 
	{
		$this->writelog("getgroup($profileid, $groupid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getgroup($profileid, $groupid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
	/**
	* getgrouplist
	*
	* Get a list of groups for a particular user and assignment. This function returns an array of group objects. 
	* The grouplist values that are returned are: groupid, title.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Group $var
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param 	string $sort
	*/
	public function getgrouplist($profileid,$assignmentid,$sort) 
	{
		$this->writelog("getgrouplist($profileid,$assignmentid,$sort)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getgrouplist($profileid,$assignmentid,$sort);
			
			if($sort){
				usort($response, array("Locker_Client", "cmpString"));
			}//end if
			
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getcurrenttask
	*
	* This function returns a task object.
	* The assignment values that are returned are: task.taskid, task.duedate, locker1support_gi.tasktype.description as title, customtaskdescription.description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Task object
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getcurrenttask($profileid,$assignmentid) 
	{
		$this->writelog("getcurrenttask($profileid,$assignmentid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcurrenttask($profileid,$assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getassignmentdaysleft
	*
	* This function returns the number of days left
	* The assignment values that are returned are: daysleft
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int - days left
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function getassignmentdaysleft($profileid,$assignmentid) 
	{
		$this->writelog("getassignmentdaysleft($profileid,$assignmentid)  \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignmentdaysleft($profileid,$assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
  	/**
	* getassignmentpercentcomplete
	*
	* This function returns a percentage complete string
	* The list of possible values are: percentagecomplete.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	string - percentage complete
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	*/
	public function getassignmentpercentcomplete($profileid, $assignmentid)
	{
		$this->writelog("getassignmentpercentcomplete($profileid, $assignmentid) \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassignmentpercentcomplete($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* getfinaldraftformat
	*
	* This function returns a support data object.
	* The list of possible values are:finaldraftformatid, description.
	* 
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $finaldraftformatid
	*/
	public function getfinaldraftformat($finaldraftformatid) 
	{
		$this->writelog("getfinaldraftformat($finaldraftformatid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getfinaldraftformat($finaldraftformatid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
   	/**
	* getfinaldraftformatlist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:finaldraftformatid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getfinaldraftformatlist() 
	{
		$this->writelog("getfinaldraftformatlist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getfinaldraftformatlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
   	/**
	* getfinaldraftmodel
	*
	* This function returns a support data object.
	* The list of possible values are:finaldraftmodelid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $finaldraftmodelid
	*/
	public function getfinaldraftmodel($finaldraftmodelid) 
	{
		$this->writelog("getfinaldraftmodel($finaldraftmodelid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getfinaldraftmodel($finaldraftmodelid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

	/**
	* getfinaldraftmodellist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:finaldraftmodelid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getfinaldraftmodellist() 
	{
		$this->writelog("getfinaldraftmodellist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getfinaldraftmodellist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getsecurityquestion
	*
	* This function returns a support data object.
	* The list of possible values are:securityquestionid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $securityquestionid
	*/
	public function getsecurityquestion($securityquestionid) 
	{
		$this->writelog("getsecurityquestion($securityquestionid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getsecurityquestion($securityquestionid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getsecurityquestionlist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:securityquestionid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getsecurityquestionlist() 
	{
		$this->writelog("getsecurityquestionlist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getsecurityquestionlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
   	/**
	* getinterest
	*
	* This function returns an interest object.
	* The list of possible values are:interestid, interesttypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Interest object
	* 
	* @param	int $interestid
	* @param 	$product
	*/
	public function getinterest($interestid,$product='xs') 
	{
		$this->writelog("getinterest($interestid,$product)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getinterest($interestid,$product);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* getinterestlist
	*
	* This function returns an array of interest objects.
	* The list of possible values are:interestid, interesttypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param $product
	* @return  	array[int]Locker_Interest $var
	* 
	*/
	public function getinterestlist($product='xs') 
	{
		$this->writelog("getinterestlist($product)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getinterestlist($product);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
   	/**
	* getinteresttype
	*
	* This function returns a support data object.
	* The list of possible values are:interesttypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	* @param $product
	* @param	int $interesttypeid
	*/
	public function getinteresttype($interesttypeid,$product='xs') 
	{
		$this->writelog("getinteresttype($interesttypeid,$product)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getinteresttype($interesttypeid,$product);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
		
   	/**
	* getinteresttypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:interesttypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param $product
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getinteresttypelist($product = 'xs') 
	{
		$this->writelog("getinteresttypelist($product)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getinteresttypelist($product);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* gettasktype
	*
	* This function returns an task type object.
	* The list of possible values are:tasktypeid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Task_Type object
	* 
	* @param	int $tasktypeid
	*/
	public function gettasktype($tasktypeid) 
	{
		$this->writelog("gettasktype($tasktypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettasktype($tasktypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		
	
   	/**
	* gettasktypelist
	*
	* This function returns an array of task type objects.
	* The list of possible values are:tasktypeid, title, description, sortpriority
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Task_Type $var
	* 
	*/
	public function gettasktypelist() 
	{
		$this->writelog("gettasktypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettasktypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
   	/**
	* getcitation
	*
	* This function returns a citation object.
	* The list of possible values are:autocite, creationdate, modifieddate, citationtext, pubmediumid, citationsourcetypeid, citationtype, citationtext 
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Citation object
	* 
	* @param int $profileid
	* @param int $citationid
	*/
	public function getcitation($profileid, $citationid) 
	{
		$this->writelog("getcitation($profileid, $citationid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcitation($profileid, $citationid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getcitationlist
	*
	* This function returns an array of citation objects.
	* The list of possible values are:autocite, creationdate, modifieddate, citationtext, pubmediumid, citationsourcetypeid, citationtype, citationtext 
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Citation $var
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	* @param 	int $bibliographyid
	* @param	string $sort
	*/
	public function getcitationlist($profileid, $assignmentid, $bibliographyid, $sort) 
	{
		$this->writelog("getcitationlist($profileid, $assignmentid, $bibliographyid, $sort)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcitationlist($profileid, $assignmentid, $bibliographyid, $sort);
			if($sort){
				usort($response, array("Locker_Client", "cmpString"));
			}
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* deletecitation
	*
	* Delete a citation
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	boolean
	* 	
	* @param	int $profileid
	* @param	int $assignmentid
	* @param	int $citationid
	*/
	public function deletecitation($profileid, $assignmentid, $citationid)
	{			
		$this->writelog("deletecitation($profileid, $assignmentid, $citationid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletecitation($profileid, $assignmentid, $citationid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* deletebibliography
	*
	* Delete a bibliography
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	boolean
	* 
	* @param	int $profileid	
	* @param	int $bibliographyid
	*/
	public function deletebibliography($profileid, $bibliographyid)
	{			
		$this->writelog("deletebibliography($profileid, $bibliographyid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletebibliography($profileid, $bibliographyid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* updatecitation
	*
	* Update a citation.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	boolean
	* 
	* @param	int $profileid
	* @param 	int $citationid
	* @param 	string $citationtext
	* @param 	int $pubmediumid
	* @param 	int $citationcontenttypeid
	*/
	public function updatecitation($profileid, $citationid, $citationtext, $pubmediumid, $citationcontenttypeid)
	{			
		$this->writelog("updatecitation($profileid, $citationid, $citationtext, $pubmediumid, $citationcontenttypeid) \n");
		$retVal = false;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatecitation($profileid, $citationid, $citationtext, $pubmediumid, $citationcontenttypeid);
			$retVal = true;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

 	/**
	* insertcustomcitation
	*
	* Insert a customcitation for a profileid, assignmentid.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int new custom citation id
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param	int $bibliographyid
	* @param 	string $citationtext
	* @param	int $pubmediumid
	* @param 	int $citationsourcetypeid
	*/
	public function insertcustomcitation($profileid, $assignmentid, $bibliographyid, $citationtext, $pubmediumid, $citationsourcetypeid)
	{			
		$this->writelog("insertcustomcitation($profileid, $assignmentid, $bibliographyid, $citationtext, $pubmediumid, $citationsourcetypeid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertcustomcitation($profileid, $assignmentid, $bibliographyid, $citationtext, $pubmediumid, $citationsourcetypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
 	/**
	* insertbibliography
	*
	* Insert a new bibliography.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int new bibliography id
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	*/
	public function insertbibliography($profileid, $assignmentid)
	{			
		$this->writelog("insertbibliography($profileid, $assignmentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertbibliography($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

	
 	/**
	* insertautocitation
	*
	* Insert a auto citation for a profileid, assignmentid.
	*
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	int - new auto citation id
	* 
	* @param	int $profileid
	* @param 	int $assignmentid
	* @param	int $bibliographyid
	* @param 	string $mlacitationtext
	* @param	string $chicagocitationtext
	* @param 	string $apacitationtext
	*/
	public function insertautocitation($profileid, $assignmentid, $bibliographyid, $mlacitationtext, $chicagocitationtext, $apacitationtext)
	{			
		$this->writelog("insertautocitation($profileid, $assignmentid, $bibliographyid, $mlacitationtext, $chicagocitationtext, $apacitationtext) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertautocitation($profileid, $assignmentid, $bibliographyid, $mlacitationtext, $chicagocitationtext, $apacitationtext);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

	/**
	* getrubricanswerlist
	*
	* Get a list of rubric answers for a task id. This function returns an array of Locker_Rubric_Answer objects. 
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Rubric_Answer $var
	* 
	* @param	int $profileid
	* @param	int $taskid
	*/
	public function getrubricanswerlist($profileid, $taskid)
	{			
		$this->writelog("getrubricanswerlist($profileid, $taskid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getrubricanswerlist($profileid, $taskid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
	/**
	* setrubricanswers
	*
	* Sets the rubric answers for a task id.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	int
	* 
	* @param	int $profileid
	* @param	int $taskid
	* @param	array $rubricanswerarray
	*/
	public function setrubricanswers($profileid, $taskid, $rubricanswerarray)
	{			
		$this->writelog("setrubricanswers($profileid, $taskid, $rubricanswerarray) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->setrubricanswers($profileid, $taskid, $rubricanswerarray);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
   	/**
	* getcitationtype
	*
	* This function returns a support data object.
	* The list of possible values are:citationtypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $citationtypeid
	*/
	public function getcitationtype($citationtypeid) 
	{
		$this->writelog("getcitationtype($citationtypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationtype($citationtypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
   	/**
	* getbibliography	
	*
	* This function returns a Locker_Bibliography object.
	* The list of possible values are:profileid, assignmentid, creationdate, modifieddate.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Bibliography object
	* 
	* @param	int $profileid
	* @param	int $bibliographyid
	*/
	public function getbibliography($profileid, $bibliographyid) 
	{
		$this->writelog("getbibliography($profileid, $bibliographyid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getbibliography($profileid, $bibliographyid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
   	/**
	* getbibliographylist	
	*
	* This function returns an array of Locker_Bibliography objects.
	* The list of possible values are:profileid, assignmentid, creationdate, modifieddate.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Bibliography object
	* 
	* @param	int $profileid
	* @param	int $assignmentid
	*/
	public function getbibliographylist($profileid, $assignmentid) 
	{
		$this->writelog("getbibliographylist($profileid, $assignmentid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getbibliographylist($profileid, $assignmentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}			

  	/**
	* getcitationtypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:citationtypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getcitationtypelist() 
	{
		$this->writelog("getcitationtypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationtypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getcitationsourcetype
	*
	* This function returns a support data object.
	* The list of possible values are:citationsourcetypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $citationsourcetypeid
	*/
	public function getcitationsourcetype($citationsourcetypeid) 
	{
		$this->writelog("getcitationsourcetype($citationsourcetypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationsourcetype($citationsourcetypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getcitationsourcetypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:citationsourcetypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getcitationsourcetypelist() 
	{
		$this->writelog("getcitationsourcetypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationsourcetypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getprofiletype
	*
	* This function returns a support data object.
	* The list of possible values are:profiletypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $profiletypeid
	*/
	public function getprofiletype($profiletypeid) 
	{
		$this->writelog("getprofiletype($profiletypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getprofiletype($profiletypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getprofiletypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:profiletypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getprofiletypelist() 
	{
		$this->writelog("getprofiletypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getprofiletypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getassignmenttype
	*
	* This function returns a support data object.
	* The list of possible values are:assignmenttypeid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $assignmenttypeid
	*/
	public function getassignmenttype($assignmenttypeid) 
	{
		$this->writelog("getassignmenttype($assignmenttypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getassignmenttype($assignmenttypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getassignmenttypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:assignmenttypeid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getassignmenttypelist() 
	{
		$this->writelog("getassignmenttypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getassignmenttypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getassignmentstatus
	*
	* This function returns a support data object.
	* The list of possible values are:assignmentstatusid, description.
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object
	* 
	* @param	int $assignmentstatusid
	*/
	public function getassignmentstatus($assignmentstatusid) 
	{
		$this->writelog("getassignmentstatus($assignmentstatusid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getassignmentstatus($assignmentstatusid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getassignmentstatuslist
	*
	* This function returns an array of support data objects.
	* The list of possible values are:assignmentstatusid, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getassignmentstatuslist() 
	{
		$this->writelog("getassignmentstatuslist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getassignmentstatuslist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

   	/**
	* getrubricquestion
	*
	* This function returns a rubric question object.
	* The list of possible values are: rubricquestionid, tasktypeid, questiontext.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	Locker_Rubric_Question object
	* 
	* @param 	int $rubricquestionid
	* 
	*/
	public function getrubricquestion($rubricquestionid) 
	{
		$this->writelog("getrubricquestion($rubricquestionid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getrubricquestion($rubricquestionid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getrubricquestionlist
	*
	* This function returns an array of rubric question objects.
	* The list of possible values are: tasktypeid, rubricquestionid, questiontext.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Rubric_Question $var
	* 
	* @param 	int $tasktypeid
	* 
	*/
	public function getrubricquestionlist($tasktypeid) 
	{
		$this->writelog("getrubricquestionlist($tasktypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getrubricquestionlist($tasktypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* gettooltype
	*
	* This function returns a tool type object.
	* The list of possible values are: tooltypeid, title, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	Locker_Tool_Type object
	* 
	* @param 	int $tooltypeid
	* 
	*/
	public function gettooltype($tooltypeid) 
	{
		$this->writelog("gettooltype($tooltypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettooltype($tooltypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* gettooltypelist
	*
	* This function returns an array of tool type objects.
	* The list of possible values are: tooltypeid, title, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Tool_Type $var
	* 
	* 
	*/
	public function gettooltypelist() 
	{
		$this->writelog("gettooltypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettooltypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getskillbuilder
	*
	* This function returns a skill builder object.
	* The list of possible values are: skillbuilderid, title, description, sortpriority, lessonplanid.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	Locker_Skillbuilder object.
	* 
	* @param 	int $skillbuilderid
	* 
	*/
	public function getskillbuilder($skillbuilderid) 
	{
		$this->writelog("getskillbuilder($skillbuilderid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getskillbuilder($skillbuilderid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* getskillbuilderlist
	*
	* This function returns an array of skill builder objects.
	* The list of possible values are: skillbuilderid, title, description, sortpriority, lessonplanid.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Skillbuilder $var
	* 
	* 
	*/
	public function getskillbuilderlist() 
	{
		$this->writelog("getskillbuilderlist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getskillbuilderlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* gettasktoollist
	*
	* This function returns an array of tool type objects.
	* The list of possible values are: tooltypeid, title, description.
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Tool_Type $var
	* 
	* @param 	int $tasktypeid
	* 
	*/
	public function gettasktoollist($tasktypeid) 
	{
		$this->writelog("gettasktoollist($tasktypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettasktoollist($tasktypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
   	/**
	* gettaskskillbuilderlist
	*
	* This function returns an array of skill builder objects.
	* The list of possible values are: skillbuilderid, title, description, sortpriority, lessonplanid
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Skillbuilder $var
	* 
	* @param 	int $tasktypeid
	* 
	*/
	public function gettaskskillbuilderlist($tasktypeid) 
	{
		$this->writelog("gettaskskillbuilderlist($tasktypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettaskskillbuilderlist($tasktypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getsessionlist
	*
	* This function returns an array of sessions.
	* The list of possible values are: sessionid, description
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	* 
	*/
	public function getsessionlist() 
	{
		$this->writelog("getsessionlist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getsessionlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* gettoolskillbuilderlist
	*
	* This function returns an array of skill builder objects.
	* The list of possible values are: skillbuilderid, title, description, sortpriority, lessonplanid
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Skillbuilder $var
	* 
	* @param 	int $tooltypeid
	* 
	*/
	public function gettoolskillbuilderlist($tooltypeid) 
	{
		$this->writelog("gettoolskillbuilderlist($tooltypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->gettoolskillbuilderlist($tooltypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}		

   	/**
	* getskillbuildertasklist
	*
	* This function returns an array of task objects.
	* The list of possible values are: tasktypeid, title, description, sortpriority 
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Task_Type $var
	* 
	* @param 	int $skillbuilderid
	* 
	*/
	public function getskillbuildertasklist($skillbuilderid) 
	{
		$this->writelog("getskillbuildertasklist($skillbuilderid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getskillbuildertasklist($skillbuilderid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getskillbuildertoollist
	*
	* This function returns an array of tool objects.
	* The list of possible values are: tooltypeid, title, description 
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Tool_Type $var
	* 
	* @param 	int $skillbuilderid
	* 
	*/
	public function getskillbuildertoollist($skillbuilderid) 
	{
		$this->writelog("getskillbuildertoollist($skillbuilderid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getskillbuildertoollist($skillbuilderid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getcitationcontenttype
	*
	* This function returns a citation content type object
	* The list of possible values are: citationcontenttypeid, pubmediumid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Citation_Content_Type object
	* 
	* @param 	int $citationcontenttypeid
	* 
	*/
	public function getcitationcontenttype($citationcontenttypeid) 
	{
		$this->writelog("getcitationcontenttype($citationcontenttypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationcontenttype($citationcontenttypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
   	/**
	* getcitationcontenttypelist
	*
	* This function returns an array of citation content type objects
	* The list of possible values are: citationcontenttypeid, pubmediumid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Citation_Content_Type $var
	* 
	* 
	*/
	public function getcitationcontenttypelist() 
	{
		$this->writelog("getcitationcontenttypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationcontenttypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}
	
   	/**
	* getcitationformatexample
	*
	* This function returns a citation format example object
	* The list of possible values are: citationformatexampleid, citationformat, citationexample
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Citation_Format_Example object
	* 
	* @param 	int $citationtypeid
	* @param 	int $citationcontenttypeid
	*/
	public function getcitationformatexample($citationtypeid, $citationcontenttypeid) 
	{
		$this->writelog("getcitationformatexample($citationtypeid, $citationcontenttypeid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationformatexample($citationtypeid, $citationcontenttypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getcitationformatexamplelist
	*
	* This function returns an array of citation format example objects
	* The list of possible values are: citationformatexampleid, citationtypeid, citationcontenttypeid, citationformat, citationexample
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Citation_Format_Example $var
	* 
	*/
	public function getcitationformatexamplelist() 
	{
		$this->writelog("getcitationformatexamplelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getcitationformatexamplelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getmarketingoption
	*
	* This function returns a support data object.
	* The list of possible values are: marketingprefid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object.
	* 
	* @param 	int $marketingprefid
	*/
	public function getmarketingoption($marketingprefid) 
	{
		$this->writelog("getmarketingoption($marketingprefid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getmarketingoption($marketingprefid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getmarketingoptionlist
	*
	* This function returns an array of support data objects.
	* The list of possible values are: marketingprefid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getmarketingoptionlist() 
	{
		$this->writelog("getmarketingoptionlist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getmarketingoptionlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	

   	/**
	* getpubmediumtype
	*
	* This function returns a support data object.
	* The list of possible values are: pubmediumid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	Locker_Support_Data object.
	* 
	* @param 	int $pubmediumid
	*/
	public function getpubmediumtype($pubmediumid) 
	{
		$this->writelog("getpubmediumtype($pubmediumid)  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getpubmediumtype($pubmediumid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
   	/**
	* getpubmediumtypelist
	*
	* This function returns an array of support data objects.
	* The list of possible values are: pubmediumid, description
	* 
	* @author  	Diane Palmer
	* @access  	public 
	* 
	* @return  	array[int]Locker_Support_Data $var
	* 
	*/
	public function getpubmediumtypelist() 
	{
		$this->writelog("getpubmediumtypelist()  \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getpubmediumtypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
		
	/**
	* getdigitallockerfoldertype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $digitallockerfoldertypeid
	*/
	public function getdigitallockerfoldertype($digitallockerfoldertypeid)
	{			
		$this->writelog("getdigitallockerfoldertype($digitallockerfoldertypeid) \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getdigitallockerfoldertype($digitallockerfoldertypeid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

	/**
	* getglobaltypesdigitallockerfoldertype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $globaltype
	*/
	public function getglobaltypesdigitallockerfoldertype($globaltype)
	{			
		$this->writelog("getglobaltypesdigitallockerfoldertype($globaltype) \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getglobaltypesdigitallockerfoldertype($globaltype);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getdigitallockerfoldertypelist
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getdigitallockerfoldertypelist()
	{		
		$this->writelog("getdigitallockerfoldertypelist() \n");
		$retVal = NULL;
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$response = $this->_client->getdigitallockerfoldertypelist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}	
	
	/**
	* getreadinglevel
	*
	* Returns the reading level for a lexile value.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  int
	* 
	* @param 	int $lexilelevel
	* @param 	string $productid
	* 
	*/
	public function getreadinglevel($lexilelevel, $productid)
	{			
		$this->writelog("getreadinglevel($lexilelevel, $productid) \n");
		$retVal = false;
		try
		{
			
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_SUPPORT_URL']);
			$retVal = $this->_client->getreadinglevel($lexilelevel, $productid);
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		
		return $retVal;
	}

	
		
	/**
	* getnumofusers
	*
	* Get number of users in expert space.  This includes all shards.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	int
	* 
	* @param 	None
	*/
	public function getnumofusers()
	{			
		$this->writelog("getnumofusers() \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnumofusers();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}
	
	/**
	* getnumofuserspershard
	*
	* Get number of users in expert space per shard.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Shard $var
	* 
	* @param 	None
	*/
	public function getnumofuserspershard()
	{			
		$this->writelog("getnumofuserspershard() \n");
		$retVal = array();
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnumofuserspershard();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}
	
	/**
	* getnumofparentspershard
	*
	* Get number of parents in expert space per shard.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Shard $var
	* 
	* @param 	None
	*/
	public function getnumofparentspershard()
	{			
		$this->writelog("getnumofparentspershard() \n");
		$retVal = array();
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnumofparentspershard();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}
	
	/**
	* getnumofelementspershard
	*
	* Get a total number of a certain element in expert space per shard.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Shard $var
	* 
	* @param 	string $elementtype - Either assignment, groups, notecard, citation, task, savedasset
	*/
	public function getnumofelementspershard($elementtype)
	{			
		$this->writelog("getnumofelementspershard($elementtype) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getnumofelementspershard($elementtype);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}		

	/**
	* getshardlist
	*
	* Get a list of shards
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Shard $var
	* 
	* @param 	None
	*/
	public function getshardlist()
	{			

		$this->writelog("getshardlist() \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getshardlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
						
	}	
	
	/**
	* getcompleteshardlist
	*
	* Get a total number of a certain element in expert space per shard.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Shard $var
	* 
	* @param 	None
	*/
	public function getcompleteshardlist()
	{			
		$this->writelog("getcompleteshardlist() \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcompleteshardlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}
	
   	/**
	* getmarketinguserlist
	*
	* This function returns a list of Locker_Profile object that are to receive marketing messages.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Profile $var
	* 
	* @param 	none
	*/
	public function getmarketinguserlist()
	{			
		$this->writelog("getmarketinguserlist() \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getmarketinguserlist();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;
	}

	/**	
	* deletechildren
	*
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param 	string $parentid
	*/
	public function deletechildren($parentid)
	{
		
		$this->writelog("deletechildren($parentid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletechildren($parentid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
		
	}
	
	
	/**	
	* deleteuser
	*
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param 	string $profileid
	*/
	public function deleteuser($profileid)
	{
		$this->writelog("deleteuser($profileid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deleteuser($profileid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
		
	}
	

	/**
	* getactivelessonplan
	*
	* This function returns the active lesson plan.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Lessonplanner object
	* 
	* @param	string $profileid
	* @param	string $classid
	* @param	string $weekslpid
	* @param	string $language
	*/
	public function getactivelessonplan($profileid, $classid, $weekslpid, $language)
	{
		$this->writelog("getactivelessonplan($profileid, $classid, $weekslpid, $language) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getactivelessonplan($profileid, $classid, $weekslpid, $language);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}	
	

	/**
	* getcustomlessonplanlist
	*
	* This function returns a list of customlessonplans.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Lessonplanner object
	* 
	* @param	string $profileid
	* @param	string $weekslpid
	* @param	string $language
	*/
	public function getcustomlessonplanlist($profileid, $weekslpid, $language)
	{
		$this->writelog("getcustomlessonplanlist($profileid, $weekslpid, $language) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcustomlessonplanlist($profileid, $weekslpid, $language);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		

	}

	/**
	* getcustomlessonplan
	*
	* This function returns the lesson plan.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Lessonplanner object
	* 
	* @param	string $profileid
	* @param	string $lessonplannerid
	*/
	public function getcustomlessonplan($profileid, $lessonplannerid)
	{
		$this->writelog("getcustomlessonplan($profileid, $lessonplannerid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcustomlessonplan($profileid, $lessonplannerid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}

	/**	
	* syncparentchildren
	*
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param 	none
	*/
	public function syncparentchildren()
	{
		$this->writelog("syncparentchildren() \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->syncparentchildren();
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
	
	/**
	* get_seciresults
	*
	* Get the SECI results for a given student.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Seci_Domain_Results $var
	* 
	* @param 	string $teacher_profileid
	* @param 	string $student_profileid
	* @param 	string $lang
	*/
	public function get_seciresults($teacher_profileid,$student_profileid,$lang)
	{
		$this->writelog("get_seciresults($teacher_profileid,$student_profileid,$lang) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->get_seciresults($teacher_profileid,$student_profileid,$lang);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}		
	
	/**
	* get_secidomainresults
	*
	* Get the SECI results for a given student.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Seci_Domain_Results $var
	* 
	* @param 	string $teacher_profileid
	* @param 	string $classid
	* @param 	string $domain_id
	* @param 	string $lang
	*/
	public function get_secidomainresults($teacher_profileid, $classid, $domain_id, $lang)
	{
		$this->writelog("get_secidomainresults($teacher_profileid, $classid, $domain_id, $lang) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->get_secidomainresults($teacher_profileid, $classid, $domain_id, $lang);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;			
	}
	
	/**
	* get_allstudentsseciresults
	*
	* Get the SECI results for all students.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Profile $var
	* 
	* @param 	string $profileid
	* @param 	string $classid
	* @param 	string $lang
	*/
	public function get_allstudentsseciresults($profileid,$classid,$lang)
	{

		$this->writelog("get_allstudentsseciresults($profileid,$classid,$lang) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->get_allstudentsseciresults($profileid,$classid,$lang);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
			
	/**
	* update_lessonplan
	*
	* Update a custom lesson plan for 1 day
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $profileid
	* @param 	string $lessonplannerobj
	*/
	public function update_lessonplan($profileid, $lessonplannerobj)
	{
		$this->writelog("update_lessonplan($profileid, $lessonplannerobj) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->update_lessonplan($profileid, $lessonplannerobj);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
	
	/**
	* getlessonplannernotes
	*
	* This function returns the lesson planner notes.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_LessonPlan_Notes object
	* 
	* @param	string $profileid
	* @param	string $lessonplannerid
	* @param	string $dayid
	*/
	public function getlessonplannernotes($profileid, $lessonplannerid, $dayid)
	{
		$this->writelog("getlessonplannernotes($profileid, $lessonplannerid, $dayid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getlessonplannernotes($profileid, $lessonplannerid, $dayid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}	

	/**
	* insertlessonplannernotes
	*
	* This function inserts the lesson planner note.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_LessonPlan_Notes object
	* 
	* @param	string $profileid
	* @param	string $classid
	* @param	string $weekslpid
	* @param	string $dayid
	* @param	string $lessonplannerid
	* @param	string $notetext
	*/
	public function insertlessonplannernotes($profileid, $classid, $weekslpid, $dayid, $lessonplannerid, $notetext)
	{
		$this->writelog("insertlessonplannernotes($profileid, $classid, $weekslpid, $dayid, $lessonplannerid, $notetext) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertlessonplannernotes($profileid, $classid, $weekslpid, $dayid, $lessonplannerid, $notetext);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}	

	/**
	* updatelessonplannernotes
	*
	* This function inserts the lesson planner note.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_LessonPlan_Notes object
	* 
	* @param	string $profileid
	* @param	string $lessonplannernoteid
	* @param	string $notetext
	*/
	public function updatelessonplannernotes($profileid, $lessonplannernoteid, $notetext)
	{
		$this->writelog("updatelessonplannernotes($profileid, $lessonplannernoteid, $notetext) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatelessonplannernotes($profileid, $lessonplannernoteid, $notetext);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
	
	/**
	* hide_textfromlearningcenter  
	*
	* Hide text from learning center.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	int
	* 
	* @param 	string $profileid
	* @param 	string $lessonplannerid
	* @param 	string $learningcenterweekid
	*/
	public function hide_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid)
	{			
		$this->writelog("hide_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->hide_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}

	/**
	* show_textfromlearningcenter  
	*
	* Show text from learning center.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	int
	* 
	* @param 	string $profileid
	* @param 	string $lessonplannerid
	* @param 	string $learningcenterweekid
	*/
	public function show_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid)
	{			
		$this->writelog("show_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->show_textfromlearningcenter($profileid, $lessonplannerid, $learningcenterweekid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}
	
	/**
	* get_deletesfromlearningcenter  
	*
	* Gets Deleted text from learning center.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Learning_Center_Deletes $var
	* 
	* @param 	string $profileid
	* @param 	string $lessonplannerid
	*/
	public function get_deletesfromlearningcenter($profileid, $lessonplannerid)
	{			
		$this->writelog("get_deletesfromlearningcenter($profileid, $lessonplannerid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->get_deletesfromlearningcenter($profileid, $lessonplannerid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}

	/**
	* getuserpass  
	*
	* Gets username and password for a profileid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	Locker_Profile object
	* 
	* @param 	string $profileid
	*/
	public function getuserpass($profileid)
	{			
		$this->writelog("getuserpass($profileid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getuserpass($profileid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;		
	}
				
	/**
	* getcustomdayblock
	*
	* This function returns the custom day block.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Dayblock $var
	* 
	* @param	string $profileid
	* @param	string $lessonplannerid
	* @param	array $learning_block_id_array
	* @param	string $dayid
	*/
	public function getcustomdayblock($profileid, $lessonplannerid, $learning_block_id_array, $dayid)
	{	
		$this->writelog("getcustomdayblock($profileid, $lessonplannerid, $learning_block_id_array, $dayid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getcustomdayblock($profileid, $lessonplannerid, $learning_block_id_array, $dayid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
				
	}

    /**
	* getallassessments
	*
	* Return all the assessments for a user. Returns a list of Locker_Assessment_Results object.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Assessment object
	* 
	* @param	string $profileid
	* @param 	string $productid
	*/
	public function getallassessments($profileid,$productid)
	{			
		$this->writelog("getallassessments($profileid,$productid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getallassessments($profileid,$productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}    
	
	
    /**
	* getassessment
	*
	* Return the assessment for a user by question. Returns a Locker_Assessment_Results object
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Assessment object
	* 
	* @param	string $profileid
	* @param	string $questionid
	* @param	string $parentslpid
	* @param	string $productid
	* 
	*/
	public function getassessment($profileid, $questionid, $parentslpid, $productid)
	{
		$this->writelog("getassessment($profileid, $questionid, $parentslpid, $productid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassessment($profileid, $questionid, $parentslpid, $productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;				
	}
	
	
    /**
	* getassessmentsbyparent
	*
	* Return all the assessments for a user by parent slp. Returns a list of Locker_Assessment_Results object
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Assessment object
	* 
	* @param	string $profileid
	* @param	string $productid
	* @param	string $parentslpid
	* 
	*/
	public function getassessmentsbyparent($profileid, $productid, $parentslpid)
	{
		$this->writelog("getassessmentsbyparent($profileid, $productid, $parentslpid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassessmentsbyparent($profileid, $productid, $parentslpid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
		
	
    /**
	* insertassessment
	*
	* Insert a assessment and return the resultsid.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string $profileid
	* @param	string $questionid
	* @param	string $parentslpid
	* @param	string $parentuidid
	* @param	string $answer
	* @param	string $iscorrect
	* @param	string $productid
	* 
	*/
	public function insertassessment($profileid, $questionid, $parentslpid, $parentuidid, $answer, $iscorrect, $productid)
	{
		$this->writelog("insertassessment($profileid, $questionid, $parentslpid, $parentuidid, $answer, $iscorrect, $productid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertassessment($profileid, $questionid, $parentslpid, $parentuidid, $answer, $iscorrect, $productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;				
	}

    /**
	* getassessmentscores
	*
	* Return the assessment score for an assessment for a user.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[string]
	* 
	* @param	string $profileid
	* @param 	string $productid
	* @param 	array $questions
	*/
	public function getassessmentscores($profileid,$questions,$productid)
	{			
		$this->writelog("getassessmentscores($profileid,$questions,$productid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getassessmentscores($profileid,$questions,$productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}  	

	/**
	* getthinktankresult
	*
	* Return the think tank results for a user.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_ThinkTank object
	* 
	* @param	string 	$profileid
	* @param 	string 	$topic_id
	* @param 	string 	$activity_id
	*/
	public function getthinktankresult($profileid, $topic_id, $activity_id)
	{			
		$this->writelog("getthinktankresult($profileid, $topic_id, $activity_id) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getthinktankresult($profileid, $topic_id, $activity_id);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
	
	/**
	* getthinktankresults
	*
	* Return the think tank results for ALL users for that think tank activity.
	* 
	* @author  Dee Palmer
	* @access  public 
	* 
	* @return  Locker_Results object
	* 
	* @param	string 	$profileid
	* @param 	string 	$topic_id
	* @param 	string 	$activity_id
	*/
	public function getthinktankresults($profileid, $topic_id, $activity_id)
	{			
		$this->writelog("getthinktankresults($profileid, $topic_id, $activity_id) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getthinktankresults($profileid, $topic_id, $activity_id);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}	
	
    /**
	* insertthinktankresult
	*
	* Insert a thinktankresult and return the thinktankresultsid.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string 	$profileid
	* @param 	string 	$topic_id
	* @param 	string 	$activity_id
	* @param 	string 	$activity_type
	* @param	string 	$answer
	* 
	*/
	public function insertthinktankresult($profileid, $topic_id, $activity_id, $activity_type, $answer)
	{
		$this->writelog("insertthinktankresult($profileid, $topic_id, $activity_id, $activity_type, $answer) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->insertthinktankresult($profileid, $topic_id, $activity_id, $activity_type, $answer);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
		
    /**
	* updatethinktankresult
	*
	* Updates a thinktankresult.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string 	$profileid
	* @param 	string 	$topic_id
	* @param 	string 	$activity_id
	* @param	string 	$answer
	* 
	*/
	public function updatethinktankresult($profileid, $topic_id, $activity_id, $answer)
	{
		$this->writelog("updatethinktankresult($profileid, $topic_id, $activity_id, $answer) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->updatethinktankresult($profileid, $topic_id, $activity_id, $answer);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}	
	
    /**
	* deletethinktankresult
	*
	* Deletes a thinktankresult.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string 	$profileid
	* @param 	string 	$topic_id
	* @param 	string 	$activity_id
	* 
	*/
	public function deletethinktankresult($profileid, $topic_id, $activity_id)
	{
		$this->writelog("deletethinktankresult($profileid, $topic_id, $activity_id) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->deletethinktankresult($profileid, $topic_id, $activity_id);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;	
	}
	
	/**
	* getusersbyproduct
	*
	* This function returns an array of Locker_IAuthProfile object for a given productid. 
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_IAuthProfile $var
	* @param  	string $productid
	* 
	*/
	public function getusersbyproduct($productid)
	{
		$this->writelog("getusersbyproduct($productid) \n");
		$retVal = '';
		try
		{
			//Check memcache
			// initialize class member variables
			$this->_client = new SoapClient($_SERVER['SOAP_CLIENT_URL']);
			$response = $this->_client->getusersbyproduct($productid);
			$retVal = $response;						
		}
		catch (SoapFault $fault) 
		{
			$retVal = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
		}
		return $retVal;			
	}
	
	/**
	* writelog
	*
	* This function writes text to a logfile.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param  string $logtxt
	*
	*/
	private function writelog($logtxt)
	{			
		$filename = $_SERVER['LOCKER_LOG_FILE'];
		if(!empty($filename))
		{
		require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");
		//COOKIE STUFF
		//$cookiereader = new Cookie_Reader('bdport');
		//$profileid = $cookiereader->getprofileid();
		
			//$findme   = '86.800057619';
			//$pos = strpos($logtxt, $findme);
			//if (($pos === false))
			//if($profileid != $findme)
			//if($profileid == $findme)
			if(true)
			{
				$today = date("j/F/Y:H:i:s");
				$line = "[$today] ".$_SERVER["REQUEST_URI"]." --> $logtxt";			
				// Let's make sure the file exists and is writable first.
				if (is_writable($filename)) 
				{
				
				    // In our example we're opening $filename in append mode.
				    // The file pointer is at the bottom of the file hence
				    // that's where $somecontent will go when we fwrite() it.
				    if (!$handle = fopen($filename, 'a')) 
				    {
				         //echo "Cannot open file ($filename)";
				         //exit;
				    }
				
				    // Write $somecontent to our opened file.
				    if (fwrite($handle, $line) === FALSE) 
				    {
				        //echo "Cannot write to file ($filename)";
				        //exit;
				    }
				    fclose($handle);
				
				} 
				else 
				{
				    //echo "The file $filename is not writable";
				}	
			}
		}
	}	
}//End Locker_Client Class
?>