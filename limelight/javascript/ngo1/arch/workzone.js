/** 
	@file: arch/outline.js
	@description: the page that holds the fucntions for the outline page

*/
$(function() {
	//make the links in the tools menu disabled if they need to be
	switchdisable();
});
var atlasWindow;

/*
	@author Nate Prouty (based on code originally written by Sam San)
	@method setAssignmentDetails
	@params json_assignmentlist - the assignment list json object
	@result depending on the page the user is on, carries out functionality after switching assignments
*/
function setAssignmentDetails(json_assignmentlist) {
	//make sure the json_assignmentlist is set before proceeding
	if (typeof(json_assignmentlist) == 'undefined') {
		setTimeout("setAssignmentDetails(json_assignmentlist)", 250);
	}
	$(function() {
		//loop through the assignment list and find the current assignment
		$.each(json_assignmentlist, function(i, val) {
			var id = val._assignmentid;
		
			if (id == currassgn) {
				//build the workzone information from the assignment object
				var title   = val._title;
				var duedate = val._duedate;
				var type    = val._assignmenttype;
				var completiondate = val._completiondate;
				
				$('.workzoneassignment').html('<a style="text-decoration:none; color:white;" href="\assignment">'+title+'</a>');
				$('.assignmenttitle').html(title);
				
				$('.dueDateValue').html(duedate);
				
				if (completiondate != null) {
					assignmentComplete = true;
				}
				else {
					assignmentComplete = false;
				}
			}
		});
	});
}


/*
	@author Nate Prouty (based on code originally written by Sam San)
	@method selectitem
	@params divid - the ID (css) of the select dropdown
	@result depending on the page the user is on, carries out functionality after switching assignments
*/
function selectitem(divid) {

	$('.projDaysLeft').css("visibility", "hidden");
	$('.percentCompleted').css("visibility", "hidden");

	var selectedclass = '';
	
	$(function() {
		selectedclass = $('select#curr_asgn option:selected').attr("class");
	});
	
	var index = document.getElementById(divid).selectedIndex;
	
	var assignid = document.getElementById(divid).options[document.getElementById(divid).selectedIndex].value; // Get the value of the selected index
	var title = document.getElementById(divid).options[document.getElementById(divid).selectedIndex].text; // Grabs the title of the selected assignment
	if (assignid != currassgn) {
		if (assignid > 0) {
					
			// dynamically add "mywork_assignment_list_ajax" to the tools array if the user is on the /mywork page	
			if (window.location.pathname == '/mywork') {
				addTool('mywork_assignment_list_ajax');
			}
	
			// dynamically add "mywork_assignment_detail_ajax" to the tools array if the user is on the /assignment page
			if (window.location.pathname == '/assignment') {
				addTool('mywork_assignment_detail_ajax');		
			}
			
			var asset_type = $.getURLParam('type');
			
			var asset_set = 'null';
			
			// dynamically add "mywork_assets" to the tools array if the user is on the assets page
			if (typeof(asset_type) == 'string') {
				addTool('mywork_assets');
				asset_set = asset_type;
			}
			
			
			updateassignmentid(assignid); // update the cookie by using assignment id
			
			var productid = PRODUCT_CODE;
			updateprofilecurrentassignment(productid, assignid); // updates the assignment associated with the current profile
			
		}	
		if (assignid == -1) { 		
			createnewassignment();
		}
		
		document.getElementById(divid).selectedIndex = 0;
		
	} else {
		document.getElementById(divid).selectedIndex = 0;
	}
				
	$('.projDaysLeft').css("visibility", "visible");
	$('.percentCompleted').css("visibility", "visible");
	return true;
}

/*
	@author Nate Prouty
	@method updateUserStats
	@params json_assignmentstats - the JSON object of assignment stats
	@result the user's stats are updated with the current information passed in by json_assignmentstats
*/
function updateUserStats(json_assignmentstats) {	

	var days 	 = json_assignmentstats["_daysleft"];
	var progress = json_assignmentstats["_progress"];
	var nexttask = json_assignmentstats["_nexttaskobj"];
	var progress = parseInt(progress * 100);
	//empty hte progress bar
	if(progress==0) {
		progress='0';
		$('div.tasksComp div.filler').css({'width':'0px'});
		$('div.tasksComp div.barLeft').css({'background':'url(/images/common/mzw_percent_bar_left_empty.jpg) no-repeat top left'});
		$('div.tasksComp div.endpt').css({'background':''});	
		$('div.tasksComp div.barRight').css({'background':'url(/images/common/mwz_percent_bar_right_empty.jpg) no-repeat top right'});
	} 
	
	if(progress < 100) {
				
		if(progress > 0) {
		//fill the progress bar depending on how much there is
			var len = 154 / 100 * progress + 5;

			$('div.tasksComp div.filler').css({'width':len+'px'});
			$('div.tasksComp div.barLeft').css({'background':'url(/images/common/mwz_percent_bar_left_filled.jpg) no-repeat top left'});
			$('div.tasksComp div.endpt').css({'background':'url(/images/common/mwz_percent_bar_endpt.jpg) no-repeat right'});
			$('div.tasksComp div.barRight').css({'background':'url(/images/common/mwz_percent_bar_right_empty.jpg) no-repeat top right'});
		}
		// singular and plural of day or days
		if(Math.abs(days)==1) {
			var str='day';		
		}		
		else {
			var str='days';	
		}
		//write the days
		if(days==0)
		{
			$('div.projDaysLeft').html('<p><em>' + days +'</em></p><p>'+ str+' left</p>');
			$('div.projDaysLeft').attr('id','projDaysLeft');
		} else if(days > 0) {	
			$('div.projDaysLeft').html('<p><em>' + days + '</em></p><p>'+ str+' left</p>');
			$('div.projDaysLeft').attr('id','projDaysLeft');
		} 
		else if (days < 0) {
			days=Math.abs(days);
			$('div.projDaysLeft').html('<p><em>' + days + '</em></p><p>'+ str+' late</p>');
			$('div.projDaysLeft').attr('id','projDaysLate');
		}
		// change font side if the project is not complete
		if (days > 99) {
			// Reduce the font size if the days left is over 99 days
			$('.projDaysLeft p em').css({'font-size':'16px', 'margin-left':'0'});
			$('#projDaysLeft p em').css({'font-size':'16px', 'margin-left':'0'});
		} else {
			$('.projDaysLeft p em').css({'font-size':'16px', 'margin-left':'0'});
			$('#projDaysLeft p em').css({'font-size':'16px', 'margin-left':'0'});
		}
		// end change font side
	} 
	else if (progress >= 100) {
		//make teh assignment complete
		showAssignmentComplete();
			
		var lenStr = '';
		
		if (isIE6 == true) {
			lenStr = '158px';
		}
		else {
			lenStr = '154px';
		}
		
					
		$('div.tasksComp div.filler').css({'width':lenStr});
		$('div.tasksComp div.barLeft').css({'background':'url(/images/common/mwz_percent_bar_left_filled.jpg) no-repeat top left'});
		$('div.tasksComp div.barRight').css({'background':'url(/images/common/mzw_percent_bar_right_filled.jpg) no-repeat top right'});
		$('div.tasksComp div.endpt').css({'background':'url(/images/common/mwz_percent_bar_filling_bg.jpg) no-repeat'});				
	}

	if (typeof(nexttask) != 'undefined' && nexttask != null) {
		var nexttasktitle = nexttask._description;
		
		
		// Sets "What's Next?"
		
		if (nexttasktitle != null) {
			$('a#wnGetMarkComp').show();
			var taskduedate = nexttask._duedate;
			var str = nexttasktitle + ' ' + taskduedate;
			if(str.length < 60)
			{
				str = str + '<br><br>';	
			}
			$('.whatnext').html(str);
			//var tasktype = parseInt(nexttask._tasktype.replace(/\'|\"/g,''));
			var tasktype = nexttask._tasktype;
			if (tasktype !== 6) {
				gettasktoollist(tasktype);				
			} 			
			else {
				getskillbuilderlist();
			}
		}
		else {
			$('.whatnext').html('You can start a new assignment, view your work or browse Expert Space.');		
			$('a#wnGetMarkComp').hide();
			getskillbuilderlist();
		}		
	}	
	else {
		$('a#wnGetMarkComp').hide();
		getskillbuilderlist();
	}

	$('.percentCompleted').html(progress);
	
	if (assignmentComplete) {
		showAssignmentComplete();
	}
	var assignmenttype = typeof(json_assignmentstats._assignmenttype) == 'undefined' ? (days == null? 1:2) : json_assignmentstats._assignmenttype;

	if (days == null && assignmenttype == 1) {
		$('#mystuff').show();
		$('#assignmentPlan').hide();
		$('#loggedin').hide();
	}
	else 
	{

		$('#mystuff').hide();
		$('#assignmentPlan').show();
		$('#loggedin').show();
		//$('#wnGetMarkComp').show();		
	}

	if ($('#workzoneSubsectInner').isopenloader() == true) {
		//$('#workzoneSubsectInner').stopLoader({loaderid:'workzoneLoading',fadeIn:true,fadeIntime:200});
		$('#workzoneLoading').hide();
		$('#workzoneSubsectInner').show();
	}

}


/* 
	@author Sam San
	@method displayskillbuilder
	@params myskillbuilder
	@result displays the given skill builder
*/
function displayskillbuilder(myskillbuilder) {
	//builds the skill builders for the get help popup
	$('#gethelptool').hide();
	var i=0;
	var str='';
	str = str + '<p>Skill Builders:</p>';
	str = str + '<ul>';
	while(i < myskillbuilder.length)
	{
		var id=myskillbuilder[i]._skillbuilderid;
		var url='/skill_builders';
		var title=myskillbuilder[i]._title;
		str = str + '<li><a href="#" onclick="showAssetWindow(\'/skillbuilder?id='+id+'\', 775, 480); return false;">'+title+'</a></li>';
		i++;
   }
	str=str+'</ul>';
	$('#gethelpskillbuilder').html(str); 
}

/* 
	@author Sam San
	@method displaytasktoollist
	@params tasktypeid
	@result displays the task tool list based on the given tasktypeid
*/
function displaytasktoollist(tasktypeid) {
	var str='';
	//builds the task tools part of the get help menu
	$('#gethelptool').show();

	if(mytasktoollist.length > 0) {
		str=str+'<p>What would you like to do?</p>';
		str=str+'<ul>';
	
		var i=0;
	
		while(i < mytasktoollist.length) {
			var tooltypeid=mytasktoollist[i]._tooltypeid;
			var url=gettoolurl(tooltypeid);
			var title=mytasktoollist[i]._title;
			
			if(url=='notecard') {
				str = str + '<li><a href="#" onclick="opennotecard();">'+title+'</a>';	
			} 
			else {
				str = str + '<li><a href="'+url+'"> '+title+'</a></li>';
			}
			i++;
		}
		gettaskskillbuilderlist(tasktypeid);
		
		str=str+'</ul>';
		$('#gethelptool').html(str);	
	} else {
		
		getskillbuilderlist();
		
	}
}

/* 
	@author Sam San
	@method displayskillbuildertask
	@params json_taskskillbuilderlist
	@result outputs the list of skill builders
*/
function displayskillbuildertask(json_taskskillbuilderlist)
{
	var str='';
	
	if(json_taskskillbuilderlist.length > 0) {
		str = str + '<p>Skill Builders:</p>';
		str = str + '<ul>';
	
		$(json_taskskillbuilderlist).each(function(i,val) {
			var skillbuilderid=val._skillbuilderid;
			var title=val._title;
		str = str + '<li><a href="#" onclick="showAssetWindow(\'/skillbuilder?id='+skillbuilderid+'\', 775, 480); return false;">'+title+'</a></li>';
		});
		str=str+'</ul>';
		$('#gethelpskillbuilder').html(str);	
	}
}

/*
	@author Sam San
	@method gettoolurl
	@params index
	@returns the tool url based on the index
*/	
function gettoolurl(index) {
	/*
		1=note card, 2=outline, 3=citation, 4=bibliography, 5=search, 6=dictionary, 7=atlas, 8=calendar
	*/
	var toolurl=new Array(0,'notecard','/outline','citation','/bibliography','/search','/dictionary','/atlas','/calendar','/note_organizer');
	
	return toolurl[index];
	
}

/*
	@author Sam San
	@method getskillbuilderurl
	@params index
	@returns the skill builder url based on the index
*/	
function getskillbuilderurl(index) {
	/*
		1=setting goal, 2=search, 3=taking notes, 4=Evaluate resource, 5=citing sources, 6=organizing note, 7=using outline
	*/
	var toolurl=new Array(0,'/skill_builders','/skill_builders','skill_builders','/skill_builders','/skill_builders','/skill_builders','/skill_builders');
	
	return toolurl[index];
	
}

var dictlink = false;
var atlaslink = false;
var tmpatlaslink = '';

function checkWindowClosed(windowobj) {
	if(!(windowobj!=null && windowobj && !windowobj.closed))
	{
		dictlink=false;		
	} else {
		dictlink=true;				
	}
}
function checkWindowClosedAtlas(windowobj) {
	if(!(windowobj!=null && windowobj && !windowobj.closed))
	{
		atlaslink=false;		
	} else {
		atlaslink=true;				
	}
}

var dict_atlas = false;

function opendictionary() {

	launchDictionary();
	$('#dictlink').html('Dictionary');
	$('#dictlink').css({'color':'#cccccc'});
	$('#dict_atlas').hide('slow');
	dictlink=true;
	dict_atlas=false;
		
	return false;
}

/* 
	@author Scholastic
	@method openatlas
	@params id
*/

function openatlas(id) {

if (id)
	{ 
	var AtlasURL = "/atlas?id="+id;
	}
	else
	{
	var AtlasURL = "/atlas";
	}  
	tmpatlaslink = $('#atlaslink').html();
	$('#atlaslink').html('Atlas');
	$('#atlaslink').css({'color':'#cccccc'});
	$('#dict_atlas').hide('slow');
	var atlaslink=true;
		 
	var puWidth = 720; var puHeight=650;
	
	atlasWindow = thePopup1.newWindow(AtlasURL, puWidth, 
puHeight, "Atlas", "no", "no", "no", "yes", "no", "no", 
(screen.width-puWidth)/2, (screen.height-puHeight)/2);

	
	return false;
}

/* 
	@author Scholastic
	@method getdictionaryatlas
	@params N/A
*/
function getdictionaryatlas() {
	 $('#note_tool_menu').hide("slow");
	 /* get the width and height of note_tool */						   
	 var left = $('#dict_tool').offset().left;
	 var top = $('#dict_tool').offset().top;
	 var height = $('#dict_tool').height();
	 var width = $('#dict_tool').width();
	 
	var leftVal= left  + (width/2) - 25 +  "px";
	var topVal= top + height - 10 + "px";
	
	checkWindowClosed(dictionaryWindow);
	checkWindowClosedAtlas(atlasWindow);
	//checks the atlas and dictionary links
	if(dictlink==false)
	{
		$('#dictlink').html('<a href="#" onclick="opendictionary();" title="Dictionary" >Dictionary</a>');
		$('#dictlink').css({color:'#666666'});
	}
	if (atlaslink==false) {
		if (tmpatlaslink == '') {
			$('#atlaslink').html('<a href="#" onclick="openatlas();" title="Atlas" >Atlas</a>');
		} else {
			$('#atlaslink').html(tmpatlaslink);
		}
		$('#atlaslink').css({color:'#666666'});			
	}
  
	if(dict_atlas==true)
	{
		$('#dict_atlas').hide('slow');
			  dict_atlas=false;
	} else {
		  $('#dict_atlas').css({left:leftVal,top:topVal}).show('slow');
		  dict_atlas=true;
		  
	}
	note_tool_menu=false;
	return false;
}

/*
	@author Sam San
	@method switchdisable
	@params N/A
	@result disables page links depending on what page the user is on (e.g., disables the "bibliography" link on the bibliography page)
*/
function switchdisable() {
	var str=window.location.href;
	var str=str.split('\/');
	var url=str[3];
	if (url.indexOf('#') != -1 ) {
		url = url.substring(0,url.indexOf('#'));	
	}
	if (url.indexOf('?') != -1 ) {
		url = url.substring(0,url.indexOf('?'));	
	}	
	//gets the url and makes the link for the matched url distabled
	switch(url) {
		case 'note_organizer': $('#tool_subsect li').eq(0).addClass('inactive'); 
			$('#tool_subsect li').eq(0).html('<a onclick="return false" id="note_tool"  title="Open note tool">Notes</a>');
			$('#note_tool_menu').hide("slow");
			$('#dict_atlas').hide("slow");
			note_tool_menu=true;
		break;
		case 'projectideas': $('#tool_subsect li').eq(1).addClass('inactive'); 
			 $('#tool_subsect li').eq(1).html('<a onclick="return false" id="proj_tool"  title="Open project ideas tool.">Project Ideas</a>'); 
			$('#note_tool_menu').hide("slow");
			$('#dict_atlas').hide("slow");
		break;			
		case 'bibliography': $('#tool_subsect li').eq(2).addClass('inactive'); 
			 $('#tool_subsect li').eq(2).html('<a onclick="return false" id="biblio_tool"  title="Open bibliography tool.">Bibliography</a>'); 
			$('#note_tool_menu').hide("slow");
			$('#dict_atlas').hide("slow");
		break;	
		case 'skill_builders': $('#tool_subsect li').eq(3).addClass('inactive');
			$('#tool_subsect li').eq(3).html('<a onclick="return false" id="skill_tool"  title="View all skill builders">Skill Builders</a>');
			$('#note_tool_menu').hide("slow");
			$('#dict_atlas').hide("slow");
		break;
		case 'outline': $('#tool_subsect li').eq(4).addClass('inactive');
			$('#tool_subsect li').eq(4).html('<a id="outline_tool" onclick="return false">Outline</a>');
			$('#note_tool_menu').hide("slow");
			$('#dict_atlas').hide("slow");
		break;
	}
	
	return false;
}

/* 
	@author Nate Prouty and Sam San
	@method createAssignmentDropDown
	@params json_assignmentlist - the JSON object of the list of assignments
	@result generates the list of assignments in the dropdown list, broken down between current and completed assignments
*/
function createAssignmentDropDown(json_assignmentlist) {
	//if the assignmentlist json object has not been created then try again in 250 milliseconds
	if (typeof(json_assignmentlist) == 'undefined') {
		setTimeout("createAssignmentDropDown(json_assignmentlist)", 250);
	}
		
	$(function() {
		//if the change_asgn dropdown has not been created then try again in 250 milliseconds	
		if ($('#change_asgn').length == 0) {
			setTimeout("createAssignmentDropDown(json_assignmentlist)", 250);
		}
		
		var complete_found = false;
		var stop_find = false;
		//builds the beginning of the dropdown
		var str="<option value='null' style='font-weight: bold;'>Start/Change Assignment</option>";
		str += "<option value='null' id='optline' disabled='disabled'>--------------------------------------</option>";
		// Changed 'Create New..' to -1 since a new assignment ID is known to be -1 and to keep it consistent as an INT - NP
		str += "<option value='-1'>Start new assignment</option>";
		str += "<option value='null' id='optline' disabled='disabled'>-------------------------------------</option>";
		
		var selectedclass = '';

		var json_currentlist = new Array();
		var json_completedlist = new Array();
		//sorts the assignment list by completed
		$.each(json_assignmentlist, function(i, val) {
		
			var completiondate 	= val._completiondate;
					
			if (completiondate == null) {
				json_currentlist.push(val);
			}
			else {
				json_completedlist.push(val);
			}	
			if (val._assignmentid == currassgn) {
				updateUserStats(val);	
			}
		});	
		//builds the current assignments
		if (json_currentlist.length != 0) {
			
			str += "<option value='null' disabled='disabled' style='font-weight: bold;'>Current Assignments</option>";
		
			$.each(json_currentlist, function(i, val) {
				var id				= val._assignmentid;
				var completiondate 	= val._completiondate;
				var assignmenttype 	= val._assignmenttype;
				var title			= val._title;

				str += '<option value="'+ id +'" class="' + selectedclass + '">' + title + '</option>';
			});
		}		
		//builds the completed assignments
		if (json_completedlist.length != 0) {
			str += "<option value='null' disabled='disabled' id='optline'>&nbsp;</option>";
			str += "<option value='null' disabled='disabled' style='font-weight: bold;'>Completed Assignments</option>";

			$.each(json_completedlist, function(i, val) {
				var id				= val._assignmentid;
				var completiondate 	= val._completiondate;
				var assignmenttype 	= val._assignmenttype;
				var title			= val._title;

				str += '<option value="'+ id +'" class="' + selectedclass + '">' + title + '</option>';
			});
		}
		//builds the change assignment dropdown
		$('#change_asgn').html(str);
	});
}
