<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filename: reportgenerator.php
//
// Date: 12/18/03
//
// Author: Tyrone Mitchell
// 
// This is the portion that gets all the most recently updated id's in the changelog and sends only those to
// The designated team for nbk3.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

@include_once("dbConnect.php");
@include_once("openchangelog.php");

$newline = "\n";

$dbh = dbConnect("nbk3");

$query = "create temporary table nbk3_news_report_generator (id varchar(24) not null primary key, status varchar(8) not null, last_updated datetime)";
$results = mysql_query($query);
//echo $results . "<br>";

#make sure there are no records in the table before we start to insert
$query = "delete from nbk3_news_report_generator";
$results = mysql_query($query);
//echo $results . "<br>";


@include_once("openchangelog.php");
foreach ($aaIDs as $k => $v) {
	$iquery = "insert into nbk3_news_report_generator (id, status, last_updated) values ('$k', '$v', from_unixtime($aaIDsTime[$k]))";
	//echo "$iquery<br>";
	$results = mysql_query($iquery);
	//echo $results . "<br>";
}

$query = "select sgmlid, g.id, title, n_status from nbk3_news_report_generator g, nassets n, narchive a where n.id=g.id and a.n_artid=n.id and last_updated between date_sub(now(), interval 31 day) and now()";
#$query = "select * from nbk3_news_report_generator";
//echo "$query<br>";
$results = mysql_query($query);
$num_results = mysql_num_rows($results);
$message = "This month's changes for the build list are:\n\n";
while ($aResults = mysql_fetch_array($results)) {
	$message .= "|" . $aResults['sgmlid'] . "|" . $aResults['title'] . "|";
	
	if ($aResults['n_status'] == "active") {
		$message .= "1";		
	}
	else {
		$message .= "0";				
	}

	$message .= "|" . $aResults['id'] . "|\n";
}
$message .= "\n---end---\n\nThis message was automated. Please do not reply to this message.\n";

$query = "delete from nbk3_news_report_generator";
$results = mysql_query($query);
//echo $results . "<br>";

#get rid of the evidence
$drop = "drop table nbk3_news_report_generator";
$results = mysql_query($drop);

//Formulate email to be sent.

/* recipients, comma seperated without spaces */
$to  = "tmitchell@scholastic.com";

/* subject */
$subject = "NBK3 News BuildList Generator [development only]";

$commandline = "./sendmail.py tmitchell@scholastic.com $to \"$subject\" \"$message\"";
//echo $commandline . "<br>";
exec($commandline, $output, $status);

// echo "Output:";
// foreach ($output as $line) {
// 	echo $line ."<br>";
// }
echo "Report has been generated, Email has been sent. Result: $status<br>";
?> 


