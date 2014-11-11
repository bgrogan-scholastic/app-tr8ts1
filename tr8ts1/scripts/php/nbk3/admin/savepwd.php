<?php
##################################################################################################
# Filename: savepwd.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
# 
# Just saves the password for the destination machine along with the host.
###################################################################################################

// echo "<pre>";
// foreach ($_POST as $key => $value) {
// 	echo "Key: $key\tValue: $value<br>";
// }
// echo "<pre>";
$myDomain = $_SERVER["SERVER_NAME"];
setcookie("saved-host", $_POST["host"], 0,"/", $myDomain, false);
setcookie("saved-pwd", $_POST["password"], 0,"/", $myDomain, false);
setcookie("saved-user", $_POST["username"], 0,"/", $myDomain, false);
header("Location: /admin/menu.php");
exit;

?>
