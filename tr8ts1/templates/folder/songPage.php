<?php
include($_SERVER['INCLUDE_HOME'].'/folder_header.php');

?>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".audioPopup").colorbox({
				iframe:true, width:"800px", height:"85%"
				//onOpen:function(){ alert('onOpen: colorbox is about to open'); },
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
			
		});
	</script>
        <div id="content">              
<?php
	$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$productFacet);
	echo "<pre>";
	//print_r($children);
	echo "</pre>";
	echo "<H1>".$curr_folder[0]['node_title']."</H1>";
	displayCategorytBrowseLevel($FOLDER_ID);
	

	function displayCategorytBrowseLevel($id)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		global $GRADE_SHORT,$FOLDER_HANDLER;
		$children = $FOLDER_HANDLER->getNodeChildren($id,$productFacet);
		$children_count = count($children);
		for($i = 0; $i < $children_count; $i++)
		{		
			//CHECK TO SEE IF we are at a leaf. If so then don't display.
			if($children[$i]['node_type'] == 'T')
			{				
				$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
				$man_children = $FOLDER_HANDLER->getManifestSLPID($children[$i]['cid'],$productFacet);

				echo "<H2>".$man_children[0]['title_ent']."</H2>";
				//echo $man_children[0]['slp_id'] .' --> ' .$man_children[0]['title_ent'].".".$man_children[0]['fext'].' --> ' .$man_children[0]['type'].' --> ' .$man_children[0]['grades'].' --> ' .$man_children[0]['sort_order'].' --> ' .$man_children[0]['uid'];
				displayManifestLevel($man_children[0]['slp_id'],$GRADE_SHORT);
			}
		}			
	}
		
	function displayManifestLevel($id,$grade)
	{	
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		global $FOLDER_HANDLER;
		$children = $FOLDER_HANDLER->getManifestChildren($id,$grade,$productFacet);
		$children_count = count($children);
		$display_lyrics = true;
		$lyrics_html = '';
		$lyrics_slpid = '';
		$lyrics_title = '';
		$mp3_html = '<p>';
		
		for($i = 0; $i < $children_count; $i++)
		{		
			//displayManifestLevel($children[$i]['slp_id']);
			if($children[$i]['type'] == '0tam')
			{
				//$formatedPdfFileName = addslashes($children[0]['title_ascii']);
				$formatedPdfFileName = base64_encode($children[0]['title_ascii']);
//JP PUT BACK				$lyrics_html = "<p><a href=\"javascript:launchPDF('".$children[$i]['slp_id']."','".$children[$i]['title_ascii']."','download');\">";
//$lyrics_html = "<p><a href=\"javascript:launchPDF('".$children[$i]['slp_id']."','"."','download');\">";
				$lyrics_html = "<p><a href=\"javascript:launchPDF('".$children[$i]['slp_id']."','".$formatedPdfFileName."','download');\">";
				$lyrics_html .= 'Lyrics';
				$lyrics_html .= '</a></p>';			
				$lyrics_slpid = $children[$i]['slp_id'];
				$lyrics_title = $children[$i]['title_ascii'];				
			}
			else 
			{
				//Check to see if this is the first entry			
				if($mp3_html == '<p>')
				{
					$mp3_html .='<a class="audioPopup" href="/folder/popup_audio.php?mp3_filename='.$children[$i]['slp_id'].'&lyrics_pdf_slpid='.$lyrics_slpid.'&lyrics_pdf_title='.$lyrics_title.'&lyrics_slpid='.$id.'">'.$children[$i]['title_ent'].' </a>';
				}
				else 
				{
					$mp3_html .='&nbsp;&nbsp; | &nbsp;&nbsp;<a class="audioPopup" href="/folder/popup_audio.php?mp3_filename='.$children[$i]['slp_id'].'&lyrics_pdf_slpid='.$lyrics_slpid.'&lyrics_pdf_title='.$lyrics_title.'&lyrics_slpid='.$id.'">'.$children[$i]['title_ent'].'</a>';
				}
				
				$display_lyrics = false;
			}
		}

		$mp3_html .= '</p>';
		if($display_lyrics)
		{
			
			echo $lyrics_html;
		}
		else 
		{
			echo $mp3_html;
		}									
	}	
include($_SERVER['INCLUDE_HOME'].'/folder_footer.php');
?>