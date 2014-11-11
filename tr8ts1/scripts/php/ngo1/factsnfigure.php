<?php 
/**
 * factsnfigure is a wrapper file, which is called in popup of facts n figure
 * @name : factsnfigure.php
 * @param : id (assetid), type(optional)
 * @version : V1.0 12/1/2008
 * 
 * Modified: cmd 07/22/09
 * Changed to not have it wrap setlinks.php, because setlinks is getting primary_doc from manifest
 * That broke in older products where primary_doc is not a field
 * 
 * 
 */
echo '<link href="/css/ngo.css" rel="stylesheet" type="text/css"/>';
echo ' <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<style type="text/css">
div#yellow_Background {
			background-color: #fffae2;
			border: solid 2px #b6b6b6;
			overflow: auto;
			font-family: Verdana, arial, helvetica, sans-serif;
			margin-top: 10px;
			padding: 15px;

	}
</style>';
echo "<div id=\"yellow_Background\">";
require_once($_SERVER['PHP_INCLUDE_HOME'].'/ngo1/assetInfo.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_TransText.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
require_once('DB.php');



$slp_id = addslashes($_REQUEST['id']);


if($_SERVER[GI_AUTH_PCODE] == 'eto')
{
	$auth_code = 'eto';

}
elseif($_SERVER[GI_AUTH_PCODE] == 'xs')
{
	$auth_code = 'ngo';

}

/**
	 * Destination product id used in GI_Transtext must match $auth_code
	 * If there is no output then config files are missing on the Content Server
	 * @Octa 08-26-2009 
	 * //$ngo_product_id = "ngo";
	 */


$product_id = addslashes($_GET['product_id']);

/**
 * Check whether product source is RPS or LEGACY
 */

$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
if (DB::isError($db)) {
	echo "Error:  Could not connect to DB_CONNECT_STRING";
} else {
	$isRPS = "SELECT p.`isRPS` FROM product_map p WHERE p.`productid`='{$product_id}';";
	$isRPS = $db->getOne($isRPS);
	$db->disconnect();

}

//************************************************************************
//						Obtain DB Connect Strings						//
//************************************************************************

$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
if (DB::isError($db)) {
	echo "Error:  Could not retrieve mysql connect string APPENV_CONNECT_STRING";
}
else {
	$sql = sprintf("select value from appenv where app='$product_id' and key_name='product_db';");
	$result = $db->query($sql)->fetchrow();
	$db->disconnect();
	$db_connect_string=$result[0];
}
// echo "<BR><BR>db_connect_string=".$db_connect_string."<BR>";



//************************************************************************
//							Connect to DB								//
//************************************************************************

$newdb = DB::connect($db_connect_string);
if(DB::isError($newdb))
{
	echo "Error:  Could not retrieve mysql connect string for eto DB";
} else {
	if ($isRPS == 0){
		$sql = "SELECT p.id as assetID,p.title,
					p.fext as ext, p.title as ada_text
					FROM assets p	
					WHERE id='{$slp_id}'";
		$resultimg = $newdb->query($sql);
		$rowimg = $resultimg->fetchRow(DB_FETCHMODE_ASSOC);
		$newdb->disconnect();
	} else {

		$sql = "SELECT p.slp_id as assetID,p.title_ent as title,
					p.fext as ext,p.product_id as productid, p.ada_text as ada_text,
					p.credit as credits 
					FROM manifest c	
					INNER JOIN manifest p 
			 		ON c.uid=p.puid 
					AND c.slp_id='{$slp_id}'";
		$resultimg = $newdb->query($sql);
		$rowimg = $resultimg->fetchRow(DB_FETCHMODE_ASSOC);
		$newdb->disconnect();
	}

	$credits = addslashes($rowimg['credits']);

	//************************************************************************
	//			Create the image string and then replace in $output.		//
	//************************************************************************

	$imgstr = "img credits=\"$credits\" class=\"setlinks\"
				title=\"$rowimg[ada_text]\" alt=\"$rowimg[title]\" 
				src=\"/csimage?product_id=$rowimg[productid]&id=$rowimg[assetID]&ext=$rowimg[ext]\" ";
	$pattern='#<img.*?[^<]>#';
	$output = preg_replace($pattern,"<".$imgstr."/>",$output);


	if($product_id == 'ea'){

		//EA products

		$assetinfo = new AssetInfo("ea", $slp_id);
		$type = $assetinfo->getType();


		$newdb = DB::connect($db_connect_string);
		if(DB::isError($newdb))
		{
			echo "Error:  Could not retrieve mysql connect string for ea DB";
		}
		$sql = "SELECT src_product_id as src_product
					FROM manifest 
					where slp_id='{$slp_id}'";
		//echo $sql;

		$result = $newdb->query($sql);
		$rowing=$result->fetchRow(DB_FETCHMODE_ASSOC);
		$product_id = $rowing['src_product'];



		$newdb->disconnect();

		$textAsset = new GI_TransText(array
		(CS_PRODUCTID => $product_id,
		CS_GTYPE => $type,
		NGO_PRODUCTID => $auth_code,
		NGO_GTYPE => $type,
		GI_ASSETID => $slp_id)
		);

	}else{
		//other products

		/**
			 * Assetinfo must use {Source} Product ID and not Destination Product ID
			 * @Octa 08-26-2009
			 */
		$assetinfo = new AssetInfo($product_id, $slp_id);
		$type = $assetinfo->getType();


		$textAsset = new GI_TransText(array
		(CS_PRODUCTID => $product_id,
		CS_GTYPE => $type,
		NGO_PRODUCTID => $auth_code,
		NGO_GTYPE => $type,
		GI_ASSETID => $slp_id)
		);

	}



	//************************************************************************
	//							BEGIN DEBUG	    							//
	//************************************************************************
	//	echo "<BR>_________BEGIN DEBUG___________<BR>";
	//	echo "ngo_product_id=".$ngo_product_id."<BR>";
	//	echo "product_id=".$product_id."<BR>";
	//	echo "type=".$type."<BR>";
	//	echo "slp_id=".$slp_id."<BR>";
	//	echo "<PRE>";
	//	print_r($textAsset);
	//	echo "<BR>___________END DEBUG____________<BR>";
	//************************************************************************
	//							END DEBUG	    							//
	//************************************************************************


	if(!GI_Base::isError($output = $textAsset->output()))
	{

		echo $output;

	}
	else
	{

		$textAsset->_raiseError("error with executing GI_TransText object!!!", 2, 1);

	}
}
echo "</div>";
?>
