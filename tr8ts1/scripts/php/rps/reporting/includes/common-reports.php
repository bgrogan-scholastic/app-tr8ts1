<?php
	/* get the database connection */
	require_once('includes/common-dbconnection.php');
	
	/* get the report queries for newly classified and revised classified assets */
	require_once('includes/reportqueries.php');
	
	/* the start and end dates to generate a report within */
	$startDateTime = strtotime($_GET['startyear'] . '-' . $_GET['startmonth'] . '-' . $_GET['startday']);
	$endDateTime = strtotime($_GET['endyear'] . '-' . $_GET['endmonth'] . '-' . $_GET['endday']);	
	
	/* how should the date be displayed to the user? */
	$startDateDescription = date('j/M/y', $startDateTime);
	$endDateDescription = date('j/M/y', $endDateTime);
	
	/* the order to show the indexes in */
	$indexOrder = array ('subject', 'lc', 'dewey', 'time', 'form', 'place', 'keywords', 'ebsco');
	
	/* the descriptions used when outputting each index row header*/
	$indexDescriptions = array(
				'subject' => 'Subject Index',
				'lc' => 'Library Of Congress Subject Headings',
				'dewey' => 'Dewey Decimal Classification',
				'time' => 'Time Classification',
				'form' => 'Form Classification',
				'place' => 'Place Classification',
				'keywords' => 'Keyword Classification',
				'ebsco' => 'Ebsco Classification'
			);
			
	
	
	/* do we need to refresh the view */
	require_once('includes/refreshview.php');
	
	/* get a list of asset types from the database */
	require_once('includes/gi_assettypes.php');
	$myAssetTypes = new GI_AssetTypes($myDatabase);
?>
