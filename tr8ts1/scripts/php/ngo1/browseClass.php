<?php 
/**
 * @name : browseClass.php
 * @author : Tanmay Joshi tjoshi-consultant@scholastic.com
 * @version : created on 08/20/2008
 * @return : $output / html string
 * 
 * it extends browseDB, it is used for retriving the Primary subjects, topics and Xspaces
 */
require_once('browseDB.php');
class browse extends browseDB {
	/**
	 * private _subject
	 *
	 * @var string
	 */
	public $_subject;
	/**
	 * private _nodeid, basically contains the topic 
	 *
	 * @var string
	 */
	private $_nodeid;
	
	/**
	 * _subjectList with contain the list of all the subjects from xspace table with sb_parent_id=0
	 *
	 * @var string / html
	 */
	private $_subjectList;
	
	/**
	 * _topicList contains list of all topics (nodes) based on the subject
	 *
	 * @var string / html
	 */
	private $_topicList;
	
	/**
	 * _xspaceList, contains the xspaceList based on the subject and nodeid(topic) been set
	 *
	 * @var string / html
	 */
	private $_xspaceList;
	
	/**
	 * _heading, heading for the topic selected
	 * @var string
	 */
	private $_heading;
	/**
	 * contructor
	 * intitialize the parent constructor, to use the database connection
	 *
	 */
	public function __construct(){
		parent::__construct();
		
	}
	
	/**
	 *  uses getSubjectSet of the parent class to build the subject list
	 *
	 */
	private function browseSubject(){
			
		$result=$this->getSubjectSet();
		$sizeofarray = sizeof($result)-1;
		$subject = $this->_subject;
		/**
 			* build the subject list and store html in $output variable
 			*/
		$i=0;
		if(!isset($output))
					$output="";
		foreach ($result as $rows){
			if(strtolower($rows['title'])==strtolower($subject)){
				$currClass = 'current';
			}else{$currClass = '';}
			if($i==0){
				$output.="<li class=\"last imgcss {$currClass}\" ><b product_id=\"$rows[productid]\" id=\"$rows[child_id]\" ext=\"$rows[ext]\"><a href=\"#\" title=\"Go to the $rows[title] Page\">$rows[title]</a></b></li>";
			}else if($i==$sizeofarray){
				$output.="<li class=\"{$currClass} imgcss\" ><b product_id=\"$rows[productid]\" id=\"$rows[child_id]\" ext=\"$rows[ext]\"><a href=\"#\" title=\"Go to the $rows[title] Page\">$rows[title]</a></b></li>";
			}else {
				$output.="<li class=\"imgcss {$currClass}\" ><b product_id=\"$rows[productid]\" id=\"$rows[child_id]\" ext=\"$rows[ext]\"><a href=\"#\" title=\"Go to the $rows[title] Page\">$rows[title]</a></b></li>";
			}

			++$i;
		}

		$this->_subjectList = $output;

	}
	
	/**
	 * uses getTopicSet of parent class based on the subject
	 *
	 */
	private function browseTopic(){
		 
		
			 if($_SERVER[GI_AUTH_PCODE]=="eto" && ($this->_subject=="Language Arts" || $this->_subject=="language arts"))
				 	$result = $this->getCourseSet();
			 else 	
			$result = $this->getTopicSet($this->_subject);
	  
			$sizeofarray = sizeof($result)-1;
			/**
 			* build the topic list and store html in $output variable
 			*/
			$output="<ul id=\"sub\">";

			$i=0;
			foreach ($result as $rows){
				
				if(empty($this->_nodeid)){
						$this->_nodeid = $rows['childid'];
						$this->_heading = $rows['title'];
						
					}
					if($this->_nodeid==$rows['childid']){
						$currClass = 'currentSub';
					}else{
						$currClass = '';
					}
				if($i==0){
					
					$output.="<li class=\"{$currClass}\" id=\"$rows[childid]\">";if($currClass==""){$output.="<a  href=\"#\" title=\"View ".$rows['title']."\">".$rows['title']."</a>";}else{$output.=$rows['title'];}$output.="</li>";

				}else if($i==$sizeofarray){
					$output.="<li class=\"last {$currClass}\" id=\"$rows[childid]\">";if($currClass==""){$output.="<a  href=\"#\" title=\"View ".$rows['title']."\">".$rows['title']."</a>";}else{$output.=$rows['title'];}$output.="</li>";

				}else {
					$output.="<li class=\"{$currClass}\" id=\"$rows[childid]\">";if($currClass==""){$output.="<a  href=\"#\" title=\"View ".$rows['title']."\">".$rows['title']."</a>";}else{$output.=$rows['title'];}$output.="</li>";

				}

				++$i;
			}
			$output.="</ul><div> </div>";
			
			 
			
			$this->_topicList = $output;
		
	}
	
	/**
	 * uses getXspaceSet of parent class based on the nodeid(topic) provided
	 *
	 * @param string $h1
	 * h1 is the name of the topic
	 */
	private function browseXspace($h1){
		
		if(!isset($output))
					$output="";
					
		$result = $this->getXspaceSet($this->_nodeid);
		 
		 
		
	 
		//different heading logos for ETO arts and NGO science and Social Studies
		if($_SERVER[GI_AUTH_PCODE]=="eto"){
			
			if($this->_subject=="Language Arts" || $this->_subject=="language arts" )
			{
				
				$output.="<h1 id=\"mainTitle\">{$h1}</h1>";
				$output.="<div id=\"subsubWrap\">";
				$output.="<ul class=\"subsubnav_eto\">";
				
			 
			}else {
			
				$output.="<h1 id=\"mainTitle_ngo\">{$h1}</h1>";
					$output.="<div id=\"subsubWrap\">";
				$output.="<ul class=\"subsubnav\">";
			}
				
			
		}else{
			
			$output.="<h1 id=\"mainTitle\">{$h1}</h1>";
			$output.="<div id=\"subsubWrap\">";
			$output.="<ul class=\"subsubnav\">";
		}
		
		
		
	 
	/* 	 $output.='<ul class="subsubnav" style="outline-color: rgb(255, 0, 0); outline-style: solid; outline-width: 1px;">
		 <li>
		 <a class="topCorners" title="Climates of the World" href="/xspace?id=10000901&amp;product_id=ngo">
                
                  <div class="linkTitle">
                  <a title="Climates of the World" href="/xspace?id=10000901&amp;product_id=ngo">Climates of the World</a>
                  </div>
                 
                 
                <img alt="" src="images/browse/bottom_corners.jpg" class="bottomCorners"/></li></ul>';*/
 
		 
  
		 
  
 
		 

	/*$output = '<ul style="outline-color: rgb(255, 0, 0); outline-style: solid; outline-width: 1px;" class="subsubnav_eto">
	 
	<div class="eduWrapper_eto"><a href="/xspace?id=g6w3a000&amp;product_id=eto" title="Workshop 3: Earth Alert">
	<img src="/csimage?product_id=eto&amp;id=g6w3apbr&amp;ext=jpg" alt="Earth Alert Browse image" height="95">
	</a><p class="etoTitle_browse"><a href="/xspace?id=g6w3a000&amp;product_id=eto">Workshop 3: Earth Alert</a></p>
	</div>
 
	
	</div></ul>';
		 */
		 
		  
		  
		  
		  
		foreach ($result as $rows){
		/**
		 * get the productid,assetid and extension to generate image for the particular xspace
		 */ 
		 
		 
			if($_SERVER[GI_AUTH_PCODE]=="eto" && ($this->_subject=="Language Arts" || $this->_subject=="language arts")){
				
					$assetSQL = "select p.uid as uid,p.slp_id as assetID,
						p.title_ent as title, 
						p.fext as ext, 
						p.product_id as productid,
						c.title_ent as xptitle 
						from manifest c 
						inner join manifest p 
						on c.uid=p.puid 
						and c.slp_id='{$rows['sb_child_id']}' 
						and p.category='xt01' and p.type='0mip';";
				 
								
			 
		/**
		 * store the path of xspace image in $mainImageHTML variable
		 * output the xspace with a ETO wrapper
		 */				
								
			 
			$resultimg = $this->newdb_eto->query($assetSQL)->fetchrow(DB_FETCHMODE_ASSOC);
		 			
			$mainImageHTML= "/csimage?product_id=".$resultimg['productid']."&id=".$resultimg['assetID']."&ext=".$resultimg['ext'];
			$output.='<div class="eduWrapper_eto">';
			$output.='<a href="/xspace?id='.$rows['sb_child_id'].'&product_id='.$resultimg['productid'].'&uid='.$resultimg['uid'].'" title="'.$resultimg['xptitle'].'">';
			$output.='<img height="95" src="'.$mainImageHTML.'" alt="'.$resultimg['title'].'" /></a>';
			$output.='<p class="etoTitle_browse"><a href="/xspace?id='.$rows['sb_child_id'].'&product_id='.$resultimg['productid'].'&uid='.$resultimg['uid'].'">'.$resultimg['xptitle'].'</a></p>';
			$output.='</div>';
			$output.="</li>";
		 	 
			
			}	 
			else
			{
				$assetSQL = "select p.uid as uid,p.slp_id as assetID,
						p.title_ent as title, 
						p.fext as ext, 
						p.product_id as productid,
						c.title_ent as xptitle 
						from manifest c 
						inner join manifest p 
						on c.uid=p.puid 
						and c.slp_id='{$rows['sb_child_id']}' 
						and p.category='xs01' and p.type='0mip';";
			 
				$resultimg = $this->newdb->query($assetSQL)->fetchrow(DB_FETCHMODE_ASSOC);
		/**
		 * store the path of xspace image in $mainImageHTML variable
		 * output the xspace with a NGOwrapper
		 */
			$mainImageHTML= "/csimage?product_id=".$resultimg['productid']."&id=".$resultimg['assetID']."&ext=".$resultimg['ext'];
			$output.="<li>";
			$output.="<a href=\"/xspace?id=$rows[sb_child_id]&product_id=".$resultimg['productid'].'&uid='.$resultimg['uid']."\" title=\"".$resultimg['xptitle']."\" class=\"topCorners\">
                <img src=\"$mainImageHTML\" alt=\"".$resultimg['title']."\" /></a>
                <div class=\"linkTitleWrap\"> <div class=\"linkTitle\">
                  <a href=\"/xspace?id=$rows[sb_child_id]&product_id=".$resultimg['productid'].'&uid='.$resultimg['uid']."\" title=\"".$resultimg['xptitle']."\">".$resultimg['xptitle']."</a></div>
                </div>
                <img class=\"bottomCorners\" src=\"images/browse/bottom_corners.jpg\" alt=\"\" />";

			$output.="</li>";
		 
			
			}
	 
		
		}
		
		$output.="</ul>";
		$output.="</div>";

		$this->_xspaceList = $output;
	}
	/**
	 * set the subject for query
	 *
	 * @param string $subject
	 */
	public function setSubject($subject){
		$this->_subject = $subject;	
	}
	
	/**
	 * sets the nodeid(topic)
	 *
	 * @param string $nodeid
	 */
	public function setNodeId($nodeid){
		$this->_nodeid = $nodeid;
	}
	
	/**
	 * uses browseSubject to get the subject list and returns it
	 *
	 * @return string /  html
	 */
	public function getSubjectList(){
		$this->browseSubject();
		return $this->_subjectList;
	}
	
	/**
	 * uses browseTopic to get the topiclist (list of nodes) and returns the same
	 *
	 * @return string / html
	 */
	public function getTopicList(){
		$this->browseTopic();
		return $this->_topicList;
	}
	
	/**
	 * gets Xspace list
	 *
	 * @param string $h1
	 * @return string / html
	 */
	public function getXspaceList($h1){
		if(($h1=='')||($h1=='undefined')){
			$h1 = $this->_heading;
		}
		$this->browseXspace($h1);
		return $this->_xspaceList;	
	}

	
	/**
	 * disconnect both NGO and ETO
	 *
	 * @param string $h1
	 * @return string / html
	 */
	
	
	public function disconnect_db(){
		$this->newdb->disconnect();
		$this->newdb_eto->disconnect();
	 
	}
	

     
       	
}

?>