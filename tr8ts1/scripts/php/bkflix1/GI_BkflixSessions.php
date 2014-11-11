<?php

/* if there is no current bookflix session cookie, record a session stat */
if ( ($_COOKIE != null) && (array_key_exists("BFSESS", $_COOKIE) == false) ) {

     /* the feature parameter must be present even though we are not recording a hit */
     $GI_STAT_PARAMETERS = array(GI_STATS_PARAM_FEATURENAME => "frame");

     include($_SERVER['PHP_INCLUDE_HOME'].'common/statistics/recordstatisticssession.php');
  }
?>
