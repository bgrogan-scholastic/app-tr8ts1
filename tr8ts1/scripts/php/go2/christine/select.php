<?php

require_once('DB.php');


function getMapList() {
  $retval = "";

  $db = DB::connect('mysql://atlas:atlas@localhost/atlas');

  // if no db error
  if (!DB::isError($db)) {
    $sql = "select * from maps order by name";

    $maps = $db->getAll($sql, DB_FETCHMODE_ASSOC);

    // if no error
    if(!DB::isError($maps)) {
      
      // iterate through the returned map list
      $index = 0;
      $selectedIndex = $_GET["selectedIndex"];
      foreach($maps as $map) {
	if($selectedIndex == $index) {
	  $retval .= sprintf("<option value='%s' selected>mapid = %s,  %s\n", $map["mapid"], $map["mapid"], $map["name"]);
	} else {
	  $retval .= sprintf("<option value='%s'>mapid = %s,  %s\n", $map["mapid"], $map["mapid"], $map["name"]);
	}
	$index++;
      }
    } else {
      die($db->getMessage());
    }
  } else {
    die($db->getMessage());
  }
  $db->disconnect();

  return $retval;
}

function getMapTitle($mapid) {
  $retval = "";

  $db = DB::connect('mysql://atlas:atlas@localhost/atlas');

  // if no db error
  if (!DB::isError($db)) {
    $sql = sprintf("select * from maps where mapid='%s'", $mapid);

    $map = $db->getRow($sql, DB_FETCHMODE_ASSOC);

    // if no error
    if(!DB::isError($maps)) {
      
      $retval = sprintf("mapid = %s,  map name = %s", $mapid, $map["name"]);
      
    } else {
      die($db->getMessage());
    }
  } else {
    die($db->getMessage());
  }
  $db->disconnect();

  return $retval;
}

?>

<html>
<head>

<script language="javascript">

  function getTheMap(form) {
    if(form.mapid.value != "") {
      form.process.value = "mapid";
    } else {
      form.process.value = "mapselect";
      form.selectedIndex.value = form.mapselect.selectedIndex;
    }
    form.submit();
  }

</script>

<style type="text/css">
  body {
    margin-top: 15px;
    margin-bottom: 15px;
    margin-left: 15px;
    margin-right: 300px;
    background-color: lightgrey;
  }
  p {
    font-family: verdana, arial, sans-serif;
    border: solid black;
    padding: .5em;
    background: white;
  }
  h2 {
    font-size: 15px;
    font-family: verdana, arial, sans-serif;
  }
  img {
    padding: .5em;
    background: white;
    border: solid black;
  }

</style>

</head>
<body>

<form name="atlas" action="http://linuxdev.grolier.com:1110/christine" method="GET">
  <input type="hidden" name="process" value="mapid">
  <input type="hidden" name="selectedIndex" value="">
  <p>
    Select the map you'd like to display and print from the drop down list below:
    <select name="mapselect" onChange="javascript:getTheMap(this.form);">
      <?php
        echo getMapList();
      ?>
    </select>
    <br>
    <br>
    Or enter the mapid here : <input type="text" name="mapid" maxsize="24">
    <input type="button" name="getmap" value="Get the Map" onClick="javascript:getTheMap(this.form);">

    <?php
      $process = $_GET["process"];
      $mapid = $_GET["mapid"];
      $mapselect = $_GET["mapselect"];

      if($process != "") {
        if($process == "mapid") {
          $mapid = $mapid;
        }
        if($process == "mapselect") {
          $mapid = $mapselect;
        }
      }
      if($mapid != "") {
        printf("<br>%s", getMapTitle($mapid));
      }
    ?>

  </p>
</form>

<?php

  $process = $_GET["process"];
  $mapid = $_GET["mapid"];
  $mapselect = $_GET["mapselect"];

  if($process != "") {
    if($process == "mapid") {
      $mapid = $mapid;
    }
    if($process == "mapselect") {
      $mapid = $mapselect;
    }
  }
  printf('<img src="/christinemap?mapid=%s" border="0">', $mapid);

?>

</body>
</html>