<?php
class DataGrid {
	public $seperate = false;
	public $tbl;

	public function table($result) {
      $n = 0;
      $formatted_fields = "";          
         while($row = mysqli_fetch_row($result)) {
         	if($this->seperate == false) { 
         	    $formatted_fields .= "<tr>";
         	}
            for($i=0; $i<sizeof($row); $i++) {
                $fields[$n][$i] = $row[$i];
                if($this->seperate == false) {
                    $formatted_fields .= "<td class=\"fields\">".$fields[$n][$i]."</td>";
                }
            }
            $n++;
            if($this->seperate == false) { 
         	    $formatted_fields .= "</tr>";
         	}   
          }
          if($this->seperate == false) { 
         	    return $formatted_fields;
          } else {
               return $fields;
          }
	}  	
}
        

?>