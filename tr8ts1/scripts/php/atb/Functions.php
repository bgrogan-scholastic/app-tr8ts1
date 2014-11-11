<?php
class Functions {

	function getCategory($asset) {
       $sci_tech[0][0] = 'atbe2420';
       $sci_tech[0][1] = "Science And Technology";

       $arts_ent[1][0] = 'atbe2421';
       $arts_ent[1][1] = "Arts And Entertainment";

       $us_hist[2][0] = 'atbe2324';
       $us_hist[2][1] = "U.S. History";

       $world_hist[3][0] = 'atbe2355';
       $world_hist[3][1] = "World History";

       $writ_word[4][0] = 'atbe2419';
       $writ_word[4][1] = "Written Word";
	
	    switch($asset) {
		    case $asset == $sci_tech[0][0]:
		    return $sci_tech[0][1];
	        break;
	        case $asset == $us_hist[2][0]:
		    return $us_hist[2][1];
	        break;
	        case $asset == $arts_ent[1][0]:
		    return $arts_ent[1][1];
	        break;
	        case $asset == $world_hist[3][0]:
		    return $world_hist[3][1];
	        break;
	        case $asset == $writ_word[4][0]:
	    	return $writ_word[4][1];
	        break;
	        default:
	    	return "&nbsp;";	    
	    }
    }
    
    function evaluate($start_date1, $start_date2){
    	if($start_date1 < $start_date2) {	
    		return "less";
        } else       	
        if($start_date1 > $start_date2) { 
        	return "greater";
        } else
        if($start_date1 == $start_date2) { 
        	return "equals";
		}   
    }
    
    function getColName($result) {
    	while($row1=mysqli_fetch_row($result)){ 
	        return $row1[0];
	    }
    }
    
    function convertYear($year) {
	    if($year < 10) { 
    		return substr($year,3,1);
    	} elseif($year < 100) { 
    		return substr($year,2,2);
    	} elseif ($year < 1000) {
    		return substr($year,1,3);
    	} else {	
	        return $year;
	    }
    }
}
?>