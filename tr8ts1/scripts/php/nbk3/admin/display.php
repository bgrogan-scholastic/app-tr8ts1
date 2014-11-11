<?php
##################################################################################################
# Filename: display.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
###################################################################################################

@include_once("dbConnect.php");
@include_once("functions.php");
$dbh = dbConnect("nbk3");

//grab URL parameters and POST Variables
$thisweek = $_GET["week"];
$category = $_GET["category"];
$searchterms = $_POST["searchterms"];

//This is used when I run my news query.
$numresults = -1;

$query = "";

//if we're performing a title search, use a special query
if (isset($searchterms)) {
	//$query = "SELECT id, title, MATCH (title) AGAINST ('$searchterms') as score FROM nassets where match(title) against ('$searchterms') > 0 order by match(title) against ('$searchterms') desc";
	$query = "SELECT *, MATCH (title) AGAINST ('$searchterms') as score FROM nassets where match(title) against ('$searchterms') > 0 and type like '0tdn%' order by match(title) against ('$searchterms') desc";
}

//if we are looking for main articles for a particular week, use this query.
if (isset($thisweek)) {
	$query = "select * from nassets, narchive where ndate='$thisweek' and type like '0tdn%' and id = n_artid ";
	
	//and if we're looking for an individual category, add this in as well
	if (isset($category)) {
		$query .= " and ngroup='$category' ";
		
	}

	//finish off the query
	$query .="order by id asc, title asc";
}


//This will be shown when we first view the news page.
if ($query == "") {
	echo "No results just yet. Perform a date, category, or title search.<br>";
	exit;
}
//echo $query . "<br>";

$results = mysql_query($query);
$numresults = mysql_num_rows($results);

if ($numresults == 0) {
	echo "There are no news stories that match your query on '$searchterms'. Please modify your search and try again.<br>";
	exit;
}

//This double nested array is just bieng set up.
$aaNassets = array ();

while ($aRow = mysql_fetch_array($results)) {

	if (isset($searchterms)) {
		//when we do a search, we don't get the narchive status like when we perform any other query.
		//I'll pop that in here, but first I must retrieve it.
		$uquery = "select n_status from narchive where n_artid = '" . $aRow['id'] . "'";
		//print $uquery;
		$uresult = mysql_query($uquery);
		$auRow = mysql_fetch_array($uresult);
		$aRow['n_status'] = $auRow['n_status'];
	}
	
	$num_images_query = "select * from nassets a, nrelations r, narchive v where  n_pid='" . $aRow['id'] . "' and a.id=r.n_cid and v.n_artid=a.id and type='0mp'";
	$nresults = mysql_query($num_images_query);
	$num_pics = mysql_num_rows($nresults);

	$num_usedingo_images_query = "select * from nassets a, nrelations r, narchive v where n_pid='" . $aRow['id'] . "' and a.id=r.n_cid and v.n_artid=a.id and type='0mp' and usedingo='yes'";
	$uresults = mysql_query($num_usedingo_images_query);
	$usedingo_pics = mysql_num_rows($uresults);
															 
	//set up the array
	$aaNassets[] = array(sgmlid => $aRow['sgmlid'], id => $aRow['id'], type => $aRow['type'], title => $aRow['title'], ngroup => $aRow['ngroup'], status => $aRow['n_status'], usedingo => $aRow['usedingo'], topstory => $aRow['topstory'], ndate => $aRow['ndate'], num_pics => $num_pics, num_pics_used_in_go => $usedingo_pics);
}


?>

<html>
<head>
<title>News Administration</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css" />
<script language="javascript">
/* This window doesn't have location or menu bars */
function OpenBoxWindow(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
	
	if ((inResize == "on") || (inResize == "yes"))
	  gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=no,resizable=yes")
	else
	  gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",status=yes,scrollbars=yes,menubar=no")
	gBlurbWindow.opener = window
	gBlurbWindow.focus();
}
</script>
</head>
<body>
<?php 
if ($numresults >= 0) {
	echo "I found $numresults main stories for this week's news<br>"; 
}
?>

<form name="updatenews" method="post" action="update.php">
<table border="0" width="100%" summary="News Assets for One week" cellpadding="2" cellspacing="0">
<tr><th>SGML ID</th><th>Delete</th><th>Online ID<br>(click to see related assets)</th>

<th>Type</th><th># of related pictures <br>/ # of pictures marked used in go </th>

<th>Title<br>(click to see story in new window)</th><th>NGROUP</th><th>Archive Status</th><th class="alltop" id="frameleft">Used in GO?</th><th class="alltop" id="frameright">Top Stories for GO Kids News</th></tr>
<?php
	 
	 for ($i=0; $i < $numresults; $i++) {
		 //get the row style. I alternate styles to enhance readability.
		 $class = returnStyle($i);
		 
		 //display the class
		 echo "<tr $class>\n";
		 
// 		 echo "<pre>";
// 		 print_r($aaNassets);
// 		 echo "</pre>";

		 //display the SGML id if there is one
		 echo "<td>" . $aaNassets[$i]['sgmlid'] . "</td>";
		 echo "<td align=\"center\"><a href=\"javascript:OpenBoxWindow('delete.php?id=" . $aaNassets[$i]['id'] . "&ndate=" . $aaNassets[$i]['ndate'] . "', 700, 600, 'delete', 'yes');\">Delete</td>";
		 //get the id; I'll use this in creating the link to the story
		 $thisid = $aaNassets[$i]['id'];
		 echo "\n<td align=\"center\"><a href=\"javascript:OpenBoxWindow('related.php?newsid=$thisid', 700, 600, 'news2', 'yes')\">" . $aaNassets[$i]['id'] . "</a></td>";
		 echo "<td>" . $aaNassets[$i]['type'] . "</td>";		
		 echo "<td align=\"center\">" . $aaNassets[$i]['num_pics'] ."/" . $aaNassets[$i]['num_pics_used_in_go'] . "</td>";		
		 echo "\n<td>" . "<a href=\"/cgi-bin/dated_article?templatename=/news/standard.html&assetid=$thisid&assettype=". $aaNassets[$i]['type'] ."\" target=\"_blank\">" . $aaNassets[$i]['title'] . "</a></td>";
		 echo "<td>" . $aaNassets[$i]['ngroup'] . "</td>";

		 //I have the ArchivedOrInactive function simply echo an empty string or "checked" based on the status of the current id and its preferred statys.
		 echo "\n<td><input type=\"radio\" name=\"$thisid\" value=\"active\"" . ArchivedOrInactive($aaNassets[$i]['status'], "active")  . ">Active <br> <input type=\"radio\" name=\"$thisid\" value=\"inactive\"" . ArchivedOrInactive($aaNassets[$i]['status'], "inactive")  . ">Inactive</td>";
		 echo "\n<td id=\"frameleft\" valign=\"top\"><input type=\"radio\" name=\"usedingo-$thisid\" value=\"yes\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "yes")  . ">Yes <br> <input type=\"radio\" name=\"usedingo-$thisid\" value=\"no\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "no")  . ">No</td>";
		 
		 $action = "del";
		 $actionname = "Remove";

		 if ($aaNassets[$i]['topstory'] == "") {
		   $action = "add";
		   $actionname = "Add";
		 }
		 echo "\n<td align=\"center\" id=\"frameright\"><a href=\"/newsadmin/topstories.php?id=" . $aaNassets[$i]['id'] . "&action=$action\" target=\"topstories\">$actionname</a></td>";
		 echo "\n</tr>\n\n";
	 }

?>
<tr>
<td colspan="8" align="center">
	<table border="0">
		<td align="center">
			<input type="submit" value="Update This Week's News"></form>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">
			<form name="seechangelog" action="update.php" method="post">
			<input type="hidden" name="seelog" value="true">
			<input type="submit" value="View the Changelog">
			</form>
		<td>
	</table>
</td>
</tr>
</table>
</p>


</body>
</html>