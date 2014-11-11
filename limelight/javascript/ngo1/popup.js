/** 
	@file: popup.js
	@description: This file is the main source of all the popup javascript calls

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	popup variables:
	
	getHelpOn = false;
	testonPageOn = false;
	arrow = false;
	viewModel = false;
	yPosition = 0;
	popupFunction;
	popupcheck;
	height = false;
	doAfterFunction;
	tmpIndex = 0;
	
**/	
var flto=null;
var getHelpOn = false;
var testonPageOn = false;
var arrow = false;
var viewModel = false;
var yPosition = 0;
var popupFunction;
var popupcheck;
var height = false;
var doAfterFunction;
var tmpIndex = 0;

//$(window).bind('load',function(e){
$(document).ready(function() {
	//store the highest z index on page load
	tmpIndex = getHighestZIndex();
});

/*
	function detectMacXFF2
	finds out if the browser being used is firefox 2 on the mac
	Params - none
	result - returns true if the browser is firefox 2 on the mac
	
	
	This is called multiple times, so save "cache" the result - Nabeel
*/

var detected="";
function detectMacXFF2() {

	if(detected == "")
	{
		var userAgent = navigator.userAgent.toLowerCase();
		
		if (/firefox[\/\s](\d+\.\d+)/.test(userAgent)) 
		{
			var ffversion = new Number(RegExp.$1);
			if (ffversion < 3 && userAgent.indexOf('mac') != -1) {
				detected = true;
			}
			else 
			{
				detected = false;
			}
		}
	}
	
	
	return detected;
}
/*
	function getHighestZIndex
	finds the highest z index used on the page
	Params - none
	result - returns the highest z index on the page.
*/
function getHighestZIndex() 
{	
	var highest = 0;
	
	// nabeel - typecast to int, with base 10
	//	w/o base string "012" returns 10
	$("div, p").each(function() {
	    if($(this).css("z-index") != "auto" && parseInt($(this).css("z-index"), 10) > highest)
			highest = parseInt($(this).css("z-index"), 10);
	});
	
	return highest;
}

 /********  popup ************/
(function($){  
	$.fn.popup = function(options) {  
	/*overPageClass - string - class be used for an over page popup
	onPageClass - string - class be used for an on page popup
	layerClass - string - class for transparent overlay
	outlineClass - string - class for popup transparent outline,
	closeClass - string - class for close button added to popup,
	contentClass - string - class for content div that holds dynamic content in popup,
	closeImgSrc - string - the path to the image used for the close button
	closeHelpText - string - the tooltip text for the close button,
	contentLoadPath - string - the path to a php/html file that should be dynamically loaded into the content div
	onPage - boolean - determines if popup is treated as on page (true) or over page (false)
	coords - x,y coordinates - {x:0,y:0} format of the coordinates at which an on page popup should appear
	outlineThick - integer - thickness in pixels of popup outline
	outlineImgDim - integer - dimensions of corner images of outline
	doBefore - function - a function to run before the popup is created
	doAfter - function - a function to run after the popup is displayed
	
	*/
	
	//console.dir(this);
	// Bug fix by Nabeel
	//	We add a class to a popup later on when it's opened
	//	and then remove this class when it's closed. 
	// This prevents duplicate popups of the same div elements
	//	in the case multiple bindings are made for the same div
	if(this.hasClass("popupLoaded")){
		return false;
	}
	var defaults = {  
			overPageClass:"overpagePopup",
			onPageClass:"onpagePopup",
			closeClass:"popupClose",
			contentClass:"content",
			closeHelpText:"Close this popup.",
			contentLoadPath:false,
			onPage:false,
			height:false,
			balloon:false,
			parent:false,
			coords:false,
			scrollbars:false,
			doBefore:function(popup){},
			doAfter:function(popup){}
			
	};  
	
	var options = $.extend(defaults, options);  

	if(options.balloon) options.onPage=true;
	if(options.onPage){
		
		//on page popup defaults
		var popupClass = options.onPageClass;
		if ($.browser.mozilla && navigator.userAgent.indexOf('Macintosh;') != -1){
			var onPageDef = {
				outlineThick:8,
				outlineImgDim:12,	
				closeImgSrc:"images/common/onpage_hd_close.png",
				outlineClass:"onpageOutlineffmac"
			}
		} else {
			var onPageDef = {
				outlineThick:8,
				outlineImgDim:12,	
				closeImgSrc:"images/common/onpage_hd_close.png",
				outlineClass:"onpageOutline"
			}
		}
		
		options = $.extend(onPageDef, options);  		
		//set coords
		if(options.parent ){
			if(!options.coords){
				var locIndent = $(options.parent).width()/2;
				var locHdent = $(options.parent).height()/2;
				var parentX = $(options.parent).position().left;
				var parentY = $(options.parent).position().top;
				
				options.coords = {x:parentX + locIndent,y:parentY + locHdent};
				
			}else{
				options.coords={x:0,y:0};
			}
		}
	}else{
		//over page popup defaults
		var popupClass = options.overPageClass;
		var overPageDef;

		if (detectMacXFF2()){
			overPageDef = {
				outlineThick:15,
				outlineImgDim:22,	
				closeImgSrc:"images/common/popup_hd_close.png",
				outlineClass:"modalOutlineffmac",
				layerClass:"modalLayerffmac"
			}
		} else {
			overPageDef = {
				outlineThick:15,
				outlineImgDim:22,	
				closeImgSrc:"images/common/popup_hd_close.png",
				outlineClass:"modalOutline",
				layerClass:"modalLayer"
			}
		}
				
		options = $.extend(overPageDef, options);
		height = options.height;
	}
	

	var locateClass=""; //for finding layers and outlines of popup
	function popupResize(){
	
		if(!options.onPage){
			if(!($.browser.msie && $.browser.version() < 7)){
			   $('.' + options.outlineClass).css({position:"fixed"});	
			}
			//if(flto){
			//	window.clearTimeout(flto);
			//	flto=null;
			//}	
			//run count only after specified timeout
			//flto=window.setTimeout(function()
			//{
			if($.browser.msie && $.browser.version() < 7){
				
			}
			else
			  {
				var mlheight;

				$('.' + popupClass/* + ':visible'*/).each(function(){$(this).popupPosition({coords:options.coords,onPage:options.onPage});});
				if (options.height != false) {
					mlheight = getPageSizeWithScroll().height;
				} else {
					mlheight = getPageSizeWithScroll().height;
				}
				var mlwidth = $(window).width();
				$('.' + options.layerClass).height(mlheight + "px");
				$('.' + options.layerClass).width(mlwidth + "px");
			
			
				var xspot = ($(window).width()/2)+100;
				var yspot = ($(window).height()/2)-60;
			
				var modelCoords = {x:xspot,y:yspot};
				var shadowCoords = {x:xspot -8,y:yspot - 8};
				
				$('.'+options.outlineClass+':visible').each(function(){$(this).popupPosition({coords:shadowCoords,onPage:options.onPage});});
				$('#viewModels').each(function(){$(this).popupPosition({coords:modelCoords,onPage:options.onPage});});		
				$('.'+options.outlineClass+':visible').css({position:"fixed"});	
				$('#viewModels').css({position:"fixed"});
			}
		}
	}
	function setZIndex(popupObj)
	{	
		/* find the top most zIndex*/
		var topZIndex = parseInt(tmpIndex)+1;
		tmpIndex = parseInt(tmpIndex) + 8;
		
		//$('.' + options.overPageClass+':visible').add('.' + options.onPageClass+':visible').each(function()
		// this now properly finds the top z-index - NS
		$('.popupLoaded').each(function()
		{
			if(parseInt($(this).css("z-index")) > topZIndex){
				topZIndex=$(this).css("z-index");
			} 
		});
		
		//set zIndex for popup 
		if (viewModel == true){
			topZIndex = parseInt(topZIndex) + 4
		} else {
			topZIndex = parseInt(topZIndex) + 2
		}
		popupObj.css({zIndex:topZIndex});
		
		locateClass="forPopup" + topZIndex;
	
		return topZIndex;
	}
	
	//create and append transparent layer and outline
	function createModalLayer(popupZIndex)
	{
		//check here for safari 2 width/height bug BUGCHECKSAFARI11
		var mZIndex = parseInt(popupZIndex)-1;
		
		//create overlay
		if(!options.onPage){
			var mlayer = document.createElement("div");
			$(mlayer).addClass(options.layerClass);
			$(mlayer).addClass(locateClass);
			$(mlayer).addClass(locateClass+"Handler");
			$(mlayer).addClass("modalBGLayer");
			$(mlayer).css({zIndex:mZIndex});
			if(jQuery.browser.safari){
				var mlwidth = getPageSizeWithScroll().width;
				$(mlayer).width(mlwidth + "px");
			}
			var mlheight = getPageSizeWithScroll().height;
			$(mlayer).height(mlheight + 'px');
		}
		
		
		//create outline layer
		/*if ($.browser.mozilla){
			//mZIndex = 0;
		}*/
		
		var outlineLayer = document.createElement("div");
		$(outlineLayer).addClass(options.outlineClass);
		$(outlineLayer).addClass(locateClass);
		$(outlineLayer).css({zIndex:mZIndex});
				
		$(outlineLayer).append('<div class="rtop"><div></div></div><div class="ltop"></div><div class="middle"></div><div class="rbot"><div></div></div><div class="lbot"></div>')
		if(options.onPage && options.balloon && arrow == true)
		{
			$(outlineLayer).prepend('<div class="arrow"></div>');
		}

		$('body').append($(outlineLayer).hide());
		
		if(!options.onPage) 
		{
			$('body').append(mlayer);
		}		
	}
	
	function shapeModalOutline(popupObj)
	{		
		var outlineObj = $('.' + options.outlineClass).filter('.' + locateClass);
		
		var pwidth = popupObj.width();
		var pheight = popupObj.height();
		
		var outlineHeight = pheight + options.outlineThick*2;
		var outlineWidth = pwidth + options.outlineThick*2;
		
		outlineObj.height(outlineHeight);
		outlineObj.width(outlineWidth);
		
		var adjustedHeight = outlineHeight-(options.outlineImgDim*2);
		
		outlineObj.find('.middle').height(adjustedHeight);
		outlineObj.find('.middle').height(adjustedHeight);		
		
		var adjustedWidth= outlineWidth-(options.outlineImgDim*2);
		outlineObj.find('.rtop').width(adjustedWidth);
		outlineObj.find('.rbot').width(adjustedWidth);
		
		//hide underlying select objects in IE6
		if(options.onPage && $.browser.msie && $.browser.version() < 7){
			var iframeOverlay = document.createElement('iframe');
			$(iframeOverlay).width(adjustedWidth);
			$(iframeOverlay).height(adjustedHeight);
			$(iframeOverlay).css({margin:options.outlineImgDim +"px"});
			//$(iframeOverlay).
			outlineObj.prepend(iframeOverlay);
			
		}
		if(!options.onPage && ($.browser.msie || detectMacXFF2())) 
		{
			var iframeOverlay = document.createElement('iframe');
			$(iframeOverlay).css({width: popupObj.width(), height: popupObj.height(), top: '0', left: '0', position:'absolute',zIndex: popupObj.css('z-index')-1, display:'none'});
			iframeOverlay.setAttribute('frameborder','0');
			iframeOverlay.setAttribute('id','iframeOverlay');
			outlineObj.prepend(iframeOverlay);
		}
		outlineObj.show();
	}

	return this.each(function() {
		
		var popupObj = $(this);		
					
		//code for IE6, setting the switches to prevent double popups
		if($.browser.msie){
			if (this.id == 'getHelp'){
				if (getHelpOn == false){
					getHelpOn = true;
				} else {
					return false;
				}
			} else if (this.id == 'testonPage'){
				if (testonPageOn == false){
					testonPageOn = true;
				} else {
					return false;
				}
			}
		}
		//add class to object
		popupObj.addClass(popupClass);
		popupObj.addClass("popupLoaded");
		
		//do prep function
		options.doBefore(popupObj);

		//load any remote data specified into content area
		if(options.contentLoadPath)
		{
			var elem = $(popupObj).find('.' + options.contentClass);
			elem.innerHTML = "Loading...";			
			elem.load(options.contentLoadPath);
		}
		
		//get zIndex based on existing popup layers
		
		var popupZIndex = setZIndex(popupObj);
		//create translucent layover
		createModalLayer(popupZIndex);
		
		//hide selects in IE6 for select zIndex error
		if($.browser.msie && $.browser.version() < 7 && !options.onPage){
			$('select').css('visibility','hidden');
			$(this).find('select').css('visibility','visible');
		}
		
		if ((($.browser.safari && typeof($.browser.version) != 'function' 
				&& parseInt($.browser.version) < 420) || detectMacXFF2() == true) && !options.onPage) {

			if($("#shuffle"))
				$("#shuffle").hide();
				
			//if (document.getElementById('shuffle')) {
			//	document.getElementById('shuffle').style.visibility = 'hidden';
			//}
			if (detectMacXFF2() == true) 
			{
				$('.inactive').css({'filter':'alpha(opacity=100)','opacity': '1','-moz-opacity':'1', 'display':'none'}); 
			};
			
			if ($('.mwzAnon').length != 0) {
				//$('.mwzAnon').css({visibility: 'hidden'});
				$('.mwzAnon').hide();
			}
			if ($('#organizer').length != 0) {
				//document.getElementById('organizer').style.visibility= 'hidden';
				$("#organizer").hide();
			}
			if ($('.tableWrap .innerb').length != 0) {
				$('.tableWrap .innerb').css('overflow','hidden')
			}
			$('#existSourceList').css('overflow','hidden');
			$('#citeSourceList').css('overflow','hidden');
			$('#newSourceList').css('overflow','hidden');
			$('#viewSourceList').css('overflow','hidden');
			$('#noteListContainer').css('overflow','hidden');	
		}
		if (!options.onPage) {
			//$('body').css({overflow:'hidden'});
		}
		
		//add inner wrapper for popup design

		var popupHeader = $(popupObj).find('h1:first');
		if(popupHeader.find('div').length==0){
			popupHeader.wrapInner('<div></div>');
		}
		
		//insert popup close button if missing
		if(popupObj.find('.' + options.closeClass).length==0){
			popupHeader.before('<a class="' + options.closeClass + '" title="' + options.closeHelpText + '" href="#" onclick="return false;"><img alt="Close Popup" src="' + options.closeImgSrc + '" /></a>');
		}
		
		//add popup bottom
		if(popupObj.find('.popupBot').length==0){
			var botWidth = popupObj.width()-8;
			popupObj.append('<div class="popupBot"><div></div></div>');
		}
		
		//add on page popup balloon arrow
		if(options.onPage && options.balloon && arrow == true){
			popupObj.prepend('<div class="arrow"></div>');	
		}else{
			popupObj.find('.arrow').remove();
		}
	
		//correct safari overflow auto width bug
		if(jQuery.browser.safari && !options.onPage){
			popupObj.find('.content').width(popupObj.width()-20);
		}
		
		//position popup
		popupObj.popupPosition({coords:options.coords,onPage:options.onPage,
									balloon:options.balloon}); //positionPopup(popupObj);
		//shape outline dimensions and show outline
		
		shapeModalOutline(popupObj);
		//show popup
		popupObj.show();	
		
		//add positioning on resize
		$(window).resize(popupResize);
		
		//if they click outside the popup, it'll close
		background_close = "div."+locateClass+"Handler";
		$(background_close).click(function(){
			if(options.blockClosing == true) {
				return false;
			}
			
			popupObj.popupClose({onPage:options.onPage,doAfter:doAfterFunction});
			return false;
		});
		
		//add close functionality to close button
		popupObj.find('.popupClose').click(function(){
			if(options.blockClosing == true) {
				return false;
			}
			
			popupObj.popupClose({onPage:options.onPage,doAfter:doAfterFunction});
			return false;
		});
		
		//do callback function
		
		options.doAfter(popupObj);
		
		// Nabeel - added an event trigger so we know when
		//	a popup has opened
		$(this).trigger("popupOpened");
		return false;
	});
	};  
})(jQuery); 



 /********  balloon ************/
(function($){  
	$.fn.balloon = function(clickedOrCoord) {  
	//clickedOrCoord - DOM Element or coordinate {x:integer,y:integer} - passed in for determining location of balloon
	
		return this.each(function() {  
			if(clickedOrCoord.x){
				$(this).popup({balloon:true,coords:clickedOrCoord})
			}else{
				$(this).popup({balloon:true,parent:clickedOrCoord})	
			}
		});
	
	};  

})(jQuery); 
 
 
 
 /********  popupClose ************/
(function($){  
	$.fn.popupClose = function(options) {  
	//popupClass - string - class be used for the popup

	var defaults = {  
			overPageClass:"overpagePopup",
			onPageClass:"onpagePopup",
			closeClass:"popupClose",
			onPage:false,
			doBefore:function(popup){},
			doAfter:function(popup){}
	};  
	
	var options = $.extend(defaults, options);  
	
	if(options.onPage){
		
		//on page popup defaults
		var popupClass = options.onPageClass;
		if (detectMacXFF2()){
			var onPageDef = {
				outlineClass:"onpageOutlineffmac"
			}
		} else {
			var onPageDef = {
				outlineClass:"onpageOutline"
			}			
		}
		
		options = $.extend(onPageDef, options);  
		
	}else{
		
		//over page popup defaults
		var popupClass = options.overPageClass;	
		if (detectMacXFF2()){
			var overPageDef = {
				outlineClass:"modalOutlineffmac",
				layerClass:"modalLayerffmac"
			}
		} else {
			var overPageDef = {
				outlineClass:"modalOutline",
				layerClass:"modalLayer"
			}

		}
		options = $.extend(overPageDef, options); 
	}
	
	
	return this.each(function() {  
		var popupObj = $(this);
		if($.browser.msie){
			//code for IE6 variable set
			if (this.id == 'getHelp'){ 
				getHelpOn = false;
			} else if (this.id == 'testonPage'){ 
				testonPageOn = false;
			}
		}
		
		// Nabeel - added an event trigger so we know when
		//	a popup has opened
		$(this).trigger("popupClosed");
		
		
		//popupObj.find(".content").html("");
		
		if(popupObj.hasClass(popupClass)){
		
			//do prep function
			options.doBefore(popupObj);
	
			var popupZIndex = popupObj.css('zIndex');
		   	popupObj.hide();			
		
			windowtitle = '.forPopup' + popupZIndex;
			$(windowtitle).remove();
			popupObj.removeClass("popupLoaded");
			
			
			//console.log("Removed layer "+windowtitle);
			
			if($.browser.msie && $.browser.version() < 7)
			{
				if($('.' + options.layerClass).length==0)
				{
					$('select').css('visibility','visible');
				} 
				else 
				{
					$('.projectName').css('visibility','visible');
				}
			}
			if ((($.browser.safari && typeof($.browser.version) != 'function' && parseInt($.browser.version) < 420) || detectMacXFF2() == true) && !options.onPage) {
				if (document.getElementById('shuffle')) {
					document.getElementById('shuffle').style.visibility = 'visible';
				}
				if (detectMacXFF2() == true) {
					$('.inactive').css({'filter':'alpha(opacity=30)','opacity': '0.3','-moz-opacity':'0.3', 'display':'block'});				
				};
				if ($('.mwzAnon').length != 0) {
					$('.mwzAnon').css({visibility: 'visible'});
				}
				if ($('#organizer').length != 0) {
					document.getElementById('organizer').style.visibility= 'visible';
				}
				if ($('.tableWrap .innerb').length != 0) {
					$('.tableWrap .innerb').css('overflow','auto')
				}	
				$('#existSourceList').css('overflow','auto');
				$('#citeSourceList').css('overflow','auto');
				$('#newSourceList').css('overflow','auto');
				$('#viewSourceList').css('overflow','auto');
				$('#noteListContainer').css('overflow','auto');			
			}

			/*if (!options.onPage) {
				//document.body.style.overflow = 'auto';
			}*/
		if (options.scrollbars && !options.onPage) {
				$('div.'+ options.layerClass).css({overflow: 'hidden'});
			}
			$('#iframeOverlay').remove();
			//do callback
			options.doAfter();
		}
		if ($.browser.mozilla) {
			$('#tasks').css('display','block');	
		}
	
		
		$(popupObj).css('z-index','0');
		//$(popupObj).find('*').css('z-index','0');
		tmpIndex = getHighestZIndex();		
		
	});
	};  
})(jQuery); 

 /********  popupPosition ************/
(function($){  
	$.fn.popupPosition = function(options) {  
	
	var defaults = {  
			onPage:false,
			balloon:true,
			coords:false
	};  
	
	var options = $.extend(defaults, options);  
	
	if(options.onPage)
	{	
		//on page popup defaults
		if (detectMacXFF2() == true)
		{
			var onPageDef = {
				outlineThick:8,
				outlineClass:"onpageOutlineffmac"
			}	
		} 
		else 
		{
			var onPageDef = {
				outlineThick:8,
				outlineClass:"onpageOutline"
			}
		}
		
		options = $.extend(onPageDef, options);  
		
	}
	else
	{
		
		//over page popup defaults
		if (detectMacXFF2() == true)
		{
			var overPageDef = {
				outlineThick:15,
				outlineClass:"modalOutlineffmac",
				layerClass:"modalLayerffmac"
			}
			
		} 
		else 
		{
			var overPageDef = {
				outlineThick:15,
				outlineClass:"modalOutline",
				layerClass:"modalLayer"
			}
		}
		
		options = $.extend(overPageDef, options); 
	}
	
	if(options.balloon){
		var arrowWidth = 50;
		var arrowHeight = 40;
		var arrowIndent =20;
		
		var arrowTopRightSRC = "/images/common/onpage_warr_tright.png";
		var arrowTopRightOutlineSRC = "/images/common/onpage_barr_tright.png";
		var arrowTopLeftSRC = "/images/common/onpage_warr_tleft.png";
		var arrowTopLeftOutlineSRC = "/images/common/onpage_barr_tleft.png";		
		
		var arrowBotRightSRC = "/images/common/onpage_warr_bright.png";
		var arrowBotRightOutlineSRC = "/images/common/onpage_barr_bright.png";
		var arrowBotLeftSRC = "/images/common/onpage_warr_bleft.png";
		var arrowBotLeftOutlineSRC = "/images/common/onpage_barr_bleft.png";
	}
	
	return this.each(function() {  
	
		var popupObj = $(this);
		var locateClass = "forPopup" + popupObj.css('zIndex');
		
		var outlineObj = $('.' + options.outlineClass).filter('.' + locateClass);
		
		var pwidth = popupObj.width();
		var pheight = popupObj.height();
		var winWidth = $(window).width();
		
		if($.browser.msie && $.browser.version() < 7)
		{
			var winHeight =  window.document.documentElement.clientHeight;
			var heightOffset = 0;
		}
		else
		{
			var winHeight = $('body').height();
			var heightOffset = 0;
		}
			
		if(!options.coords){
			
			//do as floating, centered popup

			if(winWidth>pwidth){
				pleft = parseInt((parseInt(winWidth)-parseInt(pwidth))/2);
			}else{
				pleft=5;
			}
			
			// Nabeel
			ptop = $(document).scrollTop();
			ptop = ptop+30;

			//if($.browser.msie && $.browser.version() < 7){
			popupObj.css({position:"absolute",left:pleft + "px",top:ptop + "px"});
			outlineObj.css({position:"absolute",left:(pleft-options.outlineThick) + "px", top:(ptop-options.outlineThick) + "px"});
			/*}else{
				popupObj.css({position:"fixed",left:pleft + "px",top:ptop + "px"});
				outlineObj.css({position:"fixed",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});

			}*/
							
			if($.browser.msie && $.browser.version() < 7)
			{
				popupObj.css({position:"absolute",left:pleft + "px",top:ptop + "px"});
				outlineObj.css({position:"absolute",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});
			}else
			{
				// Nabeel
				popupObj.css({position:"absolute",left:pleft + "px",top:ptop + "px"});
				outlineObj.css({position:"absolute",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});
			}
		}
		else
		{
			
		// Do with coordinates
			if(options.balloon){
				var topY = $(window).scrollTop();
				var leftX = $(window).scrollLeft();
				if($.browser.msie && $.browser.version() < 7){
					var edgeX = leftX + window.document.documentElement.clientWidth;
				}else{
					var edgeX = leftX + winWidth;
				}
				var edgeY = topY + winHeight;
				var arrowIsTop = true;
				
				if(options.coords.y + pheight > edgeY && (options.coords.y - topY   > pheight + 40 )){
					arrowIsTop =false;
					outlineObj.css({paddingBottom:"40px",paddingTop:"0px"});
					popupObj.css({marginBottom:"40px",marginTop:"0px"});
					var arrowBgAlign = "bottom";
				}else{
					if (arrow == true){
						outlineObj.css({paddingTop:"40px",marginBottom:"0px"});
						popupObj.css({marginTop:"40px",paddingBottom:"0px"});
						var arrowBgAlign = "top";
					} else {
						outlineObj.css({paddingTop:"0px",marginBottom:"0px"});
						popupObj.css({marginTop:"0px",paddingBottom:"0px"});
						var arrowBgAlign = "top";
					
					}
				}
				
				//position x
				if(options.coords.x + pwidth < edgeX || pwidth > winWidth)
				{	//if space on left
					if(arrowIsTop)
					{
						var arrowPic = arrowTopLeftSRC;
						var arrowOutlinePic = arrowTopLeftOutlineSRC;
						var arrowTopPos = 0 -arrowHeight+4;
						var arrowOutlineTopPos = 0;
						var arrowOutlineLeftPos = arrowIndent;
						pleft=options.coords.x-arrowIndent;
					}
					else
					{
						var arrowPic = arrowBotLeftSRC;
						var arrowOutlinePic = arrowBotLeftOutlineSRC;
						var arrowTopPos = pheight-1;
						var arrowOutlineTopPos = pheight + 8*2;
						var arrowOutlineLeftPos = arrowIndent;
						pleft=options.coords.x-arrowIndent;
					}
				
					popupObj.find('.arrow').css({left:(arrowIndent) + "px",top:arrowTopPos + "px",background:"url(" + arrowPic + ") no-repeat " + arrowBgAlign});
					outlineObj.find('.arrow').css({left:arrowOutlineLeftPos + "px",top:arrowOutlineTopPos + "px",background:"url(" + arrowOutlinePic +") no-repeat " + arrowBgAlign});
				}
				else
				{	//if space on right
					if(arrowIsTop)
					{
						var arrowPic = arrowTopRightSRC;
						var arrowOutlinePic = arrowTopRightOutlineSRC;
						var arrowTopPos = 0 -arrowHeight+4;
						var arrowOutlineTopPos = 0;
						var arrowleftPos = pwidth-(arrowIndent + arrowWidth) + 9;
						var arrowOutlineLeftPos = arrowleftPos + 8;
						pleft=options.coords.x + arrowIndent -pwidth;
					}
					else
					{					
						var arrowPic = arrowBotRightSRC;
						var arrowOutlinePic = arrowBotRightOutlineSRC;
						var arrowTopPos = pheight -1;
						var arrowOutlineTopPos = pheight + 8*2;
						var arrowleftPos = pwidth-(arrowIndent + arrowWidth) + 9;
						var arrowOutlineLeftPos = arrowleftPos + 8;
						pleft=options.coords.x + arrowIndent - pwidth;
						
					}
					
					popupObj.find('.arrow').css({left:(arrowleftPos) + "px",top:arrowTopPos + "px",background:"url(" + arrowPic + ") no-repeat " + arrowBgAlign});
					outlineObj.find('.arrow').css({left:(arrowOutlineLeftPos) + "px",top:arrowOutlineTopPos + "px",background:"url(" + arrowOutlinePic + ") no-repeat " + arrowBgAlign});
				}
				
				//position y
				
				if(arrowIsTop)
				{
					ptop=options.coords.y;
					if ($.browser.msie && $.browser.version() < 7) {
						ptop += topY;	
					}
				}
				else
				{
					ptop=options.coords.y - (pheight + arrowHeight);
				}
			}
			else
			{
				//reset padding
				outlineObj.css({paddingTop:"0px",marginBottom:"0px"});
				popupObj.css({marginTop:"0px",paddingBottom:"0px"});
				
				//set left and top loc
				pleft=options.coords.x;
				ptop = options.coords.y;
				
			}
			
			if (viewModel == true)
			{
				if($.browser.msie && $.browser.version() < 7)
				{
					popupObj.css({position:"relative",left:pleft + "px",top:ptop + "px"});
					outlineObj.css({position:"relative",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});
				} 
				else 
				{	
					popupObj.css({position:"fixed",left:pleft + "px",top:ptop + "px"});
					outlineObj.css({position:"fixed",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});
					viewModel = false;
				}
			} 
			else 
			{			    
				popupObj.css({position:"absolute",left:pleft + "px",top:ptop + "px"});
				outlineObj.css({position:"absolute",left:(pleft-options.outlineThick) + "px",top:(ptop-options.outlineThick) + "px"});
			}
		}	
	});
};  
})(jQuery); 




 /********  warning ************/
function warning(options) {  
/*options:
	title - string - title of warning
	msg - string/html - warning message to user
	yesAction - function - action to take on yes
	noAction - function - action to take on no
	cancelAction - function - action to take on cancel click
	buttons - array - button names and values.
	see popup function for more options
*/
	if (!options.buttons) {
		yesbutton = "Yes";
		nobutton = "No";
	} else {
		yesbutton = options.buttons.split(",")[0];
		nobutton = options.buttons.split(",")[1];
	}
	var newWarning = $(document.createElement('div'));
	newWarning.append('<h1>' + options.title + '</h1>');
	newWarning.addClass('warningPopup');
	
	var content = $(document.createElement('div'));
	content.addClass('content');
	content.append('<div>' + options.msg + '</div>');
	var tmpstring = '<div class="warningButtons">';
	if (yesbutton != 'null') {
		tmpstring += '<input type="button" class="truebutton" name="yes" value="'+yesbutton+'"/>';
	}
	if (nobutton != 'null') {
		tmpstring += '<input class="truebutton" type="button" name="no" value="'+nobutton+'"/>';
	}
	tmpstring += '</div>';
	content.append(tmpstring);
	
	//handle yes action
	content.find('.warningButtons input[@name="yes"]').click(function(){
		newWarning.popupClose();
		if (typeof(options.yesAction) == 'function')
		 options.yesAction();
		
	 });
		
	//handle no action
	if(nobutton != "")
	{	
		content.find('.warningButtons input[@name="no"]').click(function(){
			newWarning.popupClose();
			if (typeof(options.noAction) == 'function')
				options.noAction();
		 });
	}
	
	newWarning.append(content);
	
	newWarning.prependTo('body');
	newWarning.popup({});
	doAfterFunction = options.doAfter;
	
	//add cancel action
	newWarning.find('.popupClose').click(function(){
		if (typeof(options.cancelAction) == 'function')
			options.cancelAction();
   });
}
	
	
/*
	function getPageSizeWithScroll
	gets the height and width of the page with the scroll added in
	Params - none;
	result - returns an array with the height and width of the page with the scroll added ini
*/
function getPageSizeWithScroll(){
	if (window.innerHeight && window.scrollMaxY) {// Firefox
		yWithScroll = window.innerHeight + window.scrollMaxY;
		xWithScroll = window.innerWidth + window.scrollMaxX;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		yWithScroll = document.body.scrollHeight;
		xWithScroll = document.body.scrollWidth;
	} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
		yWithScroll = document.body.offsetHeight;
		xWithScroll = document.body.offsetWidth;
  	}
	arrayPageSizeWithScroll = {width:xWithScroll,height:yWithScroll};
	
	return arrayPageSizeWithScroll;
}