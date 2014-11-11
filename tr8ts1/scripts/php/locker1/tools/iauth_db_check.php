<?php	
		//IAUTH Connection Test
		$iauthDBConn = new mysqli($_SERVER['IAUTH_SERVERNAME'], $_SERVER['IAUTH_USERNAME'], $_SERVER['IAUTH_PASSWORD'], $_SERVER['IAUTH_DATABASE_NAME']) ;

		if (mysqli_connect_errno()) 
		{
			echo "Database Connection Error on IAuth. ".$_SERVER['IAUTH_SERVERNAME'].' '.$_SERVER['IAUTH_USERNAME'].' '.$_SERVER['IAUTH_PASSWORD'].' '.$_SERVER['IAUTH_DATABASE_NAME'];
		}
		else 
		{
			echo "Connection to IAUTH - SUCCESSFUL";
			
		}
		
		echo '<br><br><a href="/lockertools/locker_monitor.php">Back to the Locker Monitor</a>';	
?>