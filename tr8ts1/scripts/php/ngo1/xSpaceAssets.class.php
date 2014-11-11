<?php 
/**
 * 
 * Contains the database functions to get categories, subjects
 *  and xspaces, and any derivative assets related to xspaces,
 * 	skill builders, lesson plans, and project ideas
 * 
 * 	- Project Ideas
 *  - Lesson Plans
 *  - Image for an xSpace
 * 
 * @author Nabeel Shahzad <nshahzad@scholastic.com>
 */



require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");


class xSpaceAssets extends GI_BASE
{
	public $newdb;
	public $newdb_eto;
	public $cookiereader;
	public $profileid;
	public $interests;
	/**
	 * constructor. 
	 * intialize the connection to DB
	 *
	 */
	public function __construct()
	{ 
		parent::__construct();
		$this->cookiereader = new Cookie_Reader('xs');
		$this->profileid = $this->cookiereader->getprofileid();
		
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
	 * NGO
	 * 
	 * @return array result set
	 */
	public function getSubjectSet(){
		
		if (DB::isError($this->newdb)){
			return;
		}

		$sql = "SELECT * FROM xspace_browse 
					WHERE sb_parent_id='0'";
		
		return $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}

	/**
	 * gets all the parent nodes with sb_parent_id = 0 and sb_type = 'T'(TAB)
	 * in descending alpha order based on sb_thing
	 *
	 * ETO
	 * 
	 * @return array result set
	 */
	public function getSubjectSetETO(){
		
		if (DB::isError($this->newdb)){
			return;
		}

		$sql = "SELECT * FROM ngo1.xspace_browse 
				WHERE sb_parent_id='0'
				UNION
				SELECT * FROM eto1.xspace_browse 
				WHERE sb_parent_id='0'";
		
		return $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Gives the primary topics under a subject
	 *
	 * @param string $parentid The ID of the parent subject
	 * @return array result set
	 */
	public function getTopicSet($parentid)
	{
	
		if (DB::isError($this->newdb)){
			return;
		}
		
	
		
		$sql = 'SELECT sb_child_id, sb_thing as title 
					FROM xspace_browse
					WHERE sb_parent_id=\''.$parentid.'\'
					AND sb_type=\'N\'';
		
		if($parentid=="node-32865")
			$result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC);
		else 
			$result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
		
		return $result;
	}
	
	/**
	 * Gets the list of xspaces under a certain topic ID
	 *
	 * @param string $topicid
	 * @return array result set
	 */
	public function getXSpaces($topicid)
	{
		if (DB::isError($this->newdb)){
			return;
		}

		$sql = "SELECT  m.type,m.uid, m.puid, m.slp_id, m.title_ascii , m.product_id
					FROM manifest m, xspace_browse x 
					WHERE m.slp_id = x.sb_child_id
					AND x.sb_parent_id='$topicid'
					AND m.puid=0
					GROUP BY m.title_ascii";
	 
		  
		if($topicid=="node-32866" || $topicid=="node-32867" || $topicid=="node-32868")
			$result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC);
		else 
			$result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC); 
								
		return $result;
	}
	
	/**
	 * Get a user's XSpaces based on what their favorites are
	 * Pulls the interested through the Locker_Client() and a 
	 * user's profile interests.
	 */
	public function getFavXSpaces()
	{
		$locker_client = new Locker_Client();
		$profileobj = $locker_client->getprofile($this->profileid);
	
		$this->interests = $profileobj->_interestarray;
		
		# build list
		$list = '';
		$total = count($this->interests);
		
		if($total == 0)
		{
			return $this->getAllXSpaces();
		}
		
		for($i=0; $i<$total; $i++)
		{
			$list.='p.intid=\''.$this->interests[$i].'\'';
			
			if($i < $total-1)
			{
				$list .= ' OR ';
			}
		}
		
		$sql = 'SELECT m.uid, m.puid, m.slp_id, m.title_ascii , m.product_id
					FROM manifest m, prof_int_xspaces p 
					WHERE p.xspaceid=m.slp_id
					 	AND m.puid=0
						AND ('.$list.')';
		
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Return a list of all of the XSpaces that exist within the manifest
	 *
	 * @return array
	 */
	public function getAllXSpaces()
	{
		if (DB::isError($this->newdb)){
			return;
		}

			$sql = "SELECT m.type,m.uid, m.puid, m.slp_id, m.title_ascii , m.product_id as product_id
					FROM manifest m, xspace_browse x 
					WHERE m.slp_id = x.sb_child_id
					AND m.type='0c'
					AND m.puid=0
					GROUP BY m.title_ascii";
							
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	
	
/**
	 * Return a list of all of the XSpaces that exist within the manifest
	 *
	 * @return array
	 */
	public function getAllXSpacesETOandNGO()
	{
		if (DB::isError($this->newdb)){
			return;
		}

					$sql = "SELECT m.type,m.uid, m.puid, m.slp_id, m.title_ascii, m.product_id as product_id
							FROM ngo1.manifest m, ngo1.xspace_browse x 
							WHERE m.slp_id = x.sb_child_id
							AND m.type='0c'
							AND m.puid=0
							UNION
							SELECT e.type,e.uid, e.puid, e.slp_id, e.title_ascii , e.product_id  
							FROM eto1.manifest e, eto1.xspace_browse r 
							WHERE e.slp_id = r.sb_child_id
							AND e.type='0cw'
							AND e.puid=0
							GROUP BY e.title_ascii";
							
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}	
	
	
	/**
	 * Get the image for a certain xspace
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getXSpaceImage($xspaceid)
	{
		$xspaceid = intval($xspaceid);
		$sql = "SELECT p.slp_id as assetID,
						p.title_ent as title, 
						p.fext as ext, 
						p.product_id as productid 
						FROM manifest p 
						WHERE p.puid=$xspaceid
						AND p.type='0mip' AND p.category='xs01'";
		
		return $this->newdb->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
		
	}

	/**
	 * Get the image for a certain xspace
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getXSpaceImageETO($xspaceid)
	{
		
		$xspaceid = intval($xspaceid);
				$sql = "SELECT p.slp_id as assetID,
						p.title_ent as title, 
						p.fext as ext, 
						p.product_id as productid 
						FROM manifest p 
						WHERE p.puid=$xspaceid
						AND p.type='0mip' AND p.category='xt01'";
		 
		
		return $this->newdb_eto->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
		
	}
	
	
	/**
	 * Return the project ideas associated with an XSpace NGO
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getProjectIdeas($xspaceid)
	{
			$sql = 'SELECT * FROM manifest
					WHERE puid='.$xspaceid.'
					AND type=\'0taj\'';

		 
		
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
/**
	 * Return the project ideas associated with an XSpace NGO
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getProjectIdeasETO($xspaceid)
	{
			$sql = 'SELECT * FROM manifest
					WHERE puid='.$xspaceid.'
					AND type=\'0taj\'';

		 
		
		return $result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Get all of the lesson plans for an xspace NGO
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getLessonPlans($xspaceid)
	{
		/* Exclude 0cw, Nabeel */
		$sql = 'SELECT * FROM manifest m
				INNER JOIN manifest l ON l.puid = '.$xspaceid.' AND m.uid=l.puid
				WHERE m.type != \'0cw\' AND l.type = \'0trl\'';

		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Get all of the lesson plans for an xspace ETO
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getLessonPlansETO($xspaceid)
	{
		
		return $this->getLessonPlans($xspaceid);
		
		/* Skip this, Nabeel
		// exclude 0cw
		$sql = 'SELECT * FROM manifest
				WHERE puid='.$xspaceid.'
				AND type=\'0trl\'';
		
		return $result = $this->newdb_eto->getAll($sql, DB_FETCHMODE_ASSOC); */
	}
	
	/**
	 * Get all of the lesson plans for a skill builder
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getSkillBuildLessonPlans($skillbuilderid)
	{
			$sql = 'SELECT * FROM manifest
					WHERE puid='.$skillbuilderid.'
					AND type=\'0trl\'';

		return $result = $this->newdb->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
		
	}
		
	
/**
	 * Get all of the lesson plans for an xspace
	 *
	 * @param int $xspaceid
	 * @return array
	 */
	public function getLessonPlansFromSLP($xspaceid)
	{
			$sql = 'SELECT m.slp_id, m.puid, m.uid FROM manifest m 
					INNER JOIN manifest x WHERE x.slp_id='.$xspaceid.'
					AND m.puid = x.uid
					AND m.type=\'0trl\'';

		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
/**
	 * Get all of the lesson plans for an xspace
	 *
	 * @param int $xspaceid
	 * @return array
	 */

	public function getLessonPlansFromSLP_eto($xspaceid)
	{
			$sql = 'SELECT m.slp_id, m.puid, m.uid FROM eto1.manifest m 
					INNER JOIN eto1.manifest x WHERE x.slp_id=\''.$xspaceid.'\'
					AND m.puid = x.uid
					AND m.type=\'0trl\'';

		 
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}	
	/**
	 * Get all of the available Skill Builders from the manifest
	 * They are sorted/ordered by the priority field
	 */
	public function getAllSkillBuilders()
	{
			$sql = 'SELECT * FROM manifest
					WHERE type=\'0laus\'
					ORDER BY priority ASC';	
		
		return $result = $this->newdb->getAll($sql, DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Gets the image of a Skill Builder from the manifest
	 *
	 * @param int $skill_builder_id
	 * @return array
	 */
	public function getSkillBuilderImage($skill_builder_id)
	{
			$sql = 'SELECT * FROM manifest
					WHERE type=\'0mit\'
					AND puid=\''.$skill_builder_id.'\'';
		
		return $this->newdb->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
	}

	/**
	 * Get a parent image of a lesson plan or some asset which is
	 * related to an xspace, by passing the SLP ID of the asset 
	 * which we want the parent image for
	 *
	 * @param int $slp_id
	 * @return unknown
	 */
	public function getParentImage($slp_id)
	{
		if(!$this->newdb)
		{	
			//echo 'hello';
			$this->__construct();
		}
		
		# This query made my head hurt
			$sql = "SELECT m.slp_id as xspaceid, m.product_id,
							i.uid, i.puid, i.slp_id, i.type, i.fext, i.title_ent, i.ada_text
					FROM manifest i 
					INNER  JOIN manifest x, manifest m 
					WHERE x.puid=m.uid  AND m.puid=0
					AND m.type='0c' AND m.uid=i.puid 
					AND i.type='0mip' AND i.category='xs01'
					AND x.slp_id='$slp_id'";

		return $this->newdb->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Get the parent information (xspace, subject, topic) for a NGO asset
	 *
	 * @param int $slp_id
	 * @return array
	 */
	public function getParentInfo($slp_id)
	{	
			$sql = "SELECT x2.sb_thing AS topic, x3.sb_thing AS subject 
					FROM xspace_browse x1, xspace_browse x2, xspace_browse x3 
					WHERE x1.sb_parent_id=x2.sb_child_id 
					AND x2.sb_parent_id=x3.sb_child_id 
					AND x1.sb_child_id='$slp_id'";
		
		 
						
		return $this->newdb->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Get the parent information (xspace, subject, topic) for an ETO asset
	 *
	 * @param int $slp_id
	 * @return array
	 */
	public function getParentInfoETO($slp_id)
	{	
			$sql = "SELECT x2.sb_thing AS topic, x3.sb_thing AS subject 
					FROM xspace_browse x1, xspace_browse x2, xspace_browse x3 
					WHERE x1.sb_parent_id=x2.sb_child_id 
					AND x2.sb_parent_id=x3.sb_child_id 
					AND x1.sb_child_id='$slp_id'";
		
		 
						
		return $this->newdb_eto->query($sql)->fetchrow(DB_FETCHMODE_ASSOC);
	}
	
	/**
	 * Disconnect both DB's
	 *
	 * @param none
	 * @return none
	 */
	public function disconnectDB()
	{	
			$this->newdb->disconnect(); 
			$this->newdb_eto->disconnect(); 
		 
	}
	
} 
?>
