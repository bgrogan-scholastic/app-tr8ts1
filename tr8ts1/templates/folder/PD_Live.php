<?php
include($_SERVER['INCLUDE_HOME'].'/folder_header.php');


function displayCategorytBrowseLevel($id, $eocount=0)
{
	global $FOLDER_HANDLER,$first_node;
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($id,$productFacet);
	//print '<pre>'; print_r($children); print '</pre>';
	$children_count = count($children);
	//print $children_count.'<br>';
	$evenodd=1;
	for($i = 0; $i < $children_count; $i++)
	{		
		$evenodd++;
		//CHECK TO SEE IF we are given a title like [title]. if so.. Display Space.
		if(!(substr($children[$i]['node_title'], 0,1) == '[' && substr($children[$i]['node_title'], -1) == ']'))
		{
			//CHECK TO SEE IF we are at a leaf. If so then don't display.
			if($children[$i]['node_type'] != 'T')
			{
				//echo $children[$i]['node_title']." -- ".$children[$i]['cid']."<br>";
				//echo '<table border="3"><tr><td colspan="2">';
				if ($i!=0) {
					echo '</tr></table>';
				}
				
				echo '
					<table border="0" width="100%" class="pdLive678">
						<tr>
							<td colspan="2">';
				echo "<H2>".$children[$i]['node_title']."</H2>";
				echo '
							</td>
						</tr>
				';
				
				
				if ($children_count == 0) {
					
					echo '</table>';
				} else {
					
				}
				
			} elseif ($i == 0) {
				echo '
				<tr>
				';	
			} elseif ( $evenodd % 2 == 0) {
				echo '</tr><!--2nd col-->';
				echo '<tr>';
				
			} else {

			}
		}
		else 
		{
			if($first_node)
			{
				$first_node = false;
			}	

			else 
			{
				echo '</tr>';
			}
		}
		
		displayCategorytBrowseLevel($children[$i]['cid'], $eocount);
		
	}
	
	if($children_count == 0)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		$children = $FOLDER_HANDLER->getManifestSLPID($id,$productFacet);			 			
		$children_count = count($children);
		
		if($children_count > 0)
		{
		//$formatedPdfFileName = base64_encode($children[0]['title_ascii']);
		//print $formatedPdfFileName;
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		$credit = $children[0]['credit'];
		$useImage = $FOLDER_HANDLER->getManifestChildren($children[0]['slp_id'],null,$productFacet);
		/*
		echo '
			<td width="50%">
				<table border="0" width="100%" class="singleitem">
					<tr>
						<td>
							<div style="padding: 10px;">
							<h3>
		';
								echo $children[0]['title_ent'];
		
		echo '			
							</h3>	
						</div>
						</td>
					</tr>
					<tr>
						<td>
							<div style="padding: 10px;">
								<a class="videoPopup cboxElement" href="/folder/popup_video.php?filename='.$children[0]['slp_id'].'&title='.$children[0]['title_ent'].'"><img src="/csimage?id='.$useImage[0]['slp_id'].'&product_id=tr8ts&skipdb=y&width=115&height=78" border="0"></a>
								<br>
								<a class="creditPopup" href="#" content="'.$credit.'">Credits</a>
							</div>
		';
		
		echo '
						</td>
					</tr>
				</table>
			</td>
		';
		*/
		
		echo '
			<td width="50%">
				<div class="pdBlock">
					<h3>'.$children[0]['title_ent'].'</h3>
					<a class="videoPopup cboxElement" href="/folder/popup_video.php?filename='.$children[0]['slp_id'].'&title='.$children[0]['title'].'"><img src="/csimage?id='.$useImage[0]['slp_id'].'&product_id=tr8ts&skipdb=y&width=115&height=78" border="0"></a>
					<br>
					<a class="creditPopup" href="#" content="'.$credit.'">Credits</a>
				</div>
			</td>
		';
		
		
			displayManifestLevel($children[0]['slp_id']);
		}
		
		else 
		{
			//echo "<b>No Manifest Row</b><br>";
			echo "<tr><td><b>No Manifest Row</b></td>";
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
		//echo "<b>displayManifestLevel</b><br>";
		//echo $children[$i]['slp_id'] .' --> ' .$children[$i]['title_ent'].".".$children[$i]['fext'].' --> ' .$children[$i]['type'].' --> ' .$children[$i]['grades'].' --> ' .$children[$i]['sort_order'].' --> ' .$children[$i]['uid']."<br>";
		displayManifestLevel($children[$i]['slp_id']);
	}				
}


function displayMentorVideos($subfolder_id, $FOLDER_HANDLER){
	
	$retVal = "";
	
	//get the subfolder title
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$subfolderInfo = $FOLDER_HANDLER->getNode($subfolder_id,$productFacet);	
	$subfolder_title = $subfolderInfo[0]['node_title'];

	$retVal .= '<h2>'. $subfolder_title.'</h2>'; 
	
	//get all the videos
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$mentor_videos = $FOLDER_HANDLER->getCBrowseManifestChildren($subfolder_id,$productFacet);
	$videoCount = count($mentor_videos);
			
	for($i=0; $i<$videoCount; $i++){
		
		$slp_id = $mentor_videos[$i]['slp_id'];
		$credit = $mentor_videos[$i]['credit'];
		$title = $mentor_videos[$i]['title_ent'];
//print $mentor_videos[$i]['facet'];
		if($mentor_videos[$i]['facet'] == $_SERVER['TRAITSPACE_FACET_ID']){
			
		

		$photoInfo = $FOLDER_HANDLER->getManifestChildren($slp_id,null,$productFacet);
		
		$photo_slp_id = $photoInfo[0]['slp_id'];
		
		$retVal .= '<div id="picture">';
		$retVal .= '<h3>'.$mentor_videos[$i]['title_ent'].'</h3>';
		$video_title = urlencode(html_entity_decode($mentor_videos[$i]['title']));
		//$video_title = addslashes($mentor_videos[$i]['title']);
		
		$retVal .= '<a class="videoPopup" href="/folder/popup_video.php?filename='.$slp_id.'&title='.$video_title.'"><img src="/csimage?id='.$photo_slp_id.'&product_id=tr8ts&skipdb=y&width=115&height=78" border="0"></a>';
		$retVal .= '<br><a class="creditPopup" href="#" content="'.$credit.'">Credits</a>';
		$retVal .= '</div><br clear=all>';
		}
	}
	
	return $retVal;	
		
	
}//end function

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
	h2 
	{
		color: #F60;
		font-size: 16px;
		font-weight: bold;
		margin-left: 40px;
		padding-top: 0px;
		line-height: .2em;
	}
	
	#picture 
	{
			margin-right: 18px;
			margin-left: 70px;
			margin-bottom:30px;
			width:500px;
	}
	
	p 
	{
		margin-left: 40px;
	}
	
	</style>

        <div id="content">
<?php
	echo "<H1>".$curr_folder[0]['node_title']."</H1>";
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$subfolder_Array = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	
	
	//echo $FOLDER_ID; echo "<pre>"; print_r($subfolder_Array); echo "</pre>";
	
	
	//print_r($_REQUEST);
	// bryans - hardcode grade ids for 6-8 for different layout
	if ($_REQUEST['grade_id'] == 'node-33626' || $_REQUEST['grade_id'] == 'node-33723' || $_REQUEST['grade_id'] == 'node-33820') {
		
		/*
		$html = '';
		
		foreach($subfolder_Array as $lessonCat) {
			$lessonCatId=$lessonCat['cid'];
			//print $lessonCatId.'<br>';
			$lessonCatArray=$FOLDER_HANDLER->getNodeChildren($lessonCatId);
			print '<pre>'; print_r($lessonCatArray); print '</pre>';
			$html .= '<h2>'.$lessonCat['node_title'].'</h2>';
			
			foreach ($lessonCatArray as $lessonArray) {
				//print '<pre>'; print_r($lessonArray); print '</pre>';
				
				if ($lessonArray['node_type']=='T') {
					$manifest_info = $FOLDER_HANDLER->getManifestSLPID($lessonItem['cid']);
					print '<pre>';print_r($manifest_info);print '</pre>';
				} 
				
				
				$lessonItems=$FOLDER_HANDLER->getNodeChildren($lessonArray['cid']);
				//print '<pre>'; print_r($lessonItems); print '</pre>';
				$html .= '
					<table border="0" width="640" align="center">
					<tr>
				';
				$col=1;
				$countItems=count($lessonItems);
				//print $countItems;
				foreach ($lessonItems as $lessonItem) {
					//$manifest_info = $FOLDER_HANDLER->getManifestSLPID($children[0]['cid']);
					$manifest_info = $FOLDER_HANDLER->getManifestSLPID($lessonItem['cid']);
					//print '<pre>'; print_r($manifest_info); print '</pre>';
					$credit = $manifest_info[0]['credit'];
					$formatedPdfFileName = base64_encode($manifest_info[0]['title']);
					//print $formatedPdfFileName;
					$useImage = $FOLDER_HANDLER->getManifestChildren($lessonItem['cid']);
					//print '<pre>'; print_r($useImage); print '</pre>';
					
					$html .= '
							<td width="50%" valign="top">
								<div style="text-align: left; border: 0px solid red;"><h3>'.$lessonItem['node_title'].'</h3></div>
								<div style="border: 0px solid red; text-align: center; padding: 10px;">
									<a class="videoPopup cboxElement" href="/folder/popup_video.php?filename='.$lessonItem['cid'].'&title='.$manifest_info[0]['title'].'"><img src="/csimage?id='.$useImage[0]['slp_id'].'&product_id=tr8ts1&skipdb=y&width=115&height=78" border="0"></a>
									<br>
									<a class="creditPopup" href="#" content="'.$credit.'">Credits</a>
								</div>
							
							</td>
						';
					
					if ( $col % 2 == 0) {
						$html .= '</tr>';
					}
					
					if ( $col % 2 == 0 && $col < $countItems) {
						$html .= '<tr>';
					} elseif ($col == $countItems) {
						$html .= '<td> </td>';
					}
					
					$col++;
					
				}
				
				$html .= '</table>';
			}
			
		}
		
		print $html;
		*/
		
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$first_node = true;
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	//echo "<pre>"; print_r($children); echo "</pre>";
	//echo "<H1>".$curr_folder[0]['node_title']."</H1>";
	displayCategorytBrowseLevel($FOLDER_ID);
	echo '</tr></table>';
	
	
	} else {
	
		$subfolder_Count = count($subfolder_Array);
				
		for($i=0; $i<$subfolder_Count; $i++)
		{
			if($i != 0)
			{
				echo displayMentorVideos($subfolder_Array[$i]['cid'],$FOLDER_HANDLER);
			}
			else 
			{
				$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
				$children = $FOLDER_HANDLER->getNodeChildren($subfolder_Array[$i]['cid'],$productFacet);
				$manifest_info = $FOLDER_HANDLER->getManifestSLPID($children[0]['cid'],$productFacet);		
				$formatedPdfFileName = addslashes($manifest_info[0]['title']);
				$formatedPdfFileName = base64_encode($manifest_info[0]['title']);
				//print $formatedPdfFileName;
				//Into pdf
	
				echo '<h2 style="padding-top:20px;">'. $subfolder_Array[$i]['node_title'].'</h2>'; 			
				echo '<p>';
				
				//jp put back
				//echo '<a href="javascript:launchPDF(\''.$manifest_info[0]['slp_id'].'\',\''.$formatedPdfFileName.'\',\'download\');">';
				//echo '<a href="javascript:launchPDF(\''.$manifest_info[0]['slp_id'].'\',\''.'\',\'download\');">';
				echo '<a href="javascript:launchPDF(\''.$manifest_info[0]['slp_id'].'\',\''.$formatedPdfFileName.'\',\'download\');">';
				echo $manifest_info[0]['title_ent'];
				echo'</a> </p> <br clear=all>';
			}
		}
	
	}
	
?>
            

	<div style='display:none'>
		<div id='inline_credit' style='background:#fff;'></div>
		<div class="closeButton"><a id="page" href="#" onclick="javascript:parent.$.fn.colorbox.close();">Close</a></div>
	</div>
	<br clear="all"/>      

<?php
include($_SERVER['INCLUDE_HOME'].'/folder_footer.php');
?>
