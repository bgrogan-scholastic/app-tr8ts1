<?php 

/* goframe.php
Author: Ben Robinson
Date:   6/12/07
Purpose: This page looks at your cookies and sets variables accessible by the go frame
code for decision making
*/

require_once($_SERVER['PHP_INCLUDE_HOME'].'common/auth/GI_AuthPreferences.php');

$debug_out = '';

$cm = new GI_AuthPreferences();
//application global home set by hitting kids/pp directly. takes 1st precedence
$agh = $cm->getPreference('AGH');
//current home set from permanent cookie, takes second precedence
$ch = $_COOKIE['CH'];
//global home set by auth in prefs cookie, takes last precedance
$gh = $cm->getPreference('GH');

//see if current product cookie exists to determine if we need to load the frameup code
$cp = $_COOKIE['CurrentProduct'];

$frame = '/topframe?tn=/frame/search_go.html';

//function find_home() {
	//precedence:  agh (session cookie), ch (permanent cookie), gh (auth session cookie), passport default
	if (strlen($agh) > 0) { $loc = $agh; $debug_out = 'agh  is set'; } 
		elseif (strlen($ch) > 0) { $loc = $ch; $debug_out = 'ch perm cookie is set'; } 
			elseif (strlen($gh) > 0) { $loc = $gh; $debug_out = 'gh (auth) cookie is set'; }
				else { $loc = 'P'; $debug_out = 'no global home cookies found, using passport'; }

 $debug_out .= '<br>three cookies: <br>agh: '.$agh.'<br>ch: '.$ch.'<br>gh: '.$gh.'<br>chosen value: '.$loc;

//auth will send directly to classic.
function getGoLoc() { 

	global $loc;

	if ($loc == "C") { $goLoc = 'http://'.$_SERVER['HTTP_HOST'].'/classic'; }
	elseif ($loc == "K") {
		$goLoc = GI_BaseHref("go2-kids");
		} else { $goLoc = GI_BaseHref("go2-passport"); } 

		return $goLoc;
}

function getGoFrameloc() {

  /*return location for goframe (kids or passport)   depending on $loc setting above.  only reason 
  for this function is b/c if $loc is set to Classic, you have to manually set frameup loc to classic, 
  otherwise you will get part of the classic page as a frameup
  logic is as follows (simple): set to go pp, if loc is K, set to kids.  this takes care of classic case.
  */
  
 global $loc;

	$goLoc = GI_BaseHref("go2-passport"); 
	if ($loc == "K") { 
		$goLoc = GI_BaseHref("go2-kids");
		} 

		return $goLoc;

}

//if rap cookie length < 1, send to relevant home page
function checkrap() {
	$rc = $_COOKIE['rap'];
	if  (strlen($rc) < 1) { 
	header("location: ".getGoLoc());
	} 
}

function deleteRap() {
	echo '<script>DeleteCookie("rap","/",".grolier.com");</script>';
}

?>