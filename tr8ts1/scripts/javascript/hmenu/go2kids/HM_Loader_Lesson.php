/*HM_Loader.js
* by Peter Belesis. v4.1.2 011030
* Copyright (c) 2001 Peter Belesis. All Rights Reserved.
*/

// Modified: 2/27/2004 by R.E. Dye to a php version,
// which allows the 'arrays' file to be passed as a
// parameter
// Additional changes: 12/23/2004 by T. Badura to customize
// for handling additional parameter to get asset id value
<?php
    require_once($_SERVER["PHP_INCLUDE_HOME"].'common/utils/GI_getVariable.php');
    require_once($_SERVER["PHP_INCLUDE_HOME"].'common/GI_Constants.php');
?>

   HM_DOM = (document.getElementById) ? true : false;
   HM_NS4 = (document.layers) ? true : false;
    HM_IE = (document.all) ? true : false;
   HM_IE4 = HM_IE && !HM_DOM;
   HM_Mac = (navigator.appVersion.indexOf("Mac") != -1);
  HM_IE4M = HM_IE4 && HM_Mac;
 HM_Opera = (navigator.userAgent.indexOf("Opera")!=-1);
 HM_Konqueror = (navigator.userAgent.indexOf("Konqueror")!=-1);

HM_IsMenu = !HM_Opera && !HM_Konqueror && !HM_IE4M && (HM_DOM || HM_NS4 || HM_IE4);

HM_BrowserString = HM_NS4 ? "NS4" : HM_DOM ? "DOM" : "IE4";

if(window.event + "" == "undefined") event = null;
function HM_f_PopUp(){return false};
function HM_f_PopDown(){return false};
popUp = HM_f_PopUp;
popDown = HM_f_PopDown;


HM_GL_MenuWidth          = 150;			//was 150
HM_GL_FontFamily         = "Arial,Verdana,sans-serif";
HM_GL_FontSize           = 8;                  // was 11
HM_GL_FontBold           = true;		//was true
HM_GL_FontItalic         = false;
HM_GL_FontColor          = "000000";
HM_GL_FontColorOver      = "white";
HM_GL_BGColor            = "transparent";
HM_GL_BGColorOver        = "transparent";
HM_GL_ItemPadding        = 3;

HM_GL_BorderWidth        = 0;
HM_GL_BorderColor        = "ffffcc";
HM_GL_BorderStyle        = "solid";
HM_GL_SeparatorSize      = 2;
HM_GL_SeparatorColor     = "ffffcc";

HM_GL_ImageSrc = "HM_More_black_right.gif";
HM_GL_ImageSrcLeft = "HM_More_black_left.gif";

HM_GL_ImageSrcOver =  "HM_More_white_right.gif";
HM_GL_ImageSrcLeftOver = "HM_More_white_left.gif";

HM_GL_ImageSize          = 5;
HM_GL_ImageHorizSpace    = 5;
HM_GL_ImageVertSpace     = 5;

HM_GL_KeepHilite         = false;
HM_GL_ClickStart         = false;
HM_GL_ClickKill          = 0;
HM_GL_ChildOverlap       = 0;		//was 40
HM_GL_ChildOffset        = 0;		//was 10
HM_GL_ChildPerCentOver   = null;
HM_GL_TopSecondsVisible  = .1;
HM_GL_ChildSecondsVisible = .3;
HM_GL_StatusDisplayBuild = 0;
HM_GL_StatusDisplayLink  = 1;
HM_GL_UponDisplay        = null;
HM_GL_UponHide           = null;

HM_GL_RightToLeft      = false;
HM_GL_CreateTopOnly      = HM_NS4 ? true : false;
HM_GL_ShowLinkCursor     = true;

// the following function is included to illustrate the improved JS expression handling of
// the left_position and top_position parameters
// you may delete if you have no use for it

function HM_f_CenterMenu(topmenuid) {
	var MinimumPixelLeft = 0;
	var TheMenu = HM_DOM ? document.getElementById(topmenuid) : HM_IE4 ? document.all(topmenuid) : eval("window." + topmenuid);
	var TheMenuWidth = HM_DOM ? parseInt(TheMenu.style.width) : HM_IE4 ? TheMenu.style.pixelWidth : TheMenu.clip.width;
	var TheWindowWidth = HM_IE ? document.body.clientWidth : window.innerWidth;
	return Math.max(parseInt((TheWindowWidth-TheMenuWidth) / 2),MinimumPixelLeft);
}

// custom functions for parameter passing -- added by TB

function HM_getAssetIdValue() {
	return '<?php echo GI_getVariable(GI_ASSETID); ?>';
}

function HM_getAssetIdKey() {
	return '<?php echo GI_ASSETID ?>';
}

var parameters = "";
if ( (HM_getAssetIdKey().length > 0) && (HM_getAssetIdValue().length > 0) ) {
	parameters = "?" + HM_getAssetIdKey() + "=" + HM_getAssetIdValue();
}

if(HM_IsMenu) {
	document.write("<SCR" + "IPT LANGUAGE='JavaScript1.2' SRC='<?php echo GI_getVariable('menufile')?>" + parameters + "' TYPE='text/javascript'><\/SCR" + "IPT>");
	document.write("<SCR" + "IPT LANGUAGE='JavaScript1.2' SRC='/javascript/common/hmenu/HM_Script"+ HM_BrowserString +".js' TYPE='text/javascript'><\/SCR" + "IPT>");
}

//end
