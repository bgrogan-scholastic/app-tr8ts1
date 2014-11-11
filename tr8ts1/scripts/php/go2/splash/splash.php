<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_List.php');
    require_once($_SERVER['PRODUCT_CONFIG'].'/GI_BaseHref.php');

    // Check the toggling permission cookie(s)
//     $toggleOKFlag = TRUE;
//     if (isset($_COOKIE['prefs'])) {
//         $toPos = strpos($_COOKIE['prefs'], 'ATO>N');
//         if ($toPos !== false) {
//             $toggleOKFlag = FALSE;
//         }
//     }

    // Initialize some Today Is data.
	$month = GI_getVariable('month');
	$day = GI_getVariable('day');
	
    if (!$month) {
        $month = date('m');
	}
    if (!$day) {
        $day = date('d');
	}
    $ti_date = "2002-".$month."-".$day;


    // Create a list of licensed products.
    $products = array();
    $hatchet=split('\|', $_COOKIE['auids']);
    foreach ($hatchet as $key){
        if ($key != '') {
            $auidcode=split('\>', $key);
            $productcode=split('\-', $auidcode[0]);
            $products[]=$productcode[0];
        }
    }

    // Now toss in the kids/passport specific template.
    include($_SERVER['TEMPLATE_HOME'].'/splash/splash.html');
?>
