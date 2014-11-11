<!-- page parameters

	startmonth	1 - 12
	startday	1 - 31
	startyear	1999 - present
	
	endmonth	1 - 12
	endday		1 - 31
	endyear		1999 - 2004
	
	displayindex[]	(php array) subject, loc, dewey, time, form, place, keyword, ebsco
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
<!-- <form name="byindex" action="/reporting/reportbyindex.php" method="GET">			-->
<form name="byindex" action="reportbyindex.php" method="GET">
<input type="hidden" name="reporttype" value="byindex">


<!-- use the development database -->
<!-- <input type="hidden" name="dbserver" value="dev"> -->


<table border="0" width="65%" align="center">
	<tr>
		<td with="100%" colspan="2" align="center">
			<h2>Classification Tool Monthly Statistics Report By Index</h2>
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
		<td valign="top">
			<br>
			<p><b>3) Please Select an Index</b></p>
			<input type="checkbox" name="displayindex[]" value="all">All Indices<br>
			<input type="checkbox" name="displayindex[]" value="subject">Subject Index<br>
			<input type="checkbox" name="displayindex[]" value="lc">Library of Congress Subject Headings<br>
			<input type="checkbox" name="displayindex[]" value="dewey">Dewey decimal Classification<br>
			<input type="checkbox" name="displayindex[]" value="time">Time Classification<br>
			<input type="checkbox" name="displayindex[]" value="form">Form Classification<br>
			<input type="checkbox" name="displayindex[]" value="place">Place Classification<br>
			<input type="checkbox" name="displayindex[]" value="keywords">Keyword Classification<br>
			<input type="checkbox" name="displayindex[]" value="ebsco">Ebsco Classification<br>		
		</td>
		
		<td valign="top">
			<br>
			<?php require_once('includes/showrefreshoption.php');?>
			<p align="center"><input type="submit" value="View Report" name="b1"></p>
			<p align="center"><input type="reset" value="Reset" name="b2">
			<br>
			<br>
			<br>
<!-- ~CM 5/6/04 - relative path useful for debugging a copy of entire directory			-->
<!--			<p align="center"><a href="/reporting/index.php">More Reports</a></p>	-->   
			<p align="center"><a href="index.php">More Reports</a></p>
		</td>
	</tr>

</table>

<?php
//~CM check nc
//		echo "<hr>";
//		var_dump($myProperties['connectionname']);
//		echo "</pre>\n";			
//		echo "<hr>";
?>

</form>
</body>
</html>
