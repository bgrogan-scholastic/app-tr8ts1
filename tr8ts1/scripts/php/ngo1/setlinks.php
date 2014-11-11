<?php 
/**
 * include GI_TransText.php and DB.php
 * @name : setlinks.php
 * @return : html  / string
 * setlinks bassically links with GI_TransText and returns you the html after xslt conversion.
 * After xslt conversion src of <img> tags are referenced to /csimage.
 */
 
ini_set('display_errors', 'off');
require_once($_SERVER['PHP_INCLUDE_HOME'].'/ngo1/assetInfo.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_TransText.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
require_once('DB.php');

$slp_id = addslashes($_REQUEST['id']);  

$GI_STATS3_PARAMETERS = array(	/*'xs',*/			// Product
								1=>'project',		// Feature
								2=>$slp_id,				// SLP-ID
								3=>'content');		// Service

require_once($_SERVER['PHP_INCLUDE_HOME'].'common/statistics/recordstatisticshit.php');

if($_SERVER[GI_AUTH_PCODE] == 'eto')
{
	$ngo_product_id = 'eto';
}
elseif($_SERVER[GI_AUTH_PCODE] == 'xs')
{
	$ngo_product_id = 'ngo';
}


$product_id = addslashes($_GET['product_id']);

# Huge assumption
if($product_id == '')
{
	$product_id = 'ngo';
}

$assetinfo = new AssetInfo($product_id, $slp_id);
$type = $assetinfo->getType();
$db_connect_string = $assetinfo->_productDB;

$textAsset = new GI_TransText(array 
		(CS_PRODUCTID => $product_id,
			CS_GTYPE => $type,
			NGO_PRODUCTID => $ngo_product_id,
			NGO_GTYPE => $type,
			GI_ASSETID => $slp_id)
	);
	
if(!GI_Base::isError($output = $textAsset->output()))
{
	$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
	
	if (DB::isError($db)) 
	{
		echo "Error:  Could not retrieve mysql connect string for eto DB";
	}
	else 
	{
		$sql = "SELECT value 
				FROM appenv 
				WHERE app='{$product_id}' 
				AND key_name='product_db'";

		$result = $db->query($sql)->fetchrow();
		$db->disconnect();
		$db_connect_string = $result[0];
//		echo $result[0];
	}
	
	$newdb = DB::connect($db_connect_string);
	if(DB::isError($newdb))
	{
		die("Could not connect to {$ngo_product_id} database");
	}	
		
	$sql = "SELECT  p.slp_id as assetID,p.title_ent as title,
					p.fext as ext,p.product_id as productid, p.ada_text as ada_text,
					p.credit as credits 
					FROM manifest c	
					INNER JOIN manifest p 
			 		ON c.uid=p.puid 
					AND c.slp_id='{$slp_id}'";
	//echo $sql;	 
	$resultimg = $newdb->query($sql);
	$rowimg = $resultimg->fetchRow(DB_FETCHMODE_ASSOC);
	
	$credits = addslashes($rowimg['credits']);

	//************************************************************************
	//			Create the image string and then replace in $output.		//
	//************************************************************************
	
	$imgstr = "img credits=\"$credits\" class=\"setlinks\" 
				title=\"$rowimg[ada_text]\" alt=\"$rowimg[title]\" 
				src=\"/csimage?product_id=$rowimg[productid]&id=$rowimg[assetID]&ext=$rowimg[ext]\" ";
				
	//echo $imgstr;
	$pattern='#<img.*?[^<]>#';		
	$output = preg_replace($pattern,"<".$imgstr."/>",$output);
	    $newdb->disconnect();	
	echo $output;
	
}
else
{
	echo 'error with executing GI_TransText object!!!';
	$textAsset->_raiseError("error with executing GI_TransText object!!!", 2, 1);
	
}