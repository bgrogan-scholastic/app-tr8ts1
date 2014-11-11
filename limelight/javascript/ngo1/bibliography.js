/** 
	@file: bibliography.js
	@description: This file is the main source of all the bibliography javascript calls

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	citation variables:
	
	objBibliography - the holder for the bibliography class element
	
**/	

var objBibliography;
/*
	function checkfordivid
	checks to see if when the page loads that a citation has been set to editable.
	Params: none
	returns Bool found
*/
//checks to see if when the page loads that a citation has been set to be editable
function checkfordivid() {
	var found = false;
	var location = window.location.href;
	//checks if from another page
	if (location.indexOf('#') != -1 ){
		if (location.indexOf('citationDiv') != -1) {
			found = location.substring(location.indexOf('citationDiv'));
			found = found.replace(/citationDiv/gi,'');
			found = found.replace(/itationDiv/gi,'');
			//the citation div number
			found = parseInt(found);
		}
	}
	return found;
}
/*
	class Bibliography
	the main Bibliography class
	Params: 
		uiBib - the container div for the bibliography.
	returns Class Bibliography.
*/
//the main bibliography "class"
function Bibliography(uiBib) {
	//the bibliography id
	/*
		Int id
		the bibliography id
	*/
	this.id = bibliographyid;
	//the main bibliography div
	/*
		Object bibDiv
		the main bibliography div
	*/
	this.bibDiv = $(uiBib);
	//initializes the bibliography class
	/*
		function Init
		Initializes the bibliography class.
		Params: none
		returns nothing
	*/
	this.Init = function() {
		//reinitializes the bibDiv from the class
		var tmpDiv = this.bibDiv;
		//the main bibliography class
		theparent = this;
		/* PHASE 2
		$('#changestylea').bind('click',function() {
			theparent.changeStyle(this);
			return false;
		});*/
		//set the add new citation button
		$('#add_new_citation').bind('click',function() {
			objBibliography.checkEditAdd(citationData.length,function() {objBibliography.addNewCitation();});
		});
		//if there are citations
		if (citationData.length != 0) {
			this.buildBibliography(theparent);
			var tmp = checkfordivid();
			if (tmp !== false) {
				this.editCitation(tmp);
			}
		} else { //if there are no citations
			this.bibDiv.html(' ');		
		}
	}
	//saves the new citation
	/*
		function addCitation
		saves a new citation
		Params: 
			index - the index of the new citation
		returns nothing
	*/
	this.addCitation = function(index) {
		var pubmediumid = $(':radio[name=medium'+index+']:checked').attr('value');
		var citationsourcetype = $('#contentType'+index+' option:selected').attr('value');
		var tmphtml = this.parseIframeHTML(document.getElementById('italTextArea'+index));
		//if there is something in the editable iframe
		if (tmphtml != false){	
			this.saveCitation(index,tmphtml,pubmediumid,citationsourcetype);
		} else {//nothing in the iframe
			this.removeAddCitation();	
		}
	}
	//builds the new citation div
	/*
		function addNewCitation
		builds the new citation div
		Params: none
		returns nothing
	*/
	this.addNewCitation = function() {
		if ($('#newcitationDiv').length == 0) {//if there is no add citation
			//set up the variables to use
			var citationDiv, topDiv, botDiv, divCitation, optionsDiv, clearDiv, pCitation, tmpCitation;
			var labelSpan, pubP, italLabel, contentlabel, needHelpa, contentSelect, italDiv, italbutton, italIframe, spacerDiv;
			var formatLabel, formatP, exampleLabel, exampleP, cancelButton, saveButton, buttonDiv, radio1, radio1label, radio2, radio2label, contentDivNew;
			var NewNum = citationData.length;
			saveButton = $(document.createElement('input')).attr({'type':'button','name':'save_citation','class':'truebutton','value':'Save', 'id':'save'+NewNum}).click(function() {
				objBibliography.addCitation(NewNum);
			});
			//builds all the elements
			cancelButton = $(document.createElement('input')).attr({'type':'button','name':'cancel','class':'truebutton','value':'Cancel','id':'cancel'+NewNum}).css('margin-right','5px').click(function(){objBibliography.removeAddCitation();});
			citationDiv = $(document.createElement('div')).attr({'class':'citationDiv selectDiv','id':'newcitationDiv','value':NewNum});
			topDiv = $(document.createElement('div')).attr('class','top selectDiv '+NewNum);
			botDiv = $(document.createElement('div')).attr('class','bot selectDiv '+NewNum);
			divCitation = $(document.createElement('div')).attr('class','citation '+NewNum);
			optionsDiv = $(document.createElement('div')).attr({'class':'options '+NewNum,'id':'options'+NewNum}).css({'visibility':'hidden'});
			clearDiv = $(document.createElement('div')).attr('class','clear '+NewNum);
			pCitation = $(document.createElement('p')).attr('id','pCitation'+NewNum);
			labelSpan = $(document.createElement('span')).attr('class','label '+NewNum).html('Publication Medium');
			pubP = $(document.createElement('p')).attr('class','pubMedium '+NewNum);
			radio1label = $(document.createElement('label')).attr({'for':'radio1','class':'ieLabel'}).html('Electronic');
			radio1 = $(document.createElement('input')).attr({'id':'radio1','type':'radio','class':'radio','name':'medium'+NewNum,'value':'1'}).click(function(){objBibliography.buildContentList(1,$('#contentType'+NewNum)); $(':radio[name=medium'+NewNum+']:checked').removeAttr('checked'); $(this).attr('checked','checked');});
			radio2label = $(document.createElement('label')).attr({'for':'radio2','class':'ieLabel'}).html('Print');
			radio2 = $(document.createElement('input')).attr({'id':'radio2','type':'radio','class':'radio','name':'medium'+NewNum,'value':'2'}).click(function(){objBibliography.buildContentList(2,$('#contentType'+NewNum)); $(':radio[name=medium'+NewNum+']:checked').removeAttr('checked'); $(this).attr('checked','checked');});
			italLabel = $(document.createElement('label')).attr({'for':'italTextArea','class':'labelHide'}).html('Italicize');
			contentlabel = $(document.createElement('label')).attr({'for':'contentType','class':'ieLabel'}).html('What type of content are you citing?');
			contentDivNew = $(document.createElement('div')).css('height','24px');
		needHelpa = $(document.createElement('a')).attr({'href':'#','class':'needHelp','id':'needHelp'+NewNum}).html('Need Help?').click(function(){//build the contextual help popup
			getcontextualhelp('bibliography','help-0011',function(data){
				objBibliography.openContextHelp(data,$('#needHelp'+NewNum));
			}); 
			return false;
		});
			contentSelect = $(document.createElement('select')).attr({'id':'contentType'+NewNum,'name':'contentType'+NewNum}).css('float','left');		
			//builds the contest list
			this.buildContentList(1,contentSelect);
			italDiv = $(document.createElement('div')).attr({'class':'italCont '+NewNum,'id':'italCont'+NewNum}).css({'clear':'left','margin-top':'6px','width':'300px','height':'150px', 'visibility':'hidden'});
			italbutton = $(document.createElement('input')).attr({'type':'button','id':'italicize','name':'italicize','class':'truebutton','value':'Italicize'}).click(function(){objBibliography.MakeItalic(NewNum);});
			italIframe = $(document.createElement('iframe')).attr({'src':'about:blank','id':'italTextArea'+NewNum,'class':'ital ','frameborder':'0'}).css({'cursor':'text','height':'123px','width':'300px'}).bind('load',function(){this.designMode='on';});
			spacerDiv = $(document.createElement('div')).attr('class','spacer');
			formatLabel = $(document.createElement('span')).attr({'class':'label'}).html('Format');
			formatP = $(document.createElement('p')).attr({'class':'example','id':'formatexample'+NewNum}).css({'margin-right':'5px'});
			exampleLabel = $(document.createElement('span')).attr({'class':'label'}).html('Example');
			exampleP = $(document.createElement('p')).attr({'class':'example','id':'exampleexample'+NewNum}).css({'margin-right':'5px'});
			buttonDiv = $(document.createElement('div')).attr('class','buttonsection').css({'float':'right','padding-right':'10px'});
			//sets the change event of the content select box
			contentSelect.bind('change',function() {
				//if the selected content is not "Select..."
				if(this.selectedIndex != 0) {
					//change the format example
					objBibliography.changeFormatExample(parseInt(this.options[this.selectedIndex].value),NewNum);
					//if the options are not visible set them
					if ($('#options'+NewNum).css('visibility') != 'visible') {
						$('#options'+NewNum).css({visibility:'visible'});
						$('#italCont'+NewNum).css({visibility:'visible'});
						$('#italTextArea'+NewNum).css({display:'block'});	
						//allow edits on the iframe
						objBibliography.MakeEditable(document.getElementById("italTextArea"+NewNum))
					}
					if($.browser.safari){
						//css position will only update if something is physically updated for safari
						$('#safariErrFix').html("");
					}
				} else {
					//hide the options
					$('#options'+NewNum).css({visibility:'hidden'});
					$('#italCont'+NewNum).css({visibility:'hidden'});
					$('#italTextArea'+NewNum).css({display:'none'});
				}
			});			
			//build the add new citation element from all the other elements
			italDiv.append(italbutton).append(italIframe);
			pubP.append(radio1).append(radio1label).append(radio2).append(radio2label);
			contentDivNew.append(contentSelect).append(needHelpa);
			divCitation.append(labelSpan).append(pubP).append(italLabel).append(contentlabel).append(contentDivNew).append(italDiv);
			optionsDiv.append(spacerDiv).append(formatLabel).append(formatP).append(exampleLabel).append(exampleP);
			buttonDiv.append(cancelButton).append(saveButton);
			botDiv.append(divCitation).append(optionsDiv).append(clearDiv).append(buttonDiv);
			clearDiv = $(document.createElement('div')).attr('class','clear '+NewNum);
			botDiv.append(clearDiv);		
			citationDiv.append(topDiv).append(botDiv).hide();
			this.bibDiv.prepend(citationDiv.show('slow'));
			$(':radio[name=medium'+NewNum+'][value=1]').attr('checked','checked');
			var italFrame = document.getElementById('italTextArea'+NewNum);
			if (italFrame.contentDocument) {
				var theIframecontent = 	italFrame.contentDocument;
			} else if(italFrame.contentWindow) {
				var theIframecontent = 	italFrame.contentWindow.document;		
			} else if(italFrame.document) {
				var theIframecontent = 	italFrame.document;		
			}
			theIframecontent.open();
			theIframecontent.write('<body></body>');
			theIframecontent.close();
		}
	}
	/*
		function buildBibliograpgy
		builds the bibliography HTML.
		Params: 
			parent - the Bibliography class
		returns nothing
	*/
	//builds the bibliography
	this.buildBibliography = function(parent) {
		//set a temp variable for the main div and clear the html
		var tmpmaindiv = $(document.createElement('div')).attr('id','tmpdiv');
		tmpmaindiv.html('');
		//set the basic element variables
		var citationDiv, topDiv, botDiv, divCitation, optionsDiv, clearDiv, pCitation, citationanchor;	
		//loop through the citations
		$.grep(citationData,function(n,i){
			var tmpCitation = '';			
			//create the elements
			citationDiv = document.createElement('div');
			topDiv = document.createElement('div');
			botDiv = document.createElement('div');
			divCitation = document.createElement('div');
			optionsDiv = document.createElement('div');
			clearDiv = document.createElement('div');
			pCitation = document.createElement('p');
			//set the attributes, the css, and the hover events
			$(citationDiv).attr({'class':'citationDiv normDiv','id':'citationDiv'+i,'value':i});
			parent.hoverCitationOver($(citationDiv),i);
			parent.hoverCitationOut($(citationDiv),i);
			$(topDiv).attr('class','top normDiv');
			$(botDiv).attr('class','bot normDiv');
			$(divCitation).attr('class','citation');
			$(optionsDiv).attr({'class':'options','value':i,'notesopen':'false'});
			$(clearDiv).attr('class','clear');
			$(pCitation).css('margin-right','15px').attr('class','pCitation');
			//check which type of citation it is and store the text for that citaiton
			tmpCitation = n._autocite == 1 ? n._citationtextarray["'"+citationtypeid+"'"] : n._citationtext;
			if (typeof(tmpCitation) != 'undefined' && tmpCitation != '' && stripHTMLnospace(tmpCitation).indexOf('http://') != -1) {
				tmpCitation = findHTTP(tmpCitation);
			}
			//bind the elements to each other in order and write them to the page
			$(pCitation).html(tmpCitation);
			$(divCitation).append(pCitation);
			$(botDiv).append(divCitation).append(optionsDiv).append(clearDiv);
			$(citationDiv).append(topDiv).append(botDiv);
			citationanchor = $(document.createElement('a')).attr('name','citationDiv'+i);
			tmpmaindiv.append(citationanchor).append(citationDiv);
		});			
		$(parent.bibDiv).html(tmpmaindiv);	
	}
	/*
		function buildContentList
		builds the citation content type dropdown
		Params: 
			pubmediumid - the publication medium id to check against.
			contentSelect - the citation content select box to add the options to.
			tmpopt - check if the "Select..." option is needed.
		returns nothing
	*/
	//builds the citation content dropdown
	this.buildContentList = function(pubmediumid, contentSelect,tmpopt) {
		var tmp = '';
		//if the select... option is needed
		if (tmpopt != 1)
		tmp = '<option selected="selected">Select...</option>\n';
		//build the content list html
		$(citationcontenttypeData).each(function() {
			if (this._pubmediumid == pubmediumid) {
				tmp += '<option value='+this._citationcontenttypeid+' id="option'+this._citationcontenttypeid+'">'+this._description+'</option>\n';
			}
		});
		//write the html to the dropdown and trigger the change event
		$(contentSelect).html(tmp);
		$(contentSelect).trigger('change');
	}
	/*
		function changeFormatExample
		changes the format and example
		Params: 
			citationcontenttypeid - the current citation content type id
			index - the index of the citation in the citationlist json object
		returns nothing
	*/
	//changes the format and example
	this.changeFormatExample = function(citationcontenttypeid, index) {
		//get the format and example that match the citation content type selected and write the default or the found format and example
		var formatexample = $.grep(citationformatexampleData,function(n,i){
			return (parseInt(n._citationtypeid) == parseInt(citationtypeid) && parseInt(n._citationcontenttypeid) == parseInt(citationcontenttypeid));
		});
		if (formatexample == '') {
			formatexample[0] = new Object();
			formatexample[0]._citationformat = 'No format available';
			formatexample[0]._citationexample = 'No example available';
		}
		$('#formatexample'+index).html(findHTTP(formatexample[0]._citationformat));
		$('#exampleexample'+index).html(findHTTP(formatexample[0]._citationexample));
	}
	
	/* PHASE 2 changes the citation style
	this.changeStyle = function(obj) {
		if ($('#changestylediv').length == 0) {
			var div = document.createElement('div');
			var ul = document.createElement('ul');
			var li = document.createElement('li');
			$(ul).css({'list-style':'none','padding':'0','margin':'0'});
			$(li).attr({'id':'APAStyle','value':'3'});
			$(li).css('font-size','9pt');
			$(li).hover(
				function() {
					$(this).css({'background-color':'#ffcc33'});
				},
				function() {
					$(this).css({'background-color':'#ffffff'});
				}
			);
			$(li).click(function(e) {
				$('#citationstylespan').html('APA');
				$('#changestylediv').hide("slow");
				if ($(this).attr('value') != citationtypeid) {
					$.get('srm_manager_citation.php',{func:'updateassignmentcitationtype',profileid:profileid,citationtypeid:$(this).attr('value'),assignmnetid:assignmentid},function() {
																 
					});
				}
			}).html('APA Style');
			$(ul).append(li);
			li = document.createElement('li')
			$(li).attr({'id':'MLAStyle','value':'1'});
			$(li).css('font-size','9pt');
			$(li).hover(
				function() {
					$(this).css({'background-color':'#ffcc33'});
				},
				function() {
					$(this).css({'background-color':'#ffffff'});
				}
			);
			$(li).click(function(e) {
				$('#citationstylespan').html('MLA');
				$('#changestylediv').hide("slow");
				if ($(this).attr('value') != citationtypeid) {
					$.get('srm_manager_citation.php',{func:'updateassignmentcitationtype',profileid:profileid,citationtypeid:$(this).attr('value'),assignmnetid:assignmentid},function() {
																 
					});
				}				
			}).html('MLA Style');
			$(ul).append(li);
			li = document.createElement('li')
			$(li).attr({'id':'ChicagoStyle','value':'2'});
			$(li).css('font-size','9pt');
			$(li).hover(
				function() {
					$(this).css({'background-color':'#ffcc33'});
				},
				function() {
					$(this).css({'background-color':'#ffffff'});
				}
			);
			$(li).click(function(e) {
				$('#citationstylespan').html('Chicago');
				$('#changestylediv').hide("slow");
				if ($(this).attr('value') != citationtypeid) {
					$.get('srm_manager_citation.php',{func:'updateassignmentcitationtype',profileid:profileid,citationtypeid:$(this).attr('value'),assignmnetid:assignmentid},function() {
																 
					});
				}				
			}).html('Chicago Manual');
			$(ul).append(li);
			$(div).attr({'id':'changestylediv','z-index':'10'}).css({'background-color':'white','border':'1px solid black', 'width':'100px', 'padding':'0','margin':'0'}).hide().append(ul);
			$('body').append(div);
		}
		if ($('#changestylediv').css('display') != 'block') {
			var tmptop = $(obj).offset().top+13;
			$('#changestylediv').css({'position':'absolute','top':tmptop+'px','left':$(obj).offset().left+'px'})
			$('#changestylediv').show('slow');
		}
	}
	*/
	/*
		function changeCitationStyle
		changes the citation style on the page
		Params: 
			json - a json object to represent the assignment
		returns nothing
	*/
	this.changeCitationStyle = function(json) {	
	//set thte citationtypeid
		if (typeof(json) != 'undefined' && json != 'undefined') {
			citationtypeid = json._citationtypeid;		
		} else {
			citationtypeid = $.grep(json_assignmentlist,function (n,i){
				return (n._assignmentid == currassgn);
			})[0]._citationtypeid;
			if (citationtypeid == null) citationtypeid = 1;
		}
		//write the citation style to the page
		switch(parseInt(citationtypeid)) {
			case 1:
				$('#citationstylespan').html('MLA');
				break;
			case 2:
				$('#citationstylespan').html('Chicago');
				break;
			case 3:
				$('#citationstylespan').html('APA');
				break;			
			default:
				$('#citationstylespan').html('MLA');
				break;			
		}
	}
	/*
		function checkEditAdd
		checks to see if there are any open citation panels. if there are citation panels open check to see if they 			        are to be saved before opening another citation panel.
		Params: 
			index - the index of the citation in the citation list json object.
			callback - a function to call after the check has been run.
		returns nothing
	*/
	this.checkEditAdd = function(index, callback) {
		var thetmpcitation;
		//check if the citation to check is not a new one
		if (index != citationData.length) {
			thetmpcitation = citationData[index]._citationid;
		} else {
			thetmpcitation = 0;
		}
		//loop through the citation divs
		var tmpcitations = $('div.citationDiv');		
		if (tmpcitations.length != 0) {
			//if there is a new citation div
			if ($('#newcitationDiv').length != 0) {
				//if the citation is saved just close it otherwise ask the user if they want to save.
				if (objBibliography.checkIfSaved($('#newcitationDiv').attr('value'))) {
					objBibliography.removeAddCitation();
					objBibliography.finishCheckEdit(thetmpcitation,callback);
				} else {
					var tmpindex = $('#newcitationDiv').attr('value');
					var pubmediumid = $(':radio[name=medium'+tmpindex+']:checked').attr('value');
					var citationsourcetype = $('#contentType'+tmpindex+' option:selected').attr('value');
					var tmphtml = this.parseIframeHTML(document.getElementById('italTextArea'+tmpindex));					
					warning({
						title:'Warning',
						msg:'Would you like to save the citation "'+findHTTP(tmphtml)+'"?',
						noAction:function(){
							objBibliography.buildBibliography(objBibliography);
							objBibliography.finishCheckEdit(thetmpcitation,callback);},
						yesAction:function(){
							objBibliography.saveCitation(tmpindex,tmphtml,pubmediumid,citationsourcetype);
							objBibliography.buildBibliography(objBibliography);
							objBibliography.finishCheckEdit(thetmpcitation,callback);},
						cancelAction:function(){return false;}
					});	
				}
			} else {
				//check if there are any editable citation currently open
				if ($('div.citationDiv[EditMode=true]').length != 0) {
					//for each one that is found check if the citation is saved. if they are just close the citation otherwise ask if the user wants to save.
					$('div.citationDiv[EditMode=true]').each(function() {
						if ($(this).attr('value') != index) {
							if (objBibliography.checkIfSaved($(this).attr('value'))) {
								objBibliography.buildBibliography(objBibliography);							
								objBibliography.finishCheckEdit(thetmpcitation,callback);
							} else {
								var tmpindex = $(this).attr('value');
								var pubmediumid = $(':radio[name=medium'+tmpindex+']:checked').attr('value');
								var citationsourcetype = $('#contentType'+tmpindex+' option:selected').attr('value');
								var tmphtml = objBibliography.parseIframeHTML(document.getElementById('italTextArea'+tmpindex));		
								warning({							
									title:'Warning',
									msg:'Would you like to save the citation "'+findHTTP(tmphtml)+'"?',
									noAction:function(){
										objBibliography.buildBibliography(objBibliography);
										objBibliography.finishCheckEdit(thetmpcitation,callback);},
									yesAction:function(){
										objBibliography.saveCitation(tmpindex,tmphtml,pubmediumid,citationsourcetype, true);
										objBibliography.buildBibliography(objBibliography);									
										objBibliography.finishCheckEdit(thetmpcitation,callback);
									},
									cancelAction:function(){return false;}
								});	
							}							
						} else {
							objBibliography.finishCheckEdit(thetmpcitation,callback);								
						}
					});
				} else {
					objBibliography.finishCheckEdit(thetmpcitation,callback);	
				}
			}
		} else {
			objBibliography.finishCheckEdit(thetmpcitation,callback);	
		}
	}	
	/*
		function checkIfSaved
		checks to see if a citation has been saved.
		Params: 
			index - the index of the citation in the citation list json object.
		returns nothing
	*/
	this.checkIfSaved = function(index) {
		//get the pub medium id, the citation content type, and the html from the iframe
		var pubmediumid = $(':radio[name=medium'+index+']:checked').attr('value');
		var citationsourcetype = $('#contentType'+index+' option:selected').attr('value');
		var tmphtml = this.parseIframeHTML(document.getElementById('italTextArea'+index));
		//check if the citation is a new citation and if the citation is empty or not. return true if saved
		if (index == citationData.length) {
			if (tmphtml != false) {
				return false;
			}
		} else {
			if (tmphtml != false) {
				if (tmphtml != citationData[index]._citationtext || pubmediumid != citationData[index]._pubmediumid || citationsourcetype != citationData[index]._citationcontenttypeid) {
					return false;	
				}
			}
		}
		return true;
	}
	/*
		function checkIfSavedLeave
		check if the bibliography is saved upon leave of the bibliography page.
		Params: none
		returns nothing
	*/
	this.checkIfSavedLeave = function() {
	//find the index of any editable citations
		var index = '';
		if ($('div.citationDiv[EditMode=true]').length != 0) {
			index = $('div.citationDiv[EditMode=true]').attr('value');
		} else if ($('#newcitationDiv').length != 0) {
			index = $('#newcitationDiv').attr('value');
		} else {
			return true;	
		}
		var pubmediumid = $(':radio[name=medium'+index+']:checked').attr('value');
		var citationsourcetype = $('#contentType'+index+' option:selected').attr('value');
		var tmphtml = this.parseIframeHTML(document.getElementById('italTextArea'+index));
		//check if the citation is saved
		if (index == citationData.length) {
			if (tmphtml != false) {
				return false;
			}
		} else {
			if (tmphtml != false) {
				if (tmphtml != citationData[index]._citationtext || pubmediumid != citationData[index]._pubmediumid || citationsourcetype != citationData[index]._citationcontenttypeid) {
					return false;	
				}
			}
		}
		return true;
	}
	/*
		function deleteWarning
		asks if the user wants to delete the citation from the bibliography
		Params: 
			index - the index of the citation in the citation list json object.
		returns nothing
	*/
	this.deleteWarning = function(index){
		var tmpcitation = citationData[index]._autocite == 1 ? citationData[index]._citationtextarray["'"+citationtypeid+"'"] : citationData[index]._citationtext;
		var tmpnotecards = $.grep(noteStore,function(n,i){
			return (n._citationid == citationData[index]._citationid);
		});
		if (tmpnotecards.length != 0) {
			var msg1 = 'This citation has one or more Note Cards associated to it.  Are you sure you want to delete this citation?';	
		} else {
			var msg1 = 'Are you sure you want to delete the citation "'+findHTTP(tmpcitation)+'"?';
		}
		warning({
			title:'Warning',
			msg:msg1,
			noAction:function(){return false;},
			yesAction:function(){deleteCitation(index);},
			cancelAction:function(){return false;}
		});	
	}
	/*
		function editCitation
		makes the citation editable
		Params: 
			index - the index of the citation in the citation list json object.
		returns nothing
	*/
	//makes the citation editable
	this.editCitation = function(index) {
		//create the variables for the citation
		var citationDiv, topDiv, botDiv, divCitation, optionsDiv, clearDiv, pCitation, tmpCitation;
		var labelSpan, pubP, italLabel, contentlabel, needHelpa, contentSelect, italDiv, italbutton, italIframe, spacerDiv;
		var formatLabel, formatP, exampleLabel, exampleP, cancelButton, saveButton, buttonDiv, radio1, radio1label, radio2, radio2label, contentDivNew;
		var NewNum = index;
		var i = index
		var aImg = document.createElement('a');
		var aNotes = document.createElement('a');
		var aEdit = document.createElement('a');
		var aDelete = document.createElement('a');
		var Img = document.createElement('img');
		var ViewSpan = document.createElement('span');
		var EditSpan = document.createElement('span');
		//build the elements, attributes, css, and events
		saveButton = $(document.createElement('input')).attr({'type':'button','name':'save_citation','class':'truebutton','value':'Save', 'id':'save'+NewNum}).click(function() {
			objBibliography.saveEditCitation(NewNum);
		});
		citationDiv = $(document.createElement('div')).attr({'class':'citationDiv selectDiv','id':'citationDiv'+i,'EditMode':'true', 'value':index});
		cancelButton = $(document.createElement('input')).attr({'type':'button','name':'cancel','class':'truebutton','value':'Cancel','id':'cancel'+NewNum}).css('margin-right','5px').click(function(){objBibliography.bibDiv.html('');																																																  objBibliography.buildBibliography(objBibliography);});
		topDiv = $(document.createElement('div')).attr('class','top selectDiv '+NewNum);
		botDiv = $(document.createElement('div')).attr('class','bot selectDiv '+NewNum);
		divCitation = $(document.createElement('div')).attr('class','citation '+NewNum);
		optionsDiv = $(document.createElement('div')).attr({'class':'options '+NewNum,'id':'options'+NewNum,'value':NewNum,'notesopen':'false'});
		clearDiv = $(document.createElement('div')).attr('class','clear '+NewNum);
		pCitation = $(document.createElement('p')).attr('id','pCitation'+NewNum);
		labelSpan = $(document.createElement('span')).attr('class','label '+NewNum).html('Publication Medium');
		pubP = $(document.createElement('p')).attr('class','pubMedium '+NewNum);
		radio1label = $(document.createElement('label')).attr({'for':'radio1','class':'ieLabel'}).html('Electronic');
		radio1 = $(document.createElement('input')).attr({'id':'radio1','type':'radio','class':'radio','name':'medium'+NewNum,'value':'1'}).click(function(){objBibliography.buildContentList(1,$('#contentType'+NewNum),1); $(':radio[name=medium'+NewNum+']:checked').removeAttr('checked'); $(this).attr('checked','checked');});
		radio2label = $(document.createElement('label')).attr({'for':'radio2','class':'ieLabel'}).html('Print');
		radio2 = $(document.createElement('input')).attr({'id':'radio2','type':'radio','class':'radio','name':'medium'+NewNum,'value':'2'}).click(function(){objBibliography.buildContentList(2,$('#contentType'+NewNum),1); $(':radio[name=medium'+NewNum+']:checked').removeAttr('checked'); $(this).attr('checked','checked');});
		italLabel = $(document.createElement('label')).attr({'for':'italTextArea','class':'labelHide'}).html('Italicize');
		contentlabel = $(document.createElement('label')).attr({'for':'contentType','class':'ieLabel'}).html('What type of content are you citing?');
		contentDivNew = $(document.createElement('div')).css({'height':'24px','padding-top':'5px'});
		needHelpa = $(document.createElement('a')).attr({'href':'#','class':'needHelp','id':'needHelp'+NewNum}).html('Need Help?').click(function(){
			getcontextualhelp('bibliography','help-0011',function(data){
				objBibliography.openContextHelp(data,$('#needHelp'+NewNum));
			}); 
			return false;
		});
		contentSelect = $(document.createElement('select')).attr({'id':'contentType'+NewNum,'name':'contentType'+NewNum}).css('float','left');		
		objBibliography.buildContentList(1,contentSelect,1);
		italDiv = $(document.createElement('div')).attr({'class':'italCont '+NewNum,'id':'italCont'+NewNum}).css({'clear':'left','margin-top':'6px','width':'300px','height':'150px'});
		italbutton = $(document.createElement('input')).attr({'type':'button','id':'italicize','name':'italicize','class':'truebutton','value':'Italicize'}).click(function(){objBibliography.MakeItalic(NewNum);});
		italIframe = $(document.createElement('iframe')).attr({'src':'about:blank','id':'italTextArea'+NewNum,'class':'ital ','frameborder':'0'}).css({'cursor':'text','height':'123px','width':'300px'}).bind('load',function(){this.designMode='on';});
		spacerDiv = $(document.createElement('div')).attr('class','spacer spacer'+NewNum);
		formatLabel = $(document.createElement('span')).attr({'class':'label format'+NewNum}).html('Format');
		formatP = $(document.createElement('p')).attr({'class':'example','id':'formatexample'+NewNum}).css({'margin-right':'5px'});
		exampleLabel = $(document.createElement('span')).attr({'class':'label'}).html('Example');
		exampleP = $(document.createElement('p')).attr({'class':'example','id':'exampleexample'+NewNum}).css({'margin-right':'5px'});
		buttonDiv = $(document.createElement('div')).attr('class','buttonsection').css({'float':'right','padding-right':'10px'});
		contentSelect.bind('change',function() {
			if(this.options[this.selectedIndex].innerHTML != 'Select...') {
				objBibliography.changeFormatExample(parseInt(this.options[this.selectedIndex].value),NewNum);
			}
		});
		$(ViewSpan).attr('id','viewSpan'+i);
		$(EditSpan).attr('id','editSpan'+i);
		$(Img).attr({'src':'/images/bibliography/max.jpg','alt':'View Note Cards','id':'image'+i});
		$(aImg).attr({'href':'#','title':'View Note Cards', 'id':'imagelink'+i});
		$(aImg).append(Img).click(function() {$('#view'+i).click();});
		$(aNotes).attr({'href':'#','title':'View Note Cards', 'id':'view'+i}).text('View Note Cards').click(function() {objBibliography.openNotecards(i); return false; /*placeholder for function*/ });
		$(aEdit).attr({'href':'#','title':'Edit', 'id':'edit'+i, 'class':'editSelect', 'cursor':'text'}).text('Edit').click(function() {
			return false;
		});
		$(aDelete).attr({'href':'#','title':'Delete', 'id':'delete'+i}).text('Delete').click(function() {
			objBibliography.deleteWarning(i);
			return false;
		});			
		//append the elements in the order needed
		$(ViewSpan).append(aImg).append(' ').append(aNotes).append(' | ');
		$(EditSpan).append(aEdit).append(' | ');
		$(optionsDiv).append(ViewSpan).append(EditSpan).append(aDelete);
		var tmpCitation = $.grep(noteStore, function(n,m) {
			return (n._citationid == citationData[i]._citationid);
		});
		if (tmpCitation.length == 0) {
			$(optionsDiv).find('#viewSpan'+i).css('visibility','hidden');	
		} else {
			$(optionsDiv).find('#viewSpan'+i).css('visibility','visible');
		}
		italDiv.append(italbutton).append(italIframe);
		pubP.append(radio1).append(radio1label).append(radio2).append(radio2label);
		contentDivNew.append(contentSelect).append(needHelpa);
		divCitation.append(italDiv).append(labelSpan).append(pubP).append(italLabel).append(contentlabel).append(contentDivNew);
		optionsDiv.append(spacerDiv).append(formatLabel).append(formatP).append(exampleLabel).append(exampleP);
		buttonDiv.append(cancelButton).append(saveButton);
		botDiv.append(divCitation).append(optionsDiv).append(clearDiv).append(buttonDiv);
		clearDiv = $(document.createElement('div')).attr('class','clear '+NewNum);
		botDiv.append(clearDiv);		
		citationDiv.append(topDiv).append(botDiv);
		$('#citationDiv'+index).replaceWith(citationDiv);
		var italFrame = document.getElementById('italTextArea'+i);
		var tmpcitation = citationData[index]._autocite == 1 ? citationData[index]._citationtextarray["'"+citationtypeid+"'"] : citationData[index]._citationtext;		
		if (italFrame.contentDocument) {
			var theIframecontent = 	italFrame.contentDocument;
		} else if(italFrame.contentWindow) {
			var theIframecontent = 	italFrame.contentWindow.document;		
		} else if(italFrame.document) {
			var theIframecontent = 	italFrame.document;		
		}
		if ($.browser.msie) {
			tmpcitation = tmpcitation.replace(/<(i)[^>]*>/ig,'<em>').replace(/<(\/i)[^>]*>/gi,'</em>');
		} else if ($.browser.mozilla) {
			tmpcitation = tmpcitation.replace(/<(i)[^>]*>/ig,'<span style="font-style: italic;">').replace(/<(\/i)[^>]*>/gi,'</span>');
		} 
		//write the citation information into the iframe
		theIframecontent.open();
		theIframecontent.write('<body>'+tmpcitation+'</body>');
		theIframecontent.close();
		//make the iframe editable and set the pub medium type, citation content type, format, and example.
		objBibliography.MakeEditable(italFrame,tmpcitation);
		$(':radio[name=medium'+i+'][value='+citationData[i]._pubmediumid+']').attr('checked','checked').trigger('click');
		if ($.browser.msie && parseInt($.browser.version()) == 6)  {
			setTimeout("$('#contentType"+index+"').find('#option"+citationData[index]._citationcontenttypeid+"').attr('selected','selected')",200);
			setTimeout("$('#contentType"+index+"').trigger('change');",250);
		} else {
			$('#contentType'+index).find('#option'+citationData[index]._citationcontenttypeid).attr('selected','selected').trigger('click');
			$('#contentType'+index).trigger('change');
		}
	}
	/*
		function exportPopup
		builds the popup for export html or word.
		Params: none
		returns nothing
	*/
	//pops up the export popup
	this.exportPopup = function() {
		warning({
			title:'Export',
			msg:'You have chosen to export your Bibliography. Please choose an export format and click Export.<br><br><b>Format:</b><br><div><span><input type="radio" name="format" value="rtf" checked="checked"/>Word</span><span style="width:150px;">&nbsp;</span><span><input type="radio" name="format" value="html" />HTML</span></span>',
			buttons: 'Cancel,Export',
			noAction:function(){window.location.href='export.php?tool=bibliography&apptype='+$(':radio[name=format]:checked').attr('value'); collectStat('biblio','xs','xport',''); return false;},
			yesAction:function(){ return false;},
			cancelAction:function(){return false;}
		});
	}
	/*
		function finishCheckEdit
		edits the citation from the citation panel.
		Params: 
			tmpcitationid - the id of the citation to be edited
			callback - a function to call after the check has been run.
		returns nothing
	*/
	//edits the citation from the citation panel
	this.finishCheckEdit = function(tmpcitationid, callback) {
		var index;
		if (tmpcitationid != 0) {
			$.grep(citationData,function(n,i){
				if(tmpcitationid == n._citationid){
					index = i
				}
			});
			$('#citationDiv'+index).attr('EditMode','true');
		}
		callback(index);
	}
	/*
		function hoverCitationOver
		the mouse over function for the citations
		Params: 
			obj - the object to set the mouseover function on
			i - the index of the citation in the citationlist json object
		returns nothing
	*/
	//the mouse over function for the citations.
	this.hoverCitationOver = function(obj, i) {
		//on mouseover
		obj.bind('mouseover',function(e) {
			$(this).attr('class',$(this).attr('class').replace(/normDiv/g,'selectDiv'));
			$(this).find('.normDiv').each(function() {
				$(this).attr('class',$(this).attr('class').replace(/normDiv/g,'selectDiv'));
			});
			$(this).find('.options').each(
				function() {
					if ($(this).html() == '') {
						//build the variables for the options and set the elements and attributes then add them to the options divs
						var aImg = document.createElement('a');
						var aNotes = document.createElement('a');
						var aEdit = document.createElement('a');
						var aDelete = document.createElement('a');
						var Img = document.createElement('img');
						var ViewSpan = document.createElement('span');
						var EditSpan = document.createElement('span');
						$(ViewSpan).attr('id','viewSpan'+i);
						$(EditSpan).attr('id','editSpan'+i);
						$(Img).attr({'src':'/images/bibliography/max.jpg','alt':'View Note Cards','id':'image'+i});
						$(aImg).attr({'href':'#','title':'View Note Cards', 'id':'imagelink'+i});
						$(aImg).append(Img).click(function() {$('#view'+i).click();return false;});
						$(aNotes).attr({'href':'#','title':'View Note Cards', 'id':'view'+i}).text('View Note Cards').click(function() {objBibliography.openNotecards(i); return false; /*placeholder for function*/ });
						$(aEdit).attr({'href':'#','title':'Edit', 'id':'edit'+i}).text('Edit').click(function() {
							objBibliography.checkEditAdd(i,function(index) {
								objBibliography.editCitation(index);
							});
							return false;
						});
						$(aDelete).attr({'href':'#','title':'Delete', 'id':'delete'+i}).text('Delete').click(function() {
							objBibliography.deleteWarning(i);
							return false;
						});
						$(ViewSpan).append(aImg).append(' ').append(aNotes).append(' | ');
						$(EditSpan).append(aEdit).append(' | ');
						$(this).append(ViewSpan).append(EditSpan).append(aDelete);
					}
					var tmpCitation = $.grep(noteStore, function(n,m) {
						return (n._citationid == citationData[i]._citationid);
					});
					if (tmpCitation.length == 0) {
						if (citationData[i]._autocite == 1) {
							$(this).find('#editSpan'+i).css('visibility','hidden');	
						} else {
							$(this).find('#editSpan'+i).show();
							$(this).find('#editSpan'+i).css('visibility','visible');							
						}
						$(this).find('#viewSpan'+i).css('visibility','hidden');	
						$('#notecarddiv'+i).hide();
						$('#image'+i).attr('src','/images/bibliography/max.jpg');
						$(this).attr('notesopen','false');
					} else {
						if (citationData[i]._autocite == 1) {
							$(this).find('#editSpan'+i).hide();							
						} else {
							$(this).find('#editSpan'+i).show();
							$(this).find('#editSpan'+i).css('visibility','visible');
						}
						$(this).find('#viewSpan'+i).css('visibility','visible');
					}				
					$(this).show();
				}
			);							   
		});
	}
	/*
		function hoverCitationOut
		the mouse out function for the citation
		Params: 
			obj - the object to be given the mouseout event.
			i - the index of the citation in the citation list json object.
		returns nothing
	*/
	//the mouse out function for the citation
	this.hoverCitationOut = function(obj, i) {
		obj.bind('mouseout',function(e) {
			$(this).attr('class',$(this).attr('class').replace(/selectDiv/g,'normDiv'));
			$(this).find('.selectDiv').each(function() {
				$(this).attr('class',$(this).attr('class').replace(/selectDiv/g,'normDiv'));
			});
			$(this).find('.options').hide();
		});
	}
	/*
		function MakeEditable
		makes the iframe editable.
		Params: 
			italdiv - the iframe object to be made editable
		returns nothing
	*/
	//makes the iframe editable
	this.MakeEditable = function(italdiv) {
		var theIframe = italdiv;
		//in moz you cannot change desgin mode straight away so try and then retry
		if (theIframe.contentDocument) {
			var theIframecontent = 	theIframe.contentDocument;
		} else if(theIframe.contentWindow) {
			var theIframecontent = 	theIframe.contentWindow.document;		
		} else if(theIframe.document) {
			var theIframecontent = 	theIframe.document;		
		}
			var theIframeWindow = theIframe.contentWindow || theIframe.window;
		if ($.browser.mozilla) {
			try{
				theIframecontent.designMode = "on";
			}catch(e){
				setTimeout(objBibliography.MakeEditable(italdiv,optionalHTML),250);
				return false;
			}
		} else {
			theIframecontent.designMode = "on";	
		}
		$(theIframecontent).bind('load',function(e) {
			if ($.browser.msie || $.browser.safari) {
					theIframecontent.body.contentEditable = true;
					theIframecontent.body.style.cursor = "text";
					theIframecontent.body.style.overflowX = "hidden";
					if ($.browser.msie) {
						theIframecontent.body.style.width = "285px";
					} else {
						if ($.browser.safari) {
							theIframecontent.body.style.width = "500px";
						}
					}
			} else {
				theIframecontent.body.contentEditable = true;
				theIframecontent.body.style.cursor = "text";		
				theIframecontent.body.style.width = "95%";
				theIframecontent.body.style.overflowX = "hidden";
				theIframecontent.body.style.wordWrap = "wrap";
			}
		});
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
				} else {
					if ($.browser.safari) {
						if (e.which == 62) {
							if (checkhtml.length+4>maxcitationsize) {
								return false;	
							} else {
										
							}
						}
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
		if ($.browser.safari && parseInt($.browser.version()) > 500)
		$(theIframe).css('padding-top','6px');
	}
	/*
		function MakeItalic
		makes the selected text italic
		Params: 
			index - the index of the citation in the citation list json object.
		returns nothing
	*/
	//makes the selected text italic
	this.MakeItalic = function(index) {
		var theIframe = document.getElementById("italTextArea"+index);
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
	/*
		function openContextHelp
		opens the context help popup
		Params: 
			data - the datat to put into the context help popup.		
			obj - the object to be given the popup.
		returns nothing
	*/
	//opens the context help popup
	this.openContextHelp = function(data,obj) {
		$('#contexthelptool p').html(data);
		$('#contextHelp').balloon(obj);
	}
	/*
		function closeNotecards
		closes the View Note Cards div in the bibliograpy citation
		Params: 
			index - the index of the citation in the citation list json object
		returns nothing
	*/
	//close the notecard div in the bibliography citation
	this.closeNotecards = function(index) {
			var tmpoptions = $('.options[value='+index+']');		
			$('#notecarddiv'+index).hide();
			$('#image'+index).attr('src','/images/bibliography/max.jpg');
			tmpoptions.attr('notesopen','false');	
	}
	/*
		function openNotecards
		opens the View Note Cards div in the bibliograpy citation
		Params: 
			index - the index of the citation in the citation list json object
		returns nothing
	*/
	//opens the notecard div in the bibliography citation
	this.openNotecards = function(index) {
		var tmpoptions = $('.options[value='+index+']');
		//if the notecard div is not open
		if (tmpoptions.attr('notesopen') == 'false') {
			//RECORD STAT HIT
			collectStat('notecard','xs','list','');
			//biuld the notecard div
			var tmpdiv, mainul, li, notecarda, removea;
			if ($('#notecarddiv'+index).length == 0) {
				tmpdiv = $(document.createElement('div')).attr({'class':'notecarddiv','id':'notecarddiv'+index}).css('width','240px');
				mainul = $(document.createElement('ul'));
			} else {
				tmpdiv = $('#notecarddiv'+index);
				mainul = tmpdiv.find('ul');	
				mainul.html('');
			}
			//loop through the notecards and find the ones associated to the citation and add those to the note card div
			$.grep(noteStore,function(n,i){
				if (n._citationid == citationData[index]._citationid) {				
					li = $(document.createElement('li')).attr({'id':'notecardli'+i,'class':'notecardli'+i});											
					notecarda = $(document.createElement('a')).attr({'href':'#','title':n._title}).click(function(){objBibliography.opennotetool(i); return false;}).html(n._title).css('padding-right','5px');				
					removea = $(document.createElement('a')).attr({'href':'#','class':'remove','title':'Remove'}).html('X').click(function(){return false;}).click(function(){objBibliography.removeCitation(i,index);});					
					li.append(notecarda).append(removea);					
				}
				mainul.append(li);
			});
			if ($('#notecarddiv'+index).length == 0) {
				tmpdiv.append(mainul);
				tmpdiv.css({'left':'0px','top':'4px','position':'relative'});
				if ($('.spacer'+index).length != 0) {				
					$('.spacer'+index).before(tmpdiv);
				} else {
					tmpoptions.append(tmpdiv);
				}
			} else {
				tmpdiv.show();	
			}
			tmpoptions.attr('notesopen','true');
			$('#image'+index).attr('src','/images/bibliography/min.jpg');			
		} else {
			$('#notecarddiv'+index).hide();
			$('#image'+index).attr('src','/images/bibliography/max.jpg');
			tmpoptions.attr('notesopen','false');
		}
	}
	/*
		function opennotetool
		opens the note card tool from the note card div in the bibliography citation
		Params: 
			index - the index of the note card in the note card list json object
		returns false
	*/
	//opens the notecard tool from the note card div
	this.opennotetool = function(index){
		//if the note card is open then show the note otherwise open the notecard
		if(noteCardOpen == true){
			noteChange('noteCard');
			showNote(index);
		} else {		
				InitNotecard();		
				$('#noteCard').show();
				showNote(index);
				noteCardOpen = true;
		}
		return false;
	}
	/*
		function parseIframeHTML
		gets the text from the iframe and parses the information
		Params: 
			iframe - the iframe to be checked for text
		returns String italFrameSource or false
	*/
	//gets the text from the iframe and parses the information
	this.parseIframeHTML = function(iframe) {
		var italFrame = iframe;
		if (italFrame.contentDocument) {
			var theIframecontent = 	italFrame.contentDocument;
		} else if(italFrame.contentWindow) {
			var theIframecontent = 	italFrame.contentWindow.document;		
		} else if(italFrame.document) {
			var theIframecontent = 	italFrame.document;		
		}
		var italFrameSource = theIframecontent.body.innerHTML;
		if (stripHTMLnospace(italFrameSource) != ''){
			return switchSpanoutlink(stripHTML(convertAtags(italFrameSource)));
		} else {
			return false;	
		}
	}
	/*
		function printPopup
		opens the print popup
		Params: none
		returns nothing
	*/
	//opens the print popup
	this.printPopup = function() {
		collectStat('pfe','xs','print','');
		thePopup1.newWindow('export.php?apptype=html&tool=bibliography&print=1','900','700','bibliographyPrint',1,0,0,1,0,0,0,0);
	}
	/*
		function remvoeAddCitation
		closes the new citation panel
		Params: none
		returns nothing
	*/
	//closes the new citation panel
	this.removeAddCitation = function() {
		$('#newcitationDiv').hide('slow');
		$('#newcitationDiv').remove();
	}
	/*
		function removeCitation
		asks if the user would like to remove the citation from the note card.
		Params: 
			notecardindex - the index of the notecard in the notecard list json object.
			index - the index of the citation in the citation list json object
		returns nothing
	*/
	//asks if you want to delete the citation
	this.removeCitation = function(notecardindex,index) {
		warning({
			title:'Warning',
			msg:'Are you sure you want to remove the citation from this note card?',
			noAction:function(){return false;},
			yesAction:function(){objBibliography.sendRemoveCitation(notecardindex,index);},
			cancelAction:function(){return false;}
		});
	}
	/*
		function saveCitation
		saves the citation
		Params: 
			index - the index of the citation in the citation list json object
			citationtext - the text to be updated
			pubmediumid - the publication medium id to be updated
			citationsourcetype - the citation source type to be updated
			force - a boolean to be passed to the update and insert citation functions
		returns nothing
	*/
	//saves the citation
	this.saveCitation = function(index,citationtext,pubmediumid,citationsourcetype, force) {
		if (typeof(citationData[index]) != 'undefined') {
			updateCitation(index,citationtext,pubmediumid,citationsourcetype, force);
			//RECORD STAT HIT
			collectStat('biblio','xs','save','');			
		} else {
			if (objBibliography.checkIfSaved(index)) {
				this.removeAddCitation();
			}	
			insertcustomcitation(index,citationtext,pubmediumid,citationsourcetype, force);
			//RECORD STAT HIT
			collectStat('biblio','xs','save','');
		}
	}
	/*
		function saveEditCitation
		saves the edited citation
		Params: 
			index - the index of the citation in the citation list json object
		returns nothing
	*/
	//saves the edited citation
	this.saveEditCitation = function(index) {
		var pubmediumid = $(':radio[name=medium'+index+']:checked').attr('value');
		var citationsourcetype = $('#contentType'+index+' option:selected').attr('value');
		var tmphtml = this.parseIframeHTML(document.getElementById('italTextArea'+index));
		if (tmphtml != false)
		{	
			//RECORD STAT HIT
			collectStat('biblio','xs','save','');
			this.saveCitation(index,tmphtml,pubmediumid,citationsourcetype);
		} else {
			//RECORD STAT HIT
			collectStat('biblio','xs','save','');
			this.buildBibliography(this);	
		}
	}	
	/*
		function sendRemoveCitation
		removes the citation from the database
		Params: 
			notecardindex - the index of the notecard in the notecard list json object
			index - the index of the citation in the citation list json object
		returns nothing
	*/
	//remove the citation from the database
	this.sendRemoveCitation = function(notecardindex, index) {
		var notecardid = noteStore[notecardindex]._notecardid;
		sendRemoveCitation(notecardid,index);
	}
	/*
		function updateCitation
		updates the citation
		Params: 
			index - the index of the citation in the citation list json object
			citationtext - the text to be updated
			pubmedid - the publication medium id to be updated
			citationcontenttypeid - the citation content type to be updated
		returns nothing
	*/
	//updates the citation
	this.updateCitation = function(index,citationtext,pubmedid,citationcontenttypeid) {
		updateCitation(index,citationtext,pubmedid,citationcontenttypeid);
	}
}