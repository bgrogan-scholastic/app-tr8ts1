<?php
##################################################################################################
# Filename: topstories.php
#
# Date: 1/18/05
#
# Author: Tyrone Mitchell
###################################################################################################

@include_once("dbConnect.php");
@include_once("functions.php");
$dbh = dbConnect("nbk3");
$main_query = "select * from narchive r, nassets a where r.usedingo='yes' and r.topstory is not NULL and r.topstory<>0 and a.type like '0tdn%' and r.n_artid=a.id order by r.topstory asc";

//grab URL parameters and POST Variables
$id = $_GET["id"];
$action = $_GET["action"];

$reindex = $_POST['reindex'];
$sendemail = $_POST['sendtsemail'];

if (isset($sendemail)) {
	//Formulate email to be sent.

	$hn = $_SERVER["SERVER_NAME"]; #get the current hostname
	$hostname = explode(".", $hn); #break the <hostname>.grolier.com up by "."
	$thishost = $hostname[0];  #Get just the machine name: linuxdev/linuxstage
	$output = "";
	// recipients, comma seperated without spaces
	$to  = "tmitchell@scholastic.com,treisel@scholastic.com";
	$subject = "NBK3/GO2 Top Story email (email from $thishost)";
	$results = mysql_query($main_query);
	$msg = "sgmlid|id|type|title|ngroup|n_status|usedingo|topstory\n";

	while ($aRow = mysql_fetch_array($results)) {
		//set up the array
		$msg .= $aRow['sgmlid'] . "|" . $aRow['id'] . "|" . $aRow['type'] . "|" .  $aRow['title'] . "|" .  $aRow['ngroup'] . "|" .  $aRow['n_status'] . "|" .  $aRow['usedingo'] . "|" .  $aRow['topstory'] . "\n";
	}
	$msg .= "\n---end---\n\nThis message was automated. Please do not reply to this message.[topstories.php]\n";
	$commandline = "/data/nbk3/scripts/python/nbk3/sendmail.py tmitchell@scholastic.com $to \"$subject\" \"$msg\"";
	#echo $msg;
	exec($commandline, $output, $status);
	echo "Email sent. Result: $status<br>";
}

if (isset($reindex)) {
	#print "Reindexing...<br>";
	foreach ($_POST as $id => $index) {
		#print $id . " ". $index ."<br>";
		if ($id != "reindex") {
			$updatequery = "update narchive set topstory=$index where n_artid='$id'";
			#print $updatequery . "<br>";
			$results = mysql_query($updatequery);
		}
	}
}

$query = "";


$results = mysql_query($main_query);
$count = mysql_num_rows($results);
$c = $count + 1;

//if we're performing an addition or deletion, use a special query
if (isset($id) and isset($action)) {
	if ($action == "del") {
		if ($id == "all") {
			$query = "update narchive set topstory=NULL";
		}
		else {
			$query = "update narchive set topstory=NULL where n_artid='$id'";
		}
	}
	if ($action == "add") {
		$query = "update narchive set topstory=$c where n_artid='$id' and topstory is NULL or topstory=0";
	}
	/* print "Query: $query <br>"; */
	mysql_query($query);
}

/* re-execute sql query in order to get all the updated changes.*/
$results = mysql_query($main_query);
$count = mysql_num_rows($results);


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

	//set up the array
	$aaNassets[] = array(sgmlid => $aRow['sgmlid'], id => $aRow['id'], type => $aRow['type'], title => $aRow['title'], ngroup => $aRow['ngroup'], status => $aRow['n_status'], usedingo => $aRow['usedingo'], topstory => $aRow['topstory']);
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

<style>
body {
 background: #ccccff;
}
</style>
<!-- refresh the top window from here, but only if it's the display page. I actually
had the update.php page refreshing, then in turn, refreshing this page, so on and so forth,
and I ended up with 60+ emails in my inbox. Little infinite loop.  -->
<script language="javascript">
url = top.newscontrol.document.location.href;
idx = url.indexOf("display.php");
if (idx != -1) {
	top.newscontrol.document.location = top.newscontrol.document.location;
}
</script>
<body>
<h3>Top Stories in GO2 Kids news</h3>
<a href="topstories.php">Refresh this page</a><br>
<?php 
if ($count > 0) {
	echo "There are $count Top Stories marked<br>";
}
else {
	echo "There are no news stories marked that have been marked as \"Top Stories\".<br>";
	exit;
}
?>
<form name="topstories" action="topstories.php" method="post">
<input type="hidden" name="reindex" value="true">
<table border="0" width="100%" summary="GO2 Top Stories" cellpadding="2" cellspacing="0">
<tr><th>SGML ID</th><th>Online ID<br><!-- (click to see related assets) --></th><th>Title<br>(click to see story in new window)</th>
<th class="alltop">Remove Top Story</th><th class="alltop" id="frameright">Top Story Priority</th></tr>
<?php

for ($i=0; $i < $count; $i++) {
	//get the row style. I alternate styles to enhance readability.
	$class = returnStyleForGO($i);

	//display the class
	echo "<tr $class>\n";

	//display the SGML id if there is one
	echo "<td>" . $aaNassets[$i]['sgmlid'] . "</td>";

	//get the id; I'll use this in creating the link to the story
	$thisid = $aaNassets[$i]['id'];
	//echo "\n<td><a href=\"javascript:OpenBoxWindow('related.php?newsid=$thisid', 700, 600, 'news2', 'yes')\">" . $aaNassets[$i]['id'] . "</a></td>";
	echo "\n<td>" . $aaNassets[$i]['id'] . "</a></td>";
	//echo "<td>" . $aaNassets[$i]['type'] . "</td>";
	//echo "<td>" . $aaNassets[$i]['title'] . "</td>";
	echo "\n<td>" . "<a href=\"/cgi-bin/dated_article?templatename=/news/standard.html&assetid=$thisid&assettype=". $aaNassets[$i]['type'] ."\" target=\"_blank\">" . $aaNassets[$i]['title'] . "</a></td>";
	//echo "<td>" . $aaNassets[$i]['ngroup'] . "</td>";

	//I have the ArchivedOrInactive function simply echo an empty string or "checked" based on the status of the current id and its preferred statys.
	//echo "\n<td><input type=\"radio\" name=\"$thisid\" value=\"active\"" . ArchivedOrInactive($aaNassets[$i]['status'], "active")  . ">Active <br> <input type=\"radio\" name=\"$thisid\" value=\"inactive\"" . ArchivedOrInactive($aaNassets[$i]['status'], "inactive")  . ">Inactive</td>";
	//echo "\n<td id=\"frameleft\" valign=\"top\"><input type=\"radio\" name=\"usedingo-$thisid\" value=\"yes\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "yes")  . ">Yes <br> <input type=\"radio\" name=\"usedingo-$thisid\" value=\"no\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "no")  . ">No</td>";
	#echo "\n<td>" . $aaNassets[$i]['topstory'] . "</td>";
	$action = "del";
	$actionname = "Remove";

	if ($aaNassets[$i]['topstory'] == "") {
		$action = "add";
		$actionname = "Add";
	}
	echo "\n<td id=\"frameleft\" align=\"center\"><a href=\"topstories.php?id=" . $aaNassets[$i]['id'] . "&action=$action\" target=\"topstories\">$actionname</a>&nbsp;</td>";
	echo "\n<td id=\"frameright\" align=\"center\"><input type=\"text\" name=\"" . $aaNassets[$i]['id'] ."\" size=\"2\" maxlength=\"3\" value=\"" . $aaNassets[$i]['topstory']. "\"></td>";
	echo "\n</tr>\n\n";
}

?>
</table>


<p align="center"><input type="submit" value="Re-sort news stories by priority"></p>
</form>

<table border="0" width="100%" cellspacing="10" cellpadding="10">
<tr>
<td valign="top">
<form name="topstoryemail" action="topstories.php" method="POST">
<input type="hidden" name="sendtsemail" value="true">
    <!-- input type="submit" value="Send Email" -->&nbsp;
</form>
</td>
<td valign="top">
<a href="topstories.php?id=all&action=del">Remove all "Top story" flags</a>
</td>
<td valign="top">
<input type="button" value="Print This Page" onClick="javascript:window.print();">
</td>
<tr>
</table>

</body>
</html>