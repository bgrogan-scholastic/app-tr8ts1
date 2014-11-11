<?php

require_once($_SERVER["SCRIPTS_HOME"] . "/nbk3/common/GI_DBList.php");


$mismatch_query = "select distinct ndate, id,seq, substring(id, 5, 1) mychar from nassets where type='0mp' and substring(id, 5, 1) <> seq order by ndate asc";
$mismatch_totals = "select dayofmonth(ndate) mday, month(ndate) mmonth, year(ndate) myear, count(*) total from nassets where type='0mp' and substring(id, 5, 1) <> seq group by dayofmonth(ndate), month(ndate), year(ndate) order by ndate asc";

$mmq[0]['query'] = $mismatch_query;
$mmq[0]['entry'] = array('text', "<tr><td>##NDATE##</td><td>##ID##</td><td>##SEQ##</td><td>##MYCHAR##</td></tr>\n");

$mmq2[0]['query'] = $mismatch_totals;
$mmq2[0]['entry'] = array('text', "<tr><td>##MMONTH##/##MDAY##/##MYEAR##</td><td align=\"center\">##TOTAL##</td></tr>\n");

?>
<html>
<head>
<title>Mismatched News Pictures / ID's</title>
<style>

.row1 {
 background: #99CCFF;
}

.row2 {
 background: #0099cc;
}
</style>
</head>
<body>

<table border="1" cellpadding="5" cellspacing="5" width="100%">
<tr>

<td valign="top" width="45%">
<table border="1" cellpadding="5" cellspacing="5" width="100%">
<tr><td>N_DATE</td><td>ID</td><td>Sequence<br>(From the DB)</td><td>Sequence Number Should be<br>(According to the ID)</td></tr>
<?php 
$myList2 = new GI_DBList($mmq); 
$myList2->Output(); 
?>
</table>
</td>

<td>&nbsp;</td>

<td valign="top" width="45%">
<table border="1" cellpadding="5" cellspacing="5" width="100%">
<tr><td>Date</td><td>Number of Mis-named items</td></tr>
<?php
$myList3 = new GI_DBList($mmq2); 
$myList3->Output(); 
?>
</table>
</td>


</tr>
</table>

</body>
</html>



