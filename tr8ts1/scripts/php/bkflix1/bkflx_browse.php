<?php 

class bkflx_browse {
	
 	public function __construct() { 	
 		
 		$this->_db = new mysqli('localhost', 'bkflix1', 'bkflix1', 'bkflix1');
 		$this->_cats = array();
 		$this->_links_titles = array();
 		$this->_links = array();
 		//$this->get_cats();
 	}
	 
	public function return_error() {
		
		return mysqli_error($this->_db);
		
	}
 
	public function get_cats() {
		
		$this->_catquery = 'select cb2.node_title, cb2.cid, m2.slp_id, m2.title_ascii, m2.uid from category_browse cb2, category_browse cb, manifest m, manifest m2 where m.type = "0p" and cb.cid = m.slp_id and m.uid = m2.puid and m2.type = "0ta" and m2.language = "en" and cb2.cid = cb.pid order by cb2.node_title, m.title_ascii';
		
		$result = $this->_db->query($this->_catquery) or die($this->return_error());
 		while ($row = mysqli_fetch_row($result)) {
 			array_push($this->_cats, $row); 
 			//$this->_cats[$row[1]] = array($row[0], $row[2]);
 		} return $this->_cats;
 			
 	}
 	
 	public function gen_links($type='0ta') { 
 		
 		$this->get_cats();
 		//$link_html_pre = '<br><a href="http://currdev.grolier.com:1133/b/';
 		$link_pre = 'http://currdev.grolier.com:1133/b/';
 		$out['cats'] = $this->_cats;
 		foreach ($this->_cats as $key=>$value) {
 			   		//$link_post = '">'.$value[0].' - '.$value[3].' </a>';
 			 		$slp_id = $value[2];
 			 		$title = $value[0].' - '.$value[3];
 					array_push($this->_links, $link_pre.$value[1].'/'.$value[4].'/'.$slp_id);
 					array_push($this->_links_titles, $title);
 					//return $value;
 				}
 			 			
 		//for debug, return this
 		$out['links'] = $this->_links;
 		//return $out;
 		//return $this->_links_titles;
	
	}
	
	public function gen_nav() {
		
		$this->gen_links();
		
		$js = '<script type="text/JavaScript">';
		$js .= "\n<!--\n\n function go_menu(obj){ \n ";
		$js .= "window.location=obj.options[obj.selectedIndex].value;\n}\n\n/-->\n\n</script>\n\n";
		
		$menu_html = '<select name = "links" onchange="go_menu(this)">';
    	$menu_html .= '<option selected value="">Select Another Pair here</option>';
    	foreach ($this->_links as $key=>$value) {
    		$menu_html .= '<option value="'.$value.'">'.$this->_links_titles[$key].'</option>';
    		$menu_html .= "\n";
    	}
    	
    	$menu_html .= '</select>';
      
      return $menu_html;
    	  	
	}

}
	
?>