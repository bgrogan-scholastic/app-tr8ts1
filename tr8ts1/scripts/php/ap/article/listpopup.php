
<?php

/*+ ---------------------------------------------------------------
 * This is the listpopup program PHP file. NEED TO ADD DESC
 * 
 * This program expects to be called with a URL like:
 * listpopup?productid=gme&type=pictures&assetid=0307834-0&templatename=/article/listpopup.html
 *+ ---------------------------------------------------------------*/

require_once($_SERVER["PHP_INCLUDE_HOME"] . "/common/utils/hash.php");


class Page {

	function Page(){
		$this->links = array();
		$this->readLinkFileContents();
	}
	
	function readLinkFileContents() {
		$filename = $_GET['assetid'] . '_' . $_GET['type'] . '.html';
		$hash     = new GI_Hash($_SERVER["TEXT_CACHE_HOME"]);
		
		$fp       = fopen($hash->get($filename), r) or 
			die("Unable to open file: $filename");
		$file_length = filesize($hash->get($filename));
		
		while (!(feof($fp))) {
			$this->links[] = fgets($fp, $file_length);
		}
		
		fclose($fp);
	}
	
	function banner() {
		return $_GET['productid'] . "pop_title.gif"; 
	}

	function links() {
		foreach ($this->links as $link) {
			print $link . '<br>';
		}
	}

} 

$page = new Page;
require($_SERVER['TEMPLATE_HOME'] . $_GET['templatename']);

?>
