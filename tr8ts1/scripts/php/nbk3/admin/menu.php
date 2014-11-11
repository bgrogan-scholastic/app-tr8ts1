<?php
##################################################################################################
# Filename: menu.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
# 
# In this file, I display the three different ways of displaying the data in the nassets table in order
# for editors / sgml'ers to update the news database.
###################################################################################################

@include_once("dbConnect.php");

$dbh = dbConnect("nbk3");


#------------------------------------ DATE - DRIVEN PORTION OF THE PAGE ----------------------------------------
$aQuarters = array("-08-15", "-11-15", "-02-15", "-05-15");

$yearquery = "select distinct date_format(ndate, '%Y') years from nassets order by years asc";

#choose one year before and after for school years. One calendar year (might) span two school years.

$yresults = mysql_query($yearquery);
$numyears = mysql_num_rows($yresults);

$aSchoolYears = array();
$i = 0; 

while ($aYears = mysql_fetch_array($yresults)) {
	$aSchoolYears[] = $aYears['years'];
}

$size = count($aSchoolYears);

#sort the array once so I can get the maximum and minimum years
sort($aSchoolYears);

$maxyear = $aSchoolYears[$size - 1] + 1;
$minyear = $aSchoolYears[0] - 1;

$aSchoolYears[] = $maxyear;
$aSchoolYears[] = $minyear;

#re-sort again
sort($aSchoolYears);

#This is only used on this page. I just have this write the necessary link based 
#on the beginning date and end date you pass it.
function displayWeekLink($begindate, $enddate) {
	$query = "select * from nassets where ndate between '$begindate' and '$enddate'";
	$results = mysql_query($query);
	$numresults = mysql_num_rows($results);

	echo "<li>";
	#if I have any news stories between these two dates, then display a link, otherwise, just don't bother.
	if ($numresults > 0) {
		echo "<a href=\"menu2.php?begindate=$begindate&enddate=$enddate\" target=\"menu2\">";
	}

	echo "$begindate to $enddate";
	if ($numresults > 0) {
		echo "</a>";
	}

	echo "</li>\n";
}

#--------------------------------- CATEGORY - DRIVEN PORTION OF THE PAGE -----------------------------------------

#this will look for all of the distinct categories and display links to them.
function displayCategoryLinks() {

	$catquery = "select distinct ngroup from nassets where type like '0tdn%'";
	$cresults = mysql_query($catquery);
	$has_null = false;
	$categories = array();
	while ($acRow = mysql_fetch_array($cresults)) {
		$thisgroup = $acRow['ngroup'];
		$categories[] = $thisgroup;
	}
	

	echo "<ul>View by Category<br>";
	$size = count($categories);
 	foreach ($categories as $category) {
 		echo "<li><a href=\"menu2.php?category=$category\" target=\"menu2\">$category</a><br/></li>";
 	}

	echo "</ul>";
}

#-------------------------------- CHECKING FOR NARCHIVE STATUS --------------------------------
#If there are ID's in nassets that are not in narchive, perform a left join to get the id's that are missing
#and insert the proper status.

$jquery = "SELECT id FROM nassets LEFT JOIN narchive ON id=n_artid WHERE n_artid IS NULL";
$jresults = mysql_query($jquery);
$num_res = mysql_num_rows($jresults);
#echo "$num_res";
while ($ajRow = mysql_fetch_array($jresults)) {
	$id = $ajRow['id'];
	#echo $id ."<br>";
	$status = "active";
	$uquery = "insert into narchive (n_artid, n_status) values ('$id', '$status')";
	mysql_query($uquery);
}

?>

<html>
<head>
<title>News Administration</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css">
</head>
<body>
<?php
$size = count($aSchoolYears);
$qsize = count($aQuarters);
?>
<h2>News Admin &amp; Update page</h2>

<table border="0" cellpadding="1" cellspacing="1">

<tr class="row2">
<td>
<!-- form name="passwordform" method="post" action="savepwd.php" -->
<?php  

if (isset($HTTP_COOKIE_VARS["saved-host"]) and isset($HTTP_COOKIE_VARS["saved-pwd"])) {
	echo "The password has been saved. Please begin changing status.<br>";
}
else {
	$hn = $_SERVER["SERVER_NAME"]; #get the current hostname
	$hostname = explode(".", $hn); #break the <hostname>.grolier.com up by "."
	$thishost = $hostname[0];  #Get just the machine name: linuxdev/linuxstage
	#echo "<b>Please provide your username and password before continuing!</b><br>You are logged into $thishost. <br>";
	
	$configfile = dirname(__FILE__) . "/config.pf";
	include("/data/nbk3/scripts/php/nbk3/common/GI_ParameterFile.php"); 
	include("/data/nbk3/scripts/php/nbk3/common/GI_File.php"); 
	
	$gip = new GI_ParameterFile($configfile);
	$corresponding_host = $gip->GetValue($thishost);
	#echo "<p>Enter your username and  password for host $corresponding_host:</p>";
	#echo "<input type=\"hidden\" name=\"host\" value=\"$corresponding_host\">";
	#echo "Username: <input type=\"text\" name=\"username\" size=\"12\"><br><br>";
	#echo "Password: <input type=\"password\" name=\"password\" size=\"12\"><br><br>";
	#echo "<input type=\"submit\" value=\"Save password\">";
}

#echo "<br><a href=\"/cgi-bin/newsupdate2.py\" target=\"newscontrol\">Update Search Engine</a><br>";
?>
<!-- Any passwords saved will only exist until you close your browser.<p> -->
<!-- /form -->
</td>
</tr>


<tr class="row1">
<td>
<strong>View 1: Select a quarter to display.</strong><br/>
<?php
for ($i = $size - 1 ; $i > 0; $i--) {
	$begin = $aSchoolYears[$i - 1];
	$end =  $aSchoolYears[$i] ;
	echo "<br>School year " . $begin . " - " . $end . "<br>";
	displayWeekLink($begin.$aQuarters[0], $begin.$aQuarters[1]);
	displayWeekLink($begin.$aQuarters[1], $end.$aQuarters[2]);
	displayWeekLink($end.$aQuarters[2], $end.$aQuarters[3]);
	displayWeekLink($end.$aQuarters[3], $end.$aQuarters[0]);
	echo "<br>";
}

?>

</td>
</tr>

<tr class="row2">
<td>
<br><strong>View 2: Select a category to display.</strong><br/>
<?php displayCategoryLinks(); ?>
<br>
</td>
</tr>

<tr class="row1">
<td>
<form name="searchtitle" method="post" action="display.php" target="newscontrol">
<strong>View 3: Search for words in the title of stories.</strong><br/>

Enter one or two terms that would appear in the title:<br><input name="searchterms" size="15">
<p><input type="submit" value="Perform Search"></p>

<p>Results will show up on the far right.</p>
</form>
</td>
</tr>

</form>

<br/>
</td>
</tr>

<tr class="row2">
<td>
Run monthly <a href="monthlyreport.php" target="newscontrol">report</a>.
</td>
</tr>

</table>
</body>
</html>
