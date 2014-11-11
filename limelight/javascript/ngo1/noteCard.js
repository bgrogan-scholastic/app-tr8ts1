/** 
	@file: noteCard.js
	@description: This file is the main source of all the bibliography javascript calls

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	citation variables:
	
	newNote;
	noteCardOpen = false;
	expandTitleTextClosed = "Click to view all your note cards";
	expandTitleTextOpen = "Click to close all your note cards";
	alertTimeout = false;
	profile_id=profileid;
	assignment_id=currassgn;
	assignmentid=currassgn;
	tmpstr1 = '';
	citesource = true;
	existsource = true;
	NotesIsVisible = false;
	tmpWidth = 0;
	curNote=null;
	
**/	

var newNote;
var noteCardOpen = false;
var expandTitleTextClosed = "Click to view all your note cards";
var expandTitleTextOpen = "Click to close all your note cards";
var alertTimeout = false;
var profile_id=profileid;
var assignment_id=currassgn;
var assignmentid=currassgn;
var tmpstr1 = '';
var citesource = true;
var existsource = true;
var NotesIsVisible = false;
var tmpWidth = 0;
var curNote=null;

var curNoteTitle=null;
var curNoteText=null;
var curNoteQuote=null;

//do things on page load
$(window).bind('load',function() {
	//note card title input keyup
	$('#note_title').keyup(function(e) {
		$('#save_note').removeAttr('disabled');
		if (e.keyCode == 13) {
			$('#save_note').trigger('click');
			return false;
		}
	});
	//note card notes input keyup	
	$('#note_text').keyup(function() {
		$('#save_note').removeAttr('disabled');
	});
	//note card quotes input keyup	
	$('#note_quotes').keyup(function() {
		$('#save_note').removeAttr('disabled');
	});

	//note card title input keyup
	$('#note_title').keypress(function(e) {
		$('#save_note').removeAttr('disabled');
	});
	//note card notes input keyup	
	$('#note_text').keypress(function() {
		$('#save_note').removeAttr('disabled');
	});
	//note card quotes input keyup	
	$('#note_quotes').keypress(function() {
		$('#save_note').removeAttr('disabled');
	});	


	//note card title input keyup
	$('#note_title').change(function(e) {
		$('#save_note').removeAttr('disabled');
	});
	//note card notes input keyup	
	$('#note_text').change(function() {
		$('#save_note').removeAttr('disabled');
	});
	//note card quotes input keyup	
	$('#note_quotes').change(function() {
		$('#save_note').removeAttr('disabled');
	});
		
	//group dropdown click
	$('#note_category').bind('click',function() {
		$('#save_note').removeAttr('disabled');
	});
	//group dropdown mouseup
	$('#note_category').bind('mouseup',function() {
		$('#save_note').removeAttr('disabled');
	});
	//group dropdown change
	$('#note_category').bind('change',function() {
		$('#save_note').removeAttr('disabled');
	});
	//group dropdown mousedown
	$('#note_category').bind('mousedown',function() {
		$('#save_note').removeAttr('disabled');
	});
	$('#save_note').attr('disabled','disabled');
	$('#popuup_div').hide();	
	
	$('#takeanote').click(function(e) {
		if(noteCardOpen == true){
			if(checkIfNoteSavedGroup() == true){
				resetform();
				$('#noteCard').hide();				
				$('#save_note').attr('disabled','disabled');
				noteCardOpen = false;				
			} else {
				warning({
				title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){resetform();
				addnote();				
				$('#noteCard').hide();},
				yesAction:function(){if (saveNote() != false) {
					addnote();					
					$('#noteCard').hide();
					noteCardOpen = false;}
					else {return false;}},
				cancelAction:function(){return false;}
				});
			}
		} else {	
				noteCardOpen = true;
				InitNotecard();				
				$('#noteCard').show();		
				resetform();
		}
		e.preventDefault();
	});
	
	/* if a user click on add citation, it will disable the save button.
		else saveflag is false, it prompts for save when a user click on add citation.
	*/
	$('#addcit').click(function() {
			if (curNote == null) {
				return false;	
			}
			if(checkIfNoteSavedGroup()==false) 
			{
			         warning({
						title:'Warning',
						msg:'Would you like to Save the current note?',
						noAction:function(){
						$('#save_note').attr('disabled','disabled');
						},
						yesAction:function(){
						if (saveNote() != false) {
						$('#save_note').attr('disabled','disabled');}
					else {return false;}
						},
						cancelAction:function(){
						return false;
						}
					});
			}
	});
		startCitation();
		DrawField('note_text','',2000);
		DrawField('note_quotes','',2000);
	if (isNoteOrginizer() == true) {
		$('#noteCard').show();
		noteCardOpen = true;
	}
});

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
/*
	function setupNote
	the function that positions the note card tool on page load.
	Params: 
		options - the different options for setting up the note card tool.
	returns nothing
*/
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
		if (detectMacXFF2() != true && $.browser.safari != true) {
			var iframeoverlay = document.createElement('iframe');
			$(iframeoverlay).attr({'src':'about:blank','frameborder':'0','id':'notecardiframe'});
			$(iframeoverlay).css({'display':'none','height':'530px','width':$(this).css('width'),'position':'absolute','top':'0px','left':'0px', 'z-index':'-1'});
			$(this).append(iframeoverlay);
			$('#safariErrFix').html('');
		} else {
			var divoverlay = document.createElement('div');
			$(divoverlay).attr({'id':'notecarddivoverlay'});
			$(divoverlay).css({'display':'block','height':'530px','width':$(this).width()+'px', 'position':'absolute','top':'0px','left':'0px','z-index':'-1', 'visibility':'visible'});
			$(divoverlay).css({'background-color':'white', 'background-repeat':'repeat','background-position':'0 0'});
			$(this).append(divoverlay);
			$('#safariErrFix').html('');
		}
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
		/*
			function iePositionNote
			positions note based on scroll location for IE only
			Params: 
				noteCard - the note card tool object on the page.
			returns nothing
		*/
	   //METHOD position note based on scroll location
		function iePositionNote(noteCard){
			clearTimeout(alertTimeout);		
			alertTimeout = setTimeout(function(){positionNote(noteCard);},100);
			
		}
		/*
			function positionNote
			positions note based on scroll location
			Params: 
				noteCard - the note card tool object on the page.
			returns nothing
		*/
		function positionNote(noteCard){
			if($.browser.safari){
				//css position will only update if something is physically updated for safari
				$('#safariErrFix').html("");
			}
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
							basePos += 3;
						} else {
							basePos -= 25;
						}
					dockNote(basePos + 36,noteCard);
				} else {
					if (typeof(isxspacepage) != 'undefined' && $.browser.version() == 7) {
						dockNote(basePos + 20,noteCard);
					} else
						if ($.browser.msie && $.browser.version() < 7) {
							dockNote(basePos + 36,noteCard);	
						} else {
							dockNote(basePos + 20,noteCard);	
						}
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
			if ($.browser.mozilla && window.navigator.userAgent.indexOf('mac') != -1) {
				//
			} else {
				$('#slideOut').css({overflow:'hidden'});
				$('#slideOutPanel').css({overflow:'hidden'});
			}
			if($.browser.safari){
				//css position will only update if something is physically updated for safari
				$('#safariErrFix').html("");
			}
		}
		/*
			function getNoteLeftPos
			gets the left starting position of the notecard
			Params: 
				noteCard - the note card tool object on the page.
			returns The leftmost position of the notecard.
		*/
		//METHOD get the left starting position of the notecard
		function getNoteLeftPos(noteCard){
			return $(workareaTop).position().left + workAreaWidth - noteCardWidth - 47;
		}
		/*
			function dockNote
			dock the note at the top of the page
			Params: 
				posTop - the top position of the notecard.
				noteCard - the note card tool object on the page.
			returns nothing
		*/
		//METHOD dock the note at its stationary place at top of page
		function dockNote(posTop,noteCard){
			var scrollY = $(window).scrollTop();			
			var basePos = headerHeight + projBar.height() + workareaTop.height() + subnavHeight;
			
			var posLeft = getNoteLeftPos(noteCard);
			basePos = $('div#workArea').offset().top + $('div#actionBar').height();

			if (typeof(isxspacepage) =="undefined" && isArticle() != true && isHome() == false) {
				
				if(isNoteOrginizer() == true) {
					if($('div#topGray').length != 0)
					{
						posTop = $('div#topGray').offset().top - 10;
					}
				} else {
					posTop = basePos;	
				}
				posTop = basePos;	
				if (scrollY > posTop) {
					posTop = posTop + (scrollY - posTop);
				}
			} else if (isHome() == true) {
				posTop = $('div#topNav').offset().top - 17;
				if (scrollY > posTop) {
					posTop = posTop + (scrollY - posTop);
				}
			}
			
			if(isNoteOrginizer() == true) {
				if($.browser.safari){
					if (typeof(startpagenow) == 'undefined'){
						var safPos = posTop;
						var startpagenow = true;
						noteCard.css({position:"absolute",left:posLeft+"px",top:safPos +"px"});
					}
				} else {
					noteCard.css({position:"absolute",left:posLeft+"px",top:posTop +"px"});
				}
			} else {
				if(typeof(isxspacepage) !="undefined") {
					if(($.browser.msie == true && $.browser.version() > 6) || $.browser.msie == false){
						if ($.browser.safari) {
							var safPos = ((basePos - scrollY) + 36);
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
						if (typeof(isxspacepage) =="undefined" && isArticle() != true) {
							if (typeof(startpagenow) == 'undefined'){
								var safPos = posTop;
								var startpagenow = true;
							} else {
								var safPos = ((parseInt(posTop) - (parseInt(scrollY) > parseInt(posTop)? parseInt(scrollY): 0)) + 36);
							}
						} else {
							var safPos = ((parseInt(basePos) - (parseInt(scrollY) > parseInt(posTop)? parseInt(scrollY): 0)) + 36);
						}
						noteCard.css({position:"absolute",left:posLeft+"px",top:safPos +"px"});
					} else {
						if (detectMacXFF2() == true && isHome() == true) {
							if (parseInt(scrollY) < parseInt(posTop)) {
								posTop = parseInt(posTop) - parseInt(scrollY);
							}
							noteCard.css({position:"fixed",left:posLeft+"px",top:posTop +"px"});
						} else {
							noteCard.css({position:"absolute",left:posLeft+"px",top:posTop +"px"});							
						}
					}
				}
			}
		 }
		 /*
			function undockNote
			attachnote to top of scrolling page
			Params: 
				noteCard - the note card tool object on the page.
			returns nothing
		*/
		//METHOD attach note to top of scrolling page
		function undockNote(noteCard){
			var posLeft = getNoteLeftPos(noteCard);
			 noteCard.css({position:"fixed",left:posLeft+"px",top:actionBarHeight + "px"});
		 }
		 /*
			function dockActionBar
			dock the action bar at its stationary place at top of page
			Params: 
				posTop - the top position of the action bar.
			returns nothing
		*/
		 //METHOD dock the action bar at its stationary place at top of page
		function dockActionBar(posTop){
			$('#' + options.actionBarId).css({position:""});
			if($.browser.safari){
				//css position will only update if something is physically updated for safari
				$('#safariErrFix').html("");
			}
			
		 }
 		 /*
			function undockActionBar
			dock the action bar at its stationary place at top of scrolling page
			Params: 
				posTop - the top position of the action bar.
			returns nothing
		*/
		 //METHOD attach action bar to top of scrolling page
		 function undockActionBar(posTop){
			
			 
			 if($.browser.msie && $.browser.version() < 7){
				$('#' + options.actionBarId).css({position:"absolute",top:posTop + "px"});
			}else{
				$('#' + options.actionBarId).css({position:"fixed",top:"0px"});	
			}
		 }
		
		/*
			function toggleExtended
			??
			Params: 
				el - the element to have the style applied to.
			returns nothing
		*/
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
			
			//init toggle extended panel visibility
			$('#extendedNotePanel').find('#optionsCollapse').click(function(){toggleExtended($(this));return false;});
			
			//add close
			noteCard.find('.noteTop').find('a').click(function(){
				if(checkIfNoteSavedGroup()==false) {
					warning({
						title:'Warning',
						msg:'Would you like to Save the current note?',
						noAction:function(){
//								addnote();
								resetform();
								noteCard.hide();
								noteChange('noteCard');
								$('#takeanote').removeClass('abuttonPressed');
								noteCardOpen = false;
								$('#note_tool_menu').hide('slow'); // close take a note menu in workzone.
								return false;	
						},
						yesAction:function(){
							if(saveNote() == false) {
								return false;
							} else {
//								addnote();
								noteCard.hide();
								noteChange('noteCard');								
								$('#takeanote').removeClass('abuttonPressed');
								noteCardOpen = false;
								$('#note_tool_menu').hide('slow'); // close take a note menu in workzone.
								return false;	
							}},
						cancelAction:function(){return false;}
					});
				} else {
					addnote();					
					noteCard.hide();
					noteChange('noteCard');
					$('#takeanote').removeClass('abuttonPressed');
					noteCardOpen = false;
					$('#note_tool_menu').hide('slow'); // close take a note menu in workzone.
					return false;	
				}
			});
			
			//add fewer more options
			
			//set position at start
			positionNote(noteCard);
			
			//set position after scroll
				if($.browser.msie && $.browser.version() < 7){
					$(window).scroll(function(){
											  iePositionNote(noteCard);
											  });
				} else {
					$(window).scroll(function(){
											  positionNote(noteCard);
											  });
				}
				//set position after resize
				$(window).resize(function(){positionNote(noteCard);});
			//animate position change after expand/collapse of workzone
			workzonePanButton.click(function(){
											   
			var pos = $('#noteCard').css('top').replace('px','');
			   
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
			if (isNoteOrginizer() == true) {
				$('a#closeaddcitation').hide();
				$('a#closenotecard').hide();
				$('a#closeviewcitation').hide();
			}
			$('#slideOut').css({width:'30px',left:'-30px'});
			$('#slideOutPanel').css('display','none');		
			slideOutButton.click(function(){
				
				if(myNotesVisible){
					myNotesVisible = false;
					NotesIsVisible = false;
					$('#slideArrow').css({backgroundImage:"url(/images/common/note_sidetab_head.png)"});
					$('#slideTitle').title = expandTitleTextClosed;
					//objNoteCard.isExpanded(false);
					$('#slideOutPanel').css('display','none');
					tmpWidth = $('#noteListContainer').css('width');
					$('#existSourceList').css('width','0px');
					$('#citeSourceList').css('width','0px');
					$('#newSourceList').css('width','0px');
					$('#viewSourceList').css('width','0px');
					$('#noteListContainer').css('width','0px');
					slideOutPanel.animate({ width:'0px' }, { duration:options.sidePanelSlideDur, complete:				
						function() {
							$('#existSourceList').css('overflow-y','hidden');
							$('#citeSourceList').css('overflow-y','hidden');
							$('#newSourceList').css('overflow-y','hidden');
							$('#viewSourceList').css('overflow-y','hidden');
							$('#noteListContainer').css('overflow-y','hidden');	
							$('div#slideOut').css('z-index',-1);
							$('#slideOut').css({width:'30px',left:'-30px'});
							$('div#slideOut').css('z-index',0);								
						}
					});
					if(isBibliography() != false)						
					$('div#slideOut').css('z-index',0);
				}else{		
					//RECORD STAT HIT
					if($('div#viewSourceSlideCont').css('display') == 'none')
					{
						collectStat('notecard','xs','list','');
					}
					else
					{
						collectStat('biblio','xs','list','');
					}
					
					
					myNotesVisible = true;
					NotesIsVisible = true;
					//get and draw all notes for list
					
					$('#slideArrow').css({backgroundImage:"url(/images/common/note_sidetab_head_close.png)"});
					$('#slideTitle').attr('title',expandTitleTextOpen);
					if (isHome() == true && detectMacXFF2() == true) {
						$('.tabContent').css('background-color','white');
					} else {
						$('div#slideOut').css('z-index',10);
						$('div#slideOut').css('z-index',-1);							
					}
					$('#slideOutPanel').css('display','block');					
					$('#slideOut').css({width:'260px',left:'-260px'});
					$('div#slideOut').css('z-index',1);						
					slideOutPanel.animate({ width: options.sidePanelWidth + "px"}, { duration:options.sidePanelSlideDur, complete: function() {
						$('#existSourceList').css({'overflow-y':'auto'}).trigger('mouseover');
						$('#citeSourceList').css({'overflow-y':'auto'}).trigger('mouseover');
						$('#newSourceList').css({'overflow-y':'auto'}).trigger('mouseover');
						$('#viewSourceList').css({'overflow-y':'auto'}).trigger('mouseover');
						$('#noteListContainer').css({'overflow-y':'auto'}).trigger('mouseover');
						if (isHome() == true && detectMacXFF2() == true) {						
							$('#note_title').each(function(n) {
								$(this).html($(this).html());
							});
							$('#noteListContainer').scroll(0,0);
						}
					}});
						if(tmpWidth != 0) {
							$('#existSourceList').css('width',tmpWidth);
							$('#citeSourceList').css('width',tmpWidth);
							$('#newSourceList').css('width',tmpWidth);
							$('#viewSourceList').css('width',tmpWidth);
							$('#noteListContainer').css('width',tmpWidth);
						}
						$('#note_title').focus();
				}
				return false;
			});
			if (isHome() == true && detectMacXFF2() == true) {
				slideOutButton.trigger('click');
				slideOutButton.trigger('click');
			} else if(isHome() == false && detectMacXFF2() == true) {
				$('#existSourceList').css('overflow-y','hidden');
				$('#citeSourceList').css('overflow-y','hidden');
				$('#newSourceList').css('overflow-y','hidden');
				$('#viewSourceList').css('overflow-y','hidden');
				$('#noteListContainer').css('overflow-y','hidden');	
			} else if($.browser.mozilla) {
				$('div#slideOut').css('z-index',0);	
			}
			
			
	   });  //end each
	};  
})(jQuery); 

/*
	function finishInit
	finishes the initialization of the ntoe card tool
	Params: none
	returns nothing
*/

function finishInit() {	
	//reload the notecard left panel and clear the input boxes. also make the citation area "add citation"
	BuildNoteandGroups();	
	$('#note_title').val('');
	$('#note_quotes').val('');
	$('#note_text').val('');						
	$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>");
	$('.note').each(function(i){if ($(this).hasClass('current')) {$(this).attr('class','note');}});	
	if (thisSource != 'noteCard') {
		noteChange('noteCard');
	} else {
		hideSelects();
		$('#noteCardContentCont').find('select').css('visibility','visible');
		
	}
}
/*
	function InitNotecard
	initalize the notecard tool
	Params: none
	returns nothing
*/
//initialize the notecard tool
function InitNotecard() {
	//if the notecard is not in the page manager then load the note card data.
	if (pageManager.getToolsArray().indexOf('notecard') == -1){
		if (typeof(note_tool_menu) != 'undefined'){
			note_tool_mentu=false;
			$('#note_tool_menu').hide('slow');
		}
		addTool('notecard');
		if (noteStore == null) {
			GetNoteAndGroups(assignment_id);
		} else {
			finishInit();	
		}
	} else {
		//use the current note card data
		if (noteCardOpen == true)
		{
			//finishInit();
		}
		
		if (typeof(note_tool_menu) != 'undefined'){
			note_tool_mentu=false;
			$('#note_tool_menu').hide('slow');
		}
	}

}
/*
	function sortnotecards
	sorts the notecards based on title
	Params: 
		a - the first notecard to be checked
		b - the second notecard to be checked
	returns -1 if the a title is a lower letter than the b title otherwise returns 1
*/
//sort the notecards
function sortnotecards(a,b){
	return (stripHTMLwithSpan2(a._title.toLowerCase()) < stripHTMLwithSpan2(b._title.toLowerCase()) ? -1 : 1);	
}

/*
	function loadNewWindowForPrint
	opens a new window for the print popup
	Params: none
	returns nothing
*/
//loads the print window
function loadNewWindowForPrint() {
	collectStat('pfe','xs','print','');
	thePopup1.newWindow('export.php?apptype=html&tool=noteorganizer&print=1','900','700','noteorganizerPrint',1,0,0,1,0,0,0,0);
}

/*
	function showNote
	shows the note selected from the notecard panel.
	Params:
		id - the id of the note to be shown
	returns nothing
*/
//shows the note selected from the notecard panel
function showNote(id){
	//RECORD STAT HIT
	collectStat('notecard','xs','note','');
	//remove the highlight of the current note and make sure that the group panel is on the correct side (group dropdown)
	clearhighlite(id);
	if(document.getElementById('errorgroup')) {
		toggleshowandhide('extendedNotePanel',2);
	}
	//check if the note card is saved and if it is not ask the user to save the note
	var flag=checkIfNoteSavedGroup();
	if (flag==false && id != curNote) {
		warning({title:'Warning',
				msg:'Would you like to Save the current note?',
				noAction:function(){
					finishShowNote(id);
					$('#save_note').attr('disabled','disabled');
				},
				yesAction:function(){
					if(saveNote(curNote) != false) { 				
						finishShowNote(id);
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
/*
	function finishShowNote
	finishes the showNote function
	Params:
		id - the id of the note to be shown
	returns nothing
*/
//finishes the above function
function finishShowNote(id){
	//make the error message blank
	$('#warning').html('');
	//set the note card data
	$('#note_quotes').val(noteStore[id]._directquote).focus();
	$('#note_text').val(noteStore[id]._paraphrase).focus();
	$('#note_title').val(noteStore[id]._title).focus();	
	
	var citationid = noteStore[id]._citationid;
	// display dynamic citation
	if(citationid=='0' || citationid==null)
	{
		$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>");
	} else {
	$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit' title='View Citation' onclick=\"checksavednote('viewCitation'); return false;\" id='viewcitation'>View Citation</a>Citation: </span><p class='citation'>This note has a source assigned.</p>");
	}
	if ((noteStore[id]._groupid ==null) || (noteStore[id]._groupid.replace(/\"|\'/g,'') == 0)){
		$('#select0').attr('selected','selected');
	} else {
		$('#note_category').find('option[value='+noteStore[id]._groupid.replace(/\"|\'/g,'')+']').attr('selected','selected');
		
	}
	if ((curNote != null) || (curNote == '0')){
		$('#notes'+curNote).attr('class','note');
	}
	$('#notes'+id).attr('class','note current');
	curNote = id;
}
/*
	function deleteNote()
	deletes the current notecard
	Params: none
	returns nothing
*/
//deletes the notecard
function deleteNote() {
	if((curNote != null) || (curNote == 0))	{
		deletenote(noteStore[curNote]._notecardid.replace(/\'|\"/g,''));
	}
}
/*
	function saveNote
	saves the current notecard
	Params:
		id - the id of the note to be saved
		add - if this was saved by clicking add note.
	returns nothing
*/
//saves the notecard
function saveNote(id,add){
	//RECORD STAT HIT
	collectStat('notecard','xs','save','');	
	
	if (typeof(id) == 'undefined') {
		id = curNote;
	}
	
	//retrieve the data from the new note
	var title=$('#note_title').val();
	var notequotes=$('#note_quotes').val();
	var notetext=$('#note_text').val();
	var groupid = $('#note_category').find('option:selected').val();
	if (groupid == 'Select Group') {
		groupid = 0;	
	}
	//if there is no title throw an error
	if(title.replace(/ /g,'')=='')
	{
		$('#note_title').focus();
		$('#warning').html('A note card title is required.');
		return false;
	} else {
		//save or update the notecard
		$('#warning').html('');
		if(curNote == null){
			insertnotecard(title,notequotes,notetext,groupid,add);
		} else {
			var notecardid = noteStore[id]._notecardid.replace(/\"|\'/g,'');
			updatenotecard(notecardid,title,notequotes,notetext,groupid,add);
			/**
			if (onlyGroupChanged(groupid) == true) {
				//updateNotecardGroup(notecardid, groupid,add);
			} else {
				updatenotecard(notecardid,title,notequotes,notetext,groupid,add);
			}
			*/
			$("#link" + id).text(title);
		}
		showSavePopup();
		$('#save_note').attr('disabled','disabled');
	}
}
/*
	function getCallerFunctionName
	find out which function was called
	Params:
		caller - the function that was called from
	returns caller
*/
function getCallerFunctionName(caller) {
	var tmp = '';
	tmp = caller;
	return tmp;
}
/*
	function onlyGroupChanged
	check if only the group has been changed.
	Params:
		groupid - the new group id
	returns true if the group has been changed else false.
*/
//check if the group is the only thing changed
function onlyGroupChanged(groupid){
	if (checkIfNoteSaved() != false) {
		if (noteStore[curNote]._groupid == groupid) {
			return false;
		} else {
			return true;
		}
	} else {
		return false;	
	}
}
/*
	function hideSelects
	hides the select boxes for the notecard and citation tool.
	Params: none
	returns nothing
*/
//hides the select boxes
function hideSelects() {
	$('#noteCardContentCont').find('select').css('visibility','hidden');
	$('#citeSourceCont').find('select').css('visibility','hidden');
	$('#newSourceCont').find('select').css('visibility','hidden');
	$('#existSourceCont').find('select').css('visibility','hidden');
	$('#viewCitationCont').find('select').css('visibility','hidden');
	$('#newSourceCont').find('radio').css('visibility','hidden');
}
/*
	function noteChange
	finishes the showNote function
	Params:
		link - the part of the notecard or citation tool to change to.
	returns nothing
*/
//changes the notecard to which has been chosen
function noteChange(link){
	//Change all Note Card Contents to None
	$('#noteCardContentCont').hide();
	$('#citeSourceCont').hide();
	$('#existSourceCont').hide();
	$('#newSourceCont').hide();
	$('#viewCitationCont').hide();
	
	//Change all Note Card Slideouts to None
	$('#notesSlideCont').hide();
	$('#citeSourceSlideCont').hide();
	$('#existSourceSlideCont').hide();
	$('#newSourceSlideCont').hide();
	$('#viewSourceSlideCont').hide();
	
	//Change all Button sections to empty
	$('#noteButtonsCont').hide();
	$('#citationButtonsCont').hide();
	$('#viewCitationButtonsCont').hide();
	
	//Change all Header sections to empty
	$('#noteCardHeaderCont').hide();
	$('#citationToolHeaderCont').hide();
	$('#viewCitationHeaderCont').hide();

	$('#noteCardContentCont').find('select').css('display','none');
	$('#citeSourceCont').find('select').css('display','none');
	$('#existSourceCont').find('select').css('display','none');
	$('#newSourceCont').find('select').css('display','none');
	$('#viewCitationCont').find('select').css('display','none');
	//if the page is the note card the left panel is the note panel
	if (link == 'noteCard'){
		expandTitleTextClosed = "Click to view all your note cards";
		expandTitleTextOpen = "Click to close all your note cards";
	} else {
		expandTitleTextClosed = "Click to view all your citations";
		expandTitleTextOpen = "Click to close all your citations";
	}
	//if the left panel is open show the open title
	if(myNotesVisible){
		$('#slideTitle').attr('title',expandTitleTextOpen);
	} else {
		$('#slideTitle').attr('title',expandTitleTextClosed);
	}
	//reset tmpcitationid and make thisSource the page the user id going to
	tmpcitationid = -1;
	thisSource = link;
	//show each individual panel
	if (link == 'viewCitation'){ //view citation
		InitCitation();	
		$('#viewSourceSlideCont').show();
		$('#viewCitationCont').show();
		$('#viewCitationButtonsCont').show();
		$('#viewCitationHeaderCont').show();
		hideSelects();
		$('#viewCitationCont').find('select').css({'display':'inline','visibility':'visible'});
	} else if (link == 'citeSource'){ //cite source on screen
		//restoreexistoption();
		buildContentList(1,citationcontenttypeData);		
		InitCitation();		
		if(citesource != false) {
			$('.citeSourceOption').attr('selected',true);
			$('#citeSourceSlideCont').show();
			$('#citeSourceCont').show();
			$('#citationButtonsCont').show();
			$('#citationToolHeaderCont').show();
			hideSelects();			
			$('#citeSourceCont').find('select').css({'display':'inline','visibility':'visible'});
		} else {
			noteChange('newSource');
			return false;
		}
	} else if (link == 'existSource'){ //use existing source
		if(existsource != false) {
			$('.existSourceOption').attr('selected',true);
			$('#existSourceSlideCont').show();
			$('#existSourceCont').show();
			$('#citationButtonsCont').show();
			$('#citationToolHeaderCont').show();
			$('#existcitationid').html('None Cited Yet');
			$('div#existSourceSlideCont div#existSourceList div').each(function(obj) {
				$(this).attr('class','notselected');
			});
			if (NotesIsVisible == false){
				$('#slideOutButton').find('a').trigger('click');
			}
			hideSelects();
			$('#existSourceCont').find('select').css({'display':'inline','visibility':'visible'});
		} else {
			noteChange('newSource');
			return false;
		}
	} else if (link == 'newSource'){ // new citation
		$('.newSourceOption').attr('selected',true);
		$('#newSourceSlideCont').show();
		$('#newSourceCont').show();
		$('#citationButtonsCont').show();
		$('#citationToolHeaderCont').show();	
		$(':radio[name=medium][value=1]').trigger('click');
		CheckifSet();			
		hideSelects();
		$('#newSourceCont').find('select').css({'display':'inline','visibility':'visible'});
		$('#newSourceCont').find(':radio').css('visibility','visible');		
	} else if (link == 'noteCard'){ //note card view
		document.getElementById('italTextArea').src = 'about:blank';
		$('#newSourceCont').find(':radio').css('visibility','hidden');
		$('#notesSlideCont').show();
		$('#noteCardContentCont').show();
		$('#noteButtonsCont').show();
		$('#noteCardHeaderCont').show();
		hideSelects();
		$('#noteCardContentCont').find('select').css({'display':'block','visibility':'visible'});
	}
	thisSource = link;
	if (detectMacXFF2() == true) {
		$('#notecarddivoverlay').css('height',$('#noteCard').height()+'px');
	}	
	
	if (link == 'noteCard')
	{
		if(myNotesVisible)
		{
			//RECORD STAT HIT
			collectStat('notes','xs','list','');
		}
	} 
	else 
	{
		if(myNotesVisible)
		{
			//RECORD STAT HIT
			collectStat('biblio','xs','list','');
			if(link == "viewCitation"){collectStat('biblio','xs','citation','');}
		}		
	}
}

/*
	function toggleshowandhide
	finishes the showNote function
	Params:
		id - the id of the div to be changed
		idflag - the idflag keeps track of what should be in the group area.
	returns nothing
*/
//change to add group div and back
function toggleshowandhide(id,idflag){	
	//switching to the add new group
	if(idflag==1)
	{
		//build the elements and add the attributes
		var span = document.createElement('span');
		$(span).attr('id','note_category');
		var ul = document.createElement('ul');
		var li = document.createElement('li');
		var label = document.createElement('label');
		$(label).attr('for','Add a new group').html('Add a new group');
		var input = document.createElement('input');
		$(input).attr({'name':'addnewcat','type':'text','id':'addnewcat','style':'margin-left:-8px;','title':'Add new group','maxlength':'30'}).bind('keypress',function(e){
			if (e.keyCode == 13){
				$('#savecat').trigger('click');
				return false;
			}});
																																									
		var br = document.createElement('br');
		var p = document.createElement('p');
		$(p).attr({'id':'errorgroup','class':'warning','style':'line-height:11px !important; display:inline;'}).html('&nbsp;');
		$(span).append($(ul).append($(li).append(label).append(input).append(br).append(p)));
		var div = document.createElement('div');
		$(div).attr({'class':'note_buttons','style':'background-color:transparent !important; border:0px solid black;'});
		var input2 = document.createElement('input');
		$(input2).attr({'type':'button','value':'Cancel','id':'cancelcat','class':'truebutton','title':'Cancel'}).bind('click',function(){toggleshowandhide('extendedNotePanel',2);});
		$(div).append(input2);
		var input3 = document.createElement('input');
		$(input3).attr({'type':'button','name':'Save','id':'savecat','value':'Save','title':'Save Group', 'class':'truebutton'}).unbind('click').bind('click',function(){addGroup($('#addnewcat').val());});
		$(span).append($(div).append(input3));
		tmpstr1=$('#'+id).html();	
		//build the new container
		$('#'+id).html(span);
		idflag=2;
		$('#addnewcat').trigger('focus');
		$('#save_note').attr('disabled','disabled');
		$('#delete_note').attr('disabled','disabled');
		$('#add_note').attr('disabled','disabled');
	} else {
		//put the old container back in
		$('#'+id).html(tmpstr1);
		$('#save_note').removeAttr('disabled');
		$('#delete_note').removeAttr('disabled');
		$('#add_note').removeAttr('disabled');
		$('#note_category').bind('click',function() {
			$('#save_note').removeAttr('disabled');
		});
		$('#note_category').bind('mouseup',function() {
			$('#save_note').removeAttr('disabled');
		});
		$('#note_category').bind('change',function() {
			$('#save_note').removeAttr('disabled');
		});
		$('#note_category').bind('mousedown',function() {
			$('#save_note').removeAttr('disabled');
		});
	}

}

/*
	function checkduplicate
	checks if a group name exists
	Params:
		text - group to be checked for.
	returns true if a duplicate false otherwise.
*/

function checkduplicate(text){
	var i = 0;
	var len = groupStore.length;
	if (text.toLowerCase() == 'uncategorized') {
		$('#errorgroup').html("This category name already exists.");
		return true;
	}	
	while (i < len)
	{
		var str = groupStore[i]._title;
		if(text.toLowerCase()==str.toLowerCase())
		{
			$('#errorgroup').html("This category name already exists.");
			return true;
		}
		i++;
	}
	return false;
}

/*
	function addoption
	adds the group to the dropdown
	Params:
		text - title of the group to be added.
		id - id of the group to be added.
	returns nothing
*/
function addoption(text, id){
	// create new option in drop down list
	var nextid = id;
	groupid = nextid.indexOf('"') == -1 ? nextid : nextid.replace(/"/g,'');
	len = groupStore.length;
	//add the new group to the group object
	groupStore[len] = new Object();
	groupStore[len]._profileid = profileid;
	groupStore[len]._assignmentid = currassgn;
	groupStore[len]._sort = '_title';	
	if (typeof(text) == 'object') {
		groupStore[len]._title = text[0];
	} else {
		groupStore[len]._title = text;
	}
	groupStore[len]._groupid = groupid;
	//rebuild the left panel
	BuildNoteandGroups();
}
/*
	function buildCategoryList
	biulds the group list
	Params: none
	returns nothing
*/
//builds the group list
function buildCategoryList() {
	//safari does not like the building of the option using jQuery
	if ($.browser.safari) {
		var tmpopt = document.createElement('option');
		tmpopt.setAttribute('id','select0');
		tmpopt.setAttribute('selected','true');
		tmpopt.innerHTML = 'Select Group';
	} else
	var tmpopt = $(document.createElement('option')).attr({'id':'select0','value':0,'selected':'selected'}).html('Select Group');
	//find the current selected group and rebuild the group list
	var tmpindex = $('#note_category').find('option:selected').val();
	$('#note_category').html('');
	$('#note_category').append(tmpopt);
	$.grep(groupStore,function(n,i){	   
		tmpopt = $(document.createElement('option')).attr({'value':n._groupid,'id':'select'+n._groupid}).html(n._title);
		$('#note_category').append(tmpopt);
	});
	if ($.browser.msie && parseInt($.browser.version()) <7){
		setTimeout("$('#note_category').find('option[value="+tmpindex+"]').attr('selected','selected')",200);
	} else {
		$('#note_category').find('option[value='+tmpindex+']').attr('selected','selected');
	}
}

/*
Ajax call language_check.php url and
pass in string=value
return value of 0 or 1.
1=not ok
0=ok
*/

function languagechecker(str){
	languageflag = $.ajax( {
				url: "/language_checker.php",
				data: "string="+encodeURIComponent(str),
				async: false
						  }).responseText;
	return languageflag;
}
/*
	function checkIfNoteSaved
	check to see if the note is saved minus the group
	Params: none
	returns true if saved else false.
*/
//check to see if the note is saved minus the group
function checkIfNoteSaved() {
	var count=0;
	if (curNote == null) { //if the note is not already saved
		if ($('#note_title').val() != '') { //if the title is not blank
			count++; //the note has not been saved
		}
	} else if($('#note_title').val() != noteStore[curNote]._title){ // if the note title changed
		count++; //the note has not been changed
	}
	if (curNote == null) { //if the note is not already saved
		if ($('#note_quotes').val() != '') { // if the quotes is not blank
			count++; //the note has not been saved
		}
	} else if($('#note_quotes').val() != noteStore[curNote]._directquote){ //if the quotes do not match
		count++; //the note has not been saved
	}
	if (curNote == null) { //if the note is not already saved
		if ($('#note_text').val() != '') { //if the my ntoes is not saved
			count++; //the note has not been saved
		}
	} else if($('#note_text').val() != noteStore[curNote]._paraphrase){ //if the my notes do not match
		count++; //the note has not been saved
	}
	if(count > 0) // if the note has not been saved return false else true
	{
		return false;
	} else {
		return true;
	}
}
/*
	function checkIfNoteSavedGroup
	check to see if the note is saved with the group
	Params: none
	returns true if saved else false.
*/
//check to see if the note is saved with the group
function checkIfNoteSavedGroup() {
	var count=0;
	if (curNote == null) { //if the note is not already saved
		if ($('#note_title').val() != '') { //if the title is not blank
			count++; //the note has not been saved
		}
	} else if($('#note_title').val() != noteStore[curNote]._title){ // if the note title changed
		count++; //the note has not been changed
	}
	if (curNote == null) { //if the note is not already saved
		if ($('#note_quotes').val() != '') { // if the quotes is not blank
			count++; //the note has not been saved
		}
	} else if($('#note_quotes').val() != noteStore[curNote]._directquote){ //if the quotes do not match
		count++; //the note has not been saved
	}
	if (curNote == null) { //if the note is not already saved
		if ($('#note_text').val() != '') { //if the my ntoes is not saved
			count++; //the note has not been saved
		}
	} else if($('#note_text').val() != noteStore[curNote]._paraphrase){ //if the my notes do not match
		count++; //the note has not been saved
	}
	var tmpgroup = 0;
	if ($.browser.safari) {
		tmpgroup = 'Select Group';	
	}
	if (curNote == null) { //if the note is not already saved
		if ($('#note_category').find('option:selected').attr('value') != tmpgroup) {
			count++;
		}
	} else if (noteStore[curNote]._groupid != ($('#note_category').find('option:selected').attr('value') == 'Select Group'? 0 : $('#note_category').find('option:selected').attr('value'))){ //if the group has changed
		count++; //the note has not been saved
	}
	if(count > 0)
	{
		return false;
	} else {
		return true;
	}
}

/*
	function resetform
	reset notecard form to empty and set curNote to null
	Params: none
	returns nothing
*/
function resetform(){

			$('#note_text').val('').focus();
			$('#note_quotes').val('').focus();
			$('#note_title').val('').focus();			
			$('#warning').html('');
			$('#select0').attr('selected','selected');
			curNote=null;		
}


/*
	function addnote
	makes a new note to edit.
	Params: none
	returns nothing
*/
function addnote(){					
	// check to see if a user click save the note. if not ask the user if they would like to save and create a blank note card
	if(checkIfNoteSavedGroup() == false)
	{
	warning({
		title:'Warning',
		msg:'Would you like to Save the current note?',
		noAction:function(){
			if (curNote != null)
			$('#notes'+curNote).removeAttr('class').attr('class','note');
			resetform();
			$('#save_note').attr('disabled','disabled');
			$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>");	
			curNote = null;
		},
		yesAction:function(){
			if(saveNote(curNote,1) != false) {
				if (curNote != null)
				$('#notes'+curNote).removeAttr('class').attr('class','note');
				resetform();
				$('#save_note').attr('disabled','disabled');
				$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>");
				curNote = null;
			} else return false;
			},
		cancelAction:function(){return false;}
		});
	} else {
			if (curNote != null)
				$('#notes'+curNote).removeAttr('class').attr('class','note');
				resetform();	
				$('#save_note').attr('disabled','disabled');
			$('#addcitation').html("<span class='label' for='Add citation'><a href='#' class='addCit'  title='Add Citation' onclick=\"checksavednote('citeSource'); return false;\" id='addcit'>Add a Citation</a>Citation: </span><p class='citation'>This note does not have a source assigned.</p>");	
	curNote = null;			
	}
}

/*
	function confirmDeleteNote
	asks the user if they would like to delete the note card.
	Params: none
	returns nothing
*/

function confirmDeleteNote(){
	if (curNote != null) {
		warning({
			title:'Warning',
			msg:'Are you sure you want to delete note "'+noteStore[curNote]._title+'"?',
			noAction:function(){ 
				return false;
			},
			yesAction:function(){
				deleteNote();
				resetform();	
				$('#save_note').attr('disabled','disabled');
			},
			cancelAction:function(){ return false;}
		});
	}
}
/*
	function showSavePopup
	shows the popup for saved message
	Params: none
	returns nothing
*/
function showSavePopup() {
    //getting height and width of the message box
    var height = $('#popuup_div').height();
    var width = $('#popuup_div').width();
	var x = ($('div #noteTabContent').offset().left + ($('div #noteTabContent').width()/2));
	var y = ($('div #noteTabContent').offset().top + ($('div #noteTabContent').height()/2));
    //calculating offset for displaying popup message
    leftVal= parseInt(x-(width/2))+"px";
    topVal= parseInt(y -(height/2))+"px"; 
    //show the popup message and hide with fading effect
    $('#popuup_div').css({left:leftVal,top:topVal, position:'absolute', 'z-index':100}).show().hide("slow");
}
/*
	function BuildNoteandGroups
	builds the notecard left panel.
	Params: none
	returns nothing
*/
//builds the notecard left panel
function BuildNoteandGroups() {
	//sort the 
	groupStore.sort(sortGroups);
	//get the note left panel and clear it
	var theul = $('#noteUL');
	theul.html('');
	//get the group dropdown
	var selectbox = $('#note_category');
	//loop through the groups and notes and build the left panel
	for (i=0; i<groupStore.length; i++){
		var li = $(document.createElement('li'));
		if (i%2 == 0){
			li.attr('class','category');
		} else {
			li.attr('class','category alternate');
		}
		var div = $(document.createElement('div'));
		div.html('<span>Category: </span>'+forceWrapmissHTML(groupStore[i]._title));
		var ul = $(document.createElement('ul'));
		ul.attr('id','group'+groupStore[i]._groupid);
		
		for (j=0; j<noteStore.length; j++){
			if (noteStore[j]._groupid == groupStore[i]._groupid) {
				var li2 = $(document.createElement('li'));
				if(curNote != null && noteStore[j]._notecardid==noteStore[curNote]._notecardid)
				{
					li2.attr('class','note current');
				} else {
					li2.attr('class','note');	
				}
				li2.attr('id','notes'+j);
				li2.html('<div><span>Note: </span><a href="#" onclick="showNote(\''+j+'\'); return false;" title="'+noteStore[j]._title+'" id="link'+j+'">'+forceWrapmissHTML(noteStore[j]._title)+'</a></div>');
				ul.append(li2);
			}
		}
		li.append(div);
		li.append(ul);										
		theul.append(li);
	}
	var hold = "";
	
	for (j=0; j<noteStore.length; j++){
		if (noteStore[j]._groupid == '0' || noteStore[j]._groupid == null){
			var str='';
			if(curNote != null && noteStore[j]._notecardid==noteStore[curNote]._notecardid)
			{
					str='<li class="note current" id="notes'+j+'">';
			} else {
					str='<li class="note" id="notes'+j+'">';
			}
			hold += str + '<div><span>Note: </span><a href="#" onclick="showNote('+j+'); return false;" title="'+noteStore[j]._title+'" id="link'+j+'">'+forceWrap(noteStore[j]._title)+'</a></div></li>';
		}
	}
	var li1 = $(document.createElement('li'));
	if (i%2 == 0){
		li1.attr('class','category');
	} else {
		li1.attr('class','category alternate');
	}
	var tmp = '<div><span>Category: </span>Uncategorized</div><ul id="group0">';
	hold = tmp + hold + '</ul>';
	li1.html(hold);
	theul.append(li1);
	$(theul).html($(theul).html());
	$('#note_category').html('');
	buildCategoryList();
}
/*
	function forceWrap
	forces the wrap of the specified text
	Params: 
		text - the text to be wrapped.
	returns nothing
*/
//forces the wrap of the text
function forceWrap(text){
	var tmp = '';
	if (typeof(text) == 'undefined' || text.length == 0)
	return tmp;
	for (var i = 0; i < text.length;i++){
		if (text.substring(i,i+5) == '&amp;') {
			tmp += '&amp;';
			i=i+5;
		} else if (text.substring(i,i+4) == '&gt;') {
			tmp += '&gt;';			
			i=i+4;
		} else if (text.substring(i,i+4) == '&lt;') {
			tmp += '&lt;';			
			i=i+4;	
		} else if (text.substr(i,1) == '<' && (text.substring(i,4) != '<htt')) {
			tmp += '<';
		} else if (text.substr(i,1) == '>') {
			tmp += '>'
		} else {
			if ($.browser.msie || $.browser.mozilla){
				tmp += text.substring(i,i+1)+'<wbr />';
			} else {
				tmp += text.substring(i,i+1)+'&#8203;';
			}	
		}
	}
	return tmp;
}

/*
	function clearhighlight
	removes the highlight in the note left panel
	Params: 
		id - the id of the notecard to remove the highlight from.
	returns nothing
*/
//removes the highlight in the note left panel
function clearhighlite(id){
	var i=0;
	while(i < noteStore.length)
	{
		$('#notes'+i).removeClass('note current');
		$('#notes'+i).addClass('note');
		i++;	
	}
	$('#notes'+id).addClass('note current');
}
/*
	function isNoteOrganizer
	checks if the page is the note organizer page
	Params: none
	returns true if the page is the noteorganizer page else false.
*/
//checks if the page is the note organizer page
function isNoteOrginizer() {
	var URL = window.location.href;
	URL = URL.replace('http://','');
	URL = URL.indexOf('/') != -1 ? URL.substr(URL.indexOf('/')+1) : URL;
	URL = URL.indexOf('?') != -1 ? URL.substring(0,URL.indexOf('?')) : URL;
	URL = URL.indexOf('#') != -1 ? URL.substring(0,URL.indexOf('#')) : URL;		
	if(URL.toLowerCase().replace(/#/g,'') == 'note_organizer') {
		return true;
	}
	return false;
}
/*
	function isHome
	checks if the page is the home page
	Params: none
	returns true if the page is the home page else false.
*/
//checks if the page is the home page
function isHome() {
	var URL = window.location.href;
	URL = URL.replace('http://','');
	URL = URL.indexOf('/') != -1 ? URL.substr(URL.indexOf('/')+1) : URL;
	URL = URL.indexOf('?') != -1 ? URL.substring(0,URL.indexOf('?')) : URL;
	URL = URL.indexOf('#') != -1 ? URL.substring(0,URL.indexOf('#')) : URL;	
	if(URL.toLowerCase().replace(/#/g,'') == 'home' || URL.toLowerCase().replace(/#/g,'') == '') {
		return true;
	}
	return false;
}
/*
	function sortGroups
	sorts the groups
	Params: 
		a - the first group to be sorted
		b - the second group to be sorted
	returns -1 if the a group is a lower letter than the b group else returns 1.
*/
//sort the groups
function sortGroups(a,b){
		return (a._title.toLowerCase() < b._title.toLowerCase() ? -1 : 1);
}