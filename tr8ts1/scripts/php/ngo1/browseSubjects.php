<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);
/**
 * @name : browseSubjects.php
 * @author : Tanmay Joshi tjoshi-consultant@scholastic.com
 * @version : created on 08/20/2008
 * @return : $output / html string
 * 
 * It uses browseClass.php. depending on the subject flag it gets the subject list and sets nodeId
 * In phase I we have subject as Science / Social Studies
 * 
 */
 

 
require_once('browseClass.php');


$subject =$_REQUEST['subject'];
 
if($subject=="") 
	$nodeid =$_REQUEST['topic'];	

$h1 =isset($_REQUEST['h1']) ? $_REQUEST['h1'] : NULL;	
$subflag =isset($_REQUEST['subflag']) ? $_REQUEST['subflag'] : NULL;
$browse = new browse();


 
/**
 * if nodeid is provided then we have to search the subject and heading for that nodeid provided
 */

if($nodeid!=''){
	$sql = sprintf("select x.sb_thing as h1 ,x.sb_parent_id as parentid, x1.sb_thing as subject from xspace_browse x inner join xspace_browse x1 on x.sb_parent_id = x1.sb_child_id where x.sb_child_id = '%s';",$_REQUEST['topic']);
	$result = $browse->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	//$h1 = $result[0]['h1'];
	$subject = $result[0]['subject'];

}

if(!empty($subject)){
	$browse->setSubject($subject);
}else{
 
	if($_SERVER[GI_AUTH_PCODE]=="eto")
			$browse->setSubject('language arts');
	if($_SERVER[GI_AUTH_PCODE]=="xs")
			$browse->setSubject('science');
 
	
}

/**
 * if subflag is equals 0, it means that this class is intialized on page load, so we need to get
 * the subject list tab (Science and Social Studies in phase I)
 */

if($subflag==0){
	$subList = $browse->getSubjectList();	
}else{
	$subList = $browse->getSubjectList();	
	
}

/**
 * if subject is specified, we need to set the subject using setSubject function.
 * Depending on the subject sql query is build. If no subject is specified we would take science as default 
 * 
 */

 
if(empty($_REQUEST['home'])){
	 
/**
 * if topic (nodeID) is not specified, we will retrive all the topics based on the subject.
 * If topic is pased in the query string, we would set the topic(nodeid) and retrive all the
 * related Xspaces
 */
	if(empty($nodeid)||($nodeid=="undefined")){
		$topicList = $browse->getTopicList();
	}else{
		$browse->setNodeId($nodeid);
		$topicList = $browse->getTopicList();
	}
	
  
/**
 * retrive all the xspace related to the topics and pass the Heading of the topic,
 * to set it in the html
 */
	$xspaceList = $browse->getXspaceList($h1);
       
}else{
	if(empty($nodeid)||($nodeid=="undefined")){
		$topicList = $browse->getTopicList();
	}else{
		$browse->setNodeId($nodeid);
		$topicList = $browse->getTopicList();
	}
	
	
}

/**
 * separate the subjectList, topicList and xspaceList with <-breakbrowselist->
 * which will be used to split the list.
 */

		if(!isset($topicList))
				$topicList="";
		if(!isset($xspaceList))
				$xspaceList="";
		
$output = $subList."<-breakbrowselist->".$topicList."<-breakbrowselist->".$xspaceList;
echo $output;
$xspaceList = $browse->disconnect_db();
?>
