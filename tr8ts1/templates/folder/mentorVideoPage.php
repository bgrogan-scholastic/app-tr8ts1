<?php
include($_SERVER['INCLUDE_HOME'].'/folder_header.php');
?>
	<script>
		$(document).ready(function(){
			$(".videoPopup").colorbox({
				//iframe:true, innerWidth:"700px", innerHeight:"640px"
				iframe:true, innerWidth:"870px", innerHeight:"680px", paddingLeft:"100px"
				//onOpen:function(){ alert('onOpen: colorbox is about to open'); },
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
			$(".creditPopup").colorbox({
				width:"500px", height:"300px", inline:true, href:"#inline_credit",
				onOpen:function(){  document.getElementById('inline_credit').innerHTML = $(this).attr("content")+ '<div class="closeButton"><a id="page" href="#" onclick="javascript:parent.$.fn.colorbox.close();">Close</a></div>';}
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
				
		});
	</script>
	
	<style>	
	h2 {
	color: #F60;
	font-size: 16px;
	font-weight: bold;
	margin-left: 40px;
	padding-top: 12px;
	line-height: 110%;
	}	
	</style>
	
<div id="content">           
<?php
echo "<H1>".$curr_folder[0]['node_title']."</H1>";

$unit_id = $_REQUEST['unit_id'];

//function to display the blue unit nav that appears on the mentor videos page and the lesson pages page.
function displayUnitNav($FOLDER_HANDLER, $FOLDER_ID, $unit_id, $GRADE_ID){
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	//get the data to fill the blue nav bar on top (the units)
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	$unitCount = count($children);

	$navRetVal = '';
	$navRetVal .= '<ul id="page-menu">';
	for($i=0; $i<$unitCount; $i++){
		
		$title = $children[$i]['node_title'];
		$current_id = $children[$i]['cid'];
		
		if($unit_id==$current_id){
			$theClass = 'class="indicator"';
		}else{
			$theClass = "";
		}
		
		if(empty($unit_id) && $i==0){
			
			$theClass = 'class="indicator"';
		}
				
		$navRetVal .= '<li '.$theClass.'><a href="/mentorVideos/'. $GRADE_ID .'/'.$FOLDER_ID.'/'.$current_id.'">'.$title.'</a></li>';
		
	}
	
	if($unit_id=="all"){
		$theClass = 'class="indicator"';
	}else{
		$theClass = "";
	}
	
	$navRetVal .= '<li '.$theClass .'><a href="/mentorVideos/'. $GRADE_ID.'/'. $FOLDER_ID.'/all">View All</a></li>';
	$navRetVal .= '</ul>';
	
	return $navRetVal;

}

echo displayUnitNav($FOLDER_HANDLER, $FOLDER_ID, $unit_id, $GRADE_ID);



function displayMentorVideos($unit_id, $FOLDER_HANDLER){
	
	$retVal = "";
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	//get the unit title
	$unitInfo = $FOLDER_HANDLER->getNode($unit_id,$productFacet);	
	$unit_title = $unitInfo[0]['node_title'];

	$retVal .= '<h2>'. $unit_title.'</h2>'; 
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	//get all the videos
	$mentor_videos = $FOLDER_HANDLER->getCBrowseManifestChildren($unit_id,$productFacet);
	$videoCount = count($mentor_videos);
			
	for($i=0; $i<$videoCount; $i++){
		
		$slp_id = $mentor_videos[$i]['slp_id'];
		$credit = $mentor_videos[$i]['credit'];
		$title = $mentor_videos[$i]['title_ent'];
		
		if($mentor_videos[$i]['facet'] == $_SERVER['TRAITSPACE_FACET_ID']){
			
			
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		$photoInfo = $FOLDER_HANDLER->getManifestChildren($slp_id,null,$productFacet);
		
		$photo_slp_id = $photoInfo[0]['slp_id'];
		
		$retVal .= '<div id="picture">';
		$retVal .= '<h3>'.$mentor_videos[$i]['title_ent'].'</h3>';
		$video_title = urlencode(html_entity_decode($mentor_videos[$i]['title_ent']));
		
		$retVal .= '<a class="videoPopup" href="/folder/popup_video.php?filename='.$slp_id.'&title='.$video_title.'"><img src="/csimage?id='.$photo_slp_id.'&product_id=tr8ts&skipdb=y&width=115&height=78" border="0"></a>';
		$retVal .= '<br><a class="creditPopup" href="#" content="'.$credit.'">Credits</a>';
		$retVal .= '</div>';
		}
	}
	
	return $retVal;	
		
	
}//end function

//if we are viewing all units...
if($unit_id == 'all'){
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	$unitCount = count($children);	
	
	for($i=0; $i<$unitCount; $i++){
		
		$current_id = $children[$i]['cid'];
		echo displayMentorVideos($current_id, $FOLDER_HANDLER);
		echo '<BR clear="all"><hr>';
		
	}
	
}else if($unit_id == '0'){
	

	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	$current_id = $children[0]['cid'];
	echo displayMentorVideos($current_id, $FOLDER_HANDLER);
	
	
//if we are viewing just one unit	
}else{
	
	echo displayMentorVideos($unit_id, $FOLDER_HANDLER);
	
}//end if
?>
	<div style='display:none'>
		<div id='inline_credit' style='background:#fff;'>
		</div>
		<div class="closeButton"><a id="page" href="#" onclick="javascript:parent.$.fn.colorbox.close();">Close</a></div>
	</div>
	<br clear="all"/>
<?php
include($_SERVER['INCLUDE_HOME'].'/folder_footer.php');
?>