//this function takes in the group list json object and the notecardlist json object and displays the note organizer
function displayNoteOrganizer(grouplist, notecardlist) {
	var retVal = "";

	for(var i = 0; i <grouplist.length; i++){
		var groupid = grouplist[i]._groupid;
		
		retVal += "<B>" + grouplist[i]._title + "</b><br>";
		
		for(var j = 0; j <notecardlist.length; j++){
			
			if(groupid == notecardlist[j]._groupid){
				
				
				retVal += notecardlist[j]._title + "<BR>";
				
				
			}
			
		}
		
		
	}
	
	document.getElementById("noteorganizer1").innerHTML = retVal;
}


function displayAssignmentList(assignmentlist){
	
	
	var retVal = "";

	for(var i = 0; i <assignmentlist.length; i++){
		
		
		retVal += assignmentlist[i]._title + "<BR>";
		

	}
	
	
	document.getElementById("assignmentdiv").innerHTML = retVal;
	document.getElementById("assignmentdiv").style.display = 'block';
	
	
	
}