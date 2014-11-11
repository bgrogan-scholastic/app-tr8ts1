/** 
	@file: organizer.js
	@description: the page that holds the fucntions for the note organizer
	
	note organizer variables:
	organizer_store - a variable that holds the flash operation ids
*/

var organizer_store = {opId: 0};
$(window).bind('load',function(e){
	//on page load open the notecard
	InitNotecard();
});
/*
	function org_getGroups
	gets the groups and passes them to the note organizer flash
	Params: none
	returns the flash opId?
*/
function org_getGroups()
{
  ++(organizer_store.opId);

  // Check if the groupStore has loaded yet.. if not, mark this operation as pending.
  if (typeof(groupStore) == "undefined" || groupStore == null)
  {
	organizer_store.pendingGroups = organizer_store.opId;
  }
  else
  {
	setOrganizerGroups(organizer_store.opId);
  }
  return organizer_store.opId;
}

/*
	function exportPopupno
	the export popup for the note organizer
	Params: none
	returns true if the page is the noteorganizer page else false.
*/
function exportPopupno() {
		warning({
			title:'Export',
			msg:'You have chosen to export your Notes. Please choose an export format and click Export.<br><br><b>Format:</b><br><div><span><input type="radio" name="format" value="rtf" checked="checked"/>Word</span><span style="width:150px;">&nbsp;</span><span><input type="radio" name="format" value="html" />HTML</span></span>',
			buttons: 'Cancel,Export',
			noAction:function(){window.location.href='export.php?tool=noteorganizer&apptype='+$(':radio[name=format]:checked').attr('value'); collectStat('norg','xs','xport','');return false;},
			yesAction:function(){ return false;},
			cancelAction:function(){return false;}
		});
	}
/*
	function setOrganizerGroups
	sets the groups in the note organizer
	Params: 
		opId - the falsh opertaion id
	returns nothing
*/
// Push the groups into the organizer, use the operation id from the request.
function setOrganizerGroups(opId)
{
  // thisMovie is in assignment.js.
  // TODO: relocate thisMovie to somewhere more centralized, however assignment.js should be on every page.
  var organizerSwf = thisMovie('organizerSwf');

  var fn = organizerSwf.onResult
  if (typeof(fn) != "undefined")
    organizerSwf.onResult(opId, groupStore);
}
/*
	function org_getNotecards
	sets the notes in the note organizer flash
	Params: none
	returns flash operation id
*/
function org_getNotecards()
{
  ++(organizer_store.opId);

  // Check if the noteStore has loaded yet.. if not, mark this operation as pending.
  if (typeof(noteStore) == "undefined" || noteStore == null)
  {
	organizer_store.pendingNotes = organizer_store.opId;
  }
  else
  {
	setOrganizerNotes(organizer_store.opId);
  }
  
  return organizer_store.opId;
}
/*
	function org_selectNotecards
	called when a card is selected in the organizer
	Params: 
		cardId - the note card id
	returns set if cardid is not 0 and 0 otherwise.
*/
// Called when a card is selected in the organizer
function org_selectNotecard(cardId)
{
  if (cardId >= 0)
  {
	var set = 0;
	$.grep(noteStore,function(n,i){
		if (n._notecardid.replace(/\'|\"/g,'') == cardId) {
			showNote(i);
			set = 1;
		}
		return(n._notecardid == cardId);
	});
	return set;
  }  

  return 0;
}
/*
	function setOrganizerNotes
	sets the notes in the note organizer flash
	Params: 
		opId - the flash operation id
	returns nothing
*/
// Push the notes into the organizer, use the operation id from the request.
function setOrganizerNotes(opId)
{
  // thisMovie is in assignment.js.
  // TODO: relocate thisMovie to somewhere more centralized
  var organizerSwf = thisMovie('organizerSwf');
  
  var fn = organizerSwf.onResult
  if (typeof(fn) != "undefined")
    organizerSwf.onResult(opId, noteStore);
}
/*
	function org_updateNotecardGroup
	Called by the organizer to update the groupid of a notecard.
	Params: args
		args {
			0 - the note card id,
			1 - the group id
		}
	returns flash operation id
*/
// Called by the organizer to update the groupid of a notecard.
// Return the operation id but a response is not required.
function org_updateNotecardGroup(args)
{
	var cardid = args[0];
	var groupid = args[1];
	++(organizer_store.opId);
	updateNotecardGroup(cardid,groupid);
	return organizer_store.opId;
}
/*
	function org_checkGroup
	checks the group title validity
	Params: 
		groupTitle - the title to check against.
	returns flash operation id
*/

function org_checkGroup(groupTitle)
{
	++(organizer_store.opId);

	var badlanguage = languagechecker(groupTitle);
	var i = groupStore.length;
	var duplicate = false;
	var title = String(groupTitle).toLowerCase();
	while (--i >= 0 && !duplicate)
	{
		var str = String(groupStore[i]._title).toLowerCase();
		if (str == title)
			duplicate = true;
	}
		
	var returnval = ((badlanguage == 1) ? 1 : (duplicate == true ? 2 : 0));
	var organizerSwf = thisMovie('organizerSwf');
  
	var fn = organizerSwf.onResult
	  if (typeof(fn) != "undefined")
		organizerSwf.onResult(organizer_store.opId, returnval);
	
	return organizer_store.opId;
}

/*
	function org_addGroup
	adds a group to the notecard
	Params: 
		groupTitle - the title to be sent to the note card.
	returns flash operation id
*/
// Called by the organizer to add a new group
// Return the operation id here.
// Return the new group id (now or later) by calling: organizerSwf.onResult(opId, newGroupId);
function org_addGroup(groupTitle)
{
	++(organizer_store.opId);

	organizer_store.pendingGroupId = organizer_store.opId;

	addOrgGroup(groupTitle);

	return organizer_store.opId;
}
/*
	function org_deleteGroup
	Called by the organizer to delete the group.
	Params: 
		groupId - the id of the group to be deleted.
	returns flash operation id
*/
// Called by the organizer to delete a group
// Return the operation id.
// Response not really required.
function org_deleteGroup(groupId)
{
	++(organizer_store.opId);
	//TODO
	removeGroup(groupId);

	return organizer_store.opId;
}

/*
	function setOrganizerNoteTitle
	changes the note card title in the note organizer flash
	Params: 
		noteId - the note card to change the title of
		newTitle - the new title of the note card
	returns nothing
*/
// Tell the organizer to change the title of a note
function setOrganizerNoteTitle(noteId, newTitle)
{
  var organizerSwf = thisMovie('organizerSwf');
  
  var fn = organizerSwf.setNoteTitle
  if (typeof(fn) != "undefined")
    organizerSwf.setNoteTitle(noteId, newTitle);
}

/*
	function setOrganizerNotegroup
	sets the group of the specified notecard
	Params: 
		noteId - the notecard tto change the group of
		groupId - the group to change the notecard to.
	returns nothing
*/
// Tell the organizer to change the group of a note
// Use "-1" for uncategorized.
function setOrganizerNoteGroup(noteId, groupId)
{
  var organizerSwf = thisMovie('organizerSwf');
  var fn = organizerSwf.setNoteGroup;
  if (typeof(fn) != "undefined")
    organizerSwf.setNoteGroup(noteId, groupId);
}
/*
	function addOrganizerNote
	adds the new note to the note organizer
	Params: 
		noteId - the id of the new note card
		title - the title of the new note card
		groupId - the group id of the new note card.
	returns nothing
*/
function addOrganizerNote(noteId, title, groupId)
{
	var organizerSwf = thisMovie('organizerSwf');
	var fn = organizerSwf.addNote;
	if (typeof(fn) != "undefined")
	  organizerSwf.addNote(noteId, title, groupId);
}
/*
	function addOrganizerGroup
	adds a new group to the note organizer
	Params: 
		groupId - the id of the new group to be added.
		title - the title of the new group to be added.
	returns nothing
*/
function addOrganizerGroup(groupId, title)
{
	var organizerSwf = thisMovie('organizerSwf');
	var fn = organizerSwf.addGroup;
	if (typeof(fn) != "undefined")
	  organizerSwf.addGroup(groupId, title);
}
/*
	function deleteOrganizerNote
	deletes a note from the note organizer
	Params: 
		noteId - the id of the note to be deleted
	returns nothing
*/
function deleteOrganizerNote(noteId)
{
	var organizerSwf = thisMovie('organizerSwf');
	var fn = organizerSwf.deleteNote;
	if (typeof(fn) != "undefined")
	  organizerSwf.deleteNote(noteId);
}
/*
	function setOrganizerGroupId
	??
	Params: 
		opId - the flash operation id
		groupId - the id of the new group to be added.
	returns nothing
*/
function setOrganizerGroupId(opId, groupId)
{
	
	var organizerSwf = thisMovie('organizerSwf');
  	var fn = organizerSwf.onResult
	  if (typeof(fn) != "undefined")
		organizerSwf.onResult(opId, groupId);
}

/*
	function refreshOrganizer
	refreshes the note organizer flash on assignment change.
	Params: none
	returns nothing
*/
function refreshOrganizer()
{
	var organizerSwf = thisMovie('organizerSwf');
  	var fn = organizerSwf.refresh;
	  if (typeof(fn) != "undefined")
		organizerSwf.refresh();
}