<?php
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_CollectiveHandler.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');

/**
 * Class GI_TopicCollectiveHandler
 * 
 * Handler for Collective XML's in ereads
 * @author Octasiano Valerio
 * 
 * Last Updated By: Yogen Patel (12/21/2010)
 */
class GI_MainCollectiveHandler extends GI_CollectiveHandler{
	public $_collective;
	public function __construct($inFilenameAssetID="", $inPcode=""){
		// Invoke the parent constructor
		parent::__construct($inFilenameAssetID, $inPcode);
		//Make collective public
		$this->_collective = $this->_collective;
	}
	
	
	/**
	 * Gets a specific stage from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getStages(){
		return $this->_collective->stages->stage;
	}	
	
	/**
	 * Gets the topics for a specific stage from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getTopics($stages){
		return $stages->topics->topic;
	}		
	
	/**
	 * Gets topic id from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getTopicID($topic){
		return $topic->id;
	}		
	
	/**
	 * Gets topic id from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getTopicTitle($topic){
		return $topic->title;
	}	

	/**
	 * Gets topic id from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getTopicShortSumm($topic){
		return $topic->short_summary;
	}		
	
	/**
	 * Gets topic id from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getSplashPhotoID($topic){
		return $topic->splash_photo->id;
	}		
	
	/**
	 * Gets topic id from the XML file 
	 * @author Dee Palmer
	 * @return xml stages
	 * **/
	public function getSoftwareTopicPhoto($topic){
		return $topic->software_topic_photo->id;
	}		
		
	
}

?>