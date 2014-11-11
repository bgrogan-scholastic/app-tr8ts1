<?php
require_once('DB.php');
require_once($_SERVER['GI_INCLUDE_PATH'] . 'article/GI_MediaAsset.php');


$dbConn = DB::Connect( $_SERVER['DB_CONNECT_STRING'] );
if (PEAR::isError($dbConn)) {
	echo 'Database Connection Error on gme_picture.php';
} else {
$sql = sprintf('SELECT * FROM manifest WHERE uid = %s', $_GET['uid']);
$result = $dbConn->getAll($sql, DB_FETCHMODE_ASSOC);
$record = $result[0];

}


$params  = array (
					'productid' => $record['product_id'], 
					'assetid' => $record['slp_id'], 
					'uid' => $_GET['uid'],
					'fext' => $record['fext'],
					'useDB' => false
				 );
$mediaAsset = new GI_MediaAsset($params);


?>
