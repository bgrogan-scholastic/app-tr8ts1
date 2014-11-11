<?php
require_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
$locker_client = new Locker_Client();

$profileid = $_REQUEST["profileid"];
$assignmentid = $_REQUEST["assignmentid"];


//start place holder variables for testing
//start place holder variables for testing
//start place holder variables for testing

$profileid=1;
$assignmentid=3;


//end place holder variables for testing
//end place holder variables for testing
//end place holder variables for testing

echo '<script type="text/javascript">
var profile_id='.$profileid.';
var assignment_id='.$assignmentid.';
var noteStore=new Array();';
$noteStore = $locker_client->getnotecardlist($profileid, $assignmentid,'title');
$noteCount = count($noteStore);
for ($i=0; $i<$noteCount; $i++){
	if ($noteStore[$i]->_notecardid != ''){
	
		$title= str_replace('"','\"',$noteStore[$i]->_title);
		$directquote = str_replace(chr(13).chr(10)," ",$noteStore[$i]->_directquote);
		$directquote = str_replace('"','\"',$directquote);
		$paraphrase = str_replace(chr(13).chr(10)," ",$noteStore[$i]->_paraphrase);
		$paraphrase = str_replace('"','\"',$paraphrase);
		
 		echo '
		noteStore['.$i.'] = new Array();
		noteStore['.$i.']["profileid"]="'.$noteStore[$i]->_profileid.'";
		noteStore['.$i.']["assignmentid"]="'.$noteStore[$i]->_assignmentid.'";
		noteStore['.$i.']["notecardid"]="'.$noteStore[$i]->_notecardid.'";
		noteStore['.$i.']["title"]="'.$title.'";
		
		noteStore['.$i.']["directquote"]="'.$directquote.'";
		noteStore['.$i.']["paraphrase"]="'.$paraphrase.'";
		
		noteStore['.$i.']["charcountdirectquote"]="'.$noteStore[$i]->_charcountdirectquote.'";
		noteStore['.$i.']["charcountparaphrase"]="'.$noteStore[$i]->_charcountparaphrase.'";
		noteStore['.$i.']["citationid"]="'.$noteStore[$i]->_citationid.'";
		noteStore['.$i.']["groupid"]="'.$noteStore[$i]->_groupid.'";
		noteStore['.$i.']["creationdate"]="'.$noteStore[$i]->_creationdate.'";
		noteStore['.$i.']["modifieddate"]="'.$noteStore[$i]->_modifieddate.'";
		noteStore['.$i.']["sort"]="'.$noteStore[$i]->_sort.'";
		';
	}
}
		
echo 'var groupStore=new Array();';
$groupStore = $locker_client->getgrouplist($profileid, $assignmentid,'title');
$groupCount = count($groupStore);
for ($i=0; $i<$groupCount; $i++){
	if ($groupStore[$i]->_groupid != ''){
		$titles= str_replace('"','\"',$groupStore[$i]->_title);
		echo '
		groupStore['.$i.'] = new Array();
		groupStore['.$i.']["profileid"]="'.$groupStore[$i]->_profileid.'";
		groupStore['.$i.']["assignmentid"]="'.$groupStore[$i]->_assignmentid.'";
		groupStore['.$i.']["groupid"]="'.$groupStore[$i]->_groupid.'";
		groupStore['.$i.']["title"]="'.$titles.'";
		groupStore['.$i.']["creationdate"]="'.$groupStore[$i]->_creationdate.'";
		groupStore['.$i.']["modifieddate"]="'.$groupStore[$i]->_modifieddate.'";
		groupStore['.$i.']["sort"]="'.$groupStore[$i]->_sort.'";
		';
	}
}


echo 'var assignment=new Array();';
$assignment = $locker_client->getassignment($assignmentid);
echo 'assignment["title"]="'.$assignment->_title.'";';


//Will need correct path for locker_interaction.php!!!!!!
//Will need correct path for locker_interaction.php!!!!!!
//Will need correct path for locker_interaction.php!!!!!!
//Will need correct path for locker_interaction.php!!!!!!
//Will need correct path for locker_interaction.php!!!!!!
//Remove these comments when that is done

	

	
echo '</script>';
?>
