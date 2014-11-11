<?php
##################################################################################################
# Filename: related.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
# 
# This does very similar functionality to the display.php file. THe difference is in types and how you update.
# 
###################################################################################################

@include_once("dbConnect.php");
@include_once("functions.php");

$dbh = dbConnect("nbk3");

$newsid = $_GET["newsid"];
#$thisweek = $_GET["thisweek"];
$numresults = -1;

if (isset($newsid)) {
	$query = "select * from nassets a, nrelations r, narchive v where  n_pid='$newsid' and a.id=r.n_cid and v.n_artid=a.id order by a.type asc, r.n_priority asc, a.title asc ";

	$results = mysql_query($query);
	$numresults = mysql_num_rows($results);
	
	$aaNassets = array ();

	while ($aRow = mysql_fetch_array($results)) {
	  $aaNassets[] = array(sgmlid => $aRow['sgmlid'], id => $aRow['id'], type => $aRow['type'], title => $aRow['title'], ngroup => $aRow['ngroup'], status => $aRow['n_status'], usedingo => $aRow['usedingo'], topstory => $aRow['topstory']);
	}
}

?>

<html>
<head>
<title>Related Assets</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css">
</head>

<style>
#frameleft {
border-left: purple solid 2px;
}

#frameright {
border-right: purple solid 2px;
}

.alltop {
color: white;
background: purple;
}

.warning {
	color: red;
	font-weight: 900;
}

.row1 {
 background: #99CCFF;
}

.row2 {
 background: #ffffff;
}
</style>

<body>
<?php 
if ($numresults >= 0) {
	echo "I found $numresults related assets for the story associated with id $newsid.<br>"; 
	
	?>
<form name="updaterelated" method="post" action="update.php">
<input type="hidden" name="onlyrelated" value="true">
<table border="0" width="100%" summary="News Assets for One week" cellpadding="2" cellspacing="0">
<tr><th>SGML ID</th><th>Online ID</th><th>Type</th><th>Title</th><th>NGROUP</th><th>Archive Status</th><th class="alltop" id="frameleft">Used in GO?</th><th class="alltop" id="frameleft">Top Story?</th></tr>
<?php
	 
	 for ($i=0; $i < $numresults; $i++) {
		 $class = returnStyle($i);
		 echo "<tr $class>\n";
		 echo "\n<td>" . $aaNassets[$i]['sgmlid'] . "</td>";
		 $thisid = $aaNassets[$i]['id'];
		 echo "\n<td>" . $aaNassets[$i]['id'] . "</td>";
		 echo "\n<td>" . $aaNassets[$i]['type'] . "</td>";		

		 echo "\n<td>";
		 if ($aaNassets[$i]['type'] == '0mp') {
			 echo "<a href=\"/cgi-bin/media?assetid=" . $aaNassets[$i]['id'] . "&assettype=" . $aaNassets[$i]['type'] . "0mp&templatename=/news/media_back.html\">";
		 }
		 echo $aaNassets[$i]['title'];
		 if ($aaNassets[$i]['type'] == '0mp') {
			 echo "</a>";
		 }		 
		 echo "</td>";

		 echo "\n<td>" . $aaNassets[$i]['ngroup'] . "</td>";
		 echo "\n<td><input type=\"radio\" name=\"$thisid\" value=\"active\"" . ArchivedOrInactive($aaNassets[$i]['status'], "active")  . ">Active <br> <input type=\"radio\" name=\"$thisid\" value=\"inactive\"" . ArchivedOrInactive($aaNassets[$i]['status'], "inactive")  . ">Inactive</td>";
		 echo "\n<td valign=\"top\"><input type=\"radio\" name=\"usedingo-$thisid\" value=\"yes\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "yes")  . ">Yes <br> <input type=\"radio\" name=\"usedingo-$thisid\" value=\"no\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "no")  . ">No</td>";
		 echo "\n<td>" . $aaNassets[$i]['topstory'] . "</td>";
		 echo "\n</tr>\n\n";
	 }

?>
<td colspan="8">
<input type="submit" value="Update These Related Assets">
</td>
</table>
</form>
<p align="center"><a href="javascript:window.close()">Close This Window</a></p>
<?php

}
else {
	echo "";
}

?>
</body>
</html>