<?php

require_once(getenv('PHP_SCRIPTS_HOME') . '/rps/common/database/GI_DBQuery.php');

class GI_AssetTypes {
	var $_assetTypes = array();
	var $_myDatabase;
	
	function GI_AssetTypes($myDatabase) {
		$this->_myDatabase = $myDatabase;
		
		/* get a list of all the different asset types */
		$myAssetTypesQuery = "select * from asset_types";
		$myAssetTypesObject = new GI_DBQuery($myAssetTypesQuery, $myDatabase);
		$myAssetTypesObject->ExecuteQuery();
		$myAssetTypes = array();
		
		while($myAssetType = $myAssetTypesObject->NextRow()) {
			$assetType = $myAssetType['ASSET_TYPE'];			
			$this->_assetTypes[$assetType] = array('short_desc' => $myAssetType['SHORT_DESC'], 'long_desc' => $myAssetType['LONG_DESC']);
		}
	}
	
	function getShortDesc($type) {
		/* get the short description for this asset type */
		return $this->_assetTypes[$type]['short_desc'];
	}
	
	function getLongDesc($type) {
		/* get the long description for this asset type */
		return $this->_assetTypes[$type]['long_desc'];
	}
}
