<?php
@include_once("dbConnect.php");
@include_once("functions.php");
$dbh = dbConnect("nbk3");

$ndate = $_GET['ndate'];
$id = $_GET['id'];

$deletes_log = "/export/home/nbk3/newsadministration/deletes.log";
?>

<html>
<head>
<title>News Administration - asset deletion</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css" />
</head>
<body>
Deleting this asset from the database will mean the following will occur:
<li>The asset will be deleted from the narchive table - will not appear in the Archive list</li>
<li>The asset and its related assets will be removed from the nassets table</li>

<script language="javascript">
function validateDelete(){
    
      var questionStr ="Type \"YES\" to remove these assets from narchive,nassets and nrelations."; 
      var removeans = prompt(questionStr,"");
      if(removeans == "YES"){
	return true;
	}
      else{
	document.deleteassets.del.value="no";
	var ansStr1="Assets will not be removed from the database.";
	alert(ansStr1);
	return false;
      }
}
</script>

<?php

if (isset($_GET['del'])) {

  if ($_GET['del'] == "yes") {
    $deletionfile = "/export/home/nbk3/newsadministration/deletes.txt";
    
    $grabbing_ncids = "select n_cid from nassets a, nrelations r where n_pid='$id' and n_cid=a.id";
    $results = mysql_query($grabbing_ncids);
    $idsToDelete = array();
    while($aRow = mysql_fetch_array($results)) {
      $idsToDelete[] = $aRow['n_cid'];
    }
    $idsToDelete[] = $id;

    $related_assets_dquery = "delete from nrelations where n_pid='$id'";
    $narchive_dquery = "delete from narchive where n_artid='$id'";
    $all_ids = "";

    $size = count($idsToDelete);
    for ($i = 0; $i < $size; $i++) {
      $idsToDelete[$i] = "'" . $idsToDelete[$i] .  "'";
    }

    $all_ids = join(", ", $idsToDelete);
    $main_asset_dquery = "delete from nassets where ndate='$ndate' and id in ($all_ids)";

    $queries_to_run = array($narchive_dquery, $related_assets_dquery, $main_asset_dquery);
    foreach ($queries_to_run as $query) {
      //echo $query . "<br>";
      $results = mysql_query($query);
    }
    echo "<script>window.opener.document.location = window.opener.document.location;</script>";
    $today = date("F j, Y, g:i a");
    $fp = fopen($deletes_log, "a");
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = "\n\nDate: $today\nDeleting assets from IP: $ip.\n";
    fwrite($fp, $msg);
    fwrite($fp, "Queries run:\n");
    fwrite($fp, $narchive_dquery . "\n");
    fwrite($fp, $related_assets_dquery . "\n");
    fwrite($fp, $main_asset_dquery . "\n\n");
    fclose($fp);
    echo "Done.<br>";
  }
}

$main_asset_query = "select * from nassets where ndate='$ndate' and id='$id' and type like '0tdn%'";

$related_assets_query = "select * from nassets a, nrelations r, narchive v where  n_pid='$id' and a.id=r.n_cid and v.n_artid=a.id order by a.type asc, r.n_priority asc, a.title asc";

$narchive_query = "select * from narchive where n_artid='$id'";
?>

<table border="0" width="100%" summary="News Assets for One week" cellpadding="2" cellspacing="0">
  <tr><th>SGML ID</th><th>Online ID<br></th><th>Type</th><th>Title<br>(click to see story in new window)</th><th>NGROUP</th><th>Archive Status</th><th class="alltop" id="frameleft">Used in GO?</th><th class="alltop" id="frameright">&nbsp;</th></tr>

<?php


$queries_to_run = array($main_asset_query, $related_assets_query);
$row_index = 0;
foreach ($queries_to_run as $query) {
  
  $results = mysql_query($query);
  $numresults = mysql_num_rows($results);
  
  //This double nested array is just bieng set up.
  $aaNassets = array ();
  
  while ($aRow = mysql_fetch_array($results)) {
    
    //set up the array
    $aaNassets[] = array(sgmlid => $aRow['sgmlid'], id => $aRow['id'], type => $aRow['type'], title => $aRow['title'], ngroup => $aRow['ngroup'], status => $aRow['n_status'], usedingo => $aRow['usedingo'], topstory => $aRow['topstory'], ndate => $aRow['ndate']);
  }
  
  for ($i=0; $i < $numresults; $i++) {
    //get the row style. I alternate styles to enhance readability.
    $class = returnStyle($row_index);
    $row_index = $row_index + 1;
    //display the class
    echo "<tr $class>\n";
    
    //display the SGML id if there is one
    echo "<td>" . $aaNassets[$i]['sgmlid'] . "</td>";
    
    //get the id; I'll use this in creating the link to the story
    $thisid = $aaNassets[$i]['id'];
    echo "\n<td align=\"center\">" . $aaNassets[$i]['id'] . "</td>";
    echo "<td>" . $aaNassets[$i]['type'] . "</td>";		
    echo "\n<td>";
    if (substr($aaNassets[$i]['type'], 0, 4) == "0tdn") {
      echo "<a href=\"/cgi-bin/dated_article?templatename=/news/standard.html&assetid=$thisid&assettype=". $aaNassets[$i]['type'] ."\" target=\"_blank\">";
    }
    else {
      echo "<a href=\"/cgi-bin/media?templatename=/news/media_back.html&assetid=$thisid&assettype=". $aaNassets[$i]['type'] ."\">";      
    }
    echo $aaNassets[$i]['title'] . "</a></td>";
    echo "<td>" . $aaNassets[$i]['ngroup'] . "</td>";
    
    //I have the ArchivedOrInactive function simply echo an empty string or "checked" based on the status of the current id and its preferred statys.
    echo "\n<td><input type=\"radio\" name=\"$thisid\" value=\"active\"" . ArchivedOrInactive($aaNassets[$i]['status'], "active")  . ">Active <br> <input type=\"radio\" name=\"$thisid\" value=\"inactive\"" . ArchivedOrInactive($aaNassets[$i]['status'], "inactive")  . ">Inactive</td>";
    echo "\n<td id=\"frameleft\" valign=\"top\"><input type=\"radio\" name=\"usedingo-$thisid\" value=\"yes\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "yes")  . ">Yes <br> <input type=\"radio\" name=\"usedingo-$thisid\" value=\"no\"" . ArchivedOrInactive($aaNassets[$i]['usedingo'], "no")  . ">No</td>";
    
    
    echo "\n<td align=\"center\" id=\"frameright\">&nbsp;</td>";
    echo "\n</tr>\n\n";
  }
}
?>
</table>
<form name="deleteassets" method="get" action="delete.php" onSubmit="validateDelete();">
<input type="hidden" name="del" value="yes">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="ndate" value="<?php echo $ndate; ?>">
<input type="Submit" value="Delete these assets">
</form>
<p align="center"><a href="javascript:window.close()">Close This Window</a></p>
</body>
</html>