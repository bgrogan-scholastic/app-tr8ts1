<?php
require_once('DB.php');
/**
 * Class file to fetch Image name and extension based in Global product type
 *
 */

class getIcons{
	/**
	 * Database variable
	 *
	 * @var unknown_type
	 */
	protected $_db;
	/**
	 * Image File variable
	 *
	 * @var Image File
	 */
	protected $_imageTitle;
	
	protected $_imageFile;
	/**
	 * Constructor
	 *
	 * @param unknown_type $gtc
	 */
	public function __construct($gtc,$size = 'S'){
		
		 
		 
		//get connect string based from APPENV for the NGO product
			$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
			if (DB::isError($db)) {
				echo "Error:  Could not retrieve mysql connect string for 'NGO'";
			}
			else {
				$sql = sprintf("select value from appenv where app='ngo' and key_name='product_db';");
				$result = $db->query($sql)->fetchrow();
				$db->disconnect();
				$DB_CONNECT_STRING=$result[0];
			}
 
	 

		
		$this->_db = DB::connect($DB_CONNECT_STRING);

		if (DB::isError($this->_db)) {
			print "connection to {$DB_CONNECT_STRING} failed ";
		}
		$sql = sprintf("select icon_name, ext, icon_title from icons where gtc ='".$gtc."' and icon_size='".$size."'");
		$icons = $this->_db->getRow($sql);
		$this->_imageTitle =$icons[2];
		$this->_imageFile = $icons[0].".".$icons[1];
	}
	/**
	 * Return ImageFile
	 *
	 * @return Image File
	 */
	
	public function getImage(){
		return $this->_imageFile;
	}
	
	public function getTitle(){
		return $this->_imageTitle;
	}
}
//$icon = new getIcons('0ta','png');
?>