<?php
class DBConn {
   private $mysqli;
   
   public function __construct(mysqli $mysqli) {
     $this->mysqli = $mysqli;
     if(mysqli_errno($this->mysqli)) {
     	echo mysqli_connect_error($this->mysqli);
     }
   }
   
   public function dbQuery($sql) {
	   $result = $this->mysqli->query($sql);
	   if($result) {
	   	  return $result;
	   } else {
	   	    echo mysqli_connect_error($this->mysqli);
	   }
	   mysqli_close($this->mysqli);
   }
}
?>