<?php
/**
 * @author Nabeel Shahzad
 * @version 1.0.90000000000
 * @created Jan 11 2010
 *
 * How's this work:
 * 
 * ajax.php?f=getclasslist&...
 * 
 * f= is a function in the Container{} class in this file
 * It will then just call the function passed in
 * 
 * ?f=getclasslist
 * ?f=getclasslist&profileid=86.XXXXX....
 * 
 * 
 * class Container 
 * { 
 *		public function getclasslist() 
 *		{
 *			$profileid = $this->get_clean('profileid');
 *		}
 * }
 * 
 * Then whatever other parameters. It's in a Container{} class
 * so then an arbitrary function can't be called by passing in the name
 */

include_once 'DB.php';
require_once($_SERVER['PHP_INCLUDE_HOME']."ereads1/GI_ThinkTankDisplay.php");
include_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");

/* Call up the proper function based on the f= variable passed in */
if(!isset($_REQUEST['f']) || empty($_REQUEST['f']) || !method_exists('Container', $_REQUEST['f'])) 
{
	exit;
}

$container = new Container();
call_user_func_array(array($container, $_REQUEST['f']), array());

/* OK, the actual class now */

class Container 
{
	
	public function __construct()
	{


	}
	
	protected function get_clean($var)
	{
		if(isset($_REQUEST[$var]))
		{
			return addslashes(stripslashes($_REQUEST[$var]));
		}
		
		return '';
	}
	
	/**
	 * When a question result is submitted
	 * /assessment/quickcheck?f=submitquestion
	 */
	public function submitRankIt()
	{

		//get the values from the post
		$thepost = $_POST;
		
		asort($thepost);
		
		$answerText = "";
		$count = 1;
		
		//go through them and format them into the string we need for the digital locker.
		foreach ($thepost as $key => $value) {
			
			if($key != "topicslpid" && $key != "activityid" && $key != "activitytype"){
				
				$answerText = $answerText . $key;
				
				if($count<5){
					$answerText = $answerText . "|";
				}
				$count++;
			}

		}
		
		//submit to DL
		$this->submitToDigitalLocker($thepost, $answerText);
		
		
		//$this->displayquestion($answerText);
	}	
	
	/**
	 * When a question result is submitted
	 * /assessment/quickcheck?f=submitquestion
	 */
	public function submitQuiz()
	{

		//get the values from the post
		$thepost = $_POST;
		$answerText = $thepost['totalScore'];
		
		//submit to DL
		$this->submitToDigitalLocker($thepost, $answerText);
		
		
		//$this->displayquestion($answerText);
	}
	
	
	/**
	 * When a question result is submitted
	 * /assessment/quickcheck?f=submitRateit
	 */
	public function submitRateit()
	{

		//get the values from the post
		$thepost = $_POST;
		$answerText = $thepost['starSelected'];
		
		//submit to DL
		$this->submitToDigitalLocker($thepost, $answerText);
		
		
		//$this->displayquestion($answerText);
	}	

		
	
	/**
	 * When a question result is submitted
	 * /assessment/quickcheck?f=submitquestion
	 */
	public function submitPoll()
	{

		//get the values from the post
		$thepost = $_POST;
		$answerText = $thepost['pollresult'];
		
		//submit to DL
		$this->submitToDigitalLocker($thepost, $answerText);
		
		
		//$this->displayquestion($answerText);
	}		
	
	public function submitCaption(){
		
		$thecpost = $_POST;
		
		$answerText = $thecpost['caption'];
		//echo $answerText;
		//submit to DL
		$this->submitToDigitalLocker($thecpost, $answerText);
		
		//$this->displayquestion($answerText);
		
		
	}
	
	public function submitSayWhat(){
		
		$thecpost = $_POST;
		
		
		$answerText = "";
		$answerText = $thecpost['caption1'] . "|" . $thecpost['caption2'];

		//submit to DL
		$this->submitToDigitalLocker($thecpost, $answerText);
		
		//$this->displayquestion($answerText);
		
		
	}	
	
	
		public function submitToDigitalLocker($post, $answerText)
	{
		//get the variables.
		$topic_slp_id = $post['topicslpid'];
		$activityid = $post['activityid'];
		$activitytype = $post['activitytype'];

		$cookiereader = new Cookie_Reader($_SERVER['AUTH_PCODE']);
		$profile_id = $cookiereader->getprofileid();
		$productid = $_SERVER['AUTH_PCODE'];
		
		//FOR TESTING
		//echo $resultString = "PROFILE ID: " . $profile_id . " TOPIC SLP ID: " . $topic_slp_id . " ACT ID: " . $activityid .  " ACT type: " . $activitytype . " ANS TEXT: " . $answerText;

		//make the call to the digital locker to insert the results.
		$locker_client = new Locker_Client();

		$insertthinktank = $locker_client->insertthinktankresult($profile_id, $topic_slp_id, $activityid, $activitytype, $answerText);

		$this->displayquestion($post);
	}


		/**
	/**
	 * Display a question, pass the post values
	 *
	 * @return none 
	 *
	 */
	public function displayquestion($postvalue)
	{

		$activity_type = $postvalue['activitytype'];
		
		switch ($activity_type)
		{
		case 'quiz':
		GI_ThinkTankDisplay::showQuizResults($postvalue);
		  break;
		case 'rnkg':
		  GI_ThinkTankDisplay::showRankItResults($postvalue);
		  break;
		case 'poll':
			GI_ThinkTankDisplay::showPollResults($postvalue);
		  break;
		case 'cptn':
          GI_ThinkTankDisplay::showCaptionResults($postvalue);
		  break;
		case 'sayw':
			GI_ThinkTankDisplay::showSayWhatResults($postvalue);
		  break;	
		case 'rlq':
			GI_ThinkTankDisplay::showRateItResults($postvalue);
		  break;			    	  
		default:

		}			
		
	}

}