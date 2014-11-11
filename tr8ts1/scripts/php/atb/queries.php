<?php
// connects to database
$db = new DBConn($mysqli);
// get results back in array for display
$format = new DataGrid();
// several additional functions for output and comparing dates
$func = new Functions();

$assetid1 = $_GET['assetid'];
$assetid2 = $_GET['assetid2'];

// states assets atbe0022 - different than category assets - atbe2324
// get the last 4 characters(numbers) from assetid's because 
//db state_base(id) = start with atb instead of atbe
$statesAssetid1 = substr($assetid1, 5, 3);
$statesAssetid2 = substr($assetid2, 5, 3);
// test for 00 at beginning to match state id
$statesTest1 = substr($assetid1, 4, 2);
$statesTest2 = substr($assetid2, 4, 2);
// gets all us history if only assetid1
// gets first row for categories or states comparison
// creates - $column1 heading, $column2 heading, $fields1[], $start_date1[]
if($assetid1) {
  $whereCla = "Where id = '".$assetid1."' ORDER BY start_date";
  $queryFields = "Select `id`,`start_date`,`text` From atb.tlevents $whereCla";

  $format->seperate = true;
  $resultFields = $db->dbQuery($queryFields);
  $fields = $format->table($resultFields);	

    // get the date from the text field for row 1
	if($resultFields) {
        for($i=0; $i<sizeof($fields); $i++) {		    
		    $start_date1[$i] = substr($fields[$i][1], 0, 4);		   
        }     
    } else { echo mysqli_error($mysqli); }	
}

// check for stimeline popup page for state and us- atbe1222 will be assetid sub string for us
if($assetid2=='atbe1222') { 
	$query_column1 = "SELECT state_name FROM atb.states Where state_base = 'atb".$statesAssetid1."'";
	$resultColumn1 = $db->dbQuery($query_column1); 
	$column1 = $func->getColName($resultColumn1);
	
	$query_column2 = "SELECT title FROM atb.assets Where id = 'atbe1222'";
	$format->seperate = true;
	$resultColumn2 = $db->dbQuery($query_column2);
	$column2 = $func->getColName($resultColumn2);
    
    $whereCla2 = "Where id = 'atbe1222' ORDER BY start_date";
    $queryFields2 = "Select `id`,`start_date`,`text` From atb.tlevents $whereCla2";

    $resultFields2 = $db->dbQuery($queryFields2);
    $fields2 = $format->table($resultFields2);	

    // get the date from the text field for row 2
	if($resultFields2) {
        for($i=0; $i<sizeof($fields2); $i++) {
		    $start_date2[$i] = substr($fields2[$i][1], 0, 4);
	    }     
    } else { echo mysqli_error($mysqli); }	
}

// gets second row for categories or states comparison
// creates - $column1, $column2, $fields2[], $start_date2[]
elseif($assetid2) {
   if($statesTest1 == '0' || $statesTest2 == '0') {	
	   $query_column1 = "SELECT state_name FROM atb.states Where state_base = 'atb".$statesAssetid1."'";
	   $resultColumn1 = $db->dbQuery($query_column1); 
	   $column1 = $func->getColName($resultColumn1);
	
	   $query_column2 = "SELECT state_name FROM atb.states Where state_base = 'atb".$statesAssetid2."'";
	   $format->seperate = true;
	   $resultColumn2 = $db->dbQuery($query_column2);
	   $column2 = $func->getColName($resultColumn2);
    } else {
	    $column2 = $func->getCategory($assetid2);
    }

    
    $whereCla2 = "Where id = '".$assetid2."' ORDER BY start_date";
    $queryFields2 = "Select `id`,`start_date`,`text` From atb.tlevents $whereCla2";

    $resultFields2 = $db->dbQuery($queryFields2);
    $fields2 = $format->table($resultFields2);	

    // get the date from the text field for row 2
	if($resultFields2) {
        for($i=0; $i<sizeof($fields2); $i++) {
		    $start_date2[$i] = substr($fields2[$i][1], 0, 4);
	    }     
    } else { echo mysqli_error($mysqli); }	
}



?>