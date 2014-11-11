<?php

require_once($_SERVER['PHP_INCLUDE_HOME'].'ngo1/xml_xspace.php');


if(!isset($filename)){
	require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');
	require_once($_SERVER['PHP_INCLUDE_HOME'] .'common/utils/GI_Hash.php');
	$binaryAsset = new GI_BinaryAsset(array(
			CS_PRODUCTID => 'ngo',
			GI_ASSETID => $_GET['id'],
			'fext' => 'xml'
			)
			);
			if(GI_Base::isError($binaryAsset)) {
				$GLOBALS["errorManager"]->reportError($binaryAsset);
				$GLOBALS["fatalerror"]=TRUE;
			}

			if(isset($_SERVER['CS_DOCS_ROOT'])){
				$documentRoot = $_SERVER['CS_DOCS_ROOT'];
			}else{
				$documentRoot = $_SERVER['DOCUMENT_ROOT'];
			}
			$filename = $documentRoot.$binaryAsset->getUrlPath();
}

if(isset($_GET['level'])){
	$level = $_GET['level'];
}
else
  $level = $level;



$readIt = new readIt($filename);
 
$readMore = $readIt->getSurveyTitles();
$readmoreuid = $readMore[$level]['id']['uid'];
foreach ($readMore[$level] as $key => $value){

	if($key =='id')
	$id = $value;
	elseif($key == 'src_product')
	$src_product = $value;
	elseif ($key=='title')
	$articleTitle = $value;

}
//if src_product is still not set then check the src_product_id
if(!isset($src_product))
{
	$src_product=$readMore[$level]['id']['src_product_id'];

}
	
 
echo '<a href="/article?id='.$id.'&uid='.$readmoreuid.'&product_id='.strtolower($src_product).'" class="readmoreLink"  title="Read More on '.$articleTitle.'.">Read more...</a>';
 

?>