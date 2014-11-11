<?php
	require_once($_SERVER["PHP_INCLUDE_HOME"].'/common/network/grSoapClient.inc');

#+******************************************************************
# Class      :
# Method     : FetchSOAP
# Created    : Richard E. Dye
# Date       : 10/9/2003
#
# Comment    : Attempt to retrieve an XML document from Ebsco
#
# visibility :	public
#
# Parameters :
# string			&$inQuery			Boolean query (reference!)
# string			$inDB					Which Ebsco database (glh | gkh)
# number			$inNoRec				How many records to retrieve
# number			$inStartRecNo		First record number
# string			$inMode				Retrieval mode (Full for article, Detailed for index)
# string			$inSearchText		Full text search?
#
# Returns    :
# string									Ebsco XML document (may be error) or false
#
# Revisions  :	12/4/2003: R.E. Dye - added $inSearchText paramter to instruct the
#					Ebsco searchPresent call to be set to 'full text' rather than just
#					titles and abstracts.
#
# *****************************************************************-*/
	function FetchSOAP(&$inQuery, $inDB, $inNoRec, $inStartRecNo, $inMode, $inSearchText='')
	{
		$wsdl = new SOAP_WSDL("http://xml.epnet.com/oemdirectxml/oemdirectxml.asmx?wsdl");

		if(!$wsdl || $wsdl->fault)
		{
			echo "<br><b>Unable to retrive the WSDL from Ebsco.<br></b>\n";
			echo $wsdl->fault->message."\n";
			return false;
		}

		$webservice=$wsdl->getProxy();
		if(!$webservice)
		{
			echo "<br>Unable to create the Ebsco WSDL proxy.<br>\n";
			return false;
		}

		/*
		$authRequest = array(
				'userID'=>'beta.grolier.doug',
				'userPwd'=>'doug',
				'profileID'=>''
									);
		*/

		$authRequest = array(
			'userID'		=>	'',
			'userPwd'	=>	'',
			'profileID'	=>	'ehost'
								);

		//echo "<!-- \$authrequest=\n";
		//print_r($authRequest);
		//echo " -->\n";
		
		$retval=$webservice->Init($authRequest);
		//echo "<!-- \$retval= \n";
		//print_r($retval);
		//echo " -->\n";

		if(!$retval || $retval->errors)
		{
			echo "<br><b>Unable to initialize an Ebsco session.<br>\n";
			echo $retval->errors->error."</b><br>\n";
			return false;
		}

		if(isset($retval->error_message_prefix))
		{
			echo "<br><b>Unable to initialize an Ebsco session.<br>\n";
			echo $retval->message."</b><br>\n";
			return false;
		}

		$sessionID = $retval->sessionID;

		//echo "<!-- \$sessionID = $sessionID -->\n";

		if($inSearchText == 'y')
			$searchText = 'True';
		else
			$searchText = 'False';

		$searchRequest = array(
			'db' 				=> $inDB,
			'booleanQuery'	=>	$inQuery,
			'searchText'	=> $searchText,
			'applyThes'		=>	'False',
			'sort'			=>	'Date'
										);

		echo "<!-- \$searchRequest['searchText'] = ".$searchRequest['searchText']." -->\n";

		$documentRequest = array(
			'startRecNo'	=>	$inStartRecNo,
			'noRecs'			=>	$inNoRec,
			'format'			=>	$inMode,
			'mode'			=>	'XHTML',
			'highlight'		=>	'False'
										);

		$oldparse = $webservice->setXMLParse('noparse');
		$article=$webservice->SearchPresent($authRequest, $sessionID, $searchRequest, $documentRequest);
		$result=$webservice->setXMLParse($oldparse);

		//echo "<!-- \$article= $article -->\n";

		return $article;
	}

?>
