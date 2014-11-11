<?php

// include the required libraries for database call to pfe table.
require_once($_SERVER['GI_INCLUDE_PATH'] . 'GI_Constants.php'); 
require_once($_SERVER['GI_INCLUDE_PATH'] . 'utils/GI_getVariable.php');
require_once($_SERVER['GO2_CONFIG'].'/GI_BaseHref.php');
require_once($_SERVER['GO2_CONFIG'].'/GI_ProductVersions.php');
require_once($_SERVER["PHP_INCLUDE_HOME"] .'common/auth/GI_AuthPreferences.php');

//retrieve the cookie for current product and strip off domain name
$auth_preferences = new GI_AuthPreferences();
$curr_product_id = $auth_preferences->getCurrentProductId();
$prev_product_id = $auth_preferences->getPreviousProductId();
$goBaseHref = GI_BaseHref(GI_PCODE_GO);
$frameBaseHref = GI_BaseHref("go2-" . FRAME_TYPE);
$searchBaseHref = GI_BaseHref("search");
$atlasPopupWindow = "thePopup.newWindow('" . $goBaseHref . "/rd?feature=atlas&id=mgwr016', popupWidth, popupHeight,'Atlas','yes','yes','yes','yes','yes','yes')";
$curr_product_id_ver = GI_ProductVersions(& $curr_product_id);
?>