<?php
class DBConn extends mysqli {
   private $mysqli;
   
   public function __construct(array $str) {
     return $this->mysqli = mysqli_connect($str[0],$str[1],$str[2],$str[3])
                                         or die(mysqli_connect_error($mysqli));
   }

   // this method needs no error handling when instanciated 
   public function query($sql) {
	   $result = mysqli_query($this->mysqli, $sql);
	   if($result) {
	   	  return $result;
	   } else {
	   	    echo mysqli_error($this->mysqli);
	   }
	   mysqli_close($this->mysqli);
   }
   
}
?>