<!-- page parameters

	startmonth	1 - 12
	startday	1 - 31
	startyear	1999 - present
	
	endmonth	1 - 12
	endday		1 - 31
	endyear		1999 - 2004
	
	product[]	(php array) all, ea, gme, etc.
-->

<?php
	putenv('PHP_SCRIPTS_HOME=/data/rps/scripts/php');
	require_once('includes/common-dbconnection.php');	
?>

<html>
	<head>
		<title>Classification Tool Monthly Statistics Report by Product</title>
	</head>
<body bgcolor="white">
<!-- ~CM 5/6/04 - relative path useful for debugging a copy of entire directory			-->
<!-- <form name="byproduct" action="/reporting/reportbyproduct.php" method="GET">		-->
<form name="byproduct" action="reportbyproduct.php" method="GET">

<!-- use the development database -->
<!-- <input type="hidden" name="dbserver" value="dev"> -->

<table border="0" width="65%" align="center">
	<tr>
		<td with="100%" colspan="2" align="center">
			<h2>Classification Tool Monthly Statistics Report By Product</h2>
		</td>
	</tr>

	<tr>
		<td><?php include('includes/daterange-start.php');?></td>
		
		<td><?php include('includes/daterange-end.php');?></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td><?php include('includes/productselectbox.php');?></td>
		
		<td><?php require_once('includes/showrefreshoption.php');?>
			<p align="center"><input type="submit" value="View Report" name="b1"></p>
			<p align="center"><input type="reset" value="Reset" name="b2">
			<br>
			<br>
			<br>
	<!-- ~CM 5/6/04 - relative path useful for debugging a copy of entire directory			-->
	<!--		<p align="center"><a href="/reporting/index.php">More Reports</a></p></td>	-->     
			<p align="center"><a href="index.php">More Reports</a></p></td>
	</tr>
</table>

</form>
</body>
</html>
