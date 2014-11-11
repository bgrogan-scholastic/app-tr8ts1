var objNoteCard;	
var noteCardOpen = false;
var expandTitleTextClosed = "Click to view all your note cards";
var expandTitleTextOpen = "Click to close all your note cards";
var alertTimeout = false;
var modifyid = 0;
// store temp avariable
var tempstr1;
var tempstr2;
var idflag=1;
var temptitle='';
var languageflag=0;
var temparray = new Array();
var i=0;
var noteid=0;
var saveflag=true;
var nextid=0;
var currentnoteid=0;
var profile_id=profileid;
var assignment_id=currassgn;
var assignmentid=currassgn;
var groupStore;
var noteStore;
var citesource = true;
var existsource = true;
var NotesIsVisible = false;


/*
window.onbeforeunload = function() {
		if (noteCardOpen) {
			return 'You currently have data on this page that has not been saved.';
		}
}
*/

/* If user enter anything in input and textarea, then initial saveflag to false.
   so it won't alert box won't pop up twice to ask user to save it.
*/
function randomstring(length) {
	var abc = 'abcdefghijklmnopqrstuvwxyz';
	var tmp = '';
	for (var i = 0; i < length;i++) {
		tmp += abc.substr(abc.length *Math.random(),1);
	}
	return tmp;
}


window.onload = function() {
	/*for (var i = 0; i < 101; i++){
		var tmptitle = randomstring(8);
		var tmpnote = randomstring(10);
		var tmpquote = randomstring(12);
				lockerReturn2('insertnotecard',profile_id,assignment_id,tmptitle,tmpnote,tmpquote,tmpnote.length,tmpquote.length,null,0);
	}
	alert('here');*/
	// initial group category to check with duplicate entry text
	
	$('#note_title').keypress(function() {
		saveflag=false;
		$('#save_note').removeAttr('disabled');
	});
	$('#note_text').keypress(function() {
		saveflag=false;
		$('#save_note').removeAttr('disabled');
	});
	$('#note_quotes').keypress(function() {
		saveflag=false;
		$('#save_note').removeAttr('disabled');
	});
	
	$('#note_category').mousedown(function() {
		saveflag=false;
		$('#save_note').removeAttr('disabled');
	});
	
	$('#popuup_div').hide();
	
	/* if a user click on take a note, it will disable the save button.
		else saveflag is false, it prompts for save when a user click on take a note.
	*/
	$('#takeanote').click(function() {
		if(noteCardOpen == true){
			if(checkIfNoteSaved() == true)
			{
				saveflag=true;
				$('#save_note').attr('disabled','disabled');
			} else {
				warning({
				title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){resetform();},
				yesAction:function(){if (saveNote() != false) {
					resetform();}
					else {return false;}},
				cancelAction:function(){return false;}
				});
			}
		} else {
			GetNoteAndGroups(assignment_id);
		}
	});
	
	
	/* if a user click on add citation, it will disable the save button.
		else saveflag is false, it prompts for save when a user click on add citation.
	*/
	$('#addcit').click(function() {
			return false;
			if(checkIfNoteSaved()==false) 
			{
			         warning({
						title:'Warning',
						msg:'Would you like to Save the current note?',
						noAction:function(){
						resetform();
						saveflag=false;
						$('#save_note').attr('disabled','disabled');
						},
						yesAction:function(){
						if (saveNote() != false) {
					resetform();
						saveflag=false;
						$('#save_note').attr('disabled','disabled');}
					else {return false;}
						},
						cancelAction:function(){
						return false;
						}
					});
			}
	});
	
	$('#closenotecard').click(function() {
			if((checkIfNoteSaved()==false)&&(noteCardOpen))
			{
				warning({
				title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){return false;},
				yesAction:function(){if(!saveNote()) {return false;}},
				cancelAction:function(){return false;}
				});
			}
	});
	
	
	$('#viewcitation').click(function() {
			if((checkIfNoteSaved()==false))
			{
				warning({
				title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){return false;},
				yesAction:function(){if(!saveNote()) {return false;}},
				cancelAction:function(){return false;}
				});
			}
	});
	
	/*
	$('#addcit').click(function() {
			if((checkIfNoteSaved()==false)&&(saveflag==false))
			{
				warning({
				title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){return false;},
				yesAction:function(){saveNote();},
				cancelAction:function(){return false;}
				});
			}

	});
	*/
	
		startCitation();
}

function GetNoteAndGroups(assignid) {
	assignmentid = assignment_id = assignid; // NP ?
	noteStore = null;
	groupStore = null;
	$.getJSON (
		"getstuffneeded.php?profileid="+profileid+"&assignmentid="+assignid,
		function(data) {
			noteStore = data.notecarddata;
			groupStore = data.groupdata;
			curNote = null;
			setCitationStyle();
			BuildNoteandGroups();
			document.getElementById('note_title').value = '';
			document.getElementById('note_quotes').value = '';
			document.getElementById('note_text').value = '';
			document.getElementById('addcitation').innerHTML="<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>";	

		}
	)
}

var remoteNoteList = Array();
	remoteNoteList[1] = {id:1,title:"What makes the sun shine",tags:"1tag,tag2,tag3",quote:"",text:"",citation:{id:"1"},groupId:2};
	remoteNoteList[2] = {id:2,title:"Test Note 2",tags:"2tag,tag2,tag3",quote:"this is a quote 2",text:"this is a note 2",citation:{id:"1"},groupId:1};
	remoteNoteList[3] = {id:3,title:"Test Note 3",tags:"3tag,tag2,tag3",quote:"this is a quote 3",text:"this is a note 3",citation:{id:"1"},groupId:1};
	remoteNoteList[4] = {id:4,title:"Test Note 4",tags:"4tag,tag2,tag3",quote:"thissss is a quote 4",text:"this is a note 4",citation:{id:"1"},groupId:5};
	remoteNoteList[5] = {id:5,title:"Test Note 5",tags:"5tag,tag2,tag3",quote:"this is a quote 5",text:"this is a note 5",citation:{id:"1"},groupId:5};


(function($){  
	$.fn.Cover = function(options) {  
	// msg - string - message to display on cover
	//coverClass - string - class be used for the "cover" object
	//fadeTime - integer - time in milliseconds for fadeout
	
	
	
	var defaults = {  
			coverClass:"noteCover",
			fadeTime:2000,
			isFade:false,
			unCover:false

	};  
	
	var options = $.extend(defaults, options);  
	
	
	return this.each(function() {  
		if(options.unCover){
			//uncover
			
			if(options.isFade){
				$(this).find('.' + options.coverClass).fadeOut(options.fadeTime,function(){$('.' + options.coverClass).remove()});;
			}else{
				$('.' + options.coverClass).remove();
			}
		}else{
			//cover
			var coverH = $(this).height();
			var coverW = $(this).width();
			
			$(this).prepend('<div class="' + options.coverClass + '"><p>' + options.msg + '</p></div>');
			
			var coverObj = $(this).find('.' + options.coverClass);
			coverObj.height(coverH);
			coverObj.width(coverW);
			if(options.isFade){
				coverObj.fadeOut(options.fadeTime,function(){$('.' + options.coverClass).remove()});	  
			}
		}
	});
	
	};  
})(jQuery); 

(function($){  
	$.fn.setupNote = function(options) {  

		var defaults = {  
			actionBarId:"actionBar",
			headerId:"header",
			subnavId:"subnav",
			sideBarId: "sideBar",
			centerSecId: "center",
			projBarId:"projBar",
			projPanId:"projPan",
			projPanButtonId:"projPanButton",
			slideOutButtonId:"slideOutButton",
			slideOutPanelId:"slideOutPanel",
			wzonePanDuration:300,
			sidePanelSlideDur:300,
			sidePanelWidth:229,
			imgPath:"images/",
			useActionBar:true
		};  
		
		
		var options = $.extend(defaults, options);  
		
		//preset jquery objects
		
		var actionBar = $('#' + options.actionBarId);
		var projBar = $('#' + options.projBarId);
	    var sideBar = $('#' + options.sideBarId);
		var workzonePan = $('#' + options.projPanId);
		var workzonePanButton = $('#' + options.projPanButtonId);
		var workareaTop = $('#workareaTop');

		if(actionBar.length==0) options.useActionBar=false;//only use if actionBar exists
		
		//find heights
		var headerHeight = $('#' + options.headerId).height();
		var subnavHeight = $('#' + options.subnavId).height();
		
		
		if(options.useActionBar){
			var actionBarHeight = actionBar.height();
		}else{
			var actionBarHeight=0;
		}
		var workAreaWidth = workareaTop.width();
		var noteCardWidth = this.width();
		var openPanHeight=0;
	   //METHOD position note based on scroll location
		function iePositionNote(noteCard){
			clearTimeout(alertTimeout);		
			alertTimeout = setTimeout(function(){positionNote(noteCard);},100);
			
		}
		function positionNote(noteCard){
			
		   var basePos = headerHeight + projBar.height() + workareaTop.height() + subnavHeight;
			if(options.useActionBar){
				var notePos	= basePos + actionBarHeight;
			}else{
				var notePos	= basePos;
			}
			var scrollY = $(window).scrollTop();
			//handle note card
			if(scrollY > notePos){
				if($.browser.msie && $.browser.version() < 7){
					dockNote(scrollY + actionBarHeight,noteCard);
						
				}else{
						undockNote(noteCard);
					}
			}else{
				if (typeof(isxspacepage) != 'undefined' || $.browser.msie != true ) {
					if ($.browser.msie) 
						if($.browser.version() < 7) {
							basePos += 20;
						} else {
							basePos -= 25;
						}
					dockNote(basePos + 36,noteCard);
				} else {
					if (typeof(isxspacepage) != 'undefined' && $.browser.version() == 7) {
						dockNote(basePos + 20,noteCard);
					} else
						dockNote(basePos + 20,noteCard);	
				}
			}
			
			//handle actionBar
			if(options.useActionBar){
				
				if(scrollY > basePos){
					if($.browser.msie && $.browser.version() < 7){
						undockActionBar(scrollY - basePos);
							
					}else{
							undockActionBar(scrollY - basePos);
						}
				}else{
					dockActionBar(0);
				}
			}
				
		}
	
		//METHOD get the left starting position of the notecard
		function getNoteLeftPos(noteCard){
			return workareaTop.position().left + workAreaWidth - noteCardWidth - 47;
		}
		
		//METHOD dock the note at its stationary place at top of page
		function dockNote(posTop,noteCard){
			 var basePos = headerHeight + projBar.height() + workareaTop.height() + subnavHeight;
			 var posLeft = getNoteLeftPos(noteCard);
			 if($.browser.msie || $.browser.mozilla){
				//posLeft +=9; 
			 }
			if(typeof(isxspacepage) !="undefined") {
				if(($.browser.msie == true && $.browser.version() > 6) || $.browser.msie == false){
					if ($.browser.safari) {
						var safPos = ((basePos - scrollY) + 36)				
						noteCard.css({position:"fixed",left:posLeft+"px",top:safPos +"px"});
					} else {
						var safPos = ((basePos + 36))				
						noteCard.css({position:"absolute",left:posLeft+"px",top:safPos +"px"});
					}
				} else {
					noteCard.css({position:"absolute",left:posLeft+"px",top:posTop +"px"});
				}

			} else {
				if($.browser.safari){
					var safPos = ((parseInt(basePos) - parseInt(scrollY)) + 36);
					noteCard.css({position:"fixed",left:posLeft+"px",top:safPos +"px"});
				} else {
					noteCard.css({position:"absolute",left:posLeft+"px",top:posTop +"px"});
				}
			}
			
		 }
		 
		//METHOD attach note to top of scrolling page
		function undockNote(noteCard){
			var posLeft = getNoteLeftPos(noteCard);
			 noteCard.css({position:"fixed",left:posLeft+"px",top:actionBarHeight + "px"});
		 }
		 
		 //METHOD dock the action bar at its stationary place at top of page
		function dockActionBar(posTop){
			$('#' + options.actionBarId).css({position:""});
			if($.browser.safari){
				//css position will only update if something is physically updated for safari
				$('#safariErrFix').html("");
			}
			
		 }
		 
		 //METHOD attach action bar to top of scrolling page
		 function undockActionBar(posTop){
			
			 
			 if($.browser.msie && $.browser.version() < 7){
				$('#' + options.actionBarId).css({position:"absolute",top:posTop + "px"});
			}else{
				$('#' + options.actionBarId).css({position:"fixed",top:"0px"});	
			}
		 }
		
		//METHOD toggle the extended note card panel between visible and hidden
		function toggleExtended(el){
				var togglePanel = $('#extendedNotePanel').find('ul')
				if(togglePanel.is(':visible')){
					el.html('<span >&#9658;</span> <span class="linkdec">More Options</span>');
				}else{
					el.html('<span >&#9660;</span> <span class="linkdec">Fewer Options</span>');	
				}
				togglePanel.toggle();
			
		}
		
		//do setup for note
	   return this.each(function() {  
			
			var noteCard = $(this);
			
			//initialize note card
			objNoteCard= new NoteCard(noteCard,remoteNoteList[1],projId = 12);
			
			//init toggle extended panel visibility
			$('#extendedNotePanel').find('#optionsCollapse').click(function(){toggleExtended($(this));return false;});
			
			//add close
			noteCard.find('.noteTop').find('a').click(function(){noteCard.hide();$('#takeanote').removeClass('abuttonPressed');noteCardOpen = false;return false;})
			
			//add fewer more options
			
			//set position at start
			positionNote(noteCard);
			
			//set position after scroll
			if($.browser.msie && $.browser.version() < 7){
				$(window).scroll(function(){iePositionNote(noteCard);});
			} else {
				$(window).scroll(function(){positionNote(noteCard);});
			}
			
			
			//set position after resize
			$(window).resize(function(){positionNote(noteCard);});
			
			//animate position change after expand/collapse of workzone
			workzonePanButton.click(function(){
											   
			var pos = document.getElementById('noteCard').style.top.replace('px','');
			   
			   var panHeight = workzonePan.height();;
			   if(panHeight==0 || (($.browser.msie && $.browser.version() < 7) && panHeight==95)){
					var posTop = parseInt(pos) + parseInt(openPanHeight) + 2;

			   }else{
					openPanHeight = panHeight;	
					var posTop = pos - openPanHeight - 2;
			   }
			   noteCard.animate({ top:posTop +"px" }, { duration:options.wzonePanDuration, complete: function(){} } );
			   actionBar.animate({ top:posTop-actionBarHeight +"px" }, { duration:options.wzonePanDuration, complete: function(){} } );
											   
			});
			
			//allow for expand and collapse of expandable side panel
			var slideOutButton = $('#' + options.slideOutButtonId).find('a');
			var slideOutPanel = $('#' + options.slideOutPanelId);
			slideOutButton.click(function(){
				
				
				if(myNotesVisible){
					myNotesVisible = false;
					NotesIsVisible = false;
					$('#slideArrow').css({backgroundImage:"url(/images/common/note_sidetab_head.png)"});
					document.getElementById('slideTitle').title = expandTitleTextClosed;
					objNoteCard.isExpanded(false);
					slideOutPanel.animate({ width: "0px" }, { duration:options.sidePanelSlideDur}, function() {
																										   					document.getElementById('existSourceList').style.overflow = 'hidden';
					document.getElementById('citeSourceList').style.overflow = 'hidden';
					document.getElementById('newSourceList').style.overflow = 'hidden';
					document.getElementById('viewSourceList').style.overflow = 'hidden';
					document.getElementById('noteListContainer').style.overflow = 'hidden';});
				}else{		
					myNotesVisible = true;
					NotesIsVisible = true;
					//get and draw all notes for list
					
					objNoteCard.DrawNoteList();
					objNoteCard.isExpanded(true);
					$('#slideArrow').css({backgroundImage:"url(/images/common/note_sidetab_head_close.png)"});
					document.getElementById('slideTitle').title = expandTitleTextOpen;
					slideOutPanel.animate({ width: options.sidePanelWidth + "px"}, { duration:options.sidePanelSlideDur } );
					/*setTimeout("document.getElementById('existSourceList').style.overflow = 'auto'",options.sidePanelSlideDur);
					setTimeout("document.getElementById('citeSourceList').style.overflow = 'auto'",options.sidePanelSlideDur);
					setTimeout("document.getElementById('newSourceList').style.overflow = 'auto'",options.sidePanelSlideDur);
					setTimeout("document.getElementById('viewSourceList').style.overflow = 'auto'",options.sidePanelSlideDur);
					setTimeout("document.getElementById('noteListContainer').style.overflow = 'auto'",options.sidePanelSlideDur);*/
				}
				return false;
			});
			
			//add new note functionality
			//$('#add_note').click(function(){objNoteCard.New()});
			
			//add delete note func
			//$('#delete_note').click(function(){objNoteCard.Delete()});
			
			
	   });  //end each
	};  
})(jQuery); 



// noteCard and related classes
function NoteCard(uiNote,curNote,projId){
	//data states
	var noteListChanged = true;
	var groupsChanged = true;
	
	//ui states
	var noteListOpen = false;
	var extendedOpen = true;
	
	//ui ID values
	var uiNoteTitleId="note_title";
	var uiTextId = "note_text";
	var uiQuoteId = "note_quotes";
	var uiGroupId = "note_category";
	var uiTagsId = "note_tags";
	var uiCitLink = "citLink";
	var uiNoteListId = "noteList";
	var uiGrpPrefix = "grp";
	var uiNotePrefix = "note";
	
	//data variables
	var groups = Array();
	var projNotes = Array();
	
	//constants
	var quoteCharLimit = 2000;
	var noteCharLimit = 2000;
	
	/********* Start: Method InitNote *************/
	this.InitNote = function(note){
		if((typeof note) == "string" || (typeof note) == "number"){
			//is note's id	
			note = parseInt(note);
			this.curNote = remoteNoteList[note];
			//get note data from database
			
		}else if((typeof note) == "object"){
			//is note object
			this.curNote = note;
			
		}
		
		//this.SetGroups(projId);
		//this.SetNoteList(projId);
		this.Draw();
	}
	/********* End: Method InitNote *************/
	
	
	/********* Start: Method isExpanded *************/
	this.isExpanded = function(isExp){
			if((typeof isExp) == "boolean"){
					noteListOpen = isExp;
			}
			
			return noteListOpen;
	}
	/********* Start: Method isExpanded *************/
	
	
	
	/********* Start: Method ChangeNote *************/
	this.ChangeNote = function(note){
		//change note within same project
		
		if((typeof note) == "string" || (typeof note) == "number"){
			//is note's id	
			note = parseInt(note);
			this.curNote = remoteNoteList[note];
			//get note data from database
			
		}else if((typeof note) == "object"){
			//is note object
			this.curNote = note;
			
		}
		this.Draw();
		
	}
	/********* End: Method ChangeNote *************/
	
	
	
	/********* Start: Method New *************/
	this.New = function(){
		
		this.curNote = {};
		this.Draw(true);
		
	}
	/********* End: Method New *************/
	
	
	
	/********* Start: Method Delete *************/
	this.Delete = function(){
		var notObj = this;
		
		
		if(this.curNote.id){
			
		}else{
			//not saved to db
			
			//NEED CONFIRMATION HERE
			
			notObj.New();
		}
		
		
		
	}
	/********* End: Method Delete *************/
	
	
	
	/********* Start: Private Method DeleteNoteFromList *************/
	function DeleteNoteFromList(id){
		//this.projNotes[];
		var noteIndex = FindProjNote(id);
		
		if(typeof noteIndex != "boolean"){
			projNotes.splice(noteIndex, 1);
			noteListChanged=true;
		}
		
		
	}
	/********* End: Private Method DeleteNoteFromList *************/
	
	
	/********* Start: Private Method FindProjNote *************/
	function FindProjNote(id){
		//add notes
			for(key in projNotes){
				if(projNotes[key].id==id){
					return key;
				}
			}
			
		return false;
	}
	/********* End: Private Method FindProjNote *************/
	
	
	/********* Start: Private Method SelectGroup *************/
	function SelectGroup(groupId){
		groupId = groupId + '';//convert to string if num
		
		var dropdown = $('#' + uiGroupId);
		
		dropdown.selectOptions(groupId,true);
	}
	/********* End: Private Method SelectGroup *************/
	
	
	
	/********* Start: Method Draw *************/
	this.Draw = function(drawNoteList){
		//DrawField(uiNoteTitleId,this.curNote.title);
		DrawField(uiTextId,this.curNote.text,noteCharLimit);
		DrawField(uiQuoteId,this.curNote.quote,quoteCharLimit);
		//DrawField(uiTagsId,this.curNote.tags);
		//DrawCitLink(this.curNote.citation);
		
		//if(groupsChanged){
		//	DrawGroups(this.curNote.groupId);
		//}else{
		//	SelectGroup(this.curNote.groupId);
		//}
		
		//if(drawNoteList){
		//	this.DrawNoteList();
		//}


		
		//if(noteListOpen){
		//	SelectNote(this.curNote.id);
		//}
	}
	/********* Start: Method Draw *************/
	
	
	
	/********* Start: Private Method DrawField *************/
	function DrawField(id,value,limit){
		
		//blank any null/undefined values
		if(!value) value="";
		
		var field = $('#' + id);
		if(field.is('textarea')){
			
			field.val(value);
			
			//clear previous counters
			field.siblings('.noteCharCounter').remove();
			
			//set up new character count
			field.charCounter(limit, {
					container: "<p></p>",//"#'.$fieldName.'_count",
					format: "Character Limit: %1/2000",
					classname:"noteCharCounter",
					pulse: false
				});
			
		}else{
			
			field.val(value); 	
		}
	}
	/********* End: Private Method DrawField *************/
	
	
	
	/********* Start: Private Method DrawGroups *************/
	function DrawGroups(groupId){
		var dropdown = $('#' + uiGroupId);
		dropdown.empty();
		dropdown.addOption("","Select Group...");
		var dropdownOpt="";
		for(key in groups){
			
			dropdown.addOption(groups[key].id, groups[key].title,(groups[key].id==groupId));
			
		}
		groupsChanged=false;
	}
	/********* End: Private Method DrawGroups *************/
	
	
	
	/********* Start: Private Method SelectGroup *************/
	function SelectGroup(groupId){
		groupId = groupId + '';//convert to string if num
		
		var dropdown = $('#' + uiGroupId);
		
		dropdown.selectOptions(groupId,true);
	}
	/********* End: Private Method SelectGroup *************/
	
	
	
	/********* Start: Private Method SelectNote *************/
	function SelectNote(noteId){
		
		$('#' + uiNoteListId).find('li').removeClass('current');
		$('#' + uiNotePrefix + noteId).addClass('current');
		
	}
	/********* End: Private Method SelectNote *************/
	
	
	
	/********* Start: Private Method DrawCitLink *************/
	function DrawCitLink(citation){
		var citLink = $('#' + uiCitLink);
		
		if(citation){
			citLink.html('This note already has a source assigned. &nbsp;<a href="javascript:void;">View Citation</a>');
		}else{
			citLink.html('This note does not yet have a source associated with it yet. &nbsp;<a href="javascript:void;">Add a Citation</a>');
		}
	}
	/********* End: Private Method DrawCitLink *************/
	
	
	
	/********* Start: Method DrawNoteList *************/
	this.DrawNoteList = function(){
		
		//only draw again if note values have changed
		if(noteListChanged){
			var noteList = $('#' + uiNoteListId);
			noteList.html("");
			
			//add groups
			for(key in groups){
				
				DrawNoteListGrp(groups[key],noteList);
				
			}
			
			//add notes
			for(key in projNotes){
				DrawListNote(projNotes[key],noteList)
			
			}
			
			SelectNote(this.curNote.id);
			
			
		}
		
		noteListChanged=false;
	}
	/********* End: Method DrawNoteList *************/
	
	
	
	/********* Start: Private Method DrawNoteListGrp *************/
	function DrawNoteListGrp(grp,noteList){
		
		noteList.find('#' + uiGrpPrefix + grp.id).remove();
		noteList.append('<li id="' + uiGrpPrefix + grp.id + '">' + grp.title + '</li>')
		
	}
	/********* End: Private Method DrawNoteListGrp *************/
	
	
	/********* End: Private Method DrawListNote *************/
	function DrawListNote(note,noteList){
		var uiGrp = noteList.find('#' + uiGrpPrefix + note.groupId);
		var uiNoteId = uiNotePrefix + note.id;
		
		if(uiGrp.find('ul').length==0){
			uiGrp.append('<ul></ul>');	
		}
		
		uiGrp.find('ul').append('<li id="' + uiNoteId + '"><a href="#">' + note.title + '</a></li>');
		
		$('#' + uiNoteId).find('a').click(function(){
												objNoteCard.ChangeNote(note.id);
												return false;
											});
		
	}
	/********* End: Private Method DrawListNote *************/
	
	
	/********* Start: Method DrawGroups *************/
	this.SetGroups = function(projId){
		
		//need to order alphabetically
		groups[0] = {id:"1",title:"Astronauts in Space"};
		groups[1] = {id:"2",title:"Bright Sun"};
		groups[2] = {id:"3",title:"Comets and other space objects"};
		groups[3] = {id:"4",title:"Planet Descriptions"};
		
		groups.sort(CompareGrp);
		noteListChanged=true;
	}
	/********* End: Method DrawGroups *************/
	
	
	
	/********* Start: Method SetNoteList *************/
	this.SetNoteList = function(projId){
			projNotes[0] = new Note({id:remoteNoteList[1].id,title:remoteNoteList[1].title,groupId:remoteNoteList[1].groupId});
			projNotes[1] = new Note({id:remoteNoteList[2].id,title:remoteNoteList[2].title,groupId:remoteNoteList[2].groupId});
			projNotes[2] = new Note({id:remoteNoteList[3].id,title:remoteNoteList[3].title,groupId:remoteNoteList[3].groupId});
			projNotes[3] = new Note({id:remoteNoteList[4].id,title:remoteNoteList[4].title,groupId:remoteNoteList[4].groupId});
			projNotes[4] = new Note({id:remoteNoteList[5].id,title:remoteNoteList[5].title,groupId:remoteNoteList[5].groupId});
			noteListChanged=true;
	}
	/********* End: Method SetNoteList *************/
	
	
	
	/********* End: Private Method SortGrp *************/
	function CompareGrp(a,b){
			if(a.title > b.title)
			  return 1
		   if(a.title < b.title)
			  return -1
		   return 0 
	}
	/********* End: Private Method SortGrp *************/
	
	
	
	
	
	
	
	/********* Start: Method SetTitle *************/
	this.SetTitle = function(title){
		
	}
	/********* End: Method SetTitle *************/
	
	
	 
	/********* Start: Method SetText *************/
	this.SetText = function(text){
		
	}
	/********* End: Method SetText *************/
	
	
	
	/********* Start: Method SetQuote *************/
	this.SetQuote = function(quote){
		
	}
	/********* End: Method SetQuote *************/
	
	
	
	/********* Start: Method SetTags *************/
	this.SetTags = function(tagList){
		
	}
	/********* End: Method SetTags *************/
	
	
	
	/********* Start: Method SetNoteGroup *************/
	this.SetNoteGroup = function(groupId){
		
	}
	/********* End: Method SetNoteGroup *************/
	
	
	
	/********* Start: Method SetNoteCitation *************/
	this.SetNoteCitation = function(citId){
		
	}
	/********* End: Method SetNoteCitation *************/
	
	//constructor
	if(curNote){
		this.InitNote(curNote)	
	}
}


//Note Class
function Note(noteData){
	/*
		id:string				-database note id
		title:string			-note title
		tags:string				-string of tags, separated by commas
		quote:string			-a quoted piece of text
		text:string				-the actual note's text
		citation:Citation obj	-this note's related citation
		groupId:string			-this note's group id	
	*/
			
	//constructor
	if(noteData){
		this.id = noteData.id;
		this.title = noteData.title;
		this.groupId = noteData.groupId;
		this.tags = noteData.tags;
		this.quote = noteData.quote;
		this.text = noteData.text;
		this.citation = noteData.citation;
	}
	
}

//Citation Class
function Citation(citationData){
	/*
		id:string			-database citation id
		text:string			-citation text
		style:string		-citation's style
	*/
	
	if(citationData){
		this.id = citationData.id;
		this.text = citationData.text;
		this.style = citationData.style;
	}
	
}

var curNote=null;
function showNote(id)
{
	clearhighlite(id);
	if(document.getElementById('errorgroup')) {
		toggleshowandhide('extendedNotePanel',2);
	}
	var flag=checkIfNoteSaved();
	
	if ((saveflag==false)&&(flag==false)) 
	{																																																															
		warning({title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){
					finishShowNote(id);
					saveflag=true;
					$('#save_note').attr('disabled','disabled');
				},
				yesAction:function(){
					if(saveNote() != false) { 
						finishShowNote(id);
						saveflag=true;
						$('#save_note').attr('disabled','disabled');
					} else return false;
				},
				cancelAction:function(){
					return false;
				}
			});	
	} else {
		finishShowNote(id);	
	}
}
function finishShowNote(id){
	resetform();
	document.noteform.note_title.value = noteStore[id]._title;
	document.noteform.note_quotes.value = noteStore[id]._directquote;
	document.noteform.note_text.value = noteStore[id]._paraphrase;
	document.getElementById('note_quotes').focus();
	document.getElementById('note_text').focus();
	document.getElementById('note_text').blur();
	var citationid = noteStore[id]._citationid;
	// display dynamic citation
	if(citationid=='0')
	{
		document.getElementById('addcitation').innerHTML="<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>";	
	} else {
	document.getElementById('addcitation').innerHTML="<span class='label' for='Add citation'><a href='#' class='addCit' title='View Citation' onclick=\"checksavednote('viewCitation'); return false;\" id='viewcitation'>View Citation</a>Citation: </span><p class='citation'>This note has a source assigned.</p>";	
	}
	if ((noteStore[id]._groupid == '0') || (noteStore[id]._groupid == 'NULL')){
		document.getElementById('select0').selected = true;
	} else {
		document.getElementById('select'+noteStore[id]._groupid).selected = true;
	}
	if ((curNote != null) || (curNote == '0')){
		document.getElementById('notes'+curNote).setAttribute('class','note');
	}
	document.getElementById('notes'+id).setAttribute('class','note current');
	curNote = id;
}

function deleteNote()
{
		if((curNote != null) || (curNote == 0))
		{
		lockerReturn('deletenotecard',noteStore[curNote]._notecardid.replace("\"",""));
		curNote = null;
		document.getElementById('note_quotes').focus();
		document.getElementById('note_text').focus();
		$('#warning').html('');
		GetNoteAndGroups();
		} 		
		/*
		$('#note_title').value = '';
		$('#note_quotes').value = '';
		$('#note_text').value = '';
		$('#selectnull').selected = true;
		*/
}

var newNote;
function saveNote()
{
	
if(document.noteform.note_title.value.replace(/ /g,'')=='')
{
	document.noteform.note_title.focus();
	document.getElementById('warning').innerHTML='A note card title is required.';
	return false;
} else {
	document.getElementById('warning').innerHTML='';
	if(curNote == null)
	{
		
		lockerReturn2('insertnotecard',profile_id,assignment_id,document.noteform.note_title.value,document.noteform.note_quotes.value,document.noteform.note_text.value,document.noteform.note_quotes.value.length,document.noteform.note_text.value.length,null,document.noteform.note_category.options[document.noteform.note_category.selectedIndex].value	);
		saveflag=true;
		$('#save_note').attr('disabled','disabled');
		//newNote = noteStore.length;
		newNote = noteStore.length;
		curNote = newNote;
		//newLine = '<li class="note current" id="notes'+newNote+'"><div><span>Note: </span><a href="javascript:{showNote('+newNote+')}" title="'+document.noteform.note_title.value+'" id="link'+newNote+'">'+document.noteform.note_title.value+'</a></div></li>';
		//document.getElementById('group'+document.getElementById('note_category').value).innerHTML = document.getElementById('group'+document.noteform.note_category[document.noteform.note_category.selectedIndex].value).innerHTML+newLine;
		
		noteStore[newNote] = new Object();
		noteStore[newNote]._profileid=profile_id;
		noteStore[newNote]._assignmentid=assignment_id;
		noteStore[newNote]._notecardid=nextid;
		noteStore[newNote]._title=document.noteform.note_title.value;
		noteStore[newNote]._directquote=document.noteform.note_quotes.value;
		noteStore[newNote]._paraphrase=document.noteform.note_text.value;
		noteStore[newNote]._groupid=document.noteform.note_category.options[document.noteform.note_category.selectedIndex].value;
		var tmpgroup = document.noteform.note_category.selectedIndex;
		currentnoteid=nextid;
		BuildNoteandGroups();
		setAssignmentList(); // rebuild the assignmentlist again from workzone.
		gettasklist(); // rebuild the tasklist again from workzone.
		document.getElementById('note_category').selectedIndex = tmpgroup;
	} else {
		var notecardid = noteStore[curNote]._notecardid;
		noteStore[curNote]._title=document.noteform.note_title.value;
		noteStore[curNote]._directquote=document.noteform.note_quotes.value;
		noteStore[curNote]._paraphrase=document.noteform.note_text.value;
		noteStore[curNote]._groupid=document.noteform.note_category.options[document.noteform.note_category.selectedIndex].value;
		currentnoteid=notecardid;
		var tmpgroup = document.noteform.note_category.selectedIndex;
		//var id='notes'+curNote;
	$(document).ready(function() {
   		$("#link" + curNote).text(document.noteform.note_title.value);
 	});
		
		
		lockerReturn('updatenotecard',noteStore[curNote]._notecardid,document.noteform.note_title.value,document.noteform.note_quotes.value,document.noteform.note_text.value,document.noteform.note_quotes.value.length,document.noteform.note_text.value.length,document.noteform.note_category.options[document.noteform.note_category.selectedIndex].value);
		saveflag=true;
		$('#save_note').attr('disabled','disabled');
		BuildNoteandGroups();
		document.getElementById('note_category').selectedIndex = tmpgroup;
	}
}
}

function Group(grpData){
	/*
		id:string			-group's id
		title:string		-group title
	*/
	
	if(grpData){
		this.id = grpData.id;
		this.title = grpData.title;
	}
}


function lockerReturn2(method,var1,var2,var3,var4,var5,var6,var7,var8,var9)
{ 
	
	var url="locker_interaction.php";
	if (typeof method != "undefined"){ url=url+"?method="+method }
	if (typeof var1 != "undefined"){ url=url+"&var1="+encodeURIComponent(var1) }
	if (typeof var2 != "undefined"){ url=url+"&var2="+encodeURIComponent(var2) }
	if (typeof var3 != "undefined"){ url=url+"&var3="+encodeURIComponent(var3) }
	if (typeof var4 != "undefined"){ url=url+"&var4="+encodeURIComponent(var4) }
	if (typeof var5 != "undefined"){ url=url+"&var5="+encodeURIComponent(var5) }
	if (typeof var6 != "undefined"){ url=url+"&var6="+encodeURIComponent(var6) }
	if (typeof var7 != "undefined"){ url=url+"&var7="+encodeURIComponent(var7) }
	if (typeof var8 != "undefined"){ url=url+"&var8="+encodeURIComponent(var8) }
	if (typeof var9 != "undefined"){ url=url+"&var9="+encodeURIComponent(var9) }
	nextid=$.ajax( {
			    type: "GET",
				url: url,
				cache: false,
				async: false
				}).responseText;
	
}

function lockerReturn(method,var1,var2,var3,var4,var5,var6,var7,var8,var9){ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="locker_interaction.php"
	if (typeof method != "undefined"){ url=url+"?method="+method }
	if (typeof var1 != "undefined"){ url=url+"&var1="+encodeURIComponent(var1) }
	if (typeof var2 != "undefined"){ url=url+"&var2="+encodeURIComponent(var2) }
	if (typeof var3 != "undefined"){ url=url+"&var3="+encodeURIComponent(var3) }
	if (typeof var4 != "undefined"){ url=url+"&var4="+encodeURIComponent(var4) }
	if (typeof var5 != "undefined"){ url=url+"&var5="+encodeURIComponent(var5) }
	if (typeof var6 != "undefined"){ url=url+"&var6="+encodeURIComponent(var6) }
	if (typeof var7 != "undefined"){ url=url+"&var7="+encodeURIComponent(var7) }
	if (typeof var8 != "undefined"){ url=url+"&var8="+encodeURIComponent(var8) }
	if (typeof var9 != "undefined"){ url=url+"&var9="+encodeURIComponent(var9) }
	if (method == 'insertnotecard'){
		xmlHttp.onreadystatechange=stateChanged
	} else {
		xmlHttp.onreadystatechange=stateChanged2
	}
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}


function stateChanged(){ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		nextid=xmlHttp.responseText;
	} 
}

function stateChanged2(){ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		modifyid = xmlHttp.responseText;
	} 
}


function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		//Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function noteChange(link){
	return false;
	//Change all Note Card Contents to None
	document.getElementById('noteCardContentCont').style.display = 'none';
	document.getElementById('citeSourceCont').style.display = 'none';
	document.getElementById('existSourceCont').style.display = 'none';
	document.getElementById('newSourceCont').style.display = 'none';
	document.getElementById('viewCitationCont').style.display = 'none';
	
	//Change all Note Card Slideouts to None
	document.getElementById('notesSlideCont').style.display = 'none';
	document.getElementById('citeSourceSlideCont').style.display = 'none';
	document.getElementById('existSourceSlideCont').style.display = 'none';
	document.getElementById('newSourceSlideCont').style.display = 'none';
	document.getElementById('viewSourceSlideCont').style.display = 'none';
	
	//Change all Button sections to empty
	document.getElementById('noteButtonsCont').style.display = 'none';
	document.getElementById('citationButtonsCont').style.display = 'none';
	document.getElementById('viewCitationButtonsCont').style.display = 'none';
	
	//Change all Header sections to empty
	document.getElementById('noteCardHeaderCont').style.display = 'none';
	document.getElementById('citationToolHeaderCont').style.display = 'none';
	document.getElementById('viewCitationHeaderCont').style.display = 'none';
	
	if (link == 'noteCard'){
		expandTitleTextClosed = "Click to view all your note cards";
		expandTitleTextOpen = "Click to close all your note cards";
	} else {
		expandTitleTextClosed = "Click to view all your citations";
		expandTitleTextOpen = "Click to close all your citations";
	}
	if(myNotesVisible){
		document.getElementById('slideTitle').setAttribute('title',expandTitleTextOpen);
	} else {
		document.getElementById('slideTitle').setAttribute('title',expandTitleTextClosed);
	}
	
	if (link == 'viewCitation'){
		document.getElementById('viewSourceSlideCont').style.display = 'block';
		document.getElementById('viewCitationCont').style.display = 'block';
		document.getElementById('viewCitationButtonsCont').style.display = 'block';
		document.getElementById('viewCitationHeaderCont').style.display = 'block';
		showExistingCitation(noteStore[curNote]._citationid);
	} else if (link == 'citeSource'){
		if(citesource != false) {
			document.getElementById('citeSourceOption').selected = true;
			document.getElementById('citeSourceSlideCont').style.display = 'block';
			document.getElementById('citeSourceCont').style.display = 'block';
			document.getElementById('citationButtonsCont').style.display = 'block';
			document.getElementById('citationToolHeaderCont').style.display = 'block';
		} else {
			if(existsource != false) {
				noteChange('existSource');
				return false;
			} else {
				noteChange('newSource');
				return false;
			}
		}
	} else if (link == 'existSource'){
		if(existsource != false) {
			document.getElementById('existSourceOption').selected = true;
			document.getElementById('existSourceSlideCont').style.display = 'block';
			document.getElementById('existSourceCont').style.display = 'block';
			document.getElementById('citationButtonsCont').style.display = 'block';
			document.getElementById('citationToolHeaderCont').style.display = 'block';
			if (NotesIsVisible == false){
				$('#slideOutButton').find('a').trigger('click');
			}
		} else {
			noteChange('newSource');
			return false;
		}
	} else if (link == 'newSource'){
		document.getElementById('newSourceOption').selected = true;
		document.getElementById('newSourceSlideCont').style.display = 'block';
		document.getElementById('newSourceCont').style.display = 'block';
		document.getElementById('citationButtonsCont').style.display = 'block';
		document.getElementById('citationToolHeaderCont').style.display = 'block';	
	} else if (link == 'noteCard'){
		document.getElementById('notesSlideCont').style.display = 'block';
		document.getElementById('noteCardContentCont').style.display = 'block';
		document.getElementById('noteButtonsCont').style.display = 'block';
		document.getElementById('noteCardHeaderCont').style.display = 'block';		
	}
	thisSource = link;
}

// show and hide div element.
function toggle(id)
{
	if(document.getElementById(''+id).style.display=='block')
	{
		document.getElementById(''+id).style.display='none';
	} else {
		document.getElementById(''+id).style.display='block';
	}
}


/*
This function pass div id and idflag.
The idflag has value of 1 or 2 which to keep track toggle back and fort with add new group and original drop down group.
When a user click on Add new, it show a new input text field and disable other 3 buttons: add, delete, save.
*/
function toggleshowandhide(id,idflag)
{	
	if(idflag==1)
	{
	tempstr2="<span id='note_category'><ul><li><label for='Add a new group'>Add a new group:</label>";
	tempstr2=tempstr2+"<input type='text' name='addnewcat' style='margin-left:-8px;' title='Add new group' maxlength='30' this.focus()/>";
	tempstr2=tempstr2+"<br><p id='errorgroup' class='warning' style='line-height:11px !important; display:inline;'>&nbsp;</p></li></ul>";
	tempstr2=tempstr2+"<div class='note_buttons' style='background-color:transparent !important; border:0px solid black;'>";
	
	tempstr2=tempstr2+"<input type='button' value='CANCEL' id='cancelcat' class='truebutton' title='Cancel' onClick=\"toggleshowandhide('extendedNotePanel',2);\"/>";
	tempstr2=tempstr2+"<input type='button' name='Save' id='savecat' class='truebutton' value='SAVE' title='Save' onClick=\"addnewGroup(document.noteform,profileid,assignmentid);\"></div></span>";
	tempstr1=document.getElementById(id).innerHTML;
	document.getElementById(id).innerHTML=tempstr2;
	document.noteform.addnewcat.focus();
	idflag=2;
	$('#save_note').attr('disabled','disabled');
	$('#delete_note').attr('disabled','disabled');
	$('#add_note').attr('disabled','disabled');
	} else {
		document.getElementById(id).innerHTML=tempstr1;
		$('#save_note').removeAttr('disabled');
		$('#delete_note').removeAttr('disabled');
		$('#add_note').removeAttr('disabled');
	}

}

/*
This function pass in form name, profileid, and assignmentid.
If notecard title is empty, it display inline message and set focus.
If notecard title is not empty, it calls checkduplicate() and languagechecker() function.
If both functions return false, it call lockerReturn() and does insertgroup. Then it calls
updateGroupList and toggleshowandhide() which return to original drop down list.
If languagechecker is true, it display the inline message error.
*/

function addnewGroup(f,pid,aid)
{
if(f.addnewcat.value.replace(/ /g,'')=='')
{
	$('#errorgroup').innerHTML='Group name required';
	f.addnewcat.focus();
} else {
	var text = f.addnewcat.value;
	var newtext = f.addnewcat.value;
	temptitle = text;
	var flag = checkduplicate(text);
	if(flag==false)
	{
		languageflag=languagechecker(text);
		if(languageflag == 0)
		{
			lockerReturn2('insertgroup',pid,aid,newtext);	
			f.addnewcat.value='';
			document.getElementById('errorgroup').innerHTML='';
			toggleshowandhide('extendedNotePanel',2);
			addoption(text);	
		} else {
			document.getElementById('errorgroup').innerHTML="The name you have entered cannot be <br>processed. Please enter another name.";	
		}
	}
}
}

/* 
This function pass in a string and return true or false.
check for duplicate entry in drop download list with
temparray. If the string does not duplicate, it updates
the temparray and return false. If the text is duplicated,
it return true.
*/
function checkduplicate(text)
{
	var i = 0;
	var len = groupStore.length;
	while (i < len)
	{
		var str = groupStore[i]._title;
		if(text.toLowerCase()==str.toLowerCase())
		{
			document.getElementById('errorgroup').innerHTML="This category name already exists.";
			return true;
		}
		i++;
	}
	return false;
}


/*
  Create a new option in drop down list and update the slide bar category.

*/
function addoption(text)
{
	// create new option in drop download list
	var len=document.getElementById('note_category').length;
	groupid = parseInt(nextid.replace(/"/g,''));
	var opt = document.createElement('option');
	opt.setAttribute('value',groupid);
	opt.setAttribute('id','select'+groupid);
	opt.innerHTML = text;
	document.getElementById('note_category').appendChild(opt);
	document.getElementById('note_category').selectedIndex=len;
	var str = $('ul.noteUL').html();
	var newline="<li class='category'><div><span>Category: </span>"+text+"</div><ul id='group"+groupid+"'></ul></li>";
	var newstr = newline + str;
	// update slidebar window
	$('ul.noteUL').html(newstr);
	len = groupStore.length;
	groupStore[len] = new Object();
	groupStore[len]._title = text;
	groupStore[len]._groupid = groupid;
		
}

/*
Ajax call language_check.php url and
pass in string=value
return value of 0 or 1.
1=not ok
0=ok
*/

function languagechecker(str)
{
	languageflag = $.ajax( {
				url: "/language_checker.php",
				data: "string="+encodeURIComponent(str),
				async: false
						  }).responseText;
	return languageflag;
}


function checkIfNoteSaved() {
	var count=0;
	if(document.noteform.note_title.value!='')
	{
		if (curNote != null) {
			if (document.noteform.note_title.value != noteStore[curNote]._title)
			count++;	
		} else {
			count++;	
		}
						
	}
	if(document.noteform.note_quotes.value!='')
	{
		if (curNote != null) {
			if (document.noteform.note_quotes.value != noteStore[curNote]._directquote)
			count++;	
		} else {
			count++;	
		}
	}
	if(document.noteform.note_text.value!='')
	{
		if (curNote != null) {
			if (document.noteform.note_text.value != noteStore[curNote]._paraphrase)
			count++;	
		} else {
			count++;	
		}
	}
	if(count > 0)
	{
		return false;
	} else {
		return true;
	}
}

/*
	reset notecard form to empty and set curNote to null
*/
function resetform()
{
			$('#note_title').val('');
			$('#note_text').val('');
			$('#note_quotes').val('');
			document.getElementById('note_quotes').focus();
			document.getElementById('note_text').focus();
			document.getElementById('note_title').focus();
			$('#warning').html('');
			document.noteform.note_category.options[0].selected=true;
			curNote=null;		
}

/*
	This function check if the input value and textarea empty or not
	in the notecard form.
	if notecard form is not empty, it call jquery pop up box.
	The pass in saveNote() and resetform() if user click yes.
	Else pass in resetform() if user click no.
	If user click on x, return false.
*/
function addnote(f)
{					
	// check to see if a user click save the note.
	if(saveflag==false && checkIfNoteSaved() == false)
	{
	warning({
		title:'Warning',
		msg:'Would you like to Save the current note?',
		noAction:function(){
			resetform();
			saveflag=true;
			$('#save_note').attr('disabled','disabled');
		},
		yesAction:function(){
			if(saveNote() != false) {
				resetform();
				saveflag=true;
				$('#save_note').attr('disabled','disabled');
			} else return false;
			},
		cancelAction:function(){return false;}
		});
	} else {
			resetform();	
	}
}

/*
 This function call jquery pop up windows.
 Pass in deleteNote if a user click Yes
 Else do nothing and resturn false.
*/
function confirmDeleteNote(){
	warning({
		title:'Warning',
		msg:'Are you sure you want to delete this note?',
		noAction:function(){ 
			return false;
		},
		yesAction:function(){
			deleteNote();
			resetform();
			saveflag=true;	
			$('#save_note').attr('disabled','disabled');
		},
		cancelAction:function(){ return false;}
		});
}

// fade out when note save
$(function()  
{
  $('#save_note').click(function(e)
  {
  if(saveflag==true)
  {
    //getting height and width of the message box
    var height = $('#popuup_div').height();
    var width = $('#popuup_div').width();
    //calculating offset for displaying popup message
    leftVal=e.pageX-(width)+"px";
    topVal=e.pageY -(height + 110) + "px"; 
    //show the popup message and hide with fading effect
    $('#popuup_div').css({left:leftVal,top:topVal}).show().fadeOut(1500);
  }
  }); 
});

function BuildNoteandGroups() {
	try{
		noteStore.length;
	}catch(e){
		setTimeout(BuildNoteandGroups,250);
		return false;
	}
	try{
		groupStore.length;
	}catch(e){
		setTimeout(BuildNoteandGroups,250);
		return false;
	}
	var theul = document.getElementById('noteUL');
	theul.innerHTML = '';
		var selectbox = document.getElementById('note_category');
		for (i=0; i<groupStore.length; i++){
		var li = document.createElement('li');
		if (i%2 == 0){
			li.setAttribute('class','category');
		} else {
			li.setAttribute('class','category alternate');
		}
		var div = document.createElement('div');
		div.innerHTML = '<span>Category: </span>'+forceWrap(groupStore[i]._title);
		var ul = document.createElement('ul');
		ul.setAttribute('id','group'+groupStore[i]._groupid);
		
		for (j=0; j<noteStore.length; j++){
			if (noteStore[j]._groupid == groupStore[i]._groupid) {
				var li2 = document.createElement('li');
				if(noteStore[j]._notecardid==currentnoteid)
				{
					li2.setAttribute('class','note current');
				} else {
					li2.setAttribute('class','note');	
				}
				li2.setAttribute('id','notes'+j);
				li2.innerHTML = '<div><span>Note: </span><a href="#" onclick="showNote(\''+j+'\'); return false;" title="'+noteStore[j]._title+'" id="link'+j+'">'+forceWrap(noteStore[j]._title)+'</a></div>';
				ul.appendChild(li2);
			}
		}
		li.appendChild(div);
		li.appendChild(ul);										
		theul.appendChild(li);
	}
	var hold = "";
	
	for (j=0; j<noteStore.length; j++){
		if (noteStore[j]._groupid == '0' || noteStore[j]._groupid == null){
			var str='';
			if(noteStore[j]._notecardid==currentnoteid)
			{
					str='<li class="note current" id="notes'+j+'">';
			} else {
					str='<li class="note" id="notes'+j+'">';
			}
			hold += str + '<div><span>Note: </span><a href="#" onclick="showNote('+j+'); return false;" title="'+noteStore[j]._title+'" id="link'+j+'">'+forceWrap(noteStore[j]._title)+'</a></div></li>';
		}
	}
	var li1 = document.createElement('li');
	if (i%2 == 0){
		li1.setAttribute('class','category');
	} else {
		li1.setAttribute('class','category alternate');
	}
	var tmp = '<div><span>Category: </span>Uncategorized</div><ul id="group0">';
	hold = tmp + hold + '</ul>';
	li1.innerHTML = hold;
	theul.appendChild(li1);
	$(theul).html($(theul).html());
	$('#note_category > option').each(function() {
		$(this).remove();
	});
	var option = document.createElement('option');
	option.setAttribute('id','select0');
	option.setAttribute('value',0);
	option.innerHTML = 'Select Group';
	selectbox.appendChild(option);
	for (i=0; i<groupStore.length; i++){
		if ($('#note_category #select'+groupStore[i]._groupid).length == 0) {
			var option = document.createElement('option');
			option.setAttribute('id','select'+groupStore[i]._groupid);
			option.setAttribute('value',groupStore[i]._groupid);
			option.innerHTML = groupStore[i]._title;
			selectbox.appendChild(option);
		}
	}

	// Note organizer:
	// Jeff: this was causing problems if the url ended with a #
	// It also introduces a URL dependency :)
	//if (isNoteOrginizer()) {
		if (typeof(organizer_store) != 'undefined' && typeof(organizer_store.pendingGroups) != 'undefined')
		{
			setOrganizerGroups(organizer_store.pendingGroups);
			delete organizer_store.pendingGroups;
		}
		if (typeof(organizer_store) != 'undefined' && typeof(organizer_store.pendingNotes) != 'undefined')
		{
			setOrganizerNotes(organizer_store.pendingNotes);
			delete organizer_store.pendingNotes;
		}
	//}
	// End note organizer.
}

function forceWrap(text){
	var tmp = '';
	for (var i = 0; i < text.length;i++){
		if ($.browser.msie || $.browser.mozilla){
			tmp += text.substring(i,i+1)+'<wbr />';
		} else {
			tmp += text.substring(i,i+1)+'&#8203;';
		}	
	}
	return tmp;
}


function clearhighlite(id)
{
	var i=0;
	while(i < noteStore.length)
	{
		$('#notes'+i).removeClass('note current');
		$('#notes'+i).addClass('note');
		i++;	
	}
	$('#notes'+id).addClass('note current');
}

function isNoteOrginizer() {
	var URL = window.location.href;
	URL = URL.replace('http://','');
	URL = URL.indexOf('/') != -1 ? URL.substr(URL.indexOf('/')+1) : URL;
	URL = URL.indexOf('?') != -1 ? URL.substring(0,URL.indexOf('?')) : URL;
	if(URL.toLowerCase() == 'note_organizer') {
		return true;
	}
	return false;
}