/* Copyright 2005-2008 Texthelp Systems Ltd
 */var aaa = "rwDontAlter";
var baa = "rwTHcomp";
var caa = "rwTHgen";
var daa = "rwTHpgen";
var FAST_SPEED = 55;
var MEDIUM_SPEED = 40;
var DEFAULT_SPEED = MEDIUM_SPEED;
var SLOW_SPEED = 25;
var VERY_SLOW_SPEED = 15;
var jaa = "eba_language ENG_UK  ENGLISH UK ENG_US ENGLISH_US SPANISH SPANISH_US ESPANOL SPANISH_ES FRENCH FRENCH_CN";
var ENG_UK = 0;
var UK = 0;
var ENGLISH = 0;
var ENG_US = 1;
var ENGLISH_US = 1;
var SPANISH = 2;
var SPANISH_US = 2;
var ESPANOL = 3;
var SPANISH_ES = 3;
var FRENCH = 4;
var FRENCH_CN = 5;
var uaa = [ "ScanSoft Emily_Full_22kHz", "ScanSoft Jill_Full_22kHz",
		"ScanSoft Paulina_Full_22kHz", "ScanSoft Isabel_Full_22kHz",
		"ScanSoft Virginie_Full_22kHz", "ScanSoft Julie_Full_22kHz" ];
var vaa = "eba_locale LOCALE_UK LOCALE_US ";
var LOCALE_UK = "UK";
var LOCALE_US = "US";
var yaa = [
		[
				"Click To Speak Mode",
				"Select this then click anywhere in the book to start reading text",
				"Haz clic para el modo hablado" ],
		[ "Speak The Current Selection", "Speak the current selection",
				"Leer en voz alta el texto seleccionado" ],
		[ "Stop Speech", "Stops speech playback", "Parar voz" ],
		[
				"Translate Word",
				"Double-click a word in the book and click this icon\n"
						+ "to translate the word into Spanish",
				"Traducir palabra" ],
		[
				"Fact Finder",
				"Select some text in the book and click this icon to\n"
						+ "perform a Google search", "Buscador de datos" ],
		[
				"Dictionary",
				"Double-click a word in the book and click this icon to\n"
						+ "see dictionary definitions", "Diccionario" ],
		[
				"Highlight Cyan",
				"Make a selection in the book and click this icon to\n"
						+ "create a blue highlight", "Realce azul verdoso" ],
		[
				"Highlight Magenta",
				"Make a selection in the book and click this icon to\n"
						+ "create a pink highlight", "Realce morado" ],
		[
				"Highlight Yellow",
				"Make a selection in the book and click this icon to\n"
						+ "create a yellow highlight", "Realce amarillo" ],
		[
				"Highlight Green",
				"Make a selection in the book and click this icon to\n"
						+ "create a green highlight", "Realce verde" ],
		[ "Remove Highlights", "Remove all your highlights from this page",
				"Borrar realce" ],
		[
				"Collect Highlights",
				"Collect all your highlights and display them\n"
						+ "in a window, grouped by color", "Recopilar realces" ],
		[
				"Click here to copy the text to the clipboard",
				"Click here to copy the text to the clipboard",
				"Haz clic aqu" + String.fromCharCode(237)
						+ " para copiar el texto al portapapeles" ], ];
var zaa = 0;
var Aba = zaa++;
var Bba = zaa++;
var Cba = zaa++;
var Dba = zaa++;
var Eba = zaa++;
var Fba = zaa++;
var Gba = zaa++;
var Hba = zaa++;
var Iba = zaa++;
var Jba = zaa++;
var Kba = zaa++;
var Lba = zaa++;
var Mba = zaa++;
var clicktospeak_icon = 1;
var play_icon = 2;
var search_icons = 28;
var translation_icon = 4;
var factfinder_icon = 8;
var dictionary_icon = 16;
var language_icons = 224;
var spelling_icon = 32;
var homophone_icon = 64;
var prediction_icon = 128;
var highlight_icons = 3840;
var highlightcyan_icon = 256;
var highlightmagenta_icon = 512;
var highlightyellow_icon = 1024;
var highlightgreen_icon = 2048;
var collect_icon = 4096;
var submit_icon = 8192;
var sticky_icon = 16384;
var funplay_icon = 32768;
var proncreate_icon = 65536;
var pronCreate_icon = 65536;
var pronedit_icon = 131072;
var pronEdit_icon = 131072;
var selectspeed_icon = 262144;
var selectSpeed_icon = 262144;
var fullbrowsealoud_icons = 7967;
var standardbrowsealoud_icons = 31;
var minbrowsealoud_icons = 1;
var lessonserver_icons = 12063;
var lessonserverswa_icons = 12287;
var no_bar = 0;
var title_rw = 0;
var title_ba = 1;
var title_ebooks = 2;
var title_th = 3;
var title_portal = 4;
var Nba = false;
var Oba = false;
var Pba = false;
var Qba = false;
var Rba = false;
var Sba = false;
var Tba = true;
var Uba = true;
var Vba = " ls_teacherFlag FAST_SPEED DEFAULT_SPEED MEDIUM_SPEED SLOW_SPEED VERY_SLOW_SPEED";
var Wba = false;
var eba_allow_alerts_flag = true;
var eba_server_version;
var eba_serverVersion;
var eba_client_version;
var eba_clientVersion;
var eba_icons;
var eba_no_display_icons;
var eba_server;
var eba_speech_server;
var eba_speechServer;
var eba_speech_server_backup;
var eba_speechServerBackup;
var eba_folder;
var eba_client_folder;
var eba_clientFolder;
var eba_voice;
var eba_title;
var eba_on_click;
var eba_login_name;
var eba_login_password;
var eba_loginName;
var eba_loginPassword;
var eba_language;
var eba_voice_from_lang_flag;
var eba_locale;
var eba_speed_value;
var eba_speedValue;
var eba_speed_offset;
var ls_teacherFlag = false;
var eba_no_title;
var eba_noTitleFlag;
var eba_hidden_bar;
var eba_initial_clicktospeak;
var eba_continuous_reading;
var eba_ignore_buttons;
var eba_speechCacheGenerateFlag;
var eba_speechCacheFlag;
var eba_autoCachePage;
var eba_cacheResult = "";
var eba_override_x;
var eba_override_y;
var eba_cust_id;
var eba_custId;
var eba_book_id;
var eba_bookId;
var eba_page_id;
var eba_pageId;
var eba_annotate_confirm_delete_note;
var eba_annotate_persist_notes;
var eba_annotate_persist_highlights;
var eba_annotate_note_editor_id;
var eba_annotate_highlight_editor_id;
var eba_annotate_storage_url;
var eba_annotate_note_reader_id;
var eba_annotate_highlight_reader_id;
var eba_popupSpeechFlag;
var eba_popupFreezeOnShiftFlag;
var Yba = true;
var Zba = "133";
var aba = "133";
var bba = fullbrowsealoud_icons;
var cba = 0;
var dba = "portal.texthelp.com";
var eba = "speechserver1.texthelp.com";
var fba = null;
var gba = "EmbeddedBrowsealoud";
var hba = "/EmbeddedBrowsealoud/";
var iba = "ScanSoft Jill_Full_22kHz";
var jba = title_th;
var kba = null;
var lba = null;
var mba = null;
var nba = -1;
var oba = "rwonline";
var pba = "rwonline";
var qba = 0;
var rba = false;
var sba = null;
var tba = "US";
var uba = MEDIUM_SPEED;
var vba = false;
var wba = false;
var xba = false;
var yba = false;
var zba = false;
var Aca = false;
var Bca = null;
var Cca = false;
var Dca = false;
var Eca = "*";
var Fca = "*";
var Gca = "*";
var Hca = "*";
var Ica = false;
var Jca = false;
var Kca = "portal.texthelp.com";
var Lca = "";
var Mca = true;
var Nca = -1;
var Oca = -1;
var Pca = -1;
var Qca = -1;
var Rca = -1;
var Sca = false;
var Tca = false;
var Uca = false;
var Vca = true;
var Wca = null;
var Xca = false;
var Yca = false;
function $rw_setIconsToLoad(p_nIcons) {
	var Zca = false;
	if ((p_nIcons & clicktospeak_icon) == clicktospeak_icon) {
		if (!Xca) {
			Nca = Gea('hover', yaa[Aba][qba]);
		}
		Zca = true;
	}
	if ((p_nIcons & play_icon) == play_icon) {
		if (!zba && !yba) {
			if (!Xca) {
				vda('play', yaa[Bba][qba]);
			}
			Zca = true;
		}
	}
	if (Zca) {
		vda('stop', yaa[Cba][qba]);
	}
	var aca = false;
	if ((p_nIcons & funplay_icon) == funplay_icon) {
		vda('funplay', yaa[Bba][qba]);
		aca = true;
	}
	if (aca) {
		vda('funstop', yaa[Cba][qba]);
	}
	if ((p_nIcons & translation_icon) == translation_icon) {
		vda('trans', yaa[Dba][qba]);
	}
	if ((p_nIcons & factfinder_icon) == factfinder_icon) {
		vda('ffinder', yaa[Eba][qba]);
	}
	if ((p_nIcons & dictionary_icon) == dictionary_icon) {
		vda('dict', yaa[Fba][qba]);
	}
	if ((p_nIcons & spelling_icon) == spelling_icon) {
		Pca = Gea('spell', 'Spell Checker');
	}
	if ((p_nIcons & homophone_icon) == homophone_icon) {
		Qca = Gea('homophone', 'Homophone Checker');
	}
	if ((p_nIcons & prediction_icon) == prediction_icon) {
		Rca = Gea('pred', 'Prediction Checker');
	}
	var bca = false;
	if ((p_nIcons & highlightcyan_icon) == highlightcyan_icon) {
		vda('cyan', yaa[Gba][qba]);
		bca = true;
	}
	if ((p_nIcons & highlightmagenta_icon) == highlightmagenta_icon) {
		vda('magenta', yaa[Hba][qba]);
		bca = true;
	}
	if ((p_nIcons & highlightyellow_icon) == highlightyellow_icon) {
		vda('yellow', yaa[Iba][qba]);
		bca = true;
	}
	if ((p_nIcons & highlightgreen_icon) == highlightgreen_icon) {
		vda('green', yaa[Jba][qba]);
		bca = true;
	}
	if (bca) {
		vda('clear', yaa[Kba][qba]);
	}
	if ((p_nIcons & collect_icon) == collect_icon) {
		vda('collect', yaa[Lba][qba]);
	}
	if ((p_nIcons & submit_icon) == submit_icon) {
		vda('submit', 'Submit');
	}
	if ((p_nIcons & sticky_icon) == sticky_icon) {
		Oca = Gea('sticky', 'Sticky note', 'gif');
	}
	if (kba != null && lba != null && mba != null) {
		if ((p_nIcons & pronCreate_icon) == pronCreate_icon) {
			vda('pronCreate', 'Create pronunciation', 'gif');
		}
		if ((p_nIcons & pronEdit_icon) == pronEdit_icon) {
			vda('pronEdit', 'Edit pronunciation', 'gif');
		}
	}
}
function $rw_setVoice(p_strName) {
	if (typeof (p_strName) == "string") {
		if (p_strName != null && p_strName.length > 0) {
			eba_voice = p_strName;
			iba = p_strName;
			try {
				var dca = rw_getWebToSpeech();
				dca.setVoiceName(iba);
			} catch (err) {
			}
		}
	}
}
function $rw_setVoiceForLanguage(p_strName, p_nLanguageCode) {
	if (typeof (p_nLanguageCode) == "string") {
		try {
			p_nLanguageCode = parseInt(p_nLanguageCode);
		} catch (err) {
			return;
		}
	}
	if (typeof (p_strName) == "string" && typeof (p_nLanguageCode) == "number") {
		if (p_strName != null && p_strName.length > 0 && p_nLanguageCode >= 0
				&& p_nLanguageCode < uaa.length) {
			uaa[p_nLanguageCode] = p_strName;
		}
	}
}
function $rw_setSpeedValue(p_nSpeedValue) {
	if (typeof (p_nSpeedValue) == "number") {
		if (p_nSpeedValue > -4 && p_nSpeedValue < 101) {
			eba_speedValue = p_nSpeedValue;
			eba_speed_value = p_nSpeedValue;
			uba = p_nSpeedValue;
			try {
				var dca = rw_getWebToSpeech();
				dca.setSpeedValue("" + uba);
			} catch (err) {
			}
		}
	} else if (typeof (p_nSpeedValue) == "string") {
		var eca = p_nSpeedValue.toUpperCase();
		if (eca == "VERY_SLOW_SPEED") {
			$rw_setSpeedValue(VERY_SLOW_SPEED);
		} else if (eca == "SLOW_SPEED") {
			$rw_setSpeedValue(SLOW_SPEED);
		} else if (eca == "MEDIUM_SPEED") {
			$rw_setSpeedValue(MEDIUM_SPEED);
		} else if (eca == "FAST_SPEED") {
			$rw_setSpeedValue(FAST_SPEED);
		}
	}
}
function $rw_setBarVisibility(p_bShow) {
	if (typeof (p_bShow) == "boolean") {
		var fca = document.getElementById("rwDrag");
		if (p_bShow) {
			fca.style.visibility = "visible";
			fca.style.display = "inline";
		} else {
			fca.style.visibility = "hidden";
			fca.style.display = "none";
		}
		wba = !p_bShow;
		nga();
	}
}
function $rw_enableClickToSpeak(p_bEnable) {
	if (p_bEnable && !g_bHover) {
		$rw_event_hover(null, Nca);
	} else if (!p_bEnable && g_bHover) {
		$rw_event_hover(null, Nca);
		if (Nca > -1) {
			var ara = Ida;
			Ida = 0;
			rw_mouseOffIcon("hover");
			Ida = ara;
		}
	}
}
function $rw_enableSpeachByPopup(p_bState) {
	Xca = p_bState;
	if (Xca == false) {
		Jfa();
		Kfa();
		$rw_stopSpeech();
	}
}
var hca = null;
function $rw_speakCurrentSentence(p_node, p_nOffset) {
	$rw_stopSpeech();
	var Fxa;
	var wca;
	if (typeof (p_node) == "undefined" || p_node == null) {
		if (hca == null) {
			var oca = Rna(document.body);
			if (oca == null) {
				return;
			}
			Fxa = Rra(oca);
			wca = new THHoverTarget(null, null, Fxa);
		} else {
			wca = hca;
		}
	} else {
		if (p_node instanceof Zia) {
			Fxa = Rra(p_node);
		} else {
			var PAb;
			if (typeof (p_nOffset) == "undefined") {
				PAb = new THCaret(p_node, 0);
			} else {
				PAb = new THCaret(p_node, p_nOffset);
			}
			var oza = bma(PAb);
			var pza = mma(PAb);
			var oca = new Zia(oza, pza);
			if (oca == null) {
				return;
			}
			Fxa = Rra(oca);
		}
		wca = new THHoverTarget(null, null, Fxa);
	}
	rw_speakHoverTarget(wca);
	hca = wca;
}
function $rw_speakNextSentence() {
	$rw_stopSpeech();
	if (hca == null) {
		$rw_speakCurrentSentence();
		return;
	}
	var tca = hca.getCaretRange();
	var vka = gna(tca);
	if (vka == null) {
		return;
	}
	var Fxa = Rra(vka);
	var wca = new THHoverTarget(null, null, Fxa);
	rw_speakHoverTarget(wca);
	hca = wca;
}
function $rw_speakPreviousSentence() {
	$rw_stopSpeech();
	if (hca == null) {
		$rw_speakCurrentSentence();
		return;
	}
	var tca = hca.getCaretRange();
	var uca = nna(tca);
	if (uca == null) {
		return;
	}
	var Fxa = Rra(uca);
	var wca = new THHoverTarget(null, null, Fxa);
	rw_speakHoverTarget(wca);
	hca = wca;
}
function $rw_getTHCaretRangeFromSelection() {
	var sel = Nqa();
	if (sel != null && sel.range instanceof yia) {
		return Ura(sel.range);
	}
	return null;
}
Pba = true;
Pba = true;/* Code designed and developed by Stuart McWilliams. */
var xca = false;
var g_icons = new Array();
var g_toggleIcons = new Array();
var zca = 0;
var Ada = 0;
var Bda = 300;
var Cda = {
	x :0,
	y :0
};
var Dda = {
	x :0,
	y :0
};
var Eda = null;
var Fda = false;
var Gda = 5;
var Hda = false;
var Ida = 0;
var g_strLastClicked = "";
var Kda = 1.0;
var Lda = 0.01;
var Mda;
if (jba == title_th) {
	Mda = 8;
} else {
	Mda = 4;
}
var Nda = 60;
var Oda = [ 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 ];
var Pda = [ 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 ];
var Qda = [ 400, 300, 300, 300, 600, 250, 220, 660 ];
var Rda = [ 40, 40, 40, 40, 40, 250, 40, 60 ];
var Sda = [ false, false, false, false, false, false, false, false ];
var g_bHover = false;
var Uda = 0;
var Vda = 1;
var Wda = 2;
var Xda = 3;
var Yda = 4;
var Zda = 5;
var ada = 6;
var bda = 7;
var cda = navigator.appName == "Microsoft Internet Explorer";
var dda = navigator.appVersion.indexOf("Safari") > -1;
var eda = !(cda || dda);
var fda = "localhost";
var $g_strFileLoc = "";
var gda = "";
var g_speakableTextAreaTarget = null;
var g_nSpeakableTextAreaTimerId = 0;
var jda = 1;
var kda = 0;
var lda = false;
var mda = false;
var nda = null;
var oda = 1;
var pda = 2;
var qda = 3;
var rda = "";
var sda = false;
var tda = 1;
var uda = false;
function vda(p_strName, p_strAlt, p_strExt) {
	if (typeof (p_strExt) == "undefined") {
		p_strExt = "jpg";
	}
	g_icons[zca] = new Array(6);
	g_icons[zca][0] = p_strName;
	g_icons[zca][1] = new Image();
	g_icons[zca][1].name = p_strName;
	g_icons[zca][1].src = $g_strFileLoc + 'rwimgs/' + p_strName + '-flat.'
			+ p_strExt;
	g_icons[zca][2] = new Image();
	g_icons[zca][2].name = p_strName;
	g_icons[zca][2].src = $g_strFileLoc + 'rwimgs/' + p_strName + '-hover.'
			+ p_strExt;
	g_icons[zca][3] = new Image();
	g_icons[zca][3].name = p_strName;
	g_icons[zca][3].src = $g_strFileLoc + 'rwimgs/' + p_strName + '-toggle.'
			+ p_strExt;
	g_icons[zca][4] = p_strAlt;
	g_icons[zca][5] = new Image();
	g_icons[zca][5].src = $g_strFileLoc + 'rwimgs/' + p_strName + '-grey.'
			+ p_strExt;
	zca++;
}
var wda = 1;
var xda = 2;
var yda = 3;
var zda = 4;
var Aea = 1;
var Bea = 2;
var Cea = 3;
var Dea = 5;
var Eea = 6;
var Fea = 7;
function Gea(name, alt, p_strExt) {
	if (typeof (p_strExt) == "undefined") {
		p_strExt = "jpg";
	}
	var hCb = Ada;
	g_toggleIcons[Ada] = new Array(9);
	g_toggleIcons[Ada][0] = name;
	g_toggleIcons[Ada][1] = new Image();
	g_toggleIcons[Ada][1].name = name;
	g_toggleIcons[Ada][1].src = $g_strFileLoc + 'rwimgs/' + name + 'off-flat.'
			+ p_strExt;
	g_toggleIcons[Ada][2] = new Image();
	g_toggleIcons[Ada][2].name = name;
	g_toggleIcons[Ada][2].src = $g_strFileLoc + 'rwimgs/' + name + 'off-hover.'
			+ p_strExt;
	g_toggleIcons[Ada][3] = new Image();
	g_toggleIcons[Ada][3].name = name;
	g_toggleIcons[Ada][3].src = $g_strFileLoc + 'rwimgs/' + name
			+ 'off-toggle.' + p_strExt;
	g_toggleIcons[Ada][4] = alt;
	g_toggleIcons[Ada][5] = new Image();
	g_toggleIcons[Ada][5].name = name;
	g_toggleIcons[Ada][5].src = $g_strFileLoc + 'rwimgs/' + name + 'off-grey.'
			+ p_strExt;
	g_toggleIcons[Ada][6] = new Image();
	g_toggleIcons[Ada][6].name = name;
	g_toggleIcons[Ada][6].src = $g_strFileLoc + 'rwimgs/' + name + 'on-toggle.'
			+ p_strExt;
	g_toggleIcons[Ada][7] = new Image();
	g_toggleIcons[Ada][7].name = name;
	g_toggleIcons[Ada][7].src = $g_strFileLoc + 'rwimgs/' + name + 'on-grey.'
			+ p_strExt;
	g_toggleIcons[Ada][8] = false;
	Ada++;
	return hCb;
}
function Jea(p_strName) {
	var i = 0;
	for (i = 0; i < g_toggleIcons.length; i++) {
		if (g_toggleIcons[i][0] == p_strName) {
			return i;
		}
	}
	for (i = 0; i < g_icons.length; i++) {
		if (g_icons[i][0] == p_strName) {
			return i;
		}
	}
	return -1;
}
function Kea(i) {
	var tea;
	tea = '';
	var Tea = g_icons[i][1].src;
	var VBb = g_icons[i][0];
	var mja = g_icons[i][4];
	if (dda) {
		if (VBb.equalsTH("submit")) {
			Mda += 53;
			tea = '<img  ignore="1" name="' + VBb + '" class=rwIcon src="'
					+ Tea + '" width=53 height=32 ';
		} else {
			Mda += 33;
			tea = '<img  ignore="1" name="' + VBb + '" class=rwIcon src="'
					+ Tea + '" width=33 height=32 ';
		}
		tea += 'alt="' + mja + '"';
		tea += 'title="' + mja + '"';
		tea += 'id="thnodragicon"';
		tea += 'onclick="if($rw_blockClick(\'' + VBb
				+ '\')){return true;}else{$rw_event_' + VBb + '(event);}"';
		tea += 'onMouseOver="rw_mouseOverIcon(\'' + VBb + '\')" ';
		tea += 'onMouseOut="rw_mouseOffIcon(\'' + VBb + '\')" ';
		tea += 'onMouseDown="rw_press(\'' + VBb + '\')"';
		tea += 'onMouseUp="rw_mouseOverIcon(\'' + VBb + '\')"';
		tea += '>';
	} else {
		var Wea = 33;
		if (VBb.equalsTH("submit")) {
			Wea = 53;
		}
		tea += '<span ignore="1"';
		tea += 'onMouseOver="rw_mouseOverIcon(\'' + VBb + '\'); " '
				+ 'onMouseOut="rw_mouseOffIcon(\'' + VBb + '\'); " '
				+ 'onMouseDown="' + 'rw_press(\'' + VBb + '\'); '
				+ 'g_strLastClicked=\'' + VBb + '\';" ' + 'onMouseUp="'
				+ 'rw_mouseOverIcon(\'' + VBb + '\'); '
				+ 'if(g_strLastClicked.equalsTH(\'' + VBb + '\'))' + '{'
				+ 'if($rw_blockClick(\'' + VBb + '\'))' + '{return true;}'
				+ 'else' + '{' + '$rw_event_' + VBb + '(event);' + '}' + '}" >';
		tea += Qea(g_icons[i][1].src, VBb, "flat", mja, Wea, true);
		tea += Qea(g_icons[i][2].src, VBb, "hover", mja, 0, false);
		tea += Qea(g_icons[i][3].src, VBb, "toggle", mja, 0, false);
		tea += Qea(g_icons[i][5].src, VBb, "mask", mja, 0, false);
		tea += '</span>';
	}
	return tea;
}
function Qea(p_strIcon, p_strName, p_strExt, p_strAlt, p_nWidth, p_bShow) {
	var tea;
	tea = '';
	Mda += p_nWidth;
	tea = '<img ignore="1" name="' + p_strName + p_strExt
			+ '" class=rwIcon src="' + p_strIcon + '" width=' + p_nWidth
			+ ' height=32 ' + 'style="width:' + p_nWidth + 'px;" ' + 'alt="'
			+ p_strAlt + '" title="' + p_strAlt + '" id="thnodragicon" ';
	if (p_bShow) {
		tea += 'style="visibility:visible; display:inline" ';
	} else {
		tea += 'style="visibility:hidden; display:none" ';
	}
	tea += '/>';
	return tea;
}
function Sea(i) {
	var tea;
	tea = '';
	var Tea = g_toggleIcons[i][1].src;
	var VBb = g_toggleIcons[i][0];
	var mja = g_toggleIcons[i][4];
	if (VBb == "hover" && eba_initial_clicktospeak) {
		Tea = g_toggleIcons[i][Eea].src;
		g_toggleIcons[i][8] = true;
	}
	if (dda) {
		Mda += 33;
		tea = '<img  ignore="1" name="' + VBb + '" class=rwIcon src="' + Tea
				+ '" width=33 height=32 '
				+ 'style="visibility:visible; display:inline" ' + 'alt="' + mja
				+ '" title="' + mja + '" id="thnodragicon" ';
		tea += 'onMouseOver=' + '"if(g_toggleIcons[' + i + '][8] == false) '
				+ '{' + 'rw_mouseOverIcon(\'' + VBb + '\');' + '} " '
				+ 'onMouseOut=' + '"if(g_toggleIcons[' + i + '][8] == false) '
				+ '{' + 'rw_mouseOffIcon(\'' + VBb + '\');' + '} " '
				+ 'onMouseDown=' + '"if(g_toggleIcons[' + i + '][8] == false)'
				+ '{' + 'rw_press(\'' + VBb + '\');' + '} '
				+ 'g_strLastClicked=\'' + VBb + '\';" ' + 'onMouseUp='
				+ '"if(g_strLastClicked.equalsTH(\'' + VBb + '\'))' + '{'
				+ 'if(g_bSpeechModeFlag && ICONS_TO_DISABLE.indexOf(\'' + VBb
				+ '\')> -1)' + '{return true;}' + 'else{$rw_event_' + VBb
				+ '(event, ' + i + ');}' + '}' + 'if(g_toggleIcons[' + i
				+ '][8] == false)' + '{' + 'rw_mouseOverIcon(\'' + VBb + '\');'
				+ '}" ';
		tea += '>';
	} else {
		var Wea = 33;
		tea += '<span ignore="1"';
		tea += 'onMouseOver=' + '"if(g_toggleIcons[' + i + '][8] == false) '
				+ '{' + 'rw_mouseOverIcon(\'' + VBb + '\');' + '} " '
				+ 'onMouseOut=' + '"if(g_toggleIcons[' + i + '][8] == false) '
				+ '{' + 'rw_mouseOffIcon(\'' + VBb + '\');' + '} " '
				+ 'onMouseDown=' + '"if(g_toggleIcons[' + i + '][8] == false)'
				+ '{' + 'rw_press(\'' + VBb + '\');' + '} '
				+ 'g_strLastClicked=\'' + VBb + '\';" ' + 'onMouseUp='
				+ '"if(g_strLastClicked.equalsTH(\'' + VBb + '\'))' + '{'
				+ 'if(g_bSpeechModeFlag && ICONS_TO_DISABLE.indexOf(\'' + VBb
				+ '\')> -1)' + '{return true;}' + 'else{$rw_event_' + VBb
				+ '(event, ' + i + ');}' + '}' + 'if(g_toggleIcons[' + i
				+ '][8] == false)' + '{' + 'rw_mouseOverIcon(\'' + VBb + '\');'
				+ '}" >';
		tea += Qea(g_toggleIcons[i][1].src, VBb, "flat", mja, Wea, true);
		tea += Qea(g_toggleIcons[i][2].src, VBb, "hover", mja, 0, false);
		tea += Qea(g_toggleIcons[i][3].src, VBb, "toggle", mja, 0, false);
		tea += Qea(g_toggleIcons[i][5].src, VBb, "mask", mja, 0, false);
		tea += Qea(g_toggleIcons[i][6].src, VBb, "toggleOn", mja, 0, false);
		tea += Qea(g_toggleIcons[i][7].src, VBb, "maskOn", mja, 0, false);
		tea += '</span>';
	}
	return tea;
}
function Yea(p_bShow) {
	var tea = "";
	Mda += 100;
	tea += ' <select ignore="1" onchange="$rw_setSpeedValue(parseInt(this.value));" ' + 'style="vertical-align=top;margin-top:5px;margin-bottom:8px;border: 1px solid;color:#000000;background-color:#f1efe5">';
	if (uba == -3 || uba == SLOW_SPEED) {
		tea += '  <option ignore="1" selected value="' + SLOW_SPEED + '">';
	} else {
		tea += '  <option ignore="1" value="' + SLOW_SPEED + '">';
	}
	tea += '   Slow';
	tea += '  </option>';
	if (uba == -2 || uba == MEDIUM_SPEED) {
		tea += '  <option ignore="1" selected value="' + MEDIUM_SPEED + '">';
	} else {
		tea += '  <option ignore="1" value="' + MEDIUM_SPEED + '">';
	}
	tea += '   Medium';
	tea += '  </option>';
	if (uba == -1 || uba == FAST_SPEED) {
		tea += '  <option ignore="1" selected value="' + FAST_SPEED + '">';
	} else {
		tea += '  <option ignore="1" value="' + FAST_SPEED + '">';
	}
	tea += '   Fast';
	tea += '  </option>';
	tea += ' </select>';
	return tea;
}
function Zea(p_strName, p_strExt, p_bToggleIcon) {
	if (p_strExt != null) {
		if (p_strExt == "toggle") {
			Ida = 2;
		}
		var aea = document.images[p_strName + p_strExt].style;
		aea.visibility = "visible";
		aea.display = "inline";
		if (p_strName == "submit") {
			aea.width = "53px";
		} else {
			aea.width = "33px";
		}
	}
	if (p_strExt != "flat") {
		document.images[p_strName + "flat"].style.visibility = "hidden";
		document.images[p_strName + "flat"].style.display = "none";
		document.images[p_strName + "flat"].style.width = "0px";
	}
	if (p_strExt != "hover") {
		document.images[p_strName + "hover"].style.visibility = "hidden";
		document.images[p_strName + "hover"].style.display = "none";
		document.images[p_strName + "hover"].style.width = "0px";
	}
	if (p_strExt != "toggle") {
		document.images[p_strName + "toggle"].style.visibility = "hidden";
		document.images[p_strName + "toggle"].style.display = "none";
		document.images[p_strName + "toggle"].style.width = "0px";
	}
	if (p_strExt != "mask") {
		document.images[p_strName + "mask"].style.visibility = "hidden";
		document.images[p_strName + "mask"].style.display = "none";
		document.images[p_strName + "mask"].style.width = "0px";
	}
	if (p_bToggleIcon) {
		if (p_strExt != "toggleOn") {
			document.images[p_strName + "toggleOn"].style.visibility = "hidden";
			document.images[p_strName + "toggleOn"].style.display = "none";
			document.images[p_strName + "toggleOn"].style.width = "0px";
		}
		if (p_strExt != "mask") {
			document.images[p_strName + "maskOn"].style.visibility = "hidden";
			document.images[p_strName + "maskOn"].style.display = "none";
			document.images[p_strName + "maskOn"].style.width = "0px";
		}
	}
}
function $rw_barInit() {
	var Lfa = false;
	if (typeof (BYPASS_BROWSER_CHECK) != "undefined"
			&& BYPASS_BROWSER_CHECK == "y") {
		Lfa = true;
	} else {
		Lfa = Nfa();
	}
	if (!Lfa) {
		return;
	}
	Xfa();
	if (typeof (pktTitleId) != "undefined") {
		Zfa();
	}
	if (typeof (eba_annotate_storage_url) == "string") {
		Yfa();
	}
	if (qba == SPANISH) {
		iba = "ScanSoft Paulina_Full_22kHz";
	}
	if (typeof (dtdType) != "undefined") {
		rda = dtdType;
		if (dtdType == "xtran") {
			sda = true;
		}
	}
	nba = parseInt(kba);
	if (nba >= 200 && nba < 300) {
		lba = "none";
		var cea = document.getElementsByTagName("meta");
		var SCb = cea.length;
		var i;
		for (i = 0; i < SCb; i++) {
			var eea = cea[i];
			if (eea.name != null) {
				if (eea.name.toLowerCase() == "assetid" && eea.content != null
						&& eea.content.length > 0) {
					mba = eea.content;
				} else if (eea.name.toLowerCase() == "pcode"
						&& eea.content != null && eea.content.length > 0) {
					lba = eea.content;
				}
			}
		}
		var fea = window.location.search;
		var fta;
		var gta;
		var iea;
		fta = fea.indexOf("id=");
		while (fta > 0) {
			iea = fea.charAt(fta - 1);
			if (iea == "?" || iea == "&") {
				gta = fea.indexOf("&", fta + 3);
				if (gta == -1) {
					mba = fea.substr(fta + 3);
				} else {
					mba = fea.substring(fta + 3, gta);
				}
				fta = -1;
			} else {
				fta = fea.indexOf("id=", fta + 1);
			}
		}
		fta = fea.indexOf("product_id=");
		while (fta > 0) {
			iea = fea.charAt(fta - 1);
			if (iea == "?" || iea == "&") {
				gta = fea.indexOf("&", fta + 11);
				if (gta == -1) {
					lba = fea.substr(fta + 11);
				} else {
					lba = fea.substring(fta + 11, gta);
				}
				fta = -1;
			} else {
				fta = fea.indexOf("product_id=", fta + 1);
			}
		}
	}
	if (nba == 300) {
		lba = "index";
		mba = "1";
		var jea = document.location;
		if (jea != null) {
			var UCb = jea.pathname;
			if (UCb.length > 0) {
				var lea = UCb.lastIndexOf("/");
				if (lea > -1) {
					UCb = UCb.substr(lea + 1);
					lea = UCb.indexOf(".html");
					if (lea > -1) {
						UCb = UCb.substring(0, lea);
						lba = UCb;
					}
				}
			}
		}
	}
	var mea = "http://" + dba + "/";
	var nea = "http://" + eba + "/";
	var oea;
	if (fba != null) {
		oea = "http://" + fba + "/";
	} else {
		oea = null;
	}
	if (cda) {
		var pea = hfa();
		if (!pea) {
			Uca = true;
			if (yba) {
				throw "failure: The embedded speech toolbar cannot be added due to invalid html tag markup in this page.";
			} else {
				Jua("The embedded speech toolbar cannot be added due to invalid html tag markup in this page .\n"
						+ "Try using FireFox or Safari to view this page or contact the page author to notify them of this error.");
				return;
			}
		}
	}
	var qea;
	if (Zba.length > 0) {
		qea = gba + "/v" + Zba;
	} else {
		qea = gba;
	}
	if (qea.length > 0) {
		$g_strFileLoc = mea + qea + "/";
	} else {
		$g_strFileLoc = mea;
	}
	gda = hba;
	try {
		var rea = new String(document.location);
		if (rea.substring(0, 4) == "file") {
			$g_strFileLoc = "";
			gda = "";
		}
	} catch (ignore) {
	}
	if (jba == title_rw) {
		document.writeln("<link href=\"" + $g_strFileLoc
				+ "rwMainRWBar.css\" type=\"text/css\" rel=\"stylesheet\">");
	}
	if (jba == title_ba) {
		document.writeln("<link href=\"" + $g_strFileLoc
				+ "rwMainBABar.css\" type=\"text/css\" rel=\"stylesheet\">");
	}
	if (jba == title_ebooks) {
		document
				.writeln("<link href=\""
						+ $g_strFileLoc
						+ "rwMainEbooksBar.css\" type=\"text/css\" rel=\"stylesheet\">");
	}
	if (jba == title_th) {
		document.writeln("<link href=\"" + $g_strFileLoc
				+ "rwMainTHBar.css\" type=\"text/css\" rel=\"stylesheet\">");
	}
	if (jba == title_portal) {
		document
				.writeln("<link href=\""
						+ $g_strFileLoc
						+ "rwMainPortalBar.css\" type=\"text/css\" rel=\"stylesheet\">");
	}
	$rw_setIconsToLoad(bba);
	var sea = '';
	for ( var i = 0; i < Ada; i++) {
		sea += Sea(i);
	}
	for ( var i = 0; i < zca; i++) {
		sea += Kea(i);
	}
	if ((bba & selectSpeed_icon) == selectSpeed_icon) {
		sea += Yea(true);
	}
	if (zca > 0 && Mda < 110) {
		Mda = 110;
	} else if (zca == 0) {
		Mda = 0;
	}
	var tea = "";
	if (Mda > 0) {
		tea = '<div id="rwDrag" rwTHcomp="1">';
		if (!Wba) {
			tea += ' <div id="rwMainOutline" class="rwToolbarOutline" style="width:' + Mda + 'px;';
			if (wba) {
				tea += 'visibility:hidden;display:none;';
			}
			tea += '">';
			if (jba == title_th) {
				tea += '  <div id="rwDragMe" class="rwToolbarCaption">'
						+ '<a href="http://www.texthelp.com" target="new" style="cursor:hand">'
						+ '<img border="0" ignore align="right" src="'
						+ $g_strFileLoc
						+ 'rwimgs/logo.gif" title="Click here to go to www.texthelp.com" '
						+ 'alt="Click here to go to www.texthelp.com"></a>'
						+ '</div>';
			} else {
				tea += '  <div id="rwDragMe" class="rwToolbarCaption" ></div>';
			}
		} else {
			tea += ' <div id="rwMainNoOutline" style="width:' + Mda + 'px; visible:hidden;display:none;">';
		}
		tea += '  <div class="rwToolbarBar">';
		if (jba != title_th) {
			tea += '</div>';
		}
		tea += sea;
		if (!Wba) {
			tea += '\n</div></div>';
			if (jba == title_th) {
				tea += '</div>';
			}
		} else {
			tea += '\n</div></div>';
		}
	} else {
		tea = '<div id="rwDrag" rwTHcomp="1" visibility="hidden">';
		tea += '\n</div>';
	}
	var uea = '&userName=' + oba + '&userPassword=' + pba;
	if (Cca) {
		uea += "&customerName=pkt";
	}
	tea += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
	tea += 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" ';
	tea += 'width="1" height="1" id="WebToSpeech" align="middle">';
	tea += '  <param name="allowScriptAccess" value="sameDomain" />';
	tea += '  <param name="movie" value="' + gda + 'WebToSpeech' + aba
			+ '.swf" />';
	tea += '  <param name="quality" value="high" />';
	tea += '  <param name="bgcolor" value="#ffffff" />';
	tea += '  <param name="flashVars" value="lessonServerLoc=' + mea
			+ '&speechServerLoc=' + nea + '&speedValue=' + uba + uea;
	if (yba || zba) {
		tea += '&cacheMode=true';
	}
	if (oea != null) {
		tea += '&speechServerBackupLoc=' + oea;
	}
	if (kba != null && lba != null && mba != null) {
		tea += '&custID=' + kba;
		tea += '&bookID=' + lba;
		tea += '&pageID=' + mba;
	}
	tea += '&locale=' + tba + '';
	tea += '&speechName=' + iba + '"/>';
	tea += '  <embed src="' + gda + 'WebToSpeech' + aba
			+ '.swf" quality="high" bgcolor="#ffffff" width="1" height="1"';
	tea += '   name="WebToSpeech" align="middle" allowScriptAccess="sameDomain"';
	tea += '   type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"';
	tea += '   flashVars="lessonServerLoc=' + mea + '&speechServerLoc=' + nea
			+ '&speedValue=' + uba + uea;
	if (yba || zba) {
		tea += '&cacheMode=true';
	}
	if (kba != null && lba != null && mba != null) {
		tea += '&custID=' + kba;
		tea += '&bookID=' + lba;
		tea += '&pageID=' + mba;
	}
	tea += '&locale=' + tba + '';
	tea += '&speechName=' + iba + '">';
	tea += '  </embed>';
	tea += '</object>';
	document.writeln(tea);
	iga(window, 'scroll', nga);
	iga(window, 'resize', nga);
	iga(window, 'scroll', qga);
	iga(window, 'resize', qga);
	iga(window, 'load', Mia);
	iga(window, 'beforeunload', Uia);
	iga(document, 'click', qha);
	iga(document, 'mouseout', Gia);
	iga(document, 'mouseup', Eia);
	iga(document, 'mousemove', Bia);
	iga(document, 'mouseover', rha);
	iga(document, 'mousedown', oha);
	iga(document, 'dragstart', pha);
	iga(document, 'keyup', nha);
	bba = bba | cba;
	if ((bba & dictionary_icon) == dictionary_icon
			|| (bba & factfinder_icon) == factfinder_icon
			|| (bba & translation_icon) == translation_icon) {
		document.writeln("<script type=\"text/javascript\" src=\""
				+ $g_strFileLoc + "obfSearch.js\" ></script>");
	}
	if ((bba & highlightcyan_icon) == highlightcyan_icon
			|| (bba & highlightgreen_icon) == highlightgreen_icon
			|| (bba & highlightmagenta_icon) == highlightmagenta_icon
			|| (bba & highlightyellow_icon) == highlightyellow_icon
			|| (bba & collect_icon) == collect_icon || Dca) {
		document.writeln("<script type=\"text/javascript\" src=\""
				+ $g_strFileLoc + "obfSS.js\" ></script>");
	}
	if ((bba & sticky_icon) == sticky_icon || Dca) {
		document.writeln("<script type=\"text/javascript\" src=\""
				+ $g_strFileLoc + "obfSticky.js\" ></script>");
	}
	if ((bba & pronCreate_icon) == pronCreate_icon
			|| (bba & pronEdit_icon) == pronEdit_icon) {
		document.writeln("<script type=\"text/javascript\" src=\""
				+ $g_strFileLoc + "obfPron.js\" ></script>");
	}
	if (!cda) {
		var vea = document.getElementsByTagName('input');
		for ( var i = 0; i < vea.length; i++) {
			var wea = vea.item(i);
			var Zva = wea.getAttribute("type");
			if (Zva != null && Zva == "text") {
				iga(wea, "mouseup", hga);
			}
		}
	}
	if (Xca) {
		var yea = document.createElement("div");
		yea.id = "startbubble";
		yea.style.position = "absolute";
		yea.style.display = "none";
		if (cda) {
			yea.style.cursor = "hand";
		} else {
			yea.style.cursor = "pointer";
		}
		iga(yea, 'click', Gfa);
		var zea = document.createElement("img");
		zea.setAttribute("src", $g_strFileLoc + "rwimgs/start_speak_popup.gif");
		yea.appendChild(zea);
		document.body.appendChild(yea);
		var Afa = document.createElement("div");
		Afa.id = "stopbubble";
		Afa.style.position = "absolute";
		Afa.style.display = "none";
		if (cda) {
			Afa.style.cursor = "hand";
		} else {
			Afa.style.cursor = "pointer";
		}
		iga(Afa, 'click', Hfa);
		var Bfa = document.createElement("img");
		Bfa.setAttribute("src", $g_strFileLoc + "rwimgs/stop_speak_popup.gif");
		Afa.appendChild(Bfa);
		document.body.appendChild(Afa);
	}
}
var Cfa = null;
var Dfa;
var Efa;
function Ffa(x, y, p_hoverTarget) {
	if (Xca) {
		x = x - 30;
		if (x < 0) {
			x = 0;
		}
		y = y - 16;
		if (y < 0) {
			y = 0;
		}
		var scrollLeft = rw_getScreenOffsetLeft();
		var scrollTop = rw_getScreenOffsetTop();
		Dfa = x + scrollLeft;
		Efa = y + scrollTop;
		document.getElementById("startbubble").style.display = "inline";
		document.getElementById("startbubble").style.left = Dfa + 'px';
		document.getElementById("startbubble").style.top = Efa + 'px';
		Cfa = p_hoverTarget;
	}
}
function Gfa() {
	if (Cfa != null) {
		$rw_event_stop();
		Ifa(Dfa, Efa);
		rw_speakHoverTarget(Cfa);
	}
}
function Hfa() {
	$rw_event_stop();
}
function Ifa(x, y) {
	if (Xca) {
		document.getElementById("stopbubble").style.display = "inline";
		document.getElementById("stopbubble").style.left = x + 'px';
		document.getElementById("stopbubble").style.top = y + 'px';
	}
}
function Jfa() {
	if (Xca) {
		document.getElementById("startbubble").style.display = "none";
	}
}
function Kfa() {
	if (Xca) {
		document.getElementById("stopbubble").style.display = "none";
	}
}
function Nfa() {
	var Lfa = false;
	var Mfa = navigator.userAgent;
	if (Mfa.indexOf("MSIE 6") > -1) {
		Lfa = true;
	} else if (Mfa.indexOf("MSIE 7") > -1) {
		Lfa = true;
	} else if (Mfa.indexOf("Safari") > -1) {
		Lfa = true;
		var Dka = navigator.appVersion;
		var Eka = Dka.lastIndexOf("/");
		Dka = Dka.substring(Eka + 1);
		try {
			var Fka = parseFloat(Dka);
			if (Fka < 300) {
				Jua("You are using an older version of Safari that is not "
						+ "support by the embedded bar in this page.  "
						+ "The bar may not work at all or work erratically, "
						+ "it is recommended that you upgrade to the latest version of Safari.");
			}
		} catch (err) {
		}
	} else if (Mfa.indexOf("Firefox") > -1) {
		Lfa = true;
		var Fga = Mfa.indexOf("Firefox") + 8;
		if (Fga < Mfa.length) {
			var bja = Mfa.substr(Fga);
			var Qia = bja.substr(0, bja.indexOf("."));
			try {
				var Ufa = parseInt(Qia);
				if (Ufa < 2) {
					if (Ufa == 1) {
						bja = bja.substr(Qia.length + 1);
						var Ria = bja.substr(0, bja.indexOf("."));
						Ufa = parseInt(Ria);
					} else {
						Ufa = 0;
					}
					if (Ufa < 5) {
						Jua("You are using an older version of Firefox that is not "
								+ "support by the embedded bar in this page.  "
								+ "The bar may not work at all or work erratically, "
								+ "it is recommended that you upgrade to the latest version of Firefox.");
					}
				}
			} catch (err) {
			}
		}
	} else {
		var Wfa = navigator.platform;
		if (Wfa.indexOf("mac") > -1) {
			Jua("The browser you are using is not supported by the embedded bar that should be displayed in this page.  "
					+ "To view this page with the bar displayed please use Firefox (version 2.0.0.1 or later).");
		} else {
			Jua("The browser you are using is not supported by the embedded bar that should be displayed in this page.  "
					+ "To view this page with the bar displayed please use either Firefox (version 2.0.0.1 or later) "
					+ "or Internet Explorer (version 6 or 7).");
		}
	}
	return Lfa;
}
function Xfa() {
	if (typeof (eba_allow_alerts_flag) == "boolean") {
		Yba = eba_allow_alerts_flag;
	}
	if (typeof (eba_no_title) == "boolean") {
		Wba = eba_no_title;
		jba = 0;
	}
	if (typeof (eba_noTitleFlag) == "boolean") {
		Wba = eba_noTitleFlag;
		jba = 0;
	}
	if (typeof (eba_hidden_bar) == "boolean") {
		wba = eba_hidden_bar;
	}
	if (typeof (eba_continuous_reading) == "boolean") {
		Vca = eba_continuous_reading;
	}
	if (typeof (eba_ignore_buttons) == "boolean") {
		xba = eba_ignore_buttons;
	}
	if (typeof (eba_speechCacheGenerateFlag) == "boolean") {
		yba = eba_speechCacheGenerateFlag;
	}
	if (typeof (eba_speechCacheFlag) == "boolean") {
		zba = eba_speechCacheFlag;
	}
	if (typeof (eba_autoCachePage) == "boolean") {
		Aca = eba_autoCachePage;
	}
	if (typeof (eba_voice_from_lang_flag) == "boolean") {
		rba = eba_voice_from_lang_flag;
	}
	if (typeof (eba_initial_clicktospeak) == "boolean") {
		if (eba_initial_clicktospeak) {
			g_bHover = true;
			Iha(true);
		}
	}
	if (typeof (eba_popupSpeechFlag) == "boolean") {
		Xca = eba_popupSpeechFlag;
	}
	if (typeof (eba_popupFreezeOnShiftFlag) == "boolean") {
		Yca = eba_popupFreezeOnShiftFlag;
	}
	if (typeof (eba_on_click) == "boolean") {
		Tba = eba_on_click;
	}
	if (typeof (eba_icons) == "number") {
		bba = eba_icons;
	}
	if (typeof (eba_no_display_icons) == "number") {
		cba = eba_no_display_icons;
	}
	if (typeof (eba_title) == "number") {
		jba = eba_title;
	}
	if (typeof (eba_language) == "number") {
		qba = eba_language;
		if (qba == 3) {
			qba = 2;
		} else if (qba > 3 || qba < 0) {
			qba = 0;
		}
		if (rba) {
			if (eba_language >= 0 && eba_language < uaa.length) {
				iba = uaa[eba_language];
			}
		}
	}
	if (typeof (eba_speed_value) == "number") {
		uba = eba_speed_value;
	}
	if (typeof (eba_speedValue) == "number") {
		uba = eba_speedValue;
	}
	if (typeof (eba_speed_offset) == "number") {
		uba += eba_speed_offset;
	}
	if (typeof (eba_server_version) == "string") {
		Zba = eba_server_version;
	}
	if (typeof (eba_serverVersion) == "string") {
		Zba = eba_serverVersion;
	}
	if (typeof (eba_client_version) == "string") {
		aba = eba_client_version;
	}
	if (typeof (eba_clientVersion) == "string") {
		aba = eba_clientVersion;
	}
	if (typeof (eba_server) == "string") {
		dba = eba_server;
	}
	if (typeof (eba_speech_server) == "string") {
		eba = eba_speech_server;
	}
	if (typeof (eba_speechServer) == "string") {
		eba = eba_speechServer;
	}
	if (typeof (eba_speech_server_backup) == "string") {
		fba = eba_speech_server_backup;
	}
	if (typeof (eba_speechServerBackup) == "string") {
		fba = eba_speechServerBackup;
	}
	if (typeof (eba_folder) == "string") {
		gba = eba_folder;
	}
	if (typeof (eba_client_folder) == "string") {
		hba = eba_client_folder;
	}
	if (typeof (eba_clientFolder) == "string") {
		hba = eba_clientFolder;
	}
	if (typeof (eba_voice) == "string") {
		iba = eba_voice;
	}
	if (typeof (eba_custId) == "string") {
		kba = eba_custId;
	}
	if (typeof (eba_cust_id) == "string") {
		kba = eba_cust_id;
	}
	if (typeof (eba_bookId) == "string") {
		lba = eba_bookId;
	}
	if (typeof (eba_book_id) == "string") {
		lba = eba_book_id;
	}
	if (typeof (eba_pageId) == "string") {
		mba = eba_pageId;
	}
	if (typeof (eba_page_id) == "string") {
		mba = eba_page_id;
	}
	if (typeof (eba_loginName) == "string") {
		oba = eba_loginName;
	}
	if (typeof (eba_login_name) == "string") {
		oba = eba_login_name;
	}
	if ((typeof (eba_loginPassword) == "string")
			|| (typeof (eba_login_password) == "string")) {
		if (typeof (eba_loginPassword) == "string") {
			pba = eba_loginPassword;
		}
		if (typeof (eba_login_password) == "string") {
			pba = eba_login_password;
		}
	} else {
		pba = oba;
	}
	if (typeof (eba_locale) == "string") {
		tba = eba_locale;
	}
}
function Yfa() {
	if (lba == null) {
		Jua("Persistent annotations is enabled but no book id was provided, "
				+ "this feature will not work in this page.");
		return;
	}
	if (mba == null) {
		Jua("Persistent annotations is enabled but no page id was provided, "
				+ "this feature will not work in this page.");
		return;
	}
	Dca = true;
	if (typeof (eba_annotate_note_editor_id) == "string") {
		Eca = eba_annotate_note_editor_id;
	}
	if (typeof (eba_annotate_highlight_editor_id) == "string") {
		Fca = eba_annotate_highlight_editor_id;
	}
	if (typeof (eba_annotate_note_reader_id) == "string") {
		Gca = eba_annotate_note_reader_id;
	}
	if (typeof (eba_annotate_highlight_reader_id) == "string") {
		Hca = eba_annotate_highlight_reader_id;
	}
	if (typeof (eba_annotate_persist_notes) == "boolean" && Eca != "*") {
		Ica = eba_annotate_persist_notes;
	}
	if (typeof (eba_annotate_persist_highlights) == "boolean" && Fca != "*") {
		Jca = eba_annotate_persist_highlights;
	}
	if (typeof (eba_annotate_storage_url) == "string") {
		Kca = eba_annotate_storage_url;
		if (typeof (eba_server) == "undefined") {
			dba = Kca;
		}
	}
	if (typeof (eba_annotate_confirm_delete_note) == 'boolean') {
		Mca = eba_annotate_confirm_delete_note;
	}
	if (Ica) {
		bba += sticky_icon;
	}
}
function Zfa() {
	Cca = true;
	Dca = true;
	if (typeof (pktIsTeacher) == "boolean") {
		Ica = pktIsTeacher;
	}
	if (typeof (pktTitleId) == "string") {
		lba = pktTitleId;
	}
	if (typeof (pktPageId) == "string") {
		mba = pktPageId;
	}
	if (typeof (pktStudentId) == "string") {
		if (!Ica) {
			Jca = true;
		}
		Fca = pktStudentId;
		Gca = pktStudentId;
	}
	if (typeof (pktTeacherId) == "string") {
		Eca = pktTeacherId;
		Hca = pktTeacherId;
	}
	if (typeof (pktStorageUrl) == "string") {
		Kca = pktStorageUrl;
		if (typeof (eba_server) == "undefined") {
			dba = Kca;
		}
	}
	if (typeof (pktSpeechServerUrl) == "string") {
		eba = pktSpeechServerUrl;
	}
	if (typeof (pktVoice) == "string") {
		iba = pktVoice;
	}
	if (typeof (pktCustCode) == 'string') {
		Lca = pktCustCode;
	}
	if (typeof (pktConfirmOnDelete) == 'boolean') {
		Mca = pktConfirmOnDelete;
	}
	if (Ica) {
		bba += sticky_icon;
	}
}
function hfa() {
	if (top.window.frames.length > 0) {
		var i = 0;
		var SCb = top.window.frames.length;
		for (i = 0; i < SCb; i++) {
			var rua = top.window.frames[i];
			
			var qfa = rua.document;
			if(qfa.body == null) return false;
			var b = ifa(qfa.body);
			if (!b) {
				return false;
			}
		}
	}
	if (document.body != null) {
		return ifa(document.body);
	} else {
		return true;
	}
}
function ifa(p_body) {
	
	try 
	{
		var jqa = p_body.firstChild;
		var bod = jqa.ownerDocument.body;
	}
	catch(er)
	{
		return false;
	}
	
	try {
		while (jqa != null && jqa != bod) {
			jqa = Wma(jqa);
		}
	} catch (er) {
		return false;
	}
	return true;
}
var efa = 0;
var ffa = false;
var gfa = null;
function rw_getWebToSpeech() {
	if (gfa != null) {
		return gfa;
	} else {
		var flash = null;
		try {
			if (dda) {
				flash = window.document.WebToSpeech;
			} else {
				if (window.document.WebToSpeech) {
					flash = window.document.WebToSpeech;
				} else {
					flash = window.WebToSpeech;
				}
			}
			if (flash != null) {
				flash.getVersion();
				gfa = flash;
			}
		} catch (err) {
			gfa = null;
		}
		if (flash == null && !ffa) {
			if (yba) {
				throw "A necessary flash component failed to load.  This page will not work as intended.";
			} else {
				Jua("A necessary flash component failed to load.  This page will not work as intended.");
			}
			ffa = true;
		}
		return flash;
	}
}
function $rw_versionCheck() {
	try {
		var flash = rw_getWebToSpeech();
		var mfa = flash.getVersion();
		var nfa = parseFloat(mfa);
		if (typeof (eba_no_flash) == "boolean" && eba_no_flash == true) {
			xca = true;
		} else {
			if (nfa < 1.05 || nfa == NaN) {
				xca = false;
			} else {
				xca = true;
			}
		}
	} catch (err) {
		xca = false;
		efa++;
		if (efa < 50) {
			setTimeout("$rw_versionCheck();", 100);
		}
	}
}
function $rw_pageSetup() {
	$rw_tagSentences();
	if (top.window.frames.length > 0) {
		var i = 0;
		var SCb = top.window.frames.length;
		for (i = 0; i < SCb; i++) {
			var rua = top.window.frames[i];
			var qfa = rua.document;
			iga(qfa, 'mouseout', Gia);
			iga(qfa, 'mouseup', Eia);
			iga(qfa, 'click', qha);
			iga(qfa, 'mousemove', Bia);
			iga(qfa, 'mouseover', rha);
			iga(qfa, 'mousedown', oha);
			iga(qfa, 'dragstart', pha);
			iga(qfa, 'keyup', nha);
		}
	}
	nda = document.getElementById('SWA1');
	if (nda != null) {
		iga(nda, 'mouseup', lga);
	}
	Lha(lda);
	if (document.all) {
		var oo = document.all['rwDrag'];
		if (oo == null) {
			return;
		}
		dha = document.all['rwDrag'].style;
	} else {
		dha = document.getElementById('rwDrag').style;
	}
	dha.display = "inline";
	$rw_versionCheck();
}
var rfa = "[\\x21\\x2E\\x3F\\x3A]";
var sfa = /[\n\r\t ]{2,}/g;
function $rw_tagSentences() {
	var Iza = 0;
	var ufa = false;
	if (document && document.body) {
		var vfa = false;
		if (nba >= 200 && nba < 300) {
			vfa = true;
		}
		Tca = vfa;
		var Fwa = document.body;
		while (Fwa != null) {
			if (Fwa.nodeType == 3) {
				if (Fwa.parentNode.tagName.toLowerCase() == "textarea") {
					Fwa = Ima(Fwa, false, null);
					continue;
				}
				var txt = Fwa.nodeValue;
				var xfa = txt.trimTH();
				var Uga = xfa.length > 0;
				if (!Uga) {
					if (Dca) {
						if (ufa) {
							Fwa.nodeValue = " ";
							ufa = false;
							Fwa = Ima(Fwa, false, null);
						} else {
							var tmp = Fwa;
							Fwa = Ima(Fwa, false, null);
							tmp.parentNode.removeChild(tmp);
						}
					} else {
						Fwa = Ima(Fwa, false, null);
					}
				} else {
					if (Dca) {
						if (xfa.length < txt.length) {
							var Nxa = false;
							xfa = txt.trimStartTH();
							if ((txt.length - xfa.length) > 0) {
								if (ufa) {
									txt = " " + xfa;
								} else {
									txt = xfa;
								}
								Nxa = true;
							}
							xfa = txt.trimEndTH();
							if ((txt.length - xfa.length) > 1) {
								txt = xfa + " ";
								ufa = false;
								Nxa = true;
							}
							xfa = txt.replace(sfa, " ");
							if (xfa.length < txt.length) {
								txt = xfa;
								Nxa = true;
							}
							if (Nxa) {
								Fwa.nodeValue = txt;
							}
						}
					}
					var nCb;
					nCb = txt.search(rfa);
					var Bga = Fwa;
					if (nCb > -1 && nCb < (txt.length - 1)) {
						var Cga = true;
						while (true) {
							var Yia = dga(txt, nCb);
							if (Yia) {
								break;
							} else {
								var Ega = txt.substring(nCb + 1);
								var Fga = Ega.search(rfa);
								if (Fga > -1) {
									nCb = nCb + 1 + Fga;
								} else {
									Cga = false;
									break;
								}
							}
						}
						if (Cga) {
							var Eoa = txt.substring(0, nCb + 1);
							var Foa = txt.substring(nCb + 1);
							var span = document.createElement("span");
							span.setAttribute(daa, "1");
							var Ioa = document.createTextNode(Eoa);
							var Joa = document.createTextNode(Foa);
							var par = Fwa.parentNode;
							par.insertBefore(Joa, Fwa);
							par.insertBefore(span, Joa);
							span.appendChild(Ioa);
							par.removeChild(Fwa);
							Fwa = Joa;
							Bga = Ioa;
						} else {
							if (Fwa.previousSibling != null
									|| Fwa.nextSibling != null) {
								var span = document.createElement("span");
								span.setAttribute(daa, "1");
								var Ioa = document.createTextNode(txt);
								var par = Fwa.parentNode;
								par.insertBefore(span, Fwa);
								span.appendChild(Ioa);
								par.removeChild(Fwa);
								Fwa = Ioa;
							}
							Bga = Fwa;
							Fwa = Ima(Fwa, false, null);
						}
					} else {
						if (Fwa.previousSibling != null
								|| Fwa.nextSibling != null) {
							var span = document.createElement("span");
							span.setAttribute(daa, "1");
							var Ioa = document.createTextNode(txt);
							var par = Fwa.parentNode;
							par.insertBefore(span, Fwa);
							span.appendChild(Ioa);
							par.removeChild(Fwa);
							Fwa = Ioa;
						}
						Bga = Fwa;
						Fwa = Ima(Fwa, false, null);
					}
					if (Dca) {
						var Pga = Bga.nodeValue;
						var Qga = Bga.nodeValue.length;
						if (Qga > 0 && Pga.charCodeAt(Qga - 1) == 32) {
							ufa = false;
						} else {
							ufa = true;
						}
					}
				}
			} else if (Fwa.nodeType == 1) {
				if (Dca) {
					if (!Moa(Fwa)) {
						if (Soa(Fwa)) {
							ufa = false;
						}
					} else if (Fwa.tagName.toLowerCase() == "img") {
						ufa = true;
					}
				}
				if (vfa) {
					if (Fwa.tagName.toLowerCase() == "img") {
						var eoa = Fwa.getAttribute("title");
						Fwa.setAttribute("msg", eoa);
					}
				}
				var Yga = Fwa.getAttribute(baa);
				var Zga = Fwa.getAttribute(aaa);
				if (Fwa.tagName.toLowerCase() == "pre"
						|| (Yga != null && Yga.length > 0)
						|| (Zga != null && Zga.length > 0)) {
					Fwa = Mma(Fwa, false, null);
				} else {
					Fwa = Ima(Fwa, false, null);
				}
			} else {
				Fwa = Ima(Fwa, false, null);
			}
		}
		if (Dca) {
			Fwa = document.body;
			while (Fwa != null) {
				if (Fwa.nodeType == 3) {
					var Uga = Fwa.nodeValue.trimTH().length > 0;
					if (Uga) {
						var Vga = Fwa.parentNode;
						var Wga = Vga.getAttribute("id");
						if (Wga == null || Wga.length == 0) {
							Vga.id = "rwTHnoteMarker" + tda;
							++tda;
						}
					}
					Fwa = Ima(Fwa, false, null);
				} else if (Fwa.nodeType == 1) {
					if (UBb(Fwa)) {
						var Xga = Fwa.getAttribute("id");
						if (Xga == null || Xga.length == 0) {
							Fwa.id = "rwTHnoteMarker" + tda;
							++tda;
						}
					}
					var Yga = Fwa.getAttribute(baa);
					var Zga = Fwa.getAttribute(aaa);
					if (Fwa.tagName.toLowerCase() == "pre"
							|| (Yga != null && Yga.length > 0)
							|| (Zga != null && Zga.length > 0)) {
						Fwa = Mma(Fwa, false, null);
					} else {
						Fwa = Ima(Fwa, false, null);
					}
				} else {
					Fwa = Ima(Fwa, false, null);
				}
			}
		}
	}
	Sca = true;
}
function dga(p_txt, p_nPos) {
	var bFS = true;
	var SCb = p_txt.length;
	if (SCb > p_nPos + 1) {
		var bga = p_txt.charCodeAt(p_nPos + 1);
		if ((bga > 47 && bga < 58) || (bga > 63 && bga < 91)
				|| (bga > 96 && bga < 123)) {
			bFS = false;
		}
	}
	if (bFS) {
		if (p_nPos > 1) {
			var cga = p_txt.substring(p_nPos - 2, p_nPos);
			if (cga.charAt(0) == ' ' && cga.charCodeAt(1) > 63
					&& cga.charCodeAt(1) < 91) {
				bFS = false;
			} else {
				if (cga == "Dr" || cga == "Mr" || cga == "Ms" || cga == "Av"
						|| cga == "St" || cga == "eg") {
					bFS = false;
				} else if (p_nPos > 2) {
					var ega = p_txt.substring(p_nPos - 3, p_nPos);
					if (ega == "Mrs" || ega == "etc" || ega == "i.e"
							|| ega == "P.O" || ega == "PhD") {
						bFS = false;
					} else if (p_nPos > 3) {
						var fga = p_txt.substring(p_nPos - 4, p_nPos);
						if (fga == "Ph.D" || fga == "PhD") {
							bFS = false;
						}
					}
				}
			}
		}
	}
	return bFS;
}
var gga = null;
function hga(event) {
	gga = event.currentTarget;
}
function iga(obj, eventType, func) {
	if (obj.addEventListener) {
		obj.addEventListener(eventType, func, false);
		return true;
	} else if (obj.attachEvent) {
		return obj.attachEvent("on" + eventType, func);
	} else {
		return false;
	}
}
var nc = 0;
function lga() {
	if (!lda) {
		var flash = Zra(jda);
		flash.gotFocus();
		Lha(true);
	}
	mda = true;
}
var kga = false;
function nga() {
	if (Rba) {
		var i = 0;
		var nW = ((window.innerWidth) ? window.innerWidth
				: document.documentElement.offsetWidth) - 50;
		var mga = nW + "px";
		for (i = 1; i < 11; i++) {
			var fwa = document.getElementById("placeholderSWA" + i);
			if (fwa != null) {
				fwa.style.width = mga;
			}
		}
	}
	var dha;
	if (document.all) {
		var oo = document.all['rwDrag'];
		if (oo == null) {
			return;
		}
		dha = document.all['rwDrag'].style;
	} else {
		dha = document.getElementById('rwDrag').style;
	}
	if (dha == null) {
		return;
	}
	var x;
	var y;
	if (typeof (eba_override_x) != 'undefined'
			&& typeof (eba_override_y) != 'undefined') {
		x = eba_override_x;
		y = eba_override_y;
	} else {
		var wd = rw_getDisplayWidth();
		var ht = rw_getDisplayHeight();
		if (Wba) {
			Kda = 1;
			Lda = 0;
			Gda = 0;
		}
		x = wd * Kda;
		y = ht * Lda;
		if ((x + Mda + Gda) > rw_getDisplayWidthAdjusted()) {
			x = rw_getDisplayWidthAdjusted() - Mda - Gda;
		}
		if (x < Gda) {
			x = Gda;
		}
		if ((y + Nda + Gda) > rw_getDisplayHeightAdjusted()) {
			y = rw_getDisplayHeightAdjusted() - Nda - Gda;
		}
		if (y < Gda) {
			y = Gda;
		}
		x = rw_getScreenOffsetLeft() + x;
		y = rw_getScreenOffsetTop() + y;
		if (Wba) {
			y = 0;
		}
	}
	dha.left = x + 'px';
	dha.top = y + 'px';
	if (wba) {
		return;
	}
	dha.visibility = 'visible';
	dha.display = "inline";
	if (!kga) {
		var tmp = document.getElementById("rwMainOutline");
		if (tmp != null) {
			tmp.style.visibility = 'visible';
			tmp.style.display = "block";
		}
		tmp = document.getElementById("rwMainNoOutline");
		if (tmp != null) {
			tmp.style.visibility = 'visible';
			tmp.style.display = "block";
		}
	}
}
function qga() {
	uga(0);
	uga(1);
	uga(2);
	uga(3);
	uga(4);
	uga(5);
	uga(6);
	uga(7);
}
function uga(p_nType) {
	var rga;
	var dha;
	var VBb;
	switch (p_nType) {
	case 0:
		VBb = "rwDisplay";
		break;
	case 1:
		VBb = "rwTrans";
		break;
	case 2:
		VBb = "rwFF";
		break;
	case 3:
		VBb = "rwDict";
		break;
	case 4:
		VBb = "rwCollect";
		break;
	case 5:
		VBb = "rwSticky";
		break;
	case 6:
		VBb = "rwPronCreate";
		break;
	case 7:
		VBb = "rwPronEdit";
		break;
	default:
		VBb = "rwDisplay";
	}
	if (document.all) {
		rga = document.all[VBb];
	} else {
		rga = document.getElementById(VBb);
	}
	if (typeof (rga) == 'undefined' || rga == null) {
		return;
	}
	dha = rga.style;
	if (dha == null) {
		return;
	}
	if (Sda[p_nType]) {
		dha.display = "block";
		if (dha.visibility == 'visible') {
			var vsa = eha(VBb);
			if (vsa != null) {
				var wga = parseInt(vsa.offsetHeight);
				if (!isNaN(wga)) {
					Rda[p_nType] = wga - 4;
				}
			}
		}
		var width = rw_getDocumentDisplayWidth();
		var height = rw_getDocumentDisplayHeight();
		var x = width * Oda[p_nType];
		var y = height * Pda[p_nType];
		if ((x + Qda[p_nType] + Gda) > rw_getDocumentDisplayWidthAdjusted()) {
			x = rw_getDocumentDisplayWidthAdjusted() - Qda[p_nType] - Gda;
		}
		if (x < Gda) {
			x = Gda;
		}
		if ((y + Rda[p_nType] + Gda) > rw_getDocumentDisplayHeightAdjusted()) {
			y = rw_getDocumentDisplayHeightAdjusted() - Rda[p_nType] - Gda;
		}
		if (y < Gda) {
			y = Gda;
		}
		x = rw_getScreenOffsetLeft() + x;
		y = rw_getScreenOffsetTop() + y;
		dha.left = x + 'px';
		dha.top = y + 'px';
		dha.visibility = 'visible';
	} else {
		if (eda) {
			dha.display = "none";
		}
		dha.visibility = 'hidden';
	}
}
function xga(x, y) {
	Kda = x / rw_getDocumentDisplayWidth();
	Lda = y / rw_getDocumentDisplayHeight();
}
function yga(p_nType, x, y) {
	Oda[p_nType] = x / rw_getDocumentDisplayWidth();
	Pda[p_nType] = y / rw_getDocumentDisplayHeight();
}
function zga(ev) {
	if (ev.pageX) {
		if (sda) {
			return {
				x :(ev.pageX - document.documentElement.scrollLeft),
				y :(ev.pageY - document.documentElement.scrollTop)
			};
		} else {
			return {
				x :(ev.pageX - document.body.scrollLeft),
				y :(ev.pageY - document.body.scrollTop)
			};
		}
	} else {
		return {
			x :ev.clientX,
			y :ev.clientY
		};
	}
}
function Bha(p_element) {
	var left = 0;
	var top = 0;
	if (p_element.nodeType == 3) {
		p_element = p_element.parentNode;
	}
	while (p_element.offsetParent) {
		left += p_element.offsetLeft
				+ (p_element.currentStyle ? (parseInt(p_element.currentStyle.borderLeftWidth))
						.NaN0()
						: 0);
		top += p_element.offsetTop
				+ (p_element.currentStyle ? (parseInt(p_element.currentStyle.borderTopWidth))
						.NaN0()
						: 0);
		p_element = p_element.offsetParent;
	}
	left += p_element.offsetLeft
			+ (p_element.currentStyle ? (parseInt(p_element.currentStyle.borderLeftWidth))
					.NaN0()
					: 0);
	top += p_element.offsetTop
			+ (p_element.currentStyle ? (parseInt(p_element.currentStyle.borderTopWidth))
					.NaN0()
					: 0);
	left -= rw_getScreenOffsetLeft();
	top -= rw_getScreenOffsetTop();
	return {
		x :left,
		y :top
	};
}
var Cha = false;
var g_bSpeechModeFlag = false;
function $rw_isSpeaking() {
	return Cha;
}
var ICONS_TO_DISABLE = "funplay play cyan magenta yellow green clear collect trans ffinder dict ";
var Fha = "cyan magenta yellow green clear collect";
var Gha = "spell homophone pred";
function Iha(p_bState) {
	if (g_bHover && Tba) {
		p_bState = true;
	}
	if (g_bSpeechModeFlag == p_bState) {
		return;
	}
	try {
		for ( var i = 0; i < zca; i++) {
			var VBb = g_icons[i][0];
			if (ICONS_TO_DISABLE.indexOf(VBb) > -1) {
				if (p_bState) {
					if (dda) {
						document.images[g_icons[i][0]].src = g_icons[i][5].src;
					} else {
						Zea(g_icons[i][0], "mask", false);
					}
				} else {
					if (dda) {
						document.images[g_icons[i][0]].src = g_icons[i][1].src;
					} else {
						Zea(g_icons[i][0], "flat", false);
					}
				}
			}
		}
		g_bSpeechModeFlag = p_bState;
	} catch (err) {
	}
}
function Jha(p_bState) {
	Cha = p_bState;
}
function Lha(p_bState) {
	lda = p_bState;
	try {
		for ( var i = 0; i < zca; i++) {
			var VBb = g_icons[i][0];
			if (Fha.indexOf(VBb) > -1) {
				if (p_bState) {
					if (dda) {
						document.images[g_icons[i][0]].src = g_icons[i][5].src;
					} else {
						Zea(g_icons[i][0], "mask", false);
					}
				} else {
					if (dda) {
						document.images[g_icons[i][0]].src = g_icons[i][1].src;
					} else {
						Zea(g_icons[i][0], "flat", false);
					}
				}
			}
		}
		for ( var i = 0; i < Ada; i++) {
			var VBb = g_toggleIcons[i][0];
			if (Gha.indexOf(VBb) > -1) {
				if (p_bState) {
					var flash = Zra(jda);
					if (flash != null) {
						var kha = flash.getSpelling();
						var lha = flash.getHomophone();
						var mha = flash.getPrediction();
						if (VBb == "spell") {
							g_toggleIcons[i][8] = kha;
							if (kha) {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
								} else {
									Zea(g_toggleIcons[i][0], "toggleOn", true);
								}
							} else {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Aea].src;
								} else {
									Zea(g_toggleIcons[i][0], "flat", true);
								}
							}
						} else if (VBb == "homophone") {
							g_toggleIcons[i][8] = lha;
							if (lha) {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
								} else {
									Zea(g_toggleIcons[i][0], "toggleOn", true);
								}
							} else {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Aea].src;
								} else {
									Zea(g_toggleIcons[i][0], "flat", true);
								}
							}
						} else if (VBb == "pred") {
							g_toggleIcons[i][8] = mha;
							if (mha) {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
								} else {
									Zea(g_toggleIcons[i][0], "toggleOn", true);
								}
							} else {
								if (dda) {
									document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Aea].src;
								} else {
									Zea(g_toggleIcons[i][0], "flat", true);
								}
							}
						} else {
							if (dda) {
								document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Aea].src;
							} else {
								Zea(g_toggleIcons[i][0], "flat", true);
							}
						}
					} else {
						if (dda) {
							document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Aea].src;
						} else {
							Zea(g_toggleIcons[i][0], "flat", true);
						}
					}
				} else {
					if (dda) {
						document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Dea].src;
					} else {
						Zea(g_toggleIcons[i][0], "mask", true);
					}
				}
			}
		}
	} catch (err) {
	}
}
function $rw_divOver(p_nType) {
	var VBb;
	switch (p_nType) {
	case Uda:
		VBb = "displayImg";
		break;
	case Vda:
		VBb = "transImg";
		break;
	case Wda:
		VBb = "FFImg";
		break;
	case Xda:
		VBb = "dictImg";
		break;
	case Yda:
		VBb = "collectImg";
		break;
	case ada:
		VBb = "pronCreateImg";
		break;
	case bda:
		VBb = "pronEditImg";
		break;
	default:
		VBb = "displayImg";
	}
	if (document.images[VBb] != null) {
		document.images[VBb].src = $g_strFileLoc + "rwimgs/thepressedx.bmp";
	}
}
function $rw_divOut(p_nType) {
	var VBb;
	switch (p_nType) {
	case Uda:
		VBb = "displayImg";
		break;
	case Vda:
		VBb = "transImg";
		break;
	case Wda:
		VBb = "FFImg";
		break;
	case Xda:
		VBb = "dictImg";
		break;
	case Yda:
		VBb = "collectImg";
		break;
	case ada:
		VBb = "pronCreateImg";
		break;
	case bda:
		VBb = "pronEditImg";
		break;
	default:
		VBb = "displayImg";
	}
	if (document.images[VBb] != null) {
		document.images[VBb].src = $g_strFileLoc + "rwimgs/thex.bmp";
	}
}
function $rw_divPress(p_nType) {
	$rw_event_stop();
	Yha(false, p_nType);
}
function Vha(p_nType, p_strText) {
	var dha;
	var VBb;
	switch (p_nType) {
	case Uda:
		VBb = "rwpopupdisplay";
		break;
	case Vda:
		VBb = "rwpopuptrans";
		break;
	case Wda:
		VBb = "rwpopupff";
		break;
	case Xda:
		VBb = "rwpopupdict";
		break;
	case Yda:
		VBb = "rwpopupcollect";
		break;
	case ada:
		VBb = "rwpopupproncreate";
		break;
	case bda:
		VBb = "rwpopuppronedit";
		break;
	default:
		VBb = "rwpopupdisplay";
	}
	if (document.all) {
		var oo = document.all[VBb];
		if (oo == null) {
			return;
		}
		dha = document.all[VBb];
	} else {
		dha = document.getElementById(VBb);
	}
	if (dha == null) {
		return;
	}
	dha.innerHTML = p_strText;
}
function Yha(p_bShow, p_nType) {
	var dha;
	Sda[p_nType] = p_bShow;
	var VBb;
	switch (p_nType) {
	case Uda:
		VBb = "rwDisplay";
		break;
	case Vda:
		VBb = "rwTrans";
		break;
	case Wda:
		VBb = "rwFF";
		break;
	case Xda:
		VBb = "rwDict";
		break;
	case Yda:
		VBb = "rwCollect";
		break;
	case Zda:
		VBb = "rwSticky";
		break;
	case ada:
		VBb = "rwPronCreate";
		break;
	case bda:
		VBb = "rwPronEdit";
		break;
	default:
		VBb = "rwDisplay";
	}
	var vsa = eha(VBb);
	if (vsa != null) {
		dha = vsa.style;
		if (dha == null) {
			return;
		}
		if (p_bShow) {
			bha();
			dha.visibility = 'visible';
			dha.display = 'block';
			dha.zIndex = 501;
		} else {
			dha.visibility = 'hidden';
			if (eda) {
				dha.display = "none";
			}
			Vha(p_nType, "");
		}
	}
	qga();
}
function bha() {
	var VBb;
	VBb = "rwDisplay";
	var vsa = eha(VBb);
	var dha;
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
	VBb = "rwTrans";
	vsa = eha(VBb);
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
	VBb = "rwFF";
	vsa = eha(VBb);
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
	VBb = "rwDict";
	vsa = eha(VBb);
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
	VBb = "rwCollect";
	vsa = eha(VBb);
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
	VBb = "rwSticky";
	vsa = eha(VBb);
	if (vsa != null && vsa.style) {
		dha = vsa.style;
		dha.zIndex = 500;
	}
}
function eha(p_strName) {
	if (document.all) {
		return document.all[p_strName];
	} else {
		return document.getElementById(p_strName);
	}
}
function $speechFinishedInFlash() {
	Iha(false);
	Jha(false);
}
function $flashHasFocus(p_bHasFocus, p_strId) {
	if (1 == 1) {
		return;
	}
	jda = parseInt(p_strId);
	if (p_bHasFocus) {
		var flash = Zra(jda);
		if (flash != null) {
			var kha = flash.getSpelling();
			var lha = flash.getHomophone();
			var mha = flash.getPrediction();
			g_toggleIcons[Pca][8] = kha;
			if (kha) {
				if (dda) {
					document.images[g_toggleIcons[Pca][0]].src = g_toggleIcons[i][Eea].src;
				} else {
					Zea(g_toggleIcons[Pca][0], "toggleOn", true);
				}
			} else {
				if (dda) {
					document.images[g_toggleIcons[Pca][0]].src = g_toggleIcons[i][Aea].src;
				} else {
					Zea(g_toggleIcons[Pca][0], "flat", true);
				}
			}
			g_toggleIcons[Qca][8] = lha;
			if (lha) {
				if (dda) {
					document.images[g_toggleIcons[Qca][0]].src = g_toggleIcons[i][Eea].src;
				} else {
					Zea(g_toggleIcons[Qca][0], "toggleOn", true);
				}
			} else {
				if (dda) {
					document.images[g_toggleIcons[Qca][0]].src = g_toggleIcons[i][Aea].src;
				} else {
					Zea(g_toggleIcons[Qca][0], "flat", true);
				}
			}
			g_toggleIcons[Rca][8] = mha;
			if (mha) {
				if (dda) {
					document.images[g_toggleIcons[Rca][0]].src = g_toggleIcons[i][Eea].src;
				} else {
					Zea(g_toggleIcons[Rca][0], "toggleOn", true);
				}
			} else {
				if (dda) {
					document.images[g_toggleIcons[Rca][0]].src = g_toggleIcons[i][Aea].src;
				} else {
					Zea(g_toggleIcons[Rca][0], "flat", true);
				}
			}
		}
	} else {
		var flash = Zra(jda);
		if (flash != null) {
			var kha = flash.getSpelling();
			var lha = flash.getHomophone();
			var mha = flash.getPrediction();
			g_toggleIcons[Pca][8] = kha;
			g_toggleIcons[Qca][8] = lha;
			g_toggleIcons[Rca][8] = mha;
		}
	}
}
Number.prototype.NaN0 = function() {
	return isNaN(this) ? 0 : this;
};
function nha(event) {
}
function oha(event) {
	var target = event.target || event.srcElement;
	if (target.id == 'rwDragMe' || target.id == 'rwDragMeDisplay'
			|| target.id == 'rwDragMeTrans' || target.id == 'rwDragMeFF'
			|| target.id == 'rwDragMeDict' || target.id == 'rwDragMeCollect'
			|| target.id == 'rwDragMeStickyNoteTop'
			|| target.id == 'rwDragMeStickyNoteBot'
			|| target.id == 'rwDragMePronCreate'
			|| target.id == 'rwDragMePronEdit') {
		Eda = target;
		Fda = true;
		if (Eda.setCapture) {
			Eda.setCapture(true);
		}
		Dda = Bha(Eda);
		if (target.id == 'rwDragMeStickyNoteBot') {
			Dda.y -= target.offsetTop;
		}
		Cda = zga(event);
		return false;
	}
}
function pha(event) {
	var target = event.target || event.srcElement;
	if (target.tagName == "IMG" && target.id == "thnodragicon") {
		Hia(event);
		return false;
	}
}
function qha(event) {
	if (kda > 0) {
		--kda;
	}
	if (event != null) {
		if (!Fda) {
			if (g_bHover && Tba) {
				Tka(event);
			}
			if (uda) {
				DBb(event);
			}
		}
	}
}
function rha(event) {
	if (event != null) {
		if (!Fda) {
			if (dda) {
				if (g_bHover && !Tba) {
					Tka(event);
				} else if (Xca) {
					Jka(event);
				}
			}
		}
	}
}
function Bia(event) {
	if (event == null) {
		return true;
	}
	if (Eda == null) {
		if (g_bHover && (eda || cda) && !Tba) {
			Tka(event);
		} else if (Xca) {
			Jka(event);
		}
		Fda = false;
		return true;
	}
	var fqa = zga(event);
	if (fqa.x < 0 || fqa.y < 0 || fqa.x > rw_getDocumentDisplayWidth()
			|| fqa.y > rw_getDocumentDisplayHeight()) {
		Hia(event);
		return false;
	}
	var tha;
	var uha;
	var vha = false;
	var wha = 1.0;
	if (cda && !sda) {
		var a1 = document.body.offsetWidth;
		var a2 = document.documentElement.offsetWidth;
		wha = (a1 / a2);
		if (wha > 1.05 || wha < 99.5) {
			vha = true;
		}
	}
	if (vha) {
		var zha = (wha * Cda.x) - (Dda.x);
		var Aia = (wha * Cda.y) - (Dda.y);
		tha = (((wha * fqa.x) - zha)) / wha;
		uha = (((wha * fqa.y) - Aia)) / wha;
	} else {
		var zha = Cda.x - (Dda.x);
		var Aia = Cda.y - (Dda.y);
		tha = (fqa.x - zha);
		uha = (fqa.y - Aia);
	}
	if (Eda.id == 'rwDragMe') {
		xga(tha, uha);
		if ((tha + Mda + Gda) > rw_getDocumentDisplayWidthAdjusted()) {
			tha = rw_getDocumentDisplayWidthAdjusted() - Mda - Gda;
			Kda = 1.0;
		}
		if (tha < Gda) {
			tha = Gda;
			Kda = 0.0;
		}
		if ((uha + Nda + Gda) > rw_getDocumentDisplayHeightAdjusted()) {
			uha = rw_getDisplayHeightAdjusted() - Nda - Gda;
			Lda = 1.0;
		}
		if (uha < Gda) {
			uha = Gda;
			Lda = 0.0;
		}
		nga();
		Hia(event);
	} else if (Eda.id == 'rwDragMeTrans' || Eda.id == 'rwDragMeFF'
			|| Eda.id == 'rwDragMeDict' || Eda.id == 'rwDragMeDisplay'
			|| Eda.id == 'rwDragMeCollect' || Eda.id == 'rwDragMeStickyNoteTop'
			|| Eda.id == 'rwDragMeStickyNoteBot'
			|| Eda.id == 'rwDragMePronCreate' || Eda.id == 'rwDragMePronEdit') {
		var Cia;
		if (Eda.id == 'rwDragMeDisplay') {
			Cia = Uda;
		} else if (Eda.id == 'rwDragMeTrans') {
			Cia = Vda;
		} else if (Eda.id == 'rwDragMeFF') {
			Cia = Wda;
		} else if (Eda.id == 'rwDragMeDict') {
			Cia = Xda;
		} else if (Eda.id == 'rwDragMeStickyNoteTop') {
			Cia = Zda;
		} else if (Eda.id == 'rwDragMeStickyNoteBot') {
			Cia = Zda;
		} else if (Eda.id == 'rwDragMePronCreate') {
			Cia = ada;
		} else if (Eda.id == 'rwDragMePronEdit') {
			Cia = bda;
		} else {
			Cia = Yda;
		}
		yga(Cia, tha, uha);
		if ((tha + Qda[Cia] + Gda) > rw_getDocumentDisplayWidthAdjusted()) {
			tha = rw_getDocumentDisplayWidthAdjusted() - Qda[Cia] - Gda;
			Oda[Cia] = 1.0;
		}
		if (tha < Gda) {
			tha = Gda;
			Oda[Cia] = 0.0;
		}
		if ((uha + Rda[Cia] + Gda) > rw_getDocumentDisplayHeightAdjusted()) {
			uha = rw_getDocumentDisplayHeightAdjusted() - Rda[Cia] - Gda;
			Pda[Cia] = 1.0;
		}
		if (uha < Gda) {
			uha = Gda;
			Pda[Cia] = 0.0;
		}
		uga(Cia);
		Hia(event);
	}
	return false;
}
function Eia(event) {
	if (nda != null) {
		if (mda) {
			mda = false;
			return;
		} else {
			if (lda) {
				var flash = Zra(jda);
				if (typeof (flash) != "undefined" && flash != null) {
					try {
						flash.lostFocus();
					} catch (err) {
					}
				}
				Lha(false);
			}
		}
	}
	if (!Fda) {
		return true;
	}
	if (Eda.releaseCapture) {
		Eda.releaseCapture();
	}
	Eda = null;
	Fda = false;
	Hia(event);
	return false;
}
function Gia(event) {
	if (Fda) {
		if (!cda && !dda) {
			var fqa = zga(event);
			if (fqa.x < 5 || fqa.y < 5
					|| fqa.x > (rw_getDocumentDisplayWidth() - 5)
					|| fqa.y > (rw_getDocumentDisplayHeight() - 5)) {
				Eia(event);
				Hia(event);
				return;
			}
		}
		Bia(event);
		Hia(event);
	} else {
		if (!Tba) {
			wja = null;
		}
	}
}
function Hia(event) {
	if (event == null) {
		return;
	}
	if (event.cancelBubble) {
		event.cancelBubble = true;
	} else if (event.stopPropagation) {
		event.stopPropagation();
	}
	if (event.returnValue) {
		event.returnValue = false;
	} else if (event.preventDefault) {
		event.preventDefault(true);
	}
}
function rw_mouseOverIcon(p_strName) {
	if (Ida > 0) {
		--Ida;
		return;
	}
	if (Fda) {
		return;
	}
	if ($rw_blockClick(p_strName)) {
		return;
	}
	for ( var i = 0; i < zca; i++) {
		if (p_strName == g_icons[i][0]) {
			if (dda) {
				document.images[g_icons[i][0]].src = g_icons[i][2].src;
			} else {
				Zea(g_icons[i][0], "hover", false);
			}
		}
	}
	for ( var i = 0; i < Ada; i++) {
		if (p_strName == g_toggleIcons[i][0]) {
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][2].src;
			} else {
				Zea(g_toggleIcons[i][0], "hover", true);
			}
		}
	}
}
function rw_mouseOffIcon(p_strName) {
	if (Ida > 0) {
		--Ida;
		return;
	}
	if (Fda) {
		return;
	}
	if ($rw_blockClick(p_strName)) {
		return;
	}
	for ( var i = 0; i < zca; i++) {
		if (p_strName == g_icons[i][0]) {
			if (dda) {
				document.images[g_icons[i][0]].src = g_icons[i][1].src;
			} else {
				Zea(g_icons[i][0], "flat", false);
			}
		}
	}
	for ( var i = 0; i < Ada; i++) {
		if (p_strName == g_toggleIcons[i][0]) {
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][1].src;
			} else {
				Zea(g_toggleIcons[i][0], "flat", true);
			}
		}
	}
}
function rw_press(p_strName) {
	if (Ida > 0) {
		--Ida;
		return;
	}
	if (Fda) {
		return;
	}
	if ($rw_blockClick(p_strName)) {
		return;
	}
	for ( var i = 0; i < zca; i++) {
		if (p_strName == g_icons[i][0]) {
			if (dda) {
				document.images[g_icons[i][0]].src = g_icons[i][3].src;
			} else {
				Zea(g_icons[i][0], "toggle", false);
			}
		}
	}
	for ( var i = 0; i < Ada; i++) {
		if (p_strName == g_toggleIcons[i][0]) {
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][3].src;
			} else {
				Zea(g_toggleIcons[i][0], "toggle", true);
			}
		}
	}
}
function $rw_blockClick(p_strName) {
	if (g_bSpeechModeFlag && ICONS_TO_DISABLE.indexOf(p_strName) > -1) {
		return true;
	}
	if (lda && Fha.indexOf(p_strName) > -1) {
		return true;
	}
	if (!lda && Gha.indexOf(p_strName) > -1) {
		return true;
	}
	return false;
}
function Mia(event) {
	var Lia = nsa("rwebooks-x");
	var Nia = nsa("rwebooks-y");
	if ((Lia != null) && (Nia != null)) {
		Kda = parseFloat(Lia);
		Lda = parseFloat(Nia);
	}
	var Oia = false;
	var SCb = Oda.length;
	var Qia;
	var Ria;
	for ( var i = 0; i < SCb; i++) {
		Qia = nsa("rwebooks-div" + i + "x");
		if (Qia != null) {
			Oda[i] = parseFloat(Qia);
		}
		Ria = nsa("rwebooks-div" + i + "y");
		if (Ria != null) {
			Pda[i] = parseFloat(Ria);
		}
		if (i == Zda) {
			if (Qia == null && Ria == null) {
				Oia = true;
			}
		}
	}
	if (Oia) {
		Oda[Zda] = 0.45;
		Pda[Zda] = 0.35;
	}
	nga();
	qga();
	$rw_pageSetup();
	if (Dca) {
		if (Fca != "*" && typeof (VAb) != "undefined") {
			VAb();
		} else {
			if (Eca != "*" && typeof (XCb) != "undefined") {
				XCb();
			}
		}
	}
	if (cda) {
		var Sia = document.createTextNode(" ");
		var Tia = document.body.appendChild(Sia);
	}
	if (yba && Aca) {
		$rw_cachePage(null, null);
	}
}
function Uia(event) {
	window.onunload = null;
	if (typeof (xBb) != 'undefined' && Dca && typeof (ABb) != 'undefined'
			&& ABb > -1) {
		fBb(ABb);
	}
	if (!Hda && Rba && !ls_teacherFlag) {
		event.returnValue = "Your data will be lost if you click OK!";
	}
	qsa("rwebooks-x", Kda, 20, "/", window.location.host);
	qsa("rwebooks-y", Lda, 20, "/", window.location.host);
	var SCb = Oda.length;
	for ( var i = 0; i < SCb; i++) {
		qsa("rwebooks-div" + i + "x", Oda[i], 20, "/", window.location.host);
		qsa("rwebooks-div" + i + "y", Pda[i], 20, "/", window.location.host);
	}
	if (!Hda && Rba && !ls_teacherFlag) {
		return "Your data will be lost if you click OK!";
	} else {
	}
}
var Wia = -10;
function THCaret(p_node, p_nOffset) {
	this.node = p_node;
	this.offset = p_nOffset;
	if (Nla(this.node)) {
		this.offset = Wia;
	}
	this.isSpecialCase = function() {
		return (this.offset == Wia);
	};
	this.check = function() {
		var Yia = true;
		with (this) {
			if (node == null || node.parentNode == null) {
				Yia = false;
			} else {
				if (node.nodeType != 3) {
					if (node.nodeType == 1 && this.offset == Wia) {
					} else {
						Yia = false;
					}
				} else if (this.offset < 0
						|| this.offset > node.nodeValue.length) {
					Yia = false;
				}
			}
		}
		return Yia;
	};
	this.toString = function() {
		var txt = "THCaret ";
		if (this.node != null) {
			if (this.node.nodeType == 3) {
				txt += this.node.nodeValue + " " + this.node.parentNode.tagName
						+ " ";
			} else if (this.node.nodeType == 1) {
				txt += this.node.tagName + " ";
			}
		}
		txt += this.offset;
		return txt;
	};
};
function Zia(p_leftCaret, p_rightCaret) {
	this.oza = p_leftCaret;
	this.pza = p_rightCaret;
}
function THDomRefPt(p_strPath, p_nOffset) {
	this.path = p_strPath;
	this.offset = p_nOffset;
	this.isSpecialCase = function() {
		return (this.offset == Wia);
	};
	this.toString = function() {
		return "THDomRefPt " + this.path + " " + this.offset;
	};
};
var bia = -1;
var cia = 0;
var dia = 1;
var eia = 2;
var fia = 3;
var gia = 4;
var hia = 5;
var iia = 6;
var jia = 7;
var kia = 8;
function lia(p_startNode, p_nStartOffset, p_endNode, p_nEndOffset) {
	this.body = p_startNode.ownerDocument.body;
	this.PAb = new THCaret(p_startNode, p_nStartOffset);
	this.QAb = new THCaret(p_endNode, p_nEndOffset);
	this.gza = Gja(p_startNode, p_nStartOffset);
	this.hza = Gja(p_endNode, p_nEndOffset);
	this.refresh = function() {
		with (this) {
			if (PAb.check() == false || QAb.check() == false) {
				var OAb = mpa(this.body, this.gza.path, this.gza.offset,
						this.hza.path, this.hza.offset);
				var PAb = OAb.oza;
				var QAb = OAb.pza;
				if (PAb == null && QAb == null) {
					PAb = new THCaret(document.body, 0);
					QAb = new THCaret(document.body, 0);
				} else if (PAb == null || QAb == null) {
					if (PAb == null) {
						PAb = new THCaret(QAb.node, QAb.offset);
					} else {
						QAb = new THCaret(PAb.node, PAb.offset);
					}
				}
			}
		}
	};
	this.toString = function() {
		with (this) {
			refresh();
			var range = ata();
			range.setStart(PAb.node, PAb.offset);
			range.setEnd(QAb.node, QAb.offset);
			return range.toString();
		}
	};
	this.getStartAsRange = function() {
		var range = ata();
		range.setStart(this.PAb.node, this.PAb.offset);
		range.setEnd(this.PAb.node, this.PAb.offset);
		return range;
	};
	this.getEndAsRange = function() {
		var range = ata();
		range.setStart(this.QAb.node, this.QAb.offset);
		range.setEnd(this.QAb.node, this.QAb.offset);
		return range;
	};
	this.equals = function(p_target) {
		return (this.gza.path == p_target.gza.path
				&& this.gza.offset == p_target.gza.offset
				&& this.hza.path == p_target.hza.path && this.hza.offset == p_target.hza.offset);
	};
	this.compareRange = function(p_target) {
		if (this.equals(p_target)) {
			return cia;
		}
		this.refresh();
		p_target.refresh();
		var pia = this.getStartAsRange();
		var qia = this.getEndAsRange();
		var ria = p_target.getStartAsRange();
		var sia = p_target.getEndAsRange();
		var tia = pia.compareBoundaryPoints("START_TO_START", ria);
		var uia = pia.compareBoundaryPoints("START_TO_START", sia);
		var via = qia.compareBoundaryPoints("START_TO_START", ria);
		var wia = qia.compareBoundaryPoints("START_TO_START", sia);
		var nya = bia;
		if (uia > -1) {
			nya = dia;
		} else if (via < 1) {
			nya = eia;
		} else if (tia == -1) {
			if (wia == -1) {
				nya = iia;
			} else {
				nya = fia;
			}
		} else if (tia == 0) {
			if (wia == -1) {
				nya = jia;
			} else if (wia == 0) {
				nya = cia;
			} else {
				nya = fia;
			}
		} else {
			if (wia == -1) {
				nya = gia;
			} else if (wia == 0) {
				nya = kia;
			} else {
				nya = hia;
			}
		}
		return nya;
	};
};
function yia(p_body, p_startRefPt, p_endRefPt) {
	this.body = p_body;
	this.gza = p_startRefPt;
	this.hza = p_endRefPt;
	this.equals = function(p_target) {
		return (this.gza.path == p_target.gza.path
				&& this.gza.offset == p_target.gza.offset
				&& this.hza.path == p_target.hza.path && this.hza.offset == p_target.hza.offset);
	};
	this.toString = function() {
		with (this) {
			if (cda) {
				var range = getAsRange();
				if (range != null) {
					return getAsRange().text;
				} else {
					return "";
				}
			} else {
				var range = getAsRange();
				if (range != null) {
					return getAsRange().toString();
				} else {
					return "";
				}
			}
		}
	};
	this.getAsRange = function() {
		with (this) {
			var range = null;
			if (cda) {
				range = rw_getAsTextRange(this.body, this.gza.path,
						this.gza.offset, this.hza.path, this.hza.offset);
			} else {
				range = ata();
				var OAb = mpa(this.body, this.gza.path, this.gza.offset,
						this.hza.path, this.hza.offset);
				var PAb = OAb.oza;
				var QAb = OAb.pza;
				if (PAb != null && QAb != null) {
					range.setStart(PAb.node, PAb.offset);
					range.setEnd(QAb.node, QAb.offset);
				} else {
					range = null;
					cta("Failed to get the start or end caret.");
				}
			}
			return range;
		}
	};
};
function Gja(p_node, p_nOffset) {
	try {
		if (p_node == null) {
			return null;
		}
		if (p_node.nodeType == 1) {
			var KCb = Wla(p_node);
			if (KCb != null) {
				return new THDomRefPt(Jpa(KCb), p_nOffset);
			}
			var hCb = 0;
			var nBb = p_node;
			var Zva = nBb.getAttribute("rwstate");
			var Mja = nBb.getAttribute(caa);
			while (nBb.tagName.toLowerCase() == "font"
					|| (Zva != null && Zva.length > 0) || Mja != null) {
				hCb += Sja(nBb);
				nBb = nBb.parentNode;
				Zva = nBb.getAttribute("rwstate");
				Mja = nBb.getAttribute(caa);
			}
			if (p_nOffset == -1) {
				hCb = -1;
			}
			return new THDomRefPt(Jpa(nBb), hCb + p_nOffset);
		} else if (p_node.nodeType == 3) {
			var KCb = Wla(p_node);
			if (KCb != null) {
				return new THDomRefPt(Jpa(KCb), p_nOffset);
			}
			if (p_node.nodeValue.trimTH().length == 0) {
				p_nOffset = 0;
			}
			var hCb = Sja(p_node);
			var nBb = p_node.parentNode;
			var Zva = nBb.getAttribute("rwstate");
			var Mja = nBb.getAttribute(caa);
			while (nBb.tagName.toLowerCase() == "font"
					|| (Zva != null && Zva.length > 0) || Mja != null) {
				hCb += Sja(nBb);
				nBb = nBb.parentNode;
				Zva = nBb.getAttribute("rwstate");
				Mja = nBb.getAttribute(caa);
			}
			if (p_nOffset == -1) {
				hCb = -1;
			}
			return new THDomRefPt(Jpa(nBb), hCb + p_nOffset);
		} else {
			return null;
		}
	} catch (ignore) {
		return null;
	}
};
function Sja(p_node) {
	if (p_node == null) {
		return 0;
	}
	var hCb = 0;
	var koa = p_node.previousSibling;
	if (koa != null) {
		hCb = Tja(koa);
	}
	return hCb;
};
function Tja(p_node) {
	var hCb = 0;
	var koa = p_node;
	var Kta;
	while (koa != null) {
		if (koa.nodeType == 3) {
			Kta = koa.nodeValue;
			hCb += Kta.length;
		} else if (koa.nodeType == 1) {
			if (!Poa(koa)) {
				if (Nla(koa)) {
					hCb += 1;
				} else if (koa.tagName.toLowerCase() != "textarea") {
					hCb += Tja(koa.lastChild);
				} else {
					hCb += 1;
				}
			}
		}
		koa = koa.previousSibling;
	}
	return hCb;
};
function THHoverTarget(p_body, p_strPath, p_thRange) {
	this.body = p_body;
	this.path = p_strPath;
	this.range = p_thRange;
	this.Tsa = null;
	this.isRange = function() {
		return this.range != null;
	};
	this.getCaretRange = function() {
		var OAb;
		if (this.isRange()) {
			OAb = mpa(this.range.body, this.range.gza.path,
					this.range.gza.offset, this.range.hza.path,
					this.range.hza.offset);
		} else {
			var caret = jpa(this.body, this.path, -1, true);
			OAb = new Zia(caret, caret);
		}
		return OAb;
	};
	this.getTextPreparedForSpeech = function() {
		var txt;
		if (this.isRange()) {
			this.Tsa = new Array();
			var Xja = Dla(this.range.body, this.range.gza, this.range.hza,
					this.Tsa);
			Nwa(Xja.voice);
			if (Xja.OAb != null) {
				var Yja = Xja.OAb;
				this.range = Rra(Yja);
			}
			txt = Xja.txt;
		} else {
			var caret = jpa(this.body, this.path, -1, true);
			if (caret != null && caret.node != null) {
				var aja = cja(caret.node);
				if (aja.trimTH().length == 0) {
					return "";
				} else {
					if (rba) {
						Nwa(Awa(oza.node));
					}
					txt = uja + "0" + vja + cja(caret.node) + uja + "1" + vja;
				}
			} else {
				txt = "";
			}
		}
		if (rba && txt.length > 0) {
			var bja;
			if (sba != null) {
				bja = sba;
			} else {
				sba = iba;
			}
			if (sba == "ScanSoft Emily_Full_22kHz"
					|| sba == "ScanSoft Daniel_Full_22kHz"
					|| sba == "ScanSoft Jill_Full_22kHz"
					|| sba == "ScanSoft Tom_Full_22kHz" || sba == "VW Kate"
					|| sba == "VW Paul") {
				txt = "<volume level=\"75\"/>" + txt;
			}
		}
		return txt;
	};
	function cja(p_node) {
		var txt = "";
		try {
			if (p_node.nodeType == 1) {
				if (p_node.getAttribute("ignore") == null) {
					var tagName = p_node.tagName.toLowerCase();
					if (tagName == "input") {
						var Qua = p_node.getAttribute("type");
						if (Qua != null) {
							Qua = Qua.toLowerCase();
							if (Qua.length == 0 || Qua == "text") {
								txt = p_node.value;
							} else if (Qua == "password") {
								txt = "";
							} else if (Qua == "image") {
								var mja = p_node.getAttribute("alt");
								if (mja != null && mja.length > 0) {
									txt = mja;
								} else {
									txt = "";
								}
							} else if (Qua == "button" || Qua == "submit"
									|| Qua == "reset") {
								txt = p_node.getAttribute("value");
							}
						} else {
							txt = p_node.value;
						}
					} else if (tagName == "select") {
						var Tua = p_node.selectedIndex;
						var Uua = "";
						var SCb = p_node.options.length;
						for ( var Iza = 0; Iza < SCb; Iza++) {
							Uua += p_node.options[Iza].text + " ";
						}
						if (SCb > 0) {
							if (Tua > -1) {
								txt = p_node.options[Tua].text
										+ " selected from the list " + Uua;
							} else {
								txt = "No selection from list " + Uua;
							}
						}
					} else if (tagName == "textarea" || tagName == "option") {
						txt = p_node.value;
					} else if (tagName == "img") {
						var jja = p_node.getAttribute("title");
						if (jja != null && jja.length > 0) {
							txt = jja;
						} else {
							var mja = p_node.getAttribute("alt");
							if (mja != null && mja.length > 0) {
								txt = mja;
							} else {
								var nja = p_node.getAttribute("msg");
								if (nja != null && nja.length > 0) {
									txt = nja;
								}
							}
						}
					} else {
						var mja = p_node.getAttribute("alt");
						if (mja != null && mja.length > 0) {
							txt = mja;
						} else {
							var nja = p_node.getAttribute("msg");
							if (nja != null && nja.length > 0) {
								txt = nja;
							}
						}
					}
				}
			}
		} catch (ignore) {
			txt = "";
		}
		return txt;
	}
	;
	this.highlightRange = function() {
		try {
			if (this.range != null) {
				var OAb = mpa(this.range.body, this.range.gza.path,
						this.range.gza.offset, this.range.hza.path,
						this.range.hza.offset);
				var oza = OAb.oza;
				var pza = OAb.pza;
				if (oza != null && pza != null) {
					rw_setSpeechRangeImpl(oza.node, oza.offset, pza.node,
							pza.offset, "sp");
				} else {
				}
			}
		} catch (err) {
			cta("err THHoverTargetClass:highlightRange: " + err.message);
		}
	};
	this.unhighlightRange = function() {
		try {
			if (this.range != null) {
				var OAb = mpa(this.range.body, this.range.gza.path,
						this.range.gza.offset, this.range.hza.path,
						this.range.hza.offset);
				var oza = OAb.oza;
				var pza = OAb.pza;
				if (oza != null && pza != null) {
					rw_removeSpeechHighlight(Bva(oza, pza), false);
				} else {
				}
			}
		} catch (err) {
			cta("failed to do unhighlightRange:" + err.message);
		}
	};
	this.equals = function(p_hoverTarget) {
		if (p_hoverTarget == null) {
			return false;
		}
		if (this.isRange() != p_hoverTarget.isRange()) {
			return false;
		}
		if (this.isRange()) {
			return this.range.equals(p_hoverTarget.range);
		} else {
			return this.path.equalsTH(p_hoverTarget.path);
		}
	};
	this.toString = function() {
		var txt = "THHoverTarget ";
		if (this.path != null) {
			txt += "path=" + this.path;
		} else if (this.range != null) {
			txt += this.range.toString();
		}
		return txt;
	};
};
var uja = '<bookmark mark="';
var vja = '"/>';
var wja = null;
var g_lastTarget = null;
var yja = 0;
var zja = 0;
var Aka = false;
var Bka = false;
var Cka = false;
if (dda) {
	var Dka = navigator.appVersion;
	var Eka = Dka.lastIndexOf("/");
	Dka = Dka.substring(Eka + 1);
	try {
		var Fka = parseFloat(Dka);
		if (Fka < 300 || (Fka > 400 && Fka < 416)) {
			Aka = true;
		} else if (Fka > 500) {
			Cka = true;
		} else {
			Bka = true;
		}
	} catch (err) {
		Cka = true;
	}
}
function tmp(str) {
	var el = document.getElementById("asd");
	el.innerText = str;
};
function Jka(evt) {
	if (Yca && evt.shiftKey) {
		return;
	}
	var Rka = Wka(evt);
	if (Rka != null) {
		if (Rka.node.nodeType == 1) {
			var KBb = Rka.node;
			var VBb = KBb.tagName.toLowerCase();
			if (VBb == "img") {
				KBb = KBb.parentNode;
				VBb = KBb.tagName.toLowerCase();
			}
			if (VBb == "div") {
				if (KBb.id == "startbubble" || KBb.id == "stopbubble") {
					return;
				}
			}
		}
		var bka = ika(Rka);
		if (bka != null) {
			var txt = rw_getTextOverCaretRange(bka.getCaretRange());
			if (txt != null && txt.length > 0) {
				var start = bka.getCaretRange().oza.node;
				if (bka.isRange()) {
					var end = bka.getCaretRange().pza.node;
					start = sna(start);
					end = wna(end);
					var gza = Gja(start, 0);
					var hza;
					if (end.nodeType == 1) {
						hza = Gja(end, 0);
					} else {
						hza = Gja(end, end.nodeValue.length);
					}
					bka.range = new yia(document.body, gza, hza);
				}
				var pos = Bha(start);
				var scrollLeft = rw_getScreenOffsetLeft();
				var scrollTop = rw_getScreenOffsetTop();
				Ffa(pos.x, pos.y, bka);
				var dd = document.getElementById("testout");
				if (dd != null) {
					dd.innerHTML = "Target  = "
							+ bka.getTextPreparedForSpeech() + "   " + pos.x
							+ "   " + pos.y;
				}
			} else {
			}
		}
	}
}
var Oka = 0;
var Pka = 0;
function Tka(evt) {
	try {
		var d = new Date();
		var gDb = d.getTime();
		if (gDb < (Pka + 800)) {
			return;
		}
		g_bInMouseHoverFlag = true;
		var Rka = Wka(evt);
		if (Rka != null) {
			var bka = ika(Rka);
			if (bka != null) {
				try {
					if (bka.equals(wja)) {
						return;
					}
					if (bka.equals(g_lastTarget)) {
						if ((gDb - Oka) < 1000) {
							return;
						}
						Oka = gDb;
					}
					wja = bka;
					oka(wja);
				} catch (err) {
					cta("err " + err.message);
				}
			} else {
				wja = null;
			}
		}
	} catch (err) {
		cta("mousehover error:" + err.message);
	}
};
function Wka(p_evt) {
	var Cpa = null;
	var Dpa = 0;
	if (cda) {
		Cpa = p_evt.srcElement;
		if (Cpa.nodeType == 1 && Cpa.tagName.toLowerCase() == "textarea") {
		} else {
			var iCb = rw_getTargetNodeAsCaretIE(p_evt);
			if (iCb != null) {
				Cpa = iCb.node;
				Dpa = iCb.offset;
			}
		}
	} else if (dda) {
		Cpa = p_evt.target;
		if (Cpa != null) {
			if (Cka) {
				if (Cpa.firstChild != null && Cpa.firstChild.nodeType == 3
						&& Cpa.tagName.toLowerCase() != "textarea") {
					var Gpa = Cpa.firstChild.nodeValue;
					if (Gpa.trimTH().length > 0) {
						Cpa = Cpa.firstChild;
					}
				}
			} else if (Bka) {
				if (p_evt.fromElement != null) {
					if (Cpa.nodeType == 1
							&& Cpa.tagName.toLowerCase() != "textarea") {
						if (p_evt.fromElement.nodeType == 3) {
							Cpa = p_evt.fromElement;
						}
					}
				} else {
					if (Cpa.firstChild != null && Cpa.firstChild.nodeType == 3
							&& Cpa.tagName.toLowerCase() != "textarea") {
						var Gpa = Cpa.firstChild.nodeValue;
						if (Gpa.trimTH().length > 0) {
							Cpa = Cpa.firstChild;
						}
					}
				}
			}
		}
	} else {
		if (p_evt.explicitOriginalTarget.nodeValue != null) {
			if (p_evt.target.tagName.toLowerCase() == "textarea") {
				Cpa = p_evt.target;
			} else {
				Cpa = p_evt.explicitOriginalTarget;
			}
		} else {
			Cpa = p_evt.target;
		}
	}
	if (Cpa == null) {
		return null;
	}
	return new THCaret(Cpa, Dpa);
}
function ika(p_targetCaret) {
	var Cpa = p_targetCaret.node;
	var bka = null;
	if (zba || yba) {
		var bod = bta(Cpa);
		var qza = Cpa;
		if (qza.nodeType == 3) {
			qza = qza.parentNode;
		}
		while (qza != null && qza != bod) {
			if (qza.getAttribute(baa) != null) {
				return bka;
			}
			qza = qza.parentNode;
		}
	}
	if (Cpa != null && Cpa.parentNode != null && Cpa.parentNode.getAttribute) {
		var Nua;
		var eka;
		var fka;
		var gka;
		var hka;
		if (Cpa.nodeType == 1) {
			Nua = Cpa.tagName;
			if (xba && Nua.toUpperCase() == "INPUT") {
				var vBb = Cpa.getAttribute("type");
				if (vBb != null && vBb == "button") {
					return bka;
				}
			}
			eka = Cpa.getAttribute("started");
			fka = Cpa.getAttribute("ignore");
			gka = Cpa.getAttribute("sp");
			hka = Cpa.getAttribute("csp");
			if (hka != null || fka != null || gka != null || eka != null) {
				return bka;
			}
		}
		var kka = Cpa.parentNode;
		eka = kka.getAttribute("started");
		fka = kka.getAttribute("ignore");
		gka = kka.getAttribute("sp");
		hka = kka.getAttribute("csp");
		if (hka != null || fka != null || gka != null || eka != null) {
			bka = null;
		} else {
			if (Cpa.nodeType == 3) {
				var iCb = p_targetCaret;
				try {
					var oza;
					var pza;
					if (!cda && iCb.node.nodeValue.length > 0) {
						iCb.offset = 0;
						oza = bma(iCb);
						iCb.offset = iCb.node.nodeValue.length - 1;
						pza = mma(iCb);
					} else {
						oza = bma(iCb);
						pza = mma(iCb);
					}
					var range = new yia(bta(kka), Gja(oza.node, oza.offset),
							Gja(pza.node, pza.offset));
					bka = new THHoverTarget(null, null, range);
				} catch (err) {
					cta(err.message);
				}
			} else if (Cpa.nodeType == 1) {
				bka = new THHoverTarget(bta(Cpa), Jpa(Cpa), null);
			} else {
				bka = null;
			}
		}
	}
	return bka;
}
function oka(p_hoverTarget) {
	if (Tba) {
		$rw_event_stop_limited();
		yja = setTimeout("rw_doHoverStep2()", 500);
	} else {
		yja = setTimeout("rw_doHoverStep1()", 500);
	}
};
function rw_doHoverStep1() {
	if (g_bHover) {
		yja = 0;
		if (wja != null) {
			if (!Tba) {
				var txt;
				if (wja instanceof String) {
					txt = wja.toString();
				} else {
					txt = wja.getTextPreparedForSpeech();
				}
				if (txt == null || txt.length == 0) {
					return;
				}
			}
			$rw_event_stop_limited();
			zja = setTimeout("rw_doHoverStep2()", 1000);
		}
	}
};
var qka = false;
function rw_doHoverStep2() {
	try {
		qka = true;
		if (g_bHover) {
			yja = 0;
			if (wja != null) {
				if (g_lastTarget != null) {
					zja = setTimeout("rw_doHoverStep2()", 500);
				} else {
					var d = new Date();
					Pka = d.getTime();
					rw_speakHoverTarget(wja);
					wja = null;
				}
			}
		}
	} catch (ignore) {
	}
	qka = false;
};
function rw_speakHoverTarget(p_target) {
	try {
		if (g_lastTarget != null) {
			g_lastTarget.unhighlightRange();
		}
		if (p_target instanceof String) {
			g_lastTarget = null;
			hra(p_target.toString());
		} else {
			g_lastTarget = p_target;
			var txt = p_target.getTextPreparedForSpeech();
			if (txt != null && txt.length > 0) {
				p_target.highlightRange();
				hra(txt);
				if (Vca) {
					var Fxa = p_target.range;
					var OAb;
					var bod;
					if (Fxa != null) {
						bod = Fxa.body;
						OAb = mpa(bod, Fxa.gza.path, Fxa.gza.offset,
								Fxa.hza.path, Fxa.hza.offset);
					} else if (p_target.body != null && p_target.path != null) {
						bod = p_target.body;
						var uka = new THCaret(Spa(bod, p_target.path), 0);
						OAb = new Zia(uka, uka);
					} else {
						return;
					}
					var vka = gna(OAb);
					if (vka == null) {
						return;
					}
					var wka = rw_getTextOverCaretRange(vka);
					if (wka == null || wka.length == 0 || !bla(wka)) {
						vka = gna(vka);
						if (vka == null) {
							return;
						}
						wka = rw_getTextOverCaretRange(vka);
					}
					if (Ala(OAb.pza.node, vka.oza.node)) {
						return;
					}
					var xka = new yia(bod, Gja(vka.oza.node, vka.oza.offset),
							Gja(vka.pza.node, vka.pza.offset));
					Wca = new THHoverTarget(null, null, xka);
					Ksa.push("setTimeout(\"$rw_readNextTarget();\", 50);");
				}
			}
		}
	} catch (err) {
		cta("rw_speakHoverTarget error:" + err.message);
	}
}
function $rw_readNextTarget() {
	if (Wca != null) {
		wja = Wca;
		Wca = null;
		rw_doHoverStep2();
	}
}
function Ala(p_startNode, p_endNode) {
	if (p_startNode == null || p_endNode == null || p_startNode == p_endNode) {
		return false;
	}
	var Fwa = p_startNode;
	Fwa = Ima(Fwa, false, p_endNode);
	while (Fwa != null && Fwa != p_endNode) {
		if (Fwa.nodeType == 1) {
			if (Fwa.getAttribute("texthelpStopContinuous") != null) {
				return true;
			}
		}
		Fwa = Ima(Fwa, false, p_endNode);
	}
	return false;
}
function Cla(p_range, p_strWord) {
	this.range = p_range;
	this.word = p_strWord;
};
function Dla(p_body, p_domRefLeft, p_domRefRight, p_wordNodes) {
	try {
		if (p_domRefLeft == null || p_domRefRight == null) {
			return new zva();
		}
		var OAb = mpa(p_body, p_domRefLeft.path, p_domRefLeft.offset,
				p_domRefRight.path, p_domRefRight.offset);
		return Lla(OAb, p_wordNodes);
	} catch (err) {
		cta("err rw_getTextOverRangeToSpeak:" + "|" + err.message);
		return new zva();
	}
};
function Lla(p_thCaretRange, p_wordNodes) {
	var Ela = new zva();
	try {
		if (p_thCaretRange == null) {
			return Ela;
		}
		var oza = p_thCaretRange.oza;
		var pza = p_thCaretRange.pza;
		if (oza == null) {
			return Ela;
		}
		if (pza == null) {
			return Ela;
		}
		if (oza.node != null) {
			var KCb = Wla(oza.node);
			if (KCb != null) {
				oza.node = KCb;
				oza.offset = 0;
			}
		}
		if (pza.node != null && pza.node.nodeType == 3) {
			var KCb = Wla(pza.node);
			if (KCb != null) {
				if (pza.node.nodeType == 3) {
					pza.offset = pza.node.nodeValue.length;
				}
				pza.node = KCb;
			}
		}
		if (rba) {
			var Jla = Awa(oza.node);
			if (Jla != null) {
				Ela.voice = Jla;
			}
			var Kla = Iwa(oza.node, pza.node, Jla);
			if (Kla != null) {
				Ela.OAb = new Zia(p_thCaretRange.oza, Kla);
				pza = Kla;
			}
		}
		rw_getTextOverRangeToSpeakImpl(oza, pza, p_wordNodes);
		var txt = "";
		var SCb = p_wordNodes.length;
		if (SCb > 0) {
			var i = 0;
			for (i = 0; i < SCb; i++) {
				txt += uja + i + vja + p_wordNodes[i].word;
			}
			txt += uja + SCb + vja;
		}
		Ela.txt = txt;
		return Ela;
	} catch (err) {
		cta("err rw_getTextOverRangeToSpeak:" + "|" + err.message);
		return Ela;
	}
};
function Nla(p_node) {
	if (p_node == null) {
		return false;
	}
	if (p_node.nodeType == 1) {
		var tagName = p_node.tagName.toLowerCase();
		if (tagName == "span") {
			var Zva = p_node.getAttribute("pron");
			if (Zva != null) {
				return true;
			}
			Zva = p_node.getAttribute("chunk");
			if (Zva != null) {
				return true;
			}
		} else if (tagName == "acronym" || tagName == "abbr") {
			var Zva = p_node.getAttribute("title");
			if (Zva != null) {
				return true;
			}
		} else if (tagName == "chunk") {
			return true;
		} else if (tagName == "img") {
			var Zva = p_node.getAttribute("msg");
			if (Zva != null) {
				return true;
			}
		} else if (p_node.getAttribute("ignore") != null) {
			return true;
		}
	}
	return false;
};
function Rla(p_node) {
	if (p_node.nodeType == 1) {
		var tagName = p_node.tagName.toLowerCase();
		if (tagName == "span") {
			var Zva = p_node.getAttribute("pron");
			if (Zva != null) {
				return true;
			}
		} else if (tagName == "acronym" || tagName == "abbr") {
			var Zva = p_node.getAttribute("title");
			if (Zva != null) {
				return true;
			}
		}
	}
	return false;
};
function Wla(p_node) {
	if (p_node != null) {
		var bod = bta(p_node);
		var qza = p_node;
		while (qza != null && qza != bod) {
			if (Nla(qza)) {
				return qza;
			}
			qza = qza.parentNode;
		}
	} else {
		return null;
	}
};
var Vla = 500;
function Yla(p_storedText) {
	var ola = p_storedText.length;
	if (ola > 1 && p_storedText.substr(ola - 2, 2) == ". ") {
		return p_storedText;
	} else if (ola > 0 && p_storedText.substr(ola - 1, 1) == ".") {
		return p_storedText + " ";
	} else {
		var txt = p_storedText.trimEndTH();
		var c = txt.charCodeAt(txt.length - 1);
		if (ita(c) || c > 127) {
			return p_storedText + ". ";
		} else {
			return p_storedText;
		}
	}
}
function bla(p_strWord) {
	var SCb = p_strWord.length;
	var i = 0;
	var GDb;
	for (i = 0; i < SCb; i++) {
		GDb = p_strWord.charCodeAt(i);
		if (GDb > 63 && GDb != 91 && GDb != 93 && GDb != 160
				&& (GDb < 123 || GDb > 127)) {
			return true;
		} else if (GDb > 35
				&& ((GDb < 58 && GDb != 40 && GDb != 41 && GDb != 44 && GDb != 46) || GDb == 61)) {
			return true;
		}
	}
	return false;
}
function dla(p_strWord) {
	var gAb = "";
	var SCb = p_strWord.length;
	var i = 0;
	var GDb;
	for (i = 0; i < SCb; i++) {
		GDb = p_strWord.charCodeAt(i);
		if (GDb > 127) {
			gAb += p_strWord.charAt(i);
		} else {
			switch (GDb) {
			case 35:
			case 40:
			case 41:
			case 91:
			case 93:
			case 95:
			case 123:
			case 124:
			case 125:
				gAb += " ";
				break;
			case 96:
				gAb += "'";
				break;
			case 38:
				gAb += "&amp;";
				break;
			case 34:
				gAb += "&quot;";
				break;
			case 60:
				gAb += "&lt;";
				break;
			case 62:
				gAb += "&gt;";
				break;
			default:
				gAb += p_strWord.charAt(i);
			}
		}
	}
	return gAb;
}
function rw_getTextOverRangeToSpeakImpl(p_leftCaret, p_rightCaret, p_wordNodes) {
	try {
		var koa = p_leftCaret.node;
		var loa = p_rightCaret.node;
		var bod = bta(koa);
		var fma = p_leftCaret.offset;
		var oma = p_rightCaret.offset;
		var kla = "";
		var Fwa = koa;
		var nla = null;
		var ola = 0;
		var Iza = 0;
		var xqa = Gja(Fwa, fma);
		var yqa = null;
		while (Fwa != null) {
			if (Iza > Vla) {
				if (yba) {
					throw "Full selection will not be spoken due to its length.";
				} else {
					Jua("Full selection will not be spoken due to its length.");
				}
				return;
			}
			if (Nla(Fwa)) {
				if (kla.length > 0) {
					if (bla(kla)) {
						p_wordNodes[Iza++] = new Cla(new yia(bod, xqa, yqa),
								dla(kla));
					}
					kla = "";
				}
				var vla = aoa(Fwa);
				if (vla.length > 0 && bla(vla)) {
					if (Rla(Fwa)) {
						var ysa = Nma(Fwa, false);
						var Hwa = Pma(Fwa, false);
						if (ysa != null && ysa.nodeType == 3 && Hwa != null
								&& Hwa.nodeType == 3) {
							xqa = Gja(ysa, 0);
							yqa = Gja(Hwa, Hwa.nodeValue.length);
						}
						p_wordNodes[Iza++] = new Cla(new yia(bod, xqa, yqa),
								dla(vla));
					} else {
						xqa = Gja(Fwa, -1);
						p_wordNodes[Iza++] = new Cla(new yia(bod, xqa, xqa),
								dla(vla));
					}
					kla = "";
				}
				xqa = null;
				yqa = null;
				Fwa = Mma(Fwa, false, loa);
			} else if (Fwa.nodeType == 1) {
				nla = Ima(Fwa, true, loa);
				if (nla == null) {
					if (kla.length > 0) {
						if (bla(kla)) {
							p_wordNodes[Iza++] = new Cla(
									new yia(bod, xqa, yqa), dla(Yla(kla)));
						}
						kla = "";
						xqa = null;
						yqa = null;
					}
					Fwa = Ima(Fwa, false, loa);
				} else {
					Fwa = nla;
				}
			} else if (Fwa.nodeType == 3) {
				var vla = aoa(Fwa);
				if (vla == null) {
					vla = "";
				}
				var hCb = 0;
				if (loa == Fwa && oma > -1) {
					vla = vla.substring(0, oma);
				}
				if (koa == Fwa && fma > 0) {
					vla = vla.substring(fma);
					hCb = fma;
				}
				if (vla.length == 0 && kla.length == 0) {
					xqa = null;
				} else {
					if (xqa == null || kla.length == 0) {
						xqa = Gja(Fwa, hCb);
					}
					var nCb = Dma(vla);
					while (nCb > -1) {
						if (nCb == 0) {
							if (kla.length > 0) {
								if (bla(kla)) {
									if (yqa == null) {
										yqa = Gja(Fwa, hCb);
									}
									var Fxa = new yia(bod, xqa, yqa);
									p_wordNodes[Iza++] = new Cla(Fxa, dla(kla));
								}
								kla = "";
								++hCb;
								vla = vla.substr(1);
							} else {
								vla = vla.substr(1);
								++hCb;
							}
						} else {
							var zla = kla + vla.substring(0, nCb + 1);
							if (bla(zla)) {
								yqa = Gja(Fwa, nCb + hCb);
								var Fxa = new yia(bod, xqa, yqa);
								p_wordNodes[Iza++] = new Cla(Fxa, dla(zla));
								if (Iza > Vla) {
									if (yba) {
										throw "Full selection will not be spoken due to its length.";
									} else {
										Jua("Full selection will not be spoken due to its length.");
									}
									return;
								}
							}
							kla = "";
							hCb += nCb + 1;
							vla = vla.substring(nCb + 1);
						}
						xqa = Gja(Fwa, hCb);
						yqa = null;
						nCb = Dma(vla);
					}
					if (vla.length > 0) {
						kla += vla;
						yqa = Gja(Fwa, vla.length + hCb);
						if (yqa == null) {
							kla = "";
						}
					}
					if (Fwa == loa) {
						if (kla.length > 0) {
							var Fxa = new yia(bod, xqa, yqa);
							if (bla(kla)) {
								p_wordNodes[Iza++] = new Cla(Fxa, dla(kla));
							}
						}
						return;
					}
				}
				nla = Ima(Fwa, true, loa);
				if (nla == null) {
					if (kla.length > 0) {
						if (bla(kla)) {
							p_wordNodes[Iza++] = new Cla(
									new yia(bod, xqa, yqa), dla(Yla(kla)));
						}
						kla = "";
						xqa = null;
						yqa = null;
					}
					Fwa = Ima(Fwa, false, loa);
				} else {
					Fwa = nla;
				}
			} else {
				nla = Ima(Fwa, true, loa);
				if (nla == null) {
					if (kla.length > 0) {
						if (bla(kla)) {
							p_wordNodes[Iza++] = new Cla(
									new yia(bod, xqa, yqa), dla(Yla(kla)));
						}
						kla = "";
						xqa = null;
						yqa = null;
					}
					Fwa = Ima(Fwa, false, loa);
				} else {
					Fwa = nla;
				}
			}
		}
	} catch (err) {
		cta("err rw_getTextOverRangeToSpeakImpl:" + err.message);
	}
};
function Dma(p_txt) {
	if (p_txt == null || p_txt.length == 0) {
		return -1;
	}
	var nCb = p_txt.search("\\s");
	return nCb;
};
function Fma(p_node, p_bGoByStyle, p_endNode) {
	if (p_node == null || p_node == p_endNode) {
		return null;
	}
	var koa = p_node;
	if (koa.previousSibling != null) {
		koa = koa.previousSibling;
		if (p_bGoByStyle) {
			if (!Moa(koa)) {
				return null;
			}
		}
		if (p_endNode == koa) {
			if (Poa(p_endNode)) {
				return null;
			} else {
				return p_endNode;
			}
		}
		if (koa != null && Poa(koa)) {
			koa = Fma(koa, p_bGoByStyle, p_endNode);
		} else {
			while (koa != null && koa.lastChild != null) {
				koa = koa.lastChild;
				if (p_bGoByStyle) {
					if (Moa(koa) == false) {
						koa = null;
					}
				}
				if (p_endNode == koa) {
					if (Poa(p_endNode)) {
						koa = null;
					}
					break;
				} else if (koa != null && Poa(koa)) {
					koa = Fma(koa, p_bGoByStyle, p_endNode);
					break;
				}
			}
		}
	} else {
		koa = koa.parentNode;
		if (p_bGoByStyle) {
			if (!Moa(koa)) {
				koa = null;
			}
		}
	}
	return koa;
};
function Ima(p_node, p_bGoByStyle, p_endNode) {
	if (p_node == null) {
		return null;
	}
	var Sma = Poa(p_node);
	var loa = p_node;
	if (loa.firstChild != null && !Sma) {
		loa = loa.firstChild;
	} else if (loa.nextSibling != null) {
		if (p_node == p_endNode) {
			loa = null;
		} else {
			loa = loa.nextSibling;
		}
	} else {
		if (p_node == p_endNode) {
			loa = null;
		} else {
			while (loa != null && loa.nextSibling == null) {
				loa = loa.parentNode;
				if (p_bGoByStyle) {
					if (Moa(loa) == false) {
						loa = null;
					}
				}
				if (p_endNode == loa) {
					break;
				}
			}
			if (loa != null && p_endNode != loa) {
				loa = loa.nextSibling;
			}
		}
	}
	if (loa != null) {
		if (p_bGoByStyle) {
			if (Moa(loa) == false) {
				loa = null;
			}
		}
	}
	if (loa != null && Poa(loa)) {
		if (loa != p_endNode) {
			loa = Ima(loa, p_bGoByStyle, p_endNode);
		} else {
			loa = null;
		}
	}
	return loa;
};
function Kma(p_node, p_bGoByStyle, p_endNode) {
	if (p_node == null || p_node == p_endNode) {
		return null;
	}
	var koa = p_node;
	if (koa.previousSibling != null) {
		koa = koa.previousSibling;
		if (p_bGoByStyle) {
			if (!Moa(koa)) {
				koa = null;
			}
		}
		if (koa != null && Poa(koa)) {
			if (p_endNode == koa) {
				koa = null;
			} else {
				koa = Kma(koa, p_bGoByStyle, p_endNode);
			}
		}
	} else {
		koa = koa.parentNode;
		if (p_bGoByStyle) {
			if (!Moa(koa)) {
				koa = null;
			}
		}
	}
	return koa;
};
function Mma(p_node, p_bGoByStyle, p_endNode) {
	if (p_node == null || p_node == p_endNode) {
		return null;
	}
	var loa = p_node;
	if (loa.nextSibling != null) {
		loa = loa.nextSibling;
	} else {
		while (loa != null && loa.nextSibling == null) {
			loa = loa.parentNode;
			if (p_bGoByStyle) {
				if (Moa(loa) == false) {
					loa = null;
				}
			}
			if (p_endNode == loa) {
				break;
			}
		}
		if (loa != null && loa != p_endNode) {
			loa = loa.nextSibling;
		}
	}
	if (loa != null) {
		if (p_bGoByStyle) {
			if (Moa(loa) == false) {
				loa = null;
			}
		}
	}
	if (loa != null && Poa(loa)) {
		if (loa == p_endNode) {
			loa = null;
		} else {
			loa = Mma(loa, p_bGoByStyle, p_endNode);
		}
	}
	return loa;
};
function Nma(p_node, p_bAllowImg) {
	if (p_node == null) {
		return null;
	}
	if (p_node.firstChild == null) {
		return p_node;
	}
	if (p_node.nodeType == 1 && p_node.tagName.toLowerCase() == "textarea") {
		return p_node;
	} else {
		var qza = p_node.firstChild;
		if (qza.nodeType == 3) {
			return qza;
		} else if (p_bAllowImg && qza.tagName.toLowerCase() == "img"
				&& qza.getAttribute("msg") != null
				&& qza.getAttribute("msg").length > 0) {
			return qza;
		} else {
			if (p_bAllowImg) {
				return Hna(qza, false, p_node);
			} else {
				return Nna(qza, false, p_node, true);
			}
		}
	}
}
function Pma(p_node, p_bAllowImg) {
	if (p_node == null) {
		return null;
	}
	if (p_node.nodeType == 1 && p_node.tagName.toLowerCase() == "textarea") {
		return p_node;
	}
	var qza = p_node.lastChild;
	while (qza != null) {
		if (qza.nodeType == 3) {
			return qza;
		} else if (p_bAllowImg && qza.tagName.toLowerCase() == "img"
				&& qza.getAttribute("msg") != null
				&& qza.getAttribute("msg").length > 0) {
			return qza;
		} else if (Poa(qza)) {
			var TBb;
			if (p_bAllowImg) {
				TBb = yma(qza, false, p_node);
			} else {
				TBb = Ena(qza, false, p_node, true);
			}
			return TBb;
		} else {
			qza = qza.lastChild;
		}
	}
	return p_node;
}
function Wma(jqa) {
	var Sma = Poa(jqa);
	var loa = jqa;
	if (loa.firstChild != null && !Sma) {
		loa = loa.firstChild;
	} else if (loa.nextSibling != null) {
		var Fwa = loa;
		loa = loa.nextSibling;
		var qza = loa;
		var bod = qza.ownerDocument.body;
		while (qza != null && qza != bod) {
			if (qza == Fwa) {
				throw "DOM Error";
			}
			qza = qza.parentNode;
		}
	} else {
		while (loa != null && loa.nextSibling == null) {
			loa = loa.parentNode;
		}
		if (loa != null) {
			var Fwa = loa;
			loa = loa.nextSibling;
			var qza = loa;
			var bod = qza.ownerDocument.body;
			while (qza != null && qza != bod) {
				if (qza == Fwa) {
					throw "DOM Error";
				}
				qza = qza.parentNode;
			}
		}
	}
	if (loa != null && Poa(loa)) {
		loa = Wma(loa);
	}
	return loa;
};
function bma(p_thCaret) {
	var node = p_thCaret.node;
	var hCb = p_thCaret.offset;
	var lma = aoa(node);
	if (lma == null) {
		lma = "";
	}
	lma = lma.replace(/[\x21\x3f\x3a]/, ".");
	if (lma.length == 0) {
		hCb = 0;
		lma = " ";
	}
	if ((lma.length + 1) < hCb) {
		hCb = 0;
	}
	var pma = node;
	var qma = hCb;
	var koa = node;
	var fma = hCb;
	var Voa = false;
	var sma = lma.charAt(hCb);
	var tma = true;
	while (!Voa) {
		var txt;
		if (tma) {
			if (hCb > 0) {
				txt = lma.substring(0, hCb);
			} else {
				txt = "";
			}
		} else {
			txt = aoa(koa);
		}
		tma = false;
		if (txt.length > 0) {
			if (fma == -1) {
				fma = txt.length;
			}
			txt = txt.replace(/[\x21\x3f\x3a]/, ".");
			if (koa.nodeType == 3) {
				var nCb = txt.lastIndexOf(".", fma);
				if (nCb > -1) {
					if (dga(txt, nCb)) {
						if (nCb < txt.length - 1) {
							sma = txt.charAt(nCb + 1);
							if (Bua(sma)) {
								pma = koa;
								qma = nCb + 1;
								Voa = true;
								break;
							}
						} else {
							if (Bua(sma)) {
								Voa = true;
								break;
							}
						}
					}
				}
			}
			if (koa.nodeType == 3) {
				if (koa.nodeValue.trimTH().length > 0) {
					pma = koa;
					qma = 0;
				}
			} else {
				if (Nla(koa)) {
					pma = koa;
					qma = 0;
				}
			}
			sma = txt.charAt(0);
		}
		koa = Fma(koa, true, null);
		fma = -1;
		if (koa == null) {
			Voa = true;
			break;
		}
	}
	if (pma.nodeType == 3) {
		var txt = pma.nodeValue;
		if (qma < txt.length) {
			while (qma < txt.length) {
				if (Bua(txt.charAt(qma))) {
					++qma;
				} else {
					break;
				}
			}
		}
	}
	return new THCaret(pma, qma);
}
function mma(p_thCaret) {
	var node = p_thCaret.node;
	var hCb = p_thCaret.offset;
	var lma = aoa(node);
	if (lma == null) {
		lma = "";
	}
	lma = lma.replace(/[\x21\x3f\x3a]/, ".");
	if (lma.length == 0) {
		hCb = 0;
		lma = " ";
	}
	if ((lma.length + 1) < hCb) {
		hCb = 0;
	}
	var loa = node;
	var oma = hCb;
	var pma = node;
	var qma = hCb + 1;
	var Voa = false;
	var sma = lma.charAt(hCb);
	if (sma == '.' && !dga(lma, hCb)) {
		sma = ' ';
	}
	var tma = true;
	while (!Voa) {
		var txt;
		if (tma) {
			if (hCb < lma.length) {
				txt = lma;
			} else {
				txt = "";
			}
		} else {
			txt = aoa(loa);
		}
		tma = false;
		if (txt.length > 0) {
			if (oma == -1) {
				oma = 0;
			}
			if (loa.nodeType == 3) {
				if (sma == '.') {
					var uma = txt.charAt(oma);
					if (Bua(uma)) {
						Voa = true;
						break;
					}
				}
				txt = txt.replace("[\\x21\\x3f\\x3a]", ".");
				var nCb = txt.indexOf(".", oma);
				if (nCb > -1) {
					if (dga(txt, nCb)) {
						if (nCb < txt.length - 1) {
							sma = txt.charAt(nCb + 1);
							if (Bua(sma)) {
								pma = loa;
								qma = nCb + 1;
								Voa = true;
								break;
							}
						}
					}
				}
			}
			if (loa.nodeType == 3) {
				if (loa.nodeValue.trimTH().length > 0) {
					pma = loa;
					qma = loa.length;
				}
			} else {
				if (Nla(loa)) {
					pma = loa;
					qma = 0;
				}
			}
			sma = txt.charAt(txt.length - 1);
		}
		loa = Ima(loa, true, null);
		oma = -1;
		if (loa == null) {
			Voa = true;
			break;
		}
	}
	if (pma.nodeType == 3) {
		var txt = pma.nodeValue;
		if (qma > 0 && qma <= txt.length) {
			while (qma > 0) {
				if (Bua(txt.charAt(qma - 1))) {
					--qma;
				} else {
					break;
				}
			}
		}
	}
	return new THCaret(pma, qma);
}
function yma(p_node, p_bGoByStyle, p_endNode) {
	var koa = p_node;
	var epa = false;
	while (koa != null && koa != p_endNode) {
		koa = Fma(koa, p_bGoByStyle, p_endNode);
		if (koa != null) {
			if (koa.nodeType == 3
					&& koa.parentNode.tagName.toLowerCase() != "textarea") {
				epa = true;
			} else if (koa.nodeType == 1 && koa.tagName.toLowerCase() == "img") {
				var eoa = koa.getAttribute("msg");
				if (eoa != null && eoa.length > 0) {
					epa = true;
				}
			}
			if (epa) {
				return koa;
			}
		}
	}
	return null;
}
function Cna(p_node, p_bGoByStyle, p_endNode) {
	var koa = p_node;
	while (koa != null && koa != p_endNode) {
		koa = yma(koa, p_bGoByStyle, p_endNode);
		if (koa != null) {
			var Kna = (koa.nodeType == 3) ? koa.nodeValue.trimTH() : koa
					.getAttribute("msg").trimTH();
			if (bla(Kna)) {
				return koa;
			}
		}
	}
	return null;
}
function Ena(p_node, p_bGoByStyle, p_endNode, p_bIncludeBlanks) {
	var koa = (p_bIncludeBlanks) ? yma(p_node, p_bGoByStyle, p_endNode) : Cna(
			p_node, p_bGoByStyle, p_endNode);
	while (koa != null && koa.nodeType != 3 && koa != p_endNode) {
		koa = (p_bIncludeBlanks) ? yma(koa, p_bGoByStyle, p_endNode) : Cna(koa,
				p_bGoByStyle, p_endNode);
	}
	return koa;
}
function Hna(p_node, p_bGoByStyle, p_endNode) {
	var loa = p_node;
	var epa = false;
	while (loa != null && loa != p_endNode) {
		loa = Ima(loa, p_bGoByStyle, p_endNode);
		if (loa != null) {
			if (loa.nodeType == 3
					&& loa.parentNode.tagName.toLowerCase() != "textarea") {
				epa = true;
			} else if (loa.nodeType == 1 && loa.tagName.toLowerCase() == "img") {
				var eoa = loa.getAttribute("msg");
				if (eoa != null && eoa.length > 0) {
					epa = true;
				}
			}
			if (epa) {
				return loa;
			}
		}
	}
	return null;
}
function Lna(p_node, p_bGoByStyle, p_endNode) {
	var loa = p_node;
	while (loa != null && loa != p_endNode) {
		loa = Hna(loa, p_bGoByStyle, p_endNode);
		if (loa != null) {
			var Kna = (loa.nodeType == 3) ? loa.nodeValue.trimTH() : loa
					.getAttribute("msg").trimTH();
			if (bla(Kna)) {
				return loa;
			}
		}
	}
	return null;
}
function Nna(p_node, p_bGoByStyle, p_endNode, p_bIncludeBlanks) {
	var loa = (p_bIncludeBlanks) ? Hna(p_node, p_bGoByStyle, p_endNode) : Lna(
			p_node, p_bGoByStyle, p_endNode);
	while (loa != null && loa.nodeType != 3 && loa != p_endNode) {
		loa = (p_bIncludeBlanks) ? Hna(loa, p_bGoByStyle, p_endNode) : Lna(loa,
				p_bGoByStyle, p_endNode);
	}
	return loa;
}
function Rna(p_body) {
	var ena = Nma(p_body, true);
	var oza = new THCaret(ena, 0);
	var pza = mma(oza);
	oza = bma(pza);
	return new Zia(oza, pza);
}
function Vna(p_body) {
	var ena = Pma(p_body, true);
	var pza;
	if (ena.nodeType == 3) {
		pza = new THCaret(ena, ena.nodeValue.length);
	} else {
		pza = new THCaret(ena, -1);
	}
	var oza = bma(pza);
	pza = mma(oza);
	return new Zia(oza, pza);
}
function Yna(p_thCaret) {
	var pza = mma(p_thCaret);
	var oza = bma(pza);
	return new Zia(oza, pza);
}
function gna(p_caretRange) {
	var Fwa = p_caretRange.pza.node;
	var jna = p_caretRange.pza.offset;
	var pza;
	var oza;
	while (Fwa != null) {
		if (Fwa.nodeType != 3) {
			var ena = Lna(Fwa, false, null);
			if (ena == null) {
				return null;
			}
			pza = mma(new THCaret(ena, 0));
		} else {
			if (jna >= Fwa.nodeValue.length - 1) {
				var ena = Lna(Fwa, false, null);
				if (ena == null) {
					return null;
				}
				pza = mma(new THCaret(ena, 0));
			} else {
				pza = mma(new THCaret(Fwa, jna + 2));
			}
		}
		oza = bma(pza);
		if (oza == null) {
			return null;
		}
		if (p_caretRange.oza.node != oza.node
				|| p_caretRange.oza.offset != oza.offset) {
			return new Zia(oza, pza);
		}
		Fwa = pza.node;
		if (Fwa.nodeType == 3) {
			var Kta = Fwa.nodeValue.replace("[\\x21\\x3f\\x3a]", ".");
			var ona = Kta.indexOf(".", pza.offset + 1);
			if (ona == -1) {
				jna = Kta.length;
			} else {
				jna = ona;
			}
		}
	}
	return null;
}
function nna(p_caretRange) {
	var Fwa = p_caretRange.oza.node;
	var jna = p_caretRange.oza.offset;
	var oza;
	var pza;
	while (Fwa != null) {
		if (Fwa.nodeType == 3) {
			var Kta = Fwa.nodeValue.replace("[\\x21\\x3f\\x3a]", ".");
			var ona;
			if (jna > 0) {
				ona = Kta.lastIndexOf(".", jna);
			} else if (jna == 0) {
				ona = -1;
			} else {
				ona = Kta.lastIndexOf(".");
			}
			while (ona > -1) {
				jna = ona;
				pza = mma(new THCaret(Fwa, jna));
				if (pza == null) {
					return null;
				}
				if (pza.node != p_caretRange.pza.node
						|| pza.offset != p_caretRange.pza.offset) {
					oza = bma(pza);
					if (oza == null) {
						return null;
					}
					return new Zia(oza, pza);
				}
				ona = Kta.lastIndexOf(".", ona - 1);
			}
		}
		jna = -1;
		qza = Ena(Fwa, true, null, false);
		if (qza != null) {
			Fwa = qza;
		} else {
			Fwa = Ena(Fwa, false, null, false);
			if (Fwa != null) {
				pza = mma(new THCaret(Fwa, Fwa.nodeValue.length));
				if (pza.node != p_caretRange.pza.node
						|| pza.offset != p_caretRange.pza.offset) {
					oza = bma(pza);
					return new Zia(oza, pza);
				}
			}
		}
	}
	return null;
}
function sna(p_node) {
	var tna;
	var una = p_node;
	var TBb = Fma(p_node, true, null);
	while (TBb != null) {
		tna = false;
		if (TBb.nodeType == 1) {
			if (Nla(TBb)) {
				if (TBb.getAttribute("ignore") != null) {
					tna = true;
				}
			} else {
				tna = true;
			}
		} else if (TBb.nodeType == 3) {
			if (TBb.nodeValue.trimTH().length == 0) {
				tna = true;
			}
		}
		if (!tna) {
			una = TBb;
		}
		TBb = Fma(TBb, true, null);
	}
	return una;
}
function wna(p_node) {
	var tna;
	var una = p_node;
	var lqa = Ima(p_node, true, null);
	while (lqa != null) {
		tna = false;
		if (lqa.nodeType == 1) {
			if (Nla(lqa)) {
				if (lqa.getAttribute("ignore") != null) {
					tna = true;
				}
			} else {
				tna = true;
			}
		} else if (lqa.nodeType == 3) {
			if (lqa.nodeValue.trimTH().length == 0) {
				tna = true;
			}
		}
		if (!tna) {
			una = lqa;
		}
		lqa = Ima(lqa, true, null);
	}
	return una;
}
function Aoa(p_node, p_nPos) {
	if (p_node == null || p_node.nodeType != 3 || p_node.parentNode == null) {
		return p_node;
	}
	var xna = 0;
	var nBb = p_node.parentNode;
	var zna = nBb.parentNode;
	if (zna != null && nBb.tagName.toLowerCase() == "span"
			&& zna.tagName.toLowerCase() == "span"
			&& nBb.getAttribute(caa) != null
			&& (zna.getAttribute(caa) != null || zna.getAttribute(daa) != null)) {
		xna = 2;
	} else if (nBb.tagName.toLowerCase() == "span"
			&& (nBb.getAttribute(caa) != null || nBb.getAttribute(daa) != null)) {
		xna = 1;
	}
	if (p_node.nodeValue.length == 0 || p_nPos <= 0
			|| p_nPos >= p_node.nodeValue.length) {
		if (xna == 0) {
			var span = document.createElement("span");
			span.setAttribute(caa, "1");
			var Goa = document.createElement("span");
			Goa.setAttribute(caa, "1");
			nBb.insertBefore(span, p_node);
			span.appendChild(Goa);
			Goa.appendChild(p_node);
		} else if (xna == 1) {
			var span = document.createElement("span");
			span.setAttribute(caa, "1");
			nBb.insertBefore(span, p_node);
			span.appendChild(p_node);
		}
		return p_node;
	}
	var txt = p_node.nodeValue;
	var Eoa = txt.substring(0, p_nPos);
	var Foa = txt.substring(p_nPos);
	var Goa = document.createElement("span");
	var Hoa = document.createElement("span");
	var Ioa = document.createTextNode(Eoa);
	var Joa = document.createTextNode(Foa);
	Goa.appendChild(Ioa);
	Hoa.appendChild(Joa);
	Goa.setAttribute(caa, "1");
	Hoa.setAttribute(caa, "1");
	if (xna == 2) {
		zna.insertBefore(Hoa, nBb);
		zna.insertBefore(Goa, Hoa);
		zna.removeChild(nBb);
	} else if (xna == 1) {
		nBb.insertBefore(Goa, p_node);
		nBb.insertBefore(Hoa, p_node);
		nBb.removeChild(p_node);
	} else {
		var span = document.createElement("span");
		span.setAttribute(caa, "1");
		span.appendChild(Goa);
		span.appendChild(Hoa);
		nBb.insertBefore(span, p_node);
		nBb.removeChild(p_node);
	}
	return Joa;
}
function Moa(p_node) {
	if (p_node.nodeType != 1) {
		if (p_node.nodeType == 3) {
			return true;
		} else {
			return false;
		}
	}
	var VBb = p_node.tagName.toLowerCase().trimTH();
	if (VBb == "font") {
		var vBb = p_node.getAttribute("started");
		if (vBb != null && vBb == "1") {
			return false;
		}
	}
	if (VBb == "em" || VBb == "strong" || VBb == "b" || VBb == "i"
			|| VBb == "u" || VBb == "tt" || VBb == "font" || VBb == "kbd"
			|| VBb == "dfn" || VBb == "cite" || VBb == "sup" || VBb == "sub"
			|| VBb == "a" || VBb == "embed" || VBb == "span" || VBb == "small"
			|| VBb == "nobr" || VBb == "wbr" || VBb == "acronym"
			|| VBb == "abbr" || VBb == "code" || VBb == "chunk" || VBb == "th"
			|| VBb == "th:pron" || VBb == "img" || VBb == "/th:pron"
			|| VBb == "w" || VBb == "/w" || VBb == "lic" || VBb == "/lic") {
		return true;
	}
	return false;
};
function Poa(p_node) {
	if (p_node == null) {
		return true;
	}
	if (p_node.nodeType != 1) {
		return p_node.nodeType != 3;
	}
	var Zva = p_node.getAttribute("ignore");
	if (Zva != null) {
		return true;
	}
	var VBb = p_node.tagName.toLowerCase();
	return VBb == "link" || VBb == "area" || VBb == "script"
			|| VBb == "noscript" || VBb == "annotation" || VBb == "style"
			|| VBb == "!--" || VBb == "title";
};
function Soa(jqa) {
	if (jqa.nodeType != 1) {
		return false;
	}
	var VBb = jqa.tagName.toLowerCase().trimTH();
	if (VBb == "p" || VBb == "br" || VBb == "head" || VBb == "body"
			|| VBb == "hr" || VBb == "div" || VBb == "h1" || VBb == "h2"
			|| VBb == "h3" || VBb == "h4" || VBb == "h5" || VBb == "h6"
			|| VBb == "blockquote" || VBb == "table" || VBb == "tbody"
			|| VBb == "tr" || VBb == "td" || VBb == "th") {
		return true;
	}
	return false;
};
function Toa(p_node) {
	var txt = "";
	if (p_node.nodeType == 3) {
		if (Poa(p_node.parentNode) == false
				&& p_node.parentNode.tagName.toLowerCase() != "textarea") {
			txt = p_node.nodeValue;
		}
	} else if (p_node.nodeType == 1) {
		if (p_node.getAttribute("ignore") != null) {
			txt = "";
			Voa = true;
		} else {
			var Nua = p_node.tagName.toLowerCase();
			var Voa = false;
			if (Nua == "img") {
				var eoa = p_node.getAttribute("msg");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = " " + eoa.trimTH() + " ";
				}
				Voa = true;
			} else if (Nua == "span") {
				var eoa = p_node.getAttribute("pron");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = eoa.trimTH();
					Voa = true;
				}
			} else if (Nua == "acronym" || Nua == "abbr") {
				var eoa = p_node.getAttribute("title");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = eoa.trimTH();
					Voa = true;
				}
			}
		}
		if (Voa == false) {
			var Lua = p_node.firstChild;
			while (Lua != null) {
				txt += Toa(Lua);
				Lua = Lua.nextSibling;
			}
		}
	}
	return txt;
}
function aoa(p_node) {
	var txt = "";
	if (p_node.nodeType == 3) {
		if (Poa(p_node.parentNode) == false
				&& p_node.parentNode.tagName.toLowerCase() != "textarea") {
			txt = p_node.nodeValue;
		}
	} else if (p_node.nodeType == 1) {
		if (p_node.getAttribute("ignore") != null) {
			txt = "";
		} else {
			var Nua = p_node.tagName.toLowerCase();
			if (Nua == "img") {
				var eoa = p_node.getAttribute("msg");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = " " + eoa.trimTH() + " ";
				}
			} else if (Nua == "span") {
				var eoa = p_node.getAttribute("pron");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = eoa.trimTH();
				}
			} else if (Nua == "acronym" || Nua == "abbr") {
				var eoa = p_node.getAttribute("title");
				if (eoa != null && eoa.trimTH().length > 0) {
					txt = eoa.trimTH();
				}
			}
		}
	}
	return txt;
}
function rw_getTextOverRange(p_body, p_domRefLeft, p_domRefRight) {
	try {
		if (p_domRefLeft == null || p_domRefRight == null) {
			return "";
		}
		var OAb = mpa(p_body, p_domRefLeft.path, p_domRefLeft.offset,
				p_domRefRight.path, p_domRefRight.offset);
		return rw_getTextOverCaretRange(OAb);
	} catch (err) {
		cta("err rw_getTextOverRange:" + "|" + err.message);
		return "";
	}
}
function rw_getTextOverCaretRange(p_thCaretRange) {
	try {
		if (p_thCaretRange == null || p_thCaretRange.oza == null
				|| p_thCaretRange.pza == null) {
			return "";
		}
		var oza = p_thCaretRange.oza;
		var pza = p_thCaretRange.pza;
		var koa = oza.node;
		var loa = pza.node;
		var Fwa = koa;
		var txt = "";
		while (Fwa != null) {
			var tmp = aoa(Fwa);
			if (tmp != null && tmp != "") {
				if (Fwa == loa) {
					tmp = tmp.substring(0, pza.offset);
				}
				if (Fwa == koa) {
					tmp = tmp.substring(oza.offset);
				}
				txt += tmp;
			}
			Fwa = Hna(Fwa, false, loa);
		}
		return txt.trimTH();
	} catch (err) {
		cta("err rw_getTextOverCaretRange:" + "|" + err.message);
		return "";
	}
}
function qoa(jqa) {
	var Mua = null;
	var Nua = jqa.tagName.toLowerCase();
	var ECb = Jpa(jqa);
	if (Nua == "input") {
		var Qua = jqa.getAttribute("type");
		if (Qua != null) {
			Qua = Qua.toLowerCase();
		}
		var Xua = "";
		if (Qua == null || Qua.equalsTH("") || Qua.equalsTH("text")) {
			Xua = jqa.value;
		} else if (Qua.equalsTH("password")) {
			Xua = "Masked password field";
		} else if (Qua.equalsTH("image")) {
			Xua = "";
		} else if (Qua.equalsTH("button") || Qua.equalsTH("submit")
				|| Qua.equalsTH("reset")) {
			Xua = jqa.getAttribute("value");
		}
		if (Xua.equalsTH("") == false) {
			Mua = "form:" + ECb + ";" + Xua;
		}
	} else if (Nua == "select") {
		var Xua = "";
		var Tua = jqa.selectedIndex;
		var Uua = "";
		for ( var Iza = 0; Iza < jqa.options.length; Iza++) {
			Uua += jqa.options[Iza].text + " ";
		}
		if (Uua.equalsTH("") == false) {
			if (Tua > -1) {
				Xua = jqa.options[Tua].text;
				Xua += " selected from the list " + Uua;
			} else {
				Xua = "No selection from the list " + Uua;
			}
			Mua = "form" + ECb + ";" + Xua;
		}
	} else if (Nua == "textarea") {
		var Xua = jqa.value;
		Mua = "form" + ECb + ";" + Xua;
	} else if (Nua == "option") {
		var Xua = jqa.value;
		Mua = "form" + ECb + ";" + Xua;
	}
	return Mua;
}
function Apa(evt) {
	var Cpa;
	if (cda) {
		Cpa = evt.srcElement;
	} else if (dda) {
		Cpa = evt.target;
	} else {
		Cpa = evt.target;
	}
	return Cpa;
}
function Epa(evt) {
	var iCb = null;
	var Cpa;
	var Dpa = 0;
	if (cda) {
		Cpa = evt.srcElement;
		if (Cpa.nodeType == 1 && Cpa.tagName.toLowerCase() == "textarea") {
		} else {
			iCb = rw_getTargetNodeAsCaretIE(evt);
			if (iCb != null) {
				if (iCb.node == null || iCb.node.parentNode == null
						|| iCb.node.parentNode != Cpa) {
					iCb = null;
					return null;
				}
			}
		}
	} else if (dda) {
		Cpa = evt.target;
		if (Cpa != null) {
			if (Cka) {
				if (Cpa.firstChild != null && Cpa.firstChild.nodeType == 3
						&& Cpa.tagName.toLowerCase() != "textarea") {
					var Gpa = Cpa.firstChild.nodeValue;
					if (Gpa.trimTH().length > 0) {
						Cpa = Cpa.firstChild;
					}
				}
			} else if (Bka) {
				if (evt.fromElement != null && Cpa.nodeType == 1
						&& Cpa.tagName.toLowerCase() != "textarea") {
					if (evt.fromElement.nodeType == 3) {
						Cpa = evt.fromElement;
					}
				} else {
					if (Cpa.nodeType == 1 && Cpa.firstChild != null
							&& Cpa.firstChild.nodeType == 3
							&& Cpa.tagName.toLowerCase() != "textarea") {
						var Gpa = Cpa.firstChild.nodeValue;
						if (Gpa.trimTH().length > 0) {
							Cpa = Cpa.firstChild;
						}
					}
				}
			}
		}
	} else {
		if (evt.explicitOriginalTarget.nodeValue != null) {
			if (evt.target.tagName.toLowerCase() == "textarea") {
				Cpa = evt.target;
			} else {
				Cpa = evt.explicitOriginalTarget;
				var Tta = window.getSelection();
				if (Tta.anchorNode == null || Tta.anchorNode != Cpa) {
					return null;
				} else {
					iCb = new THCaret(Tta.anchorNode, Tta.anchorOffset);
				}
			}
		} else {
			Cpa = evt.target;
		}
	}
	if (iCb == null && Cpa != null) {
		iCb = new THCaret(Cpa, 0);
	}
	return iCb;
}
function Jpa(p_theNode) {
	var ECb = "";
	var Kpa = 0;
	var Lpa = "";
	if (p_theNode != null && p_theNode.ownerDocument != null) {
		var Ypa = false;
		var Xpa = false;
		var bod = p_theNode.ownerDocument.body;
		while (p_theNode != null && p_theNode != bod) {
			if (Nla(p_theNode)) {
				ECb = "";
			}
			Ypa = p_theNode.nodeType == 3;
			var jqa = p_theNode.previousSibling;
			while (jqa != null) {
				Xpa = (jqa.nodeType == 3);
				if (Ypa && Xpa) {
				} else {
					++Kpa;
				}
				jqa = jqa.previousSibling;
				Ypa = Xpa;
			}
			ECb = ECb + Kpa + "~";
			Kpa = 0;
			p_theNode = p_theNode.parentNode;
			if (p_theNode != null && p_theNode.getAttribute != null
					&& p_theNode.tagName != null) {
				var Ppa = p_theNode.getAttribute("chunk");
				if (p_theNode.tagName.toLowerCase() == "span" && Ppa == "1") {
					var Qpa = Jpa(p_theNode);
					Lpa = "#^th*" + Qpa + "#^th*";
				}
			}
		}
	}
	return Lpa + ECb;
};
function Spa(p_theBody, p_strPath) {
	var KBb = p_theBody;
	if (p_strPath.lastIndexOf("*") > -1) {
		var nCb = p_strPath.lastIndexOf("*");
		p_strPath = p_strPath.substring(nCb + 1);
	}
	var Upa = p_strPath.split("~");
	var SCb = Upa.length;
	var i;
	for (i = SCb - 2; i > -1; i--) {
		KBb = KBb.firstChild;
		if (KBb == null) {
			return null;
		}
		var GDb;
		if (Upa[i].length == 0) {
			GDb = 0;
		} else {
			GDb = parseInt(Upa[i]);
		}
		var Xpa = false;
		var Ypa = false;
		while (GDb > 0) {
			var qza = KBb;
			KBb = KBb.nextSibling;
			if (KBb == null) {
				return null;
			}
			Xpa = (KBb.nodeType == 3);
			if (Xpa && Ypa) {
			} else {
				--GDb;
				Ypa = KBb.nodeType == 3;
			}
		}
	}
	return KBb;
}
function jpa(p_theBody, p_strPath, p_nPos, p_bForwardBias) {
	try {
		if (p_theBody == null) {
			return null;
		}
		var KBb = Spa(p_theBody, p_strPath);
		if (Nla(KBb)) {
			if (Rla(KBb)) {
				if (p_bForwardBias) {
					var jza = Nma(KBb, false);
					if (jza != null) {
						return new THCaret(jza, 0);
					} else {
						return new THCaret(KBb, 0);
					}
				} else {
					var kza = Pma(KBb, false);
					if (kza != null) {
						if (kza.nodeType == 3) {
							return new THCaret(kza, kza.length);
						} else {
							return new THCaret(kza, 0);
						}
					} else {
						return new THCaret(KBb, 0);
					}
				}
			} else {
				return new THCaret(KBb, 0);
			}
		}
		var hCb = 0;
		if (p_bForwardBias == false) {
			++hCb;
		}
		if (p_nPos > -1) {
			if (KBb == null) {
				return null;
			}
			var epa = false;
			var kza = KBb.parentNode;
			var gpa = KBb;
			var Kta;
			while (epa == false) {
				if (KBb.nodeType == 3) {
					Kta = KBb.nodeValue;
					if (p_nPos < (hCb + Kta.length)) {
						epa = true;
						break;
					}
					gpa = KBb;
					hCb += KBb.nodeValue.length;
				} else if (KBb.nodeType == 1) {
					if (Nla(KBb)) {
						var ipa = p_nPos - hCb;
						if (ipa > 0) {
							hCb += 1;
						} else {
							epa = true;
							break;
						}
					}
				}
				KBb = Hna(KBb, false, kza);
				if (KBb == null || KBb == kza) {
					if (gpa != null) {
						KBb = gpa;
						if (KBb.nodeType == 3) {
							hCb = p_nPos - KBb.nodeValue.length;
						} else {
							hCb = 0;
						}
						if (!p_bForwardBias) {
							++hCb;
						}
						break;
					} else {
						return null;
					}
				}
			}
			if (p_bForwardBias) {
				return new THCaret(KBb, p_nPos - hCb);
			} else {
				return new THCaret(KBb, p_nPos - (hCb - 1));
			}
		} else {
			return new THCaret(KBb, p_nPos);
		}
	} catch (err) {
		cta("getCaretFromDomPosition error");
		return null;
	}
}
function mpa(p_theBody, p_strPathLeft, p_nPosLeft, p_strPathRight, p_nPosRight) {
	var oza = jpa(p_theBody, p_strPathLeft, p_nPosLeft, true);
	var pza;
	if (p_strPathLeft == p_strPathRight && p_nPosLeft >= p_nPosRight) {
		pza = oza;
	} else {
		pza = jpa(p_theBody, p_strPathRight, p_nPosRight, false);
	}
	return new Zia(oza, pza);
}
function rw_getDisplayWidth() {
	var nW = (window.innerWidth) ? window.innerWidth
			: document.body.offsetWidth;
	return nW;
}
function rw_getDisplayWidthAdjusted() {
	var nW = ((window.innerWidth) ? window.innerWidth
			: document.body.offsetWidth)
			- rw_getScrollBarWidth();
	return nW;
}
function rw_getDocumentDisplayWidth() {
	var nW = (window.innerWidth) ? window.innerWidth
			: document.documentElement.offsetWidth;
	return nW;
}
function rw_getDocumentDisplayWidthAdjusted() {
	var nW = ((window.innerWidth) ? window.innerWidth
			: document.documentElement.offsetWidth)
			- rw_getScrollBarWidth();
	return nW;
}
function rw_getDisplayHeight() {
	if (sda) {
		return rw_getDocumentDisplayHeight();
	} else {
		var nH = (window.innerHeight) ? window.innerHeight
				: document.body.offsetHeight;
		return nH;
	}
}
function rw_getDisplayHeightAdjusted() {
	if (sda) {
		return rw_getDocumentDisplayHeightAdjusted();
	} else {
		var nH = ((window.innerHeight) ? window.innerHeight
				: document.body.offsetHeight)
				- rw_getScrollBarHeight();
		return nH;
	}
}
function rw_getDocumentDisplayHeight() {
	var nH = (window.innerHeight) ? window.innerHeight
			: document.documentElement.offsetHeight;
	return nH;
}
function rw_getDocumentDisplayHeightAdjusted() {
	var nH = ((window.innerHeight) ? window.innerHeight
			: document.documentElement.offsetHeight)
			- rw_getScrollBarHeight();
	return nH;
}
function rw_getScreenOffsetLeft() {
	var n = (window.pageXOffset) ? window.pageXOffset
			: (document.body.scrollLeft) ? document.body.scrollLeft
					: (document.documentElement.scrollLeft) ? document.documentElement.scrollLeft
							: 0;
	return n;
}
function rw_getScreenOffsetTop() {
	var n = (window.pageYOffset) ? window.pageYOffset
			: (document.body.scrollTop) ? document.body.scrollTop
					: (document.documentElement.scrollTop) ? document.documentElement.scrollTop
							: 0;
	return n;
}
function rw_getScrollBarWidth() {
	if (cda) {
		if (sda) {
			return 20;
		} else {
			if (document.compatMode.equalsTH("CSS1Compat")) {
				return (document.documentElement.offsetWidth - document.documentElement.clientWidth);
			} else {
				return (document.body.offsetWidth - document.body.clientWidth);
			}
		}
	} else {
		if (window.scrollMaxY > 0 || dda) {
			return 18;
		} else {
			return 4;
		}
	}
}
function rw_getScrollBarHeight() {
	if (cda) {
		if (sda) {
			return 20;
		} else {
			if (document.compatMode.equalsTH("CSS1Compat")) {
				return (document.documentElement.offsetWidth - document.documentElement.clientWidth);
			} else {
				return (document.body.offsetWidth - document.body.clientWidth);
			}
		}
	} else {
		if (window.scrollMaxX > 0) {
			return 18;
		} else {
			return 4;
		}
	}
}
function Bqa() {
	var zpa = null;
	var Rta = null;
	if (window.getSelection) {
		var Tta = window.getSelection();
		var Uta = null;
		if (Tta.isCollapsed == false) {
			zpa = window;
			Uta = Tta;
		} else {
			if (gga && gga.selectionStart != gga.selectionEnd) {
				return {
					frame :window,
					range :new String(uja
							+ "0"
							+ vja
							+ gga.value.substring(gga.selectionStart,
									gga.selectionEnd) + uja + "1" + vja)
				};
			}
			if (top.window.frames.length > 0) {
				var i = 0;
				var SCb = top.window.frames.length;
				for (i = 0; i < SCb; i++) {
					var Fqa = top.window.frames[i].getSelection();
					if (Fqa != null && Fqa.isCollapsed == false) {
						zpa = top.window.frames[i];
						Uta = Fqa;
						break;
					}
				}
			}
		}
		if (Uta == null) {
			return null;
		}
		var Gqa = null;
		if (Uta.getRangeAt) {
			Gqa = Uta.getRangeAt(0);
		} else {
			var range = ata();
			if (range != null) {
				if (Uta.anchorNode == Uta.focusNode
						&& Uta.anchorOffset == Uta.focusOffset) {
					range = Hta(Uta);
				} else {
					range.setStart(Uta.anchorNode, Uta.anchorOffset);
					range.setEnd(Uta.focusNode, Uta.focusOffset);
					if (range.toString().length == 0) {
						range.setStart(Uta.focusNode, Uta.focusOffset);
						range.setEnd(Uta.anchorNode, Uta.anchorOffset);
					}
				}
				Gqa = range;
			}
		}
		if (Gqa != null) {
			var Hqa = Gqa.startContainer;
			var Iqa = Gqa.startOffset;
			var Jqa = Gqa.endContainer;
			var Kqa = Gqa.endOffset;
			if (Hqa.nodeType != 3) {
				if (Hqa.nodeType != 1) {
					return null;
				} else {
					if (Iqa > 0) {
						if (Hqa.hasChildNodes() && Hqa.childNodes.length > Iqa) {
							Hqa = Hqa.childNodes[Iqa];
							if (Hqa.nodeType == 3) {
								Iqa = 0;
							} else {
								Iqa = 0;
							}
						}
					}
				}
			}
			if (Jqa.nodeType != 3) {
				if (Jqa.nodeType != 1) {
					return null;
				} else {
					if (Kqa > 0) {
						if (Jqa.hasChildNodes() && Jqa.childNodes.length >= Kqa) {
							Jqa = Jqa.childNodes[Kqa - 1];
							if (Jqa.nodeType == 3) {
								Kqa = Jqa.nodeValue.length;
							} else {
								Kqa = 0;
							}
						}
					}
				}
			}
			Rta = new lia(Hqa, Iqa, Jqa, Kqa);
		} else {
			return null;
		}
	} else if (document.selection) {
		var range = document.selection.createRange();
		if (range.text.length > 0) {
			zpa = window;
			Rta = range;
		} else {
			if (top.window.frames.length > 0) {
				var i = 0;
				var SCb = top.window.frames.length;
				for (i = 0; i < SCb; i++) {
					var Zya = top.window.frames[i];
					range = Zya.document.selection.createRange();
					if (range.text.length > 0) {
						zpa = Zya;
						Rta = range;
						break;
					}
				}
			}
		}
		if (Rta != null && Rta.parentElement() != null
				&& Rta.parentElement().tagName.toLowerCase() == "input") {
			Rta = new String(Rta.text);
		}
	}
	if (zpa != null && Rta != null) {
		return {
			frame :zpa,
			range :Rta
		};
	} else {
		return null;
	}
}
function Nqa() {
	var sel = Bqa();
	if (sel != null && sel.range != null && !(sel.range instanceof String)) {
		if (cda) {
			sel.range = Hra(sel.frame.document.body, sel.range);
		} else if (sel.range instanceof lia) {
			sel.range = Sra(sel.range);
		}
	}
	return sel;
}
function Oqa() {
	var obj = Bqa();
	if (obj != null) {
		var sel = obj.range;
		if (sel instanceof String) {
			return sel;
		} else if (sel instanceof yia) {
			return sel.toString();
		} else {
			return range.text;
		}
	}
	return "";
}
function Uqa(p_window, p_node) {
	try {
		if (window == null || p_node == null || p_node.parentNode == null) {
			return;
		}
		var x = 0;
		var y = 0;
		var obj = p_node;
		if (obj.nodeType == 3) {
			obj = obj.parentNode;
		}
		while (obj != null) {
			x += obj.offsetLeft;
			y += obj.offsetTop;
			obj = obj.offsetParent;
		}
		var Pqa;
		var Qqa;
		var Rqa;
		var Sqa;
		var Tqa = 30;
		if (p_node.nodeType == 3) {
			Tqa = 10 + 5 * p_node.nodeValue.length;
			if (Tqa > 60) {
				Tqa = 60;
			}
		}
		Pqa = rw_getScreenOffsetLeft();
		Qqa = rw_getScreenOffsetTop();
		if (typeof (p_window.innerWidth) == 'number') {
			Rqa = p_window.innerWidth;
			Sqa = p_window.innerHeight;
		} else if (document.documentElement.clientHeight > 0
				&& document.documentElement.clientWidth > 0) {
			Rqa = document.documentElement.clientWidth;
			Sqa = document.documentElement.clientHeight;
		} else {
			Rqa = document.body.clientWidth;
			Sqa = document.body.clientHeight;
		}
		Rqa = Rqa - Tqa;
		Sqa = Sqa - 20;
		var Vqa;
		var Wqa;
		Vqa = (x < Pqa || x > (Pqa + Rqa));
		Wqa = (y < Qqa || y > (Qqa + Sqa));
		if (Vqa || Wqa && (x != 0 || y != 0)) {
			if (x > (Pqa + Rqa)) {
				x = (x + Pqa) / 2;
			}
			if (y > (Qqa + Sqa)) {
				y = (y + Qqa) / 2;
			}
			var Xqa = g_bHover;
			if (g_bHover == true) {
				g_bHover = false;
			}
			p_window.scrollTo((Vqa ? x : Pqa), (Wqa ? y : Qqa));
			if (Xqa) {
				var Yqa = setTimeout("g_bHover=true;", 500);
			}
		}
	} catch (ignore) {
	}
	g_bDidScroll = false;
}
function Zqa() {
	var str = "" + "rw_getDisplayWidth=" + rw_getDisplayWidth()
			+ "  rw_getDisplayWidthAdjusted=" + rw_getDisplayWidthAdjusted()
			+ "  rw_getDocumentDisplayWidth=" + rw_getDocumentDisplayWidth()
			+ "  rw_getDocumentDisplayWidthAdjusted="
			+ rw_getDocumentDisplayWidthAdjusted() + "  rw_getDisplayHeight="
			+ rw_getDisplayHeight() + "  rw_getDisplayHeightAdjusted="
			+ rw_getDisplayHeightAdjusted() + "  rw_getDocumentDisplayHeight="
			+ rw_getDocumentDisplayHeight()
			+ "  rw_getDocumentDisplayHeightAdjusted="
			+ rw_getDocumentDisplayHeightAdjusted()
			+ "  rw_getScreenOffsetLeft=" + rw_getScreenOffsetLeft()
			+ "  rw_getScreenOffsetTop=" + rw_getScreenOffsetTop()
			+ "  rw_getScrollBarWidth=" + rw_getScrollBarWidth()
			+ "  rw_getScrollBarHeight=" + rw_getScrollBarHeight();
	Jua(str);
}
function dqa() {
	var aqa = Bqa();
	var bqa = Nqa();
	var cqa = Oqa();
}
function eqa(p_strId) {
	Uqa(window, document.getElementById(p_strId));
}
function rw_getTargetNodeAsCaretIE(evt) {
	try {
		var fqa = zga(evt);
		var gqa = ata();
		gqa.moveToPoint(fqa.x, fqa.y);
		var oqa = ata();
		var iqa = ata();
		var jqa = evt.srcElement.firstChild;
		while ((jqa != null)) {
			if (jqa.nodeType == 3 && jqa.nodeValue.trimTH().length > 0) {
				var TBb = jqa.previousSibling;
				while (TBb != null && TBb.nodeType != 1) {
					TBb = TBb.previousSibling;
				}
				if (TBb != null) {
					oqa.moveToElementText(TBb);
					oqa.collapse(false);
				} else {
					oqa.moveToElementText(jqa.parentNode);
				}
				var lqa = jqa.nextSibling;
				while (lqa != null && lqa.nodeType != 1) {
					lqa = lqa.nextSibling;
				}
				if (lqa != null) {
					iqa.moveToElementText(lqa);
					oqa.setEndPoint("EndToStart", iqa);
				} else {
					iqa.moveToElementText(jqa.parentNode);
					oqa.setEndPoint("EndToEnd", iqa);
				}
				if (oqa.inRange(gqa)) {
					var hCb = tqa(jqa, oqa, gqa);
					return new THCaret(jqa, hCb);
				}
			}
			jqa = jqa.nextSibling;
		}
	} catch (exc) {
		cta("rw_getTargetNodeAsCaretIE error:" + exc.message);
	}
	return null;
}
function rw_getTextRangeAsRefPtIE(p_textRange) {
	try {
		var oqa = ata();
		var parentNode = p_textRange.parentElement();
		oqa.moveToElementText(parentNode);
		var hCb = tqa(parentNode, oqa, p_textRange);
		var qqa = Gja(parentNode, hCb);
		return qqa;
	} catch (exc) {
		cta("rw_getTextRangeAsRefPtIE error:" + exc.message);
	}
	return null;
}
function tqa(p_aNode, p_range, p_evtRange) {
	try {
		var hCb = 0;
		var range = p_range.duplicate();
		range.collapse();
		range.move("character", 1);
		range.move("character", -1);
		var uqa = 0;
		var vqa = 0;
		while (range.compareEndPoints("EndToEnd", p_evtRange) == -1) {
			range.moveEnd("character", 1);
			uqa = range.text.length;
			if (uqa > vqa) {
				++hCb;
				vqa = uqa;
			}
		}
		return hCb;
	} catch (err) {
		return 0;
	}
}
function Hra(p_body, p_textRange) {
	var kya = p_textRange.duplicate();
	kya.collapse(true);
	var xqa = rw_getTextRangeAsRefPtIE(kya);
	kya = p_textRange.duplicate();
	kya.collapse(false);
	var yqa = rw_getTextRangeAsRefPtIE(kya);
	return new yia(p_body, xqa, yqa);
}
function rw_getAsTextRange(p_body, p_strLeftPath, p_nLeftOffset,
		p_strRightPath, p_nRightOffset) {
	var range = ata();
	var OAb = mpa(p_body, p_strLeftPath, -1, p_strRightPath, -1);
	var oza = OAb.oza;
	var pza = OAb.pza;
	if (oza != null && pza != null) {
		var Cra = oza.node;
		if (Cra.nodeType == 3) {
			var hCb = Sja(Cra);
			Cra = Cra.parentNode;
			p_nLeftOffset += hCb;
		}
		var Era = pza.node;
		if (Era.nodeType == 3) {
			var hCb = Sja(Era);
			Era = Era.parentNode;
			p_nRightOffset += hCb;
		}
		range.moveToElementText(Cra);
		range.collapse();
		Mra(range, p_nLeftOffset);
		range.collapse(false);
		range.select();
		var Gra = ata();
		Gra.moveToElementText(Era);
		Gra.collapse();
		Mra(Gra, p_nRightOffset);
		Gra.collapse(false);
		range.setEndPoint("EndToEnd", Gra);
	} else {
		range = null;
		cta("Error with rw_getAsTextRange.");
	}
	return range;
}
function Mra(p_range, p_nVal) {
	var SCb;
	var Kra;
	var Lra;
	SCb = p_range.text.length;
	while (p_nVal != 0) {
		Lra = p_range.moveEnd("character", p_nVal);
		if (Lra == 0) {
			return;
		}
		Kra = p_range.text.length;
		p_nVal -= (Kra - SCb);
		SCb = Kra;
	}
}
function Rra(p_caretRange) {
	if (p_caretRange == null || p_caretRange.oza == null
			|| p_caretRange.pza == null) {
		return null;
	}
	return new yia(p_caretRange.oza.node.ownerDocument.body, Gja(
			p_caretRange.oza.node, p_caretRange.oza.offset), Gja(
			p_caretRange.pza.node, p_caretRange.pza.offset));
}
function Sra(p_domRange) {
	if (p_domRange == null || p_domRange.gza == null || p_domRange.hza == null) {
		return null;
	} else {
		return new yia(p_domRange.body, p_domRange.gza, p_domRange.hza);
	}
}
function Tra(p_domRange) {
	if (p_domRange == null || p_domRange.gza == null || p_domRange.hza == null) {
		return null;
	} else {
		var oza = jpa(p_domRange.body, p_domRange.gza.path,
				p_domRange.gza.offset, true);
		var pza = jpa(p_domRange.body, p_domRange.hza.path,
				p_domRange.hza.offset, false);
		if (oza != null && pza != null) {
			return new Zia(p_domRange.body, oza, pza);
		} else {
			return null;
		}
	}
}
function Ura(p_range) {
	if (p_range == null || p_range.gza == null || p_range.hza == null) {
		return null;
	} else {
		var oza = jpa(p_range.body, p_range.gza.path, p_range.gza.offset, true);
		var pza = jpa(p_range.body, p_range.hza.path, p_range.hza.offset, false);
		if (oza != null && pza != null) {
			return new Zia(oza, pza);
		} else {
			return null;
		}
	}
}
var Vra = null;
var Wra = null;
function Zra(p_nPos) {
	var flash = null;
	var Yra;
	if (window.document.WebToSpeech) {
		Yra = window.document;
	} else {
		Yra = window;
	}
	switch (p_nPos) {
	case 1:
		flash = Yra.SWA1;
		break;
	case 2:
		flash = Yra.SWA2;
		break;
	case 3:
		flash = Yra.SWA3;
		break;
	case 4:
		flash = Yra.SWA4;
		break;
	case 5:
		flash = Yra.SWA5;
		break;
	case 6:
		flash = Yra.SWA6;
		break;
	case 7:
		flash = Yra.SWA7;
		break;
	case 8:
		flash = Yra.SWA8;
		break;
	case 9:
		flash = Yra.SWA9;
		break;
	case 10:
		flash = Yra.SWA10;
		break;
	default:
		flash = Yra.SWA1;
	}
	return flash;
}
function $rw_event_click(event, i) {
	return $rw_event_hover(event, i);
}
function $rw_event_hover(event, i) {
	if (!xca) {
		return;
	}
	if (!Sca) {
		if (yba) {
			throw "The page has not fully loaded, click and speak is not available yet.";
		} else {
			Jua("The page has not fully loaded, click and speak is not available yet.");
		}
		return;
	}
	g_bHover = !g_bHover;
	if (i > -1) {
		g_toggleIcons[i][8] = !g_toggleIcons[i][8];
		if (dda) {
			document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
		} else {
			Zea(g_toggleIcons[i][0], "toggleOn", true);
		}
	}
	if (uda && g_bHover) {
		if (Oca > -1 && typeof ($rw_event_sticky) != "undefined") {
			$rw_event_sticky(event, Oca);
			var ara = Ida;
			Ida = 0;
			rw_mouseOffIcon("sticky");
			Ida = ara;
		}
	}
	if (!g_bHover) {
		$rw_event_stop();
		Iha(false);
	} else {
		Iha(true);
	}
	try {
		var flash = Zra(jda);
		if (flash != null) {
			flash.setClickToSpeakFlag(g_bHover);
		}
	} catch (err) {
		cta("call to flash click to speak failed.");
	}
}
function $rw_event_play() {
	if (xca) {
		try {
			if (g_speakableTextAreaTarget != null) {
				if (g_nSpeakableTextAreaTimerId != 0) {
					clearTimeout(g_nSpeakableTextAreaTimerId);
					g_nSpeakableTextAreaTimerId = 0;
					if (g_speakableTextAreaTarget == null) {
						$rw_event_play();
						return;
					}
				}
				var cra = g_speakableTextAreaTarget;
				cra.focus();
				g_speakableTextAreaTarget = null;
				var target = new THHoverTarget(document.body, Jpa(cra), null);
				rw_speakHoverTarget(target);
			} else if (lda) {
				var flash = Zra(jda);
				mda = true;
				flash.clickOnPlay();
				flash.focus();
			} else {
				var era = Nqa();
				if (era != null && era.range != null) {
					var Fxa = era.range;
					if (Fxa instanceof String) {
						rw_speakHoverTarget(Fxa);
					} else {
						if (cda) {
							var range = Sta();
							range.collapse();
							range.select();
						}
						var target = new THHoverTarget(null, null, Fxa);
						rw_speakHoverTarget(target);
					}
				}
			}
		} catch (err) {
			cta("Caught error " + err);
		}
	}
}
function $rw_event_funplay() {
	$rw_event_play();
}
var g_tmpLastTargetForCache = null;
function hra(p_strText) {
	if (typeof (eba_no_flash) == "boolean" && eba_no_flash == true) {
		THSendSocketMessage("THStart" + p_strText + "THEnd");
		return;
	}
	if (p_strText == null && p_strText.length == 0) {
		$rw_doSelection(-1);
		return;
	}
	if (!xca) {
		$rw_doSelection(-1);
		return;
	}
	try {
		var flash = rw_getWebToSpeech();
		if (flash != null) {
			g_nType = 2;
			Iha(true);
			$rw_doSelection(0);
			if (zba) {
				flash.startSpeechFromCache(awa(p_strText));
			} else if (yba) {
				g_tmpLastTargetForCache = g_lastTarget;
				g_lastTarget = null;
				var Swa = Owa(p_strText);
				var Twa = bwa();
				if (1 == 0) {
					flash.startSpeechCacheGenerationWithPronunciation(txt, iba,
							"" + uba, Twa, Swa, kba, lba, mba);
				} else {
					flash.startSpeechCacheGeneration(p_strText, iba, "" + uba,
							Twa, Swa);
				}
				var wza = awa(p_strText);
				Ksa
						.push("g_lastTarget = g_tmpLastTargetForCache; g_nLastNodePosition = 0;"
								+ "var flash = rw_getWebToSpeech(); flash.startSpeechFromCacheGenerator('"
								+ wza + "');");
			} else {
				flash.startSpeech(p_strText);
			}
		}
	} catch (err) {
		cta("Caught error " + err);
	}
}
function $rw_event_funstop() {
	$rw_event_stop();
}
function $rw_event_stop() {
	if (!xca) {
		return;
	}
	try {
		if (Xca) {
			Kfa();
		}
		Ksa.length = 0;
		Wca = null;
		if (qka) {
			setTimeout("$rw_event_stop()", 100);
			return;
		}
		if (yja > 0) {
			clearTimeout(yja);
			yja = 0;
		}
		if (zja > 0) {
			clearTimeout(zja);
			zja = 0;
		}
		if (lda) {
			var flash = Zra(jda);
			mda = true;
			flash.clickOnStop();
			flash.focus();
		} else {
			Iha(false);
			var flash = rw_getWebToSpeech();
			if (flash != null) {
				var aAb = flash.stopSpeechAlt();
			}
		}
		wja = null;
	} catch (err) {
		cta("Caught error " + err);
	}
}
function $rw_event_stop_limited() {
	if (!xca) {
		return;
	}
	try {
		Ksa.length = 0;
		Wca = null;
		if (lda) {
			var flash = Zra(jda);
			mda = true;
			flash.clickOnStop();
			flash.focus();
		} else {
			Iha(false);
			var flash = rw_getWebToSpeech();
			if (flash != null) {
				var aAb = flash.stopSpeechAlt();
			}
		}
	} catch (err) {
		cta("Caught error " + err);
	}
}
function $rw_event_mp3() {
	try {
		var gAb = Gsa();
		gAb = gAb.trimTH();
		if (gAb.length > 0) {
			var flash = rw_getWebToSpeech();
			if (flash != null) {
				var ura = flash.getMP3File(gAb);
			}
		}
	} catch (err) {
		cta("Caught error " + err);
	}
}
function $rw_mp3reply(txt) {
	try {
		if (txt.length > 0) {
			var vra = "Save Target As...";
			if (!cda) {
				if (dda) {
					vra = "Download Linked File";
				} else {
					vra = "Save Link As...";
				}
			}
			var d = new Date();
			var gDb = (d.getTime() - 1164713747000);
			txt = "<br></br>Right click on the link below and select " + "'"
					+ vra + "' to save the mp3 file to your hard drive.<p></p>"
					+ "<a type='application/octet-stream' href=\"" + txt
					+ "\">speech" + gDb + ".mp3</a><p></p>";
			Vha(Uda, txt);
			Yha(true, Uda);
		}
	} catch (err) {
		cta("Caught error " + err);
	}
}
function $rw_event_spell(event, i) {
	try {
		if (lda) {
			g_toggleIcons[i][8] = !g_toggleIcons[i][8];
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
			} else {
				Zea(g_toggleIcons[i][0], "toggleOn", true);
			}
			var flash = Zra(jda);
			mda = true;
			flash.setSpelling(g_toggleIcons[i][8]);
			flash.focus();
		}
	} catch (err) {
		cta(err.message);
	}
}
function $rw_event_homophone(event, i) {
	try {
		if (lda) {
			g_toggleIcons[i][8] = !g_toggleIcons[i][8];
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
			} else {
				Zea(g_toggleIcons[i][0], "toggleOn", true);
			}
			var flash = Zra(jda);
			mda = true;
			flash.setHomophone(g_toggleIcons[i][8]);
			flash.focus();
		}
	} catch (err) {
		cta(err.message);
	}
}
function $rw_event_pred(event, i) {
	try {
		if (lda) {
			g_toggleIcons[i][8] = !g_toggleIcons[i][8];
			if (dda) {
				document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][Eea].src;
			} else {
				Zea(g_toggleIcons[i][0], "toggleOn", true);
			}
			var flash = Zra(jda);
			mda = true;
			flash.setPrediction(g_toggleIcons[i][8]);
			flash.focus();
		}
	} catch (err) {
		cta(err.message);
	}
}
function $rw_event_submit() {
	try {
		Hda = true;
		lm_doSubmit();
		Hda = false;
	} catch (err) {
		cta("Caught error " + err);
	}
}
var Asa = "setWarning";
function setWarning() {
	$rw_lexiSubmitEvent();
}
function $rw_lexiSubmitEvent() {
	Hda = true;
}
function Csa() {
	var txt = '';
	if (window.getSelection) {
		if (window.getSelection() != null && !window.getSelection().isCollapsed) {
			return true;
		}
		if (top.window.frames.length > 0) {
			var i = 0;
			var SCb = top.window.frames.length;
			for (i = 0; i < SCb; i++) {
				if (top.window.frames[i].getSelection() != null
						&& !top.window.frames[i].getSelection().isCollapsed) {
					return true;
				}
			}
		}
	} else if (document.selection) {
		var range = document.selection.createRange();
		if (range.text.length > 0) {
			return true;
		}
		if (top.window.frames.length > 0) {
			var i = 0;
			var SCb = top.window.frames.length;
			for (i = 0; i < SCb; i++) {
				var Zya = top.window.frames[i];
				range = Zya.document.selection.createRange();
				if (range.text != null && range.text.length > 0) {
					return true;
				}
			}
		}
	}
	return false;
}
function Gsa() {
	var txt = '';
	if (window.getSelection) {
		txt = new String(window.getSelection());
	} else if (document.getSelection) {
		txt = new String(document.getSelection());
	} else if (document.selection) {
		var range = document.selection.createRange();
		if (range.text == null || range.text.length == 0) {
			if (top.window.frames.length > 0) {
				var i = 0;
				var SCb = top.window.frames.length;
				for (i = 0; i < SCb; i++) {
					var Zya = top.window.frames[i];
					range = Zya.document.selection.createRange();
					if (range.text != null && range.text.length > 0) {
						break;
					}
				}
			}
		}
		txt = range.text;
	} else {
		return;
	}
	return txt;
}
var g_nLastNodePosition = -1;
var Ksa = new Array();
var Lsa = false;
function $rw_doSelection(p_nPosition) {
	if (p_nPosition < 0) {
		Iha(false);
		Jha(false);
		if (Xca) {
			Kfa();
		}
	} else {
		Jha(true);
	}
	if (g_lastTarget && g_lastTarget.isRange()) {
		if (p_nPosition != g_nLastNodePosition) {
			if (p_nPosition == -1 || p_nPosition == -2) {
				if (g_nLastNodePosition > -1 && g_lastTarget.Tsa != null) {
					try {
						var Tsa = g_lastTarget.Tsa;
						var SCb = Tsa.length;
						if (g_nLastNodePosition < SCb) {
							var Fxa = Tsa[g_nLastNodePosition].range;
							if (cda && Lsa) {
								var csa = rw_getAsTextRange(Fxa.body,
										Fxa.gza.path, Fxa.gza.offset,
										Fxa.hza.path, Fxa.hza.offset);
								if (csa != null) {
									csa.collapse();
									csa.select();
								}
							} else {
								var OAb = mpa(Fxa.body, Fxa.gza.path,
										Fxa.gza.offset, Fxa.hza.path,
										Fxa.hza.offset);
								var oza = OAb.oza;
								var pza = OAb.pza;
								if (oza != null && pza != null) {
									rw_removeSpeechHighlight(Bva(oza, pza),
											true);
								} else {
									cta("Cannot determine valid range to remove speech highlight from. "
											+ oza + " " + pza);
								}
							}
						}
					} catch (err) {
						cta("$rw_doSelection:clear last speech:"
								+ err.toString());
					}
				}
				g_nLastNodePosition = -1;
				try {
					g_lastTarget.unhighlightRange();
				} catch (err) {
					cta("$rw_doSelection:unhighlightRange:" + err.message);
				}
			} else if (g_lastTarget.Tsa != null) {
				if (g_nLastNodePosition == p_nPosition) {
					return;
				}
				var Tsa = g_lastTarget.Tsa;
				var SCb = Tsa.length;
				try {
					if (g_nLastNodePosition > -1 && g_nLastNodePosition < SCb) {
						var Fxa = Tsa[g_nLastNodePosition].range;
						if (cda && Lsa) {
							var csa = rw_getAsTextRange(Fxa.body, Fxa.gza.path,
									Fxa.gza.offset, Fxa.hza.path,
									Fxa.hza.offset);
							if (csa != null) {
								csa.collapse();
								csa.select();
							}
						} else {
							var OAb = mpa(Fxa.body, Fxa.gza.path,
									Fxa.gza.offset, Fxa.hza.path,
									Fxa.hza.offset);
							var oza = OAb.oza;
							var pza = OAb.pza;
							if (oza != null && pza != null) {
								rw_removeSpeechHighlight(Bva(oza, pza), true);
							} else {
								cta("Cannot determine valid range to remove speech highlight from. "
										+ oza + " " + pza);
							}
						}
					}
				} catch (err) {
					cta(" **** " + err.toString());
				}
				if (p_nPosition < 0 || p_nPosition >= SCb) {
					return;
				}
				g_nLastNodePosition = p_nPosition;
				var Fxa = Tsa[p_nPosition].range;
				var cCb = Tsa[p_nPosition].word;
				try {
					if (cda && Lsa) {
						var csa = rw_getAsTextRange(Fxa.body, Fxa.gza.path,
								Fxa.gza.offset, Fxa.hza.path, Fxa.hza.offset);
						if (Fxa != null) {
							csa.select();
						}
					} else {
						var OAb = mpa(Fxa.body, Fxa.gza.path, Fxa.gza.offset,
								Fxa.hza.path, Fxa.hza.offset);
						var oza = OAb.oza;
						var pza = OAb.pza;
						if (oza != null && pza != null) {
							Uqa(window, oza.node);
							rw_setSpeechRangeImpl(oza.node, oza.offset,
									pza.node, pza.offset, "csp");
						} else {
							cta("Cannot determine valid range to add speech highlight from. "
									+ oza + " " + pza);
						}
					}
				} catch (err) {
					cta("error with highlight speech range in rw_doSelection:"
							+ err.message);
				}
			}
		}
	}
	if (p_nPosition == -1 || p_nPosition == -2) {
		g_nLastNodePosition = -1;
		g_lastTarget = null;
		if (p_nPosition == -1) {
			if (Ksa.length > 0) {
				var gsa = Ksa.shift();
				eval(gsa);
			}
		}
	}
}
function $displayMe(txt) {
	alert(txt);
}
function ksa(a_str_windowURL, a_str_windowName, a_int_windowWidth,
		a_int_windowHeight, a_bool_scrollbars, a_bool_resizable,
		a_bool_menubar, a_bool_toolbar, a_bool_addressbar, a_bool_statusbar,
		a_bool_fullscreen) {
	var hsa = (screen.width - a_int_windowWidth) / 2;
	var isa = (screen.height - a_int_windowHeight) / 2;
	var jsa = 'height=' + a_int_windowHeight + ',width=' + a_int_windowWidth
			+ ',top=' + isa + ',left=' + hsa + ',scrollbars='
			+ a_bool_scrollbars + ',resizable=' + a_bool_resizable
			+ ',menubar=' + a_bool_menubar + ',toolbar=' + a_bool_toolbar
			+ ',location=' + a_bool_addressbar + ',statusbar='
			+ a_bool_statusbar + ',fullscreen=' + a_bool_fullscreen + '';
	var lsa = window.open(a_str_windowURL, a_str_windowName, jsa);
	if (parseInt(navigator.appVersion) >= 4) {
		lsa.window.focus();
	}
}
function nsa(p_name) {
	var start = document.cookie.indexOf(p_name + "=");
	var len = start + p_name.length + 1;
	if ((!start) && (p_name != document.cookie.substring(0, p_name.length))) {
		return null;
	}
	if (start == -1) {
		return null;
	}
	var end = document.cookie.indexOf(";", len);
	if (end == -1) {
		end = document.cookie.length;
	}
	return unescape(document.cookie.substring(len, end));
}
function qsa(p_name, p_value, p_expires, p_path, p_domain, p_secure) {
	var osa = new Date();
	osa.setTime(osa.getTime());
	if (p_expires) {
		p_expires = p_expires * 1000 * 60 * 60 * 24;
	}
	var psa = new Date(osa.getTime() + (p_expires));
	document.cookie = p_name + "=" + escape(p_value)
			+ ((p_expires) ? ";expires=" + psa.toGMTString() : "")
			+ ((p_path) ? ";path=" + p_path : "")
			+ ((p_domain) ? ";domain=" + p_domain : "")
			+ ((p_secure) ? ";secure" : "");
}
function rsa(p_name, p_path, p_domain) {
	if (nsa(p_name)) {
		document.cookie = p_name + "=" + ((p_path) ? ";path=" + p_path : "")
				+ ((p_domain) ? ";domain=" + p_domain : "")
				+ ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
	}
}
function usa() {
	if (Pza()) {
		var cCb = tya();
		Vha(Yda, cCb);
		Yha(true, Yda);
		var VBb = "rwcollatewrapper";
		var vsa = eha("rwTextCollect");
		if (parseInt(vsa.offsetHeight) >= 380) {
			vsa.parentNode.parentNode.style.height = (380);
			eha("rwDragMeCollect").style.width = "580px";
			eha("rwcollatewrapper").style.width = "580px";
			vsa.parentNode.parentNode.style.overflow = "auto";
		} else {
			vsa.parentNode.parentNode.style.height = (vsa.offsetHeight + 36);
			eha("rwDragMeCollect").style.width = "600px";
			eha("rwcollatewrapper").style.width = "600px";
			vsa.parentNode.parentNode.style.overflow = "hidden";
		}
	}
}
function $rw_event_axendolink(event) {
	document.location = "http://www.browsealoud.info";
}
function dis(node) {
	Jua(node.tagName + "|" + node.nodeValue + "|" + Jpa(node));
}
function $rw_event_test(event) {
}
function $rw_speakById(id) {
	var vza = document.getElementById(id);
	if (vza != null) {
		var xsa = vza.innerHTML;
		if (xsa.length > 0) {
			var ysa = Nma(vza, true);
			if (ysa == null) {
				return;
			}
			var Hwa = Pma(vza, true);
			if (Hwa == null) {
				return;
			}
			var gza = Gja(ysa, 0);
			var hza = (Hwa.nodeType == 3) ? Gja(Hwa, Hwa.nodeValue.length)
					: Gja(Hwa, 0);
			var Fxa = new yia(document.body, gza, hza);
			var target = new THHoverTarget(null, null, Fxa);
			rw_speakHoverTarget(target);
		}
	}
}
function $rw_stopSpeech() {
	$rw_event_stop();
}
function Gta(p_node) {
	var doc = p_node.ownerDocument;
	var iva = p_node.parentNode;
	if (iva != null && p_node.nodeType == 3) {
		while (p_node.previousSibling != null
				&& p_node.previousSibling.nodeType == 3) {
			var txt = p_node.previousSibling.nodeValue + p_node.nodeValue;
			var uva = doc.createTextNode(txt);
			iva.removeChild(p_node.previousSibling);
			iva.replaceChild(uva, p_node);
			p_node = uva;
		}
		while (p_node.nextSibling != null && p_node.nextSibling.nodeType == 3) {
			var txt = p_node.nodeValue + p_node.nextSibling.nodeValue;
			var uva = doc.createTextNode(txt);
			iva.removeChild(p_node.nextSibling);
			iva.replaceChild(uva, p_node);
			p_node = uva;
		}
	}
	return p_node;
}
function Hta(p_sel) {
	try {
		var txt = p_sel + "";
		txt = txt.trimTH();
		p_sel.collapseToStart();
		var jza = p_sel.anchorNode;
		var Tva = p_sel.anchorOffset;
		if (jza.nodeType != 3) {
			jza = Lna(jza, false, null);
			Tva = 0;
		} else if (Tva == jza.nodeValue.length) {
			jza = Lna(jza, false, null);
			Tva = 0;
		}
		if (jza != null && jza.nodeType == 3) {
			var Kta = jza.nodeValue.substring(Tva);
			var Lta = Kta.trimStartTH();
			while (Kta.length > Lta.length) {
				if (Lta.length == 0) {
					jza = Lna(jza, false, null);
					Tva = 0;
					if (jza == null || jza.nodeType != 3) {
						break;
					}
				} else {
					Tva += Kta.length - Lta.length;
				}
				Kta = jza.nodeValue.substring(Tva);
				Lta = Kta.trimStartTH();
			}
		}
		var range = ata();
		if (jza == null) {
			range.setStart(p_sel.anchorNode, p_sel.anchorOffset);
			range.setEnd(p_sel.anchorNode, p_sel.anchorOffset);
		} else {
			if (jza.nodeType != 3) {
				range = Qta(jza, Tva, txt);
			} else {
				if ((Tva + txt.length) < jza.nodeValue.length) {
					range.setStart(jza, Tva);
					range.setEnd(jza, Tva + txt.length);
				} else {
					range = Qta(jza, Tva, txt);
				}
			}
		}
		return range;
	} catch (ignore) {
		var range = ata();
		range.setStart(p_sel.anchorNode, p_sel.anchorOffset);
		range.setEnd(p_sel.anchorNode, p_sel.anchorOffset);
		return range;
	}
}
function Qta(p_startNode, p_nOffset, p_txt) {
	var range = ata();
	range.setStart(p_startNode, p_nOffset);
	range.setEnd(p_startNode, p_nOffset);
	var SCb = 0;
	var Nta = p_txt.length + p_nOffset;
	var qza = p_startNode;
	while (qza != null && SCb < Nta) {
		if (qza.nodeType == 3) {
			var txt = qza.nodeValue;
			SCb += txt.length;
		}
		if (SCb < Nta) {
			qza = Lna(qza, false, null);
		} else {
			var Pta = SCb - Nta;
			range.setEnd(qza, qza.nodeValue.length - Pta);
		}
	}
	return range;
}
function Sta() {
	var Rta = null;
	if (window.getSelection) {
		var Tta = window.getSelection();
		var Uta = null;
		if (Tta.isCollapsed == false) {
			Uta = Tta;
		} else {
			if (top.window.frames.length > 0) {
				var i = 0;
				var SCb = top.window.frames.length;
				for (i = 0; i < SCb; i++) {
					if (top.window.frames[i].getSelection() != null
							&& top.window.frames[i].getSelection().isCollapsed == false) {
						Uta = top.window.frames[i].getSelection();
						break;
					}
				}
			}
		}
		if (Uta == null) {
			return null;
		}
		Rta = Uta;
	} else if (document.selection) {
		var range = document.selection.createRange();
		if (range.text.length > 0) {
			zpa = window;
			Rta = range;
		} else {
			if (top.window.frames.length > 0) {
				var i = 0;
				var SCb = top.window.frames.length;
				for (i = 0; i < SCb; i++) {
					var Zya = top.window.frames[i];
					range = Zya.document.selection.createRange();
					if (range.text.length > 0) {
						zpa = Zya;
						Rta = range;
						break;
					}
				}
			}
		}
	}
	return Rta;
}
function Yta() {
	var txt = "";
	if (document.body.createTextRange) {
		var range = document.body.createTextRange();
		range.expand("textedit");
		txt = range.text;
	} else if (document.createRange) {
		var range = document.createRange();
		range.setStartBefore(document.body);
		range.setEndAfter(document.body);
		txt = range.toString();
	}
	return txt;
}
function Zta(p_node) {
	if (p_node.innerText) {
		return p_node.innerText;
	} else if (p_node.textContent) {
		return p_node.textContent;
	} else {
		return "";
	}
}
function ata() {
	if (document.body.createTextRange) {
		return document.body.createTextRange();
	} else if (document.createRange) {
		return document.createRange();
	} else {
		return null;
	}
}
function bta(p_node) {
	if (p_node.document) {
		return p_node.document.body;
	} else {
		return p_node.ownerDocument.body;
	}
}
function cta(nja) {
	if (window.console && window.console.log) {
		window.console.log(nja);
	} else if (typeof (dump) != 'undefined') {
		dump(nja + "\n");
	}
}
function dta(txt) {
	if (txt == null) {
		return "";
	}
	var eta = "";
	var i = 0;
	var n = txt.length;
	var fta = -1;
	var gta = -1;
	for (i = 0; i < n; i++) {
		var GDb = txt.charCodeAt(i);
		if ((GDb > 64 && GDb < 91) || (GDb > 96 && GDb < 123)) {
			if (fta == -1) {
				fta = i;
			}
		} else if (GDb == 39) {
			if (i < (n - 1)) {
				nValNext = txt.charCodeAt(i + 1);
				if ((nValNext > 64 && nValNext < 91)
						|| (nValNext > 96 && nValNext < 123)) {
					++i;
				} else {
					gta = i;
					break;
				}
			} else {
				gta = i;
				break;
			}
		} else {
			gta = i;
			break;
		}
	}
	if (fta > -1) {
		if (gta > -1) {
			eta = txt.substring(fta, gta);
		} else {
			eta = txt.substring(fta);
		}
	}
	return eta;
}
function ita(p_nCode) {
	return (p_nCode > 64 && p_nCode < 91) || (p_nCode > 96 && p_nCode < 123);
}
function jta(p_nCode) {
	return (p_nCode > 47 && p_nCode < 58);
}
function kta(p_nCode) {
	return (p_nCode == 39 || (p_nCode > 47 && p_nCode < 58)
			|| (p_nCode > 64 && p_nCode < 91) || (p_nCode > 95 && p_nCode < 123));
}
function pta(p_txt) {
	var lta = false;
	if (p_txt.length > 0) {
		if (p_txt.length > 2) {
			lta = true;
		}
		if (p_txt.length == 2) {
			var ota = p_txt.charCodeAt(0);
			var nta = p_txt.charCodeAt(1);
			if (ota > 32 && ota < 127 && nta > 32 && nta < 127) {
				lta = true;
			}
		} else {
			var ota = p_txt.charCodeAt(0);
			if (ota > 32 && ota < 127) {
				lta = true;
			}
		}
	}
	return lta;
}
function rta(txt) {
	if (txt == null) {
		return false;
	}
	for ( var i = 0; i < txt.length; i++) {
		var GDb = txt.charCodeAt(i);
		if (GDb == 39 || (GDb > 47 && GDb < 58) || (GDb > 64 && GDb < 91)
				|| GDb == 96 || (GDb > 96 && GDb < 123)) {
			return true;
		}
	}
	return false;
}
function uta(p_strPhrase) {
	if (p_strPhrase == null || p_strPhrase.length == 0) {
		return p_strPhrase;
	}
	var SCb = p_strPhrase.length;
	for ( var i = 0; i < SCb; i++) {
		var GDb = p_strPhrase.charCodeAt(i);
		if (!(GDb == 39 || GDb == 44 || GDb == 46 || (GDb > 47 && GDb < 58)
				|| (GDb > 63 && GDb < 91) || (GDb > 94 && GDb < 123))) {
			p_strPhrase = p_strPhrase.replace(p_strPhrase.charAt(i), ' ');
		}
	}
	return p_strPhrase.trimTH();
}
function vta(range) {
	var txt = "";
	if (range.text) {
		txt = range.text;
	} else {
		txt = range.toString();
	}
	return txt;
}
function wta() {
	var sel = Sta();
	if (sel == null) {
		return;
	}
	if (sel.collapseToStart) {
		sel.collapseToStart();
	} else if (sel.execCommand) {
		sel.execCommand("UnSelect", false, null);
	}
}
function Aua(p_range) {
	if (cda) {
		p_range.select();
	} else {
		var start = p_range.PAb;
		var end = p_range.QAb;
		if (!dda) {
			var fza = window.getSelection();
			fza.collapse(start.node, start.offset);
			fza.extend(end.node, end.offset);
		} else {
			window.getSelection().setBaseAndExtent(start.node, start.offset,
					end.node, end.offset);
		}
	}
}
function Bua(p_char) {
	return (p_char.search(/[\s\xa0]/) > -1);
}
function Cua(obj) {
	var Dua = obj + "  ";
	for (prop in obj) {
		Dua += prop + "  " + " | ";
	}
	alert(Dua);
}
function Eua(obj) {
	var Dua = obj + "  ";
	for (prop in obj) {
		Dua += prop + "  " + " | ";
	}
	return Dua;
}
function $rw_inputFieldFilter(p_str) {
	if (p_str == null || p_str.length == 0) {
		return p_str;
	}
	var i;
	var SCb = p_str.length;
	for (i = SCb - 1; i >= 0; i--) {
		var c = p_str.charCodeAt(i);
		if ((c < 44 && c != 39) || c == 47 || (c > 57 && c < 65)
				|| (c > 90 && c < 97 && c != 95) || (c > 122 && c < 128)) {
			p_str = p_str.substring(0, i) + p_str.substr(i + 1);
		}
	}
	return p_str;
}
function $rw_handleFieldInput(p_obj) {
	var pre = p_obj.value;
	var Gua = $rw_inputFieldFilter(pre);
	if (pre != Gua) {
		p_obj.value = Gua;
	}
}
function $rw_handleFieldKeyDownInput(evt) {
	if (!evt.ctrlKey) {
		var c = evt.keyCode;
		if ((c > 32 && c < 44 && c != 39) || c == 47 || (c > 57 && c < 65)
				|| (c > 90 && c < 97 && c != 95) || (c > 122 && c < 128)) {
			return false;
		}
	}
	return true;
}
function Iua(p_strText) {
	p_strText = p_strText.trimTH();
	var SCb = p_strText.length;
	var i;
	for (i = 0; i < SCb; i++) {
		var c = p_strText.charCodeAt(i);
		if ((c > 47 && c < 58) || (c > 63 && c < 91) || (c > 96 && c < 123)
				|| c == 38 || c == 39) {
			return p_strText;
		}
	}
	return "";
}
function d2h(d) {
	return d.toString(16);
}
function h2d(h) {
	return parseInt(h, 16);
}
function Jua(p_str) {
	if (Yba) {
		alert(p_str);
	} else {
		cta(p_str);
	}
}
function Kua(jqa) {
	var txt = "";
	if (jqa.nodeType == 3) {
		txt = jqa.nodeValue;
	} else if (jqa.nodeType == 1) {
		var Lua = jqa.firstChild;
		while (Lua != null) {
			if (Lua.nodeType == 3) {
				txt += Lua.nodeValue;
			} else if (Lua.nodeType == 1) {
				txt += Kua(Lua);
			}
			Lua = Lua.nextSibling;
		}
	}
	return txt;
};
function Pua(jqa) {
	var Mua = null;
	var Nua = jqa.tagName.toLowerCase();
	var ECb = Jpa(jqa);
	if (Nua == "input") {
		var Qua = jqa.getAttribute("type");
		if (Qua != null) {
			Qua = Qua.toLowerCase();
		}
		var Xua = "";
		if (Qua == null || Qua.equalsTH("") || Qua.equalsTH("text")) {
			Xua = jqa.value;
		} else if (Qua.equalsTH("password")) {
			Xua = "Masked password field";
		} else if (Qua.equalsTH("image")) {
			Xua = "";
		} else if (Qua.equalsTH("button") || Qua.equalsTH("submit")
				|| Qua.equalsTH("reset")) {
			Xua = jqa.getAttribute("value");
		}
		if (Xua.equalsTH("") == false) {
			Mua = "form:" + ECb + ";" + Xua;
		}
	} else if (Nua == "select") {
		var Xua = "";
		var Tua = jqa.selectedIndex;
		var Uua = "";
		for ( var Iza = 0; Iza < jqa.options.length; Iza++) {
			Uua += jqa.options[Iza].text + " ";
		}
		if (Uua.equalsTH("") == false) {
			if (Tua > -1) {
				Xua = jqa.options[Tua].text;
				Xua += " selected from the list " + Uua;
			} else {
				Xua = "No selection from the list " + Uua;
			}
			Mua = "form" + ECb + ";" + Xua;
		}
	} else if (Nua == "textarea") {
		var Xua = jqa.value;
		Mua = "form" + ECb + ";" + Xua;
	} else if (Nua == "option") {
		var Xua = jqa.value;
		Mua = "form" + ECb + ";" + Xua;
	}
	return Mua;
}
var Yua = null;
function Zua(Yua) {
	Yua.setAttribute("onMouseOver", "top.doMouseOverTH(event)");
}
function aua(jqa) {
	pua();
	if (document.getElementsByTagName("frameset").item(0) != null) {
		var bua = document.getElementsByTagName("frameset").item(0);
		bua.removeAttribute("thSafariReaderDetails");
		bua.removeAttribute("thSafariReaderAutoDetails");
		bua.removeAttribute("thSafariReaderFlag");
	} else {
		document.body.removeAttribute("thSafariReaderDetails");
		document.body.removeAttribute("thSafariReaderAutoDetails");
		document.body.removeAttribute("thSafariReaderFlag");
	}
};
function cua(theFrameSet, strLoc) {
	var doc = theFrameSet.document;
	if (doc != null) {
		var bod = doc.body;
		if (bod != null) {
			gua(theFrameSet, strLoc + ".");
		}
	}
	var kua;
	var size = theFrameSet.frames.length;
	for ( var i = 0; i < size; i += 1) {
		var rua = theFrameSet.frames[i];
		kua = strLoc + ".frames[" + i + "]";
		cua(rua, kua);
	}
};
function gua(aWindow, baseLoc) {
	aWindow.String.prototype.trimTH = function() {
		return this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "");
	};
	aWindow.String.prototype.equalsTH = function(s) {
		if (this.length != s.length) {
			return false;
		}
		for ( var i = 0; i < this.length; i += 1) {
			if (this.charAt(i) != s.charAt(i)) {
				return false;
			}
		}
		return true;
	};
	var bod = aWindow.document.body;
	var hua = bod.getAttribute("onMouseOver");
	var iua = bod.getAttribute("onClick");
	var jua = bod.getAttribute("onUnload");
	if (typeof hua == 'function') {
		aWindow.onmouseover = function(event) {
			hua(event);
			top.doMouseOverTH(event);
		};
	} else {
		aWindow.onmouseover = function(event) {
			top.doMouseOverTH(event);
		};
	}
	if (typeof iua == 'function') {
		aWindow.onclick = function(event) {
			iua(event);
			top.doMouseClickTH(event);
		};
	} else {
		aWindow.onclick = function(event) {
			top.doMouseClickTH(event);
		};
	}
	if (typeof jua == 'function') {
		aWindow.onunload = function() {
			jua();
			top.aua();
		};
	} else {
		aWindow.onunload = function() {
			top.aua();
		};
	}
	var kua = baseLoc + "document.body";
	bod.setAttribute("body_loc", kua);
};
function nua(obj) {
	var lua = 0;
	if (obj) {
		if (obj.offsetParent) {
			while (obj.offsetParent) {
				lua += obj.offsetLeft;
				obj = obj.offsetParent;
				if (obj.offsetParent == null) {
					lua += obj.offsetLeft;
				}
			}
		} else if (obj.offsetLeft) {
			lua += obj.offsetLeft;
		}
	}
	return lua;
};
function oua(obj) {
	var mua = 0;
	if (obj) {
		if (obj.offsetParent) {
			while (obj.offsetParent) {
				mua += obj.offsetTop;
				obj = obj.offsetParent;
				if (obj.offsetParent == null) {
					mua += obj.offsetTop;
				}
			}
		} else if (obj.offsetTop) {
			mua += obj.offsetTop;
		}
	}
	return mua;
};
function pua() {
	setSpeechDetailsTH("");
	setSpeechAutoDetailsTH("");
	if (document.getElementsByTagName("frameset").item(0) != null) {
		sua(top);
	} else {
		var bod = document.body;
		tua(bod);
	}
};
function sua(theFrameSet) {
	var size = theFrameSet.frames.length;
	for ( var i = 0; i < size; i += 1) {
		var rua = theFrameSet.frames[i];
		if (rua.length == 0) {
			tua(rua.document.body);
			rua.String.prototype.trimTH = function() {
				return this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "");
			};
			rua.String.prototype.equalsTH = function(s) {
				if (this.length != s.length) {
					return false;
				}
				for (i = 0; i < this.length; i += 1) {
					if (this.charAt(i) != s.charAt(i)) {
						return false;
					}
				}
				return true;
			};
		} else {
			cua(rua);
		}
	}
};
function tua(jqa) {
	if (jqa == null) {
		return;
	}
	if (jqa.nodeType == 1) {
		if (jqa.tagName.toLowerCase() == ("font")
				&& jqa.getAttribute("started") == "1") {
			var txt = Kua(jqa);
			var doc = jqa.ownerDocument;
			var uva = doc.createTextNode(txt);
			jqa.parentNode.replaceChild(uva, jqa);
		} else {
			var vua = jqa.firstChild;
			while (vua != null) {
				var wua = vua;
				vua = vua.nextSibling;
				tua(wua);
			}
		}
	}
};
function aa(a) {
};
function xua(str) {
	var nn = 150;
	if (str.length > nn) {
		while (str.length > nn) {
			var sss = str.substring(0, nn);
			str = str.substring(nn);
			cta(sss);
		}
	} else {
		cta(str);
	}
};
String.prototype.trimTH = function() {
	return this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "");
};
String.prototype.trimStartTH = function() {
	return this.replace(/^[\s\xA0]+/, "");
};
String.prototype.trimEndTH = function() {
	return this.replace(/[\s\xA0]+$/, "");
};
String.prototype.equalsTH = function(s) {
	if (this.length != s.length) {
		return false;
	}
	for ( var i = 0; i < this.length; i += 1) {
		if (this.charAt(i) != s.charAt(i)) {
			return false;
		}
	}
	return true;
};
function Bva(p_startCaret, p_endCaret) {
	var arr = new Array();
	var jza = p_startCaret.node;
	var kza = p_endCaret.node;
	if (jza.nodeType != 3) {
		jza = Nma(jza, false);
		if (jza == null) {
			return arr;
		}
	}
	if (jza == kza) {
		if (jza.nodeType == 3) {
			var txt = jza.nodeValue;
			if (txt.length > 0 && p_startCaret.offset < txt.length
					&& p_endCaret.offset > 0
					&& p_endCaret.offset > p_startCaret.offset) {
				arr.push(jza);
			}
		}
	} else {
		if (jza.nodeType == 3) {
			var txt = jza.nodeValue;
			if (txt.length > 0 && p_startCaret.offset < txt.length) {
				arr.push(jza);
			}
		}
		var qza = Nna(jza, false, kza, true);
		while (qza != null) {
			if (qza == kza) {
				if (kza.nodeType == 3) {
					var txt = kza.nodeValue;
					if (txt.length > 0 && p_endCaret.offset > 0) {
						arr.push(kza);
					}
				}
				break;
			} else {
				arr.push(qza);
			}
			qza = Nna(qza, false, kza, true);
		}
	}
	return arr;
}
function Cva(p_range) {
	p_range.refresh();
	var arr = Bva(p_range.PAb, p_range.QAb);
	var str = "";
	for ( var i = 0; i < arr.length; i++) {
		str += arr[i].nodeValue;
	}
	return str;
}
var Dva = false;
function rw_setHighlight(p_startNode, p_startOffset, p_endNode, p_endOffset,
		p_strColour) {
	var Eva = p_startNode;
	var Fva = p_endNode;
	try {
		var result = null;
		if (p_endNode == p_startNode) {
			result = rw_setNodeBackground(p_startNode, p_startOffset,
					p_endOffset, "ss", p_strColour);
			Eva = result.node;
			Fva = result.node;
		} else {
			if (p_startOffset > 0) {
				result = rw_setNodeBackground(p_startNode, p_startOffset,
						p_startNode.nodeValue.length, "ss", p_strColour);
			} else {
				result = rw_setNodeBackground(p_startNode, -1, -1, "ss",
						p_strColour);
			}
			Eva = result.node;
			var qza = Nna(result.node, false, p_endNode, true);
			while (qza != null) {
				if (qza == p_endNode) {
					result = rw_setNodeBackground(qza, 0, p_endOffset, "ss",
							p_strColour);
					qza = result.node;
					Fva = qza;
					break;
				} else {
					result = rw_setNodeBackground(qza, -1, -1, "ss",
							p_strColour);
					qza = result.node;
				}
				Fva = qza;
				qza = Nna(qza, false, p_endNode, true);
			}
		}
	} catch (err) {
		cta("rw_setHighlight error:" + err.message);
	}
	return {
		start :Eva,
		end :Fva
	};
}
function Pva(p_arr) {
	try {
		if (p_arr == null || (p_arr instanceof Array) == false
				|| p_arr.length == 0) {
			return;
		}
		var Tva = 0;
		var jza = p_arr[0];
		var Vva = 0;
		var kza = p_arr[p_arr.length - 1];
		for ( var i = 0; i < p_arr.length; i++) {
			var tmp = p_arr[i];
			if (Rva(tmp)) {
				var iva = tmp.parentNode;
				var Yva = iva.parentNode;
				Yva.replaceChild(tmp, iva);
				p_arr[i] = tmp;
			}
		}
	} catch (err) {
		cta("rw_setHighlight error:" + err.message);
	}
}
function Rva(p_node) {
	if (p_node.nodeType != 3 || p_node.parentNode == null
			|| p_node.parentNode.parentNode == null) {
		return false;
	}
	var parent = p_node.parentNode;
	var Zva = parent.getAttribute("rwstate");
	if (parent.tagName.toLowerCase() != "font" || Zva == null || Zva != "ss") {
		return false;
	}
	return true;
}
function rw_removeSpeechHighlight(p_arr, p_bWord) {
	try {
		if (typeof (p_bWord) == "undefined") {
			p_bWord = false;
		}
		if (p_arr == null || (p_arr instanceof Array) == false
				|| p_arr.length == 0) {
			return;
		}
		var Tva = 0;
		var jza = p_arr[0];
		var Vva = 0;
		var kza = p_arr[p_arr.length - 1];
		for ( var i = 0; i < p_arr.length; i++) {
			var tmp = p_arr[i];
			if (ava(tmp, p_bWord)) {
				var iva = tmp.parentNode;
				if (tmp.nextSibling != null || tmp.previousSibling != null) {
					var txt = Kua(iva);
					var doc = iva.ownerDocument;
					tmp = doc.createTextNode(txt);
				}
				var Yva = iva.parentNode;
				Yva.replaceChild(tmp, iva);
			}
		}
	} catch (err) {
		cta("rw_removeSpeechHighlight failed error:" + err.message);
	}
}
function ava(p_node, p_bWord) {
	if (p_node.nodeType != 3 || p_node.parentNode == null
			|| p_node.parentNode.parentNode == null) {
		return false;
	}
	var parent = p_node.parentNode;
	var Zva = parent.getAttribute("rwstate");
	if (parent.tagName.toLowerCase() == "font" && Zva != null) {
		if ((p_bWord == false && Zva == "sp") || Zva == "csp") {
			return true;
		}
	}
	return false;
}
function rw_setSpeechRangeImpl(p_startNode, p_startOffset, p_endNode,
		p_endOffset, p_strState) {
	try {
		if (p_endNode == p_startNode) {
			var result = rw_setNodeBackground(p_startNode, p_startOffset,
					p_endOffset, p_strState, "");
			return;
		}
		var result;
		if (p_startOffset > 0) {
			result = rw_setNodeBackground(p_startNode, p_startOffset,
					p_startNode.nodeValue.length, p_strState, "");
		} else {
			result = rw_setNodeBackground(p_startNode, -1, -1, p_strState, "");
		}
		var qza = Nna(result.node, false, p_endNode, true);
		while (qza != null) {
			if (qza == p_endNode) {
				result = rw_setNodeBackground(qza, 0, p_endOffset, p_strState,
						"");
				qza = result.node;
				break;
			} else {
				result = rw_setNodeBackground(qza, -1, -1, p_strState, "");
				qza = result.node;
			}
			qza = Nna(qza, false, p_endNode, true);
		}
	} catch (err) {
		cta("rw_setSpeechRangeImpl error:" + err.message);
	}
}
function fva() {
	this.node = null;
	this.offset = 0;
}
function rw_setNodeBackground(p_textNode, p_nStartPt, p_nEndPt, p_state,
		p_strCol) {
	var res = new fva();
	res.node = p_textNode;
	res.offset = p_nStartPt;
	if (p_textNode.nodeType != 3) {
		if (p_textNode.nodeType == 1 && Rla(p_textNode)) {
			var gva = Nma(p_textNode, false);
			var hva = Pma(p_textNode, false);
			if (gva != null && gva.nodeType == 3 && hva != null
					&& hva.nodeType == 3) {
				rw_setSpeechRangeImpl(gva, 0, hva, hva.nodeValue.length,
						p_state);
				res.node = gva;
				res.offset = 0;
				return res;
			} else {
				return res;
			}
		} else {
			return res;
		}
	}
	var doc = p_textNode.ownerDocument;
	var iva = p_textNode.parentNode;
	var jva = null;
	if (iva.tagName.toLowerCase() == "font") {
		jva = iva.getAttribute("rwstate");
	}
	if (p_state == "ss") {
		if (jva == null || jva == "") {
			res = lva(iva, p_textNode, p_nStartPt, p_nEndPt, p_state, p_strCol);
		} else if (jva == "ss") {
			return res;
		} else {
			return res;
		}
	} else if (p_state == "sp") {
		if (jva == "csp") {
			cta("fail in rw_setNodeBackground setting sp to csp");
			return res;
		}
		if (jva == "sp") {
			cta("fail in rw_setNodeBackground setting sp to sp");
			return res;
		}
		res = lva(iva, p_textNode, p_nStartPt, p_nEndPt, p_state, "");
	} else if (p_state == "csp") {
		if (jva == "csp") {
			cta("fail parent is csp for csp");
			return res;
		}
		if (jva == "sp") {
			res = lva(iva, p_textNode, p_nStartPt, p_nEndPt, p_state, "");
		} else {
		}
	} else {
	}
	return res;
}
function lva(p_parentNode, p_textNode, p_nStartPt, p_nEndPt, p_state, p_strCol) {
	if (p_textNode.nodeType == 3 && (p_nEndPt == -1 || p_nEndPt > p_nStartPt)) {
		var doc = p_parentNode.ownerDocument;
		var mva = false;
		if (p_nStartPt == -1 && p_nEndPt == -1) {
			mva = true;
		} else if (p_nEndPt == -1) {
			p_nEndPt = p_textNode.nodeValue.length;
		}
		if (p_nStartPt == 0 && p_nEndPt >= p_textNode.nodeValue.length) {
			mva = true;
		}
		var nva;
		if (p_state == "ss") {
			nva = "background:" + p_strCol;
		} else if (p_state == "sp") {
			nva = "color:#000000; background:#FFFF00";
		} else if (p_state == "csp") {
			nva = "color:#FFFFFF; background:#0000FF";
		} else {
			nva = "color:#ff000; background:#00ff00";
		}
		if (mva) {
			var sva = doc.createElement("font");
			if (cda) {
				sva.style.setAttribute("cssText", nva, 0);
				sva.setAttribute("rwstate", p_state);
				if (p_state != "ss") {
					sva.setAttribute("started", "1");
				}
			} else {
				sva.setAttribute("STYLE", nva);
				sva.setAttribute("rwstate", p_state);
				if (p_state != "ss") {
					sva.setAttribute("started", "1");
				}
			}
			p_parentNode.replaceChild(sva, p_textNode);
			sva.appendChild(p_textNode);
		} else {
			var txt = p_textNode.nodeValue;
			var pva;
			var qva;
			var rva;
			if (p_parentNode.tagName.toLowerCase() == "span"
					&& p_parentNode.getAttribute("pron") != null) {
				pva = "";
				qva = txt;
				rva = "";
			} else {
				pva = txt.substring(0, p_nStartPt);
				qva = txt.substring(p_nStartPt, p_nEndPt);
				rva = txt.substring(p_nEndPt);
			}
			var sva = doc.createElement("font");
			if (cda) {
				sva.style.setAttribute("cssText", nva, 0);
				sva.setAttribute("rwstate", p_state);
				if (p_state != "ss") {
					sva.setAttribute("started", "1");
				}
			} else {
				sva.setAttribute("STYLE", nva);
				sva.setAttribute("rwstate", p_state);
				if (p_state != "ss") {
					sva.setAttribute("started", "1");
				}
			}
			var tva = null;
			var uva = null;
			var vva = null;
			if (pva.length > 0) {
				tva = doc.createTextNode(pva);
			}
			uva = doc.createTextNode(qva);
			if (rva.length > 0) {
				vva = doc.createTextNode(rva);
			}
			sva.appendChild(uva);
			p_parentNode.replaceChild(sva, p_textNode);
			if (tva != null) {
				p_parentNode.insertBefore(tva, sva);
			}
			if (vva != null) {
				if (sva.nextSibling == null) {
					p_parentNode.insertBefore(vva, null);
				} else {
					p_parentNode.insertBefore(vva, sva.nextSibling);
				}
			}
			p_textNode = uva;
		}
	}
	var res = new fva();
	res.node = p_textNode;
	if (p_nStartPt < 0) {
		res.offset = 0;
	} else {
		res.offset = p_nStartPt;
	}
	return res;
}
function yva(p_firstNode, p_secondNode) {
	if (p_firstNode == p_secondNode) {
		return 0;
	}
	var wva = ata();
	wva.setStart(p_firstNode, 0);
	wva.setEnd(p_firstNode, 0);
	var xva = ata();
	xva.setStart(p_secondNode, 0);
	xva.setEnd(p_secondNode, 0);
	return (wva.compareBoundaryPoints("START_TO_START", xva));
}
function zva() {
	this.txt = "";
	this.voice = null;
	this.OAb = null;
};
function Awa(p_node) {
	return Kwa(Ewa(p_node));
}
function Bwa(p_node) {
	if (p_node != null && p_node.nodeType == 1) {
		return Kwa(p_node.getAttribute("lang"));
	}
	return null;
}
function Ewa(p_node) {
	var Fwa = p_node;
	while (Fwa != null) {
		if (Fwa.nodeType == 1) {
			var Dwa = Fwa.getAttribute("lang");
			if (Dwa != null) {
				return Dwa;
			}
		}
		Fwa = Fwa.parentNode;
	}
	return null;
}
function Iwa(koa, loa, p_strOrigVoice) {
	var Fwa = koa;
	Fwa = Ima(Fwa, false, loa);
	while (Fwa != null) {
		var Gwa = Awa(Fwa);
		if (Gwa != p_strOrigVoice) {
			var Hwa = Cna(Fwa, false, koa);
			if (Hwa.nodeType == 3) {
				return new THCaret(Hwa, Hwa.nodeValue.length);
			} else {
				return new THCaret(Hwa, 0);
			}
		}
		Fwa = Ima(Fwa, false, loa);
	}
	return null;
}
function Kwa(p_strLang) {
	if (p_strLang != null) {
		var str = p_strLang.toLowerCase();
		var Jwa;
		if (str == "en" || str == "en-uk") {
			Jwa = ENGLISH;
		} else if (str == "en-us") {
			Jwa = ENGLISH_US;
		} else if (str == "es-us") {
			Jwa = SPANISH;
		} else if (str == "es" || str == "es-es") {
			Jwa = ESPANOL;
		} else if (str == "fr" || str == "fr-fr") {
			Jwa = FRENCH;
		} else if (str == "fr-ca") {
			Jwa = FRENCH_CN;
		} else {
			return null;
		}
		return uaa[Jwa];
	} else {
		return null;
	}
}
function Nwa(p_strVoice) {
	if (p_strVoice != null) {
		if (p_strVoice != sba) {
			sba = p_strVoice;
			var flash = rw_getWebToSpeech();
			flash.setVoiceName(sba);
		}
	} else {
		if (sba != null) {
			sba = null;
			var flash = rw_getWebToSpeech();
			flash.setVoiceName(iba);
		}
	}
}
function Owa(p_str) {
	if (nba == 200) {
		p_str = p_str.replace(/\s+/g, " ");
	} else {
		p_str = p_str.replace(
				/(\x3cbookmark\x20mark\x3d\x22(\d)+\x22\x2f\x3e)/g, "");
		p_str = p_str.replace(/[\s\xA0]+/g, " ");
	}
	return jwa(p_str);
}
function $rw_scholasticHashShort(p_asset) {
	var txt = p_asset.replace(/^0+|[^0-9]/g, "");
	return "0001".substring(0, 4 - txt.length) + txt.substring(0, 4);
}
function $rw_scholasticHash(p_asset) {
	var txt = p_asset.replace(/^0+|[^0-9]/g, "");
	if (txt.length < 4) {
		txt = "0001".substring(0, 4 - txt.length) + txt;
	} else {
		txt = txt.substring(0, 4);
	}
	return txt;
}
var Pwa = null;
function $rw_cachePage(p_strVoice, p_strSpeed, p_strBookName) {
	try {
		if (Uca) {
			eba_cacheResult = "failure: The embedded speech toolbar cannot be added due to invalid html tag markup in this page.";
			window.external.completed(eba_cacheResult);
			return eba_cacheResult;
		}
		if (nba == 300) {
			if (typeof (p_strBookName) == "string" && p_strBookName != null
					&& p_strBookName.length > 0) {
				lba = p_strBookName;
			} else {
				lba = "1";
			}
			mba = "1";
		}
		if (yba) {
			if (p_strSpeed != null) {
				$rw_setSpeedValue(parseInt(p_strSpeed));
			}
			if (p_strVoice != null) {
				$rw_setVoice(p_strVoice);
			}
			var Qwa = Rna(document.body);
			$rw_doSelection(-2);
			Vwa(Qwa);
		}
	} catch (err) {
		if (err.message != null) {
			eba_cacheResult = "failure:" + err.message;
		} else {
			eba_cacheResult = "failure:" + err;
		}
		window.external.completed(eba_cacheResult);
		return eba_cacheResult;
	}
	eba_cacheResult = "success";
	window.external.completed(eba_cacheResult);
	return "success";
}
function Vwa(p_sent) {
	while (p_sent != null) {
		Pwa = p_sent;
		var Rwa = Lla(p_sent, new Array());
		var txt = Rwa.txt;
		if (txt == null || txt.trimTH().length == 0) {
			Xwa();
			return;
		}
		var Swa = Owa(txt);
		var Twa = bwa();
		var flash = rw_getWebToSpeech();
		if (1 == 0) {
			flash.startSpeechCacheGenerationWithPronunciation(txt, iba, ""
					+ uba, Twa, Swa, kba, lba, mba);
		} else {
			window.external.Generate(txt, Twa, Swa);
			p_sent = gna(p_sent);
		}
	}
}
function Xwa() {
	if (Pwa != null) {
		var Wwa = gna(Pwa);
		if (Wwa != null) {
			Vwa(Wwa);
		} else {
			Zwa();
		}
	} else {
		Zwa();
	}
}
function Zwa() {
	var fwa = document.getElementById("pageComplete");
	if (fwa != null) {
		fwa.click();
	}
}
function awa(p_strText) {
	return cwa() + "/" + Owa(p_strText);
}
function bwa() {
	var str = iba.replace(" ", "_");
	if (Tca) {
		return dwa(kba + "\\" + lba + "\\" + $rw_scholasticHash(mba) + "\\"
				+ mba + "\\" + str + (uba));
	} else {
		return dwa(kba + "\\" + lba + "\\" + mba + "\\" + str + uba);
	}
}
function cwa() {
	var str = iba.replace(" ", "_");
	if (Tca) {
		return dwa(kba + "/" + lba + "/" + $rw_scholasticHash(mba) + "/" + mba
				+ "/" + str + uba);
	} else {
		return dwa(kba + "/" + lba + "/" + mba + "/" + str + uba);
	}
}
function dwa(p_str) {
	return p_str.replace(/[:*?\x22<>|]/g, "");
}
var ewa = "";
function $rw_speechCacheGenErrorHandler(p_strMsg) {
	ewa = p_strMsg;
	var fwa = document.getElementById("pageFailed");
	if (fwa != null) {
		fwa.click();
	}
}
function $rw_getLastError() {
	return ewa;
}/*
	 * The following code is derived from MD5 hash functions (c) Paul Johnston,
	 * http://pajhome.org.uk/crypt/md5/.
	 */
var gwa = 0;
var hwa = "";
var iwa = 8;
function jwa(s) {
	return zwa(kwa(xwa(s), s.length * iwa));
}
function kwa(x, len) {
	x[len >> 5] |= 0x80 << ((len) % 32);
	x[(((len + 64) >>> 9) << 4) + 14] = len;
	var a = 1732584193;
	var b = -271733879;
	var c = -1732584194;
	var d = 271733878;
	for ( var i = 0; i < x.length; i += 16) {
		var lwa = a;
		var mwa = b;
		var nwa = c;
		var owa = d;
		a = qwa(a, b, c, d, x[i + 0], 7, -680876936);
		d = qwa(d, a, b, c, x[i + 1], 12, -389564586);
		c = qwa(c, d, a, b, x[i + 2], 17, 606105819);
		b = qwa(b, c, d, a, x[i + 3], 22, -1044525330);
		a = qwa(a, b, c, d, x[i + 4], 7, -176418897);
		d = qwa(d, a, b, c, x[i + 5], 12, 1200080426);
		c = qwa(c, d, a, b, x[i + 6], 17, -1473231341);
		b = qwa(b, c, d, a, x[i + 7], 22, -45705983);
		a = qwa(a, b, c, d, x[i + 8], 7, 1770035416);
		d = qwa(d, a, b, c, x[i + 9], 12, -1958414417);
		c = qwa(c, d, a, b, x[i + 10], 17, -42063);
		b = qwa(b, c, d, a, x[i + 11], 22, -1990404162);
		a = qwa(a, b, c, d, x[i + 12], 7, 1804603682);
		d = qwa(d, a, b, c, x[i + 13], 12, -40341101);
		c = qwa(c, d, a, b, x[i + 14], 17, -1502002290);
		b = qwa(b, c, d, a, x[i + 15], 22, 1236535329);
		a = rwa(a, b, c, d, x[i + 1], 5, -165796510);
		d = rwa(d, a, b, c, x[i + 6], 9, -1069501632);
		c = rwa(c, d, a, b, x[i + 11], 14, 643717713);
		b = rwa(b, c, d, a, x[i + 0], 20, -373897302);
		a = rwa(a, b, c, d, x[i + 5], 5, -701558691);
		d = rwa(d, a, b, c, x[i + 10], 9, 38016083);
		c = rwa(c, d, a, b, x[i + 15], 14, -660478335);
		b = rwa(b, c, d, a, x[i + 4], 20, -405537848);
		a = rwa(a, b, c, d, x[i + 9], 5, 568446438);
		d = rwa(d, a, b, c, x[i + 14], 9, -1019803690);
		c = rwa(c, d, a, b, x[i + 3], 14, -187363961);
		b = rwa(b, c, d, a, x[i + 8], 20, 1163531501);
		a = rwa(a, b, c, d, x[i + 13], 5, -1444681467);
		d = rwa(d, a, b, c, x[i + 2], 9, -51403784);
		c = rwa(c, d, a, b, x[i + 7], 14, 1735328473);
		b = rwa(b, c, d, a, x[i + 12], 20, -1926607734);
		a = swa(a, b, c, d, x[i + 5], 4, -378558);
		d = swa(d, a, b, c, x[i + 8], 11, -2022574463);
		c = swa(c, d, a, b, x[i + 11], 16, 1839030562);
		b = swa(b, c, d, a, x[i + 14], 23, -35309556);
		a = swa(a, b, c, d, x[i + 1], 4, -1530992060);
		d = swa(d, a, b, c, x[i + 4], 11, 1272893353);
		c = swa(c, d, a, b, x[i + 7], 16, -155497632);
		b = swa(b, c, d, a, x[i + 10], 23, -1094730640);
		a = swa(a, b, c, d, x[i + 13], 4, 681279174);
		d = swa(d, a, b, c, x[i + 0], 11, -358537222);
		c = swa(c, d, a, b, x[i + 3], 16, -722521979);
		b = swa(b, c, d, a, x[i + 6], 23, 76029189);
		a = swa(a, b, c, d, x[i + 9], 4, -640364487);
		d = swa(d, a, b, c, x[i + 12], 11, -421815835);
		c = swa(c, d, a, b, x[i + 15], 16, 530742520);
		b = swa(b, c, d, a, x[i + 2], 23, -995338651);
		a = twa(a, b, c, d, x[i + 0], 6, -198630844);
		d = twa(d, a, b, c, x[i + 7], 10, 1126891415);
		c = twa(c, d, a, b, x[i + 14], 15, -1416354905);
		b = twa(b, c, d, a, x[i + 5], 21, -57434055);
		a = twa(a, b, c, d, x[i + 12], 6, 1700485571);
		d = twa(d, a, b, c, x[i + 3], 10, -1894986606);
		c = twa(c, d, a, b, x[i + 10], 15, -1051523);
		b = twa(b, c, d, a, x[i + 1], 21, -2054922799);
		a = twa(a, b, c, d, x[i + 8], 6, 1873313359);
		d = twa(d, a, b, c, x[i + 15], 10, -30611744);
		c = twa(c, d, a, b, x[i + 6], 15, -1560198380);
		b = twa(b, c, d, a, x[i + 13], 21, 1309151649);
		a = twa(a, b, c, d, x[i + 4], 6, -145523070);
		d = twa(d, a, b, c, x[i + 11], 10, -1120210379);
		c = twa(c, d, a, b, x[i + 2], 15, 718787259);
		b = twa(b, c, d, a, x[i + 9], 21, -343485551);
		a = uwa(a, lwa);
		b = uwa(b, mwa);
		c = uwa(c, nwa);
		d = uwa(d, owa);
	}
	return Array(a, b, c, d);
}
function pwa(q, a, b, x, s, t) {
	return uwa(vwa(uwa(uwa(a, q), uwa(x, t)), s), b);
}
function qwa(a, b, c, d, x, s, t) {
	return pwa((b & c) | ((~b) & d), a, b, x, s, t);
}
function rwa(a, b, c, d, x, s, t) {
	return pwa((b & d) | (c & (~d)), a, b, x, s, t);
}
function swa(a, b, c, d, x, s, t) {
	return pwa(b ^ c ^ d, a, b, x, s, t);
}
function twa(a, b, c, d, x, s, t) {
	return pwa(c ^ (b | (~d)), a, b, x, s, t);
}
function uwa(x, y) {
	var lsw = (x & 0xFFFF) + (y & 0xFFFF);
	var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
	return (msw << 16) | (lsw & 0xFFFF);
}
function vwa(num, cnt) {
	return (num << cnt) | (num >>> (32 - cnt));
}
function xwa(str) {
	var bin = Array();
	var mask = (1 << iwa) - 1;
	for ( var i = 0; i < str.length * iwa; i += iwa) {
		bin[i >> 5] |= (str.charCodeAt(i / iwa) & mask) << (i % 32);
	}
	return bin;
}
function zwa(binarray) {
	var ywa = gwa ? "0123456789ABCDEF" : "0123456789abcdef";
	var str = "";
	for ( var i = 0; i < binarray.length * 4; i++) {
		str += ywa.charAt((binarray[i >> 2] >> ((i % 4) * 8 + 4)) & 0xF)
				+ ywa.charAt((binarray[i >> 2] >> ((i % 4) * 8)) & 0xF);
	}
	return str;
}
