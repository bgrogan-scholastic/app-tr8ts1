<?php

require_once('DB.php');
class SideBar extends GI_Base
{
	private $_db;
	
	public function __construct(){

		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		
	}
	
	public  function GetValues($id,$type1,$type2)
	{
		$sql='select c.slp_id,c.title_ent from manifest p, manifest c where p.slp_id='.$id.' and p.uid=c.puid and c.type in (\''.$type1.'\' ,\''.$type2.'\' )order by c.priority ASC, c.title_ent ASC';
		
		$i=1;
	
		$result =& $this->_db->query($sql);
	
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dbrow .=$i.' '.'<a href="javascript:loadParentWindowAndClose(\'/sidebar/'.$row['slp_id'].'\');"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'.$row['title_ent'] .'</font></a>'. '<br>';
			$i++;			
		}
		
		return $dbrow;
	}
}


?>