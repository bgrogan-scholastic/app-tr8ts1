<?php
 
	//************************************************************************
	//	 			 GENERATE XML for the SWF SHUFFLE						//
	//Fetches data from the MANIFEST table and creates elements of XML	    //
	//	 			 			STRICTLY FOR ETO							//
	//************************************************************************

require_once('DB.php');
require_once($_SERVER['LOCKER'] .'/locker1/client/locker_soap_client.php');
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");

//GET courses, IF NOT SET make it 1
if(!isset($_GET['courses'])){
	$_GET['courses']=1;
	 
} 

class shuffleFeed_ETO{
	protected $_db;
	protected $_db_eto;
	protected $_ngo_spaces;
	protected $_eto_Relevant_spaces;
	protected $_eto_spaces;
	protected $_eto_uid;
	protected $_ngo_spaceList;
    protected $_ngo_Nodes;
    protected $_studentSpace;
    protected $_xml_output;
    protected $_AllSpaces;
    protected $_totalXtraReleventSpaces = 9;
	 
	//************************************************************************
	// 			set to true if TEMPORARY spots are desired					//
	//************************************************************************
 
  	protected $_fillInTempSpaces=true;
   
 
	//************************************************************************
	//						ESTABLISH Connect Strings						//
	//************************************************************************
 
   	
   		public function __construct(){
   			
   			$cookiereader = new Cookie_Reader('xs');
   			$profileid = $cookiereader->getprofileid();
   			
			//************************************************************************   		
			//			get connect strings to both ETO and NGO                     //
			//************************************************************************
				$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
				if (DB::isError($db)) {
					echo "Error:  Could not retrieve mysql connect string for eto DB";
				}
				else {
					$sql = sprintf("select value from appenv where app='eto' and key_name='product_db';");
					$result = $db->query($sql)->fetchrow();
					$db->disconnect ();
					$db_eto=$result[0];
				}
				$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
				if (DB::isError($db)) {
					echo "Error:  Could not retrieve mysql connect string for ngo Db";
				}
				else {
					$sql = sprintf("select value from appenv where app='ngo' and key_name='product_db';");
					$result = $db->query($sql)->fetchrow();
					$db->disconnect ();
					$db_ngo=$result[0];
				}
				//************************************************************************
				//connect to ETO as $this->_db_eto
				//************************************************************************
				$this->_db_eto = DB::connect($db_eto);
								
				if (DB::isError($db_eto)) {
					$this->_raiseError('No database connection', 8, 1);
					return;
				}
				//************************************************************************
				//connect to NGO as $this->_db
				//************************************************************************
				$this->_db = DB::connect($db_ngo);
				if (DB::isError($db_ngo)) {
					$this->_raiseError('No database connection', 8, 1);
					return;
				}
		 
				
		if (!PEAR::isError($this->_db) && !PEAR::isError($this->_db_eto)) {

	
				//************************************************************************
				//	 						GET ETO SPACES								//
				//				from MANIFEST, WORKSHOP and COURSES table 				// 
				//************************************************************************
 
			$query_eto = "SELECT manifest.uid, workshops.slp_id, manifest.ada_text , manifest.type 
						  FROM manifest, workshops, courses 
						  WHERE workshops.course_name=courses.name 
						  AND courses.course_id='".$_GET['courses']."' 
						  AND workshops.slp_id=manifest.slp_id 
						  ORDER BY manifest.ada_text ASC";  
 
			$result =& $this->_db_eto->query($query_eto);
						 
			 	$i=0;
			 	
				if (!DB::isError($result)) 
				{
									
						while($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
						{
							$this->_eto_uid[$i]= $row['uid'];
							$this->_eto_spaces[$i]= $row['slp_id'];
							$i++;
						}
							
				//end IS ERROR			
				}
				else
					{
						echo "ETO DB Error";
						die;
													
					}
			 
			 
			//************************************************************************
			//		 						END GET ETO SPACES						//
			//************************************************************************			
			 
		   
			//************************************************************************
			//		 						GET RELATED SPACES						//
			//************************************************************************		
			 
			$i=0;
				foreach ($this->_eto_uid as $value)
				 {
				 	 
     
				 	$query_eto = "select * from manifest where puid='".$value."' and type='0c';";
				 	$result_eto =& $this->_db_eto->query($query_eto);		
				 			 	
					 if (DB::isError($result_eto))
					 {
					 	echo "ETO DB Error";
					 	die;	 
					 }
				
						while($Result_eto =& $result_eto->fetchRow(DB_FETCHMODE_ASSOC))
						{
		 		
							$query_ngo = "SELECT p.sb_parent_id 'parentId',
										  c.sb_parent_id 'nodeId', c.sb_child_id 'spaceId' ,
										  c.sb_thing 'Subject',c.sb_type 
										  FROM xspace_browse c, 
										  (SELECT c.sb_child_id,c.sb_parent_id 
										  FROM xspace_browse p,xspace_browse c 
										  WHERE p.sb_parent_id='0' 
										  AND p.sb_child_id=c.sb_parent_id) p 
										  WHERE c.sb_parent_id = p.sb_child_id 
										  AND c.sb_child_id='".$Result_eto['slp_id']."'";
							$result_ngo =& $this->_db->query($query_ngo);
							
								while($Result_ngo =& $result_ngo->fetchRow(DB_FETCHMODE_ASSOC))
								
								{
									$this->_eto_Relevant_spaces[$i] =$Result_ngo['spaceId'];
									$i++;
								}
							 
							
						//end while  Result_eto
						}
				 
				 	
				 //end foreach
				}
				 
		 
				
			if($i<7 )
			{
				
					$query_ngo = "SELECT p.sb_parent_id 'parentId',
		  						  c.sb_parent_id 'nodeId', c.sb_child_id 'spaceId' ,
		  						  c.sb_thing 'Subject',c.sb_type from xspace_browse c,
		  						  (SELECT c.sb_child_id,c.sb_parent_id 
					  		      FROM xspace_browse p,xspace_browse c 
		   						  WHERE p.sb_parent_id='0' 
		   						  AND p.sb_child_id=c.sb_parent_id) p
				       			  WHERE c.sb_parent_id = p.sb_child_id";
			
					$result_ngo =& $this->_db->query($query_ngo);
					 
						while($Result_ngo =& $result_ngo->fetchRow(DB_FETCHMODE_ASSOC))
						{
							$this->_NodeSpaceList[$Result_ngo['parentId']][$i] = $Result_ngo['spaceId'];
						 	$this->_ngo_spaces[$Result_ngo['parentId']][$Result_ngo['nodeId']][$i] =$Result_ngo['spaceId'];
						  	$i++;
						
						}
	
			//end if
			} 
				 
				
				
				$i = 0;
				foreach ($this->_ngo_spaces as $key => $value)
				{	
				    $this->_ngo_Nodes[$i++] = $key;
				}
				
				$i= 0;
				foreach ($this->_NodeSpaceList as $key =>$value)
				{
					foreach ($value as $list)
					{					
					$this->_AllSpaces[$i] = $list;
					$i++;
					}
				}
			 
				
				// FOR NOW Both logged in/not logged in generates the same results
				if($cookiereader->isloggedin()){
					
					$this->GenerateXML($this->getAllSpacesDisplayArray());
				 
				}
				else
					$this->GenerateXML($this->getAllSpacesDisplayArray());
		 
			//end if PEAR::isERROR
			}
			else
			{
			echo "A database error has occured.";	
			}
			
			
			
		//END CONSTRUCT
		}
	
	 		
		/**
		 * get The Child Nodes of give Parent ID
		 *
		 * @param unknown_type $_ngo_Nodes
		 * @return array of child Nodes.
		 */
		
		function getChildNodes($ngo_pNodes)
		{
				 $i=0;
				 foreach($this->_ngo_spaces[$ngo_pNodes] as $key=>$value)
				 {
				 	 $ngo_cNodes[$i++]= $key;
				 }
	        return $ngo_cNodes;
		}
		
		/**
		 * Function getSpaces return list of all Xpert Spaces list
		 *
		 * @param unknown_type $parentNode
		 * @param unknown_type $childNode
		 * @return array of spaces 
		 */
		function getSpaces($parentNode,$childNode)
		{
				 $i=0;
				 foreach($this->_ngo_spaces[$parentNode][$childNode] as $key=>$value)
				 {
				 	 $spaces[$i++]= $value;
				 }
	        return $spaces;
		}
		
		/**
		 * Function shuffleSpaces Returns shuffled Array
		 *
		 * @param unknown_type $sarray
		 * @return unknown
		 */
		
		function shuffleSpaces($sarray)
		{
			shuffle($sarray);
			return $sarray;
		}
		
		/**
		 * Function getAllSpacesDisplayArray 
		 * This fetches combination of parent nodes from XspaceBrowse table. 
		 * 
		 * @return unknown
		 */
		function getAllSpacesDisplayArray($spaces = null)
		{

			$index= 0;
			$i =0;
			 
			if ($spaces == null)
			{
				foreach ($this->_ngo_Nodes as $pnode)
				{
					foreach ($this->getChildNodes($pnode) as $key=> $cnode)
					{
						foreach($this->getSpaces($pnode,$cnode) as $key =>$spaces)
						{
							$spaceList[$pnode][$i++] = $spaces;
						}
					}
				$i=0;				
				} 
			}
			else 
				$spaceList = $spaces;
				 
				//set $ngo spaces
				 $ngo_spaces=$this->displaySpaces($spaceList);

				 $i=0;
				 foreach ($this->_eto_Relevant_spaces as $eto_space)
				 {
					$ngo_spaces[$i]=$eto_space;
					$i++;
				 } 
			
			return $ngo_spaces;
		}
		/**
		 * function DisplaySpaces
		 * Algorithm to fetch exact number of Xspaces from 
		 *
		 * @param unknown_type $spacelist
		 * @return unknown
		 */
		
		function displaySpaces($spacelist)
		{
			//$spacelist = $this->getAllSpacesDisplayArray();
			$index=0;
			$pcount = count($this->_ngo_Nodes);
			$val = floor($this->_totalXtraReleventSpaces/$pcount);
			
			foreach ($spacelist as $key => $value)
			{
			  	$sList = $this->shuffleSpaces($value);
			  	for ($i=0; $i<$val; $i++)
			  	{
			  		$this->_ngo_spaceList[$index++] = $sList[$i];
			  	}
			}
			 
				if (count($this->_ngo_spaceList) == $this->_totalXtraReleventSpaces) 
				{
				   return $this->_ngo_spaceList;
				}
				else 
				{
		  			$leftOverCount = $this->_totalXtraReleventSpaces - count($this->_ngo_spaceList);
		  			
		  			$this->_ngo_spaceList = array_merge($this->_ngo_spaceList,$this->getleftover($this->_AllSpaces,$leftOverCount));
		  			//	print_r($this->_ngo_spaceList);
		  			return $this->_ngo_spaceList;
				}
			 
		}
		
		
		function getleftover($spacelist,$leftoverCount)
		{
		
			$array = array_diff($spacelist,$this->_ngo_spaceList);
			$i = 0;
			
				foreach ($array as $list)
				{
					$array[$i] = $list;
					$i++;
				}
			
			  	 for ($i=0; $i<$leftoverCount; $i++)
			  	 {
			  	  $temparray[$i] = $array[$i];
			  	 }
		
		   return $temparray;
		}
		/**
		 * Function genStudentXspaces
		 * This function fecthes topic of interests of Sudent user from Locker_Client class
		 * Xspace are captured for list of interests. Rest of Xspaces are fectehd using Algorithm of 
		 * anonymous user.
		 *
		 * @param unknown_type $usrid
		 * @return unknown
		 */
		
		function genStudentXspaces($usrid)
		{
			$locker_client = new Locker_Client();
			$profile = $locker_client->getprofile($usrid);
			
			$ngo_pNodes = $profile->_interestarray;
			//print_r($pNodes);
			$ngo_pNodes = implode("','",$ngo_pNodes);
			
		
			$i = 0;
			if (!PEAR::isError($this->_db)) 
			{
				//$usrSQL = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_parent_id in ('".$ngo_pNodes."');";
				
				/*** cmd: modified to use the prof_int_xspaces table***/
				$usrSQL = "select xspaceid from prof_int_xspaces where intid in ('".$ngo_pNodes."');";
				$result =& $this->_db->query($usrSQL);
				if(!$result->numRows())
				{
				return $this->getAllSpacesDisplayArray();
				}
				else 
				{
					
					if (!DB::isError ($result))
					{
						while($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
						{
							$stuSpace[$i++] = $row['xspaceid'];
						}
					 
						$totalXspaces = $this->_totalXtraReleventSpaces - $result->numRows();
						 
							if($totalXspaces > 0)
							{
							
							$array = array_diff($this->getAllSpacesDisplayArray(),$stuSpace);
							$i=0;
						
								foreach($array as $list)
								{
									$anonymous_array[$i] = $list;
									$i++;
								}
							 
							 $aarray = array_chunk($anonymous_array,$totalXspaces);
							 
							 $this->_studentSpace =  array_merge($stuSpace,$aarray[0]);
							}
							else 
								$this->_studentSpace = $stuSpace;
					 
						return $this->_studentSpace;
					}
					else 
					{
						echo "connection Error".mysqli_connect_error()."<br>";
						echo "Get message".$result->getMessage () ;
					}
				}
			//END if pear::errror
			}
		}
		
		/**
		 * Function GenerateNgoSpace
		 * Generates ONE LINE of the XML code for NGO asset
		 * 
		 *
		 * @param $result_uid $result_title
		 * @return $this->outputxml
		 */
		
	function GenerateNgoXMLSpace($result_uid,$result_title){
			 
					
					$lessonQry = "select product_id, uid,fext, title_ascii from manifest  where type ='0trl' and puid =".$result_uid;
 					$lessonRslt =& $this->_db->query($lessonQry);
					$lessonrslt_set = $lessonRslt->fetchRow(DB_FETCHMODE_ASSOC);
					$plan = "/lessonplan?id=".$lessonrslt_set['uid'];
						
											
					$linkqry = "select title_ent,uid,puid,slp_id from manifest where uid=".$result_uid." and type ='0c' and puid = 0";
					$linkResult = & $this->_db->query($linkqry);
					$linkResult_set = & $linkResult->fetchRow(DB_FETCHMODE_ASSOC);
					$link = "/xspace?product_id=ngo&amp;id=".$linkResult_set['slp_id']."&amp;uid=".$result_uid;
					
					$imgqry = 	"select title_ent,uid,slp_id,fext from manifest where puid=".$result_uid." and type ='0mip' and category='xs01'";
					$imgrslt =& $this->_db->query($imgqry);
 					$imgrslt_set =& $imgrslt->fetchRow(DB_FETCHMODE_ASSOC);
 					
 					
					if($imgrslt_set['fext']==null)
					  $imgrslt_set['fext'] = 'jpg';
				  
					$image =  "product_id=ngo&amp;id=".$imgrslt_set['slp_id']."&amp;ext=".$imgrslt_set['fext']."&amp;uid=".$result_uid."";
					$output .= "<space name=\"".$result_uid."\" img= \"".$image."\" link=\"".$link."\" plan=\"".$plan."\">";
					$output .="<![CDATA[".$result_title."]]>";
 					$output .= "</space>";
					
			return $output;
			
		}
		
				
		/**
		 * Function GenerateEtoSpace
		 * Generates ONE LINE of the XML code for ETO asset
		 * 
		 *
		 * @param $result_uid $result_title
		 * @return $this->outputxml
		 */
		function GenerateEtoXMLSpace($result_uid,$result_title){

					$imgqry = 	"select title_ent,uid,slp_id,fext from manifest where puid=".$result_uid." and type ='0mip' and category='xt01'";
			 	 	$imgrslt =& $this->_db_eto->query($imgqry);
					$lessonQry = "select product_id, uid,fext, title_ascii from manifest  where type ='0uv' and puid =".$result_uid;
					$lessonRslt =& $this->_db_eto->query($lessonQry);
					$lessonrslt_set = $lessonRslt->fetchRow(DB_FETCHMODE_ASSOC);
					$plan = "/lessonplan?id=".$lessonrslt_set['uid'];
					
					$linkqry = "select title_ent,uid,puid,slp_id from manifest where uid=".$result_uid." and type ='0cw' and puid = 0";
						
					$linkResult = & $this->_db_eto->query($linkqry);
					$linkResult_set = & $linkResult->fetchRow(DB_FETCHMODE_ASSOC);
					$link = "/xspace?product_id=eto&amp;id=".$linkResult_set['slp_id']."&amp;uid=".$result_uid;
					
					$imgrslt_set =& $imgrslt->fetchRow(DB_FETCHMODE_ASSOC);
					
					if($imgrslt_set['fext']==null)
					  $imgrslt_set['fext'] = 'jpg';
					$image =  "product_id=eto&amp;id=".$imgrslt_set['slp_id']."&amp;ext=".$imgrslt_set['fext']. "";
					$output .= "<space name=\"".$result_uid."\" setid=\"eto\" img= \"".$image."\" link=\"".$link."\" plan=\"\">";
					$output .="<![CDATA[".$result_title."]]>";
					$output .= "</space>";
					
			return $output;
			
		}
			
		/**
		 * Function GenerateXML
		 * Generates XML output for the spaces fecthed by each algorithm. Gets information from the 
		 * 
		 *
		 * @param unknown_type $spaces
		 * @return unknown
		 */
		
		function GenerateXML($spaces){
		 
		
		/* Process the _eto_spaces and add a comma */
        $slpid_ngo =  implode("','",$spaces);
        $slpid_eto =  implode("','",$this->_eto_spaces);
        /* Get data from the NGO DB */
  		$query_ngo = "select title_ascii,title_ent, uid,fext from manifest where slp_id in ('".$slpid_ngo."') and  type = '0c' and category='xs01' and puid =0 ORDER BY RAND() ;" ;
		$result_ngo =& $this->_db->query($query_ngo);
		/* Get data from the ETO DB */
		$query_eto = "select title_ascii,title_ent, uid,fext from manifest where slp_id in ('".$slpid_eto."') and  type = '0cw' and category='xt01' and puid =0 ORDER BY title_ent ASC;" ;
		$result_eto = $this->_db_eto->getAll($query_eto, DB_FETCHMODE_ASSOC);

		
			if (!DB::isError($result_ngo) || !DB::isError($result_eto)) 
			{
				/* output XML headers */
				header("Content-Type: text/xml; charset=utf8");
				$this->_xml_output = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
				$this->_xml_output .= "<grid rows=\"3\" columns=\"5\" imgPrefix=\"/csimage?\">";
				$this->_xml_output .= "<spaces>";
				$count=1;
			
				/* process ALL the ETO DB results */
				 foreach($result_eto as $row)
				 {
					 /* if COUNT is 5 or 10 output a NGO related ASSETT */
				 	if($count==5 || $count==10)
				 	{
 		 			//add a NGO asset
		 			$Result_ngo = $result_ngo->fetchRow(DB_FETCHMODE_ASSOC);
			 			/* OUTPUT one line of XML for NGO*/
						$this->_xml_output .=  $this->GenerateNgoXMLSpace($Result_ngo['uid'],$Result_ngo['title_ascii']);
						$this->_xml_output .= $this->GenerateEtoXMLSpace($row['uid'],$row['title_ascii']);
					} 
	 				else 
	 				{
	 					/* OUTPUT one line of XML for ETo*/
	 					$this->_xml_output .= $this->GenerateEtoXMLSpace($row['uid'],$row['title_ascii']);
	 				}
 				 	
				 	$count++;
				 
				 //end foreach	
				 }
		 		
 				/* OUTPUT any EXTRA temporary spots if the DB does not contain all 8 spots*/	
 				if($this->_fillInTempSpaces==true)
 				{
	 				for ( $counter = $count; $counter < 11; $counter ++) 
					{
					list($workshopNumber, $justTitle) = split('[:]', $Result_eto['title_ascii']);
	 				list($workshop, $workshopNumber) = split('[ ]', $workshopNumber); 
	 				
		 				if($counter==5 || $counter==10)
		 				{
			 					
				 			//add a NGO asset
				 			$Result_ngo =  $result_ngo->fetchRow(DB_FETCHMODE_ASSOC);
							$this->_xml_output .= $this->GenerateNgoXMLSpace($Result_ngo['uid'],$Result_ngo['title_ascii']);
							
		 				
		 				}else 
		 				{
	
		 					$this->_xml_output .= $this->temporarySpots($counter);
		 				} 
					 
	 				//end for
					}
				//end if TRUE
 				}
			 
			 
	 			//************************************************************************
				//  						BOTTOM ROW
				//					Add 5 more NGO spots for the bottom row
				//************************************************************************
				for ( $counter1 = 1; $counter1 < 6; $counter1 ++)
					{
					
						$Result_ngo =  $result_ngo->fetchRow(DB_FETCHMODE_ASSOC);
						$this->_xml_output .= $this->GenerateNgoXMLSpace($Result_ngo['uid'],$Result_ngo['title_ascii']);
						
						 
					//end counter1
					} 
				 
 
			}
			else 
			{
				echo 'Unable to connect to the database.';
				exit;
			}
						 
			$this->_xml_output .= "</spaces></grid>";
			echo $this->_xml_output;
			
 
			/**
 			  * Append result to XML output and return.
 			*/
		return $this->_xml_output;
		}
			
	
	//************************************************************************
	// 			    This function is strictly used for 					
	//			development. It ads temporasry spots until all Workshops are
	//						located in the DB									 
	//************************************************************************	
	function temporarySpots($spotNumber)
	{
		
		switch ($spotNumber) 
		{
	    	case 1:
			 
			$output='<space name="10209518" setid="eto" img= "product_id=ngo&amp;id=g6w4apbr&amp;ext=jpg" link="/xspace?id=g6w3a000" plan=""><![CDATA[TEMP-1: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 2:
			$output='<space name="10229533" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-2: PlaceHolder]]></space>';
			return $output;
			
			case 3:
			 
			 $output='<space name="10239556" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-3: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 4:
		 
			 $output='<space name="10249530" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-4: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 5:
			 
			return $output;
			break;
			
			case 6:
			 
			$output='<space name="10269537" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-6: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 7:
			 
			$output='<space name="10279550" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-7: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 8:
			 
			$output='<space name="10289552" setid="eto" img= "product_id=ngo&amp;id=g6w3apbr&amp;ext=jpg" link="/xspace?id=g6w4a000" plan=""><![CDATA[TEMP-8: PlaceHolder]]></space>';
			return $output;
			break;
			
			case 9:
			
				return $output;
			break;
			
		}
			
			
	
	}	


	//************************************************************************
	// 			Desatructor to close DB										//
	//************************************************************************
	 function __destruct() 
	 {
	 //disconnect from both databases
			$this->_db_eto->disconnect;
			$this->_db->disconnect;
	 }

	
// END CLASS	
}

 

$shuffle = new shuffleFeed_ETO();	


?>
