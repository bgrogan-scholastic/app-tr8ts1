<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Ebsco SOAP experiments</title>
</head>
<body bgcolor="#ddeeff">

<a name="top" />

<?php
	require_once($_SERVER["PHP_INCLUDE_HOME"].'/common/network/grSoapClient.inc');
	require_once($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/include/EntryParseAndFormat.inc');

	$wsdl = new SOAP_WSDL("http://xml.epnet.com/oemdirectxml/oemdirectxml.asmx?wsdl");

	if($wsdl)
	{
		$webservice=$wsdl->getProxy();
		if($webservice)
		{

			$authRequest = array(
										'userID'=>'beta.grolier.doug',
										'userPwd'=>'doug',
										'profileID'=>''
										);

			$retval=$webservice->Init($authRequest);

			if($retval)
			{
				$sessionID = $retval->sessionID;


				$querystring = '((China not taiwan) and ';
				$querystring .= '(Economic Growth or Economic Indicators ';
				$querystring .= 'or Political Situation or ';
				$querystring .= 'Political Life or Political System or Political Structure or ';
				$querystring .= 'Political Parties or Government or ';
				$querystring .= 'Civilization or Ethnic Group or ';
				$querystring .= 'Ethnic Groups or Social Conditions or Social Structure or ';
				$querystring .= 'Social Infrastructure) and fm t)';

				$searchRequest = array(
					'db' 				=> 'glh',
					'booleanQuery'	=>	$querystring,
					'searchText'	=> 'Default',
					'applyThes'		=>	'Default',
					'sort'			=>	'Date'
												);

				$articleRequest = array(
					'startRecNo'	=>	8,
					'noRecs'			=>	1,
					'format'			=>	'Full',
					'mode'			=>	'XHTML',
					'highlight'		=>	'False'
												);

				$oldparse = $webservice->setXMLParse('noparse');
				$article=$webservice->SearchPresent($authRequest, $sessionID, $searchRequest, $articleRequest);
				$result=$webservice->setXMLParse($oldparse);

				if($article)
				{
					$mycontrol = new EntryParseAndFormat();
					echo $mycontrol->parseXMLdocument($article);
				}
			}
		}
	}
?>

</body>
</html>

