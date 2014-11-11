<html>
<head>
<title>News Administration</title>
<link rel="stylesheet" type="text/css" href="newsadmin.css" />
</head>
<body>
<?php

  
function elapsedtime($sec){
   $days  = floor($sec / 86400);
   $hrs   = floor(bcmod($sec,86400)/3600);
   $mins  = round(bcmod(bcmod($sec,86400),3600)/60);
   $secs  = round((bcmod(bcmod($sec,86400),3600)/60)/60);
   if($days > 0) $tstring = $days . "d,";
   if($hrs  > 0) $tstring = $tstring . $hrs . "h,";
   $tstring = "[" . $tstring . $mins . "m " . $secs . "s]";
   return $tstring;
 }

function calcDateDiff( $date1, $date2 ) 
{
  
  if( $date2 > $date1 )    {
    
    die( "error: date1 has to be >= date2 in calcDateDiff($date1, $date2)" );
    
  }
  
  
  
  $diff = $date1-$date2;
  
  $seconds = 0;
  
  $hours  = 0;
  
  $minutes = 0;
  
  if($diff % 86400 > 0)
    
    {
      
      $rest = ($diff % 86400);
      
      $days = ($diff - $rest) / 86400;
      
      
      
      if( $rest % 3600 > 0 )
	
       {
	 
	 $rest1 = ($rest % 3600);
	 
	 $hours = ($rest - $rest1) / 3600;
	 
	 
	 
	 if( $rest1 % 60 > 0 )
	   
           {
	     
	     $rest2 = ($rest1 % 60);
	     
	     $minutes = ($rest1 - $rest2) / 60;
	     
	     $seconds = $rest2;
	     
           }else

               $minutes = $rest1 / 60;

      

       }else

           $hours = $rest / 3600;

   }else

       $days = $diff / 86400;

      

   return array( "days" => $days, "hours" => $hours, "minutes" => $minutes, "seconds" => $seconds);

}

$beginTime = mktime();
print "Report Started at ". date('F j, Y, g:i a', $beginTime) . "<br>";

@include_once("dbConnect.php");
$dbh = dbConnect("nbk3");

require_once($_SERVER["SCRIPTS_HOME"] . "/nbk3/common/GI_DBList.php");
$buildListURL = "http://omega.grolier.com/products/buildlists/buildlist.SCP";

$blHTML = file($buildListURL);
$blInfo = array();
//Break each pipe-delimited line into pertinent information: I only need sgmlid, title and status
$sgmlids = array();

$allQuery = "select sgmlid, id, title, n_status from nassets a, narchive r where a.id=r.n_artid and a.type like '0tdn%' and a.type<>'0tdnr'";

$results = mysql_query($allQuery);
$num_results = mysql_num_rows($results);
$allResults = array();
while ($aRow = mysql_fetch_assoc($results)) {
    $allResults[$aRow['sgmlid']][$aRow['id']] = array(title => $aRow['title'], n_status => $aRow['n_status']);
}


foreach ($blHTML as $line) {
  $oneLine = explode("|", $line);
  $thisStatus = "unset";
  //try to set the status the same as the narchive table. This will make comparison easier later on.
  if ($oneLine[4] == 1) {
    $thisStatus = "active";
  }
  else if ($oneLine[4] == 0) {
    $thisStatus = "inactive";
  }
  //print $thisStatus. "<br><hr>";
  $blInfo[$oneLine[0]] = array('title' => $oneLine[1], 'status' => $thisStatus);
}
//print("There are ". $num_results . " in the result set, and " . count($blInfo) . " appear in the buildlist.<br>");

// print_r($allResults);
// print "<hr><hr><hr>";
// print count($blInfo);
// print "<br>";
// print_r($blInfo);
// print "<br>";

//print_r($sgmlids);
//print "<br>";

$blKeys = array_keys($blInfo);
$dbKeys = array_keys($allResults);
//what's in both sets of information? use the intersection
$intersection = array_intersect($blKeys, $dbKeys);
//print "<b>Intersection: </b><br>";
//print_r($intersection);
$mismatched = array();

foreach ($intersection as $key => $sgmlid) {
  //Because we have possible duplicate sgmlid's with different id's attached, we'll need to loop to get the id's attached to each mismatched status.
  $size = count($allResults[$sgmlid]);
  foreach ($allResults[$sgmlid] as $id => $data) {
    if ($allResults[$sgmlid][$id][n_status] != $blInfo[$sgmlid][status]) {
      $mismatched[$sgmlid][] = $id;
    }
  }
}

//print_r($mismatched);

if(count($mismatched) > 0) {
  print "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n";
  print "<tr><th colspan=\"6\">There are " . count($mismatched) . " SGML ID's that don't match the NBK3 database status.</th></tr>\n";
  print "<tr><th colspan=\"1\">SGMLID</th><th colspan=\"2\">BuildList</th><th colspan=\"3\">NBK3 Database</th></tr>\n";
  print "<tr><th>&nbsp;</th><th>SGML Title</th><th>Status in SGML</th><th>NBK3 Asset ID</th><th>NBK3 Title</th><th>NBK3 Status</th></tr>\n";
}

foreach ($mismatched as $sgmlid => $mismatchInfo) {
  foreach ($mismatchInfo as $index=>$id) {
    echo "<tr>\n<td>$sgmlid</td><td>" . $blInfo[$sgmlid][title] . "</td><td>" . $blInfo[$sgmlid][status] . "</td>\n";
    echo "<td>$id</td><td>" . $allResults[$sgmlid][$id][title] . "</td><td>" . $allResults[$sgmlid][$id][n_status] . "</td></tr>\n";

  }
}

if(count($mismatched) > 0) {
  print "</table>";
}




//what's in the buildlist but not in the database?
$buildListOnly = array_diff($blKeys, $dbKeys);
//print "<b>Build list only:</b><br>";
//print count($buildListOnly) . "<br>";
//print_r($buildListOnly);

if(count($buildListOnly) > 0) {
  print "<br><table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n";
  print "<tr><th colspan=\"3\">There are " . count($buildListOnly) . " SGML ID's that don't appear in the NBK3 database.</th></tr>\n";
  print "<tr><th colspan=\"1\">SGMLID</th><th>SGML Title</th><th>Status in SGML</th></tr>\n";
}
foreach ($buildListOnly as $index => $sgmlid) {
  echo "<tr>\n<td>$sgmlid</td><td>" . $blInfo[$sgmlid][title] . "</td><td>" . $blInfo[$sgmlid][status] . "</td></tr>\n";
}

if(count($buildListOnly) > 0) {
  print "</table>";
}




//what's in the database, but not in the buildlist?
$dbOnly = array_diff($dbKeys, $blKeys);
//print "<b>Database only:</b><br>";
// print count($dbOnly) . "<br>";
// print_r($dbOnly);
// print_r($allResults);

if(count($dbOnly) > 0) {
  print "<br><table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n";
  print "<tr><th colspan=\"4\">There are " . count($dbOnly) . " Assets that appear in the NBK3 database that are not in the SGML Buildlist</th></tr>\n";
  print "<tr><th colspan=\"1\">SGMLID</th><th>NBK3 Asset ID</th><th>NBK3 Title</th><th>NBK3 Status</th></tr>\n";
}

foreach ($dbOnly as $index => $sgmlid) {
  foreach ($allResults[$sgmlid] as $id => $info) {
    //print_r($allResults[$sgmlid][$id]);
    echo "<tr>\n<td>$sgmlid</td><td>$id</td><td>" . $allResults[$sgmlid][$id][title] . "</td><td>" . $allResults[$sgmlid][$id][n_status] . "</td></tr>\n";
  }
}

if(count($dbOnly) > 0) {
  print "</table>";
}

//print "<pre>";
$duplicates = array ();
foreach ($allResults as $sgmlid => $data) {
  if (count($data) > 1) {
    $duplicates[$sgmlid] = $data;
  }
}
//print_r($duplicates);

if(count($duplicates) > 0) {
  print "<br><table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n";
  print "<tr><th colspan=\"4\">There are " . count($duplicates) . " duplicate SGML ID's and their corresponding NBK3 Information</th></tr>\n";
  print "<tr><th colspan=\"1\">SGMLID</th><th>NBK3 Asset ID</th><th>NBK3 Title</th><th>NBK3 Status</th></tr>\n";
}

foreach ($duplicates as $sgmlid => $data) {
  //print_r($allResults[$sgmlid][$id]);
  foreach ($data as $id => $assetData) {
    echo "<tr>\n<td>$sgmlid</td><td>$id</td><td>" . $assetData[title] . "</td><td>" . $assetData[n_status] . "</td></tr>\n";
  }
}

if(count($duplicates) > 0) {
  print "</table>";
}
$endTime = mktime();
print "Report Finished at ". date('F j, Y, g:i a', $endTime) . "<br>";
$diff = ($endTime > $beginTime) ? ($endTime - $beginTime) : ($beginTime - $endTime);

print "Elapsed Time: " . elapsedtime($diff) . "<br>";
print_r(calcDateDiff($beginTime, $endTime)); 
?>
</body>
</html>