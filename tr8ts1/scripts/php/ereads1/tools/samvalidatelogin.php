<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/**
 * File that takes in a token and retrieves User Information from SAM. Then auto logs the user in.
 * 
 * Token comes in like this: ##TOKEN##sctok
 * @author John Palmer
 */

//Required Files for retrieving user data from SAM
require_once('HTTP/Request.php');
require_once ('XML/Unserializer.php');
require_once ('XML/Serializer.php');
require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
require_once($_SERVER['CONFIG_HOME'].'GI_BaseHref.php'); 

$locker_client = new Locker_Client();

//Parse the token.Strip the "sctok". Make sure the token has sctok at the end.
$sctok = substr($_REQUEST['sctok'], -5);

if($sctok == "sctok")
{
	//Parse the token.Strip the "sctok".
	$sctok = substr($_REQUEST['sctok'], 0, strlen($_REQUEST['sctok'])-5);
//echo $sctok;	
	//REQUEST DATA FROM SAM URL.	
	$var = $_SERVER['SAM_URL'].$sctok;
	$r = new Http_Request($var);
	$r->sendRequest();
	
	if (PEAR::isError($r) == false) 
	{
		if ($r->getResponseCode() == 200) 
		{

			//get the XML response
			$theResponse = $r->getResponseBody();
//echo $theResponse;			
			//change the xml response into an array
			$options = array('complexType' => 'array',
			'parseAttributes' => TRUE,
			'attributesArray' => "attr");

			$unserialize = &new XML_Unserializer($options);
			$status = $unserialize->unserialize( $theResponse );
			$userdata = $unserialize->getUnserializedData();
/*			
			//Now we have user data.
//echo "GUID-->".$userdata['attr']['guid']."<br>";
echo "<pre>";
print_r($userdata);
echo "</pre>";

			//DEBUG CODE! THIS SHOULD BE TAKEN OUT OF THE FINAL VERSION.
			//THIS IS JUST PRINTING OUT THE DATA BACK FROM SAM!

			echo "GUID-->".$userdata['attr']['guid']."<br>";
			echo "FNAME-->".$userdata['name']['first']."<br>";
			echo "Reading Level-->".$userdata['reading_level']."<br>";
$stages_str = '';	
			if(!empty($userdata['stages'])) 
			{		
				//check to see if we have multiple stages
				if(is_array($userdata['stages']['stage']))
				{
					for ($i = 0; $i<count($userdata['stages']['stage']); $i++)
					{
						$stages_str .= $userdata['stages']['stage'][$i].'|';
					}	
				}
				else 
				{
					$stages_str = $userdata['stages']['stage'].'|';
				}
			}
$topics_str = '';				
			//check number of topics.
			if(!empty($userdata['unlocked_topics'])) 
			{			
				if(count($userdata['unlocked_topics']['topic']) > 1)
				{
					// More than 1
					for ($i = 0; $i<count($userdata['unlocked_topics']['topic']); $i++)
					{
						$topics_str .= $userdata['unlocked_topics']['topic'][$i]['attr']['id'].'|';
					}			
				}
				else 
				{
					//1 topic
					$topics_str = $userdata['unlocked_topics']['topic']['attr']['id'].'|';
				}
			}
$entitlements_str = $userdata['entitlements']['entitlement'];

$profile_values = $stages_str.$topics_str.$entitlements_str;
echo "profile_values-->".$profile_values."<br>";
*/
$PARENT_AUID = '387834';
$PARENT_ID = '800081928';
$PRODUCT_CODE = 'ereads';	
			$success = $locker_client->create_sam_user_by_product($userdata['attr']['guid'], $PARENT_ID, $PARENT_AUID, $PRODUCT_CODE, $userdata);
//			echo "Created User: $success";
			if($success == 1)
			{	

				


				$guid = $userdata['attr']['guid']. "_" . $PRODUCT_CODE;
/**
				echo"<pre>";
					print_r($locker_client->validatelogin($guid,$guid,'ereads'));
				echo"</pre>";				
*/			

				$link = str_replace("http://", "", GI_BaseHref("ereads")); 
				$link = urldecode($link);				
				$guid = urldecode($guid);
				$signin = urldecode("SIGN IN");
				$url = $_SERVER['AUTH_BASE_URL']."/cgi-bin/authV2/?link=$link&pagetype=signinbox&bffs=N&profile=$PRODUCT_CODE&formu=$guid&formp=$guid&login=$signin";
//				echo "URL:".$url;
				header("Location:$url");
			}
			else 
			{
			echo "No Success";
			}

		}
		else 
		{
			//ERROR RETURN TO SAM
			header("Location:".$_SERVER['SAM_BASE_URL']."error");
			
		}
	}
	else 
	{
		//ERROR RETURN TO SAM
		header("Location:".$_SERVER['SAM_BASE_URL']."error");
	}
}
else 
{
	//ERROR RETURN TO SAM
	header("Location:".$_SERVER['SAM_BASE_URL']."error");
}

?>