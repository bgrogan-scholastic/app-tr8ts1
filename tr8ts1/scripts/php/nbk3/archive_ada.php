<?php
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
    } 

//$time_start = getmicrotime();
?>

<html>

	<head>	
	<title>The New Book of Knowledge</title>
	<link href="/css/int_ada.css" rel="stylesheet" type="text/css">
	<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
	<script language="javascript">

		<?php
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/querystring.js');

				/* all part of common.js */
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/cookies.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/setcurrentlocation.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/grabselection.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/browsercheck.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/toggle_php.js');
		?>
	</script>
	</head>

<body bgcolor="#ffff99">
<?php include($_SERVER['INCLUDE_HOME'] . '/php/searchform.php'); ?>

<?php

/* include common code */
require_once($_SERVER["SCRIPTS_HOME"] . "/nbk3/common/GI_DBList.php");
include_once( $_SERVER["INCLUDE_HOME"] . '/php/newsarchive_entry.php');

/*******************************************************************************
* List program definitions.  This area contains parameters for the list object
* The List program in this case will be used to generate 2 levels of nesting.
*
* Programming Differences Between C++ and PHP version of list
*    1) no need to specify 'fields' parameter, the query "subtemplate" is
*           specified as a subtemplate that can contain ##tags##, these tags
*           are parsed in the same way as a subtemplate, the list program knows
*           the order in which to populate the items.
*******************************************************************************/

/* this is a good example of a list that uses the default entry style text */
$list1config[1]['query'] = "select * from ngroup where n_group='##category##' order by n_group ASC";
$list1config[1]['entry'] = array('text', '<p class="ibrowse">##N_GDESC##</p>' . "\n");

/* level 1 parameters */
$list2config[1]['query'] = "select *, dayofmonth(a.ndate) myday, month(a.ndate) mymonth, year(a.ndate) myyear from nassets a, ntypes t, narchive s where a.id=s.n_artid and s.n_status='active' and a.type like '0tdn%' and a.type <> '0tdnr'  and a.type <> '0tdnh' and a.type <> '0tdno' and t.n_type=a.type and a.ngroup='##category##' order by a.ndate DESC";
$list2config[1]['entry'] = array('function:', displayArchiveRecord, '<p class="iarchivelist">##LESSONPLAN## <a class="iarchivelist" href="/cgi-bin/dated_article?templatename=/news/##NORIENT##.html&assetid=##ID##&assettype=##TYPE##">##TYPEDESC####TITLE##</a> <span class="iarchivedate">##ARCHIVEDATE##</span> ##READMORE## ##RELATEDSTORIES##</p>' . "\n");


/* keep some state information about the page */
global $previousSchoolYearBegin;
global $previousSchoolYearEnd;
global $currentSchoolYearBegin;
global $currentSchoolYearEnd;

/* keep a list of subcategory groups */
global $sGroups;
$sGroups = array();

?>

<!-- h3 Category Listing /h3 -->
	<table border="0" cellpadding="4" cellspacing="3" width="100%">		

	<tr><!--this row holds the table together by fixing the column widths-->	
	<td><img src="/images/common/spacer.gif" width="165" height="1" border="0"></td>			
	<td><img src="/images/common/spacer.gif" width="200" height="1" border="0"></td>		
	<td width="55%"></td>				
	<td><img src="/images/common/spacer.gif" width="170" height="1" border="0"></td>
<?php include($_SERVER['INCLUDE_HOME'] . '/html/top.php'); ?>	
		
	<tr><!--first column is navigation to NBK features, second column is the encyclopedia content, the third is available assets-->		
	<td valign="top">  
						<?php include($_SERVER['INCLUDE_HOME'] . '/php/sidebar-common.php'); ?>	
	</td>
		
	<td colspan="4" valign="top">				
	<h1 class="inewsarchive">NBK News Archive</h1>
	<?php $myList1 = new GI_DBList($list1config); $myList1->Output(); ?>
<hr></hr>
		<!-- news story listing by category -->
		<?php $myList2 = new GI_DBList($list2config); $myList2->Output(); ?>


</td></tr>
       
  <!-- footer.html:begin -->
<tr>
	<td colspan="4" class="icenter">
	<?php include($_SERVER['INCLUDE_HOME'] . '/php/footer.php'); ?><br><?php include($_SERVER['INCLUDE_HOME'] . '/php/copyright_black.html'); ?>
	</td>	
	</tr>
	
	<tr>
    <td colspan="4" class="icenter">    <br><?php include($_SERVER['INCLUDE_HOME'] . '/html/w3cfooter.html'); ?>

    </td>
	</tr>
				
			
</table>
</form>	


<?php
//$time_end = getmicrotime();
//print "<h1>Elapsed Time is: " . ($time_end - $time_start) . "</h1><br>";
?>

</body>
</html>

