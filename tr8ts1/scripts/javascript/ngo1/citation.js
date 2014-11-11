/** 
	@file: citation.js
	@description: This file is the main source of all the citation javascript calls

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	citation variables:
	
	curCitation - the current selected citation from the existing citation panel
	pubmedid - the current publication medium id
	thisSource - the panel of the note card that is currently shown
	tmpcitationid - the citation id for view citation
	useablekeys - the keys that are useable when the citation limit has been reached
	maxcitationtextsize - the max size for entered characters
	maxcitationsize - the max size for citations with entered characters and html
	ctrlKey - the placeholder for if the control key has been pressed in different browsers
	
**/	
var curCitation = -1;
var pubmedid = 1;
var thisSource = 'citeSource';
var tmpcitationid = -1;
var useablekeys = new Array(0,8,16,17,19,20,27,33,34,35,36,37,38,39,40,45,46,144,145);
var maxcitationtextsize = 200;
var maxcitationsize = 254;
var ctrlKey = false;
//A

/*
	function Addcustomcitation
	creates the add custom citation information for insert custom citation.
	Params:
		citationtext - the citation text to send to the insertcustomcitation function.
		pubmediumid - the publication medium id of the new citation.
		citationsourcetype - the source type of the new citation.
	returns nothing
*/

function Addcustomcitation(citationtext, pubmediumid, citationsourcetype) {
	if (typeof(citationData.length) == 'undefined') {
		var index = 0;	
	} else {
		var index = citationData.length;
	}
	
	insertcustomcitation(index,citationtext,pubmediumid,citationsourcetype,noteStore[curNote]._notecardid.replace(/\'|\"/g,''));
}

/*
	function Addcustomcitation
	builds the citationtextarray for the source on the page.
	Params: none
	returns nothing
*/


//adds the source on the page to an array to be used later
function Addsourceonpage() {
	var submitrequesturl = "action=getcitation&product_id=" + G_PRODUCT_ID + "&id=" + G_ID + "&citationtypeid=" + citationtypeid;

	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/citationajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file
			dataType: "text", // the expected type of data returned
			success: function(data) {
				var citationtextdata = data;							
				//set the source on page in the citation to this citation
				//alert(citationtextdata);
				$('li#citesourceli > p.citation').html(forceWrapmissHTML(stripHTMLwithSpan(citationtextdata)));
			}
		});
	});
}
//B
/*
	function BuildCitationList
	builds the citation list for the left citation panel.
	Params: none
	returns nothing
*/
//build citation list in left panel
function BuildCitationList() {
	//get each citation list
	$('.sourceList').each( function(obj) {
		//set the overflow to auto
		$(this).css({overflow:'auto'});
		var divhtml = '';
		//sort the citations
		citationData.sort(callbackFunc);
		//loop through the citations
		$(citationData).each(function(obj) {
			//build the containers for each citation
			divhtml += "<div id='citationid"+this._citationid+"'>\n";
			divhtml += this._autocite == 0 ? forceWrapmissHTML(this._citationtext) : forceWrapmissHTML(this._citationtextarray["'"+citationtypeid+"'"]) + "\n";
			divhtml += "</div>\n"
		});
		//set the citations in the citation panel
		$(this).html(divhtml==''?'<center>There are no citations for this assignment.</center>':divhtml);
		//if there are citations
		if (divhtml != '') {
			// set jQuery hover event on selectable citations
			if($(this).attr("id") == 'existSourceList')
			{
				listChange();
			}
		}
	});
	
}

/*
	function buildContentList
	builds the Which source are you citing.
	Params: 
		pubmediumid - the current publication medium id selected.
		JSONdata - the JSON data returned from another function.
	returns nothing
*/

//build content type list
function buildContentList(pubmediumid, JSONdata) {
	//build the first option of the citation content type list dropdown
	var tmp = '<option value="0" selected="true">Select...</option>\n';	
	//loop thorough the content type list
	$(JSONdata).each(function() {
		//if the content type has a pub medium id of the current selected one
		if (this._pubmediumid == pubmediumid) {
			//build the option for that content type
			tmp += '<option value='+this._citationcontenttypeid+' >'+this._description+'</option>\n';
		}
	});
	//set the content dropdown
	$('#contentType').html(tmp);
	//make the first opeion selected
	$('#contentType').find('option[value=0]').attr('selected','selected');
}
//C
/*
	function callbackFunc
	sorts the citation list based on citationtext.
	Params: 
		this is a sort function for an array. the a and b parameters are special.
	returns sorted array
*/
//sorts citation based on citation text.
function callbackFunc(a,b){
	//if the citation is an autocitation sort on the citation text array value else sort on the citationtext value
	var thea = a._autocite == 0 ? a._citationtext : a._citationtextarray["'"+citationtypeid+"'"];
	var theb = b._autocite == 0 ? b._citationtext : b._citationtextarray["'"+citationtypeid+"'"];
	//if either return blank return -1
	if (stripHTMLwithSpan2(thea) == '' || stripHTMLwithSpan2(theb) == '') return -1
	//if thea is less than the b return -1 (higher on list) else return 1(lower on list)
	return (stripHTMLwithSpan2(thea.toLowerCase()) < stripHTMLwithSpan2(theb.toLowerCase())) ? -1 : 1;
}

/*
	function changeFormatExample
	changes the format and example on the create a citation panel
	Params: 
		citationtypeid - the current citation type id for finding the correct format and example.
		citationcontenttypeid - the current citation content type id for finding the correct format and example.		
		arraydata - the formatexample array for searching through
	returns nothing
*/

//change citation format example
function changeFormatExample(citationtypeid, citationcontenttypeid, arraydata) {
	//find the format and example for the selected citation content type
	var formatexample = $.grep(arraydata,function(n,i) {
		return (parseInt(n._citationtypeid) == parseInt(citationtypeid) && parseInt(n._citationcontenttypeid) == parseInt(citationcontenttypeid));
	});
	//if the format and example have returned nothing
	if (formatexample == '') {
		//set a default format and example
		formatexample[0] = new Object();
		formatexample[0]._citationformat = 'No format available';
		formatexample[0]._citationexample = 'No example available';
	}
	//store the formatexmaple container
	var formatp = $('#formatexample');
	//set the html of the container
	$(formatp).html(findHTTP(formatexample[0]._citationformat));
	//reset the font size
	if (formatexample[0]._citationformat.length > 50) {
		$(formatp).css({fontSize:'9px',lineHeight:'11px'});
	} else {
		$(formatp).css({fontSize:'11px',lineHeight:'14px'});
	};
	//store the exampleexample container	
	var examplep = $('#exampleexample');
	//set the html of the container
	$(examplep).html(findHTTP(formatexample[0]._citationexample));
	//reset the font size
	if (formatexample[0]._citationexample.length > 50) {
		$(examplep).css({fontSize:'9px',lineHeight:'11px'});
	} else {
		$(examplep).css({fontSize:'11px',lineHeight:'14px'});
	};
}

/*
	function checkifCitationsaved
	checks if the citation is saved before leaveing the page or changing the citation.
	Params: none
	returns true or false
*/

//check if the citation is saved
function checkifCitationsaved() {
	//if the page is the new citation source page
	if(thisSource == 'newSource') {
		//find the iframe and the document element of the iframe
		var italFrame = document.getElementById('italTextArea');
		if (italFrame.contentDocument) {
			var theIframecontent = 	italFrame.contentDocument;
		} else if(italFrame.contentWindow) {
			var theIframecontent = 	italFrame.contentWindow.document;		
		} else if(italFrame.document) {
			var theIframecontent = 	italFrame.document;		
		}
		//find the source of the iframe
		var italFrameSource = theIframecontent.body.innerHTML;
		//if the source of the iframe minus html and spaces is blank then return false
		if (stripHTMLnospace(italFrameSource) != ''){
			return false;	
		}
	}
	return true;
}
/*
	function checkBeforeLeave
	checks before the user leaves the page to see if anything needs to be saved.
	Params: 
		href - the url to go to
		force - if true stops from leaving.
	returns false
*/
function checkBeforeLeave(href,force) {
	//if force is not defined then make force false
	if (typeof(force) == 'undefined') {
		force = false;
	}
	//if force is true and the page is the bibliography page return false
	if (force==true && isBibliography() != false) {
		return false;	
	}
	//if the page is the bibliography page and the page to go to is the bibliography
	if (isBibliography() !=  false && href == 'bibliography'){
		var tmpcitation = null;
		//loop through the citation object and find the current citation and set the index
		$.grep(citationData,function(n,i) {
			if (n._citationid == noteStore[curNote]._citationid) {
				tmpcitation = i;
				return false;
			}
		});
		//if the index is set then change the hash and make the citation editable
		if (tmpcitation != null) {
			window.location.hash = 'citationDiv'+tmpcitation;
			objBibliography.checkEditAdd(tmpcitation,function(index) {
				objBibliography.editCitation(index);
			});
		} else {
			return false;
		}
	} else {
		//check to see if the note card is saved if not ask if the user wants to save
		if (checkIfNoteSaved() == false) {	
			warning({
				title:'Warning',
				msg:'Would you like to Save the current note before leaving?',
				noAction:function(){window.location.href = href;},
				yesAction:function(){if (saveNote() != false) { 
							window.location.href = href;
				} else {
					return false;
				}},
				cancelAction:function(){return false;}
			});
		} else {
			//if the page you are going to is the bibliography append the citation div id to go to once the page has been reached
			if (href.toLowerCase() == 'bibliography') {
				var tmpcitation = null;
				$.grep(citationData,function(n,i){
					if (n._citationid == noteStore[curNote]._citationid) {
						tmpcitation = i;	
					}
				});
				href = href+'#citationDiv'+tmpcitation;
			}
			window.location.href = href;
		}
	}
}

/*
	function CheckifSet
	check if content type is selected
	Params: none
	returns nothin
*/

//check if content type is selected
function CheckifSet() {
	//if the content type selected option is not "Select..." change the format and example and set them visible if they are not already
	if(document.getElementById('contentType').selectedIndex != 0) {
		changeFormatExample(citationtypeid,$('#contentType option:selected').attr('value'), citationformatexampleData);
		if ($('#format').css('visibility') != 'visible') {
			$('#format').css({visibility:'visible', 'height':'auto'});
			$('#inputcont').css({visibility:'visible', 'height':'auto'});
			$('#example').css({visibility:'visible', 'height':'auto'});
			if (detectMacXFF2() != true) {
				$('#inputcont iframe').css({'display':'block','z-index':'1'});
			}
		}
		//make the iframe editable
		MakeEditable();
		if($.browser.safari){
			//css position will only update if something is physically updated for safari
			$('#safariErrFix').html("");
		}
	} else {
		//hide the iframe and the format and exmaples
		if (detectMacXFF2() != true) {
			$('#inputcont iframe').css('display','none');
		}
		$('#format').css({visibility:'hidden','height':'1px'});
		$('#inputcont').css({visibility:'hidden','height':'1px'});
		$('#example').css({visibility:'hidden','height':'1px'});
	}
}

/*
	function checkBeforeLeave
	check if the note is saved
	Params: 
		link - the type of panel to go to in the note card or citation tool.
	returns nothing
*/

//check to see if note is saved
function checksavednote(link) {
	//stroe the title
	var title=$('#note_title').val();	
	//if the note is note saved then ask if the user would like to save
	if (checkIfNoteSaved() == false || curNote == null || typeof(curNote) == 'undefined') {	
		warning({
			title:'Warning',
			msg:'Would you like to Save the current note?',
			noAction:function(){if (curNote == null || curNote == 0 || typeof(curNote) == 'undefined'){ return false;} else {
				$('li.notecardtitleid > p').each(function() {
					$(this).html(noteStore[curNote]._title);
				});
				noteChange(link);}},
			yesAction:function(){if (saveNote() != false) { 
				$('li.notecardtitleid > p').each(function() {
					$(this).html(title);
													   });
				noteChange(link);
			}},
			cancelAction:function(){return false;}
		});
	} else {
		//go to the changed "link"
		$('li.notecardtitleid > p').each(function(obj) {
			$(this).html(noteStore[curNote]._title);
		});
		noteChange(link);
	}
}
/*
	function checkTextSize
	check the text length and resize if need be.
	Params: 
		text - the text to check the length of
		size - the length to check against
		callback - function called if true
		callback2 - function called if false.
	returns text
*/

//check text size. resize if need be
function checkTextSize(text,size, callback, callback2){
	if (text.length > size) {
		callback();
	} else {
		callback2();
	}
	return text;
}
function finditless(lesindex,tmptext,text,i) {
	var count = 0;
	if (lesindex == -1) {
		count++;	
	} else {
		if (tmptext.length == i+2 || lesindex >= tmptext[i+1]-1) {
			count++;
		} else {
			if (text.indexOf(' ',tmptext[i]) == -1 || lesindex >= text.indexOf(' ',tmptext[i])) {
				count++;
			} else {
				if (text.indexOf('&gt;',tmptext[i]) == -1 || lesindex >= text.indexOf('&gt;',tmptext[i])) {
					count++;
				}
			}
		}
	}
	if (count > 0) {
		return false;
	} else {
		return true;
	}
}
//F
//finds the links in the citation and only forces a wrap in the link
function findHTTP(text) {
	var i = 0;
	//get all the indexes of http://
	var tmptext = text.indexOfAll('http://');
	var tmp = text;
	//if there are no indexed of http:// return the origional text
	if (tmptext == -1) return text;
	tmp = '';
	for (i = 0, len = tmptext.length; i < len; i++){
		//if the first index of the http:// is not 0 then get the string up to that index
		if (tmptext[i] != 0 && i == 0) {
			tmp = text.substring(0,tmptext[i]);
		}
		//boolean for finding the end of the link
		var bool = false;
		while (bool == false) {
			//store the index of any html less than sign
			var lesindex = text.indexOf('<',tmptext[i]);
			//if the less than sign is found then loop through and remove the html inside that less than sign
			if (finditless(lesindex,tmptext,text,i) == true) {
				var texttmp = text.substring(lesindex,text.indexOf('>',lesindex)+1).length;
				text = text.substring(0,lesindex) + text.substring(parseInt(lesindex)+parseInt(texttmp),text.length);
				for (l = i+1, leng = tmptext.length;l<leng;l++){
					tmptext[l] = parseInt(tmptext[l]) - parseInt(texttmp);
				}
			//if the next character to be found is a space then that is the end of any http://www.****.*** without a less than or greater than sign
			} else if (text.indexOf(' ',tmptext[i]) != -1 && text.indexOf(' ',tmptext[i]) < text.indexOf('&gt;',tmptext[i])) {
				tmp += forceWrap(stripHTMLwithSpan(text.substring(tmptext[i],text.indexOf(' ',tmptext[i]+1))));
				tmp += text.substring(text.indexOf(' ',tmptext[i]+1),i == len-1 ? text.length : tmptext[i+1]);
				bool = true;
			//finds the index of the greater than sign that matches the link or the end of the text.
			} else {
				if (text.indexOf('&gt;',tmptext[i]) != -1) {
					tmp += forceWrap(stripHTMLwithSpan(text.substring(tmptext[i],text.indexOf('&gt;',tmptext[i]+1))));
					tmp += text.substring(text.indexOf('&gt;',tmptext[i]+1),i==len-1 ? text.length : tmptext[i+1]);
				} else {
					tmp += forceWrap(text.substring(tmptext[i],text.length));
				}
				bool = true;
			}
		}
	}
	return tmp;

}
/*
	function String.prototype.indexOfAll
	finds all indices of the specified text in the string.
	Params: 
		text - string to search for
	returns Array tmpArray
*/
//finds the index of all specified text
String.prototype.indexOfAll = function(text) {
	var i = 0;
	var tmpArray = new Array();
	while (i < this.length) {
		if (this.indexOf(text,i) != -1) {
			tmpArray[tmpArray.length] = this.indexOf(text,i);
			i = this.indexOf(text,i) + text.length + 1;
		} else {
			break;	
		}
	}
	if (tmpArray.length == 0) {
		tmpArray = -1;	
	}
	
	return tmpArray;
}

/*
	function forceWrapMissHTML
	wraps the selected text ignoring html
	Params: 
		text - the text to be wrapped.
	returns String tmp
*/

//wraps the selected text ignoring the html
function forceWrapmissHTML(text) {
	if (typeof(text) == 'undefined' || text.length == 0) {
		return '';
	}
	var html = text;
	var tmp = '';
	var i = 0;
	
	for (i = 0, len = text.length; i<len; i++) {
		if (text.indexOf(/<[^>]*>/,i+1) != -1) {
			tmp += text.substr(i+1).match(/<[^>]*>/);
			i = (text.indexOf(/<[^>]*>/,i+1) + text.substr(i+1).match(/<[^>]*>/).length)-1;
		}
		if (text.indexOf(/<\/[^>]*>/,i+1) != -1) {
			tmp += text.substr(i+1).match(/<\/[^>]*>/);
			i = (text.indexOf(/<\/[^>]*>/,i+1) + text.substr(i+1).match(/<\/[^>]*>/).length)-1;
		}		
		if (text.indexOf(/&[^;]>;/,i+1) != -1) {
			tmp += text.substr(i+1).match(/&[^;]>;/);
			i = (text.indexOf(/&[^;]>;/,i+1) + text.substr(i+1).match(/&[^;]>;/).length)-1;
		}
		if (text.indexOf(/ /,i+1) != -1) {
			if (i+text.indexOf(/ /,i+1) > 26) {
				tmp += forceWrap(text.substring(i,text.indexOf(/ /,i+1)));
				i = text.indexOf(/ /,i+1);
			} else {
				tmp += text.substring(i,text.indexOf(/ /,i+1));
				i = text.indexOf(/ /,i+1);
			}
		} else {
			tmp += text.substr(i,len);
			i = len;
		}
	}
	tmp = findHTTP(tmp);
	return tmp;
}
//G
/*
	function getIframeLength
	gets the length of the iframe with all span/em tags converted to i tags
	Params - 
		iframecontent - the iframe document element
	returns - the length of the text in the iframe including html or 0
*/
function getIframeLength(iframecontent) {
	var tmplen = 0;
	var iframehtml = $(iframecontent).find('body').html();
	if (iframehtml.match(/<(span|\/span|em|\/em)[^>]*>/gi) != null) {
		iframehtml = iframehtml.replace(/<(span|em)[^>]*>/gi,'<i>').replace(/<(\/span|\/em)[^>]*>/gi,'</i>');
		tmplen = iframehtml.length;
	} else {
		tmplen = iframehtml.length;	
	}
	return tmplen;
}
/*
	function getCitationListFinish
	this function is called when getCitationList is. this does the rest of the things needed afterwards.
	Params: none
	returns false
*/
//get citation list
function getCitationListFinish() {
	if (citationData == '' || citationData.length == 0) {
		$('.existSourceOption').each(function(obj) {
			if (thisSource == 'existSource') {
				noteChange('existSource');
			}
		});
		existsource = false;
	}
	
	BuildCitationList();
	if (thisSource == 'viewCitation') {
		showExistingCitation(noteStore[curNote]._citationid);
	}
}
/*
	function getSelectedHTML
	gets the selected text in the iframe and does various checking on it
	Params - 
		iframcontent - the iframe window element
	returns - the selected text from the iframe and any html associated with it.

*/
function getSelectedHTML(iframecontent) {
	var userSelection, rangeObject;
	if (iframecontent.getSelection) {
		userSelection = iframecontent.getSelection();
		if (userSelection.getRangeAt)
			rangeObject = userSelection.getRangeAt(0);
		else { // Safari!
			var range = iframecontent.document.createRange();
			range.setStart(userSelection.anchorNode,userSelection.anchorOffset);
			range.setEnd(userSelection.focusNode,userSelection.focusOffset);
			rangeObject = range;
		}
	}
	else if (iframecontent.document.selection) { // should come last; Opera!
		userSelection = rangeObject = iframecontent.document.selection.createRange();
	}		
	if (rangeObject.cloneRange) {
		var tmpclone = rangeObject.cloneRange()
	} else if (rangeObject.duplicate) {
		var tmpclone = rangeObject.duplicate();
	}
	if (rangeObject.text) {
		if (rangeObject.text.length == 0)
			return '';	
	} else { 
		if (rangeObject.cloneContents().toString && rangeObject.cloneContents().toString().length == 0) 
			return '';
	}
	if (rangeObject.htmlText) {
		var tmpclonehtml = rangeObject.htmlText;
		if (tmpclonehtml.match(/<[^>]*>/gi) == null) {
			var tmpparent = rangeObject.parentElement();
			if (tmpparent.tagName.toLowerCase() != 'body') {
				return tmpparent.outerHTML;
			}
		}
		return tmpclonehtml;
	} else {
		tmpclone = tmpclone.cloneContents();
		var div = document.createElement('div');
		$(div).append(tmpclone);
		var clonehtml = $(div).html();
		if (clonehtml.match(/<[^>]*>/gi) == null) {
			var tmpparent = rangeObject.startContainer.parentNode;
			if (tmpparent.tagName.toLowerCase() != 'body') {	
				clonehtml = tmpparent.cloneNode(true).innerHTML;
			}
		}
		return clonehtml;		
	}
}

/*
	function getSelText
	get the selected text dependant on browser
	Params - 
		iframcontent - the iframe document object
	returns - the selected text from the iframe.
*/
function getSelText(iframecontent) {
	var txt = '';
	if (iframecontent.getSelection){
		txt = iframecontent.getSelection();
	}
	else if (iframecontent.getSelection){
		txt = iframecontent.getSelection();
	}
	else if (iframecontent.selection){
		txt = iframecontent.selection.createRange().text;
	}
	return txt;
}

//I
//check if page is article
/*
	function isArticle
	checks if the page is an article page
	Params: none
	returns bool
*/
function isArticle() {
	var URL = window.location.href;
	URL = URL.replace('http://','');
	URL = URL.indexOf('/') != -1 ? URL.substr(URL.indexOf('/')+1) : URL;
	URL = URL.indexOf('?') != -1 ? URL.substring(0,URL.indexOf('?')) : URL;
	URL = URL.indexOf('#') != -1 ? URL.substring(0,URL.indexOf('#')) : URL;		
	if(URL.toLowerCase() == 'article') {
		return true;
	}
	return false;
}

/*
	function isBibliography
	checks if the page is an bibliography page
	Params: none
	returns bool
*/

//check if page is bibliography
function isBibliography() {
	var URL = window.location.href;
	URL = URL.replace('http://','');
	URL = URL.indexOf('/') != -1 ? URL.substr(URL.indexOf('/')+1) : URL;
	URL = URL.indexOf('?') != -1 ? URL.substring(0,URL.indexOf('?')) : URL;
	URL = URL.indexOf('#') != -1 ? URL.substring(0,URL.indexOf('#')) : URL;		
	if(URL.toLowerCase().replace(/#/g,'') == 'bibliography') {
		return true;
	}
	return false;
}

/*
	function InitCitation
	Initializes the citation tool and gets data if needed.
	Params: none
	returns nothing
*/

//initialize the citation tool
function InitCitation() {
	if (citationData == null) {
		addTool('citation');
		getCitationList();	
		setCitationStyle();
	} else {
		addTool('citation');
		getCitationListFinish();
		setCitationStyle();
	}
	if (isArticle() != false) {
		Addsourceonpage();	
	}
}
//L
/*
	function listChange
	create the hover effect on the sourcelist when using an existing source
	Params: none
	returns none
*/
// create hover effect on sourcelist
function listChange() {

	$('div#existSourceSlideCont div#existSourceList div').each(function(obj) {
		
		//the mouse on/mouse out events
		$(this).hover(
			function() {
				$(this).attr('class','selected');
				this.style.cursor = "pointer";
			},
			function() {
				$(this).attr('class','notselected');
			}
		);
		$(this).click(function() {
		   setExistingCitation(this);
		});
	});
}
//M
//make iframe WYSIWYG editor
var timeouttest = '';

/*
	function MakeEditable
	Makes the iframe editable to be used as a WYSIWYG editor
	Params: none
	returns bool
*/
//makes the iframe editable
function MakeEditable()
{
	var theIframe = document.getElementById("italTextArea");
	//in moz you cannot change design mode straight away so try and then retry
	if (theIframe.contentDocument) {
		var theIframecontent = 	theIframe.contentDocument;
	} else if(theIframe.contentWindow) {
		var theIframecontent = 	theIframe.contentWindow.document;		
	} else if(theIframe.document) {
		var theIframecontent = 	theIframe.document;		
	}
	//check if the timouttest variable is set
	if (timeouttest == '') {
		timeouttest = setTimeout(MakeEditable,100);
	} else {
		timeouttest = '';	
	}
	try{
		theIframecontent.designMode = "on";
	}catch(e){
		setTimeout(MakeEditable,250);
		return false;
	}
	if ($.browser.msie || $.browser.safari) {
		theIframe.onload = function() {
			theIframecontent.body.contentEditable = true;
			theIframecontent.body.style.cursor = "text";
			theIframecontent.body.style.overflowX = "hidden";
			if ($.browser.msie) {
				theIframecontent.body.style.width = "273px";
			} else {
				if ($.browser.safari) {
					theIframecontent.body.style.width = "500px";
				}
			}
			theIframecontent.body.style.wordWrap = "wrap";
		}
	} else {
		theIframecontent.body.contentEditable = true;
		theIframecontent.body.style.cursor = "text";		
		theIframecontent.body.style.width = "95%";
		theIframecontent.body.style.overflowX = "hidden";
		theIframecontent.body.style.wordWrap = "wrap";
	}
		// set ital to the iframe or textarea if iframes are not supported
	var ital =	document.getElementById('italTextArea');
	//check if ital is an iframe '[object HTMLIFrameElement]'
	if (ital.toString() == document.createElement('iframe').toString()) {
		if ($.browser.safari) {
			$(ital).css('width','258px');				
			$(ital).css('height','56px');				
			$(ital).css('padding-top','3px');
			$(theIframecontent.body).css({'overflow-x':'hidden','width':'228px','height':'56px'});
			$('#safariErrFix').html("");
		} else {
				$(ital).width(258);
				$(ital).height(58);
		}
		//bind the keypress event
		$(theIframecontent).bind('keypress',function(e) {
			//get the html minus all p/font tags and convert any &nbsp; to spaces
			var checkhtml = $(this).find('body').html().replace(/<(p|font|\/p|\/font)[^>]*>/gi,'').replace(/&nbsp;/gi,' ');
			//if the length exceeds or is equal to the max citationtextsize
			if (checkhtml.replace(/<[^>]*>/gi,'').length >= maxcitationtextsize) {			
				//first check the exceeds
				if (checkhtml.replace(/<[^>]*>/gi,'').length > maxcitationtextsize) {
					var tmplimit = 200;
					//find the html in the area and add the length to the limit length
					if (checkhtml.match(/<(span|em|\/span|\/em|i|\/i)[^>]*>/gi) != null) {
						var tmphtmls = checkhtml.match(/<(span|em|\/span|\/em|i|\/i)[^>]*>/gi);
						$.each(tmphtmls,function(i,val){
							tmplimit += val.length;
						});
					}
					//set the text to the limit html
					$(this).find('body').html(checkhtml.substr(0,tmplimit));
				}
				//the key which was pressed
				var key = e.which;
				//if the key was a
				var a = (key == 97 ? true : (key == 65 ? true : false));
				//if the key was enter and the length is too large do not let the keypress go through
				if (e.which == 13) {
					if (checkhtml.length+4>maxcitationsize) {
						return false;	
					}
					//if the keys are the control/apple key and a to select all
				} else if ((ctrlKey == true && a == true)) {
					//do nothing
					//if the keys are in the useablekeys array
				} else if ((useablekeys.indexOf(key) == -1 && getSelText(this) == '')) {
					return false;
				}
			} else {
				//check if there is room for an enter
				if (e.which == 13) {
					if (checkhtml.length+4>maxcitationsize) {
						return false;	
					}
				}
			}
		});
		//find if the control key has been pressed
		$(theIframecontent).bind('keydown',function(e){
			if (ctrlKey != true) {
				if ($.browser.msie) {//IE
					if (e.which == 17) {
						ctrlKey = true;
					}
				} else if ($.browser.safari) {
					if (e.which == 91) {//Safari
						ctrlKey = true;	
					}
				} else if ($.browser.mozilla) {
					if (window.navigator.userAgent.indexOf('mac') != -1) {//FFMac
						if (e.which == 224) {
							ctrlKey = true;
						}
					} else {//FFPC
						if (e.which == 17) {
							ctrlKey = true;
						}
					}
				}
			} else {
				$(theIframecontent).trigger('keypress',e);	
			}
		});
		//find if control has been let go
		$(theIframecontent).bind('keyup',function(e){
			if ($.browser.msie) {//IE
				if (e.which == 17) {
					ctrlKey = false;
				}
			} else if ($.browser.safari) {//Safari
				if (e.which == 91) {
					ctrlKey = false;	
				}
			} else if ($.browser.mozilla) {
				if (window.navigator.userAgent.indexOf('mac') != -1) {//FFMac
					if (e.which == 224) {
						ctrlKey = false;
					}
				} else {
					if (e.which == 17) {//FFPC
						ctrlKey = false;
					}
				}
			}
		});
	}
	return true;
}
/*
	function makeItalic
	Makes text Italicized in WYSIWYG editor
	Params: none
	returns nothing
*/
//make text in WYSIWYG editor
function makeItalic() {
	//get the iframe and the document/window objects
	var theIframe = document.getElementById("italTextArea");
	if (theIframe.contentDocument) {
		var theIframecontent = 	theIframe.contentDocument;
		var theIframewindow = theIframe.contentWindow;
	} else if(theIframe.contentWindow) {
		var theIframecontent = 	theIframe.contentWindow.document;		
		var theIframewindow = theIframe.contentWindow;		
	} else if(theIframe.document) {
		var theIframecontent = 	theIframe.document;		
		var theIframewindow = theIframe.contentWindow || theIframe.window;		
	}
	//build a regular expression dependant on which browser
	var theReg = new RegExp();
	if ($.browser.mozilla) {
		theReg = new RegExp(/<(span|\/span)[^>]*>/gi);
	} else if($.browser.msie) {
		theReg = /<(em|\/em)[^>]*>/gi;
	} else {
		theReg = /<(i|\/i)[^>]*>/gi;
	}
	//this is the number of italics
	var istoomany = ($(theIframecontent).find('body').html().match(/<(span|em|i)[^>]*>[^<]*<\/(span|em|i)[^>]*>/gi));
	//if the italics is null or less than 8 false else true
	istoomany = istoomany == null? false: istoomany.length > 6;
	//dont let them italicize unless the italics is in the area or you are unitalicizing
	if (istoomany == true && getSelectedHTML(theIframewindow).match(theReg) == null) {
		theIframewindow.focus();	
		return false;
	}
	//if the length is too long dont let them italicize
	if (getIframeLength(theIframecontent)+7 < maxcitationsize || getSelectedHTML(theIframewindow).match(theReg) != null ) {
		theIframecontent.execCommand('italic',false,null);
	}
	theIframewindow.focus();
}
//R
/*
	function removeCitation
	asks if you want to remove the citation from the current notecard.
	Params: 
		notecardid - the id of the note card to remove the citation from.
	returns nothing
*/
//disassociate citation from current notecard
function removeCitation(notecardid) {
	var tmpindex = null;
	var tmpindex1 = null;
	//find the index of the note card to be changed
	$.grep(noteStore,function(n,i){if (n._notecardid == notecardid) {tmpindex1 = i;}});
	//get the index of the citation to remove
	$.grep(citationData,function(n,i) { if (n._citationid == noteStore[tmpindex1]._citationid) { tmpindex = i}});
	warning({
		title:'Warning',
		msg:'Are you sure you want to remove the citation from this note card?',
		noAction:function(){return false;},
		yesAction:function(){sendRemoveCitation(notecardid,tmpindex);},
		cancelAction:function(){return false;}
	});
}
/*
	function replaceCitation
	asks if the user would like to replace the citation
	Params: none
	returns nothing
*/
//asks if the user would like to replace the citation
function replaceCitation() {
		warning({
		title:'Warning',
		msg:'Are you sure you want to replace the citation associated to this note card?',
		noAction:function(){return false;},
		yesAction:function(){noteChange('citeSource');},
		cancelAction:function(){return false;}
	});

}
/*
	function restoreexistoption
	restores the options that were removed before if needed
	Params: none
	returns nothing
*/
//restores the options that were removed before if needed
function restoreexistoption() {
	var tmp2 = new Array();
	//set exist source dependant on whether there aer citations
	if (citationData != null && citationData.length == 0) {existsource = false;} else {existsource = true;}
	//find each citation select object
	$('.citationSelect').each(function(obj){
		//get the selected option
		tmp2[obj] = $(this).find('option:selected').val();
	});
    var	tmp = '';
	//if the page is article
	if (citesource == true) {
		tmp += '<option value="citeSource" id="citeSourceOption" class="citeSourceOption">Cite the source on screen</option>';
	}
	//if there are citations
	if (existsource == true) {
		tmp += '<option value="existSource" id="existSourceOption" class="existSourceOption">Use an existing source</option>';
	}
	//always for new citation
	tmp += '<option value="newSource" id="newSourceOption" class="newSourceOption">Create a new source</option>';
		//find each select dropdown again
		$('.citationSelect').each(function(obj){
			//set each select dropdowns options
			$(this).html(tmp);
			//add the notechange function on change of the dropdown
			$(this).bind('change',function(e) {
				noteChange(this.value);
			});
			//set the select to the old select or the newsource option
			if ($(this).find('option[value='+tmp2[obj]+']').length != 0) {
				$(this).find('option[value='+tmp2[obj]+']').attr('selected','selected');
			} else {
				$(this).find('options[value=newSource]').attr('selected','selected');	
			}
		});
}
//S

/*
	function SaveSourceonpage
	saves the source on article pages only.
	Params: none
	returns false
*/

//saves the source on the page
function SaveSourceonpage() {
	var i = 0;
	var citationtextarray = new Array();
	$('dl.citationEx dd').each(
		function(obj){
			var citationtype = $('dl.citationEx dt:eq('+obj+')').html().substring(0,3).toLowerCase();
			switch(citationtype) {
				case 'mla':
					i = 1;
					break;
				case 'apa':
					i = 3;
					break;
				case 'chi':
					i = 2;
					break;
				default:
					i = 1;
					break;
			}
			citationtextarray["'"+i+"'"] = stripHTMLwithSpan($(this).html());
		}
	);
	for (i in citationData ) {
		var this1 = citationData[i];
		if (this1._autocite == 1) {
			if (this1._citationtextarray["'1'"] == citationtextarray["'1'"] && this1._citationtextarray["'2'"] == citationtextarray["'2'"] && this1._citationtextarray["'3'"] == citationtextarray["'3'"]) {
				addcitationtonotecard(citationData[i]._citationid,noteStore[curNote]._notecardid.replace(/\"|\'/g,''));
				return false;
			}
		}
	}
	saveSourceOnScreen(bibliographyid, citationtextarray,noteStore[curNote]._notecardid.replace(/\"|\'/g,''));
}
/*
	function setCitation Style
	find the citation style type and set it
	Params: 
		json - the current assignment json object.
	returns nothing
*/

// find citation style type and set it
function setCitationStyle(json) {
	//set teh citation type id
	if (typeof(json) != 'undefined' && json != 'undefined') {
		citationtypeid = json._citationtypeid;
	} else {
		citationtypeid = $.grep(json_assignmentlist,function (n,i){
			return (n._assignmentid == currassgn);
		});
	}
	if (citationtypeid.length == 0) {
		citationtypeid = 1;	
	} else {
		citationtypeid = citationtypeid[0]._citationtypeid;
		if (citationtypeid == null || citationtypeid == 0 || typeof(citationtypeid) == 'undefined') {
			citationtypeid = 1;
		}
	}
	//make the citation style the correct style
	$('.citationstyle').each(function(obj) {
		var stylehtml = '(Style: [insertcitationstyle])';
		switch(parseInt(citationtypeid)) {
			case 1: //mla
				stylehtml = stylehtml.replace('[insertcitationstyle]','MLA');
				break;
			case 2: //chicago
				stylehtml = stylehtml.replace('[insertcitationstyle]','Chicago');
				break;
			case 3: //apa
				stylehtml = stylehtml.replace('[insertcitationstyle]','APA');				
				break;
			default: //all others
				stylehtml = stylehtml.replace('[insertcitationstyle]','Broken');				
				break;
		}
		//set teh citation style html
		$(this).html(stylehtml);
	});
}

/*
	function setExistingCitation
	sets the selected citation as the one to be used.
	Params: 
		obj - the selected citation's html object.
	returns nothing.
*/

//set the current citation to the selected one.
function setExistingCitation( obj ) {
	//shows the citation that was just clicked and sets curcitation to the index of that citation
	$('#existcitationid').html($(obj).html());
	$.grep(citationData,function(n,i) {
		if (obj.id.replace('citationid','') == n._citationid) {
			curCitation = i;
			collectStat('biblio','xs','citation','');
		}
	});
}

/*
	function showExistingCitation
	shows the citation associated to the current note card when the view citation link is clicked.
	Params: none
	returns false
*/

// show citation associated to the current notecard
function showExistingCitation(citationid) {
	//look for the citation with the citation id of the current notecard
	var thiscitation = $.grep(citationData,function(n,i) {
		return (n._citationid == citationid);
	});
	//set the citation text to the proper citation text.
	tmpcitationid = citationid;
	$('#alreadycitation').html(thiscitation[0]._autocite == 1 ? forceWrapmissHTML(thiscitation[0]._citationtextarray["'"+citationtypeid+"'"]) : forceWrapmissHTML(thiscitation[0]._citationtext));
	if (thiscitation[0]._autocite == 1) {
		$('#editcitationli').hide();	
	} else {
		$('#editcitationli').show();	
	}
}
/*
	function startCitation
	starts the citation tool and builds the necissary components.
	Params: none
	returns nothing
*/
//starts the citation
function startCitation() {
	if (typeof(citationtypeid) == 'undefined' || citationtypeid == null) {
		citationtypeid = 1;
	}
	if ($.browser.safari) {
		$("#noteTabContent").css({overflow: 'hidden'});
	}
	//hide format, example, and custom citation input
		$('#format').css({visibility:'hidden'});
		$('#inputcont').css({visibility:'hidden'});
		$('#example').css({visibility:'hidden'});
		if (detectMacXFF2() != true) {
			$('#inputcont iframe').css('display','none');
		} else {
			$('#inputcont iframe').css('display','block');			
		}
	//check if page is article
	if (isArticle() == false) {
		//if not remove all cite source on screen options
		$('.citeSourceOption').each(function() {
			$(this).remove();
		});
		citesource = false;
		//set existing source options to selected
		$('.existSourceOption').each(function(obj) {
			if (typeof(citationData) == 'undefined' || citationData == ''){
				$(this).remove();
			} else
			$(this).attr({selected: 'selected'});
				
		});
	} else {
		// set cite source options to selected
		$('.citeSourceOption').each(function() {
			$(this).attr({selected: 'selected'});
											 });
	}
	// set onclick of electronic radio button
	setCitationStyle();
	//set onclick of save citation button
	$('#saveView_note').click(function() {
		if (curCitation == -1 && thisSource == 'existSource') {
			document.getElementById('contentType').options[0].selected = true;
			noteChange('noteCard');
			return false;
		}
		collectStat('biblio','xs','save','');
		switch(thisSource) {
			case 'citeSource': //cite source on screen
				SaveSourceonpage();
				break;
			case 'existSource': //use existing source
				var curCitationid = citationData[curCitation]._citationid.replace(/\"/g,'').replace(/\'/g,''); //current citation id
				var curNoteid = noteStore[curNote]._notecardid.replace(/\"/g,'').replace(/\'/g,''); //current notecard id
				addcitationtonotecard(curCitationid,curNoteid);
				break;
			case 'newSource': // insert custom cite
				var italFrame = document.getElementById('italTextArea');
				if (italFrame.contentDocument) {
					var theIframecontent = 	italFrame.contentDocument;
				} else if(italFrame.contentWindow) {
					var theIframecontent = 	italFrame.contentWindow.document;		
				} else if(italFrame.document) {
					var theIframecontent = 	italFrame.document;		
				}
				var italFrameSource = theIframecontent.body.innerHTML;
				if (stripHTMLnospace(italFrameSource) != ''){
					Addcustomcitation(switchSpanoutlink(stripHTML(convertAtags(italFrameSource))),pubmedid,document.getElementById('contentType').options[document.getElementById('contentType').selectedIndex].value);	
				} else {
					theIframecontent.body.innerHTML = '';	
					document.getElementById('contentType').selectedIndex = 0;
					noteChange('noteCard');
					return false;
				}
				break;
		}
	});
}
/*
	function switchPubMedium
	changes the publication medium type.
	Params: 
		value - the pub medium id.
	returns nothing
*/
//change the publication medium type
function switchPubMedium(value) {
		pubmedid = value;
		// set the content type list
		buildContentList(value,citationcontenttypeData);
		CheckifSet();
}
/*
	function stripHTML
	removes all html that is not a span
	Params: 
		oldString - the string to remove the html from.
v
*/
//removes all html that is not a span
function stripHTML(oldString) {	
	if (typeof(oldString) == 'undefined') {
		var oldString = '';
	}
	oldString = oldString.replace(/<(em|span)[^>]*>/gi,'<i>').replace(/<(\/em|\/span)[^>]*>/gi,'</i>');
	oldString = oldString.replace(/<(?!i|\/i|br)[^>]*>/gi,'');
	return oldString;
}
/*
	function stripHTMLwithSpan
	removes all html
	Params: 
		oldString - the string to remove the html from.
	returns String oldString
*/
//removes all html
function stripHTMLwithSpan(oldString) {	
	if (typeof(oldString) == 'undefined') {
		var oldString = '';
	}
	oldString = oldString.replace(/<[^>]*>/gi,'');
	oldString = oldString.replace(/&amp;/gi,'&');
	return oldString;
}
/*
	function stripHTMLwithSpan2
	removes all html, non-alphanumeric characters, and spaces
	Params: 
		oldString - the string to remove the html from.
	returns String oldString
*/
//removes all html, characters, and spaces
function stripHTMLwithSpan2(oldString) {	
	if (typeof(oldString) == 'undefined') {
		var oldString = '';
	}
	oldString = oldString.replace(/<[^>]*>/gi,'');
	oldString = oldString.replace(/&amp;/gi,'&');
	oldString = oldString.replace(/\W/gi,'');
	oldString = oldString.replace(/ /g,'');
	return oldString;
}
/*
	function stripHTMLnospace
	removes all html and spaces
	Params: 
		text - the string to remove the html from.
	returns String tmp
*/
function stripHTMLnospace(text) {
	var tmp = '';
	tmp = text.replace(/<[^>]*>/gi,'');
	return tmp.replace(/ /g,'').replace(/&nbsp;/g,'');
}
/*
	function switchSpanoutlink
	used to move the italics out of the links
	Params - 
		text - the string to be checked against
	returns a modified string with the italics outside of the link
*/
function switchSpanoutlink(text) {
	var html = text;
	//if the browser is safari there is a strange bug where any > signs are interpretid as the html >. we need to convert these to &gt;.
	if ($.browser.safari) {
		html = html.reverse();
		html = html.replace(/>(?!i<|i\/<)/gi,';tg&');
		text = html.reverse();
	}
	//look for anything surrounded by < and > that is not html
	var reg = new RegExp(/&lt;.*&gt;/gi);
	//if there is none skip
	if (reg.test(text) != false) {	
		//set the html variable to the first match
		html = text.match(reg)[0];
		//if you find a match for a begin italics tag
		if (html.match(/<(i)[^>]*>/i) != null) {
			//set tmptmp as the matched variable position
			var tmptmp = html.search(/<(i)[^>]*>/i);
			//rebuild the the html variable with the italics tag at the beginning
			html = html.match(/<(i)[^>]*>/i)[0] + html.substring(0,tmptmp) + html.substring(tmptmp+html.match(/<(i)[^>]*>/i)[0].length,html.length);
		}
		//if you find a match for an end italics tag
		if (html.match(/<(\/i)[^>]*>/i) != null) {
			//store the position
			var tmptmp = html.search(/<(\/i)[^>]*>/i);
			//rebuild the string adding the end italics tag to the end
			html = html.substring(0,tmptmp) + html.substring(tmptmp+html.match(/<(\/i)[^>]*>/i)[0].length,html.length) +  html.match(/<(\/i)[^>]*>/i)[0];
		}
		//rebuild the string with the new link
		text = text.substring(0,text.search(reg)) + html + text.substring(text.search(reg)+text.match(reg)[0].length,text.length);
	}
	//return the new string
	return text;
}

/*
	function convertAtags
	converts A tags to < and end A tags to >
	Params: 
		text - the string to convert the a tags from.
	returns String tmp
*/
function convertAtags(text){
	var tmp = '';
	tmp = text.replace(/<(a)[^>]*>/gi,'&lt;').replace(/<(\/a)[^>]*>/gi,'&gt;');
	return tmp;
}