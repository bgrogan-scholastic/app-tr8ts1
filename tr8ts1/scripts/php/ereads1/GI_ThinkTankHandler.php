<?php

require_once('DB.php');
require_once($_SERVER['COMMON_CONFIG_PATH'].'/GI_ProductConfig.php');

/**
 * @author Dee Palmer
 * @version 1.0
 * @created 24-Feb-2011
 */
class GI_ThinkTankHandler
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
		$serverID = "ereads";
		$mysql_string = GI_ProductConfig::getProductDb($serverID);
		$this->_db = DB::connect($mysql_string);
	
	
	    if (DB::isError($this->_db)) 
	    {
	  
            $this->_raiseError('No database connection', 8, 1);
       
            return;
       	}        
	}//end constructor


	/**
	 * Return an array of all activities per topic
	 * @param $topic_slp_id
	 * @return array of activities
	 */
	public function getTopicActivities($topic_slp_id)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select activity.activity_text, activity_type.name, activity.id, activity.photo_slp_id, activity.activity_type, activity_type.icon_slp_id from topic_activity, activity, activity_type WHERE topic_activity.topic_slp_id='$topic_slp_id' AND topic_activity.activity_id = activity.id AND activity.activity_type = activity_type.code;";
	
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
	 * Return an array of all activities per topic
	 * @param $topic_slp_id
	 * @return array of activities
	 */
	public function getActivity($activity_id)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from activity where id='$activity_id';";
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
	 * Return an array of all activity_questions by activity.
	 * @param $topic_slp_id
	 * @return array of activity_questions
	 */
	public function getActivityQuestions($activity_id)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from activity_question where activity_id='$activity_id' order by sort_order;";
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
	 * Return an array of all activity_choices by activity.
	 * @param $question_id
	 * @return array of activity_choices
	 */
	public function getActivityChoices($question_id)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from activity_choice where question_id='$question_id' order by sort_order DESC;";
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
	 * Return the caption image info
	 * @param $topic_slp_id
	 * @return array of caption image
	 */
	public function getCaptionPicInfo($photo_slp_id)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from manifest where slp_id='$photo_slp_id';";
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
	 * Return the caption image info
	 * @param $topic_slp_id
	 * @return array of caption image
	 */
	public function getQuizResults($activity_id, $users_score)
	{
		$PArray = Array();
		/* retrieve the parent of this uid, if any */
        $qString = "select * from quiz_results where activity_id='$activity_id' and '$users_score' > threshold_low AND '$users_score' < threshold_high;";
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
	
}
?>