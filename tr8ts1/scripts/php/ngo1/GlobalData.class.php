<?php

	require_once 'AbstractSubject.class.php';
	require_once 'AbstractObserver.class.php';
	require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
	
	
	
	class GlobalData extends AbstractSubject {
		
		private static $instance;
		
		private $profileData = NULL;	
		private $assignmentData = NULL;
			
		private $observers = array();
		
		function __construct() {
			echo "Establishing Global Data...<br /><br />";
		}
		
		/* There should only be 1 instance of this class */
		public static function getInstance() {
			if (!self::$instance) {
				self::$instance = new self;
			}
			
			return self::$instance;
		}
		
		
		function attach(AbstractObserver $observer_in) {
			array_push($this->observers, $observer_in);
		}
		function detach(AbstractObserver $observer_in) {
			$key = array_search($observer_in, $this->observers);
			unset($this->observers[$key]);
		}
		function notify() {
			foreach ($this->observers as $obs) {
				$obs->update($this);
			}
		}
		
		function setProfile($profileid) {
			if (is_int($profileid)) {
				echo "Calling the SOAP client (Profile) ...<br />";
				$locker_client = new Locker_Client();
				$profile = $locker_client->getprofile($profileid);
				$this->profileData = '{"profiledata":' . json_encode($profile) . '}';
				
				$this->notify();
			}
			else {
				die;
			}
		}
		
		function getProfile() {
			return $this->profileData;
		}
		
		function setAssignmentList($profileid, $productid, $active, $sort) {
			try {
				echo "Calling the SOAP client (Assignment) ... <br />";
				
				$locker_client = new Locker_Client();
				$assignmentlist = $locker_client->getassignmentlist($profileid, $productid, $active, $sort);
				
				$this->assignmentData = '{"assignmentdata":' . json_encode($assignmentlist) . '}';
				
				$this->notify();
			}
			catch (Exception $e) {}
		}
		
		function getAssignmentList() {
			return $this->assignmentData;
		}
	}