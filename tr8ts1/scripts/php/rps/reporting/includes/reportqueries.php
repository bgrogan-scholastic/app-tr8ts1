<?php
		 
/* the data query to use for newly classified and revised classified assets*/
$indexQueries = array(
		'new' => array(
				'query' => "select lmb, asset_type, count(distinct asset_id) RECORDCOUNT from reports_mv where product='##MYPRODUCTCODE##' and index_type='##INDEXTYPE##' and cdate >=mdate and cdate >= to_date('##STARTDATE## 00:00', 'MM/DD/YYYY HH24:MI') and cdate <= to_date('##ENDDATE## 23:59', 'MM/DD/YYYY HH24:MI') group by lmb, asset_type order by lmb ASC, asset_type ASC",
		)
		,
		
		'revised' => array(
				'query' => "select lmb, asset_type, count(distinct asset_id) RECORDCOUNT from reports_mv where product='##MYPRODUCTCODE##' and index_type='##INDEXTYPE##' and cdate < mdate and mdate >= to_date('##STARTDATE## 00:00', 'MM/DD/YYYY HH24:MI') and mdate <= to_date('##ENDDATE## 23:59', 'MM/DD/YYYY HH24:MI') group by lmb, asset_type order by lmb ASC, asset_type ASC",
		)
		,
/* ~CM 5/14/04	- query for unclassified assets, test using username classdbm */
		'unclassified' => array(
				'query' => "select uca_count, uca_asset_type from unclassified_assets where uca_product='##MYPRODUCTCODE##' and uca_index_type='##INDEXTYPE##' group by uca_count, uca_asset_type order by uca_count ASC, uca_asset_type ASC",
		)
	);

/************************* prepare a new and revised query based on product and the index ***********************/
function prepareIndexQueries($indexQueries, $productID, $indexType) {
	$startDateTime = strtotime($_GET['startyear'] . '-' . $_GET['startmonth'] . '-' . $_GET['startday']);
	$endDateTime = strtotime($_GET['endyear'] . '-' . $_GET['endmonth'] . '-' . $_GET['endday']);	

	/* convert the start date and end date to oracle format */
	$oracleStartDateStamp = date('m/d/Y', $startDateTime);
	$oracleEndDateStamp = date('m/d/Y', $endDateTime);
		
	/* get the newly classified assets query */	
		$myNewIndexQuery = $indexQueries['new']['query'];
		
		/* substitute the date range into the query */
		$myNewIndexQuery = str_replace('##STARTDATE##', $oracleStartDateStamp, $myNewIndexQuery);
		$myNewIndexQuery = str_replace('##ENDDATE##', $oracleEndDateStamp, $myNewIndexQuery);

		/* substitute the product code for the current product row */
		$myNewIndexQuery = str_replace('##MYPRODUCTCODE##', $productID, $myNewIndexQuery);

		/* substitute the index type */
		$myNewIndexQuery = str_replace('##INDEXTYPE##', $indexType, $myNewIndexQuery);

	
	/* get the revised classified assets query */
		$myRevisedIndexQuery = $indexQueries['revised']['query'];

		/* substitute the date range into the query */
		$myRevisedIndexQuery = str_replace('##STARTDATE##', $oracleStartDateStamp, $myRevisedIndexQuery);
		$myRevisedIndexQuery = str_replace('##ENDDATE##', $oracleEndDateStamp, $myRevisedIndexQuery);

		/* substitute the product code for the current product row */
		$myRevisedIndexQuery = str_replace('##MYPRODUCTCODE##', $productID, $myRevisedIndexQuery);

		/* substitute the index type */
		$myRevisedIndexQuery = str_replace('##INDEXTYPE##', $indexType, $myRevisedIndexQuery);

/* ~CM 5/14/04	- query for unclassified assets, test using username classdbm */
	/* get the unclassified assets query */
		$myUnclassifiedIndexQuery = $indexQueries['unclassified']['query'];

		/* substitute the product code for the current product row */
		$myUnclassifiedIndexQuery = str_replace('##MYPRODUCTCODE##', $productID, $myUnclassifiedIndexQuery);

		/* substitute the index type */
		$myUnclassifiedIndexQuery = str_replace('##INDEXTYPE##', $indexType, $myUnclassifiedIndexQuery);

	
	/* the return value is an array with 2 keys - news/revised */
	return array(
		'new' => $myNewIndexQuery,
		'revised' => $myRevisedIndexQuery,
/* ~CM 5/14/04	- Add 3rd key unclassified */
		'unclassified' => $myUnclassifiedIndexQuery
		);
}
?>
