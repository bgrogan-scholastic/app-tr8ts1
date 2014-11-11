<?php
if ( ($_COOKIE != null) && (array_key_exists("rec_ses", $_COOKIE) == true) ) {
  $record_session = $_COOKIE["rec_ses"];
  if ($record_session == "yes") {
     /* this page requires a statistic session to be recorded */

     /* the feature parameter must be present even though we are not recording a hit */
     $GI_STAT_PARAMETERS = array(GI_STATS_PARAM_FEATURENAME => "frame");

     include($_SERVER['PHP_INCLUDE_HOME'].'common/statistics/recordstatisticssession.php');

     /* make sure a refresh to this frame does not record a session statistics unless requested */
     Header("Set-Cookie: rec_ses=no; path=/; domain=.grolier.com");
  }
}
?>