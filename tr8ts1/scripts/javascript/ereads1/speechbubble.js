//if(typeof(console) === 'undefined') {
//    var console = {}
//    console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {};
//}

//prevent click on all links with class popuptext
window.addEvent('domready', function() {
	$each($$('.popuptext'),function(el) {
		el.addEvent('click',function(event) {
			event.preventDefault();
		});
	});
});
		var mySound = null;
		function soundCallback(inID, inStatus){
		    if (inStatus == 'ready') {
		        if (inID == 'mySound') {
		        	mySound.play();            
		        }
		    }
		    else if (inStatus == 'done') {
		        //alert(inID + ": complete");
		    }
		}
		
var speechbubble_ajax = function(xOffset, yOffset, speechBoxSuffix, speechBoxClose) {

	//select all speechboxes HTML
	var speechBoxes = $(document.body).getElements('[id$=' + speechBoxSuffix + ']');
	//select all LINKS that need inline box
	var textLinks = $('articletext').getElements('a.popuptext');
	//make sure all the speechboxes are not displayed
	var closeBoxes = function() { speechBoxes.setStyle('display', 'none'); };
	var fireMP3 = function(mp3_id) { 
		//mySound = new GI_Sound("mySound", "/limelight/TaDa.mp3", false, "soundCallback");		
		mySound = new GI_Sound("mySound", "/limelight/"+mp3_id+".mp3", false, "soundCallback");		
		class_id = "mp3player";
		$(class_id).set({html: mySound.getHTML()});
			//alert(mp3_id);
		var len = mp3_id.length;
		var lch = mp3_id.charAt(len-1); //checking the last character of mp3_id for stats  
		//alert(lch);
		if(lch == 'v')
		{
			collectStat('tts','ereads','vocab', mp3_id);		
		}else
		{
			
			collectStat('contents','ereads','readaloud', mp3_id);
		}
	};

	//itterate through all the links and add mouseover to each
	textLinks.each(function(item){
		//get HREF from each link
		thisId=item.getProperty('href');
		
		//get class and remove popuptext so now all that is left is either  'content' or 'scaffold' or 'academic'
		thisClass = item.getProperty('class');
		thisClass = thisClass.replace('popuptext ', '');
		
		//make the HREF an ID and inject into link
		$(item).setProperty ( 'id' , "pop_"+thisId ) ;
		//get the ID in case above failed or link had an id or something else happened
		var currentLink = item.getProperty('id');
		//the new id will have _speechbubble attached to ID
		var speechBoxId=thisClass+'_speechbubble';
		//grab the link using above id
		var speechBox = $(speechBoxId);
		
		//clear margin
		item.setStyle('margin', '0');
		//add mouseeneter event, with ajax built in
		$(currentLink).addEvent('click', function(){
				
				//shut down ALL opeen popups
				speechBoxes.setStyle('display', 'none');

 				//clear div just in case its lingering, add loading image
				$(speechBoxId).set({html: '<img src="/images/ajax-loader.gif" id="loadingAJAX">'});
				
		 		//make the ajax call, replace text
				var req = new Request.HTML({
					method: 'get',
					url: '/article/popup_request.php',
					data: { 'href' : $(currentLink).getProperty('href') },
					onRequest: function() { },
					update: $(speechBoxId),
					onComplete: function(response){  
						
						//set close button  
						var closeElem = $(document.body).getElements('.' + speechBoxClose);
						closeElem.addEvent('click', function(){ closeBoxes() }).setStyle('cursor', 'pointer');
											
						//set fire mp3 button  
						var fireMP3Elem = $(document.body).getElements('.' + 'firemp3');
						fireMP3Elem.addEvent('click', function(){ fireMP3($(currentLink).getProperty('href')) }).setStyle('cursor', 'pointer');
						
						
					 }//end onComplete
				}).send();
		
				//coordinates and size vars and math
				var windowSize = $(window).getSize();
				var windowScroll = $(window).getScroll();
				var halfWindowY = windowSize.y / 2;
				var halfWindowX = windowSize.x / 2;
				var boxSize = item.getSize();
				var inputPOS = $(currentLink).getCoordinates();
				var inputCOOR = $(currentLink).getPosition();
				var inputSize = $(currentLink).getSize();
				var inputBottomPOS = inputPOS.top + inputSize.y;
				var inputBottomPOSAdjust = inputBottomPOS - windowScroll.y
				var inputLeftPOS = inputPOS.left + xOffset;
				var inputRightPOS = inputPOS.right;
 
 				//adjust position depending on size of browser and position of element
				if(halfWindowX<500)
							halfWindowX=504;
				
				var leftAdjust=(inputPOS.left)-(halfWindowX-504);
	 			
				//use this to dump POSITIONING VARS in case its off
				 //console.log("The element is "+inputSize.x+" pixels wide and "+inputSize.y+"pixels high.");
				 //console.log("The inputCOOR is "+inputCOOR.x+" in x  and "+inputCOOR.y+" in y");
				 //console.log("The inputPOS is "+inputPOS.left+" in x  and "+inputPOS.right+" in y");
 				 //console.log("halfWindowX="+halfWindowX+" TOP="+((inputPOS.top - boxSize.y) - 120 )+" LEFT="+leftAdjust);
   				 //set position TOP and LEFT
				speechBox.setStyle('top', inputPOS.top - boxSize.y - 100);
				speechBox.setStyle('left', leftAdjust);
 				speechBox.setStyles({ display: 'block', position: 'absolute' }).setStyle('z-index', '1000000');
 	
		}).setStyle('cursor', 'pointer');
		
		
		
	});
};


 
		