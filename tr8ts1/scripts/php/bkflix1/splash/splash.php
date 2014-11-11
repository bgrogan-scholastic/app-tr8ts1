<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Base/package.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'bkflix1/GI_DBRecord.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_List.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_BrowserDetect.php');

    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'allflix1/collective/PairCollectiveHandler.php');

    # initialize the error manager
    $errMgr =& GI_ErrorManager::getInstance();
    $GLOBALS["errorManager"] =& $errMgr;
	$buildresult = GI_BUILD_STATUS_SUCCESS;
	$GLOBALS["fatalerror"] = FALSE;

	$introInfo = new GI_DBRecord("select slp_id INTROFILE from manifest where puid = '0' and type='0uii' limit 1");

	$featuredPairInfo = new GI_DBRecord("select fpbrowse.pid CATID, m.uid UID, fpbrowse.cid SLPID from category_browse fpbrowse, category_browse cbrowse, category_browse tbrowse, manifest m where fpbrowse.cid = (select asset_id from fa_current where type = '0p' limit 1) and cbrowse.cid = fpbrowse.pid and tbrowse.cid = cbrowse.pid and m.slp_id = fpbrowse.cid order by tbrowse.seq, cbrowse.seq asc limit 1");
    $featuredPairSLPID = $featuredPairInfo->getValue('SLPID');
    $featuredPairUID = $featuredPairInfo->getValue('UID');
   	$featuredPairCatID = $featuredPairInfo->getValue('CATID');

    // At this point, we need to get the 0cp for the featured pair
    //$featureIntroInfo = new GI_DBRecord("select slp_id INTROFILE from manifest where puid = '".$featuredPairUID."' and type='0uif'");
    $binaryAsset = new GI_BinaryAsset(array(
        CS_PRODUCTID    =>  'bkflix',
        GI_ASSETID      =>  $featuredPairSLPID,
        'fext'          =>  'xml'));

    $fpbjid = "";
    $fpscid = "";
    if (GI_Base::isError($binaryAsset)) {
        echo "Error fetching featured pair 0cp binary asset";
        $GLOBALS['errorManager']->reportError($binaryAsset);
        $GLOBALS['fatalerror'] = TRUE;
    }
    else {
        $collective = new PairCollectiveHandler($_SERVER['CS_DOCS_ROOT'] . $binaryAsset->getUrlPath());
        $fpbjid = $collective->getBookJacketId();
        $fpscid = $collective->getStoryCoverId();
    }
    
    // This is for the category interface swfs.
    $catFormatString = '<script type="text/javascript">';
    $catFormatString .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','240','height','66','src','/limelight/##FLASHFILENOEXT##','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','allowScriptAccess','always','movie','/limelight/##FLASHFILENOEXT##' );";
    $catFormatString .= "</script>";
    $catFormatString .= "<noscript>";
    $catFormatString .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="240" height="66">';
    $catFormatString .= '<param name="movie" value="/limelight/##FLASHFILE##">';
    $catFormatString .= '<param name="allowScriptAccess" value="always">';
    $catFormatString .= '<param name="quality" value="high">';
    $catFormatString .= '<embed src="/limelight/##FLASHFILE##" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="240" height="66">';
    $catFormatString .= '</embed>';
    $catFormatString .= '</object>';
    $catFormatString .= '</noscript>';


    $academicCategoriesParameters = array(
        array(
            'query'     => "select concat(m.slp_id, '.', m.fext) flashfile, m.slp_id flashfilenoext
                                from category_browse cat, manifest m, category_browse catchild
                                where cat.pid in (select cid from category_browse where pid='0' and seq=1)
                                and m.type = '0uib' and m.slp_id = catchild.cid and catchild.pid = cat.cid order by cat.seq",
            'format'    => $catFormatString,
            'separator' => '<img src="/images/spacer.gif" width="79" height="5" />'
            ),
    );

	$academicCategories = new GI_List($academicCategoriesParameters);
    $totalrows = $academicCategories->create();
	if (GI_Base::isError($totalrows)) {
        $errMgr->reportError($totalrows);
        $GLOBALS["fatalerror"]=TRUE;
	}


    $whimsicalCategoriesParameters = array(
        array(
            'query'     => "select concat(m.slp_id, '.', m.fext) flashfile, m.slp_id flashfilenoext
                                from category_browse cat, manifest m, category_browse catchild
                                where cat.pid in (select cid from category_browse where pid='0' and seq=2)
                                and m.type = '0uib' and m.slp_id = catchild.cid and catchild.pid = cat.cid order by cat.seq",
            'format'    => $catFormatString,
            'separator' => '<img src="/images/spacer.gif" width="79" height="5"  />'
            ),
    );

	$whimsicalCategories = new GI_List($whimsicalCategoriesParameters);
    $totalrows = $whimsicalCategories->create();
	if (GI_Base::isError($totalrows)) {
        $errMgr->reportError($totalrows);
        $GLOBALS["fatalerror"]=TRUE;
	}


    // then toss in the template.
    include($_SERVER['TEMPLATE_HOME'].'/splash/splash.html');
?>

