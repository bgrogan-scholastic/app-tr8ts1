<?php
include($_SERVER['INCLUDE_HOME'].'/folder_header.php');
?>
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

	$featurecode=$_SERVER['TRAITSPACE_FACET_ID'];
	$first_node = true;
	$children = $FOLDER_HANDLER->getNodeChildren($FOLDER_ID,$featurecode);
	//echo "<pre>";
	// print_r($children); 
	//echo "</pre>";
	echo "<H1>".$curr_folder[0]['node_title']."</H1>";
	//print_r($_REQUEST['grade_id']);
	//print $FOLDER_ID;

	if (
			($_REQUEST['grade_id'] ='node-33291' && $FOLDER_ID=='node-35138')
			||
			($_REQUEST['grade_id'] ='node-33382' && $FOLDER_ID=='node-35141')
			||
			($_REQUEST['grade_id'] ='node-33473' && $FOLDER_ID=='node-35144')
		)
		{

		print '<h2 class="soon">Coming Soon!</h2>';

	} else {

		displayCategorytBrowseLevel($FOLDER_ID);
	}


	function displayCategorytBrowseLevel($id)
	{
		global $FOLDER_HANDLER,$first_node;
		$featurecode=$_SERVER['TRAITSPACE_FACET_ID'];
		$children = $FOLDER_HANDLER->getNodeChildren($id,$featurecode);
		//print '<pre>'; 
		//print_r($children);
		// print '</pre>';
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
					echo "<H2>".$children[$i]['node_title']."</H2>";
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
					echo "<br>";
				}
			}
			displayCategorytBrowseLevel($children[$i]['cid']);
		}

		if($children_count == 0)
		{
			$featurecode=$_SERVER['TRAITSPACE_FACET_ID'];
			$children = $FOLDER_HANDLER->getManifestSLPID($id,$featurecode);
			$children_count = count($children);
			if($children_count > 0)
			{

			/*
			BRYAN SHELLEY
			strip white space and replace with hyphen so we can pass title of media asset instead of slip
			*/

			//$searchArray= array("/\s+/", "/\'/");
			//print $formatedPdfFileName = preg_replace($searchArray, "-" , $children[0]['title_ent']);
			//print $formatedPdfFileName = preg_replace('/[^a-zA-Z0-9\s]/', '-', $children[0]['title_ent']);
			//print $formatedPdfFileName = preg_replace('~[\W\s]~', '-', $children[0]['title_ent']);

			$formatedPdfFileName = addslashes($children[0]['title']);
			$formatedPdfFileName = base64_encode($children[0]['title']);
			//print $formatedPdfFileName;

			echo '<p>';
			echo "<a href=\"javascript:launchPDF('".$children[0]['slp_id']."','".$formatedPdfFileName."','download');\">";

			//echo '<a href="javascript:launchPDF(\''.$children[0]['slp_id'].'\',\''.$children[0]['title_ent'].'\',\'download\');">';
			//echo '<a href="javascript:launchPDF(\''.$children[0]['slp_id'].'\',\''.$formatedPdfFileName.'\',\'download\');">';
			//echo '<a href="javascript:launchPDF(\''.$children[0]['slp_id'].'\',\''.'\',\'download\');">';
			echo $children[0]['title_ent'];

			echo'</a> </p>';
				displayManifestLevel($children[0]['slp_id']);
			}
			else
			{
				echo "<b>No Manifest Row</b><br>";
			}
		}

	}

	function displayManifestLevel($id)
	{
		$featurecode=$_SERVER['TRAITSPACE_FACET_ID'];
		global $FOLDER_HANDLER;
		$children = $FOLDER_HANDLER->getManifestChildren($id,null,$featurecode);
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