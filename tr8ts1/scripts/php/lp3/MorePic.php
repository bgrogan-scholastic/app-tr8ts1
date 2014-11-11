<?php

require_once('DB.php');
include $_SERVER['COMMON_CONFIG_PATH'] . '/GI_ProductConfig.php';
 $searchBaseHref = GI_ProductConfig::getBaseHref('go3-passport');
 
class More_Pic extends GI_Base
{
	private $_db;
	protected $_asset;

	public function __construct(){

		$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		
	}
	public function getImage($assetid,$type)
	{
		
		$sql = 'select  m2.uid,m2.slp_id, m2.title_ent,m2.type,m2.fext from manifest m1, manifest m2 where m1.slp_id='.$assetid.' and m1.uid=m2.puid and m2.type=\''.$type.'\'';
		$count=1;
		$result =& $this->_db->query($sql);

		$html ='<table>';
		
		$html.='<tr>';
		while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$html .= '<td width="147" ><a href="/picture/'.$dbrow['slp_id'].'/'.$dbrow['uid'].'"><img src="/csimage?product_id=lp&id='.$dbrow['slp_id'].'t&ext='.$dbrow['fext'].'" alt="'.$dbrow['title_ent'].' "border="0" /></a><br>';
						
			$html .= '<a href="/picture/'.$dbrow['slp_id'].'/'.$dbrow['uid'].'"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'.$dbrow['title_ent'].'</font></a></td>';

			if($count>=3)
			{
				$html.=	'</tr><tr>';
				$count=0;						
			}
			$count++;		
		}
		$html.='</tr>';	
	   $html .= '</table>';
	   return $html;

	}
	
	public function getMap($assetid,$type)
	{
	$searchBaseHref = GI_ProductConfig::getBaseHref('go3-passport');
		$sql = 'select m2.uid,m2.slp_id, m2.title_ent,m2.type,m2.fext from manifest m1, manifest m2 where m1.slp_id='.$assetid.' and m1.uid=m2.puid and m2.type like \''.$type.'\'';
		$count=1;
		$result =& $this->_db->query($sql);

		$html ='<table border="0" cellspacing="10" cellpadding="5">';
			
		$html.='<tr>';
		
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{			
					
			$html .= '<td width="147" align="center"><a href="'.$searchBaseHref.'/atlas?id='.$dbrow['slp_id'].'" ><img src="/csimage?product_id=go&id='.$dbrow['slp_id'].'&width=90&ext=png" alt="'.$dbrow['title_ent'].'"border="0"  /></a><br>';
				
			$html .= '<a href="'.$searchBaseHref.'/atlas?id='.$dbrow['slp_id'].'"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">'.$dbrow['title_ent'].'</font></a></td>';
			
			if($count>=3)
			{
				$html.=	'</tr><tr>';
				$count=0;						
			}
		
			$count++;
					    
		}				
	   $html .= '</table>';
	   
	   return $html;
	}
		
}
?>