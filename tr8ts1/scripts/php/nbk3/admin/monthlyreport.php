<?php

#$server

// Another example, let's get a web page into a string.  See also file_get_contents().
$html = implode('', file("http://" . $_SERVER["HTTP_HOST"] . "/admin/update.php?seelog=true"));
$html = str_replace('<!DOCTYPE','<DOCTYPE', $html);
$html = str_replace('<td>', '|', $html);
$html = str_replace('<tr>', ':::::', $html);
$html = str_replace('<th>', '|', $html);
$html = str_replace("\t", '', $html);
$html = str_replace("\n", "", $html);
$html = str_replace(':::::', "\n", $html);
$html = strip_tags($html, "");

$mr_file = "/home/nbk3/newsadministration/monthlyreports.txt";

$location =  strpos ($html, "|");
if ($location !== FALSE) {
	$html = substr($html, $location);
}
#print $html;
$hn = $_SERVER["SERVER_NAME"]; #get the current hostname
$hostname = explode(".", $hn); #break the <hostname>.grolier.com up by "."
$thishost = $hostname[0];  #Get just the machine name: linuxdev/linuxstage

// recipients, comma seperated without spaces
$to  = "dlanglois@scholastic.com,treisel@scholastic.com,kcalise@scholastic.com,fmamberg@scholastic.com,pbehan@scholastic.com,mfiero@scholastic.com,bcole@scholastic.com,datkins@scholastic.com"; 
#$to  = "tmitchell@scholastic.com"; 
$subject = "NBK3 Monthly Report sent from $thishost";
$message = $html;
$commandline = "/data/nbk3/scripts/python/nbk3/sendmail.py tmitchell@scholastic.com $to \"$subject\" \"$message\"";
exec($commandline, $output, $status);
echo "Email sent. Result: $status<br>Done.";
if ($status == 126) {
		echo "The sendmail.py script might not be executable.<br>";
}
$output = implode('<br>', $output);
#echo "$output<br>";

//clear the change log
file("http://" . $_SERVER["HTTP_HOST"] . "/admin/update.php?clearlog=true");


//Add to the canonical monthly reports change list. If somehow I didn't archive all of the monthly reports, we'd be hosed. 
//So this is a backup.
$mrf = fopen($mr_file, "a");
fwrite($mrf, $message . "\n\n-----\n\n");
fclose($mrf);

?>
