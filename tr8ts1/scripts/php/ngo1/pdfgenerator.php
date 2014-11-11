<?php
//Author: Diane K. Palmer
//Date: March 31, 2009

error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 'on');
ini_set("memory_limit","512M");
@set_time_limit(10000);

define('DEBUG', false);

//include these two files for the pdf generation
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/config.inc.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/pipeline.factory.class.php');

//these are being included to get the lesson plan html text asset
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/article/GI_TransText.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/ngo1/assetInfo.php');

//need a database connection to get the basehref for this server..
require_once ('DB.php');

//grab the basehref for this server
if($_SERVER['AUTH_PCODE'] == 'eto')
{
	$product_id = 'eto1';
}
else
{
	$product_id = 'ngo';
}

//connect to the datavase
$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
if (DB::isError($db)) 
{	
	//exit("Error encountered: " . $resultMysql->getMessage()); 
}
else 
{	
	$appenvqry = "SELECT value 
	  			  FROM appenv 
				  WHERE app='{$product_id}' 
				    AND key_name='basehref'";
	
	$appenvresult =  $db->query($appenvqry);
	
	$approw = $appenvresult->fetchRow(DB_FETCHMODE_ASSOC);
	$basehref = $approw['value'];	
}

parse_config_file($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/html2ps.config');


//this class is needed for pdf generation..just copy and paste this into your own code..
/**
 * Handles the saving generated PDF to user-defined output file on server
 */
class MyDestinationFile extends Destination 
{
	/**
	 * @var String result file name / path
	 * @access private
	 */
	public $_dest_filename;
	
	public function MyDestinationFile($dest_filename) {
		$this->_dest_filename = $dest_filename;
	}
	
	public function process($tmp_filename, $content_type) {
		copy($tmp_filename, $this->_dest_filename);
	}
}

class MyFetcherMemory extends Fetcher 
{
	public $base_path;
	public $content;
	
	public function MyFetcherMemory($content, $base_path) 
	{
		$this->content   = $content;
		$this->base_path = $base_path;
	}
	
	public function get_data($url) 
	{
		if (!$url) 
		{
			return new FetchedDataURL($this->content, array(), "");
		} 
		else 
		{
			// remove the "file:///" protocol
			/*if (substr($url,0,8)=='file:///') 
			{
				$url=substr($url,8);
				
				// remove the additional '/' that is currently inserted by utils_url.php
				if (PHP_OS == "WINNT") 
				{
					$url=substr($url,1);
				}
			}*/
			
			#
			# Unless we are referring to csimage, just assume it's a local
			#	path going to /data/ngo1/docs
			#
			# Otherwise, use PEAR's HTTP_Request to grab the remote image, 
			#	since we have to add the cookies into the header
			# Nabeel , 7/8/09
			#
			
			$url = str_replace('http://localhost/', '', $url);
						
			if(strpos($url, 'csimage') === false)
			{
				$url = '/data/ngo1/docs/'.$url;
				$contents = file_get_contents($url);
			}
			else
			{
				$url = $this->base_path.'/'.$url;
				
				$req = new HTTP_Request($url);
				$req->addHeader('Cookie', 'auth-pass=true; auids=' . $_COOKIE['auids'] . ';pfeurl=' . $_COOKIE['pfeurl']);
				$req->sendRequest();
				$contents = $req->getResponseBody();
				
			}
			
			return new FetchedDataURL($contents, array(), "");
			
		}
	}
	
	public function get_base_url() 
	{
		#return $this->base_path;
		return '';
		#return 'file:///'.$this->base_path.'/dummy.html';
	}
}

/**
 * Runs the HTML->PDF conversion with default settings
 *
 * Warning: if you have any files (like CSS stylesheets and/or images referenced by this file,
 * use absolute links (like http://my.host/image.gif).
 *
 * @param $path_to_html String HTML code to be converted
 * @param $path_to_pdf  String path to file to save generated PDF to.
 * @param $base_path    String base path to use when resolving relative links in HTML code.
 */
function convert_to_pdf($html, $path_to_pdf, $base_path='') 
{
	$pipeline = PipelineFactory::create_default_pipeline('', '');
	
	// Override HTML source 
	// @TODO: default http fetcher will return null on incorrect images 
	// Bug submitted by 'imatronix' (tufat.com forum).
	$pipeline->fetchers[] = new MyFetcherMemory($html, $base_path);
		
	// Override destination to local file
	$pipeline->destination = new MyDestinationFile($path_to_pdf);
	
	$baseurl = '';
	$media =& Media::predefined('A4');
	$media->set_landscape(false);
	$media->set_margins(array('left'   => 3,
				'right'  => 3,
				'top'    => 3,
				'bottom' => 7));
	$media->set_pixels(1024); 
	
	global $g_config;
	$g_config = array(
			'cssmedia'     => 'screen',
			'scalepoints'  => '1',
			'renderimages' => true,
			'renderlinks'  => true,
			'renderfields' => true,
			'renderforms'  => false,
			'mode'         => 'html',
			'encoding'     => '',
			'debugbox'     => false,
			'pdfversion'    => '1.4',
			'draw_page_border' => false
			);
	
	$pipeline->configure($g_config);
	$pipeline->process_batch(array($baseurl), $media);
}
//////////////////////////////////////////////////////////////////////////////
//the file path for the pdf file the user wants to see..if this is the first time viewing this pdf then this will be the filename that the pdf generator will use when generating the pdf.  if its not the first time
//then we will grab the pdf from the server and display it.
$pdffile = "/data/ngo1/csdocs/pdf/".$_REQUEST['id'] .".pdf";

//check to see if this pdf file already exists...
if(file_exists($pdffile) == true && DEBUG == false){
	
	$pdffile = "/csdocs/pdf/".$_REQUEST['id'] .".pdf";
	$pdffile = $basehref . $pdffile;
	//if it does exist then read that file and display it...
	header("Location: $pdffile");
	exit;
	
	
	//if it does not already exist then get the html for the lesson plan and convert it to pdf, save it and then display it	
}
else
{
	# Lesson plan type
	$type = '0trl'; //$assetinfo->getType();
	$product_id = 'ngo';
	$productid = $product_id;
	$csgtype = $type;
	$ngoproductid = "ngo";
	$ngogtype = $type;
	$giassetid = $_REQUEST['id'];

	//the 2 css files needed...grab the contents of each file and set them to variables...
	$lp2css = file_get_contents("/data/ngo1/docs/css/lp2.css");
	$ngotrcss = file_get_contents("/data/ngo1/docs/css/ngo-tr.css");
	$copyright = '
		@page {
		  @bottom-center {
			padding-bottom: 100px;
			font-size: 8pt;
			content: "Trademark and Copyright © '.date('Y').' Scholastic, Inc. All rights reserved";
		  }
		}';
		
	//make the html..  add the doctype, the metatag, the css....
	$html = "<html>
			<head>
				<style type=\"text/css\">"
				.$lp2css 
				.$ngotrcss
				.$copyright
				."</style>
			</head>
			<body>";
	
	//grab the lesson plan text asset (html) from the content server...
	$textAsset = new GI_TransText(
		array(CS_PRODUCTID	=> $productid, 
				CS_GTYPE		=> $csgtype, 
				NGO_PRODUCTID => $ngoproductid , 
				NGO_GTYPE		=> $ngogtype , 
				GI_ASSETID	=> $giassetid)
		);
	
	//if there wasnt an error grabbing the text asset...
	if (! GI_Base::isError($output = $textAsset->output()))
	{
		#$output = str_replace("src=\"", "src=\"".$basehref, $output);
		#$output = preg_replace('/src=\"(.*)\"/', 
		#		"src=\"{$basehref}$1\"",
		#		$output);
		
		require_once ($_SERVER['PHP_INCLUDE_HOME'].'ngo1/xSpaceAssets.class.php');
		$sB = new xSpaceAssets();
		$image = $sB->getParentImage($_REQUEST['id']);
		
		if($image)
		{
			$imgstr = '<div id="eduWrapper" style="margin-top: 30px">
					<img title="'.$image['ada_text'].'" alt="'.$image['title_ascii'].'" 
						src="/csimage?product_id=ngo&id='.$image['slp_id'].'&ext='.$image['fext'].'"  
						style="width: 77px; height: 73px; margin-top: 5px;" />
	                </div>';
		}
			
		$html .= preg_replace('/\<!--gf:\d*--\>/', $imgstr, $output);
		# Convert images from relative to abs path
		$html = str_replace('../images', '/images', $html);
		# Remove all links
		$html = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $html);
		
	}
	
	$html .= "</body></html>";
		
	//call the function to convert to pdf... 
	//$html - the html code that you want to convert...
	//$pdffile - the full file path and name you want the pdf to be.. (for example: "/data/ngo1/csdocs/pdf/testpdf.pdf"
	//$basehref - the base href of the server you are currently on (for example: "http://currdev.grolier.com:1120/"
	convert_to_pdf($html, $pdffile, $basehref);
	
	//after you convert to pdf..then go find the pdf you just converted...
	$pdffile = "/csdocs/pdf/".$_REQUEST['id'] .".pdf";
	$pdffile = $basehref . $pdffile;
	
	//and change the current page to be that pdf... 
	header("Location:$pdffile");
	exit;
	
}//end if