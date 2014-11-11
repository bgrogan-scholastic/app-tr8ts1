// JavaScript Document
var projPanCollapsed = false;
var myNotesVisible = false;
var elementsAttached = true;
var activeTab = 0;
var projPanHeight = 0;

//profile cookie reader code
var cookiereader = new cookie_reader('xs'); 
var profileid = cookiereader.getprofileid();
var lexile = cookiereader.getlexile();
var proftype = cookiereader.getproftype();
var name = cookiereader.getname();
var currassgn = cookiereader.getcurrassgn();
var readlvl = cookiereader.getreadlvl();


//profile and log out code 
var options = {  

	contentLoadPath:"/profile/profile.php",
	scrollbars: true

};  

 


function logout(){

    var theCookie = new Cookie();

    theCookie.DeleteCookie('prof_values', "/", ".grolier.com");
    theCookie.DeleteCookie('prof_values_xs',"/", ".grolier.com");
    theCookie.DeleteCookie('profu',"/", ".grolier.com");
    theCookie.DeleteCookie('profp',"/", ".grolier.com");
    
    theCookie.DeleteCookie('auids',"/", ".grolier.com");
    theCookie.DeleteCookie('auth-pass',"/", ".grolier.com");
    theCookie.DeleteCookie('prefs',"/", ".grolier.com");

    location.href="/home";

            

}


$(window).load(function(){


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

	//define stopScrollingActionBar on specific page to turn it off 
	if((typeof stopScrollingActionBar)=="undefined"){
		$('#noteCard').setupNote();
	}else{
		$('#noteCard').setupNote({
			useActionBar:false
		});
	}


	//temp to stop click from working.
	//$('#projPanButton').unbind('click');
	
	$('#projPanButton').click(function(){
		$('#projPanButton').attr("disabled","disabled");						   
		if(projPanCollapsed){
		
			$('.innera').css('overflow', 'hidden');
			$('.innerb').css('overflow', 'hidden');
	
	
			projPanCollapsed = false;
			//showProjPan();
			showProjPan();
			
			
			
			
			$(this).attr('src','images/common/mwz_arrow_down.jpg');
			$(this).attr('title','Click to close My Work Zone.');
			
			//setTimeout ( '$("#workareaTop").removeClass("waTopClosed");$("#workareaTop").addClass("waTopBetween");', 20 );
			
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
			
					if(!$.browser.msie){
						$('.mwzAnon').find('object').show();
					}
				}
	
	
			});
	
	
	
			$('.innera').css('overflow', 'auto');	
			$('.innerb').css('overflow', 'auto');
	
		}else{
	
			$('.innera').css('overflow', 'hidden');
			$('.innerb').css('overflow', 'hidden');
	
			projPanHeight = $('#projPan').height();
			projPanCollapsed = true;
			$("#workzoneSubsect").find('.barLeft').find('p').hide();
			//setTimeout ( '$("#workareaTop").removeClass("waTopOpen");$("#workareaTop").addClass("waTopBetween");', 30 );
	
			$(this).attr('src','images/common/mwz_arrow_right.jpg');
			$(this).attr('title','Click to open My Work Zone.');
	
			$("#workareaTop").removeClass("waTopOpen");
			$("#workareaTop").addClass("waTopBetween");
			
			if(!$.browser.msie){
				$('.mwzAnon').find('object').hide();
			}
	
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
	
			/*if($.browser.msie){
				setTimeout ( '$("#workareaTop").removeClass("waTopBetween");$("#workareaTop").addClass("waTopClosed");', 200 );
			}*/
		
		
			$(".workzoneCon").animate({
				height: "0px" 
			}, { 
				duration:300, 
				complete: hideProjPan 
			}); 
			$('.innera').css('overflow', 'auto');
			$('.innerb').css('overflow', 'auto');
		}
	
	});



});


/*function scrollHandler() { 
//setNotePos();
//setActionBarPos();
setStuffPos();
ie6=false;
if(ie6){
if(flto){
window.clearTimeout(flto);
flto=null;
}	
//run count only after specified timeout
flto=window.setTimeout(function(){
setActionBarPos();
setNotePos();							

},150);
}


}

*/

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


/*function getScrollXY() {  //gets scroll offset across browsers
var scrOfX = 0, scrOfY = 0;
if( typeof( window.pageYOffset ) == 'number' ) {
//Netscape compliant
scrOfY = window.pageYOffset;
scrOfX = window.pageXOffset;
} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
//DOM compliant
scrOfY = document.body.scrollTop;
scrOfX = document.body.scrollLeft;
} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
//IE6 standards compliant mode
scrOfY = document.documentElement.scrollTop;
scrOfX = document.documentElement.scrollLeft;
}
return [ scrOfX, scrOfY ];
}
*/

