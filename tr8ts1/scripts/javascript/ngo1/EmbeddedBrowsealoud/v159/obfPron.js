function $rw_barPronInit(p_strCustId, p_strBookId, p_strPageId){ if(Wea) { document.writeln("<link href=\"" + $g_strFileLoc + "VLEpronIE.css\" type=\"text/css\" rel=\"stylesheet\">"); } else if(Yea) { document.writeln("<link href=\"" + $g_strFileLoc + "VLEpronS.css\" type=\"text/css\" rel=\"stylesheet\">"); } else { document.writeln("<link href=\"" + $g_strFileLoc + "VLEpronFF.css\" type=\"text/css\" rel=\"stylesheet\">"); } var gEb = ""; gEb += "<form class=\"rwPrScreen\" rwTHcomp=\"1\" >" + " <input TYPE=\"hidden\" id=\"createCustId\" VALUE=\"" + p_strCustId + "\">" + " <input TYPE=\"hidden\" id=\"createBookId\" VALUE=\"" + p_strBookId + "\">" + " <input TYPE=\"hidden\" id=\"createPageId\" VALUE=\"" + p_strPageId + "\">" + " <div id=\"rwPronCreate\" class=\"rwPronContent\" style=\"visibility:hidden\" texthelpStopContinuous>" + "  <div id=\"rwDragMePronCreate\" style='cursor:move'>" + "   <a href=\"javascript:void(0)\" onmouseover = \"if (document.images) { rwCloseCreate.src = close2.src } \"" + "       onmouseout = \"if (document.images) { rwCloseCreate.src = close1.src }\" " + "       onclick=\"$rw_closePronCreate();return false\">" + "    <img ignore id=\"rwCloseCreate\" src=\"" + $g_strFileLoc + "vleimgs/close_off.gif\" " + "        style=\"margin:0;border:0;position:relative;top:0px;right:-1px;\" " + "        alt=\"Close button\" title=\"Close Create Pronunciation Form\" name=\"rwCloseCreate\" align=\"right\" />" + "   </a>" + "  </div>" + "  <table width=\"220\" cellspacing=\"8\" " + "      cellpadding=\"0\">" + "   <tr>" + "    <td width=\"167\">" + "     <span>Say this:</span>" + "     <input TYPE=\"text\" id=\"createSayThis\" size=\"28\">" + "    </td>" + "    <td valign=\"bottom\"><img ignore border=\"0\" " + "        onClick=\"callFlashSpeechNoPron(document.getElementById('createSayThis').value);\" alt=\"Speaker\" title=\"Click To Speak Pronunciation\"" + "        src=\"" + $g_strFileLoc + "vleimgs/speaker.gif\" onmouseover=\"roll(this, '" + $g_strFileLoc + "/vleimgs/speaker_on.gif')\" " + "        onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker.gif')\" />" + "    </td>" + "   </tr>" + "   <tr>" + "    <td width=\"167\"><span>Like this:</span><input id=\"createLikeThis\" size=\"28\">" + "    </td>" + "    <td valign=\"bottom\">" + "     <img ignore border=\"0\" " + "         onClick=\"callFlashSpeechNoPron(document.getElementById('createLikeThis').value);\" " + "         alt=\"Speaker\" title=\"Click To Speak Pronunciation\" " + "         src=\"" + $g_strFileLoc + "vleimgs/speaker.gif\" " + "         onmouseover=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker_on.gif')\" " + "         onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker.gif')\" />" + "    </td>" + "   </tr>" + "   <tr>" + "    <td><input type=\"checkbox\" id=\"createAllPages\" value=\"true\"><span>All pages in book</span>" + "    </td>" + "    <td></td>" + "   </tr>" + "   <tr>" + "    <td colspan=\"2\">" + "     <table>" + "      <tr>" + "       <td width=150 class=\"message\">" + "        <div id=\"confirmPageMsg\">" + "        </div>" + "       </td>" + "       <td>" + "        <img ignore src=\"" + $g_strFileLoc + "vleimgs/insert.gif\" border=\"0\" " + "            alt=\"Create pronunciation button\" title=\"Create Pronunciation\" " + "            onClick=\"createPron(document.getElementById('createCustId').value, " + "document.getElementById('createBookId').value, " + "document.getElementById('createPageId').value, " + "document.getElementById('createSayThis').value, " + "document.getElementById('createLikeThis').value, " + "document.getElementById('createAllPages').checked);\" " + "            onmouseover=\"roll(this, '" + $g_strFileLoc + "vleimgs/insert_on.gif')\" " + "            onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/insert.gif')\" />" + "       </td>" + "      </tr>" + "     </table>" + "    </td>" + "   </tr>" + "  </table>   " + " </div>" + "</form>"; document.writeln(gEb); var hEb; var iEb = false; try { var jEb = parseInt(p_strCustId); iEb = Wea && (jEb >= 100 && jEb < 200); } catch(err) { iEb = false; } if(iEb) { hEb = 28; } else { hEb = Wea?29:28; } gEb = "<FORM class=\"rwPrScreen\" rwTHcomp=\"1\" id=\"theEditform\" style=\"visible:hidden\">" + " <input TYPE=\"hidden\" id=\"editCustId\" VALUE=\"" + p_strCustId + "\">" + " <input TYPE=\"hidden\" id=\"editBookId\" VALUE=\"" + p_strBookId + "\">" + " <input TYPE=\"hidden\" id=\"editPageId\" VALUE=\"" + p_strPageId + "\">" + " <div id=\"rwPronEdit\" class=\"" + (iEb?"create_edit_nimas":"rwPronContent") + "\" style=\"visibility:hidden\" texthelpStopContinuous>" + "  <div id=\"rwDragMePronEdit\" style='cursor:move'>" + "   <a href=\"javascript:void(0)\" onmouseover=\"if (document.images) { rwCloseEdit.src = close2.src; } \"" + "       onmouseout=\"if (document.images) { rwCloseEdit.src = close1.src; }\"" + "       onclick=\"$rw_closePronEdit();return false;\">" + "    <img ignore id=\"rwCloseEdit\" src=\"" + $g_strFileLoc + "vleimgs/close_off.gif\" " + "        style=\"margin:0;border:0;position:relative;top:0px;right:-1px;\"" + "        alt=\"Close button\" title=\"Close Edit Pronunciation Form\" name=\"rwCloseEdit\" align=\"right\"/>" + "   </a>" + "  </div>" + "  <table border=0 cellspacing=\"0\" bgcolor=\"#ECE9D8\" height=\"100%\" cellpadding=\"0\">" + "   <tr>" + "    <td valign=TOP>" + "     <table width=\"212\" cellspacing=\"8\" "+ "         bgcolor=\"#ECE9D8\" cellpadding=\"0\">" + "      <tr>" + "       <td width=\"212\">" + "        <span>Say this (Read only):</span>" + "        <span style=\"font-size: 9pt\">" + "         <input class=\"input\" id=\"editSayThis\" " + "             onKeyUp=\"OnChangedURL();\" DISABLED" + "             size=\"" + hEb + "\">" + "        </span>" + "       </td>" + "       <td valign=\"bottom\">" + "        <img ignore border=\"0\" " + "            alt=\"Speaker\" title=\"Speak Pronunciation\" src=\"" + $g_strFileLoc + "vleimgs/speaker.gif\"" + "            onclick=\"callFlashSpeechNoPron(document.getElementById('editSayThis').value);\"" + "            onmouseover=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker_on.gif');\"" + "            onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker.gif');\" />" + "       </td>" + "      </tr>" + "      <tr>" + "       <td width=\"212\">" + "        <span>Like this:</span>" + "        <input id=\"editLikeThis\" class=\"input\" size=\"" + hEb + "\">" + "       </td>" + "       <td valign=\"bottom\">" + "        <p align=\"center\">" + "         <img ignore border=\"0\" alt=\"Speaker\" title=\"Speak Pronunciation\" src=\"" + $g_strFileLoc + "vleimgs/speaker.gif\"" + "             onclick=\"callFlashSpeechNoPron(document.getElementById('editLikeThis').value);\"" + "             onmouseover=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker_on.gif');\"" + "             onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/speaker.gif');\" />" + "        </p>"+ "       </td>" + "      </tr>" + "      <tr>" + "       <td><input type=\"checkbox\" id=\"editAllPages\" value=\"false\" DISABLED>All pages in book" + "       </td>" + "       <td></td>" + "      </tr>" + "      <tr>" + "       <td colspan=2>" + "        <table>" + "         <tr>" + "          <td width=150 class=\"message\">" + "           <div id=\"editPageMsg\"></div>" + "          </td>" + "          <td>" + "           <div ID=\"updateButton\" style=\"display:none\">" + "            <img ignore src=\"" + $g_strFileLoc + "vleimgs/update.gif\" border=0 " + "                alt=\"Update pronunciation button\" title=\"Update Pronunciation\" " + "                onClick=\"updatePron(document.getElementById('editSayThis').value, " + "document.getElementById('editLikeThis').value, " + "document.getElementById('editCustId').value, " + "document.getElementById('editBookId').value, " + "document.getElementById('editPageId').value, " + "document.getElementById('editAllPages').checked);\"" + "                onmouseover=\"roll(this, '" + $g_strFileLoc + "vleimgs/update_on.gif');\"" + "                onmouseout=\"roll(this, '" + $g_strFileLoc + "vleimgs/update.gif');\" />" + "           </div>" + "          </td>" + "         </tr>" + "        </table>" + "       </td>" + "      </tr>" + "     </table>" + "    </td>" + "    <td>" + "     <table id=\"proneditlist\" border=0 height=\"160\" cellspacing=\"1\" width=\"433\" bgcolor=\"#ECE9D8\" cellpadding=\"0\">" + "      <tr>" + "       <td valign align=\"top\">" + "        <TABLE border=\"0\" width=\"433\" cellspacing=\"0\" cellpadding=\"2\" class=\"tblProns\">" + "         <COL WIDTH=164>" + "         <COL WIDTH=164>" + "         <COL WIDTH=48>" + "         <COL WIDTH=60>" + "         <tr height=24>" + "          <td bgcolor=\"#c9c7b8\">&nbsp;Say this</td>" + "          <td bgcolor=\"#c9c7b8\">&nbsp;Like this</td>" + "          <td bgcolor=\"#c9c7b8\">&nbsp;Actions</td>" + "          <td bgcolor=\"#c9c7b8\">&nbsp;All pages</td>" + "         </tr>" + "        </TABLE>" + "       </td>" + "       <td></td>" + "      </tr>" + "      <tr>" + "       <td>" + "        <div class=\"pronList\">" + "         <div id=\"pronsAvail\"></div>" + "        </div>" + "       </td>" + "      </tr>" + "     </table>" + "    </td>" + "   </tr>" + "  </table>" + " </div>" + "</form>"; document.writeln(gEb);}if(rba != null && sba != null && tba != null){ $rw_barPronInit(rba, sba, tba);}function $rw_setCustomerId(p_strVal){ try { rba = p_strVal; var flash = rw_getWebToSpeech(); if(flash != null) { flash.setCustomerId(p_strVal); } var vEb = document.getElementById("createCustId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editCustId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editPageMsg"); if(vEb != null) { vEb.innerHTML = ""; } HFb(rba, sba, tba); } catch(ignore) { }}function $rw_setBookId(p_strVal){ try { sba = p_strVal; var flash = rw_getWebToSpeech(); if(flash != null) { flash.setBookId(p_strVal); } var vEb = document.getElementById("createBookId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editBookId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editPageMsg"); if(vEb != null) { vEb.innerHTML = ""; } HFb(rba, sba, tba); } catch(ignore) { }}function $rw_setPageId(p_strVal){ try { tba = p_strVal; var flash = rw_getWebToSpeech(); if(flash != null) { flash.setPageId(p_strVal); } var vEb = document.getElementById("createPageId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editPageId"); if(vEb != null) { vEb.value = "" + p_strVal; } vEb = document.getElementById("editPageMsg"); if(vEb != null) { vEb.innerHTML = ""; } HFb(rba, sba, tba); } catch(ignore) { }}var qEb = false;var rEb = false;function $rw_event_pronCreate(){ if(rEb) { $rw_closePronEdit(); } var sEb; if(gea) { var flash = Dta(eea); hea = true; if(flash == null) { return; } sEb = flash.clickOnDictionary(); flash.focus(); } else { sEb = qta(); } sEb = Jva(sEb); if(sEb.length > 0) { document.getElementById("createSayThis").value = sEb; } bia(true, Uea); qEb = true; }function $rw_event_pronEdit(){ if(qEb) { $rw_closePronCreate(); } bia(true, Vea); rEb = true;}function $rw_closePronCreate(){ try { var vEb = document.getElementById("createSayThis"); if(vEb != null) { vEb.value = ""; } vEb = document.getElementById("createLikeThis"); if(vEb != null) { vEb.value = ""; } document.getElementById("confirmPageMsg").innerHTML = ''; bia(false, Uea); qEb = false; } catch(ignore) { }}function $rw_closePronEdit(){ try { var vEb = document.getElementById("editSayThis"); if(vEb != null) { vEb.value = ""; } vEb = document.getElementById("editLikeThis"); if(vEb != null) { vEb.value = ""; } document.getElementById("editPageMsg").innerHTML = ''; RFb(); bia(false, Vea); rEb = false; } catch(ignore) { }}var wEb = "createPron deletePron editPron updatePron roll callFlashSpeech callFlashSpeechNoPron";if(document.images){ close1 = new Image(); close1.src = $g_strFileLoc + "vleimgs/close_off.gif"; close2 = new Image(); close2.src = $g_strFileLoc + "vleimgs/close_on.gif";}var xEb = false;function BFb(txt){ if(txt == null) { return false; } for(var i = 0; i < txt.length; i++) { var yEb = txt.charCodeAt(i); if(!((yEb > 47 && yEb < 58) || (yEb > 64 && yEb < 91) || (yEb > 96 && yEb < 123) || yEb == 32 || yEb == 39 || yEb == 45 || yEb == 95 || yEb > 127)) { return false; } } return true;}function createPron(p_custID, p_bookID, p_pageID, p_sayThis, p_likeThis, p_allPages){ var LFb = p_sayThis.trimTH(); var NFb = p_likeThis.trimTH(); if(LFb == null || LFb == "") { Bwa('Phrases should have 1 to 3 words, please re-enter a say this phrase.'); document.getElementById('createSayThis').focus(); return; } if(!BFb(LFb)) { Bwa('Your say this entry contains invalid characters, please re-enter.'); document.getElementById('createSayThis').focus(); return; } if(NFb == null || NFb == "") { Bwa('Phrases should have 1 to 3 words, please re-enter a like this phrase.'); document.getElementById('createLikeThis').focus(); return; } if(!BFb(LFb)) { Bwa('Your like this entry contains invalid characters, please re-enter.'); document.getElementById('createLikeThis').focus(); return; } var OFb = LFb.split(/\s+/g); var PFb = NFb.split(/\s+/g); if(OFb.length > 3) { Bwa('Phrases can only have up 3 phonetic words, please re-enter.'); document.getElementById('createSayThis').focus(); return; } if(OFb.length == 1 && PFb.length > 3) { Bwa('Phrases with 1 word can only have up 3 phonetic words, please re-enter.'); document.getElementById('createLikeThis').focus(); return; } if(OFb.length == 2 && (!(PFb.length == 2))) { Bwa('Phrases with 2 words can only have 2 phonetic words, please re-enter.'); document.getElementById('createLikeThis').focus(); return; } if(OFb.length == 3 && (!(PFb.length == 3))) { Bwa('Phrases with 3 words can only have up 3 phonetic words, please re-enter.'); document.getElementById('createLikeThis').focus(); return; } var QFb = document.createElement("script"); QFb.type = "text/javascript"; if(xEb) { QFb.src = "http://www.texthelp.com/RWOnlinePron/vle_create_post.asp?" + "custID=" + p_custID + "&bookID=" +p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(document.getElementById('createSayThis').value) + "&likeThis=" + escape(document.getElementById('createLikeThis').value) + "&allPages=" + p_allPages + "&serverName=" + escape(jba); } else { QFb.src = "http://" + iba + "/RWPronServer?" + "cmd=" + "createPron" + "&domain=" + escape(jba) + "&serverName=" + "SpeechNAServer" + "&custID=" + p_custID + "&bookID=" +p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(LFb) + "&likeThis=" + escape(NFb) + "&allPages=" + p_allPages; } document.body.appendChild(QFb);}function $vleCreatePostAspReply(p_str){ $vleCreateJSReply(p_str);}function $vleCreateJSReply(p_str){ try { if(p_str == "Pronunciation inserted") { document.getElementById('createSayThis').value = ''; document.getElementById('createLikeThis').value = ''; } document.getElementById("confirmPageMsg").innerHTML = p_str; HFb(rba, sba, tba); } catch(ignore) { }}function HFb(p_custID, p_bookID, p_pageID){ var QFb = document.createElement("script"); QFb.type = "text/javascript"; if(xEb) { QFb.src = "http://www.texthelp.com/RWOnlinePron/vle_edit_list.asp?" + "custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&serverName=" + escape(jba); document.body.appendChild(QFb); } else { QFb.src = "http://" + iba + "/RWPronServer?" + "cmd=" + "getPron" + "&domain=" + escape(jba) + "&serverName=" + "SpeechNAServer" + "&custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&imagePath=" + "http://" + iba + "/" + nba + "/v" + eba; document.body.appendChild(QFb); }}function $vleEditListAspReply(p_str){ try { document.getElementById("pronsAvail").innerHTML = p_str; } catch(ignore) { }}function $vleEditListJavaReply(p_str){ try { document.getElementById("pronsAvail").innerHTML = p_str; } catch(ignore) { }}function deletePron(p_custID, p_bookID, p_pageID, p_pron, p_allPages){ document.getElementById('editSayThis').value = ''; document.getElementById('editLikeThis').value = ''; RFb(); var QFb = document.createElement("script"); QFb.type = "text/javascript"; if(xEb) { QFb.src = "http://www.texthelp.com/RWOnlinePron/vle_edit_delete.asp?" + "custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(p_pron) + "&allPages=" + p_allPages + "&serverName=" + escape(jba); document.body.appendChild(QFb); } else { QFb.src = "http://" + iba + "/RWPronServer?" + "cmd=" + "deletePron" + "&domain=" + escape(jba) + "&serverName=" + "SpeechNAServer" + "&custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(p_pron) + "&allPages=" + p_allPages; document.body.appendChild(QFb); }}function $vleEditDeleteAspReply(p_src){ $vleDeleteJSReply(p_src);}function $vleDeleteJSReply(p_src){ try { document.getElementById("editPageMsg").innerHTML = p_src; HFb(rba, sba, tba); } catch(ignore) { }}function editPron(p_sayThis, p_likeThis, p_allPages){ try { document.getElementById("editPageMsg").innerHTML = ''; document.getElementById('editSayThis').value = p_sayThis; document.getElementById('editLikeThis').value = p_likeThis; document.getElementById('editAllPages').checked = p_allPages; SFb(); } catch(ignore) { }}function updatePron(p_sayThis, p_likeThis, p_custID, p_bookID, p_pageID, p_allPages){ var LFb = p_sayThis.replace(/^\s+|\s+$/g, ""); var NFb = p_likeThis.replace(/^\s+|\s+$/g, ""); if(NFb == null || NFb == "") { Bwa('Phrases should have 1 to 3 words, please re-enter a like this phrase.'); document.getElementById('editLikeThis').focus(); return; } if(!BFb(NFb)) { Bwa('Your like this entry contains invalid characters.'); document.getElementById('editLikeThis').focus(); return; } var OFb = LFb.split(/\s+/g); var PFb = NFb.split(/\s+/g); if(OFb.length > 3) { Bwa('Phrases can only have up 3 phonetic words, please re-enter.'); document.getElementById('editSayThis').focus(); return; } if(OFb.length == 1 && PFb.length > 3) { Bwa('Phrases with 1 word can only have up 3 phonetic words, please re-enter.'); document.getElementById('editLikeThis').focus(); return; } if(OFb.length == 2 && (!(PFb.length == 2))) { Bwa('Phrases with 2 words can only have 2 phonetic words, please re-enter.'); document.getElementById('editLikeThis').focus(); return; } if(OFb.length == 3 && (!(PFb.length == 3))) { Bwa('Phrases with 3 words can only have up 3 phonetic words, please re-enter.'); document.getElementById('editLikeThis').focus(); return; } var QFb = document.createElement("script"); QFb.type = "text/javascript"; if(xEb) { QFb.src = "http://www.texthelp.com/RWOnlinePron/vle_edit_post.asp?" + "custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(document.getElementById('editSayThis').value) + "&likeThis=" + escape(document.getElementById('editLikeThis').value) + "&allPages=" + document.getElementById('editAllPages').checked + "&serverName=" + escape(jba); document.body.appendChild(QFb); } else { QFb.src = "http://" + iba + "/RWPronServer?" + "cmd=" + "editPron" + "&domain=" + escape(jba) + "&serverName=" + "SpeechNAServer" + "&custID=" + p_custID + "&bookID=" + p_bookID + "&pageID=" + p_pageID + "&sayThis=" + escape(LFb) + "&likeThis=" + escape(NFb) + "&allPages=" + document.getElementById('editAllPages').checked; document.body.appendChild(QFb); }}function $vleEditPostAspReply(p_str){ try { $vleEditJSReply(p_str); } catch(ignore) { }}function $vleEditJSReply(p_str){ try { document.getElementById("editPageMsg").innerHTML = p_str; HFb(rba, sba, tba); } catch(ignore) { }}function RFb(){ try { if(document.getElementById) { document.getElementById('updateButton').style.display = 'none'; } } catch(ignore) { }}function SFb(){ if(document.getElementById) { document.getElementById('updateButton').style.display = 'inline'; }}function roll(p_img, p_img_src){ p_img.src = p_img_src; }function callFlashSpeech(p_txt){ if(Gca) { Bwa("The pronunciation screen should not be enabled on this page with cached speech.  Changes made to pronunciations here will have no effect."); return; } var d = new Date(); var YFb = d.getTime(); if(YFb < (Tla + 500)) { return; } Tla = YFb; var flash = rw_getWebToSpeech(); if(flash != null) { flash.startSpeech(p_txt); }}function callFlashSpeechNoPron(p_txt){ if(p_txt != null && typeof(p_txt) == "string" && p_txt.length > 0) { var d = new Date(); var YFb = d.getTime(); if(YFb < (Tla + 500)) { return; } Tla = YFb; try { var flash = rw_getWebToSpeech(); if(flash != null) { flash.noPronSpeech(p_txt); } } catch(ignore) { try{window.status = "Speech failed due to the page using an old version of the WebToSpeech swf.";}catch(ignore){} } }}setTimeout("vlepronstart();", 200);function vlepronstart(){ HFb(rba, sba, tba);}