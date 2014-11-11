<?php

require_once('DB.php');
require_once($_SERVER['COMMON_CONFIG_PATH'].'/GI_ProductConfig.php');

	
	//echo $productname;
/**
 * @author Dee Palmer
 * @version 1.0
 * @created 24-Feb-2011
 */
class GI_FolderHandler
{
	/**
	 * A database connection
     * @access   private
     * @var      database connection
     */
	private $_db = NULL;

	public function __construct()
	{
		
		//To connect with rlib database
		 $serverID = "tr8ts";
		 $mysql_string = GI_ProductConfig::getProductDb($serverID);
		$this->_db = DB::connect($mysql_string);
	
	
	    if (DB::isError($this->_db)) 
	    {  
            $this->_raiseError('No database connection', 8, 1);
            return;
       	}        
	}//end constructor


		/**
	 * Return an array of all folders per grade
	 * @param $grade_node_id
	 * @return array of folders
	 */
	public function getGrades($featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select category_browse.*, grade_browse.grade_short_title from category_browse, grade_browse where pid = '".$productFacet."' AND grade_browse.grade_title = category_browse.node_title and category_browse.facet='".$productFacet."' order by seq";
		//AND category_browse.facet='tr8ts'
        //print $qString;
        $result =& $this->_db->query($qString);
			
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}
	
	/**
	 * Return an array of all folders per grade
	 * @param $grade_node_id
	 * @return array of folders
	 */
	
	

	
	public function getFolders($grade_node_id,$featurecode)
	{
		
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		
		
		
		//print_r($featurecode);
		//echo "<br>";
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from category_browse LEFT JOIN folder_template_relation on category_browse.cid = folder_template_relation.folder_id where pid = '$grade_node_id' and category_browse.facet='".$productFacet."' order by seq";
        
        // REMOVED THIS FROM QUERY RP 9/4/13 WORKS NOW and folder_template_relation.facet = '".$productFacet."'
        
        
        if(!empty($featurecode)){
        	//echo "<br>getFolders for ".$productFacet;
			//print "<br>getFolders Query: ".$qString;
		}
		
        $result =& $this->_db->query($qString);
		
        //print_r($result);
        
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}

	/**
	 * Return an array of all values per node
	 * @param $node_id
	 * @return array of folders
	 */
	public function getNode($node_id,$featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from category_browse where cid = '$node_id' and facet='".$productFacet."'";
	
        $result =& $this->_db->query($qString);
			
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}	

	/**
	 * Return an array of children nodes.
	 * @param $node_id
	 * @return array of nodes
	 */
	public function getNodeChildren($node_id,$featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from category_browse where pid = '$node_id' and facet='".$productFacet."' order by seq";
		//print $qString;
		
        $result =& $this->_db->query($qString);
        
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
				////if($dbrow){
	            $PArray[] = $dbrow;
	           
				//}
	        }        
		}
	    $result->free();		        
		//print '<pre>'; print_r($PArray); print '<pre>';
		
		return $PArray;
	}	
	
	/**
	 * Return an array of manifest values.
	 * @param $slp_id
	 * @return array of values
	 */
	public function getManifestSLPID($slp_id,$featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from manifest where slp_id = '$slp_id'";
		//print $qString;
        
        $result =& $this->_db->query($qString);
			
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}	
	
	/**
	 * Return an array children for an slpid value.
	 * @param $slp_id
	 * @param $grade (OPTIONAL)
	 * @return array of values
	 */
	public function getManifestChildren($slp_id,$grade,$featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		//echo "<br> @getManifestChildren <br>";
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
		$qString = "select b.* from manifest a, manifest b where a.uid = b.puid AND a.slp_id = '$slp_id' order by sort_order";
		if(!empty($grade))
		{
        	$qString = "select b.* from manifest a, manifest b where a.uid = b.puid AND a.slp_id = '$slp_id' AND b.grades LIKE '%$grade%' order by sort_order";
		}
		
	
        $result =& $this->_db->query($qString);
			
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}	
	
	/**
	 * Return an array children for an slpid value.
	 * @param $slp_id
	 * @param $grade (OPTIONAL)
	 * @return array of values
	 */
	public function getCBrowseManifestChildren($slp_id,$featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID'];
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
		$qString = "select * from category_browse, manifest where category_browse.cid = manifest.slp_id and category_browse.pid='$slp_id' order by category_browse.seq";
		
		//print $qString;
	
        $result =& $this->_db->query($qString);
			
        if (DB::isError($result)) {
            $this->_raiseError($qString.' query failed', 8, 1);
            return;
        }

        //set the row returned to the parentInfo array
        if($result->numRows() > 0)
		{        
			while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
			{			    
	            $PArray[] = $dbrow;
	        }        
		}
	    $result->free();		        

		return $PArray;
	}	
	
	/**
	 * populate the folder_template_relation table
	 */
	public function populateFolderTemplateRelation($featurecode)
	{
		$productFacet=$_SERVER['TRAITSPACE_FACET_ID']; //set default to this server pcode
		
		if(!empty($featurecode)){
			$productFacet=$featurecode;
		}
		echo "<br><br>populate folderTemplateRelation...".$productFacet;
		//get all the grades
		$grades = $this->getGrades($productFacet);
	
		$template_code;
		for($i=0; $i<count($grades); $i++){
		
			$grade_node_id = $grades[$i]['cid'];
			$folders = $this->getFolders($grade_node_id,$productFacet);
			
			echo count($folders);
			for($j=0; $j<count($folders); $j++){
			
				$folder_id = $folders[$j]['cid'];
				$node_title = $folders[$j]['node_title'];
			
				if($folder_id == 'node-33107' || $folder_id == 'node-33094'){
					$template_code = 'folderPage';
					
				}else{
					switch ($node_title) {
					    case 'Lesson Pages':
					     	$template_code = 'unitPages';
					        break;
					    case 'Mentor Videos':
					     	$template_code = 'mentorVideos';
					        break;
					    case 'Songs':
					      	$template_code = 'songs';
					        break;
					    case 'Unit Benchmark Papers':
					     	$template_code = 'unitPages';
					        break;	
					    case 'PD Live':
					     	$template_code = 'pdLive';
					        break;
					    case 'Argumentative Research Paper Module':
					    	$template_code = 'argumentativeResearch';	
					    	break;		        			        
					    default:
					    	$template_code = 'folderPage';
					    	break;
					}
				}
				
				$qString = "INSERT into folder_template_relation (folder_id, template_code, facet) VALUES ('$folder_id', '$template_code', '$productFacet');";
			echo $qString;echo "<br>";
				if(!empty($featurecode)){
					echo "<br>folder_id: ".$folder_id.", template_code: ".$template_code.", facet: ".$productFacet;
					echo "<br>";
				}

				$result =& $this->_db->query($qString);
				
			}
			
		}
		
	
		
		
		
		
	}	
		
}
?>
