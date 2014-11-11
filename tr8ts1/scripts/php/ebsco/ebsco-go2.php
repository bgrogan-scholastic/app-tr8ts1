<?php

	require_once('include/EbscoNumResults.inc');

	echo "\n<!-- SOAP VERSION -->\n";
	echo "<!-- server: ".$_SERVER['SERVER_NAME']." -->\n";

	// Note that we fetch individual elements rather than simply
	// extract()ing the $_REQUEST array to prevent malicious users
	// from feeding unintended parameters into the system.

	$product = $_REQUEST['product'];
	$docid = $_REQUEST['docid'];
	$NoRec = $_REQUEST['NoRec'];
	$StartRecNo = $_REQUEST['StartRecNo'];
	$editfield1 = stripslashes($_REQUEST['editfield1']);

	$bqoverride = stripslashes($_REQUEST['booleanquery']);
	$dboverride = $_REQUEST['db'];
	$stoverride = $_REQUEST['searchtext'];
	if($_REQUEST['norecs'])
		$NoRec=$_REQUEST['norecs'];

	$index_override = 0;

	if(!$StartRecNo) $StartRecNo = 1;
	if(!$NoRec)
	{
		if($StartRecNo > 36)
		{
			$NoRec = 51-$StartRecNo;
			$index_override = 1;
		} else {
			$numResults = new EbscoNumResults();
			$NoRec = $numResults->getValue($product);
		}
	}

	$query = "((".$editfield1.") and ft y)";

	echo "<!-- \$query = $query -->\n";

	$database = '';
	if ($product == 'go2-passport') {
		/* search the ea/gme subset of ebsco in the passport side */
		$database = 'glh';
	}
	else if ($product == 'go2-kids') {
		/* search the nbk set of ebsco in the kids side */
		$database = 'gkh';
	}


	/* don't differentiate between title and full-text searching, it doesn't seem to work as expected */
	$searchtext = 'n';

	// 11/21/2003: R.E. Dye - To enable query checking from fmp, provision is being
	// added for overriding the boolean query returned by the MYSQL database with
	// one provided in the GET parameters.
	if($bqoverride)
		$query = $bqoverride;
	if($dboverride)
		$database = $dboverride;

	// 12/4/2003: R.E. Dye - We also need to be able to override the 'searchtext'
	// parameter retrieved from the database.  This is a bit trickier, though.
	// If we're overriding, then we need to make 'searchtext' a null or no, even
	// if it's yes in the retrieved query...
	if($bqoverride || $dboverride)
	{
		if($stoverride)
			$searchtext = 'y';
		else
			$searchtext = '';
	}

	if(!$query)
	{
		echo "Unable to retrieve the boolean query.<br>\n";
	} else {
		//echo "\n<!-- $query -->\n";
		echo "<!-- \$searchtext = $searchtext -->\n";

		// Now we need the SOAP stuff.
		include_once($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/include/FetchSOAP.inc');
		if($NoRec == 1 && !$index_override)
		{			
			//This is a single Journal entry
			$ebdocument=FetchSOAP($query, $database, $NoRec, $StartRecNo, 'Full', $searchtext);
			if($ebdocument)
			{
				include_once($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/include/EntryParseAndFormat.inc');
				$mycontrol = new EntryParseAndFormat($product);
				echo $mycontrol->parseXMLdocument($ebdocument);
			} else {
				echo "<p><b>EBSCO, our online magazine article provider, is currently unavailable</b></p>\n";
				echo "<p><b>Please try your request again later.</b></p>\n";
			}
		} else {

		//This is an index
			$ebdocument = FetchSOAP($query, $database, $NoRec, $StartRecNo, 'Detailed', $searchtext);
			if($ebdocument)
			{
				//echo "<!-- \$ebdocument -->\n";
				//echo "$ebdocument\n";
				//echo "<!-- End of \$ebdocument -->\n\n";
				include_once($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/include/IndexParseAndFormat.inc');
				$mycontrol = new IndexParseAndFormat($docid, $product, $editfield1);
				echo $mycontrol->parseXMLdocument($ebdocument);
			} else {
				echo "<p><b>EBSCO, our online magazine article provider, is currently unavailable</b></p>\n";
				echo "<p><b>Please try your request again later.</b></p>\n";
			}
		}
	}
?>
