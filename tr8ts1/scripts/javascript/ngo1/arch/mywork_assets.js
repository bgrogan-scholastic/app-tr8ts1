/** 
	@file: mywork_assignment_detail.js
	@description: This file is used on "Level 3" of the "My Work" series of pages and handles javascript actions used by that page.

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	mywork assignment details variables:
	
	options - This needs to be declared for use in the popup
	
**/	
function addslashes(str) {
str=str.replace(/\'/g,'\\\'');
str=str.replace(/\"/g,'\\"');
str=str.replace(/\\/g,'\\\\');
str=str.replace(/\0/g,'\\0');
return str;
}

var options = '';
// This needs to be declared for use in the popup

$(function() {
	bindClickSort(); // see below
});

/* 
	@author Nate Prouty
	@method displayAssetFolders
	@params json_stuffcollected
	@result displays the list of assets 
*/
function displayAssetList(json_stuffcollected) {

	if (typeof(json_stuffcollected) == 'undefined') {
		setTimeout("displayAssetList(json_stuffcollected)", 250);
	}
	
	var scrollContent = $('tbody.scrollContent').html("");
	
	var output = '';
	// loop through json_stuffcollected and output each item with the proper link for its type
	$.each(json_stuffcollected, function(i, val) {
					
		var asset_id = '';
		var asset_class = '';
		var asset_major = '';
		
		if (typeof(val._savedassetid) != 'undefined') {
			asset_major  = val._assetid;
			asset_id 	 = "asset_" + val._savedassetid;
			asset_value	 = val._savedassetid;
		}
		if (typeof(val._savedweblinkid) != 'undefined') {
			asset_id 	 = "link_" + val._savedweblinkid;
			asset_value  = val._savedweblinkid;
		}
		
		var asset_title 	 	= val._title;
		var asset_url 		 	= val._url;
		var asset_class	 	 	= val._digitallockerfoldertypeid;
		var asset_type_title 	= val._digitallockerfoldertitle;
		var asset_global_type	= val._type;
		var product_id = val._productid;
				
		var output = "<tr>\n";	
		output += "<td class='article_title'>\n";
			
		// Media
		if ((asset_global_type == '0mm') || (asset_global_type == '0mmg') || (asset_global_type == '0mmt') || (asset_global_type == '0mme')|| (asset_global_type == '0mmh')) {
			output += "<a href='#' onclick=\"thePopup1.newWindow("+ escape(asset_url) + ");\" title='" + asset_title + "'>" + asset_title + "</a>\n";
			
		}else if ((asset_global_type == '0ma') || (asset_global_type == '0mp') || (asset_global_type == '0mf')) {
			output += "<a href='#' onclick='$(\"#mainImagePopup\").popup({contentLoadPath:\"" + asset_url + "\"}); return false;' title='" + asset_title + "'>" + asset_title + "</a>\n";
		}
		// Project Ideas
		else if (asset_global_type == '0taj') {
			asset_title2 = asset_title.replace("'", "\\'");
	
			output += "<p class='eduTxt'><a href='#' onclick=\"loadIdea('"+product_id+"', '" + asset_major + "', '"+asset_title2+"'); return false;\">" + asset_title + "</a></p>\n";
		}
		// Video
		else if (asset_global_type == '0uv') {
			
			// Anchor Video
			if (asset_url == '') {
				output += "<a href='#' onclick='$(\"#video\").popup({contentLoadPath:\"/php/common/article/video_popup.php?id="+asset_major+"&product_id="+product_id+"\"}); return false;' title='" + asset_title + "'>" + asset_title + "</a>\n";
				
				//output += "<a class='play_video' href='" + asset_major + "' title='" + asset_title + "' name='Some Credits'>" + asset_title + "</a>\n";
			}
			// Link to Video
			else { 
			
				output += '<a href="' + asset_url + '" title="'+ asset_title + '">' + asset_title + '</a>';
				//output += '<a href="#" onclick="window.open(\'' + asset_url + '\', \'pops\'); return false;">' + asset_title + '</a>';			
			}
		}
		// Web Links
		else if (typeof(asset_global_type) == 'undefined') {
			output += '<a href="javascript:thePopup1.blurbWindow(\'' + asset_url + '\', 725, 600, \'gii\', \'on\');" title="'+ asset_title + '">' + asset_title + '</a>';	
			//output += '<a href="#" onclick="window.open(\'http://' + asset_url + '\', \'pops\'); return false;">' + asset_title + '</a>';			

		}
		
		// Catch All
		else {
			output += '<a href="' + asset_url + '" title="' + asset_title + '">' + asset_title + '</a>';
		}
		output += "</td>\n";
		output += "<td class='article_type'><span class='" + asset_class + "'>" + asset_type_title + "</span></td>\n"; 
		output += "<td class='select'><input id='" + asset_id + "' type='checkbox' class='" + asset_class + "' value='" + asset_value + "' /></td>\n";
		output += "</tr>\n";

		scrollContent.append(output);
		
	});	
	
	$('a.play_video').bind("click", function(e) {
		playVideo(e);
	});

	
	// Set every other row to have a different background color	
	$("tbody.scrollContent tr:odd").attr("class", "odd");
	
}


/* 
	@author Jeff Landry
	@method bindClickSort
	@params N/A
	@result sorts list of assets and handles modifying related actions, such as swapping icons
*/
function bindClickSort() {
	//find each element that will be used for sorting
	$('.sortableparent').each(function(i,obj){
		//on click of the element
		$(this).bind('click',function(e){
			//get the sortable direction and which sortable it is and sort the list based on that selection
			var tmpa = $(this).find('.sortable').attr('id').split('-')[0];
			var tmpb = $(this).find('.sortable').attr('id').split('-')[1];
			if (parseInt(tmpb) == 1) {
				$(this).find('.sortable').attr('id',tmpa+'-2');	
				changeSortType(parseInt(tmpa),2);
				$('.sortableparent').find('img').attr({'src':'/images/digital_locker/arrow.gif'}).css('display','none');
				$(this).find('img').attr({'src':'/images/digital_locker/arrow.gif'}).css({'display':'block'});
			} else {
				$(this).find('.sortable').attr('id',tmpa+'-1');
				changeSortType(parseInt(tmpa),1);
				$('.sortableparent').find('img').attr({'src':'/images/digital_locker/arrow_down.gif'}).css('display','none');				
				$(this).find('img').attr({'src':'/images/digital_locker/arrow_down.gif'}).css({'display':'block'});
			}
			lastsort = tmpa + '-' + tmpb;
		});
	});
}

/* 
	@author Jeff Landry
	@method changeSortType
	@params type - the sort type, way - sort direction
	@result modifies how the current json_stuffcollected object should be sorted
*/
function changeSortType(type,way){
	switch(type){
		case 1: //assets
			switch(way){
				case 1: //asc
					json_stuffcollected.sort(sortAssetsAsc);
					break;
				case 2://dec
					json_stuffcollected.sort(sortAssetsDec);
					break;
			}
			break;
		case 2://type
			switch(way){
				case 1://asc
					json_stuffcollected.sort(sortTypeAsc);
					break;
				case 2://dec
					json_stuffcollected.sort(sortTypeDec);
					break;
			}
			break;		
	}
	//reshow the asset list
	displayAssetList(json_stuffcollected);
}


/* 
	@author Nate Prouty
	@method getTypeName
	@params typeid
	@returns the name of the type for the given typeid
	@details This needs to be updated so that we're getting information 
	from the SOAP client and not hard coding values.
*/
function getTypeName(typeid) {
	switch(parseInt(typeid)) {
		case 1:
			return 'articles';
			break;
		case 2:
			return 'media';
			break;
		case 3:
			return 'web links';
			break;
		case 4:
			return 'magazines';
			break;
		case 5:
			return 'other';
			break;
		case 6:
			return 'xspaces';
			break;
		case 7:
			return 'project ideas';
			break;
		default:
			return null;
			break;
	}
}

/* 
	@author Jeff Landry
	@method sortAssetsAsc
	@params a - the first asset, b - the second asset
	@returns -1 if the title of a is less than b, 1 if the title of a is greater than b
*/
function sortAssetsAsc(a,b) {
	return (a._title.toLowerCase() < b._title.toLowerCase() ? -1 : 1);
}

/* 
	@author Jeff Landry
	@method sortAssetsDec
	@params a - the first asset, b - the second asset
	@returns 1 if the title of a is less than b, -1 if the title of a is greater than b
*/
function sortAssetsDec(a,b) {
	return (a._title.toLowerCase() < b._title.toLowerCase() ? 1 : -1);	
}

/* 
	@author Jeff Landry
	@method sortTypeAsc
	@params a - the first asset, b - the second asset
	@returns -1 if a is equal to b AND a's title is less than b's title OR a is less than b	
			  1 if a is equal to b AND a's title is greater than b's title OR a is greater than b
*/
function sortTypeAsc(a,b) {
	var tmpa = getTypeName(a._digitallockerfoldertypeid);
	var tmpb = getTypeName(b._digitallockerfoldertypeid);	
	if (tmpa == tmpb) {
		return (a._title.toLowerCase() < b._title.toLowerCase() ? -1 : 1);
	} else {
		return (tmpa < tmpb ? -1 : 1);
	}
}

/* 
	@author Jeff Landry
	@method sortTypeDec
	@params a - the first asset, b - the second asset
	@returns 1 if a is equal to b AND a's title is less than b's title OR a is less than b	
			-1 if a is equal to b AND a's title is greater than b's title OR a is greater than b
*/
function sortTypeDec(a,b) {
	var tmpa = getTypeName(a._digitallockerfoldertypeid);
	var tmpb = getTypeName(b._digitallockerfoldertypeid);	
	if (tmpa == tmpb) {
		return (a._title.toLowerCase() < b._title.toLowerCase() ? 1 : -1);
	} else {
		return (tmpa < tmpb ? 1 : -1);
	}
}

/*
	Called when the user clicks on a video asset on the /assets page
*/
function playVideo(e) {

	e.preventDefault();
	  
	 var str = loadAnchorVideo($(e.target).attr("href"),$(e.target).attr("title"));
	 	 	
	$("#video").popup();
	$("#video .content").html(str).append('<p align="left"><a href="#" class="showcredit" style="text-weight: none; font-size: 10px; padding-top: 10px; margin-left: 5px;" onClick="return false;">Credits</a></p><div align="center" class="assetcredit" style="width: 400px; height: 55px; display: none; overflow: auto; text-align: left; margin-left: 5px;">'+$(e.target).attr("name")+'</div>');
	$(".showcredit").bind('click', function(e){	
		e.preventDefault();
		
		if($(".assetcredit").css('display') == "none"){		
			$(".assetcredit").slideDown();
			$(".showcredit").html("Hide Credits");
		}
		else{ 
			$(".assetcredit").slideUp(); 
			$(".showcredit").html("Credits");
		}
	 });
}

// Loads the requested video
function loadAnchorVideo(vid, vtitle){
		var videoFile = vid+".flv"; 
		str1 = AC_FL_CreateRunContent(

		'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',

		'width', '580',

		'height', '420',

		'src', vid,

		'quality', 'high',

		'pluginspage', 'http://www.macromedia.com/go/getflashplayer',

		'align', 'middle',

		'play', 'true',

		'loop', 'true',

		'scale', 'showall',

		'wmode', 'opaque',

		'devicefont', 'false',

		'id', vid,

		'bgcolor', '#FFFFF',

		'name', 'Video',

		'menu', 'true',

		'allowFullScreen', 'true',

		'allowScriptAccess','always',

		'movie', '/limelight/flvplayers/ngoflvplayer?&flvfilename=rtmp://scholastic.fcod.llnwd.net/a1122/o16/ngo/' + limelight_env + '/'+videoFile+'&flvskinname=/limelight/skins/SkinUnderAllNoCaption.swf&baseurl=/limelight/',

		'salign', '');
		
		
return str1;
} //end function


/* 
	@author Nate Prouty
	@method displayTaskList
	@params json_tasklist - the JSON object of tasks
	@result outputs the list of tasks in "My Assignment Plan"
*/
function displayTaskList(json_tasklist) { 
	
	if ((($('#assignmentPlan').length == 0) || (typeof(json_tasklist) == 'undefined')) || (json_tasklist == '')) {
		setTimeout("displayTaskList(json_tasklist)", 250);
	}
	
	$('#assignmentPlan #tasks').html("");

	$.each(json_tasklist, function(i, val) {
	
		var task_id  = val._tasktypeid;
		var tasktype = val._tasktype;
		
		// User created tasks get their title from the description
		
		if (tasktype == 1) {
			var tasktitle = val._title;
			var taskclass = 'assignment_task';
		}
		else if (tasktype == 6) {
			var tasktitle = val._description;
			var taskclass = 'user_task';
		}
		else {
			var tasktitle = val._title;
			var taskclass = 'default_task';
		}
		
		var duedate = val._duedate;
	
		var input_id = "task" + i;
		var taskid = val._taskid;
		
		var evaluationLink = '';
		
		if ((tasktype != 1) && (tasktype != 6)) {
			var evaluationLink = "<a href='#' title='Answer questions about this task' onclick='getrubricquestionlist(" + tasktype + "," + task_id + ")'; return false;'>Self-evaluation</a>";
		}
			
		var task = "<li class=\"" + taskclass + "\"><input class=\"checkbox\" id=\"" + input_id + "\" name=\"" + tasktype + "\" type=\"checkbox\" value=\"" + taskid + "\" />" + tasktitle + " " + evaluationLink + "<br /><span>(" + duedate + ")</span></li>";
			
		$('#assignmentPlan #tasks').append(task);	// add the task to the task list

		// Check off the tasks that have been completed
		if (val._completiondate != null) {
			$('#assignmentPlan #tasks li #' + input_id).attr("checked", "checked");
		}
		
		$("#tasks #" + input_id).click(function(e) {
								
			var taskid = $(this).val();
			var assignmentchecked = false;
			var task_class = $(this).parent().attr("class");
			var tasktype = $(this).attr("name");
			//RECORD STAT HIT
			collectStat('assign','xs','save','');
			if ((task_class == 'default_task') && (e.target.checked)) {
				//getrubricquestionlist(tasktype, taskid); // see: ../pagemanager.js
			}	
			
			if ((task_class != 'assignment_task') && (e.target.checked)) {
				updatetaskcompletiondate(taskid);	// see: ../pagemanager.js
			}
			
			if ((task_class != 'assignment_task') && (!e.target.checked)) {
				marktaskincomplete(taskid);	// see: ../pagemanager.js
			}
			
			if ((task_class == 'assignment_task') && (e.target.checked)) {
				updateassignmentcompletiondate(taskid, 2); // see: ../pagemanager.js
			}
			
			if ((task_class == 'assignment_task') && (!e.target.checked)) {
				updateassignmentcompletiondate(taskid, 1); // see: ../pagemanager.js
			}
		});
	
	});
}


/* 
	@author Nate Prouty
	@method loadAssignmentList
	@params json_assignmentlist - the JSON object of assignments
	@result creates the list of assignments in the select dropdown
*/
function loadAssignmentList(json_assignmentlist) {

	// Clear the list
	$('select#selectAssignment').html("");
	$('select#selectAssignment').append('<option value="null">Select an assignment...</option>');
	$(function() {
		$.each(json_assignmentlist, function(i, val) {
			// Don't show the current assignment in the list
			if (val._assignmentid != currassgn) {
				var str = '<option value="'+json_assignmentlist[i]._assignmentid+'">'+json_assignmentlist[i]._title + '</option>';
				$('select#selectAssignment').append(str);
			}
		});
	});
}

/*
	Displays the self evaluation popup that appears when the user either clicks the "Self-evaluation" link or 
	marks a task that has a self evaluation as complete
*/

var rubricIdArray = new Array();

/* 
	@author Nate Prouty
	@method displaySelfEvaluation
	@params json_rubricquestionlist - the JSON object of rubric questions, taskid - the ID of the task
	@result outputs the list of rubric questions for the given task
*/
function displaySelfEvaluation(json_rubricquestionlist, taskid) {

	$(function() { 
		$('#selfEvaluation').popup();
		$('#selfEvaluation').css("text-align", "left");
		$('.selfEvalQuestions').html("");
		
		var evaluation = '';
		// Loop through the rubric questions and write the questions with any answers that they have.		
		$.each(json_rubricquestionlist, function(i, val) {
			
			var n = i+1;
		
			var inputid = val._tasktypeid + "-" + val._rubricquestionid;
			
			var questionid = val._rubricquestionid;
			
			rubricIdArray.push(inputid);
		
			evaluation += "<p>\n";
			evaluation += val._questiontext + "\n";
			evaluation += "</p>\n";
			
			evaluation += "<p class='input'>\n";
			evaluation += "<span class='" + n + "'><input id='" + inputid + "-yes' class='radio yes' name='" + inputid + "' type='radio' value='yes' /></span>\n"; 
			evaluation += "<label for='" + inputid + "-yes'>Yes</label>\n";
			evaluation += "<span class='" + n + "'><input id='" + inputid + "-no' class='radio no' name='" + inputid + "' type='radio' value='no' /></span>\n"; 
			evaluation += "<label for='" + inputid + "-no'>No</label>\n";
			evaluation += "</p>\n";
		});
		$('.selfEvalQuestions').html(evaluation);
		$('.selfEvalButtons').html("");
		
		var buttons = '';
		buttons += '<a href="#" title="cancel" id="popupCancel">';
		buttons += '<button class="cancel" onclick="$(\'#selfEvaluation\').popupClose(); return false;">Cancel</button>';
		buttons += '</a>';
		buttons += '<a href="#" title="submit" id="popupSubmit">';
		buttons += '<button type="submit" class="submit" onclick="setrubricanswers(' + taskid + '); return false;">Submit</button>';
		buttons += '</a>';

		$('.selfEvalButtons').html(buttons);
	});
}