<?php
/**
 * @author Nabeel Shahzad <nshahzad@scholastic.com>
 * Jan 2010
 * 
 * Open a PDF, or prompt the user to download the PDF file
 * Pass a slpid= and uid=
 * 
 * pdf.php?slpid=sample57&uid=10536540&product=bdport
 * 
 * That will open the PDF in the browser, by default. If you want
 * to prompt them to download it, add the &prompt parameter, and 
 * an option &filename= parameter. If you pass a filename, it'll
 * prompt them to save it as that filename. Otherwise, the default
 * filename will be the slpid passed in.
 * 
 * pdf.php?slpid=sample57&uid=10536540&product=bdport&prompt&filename=teachersguide
 */
require_once($_SERVER['COMMON_CONFIG_PATH'].'/GI_ProductConfig.php');
error_reporting(E_ALL);
ini_set('display_errors', 'off');

if(!isset($_GET['slpid']) || /*!isset($_GET['uid']) || */!isset($_GET['product']))
{	
	return;	
}

$slpid = addslashes(stripslashes($_GET['slpid']));
$uid = addslashes(stripslashes($_GET['uid']));
$product = addslashes(stripslashes($_GET['product']));

$basehref =  GI_ProductConfig::get_base_href('tr8ts1');
//$basehref = "http://traitspace-dev.grolier.com";
//echo "BASE" . $basehref;

	require_once($_SERVER['PHP_INCLUDE_HOME'].'/common/article/GI_MediaAsset.php');
	
	$mediaAsset = new GI_MediaAsset(array(
			'productid' => $product, 
			'assetid' => $slpid, 
			'uid' => $uid,
			'fext' => 'pdf',
			'useDB' => false
		)
	);
	
	$path = $mediaAsset->getUrlPath();
	
	unset($mediaAsset); # Free up this class, we don't need it anymore
	
	
	/*	If they passed &prompt, then tell the browser to prompt
		the user to do something about it 
	 */
	
	/* old taken out by bryan
	if(isset($_GET['prompt']))
	{
		if(isset($_GET['filename']) && !empty($_GET['filename']))
		{
			$filename = $_GET['filename'];
		}
		else
		{
			$filename = $slpid;
		}
		$pdffile = "/csdocs" . $path;
		$pdffile = $basehref . $pdffile;
		header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');
		header("Location:$pdffile");
	}
	*/
	
	//new added by bshelley
	if (isset($_GET['title']) && !empty($_GET['title'])) {
		//$filename = '<pre>'.$_GET['title'].'</pre>';
		//print $filename;
		$filename = addslashes(html_entity_decode(base64_decode($_GET['title'])));
		$filename = str_replace(" ", "_", $filename);
		
		//print $filename;
		//exit;
	} else {
		$filename = $slpid;
	}
	//$filename = $_GET['title'];
	$pdffile = $_SERVER['CS_DOCS_ROOT'].$path;
//$filename = "test: Boom, &amp; Boom, Ain't It Great to Be Writing?";
//file_put_contents("/data/tr8ts1/logs/jp_test.out", $filename);
	header('Content-Type: application/pdf; filename="'.$filename.'"');
	header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');
	readfile($pdffile);



//header('Content-Disposition: attachment; filename="'.$slpid.'.pdf"');
//echo file_get_contents($_SERVER['CS_DOCS_ROOT'].'/'.$path);

//after you convert to pdf..then go find the pdf you just converted...
//$pdffile = $_SERVER['CS_DOCS_ROOT']."/".$slpid .".pdf";
//$pdffile = "/csdocs" . $path;
//$pdffile = $basehref . $pdffile;
//echo "basehref" . $basehref;
//echo $pdffile;

//and change the current page to be that pdf... 

//$filename = $_GET['title'];
//$pdffile = $_SERVER['CS_DOCS_ROOT'].$path;
//$filename = "test: Boom, Boom, Ain't It Great to Be Writing?";
//header('Content-Type: application/pdf; filename="'.$filename.'"');
//header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');
//readfile($pdffile);


exit;