<?php

/**
 * A class managing the HitWord Highlight on the SideBar page along with sidebar page of the Lands and Peoples
 *
 *    
 */
 require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/article/GI_Factbox.php');
 class HitWord
 {
 	public $_product;
	public $_id;
 	public $_db;
 	public $_baseRef;
 	
 	public function __construct($product, $id){
 
		 
		$this->_product = $product;
		$this->_id = $id;
			 

			
		$this->_baseRef = GI_ProductConfig::getBaseHref($_SERVER['AUTH_PCODE']);
 		$this->_db = DB::connect(GI_ProductConfig::getProductDB($_SERVER['AUTH_PCODE']));
 
 
	}
	
	public function buildSidebarPage()
	{
		 if (isset($_REQUEST["queryText"]) && isset($_REQUEST["queryParser"]) && isset($_REQUEST["docKey"]))
			{

				$ttParms = array(
				GI_PRODUCTID => $this->_product,
				GI_QUERY => $_REQUEST["queryText"],
				GI_QUERYPARSER => $_REQUEST["queryParser"],
				GI_DOCKEY => $_REQUEST["docKey"],
				GI_GTYPE => '0ta',
				GI_DEST_ID => $this->_product,
				GI_DEST_TYPE => '0ta');
				 
				$myTextAsset = new GI_Highlight($ttParms);
			
			}else 
			{
				  $ttParms = array (
	                    CS_PRODUCTID    =>  $this->_product,
	                    CS_GTYPE        =>  '0ta',
	                    NGO_PRODUCTID   =>  $this->_product,
	                    NGO_GTYPE       =>  '0ta',
	                    GI_ASSETID      =>  $this->_id
	                    );
	
	   		 $myTextAsset = new GI_TransText($ttParms);
			}
			
			
			 
	    
		    if(GI_Base::isError($myTextAsset))
		    {
		    	echo "<p><b>Error in article text.</b></p>";
		    }
		    else {
		        return $myTextAsset->output();
		    }
	}
	

	}
	
 
 
 ?>