<?php
//require_once($_SERVER['PHP_INCLUDE_HOME'].'ngo1/xsltransform.php');
 /*  
  * Name       : xml_xspace
  * @author    : Valli Abbaraju
  * @version   : v 1.0  14-Aug-2008
  * @param     : $filename - XML filename
  * @return    : Return parsed XML file.
  *  
  */
 /**
  * Class: Xspace 
  * Class to parse XML files
  */
 
class Xspace{
	
	/**
	 * Declare variables
	 *
	 * @var expert_space
	 * @var title
	 */
	
	protected $expert_space;
	protected $_title;
	/**
	 * Function : parse
	 * Loads and parses the XML file
	 * @param unknown_type $fileName
	 * @return expert_space
	 */
	public function parse($fileName)
    {
    	$source_xml = @file_get_contents($fileName);
        
		if(empty($source_xml)){
			return $this->_raiseError('XML FILE IS EMPTY, FILE: '.$this->xml_file.' FILE !!!',3,1);
		}
		else{
			
			$source_xml = str_ireplace('xmlns="http://omega/products/epiccustom/doctypes/ngo"','',$source_xml);
			$source_xml = str_ireplace('%specchars;','',$source_xml);
			
			//$source_xml = str_ireplace('<i>','&lt;i&gt;',$source_xml);
			$entities_file_handle = fopen("$_SERVER[CONFIG_HOME]XMLEntityReplace.txt", "r");
			if ($entities_file_handle === FALSE) {
				echo "Failed: Entities file (XMLEntityReplace.txt) not opened\n\n";
				exit;
			}
			while (!feof($entities_file_handle))
			{
				$buffer = trim(fgets($entities_file_handle));
				$pos = strpos($buffer, '|');
				if( ! ($pos === FALSE) )
				{
					$pieces = explode("|", $buffer);
					if ( $pieces[1] == '' )
					$pieces[1] = ' ';
					$html_ent_table[$pieces[0]] = $pieces[1];
				}
			}
			//replace any entities present in the xml string
			$encoded = strtr($source_xml,$html_ent_table);
		}
    	
    	
        if (file_exists($fileName)){
             $encoded = str_ireplace("<i>","&lt;i&gt;",$encoded);
			 $encoded = str_ireplace("</i>","&lt;/i&gt;",$encoded);
        	 $this->expert_space = simplexml_load_string($encoded);
        	//$this->expert_space = simplexml_load_file($fileName);              
        	return ($this->expert_space);
        	}
        else exit('Error.');
    }
    
    /*function xml2array($object) {
    	$return = NULL;
    	if(is_array($object)) {
    		foreach($object as $key => $value) $return[$key] = xml2array($value);
    	} else {
    		$var = get_object_vars($object);
    		if ($var) {
    			foreach($var as $key => $value)
    			$return[$key] = xml2array($value);
    		} else return strval($object);
    	}
    	return $return;
    }*/
    /**
     * Function : getTitle()
     *
     * @return title of Xpert_space
     */
    function getTitle(){
       	return $this->expert_space->title;
    }
    /**
     * Function : getOnlyTitle()
     *
     * @return title of X21 Drops the Colon and returns only the title
     */
    function getOnlyTitle(){
    	
	list($workshopNumber, $justTitle) = split('[:]', $this->expert_space->title);
	return $justTitle;
        
    }
    
     /**
     * Function : getWorkshopNumber()
     *
     * @return title of X21 returns only the Number
     */
     
    function getWorkshopNumber(){
    	 
list($workshopNumber, $justTitle) = split('[:]', $this->expert_space->title);
 
list($workshop, $workshopNumber) = split('[ ]', $workshopNumber);
return $workshopNumber;
 
    }
    
    
}

/**
 * Class: readIt 
 * Class to capture all read IT elements.
 */

class readIt extends Xspace {
	/**
	 * Declare variables
	 *
	 * @var titleInfo
	 * @var xpertSpace
	 * @var articleInfo
	 * @var blurbtext
	 * @var featuredAssets
	 */
	protected $_titleInfo;
	protected $xpertSpace;
	protected $_articleInfo;
	protected $_attInfo;
	protected $_blurbText;
	protected $_featuredAssets;
	
	/**
	 * Constructor : calls the Xspace class. loops thru the nodes of readIt and return the article Information
	 * 
	 * @param unknown_type $fileName
	 */
	
	public function __construct($fileName){
		$getXspace = new Xspace();
		$this->xpertSpace = $getXspace->parse($fileName);
		$i = 1;
		foreach ($this->xpertSpace->survey_articles->article as $article) {
			$this->_attInfo[(String) $article->id] =$article->attributes();
			foreach($article->children() as $art_item){
				$this->_articleInfo[$i][$art_item->getName()] = $art_item;
			}
			$i++;
		}
		/* Get Read IT title */
		foreach ($this->xpertSpace->read_it as $key=>$item){
			if(!isset($this->_titleInfo[$item->id])){
				$this->_titleInfo[(String) $item->id] = $item->title;
			}
		}
		$this->_blurbText = $this->xpertSpace->blurb;	
	    $i=1;
		foreach ($this->xpertSpace->featured_assets as $featuredAsset) {
			foreach ($featuredAsset->feature as $features){
				foreach ($features->children() as $child_features){
			     // echo $child_features->getName()."dfhgjkshdgkj ".$child_features;
			      
			      $this->_featuredAssetsInfo[$i] =  $features->attributes();
	    	      $this->_featuredAssets[$i][(String) $child_features->getName()] = $child_features;				
				}
				$i++;
			}
		}
	}
    /**
     * Function: getTitle()
     *
     * @return titleInfo
     */
	function getTitle(){
		return $this->_titleInfo;
	}
	/**
	 * Function: getAttributes Returns attribute Information
	 *
	 * @param unknown_type $article_id
	 * @return attributeInfo array
	 */
	function getAttributes($article_id){
		return $this->_attInfo[$article_id];
	}
	/**
	 * Function : getSurveyTitles return surveyArticleInformation.
	 * 
	 * @return articleInfo
	 */
	function getSurveyTitles(){
		return $this->_articleInfo;
	}
    /**
     * Function: getChildrenInfo
     *
     * @param unknown_type $parent
     * @return Children information
     */
	function getChildInfo($parent){
		return $parent->children();
	}
	/**
	 * Function: getBlurbText
	 *
	 * @return blurbText
	 */
	function getBlurbText(){
		return $this->_blurbText;
	}
	/**
	 * Function:getFeaturedAsset
	 *
	 * @return featureAssets array
	 */
	function getFeaturedAsset(){
		return $this->_featuredAssets;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $order
	 * @return unknown
	 */
	function getFeaturedAssetAttributes($order){
		return $this->_featuredAssetsInfo[$order];
	}
}
/**
 * Class WatchIT
 *
 */
class WatchIt{ 
	
	protected $_titleInfo;
	protected $xpertSpace;
	protected $_videoInfo;
	/**
	 * Function: Constructor Captures all the WatchIt elements and its attributes
	 *
	 * @param unknown_type $fileName
	 */
	public function __construct($fileName)
	{
		
		$getXspace = new Xspace();
		$this->xpertSpace = $getXspace->parse($fileName);

		foreach ($this->xpertSpace->watch_it as $key=>$item){
			if(!isset($this->_titleInfo[$item->id])){
				$this->_titleInfo[(String) $item->id] = $item->title;
			}
		}
		foreach($this->xpertSpace->anchor_video->children() as $child_item){
					$this->_videoInfo[$child_item->getName()] = $child_item;
				}
				
		/*foreach ($this->xpertSpace->anchor_video as $key=>$item){
			if(!isset($this->_videoInfo[$item->id])){ 	  
				
		  		$this->_videoInfo[(String) $item->id] = $item->title;
		  	}
		}*/			
	}
	function getTitle(){
		return $this->_titleInfo;
	}

	function getVideo(){
		//print_r($this->_videoInfo);
		return $this->_videoInfo;
	}
}

class topic{
	protected $_topicInfo;
	protected $_imageInfo;
	protected $_imageAttribute;
	protected $_attInfo;
	protected $_projectInfo;
	protected $_subTopicInfo;
	protected $_assetInfo;
	protected $_assetattri;
	protected $_subtopicTitle;
	protected $_subtopicattri;
	protected $xpertSpace;
	protected $_topicLinkInfo;
	protected $_exploreLink;
	
	public function __construct($fileName){
		 
			$getXspace = new Xspace();
		    $this->xpertSpace = $getXspace->parse($fileName);
		    //print_r($this->xpertSpace);
		     /* Code to get Topic Information */
		    foreach ($this->xpertSpace->topic as $key=>$item) {
		     //	$this->_attInfo[(String) $item] =$item->attributes();
		     // if(!isset($this->_topicInfo)){
		          $sortOrder = $item->attributes();
		      	  $this->_topicInfo[(String) $sortOrder]['title'] = $item->title;
		      	  $this->_topicInfo[(String) $sortOrder]['topic_text'] = $item->topic_text;
		      	  //echo  $this->_topicInfo[$item->topic_text->getname()];
		     }
		  
		  $this->getImages($this->xpertSpace);

		  $this->getProject($this->xpertSpace);

		  $subTopicinfo = new subTopic($this->xpertSpace);
		  
          $this->_assetInfo = $subTopicinfo->getAssetInfo();
		
		  $this->_subtopicTitle = $subTopicinfo->getSubTopicInfo();
		
		  $this->_subtopicattri = $subTopicinfo->getsubAttri();
		  
		  $this->_assetattri = $subTopicinfo->getAssetAttr();
		  
		  $this->getTopicLinkInfo($this->xpertSpace);
	}	
	
 	function getAssetAttributes($topicsort,$subsort = NULL, $assetsort = NULL){
 		//print_r($this->_assetattri[1][1][1]);
 	if ($subsort == null and $assetsort == null) 
		return $this->_assetattri[$topicsort];
	elseif ($subsort != null and $assetsort == null)
		return $this->_assetattri[$topicsort][$subsort];
	else 
	{
		if(isset($this->_assetattri[$topicsort][$subsort][$assetsort]))
		{
		return $this->_assetattri[$topicsort][$subsort][$assetsort];
		}else
		{
			return;
		}
	}
		
 	}
	
	function getImages($xpertSpace){
		foreach($xpertSpace->topic as $topic){
			foreach ($topic->image as $images){
				$sortOrder = $topic->attributes();
				 $imageAttr = $topic->image->attributes();
				foreach($images->children() as $child_item){
					$this->_imageInfo[(String) $sortOrder][$child_item->getName()] = $child_item;
				}
				$this->_imageAttribute[(string) $sortOrder]= $topic->image->attributes();
			}
		}
	}

	function getImageInfo($sortOrder){
		return $this->_imageInfo[$sortOrder];
	}
	
    function getImageAttribute($sortOrder){
   //   print_r($this->_imageAttribute[$sortOrder]);
    	return $this->_imageAttribute[$sortOrder];
    }
    
 	function getTopicInfo(){
	 	return $this->_topicInfo;
 	}
 
 	function getProject($xpertSpace){
 		foreach($xpertSpace->topic as $topic){
 			foreach ($topic->project as $projects){

 				foreach($projects->children() as $project_item){
 					//echo $project_item;
 					$sortOrder = $topic->attributes();
 				//	echo $sortOrder;
 					$this->_projectInfo[(String) $sortOrder][$project_item->getName()] = $project_item;
 				}
 			}
 		}
 	}
	
	function getProjectInfo($sortOrder){
		return $this->_projectInfo[$sortOrder];
	}
	
	function getasset($topicsort,$subsort = NULL, $assetsort = NULL){
	//	print_r($this->_assetInfo[$topicsort][$subsort][$assetsort]);
//	echo $topicsort." ".$subsort." ".$assetsort;
	if ($subsort == null and $assetsort == null) 
		return  $this->_assetInfo[$topicsort];
	elseif ($subsort != null and $assetsort == null)
		return $this->_assetInfo[$topicsort][$subsort];
	else {
		if(isset($this->_assetInfo[$topicsort][$subsort][$assetsort]))
		{
		return $this->_assetInfo[$topicsort][$subsort][$assetsort];
		}else
		{
			return;
		}
	}
	 
		echo "Value of ".$this->_assetInfo[$topicsort][$subsort][$assetsort];
	}
	
	function getSubTopics($topicSrtOrder,$subsort = NULL){
		//print_r($this->_subtopicTitle[$topicSrtOrder]);
		if ($subsort == NULL) 
		   return $this->_subtopicTitle [$topicSrtOrder];
		else 
		   return $this->_subtopicTitle [$topicSrtOrder][$subsort];
	}
	
	function getsubAttri($sortOrder){
		// print_r($this->_subtopicattri);
		 return $this->_subtopicattri[$sortOrder];
	}
	
	function getTopicLinkInfo($xpertSpace){
		foreach($xpertSpace->topic as $topic){
 			foreach ($topic->topic_links as $topicLink){
 				foreach($topicLink->children() as $topicLink_item){
 					//echo $project_item;
 					$sortOrder = $topic->attributes();
 				//	echo $sortOrder;
 					$this->_topicLinkInfo[(String) $sortOrder] = $topicLink_item;
 				}
 			}
 		}
 		
 		return $this->_topicLinkInfo;
	}
	
	function getexploreId($sortorder){
      return $this->_topicLinkInfo[$sortorder];
	}
}	

class subTopic extends topic {
	protected $_asset_att;
	protected $_assetInfo;
	protected $_assetattributes;
	protected $_titleInfo;
	protected $_subtopicAttr;
	
	public function __construct($xpertSpace){
		foreach ($xpertSpace->topic as $topic) {
			foreach ($topic->subtopic as $subtopic){
						$topicSortOrder = $topic->attributes();
						$subtopicOrder =  $subtopic->attributes();
                        $this->_titleInfo[(String) $topicSortOrder][(String) $subtopicOrder[1]]	= $subtopic->title;
					}
		}
	
  		$this->_assetInfo = $this->getAsset($xpertSpace);			 
	}
	
	function getAssetInfo(){
		return $this->_assetInfo;
	}
   
	function getSubTopicInfo(){
		return $this->_titleInfo;
	}
	
	function getsubAttri(){
		return $this->_subtopicAttr;
	}
	
	function getAssetAttr(){
		return $this->_asset_att;
	}
	 
	function getAsset($xpertSpace){
		foreach ($xpertSpace->topic as $topic) {
			foreach ($topic->subtopic as $subtopic){
				foreach($subtopic->asset as $assets){
					foreach($assets->children() as $assetInfo){
						$assetSortOrder = $assets->attributes();
						$topicSortOrder = $topic->attributes();
						$subtopicOrder =  $subtopic->attributes();
						if($subtopicOrder['component']=='non-article'){
							$assetSortOrder['level'] = 0;
						}
						
						$this->_assetInfo[(String) $topicSortOrder][(String) $subtopicOrder[1]][(String) $assetSortOrder[0]][$assetInfo->getName()] = $assetInfo;
						$this->_asset_att[(String) $topicSortOrder][(String) $subtopicOrder[1]][(String) $assetSortOrder[0]] = $assets->attributes();
					}
				}
			}
		}

		
		return $this->_assetInfo;
	}
	
	/*function getAtributes($xpertSpace){
	//	echo "Call to Get attributes".$xpertSpace;
	   
		return ($xpertSpace->attributes());
	}*/
}
?>