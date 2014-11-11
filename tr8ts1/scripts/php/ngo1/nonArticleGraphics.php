<html>
<?php
		require_once('DB.php');
		$productid = $_REQUEST["product_id"];
		$giassetid = $_REQUEST["id"];
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
				
					if (DB::isError($db)) {
						print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
					}
					else {
					$mainSQL = "Select fext,credit,title_ent as title,caption_id as caption,type from manifest "
							. "where slp_id = '{$giassetid}';";
					$result = $db->getall($mainSQL,DB_FETCHMODE_ASSOC);
					$rslt = $result[0];
					$assetImageHTML = "<img align=center src=\"/csimage?product_id=".$productid."&id=".$giassetid."&ext=".$rslt['fext']."\">";
					echo $assetImageHTML;
				}
?>
</html>