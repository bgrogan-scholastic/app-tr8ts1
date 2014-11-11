<?php

require_once($_SERVER['CONFIG_HOME'].'/GI_BaseHref.php');  
require_once('HTTP/Request.php');
require_once 'XML/Unserializer.php';

function anyStandardsAlign($assetid){
   		$requestUrl = "ScsAlignedDocument?SOURCE_CODE=GOnline&SOURCE_ASSET_CODE=".$assetid;
		$scsLoc = GI_BaseHref("scs");
		$baseUrl = $scsLoc."/SCS/";
		$requestUrl = $baseUrl . $requestUrl;
		
   		//connect to the SCS system
        $r = new Http_Request($requestUrl);
        $r->sendRequest();
        if (PEAR::isError($r) == false) {
       		//when we get a response set it to the variable $theResponse
			if ($r->getResponseCode() == 200) 
			{
				$theResponse = $r->getResponseBody();
			}
        }
        else {
			$returnMsg = $r->getMessage();
        }
        
        // create object to unserialize
		$unserializer = &new XML_Unserializer();
		
		// unserialize the document
		$result = $unserializer->unserialize($theResponse, false);
		
		// dump the result (which is now an array)
		$data = $unserializer->getUnserializedData(); 

		$theArray = isset($data['ALIGNED_DOCUMENTS']['ALIGNED_DOCUMENT']) ? $data['ALIGNED_DOCUMENTS']['ALIGNED_DOCUMENT'] : NULL;
		
		if(!is_array($theArray))
			return false;

		if( isset($theArray['ASSET_ID']) || isset($theArray[0]['ASSET_ID']))
		{
			return true;
		}
		else
		{
			return false;
		}
   }
?>