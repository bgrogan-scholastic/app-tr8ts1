<?php
function cmp($a, $b)
{
    return strcmp($a->_emailaddress, $b->_emailaddress);
}
	
	$_SERVER["PHP_INCLUDE_HOME"] = '/data/locker1/scripts/php/';
	$_SERVER['SOAP_CLIENT_URL'] = 'http://fivedev.grolier.com:1134/lockerserverwsdl';
	$_SERVER['ENVIRONMENT'] = 'development';
	require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
	$locker_client = new Locker_Client();
	$marketinguserlist = $locker_client->getmarketinguserlist();
	usort($marketinguserlist, "cmp");	
	
	$optInFileName = "SDLS_opt_in_".$_SERVER['ENVIRONMENT'].".csv";
	$optOutFileName = "SDLS_opt_out_".$_SERVER['ENVIRONMENT'].".csv";
	$optInUserList = array();
	$optOutUserList = array();
	$optInLine = '';
	$optOutLine = '';
	for ($i = 0; $i<count($marketinguserlist); $i++)
	{
		if(!empty($marketinguserlist[$i]->_marketingprefarray))
		{
			if(!in_array($marketinguserlist[$i]->_emailaddress,$optInUserList))
			{
				$optInUserList[] = $marketinguserlist[$i]->_emailaddress;
			}
		}
		else 
		{
			if(!in_array($marketinguserlist[$i]->_emailaddress,$optOutUserList))
			{
				$optOutUserList[] = $marketinguserlist[$i]->_emailaddress;
				
			}
		}
	}

	//Remove dups from opt in
	for ($i = 0; $i<count($optOutUserList); $i++)
	{
		//check to see if a user in the opt out list is also in the opt in list
		$key = array_search($optOutUserList[$i], $optInUserList);
		if($key != false)
		{
			$tempArray1 = array_slice($optInUserList, $key);
			array_shift($tempArray1);
			$tempArray2 = array_slice($optInUserList, 0, $key);
			$optInUserList = array_merge($tempArray1, $tempArray2);
		}
	}
	
	sort($optInUserList);

	//Create output for opt in
	for ($i = 0; $i<count($optInUserList); $i++)
	{
		$optInLine .= $optInUserList[$i]."\n";
	}
	
	//Create output for opt out
	for ($i = 0; $i<count($optOutUserList); $i++)
	{
		$optOutLine .= $optOutUserList[$i]."\n";
	}

	//Print Opt In
	echo '<br><b>Opt In List:</b><br>';
	if(!empty($optInFileName))
	{
		if (is_writable($optInFileName)) 
		{
		    if (!$handle = fopen($optInFileName, 'w')) 
		    {
		         //echo "Cannot open file ($optInFileName)";
		         exit;
		    }
		} 
		else 
		{
		    //echo "The file $filename is not writable";
		    exit;
		}
		
		$optInLine = substr($optInLine, 0, -1); 
		// Write $somecontent to our opened file.
		if (fwrite($handle, $optInLine) === FALSE) 
		{
		    //echo "Cannot write to file ($optInFileName)";
		    exit;
		}	
		fclose($handle);
		//echo $optInLine.'<br>';
		for ($i = 0; $i<count($optInUserList); $i++)
		{
			echo $optInUserList[$i].',<br>';
		}
			
	}

	//Print Opt Out	
	echo '<br><b>Opt Out List:</b><br>';
	if(!empty($optOutFileName))
	{
		if (is_writable($optOutFileName)) 
		{
		    if (!$handle = fopen($optOutFileName, 'w')) 
		    {
		         //echo "Cannot open file ($optOutFileName)";
		         exit;
		    }
		} 
		else 
		{
		    //echo "The file $optOutFileName is not writable";
		    exit;
		}
		
		$optOutLine = substr($optOutLine, 0, -1); 
		// Write $somecontent to our opened file.
		if (fwrite($handle, $optOutLine) === FALSE) 
		{
		   // echo "Cannot write to file ($optOutFileName)";
		    exit;
		}	
		fclose($handle);
		//echo $optOutLine.'<br>';
		for ($i = 0; $i<count($optOutUserList); $i++)
		{
			echo $optOutUserList[$i].',<br>';
		}		
	}
	
	//FTP files
	$remote_file = "/export/home/pubftp01/ES_Marketing/$optInFileName";
	$ftp_server = '198.181.165.14';
	$ftp_user_name = 'pubftp01';
	$ftp_user_pass = '01~isit';
	// set up a connection or die
	$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
	
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	ftp_pasv($conn_id, true);
	
	// upload a file
	if (ftp_put($conn_id, $remote_file, $optInFileName, FTP_ASCII)) 
	{
		echo "<br>successfully uploaded $optInFileName\n";
	} 
	else 
	{
		echo "<br>There was a problem while uploading $optInFileName\n";
	}

	$remote_file = "/export/home/pubftp01/ES_Marketing/$optOutFileName";
	// upload a file
	if (ftp_put($conn_id, $remote_file, $optOutFileName, FTP_ASCII)) 
	{
		echo "<br>successfully uploaded $optOutFileName\n";
	} 
	else 
	{
		echo "<br>There was a problem while uploading $optOutFileName\n";
	}
	
	// close the connection
	ftp_close($conn_id);
?>