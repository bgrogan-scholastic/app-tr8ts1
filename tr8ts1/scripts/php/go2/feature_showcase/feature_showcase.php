<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'go2/common/utils/GI_TWrapper.php');
    require_once($_SERVER['PRODUCT_CONFIG'].'/GI_BaseHref.php');

    $templateToWrap=GI_getVariable(GI_TEMPLATENAME);

    // Some 'special case' logic.  (ie: kludges)
    $chooserFlag = false;
    $mediaFlag = false;
    $noplugsFlag = false;

    $lcTname=strtolower($templateToWrap);

    if (strstr($lcTname, 'chooser')) {
        $chooserFlag = true;
    } elseif (strstr($lcTname, 'noplugs')) {
        $noplugsFlag = true;
    } elseif (ereg('sl_(kids|pass)_media_(quick|wmv)', $lcTname)) {
        $mediaFlag = true;
    }
    

    // header
    include($_SERVER['TEMPLATE_HOME'].'/feature_showcase/fsheader.html');

    // toss in the requested template.
    if (!$templateToWrap) {
        if ($_SERVER['PCODE'] == 'go2-kids') {
            $templateToWrap = 'go_kid_start.html';
        } else {
            $templateToWrap = 'go-passport_start.html';
        }
    }

    include($_SERVER['SHOWCASE_HOME'].'/'.$templateToWrap);

    // footer?
    include($_SERVER['TEMPLATE_HOME'].'/feature_showcase/fsfooter.html');

    print "</body>\n</html>\n";
?>
