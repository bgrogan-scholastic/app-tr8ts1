<?php	

class Shard_Tester
{
	public function test()
	{		
	//IAUTH Connection Test
		$iauthDBConn = new mysqli($_SERVER['IAUTH_SERVERNAME'], $_SERVER['IAUTH_USERNAME'], $_SERVER['IAUTH_PASSWORD'], $_SERVER['IAUTH_DATABASE_NAME']) ;

		if (mysqli_connect_errno()) 
		{
			echo "Database Connection Error on iauth - ".$_SERVER['IAUTH_SERVERNAME'].' '.$_SERVER['IAUTH_USERNAME'].' '.$_SERVER['IAUTH_PASSWORD'].' '.$_SERVER['IAUTH_DATABASE_NAME']."<br>";
			return;
		}
		$statement = $iauthDBConn->prepare("SELECT * from shard;");
		$statement->execute();	
		$row = $this->getresult($statement);
		echo "List of Shards:<br>";
		print_r($row);
		echo'<br>';
		
		foreach ($row as $key => $val) 
		{
			$lockerdbConn = new mysqli($row[$key]['db_hostname'],$row[$key]['db_username'],$row[$key]['db_password'],$row[$key]['db_name'],$row[$key]['db_port']) ;

			if (mysqli_connect_errno()) 
			{
				echo "Database Connection Error on locker1 - ".$row[$key]['db_hostname'].' , '.$row[$key]['db_username'].' , '.$row[$key]['db_password'].' , '.$row[$key]['db_name'].' , '.$row[$key]['db_port']."<br>";
			}	 
			else 
			{
				echo "$key) Connection to LOCKER - SUCCESSFUL - ".$row[$key]['db_hostname'].' , '.$row[$key]['db_username'].' , '.$row[$key]['db_password'].' , '.$row[$key]['db_name'].' , '.$row[$key]['db_port']."<br>";
			}            	
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

$shardtest = new Shard_Tester();

echo "<pre>";
print_r($shardtest->test());
echo "</pre>";
echo '<br><br><a href="/lockertools/locker_monitor.php">Back to the Locker Monitor</a>';	

?>