<?php
require_once("DBConn.php");

class DataGrid extends DBConn {
	// main entry point - decides what type of formatting for result sets, if any
	public function formatResult( $result, $mode, $type ) {
		switch ( $type ) {
			case "table":
				return $this->table( $result, $mode );
			break;
			case "form":
				return $this->form( $result );
			break;
		}
	}
	
		// mode 0 returns no formatting, just $fields array in table type
	private function table( $result, $mode ) {
      $n = 0;
      if( $mode == 3 ) {
         $formatted_fields .= "<table>";
      }          
         while( $row = mysqli_fetch_row($result ) ) {
         	if( $mode == 2 ) { 
         	    $formatted_fields .= "<tr>";
         	}
            for( $i=0; $i < sizeof( $row ); $i++ ) {
                $fields[$n][$i] = $row[$i];
                if( $mode != 0 ) {
                    $formatted_fields .= "<td class=\"fields\">".$fields[$n][$i]."</td>";
                }                                        
            }
            if( $mode == 2 ) { 
         	    $formatted_fields .= "</tr>";
         	} 
         	$n++;  
          }
          if( $mode == 3 ) {
          	  $formatted_fields .= "</table>";
          } else if( $mode == 0 ) {
               return $fields;
          } else {
          	   return $formatted_fields;
          }
	}

	private function form( $result ) {
		// TODO
	}
}
        
?>