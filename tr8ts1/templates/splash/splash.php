<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<title>Traitspace</title>
	<link href="/css/traitspace.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
		<link href="/css/traitspace.ie.css" rel="stylesheet" type="text/css" />
	<![endif]-->

</head>
<body>
<?php
require_once($_SERVER['PHP_INCLUDE_HOME'].'/tr8ts1/GI_FolderHandler.php');
$golla_href = GI_ProductConfig::getBaseHref('golla');
$go_href = GI_ProductConfig::getBaseHref('go');

$folder_handler =  new GI_FolderHandler();
$nav_array = $folder_handler->getGrades();
//print_r($nav_array);
//print "<pre>"; print_r($_REQUEST);print"</pre>";
//print "<pre>"; print_r($_SESSION);print"</pre>";
//print "<pre>"; print_r($_SERVER);print"</pre>";
?>



<div id="container">
    <div id="grade1">
<ul class="cssmenu">
		<li  class="grade_k"><a href="/folderPage/<?php echo $nav_array[0]['cid'];?>/" target="_self" alt="K"><span class="displace">K</a></span></li>
		<li class="grade_1"><a href="/folderPage/<?php echo $nav_array[1]['cid'];?>/" target="_self" alt="1" ><span class="displace">1</a></span></li>
		<li class="grade_2"><a href="/folderPage/<?php echo $nav_array[2]['cid'];?>/" target="_self" alt="2"><span class="displace">2</a></span></li>
		<li class="grade_3"><a href="/folderPage/<?php echo $nav_array[3]['cid'];?>/" target="_self" alt="3"><span class="displace">3</a></span></li>
		<li class="grade_4"><a href="/folderPage/<?php echo $nav_array[4]['cid'];?>/" target="_self" alt="4"><span class="displace">4</a></span></li>
		<li class="grade_5"><a href="/folderPage/<?php echo $nav_array[5]['cid'];?>/" target="_self" alt="5"><span class="displace">5</a></span></li>
		</ul>

		<ul class="cssmenu2">
		<li class="grade_6"><a href="/folderPage/<?php echo $nav_array[6]['cid'];?>/" target="_self"  alt="6"><span class="displace">6</a></span></li>
		<li class="grade_7"><a href="/folderPage/<?php echo $nav_array[7]['cid'];?>/" target="_self" alt="7" ><span class="displace">7</a></span></li>
		<li class="grade_8"><a href="/folderPage/<?php echo $nav_array[8]['cid'];?>/" target="_self" alt="8"><span class="displace">8</a></span></li>
		</ul>
	 </div> 
    
	<div id="footer-main">
    <div id="footer">
        <a href="<?php echo $golla_href."/sysreqs?support=N";?>" target="_blank" >Check System Requirements</a> 
        <div style="display:inline; margin-left: 55px; ">&#8482; &amp; &copy; <?php echo date('Y'); ?> Scholastic Inc.&nbsp;All rights reserved.</div>
    </div>   
    <div id="footer-center">
        <img src="images/logo.png" alt="Scholastic" width="337" height="22" hspace="0" align="left">                
    </div>
    
    <div id="footer-right">         	
        <a href="<?php echo $golla_href."/privacy";?>" target="_blank" >&nbsp; Privacy Policy</a>&nbsp; &nbsp;  &nbsp; &nbsp; <a href="<?php echo $golla_href."/terms";?>" target="_blank" >Terms of Use</a>
    </div>
	</div>
</div>
</body>
</html>

