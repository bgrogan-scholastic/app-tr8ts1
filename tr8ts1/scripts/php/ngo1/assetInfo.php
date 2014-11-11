<?php
require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
 

/*  
  * Name       : assetInfo
  * @author    : Claire Dunn
  * @version   : v 1.0  09-03-2008
  * @param     : id, product_id
  * @return    : 
  *  
  */

 
 
 
 /**
  * Class: AssetInfo 
  * Class to get information on legacy assets 
  */

 
 class AssetInfo extends GI_Base{
	
	/**
	 * Declare variables
	 *
	 */
	
	protected $_gtc;
	protected $_title;
	protected $_lexile;
	protected $_readinglevel;
	protected $_productid;	
	public	  $_rpsFlag;
	public  $_productDB;
	protected $_goDB;
	protected $_assetid;
        protected $_language;	
    public $_mainTitle;
	
	/**
	 * Constructor : 
	 * 
	 * @param 
	 */
	
	public function __construct($product_id, $assetid){

		$this->_productid = $product_id;
		$this->_assetid = $assetid;
	       	
		
		
		// Check if this is an RPS productor LEGACY
		$this->_rpsFlag = $this->isRPS();
		
		
		//Get the connect string for this product's database and go database (for legacy)
		$this->setProductDB();
		// Get asset's info from product's databases
		$this->getAssetInfo();
		
		// For test purposes
		//echo $this->_productid . ": " .$this->_rpsFlag . ": ". $this->_title .  ": ". $this->_lexile .  ": ". $this->_gtc . "<br>";
		
	}
    
	/**
     * Function: isRPS()
     *
     * @return RPS or LEGACY (for non-rps products)
     * 
     */
	private function isRPS(){
		
		$dataSource;
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
				print  "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
			}

		if(isset($this->_productid))
		
				{
					
				$sql = sprintf("select isRPS from product_map where productid='{$this->_productid}';");
					$result = $db->query($sql)->fetchrow();
				$dataSource = ($result[0]==1) ? "RPS" : "LEGACY";
				//$db->disconnect();
				}
				
		if(isset($dataSource))
			return $dataSource;
		else 
			return;
	}
	
	/**
     * Function: setProductDB()
     *
     * @return 	productDB
     */
	public function setProductDB(){
	 
    	
    	$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
    	//$connect_string =  'mysql://appenv:appenv@currdev.grolier.com/appenv';
    	//$db = DB::connect($connect_string);
    	if (DB::isError($db)) {
        	  echo "Error:  Could not retrieve mysql connect string for $this->_productid";
    	}
    	else {
    		$sql = sprintf("select value from appenv where app='{$this->_productid}' and key_name='product_db';");
    		$result = $db->query($sql)->fetchrow();
    		$this->_productDB = $result[0];
    		
    		
    		if($this->_rpsFlag == "LEGACY"){
    		
	    		$sql = sprintf("select value from appenv where app='go' and key_name='product_db';");
    			$result = $db->query($sql)->fetchrow();
    			$this->_goDB = $result[0];
    			/*echo $this->_goDB;*/
    		    return $this->_goDB;
    		}
    		else {
    		return $this->_productDB;
    		}
    		$db->disconnect();
    	}
    	
    	
	}
	
	
	
	
	/**
     * Function: getAssetInfo()
     *
     * @return title
     */
	private function getAssetInfo(){
		$title ="";
		// RPS Products
		 
		if($this->_rpsFlag == "RPS"){

			$db = DB::connect($this->_productDB);
	    	if (DB::isError($db)) {
    	    	  print  "connection to {$this->_productDB} failed ";
    		}
			else {


			/*** If this product contains spanish articles, we need to get the language from manifest***/
			if(($this->_productid == 'nec') || ($this->_productid == 'ngo')) {	
    			$sql = sprintf("select title_ent, type, lexile,language from manifest where slp_id='{$this->_assetid}';");
    			}	

//			/*** Some RPS products don't yet have a lanugage field in the manifest ***/
			else{
			 $sql = sprintf("select title_ent, type, lexile from manifest where slp_id='{$this->_assetid}';");
			}
			

			$result = $db->query($sql)->fetchrow();

	    		$this->_title = $result[0];
	    		$this->_mainTitle = $result[0];
	    		 
	    		$this->_gtc = $result[1];
	    		$this->_lexile = $result[2];
			$this->_language = 'en';	
			if(($this->_productid == 'nec') || ($this->_productid == 'ngo')) {

				$this->_language = $result[3];
			}	

    		
       			//$db->disconnect();
			}
		}
		
		// LEGACY Products
		else {

			if($this->_rpsFlag == "LEGACY"){
	
				$db = DB::connect($this->_productDB);
	    		if (DB::isError($db)) {
    	    		  print  "connection to {$this->_productDB} failed ";
    			}
				else {
    				$sql = sprintf("select title, type from assets where id='{$this->_assetid}';");
    				$result = $db->query($sql)->fetchrow();
	    			$this->_title = $result[0];
	    			$this->_gtc = $result[1];
				$this->_language = 'en';
       				$db->disconnect();
				}
				$lexDb = DB::connect($this->_goDB);
			
				
	    		if (DB::isError($lexDb)) {
    	    		  print  "connection to {$this->_goDB} failed ";
    			}
				else {
					$sql = sprintf("select measure from lexile where id ='{$this->_assetid}';");
    				$result = $lexDb->query($sql)->fetchrow();
    				$this->_lexile = $result[0];
				}
			}		
		}
		
	}
	
	/**
     * Function: getTitle()
     *
     * @return title
     */
	public function getTitle(){

		return $this->_title;

	}
	
	/**
     * Function: getLexile()
     *
     * @return lexile
     */
	public function getLexile(){
		return $this->_lexile;
	}
	

	/**
     * Function: getRPS()
     *
     * @return lexile
     */
	
	public function getRPS(){
		return $this->_rpsFlag;
	}
	
	     /**
     * Function: getLanguage()
     *
     * @return language
     */
        public function getLanguage(){
                return $this->_language;
        }


	/**
     * Function: getType()
     *
     * @return lexile
     */
	public function getType(){
		return $this->_gtc;
	}
	
	/**
     * Function: getReadingLevel()
     *
     * @return readinglevel
     */
	public function getReadingLevel() {
		$this->getLexile();
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
	    	if (DB::isError($db)) 
	    	{
    	    	  print  "connection to {$this->_productDB} failed ";
    		}
			else 
			{
			
				if($this->_lexile != null){				
    			$sql = "select reading_level from readinglevel where lexile_begin <={$this->_lexile} and lexile_end >= {$this->_lexile};";
    			$result = $db->getOne($sql);
    			$this->_readinglevel = $result;  	
				}
				else $this->_readinglevel = 0;
			}
			
		return $this->_readinglevel;
	}
}
?>
