<!-- Copyright 2002 (C) Gambit Design Internet Services -->
<!-- This is licensed under the GNU Public License -->
<!-- Author: Derek T Del Conte - derek@gambitdesign.com -->

<?php include_once("config.inc.php"); ?>
<html>
	<head>
		<title>BookFLIX -- Conducting Bandwidth Test Now</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<META HTTP-EQUIV="Expires" CONTENT="Fri, Jun 12 1981 08:20:00 GMT"> 
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
		<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
		<link rel="stylesheet" href="style.css">
	</head>

	<body style="background-color:#95beff;">
	
		<center>
		<div style="background-color:#FFFFFF; width:514px; height:382px; padding:2px;">
			<table border="0" cellpadding="0" cellspacing="0">
  				<tr>
    				<td></td>
    			</tr>
			</table>
			<table border=0 cellpadding=0 cellspacing=0>
				<tr>
      				<td><br><br><br><br><br><br><font size=+1>
						Conducting bandwidth tests...</font></td>
				</tr>
			</table>

<script>
<!--
	time      = new Date();
	starttime = time.getTime();
// -->
</script>

<?php

	$data_file = "/data/bkflix1/docs/tools/bandwidthmeter/payload.bin";
	if ( $fd = fopen ($data_file, "rb") ) {
		$test_kbytes = 1024;
	
		$contents = fread ($fd, $test_kbytes * 1024);
		
		echo "<!-- $contents -->";
		fclose ($fd);
	} else {
		die("could not open payload file");
	}


?>

<script>
<!--
	time          = new Date();
	endtime       = time.getTime();

	if (endtime == starttime)
		{downloadtime = 0
		}
	else
	{downloadtime = (endtime - starttime)/1000;
	}

	kbytes_of_data = <?php echo $test_kbytes; ?>;
	linespeed     = kbytes_of_data/downloadtime;
	kbps          = (Math.round((linespeed*8)*10*1.024))/10;

	nextpage='meter2.php?kbps=' + kbps;
	document.location.href=nextpage
// -->
</script>
</div>
<center>

</body>
</html>
