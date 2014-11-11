<?php
require_once('HTTP/Request.php');
require_once ('XML/Unserializer.php');
require_once ('XML/Serializer.php');
require_once($_SERVER['CONFIG_HOME'].'GI_BaseHref.php'); 
require_once('DB.php'); 
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Constants.php');
require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");

$sctok = substr($_REQUEST['sctok'], -5);
$locker_client = new Locker_Client();

if($sctok == "sctok")
{
	$sctok = substr($_REQUEST['sctok'], 0, strlen($_REQUEST['sctok'])-5);
	$var = "https://samconnect.scholastic.com/auth/services/Profile/".$sctok;
	$r = new Http_Request($var);
	$r->sendRequest();
	if (PEAR::isError($r) == false) 
	{
		if ($r->getResponseCode() == 200) 
		{
			//get the XML response
			$theResponse = $r->getResponseBody();
			//change the xml response into an array
			$options = array('complexType' => 'array',
			'parseAttributes' => TRUE,
			'attributesArray' => "attr");
			
			$unserialize = &new XML_Unserializer($options);
			$status = $unserialize->unserialize( $theResponse );
			$userdata = $unserialize->getUnserializedData();
/**
			echo"<pre>";
				print_r($userdata);
			echo"</pre>";
	
			echo "GUID-->".$userdata['attr']['guid']."<br>";
			echo "FNAME-->".$userdata['name']['first']."<br>";
			echo "STATE_CODE-->".$userdata['state']['attr']['code']."<br>";
			echo "STATE-->".$userdata['state']['_content']."<br>";
			echo "UTYPE-->".$userdata['user_type']."<br>";
			echo "EMAIL-->".$userdata['email']."<br>";
			echo "LEXILE-->".$userdata['lexile_score']."<br>";
			echo "COURSE-->".$userdata['course']."<br>";
*/
		
			$success = $locker_client->createSAMuser($userdata['attr']['guid'], $userdata['state']['attr']['code'], $userdata);
			if($success == 1)
			{	
/**
				echo"<pre>";
					print_r($locker_client->validatelogin($userdata['attr']['guid'],$userdata['attr']['guid'],'eto'));
				echo"</pre>";
*/				
				$guid = $userdata['attr']['guid'];
				$ngo = str_replace("http://", "", GI_BaseHref("eto")); 
				$ngo = urldecode($ngo);				
				$guid = urldecode($guid);
				$signin = urldecode("SIGN IN");
				$url = $_SERVER['AUTH_BASE_URL']."/cgi-bin/authV2/?link=$ngo&pagetype=signinbox&bffs=N&profile=eto&formu=$guid&formp=$guid&login=$signin";
				header("Location:$url");
			}
			else 
			{
				//header("Location:https://samconnect.scholastic.com/auth/pages/Login?zone=E21-D");
			
/**
		 	echo"<pre>";
				print_r($userdata);
			echo"</pre>";
	
			echo "GUID-->".$userdata['attr']['guid']."<br>";
			echo "FNAME-->".$userdata['name']['first']."<br>";
			echo "STATE_CODE-->".$userdata['state']['attr']['code']."<br>";
			echo "STATE-->".$userdata['state']['_content']."<br>";
			echo "UTYPE-->".$userdata['user_type']."<br>";
			echo "EMAIL-->".$userdata['email']."<br>";
			echo "LEXILE-->".$userdata['lexile_score']."<br>";
			echo "COURSE-->".$userdata['course']."<br>";	
			echo $success;			
*/
			}
		
		}
		else 
		{
			header("Location:https://samconnect.scholastic.com/auth/pages/Login?zone=E21-D");
			
		}
	}
	else 
	{
		header("Location:https://samconnect.scholastic.com/auth/pages/Login?zone=E21-D");
	}
}
else 
{
	header("Location:https://samconnect.scholastic.com/auth/pages/Login?zone=E21-D");
}

?>