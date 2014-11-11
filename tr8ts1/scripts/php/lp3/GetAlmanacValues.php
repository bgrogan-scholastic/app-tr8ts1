<?php
require_once('DB.php');
include_once($_SERVER['COMMON_CONFIG_PATH'] . '/GI_ProductConfig.php');


class GetAlmanacValues extends GI_Base
{
	
	private $_db;
	public function __construct(){

		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		$this->baseUrl = GI_ProductConfig::getBaseHref('lp');
		
	}
	public function GetFacts($type)
	{
		$sql='select p.title_ent, c.slp_id from manifest p, manifest c where c.puid=p.uid and c.type=\''.$type.'\' and p.title_ent is not null order by title_ent ASC';
		$dbrow = '<table>';
		$result =& $this->_db->query($sql);
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .='<tr><td><a href="'.$this->baseUrl.'/almanac?id='.$row['slp_id'].'">'. $row['title_ent'] .'</a></td></tr>';
						
		}
		
		return $dbrow.'</table>';
		
	}
	public function GetFlags($type)
	{
		$sql='select CONCAT(p.title_ent,"  ,flag of") title_ent, c.slp_id,c.uid,c.src_product_id from manifest p, manifest c where c.puid=p.uid and c.type=\''.$type.'\' and p.title_ent is not null order by title_ent ASC';
		$dbrow = '<table>';
		$result =& $this->_db->query($sql);
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .='<tr><td><a href="flag/'.$row['slp_id'].'/'.$row['uid'].'/'.$row['src_product_id'].'"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'. $row['title_ent'] .'</font></a></td></tr>';
						
		}
		
		return $dbrow.'</table>';
		//<font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
	}
	
	public function GetSelectReading($type)
	{
		$sql='select distinct CONCAT("Selected Readings   " ,title_ent) title_ent, slp_id from manifest where type=\''.$type.'\' and title_ent is not null order by title_ent ASC';
		$dbrow = '<table>';
		$result =& $this->_db->query($sql);
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .='<tr><td><a href="javascript:loadParentWindowAndClose(\'/reading/'.$row['slp_id'].'\');"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'.$row['title_ent'] .'</font></a></td></tr>';
			
		}
	return $dbrow.'</table>';
	}
	public function GetChartTable($type)
	{
		$sql='select distinct title_ent, slp_id from manifest where type=\''.$type.'\' and title_ent is not null order by title_ent ASC';
		$dbrow = '<table>';
		$result =& $this->_db->query($sql);
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .='<tr><td><a href="table/'.$row['slp_id'].'"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'. $row['title_ent'] .'</font></a></td></tr>';
		}
		
		return $dbrow.'</table>';
	}
	public function GetFactsReadings($type)
	{
		$sql='select slp_id,title_ent from manifest where type=\''.$type.'\' order by title_ent';

		$dbrow = '<table>';
		$result =& $this->_db->query($sql);
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .='<tr><td><a href="javascript:loadParentWindowAndClose(\'/factbox/'.$row['slp_id'].'\');"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'.$row['title_ent'] .'</font></a></td></tr>';
			
		}
	return $dbrow.'</table>';
		
	}
}
?>
		
		
	

