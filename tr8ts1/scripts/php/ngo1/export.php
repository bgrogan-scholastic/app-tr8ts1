<?php
require_once $_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php";
$client = new LockerClient();
$citationData = $client->getcitationlist(3,149,149);
$notecardList = $client->getnotecardlist(3,149);
function exportbibliography(){
	$NumCells = 2;
	$NumRows = count($citationData);
	
	
	echo "\par\posx200\trowd\trautofit1\intbl";
	
	
	for($i=0; $i < $NumCells;$i++){
		echo "\cellx".$i;
	}
	echo "{";
	
	for ($i=0; $i<$NumCells;$i++){
		if ($i == 0){
			echo 'citations\cell';
		} else {
			echo 'notecards\cell';
		}
	}
	
	echo "}";
	
	echo "{\trowd\trautofit1\intbl";
	
	for($i=0; $i < $NumCells;$i++){
		echo "\cellx".$i;
	}
	echo "\row }";
	
	for ($l = 0;$l < $NumRows;$l++) {
		echo "\trowd\trautofit1\intbl";
		for ($i=0; $i<$NumCells; $i++) {
			echo "\cellx".$i;
		}
		echo "{";
		if ($citationData[$l]->_autocite == 1) {
			$tmpcitation = $citationData[$l]->_citationtextarray["'1'"];
		} else {
			$tmpcitation = $citationData[$l]->_citationtext;
		}
		echo $tmpcitation."\cell ";
		$tmpnotecards = findNoteCards($citationData[$l]->_citationid);
		for ($i=0; $i<count($tmpnotecards);$i++){
			echo ($tmpnotecards[$i]->_title."\n");
		}
		echo "\cell";
		echo "}";
		echo "{\trowd\trautofit1\intbl";
		for ($i=0; $i<$NumCells; $i++){
			echo "\cellx".$i;
		}
		echo "\row }";
	}
}

function findNoteCards($citationid){
	$tmparray = array();
	for ($i=0; $i < count($notecardList); $i++){
		if ($notecardList[$i]->-citationid == $citationid) {
			array_push($tmparray,$notecardList[$i]);
		}
	}
	return $tmparray;
}

exportbibliography();
?>