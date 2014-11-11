<?php

/*******************************************************************************
 * Set this to true if you are using MySQL as the backend database.  Currently
 * this is the only available method to view speed tests from the Admin
 * page.
 ******************************************************************************/
$mysql = false;

/*******************************************************************************
 * The following array stores the access information for the database.  The
 * values are determined when you setup the database and grant access.  More
 * information can be found in the README about setting up the database
 * correctly.
 ******************************************************************************/
/* $database = array ( "host" => "localhost"
				  , "login" => "root"
				  , "password" => ""
				  , "database" => "bwmeter"
				  );
*/
/*******************************************************************************
 * The following options allow simple customization.  $isp_name shows up in the
 * title bar.
 ******************************************************************************/
$isp_name = "ISP NAME";
$header = "Here is an optional header";
$footer = "Here is an optional footer";

/*******************************************************************************
 * Modify the following settings if you would like to change the name/speed of
 * services the meter compares the current connection to.
 ******************************************************************************/$services = array( "28.8" =>  array ( "name" => "dial-up"
								   , "image" => "1.gif"
								   )
                 , "33.6" =>  array ( "name" => "dial-up"
				 				   , "image" => "1.gif"
								   )
                 , "53.3" =>  array ( "name" => "dial-up"
				 				   , "image" => "1.gif"
								   )
                 , "56" =>    array ( "name" => "ISDN"
				 				   , "image" => "2.gif"
								   )
                 , "128"  =>  array ( "name" => "ISDN"
				 				   , "image" => "2.gif"
								   )
                 , "384"  =>  array ( "name" => "DSL"
				 				   , "image" => "3.gif"
								   )
                 , "768"  =>  array ( "name" => "DSL"
				 				   , "image" => "3.gif"
								   )
                 , "1000"  => array ( "name" => "DSL"
				 				   , "image" => "4.gif"
								   )
                 , "1500"  => array ( "name" => "DSL/T1/Cable Modem"
				 				   , "image" => "5.gif"
								   )
          );

/*******************************************************************************
 * Determines the bar image that is shown for the current test.
 ******************************************************************************/
$user_graph_image = "you.gif";

/*******************************************************************************
 * Determines the heights of the bars (in pixels) in the graph display.
 ******************************************************************************/
$bar_height = 10;

/*******************************************************************************
 * When set to true, the bandwidthmeter performs a quick check then sends a
 * payload based on the estimated pipe size.
 ******************************************************************************/
$use_initialmeter = True;

/*******************************************************************************
 * When not using the initialmeter.php to calculate the payload size,
 * $default_kbyte_test_size will be used.  When linking to meter.php directly,
 * this file size is used.  When linking to initialmeter.php, initialmeter
 * decides the file size to send based on its estimate of the pipe size.
 ******************************************************************************/
$default_kbyte_test_size = 512;

?>
