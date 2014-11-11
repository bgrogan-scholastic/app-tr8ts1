<?php //echo $_GET['rate'] ;

	$kbps = round($_GET['rate'], 2);
	$ksec = round($kbps / 8, 2);
	$mbps = round($kbps / 1024, 2);
	$msec = round($mbps / 8, 2);
echo $kbps;
   if ($msec > 1) {
      echo "<font size=+0 color=black>you can download at " . $msec . " MB/sec. from our servers.</font>";
   } else {
      echo "<font size=+0 color=black>you can download at " . $ksec . " KB/sec. from our servers.</font>";
   }
   
?>