<?php

$format_level_1 = $_GET['type'] == "profiles" ? '<br><a name="%s"></a><a href="#pres">Presidents</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#vicepres">Vice Presidents</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#ladies">First Ladies</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#dates">Candidates</a>
<h2 class="icategories">%s:</h2>' . "\n" : '<br><a name="%s"></a><a href="#constitution">Constitution and Democracy</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#congress">Congress</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#politics">Politics</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#elections">Elections</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#presidency">Presidency</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#programs">Presidential Programs</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#scandals">Presidential Scandals</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#monuments">Monuments</a>
<h2 class="icategories">%s:</h2>' . "\n";

$hierarchy = array(1 => array('query' => "SELECT * FROM subject_browse WHERE sb_parent_id = '%s' ORDER BY sb_seq",
														  'placeholders' => array($_GET['type'] == "pep" ? "001" : "002"),
														  'format' => $format_level_1,
														  'format_args' => array('sb_thing'),
															'format_func' => 'format_level_1'),

									 2 => array('query' => "SELECT * FROM subject_browse WHERE sb_parent_id = '%s' ORDER BY sb_seq, sb_thing",
															'placeholders' => array("sb_child_id"),
															'format' => "<p class='imiddle'><b>%s</b>" . "\n",
														  'format_args' => array('sb_thing'),
															'format_func' => NULL),

									 3 => array('query' => "SELECT id, product_flag, name FROM assets, subject_browse, products WHERE sb_parent_id = '%s' AND id=sb_thing AND product_flag=products.product_id ORDER BY sb_seq",
															'placeholders' => array("sb_child_id"),
															'format' => '<a href="/article?assetid=%s&templatename=/article/article.html"><img src="/images/common/%s_cap.jpg" alt="%s" title="%s" align="middle" width="36" height="26" border="0"></a>' . "\n",
															'format_args' => array('id', 'product_flag', 'name', 'name'),
															'format_func' => NULL,
															'footer' => "</p>" . "\n")
									 );

include('DB.php');


class SingletonDB {
	function SingletonDB() {
	  // -------------------------------------------
	  // connect to the database
  	// -------------------------------------------
	  $this->_db = DB::connect('mysql://ap:ap@localhost/ap');

	  // -------------------------------------------
	  // did we connect to the database?
  	// -------------------------------------------
		if (DB::isError($this->_db)) {
			die($this->_db->getDebugInfo());
		}
	}
	function &instance() {
		static $instance;
		
		if(!isset($instance)) {
			$instance = new SingletonDB;
		}
		return $instance;
	}
	function &db() {
		return $this->_db;
	}
}


class HierNode {
	function HierNode($parentrow=NULL, $level=1) {
	  // -------------------------------------------
	  // save class variables
  	// -------------------------------------------
		$singleton        = SingletonDB::instance();
		$this->_db        = $db = $singleton->db();
		$this->_parentrow = $parentrow;
		$this->_level     = $level;

	  // -------------------------------------------
	  // get the global variable within our scope
  	// -------------------------------------------
		global $hierarchy;

	  // -------------------------------------------
		// save the indirect value of the variable
	  // -------------------------------------------
		$this->_query        = $hierarchy[$level]['query'];;
		$this->_placeholders = $hierarchy[$level]['placeholders'];
		$this->_format       = $hierarchy[$level]['format'];
		$this->_format_args  = $hierarchy[$level]['format_args'];
		$this->_format_func  = $hierarchy[$level]['format_func'];

	  // -------------------------------------------
		// run the query for this node
	  // -------------------------------------------
		$query = $this->_getQuery();
		$result = $this->_db->getAll($query, DB_FETCHMODE_ASSOC);

		// -----------------------------------------
		// did we get a query error?
		// -----------------------------------------
		if (!DB::isError($result)) {
			// ---------------------------------------
			// output the header if we have one
			// ---------------------------------------
			if(array_key_exists('header', $hierarchy[$this->_level])) {
				echo $hierarchy[$this->_level]['header'];
			}
			// ---------------------------------------
			// loop over the results array
			// ---------------------------------------
			foreach($result as $row) {

				// -------------------------------------
				// output the results in our format
				// -------------------------------------
				$this->_output($row);

				// -------------------------------------
				// do we need to create another level?
				// -------------------------------------
				if($this->_level < count($hierarchy)) {
					$hiernode = new HierNode($row, $level + 1);
				}
			}
			// ---------------------------------------
			// output the footer if we have one
			// ---------------------------------------
			if(array_key_exists('footer', $hierarchy[$this->_level])) {
				echo $hierarchy[$this->_level]['footer'];
			}
		// -----------------------------------------
		// otherwise, yep, got an error
		// -----------------------------------------
		} else {
			die($result->getDebugInfo());
		}
	}
	function _getQuery() {
		$query = "";
		// -------------------------------------------
		// are we the first level node?
		// -------------------------------------------
		if($this->_parentrow == NULL) {
			$query = vsprintf($this->_query, $this->_placeholders);

			// -----------------------------------------
			// otherwise, we need to build the array 
			// from the row
			// -----------------------------------------
		} else {
			$args = array();
			foreach($this->_placeholders as $placeholder) {
				$args[] = $this->_parentrow[$placeholder];
			}
			$query = vsprintf($this->_query, $args);
		}
		return $query;
	}
	function _output($row) {
		// ---------------------------------------
		// get row items into array for printing
		// ---------------------------------------
		$args = array();
		foreach($this->_format_args as $arg) {
			$args[] = $row[$arg];
		}
		// ---------------------------------------
		// are we doing normal formatting?
		// ---------------------------------------
		if($this->_format_func == NULL) {

			// -------------------------------------
			// output the results in the format
			// -------------------------------------
			echo vsprintf($this->_format, $args);

		// ---------------------------------------
		// otherwise, we have a format function
		// ---------------------------------------
		} else {
			$format_func = $this->_format_func;
			$format_func($row, $this->_format, $args);
		}
	}
}


//-------------------------------------------------------
// call back function for first level to get the 
// correct anchors in there
//-------------------------------------------------------
function format_level_1($row, $format, $format_args) {
	$args = array();
	$test = $row['sb_thing'];

	// ----------------------------------------------------
	// test what stage of the browse we're at
	// ----------------------------------------------------
	if($test == "Presidents") {
		$args[] = "pres";
	} elseif($test == "Vice Presidents") {
		$args[] = "vicepres";
	} elseif($test == "First Ladies") {
		$args[] = "ladies";
	} elseif($test == "Candidates") {
		$args[] = "dates";
	} elseif($test == "Constitution and Democracy") {
		$args[] = "constitution";
	} elseif($test == "Elections") {
		$args[] = "elections";
	} elseif($test == "Politics") {
		$args[] = "politics";
	} elseif($test == "Presidency") {
		$args[] = "presidency";
	} elseif($test == "Presidential Programs") {
		$args[] = "programs";
	} elseif($test == "Presidential Scandals") {
		$args[] = "scandals";
	} elseif($test == "Congress") {
		$args[] = "congress";
	} elseif($test == "Monuments") {
		$args[] = "monuments";
	} else {
		$args[] = "oops";
	}
	$args[] = $format_args[0];

	// ----------------------------------------------------
	// output results of format
	// ----------------------------------------------------
	echo vsprintf($format, $args);
}


function iconImage() {
	return ($_GET['type'] == "pep") ? "icon_key.jpg" : "noeas_key.jpg";
}


function introtext() {
	$retval = "";
	// ----------------------------------------------------
	// are we doing presidency and electoral politics?
	// ----------------------------------------------------
	if($_GET['type'] == "pep") {
		$retval = "<h1>The Presidency and Electoral Politics</h1><p>This section of the American Presidency includes articles from five Grolier encyclopedias, suited to different reading levels.</p>";

	// ----------------------------------------------------
	// otherwise, we're doing profiles
	// ----------------------------------------------------
	} else {
		$retval = "<h1>Profiles</h1><p>This section of the American Presidency includes articles from four Grolier encyclopedias, suited to different reading levels.</p>";
	}
	return $retval;
}


require($_SERVER['TEMPLATE_HOME'] . '/browse/browse.html');

?>