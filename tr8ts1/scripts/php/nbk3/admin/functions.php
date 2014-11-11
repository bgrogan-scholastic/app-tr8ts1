<?php

##################################################################################################
# Filename: functions.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
# Just a helper file that does common little pieces of functionality for the related assets page
# and the main display page.
###################################################################################################

#This allows me to use the alternating row styles. If the index is divisible by two evenly, use row1 style, otherwise, use row2 style.
function returnStyle($idx) {
  if ($idx % 2 == 0) {
    $style = " class=\"row1\"";
  }
  else {
    $style = " class=\"row2\"";
  }
  
  return $style;
}


function returnStyleForGO($idx) {
  if ($idx % 2 == 0) {
    $style = " class=\"row1go2\"";
  }
  else {
    $style = " class=\"row2go2\"";
  }
  
  return $style;
}

#if the status matches the preferred status, just return "checked" - this is for radio buttons.
function ArchivedOrInactive($status, $preferred) {
	
	if ($status == $preferred) {
		return " checked";
	}

}


?>