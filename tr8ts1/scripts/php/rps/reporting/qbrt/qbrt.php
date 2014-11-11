<?php

    /**
    * Q*Bert
    *
    * Originally developed for the RPS 'querybuilder report tool' (qbrt),
    * Q*Bert is a PHP app which uses the PHP session information to
    * allow the creation of object-oriented web-based applications.
    *
    * @author       Richard E. Dye
    * @copyright    4/2/2004
    * @package      qbrt
    */

    require_once('qbrt_config.php');

    # Important safety tip: All classes must be defined before
    # the session is started, so the session will know what to do
    # with them

    $_class = $_REQUEST['class'];

    # If there is no instance specified, then there will be only
    # one object of the class - the instance having the same name
    # as the class.
    if (isset($_REQUEST['instance']))
        $_instance = $_REQUEST['instance'];
    else
        $_instance = $_class;

    # Here we need to sanitize the class name to keep a malicious user
    # from including other classes.
    # If an illegal character is found, the class name is changed
    # to 'qbrt_badclass'.  If desired, and actual class with that
    # name can be created, and its output() method used to display
    # a message.  Otherwise, just let the 'require_once()' directive
    # fail.
    $theIllegalStrings = array('..', ';');

    foreach($theIllegalStrings as $illegalString) {
        if(strpos($_class, $illegalString) !== FALSE) {
            $_class = 'qbrt_badclass';
        }
    }

    # By default, Q*Bert will only incorporate the source code for
    # the class currently being used.
    # If a class needs knowledge of other classes to do its work,
    # then it must include their .php files in its own file.
    include_once(getcwd().'/classes/'.$_class.'.php');

    # Let's prepare an array of parameters for the method
    $parmarray = array();

    # Here we set certain 'state' information which the
    # method might find useful.  The passed GET or POST
    # variables could overwrite them, if needed.

    $parmarray['class'] = $_class;
    $parmarray['instance'] = $_instance;
    
    foreach ($_REQUEST as $key=>$value) {
        if (strpos($key, 'parm_') === 0) {
            $parmarray[substr($key, 5)] = $value;
        }
    }


    # Now it is time to start our session, with the session handler
    # knowing how to deal with the objects this instance of the
    # program is using.
    require_once('qbrt_session.php');


    # if we don't already have our object instance,
    # create it now
    if (!isset($_SESSION[$_instance])) {
        $_SESSION[$_instance] = new $_class($parmarray);
    }

    # Begin the HTML document...
    writeHeaders($_instance);

    # Time to call the requested method.
    #
    # the default method is 'output()'
    #
    # Please note that all methods must return the html
    # for rebuilding the object's display.
    #
    if (!isset($_REQUEST['method'])) {
        echo $_SESSION[$_instance]->output($parmarray);
    } else {
        echo $_SESSION[$_instance]->$_REQUEST['method']($parmarray);
    }

    require_once('qbrt_end_session.php');

    # Close out the HTML document.
    writeFooters();

    /**
    * Write out the HTTP headers for this document.
    *
    * @author       Richard E. Dye
    * @copyright    3/31/2004
    * @package      qbrt
    */
	function writeHeaders($inTitle=''){
        global $qbrt_settings;

	    if ($inTitle == '')
	        $inTitle=$qbrt_settings['title'];

        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"'."\n";
        echo '    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n\n";

        echo '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
        echo "<head>\n";
        echo '<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />'."\n";
        echo "<title>$inTitle</title>\n";
        echo "</head>\n";

        if (isset($qbrt_settings['background'])) {
            echo '<body bgcolor="'.$qbrt_settings['bgcolor'].'" background="'.$qbrt_settings['background'].'">';
        } else {
            echo '<body bgcolor="'.$qbrt_settings['bgcolor'].'">';
    	}
    	echo "\n";
    }


    /**
    * Write out the HTTP footers for this document.
    *
    * @author       Richard E. Dye
    * @copyright    3/31/2004
    * @package      qbrt
    */
	function writeFooters(){
        echo "</body>\n";
        echo "</html>\n";
    }

?>

