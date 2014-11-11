/** 
	@file: pagemanager.js
	@description: This file is the main gateway between every tool in "Expert Space" and the PHP SOAP client. It exists to facilitate calls to the 
	database and to handle the result of the calls.

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page

	PageManager variables:
	
	toolsArray - array of tools that are on this page
	json_assignmentlist - holds the JSON object for the current list of assignments
	json_assignmentstats - holds the JSON object for the current list of assets per assignment
	json_assignmentstats - holds the JSON object for the current assignment stats
	json_assignment - holds the JSON object for the current assignment
	json_tasklist - holds the JSON object for the current list of tasks
	json_stuffcollected - holds the JSON object for the stuff collected for the current assignment
	json_stuffcollectedcounts - holds the JSON object for the count of stuff collected for the current assignment
	json_rubricanswerlist - holds the JSON object for the list of rubric questions that appear when a user checks off a task in "My Work"
	json_digitallockerfoldertype - holds the JSON object of the type of digital locker folder (aka "My Work")
	cicationsourceidjson - used when inserting/updating an assignment; holds a JSON object that the insert/update SOAP function can accept
	assignment_complete - BOOLEAN value that says whether or not the current assignment is complete
	saved_to - an ARRAY that holds a list of assets and the assignments to which they are saved
	tmpcontexthelp -  the array to hold the contextual helps referenced by toolname-contextualhelpid
	myskillbuildertool - holds the task skill builder list
	mytasktoollist - holds the task tool list

*/

var toolsArray; 
var json_assignmentlist = '';
var json_assignmentassetlist = '';
var json_assignmentstats = '';
var json_assignment = '';
var json_tasklist = '';
var json_stuffcollected = '';
var json_stuffcollectedcounts = '';
var json_rubricanswerlist;
var json_digitallockerfoldertype = '';

var citationsourceidjson = ''

var assignment_complete = false;

var saved_to = [];

var tmpcontexthelp = new Array();
var myskillbuildertool = null;
var mytasktoollist = null;
var taskadd = false;


/**
	@method ajaxRequest
	@params N/A
	@description creates an ajax request object
*/
function ajaxRequest(){
	
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	/* The variable http will hold our new XMLHttpRequest object. */
	var http = request_o; 

	return http; //return the object
	
	
	
}//end function ajaxRequest

/*
	@author Scholastic
	@class PageManager
	@params theToolsArray - the array of tools
	@description manages which tools are active on the current page
*/

function PageManager(theToolsArray) {

	//set the tools that are on this page
	this.setToolsArray = function(theToolsArray) {
	
		toolsArray = theToolsArray;
	
	}//end function	
	
	//get the tools that are on this page.
	this.getToolsArray = function() {
	
		return toolsArray;
	
	}//end function	

}//end function


/* 
	@author Nate Prouty
	@method addTool
	@params toolname - the name of the tool to add to the tools array
	@description - used to dynamically add a new tool to the current toolsArray
	@result adds a new item to the tool's array IF it's not already there
*/
addTool = function(toolname) {

	// Create a PageManager if one does not yet exist
	if (typeof(pageManager) == 'undefined') {
		var toolsArray = new Array();
		var pageManager = new PageManager(toolsArray);
	}

	var currentTools = pageManager.getToolsArray();
	
	if (currentTools.indexOf(toolname) == -1) {
		currentTools.push(toolname);
		pageManager.setToolsArray(currentTools);
	}	
} // end function

/* 
	@author Nate Prouty
	@method removeTool
	@params toolname - the name of the tool to remove from the tools array
	@description - used to dynamically remove a tool from the current toolsArray
	@result removes a new item from the tool's array IF it's there
*/
removeTool = function(toolname) {

	var currentTools = pageManager.getToolsArray();
	var index = currentTools.indexOf(toolname);
	
	if (index != -1) {
		currentTools.splice(index);
		pageManager.setToolsArray(currentTools);
	}
}

/*
	@author Jeff Landry
	@method checkIfInAssignmentList
	@params assignmentid - The ID of the assignment to check
	@description - checks to see if the assignmentid is in the current list of assignments
	@result - returns true if the assignment is in the assignment list, otherwise false
*/
function checkIfInAssignmentList(assignmentid) {
	var tmpbool = false;
	// loop through the assignment list and test if its ID matches the assignmentid
	$.each(json_assignmentlist,function(i,val) {
		if (val._assignmentid != assignmentid) {
			return true;
		} else {
			tmpbool = true;
			return false;
		}
										
	});
	return tmpbool;
}

/*
	@author Nate Prouty
	@method checkIfAssignmentComplete
	@params assignid - The ID of the assignment to check
	@description - used as a way to quickly check to see if an assignment is complete, 
				   based on whether task is an assignment AND its completion date is not NULL
	@result - sets assignmentComplete to true if it's complete ("_completiondate" is not null), false otherwise
*/
function checkIfAssignmentComplete(assignid) {

	if (typeof(assignid) == 'undefined') {
		var assignid = currassgn;
	}
		
	var submitrequesturl = "action=gettaskbytype&assignmentid=" + assignid + "&tasktype=1";
	
	$(function() {
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			
			success: function(json_assignmenttask) {
				// on success: set the assignmentComplete boolean to TRUE/FALSE 
				if (json_assignmenttask._completiondate != null) {
					assignmentComplete = true;
				}
				else {
					assignmentComplete = false;
				}
			}
		})
	})
}



/* 
	@author Nate Prouty
	@method getassignmentstats_actions
	@params json_assignmentstats - the JSON object of the assignment stats
	@description - takes the result of getassignmentstats() and loops through the tools array, passing the result to functions that exist in their indicated 	locations (e.g., workzone functions exist in workzone.js)
	@result - depends on the current tools that are in the tools array
			once complete, the workzone loading bar is stopped (by Jeff Landry)
*/
function getassignmentstats_actions(json_assignmentstats) {
	for (k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in workzone.js
				updateUserStats(json_assignmentstats);	// update the user's stats
				break;
			case 'mywork_assignment_list_ajax':
				// in mywork_assignment_list.js
				createAssignmentList(json_assignmentlist);	// create the list of assignments (folders) on the /mywork page
				break;				
			default:
				break;
		}
	}
	$('#workzoneSubsectInner').stopLoader({loaderid:'workzoneLoading',fadeIn:true,fadeIntime:200}); // when the stats are done loading, stop the loading bar
}

/* 
	@author Nate Prouty & Jeff Landry (workzone loading message)
	@method getassignmentstats
	@params force - (optional) tells the function whether or not to force getting information from the SOAP client
	@description - gets the assignment stats for the current assignment
	@result - passes the result onto getassignmentstats_actions
*/
function getassignmentstats(force) {
	$('#workzoneSubsectInner').startLoader({loaderid:'workzoneLoading',fadeIn:true,fadeIntime:200,pause:200}); 
	// show the loading message while the stats are being retrieved
	
	// immediately stop the loader if the user is not signed in, as there are no stats to load
	if (profileid == null) {
		$('#workzoneSubsectInner').stopLoader({loaderid:'workzoneLoading',fadeIn:true,fadeIntime:200});
		return;
	}
	
	// default the variable force to "false"
	if (typeof(force) == 'undefined') {
		var force = false;
	}

	// if the json_assignmentstats are not undefined AND json_assignmentstats are not empty AND force is false, just call 
	// getassignmentstats_actions on the current json_assignmentstats object.
	if ((typeof(json_assignmentstats) != 'undefined') && (json_assignmentstats != '') && (!force)) {
		getassignmentstats_actions(json_assignmentstats);
	}

	// if the above IF statement is FALSE:
	else {
		var submitrequesturl = "action=getassignmentstats&assignmentid=" + currassgn;
		
		$(function() {			
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/assignmentajax.php", // the PHP file that holds the function we're calling
				data: submitrequesturl, // the data to pass to the call, including the function name
				dataType: "json", // the data type we're expecting to get back from the call
				success: function(json) { // json: the object returned, success: what to do upon a successful AJAX call
					json_assignmentstats = json; // set the json_assignmentstats object to the return json object
					getassignmentstats_actions(json); // carry out the actions on the returned json object
				}		
			});
		});
	}
}


/* End getassignmentstats functions */

/* Start getassignmentlist functions */

/* 
	@author Nate Prouty
	@method getassignmentlist_actions
	@params json_assignmentlist - the JSON object of the assignment list
	@description - takes the result of getassignmentlist() and loops through the tools array, passing the result to functions that exist in their indicated 	locations (e.g., workzone functions exist in workzone.js)
	@result - depends on tools that are in the tools array
*/

function getassignmentlist_actions(json_assignmentlist) {

	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'workzone':
				// in workzone.js
				createAssignmentDropDown(json_assignmentlist);	// builds the assignment-switching select box in the workzone
				setAssignmentDetails(json_assignmentlist); // sets the assignment title and due date in the workzone
				break;
			case 'mywork_assignment_list_ajax':
				// in mywork_assignment_list.js
				createAssignmentList(json_assignmentlist); // create the list of assignments (folders) on the /mywork page
				break;
			case 'mywork_assignment_detail': 
				// in mywork_assignment_detail.js
				loadAssignmentList(json_assignmentlist); // adds the assignments to the dropdown on the list view of the /assignment page
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				loadAssignmentList(json_assignmentlist); // adds the assignments to the dropdown on the /assets page
				break;
			default:
				break;
		}
				
	}		
}

/* 
	@author Nate Prouty & Jeff Landry (workzone loading message)
	@method getassignmentlist
	@params:
		 productid - the ID of the product to which the assignment belongs
		 active - whether or not to retrieve active assignments
		 sort - how the returned result should be sorted
		 force - (optional) tells the function whether or not to force getting information from the SOAP client
		 
	@description - gets the list of assignments that meet the criteria of the passed parameters
	@result passes the result onto getassignmentlist_actions
*/
function getassignmentlist(productid, active, sort, force){

	if (typeof(force) == 'undefined') {
		var force = false;
	}
	
	// If the json_assignmentlist object is not undefined AND the json_assignmentlist object is not empty AND force is FALSE:
	if ((typeof(json_assignmentlist) != 'undefined') && (json_assignmentlist != '') && !(force)) {
		getassignmentlist_actions(json_assignmentlist);
	}
	
	// IF the above IF statement is FALSE:
	else {
	
		var productid = 'xs';	// assignments are "Expert Space" products, indicated by "xs"
		var submitrequesturl = "action=getassignmentlist&productid="+productid+"&active="+active+"&sort="+sort;

		$(function() {	
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/assignmentajax.php", // the PHP file that holds the function this request is calling
				data: submitrequesturl, // the data to pass to the call, including the function name
				dataType: "json", // the expected type of return object
				success: function(json) { // json: the returned json object
					json_assignmentlist = json; // set the json_assignmentlist object to json
					getassignmentlist_actions(json_assignmentlist); // call the actions on json_assignmentlist
				}
				
			});
		});
	}	
}
/* End getassignmentlist functions */

/* Start getassignment functions */

/* 
	@author Nate Prouty / Jeff Landry
	@method getassignment_actions
	@params json_assignment - the JSON object of the assignment
			rebuild - (optional) tells whether you want to rebuild the assignment dropdown
	@description - takes the result of getassignment() and loops through the tools array, passing the result to functions that exist in their indicated 					   locations (e.g., workzone functions exist in workzone.js)
	@result depends on the tools in the tools array
*/
function getassignment_actions(json_assignment,rebuild) {

	// default rebuild to FALSE
	if (typeof(rebuild) == 'undefined') {
		var rebuild = false;
	}
	
	/**
		Test to see if the passed assignment is currently in the list of assignments (json_assignmentlist).
		If it is not, add it to json_assignmentlist
		If it is, loop through the json_assignmentlist to find the location of the assignment in json_assignmentlist and update the assignment
	*/
	if (checkIfInAssignmentList(json_assignment._assignmentid) == false) {
		json_assignmentlist[json_assignmentlist.length] = json_assignment;
	} else {
		$.each(json_assignmentlist,function(i,val) {
			if (val._assignmentid == json_assignment._assignmentid) {
				json_assignmentlist[i] = json_assignment;
				return false;
			} else {
				return true;	
			}
		});
	}
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setAssignmentForPlanner(json_assignment); // tells the Assignment Planner the current assignment
				break;
			case 'assignmentPlannerfix':
				// in assignmentPlanner.js
				setAssignmentForPlanner(json_assignment); // tells the Assignment Planner the current assignment
				break;				
			case 'workzone':
				// in workzone.js
				if (rebuild) {
					createAssignmentDropDown(json_assignmentlist); // build the dropdown in the worzone (if rebuild == TRUE)
				}
				setAssignmentDetails(json_assignmentlist); // sets the assignment title and due date in the workzone
				break;
			case 'mywork_assignment_list_ajax':
				// in mywork_assignment_list.js
				if (rebuild) {
					createAssignmentList(json_assignmentlist); // create the list of assignments (folders) on the /mywork page (if rebuild == TRUE)
				}
				break;
			case 'mywork_assignment_detail': 
				// in mywork_assignment_detail.js
				if (rebuild) {
					loadAssignmentList(json_assignmentlist); // builds the assignments in the dropdown in the list view of /assignment (if rebuild == TRUE)
				}
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				if (rebuild) {
					loadAssignmentList(json_assignmentlist); // builds the assignments in the dropdown on the /assets page (if rebuild == TRUE)
				}
				break;
			case 'bibliography':
				objBibliography.changeCitationStyle();	// changes the visible citation style on the bibliography page 
				break;				
			default:
				break;
		}
	}
}

/** 
	@author Nate Prouty
	@method getassignment
	@params assignmentid - the ID of the assignment to get, 
			force - (optional) tells the function whether or not to force getting information from the SOAP client
			rebuild - (optional) tells whether you want to rebuild the assignment dropdown
	@description - gets the assignment object based on the assignmentid
	@result passes the result onto getassignment_actions
*/
function getassignment(assignmentid, force, rebuild) {

	// default force to FALSE
	if (typeof(force) == 'undefined') {
		var force = false;
	}
	
	// default rebuild to FALSE
	if (typeof(rebuild) == 'undefined') {
		var rebuild = false;
	}

	// If the json_assignment object is not undefined AND json_assignment is not empty AND force is FALSE,
	// call getassignment_actions on the current json_assignment object	
	if ((typeof(json_assignment) != 'undefined') && (json_assignment != '') && !(force)) {
		getassignment_actions(json_assignment);
	}

	// If the above IF statement is FALSE
	else {
		var submitrequesturl = "action=getassignment&assignmentid=" + assignmentid;

		$(function() {			
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/assignmentajax.php", // the file that contains the function that's being called
				data: submitrequesturl, // the data (including function name) to pass to the called file				
				dataType: "json",	// the expected returned data type
				success: function(json) { // json: the result of the PHP call
					json_assignment = json; // set the json_assignment object to the return json object
					getassignment_actions(json,rebuild); // call the actions for getassignment, passing the json object and whether or not to rebuild lists
				}
			});
		});
	}
}
/* End getassignment functions */

/* Start insertassignment functions */


/* 
	@author Nate Prouty
	@method insertassignment_actions
	@params data - the ID of the assignment
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to insertassignment()
	@result - depends on the tools in the tools array
*/
function insertassignment_actions(data) {
	
	// in pagemanager.js
	updateprofilecurrentassignment('xs', data); // update the assignment associated with the current profile
	updateassignmentid(data); // update the assignmentid

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {			
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setAssignmentIdForPlanner(data); // set the assignment id for the Assignment Planner
				break;
			case 'mywork_assignment_list_ajax':
				// in pagemanager.js
				getassignment(currassgn,true,true);	// get the current assignment		
				break;
			default:
				break;
		}
	}

}

/**
	@author Nate Prouty
	@method insertassignment
	@params assignmenttype - the type of assignment (ID)
			title - the assignment title
			productid - the current product ID
			active - is this an active assignment?
			duedate - the date the assignment is due
			status - the status of the assignment
	@description - inserts a new assignment into the database, based on the passed parameters
	@result - passes the result onto insertassignment_actions
*/
function insertassignment(assignmenttype, title, productid, active, duedate, status) {
			
	var submitrequesturl = "action=insertassignment&assignmenttype=" + assignmenttype + "&title=" + title + "&productid=" + productid + "&active=" + active + "&duedate=" + duedate + "&status=" + status;
	
	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/assignmentajax.php", // the file that contains the function that's being called
			data: submitrequesturl, // the data (including function name) passed to the called file
			dataType: "text", // the expected return type
			success: function(data) { // data: the returned data
				insertassignment_actions(data); // actions to performed on the returned data, if data was returned successfully
			}
		});
	});
}

/* End insertassignment functions */

/* Start updateassignment functions */


/**
	@author Nate Prouty
	@method updateassignment_actions
	@params data - the result of the call to updateassignment()
	 	    assignmentid - the assignment on which to perform any of the following functions that require that information
	@description - loops through the toolsArray and calls the given methods
	@result  - depends on the tools in the tools array
*/
function updateassignment_actions(data, assignmentid) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				getassignment(assignmentid, true); // the assignment was updated, so re-get it and rebuild menus
				break;
			// in assignmentPlanner.js
			case 'assignmentPlanner':
				notifyAssignmentPlanner('updateassignment'); // notify the assignment planner that the assignment has been updated
				break;
			// in mywork_assignment_detail.js
			case 'mywork_assignment_detail': // the user is on the /assignment page
				getstuffcollectedcounts(true); // get the count of stuff collected
				getstuffcollected('null', true); // get the stuff collected
				break;				
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updateassignment
	@params assignmentid - the ID of the assignment
			title - the assignment title
			duedate - the date the assignment is due
	@description - updates the given assignment with a new title/duedate
	@result passes the result onto updateassignment_actions
*/
function updateassignment(assignmentid, title, duedate) {
		
	var submitrequesturl = "action=updateassignment&assignmentid=" + assignmentid + "&title=" + title + "&duedate=" + duedate;

	$(function() {		
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/assignmentajax.php", // the PHP file that the contains the function being called
			data: submitrequesturl, // the data (and function name) passed to the called PHP file
			dataType: "text", // the expected return type
			success: function(data) { // data: the result of the call
				updateassignment_actions(data, assignmentid); // on success, perform the necessary actions, based on the current state of the toolsArray
			}
		});
	});
}

/*
	@author Nate Prouty 
	@method updateassignmentid
	@params assignid - the ID of the assignment
	@description - updates the cookies (assignmentid, bibliographyid, outlineid)
	@result updates the cookie ID of the assignment, as well as the bibliography and outline
*/
function updateassignmentid(assignid) {

	// update cookie
	if(assignid > 0) {	// the assignment ID is legitimate
		// update the cookies
		cookiereader.updateSubCookie("currassgn", assignid); // currassgn = assignid
		var submitrequesturl = "action=getassignment&assignmentid=" + assignid;
		$(function() {		
			$.ajax({
				type: "POST", // the type of request
				url: "/arch/assignmentajax.php", // the PHP file that the contains the function being called
				data: submitrequesturl, // the data (and function name) passed to the called PHP file
				dataType: "json", // the expected return type
				success: function(data) { // data: the result of the call
					// re-store the cookie values from the cookiereader	
					bibliographyid = data._bibliographyid;
					outlineid = data._outlineid;					
					cookiereader.updateSubCookie("bibliographyid", bibliographyid); // bibliographyid
					cookiereader.updateSubCookie("outlineid", outlineid); // outlineid								
					// Used for the Assignment Planner (Flash), indicating that the assignment ID has changed	
				}
			});
		});
}
	currassgn = assignid;
	aid = currassgn;
	aidChanged = true;
	return true;
}


/* End updateassignmentid functions */


/* Start updateprofilecurrentassignment functions */

/* 
	@author Nate Prouty
	@method updateprofilecurrentassignment_actions
	@params data - the result of the call to updateprofilecurrentassignment()
			assignmentids - the ID of the assignment on which to perform the following methods (when the ID is required)
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updateprofilecurrentassignment()
	@result - depends on the tools in the tools array
*/
function updateprofilecurrentassignment_actions(data, assignmentids) {
	assignment_id = assignmentid = assignmentids;
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in pagemanager.js
				getassignmentstats(true); // get the stats of the current assignment
				//if (toolsArray.indexOf('assignmentPlanner') == -1) { 
					setAssignmentDetails(json_assignmentlist); // set the details of the assignment, if "assignmentPlanner" is not in the toolsArray
			//	}
				setCurrentAssignment(assignmentid);
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				getassignment(assignmentids,true, true);	// get the current assignment object			
				setAssignmentIdForPlanner(assignmentids); // used for the Assignment Planner; set the current assignment id
				break;
			case 'assignmentPlannerfix':
				setAssignmentIdForPlanner(assignmentids);
				$.each(json_assignmentlist,function(i,obj){
					if (obj._assignmentid == assignmentids) {
						getassignment_actions(obj,true);
					}
				});
				break;
			case 'mywork_assignment_ajax':
				if (s == 1) { // s: indicates that the change came from a "click" and not the selectitem function
					updateassignmentinfo(assignmentids); // updates the assignment id's
					s = null;
				}
			case 'mywork_assignment_detail':
				// in mywork_assignment_detail.js
				gettasklist(true); // get the task list for the current assignment
				getstuffcollected('null', true); // get the stuff collected for the current assignment
				getstuffcollectedcounts(true); // get the count of stuff collected for the current assignment
				getnotecardcount(); // get the count of note cards for the current assignment
				getcitationcount(); // get the count of citations for the current assignment
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				gettasklist(true); // get the task list for the current assignment
				var type = $.getURLParam("type"); // get the proper type of asset to load from the _GET parameter
				getstuffcollected(type, true); // get the list of the stuff collected for the current assignment
				break;
			case 'bibliography':
				// in bibliography.js
				updatebibliography(assignmentids); // update the bibliographyid
				if (toolsArray.indexOf('assignmentPlanner') == -1) {					
					objBibliography.changeCitationStyle(); // change the citation style, if the assignmentPlanner is is not in the toolsArray.
				}
				break;
			case 'citation':
				// in pagemanager.js
				getCitationList(); // get the list of citations
				break;
			case 'notecard':
				// in notecard.js
				updatemynotecard(assignmentids); // passes the assignmentid to the current notecard
				if(myNotesVisible)
				{
					//RECORD STAT HIT
					collectStat('notecard','xs','list','');
				}
				break;
			case 'outline':
				updateoutline(assignmentids); // update the outlineid (in outline.js)
				getajaxoutline(assignmentids); // get the outline for the current assignment (in pagemanager.js)
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updateprofilecurrentassignment
	@params productid - the ID of the current product
			assignmentid - the ID of the assignment
	@description - calls the SOAP method responsible for informing the system which assignment is currently being viewed by the user
	@result passes the result onto updateprofilecurrentassignment_actions
*/

function updateprofilecurrentassignment(productid,assignmentid) {
	var submitrequesturl = "action=updateprofilecurrentassignment&productid=" + productid + "&assignmentid=" + assignmentid;

	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/assignmentajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file
			dataType: "text", // the expected type of data returned
			success: function(data) {
				updateprofilecurrentassignment_actions(data,assignmentid);	// call the function to perform any necessary actions on the result
			},
			error: function(a,b,c) { // if there's an error, set a delay and try again
				setTimeout('updateprofilecurrentassignment('+productid+','+assignmentid+')',250);
			}
		});
	});
}
/* End updateprofilecurrentassignment functions */



/* Start insertassignmentdetails functions */

/* 
	@author Nate Prouty
	@method insertassignmentdetails_actions
	@params data - the result of the call to insertassignmentdetails()
			assignmentid - the ID of the assignment on which to perform the following methods
	@description - loop through the toolsArray and perform the necessary actions, using the returned data and assignmentid
	@result depends on the tools in the tools array
*/
function insertassignmentdetails_actions(data, assignmentid) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in pagemanager.js
				getassignment(assignmentid, true); // get the current assignment
				getassignmentstats(true); // get the stats of the current assignment
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				notifyAssignmentPlanner('insertassignmentdetails'); // let the Assignment Planner know the details of an assignment have changed
				break;
			case 'mywork_assignment_detail':
				// in pagemanager.js
				getstuffcollectedcounts(); // get the count of the stuff collected
				getstuffcollected('null', true); // get the stuff collected
				break;
			case 'mywork_assets':
				var type = $.getURLParam("type"); // in srm_utils.js; we're on the /assets page; type: the type parameter in the URL
				getstuffcollected(type, true); // in pagemanager.js; get the stuff collected
				break;
			case 'bibliography':
				// in bibliography.js
				objBibliography.changeCitationStyle(); // change the citation style
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method insertassignmentdetails
	@params	assignmentid - the ID of the assignment
			paraphrase - the paraphrase entered by the user when creating an assignment 
			finaldraftformatid - the ID of the final draft format selected by the user
			lengthoffinaldraft - the value of the length of the final draft, entered by the user 
			numofsources - the count of required sources, entered by the user
			citationtypeid - the type of citation required, selected by the user
			citationsourceidarray - the array of citation source ids
			ALL RETRIEVED FROM ASSIGNMENT PLANNER FLASH
	@description - inserts the details of a new assignment into the database
	@result passes the result onto insertassignmentdetails_actions
*/
function insertassignmentdetails(assignmentid, paraphrase, finaldraftformatid, lengthoffinaldraft, numofsources, citationtypeid, citationsourceidarray, 
othercitationsource) {	

	citationsourceidjson = citationsourceidarray.join(",");
	// the Assignment Planner creates a citationsourceidarray Array, but the SOAP client expects a comma-separated list, not an array.

	var submitrequesturl = "action=insertassignmentdetails&assignmentid=" + assignmentid + "&paraphrase=" + paraphrase + "&finaldraftformatid=" + finaldraftformatid + "&lengthoffinaldraft=" + lengthoffinaldraft + "&numofsources=" + numofsources + "&citationtypeid=" + citationtypeid + "&citationsourceidjson=" + citationsourceidjson + "&othercitationsource=" + othercitationsource;

	$(function() {	
		$.ajax({
			type: "POST", // the type of request 
			url: "/arch/assignmentajax.php", // the file that contains the PHP function to be called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				insertassignmentdetails_actions(data, assignmentid); 
				// on success, perform the necessary actions, based on the current state of the toolsArray
			}
		});
	});
}


/* End insertassignmentdetails functions */

/* Start updateassignmentdetails functions */


/* 
	@author Nate Prouty
	@method updateassignmentdetails_actions
	@params data - the result of the call to updateassignmentdetails()
			assignmentid - the assignmentid on which to perform the following actions (when it's required)
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updateassignmentdetails()
	@result depends on the tools in the tools array
*/
function updateassignmentdetails_actions(data, assignmentid) {
		
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in pagemanager.js
				getassignment(assignmentid, true); // get the assignment of the passed assignmentid
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				notifyAssignmentPlanner('updateassignmentdetails'); // inform the Assignment Planner of the updated assignment details
				break;
			case 'mywork_assignment_detail':
				// in pagemanager.js
				getstuffcollectedcounts(); // get the count of stuff collected
				getstuffcollected('null', true); // get the stuff collected
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updateassignmentdetails
	@params assignmentid - the ID of the assignment
			paraphrase - the paraphrase entered by the user when updating an assignment
			finaldraftformatid - the ID of the final draft format selected by the user
			numofsources - the required number of sources, entered by the user
			citationtypeid - the ID of the citation type, selected by the user
			citationsourceidarray - the array of citation source IDs
			ALL RETRIEVED FROM ASSIGNMENT PLANNER FLASH
	@description - updates the details of a given assignment, using the results entered by the user in the Assignment Planner
	@result - passes the result onto updateassignmentdetails_actions
*/
function updateassignmentdetails(assignmentid, paraphrase, finaldraftformatid, lengthoffinaldraft, numofsources, citationtypeid, citationsourceidarray, 
othercitationsource) {	

	citationsourceidjson = citationsourceidarray.join(",");

	var submitrequesturl = "action=updateassignmentdetails&assignmentid=" + assignmentid + "&paraphrase=" + paraphrase + "&finaldraftformatid=" + finaldraftformatid + "&lengthoffinaldraft=" + lengthoffinaldraft + "&numofsources=" + numofsources + "&citationtypeid=" + citationtypeid + "&citationsourceidjson=" + citationsourceidjson + "&othercitationsource=" + othercitationsource;

	$(function() {		
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/assignmentajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				updateassignmentdetails_actions(data, assignmentid);
				// on success, perform the necessary actions, based on the current state of the toolsArray

			}
		});
	});
}


/* End updateassignmentdetails functions */


/* Start deleteassignment functions */

/* 
	@author Nate Prouty
	@method deleteassignment_actions
	@params data - the result of the call to deleteassignment()
			assignmentid - the id of the assignment on which to perform the following methods (when it's needed)
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to deleteassignment()
	@result - depends on the tools in the tools array
*/
function deleteassignment_actions(data, assignmentid) {
	// update the json_assignmentlist object so that it does not contain the deleted assignment
	json_assignmentlist = $.grep(json_assignmentlist,function(val,i) {
		return (val._assignmentid != assignmentid);
	});
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'mywork_assignment_list_ajax':
				// in pagemanager.js
				getassignment(currassgn,true); // get the current assignment list
				getassignmentstats(true); // get that stats of the current assignment
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updateassignmentdetails
	@params assignmentid - the ID of the assignment
	@description - calls the SOAP function to delete the given assignment
	@result - deletes the assignment, passing the result onto deleteassignment_actions
*/

function deleteassignment(assignmentid) {

	var submitrequesturl = "action=deleteassignment&assignmentid=" + assignmentid;

	$.ajax({
		type: "POST", // the type of request
		url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
		data: submitrequesturl, // the data (and function) passed to the called PHP file 
		dataType: "text", // the expected type of data returned
		success: function(data) {
			deleteassignment_actions(data, assignmentid);
			// on success, perform the necessary actions, based on the current state of the toolsArray

		}
	});
}

/* 
	@author Nate Prouty
	@method removeAssignment
	@params assignmentid - the ID of the assignment
			name - the name of the assignment
	@description - shows a message to the user confirming that they want to delete as assignment
	@result confirmation message to the user for deleting an assignment
*/

function removeAssignment(assignmentid, name) {

	$(function() {	
		warning({
			title:'Message',
			msg: 'Are you sure you want to delete the assignment "' + name + '"?',	
			noAction: function(){
				
			},
			yesAction: function(){
				//RECORD STAT HIT
				collectStat('dlock','xs','save','');
				deleteassignment(assignmentid);	
			},
			cancelAction: function(){	
				
			}
		});
	});
}


/* End deleteassignment functions */


/* Start gettasklist functions */

/* 
	@author Nate Prouty
	@method gettasklist_actions
	@params json_tasklist - the JSON object of the list of tasks
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to gettasklist()
	@result - depends on the tools in the tools array
*/
function gettasklist_actions(json_tasklist) {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				// in mywork_assignment_detail.js
				displayTaskList(json_tasklist); // print out the list of tasks
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				displayTaskList(json_tasklist); // print out the list of tasks
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setTaskListForPlanner(json_tasklist); // set the list of tasks for the Assignment Planner
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method gettasklist
	@params force (optional) - whether or not to force retrieval from the SOAP client
	@description - gets the task list for the current assignment
	@result gets the list of tasks for the current assignment, passing the result onto gettasklist_actions
*/
function gettasklist(force) {

	if (typeof(force) == 'undefined') {
		var force = false;
	}

	// If the json_tasklist object exists, use it. Otherwise, create it.	
	if ((typeof(json_tasklist) != 'undefined') && (json_tasklist != '') && (!force)) {
		gettasklist_actions(json_tasklist);
	}
	else {	
		var submitrequesturl = "action=gettasklist&assignmentid=" + currassgn + "&sort=duedate";
		
		$(function() {		
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/taskajax.php", // the file that contains the PHP function being called
				data: submitrequesturl, // the data (and function) passed to the called PHP file 
				dataType: "json", // the expected type of data returned
				success: function(json) {
					// on success, perform the necessary actions, based on the current state of the toolsArray
					json_tasklist = json;
					gettasklist_actions(json);
				}
			});
		});
	}
}
/* End gettasklist functions */


/* Start inserttask functions */


/* 
	@author Nate Prouty
	@method inserttask_actions
	@params data - the result of the call to inserttask(), which is the new task id
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to inserttask()
	@result - depends on the tools in the tools array
*/
function inserttask_actions(data) {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in pagemanager.js
				getassignmentstats(true); // get the stats of the current assignment
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setTaskIdForPlanner(data); // sets the task id for the assignment planner
				taskadd = true;
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method inserttask
	@params assignmentid - the ID of the assignment
			tasktype - the type of task
			duedate - the date the task is due
			customdescription - the user-generated description of the task
	@description - inserts a task to an assignment and passes the result onto inserttask_actions
	@result - a new task is inserted into the database
	@details PASS 'NULL' FOR ANY EMPTY VALUE
*/
function inserttask(assignmentid, tasktype, duedate, customdescription) {
	
	var submitrequesturl = "action=inserttask&assignmentid=" + assignmentid + "&tasktype=" + tasktype + "&duedate=" + duedate + "&customdescription=" + customdescription;
		
	$(function() {			
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
			// on success, perform the necessary actions, based on the current state of the toolsArray
				inserttask_actions(data);
			}
		});
	});
}
/* End inserttask functions */

/* Start updatetaskduedate functions */

/* 
	@author Nate Prouty
	@method updatetaskduedate_actions
	@params data - the result of the call to updatetaskduedate
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updatetaskduedate()
	@result - depends on the tools in the tools array
*/
function updatetaskduedate_actions(data) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in pagemanager.js
				getassignmentstats(true); // get the stats for the current assignment
				break;			
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				notifyAssignmentPlanner('updatetaskduedate'); // notifies the Assignment Planner of the update task due date
				taskadd = true;
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updatetaskduedate
	@params taskid - the ID of the task
			duedate - the due date of the task 
	@description - updates the due date of the task and passes the result onto updatetaskduedate_actions
	@result - the task due date is updated in the database
*/
function updatetaskduedate(taskid, duedate) {
	
	var submitrequesturl = "action=updatetaskduedate&taskid=" + taskid + "&duedate=" + duedate;

	$(function() {	
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			datatype: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				updatetaskduedate_actions(data);		
			}
		});
	});
}

/* End updatetaskdescription functions */

/* Start updatetaskdescripton functions */


/* 
	@author Nate Prouty
	@method updatetaskdescription_actions
	@params data - the result of the call to updatetaskdescription
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updatetaskdescription()
	@result - depends on the tools in the tools array
*/
function updatetaskdescription_actions(data) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				notifyAssignmentPlanner('updatetaskdescription'); // notify the Assignment Planner of the updated task description
				taskadd = true;
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updatetaskdescription
	@params taskid - the ID of the task
			customdescription - the user-generated description
	@description - updates the description of the task and passes the result onto updatetaskdescription_actions 
	@result - the task description of the given task is updated 
*/
function updatetaskdescription(taskid, customdescription) {
	
	var submitrequesturl = "action=updatetaskdescription&taskid=" + taskid + "&customdescription=" + customdescription;

	$(function() {	
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			datatype: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				updatetaskdescription_actions(data);		
			}
		});
	});
}

/* End updatetaskdescription functions */


/* Start updatetaskcompletiondate functions */

/* 
	@author Nate Prouty
	@method updatetaskcompletiondate_actions
	@params N/A
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updatetaskcompletiondate()
	@result depends on the tools in the tools array
*/
function updatetaskcompletiondate_actions() {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				// in pagemanager.js
				getassignmentstats(true); // get the current assignment stats
				break;
			case 'mywork_assets':
				// in pagemanager.js
				getassignmentstats(true); // get the current assignment stats
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updatetaskcompletiondate
	@params taskid - the ID of the task
	@description - updates the date that the task was completed and passes the result onto updatetaskcompletiondate_actions
	@result - the task is marked complete 
*/
function updatetaskcompletiondate(taskid) {

	var submitrequesturl = "action=updatetaskcompletiondate&taskid=" + taskid;

	$(function() {	
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, if data == 1, perform the necessary actions, based on the current state of the toolsArray
				if (data == 1) {
					updatetaskcompletiondate_actions();
				}
			}
		});
	});
}

/* Start marktaskincomplete functions */

/* 
	@author Nate Prouty
	@method marktaskincomplete_actions
	@params N/A
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to marktaskincomplete()
	@result depends on the tools in the tools array
*/
function marktaskincomplete_actions() {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				// in pagemanager.js
				getassignmentstats(true); // get the current assignment stats
				break;
			case 'mywork_assets':
				// in pagemanager.js
				getassignmentstats(true); // get the current assignment stats
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method marktaskincomplete
	@params taskid - the ID of the task
	@description - marks the task incomplete and passes the result onto marktaskincomplete_actions
	@result - the task is marked incomplete in the database
*/
function marktaskincomplete(taskid) {

	var submitrequesturl = "action=marktaskincomplete&taskid=" + taskid;
	
	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, if data == 1, perform the necessary actions, based on the current state of the toolsArray
				if (data == 1) {
					marktaskincomplete_actions();
				}
			}
		});
	});
}

/* End marktaskincomplete functions */


/* Start updateassignmentcompletiondate functions */

/* 
	@author Nate Prouty
	@method updateassignmentcompletiondate_actions
	@params data - the result of the call to updateassignmentcompletiondate
			status - 1: the assignment is not complete, 2: the assignment is complete
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to updateassignmentcompletiondate()
	@result depends on the tools in the tools array
*/
function updateassignmentcompletiondate_actions(data, status) {

	if (status == 1) {
		assignmentComplete = false;
	}
	
	if (status == 2) {
		assignmentComplete = true;
	}

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				/**
					Finds the current assignment and updates its _completiondate parameter to the current date/time
				*/
				var date = new Date();
				var month = date.getMonth()+1;
				var day = date.getDate()
				var year = date.getYear();
				day = (day < 10) ? '0'+day:day;
				month = (month < 10) ? '0'+month:month;
				year = (year < 1000) ? year + 1900: year;
				var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
				var timestamp = year+"-"+month+"-"+day+" "+time;
				$.each(json_assignmentlist,function(i,val){
					if (val._assignmentid == currassgn) {
						if (assignmentComplete == true) {
							val._completiondate = timestamp;
						} else {
							val._completiondate = null;	
						}
						return false;
					}
				});
				// in pagemanager.js
				getassignment(currassgn,true,true); // get the current assignment
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method updateassignmentcompletiondate
	@params taskid - the ID of the task
			status - the status of the assignment
	@description - updates the due date of the task and passes the result onto updateassignmentcompletiondate_actions 
	@result - the due date of the task is updated in the database
*/
function updateassignmentcompletiondate(taskid, status) {
	var submitrequesturl = "action=updateassignmentcompletiondate&assignmentid=" + currassgn + "&taskid=" + taskid + "&status=" + status;

	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/assignmentajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				updateassignmentcompletiondate_actions(data, status);
			}
		});
	});	
}

/* End updateassignmentcompletiondate functions */


/* End updatetaskcompletiondate functions */

/* Start deletetask functions */

/* 
	@author Nate Prouty
	@method deletetask_actions
	@params data - the result of the call to deletetask()
	@result - depends on the tools in the tools array
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to deletetask()
*/
function deletetask_actions(data) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				notifyAssignmentPlanner('deletetask'); // notify the Assignment Planner of the deleted task
				taskadd = true;
				break;
			default:
				break;
		}
	}
}


/** 
	@author Nate Prouty
	@method deletetask
	@params taskid - the ID of the task
	@description - updates the due date of the task and passes the result onto updateassignmentcompletiondate_actions
	@result - the task is deleted from the database
*/
function deletetask(taskid) {
	
	var submitrequesturl = "action=deletetask&taskid=" + taskid;

	$(function() {	
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			datatype: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				deletetask_actions(data);		
			}
		});
	});
}

/* End deletetask functions */


/* Start gettasktypelist functions */

/** 
	@author Nate Prouty
	@method gettasktypelist_actions
	@params json_tasktypelist - the JSON object of the list of task types
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to gettasktypelist()
	@result - depends on the tools in the tools array
*/
function gettasktypelist_actions(json_tasktypelist) {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setTaskTypeListForPlanner(json_tasktypelist); // sets the task type list for the Assignment Planner
				break;
			default:
				break;
		}
	}
}

/* 
	@author Nate Prouty
	@method gettasktypelist
	@params N/A
	@description - gets the list of tasks types as a JSON object and passes the result onto gettasktypelist_actions
	@result - the list of task types is retrieved from the database
*/
function gettasktypelist() {

	var submitrequesturl = "action=gettasktypelist";	
	
	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_tasktypelist) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				gettasktypelist_actions(json_tasktypelist);
			}
		});
	});	
}


/* End gettasktypelist functions */



/* Start gettasktypelist functions */

/* 
	@author Nate Prouty
	@method gettaskskillbuilderlist_actions
	@params json_taskskillbuilderlist - the JSON object of the list of task skill builders
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to gettaskskillbuilderlist()
	@result - depends on the tools in the tools array
*/
function gettaskskillbuilderlist_actions(json_taskskillbuilderlist) {
	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'workzone':
				// in workzone.js
				displayskillbuildertask(json_taskskillbuilderlist); // print the list of skill builder tasks
				break;
			case 'assignmentPlanner':
				// in assignmentPlanner.js
				setTaskSkillBuilderListForPlanner(json_taskskillbuilderlist); // set the task list builder list for the Assignment Planner
				break;
			default:
				break;
		}
	}
}

/** 
	@author Nate Prouty
	@method gettaskskillbuilderlist
	@params tasktypeid - the ID of the task type
	@description - gets the list of task skill builders and passes the result onto gettaskskillbuilderlist_actions
	@result - the list of task skill builders is retrieved from the database
*/
function gettaskskillbuilderlist(tasktypeid) {

	var submitrequesturl = "action=gettaskskillbuilderlist&tasktypeid=" + tasktypeid;		
	
	$(function() {
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/taskajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_taskskillbuilderlist) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				gettaskskillbuilderlist_actions(json_taskskillbuilderlist);
			}
		});
	});	
}


/* End gettaskskillbuilderlist functions */

/* Start getstuffcollected functions */

/** 
	@author Nate Prouty
	@method getstuffcollected_actions
	@params json_stuffcollected - the JSON object of stuff collected
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getstuffcollected()
	@result - depends on the tools in the tools array
*/
function getstuffcollected_actions(json_stuffcollected) {
	sortCollectByTitle(json_stuffcollected); // sort by title by default
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				// in mywork_assignment_detail.js
				displayAssetList(json_stuffcollected);	// print out the list of assets
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				displayAssetList(json_stuffcollected); // print out the list of assets
				break;
			default:
				break;
		}		
	}				
}

/** 
	@author Nate Prouty
	@method getstuffcollected
	@params asset_type - the type of asset
			force (optional) - whether or not to force retrieval from the SOAP client
	@description - gets the stuff collected for the given asset type and passes the result onto getstuffcollected_actions
	@result - the stuff collected for the given asset_type is retrieved from the database
*/
function getstuffcollected(asset_type, force) {

	if (typeof(asset_type) == 'undefined') {
		var asset_type = 'null';
	}
		
	if (typeof(force) == 'undefined') {
		var force = false;
	}
	
	if ((typeof(json_stuffcollected) != 'undefined') && (json_stuffcollected != '') && !(force)) {
		getstuffcollected_actions(json_stuffcollected, asset_type);
	}
	
	else {
		var submitrequesturl = 'action=getstuffcollected&assignmentid=' + currassgn + '&type=' + asset_type;

		
		$(function() {
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
				data: submitrequesturl, // the data (and function) passed to the called PHP file 
				dataType: "json", // the expected type of data returned
				success: function(json) {	
					// on success, perform the necessary actions, based on the current state of the toolsArray
					json_stuffcollected = json;
					getstuffcollected_actions(json_stuffcollected);
				}
			});
		});
	}
}

/* End getstuffcollected functions */

/* Start getstuffcollectedcounts functions */

/** 
	@author Nate Prouty
	@method getstuffcollectedcounts_actions
	@params json_stuffcollectedcounts - the JSON object of the count of stuff collected
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getstuffcollectedcounts()
	@result depends on the tools in the tools array
*/
function getstuffcollectedcounts_actions(json_stuffcollectedcounts) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail_ajax':
				// in mywork_assignment_detail.js
				displayAssetFolders(json_stuffcollectedcounts); // print out the asset folders, along with their counts
				break;
			default:
				break;
		}		
	}				
}

/** 
	@author Nate Prouty
	@method getstuffcollectedcounts
	@params force (optional) - whether or not to force retrieval from the SOAP client
	@description - gets the count of the stuff collected and passes the result onto getstuffcollectedcounts_actions
	@result - the count of stuff collected for the current assignment is retrieved from the database
*/
function getstuffcollectedcounts(force) {

	if (typeof(force) == 'undefined') {
		var force = false;
	}

	var submitrequesturl = "action=getstuffcollectedcounts&assignmentid=" + currassgn;
		
	if (((typeof(json_stuffcollectedcounts) != 'undefined') && (json_stuffcollectedcounts != '')) && !(force)) {
		getstuffcollectedcounts_actions(json_stuffcollectedcounts);
	}
	else {
		$(function() {
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
				data: submitrequesturl, // the data (and function) passed to the called PHP file 
				dataType: "json", // the expected type of data returned
				
				success: function(json) {
					// on success, perform the necessary actions, based on the current state of the toolsArray
					json_stuffcollectedcounts = json;
					getstuffcollectedcounts_actions(json_stuffcollectedcounts);
				}
			});
		});
	}
}
/* End getstuffcollectedcounts functions */


/* Start getassignmentassetlist fuctions */

/** 
	@author Nate Prouty
	@method getassignmentassetlist_actions
	@params json_assignmentassetlist - the list of assignments to which a given asset has been saved
			assetid - the ID of the asset
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getassignmentassetlist()
	@result depends on the tools in the tools array
*/
function getassignmentassetlist_actions(json_assignmentassetlist, assetid) {

	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'digitallocker':
				// loop through the list and add found items to the "saved_to" array
				$.each(json_assignmentassetlist, function(i, val) {
				
					var tmpindex = saved_to.length;
					
					saved_to[tmpindex] = new Object();
					saved_to[tmpindex]._assignmentid = val._assignmentid;
					saved_to[tmpindex]._assetid = assetid;
				});
				// Ensure that json_assignmentlist has been created before using it
				if ((typeof(json_assignmentlist) != 'undefined') && (json_assignmentlist != '')) {
					buildProjectList(json_assignmentlist); // create the dropdown of assignments
				}
				break;
			default:
				break;
		}		
	}		
}

/** 
	@author Nate Prouty
	@method getassignmentassetlist
	@params assetid - the ID of the asset
			sourceproductid - the ID of the product
			globaltype - global type
			force (optional) - whether or not to force retrieval from the SOAP client
	@description - gets the list of assignments that have saved the given asset and passes the result onto getassignmentasset_actions
	@result - the list of assignments that have saved the given asset are retrieved from the database
*/
function getassignmentassetlist(assetid, sourceproductid, globaltype, force) {
		
	var sort = 'title';
	
	if (typeof(force) == 'undefined') {
		var force = false;
	}
	
	if ((typeof(json_assignmentassetlist) != 'undefined') && (json_assignmentassetlist != '') && !(force)) {
		getassignmentassetlist_actions(json_assignmentassetlist, assetid);
	}
	else {
		$(function() {	
		
			var submitrequesturl = "action=getassignmentassetlist&assetid=" + assetid + "&productid=" + sourceproductid + "&type=" + globaltype + "&sort=" + sort;
			
			$.ajax({
				type: "GET", // the type of request
				url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
				data: submitrequesturl, // the data (and function) passed to the called PHP file 
				dataType: "json", // the expected type of data returned
				success: function(json) {
					// on success, perform the necessary actions, based on the current state of the toolsArray
					json_assignmentassetlist = json;
					getassignmentassetlist_actions(json_assignmentassetlist,assetid);
				}
			});	
		});
	}
}

/* End getassignmentassetlist functions */


/* Start copysavedcontent functions */

/** 
	@author Nate Prouty
	@method copysavedcontent
	@params id - the ID of the current assignment
			contenttype - the type of asset
			assignmentid - the ID of the assignment that's getting this asset in the copy
	@description - copies an asset from one assignment to the other
	@result - the asset is copied
*/
function copysavedcontent(id, contenttype, assignmentid) {

	var submitrequesturl = "action=copysavedcontent&id=" + id + "&contenttype=" + contenttype + "&assignmentid=" + assignmentid;

	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// optional: output result for testing
			}
		});
	});
}

/* End copysavedcontent functions */


/* Start movesavedcontent functions */

/**
	@author Nate Prouty
	@method movesavedcontent
	@params id - the ID of the current assignment
			contenttype - the type of asset
			assignmentid - the ID of the assignment that's getting this asset in the move
	@description - moves the asset from one assignment to another
	@result the asset is moved from one assignment to the other
*/
function movesavedcontent(id, contenttype, assignmentid) {
	
	var submitrequesturl = "action=movesavedcontent&id=" + id + "&contenttype=" + contenttype + "&assignmentid=" + assignmentid;
		
	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// optional: output result for testing
			}
		});
	});
}

/* End movesavedcontent functions */ 


/* Start deletesavedcontent functions */

/** 
	@author Nate Prouty
	@method deletesavedcontent_actions
	@params type_param - the type ID
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to deletesavedcontent()
	@result depends on the tools in the tools array
*/
function deletesavedcontent_actions(type_param) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail': 
				// in pagemanager.js
				getstuffcollected('null', true); // get the stuff collected 
				break;
			case 'mywork_assets':
				// in pagemanager.js
				getstuffcollected(type_param, true); // get the stuff collected, based on the type (type_param)
				break;
			default:
				break;
		}		
	}
}

/**
	@author Nate Prouty
	@method deletesavedcontent 
	@params id - the ID of the asset
			contenttype - the content type of the asset
			type_param - the type of asset being deleted
	@description - removes the saved asset from the assignment, passing the result onto deletesavedcontent_actions
	@result - the saved content is deleted from the database (as in, unlinked from the current assignment)
*/
function deletesavedcontent(id, contenttype, type_param) {
	
	var submitrequesturl = "action=deletesavedcontent&id=" + id + "&contenttype=" + contenttype;
		
	$(function() {
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				deletesavedcontent_actions(type_param);
			}
		});
	});
}

/* End deletesavedcontent functions */


/* SUPPORT CALLS */


/** 
	@author Nate Prouty
	@method getfinaldraftformatlist_actions
	@params json_supportdata - the JSON support data object
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getfinaldraftformatlist()
	@result depends on the tools in the tools array
*/
function getfinaldraftformatlist_actions(json_supportdata) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'assignmentPlanner': 
				// in assignmentPlanner.js
				setFinalDraftFormatListForPlanner(json_supportdata); // set the final draft form list for the Assignment Planner
				break;
			default:
				break;
		}		
	}			
}

/**
	@author Nate Prouty
	@method getfinaldraftformatlist
	@params N/A
	@description - retrieves the final draft format list, passing the result ont getfinaldraftformatlist_actions
	@result - the final draft format list is retrieved from the database
*/
function getfinaldraftformatlist() {
	var submitrequesturl = "action=getfinaldraftformatlist";

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_supportdata) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getfinaldraftformatlist_actions(json_supportdata);
			}
		});
	});
}

/** 
	@author Nate Prouty
	@method getglobaltypesdigitallockerfoldertype_actions
	@params json_digitallockerfoldertype - the JSON object of the digital locker folder type
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getglobaltypesdigitallockerfoldertype()
	@result depends on the tools in the tools array
*/
function getglobaltypesdigitallockerfoldertype_actions(json_digitallockerfoldertype) {

	for (var k=0; k<toolsArray.length; k++) {
		switch (toolsArray[k]) {
			case 'digitallocker':
				// in digitallocker.js
				displaySaveFolderType(json_digitallockerfoldertype._description); // print out the type of asset being saved
				break;
			default:
				break;
		}
	}
}

/** 
	@author Nate Prouty
	@method getglobaltypesdigitallockerfoldertype
	@params globaltype - the global type
	@description - retrieves the digital locker folder type, passing the results onto getglobaltypesdigitallockerfoldertype_actions 
	@result - the digital locker folder type is retrieved from the database 
*/
function getglobaltypesdigitallockerfoldertype(globaltype) {
	
	var submitrequesturl = "action=getglobaltypesdigitallockerfoldertype&globaltype=" + globaltype;

	$(function() {
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				json_digitallockerfoldertype = json;
				getglobaltypesdigitallockerfoldertype_actions(json_digitallockerfoldertype);
			},
			complete: function() {
				
			}
		});
	});
	
	return json_digitallockerfoldertype;
}

/* CITATION */

/** 
	@author Nate Prouty
	@method getcitationcount_actions
	@params data - the result from getcitationcount()
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getcitationcount()
	@result depends on the tools in the tools array
*/
function getcitationcount_actions(data) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail': 
				// in mywork_assignment_detail.js
				displayCitationCount(data);
				break;
			default:
				break;
		}		
	}			
}

/** 
	@author Nate Prouty
	@method getcitationcount
	@params N/A
	@description - gets the citation count for the current assignment and passes the result onto getcitationcount_actions
	@result - the citation count is retrieved from the database
*/
function getcitationcount() {
	var submitrequesturl = "action=getcitationcount&assignmentid=" + currassgn;

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/citationajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				if (data == '') {
					data = '0';
				}
				getcitationcount_actions(data);
			}
		});
	});
}

/**
	@author Nate Prouty
	@method getcitationsourcetypelist_actions
	@params json_supportdata - the JSON support data object
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getcitationsourcetypelist()
	@result - depends on the tools in the tools array
*/
function getcitationsourcetypelist_actions(json_supportdata) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'assignmentPlanner': 
				// in assignmentPlanner.js
				setCitationSourceTypeListForPlanner(json_supportdata); // sets the citation source type list for the Assignment Planner
				break;
			default:
				break;
		}		
	}			
}

/** 
	@author Nate Prouty
	@method getcitationsourcetypelist
	@params N/A
	@description - gets the citation source type list for the current assignment and passes the result onto getcitationsourcetypelist_actions 
	@result - the citation source type list is retrieved from the database
*/
function getcitationsourcetypelist() {
	var submitrequesturl = "action=getcitationsourcetypelist";

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_supportdata) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getcitationsourcetypelist_actions(json_supportdata);
			}
		});
	});
}

/** 
	@author Nate Prouty
	@method getcitationtypelist_actions
	@params json_supportdata - the JSON support data object
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getcitationtypelist()
	@result depends on the tools in the tools array
*/
function getcitationtypelist_actions(json_supportdata) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'assignmentPlanner': 
				// in assignmentPlanner.js
				setCitationTypeListForPlanner(json_supportdata); // sets the citation type list for the Assignment Planner
				break;
			default:
				break;
		}		
	}			
}

/** 
	@author Nate Prouty
	@method getcitationypelist
	@params N/A
	@description - gets the citation type list for the current assignment and passes the result onto getcitationtypelist_actions
	@result - the citation type list is retrieved from the database
*/
function getcitationtypelist() {
	var submitrequesturl = "action=getcitationtypelist";

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_supportdata) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getcitationtypelist_actions(json_supportdata);
			}
		});
	});
}

/** 
	@author Nate Prouty
	@method getfinaldraftmodellist_actions
	@params json_supportdata - the JSON support data object
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getfinaldraftmodellist()
	@result depends on the tools in the tools array
*/
function getfinaldraftmodellist_actions(json_supportdata) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'assignmentPlanner': 
				// in assignmentPlanner.js
				setFinalDraftModelListForPlanner(json_supportdata); // sets the final draft model list for the Assignment Planner
				break;
			default:
				break;
		}		
	}			
}

/** 
	@author Nate Prouty
	@method getfinaldraftmodellist
	@params N/A
	@description - gets the final draft model list for the current assignment and passes the result onto getfinaldraftmodellist_actions
	@result - the final draft model list is retrieved from the database
*/
function getfinaldraftmodellist() {
	var submitrequesturl = "action=getfinaldraftmodellist";

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_supportdata) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getfinaldraftmodellist_actions(json_supportdata);
			}
		});
	});
}

/** 
	@author Nate Prouty
	@method getskillbuilderlist_actions
	@params json_skillbuilderlist
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getskillbuilderlist()
	@result depends on the tools in the tools array
*/
function getskillbuilderlist_actions(json_skillbuilderlist) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'workzone':
				// in workzone.js 
				displayskillbuilder(json_skillbuilderlist);
				break;
			default:
				break;
		}		
	}			
}

/**
	@author Nate Prouty
	@method getskillbuilderlist
	@params N/A
	@description - gets the list of skill builders, passing the result onto getskillbuilderlist_actions
	@result - the list of skill builders is retrieved from the database
*/
function getskillbuilderlist() {
	var submitrequesturl = "action=getskillbuilderlist";
	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_skillbuilderlist) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getskillbuilderlist_actions(json_skillbuilderlist);
			}
		});
	});
}

/** 
	@author Nate Prouty
	@method getrubricanswerlist_actions
	@params json_rubricanswerlist - the JSON object of the list of rubric answers
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getrubricanswerlist()
	@result - depends on the tools in the tools array
*/
function getrubricanswerlist_actions(json_rubricanswerlist) {

	// If the HTML hasn't been built yet, delay further execution
	if ($('.selfEvalQuestions').length == 0) {
		setTimeout("getrubricanswerlist_actions(json_rubricanswerlist)", 250);
	}
		
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail': 
				$.each(json_rubricanswerlist, function(i, val) {
					// triggers the appropriate response, depending on whether 'yes' or 'no' was selected for each question
					if (val._answertext === 'y') {
						$('div.selfEvalQuestions span.' + (i+1)).find('input.yes').trigger("click");
					}
					else if (val._answertext === 'n') {
						$('div.selfEvalQuestions span.' + (i+1)).find('input.no').trigger("click");
					}
					else {
						// This shouldn't happen
					}
				});
				break;
			case 'mywork_assets': 
				$.each(json_rubricanswerlist, function(i, val) {
					// triggers the appropriate response, depending on whether 'yes' or 'no' was selected for each question
					if (val._answertext === 'y') {
						$('div.selfEvalQuestions span.' + (i+1)).find('input.yes').trigger("click");
					}
					else if (val._answertext === 'n') {
						$('div.selfEvalQuestions span.' + (i+1)).find('input.no').trigger("click");
					}
					else {
						// This shouldn't happen
					}
				});
				break;				
			default:
				break;
		}		
	}			
}

/**
	@author Nate Prouty
	@method getrubricanswerlist
	@params taskid
	@description - gets the list of rubric answers, passing the result onto getrubricanswerlist_actions
	@result - the list of rubric answers is retrieved from the database
*/
function getrubricanswerlist(taskid) {
	var submitrequesturl = "action=getrubricanswerlist&taskid=" + taskid;
	$(function() {
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/digitallockerajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				json_rubricanswerlist = json;
				getrubricanswerlist_actions(json_rubricanswerlist);
			}
		});
	});
}

/**
	@author Nate Prouty
	@method getrubricquestionlist_actions
	@params json_rubricquestionlist - the JSON object of rubric questions
			taskid - the ID of the task
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getrubricquestionlist()
	@result depends on the tools in the tools array
*/
function getrubricquestionlist_actions(json_rubricquestionlist, taskid) {

	$('.selfEvalQuestions').html("");

	getrubricanswerlist(taskid);
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				// in mywork_assignment_detail.js
				displaySelfEvaluation(json_rubricquestionlist, taskid);
				break;
			case 'mywork_assets':
				// in mywork_assets.js
				displaySelfEvaluation(json_rubricquestionlist, taskid);
				break;
			default:
				break;
		}		
	}
}

/**
	@author Nate Prouty
	@method getrubricquestionlist
	@params tasktypeid - the ID of the task type
			taskid - the ID of the task
	@description - gets the rubric question list, passing the result onto getrubricquestionlist_actions
	@result - the list of rubric questions is retrieved from the database
*/
function getrubricquestionlist(tasktypeid, taskid) {

	var submitrequesturl = "action=getrubricquestionlist&tasktypeid=" + tasktypeid;
	
	$(function() {
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "json", // the expected type of data returned
			success: function(json_rubricquestionlist) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				getrubricquestionlist_actions(json_rubricquestionlist, taskid);
			}
		});
	});
}


/** 
	@author Nate Prouty
	@method setrubricanswers_actions
	@params data - the result of the call to setrubricanswers()
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to setrubricanswers()
	@result - depends on the tools in the tools array
*/
function setrubricanswers_actions(data) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail':
				$('#selfEvaluation').popupClose();
				break;
			case 'mywork_assets':
				$('#selfEvaluation').popupClose();
				break;				
			default:
				break;
		}		
	}	
}

/**
	@author Nate Prouty
	@method setrubricanswers
	@params taskid - the ID of the task
	@description - sets the rubric answers given by the user, passing the result onto setrubricanswers_actions
	@result	- the rubric answers for the given taskid are set in the database
*/
function setrubricanswers(taskid) {
	
	$(function() {
	
		var rubricanswers = new Array();
	
		// Loop over each radio button and put the value in the array, or an empty string if no value has been chosen
		$(rubricIdArray).each(function() {
			var r = $(':radio[name=' + this + ']:checked');
			if (r.length != 0) {
				rubricanswers.push(r.val());
			}
			else {
				rubricanswers.push('');
			}
		});
		
		rubricIdArray = new Array();
		
		rubricanswersend = rubricanswers.join(',');
	
		var submitrequesturl = "action=setrubricanswers&taskid=" + taskid + "&rubricanswers=" + rubricanswersend;
	
		$.ajax({
			type: "POST", // the type of request
			url: "/arch/supportajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				setrubricanswers_actions(data);
			}
		});
	});
}



/* END SUPPORT CALLS */

/* NOTECARD */

/** 
	@author Nate Prouty
	@method getnotecardcount_actions
	@params data - the result of the call to getnotecardcount
	@description - loops through the toolsArray and performs the given actions on the tools found. 
				   Called after each successful call to getnotecardcount()
	@result depends on the tools in the tools array
*/
function getnotecardcount_actions(data) {
	for(var k=0; k<toolsArray.length; k++){
		switch (toolsArray[k]) {
			case 'mywork_assignment_detail': 
				// in mywork_assignment_detail.js
				displayNoteCardCount(data);
				break;
			default:
				break;
		}		
	}			
}

/**
	@author Nate Prouty
	@method getnotecardcount
	@params N/A
	@description -  gets the number of note cards for the current assignment, passing the result onto getnotecardcount_actions
	@result - the notecard count for the current assignment is retrieved from the database
*/
function getnotecardcount() {
	var submitrequesturl = "action=getnotecardcount&assignmentid=" + currassgn;

	$(function() {	
		$.ajax({
			type: "GET", // the type of request
			url: "/arch/notecardajax.php", // the file that contains the PHP function being called
			data: submitrequesturl, // the data (and function) passed to the called PHP file 
			dataType: "text", // the expected type of data returned
			success: function(data) {
				// on success, perform the necessary actions, based on the current state of the toolsArray
				if (data == '') {
					data = '0';
				}
				getnotecardcount_actions(data);
			}
		});
	});
}


/* This is for the outline by sam */

/**
	@author Sam San/Jeff Landry
	@method saveoutline
	@params N/A
	@description - saved the outline
	@result - the outline is saved
*/
function saveoutline()
{
	// *** No reverse when it saves ****
	// stores the original data
	originaldata=$("#myGroupsInner").html();
	
	 var item="&";
	  $("#myGroupsInner ol li").find("div:eq(1)").each(function() {
	 	var str2=$(this).text();	
		item=item+"item[]="+encodeURIComponent(str2)+"&";
		
	 });
		 
	// This serialize is working for all the browser and safari 2.
	var list='';
	$("#myGroupsInner li").each(function() {
		list=list+'list[]='+$(this).attr("level") + '&';											  
	});
	 
	 
	$.ajax({
   		type: "POST", // the type of request
   		url: "/outline_save", // the file that contains the PHP function being called
   		data: list + item, // the data (and function) passed to the called PHP file 
    	success: function(msg){ // on success, perform the following actions
     	 	var pos=$("#outlineButtons").offset();
	 		var left=pos.left + 200 + 'px';
			var top=pos.top + 50 + 'px';
			$('#savemsg').css({left:left,top:top, 'position':'absolute', 'display':'block','z-index':'10','color':'#ffffff','font-size':'14px'});
  			$('#savemsg').show('slow');
   			$('#savemsg').fadeOut('slow');
		 	outlinesaveflag=1;
			$("#cancelbutton").attr("disabled","disabled");
			$("#savebutton").attr("disabled","disabled");
			if (list.length == 0) {
				originaldata = '';
				canceloutline();
			}
			//RECORD STAT HIT
			collectStat('outln','xs','save','');
   		}
  	});
	
}

/**
	@author John Palmer
	@method saveexportoutline
	@params N/A
	@description - saved the outline and pop open the export.
	@result - the outline is saved
*/
function saveexportoutline()
{
	// *** No reverse when it saves ****
	// stores the original data
	originaldata=$("#myGroupsInner").html();
	
	 var item="&";
	  $("#myGroupsInner ol li").find("div:eq(1)").each(function() {
	 	var str2=$(this).text();	
		item=item+"item[]="+encodeURIComponent(str2)+"&";
		
	 });
		 
	// This serialize is working for all the browser and safari 2.
	var list='';
	$("#myGroupsInner li").each(function() {
		list=list+'list[]='+$(this).attr("level") + '&';											  
	});

	//RECORD STAT HIT
	collectStat('outln','xs','xport','');	 
	 
	$.ajax({
   		type: "POST", // the type of request
   		url: "/outline_save", // the file that contains the PHP function being called
   		data: list + item, // the data (and function) passed to the called PHP file 
    	success: function(msg){ // on success, perform the following actions
     	 	var pos=$("#outlineButtons").offset();
	 		var left=pos.left + 200 + 'px';
			var top=pos.top + 50 + 'px';
			$('#savemsg').css({left:left,top:top, 'position':'absolute', 'display':'block','z-index':'10','color':'#ffffff','font-size':'14px'});
  			$('#savemsg').show('slow');
   			$('#savemsg').fadeOut('slow');
		 	outlinesaveflag=1;
			$("#cancelbutton").attr("disabled","disabled");
			$("#savebutton").attr("disabled","disabled");
			if (list.length == 0) {
				originaldata = '';
				canceloutline();
			}
			window.location.href='export.php?tool=outline&apptype='+$(':radio[name=format]:checked').attr('value');
   		}
  	});
	
}

/**
	@author John Palmer
	@method saveprintoutline
	@params url,width,height - Parameters to pop open the print dialog.
	@description - saved the outline and pop open the export.
	@result - the outline is saved
*/
function saveprintoutline(url,width,height)
{
	// *** No reverse when it saves ****
	// stores the original data
	originaldata=$("#myGroupsInner").html();
	
	 var item="&";
	  $("#myGroupsInner ol li").find("div:eq(1)").each(function() {
	 	var str2=$(this).text();	
		item=item+"item[]="+encodeURIComponent(str2)+"&";
		
	 });
		 
	// This serialize is working for all the browser and safari 2.
	var list='';
	$("#myGroupsInner li").each(function() {
		list=list+'list[]='+$(this).attr("level") + '&';											  
	});
	
	//RECORD STAT HIT
	collectStat('pfe','xs','print','');	 
	 
	$.ajax({
   		type: "POST", // the type of request
   		url: "/outline_save", // the file that contains the PHP function being called
   		data: list + item, // the data (and function) passed to the called PHP file 
    	success: function(msg){ // on success, perform the following actions
     	 	var pos=$("#outlineButtons").offset();
	 		var left=pos.left + 200 + 'px';
			var top=pos.top + 50 + 'px';
			$('#savemsg').css({left:left,top:top, 'position':'absolute', 'display':'block','z-index':'10','color':'#ffffff','font-size':'14px'});
  			$('#savemsg').show('slow');
   			$('#savemsg').fadeOut('slow');
		 	outlinesaveflag=1;
			$("#cancelbutton").attr("disabled","disabled");
			$("#savebutton").attr("disabled","disabled");
			if (list.length == 0) {
				originaldata = '';
				canceloutline();
			}
			
			popupprint(url,width,height);
   		}
  	});
	
}

/**
	@author Sam San/Jeff Landry
	@method getajaxoutline
	@params outlineid - the id of the outline to get
	@description - gets an outline
	@result - the requested outline is retrieved from the database
*/
function getajaxoutline(outlineid) {
	$.getJSON('/outlineajax.php',{outlineid:outlineid}, function (jsondata) {
		outlinelist=jsondata; // initial data
		if(outlinelist.length > 0)
		{
			displayoutline(); // display outline on the page.

		} else {
			// clears out the HTML in the outlineButtons and displays the outline form
			$('#outlineButtons').html('');
			displayoutlineform();
		}
	});
	
}



/**
	@author Sam San
	@description - when the user leaves a page, loop through the toolsArray and perform any necessary actions based on the items currently in the array
*/
window.onbeforeunload = function(e) {
	var navawaysaved = 0;
	var navawaystr = new Array();
	if (typeof(e) == 'undefined') {
		e = window.event;}
	
	$.grep(toolsArray,function(n,i) {
		switch(n){
			
			case 'bibliography':
				if (objBibliography.checkIfSavedLeave() == false) {
					navawaystr[navawaysaved]= "Bibliography";
					navawaysaved++;
				}
				
			break;
			case 'citation':
				if (checkifCitationsaved() == false) {
					navawaystr[navawaysaved]= "Citation";
					navawaysaved++;
				}
			break;
			case 'notecard':
				if (checkIfNoteSavedGroup() == false) {
					navawaystr[navawaysaved]= "Note card";
					navawaysaved++;
				}
			break;
			case 'outline':
				if(checkoutlinesave()==false){
					navawaystr[navawaysaved]= "Outline";
					navawaysaved++;
				}
			break;
			case 'assignmentPlanner':
				if ($('#newAssignment').css('display') == 'block') {
					navawaystr[navawaysaved]= "Assignment Plan";
					navawaysaved++;
				}
			break;

		}
	});
	
		
		if (navawaysaved  > 0) {
			var str='';
			switch(navawaystr.length)
			{
				case 1: str=navawaystr[0]; break;
				case 2: str=navawaystr[0] + ' and ' + navawaystr[1]; break;
				default:
				for(var i=0; i < (navawaystr.length -1 ); i++)
				{
					str+=navawaystr[i] + ', ';	
				}
				str+=' and ' + navawaystr[navawaystr.length-1];
				break;
				
			}
			if ($.browser.safari) {
				return	'You currently have ' + str + ' data on this page that has not been saved, and will not be saved if you leave this page.\n';
			} else {
				e.returnValue = 'You currently have ' + str + ' data on this page that has not been saved, and will not be saved if you leave this page.\n';
			}
		}
	
}

/**
	function GetNoteAndGroups
	Is used to get the note list and group list from the database.
	Params: assignid - the assignment id of the assignment you are getting the information for.
	returns none
*/


function GetNoteAndGroups(assignid) {
	assignmentid = assignment_id = assignid;
	groupStore = null;
	$.getJSON (
		"/arch/notecardajax.php",{action:'getNoteAndGroups'},
		function(data) {
			noteStore = data.notecarddata;
			noteStore.sort(sortnotecards);
			groupStore = data.groupdata;
			groupStore.sort(sortGroups);
			curNote = null;
			$.grep(toolsArray,function(n,i){
				// loop through the toolsArray and perform the given actions 
				switch(n){
					case 'notecard':
						finishInit();							
						return true;					
					case 'citation':
						setCitationStyle();					
						return true;					
					case 'bibliography':
						return true;
					case 'noteOrganizer':
						refreshOrganizer();
						return true;
					case 'outline':
						if (outlineIsOpen == 0) {
							displayoutline2();
						}
						
						return true;
					default:
						return true;
				}
			});
		}
	)
}

/*
	function removeGroup
	@description - removes a group from the database.
	Params: groupid - the group id of the group you are removing.
	returns none
*/

function removeGroup(groupid) {
$.get (
		"/arch/notecardajax.php",{action:'deletegroup',groupid:groupid},
		function(data) {
			// loop through the toolsArray and perform the given actions
			$.grep(toolsArray,function(n,i){
				switch(n){
					case 'notecard':
						BuildNoteandGroups();
						return true;					
					case 'citation':
						return true;					
					case 'bibliography':
						return true;
					case 'noteOrganizer':
						groupStore = $.grep(groupStore,
							function(n,i) {
								if (typeof(n._groupid) == 'number') {
									return (n._groupid != groupid);
								} else {
									return (n._groupid.replace(/\'|\"/g,'') != groupid);
								}
							}
						);					
						return true;
					default:
						return true;
				}
			});
			return data;
		}
	)	
}

/**
	function addGroup
	@description - adds a group to the database.
	Params: grouptext - the title of the group to be added.
	returns none
*/


function addGroup(grouptext) {
	// tests to see if the group name has been entered, sending a message to an error DIV if not
	if(grouptext.replace(/ /g,'')=='') {
		$('#errorgroup').html('Group name required');
	} else {
		var flag = checkduplicate(grouptext);
		if(flag==false)
		{
			languageflag=languagechecker(grouptext);
			if(languageflag == 0)
			{
				$.get (
					"/arch/notecardajax.php",{action:'insertgroup',grouptext:grouptext},
					function(data) {
							$.grep(toolsArray,function(n,i){
							switch(n){
								case 'notecard':
									//make sure that no errors are shown
									$('#errorgroup').html('');
									//change the add group panel back to the group dropdown panel
									toggleshowandhide('extendedNotePanel',2);
									//add the new group to the group dropdown
									addoption(grouptext, data);
									//if the browser is not IE
									if ($.browser.msie != true) {
										//set the selected attribute
										$('#note_category').find('option[value='+data+']').attr('selected','selected');
									} else if (parseInt($.browser.version()) != 6) { // if browser is not IE6
										//trigger the click event to select the option
										$('#note_category').find('option[value='+data+']').trigger('click');
									//if the browser is IE6
									} else {
										//set a timeout to set the selected attribute. in IE6 you can not set the selected attribute right away
										setTimeout("$('#note_category').find('option[value='+"+data+"+']').attr('selected','selected')",200);	
									}
									//hide all the selects
									hideSelects();
									// if the note card panel is on the view citation panel
									if (thisSource == 'viewCitation'){	
										//set any select boxes as visible
										$('#viewCitationCont').find('select').css('visibility','visible');
									// if the note card panel is on the cite source on page panel(Article page only)
									} else if (thisSource == 'citeSource'){
										//set any select boxes as visible										
										$('#citeSourceCont').find('select').css('visibility','visible');
									// if the note card panel is on the use existing citation panel
									} else if (thisSource == 'existSource'){
										//set any select boxes as visible										
										$('#existSourceCont').find('select').css('visibility','visible');
									// if the note card panel is on the new citation panel
									} else if (thisSource == 'newSource'){
										//set any select boxes as visible										
										$('#newSourceCont').find('select').css('visibility','visible');		
									// if the note card panel is on the note card panel
									} else if (thisSource == 'noteCard'){
										//set any select boxes as visible										
										$('#noteCardContentCont').find('select').css('visibility','visible');
									}									
									return true;					
								case 'citation':
									return true;					
								case 'bibliography':
									return true;
								case 'noteOrganizer':
									addOrganizerGroup(data,grouptext);		
									return true;
								default:
									return true;
							}
						});
					}
				)
			} else {
				$('#errorgroup').html("The name you have entered cannot be <br>processed. Please enter another name.");	
			}
		}
	}	
}

/*
	function addOrgGroup
	Is used to add a group to the database from the note organizer.
	Params: grouptext - the title of the group to be added.
	returns none
*/

function addOrgGroup(grouptext) {
	// Group text has already been checked for validity.
	$.get (
		"/arch/notecardajax.php",{action:'insertgroup',grouptext:grouptext},
		function(data) {
			$.grep(toolsArray,function(n,i){
				switch(n){
					case 'notecard':	
						//if there is a current notecard
						if (curNote != null) {
							//get the current selected group
							var tmpindex = $('#note_category').find('option:selected').val();
						}
						//add the new group to the group dropdown
						addoption(grouptext, data);
						//if there is a current note card
						if (curNote != null) {			
							//if the browser is not IE
							if ($.browser.msie != true) {
								//set the selected attribute
								$('#note_category').find('option[value='+tmpindex+']').attr('selected','selected');
							//if the browser is not IE6
							} else if (parseInt($.browser.version()) != 6) {
								//trigger the click event
								$('#note_category').find('option[value='+tmpindex+']').trigger('click');
							//if the browser is IE6	
							} else {
								//set a timeout to set the selected attribute. in IE6 you can not set the selected attribute right away
								setTimeout("$('#note_category').find('option[value='+"+tmpindex+"+']').attr('selected','selected')",200);	
							}
						}
						return true;
					case 'citation':
						return true;
					case 'bibliography':
						return true
					case 'noteOrganizer':
						if (typeof(organizer_store.pendingGroupId) != "undefined"){
							setOrganizerGroupId(organizer_store.pendingGroupId, data);
							delete organizer_store.pendingGroupId;
						}				
						return true;
					default:
						return true;
				}
			});
			return data;	
		}
	);
}

/**
	function insertnotecard
	@description - adds a notecard to the database.
	Params:
		title - the title of the note card to be added.
		notequotes - the "Clipped text" section of the note card to be added.
		notetext - the "Notes in my own words" section of the note card to be added.
		groupid - the id of the group that the note card is to be added to.
		add - if this has been added by clicking add note, this resets the curNote variable to null
	returns none
*/

function insertnotecard(title,notequotes,notetext,groupid,add) {
	$.post('/arch/notecardajax.php',{action:'insertnotecard',title:title,notequotes:notequotes,notetext:notetext,groupid:groupid}, function(data) {
		// inserts a notecard into the database and adds that notecard to the current noteStore object
		var newNote = noteStore.length;
		noteStore[newNote] = new Object();
		noteStore[newNote]._profileid=profile_id;
		noteStore[newNote]._assignmentid=assignment_id;
		noteStore[newNote]._notecardid=data;
		noteStore[newNote]._title=title;
		noteStore[newNote]._directquote=notequotes;
		noteStore[newNote]._paraphrase=notetext;
		noteStore[newNote]._citationid=0;
		noteStore[newNote]._groupid=groupid;
		noteStore.sort(sortnotecards);
		$.grep(noteStore,function(n,i) {
			if (n._notecardid == data) {
				curNote = i;	
			}
		});
		if (typeof(add) != 'undefined') {
			curNote = null;	
		}		
		$.grep(toolsArray,function(n,i){
			// loop through the toolsArray and perform the given actions
			switch(n){
				case 'notecard':
				//disable the save note button
					$('#save_note').attr('disabled','disabled');
					//get the selected index of the group dropdown
					var SelectedIndex = $('#note_category').find('option:selected').val();
					//rebuild the left panel
					BuildNoteandGroups();
					//set the selected of the old selected group
					$('#note_category').find('option[value='+SelectedIndex+']').attr('selected','selected');
					return true;
				case 'noteOrganizer':
					//add the note to the note organizer
					addOrganizerNote(data,title,-1);	
					//if the note card group is not "Uncategorized"
					if (groupid > 0) {
						//change the group in the note organizer
						setOrganizerNoteGroup(data,groupid);
					}
					return true;
				case 'mywork_assignment_detail':
					getnotecardcount();
					return true;
				default:
					return true;
			}
		});
	
	});
}

/*
	function updatenotecard
	@description - updates a notecard in the database.
	Params:
		notecardid - the id of the note card to be updated.
		title - the title of the note card to be updated.
		notequotes - the "Clipped text" section of the note card to be updated.
		notetext - the "Notes in my own words" section of the note card to be updated.
		groupid - the id of the group that the note card is to be updated to.
		add - if this has been added by clicking add note, this resets the curNote variable to null
	returns none
*/

function updatenotecard(notecardid, title, notequotes, notetext, groupid,add){
	$.post('/arch/notecardajax.php',{action:'updatenotecard','notecardid':notecardid,'title':title,'notequotes':notequotes,'notetext':notetext,'groupid':groupid}, function(data) {
		// set temporary variables for the note organizer
		var tmpgroup = '';
		var tmptitle = '';
		//loop through the note cards
		$.grep(noteStore,function(n,i){
			//if the notecard ids match
			if (n._notecardid == notecardid) {
				//store the old group and title in temporary variables
				tmpgroup = n._groupid;
				tmptitle = n._title;
				//set the data for the new notecard
				n._title=title;
				n._directquote=notequotes;
				n._paraphrase=notetext;
				n._groupid=groupid;				
			}
		});
		//if the add button was clicked
		if (typeof(add) != 'undefined') {
			//set the notecard as blank
			curNote = null;	
		}		
		//loop through the tools array
		$.grep(toolsArray,function(n,i){
			switch(n){
				case 'notecard':
					//disable the save note button
					$('#save_note').attr('disabled','disabled');
					//get the selected index
					var SelectedIndex = $('#note_category').find('option:selected').val();
					//rebuild the left panel
					BuildNoteandGroups();
					//set the selected of the old selected group
					$('#note_category').find('option[value='+groupid+']').attr('selected','selected');
					//hide all the selects
					hideSelects();
					// if the note card panel is on the view citation panel
					if (thisSource == 'viewCitation'){	
						//set any select boxes as visible
						$('#viewCitationCont').find('select').css('visibility','visible');
					// if the note card panel is on the cite source on page panel(Article page only)
					} else if (thisSource == 'citeSource'){
						//set any select boxes as visible										
						$('#citeSourceCont').find('select').css('visibility','visible');
					// if the note card panel is on the use existing citation panel
					} else if (thisSource == 'existSource'){
						//set any select boxes as visible										
						$('#existSourceCont').find('select').css('visibility','visible');
					// if the note card panel is on the new citation panel
					} else if (thisSource == 'newSource'){
						//set any select boxes as visible										
						$('#newSourceCont').find('select').css('visibility','visible');		
					// if the note card panel is on the note card panel
					} else if (thisSource == 'noteCard'){
						//set any select boxes as visible										
						$('#noteCardContentCont').find('select').css('visibility','visible');
					}					
					return true;
				case 'noteOrganizer':
					//if the group was changed
					if (tmpgroup!=groupid) {
						//update the group in the note organizer
						setOrganizerNoteGroup(noteStore[curNote]._notecardid.replace(/\"|\'/g,''),(groupid == 0? -1 : groupid));	
					}
					//if the title was changed
					if (tmptitle!=title) {
						//update the title in the note organizer
						setOrganizerNoteTitle(noteStore[curNote]._notecardid.replace(/\"|\'/g,''),title);	
					}
					return true;
				case 'mywork_assignment_detail':
					// in pagemanager.js
					getnotecardcount(); // get the count of notecards
					getcitationcount(); // get the count of citations
					return true;
				default:
					return true;
			}
		});
	});	
}

/*
	function deletenote
	@description - deletes a notecard from the database.
	Params:
		notecardid - the id of the note card to be deleted.
	returns none
*/


function deletenote(notecardid){
	// find the index of the notecard to be deleted in the noteStore
	var tmpindex = null;	
	$.grep(noteStore,function(n,i){
		if (n._notecardid == notecardid) {
			tmpindex = i;
		}
	});
	var citationid = noteStore[tmpindex]._citationid;
	// delete the note
	$.get('/arch/notecardajax.php',{action:'deletenote','notecardid':notecardid}, function(data) {
		// reset the noteStore so that it no longer contains the deleted note
		noteStore = $.grep(noteStore, function(n,i) {
			return (n._notecardid.replace(/\'|\"/g,'') != notecardid.replace(/\'|\"/g,''));
		});						
		curNote = null;
		$.grep(toolsArray,function(n,i){
			switch(n){
				case 'notecard':
					//resets the clipped text character count and the my notes character count
					$('#note_quotes').focus();
					$('#note_text').focus();
					//sets the title field as active
					$('#note_title').focus();
					//clear the error text
					$('#warning').html('');
					//rebiuld the notecard
					BuildNoteandGroups();
					return true;				
				case 'noteOrganizer':
					// removes the note organizer for the deleted notecard
					deleteOrganizerNote(notecardid);				
					return true;
				case 'mywork_assignment_detail':
					// in pagemanager.js
					getnotecardcount(); // gets the new notecard count
					return true;
				case 'bibliography':
					//loop through the citations
					$.grep(citationData,function(m,l) {
						//if the notecard is associated with a citation
						if (m._citationid == citationid) {
							//close and open the notecard link on the bibliography to reset the visible attributes
							objBibliography.closeNotecards(l);
							objBibliography.openNotecards(l);
						}
					});	
				default:
					return true;
			}
		});
	});
}

/**
	function updateNotecardGroup
	@description - updates a note card's group.
	Params:
		notecardid - the id of the note card to be updated.
		groupid - the id of the group that the note card is to be updated to.
		add - if this has been added by clicking add note, this resets the curNote variable to null
	returns none
*/


function updateNotecardGroup(notecardid,groupid,add) {
$.get (
		'/arch/notecardajax.php',{action:'updatenotecardgroup','notecardid':notecardid,'groupid':groupid},
		function(data) {
			var tmpi = '';
			//loop through the notecards
			$.grep(noteStore,
				function(n,i){
					//find the updated notecard
					if (n._notecardid.replace(/\'|\"/g,'') == notecardid) {
						//set the group id as the new group id
						n._groupid = groupid;
						//store the index of the notecard
						tmpi = i;
					}
				}
			);
			//if the add note button was clicked
			if (typeof(add) != 'undefined') {	
				//set curnote as null
				curNote = null;	
			}		
			//loop through the tools array
			$.grep(toolsArray,function(n,i){
				switch(n){
					case 'notecard':
						//rebuild the notecard left panel
						BuildNoteandGroups();
						//if curnote is not null
						if (curNote != null) {
							//show the updated note
							showNote(tmpi);
						}
						return true;
					case 'citation':
						return true;
					case 'bibliography':
						return true
					case 'noteOrganizer':
						//sets the note group in the note organizer
						setOrganizerNoteGroup(noteStore[tmpi]._notecardid.replace(/\"|\'/g,''),(groupid == 0? -1 : groupid));	
						return true;
					default:
						return true;
				}
			});
		}
	)	
}

/*
	function updatecitation
	Is used to update a custom made citation
	Params:
		index - the index in the citationlist json object of the citation to be updated.
		citationtext - the new citation text for the citation to be updated.
		pubmedid - the publication medium id of the citation to be updated.
		citationcontenttypeid - citation content type id of the citation to be updated.
		force - forces the bibliography not to update when this is done.
	returns none
*/


function updateCitation(index,citationtext,pubmedid,citationcontenttypeid, force) {
	//update the citation json object
	citationData[index]._citationtext = citationtext;
	citationData[index]._pubmediumid = pubmedid;
	citationData[index]._citationcontenttypeid = citationcontenttypeid;		
	//set a temp variable to save the citation id
	var tmpcitation = citationData[index]._citationid;
	$.get('/arch/citationajax.php',{action:'updatecitation',citationid:citationData[index]._citationid,citationtext:citationtext,citationcontenttypeid:citationcontenttypeid,pubmediumid:pubmedid},
		function(data) {
			//sort the new citationData object
			citationData.sort(callbackFunc);
			$.grep(toolsArray,function(n,i) {
				switch (n) {
					case 'citation':
						//rebuild the citation left panel
						BuildCitationList();
						//if there is a shown citation
						if (tmpcitationid != -1) {
							//if the view citation panel is open
							if (thisSource == 'viewCitation') {
								//if the updated citation is the shown citation
								if (tmpcitationid == tmpcitation) {
									//reshow with updated information
									showExistingCitation(tmpcitationid);	
								}
							//if the existing source panel is open
							} else if (thisSource == 'existSource') {
								//if the selected citation is the updated citaiton
								if (citationData[curCitation]._citationid == tmpcitation) {
									//reset the selected citation
									setExistingCitation($('#citation'+tmpcitation));
								}
							}
						}
						return true;
					case 'bibliography':
						//will force the bibliography not to update
						if (typeof(force) == 'undefined') {
							//updates the bibliography
							objBibliography.buildBibliography(objBibliography);
						}
						return true;
					default:
						return true;
				}
			});

		}
	);
}

/*
	function insertcustomcitation
	Is used to add a custom citation to the database.
	Params:
		index - the index of the new citation to be added.
		citationtext - the text of the new citation to be added.
		pubmediumid - the publictation medium id of the new citation to be added.
		citationsourcetype - the citation source type id of the new citation to be added.
		notecardid - the id of the note card the citation will be added to if there is one.
		force - forces the bibliography to not update.
	returns none
*/

function insertcustomcitation(index,citationtext,pubmediumid,citationsourcetype, notecardid, force) {
	//set the notecard id to 0 if the notecard id is not set
	if (typeof(notecardid) == 'undefined') notecardid = 0;
	//add the new citation object
	citationData[index] = new Object();
	citationData[index]._profileid = profileid;
	citationData[index]._assignmentid = assignmentid;
	citationData[index]._autocite = 0;
	citationData[index]._citationtext = citationtext;
	citationData[index]._pubmediumid = pubmediumid;
	citationData[index]._citationcontenttypeid = citationsourcetype;
	citationData[index]._citationtextarray = new Array();
	$.get('/arch/citationajax.php',{action: 'insertcustomcitation', bibliographyid: bibliographyid ,citationtext: citationtext, pubmediumid: pubmediumid, citationsourcetypeid: citationsourcetype,notecardid:notecardid}, 
	function(data) {
		//add the new citation id
		citationData[index]._citationid = data;
		//sort the citation objects
		citationData.sort(callbackFunc);
		//loop through the tools array
		$.grep(toolsArray,function(n,i){
			switch(n){
				case 'citation':
					//if the notecardid was set
					if (notecardid != 0) {
						//reset the note card form
						document.getElementById('noteForm').reset();
						//find the italicize iframe
						var italFrame = document.getElementById('italTextArea');
						if (italFrame.contentDocument) { //W3C standard compliant browsers
							var theIframecontent = 	italFrame.contentDocument;
						} else if(italFrame.contentWindow) { //browsers that support contentwindow
							var theIframecontent = 	italFrame.contentWindow.document;			
						} else if(italFrame.document) {//IE browsers
							var theIframecontent = 	italFrame.document;		
						}
						//set the innerHTML as nothing
						theIframecontent.body.innerHTML = '';
						//set the current note citation id equal to the new citation id
						noteStore[curNote]._citationid = data;							
						//change to the notecard
						noteChange('noteCard');
						//reshow the note
						showNote(curNote);
						//no current citation
						curCitation = -1;
					}
						//rebuild the citation list
						BuildCitationList();				
					return true;
				case 'bibliography':
				// if force is set do not update the bibliography
					if (typeof(force) == 'undefined') {
						//update the bibliography
						objBibliography.buildBibliography(objBibliography);
					}
					//if the note card id is not 0
					if (notecardid != 0) {
						//loop through the citations
						$.grep(citationData,function(m,l) {
							//if the citations match
							if (m._citationid == data) {
								//if the options html is set
								if ($('#citationDiv'+l).find('.options').html() != '') {
									//open and close the note card div in the bibliography
									objBibliography.closeNotecards(l);
									objBibliography.openNotecards(l);
								}
							}
						});
					}
					return true;
				case 'mywork_assignment_detail':
					getcitationcount();
					return true;
				default:
					return true;
			}
		});
	});
}

/*
	function deleteCitation
	Is used to delete a citation from the database.
	Params:
		index - the index of the citation to be deleted.
	returns none
*/

function deleteCitation(index) {
	$.get('/arch/citationajax.php',{action:'deletecitation','citationid':citationData[index]._citationid,assignmentid:assignmentid}, function(data) {
		//store the current citation id
		var citationid = citationData[index]._citationid;
		//find any notecards with the citation id
		$.grep(noteStore,function(n,i) {
			if (n._citationid == citationid) {
				//remove the citation from those notecards
				n._citationid = 0;	
			}
		});													
		//remove the citation from the citation json object
		citationData = $.grep(citationData,function(n,i){
			return(n._citationid != citationid);
		});
		//sort the citations
		citationData.sort(callbackFunc);
		//loops through the toolsarray
		$.grep(toolsArray,function(n,i){
			switch(n){
				case 'citation':
					//rebuild the citation id
					BuildCitationList();
					//change to the notecard
					noteChange('noteCard');
					//if there is a current notecard
					if(curNote != null) {
						//reshow that notecard
						showNote(curNote);
					}
					return true;
				case 'bibliography':
					//rebuild the bibliography
					objBibliography.buildBibliography(objBibliography);
					//loop through the bibliography
					$.grep(citationData,function(m,l) {
						if (m._citationid == citationid) {
							//open and close the notecard div
							objBibliography.closeNotecards(l);
							objBibliography.openNotecards(l);
						}
					});					
					return true;
				case 'mywork_assignment_detail':
					getcitationcount();
					return true;
				default:
					return true;
			}
		});
	});
}

/*
	function getcontextualhelp
	is used to get the contextual help of the tool specified
	Params:
		tool - the tool that the contextual help is being returned for.
		id - the id of the contextual help to be retrieved.
		callback - the function to run when the contextual help has been retrieved
	returns none
*/

function getcontextualhelp(tool,id, callback) {
	//chcek if the contextual help has already been retrieved
	if (typeof(tmpcontexthelp[tool+'-'+id]) != 'undefined') {
		//use the already retrieved contextual help in the callback function
		callback(tmpcontexthelp[tool+'-'+id]);
	} else {
		//get the contextual help
		$.get('cshelp?id='+id, function (data) {
			//store the contextual help
			tmpcontexthelp[tool+'-'+id] = data;
			//call the contextual help with the new data
			callback(data);
		});
	}
}

/*
	function getCitationList
	Is used to get a list of citations from the database.
	Params: none
	returns none
*/

function getCitationList() {
	$.getJSON('/arch/citationajax.php',{action: 'getcitationlist', bibliographyid:bibliographyid },
		function(data) {
			//sets the citation data object
			citationData = data.citationdata;
			//sorts the citation data object
			citationData.sort(callbackFunc);
			//loop through the toolsarray
			$.grep(toolsArray,function(n,i) {
				switch(n){
					case 'citation':
						getCitationListFinish();
						//get citation content types
						getCitationcontenttypelist();
						//get citation format examples
						getCitationformatexamplelist();
						return true;
					case 'bibliography':
						//if on the bibliography page
						if (isBibliography() == true) {
							//reset the bibliography object
							objBibliography = new Bibliography($('#myGroupsInner'));
							//initialize the bibliography object
							objBibliography.Init();	
						}
						return true;					
					default:
						return true;
				}						   
			});
	});
}

/*
	function getCitationcontenttypelist
	Is used to get the citation content type list from the database.
	Params: none
	returns none
*/

function getCitationcontenttypelist() {
	$.getJSON('/arch/citationajax.php',{action: 'getcitationcontenttypelist'},function(data) {
		//retrieve the citationcontenttype data
		citationcontenttypeData = data;
		//loop through the toolsarray
		$.grep(toolsArray,function(n,i) {
			switch(n) {
				case 'citation':
					//if the citation content type data length is not zero
					if (citationcontenttypeData.length != 0) {
						// and if the current panel is not the notecard
						if (thisSource != 'noteCard') {
							//rebuild the citation list
							buildContentList(1,citationcontenttypeData);
						}
					}
					return true;
				default:
					return true;	
			}
		});
	});
}

/*
	function getCitationcontenttypelist
	Is used to get the citation format example list from the database.
	Params: none
	returns none
*/

function getCitationformatexamplelist() {
	$.getJSON('/arch/citationajax.php',{action: 'getcitationformatexamplelist'},function(data) {
		//set the citation format example data object
		citationformatexampleData = data;
	});
}

/*
	function addcitationtonotecard
	associates a citation to a note card.
	Params: 
		citationid - the id of the citation to add to the note card.
		notecardid - the id of the note card that the citation is being added to.
	returns none
*/

function addcitationtonotecard(citationid, notecardid) {
	var tmpcitation = noteStore[curNote]._citationid;
	//set current notes citation id = current citation id
	noteStore[curNote]._citationid = citationid;	
	$.get('/arch/citationajax.php',{action: 'insertexistingcitation', citationid: citationid, notecardid: notecardid}, 
		function(data) {
			//loop through the toolsarray
			$.grep(toolsArray,function(n,i) {
				switch(n){
					case 'citation':
						//change to notecard
						noteChange('noteCard');
						//reload the current note
						showNote(curNote);
						curCitation = -1;
						return true;
					case 'bibliography':
						//loop through the citation object
						$.grep(citationData,function(m,l) {
							//if the citation id of the current citation is the same as the added one
							if (m._citationid == citationid) {
								//close the notecard div
								objBibliography.closeNotecards(l);
								//trigger the click on the "view notecards" link
								$('a#view'+l).click();							
							} else { 
								if (m._citationid == tmpcitation) {
									//close the notecard div
									objBibliography.closeNotecards(l);
								}
							}
						});
						return true;
					default:
						return true;

				}
			});
		});
}

/*
	function saveSourceOnScreen
	saves a citation that is displayed on the article pages.
	Params: 
		biliographyid - the bibliography id of the current assignment
		citationtextarray - Array - the array of citation text objects for the auto citation
		notecardid - the note card id to add the new citation to.
	returns none
*/

function saveSourceOnScreen(bibliographyid,citationtextarray,notecardid) {
	$.get('/arch/citationajax.php',{action: 'insertautocitation', bibliographyid: bibliographyid , mla: citationtextarray["'1'"], chicago: citationtextarray["'3'"], apa: citationtextarray["'2'"], notecardid: notecardid}, 	
	function(data) {
		//loop through the tools array
		$.grep(toolsArray,function(n,i) {
			switch(n){
				case 'citation':
					var newCitation = citationData.length;
					//build the new citation object
					citationData[newCitation] = new Object();
					citationData[newCitation]._profileid = profileid;
					citationData[newCitation]._assignmentid = assignmentid;
					citationData[newCitation]._citationid = data;
					citationData[newCitation]._autocite = 1;
					citationData[newCitation]._citationtext = '';
					citationData[newCitation]._pubmediumid = 0;
					citationData[newCitation]._citationcontenttypeid = 0;
					citationData[newCitation]._citationtextarray = citationtextarray;
					//rebuild the citation list
					BuildCitationList();
					//set the current note cards citation to the new citation
					noteStore[curNote]._citationid = data;
					//reset the notecard form
					document.getElementById('noteForm').reset();
					//change to the note card
					noteChange('noteCard');
					//show the current note card
					showNote(curNote);
					curCitation = -1;
					//restore the existing citation option
					restoreexistoption();
					return true;
				case 'bibliography':
					return true;
				default:
					return false;
			}
		})
	});
}

/*
	function sendRemoveCitation
	disassociates a citation from a note card.
	Params: 
		notecardid - the id of the note card that the citation is being added to.
		index - the index of the citation in the citation list JSON object
	returns none
*/

function sendRemoveCitation(notecardid,index) {
	$.getJSON('/arch/citationajax.php',{action: 'removecitation', notecardid: notecardid},function(data) {
		//loop thorugh the tools array
		$.grep(toolsArray,function(n,i){
			switch(n){
				case 'citation':
					//loop through the notecards
					$.grep(noteStore,function(n,i){
						//find the notecard that was specified
						if (n._notecardid == notecardid) {
							//change to the notecard panel
							noteChange('noteCard');			
							//set the notecard citation to none
							noteStore[i]._citationid = 0;
							//re show the note
							showNote(i);											
						}
					});
					return true;
				case 'bibliography':
					//loop thorugh the notecard objects
					$.grep(noteStore,function(n,i){
						if (n._notecardid == notecardid) {
							//remove the note card from the note card div
							$('#notecarddiv'+index).find('li#notecardli'+i).remove();
							//remove the citation id from the notecard
							noteStore[i]._citationid = 0;				
						}
					});
					return true;
				case 'mywork_assignment_detail':
					getcitationcount();
					return true;
				default:
					return true;
			}
		});
	});
}



/*
	function getworkzonehelp
	builds the contextual help for the workzone.
	Params: 
		divid - the id of the contextual help popup div.
		helpid - the contextual help id of the workzone tool.
		tmpthis - the jQuery object of the button clicked to display the contextual help popup
		title - the title of the contextual help box.
	returns false
*/

function getworkzonehelp(divid,helpid,tmpthis,title) {
	getcontextualhelp('workzone','help-'+helpid,function(data){
		var str='';
		//make the header for the contextual help popup
		str=str+'<h1>'+title+'</h1>';
		//build the container
		str+='<div class="contentOutline"><div class="content" id="contexthelpwz1"><div id="contexthelptoolwz1">'
		str=str+'<p>';	
		//sets the contextual help info in the popup
		var str2 = data
		str=str+str2;
		//close the container
		str=str+'</p>';	
		str=str+'</div></div></div>';
		//add the container to the page
		$('#'+divid).html(str);
		arrow=false;
		//open the popup
		$('#'+divid).balloon(tmpthis);
	}); 
	return false;
}

/*
	function gettasktoollist
	associates a citation to a note card.
	Params: 
		tasktypeid - the id of the type of task to get the tools associated to.
	returns none
*/
	
function gettasktoollist(tasktypeid) {
	mytasktoollist=null;
	$.getJSON("/arch/taskajax.php", {action: "gettasktoollist", tasktypeid:tasktypeid}, function(data) {
   		mytasktoollist=data;
		//loop through the tools array
		$.grep(toolsArray,function(n,i) {							   
			switch(n) {
				case 'workzone':
					//add the tools for the task into the get help popup
					displaytasktoollist(tasktypeid);
					return true;
				default:
					return true;
			}
		});
	});
}

/*
	function gettoolskillbuilderlist
	gets a list of skill builders associated to a certain tool
	Params: 
		tooltypeid - the id of the type of tool to get the skill biulders for.
	returns none
*/

function gettoolskillbuilderlist(tooltypeid)
{
	myskillbuildertool=null;
	$.getJSON("/arch/taskajax.php", {action: "gettoolskillbuilderlist", tooltypeid:tooltypeid}, function(data) {	
		myskillbuildertool=data;
		//loop through the tools array
		$.grep(toolsArray,function(n,i) {
			switch(n) {
				case 'workzone':
					//add the skill builders to the get help popup
					displayskillbuildertool();
					return true;
				default:
					return true;
			}
		});		
	});
}