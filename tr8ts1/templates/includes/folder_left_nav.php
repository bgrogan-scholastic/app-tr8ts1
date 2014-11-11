	<div id="menu-left">
	    <ul class="sectionmenu grade1">
<?php


//test this

//print '<pre>'; print_r($left_nav_array); print '</pre>';

//$left_nav_array - set in folder_header.php
$left_nav_array_count = count($left_nav_array);
for($i = 0; $i<$left_nav_array_count; $i++)
{
	
	if($left_nav_array[$i]['facet'] == $_SERVER['TRAITSPACE_FACET_ID']){
	
	$id = '_bottom';
	if($left_nav_array[$i]['cid'] == $FOLDER_ID)
	{
		$id = '_active';
	}
	$temp_code = $left_nav_array[$i]['template_code'];

	//print $temp_code;

	if($temp_code == "mentorVideos")
	{
		echo '<li class="sectionmenuline"><a id="sectionmenu'.$id.'" href="/'.$temp_code.'/'.$curr_grade[0]['cid'].'/'.$left_nav_array[$i]['cid'].'/0" target="_self"><span>'.$left_nav_array[$i]['node_title'].'</span></a></li>'."\n";
	}

	elseif($temp_code == "folderPage" && $left_nav_array[$i]['node_title']=='Argument Research Paper Module')
	{
		//print $temp_code;
		$temp_code = "folderPage";
		echo '<li class="sectionmenuline"><a id="sectionmenu'.$id.'" href="/'.$temp_code.'/'.$curr_grade[0]['cid'].'/'.$left_nav_array[$i]['cid'].'/" target="_self"><span>Arg. Research Module</span></a></li>'."\n";
	}

	elseif($temp_code == "folderPage" && $left_nav_array[$i]['node_title']=='Opinion Research Paper Module')
	{
		//print $temp_code;
		$temp_code = "folderPage";
		echo '<li class="sectionmenuline"><a id="sectionmenu'.$id.'" href="/'.$temp_code.'/'.$curr_grade[0]['cid'].'/'.$left_nav_array[$i]['cid'].'/" target="_self"><span>Opinion Research Module</span></a></li>'."\n";
	}

	elseif($temp_code == "pdLive")
	{
		echo '<li class="sectionmenuline"><a id="sectionmenu_top'.$id.'" href="/'.$temp_code.'/'.$curr_grade[0]['cid'].'/'.$left_nav_array[$i]['cid'].'/" target="_self"><span>'.$left_nav_array[$i]['node_title'].'</span></a></li>'."\n";
	}

	else
	{

		if($left_nav_array_count - 1 == $i )
		{
			if($id == '_active')
			{
				$id = '_bottom_active';
			}
			else
			{
				$id = '';
			}
		}
		
		echo '<li class="sectionmenuline"><a id="sectionmenu'.$id.'" href="/'.$temp_code.'/'.$curr_grade[0]['cid'].'/'.$left_nav_array[$i]['cid'].'/" target="_self"><span>'.$left_nav_array[$i]['node_title'].'</span></a></li>'."\n";
	}
}
}
?>
            </ul>
        </div>