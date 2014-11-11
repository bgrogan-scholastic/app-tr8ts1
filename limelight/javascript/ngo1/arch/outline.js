/** 
	@file: arch/outline.js
	@description: the page that holds the fucntions for the outline page
	
	outline variables:
	
	saveandcancelform=holds the information for the
	mychoice=the choice that the user makes on the selection page
	mymessage= the message for importing both note and group titles
				   
	mymessage2=the message if the user decides to create a new outline
	
	mymessage3=the message if the user is editing an outline
				   
	mynotegroupflag=if the user selected the group option the value is 1 otherwise 0
	mynotetitleflag=if the user selected the note card option the value is 1 otherwise 0
	
	index= the index of the current li
	hoverflag=whether the li is being hovered
	originaldata=the origional save and cancel form
	outlineid= the current outline id
	outlinelist=the list of outline lines
	outlineIsOpen=whether the outline is open
	outlinesaveflag=whether the outline is saved
*/
/* This message text use to display on the outline page. There are 3 different type messages */
var saveandcancelform='<input type="button" value="Add New Line" name="add_new_line"  id="add_new_line" class="truebutton first" onClick="addnewoutline();"/>'+
   '<input type="button" value="Cancel" name="cancel" id="cancelbutton" class="truebutton" onClick="canceloutline();"/>'+
   '<input type="button" value="Save" name="save" id="savebutton" class="truebutton" onclick="javascript:saveoutline();" /> ';
   
var mychoice=0;
var mymessage="You've selected to import your Groups and Note card titles. You can drag and drop the groups to reorder " + 
               "your sections.  You can also modify and indent or outdent each line by dragging and dropping left or right.";
			   
var mymessage2="You've selected to create an outline from scratch."+' Click the "Add new line" button to begin, then drag and drop to indent or outdent lines.';

var mymessage3="To edit your outline, drag and drop the groups to reorder your sections. You can also modify and indent or outdent each line "+
				"by dragging and dropping left or right." ;
			   
var mynotegroupflag=0; // Take value 0 or 1
var mynotetitleflag=0; // Take value 0 or 1

var index=0; // store the index of li 
var hoverflag=false;
var originaldata=''; // store original data for save or cancel.
var outlineid=0;
var outlinelist=null;
var outlineIsOpen=0;
var outlinesaveflag=0; // 0 for initial load, 1 for save, 2 for cancel and sort move

/*
	function updateoutline
	updates the cookie when the user changes the assignment in the workzone
	Params: 
		assignmentid - the id of the assignment to be used as the outline id
	returns nothing
*/
function updateoutline(assignmentid) {	

	var currid = cookiereader.getoutlineid();

	cookiereader.updateSubCookie("outlineid", assignmentid); // outlineid = assignid
	
	outlineid = cookiereader.getoutlineid();
	
}



/*
	function checkoutlinesave
	check the outline to see if it has been saved.
	Params: none
	returns nothing
*/
function checkoutlinesave()
{
	
	if(outlinesaveflag==2)
	{
		return false;
	} else {
		return true;	
	}

}


/*
	function canceloutline
	when you click the cancel button will reload the last saved outline or the create a new outline.
	Params: none
	returns nothing
*/
function canceloutline()
{

	if(originaldata=='')
	{
		//resets the flags the directions and the outline
		outlinesaveflag=0;
		originaldata='';
		mynotegroupflag=0; 
		mynotetitleflag=0; 
		$('#directions').html("Would you like to create a new outline, or use your folder groups and notecard titles, from your Note Organizer?");
		$('#outlineButtons').html('');
		displayoutlineform();
	} else {
		// *** reverse to last save **** 
		$("#myGroupsInner").html(originaldata);
		changeLevelLines();
		outlinehover();		
		
	}
	$("#cancelbutton").attr("disabled","disabled");
	$("div.ajax").html('');
}


/*
	function displayoutline2
	displays the outline when the user selectes import
	Params: none
	returns nothing
*/
function displayoutline2(){
	assignmentid=currassgn;
	$('#directions').html(mymessage);
	$('#direction').show();
	$('#outlineButtons').html(saveandcancelform);
	$('#outlineButtons').show();
	
	if(mychoice==2){
		// A user create a new outline from notecard and group
		if((mynotegroupflag==1)&&(mynotetitleflag==1)){
				getoutlinetitleandgroup();
		} else{
			//just group
			if(mynotegroupflag==1){
				getoutlinegroup();
			} else {
				//just notecard
				if(mynotetitleflag==1){
					getoutlinetitle();	
				}
			}
		}
		treesorting();																																										
		outlinehover();	
	} else {
		// A user create a new outline from scratch.
		$("#myGroupsInner").html('<ol class="page-list" id="levelone"></ol><div id="tmpdiv" style="width:100px;"></div>');
		createnewoutline();	
	}
	outlineIsOpen=1;
}

/*
	function getoutlinegroup
	displays the outline with groups only
	Params: none
	returns nothing
*/
// get outline from notecard by group. Then display to the page.
function getoutlinegroup()
{
	var counter=0;
	var str="<ol id='levelone' class='page-item1'>";
	var str2='';
	//loop through the group and build the groups for the outline
	for(var i=0; i < groupStore.length; i++)
	{
	
		var groupid=groupStore[i]._groupid;
		var title=groupStore[i]._title;
		str=str+"<li class='page-item1' id='list-"+counter+"' level='1'><div class='sort-handle'><div class='outlineline'>"+title+'</div>';
		str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		str=str+"</div><div class='levelOne level'></div></li>";
		counter++;
		
	}
	str=str+"<li class='page-item1' id='list-"+counter+"' level='1'><div class='sort-handle'><div class='outlineline'>"+'Uncategorized</div>';
	str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
	str=str+"</div><div class='levelOne level'></div></li>";
		
	str = str + "</ol>";
	str = str + '<div id="tmpdiv" style="width:100px;">';
	//write the groups to the page
	$("#myGroupsInner").html(str);
	$('#tmpdiv').append($(str2));	
	if(groupStore.length==0)
	{
		$("div.ajax").html('');
		$('div.ajax').hide('slow');	
	}
}

/*
	function getoutlinetitle
	gets outline from notecard only
	Params: none
	returns nothing
*/
function getoutlinetitle()
{
	var counter=0;
	var str="<ol id='levelone' class='page-item1'>";
	var	str2='';
	//loop through the notes and biuld the outline from them
	for(var i=0; i < noteStore.length; i++)
	{
	
		var notecardid=noteStore[i]._notecardid;
		var title=noteStore[i]._title;
		str=str+"<li class='page-item1' id='list-"+counter+"' level='1'><div class='sort-handle'><div class='outlineline'>"+title+'</div>';
		str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		str=str+"</div><div class='levelOne level'></div></li>";
		counter++;
		
	}
	if(noteStore.length==0)
	{
		$("div.ajax").html('');
		$('div.ajax').hide('slow');	
	}
	str = str + "</ol>";
	str = str + '<div id="tmpdiv" style="width:100px;">';
	//write the notes to the page
	$("#myGroupsInner").html(str);
		$('#tmpdiv').append($(str2));	
}

/*
	function getoutlinetitleandgroup
	gets both the note cards and groups to import into the outline
	Params: none
	returns nothing
*/
function getoutlinetitleandgroup()
{

	var counter=0;
	var uncat='';
	var str="<ol id='levelone' class='page-item1'>";
	var str2='';
	//loop through the groups and the notecards and use the groups as the main level with the notes being a lower level
	for(var j=0; j < groupStore.length; j++)
	{
		var groupid=groupStore[j]._groupid;
		var title=groupStore[j]._title;
		str=str+"<li class='page-item1' id='list-"+counter+"' level='1'><div class='sort-handle'><div class='outlineline'>"+title+'</div>';
		str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		str=str+"</div><div class='levelOne level'></div>";
		str=str+'<ol id="leveltwo" class="page-item1">';
		for(var i=0; i < noteStore.length; i++)
		{
	
			var notetitle=noteStore[i]._title;
			if(groupid==noteStore[i]._groupid)
			{
				counter++;
				str=str+"<li class='page-item1' id='list-"+counter+"' level='2'><div class='sort-handle'><div class='outlineline'>"+notetitle+'</div>';
		str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		str=str+"</div><div class='levelTwo level'></div></li>";
			} 
		
		}
		str=str+'</ol></li>';
		counter++;
	}
	// this for uncategorized group
	if(noteStore.length > 0)
	{
		counter++;
		str=str+"<li class='page-item1' id='list-"+counter+"' level='1'><div class='sort-handle'><div class='outlineline'>"+'Uncategorized</div>';
		str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		str=str+"</div><div class='levelOne level'></div>";
		str=str+'<ol id="leveltwo" class="page-item1">';
		for(var i=0; i < noteStore.length; i++)
		{
			if(noteStore[i]._groupid==0)
			{
				counter++;
				var notetitle=noteStore[i]._title;
				str=str+"<li class='page-item1' id='list-"+counter+"' level='2'><div class='sort-handle'><div class='outlineline'>"+notetitle+'</div>';
				str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
				str=str+"</div><div class='levelTwo level'></div></li>";	
			}
		}
		str=str + '</ol></li>';
	} else {
		
		$("div.ajax").html('');
		$('div.ajax').hide('slow');
	}
	str = str + "</ol>";
	str = str + '<div id="tmpdiv" style="width:100px;">';
	//write the new outline to the page.
	$("#myGroupsInner").html(str);
		$('#tmpdiv').append($(str2));	
	

}


/*
	function treesorting
	JQuery Nested Sorting Tree. When a user drag and drop outline, it call changeLevelLines(). 
	So it changed different level of outline that will use for save and outline format.
	Params: none
	returns nothing
*/

function treesorting()
{
		$("#myGroupsInner").tree({
		dropOn: "ol",
		cursor: "move",
		placeholder: 'ol', 
		containment: 'ol',
		tabSize: 20, 
		maxDepth: 6,
		maxDepthError: 'ui-tree-deptherror',
		maxDepthErrorText: 'Only 6 levels are allowed!',
		maxItems: [30], 
		maxItemsError: 'ui-tree-limiterror', 
		maxItemsErrorText: 'You have reached the maximum number of items for this level!',
		afterChange: function(e,ui,level) {
			changeLevelLines();
			outlinesaveflag=2;
			$("#cancelbutton").removeAttr("disabled");
			$("#savebutton").removeAttr("disabled");
			
		}
		
	});
		
	
}

/*
	function checkLevelLines
	changes the outline line level css
	Params: none
	returns nothing
*/
function changeLevelLines(){
	//finds each li and rebuilds the outline based on which level the lines are on
	var tmpuis = $('#myGroupsInner').find('li');
	tmpuis.each(function(n,i) {
		var uilevel = $(this).parents('ol').length;
		switch (parseInt(uilevel)) {
			case 1:
				$(this).find('div.level:first').attr('class','levelOne level');
				$(this).attr("level",1); // this level for outline serialize so it know different level
				break;				
			case 2:
				$(this).find('div.level:first').attr('class','levelTwo level');	
				$(this).attr("level",2);
				break;				
			case 3:
				$(this).find('div.level:first').attr('class','levelThree level');	
				$(this).attr("level",3);
				break;				
			case 4:
				$(this).find('div.level:first').attr('class','levelFour level');
				$(this).attr("level",4);
				break;				
			case 5:
				$(this).find('div.level:first').attr('class','levelFive level');
				$(this).attr("level",5);
				break;				
			default:
				$(this).find('div.level:first').attr('class','levelOne level');
				$(this).attr("level",1);
				break;
		}
	});	
}

/*
	function outlinehover
	hover function for the outline edit and delete links.
	Params: none
	returns nothing
*/

function outlinehover()
{
	var len=0;
	//set the hover event (mouseon/mouseout)
		$('div.sort-handle').hover(function() {
			// This section is for rollover
			$('.moveright').css('display','none');
			len=$('#myGroupsInner input').length;
			if(len==0)
			{
				//get the information from the outline to set the placement of the options
				var tmptop = $(this).offset().top+'px';
				var tmpleft = $('#savebutton').offset().left + 'px';
				var position = 'absolute';
				var id=$(this).parent().attr('id').replace('list-','');
				//move the options to the area that is specified by each line
				$('#moveright'+id).css({'position':position,'left':tmpleft, 'top':tmptop, 'display':'block'});
			}
			
		},
		function(e) {
				// This section for rollout
				e.preventDefault();
				if (!e) var e = window.event;
				//find the element that is being hovered out to
				var relTarg = e.relatedTarget || e.toElement;
				//if the element is returned null or undefined hide the options
				if (typeof(relTarg) == 'undefined' || relTarg == null) {
					$('.moveright[value='+$(this).parent().attr('id').replace('list-','')+']').css('display','none');
					return false
				}
				//if the element is a div and is not the move right div then hide the options
				if (relTarg.tagName.toLowerCase() == 'div'){
					if ($(relTarg).hasClass('moveright') != true) {
						$('.moveright[value='+$(this).parent().attr('id').replace('list-','')+']').css('display','none');
					}
				} else {
					//if the element returned is not the div and is not a child of the div then hide the options
					relTarg = $(relTarg).parents('div:first');
					if ($(relTarg).hasClass('moveright') != true) {
						$('.moveright[value='+$(this).parent().attr('id').replace('list-','')+']').css('display','none');
					}
				}
		});
		
		//This when a user double click each item.
		$('div.outlineline').each(function() {
			bindDoubleClick(this);
		});
		

}

/*
	function addnewoutline
	add new line to the current outline.
	Params: none
	returns nothing
*/
function addnewoutline()
{
	var str2='';
	if($("#myGroupsInner input").length==0)	{
		//disbale the save button and add a new line to the outline to be edited and added
		$("#savebutton").attr("disabled","disabled");
		$("#myGroupsInner").prepend('<div class="outlinebox"><br><input type="text" size="50" id="textBox"  name="textBox" maxlength="250" onmousemove="this.focus();" />&nbsp;<input type="button" value="Add" class="truebutton" id="addbutton"></div>');
		$("#cancelbutton").removeAttr("disabled");
		$("#add_new_line").attr("disabled","disabled");
	}
	//give the text box focus and assign the key press so that if the user hits enter the new line is added
	$('#textBox').focus();
	$('#textBox').keypress(function(e) {
		var key=e.which;
		if(key==13)
		{
			var mytext=$("#textBox").val();
			addtextoutline(mytext);
			$("#savebutton").removeAttr("disabled");
		
		}
	});
	//if the add button is clicked add the new line to the outline
	$("#addbutton").click(function() {
		 var mytext=$("#textBox").val();
		 var str2='';
		addtextoutline(mytext);	
		$("#savebutton").removeAttr("disabled");
	});
	
	
}
/*
	function addtextoutline
	adds the new line text to the outline.
	Params: 
		mytext - the text to be added into the new outline line.
	returns nothing
*/
function addtextoutline(mytext)
{
	var str2='';
	if(mytext!='')
	{
		//gets the length of the outline and builds the line to be added
		var len=$("#myGroupsInner li").length + 1;
		var str="<li level='1' id='list-"+len+"'>";
		str=str+'<div class="sort-handle"><div class="outlineline">'+mytext+'</div>';
		str=str+"</div><div class='levelOne level'></div></li>";
				
		str2+='<div class="moveright" value="'+len+'" id="moveright'+len+'">';
		str2+='<a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
		//adds the line to the outline and makes it hoverable
		$('#myGroupsInner ol:first').prepend(str);
		$('#tmpdiv').append(str2);
		outlinesaveflag=2;
		outlinehover();
		//$("#savebutton").removeAttr("disabled");
		$('#myGroupsInner div.outlinebox').remove();
		$("#add_new_line").removeAttr("disabled");
		
		return false;
	}	
	
}

/*
	function createnewoutline
	create a new outline from scratch when the user selects create a new outline option.
	Params: none
	returns nothing
*/
function createnewoutline()
{
	//adds the directions and the buttons to the outline
	$('#directions').html(mymessage2);
	$('#direction').show();

	$('#outlineButtons').html(saveandcancelform);
	$('#outlineButtons').show();
	//makes the add new line button and the save button disabled and adds a new line
	if($("#myGroupsInner input").length==0)
	{
		$("#add_new_line").attr("disabled","disabled");
	$("#myGroupsInner").prepend('<div class="outlinebox"><input type="text" size="50" id="textBox" value=""  name="textBox" maxlength="250"/>&nbsp;<input type="button" value="Add" class="truebutton" id="addbutton"></div>');
	$('#textBox').focus();
		$("#cancelbutton").removeAttr("disabled");
		$("#savebutton").attr("disabled","disabled");
	}
	//sets the enter key on the key press and the add button to add the new line to the outline
	$('#textBox').keypress(function(e) {
			var key=e.which;
			if(key==13)
			{
				var mytext=$("#textBox").val();
				addtextoutline(mytext);
				$("#savebutton").removeAttr("disabled");
			}
	});
	
	
	if($("#tmpdiv").length==0)
	{
		$("#myGroupsInner").append('<div id="tmpdiv"></div>');
	}
	
	$("#addbutton").click(function() {						   
		var mytext=$("#textBox").val();
		addtextoutline(mytext);	
		$("#savebutton").removeAttr("disabled");
	});
	outlinehover();
	treesorting();
	return false;
}
/*
	function setmychoice
	sets the choice selected on the first page.
	Params: 
		id - the id of the choice to select.
	returns nothing
*/
function setmychoice(id)
{
	mychoice=id;
	if(id==2)
	{
		$('#mynotegroup').removeAttr('disabled');
		$('#mynotetitle').removeAttr('disabled');
		$('#note1').removeClass('outlinecheckbox');
		$('#note2').removeClass('outlinecheckbox');
	
	} else {
		$('#mynotegroup').attr('disabled','disabled');
		$('#mynotetitle').attr('disabled','disabled');
		$('#note1').addClass('outlinecheckbox');
		$('#note2').addClass('outlinecheckbox');
	}
}


/*
	function validateoutelineform
	The validate selection option when a user click start button on the main page of outline
	So it changed different level of outline that will use for save and outline format.
	Params: none
	returns nothing
*/
function validateoutelineform()
{
	//if the choice is nothing then throw an error. otherwise find which choice is correct and run the outline depending on which was chosen
	originaldata='';
	if(mychoice==0)	{
		$('#outlineButtons').html('<p class="errormsg">Please choose an option.</p>');
		$('#outlineButtons').height(14);	
		$('#mynotegroup').attr('disabled','disabled');
		$('#mynotetitle').attr('disabled','disabled');
	} else {
		if(document.getElementById('mynotegroup').checked)
		{
			mynotegroupflag=1;	
		}
		
		if(document.getElementById('mynotetitle').checked)
		{
			
			mynotetitleflag=1;	
		}
		if((mychoice==2)&&(mynotegroupflag==0)&&(mynotetitleflag==0))
		{
			$('#outlineButtons').html('<p class="errormsg">Please select groups or notecard titles.</p>');
			$('#outlineButtons').height(14);				
		} else {
			
			if(mychoice==2)
			{
				outlineIsOpen=0;
				GetNoteAndGroups(currassgn);

			} else {		
				displayoutline2();
			}
			$('#outlineButtons').height(42);			
		}
	}
}

/*
	function bindDoubleClick
	binds the double click event to the selected object
	Params: 
		obj - the object to recieve the double click event.
	returns nothing
*/

// *** double click each line to edit. Pass in element ID *******
function bindDoubleClick(obj){
	
	$(obj).bind('dblclick',function() {
		// pass in li index value
		edittext($(obj).parents('li:first').attr('id').replace('list-',''));
		
	});
	
}

/*
	function edittext
	the edit line function for the outline
	Params: 
		obj - the object to make editable.
	returns nothing
*/

function edittext(obj)
{
	var html='';
	
	if ($('#textBox').length == 0) {
		
		var index=obj; // This work for all browser.
		  
		hoverflag=true;
		//hide the moveright div and adds the text box to the line so that the user can edit the line.
		var mytext=$('#list-'+index).find('div:eq(1)').text();
		var tmpdisabled = $('#savebutton').attr('disabled');
		var tmptext = mytext;
		$('.moveright[value='+obj+']').hide();
	
		$('#list-'+index).find('div:eq(1)').removeClass('outlineline');
		$('#list-'+index).find('div:eq(1)').addClass('outlineline2');
		if ($.browser.msie && parseInt($.browser.version()) == 7) {
			$('#list-'+index).css('padding-top','0px');
		}
		$('#list-'+index).find('div:eq(1)').html('<input type="text" size="10" maxlength="255" id="textBox" />&nbsp;<input type="button" value="Add" class="truebutton" id="addbutton">');
		$("#savebutton").attr("disabled","disabled");		
		$('#textBox').val(mytext);
		$("#cancelbutton").removeAttr("disabled");
		$("#add_new_line").attr("disabled","disabled");
		
		//if the user presses enter or clicks the add button save the line edit to the visible outline
		$('#textBox').keypress(function(e) {
			if(e.which==13)
			{
				$('#addbutton').trigger('click');
			}
		});
		
		$("#addbutton").click(function() {
		 	var mytext=$("#textBox").val();
		 	if(mytext!='')
			{
				$('#list-'+index).find('div:eq(1)').removeClass('outlineline2');
				$('#list-'+index).find('div:eq(1)').addClass('outlineline');
				$('#list-'+index).find('div:eq(1)').html(mytext);
				if ($.browser.msie && parseInt($.browser.version()) == 7) {
					$('#list-'+index).css('padding-top','10px');
				}
				$("#add_new_line").removeAttr("disabled");
				if (tmptext != mytext) {
					$("#savebutton").removeAttr("disabled");				
					outlinesaveflag=2;
				} else {
					if (tmpdisabled == false) {
						$("#savebutton").removeAttr("disabled");				
						outlinesaveflag=2;
					} else {
						outlinesaveflag=1;	
					}
				}
				hoverflag=false;
			}					   
		});
	}
	return false;
}

/*
	function deletetext2
	deletes the selected outline object
	Params: 
		obj - the object to delete
	returns nothing
*/

function deletetext2(obj)
{

	var index=obj; // This work for all browsers
	
	// find the child
	var str = $('#list-'+index).find('ol').html();
	
	
	if((str==null)||(str==''))
	{
		// The index get from outlinehover function 
		$('#list-'+index).remove();
		$('#moveright'+index).remove();

	} else {
		//remove the line from the outline	
		var pid=$('#list-'+index).attr('id');
		
		 var cid=$('#list-'+index).find('li:first').attr('id');
			 
		$('#list-'+index).replaceWith($(str));
		
		
		$('#moveright'+index).remove();
	
	}
	//set the save button active and resort and rehover the outline
	$("#savebutton").removeAttr("disabled");
	
	treesorting();
	outlinehover();
	changeLevelLines();
	$('.moveright[value='+obj+']').css('display','none');
	
	outlinesaveflag=2;
	$("#cancelbutton").removeAttr("disabled");
}
/*
	function deletetext
	warning popup when delete
	Params: 
		obj - the object to be deleted
	returns nothing
*/
function deletetext(obj)
{
	//ask if the user would like to delete the line
	warning({
				title:'Warning',
				msg:'Are you sure want to delete this line?',
				noAction:function(){return false;},
				yesAction:function(){deletetext2(obj);},
				cancelAction:function(){return false;}
	});

}

/*
	function popupprint
	popup window for the print
	Params: 
		url - the url of the web page to be opened
		width - the width of the popup
		height - the height of the popup
	returns nothing
*/

function popupprint(url,width,height)
{
	// set up width and height of popup window.
	var x=(window.screen.width/2) - 200;
	var y=(window.screen.height/2) - 300;
	var styleopen="width="+width + ',height='+height+',left='+x+',top='+y+',menubar=0,scrollbars=1, resizable=yes';
	
	window.open(url,'newin',styleopen);
	
}

/*
	function displayoutlineform
	Display outline form so a user can select "create new outline" or "import outline from notecard".
	Params: none
	returns nothing
*/

function displayoutlineform()
{
	outlineIsOpen=1;
	//build the initial outline form for when switching assignments and when deleteing the outline
	var str='<div class="outlinebox">';
	str=str+'&nbsp;<span><input type="radio" name="mychoice" value="1" id="mychoice1" onClick="setmychoice(1);"><b>Create a New Outline</b></span>';
	str=str+'<span><img src="/images/scs/spacer.gif" height="1" width="100"></span>';
	str=str+'<span><input type="radio" name="mychoice" value="2" id="mychoice2" onClick="setmychoice(2);"><b>Import Information from your Notes</b></span>';
	str=str+'</div>';
	str=str+'<div class="outlinewidth2">';
	str=str+'<span><img src="/images/scs/spacer.gif" height="1" width="150"></span>';
	str=str+'<span class="outlinecheckbox" id="note1"><input type="checkbox" name="mynotegroup" id="mynotegroup" value="0">Groups</span>';
	str=str+'&nbsp;&nbsp;&nbsp;';
	str=str+'<span class="outlinecheckbox" id="note2"><input type="checkbox" name="mynotetitle" id="mynotetitle" value="0">Notecard Titles</span>';
	str=str+'</div>';
	str=str+'<div class="outlinewidth">';
	str=str+'<input type="button" value="START" id="mysubmitchoice" class="truebutton" onClick="validateoutelineform();">';
	str=str+'</div>';
	//add the directions and the outline to the page
	$('#directions').html("Would you like to create a new outline, or use your folder groups and notecard titles, from your Note Organizer?");
	$('#myGroupsInner').html(str);
	$('#outlineButtons').height(4);
	$('#myGroupsInner input:checkbox').attr('disabled','disabled');
	
}


/*
	function displayoutline
	used to import a new outline via ajax
	Params: none
	returns nothing
*/
function displayoutline()
{
	var counter=0;
	var linecount=outlinelist.length;
	if(linecount > 0)
	{
		var currentIndentLevel = outlinelist[0]._indentlevel;
		var str= "<ol class='page-list' id='levelone'>";
		var level='';
		var str2='';
		for(var i=0; i < linecount; i++)
		{	
			//CHECK TO SEE IF WE CHANGED LEVELS
			if(currentIndentLevel != outlinelist[i]._indentlevel)
			{
				//CHECK TO SEE IF WE NEED TO CLOSE A INDENT LEVEL
				if(currentIndentLevel > outlinelist[i]._indentlevel)
				{				
					
					for(var j=currentIndentLevel; j > outlinelist[i]._indentlevel; j--)
					{
						str=str+ "</li></ol>";
					}
						str=str+ "</li>";
				}
				else 
				{	
					//OPEN AN INDENT LEVEL
					str=str+"<ol class='page-list'>";
				}
				currentIndentLevel = outlinelist[i]._indentlevel;
				
			}
			else if(i!=0) 
			{
				str=str+ "</li>";
			}
			//find which level the current line is on
			switch(outlinelist[i]._indentlevel+1){
				case 1:
					level = 'One';
					break;
				case 2:
					level = 'Two';
					break;
				case 3:
					level = 'Three';
					break;
				case 4:
					level = 'Four';
					break;
				case 5:
					level = 'Five';
					break;
				default:
					level = 'One';
					break;																									
			}
			str=str+"<li id='list-"+counter+"' level='"+outlinelist[i]._indentlevel+1+"'>";
			str=str+ "<div class='sort-handle'><div class='outlineline'>"+outlinelist[i]._linetext+"</div>";
			str2+='<div class="moveright" id="moveright'+counter+'" value='+counter+'><a onclick="edittext($(this).parent().attr(\'value\'));">Edit</a> | <a onclick="deletetext($(this).parent().attr(\'value\'));">Delete</a></div>';
			str=str+"</div><div class='level"+level+" level'></div>";
			counter++;
		}
		
		for(var i=currentIndentLevel; i >= 0; i--)
		{
			str=str+ "</li></ol>";
		}
		
		$('#directions').html(mymessage3);
		$('#direction').show();
		$('#outlineButtons').html(saveandcancelform);
		$('#outlineButtons').show();
	
		$("#myGroupsInner").html('<br>'+str + '<div id="tmpdiv">'+str2+'</div>');
		
		originaldata=$("#myGroupsInner").html();
		
		treesorting();	
		changeLevelLines();
		outlinehover();
		$("#cancelbutton").attr("disabled","disabled");
		$("#savebutton").attr("disabled","disabled");
		
	}
}

/*
	function exportPopup
	open the export popup to export into html or rtf
	Params: none
	returns nothing
*/
function exportPopup() 
{
		warning({
			title:'Export',
			msg:'You have chosen to export your Outline. Please choose an export format and click Export.<br><br><b>Format:</b><br><div><span><input type="radio" name="format" value="rtf" checked="checked"/>Word</span><span style="width:150px;">&nbsp;</span><span><input type="radio" name="format" value="html" />HTML</span></span>',
			buttons: 'Cancel,Export',
			noAction:function(){saveexportoutline(); return false;},
			yesAction:function(){ return false;},
			cancelAction:function(){return false;}
		});
}


/*
	function exportPopup
	open the export popup to export into html or rtf
	Params: none
	returns nothing
*/
function printDialogPopup(url,width,height) 
{
		warning({
			title:'Print',
			msg:'You must save your outline before you print.  Would you like to save your outline now?',
			buttons: 'No,Yes',
			noAction:function(){saveprintoutline(url,width,height); return false;},
			yesAction:function(){ return false;},
			cancelAction:function(){return false;}
		});
}