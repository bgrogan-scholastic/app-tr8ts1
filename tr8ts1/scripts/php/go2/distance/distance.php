<html>
<head>

<script type="text/javascript" language="javascript">

 function deg2rad(degree) {
   return degree * (Math.PI / 180);
 }

  function format(expr, decplaces) {
    var str = "" + Math.round(eval(expr) * Math.pow(10, decplaces));
    while (str.length <= decplaces) {
      str = "0" + str;
    }
    var decpoint = str.length - decplaces;
    return str.substring(0, decpoint) + "." + str.substring(decpoint, str.length);
  }

  function distance() {

    lat1 = 42.75;     // albany
    long1 = 73.80;    // albany
    lat2 = 40.77;     // nyc
    long2 = 73.98;    // nyc

    lat1 = deg2rad(lat1);
    lat2 = deg2rad(lat2);
    long1 = deg2rad(long1);
    long2 = deg2rad(long2);
    dlat = Math.abs(lat2 - lat1);
    dlong = Math.abs(long2 - long1);
  
    l = (lat1 + lat2) / 2;
    a = 6378;
    b = 6357;
    e = Math.sqrt(1 - (b * b)/(a * a));
  
    r1 = (a * (1 - (e * e))) / Math.pow((1 - (e * e) * (Math.sin(l) * Math.sin(l))), 3/2);
    r2 = a / Math.sqrt(1 - (e * e) * (Math.sin(l) * Math.sin(l)));
    ravg = (r1 * (dlat / (dlat + dlong))) + (r2 * (dlong / (dlat + dlong)));

    sinlat = Math.sin(dlat / 2);
    sinlon = Math.sin(dlong / 2);
    a = Math.pow(sinlat, 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(sinlon, 2);
    c = 2 * Math.asin(Math.min(1, Math.sqrt(a)));
    d = ravg * c; 

    // convert kilometers to miles
    d = d * 0.62;
    return d;
  }

  function calcDistance(form) {
    miles = distance();
    kilometers = miles / 0.62111802;
    form.miles.value = format(miles, 2);
    form.kilometers.value = format(kilometers, 2);
  }

  function clearResults(form) {
    form.miles.value = "";
    form.kilometers.value = "";
  }

  function selectOnChange(event) {
    alert("Event = ", event);
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
  This is an experiment to see how list boxes work with 1500 items in them to select
  points to calculate the distance between. It's also an experiment to determine if 
  the distance calculation can be done entirely in Javascript rather than on the server.
</p>

<form name="atlas" action="http://linuxdev.grolier.com:1110/nystate" method="GET">
  <input type="hidden" name="act">
  <input type="hidden" name="mid">
  <p>
    <table>
      <tr>
        <td width="100%" valign="top">
          Select a city from each of the lists below and click "How Far?" to find the 
          distance (as the crow flies) between them.<br><br>

          <!-- first point to select -->
          From:<br>
          <select name="point1" size="4" onChange="javascript:selectOnChange(this.form);">
          <!-- build the list -->
          <?php
            for($index = 1; $index <= 1500; $index++) {
              printf('<option value="%s">%s Index - Some location' . "\n", $index, $index);
            }
          ?>
          </select><br><br>
          
          <!-- second point to select -->
          To:<br>
          <select name="point2" size="4" onChange="javascript:selectOnChange(this.form);">
          <?php
            for($index = 1; $index <= 1500; $index++) {
              printf('<option value="%s">%s Index - Some location' . "\n", $index, $index);
            }
          ?>
          </select><br><br>

          
          The "How far?" button doesn't really use the list above as that's dummy data.
          But it will produce the distance between New York City and Albany in New York State.<br>
          <input type="button" name="distance" value="How Far?" onClick="javascript:calcDistance(this.form);">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="clear" value="Clear the results" onClick="javascript:clearResults(this.form);"><br><br>
          <input type="text" name="miles"> miles<br><br>
          <input type="text" name="kilometers"> kilometers
       </td>
     </tr>
   </table>
 </p>
</form>



</body>
</html>