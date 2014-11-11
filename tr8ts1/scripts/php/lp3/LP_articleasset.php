<?php
 
/**
 * A class managing the 'articleAsset' on the article page of the Lands and Peoples
 *
 *    7/08/10
 */


class articleAsset {
	/**
	*
	* @param $_productID
	* @access public
	*/
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

	//************************************************************************
	//							Build the article					   		//
	//************************************************************************
 
	public function buildArticle(){

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

	}//end BuildArticle

	
 	//************************************************************************
	//						retrieve Facts n Figures html			   		//
	//************************************************************************
	public function buildLeftNav_HTML(){

 
	$buttonSLP[0]['name']='africa';
	$buttonSLP[0]['id']='4041200';	
	
	$buttonSLP[1]['name']='arctic';
	$buttonSLP[1]['id']='4064955';
		
	$buttonSLP[2]['name']='asia';
	$buttonSLP[2]['id']='4046800';	
	
	$buttonSLP[3]['name']='australia';
	$buttonSLP[3]['id']='4052300';
		
	$buttonSLP[4]['name']='islands';
	$buttonSLP[4]['id']='4061800';
	
	$buttonSLP[5]['name']='c_america';
	$buttonSLP[5]['id']='4064900';		
	
	$buttonSLP[6]['name']='europe';
	$buttonSLP[6]['id']='4054400';	
	
	$buttonSLP[7]['name']='n_america';
	$buttonSLP[7]['id']='4060200';	
	
	$buttonSLP[8]['name']='oceania';
	$buttonSLP[8]['id']='4052600';
	
	$buttonSLP[9]['name']='s_america';
	$buttonSLP[9]['id']='4064950';	

	
 $world=<<<EOT
 
 <!-- world -->
 <tr>
	 <td colspan="3">
 		<a href="/article/4101426" onMouseOver="doMouseOverButton('world');"onMouseOut="doMouseOutButton('world');">
 		<img src="/images/encyc/world_blue.gif" border="0" name="world" alt="world" ></a>
 	</td>
 </tr>
 
EOT;
echo $world;

 
		for ($i = 0; $i < count($buttonSLP); $i++) {
		    
		    	$buildLeftNav_HTML.= '<!-- '.$buttonSLP[$i]['name'].' -->';
		    	$buildLeftNav_HTML.= '<tr>';
				$buildLeftNav_HTML.= '<td colspan="3">';
				$buildLeftNav_HTML.= '<a href="/article/'.$buttonSLP[$i]['id'].'" onMouseOver="doMouseOverButton(\''.$buttonSLP[$i]['name'].'\');"';
				$buildLeftNav_HTML.= 'onMouseOut="doMouseOutButton(\''.$buttonSLP[$i]['name'].'\');">';
				$buildLeftNav_HTML.= '<img src="/images/encyc/'.$buttonSLP[$i]['name'].'_blue.gif" border="0" name="'.$buttonSLP[$i]['name'].'" alt="'.$buttonSLP[$i]['name'].'"></a>';
				$buildLeftNav_HTML.= '</td>';
				$buildLeftNav_HTML.= '</tr>';
				
				
		}
		
		return $buildLeftNav_HTML;
		
		 
	}//end factsNfigures_slpid	
	
	
	 
	
}


?>