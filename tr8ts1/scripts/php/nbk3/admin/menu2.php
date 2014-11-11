<?php
##################################################################################################
# Filename: menu2.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
# 
# In this file, I display the date driver portion of the page. The only difference in views is whether a 
# category is involved or not.
###################################################################################################

@include_once("dbConnect.php");

$dbh = dbConnect("nbk3");

#get the proper information.
$begindate = $_GET["begindate"];
$enddate =  $_GET["enddate"];
$category = $_GET["category"];

$searchtype = "";

$numresults = -1;

#Date range query
if (isset($begindate) and isset($enddate)) {
	$searchtype = "date";
	$query = "select distinct ndate from nassets where ndate between '$begindate' and '$enddate' and type like '0tdn%' order by ndate asc";
}

#Category only query
if (isset($category)) {
	$searchtype = "category";
	$query = "select distinct ndate from nassets where ngroup='$category' and type like '0tdn%' order by ndate desc";
}


if ($searchtype != "") {
	$results = mysql_query($query);
	$numresults = mysql_num_rows($results);
}

?>

<html>
<head>
<title>News Administration</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css">
<base target="newscontrol">
</head>

<body>


<?php 

if ($numresults > 0 && $searchtype=="date") {
	echo "<br>Choose a week's news to view.<br/>";
  echo "<br>News weeks between $begindate and $enddate:<br>";
  while ($aRow = mysql_fetch_array($results)) {
		$week = $aRow['ndate'];
		echo "<br><a href=\"display.php?week=$week\">" . $week . "</a>";
	}
}

else if ($numresults > 0 && $searchtype=="category") {
	echo "<br>Choose a week's news to view that contains the category $category.<br>";
  while ($aRow = mysql_fetch_array($results)) {
		$week = $aRow['ndate'];
		echo "<br><a href=\"display.php?week=$week&category=$category\">" . $week . "</a>";
	}
}
else {
	echo "No results yet. Try clicking a date or category.";
}

?>
</body>
</html>