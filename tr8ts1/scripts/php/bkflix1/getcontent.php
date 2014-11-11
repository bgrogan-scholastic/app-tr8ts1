<!--php:begin-->
    header("Content-type: text/XML");
<!--php:end-->
<?php
    /* define some common constants */
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');

    /* include GI_Base and other common functionality */
    require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Base/package.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/utils/GI_getVariable.php');

    /* content server client */
    require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/cs/client/CS_Client.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/cs/CS_Constants.php');

    $assetid = GI_getVariable(GI_ASSETID);

    $clientParams = array(CS_PRODUCTID => GI_PCODE_BKFLIX, CS_FILENAME=> $assetid);

	$csClient = new CS_Client();
	$csTextObject = $csClient->getText($clientParams);

	/* check to see if any errors occurred */
	if(GI_Base::isError($csTextObject)) {
	    echo "<pre>\n";
		echo "Error fetching ".$assetid."\n";
		echo $csTextObject->getMessage()."\n";
		print_r($clientParams);
		echo "</pre>\n";
	}
	else {
		echo $csTextObject->getText(); 
	}

?>
