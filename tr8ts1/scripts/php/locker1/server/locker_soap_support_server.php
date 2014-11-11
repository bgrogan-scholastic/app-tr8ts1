<?php
require($_SERVER["LOCKER1_CONFIG"]."/locker_stored_proc_version_ids.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_interest.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_support_data.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_task_type.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_tool_type.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_skillbuilder.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_rubric_question.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_citation_content_type.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_citation_format_example.php");
require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_db_connect.php");


class Locker_Support_Server
{
	private $_dbConn;
	
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
		$this->createDbConnection('1');
		
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
    	if($this->_dbConn != null)
    	{
			$this->_dbConn->close();
    	}
    	
    	if($this->_iauthDBConn != null)
    	{
    		$this->_iauthDBConn->close();
    	}
    }
    

   /**
	* getfinaldraftformat
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $finaldraftformatid
	*/
	public function getfinaldraftformat($finaldraftformatid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_FINALDRAFTFORMAT."('%s');", $finaldraftformatid);
	
		$finaldraftformatrow = $this->executemultiquery($sql);

		$finaldraftformatobj = new Locker_Support_Data($finaldraftformatid, $finaldraftformatrow[0]['description']);
		$retval = $finaldraftformatobj;	

		return $retval;
	}	
	

   /**
	* getfinaldraftmodel
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $finaldraftmodelid
	*/
	public function getfinaldraftmodel($finaldraftmodelid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_FINALDRAFTMODEL."('%s');", $finaldraftmodelid);

		$finaldraftmodelrow = $this->executemultiquery($sql);


		$finaldraftmodelobj = new Locker_Support_Data($finaldraftmodelid, $finaldraftmodelrow[0]['description'], $finaldraftmodelrow[0]['url']);
		$retval = $finaldraftmodelobj;	

		return $retval;
	}	

   /**
	* getsecurityquestion
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $securityquestionid
	*/
	public function getsecurityquestion($securityquestionid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_SECURITYQUESTION."('%s');", $securityquestionid);

		$securityquestionrow = $this->executemultiquery($sql);

		$securityquestionobj = new Locker_Support_Data($securityquestionid, $securityquestionrow[0]['description']);
		$retval = $securityquestionobj;	

		return $retval;
	}		
	

   /**
	* getinterest
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Interest object
	*
	* @param	int $interestid
	*/
	public function getinterest($interestid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_INTEREST."('%s');", $interestid);
	
		$interestrow = $this->executemultiquery($sql);

		$interestobj = new Locker_Interest($interestid, $interestrow[0]['pintid'], $interestrow[0]['intdesc']);
		$retval = $interestobj;	

		return $retval;
	}		
 	    

   /**
	* getcitationtype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $citationtypeid
	*/
	public function getcitationtype($citationtypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_CITATIONTYPE."('%s');", $citationtypeid);
	
		$citationtyperow = $this->executemultiquery($sql);

		$citationtypeobj = new Locker_Support_Data($citationtypeid, $citationtyperow[0]['description']);
		$retval = $citationtypeobj;	

		return $retval;
	}	
	
   /**
	* getpubmediumtype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $pubmediumid
	*/
	public function getpubmediumtype($pubmediumid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_PUBMEDIUMTYPE."('%s');", $pubmediumid);
	
		$row = $this->executemultiquery($sql);

		$obj = new Locker_Support_Data($pubmediumid, $row[0]['description']);
		$retval = $obj;	

		return $retval;
	}

	/**
	* getpubmediumtypelist
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getpubmediumtypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_PUBMEDIUMTYPE_LIST."()";
		$row = $this->executemultiquery($sql);
					
		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Support_Data($row[$i]['pubmediumid'], $row[$i]['description']);
			$retval[] = $obj;	
		}

		return $retval;
	}
	
   /**
	* getmarketingoption
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $marketingprefid
	*/
	public function getmarketingoption($marketingprefid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_MARKETINGOPTION."('%s');", $marketingprefid);
	
		$marketingoptionrow = $this->executemultiquery($sql);

		$marketingoptionobj = new Locker_Support_Data($marketingprefid, $marketingoptionrow[0]['description']);
		$retval = $marketingoptionobj;	

		return $retval;
	}	
	
	
   /**
	* getmarketingoptionlist
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getmarketingoptionlist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_MARKETINGOPTION_LIST."()";
		$marketingoptionrow = $this->executemultiquery($sql);
					
		for ($i = 0; $i<count($marketingoptionrow); $i++)
		{

			$marketingoptionobj = new Locker_Support_Data($marketingoptionrow[$i]['marketingprefid'], $marketingoptionrow[$i]['description']);
			$retval[] = $marketingoptionobj;	
		}

		return $retval;
	}	

   /**
	* getcitationformatexample
	*
	* This function returns a Locker_Citation_Format_Example Object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Citation_Format_Example object
	*
	* @param	int $citationtypeid
	* @param	int $citationcontenttypeid
	*/
	public function getcitationformatexample($citationtypeid, $citationcontenttypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_CITATIONFORMATEXAMPLE."('%s','%s');", $citationtypeid, $citationcontenttypeid);
		$row = $this->executemultiquery($sql);

		$obj = new Locker_Citation_Format_Example($row[0]['citationformatexampleid'], $citationtypeid, $citationcontenttypeid, $row[0]['citationformat'], $row[0]['citationexample']);
		$retval = $obj;	

		return $retval;
	}	
	
   /**
	* getcitationformatexamplelist
	*
	* This function returns an array of  Locker_Citation_Format_Example Object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Citation_Format_Example $var
	*
	*/
	public function getcitationformatexamplelist()
	{			
		
		$retval = array();

		$sql =	"CALL ".GET_CITATIONFORMATEXAMPLE_LIST."()";
		$row = $this->executemultiquery($sql);

		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Citation_Format_Example($row[$i]['citationformatexampleid'], $row[$i]['citationtypeid'], 
													$row[$i]['citationcontenttypeid'], $row[$i]['citationformat'], $row[$i]['citationexample']);
			$retval[] = $obj;			
		}
		return $retval;
	}		
	
   /**
	* getcitationcontenttype
	*
	* This function returns a Locker_Citation_Content_Type object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Citation_Content_Type object
	*
	* @param	int $citationcontenttypeid
	*/
	public function getcitationcontenttype($citationcontenttypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_CITATIONCONTENTTYPE."('%s');", $citationcontenttypeid);
	
		$citationcontenttyperow = $this->executemultiquery($sql);
		$citationcontenttypeobj = new Locker_Citation_Content_Type($citationcontenttypeid, $citationcontenttyperow[0]['pubmediumid'], $citationcontenttyperow[0]['description']);
		$retval = $citationcontenttypeobj;	

		return $retval;
	}

   /**
	* getcitationcontenttypelist
	*
	* This function returns an  array of citation content type objects
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Citation_Content_Type $var
	*
	*/
	public function getcitationcontenttypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_CITATIONCONTENTTYPE_LIST."()";
	
		$citationcontenttypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($citationcontenttypelistrow); $i++)
		{

			$citationcontenttypelistobj = new Locker_Citation_Content_Type($citationcontenttypelistrow[$i]['citationcontenttypeid'], $citationcontenttypelistrow[$i]['pubmediumid'], $citationcontenttypelistrow[$i]['description']);
			$retval[] = $citationcontenttypelistobj;	
			
		}		

		return $retval;
	}	
	
   /**
	* getinteresttype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $interesttypeid
	*/
	public function getinteresttype($interesttypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_INTERESTTYPE."('%s');", $interesttypeid);
	
		$row = $this->executemultiquery($sql);

		$obj = new Locker_Support_Data($interesttypeid, $row[0]['intdesc']);
		$retval = $obj;	

		return $retval;
	}		
	
   /**
	* getcitationsourcetype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $citationsourcetypeid
	*/
	public function getcitationsourcetype($citationsourcetypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_CITATIONSOURCETYPE."('%s');", $citationsourcetypeid);
	
		$citationsourcetyperow = $this->executemultiquery($sql);

		$citationsourcetypeobj = new Locker_Support_Data($citationsourcetypeid, $citationsourcetyperow[0]['description']);
		$retval = $citationsourcetypeobj;	

		return $retval;
	}	

   /**
	* getprofiletype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $profiletypeid
	*/
	public function getprofiletype($profiletypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_PROFILETYPE."('%s');", $profiletypeid);
	
		$profiletyperow = $this->executemultiquery($sql);

		$profiletypeobj = new Locker_Support_Data($profiletypeid, $profiletyperow[0]['description'],'',$profiletyperow[0]['displaytext']);
		$retval = $profiletypeobj;	

		return $retval;
	}	
	
   /**
	* getassignmenttype
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $assignmenttypeid
	*/
	public function getassignmenttype($assignmenttypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_ASSIGNMENTTYPE."('%s');", $assignmenttypeid);
	
		$assignmenttyperow = $this->executemultiquery($sql);

		$assignmentypeobj = new Locker_Support_Data($assignmenttypeid, $assignmenttyperow[0]['description']);
		$retval = $assignmentypeobj;	

		return $retval;
	}		
	
   /**
	* getassignmentstatus
	*
	* This function returns Locker_Support_Data object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Support_Data object
	*
	* @param	int $assignmentstatusid
	*/
	public function getassignmentstatus($assignmentstatusid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_ASSIGNMENTSTATUS."('%s');", $assignmentstatusid);
	
		$assignmentstatusrow = $this->executemultiquery($sql);

		$assignmentstatusobj = new Locker_Support_Data($assignmentstatusid, $assignmentstatusrow[0]['description']);
		$retval = $assignmentstatusobj;	

		return $retval;
	}

   /**
	* gettasktype
	*
	* This function returns a Locker_Task_Type object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Task_Type object
	*
	* @param	int $tasktypeid
	*/
	public function gettasktype($tasktypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_TASKTYPE."('%s');", $tasktypeid);
	
		$tasktyperow = $this->executemultiquery($sql);

		$tasktypeobj = new Locker_Task_Type($tasktypeid, $tasktyperow[0]['title'], $tasktyperow[0]['description'], $tasktyperow[0]['sortpriority']);
		$retval = $tasktypeobj;	

		return $retval;
	}		
	

   /**
	* gettasktypelist
	*
	* This function returns an array of Locker_Task_Type objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Task_Type $var
	*
	*/
	public function gettasktypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_TASKTYPE_LIST."()";
	
		$tasktypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($tasktypelistrow); $i++)
		{
			//gettaskskillbuilderlist($tasktypeid)
			
			$tasktypelistobj = new Locker_Task_Type($tasktypelistrow[$i]['tasktypeid'], $tasktypelistrow[$i]['title'], $tasktypelistrow[$i]['description'], $tasktypelistrow[$i]['sortpriority']);
			$skillbuilderArray = $this->gettaskskillbuilderlist($tasktypelistrow[$i]['tasktypeid']);
			$tasktypelistobj->addskillbuilder($skillbuilderArray);
			$retval[] = $tasktypelistobj;	
			
		}		

		return $retval;
	}	
	

   /**
	* getfinaldraftformatlist
	*
	* This function returns an  array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getfinaldraftformatlist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_FINALDRAFTFORMAT_LIST."()";
	
		$finaldraftformatlistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($finaldraftformatlistrow); $i++)
		{

			$finaldraftformatlistobj = new Locker_Support_Data($finaldraftformatlistrow[$i]['finaldraftformatid'], $finaldraftformatlistrow[$i]['description']);
			$retval[] = $finaldraftformatlistobj;	
			
		}		

		return $retval;
	}		
	
   /**
	* getfinaldraftmodellist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getfinaldraftmodellist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_FINALDRAFTMODEL_LIST."()";
	
		$finaldraftmodellistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($finaldraftmodellistrow); $i++)
		{

			$finaldraftmodellistobj = new Locker_Support_Data($finaldraftmodellistrow[$i]['finaldraftmodelid'], $finaldraftmodellistrow[$i]['description'], $finaldraftmodellistrow[$i]['url']);
			$retval[] = $finaldraftmodellistobj;	
			
		}		

		return $retval;
	}	
	
   /**
	* getsecurityquestionlist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getsecurityquestionlist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_SECURITYQUESTION_LIST."()";
	
		$securityquestionlistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($securityquestionlistrow); $i++)
		{
			$securityquestionlistobj = new Locker_Support_Data($securityquestionlistrow[$i]['securityquestionid'], $securityquestionlistrow[$i]['description']);
			$retval[] = $securityquestionlistobj;	
		}		

		return $retval;
	}	
	
   /**
	* getinteresttypelist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getinteresttypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_INTERESTTYPE_LIST."()";
	
		$interesttypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($interesttypelistrow); $i++)
		{

			$interesttypelistobj = new Locker_Support_Data($interesttypelistrow[$i]['intid'], $interesttypelistrow[$i]['intdesc']);
			$retval[] = $interesttypelistobj;	
			
		}		

		return $retval;
	}		
	
   /**
	* getcitationtypelist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getcitationtypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_CITATIONTYPE_LIST."()";
	
		$citationtypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($citationtypelistrow); $i++)
		{

			$citationtypeobj = new Locker_Support_Data($citationtypelistrow[$i]['citationtypeid'], $citationtypelistrow[$i]['description']);
			$retval[] = $citationtypeobj;	
			
		}		

		return $retval;
	}	
	
   /**
	* getcitationsourcetypelist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getcitationsourcetypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_CITATIONSOURCETYPE_LIST."()";
	
		$citationsourcetypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($citationsourcetypelistrow); $i++)
		{

			$citationsourcetypeobj = new Locker_Support_Data($citationsourcetypelistrow[$i]['citationsourcetypeid'], $citationsourcetypelistrow[$i]['description']);
			$retval[] = $citationsourcetypeobj;	
			
		}		

		return $retval;
	}		
	
   /**
	* getprofiletypelist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getprofiletypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_PROFILETYPE_LIST."()";
	
		$profiletypelistrow = $this->executemultiquery($sql);

		for ($i = 0; $i<count($profiletypelistrow); $i++)
		{
			$profiletypelistobj = new Locker_Support_Data($profiletypelistrow[$i]['profiletypeid'], $profiletypelistrow[$i]['description'],'',$profiletypelistrow[$i]['displaytext']);
			$retval[] = $profiletypelistobj;	
		}		

		return $retval;
	}		
	
   /**
	* getassignmenttypelist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getassignmenttypelist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_ASSIGNMENTTYPE_LIST."()";
	
		$assignmenttypelistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($assignmenttypelistrow); $i++)
		{

			$assignmenttypelistobj = new Locker_Support_Data($assignmenttypelistrow[$i]['assignmenttypeid'], $assignmenttypelistrow[$i]['description']);
			$retval[] = $assignmenttypelistobj;	
			
		}		

		return $retval;
	}	

   /**
	* getassignmentstatuslist
	*
	* This function returns an array of Locker_Support_Data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Support_Data $var
	*
	*/
	public function getassignmentstatuslist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_ASSIGNMENTSTATUS_LIST."()";
	
		$assignmentstatusrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($assignmentstatusrow); $i++)
		{

			$assignmentstatuslistobj = new Locker_Support_Data($assignmentstatusrow[$i]['assignmentstatusid'], $assignmentstatusrow[$i]['description']);
			$retval[] = $assignmentstatuslistobj;	
			
		}		

		return $retval;
	}	
	

   /**
	* getinterestlist
	*
	* This function returns an array of Locker_Interest objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Interest $var
	*
	*/
	public function getinterestlist()
	{			
		
		$retval = array();
		$sql =	"CALL ".GET_INTEREST_LIST."()";
	
		$interestlistrow = $this->executemultiquery($sql);


		for ($i = 0; $i<count($interestlistrow); $i++)
		{

			$interestlistlistobj = new Locker_Interest($interestlistrow[$i]['intid'], $interestlistrow[$i]['pintid'], $interestlistrow[$i]['intdesc']);
			$retval[] = $interestlistlistobj;	
			
		}		

		return $retval;
	}	

   /**
	* getrubricquestion
	*
	* This function returns Locker_Rubric_Question object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Rubric_Question $var
	*
	* @param	int $rubricquestionid
	*/
	public function getrubricquestion($rubricquestionid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_RUBRICQUESTION."('%s');", $rubricquestionid);
	
		$rubricquestionrow = $this->executemultiquery($sql);

		$rubricquestionobj = new Locker_Rubric_Question($rubricquestionid,$rubricquestionrow[0]['tasktypeid'], $rubricquestionrow[0]['questiontext']);
		$retval = $rubricquestionobj;	

		return $retval;
	}	

   /**
	* getrubricquestionlist
	*
	* This function returns an array of Locker_Rubric_Question objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Rubric_Question $var
	*
	*/
	public function getrubricquestionlist($tasktypeid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_RUBRICQUESTION_LIST."('%s');", $tasktypeid);
	
		$row = $this->executemultiquery($sql);


		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Rubric_Question($row[$i]['rubricquestionid'], $tasktypeid, $row[$i]['questiontext']);
			$retval[] = $obj;	
		}		

		return $retval;
	}	

   /**
	* gettooltype
	*
	* This function returns Locker_Tool_Type object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Tool_Type object
	*
	* @param	int $tooltypeid
	*/
	public function gettooltype($tooltypeid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_TOOLTYPE."('%s');", $tooltypeid);
	
		$tooltyperow = $this->executemultiquery($sql);

		$tooltypeobj = new Locker_Tool_Type($tooltypeid,$tooltyperow[0]['title'], $tooltyperow[0]['description']);
		$retval = $tooltypeobj;	

		return $retval;
	}	


   /**
	* gettooltypelist
	*
	* This function returns an array of Locker_Tool_Type objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Tool_Type $var
	*
	*/
	public function gettooltypelist()
	{			
		
		$retval = array();
		$sql = "CALL ".GET_TOOLTYPE_LIST."();";
	
		$tooltypelistrow = $this->executemultiquery($sql);

		for ($i = 0; $i<count($tooltypelistrow); $i++)
		{
			
			$tooltypelistobj = new Locker_Tool_Type($tooltypelistrow[$i]['tooltypeid'], $tooltypelistrow[$i]['title'], $tooltypelistrow[$i]['description']);
			$retval[] = $tooltypelistobj;	
			
		}		

		return $retval;
	}	
	
   /**
	* getskillbuilder
	*
	* This function returns Locker_Skillbuilder object.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  Locker_Skillbuilder object
	*
	* @param	int $skillbuilderid
	*/
	public function getskillbuilder($skillbuilderid)
	{			
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_SKILLBUILDER."('%s');", $skillbuilderid);
	
		$skillbuilderrow = $this->executemultiquery($sql);

		$skillbuilderobj = new Locker_Skillbuilder($skillbuilderid,$skillbuilderrow[0]['title'],$skillbuilderrow[0]['description'], $skillbuilderrow[0]['sortpriority'], $skillbuilderrow[0]['lessonplanid']);
		$retval = $skillbuilderobj;	

		return $retval;
	}	

   /**
	* getskillbuilderlist
	*
	* This function returns an array of Locker_Skillbuilder data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Skillbuilder $var
	*
	*/
	public function getskillbuilderlist()
	{			
		
		$retval = array();
		$sql = "CALL ".GET_SKILLBUILDER_LIST."();";
	
		$row = $this->executemultiquery($sql);


		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Skillbuilder($row[$i]['skillbuilderid'], $row[$i]['title'], $row[$i]['description'], $row[$i]['sortpriority'], $row[$i]['lessonplanid']);
			$retval[] = $obj;		
		}		

		return $retval;
	}	

   /**
	* gettasktoollist
	*
	* This function returns an array of task tool data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Tool_Type $var
	* 
	* @param	int $tasktypeid
	*/
	public function gettasktoollist($tasktypeid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_TASKTOOL_LIST."('%s');", $tasktypeid);
	
		$row = $this->executemultiquery($sql);

		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Tool_Type($row[$i]['tooltypeid'], $row[$i]['title'], $row[$i]['description']);
			$retval[] = $obj;	
		}		

		return $retval;
	}	
	
   /**
	* gettaskskillbuilderlist
	*
	* This function returns an array of skill builder data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Skillbuilder $var
	*
	* @param	int $tasktypeid
	*/
	public function gettaskskillbuilderlist($tasktypeid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_TASKSKILLBUILDER_LIST."('%s');", $tasktypeid);
	
		$skillbuilderlistrow = $this->executemultiquery($sql);

		for ($i = 0; $i<count($skillbuilderlistrow); $i++)
		{
			$skillbuilderlistobj = new Locker_Skillbuilder($skillbuilderlistrow[$i]['skillbuilderid'], $skillbuilderlistrow[$i]['title'], $skillbuilderlistrow[$i]['description'], $skillbuilderlistrow[$i]['sortpriority'], $skillbuilderlistrow[$i]['lessonplanid']);
			$retval[] = $skillbuilderlistobj;	
		}		

		return $retval;
	}	
	
   /**
	* gettoolskillbuilderlist
	*
	* This function returns an array of skill builder data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Skillbuilder $var
	*
	* @param	int $tooltypeid
	*
	*/
	public function gettoolskillbuilderlist($tooltypeid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_TOOLSKILLBUILDER_LIST."('%s');", $tooltypeid);
	
		$skillbuilderlistrow = $this->executemultiquery($sql);

		for ($i = 0; $i<count($skillbuilderlistrow); $i++)
		{
			$skillbuilderlistobj = new Locker_Skillbuilder($skillbuilderlistrow[$i]['skillbuilderid'], $skillbuilderlistrow[$i]['title'], $skillbuilderlistrow[$i]['description'], $skillbuilderlistrow[$i]['sortpriority'], $skillbuilderlistrow[$i]['lessonplanid']);
			$retval[] = $skillbuilderlistobj;		
		}		

		return $retval;
	}	
	
   /**
	* getskillbuildertasklist
	*
	* This function returns an array of task data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Task_Type $var
	*
	* @param	int $skillbuilderid
	*/
	public function getskillbuildertasklist($skillbuilderid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_SKILLBUILDERTASK_LIST."('%s');", $skillbuilderid);
	
		$row = $this->executemultiquery($sql);

		for ($i = 0; $i<count($row); $i++)
		{
			$obj = new Locker_Task_Type($row[$i]['tasktypeid'], $row[$i]['title'], $row[$i]['description'], $row[$i]['sortpriority']);
			$retval[] = $obj;	
		}		

		return $retval;
	}	
	
   /**
	* getskillbuildertoollist
	*
	* This function returns an array of tool data objects.
	*
	* @author  Diane Palmer
	* @access  public 
	* 
	* @return  array[int]Locker_Tool_Type $var
	*
	* @param	int $skillbuilderid
	*/
	public function getskillbuildertoollist($skillbuilderid)
	{			
		
		$retval = array();
		$sql = sprintf("CALL ".GET_SKILLBUILDERTOOL_LIST."('%s');", $skillbuilderid);
	
		$row = $this->executemultiquery($sql);

		for ($i = 0; $i<count($row); $i++)
		{
			$toollistobj = new Locker_Tool_Type($row[$i]['tooltypeid'], $row[$i]['title'], $row[$i]['description']);
			$retval[] = $toollistobj;			
		}		

		return $retval;
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
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_DIGITALLOCKERFOLDERTYPE."('%s');", $digitallockerfoldertypeid);
	
		$row = $this->executemultiquery($sql);

		$obj = new Locker_Support_Data($digitallockerfoldertypeid, $row[0]['description']);
		$retval = $obj;	

		return $retval;
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
		
		$retval = NULL;
		$sql = sprintf("CALL ".GET_GLOBALTYPESDIGITALLOCKERFOLDERTYPE."('%s');", $globaltype);
	
		$row = $this->executemultiquery($sql);

		$obj = new Locker_Support_Data($row[0]['digitallockerfoldertypeid'], $row[0]['description']);
		$retval = $obj;	

		return $retval;
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
		
		$retval = array();
		$sql =	"CALL ".GET_DIGITALLOCKERFOLDERTYPE_LIST."()";
		$row = $this->executemultiquery($sql);
		
		echo "ROW " . count($row);
					
		for ($i = 0; $i<count($row); $i++)
		{

			$obj = new Locker_Support_Data($row[$i]['digitallockerfoldertypeid'], $row[$i]['description']);
			$retval[] = $obj;	
		}

		return $retval;
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
		$retval = NULL;
		$sql = sprintf("CALL ".GET_READINGLEVEL."('%s','%s');", $lexilelevel, $productid);
		$row = $this->executemultiquery($sql);
		return $row[0]['reading_level'];
	}	
	
	/**
	* createDbConnection
	* 
	* This function takes in a profileid.  Parses out the profileid and shardid.  Then creates the DB connection strings.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* 
	* @param	string $shardid
	*/	
	private function createDbConnection($shardid)
	{		
		$memcacheLoaded = false;
		//Check memcache to see if the the parentid exists.
		$memcache = new Memcache;
		$get_result = NULL;

		if($memcache->connect($_SERVER['SERVER_NAME'], 11211))
		{
			$memcacheLoaded = true;
			$get_result = $memcache->get('dbconnectshard-'.$shardid);	
		}
		else 
		{
			//throw new SoapFault("Server","Memcache Connection Error on locker1.");
			//return
		}
		
		if($get_result == NULL)
		{
			//GO TO DB AND GET INFO!!!
			$sql = sprintf("CALL ".GET_SHARDBYSHARDID."('%s');", $shardid);
			$row = $this->executeiauthmultiquery($sql);
			
			$get_result = new Locker_DB_Connect($row[0]['db_hostname'],$row[0]['db_username'],$row[0]['db_password'],$row[0]['db_name']);
			if($memcacheLoaded)
			{			
				$memcache->set('dbconnectshard-'.$shardid, $get_result, false, 10) or die ("Failed to save data at the server");
			}
		}

		$this->_dbConn = new mysqli($get_result->gethostname(), $get_result->getusername(), $get_result->getpassword(), $_SERVER['LOCKER_SUPPORT_DATABASE_NAME']) ;
		if (mysqli_connect_errno()) 
		{
			throw new SoapFault("Server","Database Connection Error on locker1support.".$get_result->gethostname().' , '.$get_result->getusername().' , '.$get_result->getpassword().' , '.$_SERVER['LOCKER_SUPPORT_DATABASE_NAME']);
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
	
	/**
	* executemultiquery
	*
	* This function takes in a query and returns a array of rows.  If there is only 1 row returned from the query.
	* then the function returns only the first row.  This makes it easier to access the rows columns.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array of database rows
	* 
	* @param	string $query
	*/	
	private function executemultiquery($query)
	{		
		$retval = array();
			
		if ($this->_dbConn->multi_query($query)) 
		{
		    do 
		    {
			    if ($result = $this->_dbConn->store_result()) 
			    {
			    	while ($row = $result->fetch_assoc()) 
			    	{
		                $retval[] = $row;
		            }
		            $result->free();
		        }
		
		    } while ($this->_dbConn	->next_result());
		}
						
		return $retval;
	}	
	
	/**
	* executeiauthmultiquery
	*
	* This function takes in a query and returns a array of rows.  If there is only 1 row returned from the query.
	* then the function returns only the first row.  This makes it easier to access the rows columns. 
	* THIS IS FOR THE IAUTH QUERYS
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array of database rows
	* 
	* @param	string $query
	*/	
	private function executeiauthmultiquery($query)
	{		
		$retval = array();
			
		if ($this->_iauthDBConn->multi_query($query)) 
		{
		    do 
		    {
			    if ($result = $this->_iauthDBConn->store_result()) 
			    {
			    	while ($row = $result->fetch_assoc()) 
			    	{
		                $retval[] = $row;
		            }
		            $result->free();
		        }
		
		    } while ($this->_iauthDBConn->next_result());
		}
						
		return $retval;
	}	
}//END OF CLASS


if($_REQUEST['testing']==1)
{
	$server = new Locker_Support_Server();
	echo "<pre>";
		print_r($server->getdigitallockerfoldertypelist());
	echo "</pre>";	
}
else
{

	ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache 
	$server = new SoapServer($_SERVER["LOCKER1_CONFIG"]."/lockersupport.wsdl");
	$server->setClass("Locker_Support_Server");
	$server->handle();
}
?>