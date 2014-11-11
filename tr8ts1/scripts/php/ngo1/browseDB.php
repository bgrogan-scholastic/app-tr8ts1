<?php 
/**
 * browseDB.php connects to database and return result set of Subject , Topics and Xspaces 
 * depending on request.
 * @name : browseClass.php
 * @author : Tanmay Joshi tjoshi-consultant@scholastic.com
 * @version : created on 08/20/2008
 * 
 */
require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/cs/CS_Constants.php');
 require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Constants.php');
class browseDB extends GI_BASE{
	
	/**
	 * public newdb, holds the connection to Database. It is public so that it can used from the child class
	 * 
	 * @var object
	 */
	public  $newdb;
	protected $_eto_spaces;
	/**
	 * constructor. 
	 * intialize the connection to DB
	 *
	 */
	public function __construct(){
		
		$db_connect_string = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($db_connect_string)) {
			echo "Error:  Could not retrieve mysql connect string for eto DB";
		}
		else {
			$sql = sprintf("select value from appenv where app='ngo' and key_name='product_db';");
			$result = $db_connect_string->query($sql)->fetchrow();
			 
			$db_connect_string_ngo=$result[0];
			$sql = sprintf("select value from appenv where app='eto' and key_name='product_db';");
			$result = $db_connect_string->query($sql)->fetchrow();
			
			
			$db_connect_string->disconnect();
			$db_connect_string_eto=$result[0];
			
		}
 
		 
		$this->newdb = DB::connect($db_connect_string_ngo);	
		if (DB::isError($this->newdb)) {
	    				$this->_raiseError('No database connection', 8, 1);
            			return;
       	}
        	$this->newdb_eto = DB::connect($db_connect_string_eto);	
		if (DB::isError($this->newdb_eto)) {
	    				$this->_raiseError('No database connection', 8, 1);
            			return;
       	} 
       	
       
	}
	/**
	 * gets all the parent nodes with sb_parent_id = 0 and sb_type = 'T'(TAB)
	 * in descending alpha order based on sb_thing
	 *
	 * @return array result set
	 */
	public function getSubjectSet(){
		
	/*
	************************************************************************
		 		DETERMINE ETO/NGO and GET LANGUAGE TABS
		 			Langauge Arts/Science/Social Studies
	************************************************************************
	*/
					if (!DB::isError($this->newdb)){
				 
						//if were on the ETO server then get ETO content
						if($_SERVER[GI_AUTH_PCODE]=="eto"  )
				{
					 
						$sql = sprintf("SELECT 
							c.sb_seq,c.sb_child_id as chilid,
							c.sb_thing as title, 
							p.sb_child_id as child_id, 
							m.fext as ext, 
							m.product_id as productid 
							from ngo1.xspace_browse c 
							inner join ngo1.xspace_browse p 
							on c.sb_child_id=p.sb_parent_id 
							and c.sb_parent_id='0' 
							and p.sb_type='T' 
							inner join ngo1.manifest m 
							on p.sb_child_id=m.slp_id
							UNION
							SELECT 
							x.sb_seq,x.sb_child_id as chilid,
							x.sb_thing as title, 
							b.sb_child_id as child_id, 
							m.fext as ext, 
							m.product_id as productid 
							from eto1.xspace_browse x 
							inner join eto1.xspace_browse b 
							on x.sb_child_id=b.sb_parent_id 
							and x.sb_parent_id='0' 
							and b.sb_type='T' 
							inner join eto1.manifest m 
							on b.sb_child_id=m.slp_id
							ORDER BY sb_seq desc");
						
						
						 	 
					
					//end if(GI_AUTH_PCODE)
				}else{
					
							/**
						 * get the list of primary topics of Subject
			 			*/
						$sql = sprintf("select c.sb_child_id as chilid,
							c.sb_thing as title, 
							p.sb_child_id as child_id, 
							m.fext as ext, 
							m.product_id as productid 
							from xspace_browse c 
							inner join xspace_browse p 
							on c.sb_child_id=p.sb_parent_id 
							and c.sb_parent_id='0' 
							and p.sb_type='T' 
							inner join manifest m 
							on p.sb_child_id=m.slp_id  
							order by c.sb_seq desc;");
			 
						 
				//end else	
				}
				//process QUERY in NGO DB
				 $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
						
			
			
			//end IF DB Error
		}
		
		return $result;
	}
	/**
	 * gives the primary topics of the subject
	 *
	 * @param string $subject
	 * @return array result set
	 */
	public function getTopicSet($subject){
		
		if (!DB::isError($this->newdb)){
			
			$sql = sprintf("select p.sb_child_id as childid, p.sb_thing as title from xspace_browse c inner join xspace_browse p on c.sb_child_id=p.sb_parent_id and c.sb_thing='%s' AND p.sb_type='N' order by p.sb_seq;",$subject);
			
			return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
			
		}
	}
	
	
	/**
	 * Returns the courses (Course I, Course II, Course III)
	 *
	 * @param string $subject
	 * @return array result set
	 */
	public function getCourseSet(){
		
		//GET COURSE SET FROM ETO
		if (!DB::isError($this->newdb_eto)){
			
			$sql = sprintf("select sb_child_id as childid,sb_thing as title from xspace_browse where sb_parent_id!='0' and sb_type='N' order by sb_seq;");
			
			 
			
			return $result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC);
			
		}
	}
	
	/**
	 * queries of the xspaces on the base of node id passed
	 *
	 * @param string $nodeid
	 * @return array result set
	 */
	public function getXspaceSet($nodeid){
		
		if (!DB::isError($this->newdb)){
			/**
			* get the list of primary topics of Subject
 			*/
		require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/GI_Constants.php');

		 
			//DETERMINE product and tab, then run the query and return
			 
			if($_SERVER[GI_AUTH_PCODE]=="eto" && ($this->_subject=="Language Arts" || $this->_subject=="language arts"))
			{
				$sql = sprintf("select sb_child_id , sb_thing as title from xspace_browse where sb_parent_id='%s'  ORDER BY title ASC;",$nodeid);
		  		$result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);$result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC);
		  						
			}else{
			
				$sql = sprintf("select sb_child_id , sb_thing as title from xspace_browse where sb_parent_id='%s'  ORDER BY title ASC;",$nodeid);
		  		$result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);	
				
			}
				
			return $result;
			
		}
	}
	
}



?>