<?php
if(array_key_exists('refreshdata', $_GET) && $_GET['refreshdata'] == 'yes') {
	/* if the user selected to refresh the materialized view, make it so. */
	/* refresh the materialized view - reports_mv using a pl/sql block of code */
	$myReportsRefreshObject = new GI_DBQuery("BEGIN CLASSDBM_REPORTSMV_REFRESH; END;", $myDatabase);
	$myReportsRefreshObject->ExecuteQuery();
}
?>

