/** 
	@file: arch/notecard.js
	@description: the page that holds the fucntions for the note card dropdown in the workzone
	
	function opennotecard
	opens the note card from the workzone
	Params - none
	returns false
*/
function opennotecard() {
	//initialize the notecard and show the notecard if it is not already
	InitNotecard();
	if(noteCardOpen == true){
		if(checkIfNoteSaved() == true)
		{
			$('#noteCard').hide();				
			$('#save_note').attr('disabled','disabled');
			noteCardOpen = false;				
		} else {
/**
			warning({
			title:'Warning',
			msg:'Would you like to Save the current noteDEBUG0?',
			noAction:function(){resetform();				
			addnote();			
			$('#noteCard').hide();},
			yesAction:function(){if (saveNote() != false) {
*/
			addnote();
				$('#noteCard').hide();
				noteCardOpen = false;//}
				//else {return false;}},
			//cancelAction:function(){return false;}
			//});
		}
	} else {
			$('#noteCard').show();
			resetform();
			noteCardOpen = true;
	}
	
	return false;
}

var note_tool_menu=false; // This variable to indicate the note menu is not open.

/* 
	function getnotetoolmenu 
	opens the note card tool menu
	Params - none
	returns - false
*/
function getnotetoolmenu() {
	//if the note tool menu is not open open it and show the links
	if($('#note_tool_menu').css('display') == 'none') {
		$('#dict_atlas').hide("slow");
		dict_atlas=false;
	
	 	/* get the width and height of note_tool */
	
	 	var left = $('#note_tool').offset().left;
	 	var top = $('#note_tool').offset().top;
	 	var height = $('#note_tool').height();
     	var width = $('#note_tool').width();
	 
    	var leftVal= left  + (width/2) - 10 +  "px";
    	var topVal= top + height - 10 + "px"; 
	
		$('#note_tool_menu').css({left:leftVal,top:topVal});
		$('#note_tool_menu').show('slow');		
	
		/* if notecard open, disable the link */
 
		if(noteCardOpen == true) {		
			$('#takeanotelink').html('Take a note');
			$('#takeanotelink').css({color:'#cccccc',cursor:'text'}).unbind('click').bind('click',function(){		note_tool_menu=false;$('#note_tool_menu').hide('slow');});
		} else {
			$('#takeanotelink').html('<a href="#" title="Open a note" onclick="opennotecard(); return false;">Take a note</a>');
		}
	} else {
		$('#note_tool_menu').hide('slow');
	}
	return false;
}

/* 
	function updatemynotecard
	Updates the notecard when the user changes assignments
	Params - 
		assignmentid - the current assignment id
	returns false
*/
function updatemynotecard(assignmentid) {

	GetNoteAndGroups(assignmentid); // Pass information into notecard
	
	return false;
}

/** 
	function displaySaveNotecardPopup
	displays the save notecard popup
	Params - none
	returns false
*/
function displaySaveNotecardPopup() 
{
			warning({
			title:'Warning',
			msg:'Would you like to Save the current note?',
			noAction:function(){resetform();
			$('#noteCard').hide();},
			yesAction:function(){if (saveNote() != false) {
			addnote();
				//$('#noteCard').hide();
				//noteCardOpen = false;
			}else {return false;}},
			cancelAction:function(){return false;}
			});
	return false;
}