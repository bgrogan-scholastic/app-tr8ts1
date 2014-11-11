<?php
//Author: Diane K. Palmer
//Date: March 31, 2009
// 11/11/2009: R.E. Dye - Making an 0cp version for allflix.
// 3/23/2010: R.E. Dye - Doing a bit of tweaking to handle errors and multiple servers.

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set("memory_limit","512M");
define('DEBUG_MODE', false);

//include these two files for the pdf generation
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/config.inc.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/pipeline.factory.class.php');


require_once($_SERVER['PHP_INCLUDE_HOME'].'allflix1/collective/PairCollectiveHandler.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php'); 
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_TextAsset.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_CSdetagger.php');


//need a database connection to get the basehref for this server..
require_once ('DB.php');

# Don't really need this anymore.
$basehref='';

//connect to the datavase
#$db = DB::connect("mysql://appenv:appenv@localhost/appenv");
#if (DB::isError($db)) {
#	exit("Error encountered: " . $resultMysql->getMessage()); 
#}
#else {	
	//grab the basehref for this server
#	$appenvqry = "select value from appenv where app='bkflix1' and key_name='basehref';";
#	$appenvresult =  & $db->query($appenvqry);	
#	$approw = $appenvresult->fetchRow(DB_FETCHMODE_ASSOC);
#	$basehref = $approw['value'];		
#}

//if you want to see what errors are coming out, then uncomment this
//error_reporting(E_ALL);

//this needs to be included for pdf generation.
//ini_set("display_errors","1");
@set_time_limit(10000); 
parse_config_file($_SERVER['PHP_INCLUDE_HOME'] . 'common/pdf/html2ps.config');


//this class is needed for pdf generation..just copy and paste this into your own code..
/**
 * Handles the saving generated PDF to user-defined output file on server
 */
class MyDestinationFile extends Destination {
	/**
	 * @var String result file name / path
	 * @access private
	 */
	var $_dest_filename;
	
	function MyDestinationFile($dest_filename) {
		$this->_dest_filename = $dest_filename;
	}
	
	function process($tmp_filename, $content_type) {
		copy($tmp_filename, $this->_dest_filename);
	}
}

class MyFetcherMemory extends Fetcher {
	var $base_path;
	var $content;
	
	function MyFetcherMemory($content, $base_path) {
		$this->content   = $content;
		$this->base_path = $base_path;
	}
	
	function get_data($url) {
		
		
		if (!$url) {
			return new FetchedDataURL($this->content, array(), "");
		} else {
			// remove the "file:///" protocol
			if (substr($url,0,8)=='file:///') {
				$url=substr($url,8);
				// remove the additional '/' that is currently inserted by utils_url.php
				if (PHP_OS == "WINNT") $url=substr($url,1);
			}
			
			# Since it's file_get_contents(), let's just refer to a local path
			$url = str_replace('http://localhost/', '', $url);
			$url = '/data/bkflix1/docs/'.$url;
			
			#echo 'fetching '.$url; 
			return new FetchedDataURL(file_get_contents($url), array(), "");
		}
	}
	
	function get_base_url() 
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
function convert_to_pdf($html, $path_to_pdf, $base_path='') {
	$pipeline = PipelineFactory::create_default_pipeline('', // Attempt to auto-detect encoding
			'');
	
	// Override HTML source 
	// @TODO: default http fetcher will return null on incorrect images 
	// Bug submitted by 'imatronix' (tufat.com forum).
	$pipeline->fetchers[] = new MyFetcherMemory($html, $base_path);
	
	// Override destination to local file
	$pipeline->destination = new MyDestinationFile($path_to_pdf);
	
	$baseurl = '';
	$media =& Media::predefined('A4');
	$media->set_landscape(false);
	$media->set_margins(array('left'   => 1,
				'right'  => 1,
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

function download_pdf($inPDFID)
{
	global $basehref;
	
	#if(DEBUG_MODE == false)
	#{
		#header('Content-disposition: attachment;');
		#header('Location: ' . $basehref . '/pdf/' . $inPDFID . '.pdf');
	#}

	# 3/23/2010: R.E. Dye - replacing the redirect with a direct dump of the file
	# to the user's browser.
    header("Content-type: application/pdf");
    readfile($_SERVER['CS_DOCS_ROOT'] . '/pdf/' . $inPDFID . ".pdf");

}





# Main app starts here...





//////////////////////////////////////////////////////////////////////////////
//the file path for the pdf file the user wants to see..if this is the first time viewing this pdf then this will be the filename that the pdf generator will use when generating the pdf.  if its not the first time
//then we will grab the pdf from the server and display it.

	$slp_id = GI_getvariable(GI_ASSETID);

	// Create a PairCollective Handler object for the pair.
    $collective = new PairCollectiveHandler();
    @$collective->load_asset($slp_id, 'allflix');

    if (GI_Base::isError($collective)) {
        echo "Error creating pair 0cp handler - $slp_id.";
        $GLOBALS['fatalerror'] = TRUE;
    }
    else {

        $lessonPlanId = $collective->getLessonPlanId() . "";

        $pdffile = $_SERVER['CS_DOCS_ROOT'] . "/pdf/".$lessonPlanId .".pdf";

        //check to see if this pdf file already exists...
        if(file_exists($pdffile) == true && DEBUG_MODE == false)
        {
        	download_pdf($lessonPlanId);
        	exit;
	
        	//if it does not already exist then get the html for the lesson plan and convert it to pdf, save it and then display it	
        }else{
	
	
        	/*
        	 * All of the stuff for the lesson plan now
        	 *
        	 */
	
        	ob_start();
	
        	# initialize the error manager
        	$errMgr =& GI_ErrorManager::getInstance();
        	$GLOBALS["errorManager"] =& $errMgr;
        	$buildresult = GI_BUILD_STATUS_SUCCESS;
        	$GLOBALS["fatalerror"] = FALSE;
	

        	$theUrlPath;

        	$PairTitle = $collective->title;

        	$textAsset = new GI_TextAsset(array(
        				'isreplaceable' => false,
        				CS_PRODUCTID => 'allflix',
        				GI_ASSETID => $lessonPlanId,
        				)
        		);
	
        	if(GI_Base::isError($textAsset)) {
        		$GLOBALS["errorManager"]->reportError($textAsset);
        		$GLOBALS["fatalerror"]=TRUE;
        	} else {
        		$LPText = $textAsset->output();
        	}

        	$SJacketSLPID = $collective->getStoryCoverId();
        	$BJacketSLPID = $collective->getBookJacketId();

        	$configarray = array(
        			'GILINK' => array(
        				format => '##DATA##'
        			)
        		);
		
        	$myDetagger = new GI_CSdetagger($configarray);
        	$parsedcontent = $myDetagger->parse($LPText);
        	ob_end_clean();
        	ob_start();
        	$css = file_get_contents($_SERVER['DOCS_ROOT'] . '/css/bkflix.css');


# -html2ps-html-content: "Trademark and Copyright © '.date('Y').' Scholastic, Inc. All rights reserved";
# -html2ps-html-content: "&#8482; &amp; &copy; '.date('Y').' Scholastic Inc. All rights reserved.";

            // Looks like you need to leave off the closing semicolon on HTML entities, in order to get
            // them to work properly!

        	$copyright = '
        		@page {
        		  @bottom-center {
        			padding-bottom: 100px;
        			font-size: 8pt;
        			-html2ps-html-content: "&#8482 &amp &copy ' . date('Y') . ' Scholastic Inc. All rights reserved.";
        		  }
        		}';
	
        	$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html><head><style type=\"text/css\"> $css body { background: #FFF; font-family: Garamond, \"Verdana\"; font-size: 105% }  $copyright </style></head><body>";
	
        	$html .= '<table border="0">
        			<tr><td colspan="2" align="center"><img src="/images/Scholastic_logo.png" /></td>
        			<tr>
        			<td valign="top" align="center" width="25%"><img src="/images/BookFLIX_logo.png" /></td>
        			<td valign="top">'
        		.$parsedcontent
        		.	'</td>
        			</tr>
        			</table>';
	
        	$html = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $html);
        	$html .= "</body></html>";
	
        	#$pdffile = "/data/csdocs/pdf/".$_REQUEST['id'] .".pdf";
        	ob_end_clean();
	
        	convert_to_pdf($html, $pdffile, $basehref);
	
        	//after you convert to pdf..then go find the pdf you just converted...
	
	
        	download_pdf($lessonPlanId);
        }
    }
?>
