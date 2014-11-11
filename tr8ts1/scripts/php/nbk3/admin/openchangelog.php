
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filename: openchangelog.php
//
// Date: 12/18/03
//
// Author: Tyrone Mitchell
// 
// This is a small snippet that gets used to open up the change log, parse it and populates 
// two arrays for displaying / adding to the changelog, or generating reports for the nbk3 news group..
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$changefile = "/home/nbk3/newsadministration/changes.txt";
$doublecolon = "::";

#open the changelog file and parse it.
if (file_exists($changefile)) {
	$lines = file($changefile);
	$numlines = count($lines);
	$aaIDs = array(); //This holds key/value == ID/Status for all the news stories that have changed status.
	
	//This is another array that deals with the last time that this record was updated.
	$aaIDsTime = array();

	for ($i=0; $i<$numlines; $i++) {
    #remove the trailing newline character
		$thisline = trim($lines[$i]);
		$value = explode($doublecolon, $thisline);
		$aaIDs[$value[0]] = $value[1]; 
		$aaIDsTime[$value[0]] = $value[2]; //insert the current time into the array
	}
}

?>