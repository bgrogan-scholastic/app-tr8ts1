function $rw_barStickyInit(){ var eCb = 500; if(Wea) { if(mea == "xtran") { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickyxtranie.css\" type=\"text/css\" rel=\"stylesheet\">"); } else { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickyie.css\" type=\"text/css\" rel=\"stylesheet\">"); } } else if(Yea) { if(mea == "xtran") { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickyxtrans.css\" type=\"text/css\" rel=\"stylesheet\">"); } else { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickys.css\" type=\"text/css\" rel=\"stylesheet\">"); } } else { if(mea == "xtran") { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickyxtranff.css\" type=\"text/css\" rel=\"stylesheet\">"); } else { document.writeln("<link href=\"" + $g_strFileLoc + "rwstickyff.css\" type=\"text/css\" rel=\"stylesheet\">"); } } var gEb = ""; gEb += "<div id=\"rwSticky\" " + baa + "=\"1\" style=\"visibility:hidden;\">" + "    <div id='rwDragMeStickyNoteTop' class='sticky_bar_top'>"; if(Sca) { } else { gEb += "        <A HREF=\"link: close\"" + "                onMouseDown=\"if (document.images) " + "{ rw_stickyNoteCloseImg.src = $rw_stickyNoteCloseImg2.src; }\"" + "                onMouseOut=\"if (document.images) " + "{ rw_stickyNoteCloseImg.src = $rw_stickyNoteCloseImg1.src; }\"" + "                onclick=\"$rw_closeStickyNote(event);return false;\">" + "           <IMG style=\"margin:1px;border:0px none;\" ID=\"closeStickyNote\" SRC=\"" + $g_strFileLoc + "rwimgs/close_off.gif\"" + "                alt=\"Close note\" title=\"Close note\" ignore=\"1\" name=\"rw_stickyNoteCloseImg\" />"; } gEb += "        </A>" + "    </div>" + "    <div id=\"innerStickyNote\" align=\"center\">" + "        <textarea id=\"stickyNoteText\" cols=\"1\" rows=\"1\" "; if(Sca) { gEb += "                  onKeyPress=\"var c =event.keyCode;limitText(this," + eCb + ");\"" + "                  onKeyUp=\"limitText(this," + eCb + ");\"" + "                  onMousePress=\"limitText(this, " + eCb + ");\"" + "                  onChange=\"limitText(this, " + eCb + ");\"" + "                  onBlur=\"g_speakableTextAreaTarget = this; " + "if(g_nSpeakableTextAreaTimerId != 0)" + "{" + "clearTimeout(g_nSpeakableTextAreaTimerId);" + "}" + "g_nSpeakableTextAreaTimerId = setTimeout('" + "g_speakableTextAreaTarget = null; " + "g_nSpeakableTextAreaTimerId = 0;', " + wda + "); " + "limitText(this, "+ eCb +");\""; } else { gEb += "readonly=\"readonly\"" + "                  onBlur=\"g_speakableTextAreaTarget = this; " + "if(g_nSpeakableTextAreaTimerId != 0)" + "{" + "clearTimeout(g_nSpeakableTextAreaTimerId);" + "}" + "g_nSpeakableTextAreaTimerId = setTimeout('" + "g_speakableTextAreaTarget = null; " + "g_nSpeakableTextAreaTimerId = 0;', " + wda + "); " + "\""; } gEb += ">" + "        </textarea>" + "    </div>" + "    <div id='rwDragMeStickyNoteBot' class='sticky_bar'>"; if(Sca) { gEb += "      &nbsp;<img src=\"" + $g_strFileLoc + "rwimgs/delete.gif\" " + "id=\"removebuttonimg\" alt=\"\" " + "name=rw_stickyNoteRemoveImg " + "        onMouseDown=\"if (document.images) " + "{ rw_stickyNoteRemoveImg.src = $rw_stickyNoteRemoveImg2.src; }\"" + "        onMouseUp=\"if (document.images) " + "{ rw_stickyNoteRemoveImg.src = $rw_stickyNoteRemoveImg1.src; }\"" + "        onMouseOut=\"if (document.images) " + "{ rw_stickyNoteRemoveImg.src = $rw_stickyNoteRemoveImg1.src; }\"" + "        onclick=\"$rw_removeStickyNote(event);return false;\"" + "      />"; gEb += "<img src=\"" + $g_strFileLoc + "rwimgs/spacer.gif\" width=\"110px\" height=\"10px;\" />"; gEb += "      <img  src=\"" + $g_strFileLoc + "rwimgs/save.gif\" " + "id=\"saveclosebuttonimg\" alt=\"\" " + "name=rw_stickyNoteSaveCloseImg " + "        onMouseDown=\"if (document.images) " + "{ rw_stickyNoteSaveCloseImg.src = $rw_stickyNoteSaveCloseImg2.src; }\"" + "        onMouseUp=\"if (document.images) " + "{ rw_stickyNoteSaveCloseImg.src = $rw_stickyNoteSaveCloseImg1.src; }\"" + "        onMouseOut=\"if (document.images) " + "{ rw_stickyNoteSaveCloseImg.src = $rw_stickyNoteSaveCloseImg1.src; }\"" + "        onclick=\"$rw_closeStickyNote(event);return false;\"" + "      />"; } else { } gEb += "    </div>" + "</div>"; document.writeln(gEb);}$rw_barStickyInit();var gCb = "texthelpnote";var hCb = "texthelpnoteid";var iCb = 20;var jCb = "cmd";var kCb = "add";var lCb = "delete";var mCb = "retrieve";var nCb = "addss";var oCb = "retrievess";var pCb = 0;var qCb = -1;var rCb = null;function tCb(event){ var YEb = fqa(event); vCb(YEb, -1, null, true);}; function vCb(p_thCaret, p_nDefaultId, p_strDefaultText, p_bAutoOpen){ if(p_thCaret != null && p_thCaret.node != null && p_thCaret.node.parentNode != null) { if(KDb(p_thCaret.node)) { var uCb = document.getElementsByName(gCb); if(uCb.length > iCb) { Bwa("The limit of " + iCb + " notes per page has been reached."); return; } var nId; if(p_nDefaultId == -1) { ++pCb; nId = pCb; } else { nId = p_nDefaultId; if(pCb< nId) { pCb = nId + 1; } } HDb = IDb(p_strDefaultText, nId); if(p_thCaret.node.nodeType == 1) { var span = document.createElement("span"); span.setAttribute(caa, "1"); var ADb = p_thCaret.node; var dDb = ADb.parentNode; dDb.insertBefore(span, ADb); span.appendChild(HDb); span.appendChild(ADb); } else if(p_thCaret.node.nodeType == 3) { var dEb = p_thCaret.offset; var ADb = p_thCaret.node; var dDb = ADb.parentNode; var txt = ADb.nodeValue; if(dEb != 0) { if(dEb > 0 && dEb == txt.length) { --dEb; } while(dEb > 0 && txt.charCodeAt(dEb) == 32) { --dEb; } while(dEb > 0) { tna = txt.charCodeAt(dEb - 1); if((tna > 63 && tna < 91) || (tna > 94 && tna < 123) || (tna > 44 && tna < 58) || tna == 34 || tna == 39) { --dEb; } else { break; } } } if(dEb == 0 && txt.charCodeAt(0) == 32) { var CDb = 1; while(CDb < txt.length && txt.charCodeAt(CDb) == 32 ) { ++CDb; } if(CDb < txt.length) { dEb = CDb; } else { var DDb = ADb.parentNode.previousSibling; if(DDb != null && DDb.tagName.toLowerCase() == "img" && DDb.getAttribute(hCb) != null) { return; } var EDb = ADb.parentNode.nextSibling; if(EDb != null && EDb.tagName.toLowerCase() == "img" && EDb.getAttribute(hCb) != null) { return; } } } var FDb = Upa(ADb, dEb); var GDb = FDb.parentNode.previousSibling; if(GDb != null && GDb.tagName.toLowerCase() == "img" && GDb.getAttribute(hCb) != null) { return; } FDb.parentNode.parentNode.insertBefore(HDb, FDb.parentNode); } if(p_bAutoOpen) { RDb(HDb); } } }};function IDb(p_strDefaultText, p_nId){ var HDb = null; if(Wea) { try { HDb = document.createElement("<img name='" + gCb + "'>"); } catch(err) { HDb = null; } } if(HDb == null) { HDb = document.createElement("img"); HDb.name = gCb; } HDb.setAttribute("src", $g_strFileLoc + "rwimgs/stickyicon.gif"); HDb.setAttribute("alt", ""); HDb.style.width = 27; HDb.style.height = 27; if(Wea && p_strDefaultText == null) { HDb.setAttribute("rwths", "0"); } if(p_strDefaultText != null) { HDb.setAttribute("title", p_strDefaultText); } HDb.setAttribute(baa, "1"); if(Wea) { lha(HDb, 'click', $rw_clickOnStickyNote); } else { HDb.setAttribute("onclick", "$rw_clickOnStickyNote(event);"); } HDb.setAttribute(hCb, "" + p_nId ); HDb.id = gCb + p_nId; HDb.className = "sticky_icon_unselected"; return HDb;}function KDb(p_node){ var JDb = p_node.previousSibling; if(JDb != null && JDb.nodeType == 1 && JDb.tagName.toLowerCase() == "img" && JDb.getAttribute(hCb) != null) { return false; } if(p_node.nodeType == 1) { if(p_node.getAttribute(hCb) != null) { return false; } var LDb = p_node.tagName.toLowerCase(); if(LDb == "input" || LDb == "textarea" || LDb == "img" || LDb == "label" || LDb == "button" || LDb == "nobr") { } else { if(LDb == "span") { var lDb = p_node.getAttribute("pron"); if(lDb != null) { } else { return false; } } else if(LDb == "acronym" || LDb == "abbr") { var lDb = p_node.getAttribute("title"); if(lDb != null) { } else { return false; } } else { return false; } } } var bod = document.body; while(p_node != null && p_node != bod) { if(p_node.nodeType == 1) { var lDb = p_node.getAttribute(baa); if(lDb != null && lDb == "1") { return false; } } p_node = p_node.parentNode; } return true;}function $rw_clickOnStickyNote(evt){ var target = bqa(evt); RDb(target);};function RDb(p_obj){ if(p_obj.nodeType == 1 && p_obj.getAttribute(hCb) != null) { var QEb = p_obj.getAttribute(hCb); var nId = parseInt(QEb); if(qCb > -1) { if(qCb == nId) { var UDb = document.getElementById("stickyNoteText"); UDb.focus(); return; } else { VDb(qCb); } } qCb = nId; var lDb = p_obj.getAttribute("title"); rCb = lDb; if(lDb == null) { lDb = ""; } var UDb = document.getElementById("stickyNoteText"); UDb.value = lDb; p_obj.className = "sticky_icon_selected"; bia(true, Tea); UDb.focus(); }}function VDb(p_nVal){ try { bia(false, Tea); var UDb = document.getElementById("stickyNoteText"); var lDb = UDb.value; var vEb = document.getElementById(gCb + p_nVal); if(vEb != null) { vEb.setAttribute("title", lDb); vEb.className = "sticky_icon_unselected"; if(lDb != rCb) { nDb(p_nVal); } else if(Wea) { var YDb = vEb.getAttribute("rwths"); if(YDb != null) { vEb.removeAttribute("rwths"); nDb(p_nVal); } } } } finally { qCb = -1; }};function eDb(qCb){ var ZDb = 0; var aDb = false; var QEb = gCb + qCb; try { var vEb = document.getElementById(QEb); if(vEb != null && vEb.parentNode != null) { var dDb = vEb.parentNode; dDb.removeChild(vEb); aDb = true; if(dDb.getAttribute(caa) && dDb.tagName.toLowerCase() == "span") { var fDb = dDb.firstChild; if(fDb != null && fDb.nextSibling == null) { if(fDb.nodeType == 3 || ( fDb.getAttribute(caa) == null && fDb.getAttribute(baa) == null) ) { var gDb = dDb.parentNode; gDb.insertBefore(fDb, dDb); gDb.removeChild(dDb); } } } } } catch(err) { ZDb += 1; } try { if(aDb) { var MEb = "http://" + Uca + "/stickynoteserver/?" + jCb + "=" + lCb; if(!Mca) { MEb += "&custid=" + HEb(rba); } MEb += "&titleid=" + HEb(sba); MEb += "&pageid=" + HEb(tba); MEb += "&teacherid=" + HEb(Oca); MEb += "&studentid=" + HEb(Qca); MEb += "&noteid=" + qCb; var OEb = document.createElement("script"); OEb.type = "text/javascript"; OEb.src = MEb; document.body.appendChild(OEb); qCb = -1; } } catch(err) { ZDb += 2; } if(ZDb > 0) { if(ZDb == 1) { Bwa("An error occurred while removing the note from the page."); } else if(ZDb == 2) { Bwa("An error occurred while sending the remove request to the server."); } else { Bwa("An error occurred while removing the note from the page and sending the remove request to the server."); } } bia(false, Tea);}function nDb(p_nVal){ if(p_nVal == -1) { var jDb = document.getElementsByName(gCb); var i=0; for(i=0;i<jDb.length;i++) { var vEb = jDb[i]; var lDb = vEb.getAttribute(hCb); if(lDb != null) { var mDb = parseInt(lDb); qDb(mDb); } } } else { qDb(p_nVal); }};function qDb(p_nVal){ var QEb = gCb + p_nVal; var vEb = document.getElementById(QEb); if(vEb != null) { if(vEb.tagName.toLowerCase() == "img" && vEb.getAttribute(baa) != null) { var rDb = vEb.getAttribute(hCb); if(QEb != null) { var SEb = vEb.title; var tDb = parseInt(rDb); var uDb; var XEb; if(vEb.nextSibling != null) { var wDb = vEb.nextSibling; if(wDb.nodeType == 1 && wDb.tagName.toLowerCase() != "span") { var BEb = wDb.getAttribute("id"); if(BEb == null || BEb.length == 0) { uDb = kqa(vEb.parentNode); } else { uDb = "idx" + BEb; } XEb = -1; } else { XEb = 0; XEb += Vka(vEb); var AEb = vEb.parentNode; var BEb = AEb.getAttribute("id"); while((BEb == null || BEb.length == 0) && AEb != document.body) { XEb += Vka(AEb); AEb = AEb.parentNode; BEb = AEb.getAttribute("id"); } if(BEb != null && BEb.length > 0) { uDb = "idx" + BEb; } else { uDb = kqa(vEb.parentNode); XEb = Vka(vEb); } } } else { XEb = 0; XEb += Vka(vEb); var AEb = vEb.parentNode; var BEb = AEb.getAttribute("id"); while((BEb == null || BEb.length == 0) && AEb != document.body) { XEb += Vka(AEb); AEb = AEb.parentNode; BEb = AEb.getAttribute("id"); } if(BEb != null && BEb.length > 0) { uDb = "idx" + BEb; } else { uDb = kqa(vEb.parentNode); XEb = Vka(vEb); } } var MEb = "http://" + Uca + "/stickynoteserver/?" + jCb + "=" + kCb; if(!Mca) { MEb += "&custid=" + HEb(rba); } MEb += "&titleid=" + HEb(sba); MEb += "&pageid=" + HEb(tba); MEb += "&teacherid=" + HEb(Oca); MEb += "&studentid=" + HEb(Qca); MEb += "&noteid=" + (rDb); MEb += "&notetext=" + HEb(SEb); MEb += "&position=" + (uDb + "-" + XEb); var OEb = document.createElement("script"); OEb.type = "text/javascript"; OEb.src = MEb; document.body.appendChild(OEb); } } }};function HEb(p_text){ var IEb = p_text.length; var i; var code; for(i=0; i<IEb; i++) { code = p_text.charCodeAt(i); if(code > 1023 || code == 91 || code == 93 || code == 37 || code == 38 || code == 61 || code == 35 || code == 47 || code == 92 || code == 10 || code == 13) { var GEb = "[" + d2h(code) + "]"; p_text = p_text.substr(0, i) + GEb + p_text.substr(i + 1); i += GEb.length - 1; IEb = p_text.length; } } return p_text;}function LEb(p_text){ var IEb = p_text.length; var i; var j; var code; var KEb; for(i=0; i<IEb; i++) { code = p_text.charCodeAt(i); if(code == 91) { j = i + 1; KEb = ""; while(j < IEb && code != 93) { KEb += p_text.charAt(j); j++; if(j < IEb) { code = p_text.charCodeAt(j); } } try { code = h2d(KEb); if(j<IEb) { p_text = p_text.substr(0, i) + String.fromCharCode(code) + p_text.substr(j + 1); } else { p_text = p_text.substr(0, i) + String.fromCharCode(code); } } catch(err) { } } } return p_text;}function NEb(){ var MEb = "http://" + Uca + "/stickynoteserver/?" + jCb + "=" + mCb; if(!Mca) { MEb += "&custid=" + HEb(rba); } MEb += "&titleid=" + HEb(sba); MEb += "&pageid=" + HEb(tba); MEb += "&teacherid=" + HEb(Oca); MEb += "&studentid=" + HEb(Qca); var OEb = document.createElement("script"); OEb.type = "text/javascript"; OEb.src = MEb; document.body.appendChild(OEb);};function $rw_unserialiseStickyNotesImpl(p_strText){ var PEb = " ^ "; var QEb = ""; var REb = ""; var SEb = ""; var TEb = 0; var UEb = 0; while(TEb > -1 && UEb > -1) { UEb = p_strText.indexOf(PEb, TEb); if(UEb > -1) { QEb = p_strText.substring(TEb, UEb); TEb = UEb + 3; UEb = p_strText.indexOf(PEb, TEb); if(UEb > -1) { REb = p_strText.substring(TEb, UEb); TEb = UEb + 3; UEb = p_strText.indexOf(PEb, TEb); if(UEb > -1) { SEb = p_strText.substring(TEb, UEb); var dEb = REb.indexOf("-"); if(dEb > -1 && dEb < REb.length -1) { var WEb = REb.substr(dEb + 1); var XEb = parseInt(WEb); REb = REb.substring(0, dEb); var YEb; if(REb.substr(0, 3) == "idx") { var ZEb = REb.substr(3); var vEb = document.getElementById(ZEb); if(vEb != null) { YEb = Jra(document.body, kqa(vEb), XEb, true); } } else { YEb = Jra(document.body, REb, XEb, false); } dEb = SEb.indexOf("^^"); if(dEb > -1) { while(dEb > -1) { SEb = SEb.substr(0, dEb) + SEb.substr(dEb + 1); dEb = SEb.indexOf("^^", dEb + 1); } } SEb = LEb(SEb); vCb(YEb, parseInt(QEb), SEb, false); } TEb = UEb + 3; UEb = p_strText.indexOf(PEb, TEb); } } } }};function bEb(){ document.getElementById("floater").style.display = "block";};function cEb(){ document.getElementById("floater").style.display = "none";};function $rw_event_sticky(event, i){ pea = !pea; g_toggleIcons[i][8] = !g_toggleIcons[i][8]; if(pea) { if(Yea) { document.images[g_toggleIcons[i][0]].src = g_toggleIcons[i][zea].src; } else { Ufa(g_toggleIcons[i][0], "toggleOn", true); } } if(pea && $g_bMouseSpeech) { $rw_enableClickToSpeak(false); }}function eEb(){ var dEb = -1; var i; for(i=0; i<g_toggleIcons.length;i++) { if(g_toggleIcons[i][0] == "sticky") { dEb = i; } } if(dEb > -1) { $rw_event_sticky(null, i); }}if(document.images){ var $rw_stickyNoteCloseImg1 = new Image(); $rw_stickyNoteCloseImg1.src = $g_strFileLoc + "rwimgs/close_off.gif"; var $rw_stickyNoteCloseImg2 = new Image(); $rw_stickyNoteCloseImg2.src = $g_strFileLoc + "rwimgs/close_on.gif"; var $rw_stickyNoteSaveCloseImg1 = new Image(); $rw_stickyNoteSaveCloseImg1.src = $g_strFileLoc + "rwimgs/save.gif"; var $rw_stickyNoteSaveCloseImg2 = new Image(); $rw_stickyNoteSaveCloseImg2.src = $g_strFileLoc + "rwimgs/save_on.gif"; var $rw_stickyNoteRemoveImg1 = new Image(); $rw_stickyNoteRemoveImg1.src = $g_strFileLoc + "rwimgs/delete.gif"; var $rw_stickyNoteRemoveImg2 = new Image(); $rw_stickyNoteRemoveImg2.src = $g_strFileLoc + "rwimgs/delete_on.gif";}function $rw_closeStickyNote(event){ VDb(qCb); event.returnValue=false; return false;}function $rw_removeStickyNote(event){ if(!Wca || confirm("Are you sure you want to remove this note?  Click OK to proceed.")) { eDb(qCb); } event.returnValue=false; return false;}function limitText(textArea, length){ if(textArea.value.length > length) { textArea.value = textArea.value.substr(0, length); Bwa("The sticky note is limited to " + length + " characters."); }}