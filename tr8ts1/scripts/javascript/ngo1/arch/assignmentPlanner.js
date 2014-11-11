/** 
	@file: assignmentPlanner.js
	@description: The file that holds all of the flash to javascript calls

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page

	assignmentPlanner variables:
	
	assignment = the assignment object
	tasklist   = the task list object
	tasktypelist = the task type list object
	taskid = the task id
	assignmentid = the assignment id
	finaldraftformatlist = the final draft format list object
	citationsourcetypelist = the citation source type list object
	citationtypelist = the citation type list object
	finaldraftmodellist = the final draft modal list object
	taskskillbuilderlist = the task skill builder list object
	aid = the assignment id for the flash
	plannerMovie = the assignment planner flash
	insertcheck = the message if the insert failed
	

*/


var assignment = Object();
var tasklist   = Object();
var tasktypelist = Object();
var taskid = '';
var assignmentid = '';
var finaldraftformatlist = Object();
var citationsourcetypelist = Object();
var citationtypelist = Object();
var finaldraftmodellist = Object();
var taskskillbuilderlist = Object();
var aid = '';
var plannerMovie = thisMovie('plannerSwf');

var insertcheck = "Insert Failed";
/*
	function thisMovie
	gets the flash movie from the page
	Params: 
		movieName - the name of the movie to look for
	returns the movie object
*/
// Creates the SWF movie for the Assignment Planner
function thisMovie(movieName) {
	if (navigator.appName.indexOf("Microsoft") != -1) {
		return window[movieName];
	} else{
		if(typeof(document[movieName]) != 'undefined' && typeof(document[movieName].length) != 'undefined'){
			return document[movieName][1];
		}
		return document[movieName];
	}
}


/*
	function openSkillBuilder
	Opens the Skill Builder popup based on the skill builder ID passed into the function 
	Params: 
		id - the skill builder ID
	returns false
*/
function openSkillBuilder(id) {
	showAssetWindow('/skillbuilder?id='+id, 775, 480);
	return false;
}

/*
	function setAssignmentPopupTitle
	Sets the title in the Assignment Planner popup	
	Params: 
		str - the title
	returns nothing
*/
function setAssignmentPopupTitle(str) {
	$('#newAssignment').find('#newAssignmentTitle').html(str);
}

/*
	function printAssignmnet
	prints the assignment planner.	
	Params: none
	returns nothing
*/
function printAssignment() {
	thisMovie('plannerSwf').printAssignment();
}

var apEmbedded = false; // boolean to test if the SWF is currently embedded
var aidChanged = false;	// boolean to test if the assignment id has changed (such as when selected a different assignment in the workzone)


/*
	function notifyAssignmentPlanner
	Tell the assignment planner that there's new data
	Params:
		methodName - the name of the method to be passed to the assignment planner
	returns nothing
	
*/
function notifyAssignmentPlanner(methodName) {
	if (typeof(plannerMovie) != 'undefined' && plannerMovie != null) {	
		var fn = plannerMovie.onResult;
		
		if (fn != undefined) {
			plannerMovie.onResult(methodName);
		}
	}
}


/*
	function openCurrentAssignment
	Opens the current assignment in the Assignment Planner 
	Params: none
	returns nothing
*/
function openCurrentAssignment() {
	addTool('assignmentPlanner');	// Dynamically add "assignmentPlanner" to the tools array.
	addTool('assignmentPlannerfix');
  	// Remove the old swf in case it has a different assignment id.
  	if (aidChanged)
  		swfobject.removeSWF('plannerSwf');
  	so_f.a = currassgn;
  	so_f.p = profileid;
  	aidChanged = false;
  	$(function() {
  		$('#newAssignment').popup({doAfter: modifyAssignmentPopupClose, blockClosing: true}); // Pop up the assignment planner
		if ($.browser.mozilla) {
			$('.modalOutline').css('z-index',1);
		}
  	});
}

/* 
	function setCurrentAssignment
	When the user switches assignments, update the variables used by the Assignment Planner to tell it so
	(note: we may not be using this anymore - NP)
	Params:
		id - the current assignment id
		title - the title of the current assignment
		due - the date due of the current assignemnt
*/
function setCurrentAssignment(id, title, due) {
 	aid = id;
  	aidChanged = true;
}

/*
	function precloseAssignmentPopup
	Cleanup code to run before closing the assignment planner popup
	Params: none
	returns false
*/
function precloseAssignmentPopup() {
	var fn = plannerMovie.externalClose;
	if (fn != undefined)
		plannerMovie.externalClose();
	else
		closeAssignmentPopup();
	return false;
}

/*
	function modifyAssignmentPopupClose
	allows the assignment planner to close the popup a special way.
	Params: 
		popupObj - the popup that the assignment planner is in.
	returns nothing
*/

function modifyAssignmentPopupClose(popupObj) {
	//get the X button on the popup and make it access the flash
	popupObj.find('.popupClose').unbind('click').bind("click", function(e) {precloseAssignmentPopup();});
	var oldPlanner = $('#plannerSwf');
	var apEmbedded;
	//if there is an old assignment planner rebuild the assignment planner
  	if ((oldPlanner.length == 0) && ($('#planner').length == 0)) {	
    	var plannerDiv = document.createElement("div");
    	plannerDiv.id = "planner";
    	$('.mainArea').append(plannerDiv);
   	 	apEmbedded = false;
  	}
	//if the assignment planner has not been embedded then add the flash
  	if (!apEmbedded) {	
		swfobject.embedSWF("/flash/assignmentplanner/bin-release/Main.swf", "planner", "725", "485", "9.0.0", "/flash/expressInstall.swf", so_f, so_p, so_a);
    	apEmbedded = true;
		plannerMovie = thisMovie('plannerSwf');
  	}
	var tmp2 = new Object();
	$.grep(json_assignmentlist,function(n,i) {
		if (currassgn == n._assignmentid) {
			tmp2 = n;	
		}
	});	
	getassignment_actions(tmp2,true);
 }

/*
	function closeAssignmentPopup
	closes the assignment popup from the assignment planner
	Params: none
	returns nothing
*/
function closeAssignmentPopup(cancel) {
	//check if the cancel or X button
	if (typeof(cancel) == 'undefined'){
		var cancel = false;
	}	
	if ($.browser.safari)
		setTimeout("removePopup("+cancel+")", 50);
	else
		removePopup(cancel);
}

/*
	function removePopup
	closes the popup
	Params: none		
	returns nothing
*/
function removePopup(cancel) {
	//check if the cancel or X button
	if (typeof(cancel) == 'undefined'){
		var cancel = false;
	}
	$(function() {
		// SWF doesnt re-initialize correctly on ie6, crashes on firefox 2.
		if (($.browser.msie) || ($.browser.mozilla)) {
			swfobject.removeSWF('plannerSwf');
		}
		
		$('#newAssignment').popupClose();
	});
	plannerMovie = null;
	//setTimeout("removeTool('assignmentPlanner')",3000);
	if (cancel == false) {
		gettasklist(true);
		getassignmentstats(true);
	} else {
		if (taskadd == true) {
			gettasklist(true);
			taskadd = false;
		}
	}
}

/*
	function createnewassignment
	Called when the user is creating a new assignment
	Params: none
	returns nothing
*/
function createnewassignment() {

	addTool('assignmentPlanner');	// dynamically add 'assignmentPlanner' to the tools array (see: ../pagemanager.js)
	addTool('assignmentPlannerfix');
	if (window.location.pathname == '/mywork') {
		// dynamically add 'mywork_assignment_list_ajax' to the tools array IF the user is on the /mywork page
		// we do this in order to reload the new assignment data via AJAX, because on first visit, the data is loaded via PHP
		addTool('mywork_assignment_list_ajax'); 
	}
	
	swfobject.removeSWF('plannerSwf');
	
	so_f.a = -1; // -1 means it's a new assignment
	so_f.p = profileid;
	$(function() {
		$('#newAssignment').popup({doAfter:modifyAssignmentPopupClose, blockClosing:true});
		if ($.browser.mozilla) {
			$('.modalOutline').css('z-index',1);
		}
	});
	aidChanged = true;	
}



/*
	The getter and setter functions below are used by the Assignment Planner flash object.
	For each service call (getassignment, insertassignment etc) initiated by the assignment planner flash,
	the operation is executed and each corresponding 'set' function is called when the operation is complete.

	This notifies the assignment planner flash object that the data is ready to be retrieved.
	The assignment planner flash object then calls the corresponding 'get' function to retrieve the data.
	
	The service calls are queued so that only one operation is performed at a time so that data is never
	overwritten before the assignment planner flash picks it up.
*/

setAssignmentForPlanner = function(json_assignment) {
	assignment = json_assignment;
	notifyAssignmentPlanner('getassignment');
}

getAssignmentForPlanner = function() {
	return assignment;
}

setAssignmentIdForPlanner = function(data) {
	assignmentid = data;
	updateassignmentid(data);
	notifyAssignmentPlanner('insertassignment');
}

getAssignmentIdForPlanner = function() {
	return assignmentid;
}

setTaskListForPlanner = function(json_tasklist) {
	tasklist = json_tasklist;
	notifyAssignmentPlanner('gettasklist');
}

getTaskListForPlanner = function() {	
	return tasklist;
}

setTaskIdForPlanner = function(data) {
	taskid = data;
	notifyAssignmentPlanner('inserttask');
}

getTaskIdForPlanner = function() {
	return taskid;
}

setFinalDraftFormatListForPlanner = function(json_supportdata) {
	finaldraftformatlist = json_supportdata;
	notifyAssignmentPlanner('getfinaldraftformatlist');
}

getFinalDraftFormatListForPlanner = function() {
	return finaldraftformatlist;
}

setCitationSourceTypeListForPlanner = function(json_supportdata) {
	citationsourcetypelist = json_supportdata;
	notifyAssignmentPlanner('getcitationsourcetypelist');
}

getCitationSourceTypeListForPlanner = function() {
	return citationsourcetypelist;
}

setCitationTypeListForPlanner = function(json_supportdata) {
	citationtypelist = json_supportdata;
	notifyAssignmentPlanner('getcitationtypelist');
}

getCitationTypeListForPlanner = function() {
	return citationtypelist;
}

setFinalDraftModelListForPlanner = function(json_supportdata) {
	finaldraftmodellist = json_supportdata;
	notifyAssignmentPlanner('getfinaldraftmodellist');
}

getFinalDraftModelListForPlanner = function() {
	return finaldraftmodellist;
}

getTaskTypeListForPlanner = function() {
	return tasktypelist;
}

setTaskTypeListForPlanner = function(json_tasktypelist) {
	tasktypelist = json_tasktypelist;
	notifyAssignmentPlanner('gettasktypelist');
}

setTaskSkillBuilderListForPlanner = function(json_taskskillbuilderlist) {
	taskskillbuilderlist = json_taskskillbuilderlist;
	notifyAssignmentPlanner('gettaskskillbuilderlist');
}

getTaskSkillBuilderListForPlanner = function() {
	return taskskillbuilderlist;
}

/*
	End assignment planner service getters/setters.
*/
