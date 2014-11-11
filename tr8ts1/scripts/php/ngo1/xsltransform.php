<?php 
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');   
require_once($_SERVER['PHP_INCLUDE_HOME'] .'common/utils/GI_Hash.php');
/**
 *  
 * @Name	: CS_XsltTransform
 * @Author	: Tanmay Joshi tjoshi-consultant@scholastic.com
 * 
 * @version : Created on 2008-07-17
 * @return 	: string
 */
class CS_XsltTransform extends GI_BASE {
	/**
	 * xml_file. xmlfile to be loaded, should be with the complete path
	 * @access protected
	 *
	 * @var string
	 */
	protected $xml_file;
	/**
	 * xsl_file. xsl file to be loaded, should be with the complete path
	 * @access protected
	 *
	 * @var string
	 */
	protected $xsl_file;
	/**
	 * 
	 * Contructor
	 *
	 * @param  : array $parms XML_FILE AND XSL_FILE
	 * @return : none
	 */
	public function __construct($parms){
		/**
		 * intialize the parent constructor to handle error
		 */
		parent::__construct();
		/**
		 * intialize the xml and xsl file variables
		 */
		$this->xml_file = $parms['XML_FILE'];
		$this->xsl_file = $parms['XSL_FILE'];

		
	}
	/**
	 * Does the transformation. If transformation is successful it will return the transformed string
	 * If there is an error, it will return an error Object
	 * 
	 * @access public
	 *
	 * @return string /  object
	 */
	public function xslttransform(){
	error_log("-------1")	;
		if((file_exists($this->xml_file))&&(file_exists($this->xsl_file))){
		error_log("-------2")	;				
			$xp = new XSLTProcessor();
			// get the content of xml file to a string
			$source_xml = @file_get_contents($this->xml_file);			
			if(empty($source_xml))
				return $this->_raiseError('XML FILE IS EMPTY, FILE: '.$this->xml_file.' FILE !!!',3,1);			


			$source_xml = str_ireplace('xmlns="http://omega/products/epiccustom/doctypes/ngo"','',$source_xml);
			$xml_doc = new DOMDocument();
			if(!$xml_doc->loadXML($source_xml)){
				echo "error1";
				error_log("-------4")	;
				return $this->_raiseError('ERROR LOADING XML '.$this->xml_file.' FILE !!!',3,1);
			}
				
			$xsl = new DOMDocument();
			if(!$xsl->load($this->xsl_file)){
				echo "error2";
				return $this->_raiseError('ERROR LOADING XSL '.$this->xsl_file.' FILE !!!',3,1);			error_log("-------5")	;
				
			}
			$xp->importStylesheet($xsl); error_log("-------6")	;
			
			if($output = $xp->transformToXml($xml_doc)){
				return $output;
			}else{
				echo "Import Style sheet";
				return $this->_raiseError('Error occured during the transformation of xml / xsl',3,1);
			}
		}else{
			if(!file_exists($this->xml_file)){
			  echo "XML File doesnot Exist";
			}
			if(!file_exists($this->xml_file)){
			   echo "XSL File doesnot Exist";
			}
			return $this->_raiseError('XML OR XSL file doesnt exists for transformation !!!',3,3);			
			}
	}
}

$id = $_REQUEST['id'];
//$xslfile = '/data/ngo1_gi/config/xslt/xspaceblurb.xsl';
$xslfile = $_SERVER['CONFIG_HOME']."xslt/xspaceblurb.xsl";
$binaryAsset = new GI_BinaryAsset(array(
			CS_PRODUCTID => 'ngo',
			GI_ASSETID => $_GET['id'],
			'fext' => 'xml'	
			)
			);
			if(GI_Base::isError($binaryAsset)) {
				echo "Error";
				$GLOBALS["errorManager"]->reportError($binaryAsset);
				$GLOBALS["fatalerror"]=TRUE;
			}
			
			if(isset($_SERVER['CS_DOCS_ROOT'])){
				$documentRoot = $_SERVER['CS_DOCS_ROOT'];
			}else{
				$documentRoot = $_SERVER['DOCUMENT_ROOT'];	
			}
$xmlfile = $documentRoot.$binaryAsset->getUrlPath();

$xsltrans = new CS_XsltTransform(array(@XML_FILE=>$xmlfile,@XSL_FILE=>$xslfile));
//print_r($xsltrans);
	if(GI_Base::isError($html = $xsltrans->xslttransform())) {
		// do what you wann do when there is an error while conversion... any messages or just raise an error!!!
		echo " XSLT transform error";	
	}else{
		//alert($html);
		print_r($html);
}
?>



