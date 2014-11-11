/** 
	@file: mywork_assignment_list.js
	@description: This file is used by the /mywork page

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	mywork assignment list variables:
	
	s - check to see if the assignment has been changed by click or not
	
**/	
var s = null;
$(window).load(function() {
	//adds the click event for the assignment folders when they are clicked add the tool to the tools array and update the current assignment
	$('ul.assignments li a.assignment_item').click(function(e) {
		addTool('mywork_assignment_ajax');
		var clicked_id 	= $(this).attr("id");			
		s = 1;		
		updateprofilecurrentassignment('xs',clicked_id);
		collectStat('dlock','xs','save','');
		e.preventDefault();		
	});
});

/*
	@author Nate Prouty
	@method updateassignmentinfo
	@params clicked_id - the id of the new assignment that was clicked
	@result sets variables and goes to the next page
	@details this function is always called dynamically, never on page load
*/
function updateassignmentinfo(clicked_id){
	assignmentid = clicked_id;
	assignment_id = clicked_id;		
	updateassignmentid(clicked_id); // updates the cookie to the selected assignment
	window.location.href = '/assignment';
}

/*
	@author Nate Prouty
	@method createAssignmentList
	@params json_assignments - the JSON object of assignments
	@result outputs the list of assignments on the /mywork page, broken down by unassigned, current, and completed
	@details this function is always called dynamically, never on page load
*/
function createAssignmentList(json_assignments) {
	$(function() {
		$('ul.unassigned').html("");
		$('ul.assigned').html(""); // clear the list
		$('ul.completed').html("");
		
		var unassigned_count = 0;
		var current_count = 0;//clear the counts
		var completed_count = 0;	
		//loop through the assignments and build the assignment list based on unassigned, completed, and not completed.
		$.each(json_assignments, function(i, val) {
		
			var id 			= val._assignmentid;
			var type 	  	= val._assignmenttype;
			var completed 	= val._completiondate;
			var duedate     = val._duedate;
			var title 		= val._title;
		
			var folderpos = 'assign';
			
			if (type == 1) { // My Stuff
				
				if (unassigned_count & 1) {
					folderpos += ' right';
				}
				
				var unassigned_output = '<li class="' + folderpos + '"><a href="/assignment" id="' + id + '" class="assignment_item" title="' + title + '" onclick="return false;">' + title + "</a></li>\n";
				
				$('ul.unassigned').append(unassigned_output);
				
				unassigned_count++;
			}
			else {
				if (completed == null) {				
					if (current_count & 1) {
						folderpos += ' right';
					}
					
					var current_output = '';
					
					if (id == currassgn) {
					
						current_output = '<li class="' + folderpos + '"><a href="/assignment" id="' + id + '" class="assignment_item" title="' + title + '" onclick="return false;">' + title + '</a><br />Due: <span class="dueDateList">' + duedate + "</span></li>\n";
					}
					
					else {
						current_output = '<li class="' + folderpos + '"><a class="redX" title="Remove" href="#">X</a><a href="/assignment" id="' + id + '" class="assignment_item" title="' + title + '">' + title + '</a><br />Due: <span class="dueDateList">' + duedate + "</span></li>\n";
					}
					$('ul.assigned').append(current_output);
					
					current_count++;
				}
				else {
				
					if (completed_count & 1) {
						folderpos += ' right';
					}
				
					var completed_output = '';
					
					if (id == currassgn) {
						completed_output = '<li class="' + folderpos + '"><a href="/assignment" onclick="return false;" id="' + id + '" class="assignment_item" title="' + title + '">' + title + '</a><br />Due: <span class="dueDateList">' + duedate + "</span></li>\n";
					}
					else {
						completed_output = '<li class="' + folderpos + '"><a class="redX" title="Remove" href="#">X</a><a href="/assignment" id="' + id + '" class="assignment_item" title="' + title + '">' + title + '</a><br />Due: <span class="dueDateList">' + duedate + "</span></li>\n";
					}
					
					$('ul.completed').append(completed_output);
					
					completed_count++;
				}
			}

		});		
	});
	//on click of the remove assignment X button call the remove assignment function in the pagemanager
	$('.redX').click(function() {
		// on page load, mywork_assignment_list_ajax does not need to be in the tools array; but 
		// in order for the view to update with the updated list of assignment when an assignment 
		// is deleted, we add it to the tools array, which, when present, will cause createAssignmentList to be called
		addTool('mywork_assignment_list_ajax');
		var id = $(this).siblings('.assignment_item').attr("id");
		var name = $(this).siblings('.assignment_item').html();
		removeAssignment(id, name); // see: ../pagemanager.js
	});
		//adds the click event for the assignment folders when they are clicked add the tool to the tools array and update the current assignment
	$('ul.assignments li a.assignment_item').click(function(e) {
		addTool('mywork_assignment_ajax');
		var clicked_id 	= $(this).attr("id");			
		s = 1;		
		//RECORD STAT HIT
		collectStat('dlock','xs','save','');
		updateprofilecurrentassignment('xs',clicked_id);
		e.preventDefault();
	});
}