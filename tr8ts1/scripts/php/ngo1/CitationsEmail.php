<?php

require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/utils/GI_Citation.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . "common/article/GI_Content.php");

/**
 * Class CitationsEmail
 * Class file Created to generate Citaions for the Email functionality in Article Page.
 */

class CitationsEmail{
	/**
	 * Database Host String
	 *
	 * @var _db 
	 */
	private $_db;
	/**
	 * Product Databse
	 *
	 * @var _productDB
	 */
	private $_productDB;
	/**
	 * Datasource RPS or LEGACY
	 *
	 * @var _dataSource
	 */
	private $_dataSource;
	/**
	 * ProductId
	 *
	 * @var productID
	 */
	private $_productID;
	/**
	 * Mainext
	 *
	 * @var _mainext
	 */
	private $_mainExt;
	/**
	 * Enter description here...
	 *
	 * @var related
	 */
	private $_related;
	/**
	 * Enter description here...
	 *
	 * @var assetID
	 */
	private $_assetId;
	
	/**
	 * Enter description here...
	 * To retrieve citation information.
	 */
	public function __construct(){
		
		$usePFEurl = true;
		
		$this->_assetId = $_REQUEST['id'];
		
		if(!isset($_REQUEST['product_id'])){
			$product_Id = $_COOKIE['productid'];
		}
		else 
			$product_Id = $_REQUEST['product_id'];
		
		if($product_Id == 'eto')
		{
			$product_Id = 'ngo';
		}
		
		$this->_productID  = $product_Id;
		$this->_productDB = $this->setProductDB();
		$this->_dataSource = $this->isRPS();
		$this->getAssets();
		
		if ($this->_productID != "ngo")
		{
			if ($this->_dataSource == "RPS")
			{
				$rpsFlag = true;
			}
			else
			{
				$rpsFlag = false;
			}
			
			$mlaCitation = new MLA_Citation($usePFEurl, $this->_productDB, $rpsFlag);
			$mlaCitation = $mlaCitation->cite();
			$apaCitation = new APA_Citation($usePFEurl, $this->_productDB, $rpsFlag);
			$apaCitation = $apaCitation->cite();
			$chicagoCitation = new Chicago_Citation($usePFEurl, $this->_productDB, $rpsFlag);
			$chicagoCitation = $chicagoCitation->cite();
			
		}
		else
		{
			
			for ($i=0; $i < sizeof($contribA); $i++)
			{
				list($authors[$i][LAST_NAME],$authors[$i][FIRST_NAME])= explode(",",$contribA[$i][1]);
				$authors[$i][INITIALS] = substr($authors[$i][FIRST_NAME],0,2);
				
			}
			for ($i=0; $i < sizeof($contribR); $i++)
			{
				list($reviewers[$i][LAST_NAME],$reviewers[$i][FIRST_NAME])= explode(",",$contribR[$i][1]);
				$reviewers[$i][INITIALS] = substr($reviewers[$i][FIRST_NAME],0,2);
				
			}
			
			$mlaCitation = new MLA_Citation($usePFEurl, $this->_productDB);
			$mlaCitation = $mlaCitation->newCite($this->_mainExt["title"], $authors, $reviewers);
			$apaCitation = new APA_Citation($usePFEurl, $this->_productDB);
			$apaCitation = $apaCitation->newCite($this->_mainExt["title"], $authors, $reviewers);
			$chicagoCitation = new Chicago_Citation($usePFEurl, $this->_productDB);
			$chicagoCitation = $chicagoCitation->newCite($this->_mainExt["title"], $authors, $reviewers);
			
		}
		echo  $mlaCitation.'<br><br>'.$apaCitation.'<br><br>'.$chicagoCitation;
		echo  '	<p> <b>Source: '.$this->getSource($product_Id).'</b>';
	}
	/**
	 * Get the Database Host String based on Product ID
	 *
	 * @return unknown
	 */
	
	public function setProductDB(){
		$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($db)) {
			echo "Error:  Could not retrieve mysql connect string for $this->_productid";
		}
		else {
			$sql = sprintf("select value from appenv where app='{$this->_productID}' and key_name='product_db';");
			$result = $db->query($sql)->fetchrow();
			$this->_productDB = $result[0];
			if($this->_rpsFlag == "LEGACY"){
				$sql = sprintf("select value from appenv where app='go' and key_name='product_db';");
				$result = $db->query($sql)->fetchrow();
				$this->_goDB = $result[0];
				return $this->_goDB;
			}
			else {
				return $this->_productDB;
			}
			$db->disconnect;
		}
	}
	/**
	 * Check if the Product is RPS or Legacy product
	 *
	 * @return unknown
	 */
	private function isRPS(){
		$dataSource;
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print  "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
		if(isset($this->_productID))
		{
			$sql = sprintf("select isRPS from product_map where productid='{$this->_productID}';");
			$result = $db->query($sql)->fetchrow();
			$dataSource = ($result[0]==1) ? "RPS" : "LEGACY";
			$db->disconnect;
		}
		return $dataSource;
	}
	/**
	 * Function to get the Asset deatils like Title 
	 *
	 */
	private function getAssets(){
		if(isset($this->_dataSource))
		{
			if($this->_dataSource == "RPS")
			{
				$mainSQL = "Select fext,credit,title_ent as title,caption_id as caption,type from manifest "
					. "where slp_id = '{$this->_assetId}';";
				$assetSQL = " select c.slp_id as assetID, c.title_ent as title, "
					. "c.fext as ext, c.type, c.uid, c.ada_text, c.priority from manifest c "
					. "inner join manifest p on p.uid = c.puid and p.slp_id = '{$this->_assetId}' order by c.type desc,c.priority;";
				
			}
			else
			{
				$mainSQL = "Select fext,title,type from assets where id = '{$this->_assetId}';";
				$assetSQL = "select c.id as assetID, c.title as title, c.fext as ext, c.type "
					. "from assets c inner join relations p on p.child_id = c.id "
					. "where p.parent_id ='{$this->_assetId}'";
			}
			$this->_db = DB::connect($this->_productDB);
			if (DB::isError($this->_productDB))
			{
				echo "Error: Could not connect to $this->_productID database!!!";
			}
			$this->_related = $this->_db->getall($assetSQL, DB_FETCHMODE_ASSOC);
			$this->_mainExt = $this->_db->getall($mainSQL,DB_FETCHMODE_ASSOC);
			$this->_mainExt = $this->_mainExt[0];
			$_numRows = $this->_db->query($assetSQL)->numRows();
		}
	}
	/**
	 * Function getSource
	 * return source.
	 * @param unknown_type $product_id
	 * @return unknown
	 */
	
	public function getSource($product_id){
		$ptitle_string= "Select description from products where product_id='".$product_id."'";
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print  "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
		$pTitle = $db->getOne($ptitle_string);
		return $pTitle;
	}
}
$citation = new CitationsEmail();


?>