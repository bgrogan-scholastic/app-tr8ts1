<?php
require_once('DB.php');

class cchome
{
	private $_db;
	
	public function __construct()
	{
		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		
	}
	
	public function getContinents()
 { 
 
 	$sql='select id,name from continents';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["id"];
    $name=$row["name"];
    $options.="<option  value=\"$id\">".$name.'</option>';
	} 
	return $options;
 }
 
 
 
 public  function getCountries()
 {
 	$sql='select id,name from countrycross order by name';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["id"];
    $name=$row["name"];
    $options.="<option  value=\"$id\">".$name.'</option>';
	} 
	return $options;
 }
  public function getStates()
 { 
 	$sql='select id,name from provcross order by name';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["id"];
    $name=$row["name"];
    $options.="<option  value=\"$id\">".$name.'</option>';
	} 
	return $options;
 }
 public function getContinentName($id){
 	$sql='select id,name from continents where id = \''.$id.'\'';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    			$name=$row["name"];
    		
    
		} 
	return $name;
 	
 }
 public function getCountryName($id){
 	$sql='select id,name from countrycross where id = \''.$id.'\'';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    			$name=$row["name"];
    
		} 
	return $name;
 	
 }
 public function getStateName($id){
 	$sql='select id,name from provcross where id = \''.$id.'\'';
 	$result =& $this->_db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    			$name=$row["name"];
    
		} 
	return $name;
 	
 }
 
 
}
?>