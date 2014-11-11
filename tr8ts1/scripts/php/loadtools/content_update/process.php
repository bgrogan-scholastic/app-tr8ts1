<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php

require_once('XML/Unserializer.php');

/**
 * Class @name logging of messages to a queue for later display when page is finished
 *
 * 12/13/2006 SJF PHP 5 Conversion
 */
class LogMessage {
	
	/**
	 * @name constructor
	 * @access public
	 * @return LogMessage
	 */
	public function __construct() {
    	$this->_log = array();
  	}
  	
  	/**
  	 * @name
  	 * @access public	
  	 * @param unknown_type $msg
  	 */
 	public function add($msg) {
    	$this->_log[] = $msg;
	}
  
	/**
	 * @name 
	 * @access public
	 * @return unknown
	 */
	public function size() {
    	return count($this->_log);
	}
  
	/**
	 * @name
	 * @access public
	 * @return unknown
	 */
	public function dump() {  
		// iterate over the log messages and print them out
	    foreach($this->_log as $msg) {
    		printf("<h3>** Log Message - %s **</h3><br>\n", $msg);
    	}
  	}
	
  	/**
  	 * @name 
  	 * @access public
  	 * @return unknown
  	 */
  	public function count() {
    	return count($this->_log);
	}
}

//	12/13/2006  This following class is standalone - It does not 
//  access one LogMessage - it returns a new one every time.
// this function is the "singleton" factory to access the one 
// LogMessage class instance
function &getLogMessage() {
  static $instance;

  // does an instance need to be created?
  if (!isset($instance)) {
    $instance = new LogMessage();
  }
  return $instance;
}

/**
 * @name
 *
 */
class XMLData {
	
	/**
	 * @name 
	 * @access public
	 * @return XMLData
	 */
	public function __construct() {

		// get the xml date and make it available
	    $options = array('complexType' => 'array',
			     'parseAttributes' => TRUE,
			     'attributesArray' => "attr");
	
	    // create the log instance
	    $this->_log = &getLogMessage();
	
	    // check for the existence of the XML file
	    if (file_exists("/data/loadtools/config/update_process/" . $_GET["product"] . ".xml")) {
	    	$unserialize = &new XML_Unserializer($options);
	    	$status = $unserialize->unserialize("/data/loadtools/config/update_process/" . $_GET["product"] . ".xml", true);
	
		    // did we successfully get the XML going?
		    if (!PEAR::isError($status)) {
				$this->_update =  $unserialize->getUnserializedData();
				$this->_product = $this->_update["product"];
		
				// 'condition' return value to be expected array structure for servers
				if (array_key_exists("attr", $this->_update["servers"]["server"])) {
				  	$this->_servers = array(0 => $this->_update["servers"]["server"]);
				} 
				else {
					$this->_servers = $this->_update["servers"]["server"];
				}
			
				// 'condition' return value to be expected array structure for features
				if (array_key_exists("attr", $this->_update["features"]["feature"])) {
				  $this->_features = array(0 => $this->_update["features"]["feature"]);
				} 
				else {
					$this->_features = $this->_update["features"]["feature"];
				}
	
	      // otherwise, got an error
		    } 
		    else {
				$this->_log->add($status->getMessage());
		    }
	    // otherwise, nope, file doesn't exist
	    } 
	    else {
	      $this->_log->add(sprintf("File : /data/loadtools/config/update_process/%s.xml doesn't exist", $_GET["product"]));
	    }
	}
	 
	/**
	 * @name This always returns an object as there should only be one in an XML configuration file
	 * @access public
	 * @param unknown_type $key
	 * @return unknown
	 */
	 public function product($key="") {
	    if (isset($this->_product)) {
	      if (array_key_exists($key, $this->_product)) {
		return $this->_product[$key];
	      }
	    // otherwise, XMLData object incomplete
	    } else {
	      $this->_log->add("XMLData object incomplete");
	    }
	  }
	  
	/**
	 * @name this will return array of objects, even if there is only one object in that array
	 * @access public
	 * @return unknown
	 */
	public function &servers() {
	  		$retval = NULL;
	
	    // is the server value set?
	    if (isset($this->_servers)) {
	      $retval = $this->_servers;
	
	    // otherwise, XMLData object incomplete
	    } else {
	      $this->_log->add("XMLData object incomplete");
	      $retval = "servers not set";
	    }
	    return $retval;
	}

	/**
	 * @name
	 * @access public
	 * @return unknown
	 */
	public function &features() {
    	
		if (isset($this->_product)) {
      		return $this->_features;

    	// otherwise, XMLData object incomplete
    	} 
    	else {
      		$this->_log->add("XMLData object incomplete");
    	}
  	}
}

// actually get the xml data in an object form
$update = new XMLData();
//echo "<pre>";
//print_r($update);
//echo "</pre>";

?>

<html>
  <head>
    <title>Update Process Control</title>
    <link rel="stylesheet" type="text/css" href="/css/update_process.css">

    <script language="javascript" type="text/javascript">
      <!--

      function selectLocation(form) {
        form.location.value = form.locationSelect[form.locationSelect.selectedIndex].value;
	form.submit();
      }
      function selectBackend(form) {
        form.backend.value = form.backendSelect[form.backendSelect.selectedIndex].value;
	form.backend.value = "something";
      }
      function selectFeature(form) {
	var feature = form.featureSelect[form.featureSelect.selectedIndex].value;
	feature.replace(/\//gi, "%2F");
        form.feature.value = feature;
      }

      function backendToggle(form) {
	// are all the fields valid?
	if (validateFields(document.update)) {
	  
	  // are you sure you wish to toggle backend state?
	  if (areYouSureYouWantToToggle(form)) {
	    if (form.backend_state.value == "online") {
	      form.backend_state.value = "offline";
	      form.backend_toggle.value = "Take Online";
	    } else if (form.backend_state.value = "offline") {
	      form.backend_state.value = "online";
	      form.backend_toggle.value = "Take Offline";
	    }
	    form.process.value = "toggle_backend";
	    var url = "/cgi-bin/update.py?templatename=/update_process/log.html";
	    url += "&product=" + form.product.value;
	    url += "&location=" + form.locationSelect[form.locationSelect.selectedIndex].value;

	    // do we have any backend servers?
	    if (form.backendSelect != null) {
	      url += "&backend=" + form.backendSelect[form.backendSelect.selectedIndex].value;
	    }
	    // %2F  = /
	    url += "&feature=" + form.featureSelect[form.featureSelect.selectedIndex].value;
	    url += "&username=" + form.username.value;
	    url += "&password=" + form.password.value;
	    url += "&backend_state=" + form.backend_state.value;
	    url += "&process=toggle_backend";
	    parent.frames["log"].window.location.href = url;
	  }
	}
      }

      function areYouSureYouWantToToggle(form) {
	var state = ""
	if (form.backendState == "" || form.backendState == "offline") {
	  state = "online";
	} else if (form.backendState == "online") {
	  state = "offline";
	}
	return confirm("Are you sure you wish to change the state\nbackend server to " + state);
      }

      function processUpdate(form) {

        // are all the fields valid?
	if (validateFields(document.update)) {

	  // sure you want to update?
	  if (areYouSure(form)) {
	    var url = "/cgi-bin/update.py?templatename=/update_process/log.html";
	    url += "&product=" + form.product.value;
	    url += "&location=" + form.locationSelect[form.locationSelect.selectedIndex].value;

	    // do we have any backend servers?
	    if (form.backendSelect != null) {
	      url += "&backend=" + form.backendSelect[form.backendSelect.selectedIndex].value;
	    }
	    // %2F  = /
	    url += "&feature=" + form.featureSelect[form.featureSelect.selectedIndex].value;
	    url += "&username=" + form.username.value;
	    url += "&password=" + form.password.value;
	    url += "&process=update";
	    parent.frames["log"].window.location.href = url;
	  }
        }
      }

      function validateFields(form) {
	var retval = true;
	if (form.username.value == "") {
	  form.username.focus();
	  alert("Please enter your username");
	  retval = false;
	} else if (form.password.value == "") {
	  form.password.focus();
	  alert("Please enter your password");
	  retval = false;
	} else if (form.locationSelect.selectedIndex == 0) {
	  form.location.focus();
	  alert("Please select a location");
	  retval = false;
	} else if (form.backendSelect != null && form.backendSelect.selectedIndex == 0) {
	  form.backend.focus();
	  alert("Please select a backend server");
	  retval = false;
	} else if (form.featureSelect.selectedIndex == 0) {
	  form.feature.focus();
	  alert("Please select a feature");
	  retval = false;
	}
	return retval;
      }

      function areYouSure(form) {
	return confirm("About to update the " + form.feature.value + " feature at the " + form.location.value + " site.\nAre you sure you wish to do this?");
      }

      -->
    </script>
  </head>
  <body>
    <!-- output the product name and version information -->
    <?php
      $product = $update->product("name");
      $version = $update->product("version");
      printf("<h2>Update Process Control : %s - Version : %s</h2>", $product, $version);
    ?>
    <p>
      This page allows you to update this product feature by feature by selecting from the various list items.<br>
      Select the feature you wish to update from the list below and click the 'Update Feature button. The feature will be automatically 
      updated and the progress of the update will be displayed below.
    </p>

    <!-- begin the form section of the display -->
    <form name="update" method="GET" action="/php_update_process/process.php">
      <input type="hidden" name="templatename" value="/update_process/process.html">
      <input type="hidden" name="product" value="<?php echo($_GET['product']);?>">
      <input type="hidden" name="location" value="">
      <input type="hidden" name="backend" value="">
      <input type="hidden" name="feature" value="">
      <input type="hidden" name="backend_state" value="">
      <input type="hidden" name="process" value="">

      <!-- build the containing table of user selections -->
      <table width="600" align="left" border="0">
	<!-- begin row one -->
	<tr>
	  <td width="20%" align="right">username:</td>
	  <td width="20%" align="left">
	    <input type="text" name="username" tabindex="1">
          </td>
	  <td width="20%" align="right">location:</td>
	  <td width="20%" align="left">
	    <select name="locationSelect" tabindex="3" onChange="javascript:selectLocation(this.form);">
              <option value="dummy" selected>Select Location</option>
	      <?php
                $servers = $update->servers();
                foreach($servers as $server) {
		  // was this the location the user selected before?
		  if ($server["attr"]["location"] == $_GET["location"]) {
		    printf('<option value="%s" selected>%s</option>' . "\n", $server["attr"]["location"], $server["attr"]["location"]);
		  // otherwise, nope, proceed as normal
		  } else {
		    printf('<option value="%s">%s</option>' . "\n", $server["attr"]["location"], $server["attr"]["location"]);
		  }
                }
	      ?>
	    </select>
	  </td>
	  <td width="20%" align="right"></td>
	</tr>
	<!-- begin row two -->
	<tr>
	  <td width="20%" align="right">password:</td>
	  <td width="20%" align="left">
	    <input type="password" name="password" tabindex="2">
          </td>
	  <!-- backend server section -->

	    <!-- make some decisions based on selected server -->
	    <?php
              $servers = $update->servers();

              // interate over the servers
              foreach($servers as $server) {
  
                // what server are we talking about?
                if ($server["attr"]["location"] == $_GET["location"]) {
  
                  // is the selected location load balanced?
                  if ($server["system"]["attr"]["loadbalanced"] == "yes") {
		    echo('<td width="20%" align="right">backend:</td>' . "\n");
		    echo('<td width="20%" align="left">' . "\n");
                    echo('<select name="backendSelect" tabindex="4" onChange="javascript:selectBackend(this.form);">' . "\n");
                    echo('<option value="dummy" selected>Select Backend</option>' . "\n");
                    $backends = $server["system"]["backend"];
                    foreach($backends as $backend) {
                      printf('<option value="%s">%s</option>' . "\n", $backend["attr"]["name"], $backend["attr"]["name"]);
                    }
                    echo("</select>\n");
                    echo("</td><td>\n");
		    echo('<input type="button" name="backend_toggle" value="Take Offline" tabindex="6" onClick="backendToggle(this.form);">');
                    echo("</td>\n");

                  // otherwise, nope, so don't put up the option
                  } else {
		      echo("<td></td><td></td><td></td>\n");
                  }
                }
              }
	    ?>
	  <td width="20%" align="right"></td>
	</tr>
	<!-- begin row three -->
	<tr>
	  <td width="20%" align="right"></td>
	  <td width="20%" align="right"></td>
	  <td width="20%" align="right">feature:</td>
	  <td width="20%" align="left">
            <select name="featureSelect" tabindex="5" onChange="javascript:selectFeature(this.form);">
              <option value="dummy">Select Feature</option>
              <?php
	        $features = $update->features();
                foreach($features as $feature) {
                  printf('<option value="%s">%s</option>' . "\n", $feature["attr"]["name"], $feature["attr"]["name"]);
                }
              ?>
            </select>
	  </td>
	  <td width="20%" align="right">
	    <input type="button" name="process_update" value="Update Feature" tabindex="7" onClick="processUpdate(this.form);">
          </td>
	</tr>
      </table>
    </form>
    <!-- output any messages from the process (error messages mostly) -->
    <?php
      echo("<br><br><br><br>");
      $log = &getLogMessage();

      if ($log->count() > 0) {
        echo("<h2>Log Messages from process</h2>\n");
        $log->dump();
      }
      // output necessary javascript
      echo('<script language="javascript" type="text/javascript">');
      printf('form.location.value = %s', $_GET["server"]);
      echo('</script>');
    ?>
  </body>
</html>
