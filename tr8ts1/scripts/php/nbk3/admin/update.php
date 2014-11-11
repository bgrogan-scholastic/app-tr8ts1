<?php
##################################################################################################
# Filename: update.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
#
# Does the bulk of the work. I update all of the id's that are passed to me with the appropriate status, then
# Call the newsupdate.py file that handles all the plweb activity.
###################################################################################################

@include_once("dbConnect.php");

$newline = "\n";

$dbh = dbConnect("nbk3");

$changefile = "/home/nbk3/newsadministration/changes.txt";
$canonicalChangeFile = "/home/nbk3/newsadministration/canonical-changes.txt";

#if you change this location, also change it in the newsupdate.py script
$telnetfile = "/home/nbk3/newsadministration/telnetchanges.txt";


if (isset($_POST['clearlog']) or isset($_GET['clearlog'])) {
  exec("echo '-----' >> " .  $canonicalChangeFile);
  exec("echo `date` >> " . $canonicalChangeFile);
  exec("cat " . $changefile . " >> " . $canonicalChangeFile);
  exec("echo '-----' >> " .  $canonicalChangeFile);

  $fp = fopen($changefile, "w");
  fwrite($fp,"");
  fclose($fp);
  echo "Done.<br>";
  exit;
}

@include_once("openchangelog.php");

$onlyrelated = $_POST["onlyrelated"];
//remove the item from the post array
unset($_POST["onlyrelated"]);

$usedingo = "usedingo-";
$so_usedingo = strlen($usedingo);

$tnIDs = array();  #build a seperate list for updating the files via telnet. This is controlled seperately from the changelog.
#append to file if we're not just viewing the file.
if (!isset($_POST['seelog'])) {
	#print_r($_POST);
	foreach ($_POST as $k => $v) {

		if (strncmp($k, $usedingo, $so_usedingo) == 0) {
			$goStatusID = substr($k, $so_usedingo);
			#print $goStatusID . "<br>";
			$gostatus = "update narchive set usedingo='$v' where n_artid='$goStatusID'";
			#print $gostatus . "<br>";
			$result = mysql_query($gostatus);
			#get the related assets to this main one that don't have the same matching 'useingo' status. 
			$related_useingo_query = "select a.id from nassets a, nrelations r, narchive v where n_pid='$goStatusID' and a.id=r.n_cid and v.n_artid=a.id and v.usedingo<>'$v'";
			$related_results = mysql_query($related_useingo_query);
			$count_rel = mysql_num_rows($related_results);
			#if there are any, then set all of them to whatever status the main asset has.
			if ($count_rel > 0) {
				$related_ids = mysql_fetch_array($related_results);
				$rid = $related_ids['id'];
				$gostatus_related = "update narchive set usedingo='$v' where n_artid='$rid'";		
				$result = mysql_query($gostatus_related);	
			}
		}
		else {
			$check_query = "select n_status from narchive where n_artid='$k'";
			$c_result = mysql_query($check_query);
			$cArray = mysql_fetch_array($c_result);
			$existing_status = $cArray['n_status'];

			if ($existing_status != $v) {

				$query = "update narchive set n_status='$v' where n_artid='$k'";

				$result = mysql_query($query);

				$aaIDs[$k] = $v;
				$aaIDsTime[$k] = date('F j, Y, g:i a', mktime());

				$typequery = "select type from nassets where id='$k'";
				$typeresults = mysql_query($typequery);
				$typeArray = mysql_fetch_array($typeresults);
				$tType = $typeArray['type'];
				if (!(strpos($tType, "0tdn") === false)) {
					$tnIDs[$k] = $v;
				}

				$relatedquery = "select a.id, a.type from nassets a, nrelations r, narchive v where  n_pid='$k' and a.id=r.n_cid and v.n_artid=a.id";
				$rresult = mysql_query($relatedquery);
				while ($aIDs = mysql_fetch_array($rresult)) {
					$thisid = $aIDs['id'];

					//check the status of the related item
					$checkrelated_query = "select n_status from narchive where n_artid='$thisid'";
					$cr_result = mysql_query($checkrelated_query);
					$crArray = mysql_fetch_array($cr_result);
					$related_existing_status = $crArray['n_status'];

					if ($related_existing_status != $v) {
						$related_inactive_query = "update narchive set n_status='$v' where n_artid='" . $thisid . "'";
						mysql_query($related_inactive_query);

						$aaIDs[$thisid] = $v;
						$aaIDsTime[$thisid] = date('F j, Y, g:i a', mktime());

						$atype = $aIDs['type'];
						//only add this asset to the telnet change list if it's a 0tdn* type. Otherwise there is no file to move at all.
						if (!strpos($atype, "0tdn") === false) {
							$tnIDs[$thisid] = $v;
						}
					}//end outer if statement checking status change.
				}
			}
		}
	}
}

$fp = fopen($changefile, "w");
if (!isset($_POST["seelog"])) {
	$tp = fopen($telnetfile, "a");
}

foreach ($aaIDs as $k => $v) {
	fwrite($fp, $k . $doublecolon . $v . $doublecolon . $aaIDsTime[$k] . $newline);
}

#only write the telnet change file if we're not simply viewing the log.
if (!isset($_POST["seelog"])) {
	foreach ($tnIDs as $k => $v) {
		fwrite($tp, $k . $doublecolon . $v . $newline);
	}
}

fclose($fp);
if (!isset($_POST["seelog"])) {
	fclose($tp);
}

?>

<html>
<head>

<title>News Administration  - Recent Updates</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css">
</head>
<body>

<?php

$size = count($aaIDs);

if ($size == 0){
	echo "<br>There are no changes in the changelog in archive/inactive status.";
	echo "You just might want to go <a href=\"javascript:window.history.back(-1);\">back</a> to the page you were just at.<br>";
	echo "Any changes made to the 'used in go' flag have been noted, however.";
	exit;
}
echo  "There are $size records in changelog.";
?>

<table summary="Recent Changes to News Archive" width="100%" cellpadding="1" cellspacing="1" border="1">
<tr>
<th>SGMLID</th>
<th>News ID</th>
<th>Title</th>
<th>Type</th>
<th>Changed Status</th>
<th>Last Change</th>
</tr>

<?php

foreach ($aaIDs as $id => $status) {
	$titleq = "select sgmlid, title, type from nassets where id='" . $id . "'";
	$tresult = mysql_query($titleq);
	$aRow = mysql_fetch_array($tresult);

	$title = $aRow['title'];
	$sgmlid = $aRow['sgmlid'];
	$type = $aRow['type'];
	echo "\n<tr>\n\t<td>" . $sgmlid . "</td>\n\t<td>". 	$id .  "</td>\n\t<td>" . $title . "</td>\n\t<td>" .$type . "</td>\n\t<td>" . $status  . "</td>\n\t<td>" . $aaIDsTime[$id] . "</td>\n</tr>";
}

?>


</table>


<input type="button" value="Print This Page" onClick="javascript:window.print();">
<form name="clearchangelog" action="update.php" method="post">
<input type="hidden" name="clearlog" value="true">
<!-- input type="submit" value="Clear the Changelog" -->
</form>

<?php
//if we're actually processing the log, not just viewing it, send an email.

if (isset($_GET["seelog"])) {
	echo "</body></html>";
	exit(0);
}

if (!isset($_POST["seelog"])) {
	//Formulate email to be sent.

	$hn = $_SERVER["SERVER_NAME"]; #get the current hostname
	$hostname = explode(".", $hn); #break the <hostname>.grolier.com up by "."
	$thishost = $hostname[0];  #Get just the machine name: linuxdev/linuxstage
	$output = "";
	// recipients, comma seperated without spaces
	$to  = "treisel@scholastic.com,datkins@scholastic.com";
	$subject = "NBK3 News Update occurred on $thishost";
	$message = "The NBK3 News update tool has been used to update some news stories. If you would take a moment, please log into the NBK3 News administration tool, provide the proper username and password, and click on the 'Update Search Engine' link, the PLWEB database will be updated.\nThank you.";
	$message .= "\n---end---\n\nThis message was automated. Please do not reply to this message.[update.php]\n";
	$commandline = "/data/nbk3/scripts/python/nbk3/sendmail.py tmitchell@scholastic.com $to \"$subject\" \"$message\"";
	exec($commandline, $output, $status);
	echo "Email sent. Result: $status<br>";
}


?>

<p align="center"><a href="javascript:history.go(-1);">Back</a></p>
<!-- refresh the top window from here -->
<script language="javascript">
parent.topstories.document.location = "topstories.php";
//parent.newscontrol.document.location = parent.newscontrol.document.location;
</script>
</body>
</html>
