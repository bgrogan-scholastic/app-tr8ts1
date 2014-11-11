
<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_TextAsset.php');       
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');     

    # initialize the error manager
    $errMgr =& GI_ErrorManager::getInstance();
    $GLOBALS["errorManager"] =& $errMgr;
        $buildresult = GI_BUILD_STATUS_SUCCESS;
        $GLOBALS["fatalerror"] = FALSE;

        
        
        
        
        
    // this feature does not support hitword highlighting
	echo "<!-- Fetching binary asset -->\n";
    $binaryAsset = new GI_BinaryAsset(array(
                                        CS_PRODUCTID => 'bkflix',
                                        GI_ASSETID => 'bk0000lpa',
                                        'fext' => 'pdf'
                                        )
                                  );

    if(GI_Base::isError($binaryAsset)) {
            $GLOBALS["errorManager"]->reportError($binaryAsset);
            $GLOBALS["fatalerror"]=TRUE;
    } 
?>





<html>
  <head>
    <title>Media test sample</title>
    

    
  </head>

  <body LEFTMARGIN="0" TOPMARGIN="0" MARGINHEIGHT="0" MARGINWIDTH="0">

    <table border="0" cellpadding="5" cellspacing="0" width="500">





<?php
echo '<p><a href="' . $binaryAsset->getURLPath() . '">pdf</a></p>' . "\n";
?>
    </td>
    </table>
  </body>

</html>


