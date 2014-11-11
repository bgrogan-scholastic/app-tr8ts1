/* For Save */
var assetid = null; 
var sourceproductid = null;
var globaltype = null; 
var assettitle = null;

var assignid = null;
var assigntitle = null;

var weblink_url = '';
var weblink_type = '';
var weblink_title = '';
var weblink_location = '';
var lastsort = '1-1';

/*
	@author Unknown
	@method loadIdea
	@params projID - the ID of the project idea
	@result shows the given project idea in a popup
*/
function loadIdea(product_id, projId, proj_title) {

	$('#projIdea').popup({contentLoadPath:'/php/ngo1/projIdea.php?product_id='+product_id+'&id='+ projId}).end();
$("#projIdea .printButton a").click(function(e){
		e.preventDefault();
		showPrint(projId);
	});			
}

function showPrint(projId)
{
	
	var url = '/print?id=' + projId + '&type=0taj';
	popupWindow = thePopup1.newWindow(url, '600', '600', "dictionary", "no", 
			"no", "no", "yes", "no", "no", '200', '200');
}

/*
	@author Nate Prouty
	@method displaySaveFolderType
	@params typetitle - the type title to set
	@result updates every instance where class="sourcetypetitle" with this type title
*/
function displaySaveFolderType(typetitle) {
	
	$('.sourcetypetitle').html(typetitle);
}

/*
	@author Nate Prouty
	@method saveAssetToDL
	@params assetid_in, sourceproductid_in, globaltype_in, title_in, uid_in
	@result populates the save popup and sets global variables to be used with doSave() to save the given asset 
	
	dkp - 8\7 - added uid as a parameter 
*/
function saveAssetToDL(assetid_in, sourceproductid_in, globaltype_in, title_in, uid_in) {
	
   	getglobaltypesdigitallockerfoldertype(globaltype_in);	// see: pagemanager.js
   
   	assetid = assetid_in;
   	uid = uid_in;
	sourceproductid = sourceproductid_in;
	globaltype = globaltype_in;
	assettitle = stripslashes(unescape(title_in));
	
	//console.log(assettitle);

   	$(function() { 
   		$('.asset_title').html(assettitle);		
		getassignmentassetlist(assetid, sourceproductid, globaltype, true);		// see: pagemanager.js
		$('#saveToDigitalLocker').popup(); // popup the Save dialog
		buildProjectList(json_assignmentlist); // rebuilds the project list in the "Save" popup (see below)
		$('.alreadysaved').html("");
	});
}

/*
	@author Nate Prouty
	@method saveWebLinkToDL
	@params url_in, weblinktype_in, title_in, location_in
	@result populates the save popup (for weblinks) 
*/
function saveWebLinkToDL(url_in, weblinktype_in, title_in, location_in) {

	weblink_url = url_in;
	weblink_type = weblinktype_in;
	weblink_title = stripslashes(unescape(title_in));
	weblink_location = location_in;
		
	$(function() {	
		$('.sourcetypetitle').html("Web Link");
		$('.asset_title').html(weblink_title);
		
		$('#saveLinkToDigitalLocker').popup();
		saved_to = [];
		buildProjectList(json_assignmentlist); // rebuilds the project list in the "Save" popup (see below)
	});
}

/*
	@author Nate Prouty
	@method buildProjectList
	@params json_assignmentlist - the JSON object of assignments
	@result creates the select dropdown of assignments, breaking them up by "Not saved to" and "Already saved to" 	
*/
function buildProjectList(json_assignmentlist) {
	
	$(function() {
		// In case this function gets called before the popup is ready, we need to delay continuing the function execution
		if ($('.projectName').length == 0) {
			setTimeout("buildProjectList(json_assignmentlist)", 250);
		}
	
		var i=0;
	
		var new_data = new Array(); // Assignments that have not saved the current asset
		var old_data = new Array(); // Assignments that have saved the current asset


		/*
			Cycle through all the assignments and place them in appropriate array, using "saved_to", which stores a list of assignments that 
			have saved the current asset. A special Array method, findAssetAssign (see: srm_utils.js), determines if the assignmentid passed to
			it has saved the assetid passed to it.
		*/ 	
		while(i < json_assignmentlist.length) {
			var str = '';
			var inarray = saved_to.findAssetAssign(json_assignmentlist[i]._assignmentid,assetid);
	
			// Default the current assignment as the selected item
			if (currassgn == json_assignmentlist[i]._assignmentid) {
				str = str + '<option value="'+json_assignmentlist[i]._assignmentid+'" selected="true ">'+json_assignmentlist[i]._title + '</option>';
			}
			else {
				str = str + '<option value="'+json_assignmentlist[i]._assignmentid+'">'+json_assignmentlist[i]._title + '</option>';
			}
	
			if(inarray === false)
			{
				new_data.push(str);
			}
			else {
				old_data.push(str);
			}
			i++;
		}
	
		var new_count = new_data.length;
		var old_count = old_data.length;
		
		var j=0;
		$('.projectName').html("");	// Clear the select dropdown
	
		// Add the new assignments to the drop down first
		var newStr = '';	
		while (j < new_count) {
			newStr = newStr + new_data[j];
			j++;
		}
	
		j = 0;
		
		// Place the already saved to assignments at the bottom, below "Already saved to:" 
		var oldStr = '';
		if (old_count > 0) {
			oldStr = oldStr + '<option value="" disabled="disabled">Already saved to:</option>';
			while (j < old_count) {
				oldStr = oldStr + old_data[j];
				j++;
			}
		}
	
		var output = newStr + oldStr; // Group the list
		
		// Build the select drop down
		$('.projectName').html(output);
		if ($.browser.msie && parseInt($.browser.version()) == 7) {
			$('.projectName').find('option[value='+currassgn+']').attr('selected','selected');
		} else if($.browser.msie && parseInt($.browser.version()) == 6) {
			setTimeout("$('.projectName').find('option[value='+"+currassgn+"+']').attr('selected','selected')",200);
		} else {
			$('.projectName').find('option[value='+currassgn+']').trigger("click").trigger("mousedown").trigger("mouseup");
	
		}
	});
}

/*
	@author Nate Prouty
	@method selectAll
	@params N/A
	@result selects all the assets in the current list
*/
function selectAll() {
	$(function() {
		$('.scrollContent input:checkbox').attr("checked", "checked");
	});
}

/*
	@author Nate Prouty
	@method selectNone
	@params N/A
	@result deselects all selected assets in the current list
*/
function selectNone() {
	$(function() {
		$('.scrollContent input:checkbox').removeAttr("checked");
	});
}

/*
	@author Nate Prouty
	@method copySelected
	@params assignmentid - the id of the assignment, checked - the array of checked assets
	@result each asset that is checked is passed to copysavedcontent for copying the asset
*/
function copySelected(assignmentid, checked) {
	$(function() {
		warning({
			title:'Message',
			msg: 'Are you sure you want to copy these assets to the selected assignment?',	
			noAction: function(){
			},
			yesAction: function(){		
				$.each(checked, function(i, val) {
					var contentid = $(val).val();
					var contenttype = $(val).attr("class");
					
					// copysavedcontent() is in pagemanager.js
					copysavedcontent(contentid, contenttype, assignmentid);
				});		
			}
		});
		
		// reset the drop down of the list of assignments at the bottom of the page to the first item in the list
		document.getElementById('selectAssignment').selectedIndex = 0;
	});
}

/*
	@author Nate Prouty
	@method moveSelected
	@params assignmentid - the id of the assignment, checked - the array of checked assets
	@result each asset that is checked is passed to movesavedcontent for moving the asset
			removeMovedJSON is called to remove the moved asset from the current view
*/

function moveSelected(assignmentid, checked) {
	$(function() {
		warning({
			title:'Message',
			msg: 'Are you sure you want to move these assets to the selected assignment?',	
			noAction: function(){
			},
			yesAction: function(){				
				$.each(checked, function(i, val) {
					var contentid = $(val).val();
					var contenttype = $(val).attr("class");
						
					// movesavedcontent is in pagemanager.js
					movesavedcontent(contentid, contenttype, assignmentid);
					removeMovedJSON(contentid, contenttype);
				});	
				$(checked).parent().parent().hide();


			}
		});
		
		document.getElementById('selectAssignment').selectedIndex = 0;
	});
}

/*
	@author Jeff Landry
	@method removeMovedJSON
	@params contentid - ID of the content that was moved, contenttype - Type of the content that was moved
	@result removes the moved asset from the current view
*/

function removeMovedJSON(contentid, contenttype) {
	json_stuffcollected = $.grep(json_stuffcollected,function(n,i) {
		if (parseInt(contenttype) == 3) {
			if (typeof(n._savedweblinkid) != 'undefined') {
				return (n._savedweblinkid != contentid);
			} else {
				return true;
			}		
		} else {
			if (typeof(n._savedassetid) != 'undefined') {
				return (n._savedassetid != contentid);
			} else {
				return true;
			}
		}
	});
	displayAssetList(json_stuffcollected);
}

/*
	@author Nate Prouty
	@method deleteSelected
	@params checked - the array of checked assets, type_param - the type, retrieved from the URL parameter "type"
	@result each asset that is checked is deleted
*/
function deleteSelected(checked, type_param) {
	
	$(function() {
		warning({
			title:'Message',
			msg: 'Are you sure you want to remove the selected assets from this assignment?',	
			noAction: function(){
			},
			yesAction: function(){					
				$.each(checked, function(i, val) {
					var contentid = $(this).val();
					var contenttype = $(this).attr("class");
					deletesavedcontent(contentid, contenttype, type_param);	// see: pagemanager.js
				});	
			}
		});
		
		// Reset the drop down at the bottom of the My Work page to the first item
		document.getElementById('selectAssignment').selectedIndex = 0;
	});
}
	
/*
	action: the action to perform
	
	This function is called in order to perform any necessary checks/cleanup prior to calling the actual action.
*/
/*
	@author Nate Prouty
	@method doAction
	@params action - the action to perform
	@result the requested action is performed (copy, move, or delete)
*/
function doAction(action) {

	// Gets the assignmentid from the selected item in the dropdown
	$(function() {
		var assignmentid = 	$('select#selectAssignment option:selected').val();	
		
		var num_checked = $('.scrollContent input:checked').length;	// The number of assignments the user has checked
		var checked = $('.scrollContent input:checked');	// Creates an array of checked items
					
		var messages = new Array();	// Stores any messages that need to be displayed to the user
					
		if (num_checked == 0) {
			messages.push("Please select at least one asset");
		}		
		
		if ((assignmentid == 'null') && (action != 'deleteSelected')) {
			messages.push("Please select an assignment");
		}
		
		if (window.location.pathname == 'assignment') {
			// Add the tool mywork_assignment_detail_ajax if the user is on the /assignment page.
			addTool('mywork_assignment_detail_ajax');
		}
					
		/*  Output the messages as a warning, if there are any.
			Ceases execution of the actions, because a message 
			means something needs to be addressed by the user first.
		*/
		if (messages.length > 0) {
		
			var message = '';
			
			for (var i=0; i<messages.length; i++) {
				message += messages[i] + "<br />";
			}
		
			warning({
				title:'Message',
				msg: message,	
				buttons: 'OK,null'
			});
		}
		/*
			Call the appropriate action if there are no messages.
			"type_param" is retrieved from the URL parameter "type"
		*/
		else {

			var get_type = $.getURLParam("type");
		
			var type_param = '';
			
			if (typeof(get_type) == 'string') {
				type_param = get_type;
			}
			else {
				type_param = 'null';
			}
			//RECORD STAT HIT
			if(profileid == '4.6002370900'){ collectStat('dlock','xs','save',''); alert('jptest');}			
			switch (action) {
				case 'copySelected':
					copySelected(assignmentid, checked);
					break;
				case 'moveSelected':
					moveSelected(assignmentid, checked);
					break;
				case 'deleteSelected':
					deleteSelected(checked, type_param);
					break;
				default:
					break;
			}
		}
	});
}
	
/*
	Displays the calendar widget in the "My Assignment Plan" side bar on the My Work page
*/
function displayCalendar() {
	$(function() {
		if ($('#calendar').length == 0) {
			setTimeout("displayCalendar()", 250);
		}
		$('#calendar').datepicker( 
			{navigationAsDateFormat: true,
			clearText: 'Erase', 	
			hideIfNoPrevNext: false,
			prevText: '', 
			nextText: '', 
			changeYear: false,
			showStatus: false,
			currentText:'', 
			firstDay:0,
			_currentClass: 'highlite',
			changeMonth: false, 
			changeFirstDay: false, 
			highlightWeek: false, 
			highlightDays: false,
			rangeSelect: false, 
			gotoCurrent: true  
		});
		if ($.browser.msie && parseInt($.browser.version()) < 7) {
			$('.ui-datepicker-current-day').trigger('mouseout');
		}
		$('#calendar').find('a').each(function(){
			$(this).replaceWith($('<p>'+$(this).html()+'</p>'));
		});
		$('#calendar').find('td').unbind('click').unbind('mousout');
		$('#calendar').find('*').unbind('click').unbind('mouseup').unbind('mousedown');
		$('#calendar').unbind('click').unbind('mouseup').unbind('mousedown');
	});
}
