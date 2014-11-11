<?php

class DBConn {
   
   public function __construct(mysqli $mysqli) {
     $this->mysqli = $mysqli;
     if(mysqli_errno($this->mysqli)) {
     	echo mysqli_connect_error($this->mysqli);
     }
   }

   // this method needs no error handling when instanciated 
   public function query($sql) {
	   $result = $this->mysqli->query($sql);
	   if($result) {
	   	  return $result;
	   } else {
	   	    echo $this->mysqli->error();
	   }
	   mysqli_close($this->mysqli);
   }
 
}

?>