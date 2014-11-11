<html>
<head>
<style type="text/css">
/*a {
	text-decoration:none;
} */
a img {
	border:none;
}
h5.txt a {
		text-decoration:none;
		font-family: Verdana, arial, helvetica, sans-serif;
        font-size: .85em;
        margin-bottom: 0em;
        }
p.ind1 a  {font-family: Verdana, arial, helvetica, sans-serif;
         font-size: .8em;
         line-height: normal;
         /*margin-top: 0.90em;*/
          margin-left: .8em;
          text-decoration: none;
          text-align: left;
          font-weight: normal;
          display: block;
         }
p.ind2 a  {font-family: Verdana, arial, helvetica, sans-serif;
          font-size: .8em;
         line-height: normal;
          /*margin-top: 0.80em;*/
          margin-left: 1.8em;
          text-align: left;
          text-decoration:none;
          font-weight: normal;
          display: block;
       }

p.ind3 a  {font-family: Verdana, arial, helvetica, sans-serif;
          font-size: .8em;
         line-height: normal;
         text-decoration:none;
         font-style: italic;
	/*   margin-top: 0.80em;*/
          margin-left: 2.2em;
	text-align: left;
	font-weight: normal;
	display: block;
         }
</style>



<script type="text/javascript" language="javascript">
function win(articlePage){
window.opener.location.href=articlePage;
window.opener.window.scrollBy(0,-50);

}
function showTaskBar() {

  window.close();
}
function scrollYou () {
	if (window.opener && !window.opener.closed) {
		window.opener.window.scrollBy(0,-50);
	}
}

</script>
<?php


class GI_TOC {
	public $_productID;
	public $_assetID;
	public $_toc;
	public $_tocButton;
	public $_closeButton;

	public function __construct($product_id="", $assetID=""){
		require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/article/GI_TransText.php');
		if (empty($product_id)){
			$this->_productID = $_REQUEST["product_id"];
		} else {
			$this->_productID = $product_id;
		}
		$csgtype ="0tac";
		$ngoproductid = "ngo";
		$ngogtype ="0tac";
		if (empty($assetID)){
			$this->_assetID = $_REQUEST["id"];
		} else {
			$this->_assetID = $assetID."-t";
		}

		if ($this->_productID == "nbk"){
			$this->_assetID = preg_replace("/-h/","",$this->_assetID);
		}
		if ($this->_productID == "ea"){
			$this->_assetID = substr($this->_assetID,0,7)."-t";
		}
		if ($this->_productID == "ngo"){
			$this->_assetID = preg_replace("/-t/","",$this->_assetID);
			$ngoproductid = "ngotoc";
		}
		if ($this->_productID == "eto"){
			$this->_assetID = preg_replace("/-t/","",$this->_assetID);
			$ngoproductid = "etotoc";
		}
		$tocAsset = new GI_TransText(array(CS_PRODUCTID => $this->_productID,
		CS_GTYPE => $csgtype,
		NGO_PRODUCTID => $ngoproductid,
		NGO_GTYPE => $ngogtype,
		GI_ASSETID => $this->_assetID));

		$this->_toc = $tocAsset->output();
//		print_r($tocAsset);
	}

	public function buildTOCButton() {
		if (!empty($this->_toc))
	{
		$this->_tocButton = '<div class="toc"><label for="toc" class="labelHide">Table of Contents</label>
				<a href="#/" onClick=window.open("/toc?product_id='.$this->_productID.'&id='.$this->_assetID.'&type=window","TOC","width=350,height=400,left=150,top=200,toolbar=0,status=0,scrollbars=1");>Table of Contents</a></div>';
	}
	return $this->_tocButton;
}

	public function buildCloseButton(){
		$this->_closeButton = '<a style="border:0; position:fixed; bottom:0px; right:0px;;" href="#"  class="abutton" id="close" title="Close Table of Contents." onclick="javascript:showTaskBar();return false;"><img height="22px" width="70px" src="images/common/close_bttn.png"></a>';
		return $this->_closeButton;
	}

	private function oldTOC() {
		$oldTOC = '<!-- START: TOC MENU --> <div class="tocMenu">
								<a name="tocClose" id="tocClose" class="close"><img src="/images/common/toc_close.jpg" /></a>
				<!--<ul>-->
					'.$this->_toc.'
	  			<!--</ul>-->
	  							<!--<ul>
									<li><a href="#">Comets</a>
										<ul>
											<li><a href="#">Comet Sub Header 1</a></li>
											<li><a href="#">Comet Sub Header 2</a></li>
											<li><a href="#">Comet Sub Header 3</a></li>
											<li><a href="#">Comet Sub Header 4</a></li>
										</ul>
									</li>
								</ul>-->
				</div> <!-- END: TOC MENU -->';
	}
}
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/ngo1/assetInfo.php');
$assetInfo = new AssetInfo($_REQUEST["product_id"],$_REQUEST["id"]);
if ($assetInfo->getType() == "0tw"){

} else {

if (isset($_REQUEST["type"])){
	if ($_REQUEST["type"] == "window"){
		$tableOfContents = new GI_TOC();
		echo '<link href="/css/ngo.css" rel="stylesheet" type="text/css"/>';
		if ($tableOfContents->_productID !== "ngo"){
			echo '<link href="/css/ngo_'.$tableOfContents->_productID.'.css" rel="stylesheet" type="text/css"/></head><body>';
		}
		echo $tableOfContents->_toc.$tableOfContents->buildCloseButton();
		echo '</body></html>';
		//print_r($tableOfContents);
	}
	else {
		$tableOfContents = new GI_TOC($_REQUEST["product_id"],$_REQUEST["id"]);
		echo $tableOfContents->buildTOCButton();
	}
} else {
		$tableOfContents = new GI_TOC($_REQUEST["product_id"],$_REQUEST["id"]);
		echo $tableOfContents->buildTOCButton();
	}
}




?>
