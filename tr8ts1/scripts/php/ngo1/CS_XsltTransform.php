<?php 
//require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/cs/server/CS_Server.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
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
	
		if((file_exists($this->xml_file))&&(file_exists($this->xsl_file))){
		
			$xp = new XSLTProcessor();
			//register any php functions associated in the xsl
			$xp->registerPhpFunctions();
			// get the content of xml file to a string
			$source_xml = @file_get_contents($this->xml_file);			
			if(empty($source_xml))
				return $this->_raiseError('XML FILE IS EMPTY, FILE: '.$this->xml_file.' FILE !!!',3,1);			

			// remove the xmlns from xml string
			 
			if($_GET['product_id']=='ngo'){
			$source_xml = str_ireplace('xmlns="http://omega/products/epiccustom/doctypes/ngo"','',$source_xml);
			}else{
				
				$source_xml = str_ireplace('xmlns="http://omega/products/epiccustom/doctypes/eto"','',$source_xml);
			}
		         //echo $source_xml;	
			/**
			 * Open XMLEntityReplace.txt file and get all entities and unicode in an array $html_ent_table;
			 */
			$entities_file_handle = fopen("$_SERVER[CONFIG_HOME]XMLEntityReplace.txt", "r");

       		if ($entities_file_handle === FALSE) {
              echo "Failed: Entities file (XMLEntityReplace.txt) not opened\n\n";
              exit;
	       }

	       while (!feof($entities_file_handle))
	       {
              $buffer = trim(fgets($entities_file_handle));
              $pos = strpos($buffer, '|');
              if( ! ($pos === FALSE) )
              {
	              $pieces = explode("|", $buffer);
                  if ( $pieces[1] == '' )
                      $pieces[1] = ' ';
                  $html_ent_table[$pieces[0]] = $pieces[1];
              }
		   }
		   //replace any entities present in the xml string
			$encoded = strtr($source_xml,$html_ent_table);
			/* commented on 29th july 2008 by tanmay 
			*  it is not needed now as we are using XMLEntityReplace.txt file which contains all Entities
			*	// catch any entities if present in the xml document and cover it in CDATA BLOCK
			*   $encoded = preg_replace("/(\&)(\D.+?)(;)/","<![CDATA["."\\1\\2\\3"."]]>",$source_xml);
			*/	
			
			 
				
		$xml_doc = new DOMDocument();
			if(!$xml_doc->loadXML($encoded)){
				return $this->_raiseError('ERROR LOADING XML '.$this->xml_file.' FILE !!!',3,1);
			}
			$xsl = new DOMDocument();
			if(!$xsl->load($this->xsl_file))
				return $this->_raiseError('ERROR LOADING XSL '.$this->xsl_file.' FILE !!!',3,1);			
				$xp->importStylesheet($xsl); 
			if($output = $xp->transformToXml($xml_doc)){
				
				return $output;
			}else{
				return $this->_raiseError('Error occured during the transformation of xml / xsl',3,1);
			}
		}else{
			return $this->_raiseError('XML OR XSL file doesnt exists for transformation !!!',3,3);			
			}
	} 
	/*public function xslttransform(){
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
	} */
}
?>
