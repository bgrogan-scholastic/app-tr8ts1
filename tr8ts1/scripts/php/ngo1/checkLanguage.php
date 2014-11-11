<?php



include($_SERVER['CONFIG_HOME'] . '/cusswords.php');

/**
* Class for checking if any bad/unacceptable words are present in the string.
* 
* You need to pass the string through the setStr() function and check the string by
* checkStr() function.
* 
* It reads in a config array of forbidden language stored in the config directory.
* There exists a separate utility for transforming a flat test file into the array in currwords.php
* 
* 
* @author      Tanmay Joshi
* @copyright    7/2008
*
*/

	
	/**
	 */
	
	class CheckLanguage{
		/**
		 * private variable _str array will contain the string to be checked
		 *
		 * @var array
		 */
		
		private $_str = array();	
		/**
		 * $list array will contain the list of the bad words from the static file
		 *
		 * @var array 
		*/	 
		private $list = array();
		
		//initialize the _str and call the function to read and build the list
		public function __construct(){
			// importing the $badlist from the cusswords.php
			global $badlist;
			$this->_str = "";
			$this->list = $badlist;
		}
		
		// public method to set the string to be checked
		public function setStr($str){
			$str = explode(" ",$str);
			
			//replace any _ * ? @ # sings if used.
			//$str = preg_replace('/[\*\?\_@]/', '', $str);   
			$this->_str = $str;
		
		}
		// method to be called to check the string
		public function checkStr(){
			$result = 0;
			$count = count($this->_str);
			
			for($i=0;$i<=$count;$i++){
				
				if(in_array(strtolower($this->_str[$i]),$this->list)){
					$result = 1;
					break;
				}
				
			}
			
			// check if any words are used within a word
			/*if($result==0){
				foreach($this->list as $words){
                	foreach($this->_str as $strs){
                    	if($getstring = strstr($strs,$words)){
                        	$result = 1;
                           	break;
                    	}
                    }
               }
			}*/
			
			return $result;	
			
		}
		
		// function reads the cusswords.txt file and creates the list array
		/*private function getList(){
			$filename='/data/ngo1_gi/docs/static/cusswords.txt';
			$file_handle = @fopen($filename,"rb");
			if($file_handle){
				
				while(!feof($file_handle)){
					$this->list[] = trim(fgets($file_handle));	
				}
				@fclose($file_handle);
			}else{
				echo "File Not Found!!!!";
				trigger_error("File Not Found!!!", E_USER_ERROR);
				die;
			}
			
			return $this->list;
		}*/
		
		
	}
	
?>
