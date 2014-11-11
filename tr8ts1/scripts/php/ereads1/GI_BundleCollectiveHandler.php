<?php
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_CollectiveHandler.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');

/**
 * Class GI_BundleCollectiveHandler
 * 
 * Handler for Collective Bundles XML's in ereads
 * @author Yogen Patel
 * 
 * Last Updated By: Yogen Patel (12/28/2010)
 *
 * All parameters are optional
 * Pass
 * Constructor parameter1: for asset ID for an XML file
 * Constructor parameter2: Product Code. Example: "rdd" or "ereads"...
 * Constructor parameter3: Ereads Level of reading. Example: "1-2" or "3-4"
 */
class GI_BundleCollectiveHandler extends GI_CollectiveHandler{
	public $_collective;
	private $level;
	public function __construct($inFilenameAssetID="", $inPcode="", $level=""){
		// Invoke the parent constructor
		parent::__construct($inFilenameAssetID, $inPcode);
		//Make collective public
		$this->_collective = $this->_collective;
		$this->level= $level;
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
	 * Gets a title from the XML file 
	 * @author Dee Palmer
	 * @return string title
	 * **/
	public function getStage(){
		return $this->_collective->stage;
	}	
	
	/**
	 * Fetches Summary from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string summary
	 * **/
	public function getSummary(){
		return $this->_collective->summary;
	}
	
		
	/**
	 * Fetches Summary from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string rated_string_question
	 * **/
	public function getRatedLeadingQuestion(){
		$a="rated_leading_question";
		return $this->_collective->$a;
	}
	
	/**
	 * Fetches Ereads Id according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string ereadId
	 * **/
	public function getEreadsId(){
		$ereadsId="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsId= $eread->id;
				}
			}
		}
		return $ereadsId;
	}
	
	/**
	 * Fetches Ereads Type according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread type
	 * **/
	public function getEreadsType(){
		$ereadsType="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsType= $eread->id->attributes()->type;
				}
			}
		}
		return $ereadsType;
	}
	
	/**
	 * Fetches Ereads Title according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string ereadTitle
	 * **/
	public function getEreadsTitle(){
		$ereadsTitle="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsTitle= $eread->title;
				}
			}
		}
		return $ereadsTitle;
	}
	
	
	/**
	 * Fetches Word Count from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string word_count
	 * **/
	public function getEreadsWordCount(){
		
		$ereadsWordCount="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsWordCount= $eread->word_count;
				}
			}
		}
		return $ereadsWordCount;
	}
	
	/**
	 * Fetches Lexile level from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string lexile
	 * **/
	public function getEreadsLexile(){
		$ereadsLexile="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsLexile= $eread->lexile;
				}
			}
		}
		return $ereadsLexile;
	}
	
	/**
	 * Fetches Ereads Text Type according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread text_type
	 * **/
	public function getEreadsTextType(){
		$ereadsTexttype="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsTexttype= $eread->text_type;
				}
			}
		}
		return $ereadsTexttype;
	}
	
	/**
	 * Fetches Ereads Audio Id according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread audio id
	 * **/
	public function getEreadsAudioId(){
		$ereadsAudioId="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsAudioId= $eread->audio->id;
				}
			}
		}
		return $ereadsAudioId;
	}
	
	
	/**
	 * Fetches Ereads Audio Title according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread audio title
	 * **/
	public function getEreadsAudioTitle(){
		$ereadsAudioTitle="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsAudioTitle= $eread->audio->title;
				}
			}
		}
		return $ereadsAudioTitle;
	}
	
	
	/**
	 * Fetches Ereads Photo UId according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread photo uid
	 * **/
	public function getEreadsPhotoUId(){
		$ereadsPhotoUId="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					if($eread->photo->attributes()->priority != null){
						if($eread->photo->attributes()->priority=="0"){
							$ereadsPhotoUId= $eread->photo->id->attributes()->uid;
						}
					}
				}
			}
		}
		return $ereadsPhotoUId;
	}
	
	/**
	 * Fetches Ereads Photo UId according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread photo uid
	 * **/
	public function getEreadsPhotoUIdTopicsPage(){
		$ereadsPhotoUId="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					if($eread->photo->attributes()->priority != null){

							$ereadsPhotoUId= $eread->photo->id->attributes()->uid;
						
					}
				}
			}
		}
		return $ereadsPhotoUId;
	}	
	
	/**
	 * Fetches Ereads content area title 
	 * @author Diane Palmer
	 * @access public
	 * @return string eread content area title
	 * **/
	public function getEreadsContentAreaTitle(){
		
		
		$content_area = $this->_collective->content_area_icon;
		$content_area_name = $content_area->title;
		
		return $content_area_name;
	}	
	
	
	
	/**
	 * Fetches Ereads content area title 
	 * @author Diane Palmer
	 * @access public
	 * @return string eread content area title
	 * **/
	public function getEreadsContentAreaPhotoId(){
		
		
		$content_area = $this->_collective->content_area_icon;
		$content_area_name = "test";
		
		if(!empty($content_area)) {
			$content_area_slpid = $content_area->attributes()->slp_id;
		}
		
		return $content_area_slpid;
	}		
	
	/**
	 * Fetches Ereads Photo Id according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread photo id
	 * **/
	public function getEreadsPhotoId(){
		$ereadsPhotoId="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
						$ereadsPhotoId= $eread->photo->id;
				}
			}
		}
		return $ereadsPhotoId;
	}
	
	/**
	 * Fetches Ereads Photo Title according to defined "level" from the XML file 
	 * @author Yogen Patel
	 * @access public
	 * @return string eread photo title
	 * **/
	public function getEreadsPhotoTitle(){
		$ereadsPhotoTitle="";
		if(!empty($this->_collective->ereads)) {
			foreach ($this->_collective->ereads->eread as $eread){
				if(strcmp($eread->attributes()->level, $this->level) == 0){
					$ereadsPhotoTitle= $eread->photo->title;
				}
			}
		}
		return $ereadsPhotoTitle;
	}
}

?>