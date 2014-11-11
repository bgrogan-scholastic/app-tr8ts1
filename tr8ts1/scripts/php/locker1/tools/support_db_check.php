<?php	

class Support_Tester
{
	public function test($shardid)
	{		
	//IAUTH Connection Test
		$iauthDBConn = new mysqli($_SERVER['IAUTH_SERVERNAME'], $_SERVER['IAUTH_USERNAME'], $_SERVER['IAUTH_PASSWORD'], $_SERVER['IAUTH_DATABASE_NAME']) ;

		if (mysqli_connect_errno()) 
		{
			echo "Database Connection Error on iauth - ".$_SERVER['IAUTH_SERVERNAME'].' '.$_SERVER['IAUTH_USERNAME'].' '.$_SERVER['IAUTH_PASSWORD'].' '.$_SERVER['IAUTH_DATABASE_NAME']."<br>";
			return;
		}
		
		$statement = $iauthDBConn->prepare("SELECT * from shard where shard_id = $shardid;");
		$statement->execute();	
		$row = $this->getresult($statement);
		echo "Shard:<br>";
		print_r($row);
		echo'<br>';
	
		$lockerdbConn = new mysqli($row[0]['db_hostname'],$row[0]['db_username'],$row[0]['db_password'], $_SERVER['LOCKER_SUPPORT_DATABASE_NAME'],$row[0]['db_port']) ;

		if (mysqli_connect_errno()) 
		{
			echo "Database Connection Error on locker1support - ".$row[0]['db_hostname'].' , '.$row[0]['db_username'].' , '.$row[0]['db_password'].' , '. $_SERVER['LOCKER_SUPPORT_DATABASE_NAME'].' , '.$row[0]['db_port']."<br>";
		}	 
		else 
		{
			echo "Connection to LOCKER SUPPORT - SUCCESSFUL - ".$row[0]['db_hostname'].' , '.$row[0]['db_username'].' , '.$row[0]['db_password'].' , '. $_SERVER['LOCKER_SUPPORT_DATABASE_NAME'].' , '.$row[0]['db_port']."<br>";
		}            	

	}	
	
	
	private function getresult($stmt)
	{
	      $result = array();
	     
	      $metadata = $stmt->result_metadata();
	      $fields = $metadata->fetch_fields();
	
	      for (;;)
	      {
	        $pointers = array();
	        //$row = new stdClass();
	        $row = array();
	       
	        $pointers[] = $stmt;
	        foreach ($fields as $field)
	        {
	          	$fieldname = $field->name;
	          	//$pointers[] = &$row->$fieldname;<br>
				$pointers[] = &$row[$fieldname];
				//echo $fieldname."<br>";
	        }
	        
	       
	        call_user_func_array(mysqli_stmt_bind_result, $pointers);
	       
	        if (!$stmt->fetch())
	          break;
	       
	        $result[] = $row;
	      }
	     
	      $metadata->free();
	     
	      return $result;
	}	

}

$supporttest = new Support_Tester();

echo "<pre>";
print_r($supporttest->test(1));
echo "</pre>";
echo '<br><br><a href="/lockertools/locker_monitor.php">Back to the Locker Monitor</a>';	
?>