/** 
	@file: main.js
	@description: This file is the main source of all the javascript calls needed for cookie and page load functions

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
**/	

// JavaScript Document
var myNotesVisible = false;
var elementsAttached = true;
var activeTab = 0;
var projPanHeight = 0;
var citationData = null;
var citationcontenttypeData = null;
var citationformatexampleData = null;
var groupStore = null;
var noteStore = null;
var citationtypeid = null;


//function to make IE, Firefox, and Safari behave the same way
Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };

//profile and log out code 
var createprofileoptions = {  

	contentLoadPath:"/profile/profile.php"

};  

var editprofileoptions = {  

	contentLoadPath:"/profile/profile.php?editprofile=1"

}; 

//forgot username/chaneg password code

var forgotusername = { 

	contentLoadPath:"/profile/forgetpassword.php"

};

function clearSearchTF(){

	if(document.getElementById('search_text').value=='Find It!'){
		document.getElementById('search_text').value='';
	}

}//end function

function logout(authpcode){

    var theCookie = new Cookie();

    var prof_values_cookie = "prof_values_" + authpcode;
    theCookie.DeleteCookie('prof_values', "/", ".grolier.com");
    theCookie.DeleteCookie(prof_values_cookie,"/", ".grolier.com");
    theCookie.DeleteCookie('profu',"/", ".grolier.com");
    theCookie.DeleteCookie('profp',"/", ".grolier.com");
    
    theCookie.DeleteCookie('auids',"/", ".grolier.com");
    theCookie.DeleteCookie('auth-pass',"/", ".grolier.com");
    theCookie.DeleteCookie('prefs',"/", ".grolier.com");
    theCookie.DeleteCookie('loggedin',"/", ".grolier.com");
    
    theCookie.DeleteCookie('profpr',"/", ".grolier.com");
    
    session_stat();

    if(authpcode=="eto"){
    	
    	location.href="https://samconnect.scholastic.com/auth/pages/Logout"; 
    	
    }else{
    	
    	location.href="/home";     	
    	
    }
   

}


$(window).load(function(){
	
	// use cache: false for all AJAX
	$.ajaxSetup({
		cache: false
	});

	$('#ddnav').find('li').each(function(){
	
		$(this).click(function(){
			var clickedElem = $(this);
			if(!clickedElem.hasClass('tabActive')){
				
				$('#ddnav').find('li').removeClass('tabActive');
				$('#ddnav').find('li a').removeClass('active');
				clickedElem.addClass('tabActive')		
				clickedElem.find('a').addClass('active');
				var clickedElemId = clickedElem.attr('id');
				$('.ddContent').each(function(){
				
					if($(this).hasClass(clickedElemId)){
						$(this).show();	
					}else{
						$(this).hide();		
					}
				
				});
			
			
			}
			return false;
		});
	
	
	});

		
	$('#projPanButton').click(function(){
		
		$('#projPanButton').attr("disabled","disabled");						   
		if(projPanCollapsed){

			$('.innera').css('overflow', 'hidden');
			$('.innerb').css('overflow', 'hidden');
						
	
			projPanCollapsed = false;
			//showProjPan();
			showProjPan();
			
			$("#workzoneSubsect").find('.barLeft').find('p').hide();
			$(this).attr('src','images/common/mwz_arrow_down.jpg');
			$(this).attr('title','Click to close My Work Zone.');
			
			$("#projPanBot").animate({ height:"8px"}, {
				duration:50,
				complete:function(){
					$("#projPanBot").show();
				}
			});
			$("#toolPanBot").animate({
				height:"8px"
			}, {
				duration:50,
				complete:function(){
					$("#toolPanBot").show();
				}
			});	
			if (projPanHeight == 0) {
				projPanHeight = tmpProjPanHeight;	
			}
			
			$("#workareaTop").removeClass("waTopClosed");
			$("#workareaTop").addClass("waTopBetween");
			
			$("#toolsPan").animate({
				height: projPanHeight + "px"
			}, {
				duration:300
			});
			$("#projPan").animate({
				height: projPanHeight + "px"
			}, {
				duration:300,complete:function(){
																		
					$('#projPanButton').attr("disabled","");
					$("#workareaTop").removeClass("waTopBetween");
					
					$("#workzoneSubsect").find('.barLeft').find('p').show();
					$("#workareaTop").addClass("waTopOpen");
					$('.wnGetHelp').css('visibility','visible');
					$('#wnGetMarkComp').css('visibility','visible');				
					$('.mwzAnon').show();
				}
	
	
			});
	
	
	
			$('.innera').css('overflow', 'auto');	
			$('.innerb').css('overflow', 'auto');
			toggleWorkZoneBar(1);
	
		}else{
		
			$('.innera').css('overflow', 'hidden');
			$('.innerb').css('overflow', 'hidden');
			
			projPanHeight = $('#projPan').height() == false ? tmpProjPanHeight : $('#projPan').height();
			projPanCollapsed = true;
			$("#workzoneSubsect").find('.barLeft').find('p').hide();
	
			$(this).attr('src','images/common/mwz_arrow_right.jpg');
			$(this).attr('title','Click to open My Work Zone.');
	
			$("#workareaTop").removeClass("waTopOpen");
			$("#workareaTop").addClass("waTopBetween");
			
			$('.mwzAnon').hide();
			$('.wnGetHelp').css('visibility','hidden');
			$('#wnGetMarkComp').css('visibility','hidden');				
			$("#projPanBot").animate({
				height:"0px"
			}, {
				duration:50,
				complete:function(){
					$("#projPanBot").hide();
				}
			});
			$("#toolPanBot").animate({ 
				height:"0px"
			}, { 
				duration:50,
				complete:function(){
					$("#toolPanBot").hide();
				}
			});
		
		
			$(".workzoneCon").animate({
				height: "0px" 
			}, { 
				duration:300, 
				complete: hideProjPan 
			}); 
			$('.innera').css('overflow', 'auto');
			$('.innerb').css('overflow', 'auto');
			toggleWorkZoneBar(0);
		}
	
	});



});


function hideProjPan() {
		
	$("#projPan").hide();
	$("#toolsPan").hide();
	
	$('#projPanButton').attr("disabled","");
	
	$("#workareaTop").removeClass("waTopBetween");																							
	$("#workareaTop").addClass("waTopClosed");
} 

function showProjPan() {
	$("#projPan").show();
	$("#toolsPan").show();
	
}

function toggleWorkZoneBar(state) {	
	theCookie.SetCookieNoEscape('workzonebarstate', state, null, "/", "");
}

function sortCollectByTitle(json_stuffcollected) {
	var tmpthis = $('.sortableparent').eq(0);
	$(tmpthis).find('.sortable').attr('id','1-1');
	$('.sortableparent').eq(1).find('.sortable').attr('id','2-2');
	$('.sortableparent').find('img').attr({'src':'/images/digital_locker/arrow_down.gif'}).css('display','none');
	$(tmpthis).find('img').attr({'src':'/images/digital_locker/arrow_down.gif'}).css({'display':'block'});
	json_stuffcollected.sort(function(a,b) {
		return (a._title.toLowerCase() < b._title.toLowerCase() ? -1 : 1);
	});
}

