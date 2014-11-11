//this is the script that handles onpage popups from the main page
var onpagePopup;
 
(function() {

	// Global variables, accessible to onpagebox only
	var options, openThis, top, mTop, left, mLeft, winWidth, winHeight, fx, preload, 
	foxfix = false, iefix = false,
	// DOM elements
	overlay, center, pop_content, topBoxHeading, captionText, popupCaptionImage, title, caption, 
	// onpagebox specific vars
	URL, WH, WHL, elrel, mediaWidth, mediaHeight, mediaSplit, mediaId = "onpagebox";

	/*
		Initialization
	*/
 
	window.addEvent("domready", function() {

		// Create and append the onpagePopup HTML code at the bottom of the document
		$(document.body).adopt(
			$$([
				overlay = new Element("div", {id: "mbOverlay"}),
				center = new Element("div", {id: "mbCenter"})
			]).setStyle("display", "none")
		);
		
 		topBox = new Element("div", {id: "mbTopSection"}).injectInside(center).adopt(
			new Element("div", {id: "mbrbtop"}).adopt(
			topImage=new Element('img', {'class':'popup_topimage' })
													),
			title = new Element("div", {id: "mbTitle"}),
			
			new Element("a", {id: "mbCloseLink", href: "#", text:"CLOSE"}).addEvent("click", close)
		);
		
		 
		 
		pop_content = new Element("div", {id: "mbContent"}).injectInside(center);
		
		bottom = new Element("div", {id: "mbbottomRight"}).injectInside(center).adopt(
		 new Element("div", {id: "mbbottomLeft"})
		);

		fx = {
			overlay: new Fx.Tween(overlay, {property: "opacity", duration: 360}).set(0),
			pop_content: new Fx.Tween(pop_content, {property: "opacity", duration: 0, onComplete: captionShow}),
			topBox: new Fx.Tween(topBox, {property: "opacity", duration: 0}).set(0) 
		};
 
		 
	});

	/*
		API
	*/

	onpagePopup = {
		close: function(){ 
			close();	
		}, 

		openMainPageBox: function(_openThis, popupTopText, _options, topOffset, popupTopImage, closeButtonPosition) {
			
 
				windowDim = _options.split(' ');
 				width=parseFloat(windowDim[0]);
				height=parseFloat(windowDim[1])
	
				options = $extend({
				overlayOpacity: 0.7,			// 1 is opaque, 0 is completely transparent (change the color in the CSS file)
				initialWidth: width,			// Initial width of the box (in pixels)
				initialHeight: height,			// Initial height of the box (in pixels)
				
				defaultWidth: 380,				// Default width of the box (in pixels) for undefined media (MP4, FLV, etc.)
				defaultHeight: 383,				// Default height of the box (in pixels) for undefined media (MP4, FLV, etc.)
				showCaption: true,				// Display the title and caption, true / false
				topOffset:topOffset,			// used to bring the box closer to the top of browser OFFSET	 
				closeButtonPosition:closeButtonPosition,
				popupCaptionImage:popupTopImage
				}, _options || {});
				
				
 			
 
			if ((Browser.Engine.gecko) && (Browser.Engine.version<19)) {	 
				foxfix = true;
				overlay.className = 'rateitOverlayFF';
			}

			if (typeof _openThis == "string") {	
				_openThis = [[_openThis, popupTopText,_options]];
			}

			openThis = _openThis;
			options.loop = options.loop && (openThis.length > 1);

 
			if ((Browser.Engine.trident) && (Browser.Engine.version<=5)) {	
				iefix = true;
				overlay.className = 'rateitOverlayIE';
				overlay.setStyle("position", "absolute");
				position();
				
			}
			size();
			setup(true);
	 
			
			top = window.getScrollTop() + (window.getHeight()/2);
			left = window.getScrollLeft() + (window.getWidth()/2);
			fx.resize = new Fx.Morph(center, $extend({duration: 240, onComplete: contentStart}, false ? {transition: false} : {}));
 
			
			//check browser and make small size adjustments
			if ((Browser.Engine.trident) && (Browser.Engine.version<=5)) {	
				
			//IE7 & IE6 needs different size
			options.initialWidth+=32;
			options.initialHeight+=0;
			options.topOffset=40
			
			center.setStyles({top: top, left: left, width: options.initialWidth, height: options.initialHeight+110, marginTop: -(options.initialHeight/2)-options.topOffset, marginLeft: -(options.initialWidth/2), display: ""});
			
		 
			
			}else{

			//add more width/height to FF
			options.initialWidth+=12;
			options.initialHeight+=110;
			options.topOffset=-20;
				
			 center.setStyles({top: top, left: left, width: options.initialWidth, height: options.initialHeight, marginTop: -(options.initialHeight/2)-options.topOffset, marginLeft: -(options.initialWidth/2), display: ""});

			}
			


 
 
			
			
			fx.overlay.start(options.overlayOpacity);
			return showPopup();
		}
	};

 	/*
		Internal functions
	*/

	function position() {
		overlay.setStyles({top: window.getScrollTop(), left: window.getScrollLeft()});
	}

	function size() {
		winWidth = window.getWidth();
		winHeight = window.getHeight();
		overlay.setStyles({width: winWidth, height: winHeight});
	}

	function setup(open) {
		// Hides on-page objects and embeds while the overlay is open, nessesary to counteract Firefox stupidity
		["object", window.ie ? "select" : "embed"].forEach(function(tag) {
			Array.forEach(document.getElementsByTagName(tag), function(el) {
				if (open) el._onpagebox = el.style.visibility;
				el.style.visibility = open ? "hidden" : el._onpagebox;
			});
		});

		overlay.style.display = open ? "" : "none";
	 

		var fn = open ? "addEvent" : "removeEvent";
		if (iefix) window[fn]("scroll", position);

		document[fn]("keydown", keyDown);
	}

	function keyDown(event) {
		switch(event.code) {
			case 27:	// Esc
			case 88:	// 'x'
			case 67:	// 'c'
				close();
				break;
		}
	}

	function showPopup() {

			pop_content.set('html', '');
			stop();
 
			// onpagebox FORMATING
			WH = openThis[0][2].split(' ');
			WHL = WH.length;
 				//calculate size and add PX
				mediaWidth = (WH[WHL-2].match("%")) ? (window.getWidth()*("0."+(WH[WHL-2].replace("%", ""))))+"px" : WH[WHL-2]+"px";
				mediaHeight = (WH[WHL-1].match("%")) ? (window.getHeight()*("0."+(WH[WHL-1].replace("%", ""))))+"px" : WH[WHL-1]+"px";
 
			URL = openThis[0][0];
			URL = encodeURI(URL).replace("(","%28").replace(")","%29");

			captionText = openThis[0][1].split('::');
 		 
			//small adjustments to IFRAME size by browser 
			if ((Browser.Engine.trident) && (Browser.Engine.version<=5)) {	
				//CALC iframe size for ie6 n ie7
				mediaWidth = options.initialWidth-10;
				mediaHeight = options.initialHeight;

			}else{

			    //CALC iframe size for FF and IE8
				mediaWidth = mediaWidth || options.defaultWidth;
				mediaWidth_fix = mediaWidth;
				mediaHeight = mediaHeight || options.defaultHeight;

			}
				mediaId = "mediaId_"+new Date().getTime();	// Safari will not update iframe content with a static id.
			
				preload = new Element('iframe', {
					'src': URL,
					'id': mediaId,
					'class': 'iframemaincontent',
					'width': mediaWidth,
					'height': mediaHeight,
					'name': 'myFrame',
					'frameborder': 0
					});
				
				
				startIframeDisplay();
			 
	 
		return false;
	}

	function startIframeDisplay() {

 			//URL open
			preload.setStyles({'background-color':'white'});
			pop_content_iframe = new Element("div", {id: "innerboxMainContent"}).injectInside(pop_content);
			pop_content_iframe.setStyles({backgroundImage: "none", display: ""});
			preload.inject(pop_content_iframe);
			pop_content_iframe.setStyles({width: mediaWidth, height: mediaHeight});
			title.set('html', (options.showCaption) ? captionText[0] : "");

		//set the SOURCE of the top image
		topImage.set('src',options.popupCaptionImage);
	 
		//this will HIDE the top right close button if needed
		if(options.closeButtonPosition=='no'){
			closeButton.setStyles({visibility:'hidden' });
		}
		
			contentStart(); 
	}

	function contentStart() {
		fx.topBox.start(1);
		fx.pop_content.start(1);
	}

	function captionShow() {	
		center.className = "";
	}

	function stop() {
		if (preload) preload.onload = $empty;
		fx.resize.cancel();
		fx.pop_content.cancel().set(0);
		fx.topBox.cancel().set(0);

	}

	function close() {
			preload.onload = $empty;
			pop_content.set('html', '');
			for (var f in fx) fx[f].cancel();
			center.setStyle("display", "none");
			fx.overlay.chain(setup).start(0);
		return false;
	}
 
	
	
})();