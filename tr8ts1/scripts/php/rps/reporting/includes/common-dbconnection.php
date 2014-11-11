<?php
				
	$myProperties = array( 
			'username' => getenv( 'RPS_REPORTS_DB_USERNAME' ),
			'password' => getenv( 'RPS_REPORTS_DB_PASSWORD' ),
			'databasename' => getenv( 'RPS_REPORTS_DB_DATABASENAME' ),
			'connectionname' => getenv( 'RPS_REPORTS_DB_CONNECTIONNAME' )
		);	

	
	/************************* get a connection to the database *************************/
	require_once(getenv('PHP_SCRIPTS_HOME') . '/rps/common/database/GI_SingletonDB.php');
	require_once(getenv('PHP_SCRIPTS_HOME') . '/rps/common/database/GI_DBQuery.php');
	$myDatabase = GI_SingletonDB::instance($myProperties['connectionname'], $myProperties['username'], $myProperties['password'], $myProperties['databasename']);
?>
