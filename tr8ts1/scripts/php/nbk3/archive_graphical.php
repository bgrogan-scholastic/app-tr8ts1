<?php
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
    } 

//$time_start = getmicrotime();
?>

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

/* level 1 parameters */
$list2config[1]['query'] = "select *, dayofmonth(a.ndate) myday, month(a.ndate) mymonth, year(a.ndate) myyear from nassets a, ntypes t, narchive s where a.id=s.n_artid and s.n_status='active' and a.type like '0tdn%' and a.type <> '0tdnr' and a.type <> '0tdnh' and a.type <> '0tdno' and t.n_type=a.type and a.ngroup='##category##' order by a.ndate DESC";
$list2config[1]['entry'] = array('function:' , displayArchiveRecord, '<p class="iarchivelist">##LESSONPLAN## <a href="/cgi-bin/dated_article?templatename=/news/##NORIENT##.html&assetid=##ID##&assettype=##TYPE##">##TYPEDESC####TITLE##</a> <span class="iarchivedate">##ARCHIVEDATE##</span> ##READMORE## ##RELATEDSTORIES##</p>' . "\n");


/* keep some state information about the page */
global $previousSchoolYearBegin;
global $previousSchoolYearEnd;
global $currentSchoolYearBegin;
global $currentSchoolYearEnd;

/* keep a list of subcategory groups */
global $sGroups;
$sGroups = array();

?>

<html>
<head>
			<link href="/css/int.css" rel="stylesheet" type="text/css">
			<title>The New Book Of Knowledge Online&#153;</title>

<script language="javascript">

			<?php
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/querystring.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/popup.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/rollovers/imagepaths.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/rollovers/imagenames_home.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/rollovers/imagenames_encycarticle.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/rollovers.js');

				/* all part of common.js */
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/cookies.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/setcurrentlocation.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/grabselection.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/sniffer.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/browsercheck.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/openspotlight.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/toggle_php.js');
				include($_SERVER['INCLUDE_HOME'] . '/javascript/common/goframeup.php');
			?>
</script>

</head>

<body class="inews" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td colspan="2" valign="bottom">
				<?php include($_SERVER['INCLUDE_HOME'] . '/html/top.php'); ?>
			</td>
		</tr>
		<tr valign="top">
			<td width="172" align="center" valign="top" bgcolor="#3300ff">
				<?php include($_SERVER['INCLUDE_HOME'] . '/html/sidebar-common.html'); ?>
			</td>
			<td valign="top" align="left" width="85%">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" valign="top">
					<tr>
						<td width="10" valign="top"><img src="/images/common/spacer.gif" width="10" height="20" border="0"></td>
						<td align="left" valign="top"><img height="30" width="160" src="/images/news/nbknews_archive.gif"></td>
					</tr>
					<tr>
						<td width="10" valign="top"><img src="/images/common/spacer.gif" width="10" height="55" border="0"></td>
						<td align="left" valign="top">
							<h2><img height="40" width="363" src="/images/news/archive_<?php echo $_GET['category'];?>-header.gif"></h2>

<?php $myList2 = new GI_DBList($list2config); $myList2->Output(); ?>
							
							
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="172"><img src="/images/common/spacer.gif" width="172" height="1"></td>
			<td width="85%"><img src="/images/common/spacer.gif" width="498" height="1"></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr height="20">
						<td height="20"><img height="20" width="10" src="/images/common/spacer.gif"></td>
					</tr>
					<tr height="15">
						<td height="15">
							<center>
								<?php include($_SERVER['INCLUDE_HOME'] . '/html/footer.html');?> </center>
							<p><br>
						</td>
					</tr>
					<tr height="15">
						<td height="15">
							<?php include($_SERVER['INCLUDE_HOME'] . '/html/copyright_black_php.html'); ?>
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php
//$time_end = getmicrotime();
//print "<h1>Elapsed Time is: " . ($time_end - $time_start) . "</h1><br>";
?>
</body>

