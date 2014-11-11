<?php
##################################################################################################
# Filename: dbConnect.php
#
# Date: 11/24/03
#
# Author: Tyrone Mitchell
###################################################################################################

function dbConnect($database) {

  #$dbh = mysql_pconnect("172.19.161.46", "nbk3", "nbk3");

	#connect using this machine / username / password
	$dbh = mysql_pconnect("localhost", "nbk3", "nbk3");

  mysql_select_db($database, $dbh);

  if (!$dbh) {
    echo "Sorry; couldn't connect to required database.<br/>";
    exit;
  }

	#return the db handle to the caller
  return $dbh;

}

?>