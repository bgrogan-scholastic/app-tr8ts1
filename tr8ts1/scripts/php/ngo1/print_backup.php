<?php 
/**
 * Print Article page is page called when print clicked from article page.
 * In Config file 
 * set Alias /print /data/ngo1/scripts/php/ngo1/print_article.php
 * 
 * Import Gi_Transtext File to get the article content.
 */
//echo $_SERVER['PHP_INCLUDE_HOME'];	

#error_reporting(E_ALL);
#ini_set('display_errors', 'on');

require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/article/GI_TransText.php');
/**
 * Import print_email.css to apply styles
 */
echo '<link href="/css/print_email.css" rel="stylesheet" type="text/css"/>';

include ($_SERVER ['INCLUDE_HOME'] . "/doctype.html");

require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Constants.php');
if(!isset($_GET['product_id']))
{
	if($_SERVER[GI_AUTH_PCODE] == 'eto' )
	{
		$_GET['product_id'] = 'eto';
	}
	elseif($_SERVER[GI_AUTH_PCODE] == 'xs')
	{
		$_GET['product_id'] = 'ngo';
	}
} 		 	
	
	
/**
 * get Id and product_id from page.
 */
$assetid = $_REQUEST['id'];
$csgtype = $_REQUEST['type'];
$ngoproductid = $_GET['product_id'];
$productid = $_GET['product_id'];
$ngogtype = $_REQUEST['type'];

//
if ($_REQUEST['product_id'])
	$productid  = $_REQUEST['product_id'];
else
	$productid  = "ngo";

/**
 * get content of article from GI_Transtext.
 */

$priAsset = new GI_TransText(array(
	CS_PRODUCTID => $productid,
	CS_GTYPE => $csgtype,
	NGO_PRODUCTID => $ngoproductid,
	NGO_GTYPE => $ngogtype,
	GI_ASSETID => $_REQUEST['id'],
	CS_FILENAME => $assetid.".html")
);

if(GI_Base::isError($priAsset)) 
{
	echo "error : ".$priAsset->getMessage();
	$outresult = $priAsset->getMessage();
	#$GLOBALS["errorManager"]->reportError($priAsset);
	#GLOBALS["fatalerror"]=TRUE;
} else {

	$outresult =  $priAsset->output();
	if(GI_Base::isError($outresult)) {
		$GLOBALS["errorManager"]->reportError($outresult);
		$GLOBALS["fatalerror"]=TRUE;
		$outresult = $_GI_Error->getMessage();
	}
}
$a = $outresult;


/**
 * Add check box for every header having toc tag set.
 * 
 */


$regex='#(<h\d[*]?.*?>)?\s*?<!--\s?toc:insert content="checkbox" id="(.+?)"/>\s?-->#';

$replace='</div><div class="hide" id="$2">$1<input type="checkbox" id="$2"/>';
$b = preg_replace($regex,$replace,$a);

/**
 * Strip off all anchors in article.
 */
$b = preg_replace("#(<[a|A].*?>)|(<[a|A].*\S\s?>)|(</[a|A]>)|(onClick=.*?\s*.\")#","",$b);

?>

<html>
<head>
<?php
include ($_SERVER ['INCLUDE_HOME'] . "metatag.html");
?>
<title>Print</title>
<script type="text/javascript" language="javascript"><?php include($_SERVER['JAVASCRIPT_INCLUDE_HOME']."/ngo1/jquery-1.2.1.min.js"); ?></script>
<script type="text/javascript" language="javascript"><?php include($_SERVER['JAVASCRIPT_INCLUDE_HOME']."/common/print_page.js"); ?></script>
<script type="text/javascript" language="javascript"><?php include($_SERVER['JAVASCRIPT_INCLUDE_HOME']."/ngo1/statcollector.js"); ?></script>
<script language="javascript">

//RECORD STAT HIT
collectStat('pfe','xs','print','');


$(document).ready(function(){
	/* Hide all dive with show as class. On clicking on check box class show is assigned.
	*/
	$(".show").hide();
	$("input[type&checkbox]").attr("checked",false);
	$("input[type@checkbox]").click(function(){
	//	alert($(this).attr("checked"));
		if($(this).attr("checked")){
			$(this).parents("div").attr('class','show');
		}
		else {
			$(this).parents("div").attr('class','hide');
		}
		/*if($(this).attr("checked","false")){
			$(this).parents("div").attr('class','hide');
		}
		*/
		
	});
	/* Click on preview button checks for all divs with class name Show and hides rest of divs. */
	$("#printpreview").click(function(){
		$(".hide").hide();
		$("input[type@checkbox]").hide();
		//$("table").hide();
		$(".show").show();
	});
	
	/* Click on print will print the page. */
	$("#print").click(function(){
		$(this).hide();
		$("#reset").hide();
		print_page();
		$("#reset").show();
		$("#reset").after("&nbsp&nbsp<a href=\"#\" onclick=\"javascript:window.close()\">close</a>");
	});
	
});
function pageload(){
	location.reload();
}

</script>
</head>
<body>
<form id="form1" action="" method="POST">


<?php 

preg_match('/<h1.*>/',$b,$matches);
//print_r($matches);
$title1 = $matches[0];

$title = preg_replace("#<[^<]+?>#","",$title1);

echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td><h1 class="idirections">Check and uncheck as needed to select sections to print:</h1>';

if($csgtype=="0ta"){
echo '<p>Citations will automatically be included with your content.</p>';
}

echo '<p class="iarttitle">Print section(s) of <b> '.$title.'</b></p></td></tr></table>';
//echo $title;

echo $b;
echo '</div>';
if($csgtype=="0ta"){
	echo "<b>How to cite this article:</b> <br><br>";
	require_once($_SERVER['PHP_INCLUDE_HOME'].'ngo1/CitationsEmail.php');
}//end if
?>

<br />
<br /><p>
<a href="#" id="printpreview" class="hide">Print Preview</a>
<a href="#" id="print" class="show">Print</a>&nbsp;&nbsp;
<a href="#" id="reset" onclick="pageload()">Reset</a>
</p>
</form>
</body>
</html>
