<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Base/package.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'bkflix1/GI_DBRecord.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_List.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_BrowserDetect.php');

    require_once($_SERVER['PHP_INCLUDE_HOME'].'allflix1/collective/PairCollectiveHandler.php');

    # initialize the error manager
    $errMgr =& GI_ErrorManager::getInstance();
    $GLOBALS["errorManager"] =& $errMgr;
	$buildresult = GI_BUILD_STATUS_SUCCESS;
	$GLOBALS["fatalerror"] = FALSE;


    // 12/9/2009: Ready to make it BK/BDflix-aware
	if (!$lang = GI_getvariable('lang')) {
        $lang = 'en';
	}

    # Location of interface elements under their base directory
    $interface = "";

    # Same, only for language-aware elements
    $interface_l = "";

    // The name of the featured pair swf (no extension).  Default is the BKFlix one
    $fpswf = "BookFlix_pairs_dynamic";

    if ($_SERVER['PCODE'] == 'bdflix') {
    	# Big Day interface element subdirectory
        $interface = "bd/";

        # Big Day language-aware interface element subdirectory
        $interface_l = $interface . $lang . "/";

        // Note that the 'toggle alt' is backwards.  It's supposed to be.  The actual
        // alt, for the toggle is in the area map on the template.  The 'toggle alt'
        // below is what will be displayed if the user mouses over the inactive part
        // of the image; ie. the current language.
        if ($lang == 'en') {
            $altsplash = "/spanish";
            $familyPage = "/f";
            $helpLink = "/help";
            $toggleAlt = "English";
            $familyAlt = "Family";
            $helpAlt = "Help";
            $learnmoreAlt = "Learn More";
            $fpswf = "BDFlix_FP_en";
            $browseall = "/r";
            $titleBrowse = "Browse All";
        }
        else {
            $altsplash = "/";
            $familyPage = "/sf";
            $helpLink = "/ayuda";
            $toggleAlt = "Espa&ntilde;ol";
            $familyAlt = "Familia";
            $helpAlt = "Ayuda";
            $learnmoreAlt = "Aprende m&aacute;s";
            $fpswf = "BDFlix_FP_es";
            $browseall = "/sr";
            $titleBrowse = "Buscar";
        }

        // Now we make the adaptive splash HTML chunks
        $HTML1 = '<img src="/images/spacer.gif" height="26" width="160" border="0" alt="" /><img src="/images/' . $interface_l . 'english_dn_on.gif" alt="' . $toggleAlt . ' " name="Image7" width="190" height="30" border="0" align="bottom" usemap="#switch_' . $lang . '" /><img src="/images/spacer.gif" height="26" width="100" alt="" />' . "\n";
        $HTML1 .= '<a href="' . $familyPage . '"><img src="/images/' . $interface_l . 'family.gif" alt="' . $familyAlt . '" name="Image6" width="78" height="23" border="0" align="top"></a>' . "\n";
        $HTML1 .= '<a href="' . $helpLink . '"><img src="/images/' . $interface_l . 'help.gif" alt="' . $helpAlt . '" name="Image6" border="0" height="23" width="61" align="top"></a>' . "\n";
        $HTML1 .= '<a href="http://www.scholastic.com/bigday"><img src="/images/' . $interface_l . 'learn_more.gif" alt="' . $learnmoreAlt . '" name="Image10" border="0" height="23" width="104" align="top"></a></td>' . "\n";

        $HTML2 = '               <!--col 1--><td width="45"><img src="/images/spacer.gif" width="45" height="58" alt="" /></td>' . "\n";
        $HTML2 .= '            <!--col 2--> <td width="282"><img src="/images/spacer.gif" width="282" height="85" alt="" /></td>' . "\n";
        $HTML2 .= '            <!--col 3--> <td><img src="/images/spacer.gif" width="60" height="10" alt="" /></td>' . "\n";
        $HTML2 .= '            <!--col 4--> <td rowspan="5" id="moviediv"><script type="text/javascript">writeFeatureHTML();</script></td>' . "\n";
        $HTML2 .= '			<!--col 5--><td>&nbsp;</td>' . "\n";
        $HTML2 .= '                </tr>';
        $HTML2 .= '            <!--row 2--><tr valign="top">' . "\n";
        $HTML2 .= '               <!--col 1--><td><img src="/images/spacer.gif" width="45" height="66" alt="" /></td>' . "\n";
        $HTML2 .= '               <!--col 2--><td rowspan="8">' . "\n";

        $HTML4 = '               <td>&nbsp;</td>' . "\n";
        $HTML4 .= '                   <!-- col 4 <td>&nbsp;</td>-->' . "\n";
        $HTML4 .= '                    <td>&nbsp;</td>' . "\n";
        $HTML4 .= '                    </tr>' . "\n";
        $HTML4 .= '             <!--row 3--><tr valign="top">' . "\n";
        $HTML4 .= '               <td colspan="5"></td>' . "\n";
        $HTML4 .= '            </tr>' . "\n";
        $HTML4 .= '             <!--row 5--><tr valign="top">' . "\n";
        $HTML4 .= '               <td><img src="/images/spacer.gif" width="45" height="50" alt="" /></td>' . "\n";
        $HTML4 .= '              <td>&nbsp;</td>' . "\n";
        $HTML4 .= '               <td>&nbsp;</td>' . "\n";
        $HTML4 .= '              <!--<td width="319"><img src="/images/spacer.gif" height="45" width="241" border="1" alt="" /></td>-->' . "\n";
        $HTML4 .= '            </tr>' . "\n";
        $HTML4 .= '             <!--row 6--><tr valign="top">' . "\n";
        $HTML4 .= '               <td><img src="/images/spacer.gif" width="45" height="1" alt="" /></td>' . "\n";
        $HTML4 .= '               <td colspan="4"><img src="/images/spacer.gif" width="1" height="45" alt="" /></td>' . "\n";
        $HTML4 .= '            </tr>' . "\n";
        $HTML4 .= '		 <!--row 7-->	<tr valign="top">' . "\n";
        $HTML4 .= '               <td><img src="/images/spacer.gif" width="45" height="32" alt="" /></td>' . "\n";
        $HTML4 .= '              <td>&nbsp;</td>' . "\n";
        $HTML4 .= '              <td rowspan="4">' . "\n";
        $HTML4 .= '                    <p>';



        $HTML5 = '                    </p>                  </td>' . "\n";
        $HTML5 .= '               <td>&nbsp;</td>' . "\n";
        $HTML5 .= '            </tr>' . "\n";
        $HTML5 .= '            <tr valign="top">' . "\n";
        $HTML5 .= '               <td><img src="/images/spacer.gif" width="45" height="5" alt="" /></td>' . "\n";
        $HTML5 .= '               <td colspan="2"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '            </tr>' . "\n";
        $HTML5 .= '            <tr valign="top">' . "\n";
        $HTML5 .= '               <td><img src="/images/spacer.gif" width="45" height="150" alt="" /></td>' . "\n";
        $HTML5 .= '              <td>&nbsp;</td>' . "\n";
        $HTML5 .= '               <td>&nbsp;</td>' . "\n";
        $HTML5 .= '            </tr>' . "\n";
        $HTML5 .= '            <tr valign="top">' . "\n";
        $HTML5 .= '               <td>&nbsp;</td>' . "\n";
        $HTML5 .= '              <td><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '               <td><a href="' . $browseall . '"><img src="/images/spacer.gif" width="90" height="60" border="0" alt="' . $titleBrowse . '"></a></td>' . "\n";
        $HTML5 .= '            </tr>' . "\n";
        $HTML5 .= '         </tbody></table>';

    }
    else {
        $HTML1 = '<img src="/images/spacer.gif" width="115" height="26" alt="" /><a href="http://scholastic.com/bookflix" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image7\',\'\',\'/images/' . $interface_l . 'moreinformation_on.gif\',1)"><img src="/images/' . $interface_l . 'moreinformation_off.gif" alt="Learn More" name="Image7" width="142" height="43" border="0" /></a><a href="http://scholastic.com/" target="_blank"><img src="/images/btn_scholastic.gif" alt="Scholastic" border="0" /></a><img src="/images/spacer.gif" width="10" height="26" alt="" /><a href="/help" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image6\',\'\',\'/images/' . $interface_l . 'btn_help_on.gif\',1)"><img src="/images/' . $interface_l . 'btn_help_off.gif" alt="Help" name="Image6" width="105" height="43" border="0" /></a><a href="/r" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image10\',\'\',\'/images/' . $interface_l . 'btn_educator_on.gif\',1)"><img src="/images/' . $interface_l . 'btn_educator_off.gif" alt="Resources" name="Image10" width="184" height="43" border="0" /></a></td>';

        $HTML2 = '                 <td><img src="/images/spacer.gif" width="79" height="58" alt="" /></td>' . "\n";
        $HTML2 .= '                 <td><img src="/images/splash_fun-to-know.gif" width="241" height="56" alt="fun" /></td>' . "\n";
        $HTML2 .= '                 <td><img src="/images/spacer.gif" width="90" height="58" alt="" /></td>' . "\n";
        $HTML2 .= '                 <td colspan="3" rowspan="4" id="moviediv"><script type="text/javascript">writeFeatureHTML();</script></td>' . "\n";
        $HTML2 .= "             </tr>\n";
        $HTML2 .= '             <tr valign="top">' . "\n";
        $HTML2 .= '             <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML2 .= '             <td rowspan="11">';

        $HTML4 = '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="5" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="5" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td colspan="5"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="31" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/splash_for-fun.gif" width="241" height="66" alt="fun" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="9" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="108" height="66" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="5" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td colspan="5"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML4 .= "              </tr>\n";
        $HTML4 .= '              <tr valign="top">' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td><img src="/images/spacer.gif" width="31" height="66" alt="" /></td>' . "\n";
        $HTML4 .= '                 <td rowspan="5">' . "\n";

        $HTML5 = '                 </td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="9" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="108" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '              <tr valign="top">' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="79" height="5" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td colspan="2"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td colspan="2"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '              <tr valign="top">' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="31" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="9" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="108" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '              <tr valign="top">' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="79" height="5" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td colspan="2"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td colspan="2"><img src="/images/spacer.gif" width="1" height="1" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '              <tr valign="top">' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="79" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="90" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="31" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="9" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '                 <td><img src="/images/spacer.gif" width="108" height="66" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '              <tr valign="top">' . "\n";
        $HTML5 .= '                 <td colspan="7"><img src="/images/spacer.gif" height="5" alt="" /></td>' . "\n";
        $HTML5 .= '              </tr>' . "\n";
        $HTML5 .= '           </table>';
    }

    // Gonna need language-awareness here, at some point.  Right now, though, I ain't even got the English asset in the manifest.
	$introInfo = new GI_DBRecord("select slp_id INTROFILE from manifest where puid = '0' and type='0uii' and language='" . $lang . "' limit 1");

	$featuredPairInfo = new GI_DBRecord("select fpbrowse.pid CATID, m.uid UID, fpbrowse.cid SLPID from category_browse fpbrowse, category_browse cbrowse, category_browse tbrowse, manifest m where fpbrowse.cid = (select asset_id from fa_current where type = '0p' limit 1) and cbrowse.cid = fpbrowse.pid and tbrowse.cid = cbrowse.pid and m.slp_id = fpbrowse.cid and tbrowse.pid='" . $lang . "' order by tbrowse.seq, cbrowse.seq asc limit 1");
    $featuredPairSLPID = $featuredPairInfo->getValue('SLPID');
    $featuredPairUID = $featuredPairInfo->getValue('UID');
   	$featuredPairCatID = $featuredPairInfo->getValue('CATID');

    // At this point, we need to get the 0cp for the featured pair
    $collective = new PairCollectiveHandler($featuredPairSLPID, "allflix");
    
    $fpbjid = "";
    $fpscid = "";
    if (GI_Base::isError($collective)) {
        echo "Error creating pair 0cp handler.";
        $GLOBALS['errorManager']->reportError($collective);
        $GLOBALS['fatalerror'] = TRUE;
    }
    else {
        $fpbjid = $collective->getBookJacketId($lang);
        $fpscid = $collective->getStoryCoverId($lang);
    }

    $catFormatString = "\n" . '<script type="text/javascript">';
    if ($_SERVER['PCODE'] == 'bdflix') {
        $catFormatString .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','282','height','75','src','/limelight/##FLASHFILENOEXT##','quality','high','wmode','transparent','pluginspage','http://www.macromedia.com/go/getflashplayer','allowScriptAccess','always','movie','/limelight/##FLASHFILENOEXT##' );";
        $catFormatString .= "</script>\n";
        $catFormatString .= "<noscript>";
        $catFormatString .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="282" height="75">';
        $catFormatString .= '<param name="movie" value="/limelight/##FLASHFILE##">';
        $catFormatString .= '<param name="allowScriptAccess" value="always">';
        $catFormatString .= '<param name="quality" value="high">';
        $catFormatString .= '<param name="wmode" value="transparent">';
        $catFormatString .= '<embed src="/limelight/##FLASHFILE##" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="282" height="75" wmode="transparent">';
        $catFormatString .= '</embed>';
        $catFormatString .= '</object>';
        $catFormatString .= '</noscript>' . "\n";

        $separator = '<img src="/images/spacer.gif" width="79" height="5" alt="" />';
        if ($is_safari) {
            $separator = '<img src="/images/spacer.gif" width="1" height="7" alt="" />';
        }
        $separator1 = $separator . " ";
    }
    else {
        $catFormatString .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','240','height','66','src','/limelight/##FLASHFILENOEXT##','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','allowScriptAccess','always','movie','/limelight/##FLASHFILENOEXT##' );";
        $catFormatString .= "</script>\n";
        $catFormatString .= "<noscript>";
        $catFormatString .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="240" height="66">';
        $catFormatString .= '<param name="movie" value="/limelight/##FLASHFILE##">';
        $catFormatString .= '<param name="allowScriptAccess" value="always">';
        $catFormatString .= '<param name="quality" value="high">';
        $catFormatString .= '<embed src="/limelight/##FLASHFILE##" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="240" height="66">';
        $catFormatString .= '</embed>';
        $catFormatString .= '</object>';
        $catFormatString .= '</noscript>';

        $separator = '<img src="/images/spacer.gif" width="79" height="5" alt="" />';
        $separator1 = $separator . " ";
        if ($is_safari) {
            $separator = '<img src="/images/spacer.gif" width="1" height="7" alt="" />';
            $separator1 = '<img src="/images/spacer.gif" width="1" height="5" alt="" /> ';
        }
    }



    // This is for the category interface swfs.


    $academicCategoriesParameters = array(
        array(
            'query'     => "select concat(m.slp_id, '.', m.fext) flashfile, m.slp_id flashfilenoext
                                from category_browse cat, manifest m, category_browse catchild
                                where cat.pid in (select cid from category_browse where pid='" . $lang . "' and seq=1)
                                and m.type = '0uib' and m.slp_id = catchild.cid and catchild.pid = cat.cid order by cat.seq",
            'format'    => $catFormatString,
            'separator' => $separator1
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
                                where cat.pid in (select cid from category_browse where pid='" . $lang . "' and seq=2)
                                and m.type = '0uib' and m.slp_id = catchild.cid and catchild.pid = cat.cid order by cat.seq",
            'format'    => $catFormatString,
            'separator' => $separator
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

