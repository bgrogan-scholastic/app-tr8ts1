<?php

include($_SERVER['GI_INCLUDE_PATH'].'database/GI_DB/GI_DB.php');
include($_SERVER['GI_INCLUDE_PATH'].'database/atb/atb.php');

class TimeLineCompareReport {
	
	/**
	 * @var 
	 * @access protected
	 */
	protected $_assetID1 = "";
	
	/**
	 * @var @access protected
	 */
	protected $_assetID2 = "";
	
	/**
	 * @var
	 * @access protected
	 */
	protected $_report = array();
	
	/**
	 * @var Constant: A valid value for $_db_arch property
	 */
	const GI_DAO = 'DAO'; 
	
	/**
	 * @var Constant: A valid value for $_db_arch property
	 */
	const MYSQLI_DIRECT = 'MYSQLI_DIRECT';
	
	/**
	 * @var Constant: A valid value for $_db_arch property
	 */
	const MYSQL_DIRECT = 'MYSQL_DIRECT';

	/**
	 * @var Type of db architecture to use.
	 * @access protected
	 */
	protected $_db_arch = "";
	
	/**
	 * @var State 1 name.
	 * @access protected
	 */
	protected $_state1_name = "";
	
	
	/**
	 * @var State 2 name
	 * @access protected
	 */
	protected $_state2_name = "";
	
	
	/**
	 * @name construct
	 */
	public function __construct($assetID1, $assetID2, $db_arch) {

		//  set db_arch property or throw an exception if it is not correct 
		if (   ($db_arch == self::GI_DAO)
			|| ($db_arch == self::MYSQLI_DIRECT
			|| ($db_arch == self::MYSQL_DIRECT))) {
				
			$this->_db_arch = $db_arch;
		}
		else {
			throw new Exception("Invalid database architecture specified.  Use constants DAO or MYSQLI_DIRECT.");
		}
		
		//  set the asset id properties
		$this->_assetID1 = $assetID1;
		$this->_assetID2 = $assetID2;
	
		//  run the report
		$this->_run();
	}

	/**
	 * @name run the report
	 * 
	 */
	protected function _run() {
				
		//  these are populated with above objects. 
		$asset1Events = array();
		$asset2Events = array();
		
		try {
		
			switch ($this->_db_arch) {
			
				case self::GI_DAO:
					
					//  get the data for both id's
					//  We found a bug with MYSQLI in combination with using the 
					//  following architecture in the Apache environment.
					//
					//  The GI_Dao->_query() method crashes.  See source for details.

					//  create an instance of the DAO
					$tlevents_dao = new TLEventsDAO();
				
					//  use the getWhere to get the events
					$asset1Events =  $tlevents_dao->getWhere('id = \''.$this->_assetID1.'\'', 'start_date');		
					$asset2Events =  $tlevents_dao->getWhere('id = \''.$this->_assetID2.'\'', 'start_date');

					break;
		
				case self::MYSQLI_DIRECT: 

					//   get the state names
					$this->_state1_name = $this->_getStateNameMYSQLI($this->_assetID1);
					$this->_state2_name = $this->_getStateNameMYSQLI($this->_assetID2);
				
					//  get the state events
					$asset1Events = $this->_getAssetTimelineMYSQLI($this->_assetID1);
					$asset2Events = $this->_getAssetTimelineMYSQLI($this->_assetID2);
				
					break;

				case self::MYSQL_DIRECT: 

					//   get the state names
					$this->_state1_name = $this->_getStateNameMYSQL($this->_assetID1);
					$this->_state2_name = $this->_getStateNameMYSQL($this->_assetID2);
				
					//  get the state events
					$asset1Events = $this->_getAssetTimelineMYSQL($this->_assetID1);
					$asset2Events = $this->_getAssetTimelineMYSQL($this->_assetID2);
				
					break;
					
			}
		}
		catch (Exception $e) {
			printf("\nException getting all tlevents.");
			printf("\n%s", $e->getMessage());	
		}
	
		//  build the report from the query
		$this->_buildReport($asset1Events, $asset2Events);	
	}
	
	/**
	 * @name Build the report from the passed arrays.
	 *
	 * @param array $asset1Events
	 * @param array $asset2Events
	 * @return unknown
	 */
	protected function _buildReport($asset1Events, $asset2Events) {
					
		//  These are objects- 1 object is a row of data from tlevents.
		//  The properties are the columns.
		$asset1Event = null;
		$asset2Event = null;
		
		//  get the first events for each state
		$asset1Event = current($asset1Events);
		$asset2Event = current($asset2Events);
			
		// while we have an event to asset 1 or asset 2
		while ($asset1Event || $asset2Event) {
				
			//  This is one line of a report
			$reportLine = array();
				
			// if we have a state 1
			if ($asset1Event) {
					
				//  if we have state 2 event
				if ($asset2Event) {
		
					//  print state 1 if it's date is less than state 2's date
					if ($asset1Event->start_date < $asset2Event->start_date) {
							
						//printf("\n%10s\t%10s", $asset1Event->start_date, substr($asset1Event->text, 1, 10));
						
						//  populate the report line
						$reportLine['event_1'] = $asset1Event;
						$reportLine['event_2'] = null;
							
						//  increment state 1 array pointer
						next($asset1Events);
						$asset1Event = current($asset1Events);
					}
					elseif ($asset1Event->start_date == $asset2Event->start_date) {
							
						//  print both states events- they have the same date
						//printf("\n%10s\t%10s\t%10s\t%10s",
						//			 $asset1Event->start_date, substr($asset1Event->text, 0, 10),
	 					//			 $asset2Event->start_date, substr($asset2Event->text, 0, 10));
						
						//  populate the report line
						$reportLine['event_1'] = $asset1Event;
						$reportLine['event_2'] = $asset2Event;
	
						//  increment state 1 array pointer
						next($asset1Events);
						$asset1Event = current($asset1Events);
							
						//  increment state 2 array pointer
						next($asset2Events);
						$asset2Event = current($asset2Events);
							
					}
					elseif ($asset1Event->start_date > $asset2Event->start_date) {
		
						//printf("\n%10s\t%10s\t%10s\t%10s", "", "", 
						//			$asset1Event->start_date, substr($asset2Event->text, 0, 10));
	
						//  populate the report line
						$reportLine['event_1'] = null;
						$reportLine['event_2'] = $asset2Event;
							
						//  increment events 2 array pointer
						next($asset2Events);
						$asset2Event = current($asset2Events);
					}	
				}
			}
			else {
				
				//  we don't have a state 1, so we only print out state 2 if we have that
				//  and we should or the loop wouldn't work.  we'll check anyway.
				if ($asset2Event) {
					//printf("\n%10s\t%10s\t%10s\t%10s", " ", " ", 
					//			$asset2Event->start_date, substr($asset2Event->text, 0, 10));
							//  populate the report line
					$reportLine['event_1'] = null;
					$reportLine['event_2'] = $asset2Event;

					//  increment asset 2 array pointer
					next($asset2Events);	
					$asset2Event = current($asset2Events);
				}
			}
							
			//  add the report line to the report
			array_push($this->_report, $reportLine);
		}
		
		//  we don't return anything.
		//  if we do discover error conditions, we'll throw exceptions.
		return null;
	}
	
	/**
	 * @name Get an assets timeline using the mysqli extension.
	 * @access protected
	 */
	protected function _getAssetTimelineMYSQL($assetid) {

		//  get DB connection singleton
		$DBConn = GI_DBMySQL::getInstance();
			
		//  get connection
		$db_conn = $DBConn->getConnection();

		//  the sql
		$sql = "select id, start_date, start_sig, stop_sig, text, stop_dsig, stop_date from tlevents where id = '$assetid'";
		
		// get the result
		$result = mysql_query($sql, $db_conn);

		//  if error, throw exception
		if (!$result) {
			mysql_free_result($result);		
			throw new Exception(mysql_errno().': '.mysql_error());
		}
		
		//  here is where we place the objects we fetch from the result
		$data = array();
		
		// -- use accordingly
		//  fetch the first row
		//  mysql
		$obj = mysql_fetch_object($result);
		
		//  while we have an object
		while ($obj){
			$text = $obj->text;
			array_push($data, $obj);
			$obj = mysql_fetch_object($result);
	   	}
		
	   	//  free the results
	   	mysql_free_result($result);
	   	
	   	return $data;
		
	}
	
	/**
	 * @name Get asset timeline using the mysql extension.
	 * @access protected
	 */
	protected function _getAssetTimelineMYSQLI($assetid) {
	
		//  get DB connection singleton
		$DBConn = GI_DBMySQLI::getInstance();
				
		//  get connection
		$db_conn = $DBConn->getConnection();

		//  the sql
		$sql = "select id, start_date, start_sig, stop_sig, text, stop_dsig, stop_date from tlevents where id = '$assetid'";
		
		// get the result
		$result = $db_conn->query();
			
		//  if error, throw exception
		if ($result) {
			$result->close();
			throw new Exception($db_conn->errono.': '.$db_conn->error);
		}
		
		//  here is where we place the objects we fetch from the result
		$data = array();
		
		//  fetch the first row
		$obj=$db_conn->fetch_object();
		
		//  while we have an object
		while (!is_null($obj)){
			array_push($data, $obj);
			$obj = $result->fetch_object();
	   	}
		
	   	//  close the results
	   	$result->close();
	   	
	   	return $data;	
	}	
	
	/**
	 * @name Get a states name using mysqli directly.
	 * @access protected
	 */
	protected function _getStateNameMYSQLI($assetid) {

		//  the id in the state table is, well, the following
		$stateID = substr($assetid, 0, 3).substr($assetid, 5);
		
		//  get DB connection singleton
		$DBConn = GI_DBMySQLI::getInstance();
			
		//  get connection
		$db_conn = $DBConn->getConnection();

		//  the sql
		$sql = "select state_name from states where state_base = '$stateID'";
		
		// get the result
		$result = $db_conn->query($sql);
		
		//  if error, throw exception
		if ($db_conn->errno != 0) {
			$result->close();
			throw new Exception($db_conn->errono.': '.$db_conn->error);
		}
		
		//  fetch the first row
		$obj = $result->fetch_object();
		
		$result->close();
		
		//  while we have an object
		if (!is_null($obj)){
			return $obj->state_name;
	   	}
	   	else {
	   		return "";
	   	}
	}

	/**
	 * @name Get a states name using mysql directly.
	 * @access protected
	 */
	protected function _getStateNameMYSQL($assetid) {

		//  the id in the state table is, well, the following
		$stateID = substr($assetid, 0, 3).substr($assetid, 5);
		
		//  get DB connection singleton
		$DBConn = GI_DBMySQL::getInstance();
			
		//  get connection
		$db_conn = $DBConn->getConnection();

		//  the sql
		$sql = "select state_name from states where state_base = '$stateID'";
		
		// get the result
		$result = mysql_query($sql, $db_conn);
		
		//  if error, throw exception
		if (!$result) {
			throw new Exception(mysql_errno().': '.mysql_error());
		}
		
		//  fetch the first row
		$obj = mysql_fetch_object($result);
		
		//  free the result
		mysql_free_result($result);
		
		//  while we have an object
		if (!is_null($obj)){
			return $obj->state_name;
	   	}
	   	else {
	   		return "";
	   	}
	}
	
	/**
	 * @name return the report data
	 * @access public
	 */
	public function getReport() {
		return $this->_report;
	}
	
	/**
	 * @name
	 * @access public
	 */
	public function getState1Name() {
		return $this->_state1_name;
	}
	
	/**
	 * @name
	 * @access public
	 */
	public function getState2Name() {
		return $this->_state2_name;
	}
}
?>
