<?php
    // Do any php set-up
	require_once('DB.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_BrowserDetect.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_Hash.php');
	
    // Random animal
    $db = DB::connect($_SERVER["DB_CONNECT_STRING"]);

    if (!DB::isError($db)) {
    	$numAnimals = $db->getOne("select count(*) from categories where type='0ta' and category is not null");
        $animalRecord = $db->getRow("select m.title_ascii title, m.slp_id id, rm.slp_id picid from manifest m, manifest rm where m.type='0ta' and rm.type = '0mp' and m.uid = rm.puid limit ".rand(0,$numAnimals-1).",1", DB_FETCHMODE_ASSOC);
        
    }
    $animalImageFile=$animalRecord['picid'];
    if (!isset($animalImageFile)) {
        $animalImageFile = '/images/ama_spl_photo.gif';
    }
    
    // then toss in the template.
    include($_SERVER['TEMPLATE_HOME'].'/splash/splash.html');
?>
