<?php
include($_SERVER['INCLUDE_HOME'].'/folder_header.php');
?>
	<script>
		$(document).ready(function(){
			$(".videoPopup").colorbox({
				width:"870px", height:"640px"
				//onOpen:function(){ alert('onOpen: colorbox is about to open'); },
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
			$(".creditPopup").colorbox({
				width:"500px", height:"300px", inline:true, href:"#inline_credit",
				onOpen:function(){  document.getElementById('inline_credit').innerHTML = $(this).attr("content");}
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
			
			
			$(".example9").colorbox({
				onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
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
	p{
	text-align: left;
	margin-left: 40px;
	line-height: 100%;
	}
	#weekid{
	color:	#0000EE;
	text-align: left;
	margin-left: 40px;
	line-height: 100%;
	display:inline;
	}	
	a#page {
	    margin-left: 47px;
	}	
	</style>
<div id="content">                 
<?php
$NEW_WEEK = true;
echo "<H1>".$curr_folder[0]['node_title']."</H1>";
$unit_id = $_REQUEST['unit_id'];


echo displayUnitNav($FOLDER_HANDLER, $FOLDER_ID, $unit_id, $GRADE_ID);

//if we are viewing all units...
if($unit_id == 'all'){
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	$unitCount = count($children);	
	
	for($i=0; $i<$unitCount; $i++)
	{			
		$unit_title = $children[$i]['node_title'];
		$current_id = $children[$i]['cid'];
		echo '<h2>'. $unit_title.'</h2>'; 			
		displayCategorytBrowseLevel($current_id, $FOLDER_HANDLER);		
	}

}else if(empty($unit_id))
{
	//displayCategorytBrowseLevel($FOLDER_ID);
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	$current_id = $children[0]['cid'];
		$unit_title = $children[0]['node_title'];
		
		echo '<h2>'. $unit_title.'</h2>'; 		
	displayCategorytBrowseLevel($current_id, $FOLDER_HANDLER);
	
}
else 
{
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$unitInfo = $FOLDER_HANDLER->getNode($unit_id,$productFacet);	
	$unit_title = $unitInfo[0]['node_title'];
	echo '<h2>'. $unit_title.'</h2>'; 

	displayCategorytBrowseLevel($unit_id);	
}

//function to display the blue unit nav that appears on the mentor videos page and the lesson pages page.
function displayUnitNav($FOLDER_HANDLER, $FOLDER_ID, $unit_id, $GRADE_ID){
	
	//get the data to fill the blue nav bar on top (the units)
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
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
		
		$navRetVal .= '<li '.$theClass.'><a href="/unitPages/'. $GRADE_ID .'/'.$FOLDER_ID.'/'.$current_id.'">'.$title.'</a></li>';
		
	}
	
	if($unit_id=="all"){
		$theClass = 'class="indicator"';
	}else{
		$theClass = "";
	}
	
	$navRetVal .= '<li '.$theClass .'><a href="/unitPages/'. $GRADE_ID.'/'. $FOLDER_ID.'/all">View All</a></li>';
	$navRetVal .= '</ul>';
	
	return $navRetVal;

}

function displayCategorytBrowseLevel($id)
{
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	global $FOLDER_HANDLER,$NEW_WEEK;
	$children = $FOLDER_HANDLER->getNodeChildren($id,$productFacet);
	$children_count = count($children);
	
	for($i = 0; $i < $children_count; $i++)
	{		
		//CHECK TO SEE IF we are given a title like [title]. if so.. Display Space.
		if(!(substr($children[$i]['node_title'], 0,1) == '[' && substr($children[$i]['node_title'], -1) == ']'))
		{
			//CHECK TO SEE IF we are at a leaf. If so then don't display.
			if($children[$i]['node_type'] != 'T')
			{
				//echo $children[$i]['node_title']." -- ".$children[$i]['cid']."<br>";	
				echo "<div id='weekid'><b>".$children[$i]['node_title']." </b></div>";	
				$NEW_WEEK = true;
			}
		}

		displayCategorytBrowseLevel($children[$i]['cid']);
		if($children_count == 1){echo "<br>";}
	}
	
	if($children_count == 0)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		$children = $FOLDER_HANDLER->getManifestSLPID($id,$productFacet);			 			
		$children_count = count($children);
		if($children_count > 0)
		{
			$formatedPdfFileName = addslashes($children[0]['title']);
			$formatedPdfFileName = base64_encode($children[0]['title']);
			//print $formatedPdfFileName;
				
			//CHECK TO SEE IF ITs A WEEK ROW. IF IT IS DISPLAY IT ON THE SAME AS THE WEEK.
			if($NEW_WEEK)
			{
				
				//JP PUT BACK	echo "<a href=\"javascript:launchPDF('".$children[0]['slp_id']."','".$children[0]['title_ascii']."','download');\">";				
				//echo "<a href=\"javascript:launchPDF('".$children[0]['slp_id']."','"."','download');\">";
						
				echo "<a href=\"javascript:launchPDF('".$children[0]['slp_id']."','".$formatedPdfFileName."','download');\">";
				echo $children[0]['title_ent'];
				echo'</a><br>';
				$NEW_WEEK = false;
			}
			else 
			{
				
//JP PUT BACK echo "<p> <a id=\"page\" href=\"javascript:launchPDF('".$children[0]['slp_id']."','".$children[0]['title_ascii']."','download');\">";				
//echo "<p> <a id=\"page\" href=\"javascript:launchPDF('".$children[0]['slp_id']."','"."','download');\">";	
				echo "<p> <a id=\"page\" href=\"javascript:launchPDF('".$children[0]['slp_id']."','".$formatedPdfFileName."','download');\">";					
				echo $children[0]['title_ent'];
				echo'</a></p>';				
			}
			displayManifestLevel($children[0]['slp_id']);
		}
		else 
		{
			echo "<br><b>No Manifest Row</b><br>";
		}
	}
			
}
	
function displayManifestLevel($id)
{		
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	global $FOLDER_HANDLER;
	$children = $FOLDER_HANDLER->getManifestChildren($id,null,$productFacet);
	$children_count = count($children);

	for($i = 0; $i < $children_count; $i++)
	{		
		echo "<b>displayManifestLevel</b><br>";
		//echo $children[$i]['slp_id'] .' --> ' .$children[$i]['title_ent'].".".$children[$i]['fext'].' --> ' .$children[$i]['type'].' --> ' .$children[$i]['grades'].' --> ' .$children[$i]['sort_order'].' --> ' .$children[$i]['uid']."<br>";
		displayManifestLevel($children[$i]['slp_id']);
	}				
}
	
	
	
	
	

include($_SERVER['INCLUDE_HOME'].'/folder_footer.php');
?>