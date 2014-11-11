/** 
	@file: jquery.loading.js
	@description: This is a jQuery plugin for the loading message in the workzone 

	This file makes heavy use of jQuery (indicated by the word 'jquery' or the symbol '$')
	jQuery documentation can be found at http://docs.jquery.com/Main_Page
	
	jquery.loading.js variables:
	
	startLoaderPause -
	tmpoptions -
	loaderopen -
**/

var startLoaderPause = true;
var tmpoptions;
var loaderopen = true;

(function($){
	/*
	
	function stopLoader
	stops the loader in the workzone
	params - options - an array of options to be used with the loader
		{
			loaderid - the id of the loader
			fadeIn - whether the assignment should fade in
			fadeOut - whether the assignment should fade out
			fadeIntime - the length of the fade in
			fadeOuttime - the length of the fade out
		}
	
	*/
	$.fn.stopLoader = function(options) {
		startLoaderPause = false;
		var defaults = {
			loaderid: 'loaderid' ,
			fadeIn: false,
			fadeOut: false,
			fadeIntime: 200,
			fadeOuttime: 200
		}	
		$.extend(defaults,options);	
		options.loadedid = this;
		//show the workzone and hide the loader
		if (options.fadeIn) {
			$(options.loadedid).fadeIn(options.fadeIntime);
		} else {
			$(options.loadedid).show();
		}
		if (options.fadeOut) {
			$('#'+options.loaderid).fadeOut(options.fadeOuttime);	
		} else {
			$('#'+options.loaderid).hide();
		}
		//loader is not open
		loaderopen = false;
	}
})(jQuery);

(function($){
	/*
	
	function startLoader
	starts the loader in the workzone
	params - options - an array of options to be used with the loader
		{
			loaderid - the id of the loader
			fadeIn - whether the assignment should fade in
			fadeOut - whether the assignment should fade out
			fadeIntime - the length of the fade in
			fadeOuttime - the length of the fade out
		}
	
	*/
	$.fn.startLoader = function(options) {
		if (startLoaderPause == false) {
			startLoaderPause = true;
			return false;
		}
		var defaults = {
			loaderid: 'loaderid' ,
			fadeIn: false,
			fadeOut: false,
			fadeIntime: 200,
			fadeOuttime: 200,
			pause: false
		}	
		$.extend(defaults,options);	
		options.loadedid = this;
		//if there is a pause try again after the pause
		if (options.pause !== false) {
			tmpoptions = options;
			setTimeout('$("#'+$(options.loadedid).attr('id')+'").startLoader(tmpoptions)',options.pause);
			startLoaderPause = true;
			return false;
		}
		//fade the workzone out and the loader in
		if (options.fadeIn) {
			$('#'+options.loaderid).fadeIn(options.fadeIntime);
		} else {
			$('#'+options.loaderid).show();
		}
		if (options.fadeOut) {
			$(options.loadedid).fadeOut(options.fadeOuttime);	
		} else {
			$(options.loadedid).hide();
		}
		loaderopen = true;
	}
})(jQuery);
(function($){
		  	/*
	
	function isopenloader
	determines if the loader is open
	params - none
	
	*/
	$.fn.isopenloader = function() {
		return loaderopen;
	}
})(jQuery);