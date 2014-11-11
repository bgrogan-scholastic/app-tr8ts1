<html>
	<head>
		<title>Soap Prototype</title>
	</head>
	<body>
<h2> Shard Statistics </h2>
		<table border=1;>
			<tr>
				<td>shardid</td>
				<td>hostname</td>
				<td>totalusers</td>
				<td>totalparents</td>
				<td>totalassignments</td>
				<td>totalgroups</td>
				<td>totalnotecards</td>
				<td>totalcitations</td>
				<td>totaltasks</td>
				<td>totalsavedassets</td>
			</tr>
		

<?php

	require($_SERVER["PHP_INCLUDE_HOME"]."locker1/data_classes/locker_line.php");
	require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
	$locker_client = new Locker_Client();
	
	$shardlist = $locker_client->getcompleteshardlist();
	
	for ($i = 0; $i<=count($shardlist); $i++)
	{
		echo '<tr>';
		echo '<td>'.$shardlist[$i]->shardid.'</td>';
		echo '<td>'.$shardlist[$i]->hostname.'</td>';
		echo '<td>'.$shardlist[$i]->totalusers.'</td>';
		echo '<td>'.$shardlist[$i]->totalparents.'</td>';
		echo '<td>'.$shardlist[$i]->totalassignments.'</td>';
		echo '<td>'.$shardlist[$i]->totalgroups.'</td>';
		echo '<td>'.$shardlist[$i]->totalnotecards.'</td>';
		echo '<td>'.$shardlist[$i]->totalcitations.'</td>';
		echo '<td>'.$shardlist[$i]->totaltasks.'</td>';
		echo '<td>'.$shardlist[$i]->totalsavedassets.'</td>';
		echo '</tr>';
	}
	
?>
		</table>
	</body>
</html>