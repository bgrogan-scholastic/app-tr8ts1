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
class GI_TopicCollectiveHandler extends GI_CollectiveHandler{
	public $_collective;
	public function __construct($inFilenameAssetID="", $inPcode=""){
		// Invoke the parent constructor
		parent::__construct($inFilenameAssetID, $inPcode);
		//Make collective public
		$this->_collective = $this->_collective;
	}
	
	
	/**
	 * @author Yogen Patel
	 * @access public
	 * Checks for Collective tag in XML file
	 * **/
	public function checkXMLCollectiveExists() {
		if(get_class($this->_collective)=='SimpleXMLElement')
			return 1;
		else return 0;
	}
	/**
	 * Gets a uid from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string uid attribute
	 * **/
	public function getUID() {
		$uid = "";
		$uid = $this->_collective->id->attributes()->uid;
		return $uid;
	}
	/**
	 * Gets a title from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string title
	 * **/
	
	public function getTitle(){
		return $this->_collective->title;
	}
	
	
	/**
	 * Fetches Short Summary from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string short_summary
	 * **/
	public function getShortSummary(){
		return $this->_collective->short_summary;
	}
	
	
	/**
	 * Fetches Long Summary from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string Long_Summary
	 * **/
	public function getLongSummary(){
		$a="long-summary"; //Need to store in a variable b'coz it not working directly
		return $this->_collective->$a;
	}
	
	/**
	 * Fetches Software Topic Photo Id from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string software_topic_photo id
	 * **/
	
	public function getSoftwareTopicPhotoId(){
		return $this->_collective->software_topic_photo->id;
	}
	
	/**
	 * Fetches Software Topic Photo Title from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string software_topic_photo title
	 * **/

	public function getSoftwareTopicPhotoTitle(){
		return $this->_collective->software_topic_photo->title;
	}
	
	/**
	 * Fetches Splash Photo Id from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string software_topic_photo id
	 * **/
	
	public function getSplashPhotoId(){
		if(!empty($this->_collective->splash_photo)) {
			return $this->_collective->splash_photo->id;
		}
	}
	
	
	/**
	 * Fetches Splash Topic Photo Title from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string splash_photo title
	 * **/
	public function getSplashPhotoTitle(){
		if(!empty($this->_collective->splash_photo)) {
			return $this->_collective->splash_photo->title;
		}
	}
	
	/**
	 * Fetches Bundles of XML Ids from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array bundles
	 * **/
	public function getBundlesId(){
		$count=0;
		foreach ($this->_collective->bundles->bundle as $bundle){
			$bundlesIds[$count]= $bundle->id;
			$count++;
		}
		return $bundlesIds;
	}
	
	/**
	 * Fetches Bundles of XML Titles from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array bundles
	 * **/
	public function getBundlesTitle(){
		$count=0;
		foreach ($this->_collective->bundles->bundle as $bundle){
			$bundlesTitles[$count]= $bundle->title;
			$count++;
		}
		return $bundlesTitles;
	}
	
	/**
	 * Fetches Type attribute of Bundles from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array type_bundle
	 * **/
	public function getBundlesType(){
		$count=0;
		foreach ($this->_collective->bundles->bundle as $bundle){
			$bundlesType[$count]= $bundle->id->attributes()->type;
			$count++;
		}
		return $bundlesType;
	}
	
	
	/**
	 * Fetches Photo Ids from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array photo id
	 * **/
	public function getPhotosId(){
		$count=0;
		foreach ($this->_collective->photo_gallery->photo as $photo){
			$photos[$count]= $photo->id;
			$count++;
		}
		return $photos;
	}
	
	
	/**
	 * Fetches Photo UIds attribute from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array photo uid attribute
	 * **/
	public function getPhotoUId(){
		$count = 0;
		foreach ($this->_collective->photo_gallery->photo as $photo){
			$photosuid[$count]= $photo->id->attributes()->uid;
			$count++;
		}
		return $photosuid;
	}
	
	/**
	 * Fetches Photo titles from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array photo title
	 * **/
	public function getPhotosTitle(){
		$count=0;
		foreach ($this->_collective->photo_gallery->photo as $photo){
			$photos[$count]= $photo->title;
			$count++;
		}
		return $photos;
	}
	
	/**
	 * Fetches Related Bundles of XML Ids from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string array bundles Ids
	 * **/
	public function getRelatedBundlesId(){
		$count=0;
		foreach ($this->_collective->related_bundles->bundle as $bundle){
			$bundlesIds[$count]= $bundle->id;
			$count++;
		}
		return $bundlesIds;
	}
	
	/**
	 * Fetches Related Bundles of XML Titles from the XML file 
	 * @author Diane Palmer
	 * @access public
	 * @return string bundles title
	 * **/
	public function getRelatedBundlesTitle($slp_id){
		
		foreach ($this->_collective->related_bundles->bundle as $bundle){
			
			if($bundle->id==$slp_id){
				
				$bundleTitle = $bundle->title;
			}
			
		}
		

		return $bundleTitle;
	}
	
	/**
	 * Fetches Related Bundles of XML Topic Titles from the XML file 
	 * @author Diane Palmer
	 * @access public
	 * @return string bundles title
	 * **/
	public function getRelatedBundlesTopicTitle($slp_id){
		
		foreach ($this->_collective->related_bundles->bundle as $bundle){
			
			if($bundle->id==$slp_id){
				
				$bundleTitle = $bundle->topic_title;
			}
			
		}
		

		return $bundleTitle;
	}	
}

?>