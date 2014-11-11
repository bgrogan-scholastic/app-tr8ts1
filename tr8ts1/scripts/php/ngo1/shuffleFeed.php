<?php

/**
* Create an xml feed for the shuffle and echo's it out
*
* @author       Valli Abbaraju
* @copyright    07/18/2008
*/

/**
 * Generates XML from the dataabase.
 * Fetches data from the MANIFEST table and creates elements of XML
 * 
 */

require_once('DB.php');
//require_once($_SERVER['INCLUDE_HOME']."/main_includes.php");
require_once($_SERVER['LOCKER'] .'/locker1/client/locker_soap_client.php');
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");

//COOKIE STUFF

class shuffleFeed{
	protected $_db;
	protected $_spaces;
	protected $_spaceList;
	protected $_cNodes;
    protected $_pNodes;
    protected $_countRows;
    protected $_studentSpace;
    protected $_xml_output;
    protected $_AllSpaces;
    protected $_totalXspaces = 15;
   
   	/**
   	 * Constructor which calls algorithm for anonymous users and Srudents.
   	 *
   	 */
   	
   		public function __construct(){
   			$cookiereader = new Cookie_Reader('xs');
   			$profileid = $cookiereader->getprofileid();
		$this->_db = db::connect($_SERVER['DB_CONNECT_STRING']);
	
		if (!PEAR::isError($this->_db)) {

		   $combiQry = "select p.sb_parent_id 'parentId', c.sb_parent_id 'nodeId', c.sb_child_id 'spaceId' ,c.sb_thing 'Subject',c.sb_type from xspace_browse c, (select c.sb_child_id,c.sb_parent_id 
					  		        from xspace_browse p,xspace_browse c 
		   							where p.sb_parent_id='0' and p.sb_child_id=c.sb_parent_id) p
				        where c.sb_parent_id = p.sb_child_id";
			
			$result =& $this->_db->query($combiQry);
			if (!DB::isError($result)) {
				$temp_parent = null;
				$this->_countRows = $result->numRows ();
				
				
				while($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)){
					 if($temp_parent != $row['parentId']){
					 	$i=0;
					    $temp_parent = $row['parentId'];
					 }
					  else
					  	$temp_parent = $row['parentId'];
					  	
					  	
					  
					  $this->_NodeSpaceList[$row['parentId']][$i] = $row['spaceId'];
					  $this->_spaces[$row['parentId']][$row['nodeId']][$i] =$row['spaceId'];
					   $i++;
					}
				
					
				}
			
				$i = 0;
				
				foreach ($this->_spaces as $key => $value){	
				    $this->_pNodes[$i++] = $key;
				}
				
				$i= 0;
				foreach ($this->_NodeSpaceList as $key =>$value){
					foreach ($value as $list){					
					$this->_AllSpaces[$i] = $list;
					$i++;
					}
				}
				//echo $profileid;	
				//$profileid = '1.6002370900';
					/*$this->GenerateXML($this->genStudentXspaces($profileid));
				$this->genStudentXspaces($profileid);*/
				if($cookiereader->isloggedin()){
					$this->GenerateXML($this->genStudentXspaces($profileid));
				}
				else
					$this->GenerateXML($this->getAnonymousSpaces());
			    
			    //$this->GenerateXML($this->genStudentXspaces(1));
			
			//	$this->genStudentXspgaces(1);
				  //print_r($this->getAnonymousSpaces());
				/*  if($this->genStudentXspaces(1)){
				    $this->GenerateXML($this->genStudentXspaces(1));
				    echo $this->_xml_output;
				  }
				  else {
				  	echo "No data found";
				  }
			*/
			}
			else 
			echo "Error";
		}
	
		/**
		 * get The Child Nodes of give Parent ID
		 *
		 * @param unknown_type $pNodes
		 * @return array of child Nodes.
		 */
		
		function getChildNodes($pNodes){
			 $i=0;
				 foreach($this->_spaces[$pNodes] as $key=>$value){
				 	 $cNodes[$i++]= $key;
				 }
	        return $cNodes;
		}
		
		/**
		 * Function getSpaces return list of all Xpert Spaces list
		 *
		 * @param unknown_type $parentNode
		 * @param unknown_type $childNode
		 * @return array of spaces 
		 */
		function getSpaces($parentNode,$childNode){
				 $i=0;
				 foreach($this->_spaces[$parentNode][$childNode] as $key=>$value){
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
		
		function shuffleSpaces($sarray){
			shuffle($sarray);
			return $sarray;
		}
		
		/**
		 * Function getAnonymousSpaces 
		 * This fetches combination of parent nodes from XspaceBrowse table. 
		 * 
		 * @return unknown
		 */
		function getAnonymousSpaces($spaces = null){			
			$index= 0;
			$i =0;
			if ($spaces == null){
			foreach ($this->_pNodes as $pnode){
				foreach ($this->getChildNodes($pnode) as $key=> $cnode){
					foreach($this->getSpaces($pnode,$cnode) as $key =>$spaces){
						$spaceList[$pnode][$i++] = $spaces;
						}
					}
					$i=0;				
				}
			}
			else 
				$spaceList = $spaces;
				//echo "Anonymous <br>";
			
				//echo "<br>";
				return $this->displaySpaces($spaceList);
		}
		/**
		 * function DisplaySpaces
		 * Algorithm to fetch exact number of Xspaces from 
		 *
		 * @param unknown_type $spacelist
		 * @return unknown
		 */
		
		function displaySpaces($spacelist){
			//$spacelist = $this->getAnonymousSpaces();
			$index=0;
			$pcount = count($this->_pNodes);
			$val = floor($this->_totalXspaces/$pcount);
			
			foreach ($spacelist as $key => $value){
			  	$sList = $this->shuffleSpaces($value);
			  	for ($i=0; $i<$val; $i++){
				  	//echo $i." ". $index;
			  		$this->_spaceList[$index++] = $sList[$i];
			  	}
			}
			//echo count($this->_spaceList);
			if (count($this->_spaceList) == $this->_totalXspaces) {
			  // print_r($this->_spaceList);
			   return $this->_spaceList;
			}
			else {
  			$leftOverCount = $this->_totalXspaces - count($this->_spaceList);
  			
  			$this->_spaceList = array_merge($this->_spaceList,$this->getleftover($this->_AllSpaces,$leftOverCount));
  		//	print_r($this->_spaceList);
  			return $this->_spaceList;
			}
			/* for ($i=0; $i<$val; $i++){
				  	//echo $i." ". $index;
			  		$this->_spaceList[$index++] = $sList[$i];
			  	}
			echo "Disply fof Anyonsf<br>";
			print_r($this->_spaceList);
			echo '<br>';
			return $this->_spaceList;*/
		}
		
		
		function getleftover($spacelist,$leftoverCount){
			/*print_r($this->_spaceList);
			echo '<br>';*/
			$array = array_diff($spacelist,$this->_spaceList);
			
			
			$i = 0;
			foreach ($array as $list){
				$array[$i] = $list;
				$i++;
			}
		
		  	 for ($i=0; $i<$leftoverCount; $i++){
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
		
		function genStudentXspaces($usrid){
			$locker_client = new Locker_Client();
			$profile = $locker_client->getprofile($usrid);
			
			$pNodes = $profile->_interestarray;
			//print_r($pNodes);
			$pNodes = implode("','",$pNodes);
			
		
			$i = 0;
			if (!PEAR::isError($this->_db)) {
				//$usrSQL = "select sb_parent_id,sb_child_id,sb_thing from xspace_browse where sb_parent_id in ('".$pNodes."');";
				
				/*** cmd: modified to use the prof_int_xspaces table***/
				$usrSQL = "select xspaceid from prof_int_xspaces where intid in ('".$pNodes."');";
				$result =& $this->_db->query($usrSQL);
				if(!$result->numRows()){
					//echo "Data not found";
					//return false;
					return $this->getAnonymousSpaces();
				}
				else {
				
				if (!DB::isError ($result)){
					while($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)){
						
						$stuSpace[$i++] = $row['xspaceid'];
					}
				/*  echo "Profile Interest";
				  print_r($stuSpace);
				  echo '<br>';
				  */
					$totalXspaces = $this->_totalXspaces - $result->numRows();
					//echo $totalXspaces ;
					if($totalXspaces > 0){
					//	print_r($this->getAnonymousSpaces());
						
					$array = array_diff($this->getAnonymousSpaces(),$stuSpace);
					$i=0;
					//echo count($array).'<br>';
					//print_r($array);
					
					foreach($array as $list){
						
						$anonymous_array[$i] = $list;
						$i++;
						/*if ($i <= $totalXspaces) 
						 exit;*/
					}
					  
					/*echo "Anonymous";
					// array_chunk($anonymous_array,$totalXspaces);
					 echo '<br>';*/
					 
					 $aarray = array_chunk($anonymous_array,$totalXspaces);
					 
					 $this->_studentSpace =  array_merge($stuSpace,$aarray[0]);
					}
					else 
						$this->_studentSpace = $stuSpace;
						
						
					//return $this->_studentSpace;
					return $this->_studentSpace;
				}
				else {
					echo "connection Error".mysqli_connect_error()."<br>";
					echo "Get message".$result->getMessage () ;
				}
			}
			}
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
		//require_once('this->_db.php');
		/* Connect to Database*/

        $slpid =  implode("','",$spaces);
         
		 if (!PEAR::isError($this->_db)) {
			/**
	          * retreive title from manifest table where type is of 'Oc' and parent ID is 0
			*/
			//$query1 = "select title_ascii,title_ent, uid,fext from manifest where slp_id in (select sb_child_id from xspace_browse where sb_parent_id in (select c.sb_child_id  from xspace_browse p,xspace_browse c where p.sb_parent_id='0' and p.sb_child_id=c.sb_parent_id)) and  type = '0c'";
			$query1 = "select title_ascii,title_ent, uid,fext from manifest where slp_id in ('".$slpid."') and  type = '0c' and category='xs01' and puid =0;" ;
			
			
			//echo $query1;
			$result =& $this->_db->query($query1);
			if (!DB::isError($result)) {

			    header("Content-Type: text/xml; charset=utf8");
				$this->_xml_output = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
				$this->_xml_output .= "<grid rows=\"3\" columns=\"5\" imgPrefix=\"/csimage?\">";
				$this->_xml_output .= "<spaces>";
				//echo $this->_xml_output;
				/**
				 * 
          		  * For every record fetched from the above code create a space element and it attributes.
          		  * For images query Database for the type 0mip and category is xs01 and parent id is uid fetched
          		  * from above qyery used for space.
          		*/	
				while($Result =& $result->fetchRow(DB_FETCHMODE_ASSOC)){
						
					$imgqry = 	"select title_ent,uid,slp_id,fext from manifest where puid=".$Result['uid']." and type ='0mip' and category='xs01'";
					
					$imgrslt =& $this->_db->query($imgqry);
				
					$lessonQry = "select product_id, uid,fext, title_ascii from manifest  where type ='0trl' and puid =".$Result['uid'];
					//echo $Result['uid'] .'<br>';
					$lessonRslt =& $this->_db->query($lessonQry);
					$lessonrslt_set = $lessonRslt->fetchRow(DB_FETCHMODE_ASSOC);
					$plan = "/lessonplan?id=".$lessonrslt_set['uid'];
						
											
					$linkqry = "select title_ent,uid,puid,slp_id from manifest where uid=".$Result['uid']." and type ='0c' and puid = 0";
					$linkResult = & $this->_db->query($linkqry);
						
					$linkResult_set = & $linkResult->fetchRow(DB_FETCHMODE_ASSOC);
							//$link = "/xspace?id=".$linkResult_set['uid'];
							$link = "/xspace?id=".$linkResult_set['slp_id']."&product_id=ngo&uid=".$Result['uid'];
						//$link = "link =\"".$xspaceid ."\">".$linkResult_set['title_ent'];
					
					
					$imgrslt_set =& $imgrslt->fetchRow(DB_FETCHMODE_ASSOC);
					if($imgrslt_set['fext']==null)
					  $imgrslt_set['fext'] = 'jpg';
					$image =  "product_id=ngo&amp;id=".$imgrslt_set['slp_id']."&amp;ext=".$imgrslt_set['fext']. "";
					
					
					//$image = $imgrslt_set['slp_id'].".".$imgrslt_set['fext'];
					$this->_xml_output .= "<space name=\"".$Result['uid']."\" img= \"".$image."\" link=\"".$link."\" plan=\"".$plan."\">";
				
					$this->_xml_output .="<![CDATA[".$Result['title_ascii']."]]>";
					//$this->_xml_output .= "<title>".$Result['title_ascii']."</title>";
					/**
			 		  * For all the uid's fetched for space element retreive child records
			 		  */
					$this->_xml_output .= "</space>";
				}
			}
			} else {
				echo 'Unable to connect to the database.';
			}
			$this->_xml_output .= "</spaces></grid>";
			echo $this->_xml_output;
			/**
 			  * Append result to XML output and return.
 			  */
			return $this->_xml_output;
		}
		

}


//require('/data/ngo1_gi/prototypes/docs/valli/shuffleFeed.php');

$shuffle = new shuffleFeed();		
?>
