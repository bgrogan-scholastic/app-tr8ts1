<html>
<head>

<script language="javascript">

  function doSearch(form) {
    form.mid.value = "mgus032";
    form.act.value = "search";
    form.submit();
  }

  function calcDistance(form) {
    form.mid.value = "mgus032";
    form.act.value = "distance";
    ssidChecked = false;
    dsidChecked = false;

    for (i = 0; i < form.ssid.length; i++) {
      if (form.ssid[i].checked) {
	ssidChecked = true;
	break;
      }
    }
    for (i = 0; i < form.dsid.length; i++) {
      if (form.dsid[i].checked) {
	dsidChecked = true;
	break;
      }
    }
    if (ssidChecked && dsidChecked) {
      form.submit();
    } else {
      alert("Please select two cities");
    }
  }
  function doLongIsland(form) {
    form.mid.value = "mgus032";
    form.act.value = "Long Island";
    form.sid.value = "6";
    form.submit();
  }

  function poiInfo(poitext) {
    alert(poitext);
  }

  function doPois(form) {
    form.mid.value = "mgus032";
    form.act.value = "poi";
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

<p>
  This is a little experiment to see how well we can do various things to an 
  image dynamically for maps. In this case I'm going to try three things. If you select
  a city to 'Search' for, I'll put up a legend for the city and a line and indication where
  it is on the map. In addition, if you select two cities and 'Calculate Distance' I'll
  add legends for both cities and calculate the miles between them. If you want to highlight
  Long Island I'm going to try and do a polygon highlight.
</p>

<form name="atlas" action="http://linuxdev.grolier.com:1110/nystate" method="GET">
  <input type="hidden" name="act">
  <input type="hidden" name="mid">
  <p>
    <table>
      <tr>
        <td width="49%" valign="top">
          Select a city you'd like to simulate a search for:<br>
          <input type="radio" name="sid" value="1">Albany<br>
          <input type="radio" name="sid" value="2">Syracuse<br>
          <input type="radio" name="sid" value="3">Rochester<br>
          <input type="radio" name="sid" value="4">New York<br>
          <input type="button" name="dosearch" value="Do The Search" onClick="javascript:doSearch(this.form);">
       </td>
       <td width="2%">
       </td>
       <td width="49%" valign="top">
         Select two cities to get the distance between:<br>
	 <table width="100%">
	   <tr>
 	     <td width="50%">
               <input type="radio" name="ssid" value="1">Albany<br>
               <input type="radio" name="ssid" value="2">Syracuse<br>
               <input type="radio" name="ssid" value="3">Rochester<br>
               <input type="radio" name="ssid" value="4">New York<br>
               <input type="radio" name="ssid" value="5">Hartford, CT<br>
             </td>
 	     <td width="50%">
               <input type="radio" name="dsid" value="1">Albany<br>
               <input type="radio" name="dsid" value="2">Syracuse<br>
               <input type="radio" name="dsid" value="3">Rochester<br>
               <input type="radio" name="dsid" value="4">New York<br>
               <input type="radio" name="dsid" value="5">Hartford, CT<br>
             </td>
	   </tr>
	 </table>
         <input type="button" name="dosearch" value="Calculate Distance" onClick="javascript:calcDistance(this.form);">
       </td>
     </tr>
   </table>
 </p>
 <p>
   Would you like to highlight Long Island?
   <input type="button" name="doisland" value="Yeah, let's do it!" onClick="javascript:doLongIsland(this.form);">
 </p>
 <p>
   Let's do some points of interest shall we.
   <input type="button" name="dopoi" value="Let's see some POI" onClick="javascript:doPois(this.form);">
 </p>
</form>


<?php

  $mid = $_GET["mid"];
  $sid = $_GET["sid"];
  $ssid = $_GET["ssid"];
  $dsid = $_GET["dsid"];
  $action = $_GET["act"];
  

  // set up the spots array, this relates spotid to spot name and it's coordinates
  $spots = array(1 => array("Albany", 370, 200, 450, 220),
                 2 => array("Syracuse", 280, 171, 350, 190),
                 3 => array("Rochester", 188, 156, 276, 181),
	         4 => array("New York", 423, 372, 501, 396),
	         5 => array("Long Island",
			  424, 388,
			  432, 368,
			  483, 355,
			  516, 352,
			  528, 342,
			  566, 342,
			  516, 372,
			  430, 392));

$pois = array(1 => array(311, 261 + 50, 322, 270 + 50, "Binghamton totally rocks!"), 
	      2 => array(418, 219 + 50, 429, 228 + 50, "Albany, you just can\'t get enough of it!"),
	      3 => array(106, 161 + 50, 117, 170 + 50, "Niagara Falls is a drip"),
	      4 => array(297, 174 + 50, 308, 183 + 50, "Syracuse, what can you say about endless snow"));


  $mapinfo = array($mid => "New York");

  printf('<img src="/map.php?map=%s&act=%s&sid=%s&ssid=%s&dsid=%s" usemap="#poi">', $mid, $action, $sid, $ssid, $dsid);
  print "\n";

  // put up the pois
  if($action == "poi") {
    $camera = imagecreatefromgif("/data/go2/docs/maps/camera1.gif");
    $sx = imageSX($camera);
    $sy = imageSY($camera);
    imagedestroy($camera);

    printf('<map name="poi">');
    print "\n";
    
    foreach($pois as $poi) {
      printf('<area shape="rect" coords="%s, %s, %s, %s" href="javascript:poiInfo(\'%s\');">', $poi[0], $poi[1], $poi[0] + $sx, $poi[1] + $sy, $poi[4]);
      print "\n";
    }
    printf('</map>');
    print "\n";
  }

?>

</body>
</html>