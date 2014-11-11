<?php
//include($_SERVER['INCLUDE_HOME'].'/folder_header.php');

require_once($_SERVER['PHP_INCLUDE_HOME'].'/tr8ts1/GI_FolderHandler.php');
$FOLDER_HANDLER =  new GI_FolderHandler();

echo "<html><body>";
echo "Processing Folder-Template-Relation Table<br><br>"; 

$featurecode=$_REQUEST['featurecode'];

		$productFacet=$_SERVER['PCODE']; //set default to this server pcode
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		} 
		
		echo "Passed in featurecode: ".$featurecode."<br>Passed out productCode: ".$productFacet;
		//exit;
		
$children = $FOLDER_HANDLER->populateFolderTemplateRelation($productFacet);




echo "</body></html>";


//include($_SERVER['INCLUDE_HOME'].'/folder_footer.php');
?>