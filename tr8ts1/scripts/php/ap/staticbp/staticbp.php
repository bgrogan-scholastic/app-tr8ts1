

<?php

/*+ ************************************************************
 * Name            : staticbp
 * Created by      : Doug Farrell
 * Date            : 11-14-2003
 * Comment         : This file contains the static build page 
 * (staticbp) program. The purpose of this program is to build a
 * mostly static page. It does this by incorporating an file into
 * a template file, both of which can be specified in the URL.
 *************************************************************** -*/

function staticPage() {
	$filepath = $_SERVER['DOCUMENT_ROOT'] . $_GET['page'];
	
	// -----------------------------------------------------
	// does the static page file exist?
	// -----------------------------------------------------
	if(file_exists($filepath)) {
		require($filepath);

	// -----------------------------------------------------
	// otherwise, no file, so print message
	// -----------------------------------------------------
	} else {
		echo "File : " . $filepath . " doesn't exist<br>\n";
	}
}


require_once($_SERVER['TEMPLATE_HOME'] . "/" . $_GET['templatename']);


?>
