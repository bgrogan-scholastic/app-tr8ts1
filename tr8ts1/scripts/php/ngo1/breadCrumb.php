<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

/**
 BREADCRUMB PROTOCOL is
 language_sb_thing->course_sb_child_id->topic_sb_thing->sub_topic_title_ent
 
 Example: ETO
 LANGUAGE->COURSE->TOPIC->SUBTOPIC
 Language Arts | Course I |Workshop 6: Animal Watch | Elephants
 Example: NGO
 Science | Life Science | Animal Behavior | Migration
 * 
 * 
 * Many of the class methods below might or might not be necessary/useful and or working
 * throughout testing, i am leaving all of them till everything is perfect
 * 
 * 
 */
//set this to true to see which crumb is being thrown out
// $debug=true;

/* connect to database */
require_once('DB.php');

//************************************************************************
//						DETERMINE PRODUCT								//
//				BY SERVER CONF IF ITS NOT PASSED						//
//************************************************************************

require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Constants.php');


if($_SERVER[GI_AUTH_PCODE] == 'eto')
{
	$server = 'eto';
}		
elseif($_SERVER[GI_AUTH_PCODE] == 'xs')
{
	$server = 'ngo';	
}




//set some variables
$type="";
$spaceProduct_id="";
$spaceSlpId="";
$spaceName="";
$uid="";
$slp_id = isset($_GET['id']) ? $_GET['id'] :	NULL; 
$uid = isset($_GET['uid']) ? $_GET['uid'] :	NULL;
$brdCrmb = '<ul>';
$dirpath = $_SERVER['PHP_SELF'];
$breadCrumb = new breadCrumbClass($server);


$type=$breadCrumb->getType_by_slpid($slp_id);
$puid=$breadCrumb->getPuid_by_slpid($slp_id);
 
if (!isset($_REQUEST["searchTerm"]) && !isset($_REQUEST["queryParser"]) && !isset($_REQUEST["docKey"]) && (isset($uid) && $uid!='undefined'))
{
	//****************************************************************************
	//					for types other than 0c and 0cw		    				//
	//****************************************************************************
	
	if ($type != '0c' && $type != '0cw' )
	{	
		
		
		//if ETO and UID is present
		if($server=="eto")
		{
			if($_GET['product_id']=="eto")
			{
	 
 
				 $brdCrmb.= $breadCrumb->getBreadCrumbCOMBINED($slp_id,$uid); 
		 	 
				
			}
			else 
			{
			 
				//get crumb based on UID first, if that returns nutin then there is no relation in ETO
				//show the NGO crumb 
				
				$brdCrmb_temp=NULL;
				$brdCrmb_temp= $breadCrumb->getBreadCrumbNGO($uid);
				
				
				if(isset($brdCrmb_temp))
				{
					 
					$brdCrmb.=$brdCrmb_temp;
					
				}
				else
				{
					 
						
					if ($dirpath!="/lessonplan")
					{
						$brdCrmb.= $breadCrumb->getBreadCrumbCOMBINED($slp_id,$uid);
					}
					else
					{
						//if its a lesson plan ouput the old crumb
						 $brdCrmb.= $breadCrumb->oldCrumb($slp_id);
					}	
						
				//end else	
				}
				
			//end else	
			}
			
			
		}else{
			
			//****************************************************************************
			//		Process breadcrumb for NGO when there is no UID 	  				//
			//****************************************************************************
			
			 
					if ($dirpath!="/lessonplan")
					{
						 
						$brdCrmb.= $breadCrumb->getBreadCrumbCOMBINED($slp_id,$uid);
						 
					}
					else
					{
						//if its a lesson plan ouput the old crumb
						 $brdCrmb.= $breadCrumb->oldCrumb($slp_id);
					}	
						
				
			
		}
		
		//end if TYPE	
	}else{
		
		//************************************************************************
		//								0c and 0cw				    			//
		//						Language->Course->Topic							//
		//************************************************************************
		
		
		
		if($server=="eto")
		{
			
			
			if($_GET['product_id']=="eto")
			{
				
				$brdCrmb.= $breadCrumb->getBreadCrumbETO_0c($slp_id);
			}
			else {
			 
				//echo "2-server=ETO Product=NGO (NON ETO) TYPE=0c or 0cw<BR>";
				
				$brdCrmb_temp=NULL;
				$brdCrmb_temp= $breadCrumb->getBreadCrumbETO_server_NGO_0c($slp_id);
				
				if(isset($brdCrmb_temp))
				{
					 
					$brdCrmb.=$brdCrmb_temp;
					
				}else{
					
					 
					$brdCrmb.= $breadCrumb->oldCrumb($slp_id);
					
				}
				
				
			}
			
			
			//$brdCrmb.= $breadCrumb->getBreadCrumbETO_0c_uid($uid);
		}
		else 
		{
			 
			$brdCrmb.= $breadCrumb->getBreadCrumbNGO_0c($slp_id);
		}
		
		
		//end ELSE
	}
	//end REQUEST search		
}else {
	//SEARCH
	//	this is where the Search Crumb- flickr
	 
	$brdCrmb .=	'';
	
}
//DISPLAY the CRUMB	
$brdCrmb .=	'</ul>';
echo $brdCrmb;	

//************************************************************************
//					LIST OF ALL THE CURRENT METHODS		    			//
//************************************************************************

//only some being used others left just in case

//getBreadCrumbNGO_noUID($slp_id)-closest to original script
//getBreadCrumbETO($uid)
//getBreadCrumbNGO($uid)
//getBreadCrumbETO_0c($slp_id)
//getBreadCrumbNGO_0c($slp_id)
//getBreadCrumbETOserverNGOasset_0c($slp_id)
//getBreadCrumbETOserverNGOasset($slp_id)
//getBreadCrumbETO_server_NGO_0c($slp_id)


class breadCrumbClass {
	
	/**
	* Product database connect string
	*
	* @var string
	* @access public
	*/
	public $_productDB;
	public $_db;
	
	public function __construct($product_id){
		
		
		//connect to DB 
		$this->_db = DB::connect($this->getProductDBconnectString($product_id));
		if (DB::isError($this->_db)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
		
	}
	public function getType_by_slpid($slp_id){
		
		//************************************************************************
		//						GET TYPE USING SLPID			    			//
		//************************************************************************		    
		
		
		$type_query = "	SELECT type,puid 
						FROM eto1.manifest where slp_id='".$slp_id."'
						UNION 
						SELECT type,puid 
						FROM ngo1.manifest 
						WHERE slp_id='".$slp_id."'";
		$result =  $this->_db->query($type_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
 
		return $row['type'];
		
		
	}
	public function getPuid_by_slpid($slp_id){
		
		//************************************************************************
		//						GET TYPE USING SLPID			    			//
		//************************************************************************		    
		
		
		$type_query = "	SELECT type,puid 
						FROM eto1.manifest 
						WHERE slp_id='".$slp_id."'
						UNION 
			 			SELECT type,puid 
			 			FROM ngo1.manifest 
			 			WHERE slp_id='".$slp_id."'";
		
		$result =  $this->_db->query($type_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
 
		return $row['puid'];
 
		
	}
	public function getProductDBconnectString($product){
		
		$this->_db= DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($this->_db)) {
			echo "Error: Could not retrieve mysql connect string for $product";
		}
		$sql = sprintf("select value from appenv where app='$product' and key_name='product_db';");
		$this->_productDB = $this->_db->getOne($sql);
		$this->_db->disconnect();
		
		return $this->_productDB;
	}
	
	
	public function getBreadCrumbNGO_noUID($slp_id){
		
		$type="";
		$breadCrumb ="";
		//imported from the OLD breadcrumb script and adapted to use to process crumbs without UID's
		$topicqry = "select uid,puid,title_ent from ngo1.manifest where slp_id='".$slp_id."'";
		$result =  $this->_db->query($topicqry);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 	
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC); 
		
		$sub_topic_topic = $row['uid'];
		$sub_topic_topic_text = $row['title_ent'];
		$puid = $row['puid'];
		
		
		
		$spaceQry = "select product_id,uid,puid,title_ent,slp_id,type from ngo1.manifest where uid=".$puid;
		$result =  $this->_db->query($spaceQry);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$spaceSlpId = $row['slp_id'];
		$slp_id = $row['slp_id'];
		$spaceId = $row['uid'];
		$spaceName = $row['title_ent'];
		$spaceProduct_id = $row['product_id']; 
	 
		
		
		
		/**
		 * SLPId of the Xspace selected fetch parent Id from the xspace_browse table to get the Primary Topic.
		 */
		
		if ($row['puid'] == 0){
			
			$ptopicQry 	= "SELECT sb_parent_id,
					sb_child_id,sb_thing 
					FROM ngo1.xspace_browse where sb_child_id = 
					(select sb_parent_id from ngo1.xspace_browse where sb_child_id ='".$slp_id."')";
			
			
			$result =  $this->_db->query($ptopicQry);
			if((DB::isError($result)) || ($result->numRows() < 0))  return; 
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$ptopicId = $row['sb_parent_id'];
			$ptopicChildId = $row['sb_child_id'];
			$pTopicName = $row['sb_thing'];
		}
		
		/**
		 * For the primary topic ID get the Subject from Xspace_browse table.
		 */
		
		$subjQry = "select sb_parent_id,sb_child_id,sb_thing 
				FROM ngo1.xspace_browse where sb_child_id ='".$ptopicId."'";
		
		$result =  $this->_db->query($subjQry);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_subId = $row['sb_parent_id'];
		$language_subName = $row['sb_thing'];
		
		/**
		 * TOPIC, XSPACENAME, PRIMARY TOPIC AND SUBJECT are assingned to brdCrmb variable.
		 */
		
		if($type=="0laus"){
			
			$breadCrumb .= '<li><a href="/educators">Educator Resources</a></li>';
			$breadCrumb .= '<li><a href="/skill_builders">Skill Builders and Lesson Plans</a></li>';
			$breadCrumb .=	'<li>'.$sub_topic_topic_text.'</li></ul>';
			
			
		}else{
			//if this is a skill builder lesson plan
			//NOT TESTED
			if($type=='0trl'){
				$puid = $row['puid'];
				$parentqry = "select type, title_ent from manifest where uid='$puid'";
				
				$parentresult =  & $db->query($parentqry);
				
				if($parentresult->numRows() > 0) {
					$prow = $parentresult->fetchRow(DB_FETCHMODE_ASSOC);
					$parent_title = $prow['title_ent'];
					$parent_type = $prow['type'];
				}	 	
				
			}
			
			
			/***Display Language***/
			if($language_subName){			
				$breadCrumb .= '<li><a href="/browse?subject='.$language_subName.'" title="'.$language_subName.'">'.$language_subName.'</a></li>';
			}
			/*** Display Second Field - COURSE ***/
			if($pTopicName){
				$breadCrumb .=	'<li><a href="/browse?nodeid='. $ptopicChildId .'" title="'.$pTopicName.'">'.$pTopicName.'</a></li>';
			}
			
			/*** Display Topic ***/
			
			$breadCrumb .=	'<li><a href="/xspace?product_id='.$spaceProduct_id.'&id='.$spaceSlpId .'" title="'.$spaceName .'">'.$spaceName.'</a></li>';
			
			
			/*** Display SUB Topic Text  ***/
			
			$breadCrumb .=	'<li>'.$sub_topic_topic_text.'</li>';
			
			
			return $breadCrumb;    	 
			
			
		} 
		
		
		
	}
	
	public function getBreadCrumbETO($uid){
		
		
		//****************************************************************************
		//							Assemble CRUMB for ETO	    					//
		//						for types other than 0c and 0cw						//
		//****************************************************************************
		$breadCrumb="";
		
		$sub_topic_query = "select p.title_ent, p.slp_id, c.title_ent, c.uid  from eto1.manifest p, eto1.manifest c where c.puid = p.uid and c.uid = '".$uid."'";
		
		$result =  $this->_db->query($sub_topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$sub_topic_uid = $row['uid'];
		if($result->numRows() < 0) return;
		$sub_topic_title_ent = $row['title_ent'];//OUTPUT as 4th spot
		$sub_topic_slp_id = $row['slp_id'];
		
		
		$topic_query = "select * from xspace_browse where sb_child_id='".$sub_topic_slp_id."'";
		
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$topic_sb_parent_id = $row['sb_parent_id'];
		$topic_sb_child_id = $row['sb_child_id'];
		$topic_sb_type = $row['sb_type'];
		$topic_sb_thing = $row['sb_thing'];//OUTPUT as 3rd spot
		
		
		
		$course_query = "select * from xspace_browse where sb_child_id='".$topic_sb_parent_id."'";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		//$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];//OUTPUT as 2rd spot
		
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		//$language_sb_parent_id = $row['sb_parent_id'];
		//$language_sb_child_id = $row['sb_child_id'];
		//$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];//OUTPUT as 1st spot
		
		//setup ETO Breadcrumb
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li><a href="/xspace?product_id='. $_GET['product_id'] .'&id='.$topic_sb_child_id.'&uid='.$sub_topic_uid.'" title="'.$topic_sb_thing.'">'.$topic_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li>'.$sub_topic_title_ent.'</li>';
		
		
		
		return $breadCrumb;
	}   
	
	public function getBreadCrumbNGO($uid){
		
		
		//****************************************************************************
		//							Assemble CRUMB for ETO	    					//
		//						for types other than 0c and 0cw						//
		//****************************************************************************
		$breadCrumb="";
		
		$sub_topic_query = "select p.product_id,p.title_ent, p.slp_id, c.title_ent, c.uid  from eto1.manifest p, eto1.manifest c where c.puid = p.uid and c.uid = '".$uid."'";
		$result =  $this->_db->query($sub_topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		
		//if row is nutin then that means this asset has no relation in ETO
		if(!isset($row))
			return;
		
		//$sub_topic_uid = $row['uid'];
		if($result->numRows() < 0) return;
		$sub_topic_title_ent = $row['title_ent'];//OUTPUT as 4th spot
		$sub_topic_slp_id = $row['slp_id'];
		$sub_topic_product_id = $row['product_id'];
		
		
		
		
		
		
		$topic_query = "select * from xspace_browse where sb_child_id='".$sub_topic_slp_id."'";
		
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$topic_sb_parent_id = $row['sb_parent_id'];
		//$topic_sb_child_id = $row['sb_child_id'];
		//$topic_sb_type = $row['sb_type'];
		$topic_sb_thing = $row['sb_thing'];//OUTPUT as 3rd spot
		
		
		
		$course_query = "select * from xspace_browse where sb_child_id='".$topic_sb_parent_id."'";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		//$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];//OUTPUT as 2rd spot
		
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		//$language_sb_parent_id = $row['sb_parent_id'];
		//$language_sb_child_id = $row['sb_child_id'];
		//$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];//OUTPUT as 1st spot
		
		//setup ETO Breadcrumb
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		//$breadCrumb .=	'<li><a href="">'.$topic_sb_thing.'</a></li> ';
		$breadCrumb .=	'<li><a href="/xspace?product_id='.$sub_topic_product_id.'&id='.$sub_topic_slp_id .'" title="'.$topic_sb_thing .'">'.$topic_sb_thing.'</a></li>';
		$breadCrumb .=	'<li>'.$sub_topic_title_ent.'</li>';
		
		
		
		return $breadCrumb;
	}   
	
	public function getBreadCrumbETO_0c($slp_id){
		
		
		//****************************************************************************
		//							Assemble CRUMB for ETO	    					//
		//							FOR: 0c and 0cw TYPES							//
		//****************************************************************************
		
		$breadCrumb="";
		
		$topic_query = "select uid,puid,title_ent, slp_id from eto1.manifest where slp_id='".$slp_id."'";
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$topic_sb_thing = $row['title_ent'];
		$topic_slp_id = $row['slp_id'];
		
		
		
		$course_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id =(select sb_parent_id from xspace_browse where sb_child_id='".$topic_slp_id."')";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];
		
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_sb_parent_id = $row['sb_parent_id'];
		$language_sb_child_id = $row['sb_child_id'];
		$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];
		
		
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li>'.$topic_sb_thing.'</li> ';
		
		return $breadCrumb;
	}
	
	public function getBreadCrumbNGO_0c($slp_id){
		
		
		//****************************************************************************
		//							Assemble CRUMB for ETO	    					//
		//							FOR: 0c and 0cw TYPES							//
		//****************************************************************************
		
		$breadCrumb="";
		
		$topic_query = "select uid,puid,title_ent, slp_id from ngo1.manifest where slp_id='".$slp_id."'";
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$topic_sb_thing = $row['title_ent'];
		$topic_slp_id = $row['slp_id'];
		
		
		
		$course_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id =(select sb_parent_id from xspace_browse where sb_child_id='".$topic_slp_id."')";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];
		
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_sb_parent_id = $row['sb_parent_id'];
		$language_sb_child_id = $row['sb_child_id'];
		$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];
		
		
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li>'.$topic_sb_thing.'</li> ';
		
		return $breadCrumb;
	}
	
	
	public function getBreadCrumbETOserverNGOasset_0c($slp_id){
		
		//TEST FUNCTION	 
		
		
		//****************************************************************************
		//				Assemble CRUMB for NGO ASSET on ETO SERVER
		//							FOR: 0c and 0cw TYPES							//
		//****************************************************************************
		
		
		$breadCrumb="";
		
		$sub_topic_query = "select * from ngo1.manifest where slp_id ='".$slp_id."' and puid='0'";
		$result =  $this->_db->query($sub_topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$sub_topic_sb_thing = $row['title_ent'];
		$sub_topic_slp_id = $row['slp_id'];
		
		
		
		$topic_query = "select * from eto1.manifest where uid = (select puid from eto1.manifest where SLP_id ='".$slp_id."')";
		
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$topic_sb_thing = $row['title_ent'];
		$topic_slp_id = $row['slp_id'];
		
		
		$course_query = "select sb_parent_id,sb_child_id,sb_thing from eto1.xspace_browse where sb_child_id =(select sb_parent_id from eto1.xspace_browse where sb_child_id='".$topic_slp_id."')";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from eto1.xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_sb_parent_id = $row['sb_parent_id'];
		$language_sb_child_id = $row['sb_child_id'];
		$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];
		
		
		
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="">'.$topic_sb_thing.'</a></li> ';
		$breadCrumb .=	'<li>'.$sub_topic_sb_thing.'</li> ';
		
		
		
		return $breadCrumb;
		
		
		
		
	}
	
	
	public function getBreadCrumbETOserverNGOasset($slp_id){
		
		//TEST FUNCTION	 
		
		
		//****************************************************************************
		//				Assemble CRUMB for NGO ASSET on ETO SERVER
		//							FOR: NON 0c TYPES								//
		//returns:Language Arts->Course I->Workshop 3: Earth Alert-> Alternative Energy->Wind Power 
		//****************************************************************************
		
		$breadCrumb="";
		
		$article_sub_topic_query = "select * from ngo1.manifest where slp_id ='".$slp_id."'";
		$result =  $this->_db->query($article_sub_topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$article_sub_topic_sb_thing = $row['title_ent'];
		$article_sub_topic_slp_id = $row['slp_id'];
		
		
		
		$sub_topic_query = "select * from ngo1.manifest where uid = (select puid from ngo1.manifest where SLP_id ='".$slp_id."')";
		
		$result =  $this->_db->query($sub_topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$sub_topic_sb_thing = $row['title_ent'];
		$sub_topic_slp_id = $row['slp_id'];
		
		
		
		
		$topic_query = "select * from eto1.manifest where uid = (select puid from eto1.manifest where SLP_id ='".$sub_topic_slp_id."')";
		
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$topic_sb_thing = $row['title_ent'];
		$topic_slp_id = $row['slp_id'];
		
		
		$course_query = "select sb_parent_id,sb_child_id,sb_thing from eto1.xspace_browse where sb_child_id =(select sb_parent_id from eto1.xspace_browse where sb_child_id='".$topic_slp_id."')";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from eto1.xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_sb_parent_id = $row['sb_parent_id'];
		$language_sb_child_id = $row['sb_child_id'];
		$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];
		
		
		
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li><a href="">'.$topic_sb_thing.'</a></li> ';
		
		
		$breadCrumb .=	'<li><a href="/xspace?product_id='. $_GET['product_id'] .'&id='.$sub_topic_slp_id.'" title="'.$sub_topic_sb_thing.'">'.$sub_topic_sb_thing.'</a></li>';
		$breadCrumb .=	'<li>'.$article_sub_topic_sb_thing.'</li> ';
		
		
		return $breadCrumb;
		
		
		
		
	}
	//getBreadCrumbETOserverNGOasset_0c
	public function getBreadCrumbETO_server_NGO_0c($slp_id){
		
		
		//****************************************************************************
		//							Assemble CRUMB for ETO	    					//
		//							FOR: 0c and 0cw TYPES							//
		//****************************************************************************
		
		$breadCrumb="";
		
		$topic_query = "select uid,puid,title_ent, slp_id from eto1.manifest where slp_id='".$slp_id."'";
		$result =  $this->_db->query($topic_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		//if row is nutin then that means this asset has no relation in ETO
		if(!isset($row))
			return;
		
		$topic_sb_thing = $row['title_ent'];
		$topic_slp_id = $row['slp_id'];
		
		
		$course_query = "select sb_parent_id,sb_child_id,sb_thing from ngo1.xspace_browse where sb_child_id =(select sb_parent_id from ngo1.xspace_browse where sb_child_id='".$topic_slp_id."')";
		$result =  $this->_db->query($course_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$course_sb_parent_id = $row['sb_parent_id'];
		$course_sb_child_id = $row['sb_child_id'];
		$course_sb_type = $row['sb_type'];
		$course_sb_thing = $row['sb_thing'];
		
		
		$language_query = "select sb_parent_id,sb_child_id,sb_thing from ngo1.xspace_browse where sb_child_id ='".$course_sb_parent_id."'";
		$result =  $this->_db->query($language_query);
		if((DB::isError($result)) || ($result->numRows() < 0))  return;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_sb_parent_id = $row['sb_parent_id'];
		$language_sb_child_id = $row['sb_child_id'];
		$language_sb_type = $row['sb_type'];
		$language_sb_thing = $row['sb_thing'];
		
		
		$breadCrumb .= '<li><a href="/browse?subject='.$language_sb_thing.'" title="'.$language_sb_thing.'">'.$language_sb_thing.'</a></li>';
		$breadCrumb .=	'<li><a href="/browse?nodeid='. $course_sb_child_id .'" title="'.$course_sb_thing.'">'.$course_sb_thing.'</a></li>';
		
		$breadCrumb .=	'<li>'.$topic_sb_thing.'</li> ';
		
		return $breadCrumb;
	}
	
	public function oldCrumb($slp_id){
		
		
		//Determine what type of asset this is
		
		//echo $_REQUEST['uid'];
		$tqry = "select type,puid from ngo1.manifest where slp_id='".$slp_id."'";
		$result =  $this->_db->query($tqry);
		if($result->numRows() > 0) {
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$type = $row['type'];
		}
		
		
		
		//* If this is an xspace, get info from top level usage (where puid is 0)  
		if ($type == '0c') {
			$topicqry = "select uid,puid,title_ent from ngo1.manifest where slp_id='".$slp_id."' and puid = '0' ";
		}
		
		// if it is OCW then it is ETO   
		elseif($type == '0cw')   {
			
			$topicqry = "select uid,puid,title_ent from ngo1.manifest where slp_id='".$slp_id."' ";
			
			
		}
		// Otherwise, this is a subtopic (article or nonarticle)  
		else {
			$topicqry = "select uid,puid,title_ent from ngo1.manifest where slp_id='".$slp_id."'";
		}
		
		
		
		//if this is a lesson plan then find out if its a skill builder lesson plan or a 'regular' one.
		if($type=='0trl'){
			$puid = $row['puid'];
			$parentqry = "select type, title_ent from ngo1.manifest where uid='$puid'";
			
			$parentresult =  & $this->_db->query($parentqry);
			
			if($parentresult->numRows() > 0) {
				$prow = $parentresult->fetchRow(DB_FETCHMODE_ASSOC);
				$parent_title = $prow['title_ent'];
				$parent_type = $prow['type'];
			}	 	
			
		}
		
		
		$result =  & $this->_db->query($topicqry);
		if($result->numRows() > 0) {
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			
			$topic = $row['uid'];
			$topic_text = $row['title_ent'];
			$puid = $row['puid'];
			
			//	   		 echo "<BR>Topic=".$topic."<BR>";
			//	   		 echo "topic_text=".$topic_text."<BR>";
			//	   		 echo "puid=".$puid."<BR>";
			//	   		 echo "type=".$type."<BR>";
			
			if ($type != '0c' && $type != '0cw'  ){	
				
				$spaceQry = "select product_id,uid,puid,title_ent,slp_id,type from ngo1.manifest where uid=".$puid;
				
				
				
				$result =  & $this->_db->query($spaceQry);
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$spaceSlpId = $row['slp_id'];
				$slp_id = $row['slp_id'];
				$spaceId = $row['uid'];
				$spaceName = $row['title_ent'];
				$spaceProduct_id = $row['product_id'];
				
			}	
			
			
			
			
			
			//SLPId of the Xspace selected fetch parent Id from the xspace_browse table to get the Primary Topic.
			
			
			if ($row['puid'] == 0){
				$ptopicQry 	= "select sb_parent_id,sb_child_id,sb_thing from ngo1.xspace_browse where sb_child_id = (select sb_parent_id from ngo1.xspace_browse where sb_child_id ='".$slp_id."')";
				//echo "<BR><BR>ptopicQry=".$ptopicQry."<BR><BR><BR>";
				
				$result =  & $this->_db->query($ptopicQry);
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$ptopicId = $row['sb_parent_id'];
				$ptopicChildId = $row['sb_child_id'];
				$pTopicName = $row['sb_thing'];
			}
			
			
			// For the primary topic ID get the Subject from Xspace_browse table.
			
			
			$subjQry = "select sb_parent_id,sb_child_id,sb_thing from ngo1.xspace_browse where sb_child_id ='".$ptopicId."'";
			
			$result =  & $this->_db->query($subjQry);
			
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$subId = $row['sb_parent_id'];
			$subName = $row['sb_thing'];
			
			
			// TOPIC, XSPACENAME, PRIMARY TOPIC AND SUBJECT are assingned to brdCrmb variable.
			
			
			
			//if this is a skill builder lesson plan
			
			
			if(isset($parent_type) && $parent_type=='0laus'){
				
				$brdCrmb .= '<li><a href="/educators">Educator Resources</a></li>';
				$brdCrmb .= '<li><a href="/skill_builders">Skill Builders and Lesson Plans</a></li>';
				$brdCrmb .=	'<li>'.$parent_title.'</li>';
				
			}else{
				
				//  Display Subtopic  
				if($subName){			
					$brdCrmb .= '<li><a href="/browse?subject='.$subName.'" title="'.$subName.'">'.$subName.'</a></li>';
				}
				// Display Primary Topic 
				if($pTopicName){
					$brdCrmb .=	'<li><a href="/browse?nodeid='. $ptopicChildId .'" title="'.$pTopicName.'">'.$pTopicName.'</a></li>';
				}
				
				// Display Article  
				if ($type != '0c' && $type != '0cw'){
					
					//strip the Workshop
					if($_GET['product_id']=='eto'){
						
						list($workshopNumber, $justTitle) = split('[:]', $spaceName);
						$spaceName=$justTitle;
					}
					
					
					$brdCrmb .=	'<li><a href="/xspace?product_id='.$spaceProduct_id.'&id='.$spaceSlpId .'" title="'.$spaceName .'">'.$spaceName.'</a></li>';
				}
				// Display Topic Text  //
				
				
				
				if($_GET['product_id']=='eto'){
					if (isset($getXspace)){
						
						$brdCrmb .=	'<li>'.$getXspace->getOnlyTitle($xpertSpace).'</li>';
						
					}else{
						$brdCrmb .=	'<li>'.$topic_text.'</li>';
						
					}
					
				}
				else {
					
					$brdCrmb .=	'<li>'.$topic_text.'</li>';
					
					
					///
				}
			}//end if
			
			
			return $brdCrmb;	
		}		
		
	}
	
	 
	
 
		public function getBreadCrumbCOMBINED($slp_id,$uid){
		 
		$type="";
		$breadCrumb ="";
 
		$topicqry = "	SELECT uid,puid,title_ent FROM 
						eto1.manifest 
						WHERE slp_id='".$slp_id."' 
						AND uid='".$uid."'
						UNION
						SELECT uid,puid,title_ent FROM 
						ngo1.manifest 
						WHERE slp_id='".$slp_id."' 
						AND uid='".$uid."'";
		
		
		$result =  $this->_db->query($topicqry);
		 
		
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 	
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC); 
		
		$sub_topic_topic = $row['uid'];
		$sub_topic_topic_text = $row['title_ent'];
		$puid = $row['puid'];
		
		
		
		$spaceQry = "	SELECT product_id,uid,puid,title_ent,slp_id,type 
						FROM eto1.manifest 
						WHERE uid='$puid'
						UNION
						SELECT product_id,uid,puid,title_ent,slp_id,type 
						FROM ngo1.manifest 
						WHERE uid='$puid'
						";
		$result =  $this->_db->query($spaceQry);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$spaceSlpId = $row['slp_id'];
		$slp_id = $row['slp_id'];
		$spaceId = $row['uid'];
		$spaceName = $row['title_ent'];
		$spaceProduct_id = $row['product_id']; 
		
		
		
		
		
		
		/**
		 * SLPId of the Xspace selected fetch parent Id from the xspace_browse table to get the Primary Topic.
		 */
		
		if ($row['puid'] == 0){
			
			$ptopicQry 	= "	SELECT sb_parent_id, sb_child_id,sb_thing 
							FROM eto1.xspace_browse where sb_child_id = 
							(SELECT sb_parent_id 
							FROM eto1.xspace_browse 
							WHERE sb_child_id ='".$slp_id."')
							UNION
							SELECT sb_parent_id, sb_child_id,sb_thing 
							FROM ngo1.xspace_browse where sb_child_id = 
							(SELECT sb_parent_id 
							FROM ngo1.xspace_browse 
							WHERE sb_child_id ='".$slp_id."')";
			
			
			$result =  $this->_db->query($ptopicQry);
			if((DB::isError($result)) || ($result->numRows() < 0))  return; 
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$ptopicId = $row['sb_parent_id'];
			$ptopicChildId = $row['sb_child_id'];
			$pTopicName = $row['sb_thing'];
		}
		
		/**
		 * For the primary topic ID get the Subject from Xspace_browse table.
		 */
		
		$subjQry = "	SELECT sb_parent_id,sb_child_id,sb_thing 
						FROM eto1.xspace_browse 
						WHERE sb_child_id ='".$ptopicId."'
						UNION
						SELECT sb_parent_id,sb_child_id,sb_thing 
						FROM ngo1.xspace_browse 
						WHERE sb_child_id ='".$ptopicId."'";
		
		$result =  $this->_db->query($subjQry);
		if((DB::isError($result)) || ($result->numRows() < 0))  return; 
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$language_subId = $row['sb_parent_id'];
		$language_subName = $row['sb_thing'];
		
		/**
		 * TOPIC, XSPACENAME, PRIMARY TOPIC AND SUBJECT are assingned to brdCrmb variable.
		 */
		
		if($type=="0laus"){
			
			$breadCrumb .= '<li><a href="/educators">Educator Resources</a></li>';
			$breadCrumb .= '<li><a href="/skill_builders">Skill Builders and Lesson Plans</a></li>';
			$breadCrumb .=	'<li>'.$sub_topic_topic_text.'</li></ul>';
			
			
		}else{
			//if this is a skill builder lesson plan
			//NOT TESTED
			if($type=='0trl'){
				$puid = $row['puid'];
				$parentqry = "	SELECT type, title_ent 
								FROM eto1.manifest where uid='$puid'
								UNION
								SELECT type, title_ent 
								FROM ngo1.manifest where uid='$puid'";
				
				$parentresult =  & $db->query($parentqry);
				
				if($parentresult->numRows() > 0) {
					$prow = $parentresult->fetchRow(DB_FETCHMODE_ASSOC);
					$parent_title = $prow['title_ent'];
					$parent_type = $prow['type'];
				}	 	
				
			}
			
			
			/***Display Language***/
			if($language_subName){			
				$breadCrumb .= '<li><a href="/browse?subject='.$language_subName.'" title="'.$language_subName.'">'.$language_subName.'</a></li>';
			}
			/*** Display Second Field - COURSE ***/
			if($pTopicName){
				$breadCrumb .=	'<li><a href="/browse?nodeid='. $ptopicChildId .'" title="'.$pTopicName.'">'.$pTopicName.'</a></li>';
			}
			
			/*** Display Topic ***/
			
			$breadCrumb .=	'<li><a href="/xspace?product_id='.$spaceProduct_id.'&id='.$spaceSlpId .'" title="'.$spaceName .'">'.$spaceName.'</a></li>';
			
			
			/*** Display SUB Topic Text  ***/
			
			$breadCrumb .=	'<li>'.$sub_topic_topic_text.'</li>';
			
			
			return $breadCrumb;    	 
			
			
		} 
		
		
		
	}
	
	
	 
	
	
}
 


 