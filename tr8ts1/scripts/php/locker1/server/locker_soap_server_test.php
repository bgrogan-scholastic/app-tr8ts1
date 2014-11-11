<?php
require($_SERVER["LOCKER1_CONFIG"]."/locker_stored_proc_version_ids.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_task.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_assignment.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_profile.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_notecard.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_group.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_citation.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_assignment_stats.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_bibliography.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_saved_asset.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_saved_weblink.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_rubric_answer.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_line.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_outline.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_au.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_iauthprofile.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_db_connect.php");
require_once('DB.php');

class Locker_Server
{
	private $_lockerdbConn;
	private $_iauthDBConn;
	private $_authDBConn;
	
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

		
		$this->_iauthDBConn = new mysqli($_SERVER['IAUTH_SERVERNAME'], $_SERVER['IAUTH_USERNAME'], $_SERVER['IAUTH_PASSWORD'], $_SERVER['IAUTH_DATABASE_NAME']) ;
		if (mysqli_connect_errno()) 
		{
			throw new SoapFault("Server","Database Connection Error on iauth.");
		}
		/**
		$this->_authDBConn = new mysqli($_SERVER['AUTH_SERVERNAME'], $_SERVER['AUTH_USERNAME'], $_SERVER['AUTH_PASSWORD'], $_SERVER['AUTH_DATABASE_NAME']) ;

		if (mysqli_connect_errno()) 
		{
			throw new SoapFault("Server","Database Connection Error on auth.");
		}
		*/
	}
	
	/**
	* Destructor
	*
	* This method cleans up the object on destory.
	*
	* @author  John Palmer
	* @access  public 
	*/
	function __destruct() 
	{
    	if($this->_lockerdbConn != null)
    	{
			$this->_lockerdbConn->close();
    	}
    	
    	if($this->_iauthDBConn != null)
    	{
    		$this->_iauthDBConn->close();
    	}
    	//$this->_authDBConn->close();
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
	* @param	string $profileid
	* @param 	string $assignmentid
	*/
	public function getassignmentstats($profileid,$assignmentid)
	{			
		$profileid = $this->createDbConnection($profileid);
		$percomp = $this->getassignmentpercentcomplete($profileid, $assignmentid);
		$daysleft = $this->getassignmentdaysleft($profileid, $assignmentid);
		$currtask = $this->getcurrenttask($profileid, $assignmentid);
		
		//Create Assignment Object
		$assignmentobj = new Locker_Assignment_Stats($profileid,$assignmentid,$percomp,$daysleft,$currtask);
		return $assignmentobj;
	}
	    
   	/**
	* getassignment
	*
	* This function returns an assignment object.
	* The assignment values that are returned are: assignmenttype,productid,title,active,creationdate.
	* It also returns values from the assignmentdetails table if the user data for that value.
	* The list of possible values are:citationsourceid,citationtypeid,finaldraftformatid,lengthoffinaldraft,numofsources,othercitationsource,paraphrase,status.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Assignment object
	* 
	* @param 	string $profileid
	* @param 	string $assignmentid
	*/
	public function getassignment($profileid, $assignmentid)
	{			
		$this->createDbConnection($profileid);
		
		$assignstatement = $this->_lockerdbConn->prepare("CALL ".GET_ASSIGNMENT."(?)");
		$assignstatement->bind_param("s", $assignmentid);
		$assignstatement->execute();			
		$assignmentrow = $this->getresult($assignstatement);
		
		$bibstatement = $this->_lockerdbConn->prepare("CALL ".GET_BIBLIOGRAPHY_LIST."(?,?)");
		$bibstatement->bind_param("is", $assignmentrow[0]['profileid'], $assignmentid);
		$bibstatement->execute();	
		$row = $this->getresult($bibstatement);		
		
		$outlinestatement = $this->_lockerdbConn->prepare("CALL ".GET_OUTLINE_LIST."(?,?)");
		$outlinestatement->bind_param("is", $assignmentrow[0]['profileid'], $assignmentid);
		$outlinestatement->execute();	
		$outlinerow = $this->getresult($outlinestatement);				
		
		//AssignmentVars
		$citationsourcearray = array();
		$citationsourcelist = NULL;
		$finaldraftformatid = NULL;
		$lengthoffinaldraft = NULL;
		$numofsources = NULL;
		$othercitationsource = NULL;
		$paraphrase = NULL;
	
		list($citationsourcelist, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $othercitationsource, $paraphrase) = explode("|", $assignmentrow[0]['assignmentvalue']);
		//$citationsourcearray = explode(",", $citationsourcelist);

		if(!empty($citationsourcelist))
		{
			$citationsourcearray = explode(",", $citationsourcelist);
		}		

		//Add stats for assignment

		$percomp = $this->getassignmentpercentcomplete($profileid, $assignmentid);
		$daysleft = $this->getassignmentdaysleft($profileid, $assignmentid);
		$currtask = $this->getcurrenttask($profileid, $assignmentid);

		list($year, $month, $day) = split("-", $assignmentrow[0]['duedate']);
		$assignmentrow[0]['duedate'] = "$month/$day/$year";

		//Create Assignment Object
		$assignmentobj = new Locker_Assignment($assignmentrow[0]['profileid'], $assignmentid, $assignmentrow[0]['productid'],
												$assignmentrow[0]['assignmenttype'], $assignmentrow[0]['title'], $assignmentrow[0]['duedate'], $assignmentrow[0]['completiondate'],
												$assignmentrow[0]['active'], $assignmentrow[0]['creationdate'], $paraphrase, $finaldraftformatid, $lengthoffinaldraft,
												$numofsources, $assignmentrow[0]['status'], $othercitationsource, $assignmentrow[0]['citationtypeid'],
												$citationsourcearray,NULL,NULL,NULL,NULL,$outlinerow[0]['outlineid'],$row[0]['bibliographyid'],$percomp,$daysleft,$currtask);
		return $assignmentobj;												
		
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
	* 
	*/
	public function validatelogin($username, $password)
	{			
		
		//make sure the username and password is lowercase
		$username = strtolower($username);
		$password = strtolower($password);
		
		$retval = new Locker_IAuthProfile(0,null,null);			
		
		$auarray = array();
		
		//Check to make sure username and password is valid.  Return the users recipient_id.	
		$validatestatement = $this->_iauthDBConn->prepare("CALL ".VALIDATE_LOGIN."(?,?)");
		$validatestatement->bind_param("ss", $username, $password);
		$validatestatement->execute();	
		$user_row = $this->getresult($validatestatement);

		if(count($user_row) > 0)
		{	
			//CREATE LOCKER DB CONNECTION
			$this->createDbConnection($user_row[0]['profile_id'].'.'.$user_row[0]['parent_id']);
		
			//Return all the au’s for a user.
			$getaustatement = $this->_iauthDBConn->prepare("CALL ".GET_AULIST."(?)");
			$getaustatement->bind_param("s", $user_row[0]['recipient_id']);
			$getaustatement->execute();	
			$auid_row = $this->getresult($getaustatement);				
			
			//LOOP Through all the AU's		
			for($i = 0; $i<count($auid_row); $i++)
			{				
				$prefarray = array();
				$prodarray = array();

				//Return all the users prefs for each AU
				$getaupstatement = $this->_iauthDBConn->prepare("CALL ".GET_AUPREFLIST."(?)");
				$getaupstatement->bind_param("s", $auid_row[$i]['au_id']);
				$getaupstatement->execute();	
				$pref_row = $this->getresult($getaupstatement);		
							
				for($j = 0; $j<count($pref_row); $j++)
				{
					$prefarray[$pref_row[$j]['pref_code']] = $pref_row[$j]['pref_value'];
				}

				//Return all the users products for each AU	
				$getauprodstatement = $this->_iauthDBConn->prepare("CALL ".GET_AUPRODLIST."(?)");
				$getauprodstatement->bind_param("s", $auid_row[$i]['au_id']);
				$getauprodstatement->execute();	
				$prod_row = $this->getresult($getauprodstatement);
								
				for($j = 0; $j<count($prod_row); $j++)
				{
					$prodarray[] = $prod_row[$j]['product_code'];	
				}			
				
				//Create AU
				$auobj = new Locker_AU($auid_row[$i]['au_id'],$prodarray,$prefarray);
				
				//AU TO ARRAY
				$auarray[] = $auobj;				
			}
					

			$getprofcookiestatement = $this->_lockerdbConn->prepare("CALL ".GET_PROFILECOOKIEINFO."(?, ?)");
			$testvar = 'xs';
			
			echo 'test'.$user_row[0]['profile_id'];
			$getprofcookiestatement->bind_param("is", $user_row[0]['profile_id'],$testvar);
			$getprofcookiestatement->execute();	
			$profcookie_row = $this->getresult($getprofcookiestatement);			
			
				
			//CREATE PROF COOKIE
			//Check to see if we should use nickname or username
			$name = $profcookie_row[0]['nickname'];
			if(empty($name))
			{
				$name = $username;				
			}
			$name = urlencode($name);
			
			$getbibliststatement = $this->_lockerdbConn->prepare("CALL ".GET_BIBLIOGRAPHY_LIST."(?, ?)");
			$getbibliststatement->bind_param("is", $profcookie_row[0]['profileid'], $profcookie_row[0]['currentassignmentid']);
			$getbibliststatement->execute();	
			$bibrow = $this->getresult($getbibliststatement);				
			
			$getoutlineliststatement = $this->_lockerdbConn->prepare("CALL ".GET_OUTLINE_LIST."(?, ?)");
			$getoutlineliststatement->bind_param("is", $profcookie_row[0]['profileid'], $profcookie_row[0]['currentassignmentid']);
			$getoutlineliststatement->execute();	
			$outlinerow = $this->getresult($getoutlineliststatement);				
							
			if($profcookie_row[0]['lexilerange'] == 0)
			{
				$profcookie_row[0]['reading_level'] = 2;
			}
			$cookiearray['prof_values'] = 'profileid>'.$profcookie_row[0]['profileid'].'.'.$user_row[0]['parent_id'].'|lexile>'.$profcookie_row[0]['lexilerange'].'|proftype>'.$profcookie_row[0]['profiletype'].'|name>'.$name;
			$cookiearray['prof_values_xs'] = 'currassgn>'.$profcookie_row[0]['currentassignmentid'].'|readlvl>'.$profcookie_row[0]['reading_level'].'|outlineid>'.$outlinerow[0]['outlineid'].'|bibliographyid>'.$bibrow[0]['bibliographyid'];
			$profilecookiearray = $cookiearray;		
			
			$retval = new Locker_IAuthProfile(true,$auarray,$profilecookiearray);
		}		
		
		return $retval;
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
		$retVal = -1;
		
		//make sure the username and securityanswer is lowercase
		$username = strtolower($username);
		$securityanswer = strtolower($securityanswer);
		
	
		//Get profileid from username
		$profilestatement = $this->_iauthDBConn->prepare("CALL ".GET_PROFILEID."(?)");
		$profilestatement->bind_param("s", $username);
		$profilestatement->execute();	
		$user_row = $this->getresult($profilestatement);				
	
		if(!empty($user_row[0]['profile_id']))
		{
			$profileid = $this->createDbConnection($user_row[0]['profile_id'].'.'.$user_row[0]['parent_id']);
			
			//validate validate security question
			$secstatement = $this->_lockerdbConn->prepare("CALL ".VALIDATE_SECURITYQUESTION."(?, ?, ?)");
			$secstatement->bind_param("iis", $user_row[0]['profile_id'], $securityquestionid, $securityanswer);
			$secstatement->execute();	
			$count_row = $this->getresult($secstatement);			
			
			if($count_row[0]['count'] > 0)
			{
				$retVal = $user_row[0]['profile_id'];	
			}
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
		//make sure the username and password is lowercase
		$username = strtolower($username);
		$password = strtolower($password);
		
		//Get profileid from username
		$passwordstatement = $this->_iauthDBConn->prepare("CALL ".UPDATE_PASSWORD."(?, ?)");
		$passwordstatement->bind_param("ss", $username, $password);
		$passwordstatement->execute();	
		

		return 1;
	}

	/**
	* getlogininfo
	*
	* Returns a username and password for an email address.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  array[int]Locker_Profile $var
	* 
	* @param 	string $emailaddress
	* @param 	string $parent_auid	
	* 
	*/
	public function getlogininfo($emailaddress, $parent_auid)
	{			
		$emailaddress = strtolower($emailaddress);
		$retval = array();

		//FIND THE PARENT ID
		$parentstatement = $this->_iauthDBConn->prepare("CALL ".GET_PARENTDETAILS."(?)");
		$parentstatement->bind_param("s", $parent_auid);
		$parentstatement->execute();	
		$parent_row = $this->getresult($parentstatement);			

//		return "<$parent_auid>1.".$parent_row[0]['recipient_id'];
		//SETUP LOCKER DB CONNECTION!!
		//THE PROFILE ID DOESNT MATTER SO PASS ANYTHING!!!
		$this->createDbConnection('1.'.$parent_row[0]['recipient_id']);
			
		//get profile id
		$emailstatement = $this->_lockerdbConn->prepare("CALL ".GET_PROFILEIDFROMEMAIL."(?)");
		$emailstatement->bind_param("s", $emailaddress);
		$emailstatement->execute();	
		$email_row = $this->getresult($emailstatement);			

		for ($i = 0; $i<count($email_row); $i++)
		{			
			//Get profileid from username	
			$userstatement = $this->_iauthDBConn->prepare("CALL ".GET_LOGININFO."(?)");
			$userstatement->bind_param("i", $email_row[$i]['profileid']);
			$userstatement->execute();	
			$user_row = $this->getresult($userstatement);	
		

			//Create Profile Object
			$profileobj = new Locker_Profile($email_row[$i]['profileid'],$user_row[0]['user_id'],$user_row[0]['user_password']);		
			$retval[] = $profileobj;
		}
			
		return $retval;
	}
		
   	/**
	* getprofile
	*
	* This function returns a Locker_Profile object.
	* The assignment values that are returned are: 
	* 
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Profile object
	* 
	* @param 	string $profileid
	*/
	public function getprofile($profileid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$profilestatement = $this->_lockerdbConn->prepare("CALL ".GET_PROFILE."(?)");
		$profilestatement->bind_param("i", $profileid);
		$profilestatement->execute();	
		$profilerow = $this->getresult($profilestatement);			
		
		//AssignmentVars
		$emailaddress = NULL;
		$gradelist = NULL;
		$interestlist = NULL;
		$marketingpreflist = NULL;
		$interestarray = array();
		$gradearray = array();
		$marketingprefarray = array();
		
		list($emailaddress, $gradelist, $interestlist, $marketingpreflist) = explode("|", $profilerow[0]['profilevalue']);
		if(!empty($interestlist))
		{
			$interestarray = explode(",", $interestlist);
		}
		if(!empty($gradearray))
		{
			$gradearray = explode(",", $gradelist);
		}
		if(!empty($marketingprefarray))
		{
			$marketingprefarray = explode(",", $marketingpreflist);
		}			
				
		//Create Profile Object

		$profileobj = new Locker_Profile($profileid,'','',$profilerow[0]['productid'], $profilerow[0]['nickname'], $profilerow[0]['securityquestionid'], $profilerow[0]['securityanswer'], $profilerow[0]['lastlogindate'],
					$profilerow[0]['active'], $profilerow[0]['creationdate'], $emailaddress,$profilerow[0]['lexilerange'], $profilerow[0]['profiletype'], 
					$profilerow[0]['currentassignmentid'],$gradearray,$interestarray,$marketingprefarray);
		return $profileobj;
	}	
	
   	/**
	* getuserlist
	*
	* This function returns an array of Locker_Profile object for a given parentid. 
	* 
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @param 	string $parentid
	* 
	* @return  	array[int]Locker_IAuthProfile $var
	* 
	*/
	public function getuserlist($parentid)
	{			
		$userliststatement = $this->_iauthDBConn->prepare("CALL ".GET_USERLISTBYPARENT."(?)");
		$userliststatement->bind_param("s", $parentid);
		$userliststatement->execute();	
		$userlist = $this->getresult($userliststatement);			
		
		$retval = array();
		
		for ($i = 0; $i<count($userlist); $i++)
		{	
			
			//Create Profile Object
			$profileobj = new Locker_IAuthProfile('','','',$userlist[$i]['profile_id'].'.'.$parentid,$userlist[$i]['user_id'],$userlist[$i]['recipient_id'],$userlist[$i]['user_password'],$parentid);
			$retval[] = $profileobj;	
		}
	
		return $retval;
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
		
		//NEED TO ADD % before we pass to Stored Function
		
		$searchterm = "%".$searchterm."%";
		$userliststatement = $this->_iauthDBConn->prepare("CALL ".SEARCH_USERLIST."(?)");
		$userliststatement->bind_param("s", $searchterm);
		$userliststatement->execute();	
		$userlist = $this->getresult($userliststatement);			
		
		$retval = array();
		
		for ($i = 0; $i<count($userlist); $i++)
		{	
			//Create Profile Object
			$profileobj = new Locker_IAuthProfile('','','',$userlist[$i]['profile_id'],$userlist[$i]['user_id'],$userlist[$i]['recipient_id'],$userlist[$i]['user_password'],$userlist[$i]['parent_id']);
			$retval[] = $profileobj;	
		}
	
		return $retval;
	}	
	
	/**
	* getassignmentlist
	*
	* Get a list of assignments. This function returns an array of assignment objects. 
	* The assignment values that are returned are: assignmentid, title, assignmenttype, duedate, completiondate 
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Assignment $var
	* 
	* @param	string $profileid
	* @param 	int $productid
	* @param 	int $active
	* @param 	string $sort
	*/
	public function getassignmentlist($profileid, $productid, $active, $sort)
	{			
		$profileid = $this->createDbConnection($profileid);	
		$retval = array();
		
		$assignmentstatement = $this->_lockerdbConn->prepare("CALL ".GET_ASSIGNMENT_LIST."(?, ?, ?)");
		$assignmentstatement->bind_param("isi", $profileid, $productid, $active);
		$assignmentstatement->execute();	
		$assignmentlistrow = $this->getresult($assignmentstatement);				
	
		
		$currassignment = $this->getcurrentassignment($profileid, $productid);
		$percomp = $this->getassignmentpercentcomplete($profileid, $currassignment->getassignmentid());
		$daysleft = $this->getassignmentdaysleft($profileid, $currassignment->getassignmentid());
		$currtask = $this->getcurrenttask($profileid, $currassignment->getassignmentid());
	
		for ($i = 0; $i<count($assignmentlistrow); $i++)
		{
			
			$bibstatement = $this->_lockerdbConn->prepare("CALL ".GET_BIBLIOGRAPHY_LIST."(?, ?)");
			$bibstatement->bind_param("is", $profileid, $assignmentlistrow[$i]['assignmentid']);
			$bibstatement->execute();	
			$bibrow = $this->getresult($bibstatement);				
			
			$outlinestatement = $this->_lockerdbConn->prepare("CALL ".GET_OUTLINE_LIST."(?, ?)");
			$outlinestatement->bind_param("is", $profileid, $assignmentlistrow[$i]['assignmentid']);
			$outlinestatement->execute();	
			$outlinerow = $this->getresult($outlinestatement);				
						
			//AssignmentVars
			$citationsourcearray = NULL;
			$citationsourcelist = NULL;
			$finaldraftformatid = NULL;
			$lengthoffinaldraft = NULL;
			$numofsources = NULL;
			$othercitationsource = NULL;
			$paraphrase = NULL;
			list($citationsourcelist, $finaldraftformatid, $lengthoffinaldraft, $numofsources, $othercitationsource, $paraphrase) = explode("|", $assignmentlistrow[$i]['assignmentvalue']);
			$citationsourcearray = explode(",", $citationsourcelist);		
			
			list($year, $month, $day) = split("-", $assignmentlistrow[$i]['duedate']);
			$assignmentlistrow[$i]['duedate'] = "$month/$day/$year";
			
			if($currassignment->getassignmentid() == $assignmentlistrow[$i]['assignmentid'])
			{
				$assignmentlistobj = new Locker_Assignment($profileid, $assignmentlistrow[$i]['assignmentid'], $productid, $assignmentlistrow[$i]['assignmenttype'],
												$assignmentlistrow[$i]['title'], $assignmentlistrow[$i]['duedate'], $assignmentlistrow[$i]['completiondate'],
												$active,$assignmentlistrow[$i]['creationdate'], $paraphrase, $finaldraftformatid, $lengthoffinaldraft,
												$numofsources, $assignmentlistrow[$i]['status'], $othercitationsource, $assignmentlistrow[$i]['citationtypeid'],
												$citationsourcearray,NULL,NULL,NULL,NULL,$outlinerow[0]['outlineid'],$bibrow[0]['bibliographyid'],$percomp,$daysleft,$currtask);
			}
			else 
			{
				$assignmentlistobj = new Locker_Assignment($profileid, $assignmentlistrow[$i]['assignmentid'], $productid, $assignmentlistrow[$i]['assignmenttype'],
												$assignmentlistrow[$i]['title'], $assignmentlistrow[$i]['duedate'], $assignmentlistrow[$i]['completiondate'],
												$active,$assignmentlistrow[$i]['creationdate'], $paraphrase, $finaldraftformatid, $lengthoffinaldraft,
												$numofsources, $assignmentlistrow[$i]['status'], $othercitationsource, $assignmentlistrow[$i]['citationtypeid'],
												$citationsourcearray,NULL,NULL,NULL,NULL,$outlinerow[0]['outlineid'],$bibrow[0]['bibliographyid']);
			}
			
			$assignmentlistobj->setsort($sort);
			$retval[] = $assignmentlistobj;	
		}
	
		return $retval;
	}	
	
   	/**
	* getcurrentdate
	*
	* This function returns the current date.
	* NOTE: In order to get this function to work i had to hard code in a profileid.  This needs to be looked at later.
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	*/
	public function getcurrentdate()
	{			

		$profileid = $this->createDbConnection('1.6002370900');	
		
		$timestatement = $this->_lockerdbConn->prepare("CALL ".GET_CURRENTDATETIME."()");
		$timestatement->execute();	
		$timerow = $this->getresult($timestatement);	
					
		return $timerow[0]['currentDate'];
	}
	
   	/**
	* getassignmentpercentcomplete
	*
	* This function returns the percentage of the assignment that is complete for a given profileid and assignmentid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* 
	*/
	public function getassignmentpercentcomplete($profileid, $assignmentid)
	{		
		$profileid = $this->createDbConnection($profileid);		
		
		$percentstatement = $this->_lockerdbConn->prepare("SELECT ".GET_ASSIGNMENTPERCENTCOMPLETE."(?, ?) as percentcomplete");
		$percentstatement->bind_param("is", $profileid, $assignmentid);
		$percentstatement->execute();	
		$percentrow = $this->getresult($percentstatement);		
		
		
		return $percentrow[0]['percentcomplete'];
	}	
	
   	/**
	* getcitationcount
	*
	* This function returns the number of citations for a given assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* 
	*/
	public function getcitationcount($profileid, $assignmentid)
	{			
		$profileid = $this->createDbConnection($profileid);	
	
		$citationcountstatement = $this->_lockerdbConn->prepare("CALL ".GET_CITATIONCOUNT."(?)");
		$citationcountstatement->bind_param("s", $assignmentid);
		$citationcountstatement->execute();	
		$citationcountrow = $this->getresult($citationcountstatement);			
		
		return $citationcountrow[0]['citationcount'];
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
	* @param 	string $profileid
	* @param 	string $assignmentid
	* @param 	int $type
	* 
	*/
	public function getstuffcollected($profileid, $assignmentid, $type = NULL)
	{	
		$profileid = $this->createDbConnection($profileid);	
		$retval = array();
		
		//find out if this is an rps product.
		$ngodb = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($ngodb)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}		
		
    	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
		if (DB::isError($godb)) {
			print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
		}		
		
		//if the user is viewing all of the assets and not just a specific one (like articles)
		if(is_null($type))
		{
			//get the saved web links
			$savedwebstatement = $this->_lockerdbConn->prepare("CALL ".GET_SAVEDWEBLINKLIST."(?, ?, ?)");
			$zerovalue = 0;
			$savedwebstatement->bind_param("isi", $profileid, $assignmentid,$zerovalue);
			$savedwebstatement->execute();	
			$savedweblinkrow = $this->getresult($savedwebstatement);				
			

			for ($i = 0; $i<count($savedweblinkrow); $i++)
			{
				$weblinkobj = new Locker_Saved_Weblink($profileid, $assignmentid, $savedweblinkrow[$i]['savedweblinkid'], $savedweblinkrow[$i]['title'], $savedweblinkrow[$i]['digitallockerfoldertypeid'], $savedweblinkrow[$i]['description'], $savedweblinkrow[$i]['url'], $savedweblinkrow[$i]['location'], $savedweblinkrow[$i]['creationdate'],$savedweblinkrow[$i]['modifieddate']);
				$retval[] = $weblinkobj;		
			
			}//end for			
			
			//get the saved assets
			$savedassetstatement = $this->_lockerdbConn->prepare("CALL ".GET_SAVEDASSETLIST."(?, ?, ?)");
			$savedassetstatement->bind_param("isi", $profileid, $assignmentid,$zerovalue);
			$savedassetstatement->execute();	
			$savedassetlinkrow = $this->getresult($savedassetstatement);				
			

			//go through all of the saved assets..
			for ($i = 0; $i<count($savedassetlinkrow); $i++)
			{
				
				
				//if the asset is an atlas
				if($savedassetlinkrow[$i]['type']=='0mmg' || $savedassetlinkrow[$i]['type']=='0mm' || $savedassetlinkrow[$i]['type']=='0mmh' || $savedassetlinkrow[$i]['type']=='0mme' || $savedassetlinkrow[$i]['type']=='0mmt'){
				
					$assetid = $savedassetlinkrow[$i]['assetid'];
					
					//make the url for the atlas
				    $url = '\'atlas?id='.$assetid .'\',720,650, \'atlas\', \'no\', \'no\', \'no\', \'yes\', \'no\', \'no\',400,200';   		
	
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;		
					
					
					
				//if the asset is an image...
				}else if($savedassetlinkrow[$i]['type']=='0ma' || $savedassetlinkrow[$i]['type']=='0mp' || $savedassetlinkrow[$i]['type']=='0mf'){
					

					$productid = $savedassetlinkrow[$i]['sourceproductid'];
					$assetid = $savedassetlinkrow[$i]['assetid'];
					//if the product this asset came from is go.. 
					if($productid=="go"){
						
						//then connect to the go database and query the manifest for info about the asset
						$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
						if (DB::isError($godb)) {
							print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
						}		
				
						$mainSQL = "select uid, slp_id as id, fext,credit,title_ent as title,caption_id as caption,type,ada_text from manifest where slp_id='$assetid'";
						

						$mainExt = $godb->getall($mainSQL,DB_FETCHMODE_ASSOC);	
						$mainExt = $mainExt[0];		
						
						//get info about the asset
						$uid = $mainExt['uid'];
						$id = $mainExt['id'];
						$newtitle = str_replace(" ", "%20", $mainExt['title']);	
						$fext = $mainExt['fext'];									
					
					//if the product is not go...		
					}else{
						
						//find the database this product is in....
						$appdb = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
						if (DB::isError($appdb)) {
							echo "Error: Could not retrieve mysql connect string for $productid";
						}
						$sql = sprintf("select value from appenv where app='$productid' and key_name='product_db';");
						$productDB = $appdb->getOne($sql);
						
		    	
						//connect to it... 
						$db = DB::connect($productDB);
						if (DB::isError($db)) {
							echo "Error: Could not retrieve mysql connect string for $productid $assetid $title";
						}
			
						
						$sql = sprintf("Select isRPS from product_map where productid='{$productid}';");
						$result = $ngodb->query($sql)->fetchrow();
						$dataSource = ($result[0]==1) ? "RPS" : "LEGACY";
						
						if($productid=="go"){
							
							$assetsql = sprintf("select asset_id as id, fext from assets where asset_id='$assetid';"); 
							
				
						}else{
							if($dataSource=="RPS"){
								$assetsql = sprintf("select uid, slp_id as id, fext from manifest where slp_id='$assetid';"); 	
								
							}else{
								
								$assetsql = sprintf("select id, fext from assets where id='$assetid';"); 
					
							}
						}
				
						$assetArray = $db->getall($assetsql, DB_FETCHMODE_ASSOC);   	
						
						$uid = $assetArray[0]['uid'];
						$id = $assetArray[0]['id'];
						$newtitle = str_replace(" ", "%20", $savedassetlinkrow[$i]['title']);
						$fext = $assetArray[0]['fext'];
					}//end if
					
				    $url ='/php/common/article/media_popup.php?search=true&type='.$savedassetlinkrow[$i]['type'].'&title='.$newtitle.'&id='.$id.'&product_id='.$savedassetlinkrow[$i]['sourceproductid'].'&ext='.$fext.'&uid='.$uid;
				       		 	
						
	
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;		
					
					
				}else{				
				
				
				
					//MAKE THE URL
					$type = $savedassetlinkrow[$i]['type'];
					$urlsql = sprintf("select url from product_urls WHERE type='$type' AND product_version='ngo1'");
					$urlresult = $godb->query($urlsql)->fetchrow();					
					$url = $urlresult[0];
					
					$url = str_replace("##ASSET_ID##", $savedassetlinkrow[$i]['assetid'], $url);
					$url = str_replace("##PRODUCT_ID##", $savedassetlinkrow[$i]['sourceproductid'], $url);
					$url = str_replace("##TYPE##", $savedassetlinkrow[$i]['type'], $url);
					
					if($type=="0uv"){
						$assetid = $savedassetlinkrow[$i]['assetid'];
						
						$mansql = sprintf("select category from manifest where slp_id='$assetid'");
						$manresult = $ngodb->query($mansql)->fetchrow();
						$category = $manresult[0];

						
						if($category == "xs02_anchor"){
							
							$url = "";
							
							
						}
						
					}					
					
					
					if(!$savedassetlinkrow[$i]['digitallockerfoldertypeid']){
						
						$savedassetlinkrow[$i]['digitallockerfoldertypeid'] = 5;
						$savedassetlinkrow[$i]['description'] = "Other";
					}
				
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;		
				}
			}//end for				
		
			
		//if the type is a weblink or a magazine	
		}
		else if ($type == 3 || $type == 4)
		{
		
			
			$savedwebstatement = $this->_lockerdbConn->prepare("CALL ".GET_SAVEDWEBLINKLIST."(?, ?, ?)");
			$savedwebstatement->bind_param("iss", $profileid, $assignmentid, $type);
			$savedwebstatement->execute();	
			$savedweblinkrow = $this->getresult($savedwebstatement);				
			
			for ($i = 0; $i<count($savedweblinkrow); $i++)
			{
				$weblinkobj = new Locker_Saved_Weblink($profileid, $assignmentid, $savedweblinkrow[$i]['savedweblinkid'], $savedweblinkrow[$i]['title'], $savedweblinkrow[$i]['digitallockerfoldertypeid'], $savedweblinkrow[$i]['description'], $savedweblinkrow[$i]['url'], $savedweblinkrow[$i]['location'], $savedweblinkrow[$i]['creationdate'],$savedweblinkrow[$i]['modifieddate']);
				$retval[] = $weblinkobj;		
			
			}//end for
				
	
		}
		else
		{
	
			
			$savedassetstatement = $this->_lockerdbConn->prepare("CALL ".GET_SAVEDASSETLIST."(?, ?, ?)");
			$savedassetstatement->bind_param("iss", $profileid, $assignmentid,$type);
			$savedassetstatement->execute();	
			$savedassetlinkrow = $this->getresult($savedassetstatement);				
			
			for ($i = 0; $i<count($savedassetlinkrow); $i++)
			{
				
				
				//if the asset is an atlas
				if($savedassetlinkrow[$i]['type']=='0mmg' || $savedassetlinkrow[$i]['type']=='0mm' || $savedassetlinkrow[$i]['type']=='0mmh' || $savedassetlinkrow[$i]['type']=='0mme' || $savedassetlinkrow[$i]['type']=='0mmt'){
				
					$assetid = $savedassetlinkrow[$i]['assetid'];
					
					//make the url for the atlas
				    $url = '\'atlas?id='.$assetid .'\',720,650, \'atlas\', \'no\', \'no\', \'no\', \'yes\', \'no\', \'no\',400,200';   		
	
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;		
				
				
				}else if($savedassetlinkrow[$i]['type']=='0ma' || $savedassetlinkrow[$i]['type']=='0mp' || $savedassetlinkrow[$i]['type']=='0mf')
				{
					$productid = $savedassetlinkrow[$i]['sourceproductid'];
					$assetid = $savedassetlinkrow[$i]['assetid'];
					
					if($productid=="go")
					{
				
						$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
						if (DB::isError($godb)) 
						{
							print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
						}		
				
						$mainSQL = "select uid, slp_id as id, fext,credit,title_ent as title,caption_id as caption,type,ada_text from manifest where slp_id='$assetid'";
						

						$mainExt = $godb->getall($mainSQL,DB_FETCHMODE_ASSOC);	
						$mainExt = $mainExt[0];		
						
						$uid = $mainExt['uid'];

						$id = $mainExt['id'];
						$newtitle = str_replace(" ", "%20", $mainExt['title']);	
						$fext = $mainExt['fext'];									
						
					}else{
						
				
						//find the database this product is in....
						$appdb = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
						if (DB::isError($appdb)) 
						{
							echo "Error: Could not retrieve mysql connect string for $productid";
						}
						$sql = sprintf("select value from appenv where app='$productid' and key_name='product_db';");
						$productDB = $appdb->getOne($sql);
						
		    	
						//connect to it... 
						$db = DB::connect($productDB);
						if (DB::isError($db)) 
						{
							echo "Error: Could not retrieve mysql connect string for $productid $assetid $title";
						}
			
						
						$sql = sprintf("Select isRPS from product_map where productid='{$productid}';");
						$result = $ngodb->query($sql)->fetchrow();
						$dataSource = ($result[0]==1) ? "RPS" : "LEGACY";
						
						if($productid=="go"){
							
							$assetsql = sprintf("select asset_id as id, fext from assets where asset_id='$assetid';"); 
							
				
						}
						else
						{
							if($dataSource=="RPS")
							{
								$assetsql = sprintf("select uid, slp_id as id, fext from manifest where slp_id='$assetid';"); 	
							}
							else
							{
								$assetsql = sprintf("select id, fext from assets where id='$assetid';"); 
							}
						}
				
						$assetArray = $db->getall($assetsql, DB_FETCHMODE_ASSOC);   	
						
						$uid = $assetArray[0]['uid'];
						$id = $assetArray[0]['id'];
						$newtitle = str_replace(" ", "%20", $savedassetlinkrow[$i]['title']);
						$fext = $assetArray[0]['fext'];
					}
				    $url ='/php/common/article/media_popup.php?search=true&type='.$savedassetlinkrow[$i]['type'].'&title='.$newtitle.'&id='.$id.'&product_id='.$savedassetlinkrow[$i]['sourceproductid'].'&ext='.$fext.'&uid='.$uid;
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;		
				}
				else
				{
					if($savedassetlinkrow[$i]['digitallockerfoldertypeid'] == NULL)
					{
						
						$savedassetlinkrow[$i]['digitallockerfoldertypeid'] = 5;
						$savedassetlinkrow[$i]['description'] = "Other";
					}
					
					//urls
					$thetype = $savedassetlinkrow[$i]['type'];
					
					$urlsql = sprintf("select url from product_urls WHERE type='$thetype' AND product_version='ngo1'");
					$urlresult = $godb->query($urlsql)->fetchrow();					
					$url = $urlresult[0];
					
					$url = str_replace("##ASSET_ID##", $savedassetlinkrow[$i]['assetid'], $url);
					$url = str_replace("##PRODUCT_ID##", $savedassetlinkrow[$i]['sourceproductid'], $url);
					$url = str_replace("##TYPE##", $savedassetlinkrow[$i]['type'], $url);			
					
					if($thetype=="0uv")
					{
						$assetid = $savedassetlinkrow[$i]['assetid'];
						
						$mansql = sprintf("select category from manifest where slp_id='$assetid'");
						$manresult = $ngodb->query($mansql)->fetchrow();
						$category = $manresult[0];
						
						if($category == "xs02_anchor")
						{
							$url = "";				
						}
					}
		
					$savedassetobj = new Locker_Saved_Asset($profileid, $assignmentid, $savedassetlinkrow[$i]['savedassetid'], $savedassetlinkrow[$i]['title'], $url, $savedassetlinkrow[$i]['type'], $savedassetlinkrow[$i]['digitallockerfoldertypeid'],$savedassetlinkrow[$i]['description'], $savedassetlinkrow[$i]['assetid'], $savedassetlinkrow[$i]['sourceproductid'], $savedassetlinkrow[$i]['creationdate'],$savedassetlinkrow[$i]['modifieddate']);
					$retval[] = $savedassetobj;				
				}
			}//end for					
		}
		
		return $retval;
	}		
	
   	/**
	* getstuffcollectedcounts
	*
	* Get the counts of all the stuff a user collected for a given assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array
	* 
	* @param 	string $profileid
	* @param 	string $assignmentid
	* 
	*/
	public function getstuffcollectedcounts($profileid, $assignmentid)
	{	
		$profileid = $this->createDbConnection($profileid);	
		$retVal = array();	
		
		//get the saved assets counts	

		$savedassetstatement = $this->_lockerdbConn->prepare("CALL ".GET_STUFFCOLLECTEDSAVEDASSETCOUNTS."(?, ?)");
		$savedassetstatement->bind_param("is", $profileid, $assignmentid);
		$savedassetstatement->execute();	
		$savedassetsrow = $this->getresult($savedassetstatement);			
		
		//put all the saved assets counts into the retval associated array.
		for ($i = 0; $i<count($savedassetsrow); $i++)
		{	
			$var = $savedassetsrow[$i]['description'];
			$retVal[$var] = $savedassetsrow[$i]['count'];		
			
		}//end for
		
		//get the other count
		$otherstatement = $this->_lockerdbConn->prepare("CALL ".GET_STUFFCOLLECTEDOTHERCOUNTS."(?, ?)");
		$otherstatement->bind_param("is", $profileid, $assignmentid);
		$otherstatement->execute();	
		$otherrow = $this->getresult($otherstatement);				
		$retVal["Other"] = $otherrow[0]['count'];
		

		
		//get the weblinks counts
		$weblinksstatement = $this->_lockerdbConn->prepare("CALL ".GET_STUFFCOLLECTEDSAVEDWEBLINKCOUNTS."(?, ?)");
		$weblinksstatement->bind_param("is", $profileid, $assignmentid);
		$weblinksstatement->execute();	
		$savedweblinksrow = $this->getresult($weblinksstatement);				

		//put all the saved assets counts into the retval associated array.
		for ($i = 0; $i<count($savedweblinksrow); $i++)
		{	
			$var = $savedweblinksrow[$i]['description'];
			$retVal[$var] = $savedweblinksrow[$i]['count'];		
			
		}//end for		
		
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
	* @return  string
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* 
	*/
	public function getnotecardcount($profileid, $assignmentid)
	{			
		$profileid = $this->createDbConnection($profileid);	

		$notecardstatement = $this->_lockerdbConn->prepare("CALL ".GET_NOTECARDCOUNT."(?)");
		$notecardstatement->bind_param("s", $assignmentid);
		$notecardstatement->execute();	
		$notecardcountrow = $this->getresult($notecardstatement);			
		
		return $notecardcountrow[0]['notecardcount'];
	}	
	
   	/**
	* getcitation
	*
	* This function returns a citation object.
	* Possible values are: autocite, creationdate, modifieddate, citationtext, pubmediumid, citationcontenttypeid, citationtype 
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Citation object
	* 
	* @param	string $profileid
	* @param	string $citationid
	* 
	*/
	public function getcitation($profileid, $citationid)
	{			
		$profileid = $this->createDbConnection($profileid);
		$retval = NUll;

		$citationstatement = $this->_lockerdbConn->prepare("CALL ".GET_CITATION."(?)");
		$citationstatement->bind_param("s", $citationid);
		$citationstatement->execute();	
		$citationrow = $this->getresult($citationstatement);			
		
		$autocite = $citationrow[0]['autocite'];
		$autocitearray = array();
		
		if($autocite=='1')
		{			

			$autocitationstatement = $this->_lockerdbConn->prepare("CALL ".GET_AUTO_CITATION."(?)");
			$autocitationstatement->bind_param("s", $citationid);
			$autocitationstatement->execute();	
			$autocitationrow = $this->getresult($autocitationstatement);				
			
				for ($i = 0; $i<count($autocitationrow); $i++)
				{	
					$citationtype = "'".$autocitationrow[$i]['citationtype']."'";
					$citationtext = $autocitationrow[$i]['citationtext'];
					$autocitearray[$citationtype] = $citationtext;
				}
		}
					
		$citationrowobj = new Locker_Citation($citationrow[0]['profileid'], $citationrow[0]['assignmentid'], $citationid, $citationrow[0]['autocite'], 
												$citationrow[0]['citationtext'], $citationrow[0]['pubmediumid'], 
												$citationrow[0]['citationcontenttypeid'], $citationrow[0]['creationdate'], $citationrow[0]['modifieddate'],$autocitearray);
		
		$retval = $citationrowobj;	

	
		return $retval;

	}	
	
   	/**
	* getcitationlist
	*
	* This function returns an array of citation objects.
	* Possible values are: autocite, creationdate, modifieddate, citationtext, pubmediumid, citationsourcetypeid, citationtype, citationtext 
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Citation $var
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	* @param 	string $bibliographyid
	* @param	string $sort
	* 
	*/
	public function getcitationlist($profileid, $assignmentid, $bibliographyid, $sort)
	{			
		$retVal = array();
		$profileid = $this->createDbConnection($profileid);

		$citationstatement = $this->_lockerdbConn->prepare("CALL ".GET_CITATION_LIST."(?, ?, ?)");
		$citationstatement->bind_param("iss", $profileid, $assignmentid, $bibliographyid);
		$citationstatement->execute();	
		$citationrow = $this->getresult($citationstatement);			
		
		
		for ($i = 0; $i<count($citationrow); $i++)
		{
			$autocite = $citationrow[$i]['autocite'];
			$citationid = $citationrow[$i]['citationid'];
			$autocitearray = array();
		
			if($autocite=='1')
			{	
				
				$autocitationstatement = $this->_lockerdbConn->prepare("CALL ".GET_AUTO_CITATION."(?)");
				$autocitationstatement->bind_param("s", $citationid);
				$autocitationstatement->execute();	
				$autocitationrow = $this->getresult($autocitationstatement);					
				
					for ($j = 0; $j<count($autocitationrow); $j++)
					{
						$citationtype = "'".$autocitationrow[$j]['citationtype']."'";
						$citationtext = $autocitationrow[$j]['citationtext'];
						$autocitearray[$citationtype] = $citationtext;				
					}				
			}
								
			$citationrowobj = new Locker_Citation($profileid, $assignmentid, $citationid, $autocite, $citationrow[$i]['citationtext'], $citationrow[$i]['pubmediumid'], 
													$citationrow[$i]['citationcontenttypeid'], $citationrow[$i]['creationdate'], $citationrow[$i]['modifieddate'],$autocitearray);
			$citationrowobj->setsort($sort);
			$retVal[] = $citationrowobj;
		
		}
		
	
		return $retVal;

	}	
	
   	/**
	* getassignmentdaysleft
	*
	* This function returns the number of days left before the assignment is due for a given profileid and assignmentid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* 
	*/
	public function getassignmentdaysleft($profileid, $assignmentid)
	{		
		$profileid = $this->createDbConnection($profileid);	

		$daysleftstatement = $this->_lockerdbConn->prepare("CALL ".GET_ASSIGNMENT_DAYSLEFT."(?, ?)");
		$daysleftstatement->bind_param("is", $profileid, $assignmentid);
		$daysleftstatement->execute();	
		$daysleftrow = $this->getresult($daysleftstatement);			
		
		return $daysleftrow[0]['daysleft'];
	}	
	
	/**
	* getcurrentassignment
	*
	* Get the current assignment. This function returns an object of the current assignment for that user. 
	* The current assignment values that are returned are: assignmentid, title.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Assignment object
	* 
	* @param	string $profileid
	* @param	string $productid
	*/
	public function getcurrentassignment($profileid, $productid)
	{		
		$profileid = $this->createDbConnection($profileid);	
		$retval = NULL;
		
		$currassignstatement = $this->_lockerdbConn->prepare("CALL ".GET_CURRENT_ASSIGNMENT."(?, ?)");
		$currassignstatement->bind_param("is", $profileid, $productid);
		$currassignstatement->execute();	
		$row = $this->getresult($currassignstatement);			
		
		$obj = new Locker_Assignment($profileid, $row[0]['currentassignmentid']);
		$retval = $obj;	
		return $retval;
	}
	
	/**
	* getcurrenttask
	*
	* Get the current task. This function returns an object of the current task for that user. 
	* The current task values that are returned are: task.taskid, task.duedate, locker1support_gi.tasktype.description as title, customtaskdescription.description
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Task object
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	*/
	public function getcurrenttask($profileid, $assignmentid)
	{			
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);
		
		$currtaskstatement = $this->_lockerdbConn->prepare("CALL ".GET_CURRENT_TASK."(?, ?)");
		$currtaskstatement->bind_param("is", $profileid, $assignmentid);
		$currtaskstatement->execute();	
		$currenttaskrow = $this->getresult($currtaskstatement);			

		$description = $currenttaskrow[0]['description'];
		if($currenttaskrow[0]['tasktype']==6){
			
			$description = $currenttaskrow[0]['customdescription'];
			
		}
		list($year, $month, $day) = split("-", $currenttaskrow[0]['duedate']);
		$timestamp = mktime(0, 0, 0, $month, 1, 2005);	
		$currenttaskrow[0]['duedate'] = date("F", $timestamp)." $day, $year";
   		$currenttaskobj = new Locker_Task($profileid, $assignmentid, $currenttaskrow[0]['taskid'],  $currenttaskrow[0]['tasktype'],
												$currenttaskrow[0]['title'], $description, $currenttaskrow[0]['duedate'],
												$currenttaskrow[0]['completiondate'],$currenttaskrow[0]['creationdate'],$currenttaskrow[0]['modifieddate']);											
		$retval = $currenttaskobj;	

		return $retval;
	}	
	
	/**
	* getbibliography
	*
	* This function returns a Locker_Bibliography object.
	* The list of possible values are:profileid, assignmentid, creationdate, modifieddate.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Bibliography object
	* 
	* @param	string $profileid
	* @param	string $bibliographyid
	*/
	public function getbibliography($profileid, $bibliographyid)
	{			
		$profileid = $this->createDbConnection($profileid);
		$retval = NULL;
		
		$bibstatement = $this->_lockerdbConn->prepare("CALL ".GET_BIBLIOGRAPHY."(?)");
		$bibstatement->bind_param("s", $bibliographyid);
		$bibstatement->execute();	
		$bibliographyrow = $this->getresult($bibstatement);		
		
		$bibliographyobj = new Locker_Bibliography($bibliographyrow[0]['profileid'], $bibliographyrow[0]['assignmentid'], $bibliographyid, $bibliographyrow[0]['creationdate'],
												$bibliographyrow[0]['modifieddate']);
		$retval = $bibliographyobj;	

		return $retval;
	}	

	/**
	* getbibliographylist	
	*
	* This function returns an array of Locker_Bibliography objects.
	* The list of possible values are:profileid, assignmentid, creationdate, modifieddate.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Bibliography object
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	*/
	public function getbibliographylist($profileid, $assignmentid)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);

		$bibstatement = $this->_lockerdbConn->prepare("CALL ".GET_BIBLIOGRAPHY_LIST."(?, ?)");
		$bibstatement->bind_param("is", $profileid, $assignmentid);
		$bibstatement->execute();	
		$row = $this->getresult($bibstatement);			
	
	
		for ($i = 0; $i<count($row); $i++)
		{
			
			$bibliographyobj = new Locker_Bibliography($profileid, $assignmentid, $row[$i]['bibliographyid'], $row[$i]['creationdate'],
										$row[$i]['modifieddate']);
			$retval[] = $bibliographyobj;	

		}		

		return $retval;
	}	
		
	/**
	* gettaskbytype
	*
	* Get a task by type. This function returns a task object.
	* The current task values that are returned are: taskid, duedate, completiondate, title, description
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Task object
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	* @param	int $tasktype
	*/
	public function gettaskbytype($profileid, $assignmentid, $tasktype)
	{			
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);

		$currtaskstatement = $this->_lockerdbConn->prepare("CALL ".GET_TASKBYTYPE."(?, ?, ?)");
		$currtaskstatement->bind_param("isi", $profileid, $assignmentid, $tasktype);
		$currtaskstatement->execute();	
		$currenttaskrow = $this->getresult($currtaskstatement);			
		
		$currenttaskobj = new Locker_Task($profileid, $assignmentid, $currenttaskrow[0]['taskid'], $tasktype,
												$currenttaskrow[0]['title'], $currenttaskrow[0]['description'], $currenttaskrow[0]['duedate'],
												$currenttaskrow[0]['completiondate'],$currenttaskrow[0]['creationdate'],$currenttaskrow[0]['modifieddate']);
		$retval = $currenttaskobj;	

		return $retval;
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
	* @param	string $profileid
	* @param	string $taskid
	*/
	public function gettask($profileid, $taskid) 
	{
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);
		
		$taskstatement = $this->_lockerdbConn->prepare("CALL ".GET_TASK."(?)");
		$taskstatement->bind_param("s", $taskid);
		$taskstatement->execute();	
		$assignmenttaskrow = $this->getresult($taskstatement);			
	
		$assignmenttaskobj = new Locker_Task($assignmenttaskrow[0]['profileid'], $assignmenttaskrow[0]['assignmentid'], $taskid, $assignmenttaskrow[0]['tasktype'],
												$assignmenttaskrow[0]['title'], $assignmenttaskrow[0]['description'], $assignmenttaskrow[0]['duedate'],
												$assignmenttaskrow[0]['completiondate'],$assignmenttaskrow[0]['creationdate'],$assignmenttaskrow[0]['modifieddate']);
		$retval = $assignmenttaskobj;	
		return $retval;
	}
				
	/**
	* gettasklist
	*
	* Get a list of tasks. This function returns an array of assignment task objects. 
	* The task values that are returned are: profileid,assignmentid,taskid,tasktype,duedate,completiondate,title,description.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Task $var
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $sort
	*/
	public function gettasklist($profileid,$assignmentid,$sort)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
		
		$taskstatement = $this->_lockerdbConn->prepare("CALL ".GET_TASK_LIST."(?, ?)");
		$taskstatement->bind_param("is", $profileid, $assignmentid);
		$taskstatement->execute();	
		$assignmenttaskrow = $this->getresult($taskstatement);			
	
		for ($i = 0; $i<count($assignmenttaskrow); $i++)
		{
			list($year, $month, $day) = split("-", $assignmenttaskrow[$i]['duedate']);
			$assignmenttaskrow[$i]['duedate'] = "$month/$day/$year";
			$assignmenttaskobj = new Locker_Task($profileid, $assignmentid, $assignmenttaskrow[$i]['taskid'], $assignmenttaskrow[$i]['tasktype'],
												$assignmenttaskrow[$i]['title'], $assignmenttaskrow[$i]['description'], $assignmenttaskrow[$i]['duedate'],
												$assignmenttaskrow[$i]['completiondate'],$assignmenttaskrow[$i]['creationdate'],$assignmenttaskrow[$i]['modifieddate']);
			$assignmenttaskobj->setsort($sort);
			$retval[] = $assignmenttaskobj;	
		}
	
		return $retval;
	}
		
	/**
	* getnotecard
	*
	* Get an individual notecard. This function returns an object of an individual notecard. 
	* The notecard values that are returned are: profileid, assignmentid, notecardid, title, groupid, tags, quote, text, citationid.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Notecard object
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	*/
	public function getnotecard($profileid, $notecardid)
	{			
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);
		
		$notecardstatement = $this->_lockerdbConn->prepare("CALL ".GET_NOTECARD."(?)");
		$notecardstatement->bind_param("s", $notecardid);
		$notecardstatement->execute();	
		$notecardrow = $this->getresult($notecardstatement);			
	
		$notecardobj = new Locker_Notecard($notecardrow[0]['profileid'], $notecardrow[0]['assignmentid'], $notecardid, $notecardrow[0]['title'],
							$notecardrow[0]['directquote'], $notecardrow[0]['paraphrase'], $notecardrow[0]['charcountdirectquote'],
							$notecardrow[0]['charcountparaphrase'],$notecardrow[0]['citationid'],$notecardrow[0]['groupid'],$notecardrow[0]['creationdate'], 
							$notecardrow[0]['modifieddate']);
		$retval = $notecardobj;	

	
		return $retval;
	}	
	
	/**
	* getnotecardlist
	*
	* Get a list of notecard for a particular user and assignment. This function returns an array of notecard objects. 
	* The notecardlist values that are returned are: notecardid, title, groupid, grouptitle.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Notecard $var
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	*/
	public function getnotecardlist($profileid,$assignmentid,$sort)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
		
		$notecardstatement = $this->_lockerdbConn->prepare("CALL ".GET_NOTECARD_LIST."(?, ?)");
		$notecardstatement->bind_param("is", $profileid, $assignmentid);
		$notecardstatement->execute();	
		$notecardrow = $this->getresult($notecardstatement);			
		
		for ($i = 0; $i<count($notecardrow); $i++)
		{
			$notecardobj = new Locker_Notecard($profileid, $assignmentid, $notecardrow[$i]['notecardid'], $notecardrow[$i]['title'],
							$notecardrow[$i]['directquote'], $notecardrow[$i]['paraphrase'], $notecardrow[$i]['charcountdirectquote'],
							$notecardrow[$i]['charcountparaphrase'],$notecardrow[$i]['citationid'],$notecardrow[$i]['groupid'],$notecardrow[$i]['creationdate'], 
							$notecardrow[$i]['modifieddate']);
			$notecardobj->setsort($sort);
			$retval[] = $notecardobj;	
		}
		return $retval;
	}	

	/**
	* updategroupmodifieddate
	*
	* Update a groups modifieddate.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	string $profileid
	* @param	string $groupid
	*/
	public function updategroupmodifieddate($profileid, $groupid)
	{			
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);

		$groupstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_GROUPMODIFIEDDATE."(?)");
		$groupstatement->bind_param("s", $groupid);
		$groupstatement->execute();				
	
	}
		
	/**
	* getgroup
	*
	* Get a group for a particular groupid. This function returns a group object. 
	* The grouplist values that are returned are: groupid, title.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Group object
	* 
	* @param	string $profileid
	* @param	string $groupid
	*/
	public function getgroup($profileid, $groupid) 
	{
		$retval = NULL;
		$profileid = $this->createDbConnection($profileid);
		
		$groupstatement = $this->_lockerdbConn->prepare("CALL ".GET_GROUP."(?)");
		$groupstatement->bind_param("s", $groupid);
		$groupstatement->execute();	
		$grouprow = $this->getresult($groupstatement);			
		
		$groupobj = new Locker_Group($grouprow[0]['profileid'],$grouprow[0]['assignmentid'], $groupid, $grouprow[0]['title'], $grouprow[0]['creationdate'], $grouprow[0]['modifieddate']);
		$retval = $groupobj;	
	
		return $retval;
	}
		
	/**
	* getgrouplist
	*
	* Get a list of groups for a particular user and assignment. This function returns an array of group objects. 
	* The grouplist values that are returned are: groupid, title.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  	array[int]Locker_Group $var
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $sort
	*/
	public function getgrouplist($profileid,$assignmentid,$sort)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
		
		$groupstatement = $this->_lockerdbConn->prepare("CALL ".GET_GROUP_LIST."(?, ?)");
		$groupstatement->bind_param("is", $profileid, $assignmentid);
		$groupstatement->execute();	
		$grouplistrow = $this->getresult($groupstatement);			
	
		
		for ($i = 0; $i<count($grouplistrow); $i++)
		{
			$grouplistobj = new Locker_Group($profileid,$assignmentid, $grouplistrow[$i]['groupid'],$grouplistrow[$i]['title'], $grouplistrow[$i]['creationdate'], $grouplistrow[$i]['modifieddate']);
			$grouplistobj->setsort($sort);
			$retval[] = $grouplistobj;	
		}
		return $retval;
	}	
	
 	/**
	* isassignmenttitlevalid
	*
	* Checks to see if assignment title is valid.  The title is checked against all active assignments for a given product.
	* Returns a true if the given title is valid. False if it is not valid.
	* 
	* @author  John Palmer
	* @access  public 
	* 
	* @return 	bool
	* 
	* @param	string $profileid
	* @param 	string $productid
	* @param 	string $title
	*/
	public function isassignmenttitlevalid($profileid, $productid, $title)
	{		
		$retval = true;	
		$profileid = $this->createDbConnection($profileid);
		
		$assigntitlestatement = $this->_lockerdbConn->prepare("CALL ".GET_ASSIGNMENT_TITLE_COUNT."(?, ?, ?)");
		$assigntitlestatement->bind_param("iss", $profileid, $productid, $title);
		$assigntitlestatement->execute();	
		$assignmentidrow = $this->getresult($assigntitlestatement);			
		
		//Stored Procedure returns a count of the rows.
		if($assignmentidrow[0]['assignmenttitlecount'] > 0	)
		{
			$retval = false;
		}
		return $retval;
	}

	
	/**
	* getusernamecount
	*
	* Returns a 1 if the username is in use or a 0 if it is not in use.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param 	string $username

	* @param 	string $parent_auid	
	*/
	public function getusernamecount($username, $parent_auid)
	{	
		//Check for dupes in iauth.uid table
		$retval = 0;
		
		//lookup in auth.au table the recipient_id, then goto customer table for sourceid and name
		$parentstatement = $this->_iauthDBConn->prepare("CALL ".GET_PARENTDETAILS."(?)");
		$parentstatement->bind_param("s", $parent_auid);
		$parentstatement->execute();	
		$parent_row = $this->getresult($parentstatement);			
				
		$dupstatement = $this->_iauthDBConn->prepare("SELECT ".GET_USERNAMECOUNT."(?, ?) as usernamecount");
		$dupstatement->bind_param("si", $username, $parent_row[0]['source_id']);
		$dupstatement->execute();	
		$dupe_row = $this->getresult($dupstatement);			
		
		//If dups error out
		if($dupe_row[0]['usernamecount'] > 0)
		{
			$retval = 1;
		}
		return $retval;
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
	* @param 	string $nickname
	* @param	int $securityquestionid
	* @param 	string $securityanswer
	* @param 	int $profiletype
	* @param 	string $parent_auid	
	*/
	public function createuser($username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype, $parent_auid)
	{			
		$retval = -1;
		
		$username = strtolower($username);
		$password = strtolower($password);
		$securityanswer = strtolower($securityanswer);
				
		//Get parents info (parentname, source)
//$parent_auid = '274389';
		//lookup in auth.au table the recipient_id, then goto customer table for sourceid and name
		$parentstatement = $this->_iauthDBConn->prepare("CALL ".GET_PARENTDETAILS."(?)");
		$parentstatement->bind_param("s", $parent_auid);
		$parentstatement->execute();	
		$parent_row = $this->getresult($parentstatement);			

		//Check for dupes in iauth.uid table					
		$dupstatement = $this->_iauthDBConn->prepare("SELECT ".GET_USERNAMECOUNT."(?, ?) as usernamecount");
		$dupstatement->bind_param("si", $username, $parent_row[0]['source_id']);
		$dupstatement->execute();	
		$dupe_row = $this->getresult($dupstatement);			
		
		//If dups error out
		if($dupe_row[0]['usernamecount'] < 1)
		{
			//Else Insert user
//SHOULD WE HAVE A LOCK?!?!
			
			//CREATE CUSTOMER
			//INSERT INTO iauth.customeridgen
			$custstatement = $this->_iauthDBConn->prepare("SELECT ".INSERT_CUSTOMERIDGEN."() as customer_id");
			$custstatement->execute();	
			$customer_row = $this->getresult($custstatement);				

			//add iauth to customer_id
			$customer_row[0]['customer_id'] = "iauth".$customer_row[0]['customer_id'];
			
			//INSERT INTO iauth.customer
			
			$insertcuststatement = $this->_iauthDBConn->prepare("CALL ".INSERT_CUSTOMER."(?, ?, ?)");
			$variable = $username." @ ".$parent_row[0]['name'];
			$insertcuststatement->bind_param("sss", $customer_row[0]['customer_id'], $parent_row[0]['source_id'], $variable);
			$insertcuststatement->execute();	
			
			
			//CREATE PROFILE
			//Determine which shard to put profile into
			//Check to see if parent has a shard assigned. 
			
			$shardstatement = $this->_iauthDBConn->prepare("CALL ".GET_SHARD."(?)");
			$shardstatement->bind_param("s", $parent_row[0]['recipient_id']);
			$shardstatement->execute();	
			$shard_row = $this->getresult($shardstatement);				
			
			if(empty($shard_row))
			{
				//NO SHARD determine which shard has the least PARENT users

				$nextshardstatement = $this->_iauthDBConn->prepare("CALL ".GET_NEXTSHARD."()");
				$nextshardstatement->execute();	
				$shard_row = $this->getresult($nextshardstatement);				
				
				//Add parent to shard.
				$insertparenttatement = $this->_iauthDBConn->prepare("CALL ".INSERT_PARENTIDLOOKUP."(?, ?)");
				$insertparenttatement->bind_param("si", $parent_row[0]['recipient_id'], $shard_row[0]['shard_id']);
				$insertparenttatement->execute();	

							
			}
						
			//INSERT INTO iauth.profileidgen
			
			$insertprofstatement = $this->_iauthDBConn->prepare("SELECT ".INSERT_PROFILEIDGEN."() as profile_id");
			$insertprofstatement->execute();	
			$profile_row = $this->getresult($insertprofstatement);			
					
			//UPDATE SHARD COUNT
			
			$updateshardstatement = $this->_iauthDBConn->prepare("CALL ".UPDATE_SHARDCOUNT."(?, ?)");
			$shardtotal = $shard_row[0]['total']+1;
			$updateshardstatement->bind_param("ii", $shard_row[0]['shard_id'], $shardtotal);
			$updateshardstatement->execute();	
							
			
			//SETUP LOCKER DB CONNECTION!!
			$this->createDbConnection($profile_row[0]['profile_id'].'.'.$parent_row[0]['recipient_id']);

			//INSERT INTO iauth.auth_profile
			$insauthprofstatement = $this->_iauthDBConn->prepare("CALL ".INSERT_AUTHPROFILE."(?, ?, ?)");
			$insauthprofstatement->bind_param("isi", $parent_row[0]['source_id'], $customer_row[0]['customer_id'], $profile_row[0]['profile_id']);
			$insauthprofstatement->execute();				
						
			//INSERT INTO locker tables;	
			$createuserstatement = $this->_lockerdbConn->prepare("SELECT ".CREATE_USER."(?, ?, ?, ?, ?) as assignmentid");
			$createuserstatement->bind_param("isisi", $profile_row[0]['profile_id'], $nickname, $securityquestionid, $securityanswer, $profiletype);
			$createuserstatement->execute();	
			$userrow = $this->getresult($createuserstatement); 
			
			
			//CREATE AU
			//INSERT INTO iauth.auidgen
			$insertauidstatement = $this->_iauthDBConn->prepare("SELECT ".INSERT_AUIDGEN."() as au_id");
			$insertauidstatement->execute();	
			$auid_row = $this->getresult($insertauidstatement); 			

			$mainvar = 'MAIN';
			$onevar =  '1';
			//INSERT INTO iauth.au
			$insertaustatement = $this->_iauthDBConn->prepare("CALL ".INSERT_AU."(?, ?, ?, ?, ?, ?, ?)");
			$insertaustatement->bind_param("iisssss", $auid_row[0]['au_id'], $parent_row[0]['source_id'], $parent_row[0]['recipient_id'], $parent_row[0]['recipient_id'], $customer_row[0]['customer_id'], $mainvar,$onevar);
			$insertaustatement->execute();	


			//INSERT INTO iauth.uid OR MAYBE AN UPDATE!!!
			$insertuidstatement = $this->_iauthDBConn->prepare("CALL ".INSERT_UID."(?, ?, ?)");
			$insertuidstatement->bind_param("sis", $username, $parent_row[0]['source_id'], $password );
			$insertuidstatement->execute();				

			//INSERT INTO iauth.au_uid
			$param5 = '6';
			$param6 = '1';
			$param7 = '0';
			$param8 = 'NULL';
			$param9='';
			$insertauuidstatement = $this->_iauthDBConn->prepare("CALL ".INSERT_AUUID."(?, ?, ?, ?, ?, ?, ?, ?)");
			$insertauuidstatement->bind_param('isiiiiss', $auid_row[0]['au_id'], $username, $parent_row[0]['source_id'], $param5, $param6,$param7, $param8 ,$param9);
			$insertauuidstatement->execute();				

			//CREATE PREFS
			//GET PREFS from parent Look in auth.au_pref
			$getparentprefsstatement = $this->_iauthDBConn->prepare("CALL ".GET_PARENTPREFS."(?)");
			$getparentprefsstatement->bind_param('s', $parent_auid);
			$getparentprefsstatement->execute();
			$parent_prefs_row = $this->getresult($getparentprefsstatement); 				
			
			//Loop through prefs and insert
			for($i=0; $i < count($parent_prefs_row); $i++)
			{
				//INSERT INTO iauth.au_pref
				$insertauprefstatement = $this->_iauthDBConn->prepare("CALL ".INSERT_AUPREF."(?, ?, ?)");
				$insertauprefstatement->bind_param('iss', $auid_row[0]['au_id'], $parent_prefs_row[$i]['pref_code'], $parent_prefs_row[$i]['pref_value']);
				$insertauprefstatement->execute();
							
			}
					
			//CREATE PRODUCTS
			//GET PRODS from parent Look in auth.au_prod
			$getparentprodsstatement = $this->_iauthDBConn->prepare("CALL ".GET_PARENTPRODS."(?)");
			$getparentprodsstatement->bind_param('i', $parent_auid);
			$getparentprodsstatement->execute();
			$parent_prods_row = $this->getresult($getparentprodsstatement); 	
						
			//Loop through prefs and insert
			
			for($i=0; $i < count($parent_prods_row); $i++)
			{
				//INSERT INTO iauth.au_prod
				$insertaprodstatement = $this->_iauthDBConn->prepare("CALL ".INSERT_AUPROD."(?, ?)");
				$insertaprodstatement->bind_param('is', $auid_row[0]['au_id'], $parent_prods_row[$i]['product_code']);
				$insertaprodstatement->execute();
			}

			$retval = $profile_row[0]['profile_id'].'.'.$parent_row[0]['recipient_id'].'|'.$userrow[0]['assignmentid'];
		}else{
			
			$retval=-2;
			
		}
			
		return $retval;
	}
	
 	/**
	* insertsavedasset
	*
	* Insert a saved asset for a user\assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $assetid
	* @param 	string $sourceproductid
	* @param 	string $type
	* @param 	string $title
	*/
	public function insertsavedasset($profileid, $assignmentid, $assetid, $sourceproductid, $type, $title)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertsavedassetstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_SAVEDASSET."(?, ?, ?, ?, ?, ?) as savedassetid");
		$insertsavedassetstatement->bind_param('isssss', $profileid, $assignmentid, $assetid, $sourceproductid, $type, $title);
		$insertsavedassetstatement->execute();
		$savedassetrow = $this->getresult($insertsavedassetstatement); 			
		
		return $savedassetrow[0]['savedassetid'];
		
	}	
	
 	/**
	* insertsavedweblink
	*
	* Insert a saved asset for a user\assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $url
	* @param 	string $weblinktype
	* @param 	string $title
	* @param 	string $location
	*/
	public function insertsavedweblink($profileid, $assignmentid, $url, $weblinktype, $title, $location)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertsavedweblinkstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_SAVEDWEBLINK."(?, ?, ?, ?, ?, ?) as savedweblinkid");
		$insertsavedweblinkstatement->bind_param('isssss', $profileid, $assignmentid, $url, $weblinktype, $title, $location);
		$insertsavedweblinkstatement->execute();
		$savedweblinkrow = $this->getresult($insertsavedweblinkstatement); 	
				
		return $savedweblinkrow[0]['savedweblinkid'];
		
	}	
	
 	/**
	* movesavedcontent
	*
	* Move saved content to another assignment
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  string
	* 
	* @param	string $profileid
	* @param	string $id
	* @param 	int $contenttype
	* @param 	string $assignmentid
	* 
	*/
	public function movesavedcontent($profileid, $id, $contenttype, $assignmentid)
	{			
		$retval = -1;
		$profileid = $this->createDbConnection($profileid);
		
		if($contenttype == 3 || $contenttype == 4)
		{

			$movesavedcontentstatement = $this->_lockerdbConn->prepare("CALL ".MOVE_SAVEDCONTENT."(?, ?, ?)");
			$movesavedcontentstatement->bind_param('sss', $id, $contenttype, $assignmentid);
			$movesavedcontentstatement->execute();
			
					
			$retval = $assignmentid;
			$retval = -3;
		}
		else 
		{
			
			$getstuffstatement = $this->_lockerdbConn->prepare("CALL ".GET_STUFFCOLLECTED."(?, ?)");
			$getstuffstatement->bind_param('ss', $id, $contenttype);
			$getstuffstatement->execute();
			$getcontentrow = $this->getresult($getstuffstatement); 				
			
			$profileid = $getcontentrow[0]['profileid'];
			$assetid = $getcontentrow[0]['assetid'];
			$sourceproductid = $getcontentrow[0]['sourceproductid'];
			$type = $getcontentrow[0]['type'];
			$title = $getcontentrow[0]['title'];
			
			$assetcountstatement = $this->_lockerdbConn->prepare("CALL ".ASSET_ASSIGNMENT_COUNT."(?, ?, ?, ?)");
			$assetcountstatement->bind_param('ssss', $assetid, $sourceproductid, $type, $assignmentid);
			$assetcountstatement->execute();
			$assetrow = $this->getresult($assetcountstatement); 			
			
			
			if($assetrow[0]['total']  < 1 )
			{
				
				$movesavedcontstatement = $this->_lockerdbConn->prepare("CALL ".MOVE_SAVEDCONTENT."(?, ?, ?)");
				$movesavedcontstatement->bind_param('sss', $id, $contenttype, $assignmentid);
				$movesavedcontstatement->execute();
				$movesavedcontent = $this->getresult($movesavedcontstatement); 				
				
				$retval = $assignmentid;
				
				$retval = -2;
			}
			
		}
		return $retval;
	}	
	
 	/**
	* copysavedcontent
	*
	* copy saved content to another assignment
	*
	* @author  Diane Palmer
	* @access  public 
	*
	* @return  string
	* 
	* @param	string $profileid
	* @param	string $id
	* @param 	int $contenttype
	* @param 	string $assignmentid
	*/
	public function copysavedcontent($profileid, $id, $contenttype, $assignmentid)
	{			
		$retval = -1;
		$profileid = $this->createDbConnection($profileid);
		
		$stuffcollstatement = $this->_lockerdbConn->prepare("CALL ".GET_STUFFCOLLECTED."(?, ?)");
		$stuffcollstatement->bind_param('si', $id, $contenttype);
		$stuffcollstatement->execute();
		$getcontentrow = $this->getresult($stuffcollstatement); 
		
		if($contenttype == 3 || $contenttype == 4)
		{
			$profileid = $getcontentrow[0]['profileid'];
			$url = $getcontentrow[0]['url'];
			$weblinktype = $getcontentrow[0]['digitallockerfoldertypeid'];
			$title = $getcontentrow[0]['title'];
			$location = $getcontentrow[0]['location'];
			
			$insertsavedstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_SAVEDWEBLINK."(?, ?, ?, ?, ?, ?) as savedweblinkid");
			$insertsavedstatement->bind_param('isssss', $profileid, $assignmentid, $url, $weblinktype, $title, $location);
			$insertsavedstatement->execute();
			$savedweblinkrow = $this->getresult($insertsavedstatement); 			
			
			$retval = $savedweblinkrow[0]['savedweblinkid'];
			
		}
		else
		{
			//CHECK TO SEE IF ASSET IS ALREADY IN ASSIGNMENT!!!
			$profileid = $getcontentrow[0]['profileid'];
			$assetid = $getcontentrow[0]['assetid'];
			$sourceproductid = $getcontentrow[0]['sourceproductid'];
			$type = $getcontentrow[0]['type'];
			$title = $getcontentrow[0]['title'];
			
			$assetcountstatement = $this->_lockerdbConn->prepare("CALL ".ASSET_ASSIGNMENT_COUNT."(?, ?, ?, ?)");
			$assetcountstatement->bind_param('ssss', $assetid, $sourceproductid, $type, $assignmentid);
			$assetcountstatement->execute();
			$assetrow = $this->getresult($assetcountstatement); 				

			if($assetrow[0]['total']  < 1 )
			{

				$insertsavedassetstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_SAVEDASSET."(?, ?, ?, ?, ?, ?) as savedassetid");
				$insertsavedassetstatement->bind_param('isssss', $profileid, $assignmentid, $assetid, $sourceproductid, $type, $title);
				$insertsavedassetstatement->execute();
				$savedassetrow = $this->getresult($insertsavedassetstatement); 				

				$retval = $savedassetrow[0]['savedassetid'];
			}			
		}
		
		return $retval;
		
	}	

 	/**
	* deletesavedcontent
	*
	* delete a saved content.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $id
	* @param 	int $contenttype
	*/
	public function deletesavedcontent($profileid, $id, $contenttype)
	{			
		$profileid = $this->createDbConnection($profileid);

		$deletesavedstatement = $this->_lockerdbConn->prepare("CALL ".DELETE_SAVEDCONTENT."(?, ?)");
		$deletesavedstatement->bind_param('ss', $id, $contenttype);
		$deletesavedstatement->execute();
	

		
	}	
	
 	/**
	* insertprofiledetails
	*
	* Insert profile details.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $productid
	* @param 	string $profilevalue
	* @param 	string $currentassignmentid
	* @param 	int $lexilerange
	*/
	public function insertprofiledetails($profileid, $productid, $profilevalue, $currentassignmentid, $lexilerange)
	{	
		$profileid = $this->createDbConnection($profileid);		
		
		$insertprofdetstatement = $this->_lockerdbConn->prepare("CALL ".INSERT_PROFILEDETAILS."(?, ?, ?, ?)");
		$insertprofdetstatement->bind_param('isss', $profileid, $productid, $profilevalue, $currentassignmentid);
		$insertprofdetstatement->execute();
		$profiledetailsrow = $this->getresult($insertprofdetstatement); 			
		
		
		$updatelexstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILELEXILERANGE."(?, ?)");
		$updatelexstatement->bind_param('ii', $profileid, $lexilerange);
		$updatelexstatement->execute();
		$row = $this->getresult($updatelexstatement); 			
	}	
	
 	/**
	* insertbibliography
	*
	* Insert bibliography.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	*/
	public function insertbibliography($profileid, $assignmentid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertbibtatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_BIBLIOGRAPHY."(?, ?) as bibliographyid");
		$insertbibtatement->bind_param('is', $profileid, $assignmentid);
		$insertbibtatement->execute();
		$bibliographyrow = $this->getresult($insertbibtatement); 			
		
		return $bibliographyrow[0]['bibliographyid'];
		
	}		
		
 	/**
	* insertnewassignment
	*
	* Insert an assignment for a given user. It returns the new assignment id. NOTE: A 'NULL' must be passed for any empty value.
	* NOTE - THIS FUNCTION IS OLD AND IS NOT USED WE SHOULD DELETE IT
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmenttype
	* @param 	string $title
	* @param 	string $productid
	* @param 	string $active
	* @param 	string $duedate
	*/
	public function insertnewassignment($profileid, $assignmenttype, $title, $productid, $active, $duedate)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertassignstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_ASSIGNMENT."(?, ?, ?, ?, ?, ?) as assignmentid");
		$insertassignstatement->bind_param('isssss', $profileid, $assignmenttype, $title, $productid, $active, $duedate);
		$insertassignstatement->execute();
		$assignmentidrow = $this->getresult($insertassignstatement); 			
		
		return $assignmentidrow[0]['assignmentid'];
	}	
	
 	/**
	* insertnotecard
	*
	* Insert a new notecard to an assignment for a given user. It returns the new notecard id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $title
	* @param 	string $directquote
	* @param 	string $paraphrase
	* @param 	int $charcountdirectquote
	* @param 	int $charcountparaphrase
	* @param 	string $citationid
	* @param 	string $groupid
	*/
	public function insertnotecard($profileid, $assignmentid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $citationid, $groupid)
	{		
		$profileid = $this->createDbConnection($profileid);	
		
		$insertnotestatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_NOTECARD."(?, ?, ?, ?, ?, ?, ?, ?, ?) as notecardid");
		$insertnotestatement->bind_param('issssiiss', $profileid, $assignmentid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $citationid, $groupid);
		$insertnotestatement->execute();
		$notecardidrow = $this->getresult($insertnotestatement); 			
		
		return $notecardidrow[0]['notecardid'];
	}	
	
 	/**
	* inserttask
	*
	* Insert a new task to an assignment for a given user. It returns the new task id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	int $tasktype
	* @param 	string $duedate
	* @param 	string $customdescription
	*/
	public function inserttask($profileid, $assignmentid, $tasktype, $duedate, $customdescription)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$inserttaskstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_TASK."(?, ?, ?, ?, ?) as taskid");
		$inserttaskstatement->bind_param('issss', $profileid, $assignmentid, $tasktype, $duedate, $customdescription);
		$inserttaskstatement->execute();
		$taskidrow = $this->getresult($inserttaskstatement); 	
				
		return $taskidrow[0]['taskid'];
	}	
 	
	/**
	* updatetaskdescription
	*
	* Updates an assignment task due date for a given user.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	string $profileid
	* @param 	string $taskid
	* @param 	string $customdescription
	*/
	public function updatetaskdescription($profileid, $taskid, $customdescription)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatetaskstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_TASKDESCRIPTION."(?, ?)");
		$updatetaskstatement->bind_param('ss', $taskid, $customdescription);
		$updatetaskstatement->execute();

				
	}	

 	/**
	* updatetaskduedate
	*
	* Updates an assignment task due date for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $taskid
	* @param 	string $duedate
	*/
	public function updatetaskduedate($profileid, $taskid, $duedate)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatetaskduestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_TASKDUEDATE."(?, ?)");
		$updatetaskduestatement->bind_param('ss', $taskid, $duedate);
		$updatetaskduestatement->execute();
		
	}	
	
 	/**
	* updatetaskcompletiondate
	*
	* Updates an assignment task completion date for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $taskid
	*/
	public function updatetaskcompletiondate($profileid, $taskid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatetaskcompstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_TASKCOMPLETIONDATE."(?)");
		$updatetaskcompstatement->bind_param('s', $taskid);
		$updatetaskcompstatement->execute();
	
				
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
	* @param	string $profileid
	* @param 	string $taskid
	*/
	public function marktaskincomplete($profileid, $taskid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$marktaskcompstatement = $this->_lockerdbConn->prepare("CALL ".MARK_TASKINCOMPLETE."(?)");
		$marktaskcompstatement->bind_param('s', $taskid);
		$marktaskcompstatement->execute();

				
		return 1;
	}	
	
 	/**
	* updatetaskmodifieddate
	*
	* Updates an assignment task modified date for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $taskid
	*/
	public function updatetaskmodifieddate($profileid, $taskid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatetaskmodstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_TASKMODIFIEDDATE."(?)");
		$updatetaskmodstatement->bind_param('s', $taskid);
		$updatetaskmodstatement->execute();
	
	}
		
  	/**
	* insertgroup
	*
	* Insert a new group to an assignment for a given user. It returns the new group id. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $title
	*/
	public function insertgroup($profileid, $assignmentid, $title)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertgroupstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_GROUP."(?, ?, ?) as groupid");
		$insertgroupstatement->bind_param('iss', $profileid, $assignmentid, $title);
		$insertgroupstatement->execute();
		$groupidrow = $this->getresult($insertgroupstatement); 
				
		return $groupidrow[0]['groupid'];
	}	
	
  	/**
	* insertassignment
	*
	* Insert a new assignment for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  int
	* 
	* @param	string $profileid
	* @param 	string $assignmenttype
	* @param 	string $title
	* @param 	string $productid
	* @param 	string $active
	* @param 	string $duedate
	* @param 	int $status
	*/
	public function insertassignment($profileid, $assignmenttype, $title, $productid, $active, $duedate, $status)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$insertassignstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_ASSIGNMENT."(?, ?, ?, ?, ?, ?, ?) as assignmentid");
		$insertassignstatement->bind_param('isssssi',  $profileid, $assignmenttype, $title, $productid, $active, $duedate, $status);
		$insertassignstatement->execute();
		$assignmentidrow = $this->getresult($insertassignstatement); 		
		
		return $assignmentidrow[0]['assignmentid'];
	}		
	
 	/**
	* insertassignmentdetails
	*
	* Insert an assignment details for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $assignmentvalue
	* @param	int $citationtypeid
	*/
	public function insertassignmentdetails($profileid, $assignmentid,$assignmentvalue,$citationtypeid)
	{	
		$profileid = $this->createDbConnection($profileid);		
		
		$insertassigndetstatement = $this->_lockerdbConn->prepare("CALL ".INSERT_ASSIGNMENT_DETAILS."(?, ?, ?)");
		$insertassigndetstatement->bind_param('ssi', $assignmentid,$assignmentvalue,$citationtypeid);
		$insertassigndetstatement->execute();
	}
	
 	/**
	* insertcustomcitation
	*
	* Insert a custom citation for a given user and assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param 	string $assignmentid
	* @param	string $profileid
	* @param	string $bibliographyid
	* @param 	string $citationtext
	* @param	int $pubmediumid
	* @param	int $citationsourcetypeid
	*/
	public function insertcustomcitation($profileid, $assignmentid, $bibliographyid, $citationtext, $pubmediumid, $citationsourcetypeid)
	{	
		$profileid = $this->createDbConnection($profileid);		
		
		$insertcustcitstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_CUSTOM_CITATION."(?, ?, ?, ?, ?, ?) as citationid");
		$insertcustcitstatement->bind_param('isssii', $profileid, $assignmentid, $bibliographyid, $citationtext, $pubmediumid, $citationsourcetypeid);
		$insertcustcitstatement->execute();
		$customcitationrow = $this->getresult($insertcustcitstatement); 		
		
		return $customcitationrow[0]['citationid'];

	}	
	
 	/**
	* insertautocitation
	*
	* Insert an auto citation for a given user and assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param 	string $assignmentid
	* @param	string $profileid
	* @param	string $bibliographyid
	* @param 	string $mlacitationtext
	* @param 	string $chicagocitationtext
	* @param 	string $apacitationtext
	*/
	public function insertautocitation($profileid, $assignmentid, $bibliographyid, $mlacitationtext, $chicagocitationtext, $apacitationtext)
	{	
		
		$profileid = $this->createDbConnection($profileid);		
		$insertautocitstatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_AUTO_CITATION."(?, ?, ?, ?, ?, ?) as citationid");
		$insertautocitstatement->bind_param('isssss', $profileid, $assignmentid, $bibliographyid, $mlacitationtext, $chicagocitationtext, $apacitationtext);
		$insertautocitstatement->execute();
		$autocitationrow = $this->getresult($insertautocitstatement); 			
		
		return $autocitationrow[0]['citationid'];
	}	

 	/**
	* updatecitation
	*
	* Update a citation.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $citationid
	* @param	int $pubmediumid
	* @param 	string $citationtext
	* @param 	int $citationcontenttypeid
	*/
	public function updatecitation($profileid, $citationid, $citationtext, $pubmediumid, $citationcontenttypeid)
	{	

		$profileid = $this->createDbConnection($profileid);	
		
		$updatecitstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_CITATION."(?, ?, ?, ?)");
		$updatecitstatement->bind_param('ssii', $citationid, $citationtext, $pubmediumid, $citationcontenttypeid);
		$updatecitstatement->execute();			

	}		
	
 	/**
	* updateassignmentdetails
	*
	* Updates assignment details for a given user. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param	int $citationtypeid
	* @param	string $assignmentvalue
	*/
	public function updateassignmentdetails($profileid, $assignmentid, $citationtypeid, $assignmentvalue) 
	{			
			
			$profileid = $this->createDbConnection($profileid);
			
			$updateassigndetstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENTDETAILS."(?, ?, ?)");
			$updateassigndetstatement->bind_param('sis', $assignmentid, $citationtypeid, $assignmentvalue);
			$updateassigndetstatement->execute();
			
		
	}	
		
 	/**
	* updateassignment
	*
	* Updates an assignment for a given user. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $title
	* @param 	string $duedate
	*/
	public function updateassignment($profileid, $assignmentid, $title, $duedate)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT."(?, ?, ?)");
		$updateassignstatement->bind_param('sss', $assignmentid, $title, $duedate);
		$updateassignstatement->execute();
	
	}
	
 	/**
	* updateassignmenttitle
	*
	* Updates an assignment title for a given assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $title
	*/
	public function updateassignmenttitle($profileid, $assignmentid, $title)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_TITLE."(?, ?)");
		$updateassignstatement->bind_param('ss', $assignmentid, $title);
		$updateassignstatement->execute();
				
	}	
	
	/**
	* updateassignmentduedate
	*
	* Updates an assignment due date for a given assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $duedate
	*/
	public function updateassignmentduedate($profileid, $assignmentid, $duedate)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_DUEDATE."(?, ?)");
		$updateassignstatement->bind_param('ss', $assignmentid, $duedate);
		$updateassignstatement->execute();
				
	}	
	
 	/**
	* updateassignmentcompletiondate
	*
	* Updates an assignments task completion date and assignmentstatus for a given user.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $taskid
	* @param 	int $status
	*/
	public function updateassignmentcompletiondate($profileid, $assignmentid, $taskid, $status)
	{			
		$profileid = $this->createDbConnection($profileid);
		if($status == 2)
		{
			
			$updatetaskstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_TASKCOMPLETIONDATE."(?)");
			$updatetaskstatement->bind_param('s', $taskid);
					
		}
		else 
		{
			
			$updatetaskstatement = $this->_lockerdbConn->prepare("CALL ".MARK_TASKINCOMPLETE."(?)");
			$updatetaskstatement->bind_param('s', $taskid);
						
		}
		
		$updatetaskstatement->execute();		

		$this->updateassignmentstatus($assignmentid, $status);
	}	
		
	/**
	* updateassignmentstatus
	*
	* Updates an assignment status for a given assignment.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	int $status
	*/
	public function updateassignmentstatus($profileid, $assignmentid, $status)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_STATUS."(?, ?)");
		$updateassignstatement->bind_param('si', $assignmentid, $status);
		$updateassignstatement->execute();		
		
	}	

	/**
	* updateassignmentactive
	*
	* Updates an assignment active for a given assignment.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	int $active
	*/
	public function updateassignmentactive($profileid, $assignmentid, $active)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_ACTIVE."(?, ?)");
		$updateassignstatement->bind_param('si', $assignmentid, $active);
		$updateassignstatement->execute();			
		
	}	

	/**
	* updateassignmentcitationtype
	*
	* Updates an assignment's citation type.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	int $citationtypeid
	*/
	public function updateassignmentcitationtype($profileid, $assignmentid, $citationtypeid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_CITATIONTYPE."(?, ?)");
		$updateassignstatement->bind_param('si', $assignmentid, $citationtypeid);
		$updateassignstatement->execute();
	}	
	
 	/**
	* updateprofilecurrentassignment
	*
	* Updates the current assignment for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $productid
	* @param 	string $currentassignmentid
	*/
	public function updateprofilecurrentassignment($profileid, $productid, $currentassignmentid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILECURRENTASSIGNMENT."(?, ?, ?)");
		$updateassignstatement->bind_param('iss', $profileid, $productid, $currentassignmentid);
		$updateassignstatement->execute();		
		
	}	
	
 	/**
	* updateprofiledetails
	*
	* Updates the profile details for a user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $productid
	* @param 	string $currentassignmentid
	* @param 	string $profilevalue
	* @param 	int $lexilerange
	*/
	public function updateprofiledetails($profileid, $productid, $currentassignmentid, $profilevalue, $lexilerange)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILEDETAILS."(?, ?, ?, ?)");
		$updateassignstatement->bind_param('isss', $profileid, $productid, $currentassignmentid, $profilevalue);
		$updateassignstatement->execute();	
		
		$updateprofilestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILELEXILERANGE."(?, ?)");
		$updateprofilestatement->bind_param('is', $profileid, $lexilerange);
		$updateprofilestatement->execute();		
		
	}		
		
 	/**
	* updateprofile
	*
	* Updates the profile for a user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $username
	* @param 	string $password
	* @param 	string $nickname
	* @param 	int $securityquestionid
	* @param 	string $securityanswer
	* @param 	int $profiletype
	* @param 	int $lexilerange
	*/
	public function updateprofile($profileid, $username, $password, $nickname, $securityquestionid, $securityanswer, $profiletype)
	{			
		$profileid = $this->createDbConnection($profileid);
		//make sure the username and password is lowercase
		$username = strtolower($username);
		$password = strtolower($password);
		$securityanswer = strtolower($securityanswer);
		
		$updateprofilestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILE."(?, ?, ?, ?, ?)");
		$updateprofilestatement->bind_param('isisi', $profileid, $nickname, $securityquestionid, $securityanswer, $profiletype);
		$updateprofilestatement->execute();			
		
		$updatepassstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PASSWORD."(?, ?, ?)");
		$updatepassstatement->bind_param('iss', $profileid, $username, $password);
		$updatepassstatement->execute();		
		
	}		
			
 	/**
	* updateprofilelastlogindate
	*
	* Updates the last login date for the given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $lastlogin
	*/
	public function updateprofilelastlogindate($profileid, $lastlogin)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateprofstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILELASTLOGINDATE."(?, ?)");
		$updateprofstatement->bind_param('is', $profileid, $lastlogin);
		$updateprofstatement->execute();		
				
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
	* @param	string $profileid
	* @param 	string $lexilerange
	* 
	*/
	public function updateprofilelexilerange($profileid, $lexilerange)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updateprofstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_PROFILELEXILERANGE."(?, ?)");
		$updateprofstatement->bind_param('is', $profileid, $lexilerange);
		$updateprofstatement->execute();
		$assignmentidrow = $this->getresult($updateprofstatement); 
				
		
		return true;
	}		
	
 	/**
	* updatenotecardgroup
	*
	* Updates a notecard group for a given user. 
	* NOTE: You can pass a null value for groupid to remove a notecard from a group.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	* @param 	string $groupid
	*/
	public function updatenotecardgroup($profileid, $notecardid, $groupid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatenotestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_NOTECARDGROUP."(?, ?)");
		$updatenotestatement->bind_param('ss', $notecardid, $groupid);
		$updatenotestatement->execute();
				
	}	
	
 	/**
	* updatenotecardcitation
	*
	* Updates a notecard citation. 
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	* @param 	string $citationid
	*/
	public function updatenotecardcitation($profileid, $notecardid, $citationid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatenotestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_NOTECARDCITATION."(?, ?)");
		$updatenotestatement->bind_param('ss', $notecardid, $citationid);
		$updatenotestatement->execute();
				
	}		
	
 	/**
	* updatenotecardmodifieddate
	*
	* Updates a notecard's modification date. 
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	*/
	public function updatenotecardmodifieddate($profileid, $notecardid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatenotestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_NOTECARDMODIFIEDDATE."(?)");
		$updatenotestatement->bind_param('s', $notecardid);
		$updatenotestatement->execute();
				
	}		
	
 	/**
	* deletenotecardgroup
	*
	* Deletes a notecard group for a given user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	* @param 	string $notecardid
	*/
	public function deletenotecardgroup($profileid, $assignmentid, $notecardid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatenotestatement = $this->_lockerdbConn->prepare("CALL ".DELETE_NOTECARD_GROUP."(?, ?, ?)");
		$updatenotestatement->bind_param('iss', $profileid, $assignmentid, $notecardid);
		$updatenotestatement->execute();
				
	}	
	
 	/**
	* deletebibliography
	*
	* Deletes a bibliography.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $bibliographyid
	*/
	public function deletebibliography($profileid, $bibliographyid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$deletebibstatement = $this->_lockerdbConn->prepare("CALL ".DELETE_BIBLIOGRAPHY."(?)");
		$deletebibstatement->bind_param('s', $bibliographyid);
		$deletebibstatement->execute();
				
	}		
	
 	/**
	* updatenotecard
	*
	* Updates a notecard for a given user. NOTE: A 'NULL' must be passed for any empty value.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	* @param 	string $title
	* @param 	string $directquote
	* @param 	string $paraphrase
	* @param 	int $charcountdirectquote
	* @param 	int $charcountparaphrase
	* @param	string $groupid
	*/
	public function updatenotecard($profileid, $notecardid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $groupid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$updatenotestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_NOTECARD."(?, ?, ?, ?, ?, ?, ?)");
		$updatenotestatement->bind_param('ssssiis', $notecardid, $title, $directquote, $paraphrase, $charcountdirectquote, $charcountparaphrase, $groupid);
		$updatenotestatement->execute(); 
				
	}	
	
 	/**
	* deleteassignment
	*
	* Updates an assignment for a user to inactive.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $assignmentid
	*/
	public function deleteassignment($profileid, $assignmentid)
	{	
		$profileid = $this->createDbConnection($profileid);		
		
		$updateassignstatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_ASSIGNMENT_ACTIVE."(?, ?)");
		$thezero = 0;
		$updateassignstatement->bind_param('si', $assignmentid, $thezero);
		$updateassignstatement->execute();
				
	}
	
 	/**
	* deletegroup
	*
	* Deletes a group.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	* @param	string $groupid
	*/
	public function deletegroup($profileid, $assignmentid, $groupid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$deletegroupstatement = $this->_lockerdbConn->prepare("CALL ".DELETE_GROUP."(?, ?, ?)");
		$deletegroupstatement->bind_param('iss', $profileid, $assignmentid, $groupid);
		$deletegroupstatement->execute();

	}	
	
  	/**
	* deletenotecard
	*
	* Deletes a notecard.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $notecardid
	*/
	public function deletenotecard($profileid, $notecardid)
	{		
		$profileid = $this->createDbConnection($profileid);	
		
		$deletenotestatement = $this->_lockerdbConn->prepare("CALL ".DELETE_NOTECARD."(?)");
		$deletenotestatement->bind_param('s', $notecardid);
		$deletenotestatement->execute();
	}	
	
 	/**
	* deletetask
	*
	* Delete a task for a user.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param 	string $taskid
	*/
	public function deletetask($profileid, $taskid)
	{			
		$profileid = $this->createDbConnection($profileid);	
		
		$deletetaskstatement = $this->_lockerdbConn->prepare("CALL ".DELETE_TASK."(?)");
		$deletetaskstatement->bind_param('s', $taskid);
		$deletetaskstatement->execute();
				
	}	
	
 	/**
	* deletecitation
	*
	* Delete a citation.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	* @param	string $citationid
	*/
	public function deletecitation($profileid, $assignmentid, $citationid)
	{			
		$profileid = $this->createDbConnection($profileid);
		
		$deletecitstatement = $this->_lockerdbConn->prepare("CALL ".DELETE_CITATION."(?, ?, ?)");
		$deletecitstatement->bind_param('iss', $profileid, $assignmentid, $citationid);
		$deletecitstatement->execute();
				
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
	* @param	string $profileid
	* @param	string $taskid
	*/
	public function getrubricanswerlist($profileid, $taskid)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
	
		$getrubricstatement = $this->_lockerdbConn->prepare("CALL ".GET_RUBRIC_ANSWER_LIST."(?)");
		$getrubricstatement->bind_param('s', $taskid);
		$getrubricstatement->execute();
		$row = $this->getresult($getrubricstatement); 		
	
		
		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Rubric_Answer($taskid, $row[$i]['rubricquestionid'], $row[$i]['answertext'], $row[$i]['dateanswered']);
			$retval[] = $obj;	
		}
		return $retval;
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
	* @param	string $profileid
	* @param	string $taskid
	* @param	array $rubricanswerarray
	*/
	public function setrubricanswers($profileid, $taskid, $rubricanswerarray)
	{			
		$retval = 1;
		$profileid = $this->createDbConnection($profileid);
		for ($i = 0; $i<count($rubricanswerarray); $i++)
		{

			$setrubricstatement = $this->_lockerdbConn->prepare("CALL ".SET_RUBRIC_ANSWER."(?, ?, ?)");
			$setrubricstatement->bind_param('sis', $taskid, $rubricanswerarray[$i]['rubricquestionid'], $rubricanswerarray[$i]['answertext']);
			$setrubricstatement->execute();
					
		}
		return $retval;
	}	
	
	/**
	* getoutlinelist	
	*
	* This function returns an array of Locker_Outline objects.
	* The list of possible values are:profileid, assignmentid, outlineid, creationdate, modifieddate.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Outline object
	* 
	* @param	string $profileid
	* @param	string $assignmentid
	*/
	public function getoutlinelist($profileid, $assignmentid)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);

		
		$getoutlinestatement = $this->_lockerdbConn->prepare("CALL ".GET_OUTLINE_LIST."(?, ?)");
		$getoutlinestatement->bind_param('is', $profileid, $assignmentid);
		$getoutlinestatement->execute();
		$row = $this->getresult($getoutlinestatement); 
				
	
		for ($i = 0; $i<count($row); $i++)
		{
			
			
			$outlineobj = new Locker_Outline($profileid, $assignmentid, $row[$i]['outlineid'], $row[$i]['creationdate'],
										$row[$i]['modifieddate'], NULL);
			$retval[] = $outlineobj;	

		}		

		return $retval;
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
	* @return  array[int]Locker_Outline object
	* 
	* @param	string $profileid
	* @param	string $outlineid
	*/
	public function getoutline($profileid, $outlineid)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
		$linearray = array();
		
		$getlinestatement = $this->_lockerdbConn->prepare("CALL ".GET_LINES."(?)");
		$getlinestatement->bind_param('s', $outlineid);
		$getlinestatement->execute();
		$linerow = $this->getresult($getlinestatement); 		

		for ($i = 0; $i<count($linerow); $i++)
		{
			
			$lineobj = new Locker_Line($outlineid, $linerow[$i]['lineid'], $linerow[$i]['parentid'], $linerow[$i]['linetext'],
							$linerow[$i]['indentlevel'], $linerow[$i]['creationdate'], $linerow[$i]['modifieddate']);
							
			$linearray[] = $lineobj;
			
		}	
		
		
		$getoutlinestatement = $this->_lockerdbConn->prepare("CALL ".GET_OUTLINE."(?)");
		$getoutlinestatement->bind_param('s', $outlineid);
		$getoutlinestatement->execute();
		$outlinerow = $this->getresult($getoutlinestatement); 
				

		$outlineobj = new Locker_Outline($outlinerow[0]['profileid'], $outlinerow[0]['assignmentid'], $outlineid, $outlinerow[0]['creationdate'],
										$outlinerow[0]['modifieddate'], $linearray);
		$retval[] = $outlineobj;	


		return $retval;
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
	* @param	string $profileid
	* @param	string $assetid
	* @param 	string $productid
	* @param 	string $type
	* @param 	string $sort
	*/
	public function getassignmentassetlist($profileid, $assetid, $productid, $type, $sort)
	{			
		$retval = array();
		$profileid = $this->createDbConnection($profileid);
	
		$getassignassetstatement = $this->_lockerdbConn->prepare("CALL ".GET_ASSIGNMENTASSET_LIST."(?, ?, ?, ?)");
		$getassignassetstatement->bind_param('sssi', $assetid,$productid, $type, $profileid);
		$getassignassetstatement->execute();
		$assignmentlistrow = $this->getresult($getassignassetstatement); 		
	
		for ($i = 0; $i<count($assignmentlistrow); $i++)
		{
			$assignmentlistobj = new Locker_Assignment($profileid, $assignmentlistrow[$i]['assignmentid'], NULL, NULL, $assignmentlistrow[$i]['title']);
			$assignmentlistobj->setsort($sort);
			$retval[] = $assignmentlistobj;	
		}
	
		return $retval;
	}

	/**
	* setoutline	
	*
	* This function set an outline.  If there is no outlineid passed then it creates an outline.  If there is an outlineid passed, then it deletes all the lines for the outline, updates the moedifieddate.  And it insert all the lines.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  	int
	* @param	string $profileid
	* @param	string $assignmentid
	* @param	string $outlineid
	* @param	array $linearray
	*/
	public function setoutline($profileid, $assignmentid, $outlineid, $linearray)
	{		
		$profileid = $this->createDbConnection($profileid);
		if(is_null($outlineid))
		{
			
			$insertoutlinestatement = $this->_lockerdbConn->prepare("SELECT ".INSERT_OUTLINE."(?, ?) as outlineid");
			$insertoutlinestatement->bind_param('is',$profileid, $assignmentid);
			$insertoutlinestatement->execute();				
			
			$outlineid = $row[0]['outlineid'];
		}
		else 
		{
			//update outline modified date

			$updateoutlinestatement = $this->_lockerdbConn->prepare("CALL ".UPDATE_OUTLINE_MODIFIEDDATE."(?)");
			$updateoutlinestatement->bind_param('s',$outlineid);
			$updateoutlinestatement->execute();						
			
			//delete all lines
			
			$deleteoutlinestatement = $this->_lockerdbConn->prepare("CALL ".DELETE_ALL_LINES."(?)");
			$deleteoutlinestatement->bind_param('s',$outlineid);
			$deleteoutlinestatement->execute();
								
		}

		//insert all lines
		for ($i = 0; $i < count($linearray); $i++)
		{
			$lineid = $linearray[$i]->_lineid;
			$parentid = $linearray[$i]->_parentid;
			$indentlevel = $linearray[$i]->_indentlevel;
			$linetext = $linearray[$i]->_linetext;
			
			$insertlinestatement = $this->_lockerdbConn->prepare("CALL ".INSERT_LINE."(?, ?, ?, ?, ?)");
			$insertlinestatement->bind_param('sssis',$outlineid, $lineid, $parentid, $indentlevel, $linetext);
			$insertlinestatement->execute();
						

		}

		return $outlineid;
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
		$retval = array();
		$statement = $this->_iauthDBConn->prepare("CALL ".GET_NUMUSERS."()");
		$statement->execute();	
		$row = $this->getresult($statement);			
		$retval = $row[0]['total'];
		return $retval;
	}
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	* createDbConnection
	* 
	* This function takes in a profileid.  Parses out the profileid and shardid.  Then creates the DB connection strings.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return 	string
	* 
	* @param	string $profileid
	*/	
	private function createDbConnection($profilestring)
	{		
		$profileid = '';
		$parentid = '';
		$get_result = NULL;
		$memcacheLoaded = false;
		list($profileid, $parentid) = split('[.]', $profilestring);
		
		if($this->_lockerdbConn == null)
		{
			//Check memcache to see if the the parentid exists.
			$memcache = new Memcache;
			if($memcache->connect($_SERVER['SERVER_NAME'], 11211))
			{
				//MEMCACHE
				$get_result = $memcache->get('dbconnect-'.$parentid);
				$memcacheLoaded = true;
			}
			else 
			{
				//throw new SoapFault("Server","Memcache Connection Error on locker1.");
				//return;			
			}
			
			if(empty($parentid))
			{
				//NO PARENT
				throw new SoapFault("Server","NO PARENTID passed in profileid.");
				return;
			}
						
			if($get_result == NULL)
			{
				//GO TO DB AND GET INFO!!!
				//$sql = sprintf("CALL ".GET_SHARD."('%s');", $parentid);
				//$row = $this->executemultiquery($this->_iauthDBConn,$sql);
			
				$statement = $this->_iauthDBConn->prepare("CALL ".GET_SHARD."(?)");
				$statement->bind_param("s", $parentid);
				$statement->execute();	
				$row = $this->getresult($statement);
							
				
				$get_result = new Locker_DB_Connect($row[0]['db_hostname'],$row[0]['db_username'],$row[0]['db_password'],$row[0]['db_name'],$row[0]['db_port']);
				if($memcacheLoaded)
				{
					$memcache->set('dbconnect-'.$parentid, $get_result, false, 10) or die ("Failed to save data at the server");
				}

			}
			
			$this->_lockerdbConn = new mysqli($get_result->gethostname(), $get_result->getusername(), $get_result->getpassword(), $get_result->getdatabase(), $get_result->getport()) ;
	
			if (mysqli_connect_errno()) 
			{
				throw new SoapFault("Server","Database Connection Error on locker1.".$get_result->gethostname().' , '.$get_result->getusername().' , '.$get_result->getpassword().' , '.$get_result->getdatabase().' , '.$get_result->getport());
			}
/**
			echo "<pre>";
			print_r($memcache->getStats());
			echo "</pre>";
			echo "Data from the cache:<br/>\n";
			echo "<pre>";
			print_r($get_result);
			echo "</pre>";
*/		
		}
		return $profileid;
	}	
	
	private function getresult($stmt)
	{
		$result = array();
		
		$metadata = $stmt->result_metadata();
		$fields = $metadata->fetch_fields();
		
		for (;;)
		{
			$pointers = array();
			$row = array();
			
			$pointers[] = $stmt;
			foreach ($fields as $field)
			{
			  	$fieldname = $field->name;
				$pointers[] = &$row[$fieldname];
			}
			call_user_func_array('mysqli_stmt_bind_result', $pointers);
			
			if (!$stmt->fetch())
			  break;
			
			$result[] = $row;
		}
	     
		$metadata->free();
		if($this->_iauthDBConn)
		{		
			while($this->_iauthDBConn->next_result())
			{
				if($l_result = $this->_iauthDBConn->store_result())
				{
					$l_result->free();
				}
			}  
		}
				
		if($this->_lockerdbConn)
		{
			while($this->_lockerdbConn->next_result())
			{
				if($l_result = $this->_lockerdbConn->store_result())
				{
					$l_result->free();
				}
			}
		}
	      return $result;
	}
	
	/**
	* executemultiquery
	*
	* This function takes in a query and returns a array of rows. 
	* NO LONGER USED!!!!
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return 	array
	* 
	* @param	string $query
	*/	
	private function executemultiquery($dbConn, $query)
	{		
		$retval = array();
			
		if ($dbConn->multi_query($query)) 
		{
		    do 
		    {
			    if ($result = $dbConn->store_result()) 
			    {
			    	while ($row = $result->fetch_assoc()) 
			    	{
		                $retval[] = $row;
		            }
		            $result->free();
		        }
		
		    } while ($dbConn->next_result());
		}
		return $retval;
	}	
	
}//END OF CLASS


if($_REQUEST['testing']==1){
	
$server = new Locker_Server();

echo "<pre>";
	//print_r($server->getassignment('1.6002370900','1.3'));
	//print_r($server->copysavedcontent('1.6002370900', '1.23', '1', '1.28'));
	//print_r($server->deleteassignment('3.6002370900', '3.57'));
	print_r($server->getstuffcollected('1.6002370900', '1.3',4));
	//print_r($server->validatelogin('johnp','validpass'));
	//print_r($server->getassignmentstats('',null));
	//print_r($server->getstuffcollected('1.6002370900','1.3',NULL));
	//print_r($server->getstuffcollected('1.6002370900', '1.26', NULL));
	//print_r($server->insertsavedasset('4.6002370900', '4.7', '10000928', 'ngo', '0c', 'Our World'));
	//print_r($server->getlogininfo('jpalmer@scholastic.com', '274389'));
	//print_r($server->insertassignmentdetails('1.6002370900','1.8', 'I like fish', 1, '10 pages', 10, 2, $citarray, NULL));
	//print_r($server->insertgroup('1.6002370900', '1.8', 'Structures'));
echo "</pre>";	

}else{

	ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache 
	
	
	$server = new SoapServer($_SERVER["LOCKER1_CONFIG"]."/lockerprofile.wsdl");
	$server->setClass("Locker_Server");
	$server->handle();
}




?>