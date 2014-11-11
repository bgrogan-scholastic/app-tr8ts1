<?php
require_once('DB.php');
include_once($_SERVER['COMMON_CONFIG_PATH'] . '/GI_ProductConfig.php');

class GetMapValues
{
	private $_db;
	
	private $baseUrl;
	
	public function __construct()
	{
		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		$this->baseUrl = GI_ProductConfig::getBaseHref('go3-passport');
	}
	
	public function getContinents()
 { 
 	
  
 $sql="select distinct manifest.slp_id,continents.name from manifest,continents where manifest.ada_text=continents.name and manifest.type like '0mm%' and manifest.category is null"; 
 $result =& $this->_db->query($sql);
 
 $options=""; 
 while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["slp_id"];
    $name=$row["name"];
    $options.="<option  value=\"$id\">".$name.'</option>';
	} 
	return $options;
 }
 public function getCountries()
 {  
 	
 $sql=" select  distinct countrycross.name,manifest.slp_id from manifest join countrycross on manifest.title_ascii=countrycross.name and manifest.type like '0mm%'order by countrycross.name"; 
$result =& $this->_db->query($sql);

 $options=""; 
 while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["slp_id"];
    $name=$row["name"];
    $options.="<OPTION VALUE=\"$id\">".$name.'</option>';
	} 
	return $options;
 }
  public function getStates()
 { 
 	
 $sql="select  distinct provcross.name,manifest.slp_id from manifest join provcross on manifest.title_ascii=provcross.name and manifest.type like '0mm%'order by provcross.name"; 
$result =& $this->_db->query($sql); 


 $options=""; 
 while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
    $id=$row["slp_id"];
    $name=$row["name"];
    $options.="<OPTION VALUE=\"$id\">".$name.'</option>';

	} 
	return $options;
 }
	public function Get_categories($id)
	{
	$sql='select title_ent,slp_id from manifest where type like "0mm%" and category="'.$id.'" order by title_ent' ;
	$i=1;
	$result =& $this->_db->query($sql); 
	
		
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{
	
		$dbrow .=$i.' '.'<a href="'.$this->baseUrl.'/atlas?id='.$row['slp_id'].'"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'. $row['title_ent'] .'</font></a>'. '<br>'; 
		
		$i++;
	}
	return $dbrow;
	}
	
}
?>