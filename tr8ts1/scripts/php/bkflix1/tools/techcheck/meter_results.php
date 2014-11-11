<?php //echo $_GET['rate'] ;

	$kbps = round($_GET['rate'], 2);
	$ksec = round($kbps / 8, 2);
	$mbps = round($kbps / 1024, 2);
	$msec = round($mbps / 8, 2);

   if ($msec > 1) {
     // echo "<font size=+0 color=black>you can download at " . $msec . " MB/sec. from our servers.</font><br><br>";
   } else {
     // echo "<font size=+0 color=black>you can download at " . $ksec . " KB/sec. from our servers.</font><br><br>";
   }
   
$BarColor;

//find out what color bar they should have
if($kbps < 351){
	
	$BarColor = "#FF0066";
	
}else if($kbps >= 351 && $kbps < 769){
	
	$BarColor = "#FFD700";
	
}else if($kbps > 768){
	
	$BarColor = "#00CD66";
	
}//end if

//find out how many pixels the bar should be.
$percent = $kbps / 46080;
$pixel = round($percent * 480);

//find out how many table cells should be filled in
if($kbps > 128){
	
	$cell1 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 256){
	
	$cell2 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 325){
	
	$cell3 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 383){
	
	$cell4 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 768){
	
	$cell5 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 1024){
	
	$cell6 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 1500){
	
	$cell7 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 10000){
	
	$cell8 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 24000){
	
	$cell9 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 32000){
	
	$cell10 = 'background-color:'.$BarColor.';';
	
}
if($kbps > 46080){
	
	$cell11 = 'background-color:'.$BarColor.';';
	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>BookFLIX -- Bandwidth Test Results</title>
</head>

<body style="background-color:#95beff;">

<div style="background-color:#FFFFFF; height:382px; padding:2px;">
<p>This will give you an indication of how well you will be able to view <i>Bookflix</i>. If your bandwidth falls within the red range you may have some difficulty. Yellow and green indicate more bandwidth and therefore better viewing.<br><br>  Note: This test represents your bandwidth at a given point in time. Factors such as network traffic and other applications you have open can affect network performance.  
</p>
<b>Legend:</b>
<table border=1 cellpadding="2" cellspacing="0" width=300>
	<tr valign="top">
		<td align=left style="font-weight:bolder; color:#FF0066;">
		Poor (red)
		</td>
		<td align=left>
		0 to 350 kpbs
		</td>
	</tr>
	<tr valign="top">
		<td align=left style="font-weight:bolder; color:#FFD700;">
		Good (yellow)
		</td>
		<td align=left>
		351 kbps to 768 kbps
		</td>
	</tr>
	<tr valign="top">
		<td align=left style="font-weight:bolder; color:#00CD66;">
		Excellent (green)
		</td>
		<td align=left>
		> 768 kbps
		</td>
	</tr>		
</table>		

<p><b>Your Bandwidth:</b> <span style="font-weight:bolder; color:<?php echo $BarColor;?>;"> <?php echo $kbps;?></span> (measured in Kbps) </p>

<table border=0 cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell1;?>">
	0
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell2;?>">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell3;?>">
	256
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell4;?>">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell5;?>">
	383
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell6;?>">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell7;?>">
	1024
	</td>
	<td align=right width=60 style="font-weight:bolder; <?php echo $cell8;?>">
	&nbsp;
	</td>	
	<td align=right width=60 style="font-weight:bolder; <?php echo $cell9;?>">
	&nbsp;
	</td>	
	<td align=right width=60 style="font-weight:bolder; <?php echo $cell10;?>">
	&nbsp;
	</td>		
	<td align=left width=60 style="font-weight:bolder; <?php echo $cell11;?>">
	46080
	</td>							
	</tr>
<tr valign="top">
	<td align=left width=60 style="font-weight:bolder;">
	Dial-up
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	DSL
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
	<td align=left width=60 style="font-weight:bolder;">
	T-1
	</td>
		<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
		<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>
		<td align=left width=60 style="font-weight:bolder;">
	&nbsp;
	</td>		
	<td align=left width=60 style="font-weight:bolder;">
	T-3
	</td>						
	</tr>	
</table>	

<br>

<center><a href="javascript:window.close();">Close</a></center>
</div>
</body>
</html>