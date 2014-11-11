<?php

require_once("DBConn.php");

class DataGrid extends DBConn {
	// main entry point - decides what type of formatting for result sets, if any
	//$sql param can be any result, sql string or array
	//$mode is 0 - no formatting, 1 - just <td>$field</td>, 2 - <tr><td>$field</td></tr>
	//$type is LOOP, TABLE, FORM	
	public function formatResult( $sql, $mode, $type ) {
		switch ( $type ) {
			case TABLE:				
				$result = $this->query($sql);
				return $this->table( $result, $mode );
			break;
			case FORM:
				$result = $sql;
				return $this->form( $result, $mode );
			break;
			case LOOP:
				$arr = $sql;
				return $this->tableHeadings( $arr );
			break;
		}
	}
	
	// mode 0 returns no formatting, just $fields array in table type
	private function table( $result, $mode ) {
      $n = 0;
      $formatted_fields = '';
      while( $row = mysqli_fetch_row($result ) ) {
         if( $mode == 2 ) { 
         	    $formatted_fields .= "<tr>";
         }
         for( $i=0; $i < sizeof( $row ); $i++ ) {
                $fields[$n][$i] = $row[$i];                
                    $formatted_fields .= "<td class=\"fields\">".$fields[$n][$i]."</td>";                             }
         if( $mode == 2 ) { 
         	    $formatted_fields .= "</tr>";
         } 
         	$n++;  
         }
          if( $mode == 0 ) {
          	   mysqli_free_result($result);
               return $fields;
         } else {
         	   mysqli_free_result($result);
          	   return $formatted_fields;
         }
	}
		
	// formats a single row of column names for headings
	private function tableHeadings( $arr ) {
		$headings = "<tr>";
        for($i=0; $i<sizeof($arr); $i++) {
	        $headings .= "<td class=\"headings\">".$arr[$i]."</td>";
	    }
        $headings .= "</tr>";
        return $headings;
	}
	
	private function form($row, $headings) {
		$n=0;
	    while($n<sizeof($row)) {
	    echo '<tr>';
	        for($i=0; $i<sizeof($headings); $i++) {	    	
	    	    if($i==0) { 
	               echo '<td class="fields"><input type="radio" name="slp_id" value="'.$row[$n][$i].'" />';  
	               echo $row[$n][$i];
	               echo "</td>"; 
	    	    } else {
	    		echo '<td class="fields">';
	            echo $row[$n][$i];
	            echo "</td>";
	    	    }
	        }
	        echo "</tr>";
	        $n++;
	    }
	}
}
        
?>