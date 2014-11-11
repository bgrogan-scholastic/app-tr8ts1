<?php
	require_once('../common/network/grSoapClient.inc');
	require_once('../common/utils/XMLParser.inc');

	/* default to no results found */
	$hasResults = "false";

	$querystring = '';
	$product = $_GET['product'];
	$database = '';

        if ($product == 'go2-passport') {
                /* search the ea/gme subset of ebsco in the passport side */
                $database = 'glh';
        }
        else if ($product == 'go2-kids') {
                /* search the nbk set of ebsco in the kids side */
                $database = 'gkh';
        }

	/* determine the search should be "title/abstract" or full-text */

	
	if (array_key_exists('ebquery', $_GET) == TRUE) {
		$editfield1 = $_GET['ebquery'];
		$querystring = "((".$editfield1.") and ft y)";
	}

	/* full-text search is always off, title/full-text searches will produce the same results */
	$searchFullText = 'False';

	/* get a connection to ebsco's web services descriptor */
	$wsdl = new SOAP_WSDL("http://xml.epnet.com/oemdirectxml/oemdirectxml.asmx?wsdl");

	if($wsdl)
	{
		$webservice=$wsdl->getProxy();
		if($webservice)
		{

			/* login to the ebsco service */
			$authRequest = array(
						'userID' => '',
						'userPwd' => '',
						'profileID' =>'ehost'
					);

			/* initialize our ebsco request */
			$retval=$webservice->Init($authRequest);

			if($retval)
			{
				$sessionID = $retval->sessionID;

				/* define the search parameters that should be used */
				$searchRequest = array(
					'db' 		=> 	$database,
					'booleanQuery'	=>	$querystring,
					'searchText'	=>	$searchFullText,
					'applyThes'	=>	'Default',
					'sort'		=>	'Date'
							);

				$articleRequest = array(
					'startRecNo'	=>	0,
					'noRecs'	=>	0,
					'format'	=>	'Full',
					'mode'		=>	'XHTML',
					'highlight'	=>	'False'
							);

				$oldparse = $webservice->setXMLParse('noparse');
				$article=$webservice->SearchPresent($authRequest, $sessionID, $searchRequest, $articleRequest);
				$result = $webservice->setXMLParse($oldparse);

				if($article)
				{
					$xmlP = new XMLParser();
					$numberOfResults = $xmlP->XPathValue('soap:Envelope/soap:Body/SearchPresentResponse/searchResults/totalHits', $article);

					if ($numberOfResults > 0) {
						if ($numberOfResults > 50) {
							/* we only only allowed to show 50 full-text results as part of our contract with ebsco */
							$hasResults = 50;
						}
						else {
							$hasResults = $numberOfResults;
						}
					}
					else {
						$hasResults = "false";
					}
				}
			}
		}
	}

	echo $hasResults;
?>
