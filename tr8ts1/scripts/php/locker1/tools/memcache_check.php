<?php
	//Memcache Test
	$memcache = new Memcache;
	
	if($memcache->connect($_SERVER['SERVER_ADDR'], 11211))
	{
		//MEMCACHE
		echo "Connection to Memcache - SUCCESSFUL - ".$_SERVER['SERVER_NAME'];
	}
	else 
	{
		echo "Cannot Connect to Memcache. - FAIL - ".$_SERVER['SERVER_NAME'];
		
	}

	echo '<br><br><a href="/lockertools/locker_monitor.php">Back to the Locker Monitor</a>';	
?>
