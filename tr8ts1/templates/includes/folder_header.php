<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Traitspace</title>
<?php
require_once($_SERVER['INCLUDE_HOME'].'/js_include.php');

//print $_SERVER['INCLUDE_HOME'];

//CONSTANTS
$GRADE_ID;
$FOLDER_ID;
$FOLDER_HANDLER;
$GRADE_SHORT;

//SETUP CONSTANTS
$remove_chars = array("/");
$GRADE_ID = str_replace($remove_chars, "", $_REQUEST['grade_id']);;
$FOLDER_ID = str_replace($remove_chars, "", $_REQUEST['folder_id']);;

require_once($_SERVER['PHP_INCLUDE_HOME'].'/tr8ts1/GI_FolderHandler.php');
$FOLDER_HANDLER =  new GI_FolderHandler();

$featurecode=$_SERVER['TRAITSPACE_FACET_ID'];
//$featurecode='tr8ts_cc';
//print ' TRAITSPACE_FACET_ID: '.$_SERVER['TRAITSPACE_FACET_ID'];



$nav_array = $FOLDER_HANDLER->getGrades($featurecode);
//print_r($nav_array);


if(empty($GRADE_ID))
{
	$GRADE_ID = $nav_array[0]['cid'];
}
$grade_count = count($nav_array);
for($i = 0; $i < $grade_count; $i++)
{
	if($GRADE_ID == $nav_array[$i][cid])
	{
		$GRADE_SHORT = $nav_array[$i]['grade_short_title'];		
	}	
}

$curr_grade = $FOLDER_HANDLER->getNode($GRADE_ID,$featurecode);
$left_nav_array = $FOLDER_HANDLER->getFolders($GRADE_ID,$featurecode);
//print_r($left_nav_array);

if(empty($FOLDER_ID))
{
	$FOLDER_ID = $left_nav_array[0]['cid'];
}
$curr_folder = $FOLDER_HANDLER->getNode($FOLDER_ID,$featurecode);
$css_filename = '';
switch ($curr_grade[0]['node_title']) 
{
    case 'Kindergarten':
        $css_filename = 'kindergarten.css';
        break;
    case 'Grade 1':
        $css_filename = 'gradeone.css';
        break;
    case 'Grade 2':
        $css_filename = 'gradetwo.css';
        break;
    case 'Grade 3':
        $css_filename = 'gradethree.css';
        break;
    case 'Grade 4':
        $css_filename = 'gradefour.css';
        break;
    case 'Grade 5':
        $css_filename = 'gradefive.css';
        break;             
    case 'Grade 6':
        $css_filename = 'gradesix.css';
        break;             
    case 'Grade 7':
        $css_filename = 'gradeseven.css';
        break;                            
    case 'Grade 8':
        $css_filename = 'gradeeight.css';
        break;         
	default:                   
	
}
?>
	

	<link href="/css/<?php echo $css_filename; ?>" rel="stylesheet" type="text/css" />
	<link href="/css/global.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
		<link href="/css/global_ie.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	
	<link media="screen" rel="stylesheet" href="/css/colorbox.css" />
	<script src="/javascript/tr8ts1/colorbox/jquery.min.js"></script>
	<script src="/javascript/tr8ts1/colorbox/jquery.colorbox.js"></script>	
	
</head>
<body>
<?php
//echo $GRADE_ID . " -- " . $FOLDER_ID;
?>

<div id="container">
	<div id="leftimage">
    	<a href="/" target="_self"><img src="/images/home.png" alt="Trait Space Home" width="335" height="62" hspace="0" vspace="0" border="0" align="left"></a>
    </div>
    
     
   	<div id="navigation">  
   	
            <ul class="cssmenu">
                <li class="grade_k"><a href="/folderPage/<?php echo $nav_array[0]['cid'];?>/" target="_self" alt="K"><span class="displace">K</span></a></li>
                <li class="grade_1"><a href="/folderPage/<?php echo $nav_array[1]['cid'];?>/" target="_self" alt="1"><span class="displace">1</span></a></li>
                <li class="grade_2"><a href="/folderPage/<?php echo $nav_array[2]['cid'];?>/" target="_self" alt="2"><span class="displace">2</span></a></li>
                <li class="grade_3"><a href="/folderPage/<?php echo $nav_array[3]['cid'];?>/" target="_self" alt="3"><span class="displace">3</span></a></li>
                <li class="grade_4"><a href="/folderPage/<?php echo $nav_array[4]['cid'];?>/" target="_self" alt="4"><span class="displace">4</span></a></li>
                <li class="grade_5"><a href="/folderPage/<?php echo $nav_array[5]['cid'];?>/" target="_self" alt="5"><span class="displace">5</span></a></li>
				<li class="grade_6"><a href="/folderPage/<?php echo $nav_array[6]['cid'];?>/" target="_self" alt="6"><span class="displace">6</span></a></li>
                <li class="grade_7"><a href="/folderPage/<?php echo $nav_array[7]['cid'];?>/" target="_self" alt="7"><span class="displace">7</span></a></li>
                <li class="grade_8"><a href="/folderPage/<?php echo $nav_array[8]['cid'];?>/" target="_self" alt="8"><span class="displace">8</span></a></li>

	    </ul>
	</div>
<?php
include($_SERVER['INCLUDE_HOME'].'/folder_left_nav.php');
?>