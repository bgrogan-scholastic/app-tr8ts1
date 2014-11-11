<?php

/* include all of the request interface classes */
require_once('/data/ngo1/scripts/php/common/search/package.php');

$wsdl_url = "http://csdev.grolier.com:2200/services/search?wsdl";

/*****************************************************************
*		AUTHENTICATION TEST				 *
*****************************************************************/
$username = "slp_gi_engineering";
$password = "36ptool";
$authReq = new AuthenticationRequest();
$authReq->setUsername($username);
$authReq->setPassword($password);
$searchClient = new Search_SOAPClient($wsdl_url, $authReq);
$authResp = $searchClient->getAuthenticationResponse();

if ($authResp->getIsAuthenticated() === FALSE) {
	echo "Authentication Failed!, Aborting other tests....\n";
}
else {
	echo "Authentication Succeeded:\n";
	echo "\tUsername: $username\n";
	echo "\tPassword: $password\n";
	echo "\tAuth Token: " . $authResp->getToken() . "\n";
	echo "\tMethods Available:\n";
	foreach ($authResp->getMethods() as $method) {
		echo "\t\t" . $method . "\n";
	}
	echo "\tIndexes Available:\n";
	foreach ($authResp->getIndexes() as $index) {
		echo "\t\t" . $index . "\n";
	}
	echo "\tDisplay Fields Available:\n";
	foreach ($authResp->getDisplayFields() as $index) {
		echo "\t\t" . $index . "\n";
	}
	echo "\n";


	/*****************************************************************
	*		SEARCH TEST				 	 *
	*****************************************************************/

	/* a single search filter with multiple values is OR'd */
	/* multiple search filters implies an AND between the results of the filters */
	$searchFilterA = new SearchFilter();
	$searchFilterA->setKey("GlobalSearchAssets");
	$searchFilterA->setFilterType(0);	//0 is a search filter, 1 is a search filter view
	$searchFilterA->setField("product_navigation");
	$searchFilterA->setValues( array("GO//Articles") );
	$searchFilterA->setValuesType(0);	//0 is a literal interpretation of the values selected.
						//1 is a range selection, only two values are required
	$searchFilterB = new SearchFilter();
	$searchFilterB->setKey("LexileRanges");
	$searchFilterB->setFilterType(0);	//0 is a search filter, 1 is a search filter view
	$searchFilterB->setField("lexile");
	$searchFilterB->setValues( array(0,800,1000,1100) );
	$searchFilterB->setValuesType(1);	//0 is a literal interpretation of the values selected.

	$searchFilterViewA = new SearchFilter();
	$searchFilterViewA->setKey("GlobalSearchAssetsView");
	$searchFilterViewA->setFilterType(1);		// 1 indicates a view of this filter
	$searchFilterViewA->setField( "Asset Type" );
	$searchFilterViewA->setValues(null);
	$searchFilterViewA->setValuesType(0);

	/* make sure to terminate the search filter chain, this is also done server-side,
		but it's a safer if the client does so as well */
	$searchFilterViewA->setNextSearchFilter(searchFilterB);

	/* make sure to chain the filter view to the search filter so it gets executed next */
	$searchFilterB->setNextSearchFilter( $searchFilterViewA );

	$searchReqB = new SearchRequest();
	$searchReqB->setStartingPosition(1);
	$searchReqB->setNumResults(25);
	$searchReqB->setQuery("*");
	$searchReqB->setQueryParser("Grolier_En");
	$searchReqB->setDisplayFields( array('assetid', 'type', 'title', 'lexile') );
	$searchReqB->setIndexes( array("go2") );
	$searchReqB->setFirstSearchFilter($searchFilterA);

	$searchReqs = array($searchReqB);

	$searchResps = $searchClient->search($searchReqs);

	echo "Search Response:\n";
	foreach($searchResps as $searchResponse) {
		if ($searchResponse->getErrorCode() !== -1) { 
			echo "Search Request Failed:!!\n";
			echo "\t\tMessage from Server: " . $searchResponse->getErrorMessage() . "\n";
		}
		else {
			echo "Search Succeeded:\n";
			echo "\t" . $searchResponse->getNumHits() . "\n";
			echo $searchResponse->getResultsXML();
		}
	}

	/****************************************************************
	*			END TEST CASES				*
	****************************************************************/
}

