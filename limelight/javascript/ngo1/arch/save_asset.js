/** 
	@file: arch/save_asset.js
	@description: the page that holds the fucntions for the saving of digital locker information.
 
	@author Nate Prouty
	@method doLinkSave
	@params N/A
	@result passes the link to save onto the method in /arch/digitallockerajax.php to save the link and then pops up a "success" message
*/

function doLinkSave() {
	$(function() {
			
		assignid 	= $('#projectLinkName option:selected').val();
		assigntitle	= $('#projectLinkName option:selected').text();

		var submitrequesturl = 'action=insertsavedweblink&profileid=' + profileid + '&assignmentid=' + assignid + '&url=' + escape(weblink_url) + '&weblinktype=' + weblink_type + '&title=' + weblink_title + '&location=' + weblink_location;
		
		$.ajax({
			type: "POST",
			url: "/arch/digitallockerajax.php",
			async: true,
			data: submitrequesturl,
			dataType: "text",
			success: function(msg) {
/**
				warning({
					title: 'Message',
					msg: 'The web link <a href="' + weblink_url + '">' + weblink_title + '</a> has been successfully saved to "' + assigntitle + '". Would you like to save this to another project?',
					noAction: function() {
						$('#saveLinkToDigitalLocker').popupClose();
					},
					yesAction: function() {							

						},
					cancelAction: function() {
						$('#saveLinkToDigitalLocker').popClose();
					} 
				});
				
				
*/
				//RECORD STAT HIT
				collectStat('dlock','xs','save','');

				$('#saveLinkToDigitalLocker').popupClose();
				//$(this).popupClose();
			}
		});			
	
	});
}

/* 
	@author Nate Prouty
	@method doSave
	@params N/A
	@result passes the asset to save onto the method in /arch/digitallockerajax.php to save the asset and then pops up a "success" message
*/
function doSave() {
	$(function() {
		//$('#saveToDigitalLocker p.assettitle').after("");
		
		assignid 	= $('#projectAssetName option:selected').val();
		assigntitle	= $('#projectAssetName option:selected').text();
		
		var savedata = '';
	
		var inarray  = saved_to.findAssetAssign(assignid,assetid);
		
		var submitrequesturl = "action=insertsavedasset&profileid=" + profileid + "&assignmentid=" + assignid + "&uid="+uid+"&assetid=" + assetid + "&sourceproductid=" + sourceproductid + "&type=" + globaltype + "&title=" + assettitle;
		
		//if (typeof(console) != 'undefined') {
		//	console.log(submitrequesturl);
		//                                                                                                                                                                                                                                                                                       }
		
		$('#alreadysaved').remove();
		
		if (inarray === false) {
			$.ajax({
				type: "POST",
				url: "/arch/digitallockerajax.php",
				data: submitrequesturl,
				dataType: "text",
				async: true,
				success: function(msg) {
					$('#saveToDigitalLocker').popupClose();			
				},
				complete: function() {
					
					//RECORD STAT HIT
					collectStat('dlock','xs','save','');

					/* Update the project dropdown to move the saved project to "Already saved to:" */
					//getassignmentassetlist();
					getassignmentassetlist(assetid, sourceproductid, globaltype, true);
					//buildProjectList();
				},
				error: function() {
					//setMessage("<br />There was a problem saving the asset " + assettitle + " to " + assigntitle + ".");
				}
			});		
		}
		else {
						
			if($("#alreadysaved").length == 0)
			{
				$('#saveToDigitalLocker p.assettitle').after("<span class=\"alreadysaved\" id=\"alreadysaved\" align=\"center\" style=\"color: red; weight: bold\">You have already saved this to the selected project. Please choose another</span>");
			
				/*setTimeout(function() {
					$('#alreadysaved').slideUp();
					$('#alreadysaved').remove();
				}, 3000);*/
			}
			
			/*warning({
				title:'Warning',
				msg:'This asset has already been saved to the selected project. Please choose another.',
				buttons: "OK,Cancel",
				noAction:function(){
					//$('#saveToDigitalLocker').popupClose();	
					$(this).popupClose();	
				},
				yesAction:function(){
					
					$(this).popupClose();	
					//$('#saveToDigitalLocker').popupClose();	
				},
				cancelAction:function(){
					$(this).popupClose();	
					//$('#saveToDigitalLocker').popupClose();	
				}
			});*/
			
			
		}	
		
	});
}