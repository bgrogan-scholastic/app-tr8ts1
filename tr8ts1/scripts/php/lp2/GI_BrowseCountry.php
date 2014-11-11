<?php 

/**
 * This Class Creates the Country Browse Menu for LP2.  
 * It was created to duplicate the logic in bc_panel.html
 *
 * Name		: GI_BrowseCountry
 * @author    : Ben Robinson brobinson@scholastic.com
 * @package   : GI
 * @version   : v 1.0  07/27/2006
 */

require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Base/package.php');

Class BrowseCountry extends GI_Base {
	
	function BrowseCountry() {
	$this->_dbConn = DB::Connect( $_SERVER['DB_CONNECT_STRING'] );	
	if (PEAR::isError($dbConn)) {
		$this->raiseError('Browse Country failed to connect to the Database', 7, 2);
		}
	$this->_assetid = $_GET['assetid'];
	}
	
	//this method sets the toplevel javascript var
	//to grey out the top level continent image
	function get_toplevel() {
	$pid = $this->_get_pid($this->_assetid);
	$output = 'var toplevel = "'.$pid.'";';
	return $output;
	}
	
	function _get_pid($assetid) {
	$heir_sql = 'select hier_pid from hier where hier_cid = "'.$assetid.'"';
	$result = $this->_dbConn->getAll($heir_sql, DB_FETCHMODE_ASSOC);	
	$pid = $result[0]['hier_pid'];
	if (strlen($pid) > 1) {
		return $this->_get_pid($pid);
	} else { return $assetid; 	}
	}
	
	//this method generates the html for the country browse
	function gen_countries($assetid) { 
		
		ob_start();
		$current_country_sql = 'SELECT * FROM manifest WHERE slp_id = "'.$assetid.'"';
		$current_country = $this->_dbConn->getAll($current_country_sql, DB_FETCHMODE_ASSOC);
		//print_r($current_country);
		//$country_list_sql = "SELECT h.hier_cid, m.title_ascii country FROM hier h, manifest m
		//WHERE hier_pid = '".$current_country[0]['slp_id']."' and h.hier_cid = m.slp_id ORDER BY country ASC";
		$country_list_sql = "SELECT h.hier_cid, m.title_ent country FROM hier h, manifest m
		WHERE hier_pid = '".$current_country[0]['slp_id']."' and h.hier_cid = m.slp_id ORDER BY h.priority ASC, country ASC";
	
		$country_list = $this->_dbConn->getAll($country_list_sql, DB_FETCHMODE_ASSOC);
	
		?>
		<ul>
		<!-- current asset -->
		<li><a href="/cgi-bin/article?assetid=<?php echo $assetid; ?>"><font size="2">
		<?php echo $current_country[0]['title_ascii']; ?></font></a></li></ul><p>
		<?php
		if (count($country_list) > 0) { ?> <ul> <?php
		$i = 0;
		//iterate over country list and create the html
		do { 
			?> 
			
		<li><a href="/cgi-bin/article?assetid=<?php echo $country_list[$i]['hier_cid']; ?>">
		<font size="2"><?php echo $country_list[$i]['country']; ?></font></a></li>
		<?php
		$i++;
		} while ($i<(count($country_list)));
		?> </p></ul> <?php }
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	
	}

	function get() {
		 $output = $this->gen_countries($_GET['assetid']);
		 return $output;
	}

}