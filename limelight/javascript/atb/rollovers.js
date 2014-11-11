<!-- begin atb:rollovers.js -->

<!-- for navigation -->
var Feature = "";
var queryParams = new Array();

/* query string */
	// START OF TOP_ROLLOVERS.JS
/* This file is used by the article page.  This is the only 
 	way to get these rollovers to work with Netscape 3.x
 	All the simpler ways to do this work fine with Netscape 4.1+
 	*/

var Feature;

var feature_names= new Array("topics","almanac","games","timelines","profiles","bulletin","");
var numFeatures=feature_names.length;
var imgDirectory="/images/atb/btn_";

var topLevelIndex = getIndexFor(Feature);

/* The following section creates the 3 different button types.  The base color (blue), the 
	rollover color (red) and the active color (gray/brown).
	Upon demand these will be changed. */
	
var offImgArray = new Array(numFeatures);  //these buttons are blue
var onImgArray = new Array(numFeatures);   //these buttons are red
var activeImgArray = new Array(numFeatures); //these buttons are brown
var imagesLoaded = "no";

function loadImages() {
	var i;
	//create the off images (onMouseOut)
	for(i=0;i<numFeatures;i++){
		offImgArray[i] = new Image();
		offImgArray[i].src = imgDirectory+feature_names[i]+"_u.gif";
	}

	//create the on images (onMouseOver)
	for(i=0;i<numFeatures;i++){
		onImgArray[i] = new Image();
		onImgArray[i].src = imgDirectory+feature_names[i]+"_d.gif";
	}

	//create the active images (whichever is the topmost ancestor of current article)
	for(i=0;i<numFeatures;i++){
		activeImgArray[i] = new Image();
		activeImgArray[i].src = imgDirectory+feature_names[i]+"_d.gif";
	}
	imagesLoaded = "yes";
}
//--------------------------------------------------------------------
// * doMouseOverButton
//--------------------------------------------------------------------
function doMouseOverButton(theName){
	if (imagesLoaded != "yes") loadImages();
	thisIndex = getIndexFor(theName);
   if (thisIndex == topLevelIndex) {
   	document.images[theName].src = activeImgArray[thisIndex].src
   }
   else {
		document.images[theName].src = onImgArray[thisIndex].src
	}
  }

//--------------------------------------------------------------------
// * doMouseOutButton
//--------------------------------------------------------------------
function doMouseOutButton(theName){
   thisIndex = getIndexFor(theName);
   if (thisIndex == topLevelIndex) {
   	document.images[theName].src = activeImgArray[thisIndex].src
   }
   else {
   	document.images[theName].src = offImgArray[thisIndex].src
   }
}

//--------------------------------------------------------------------
// * doActiveImage
//--------------------------------------------------------------------
function doActiveImage() {

	if (Feature == "") return;
	loadImages(); 
	topLevelIndex = getIndexFor(Feature);
	//	alert("Feature " + Feature + "\ntopLevelIndex " + topLevelIndex);

		theName = feature_names[topLevelIndex];
		document.images[theName].src = activeImgArray[topLevelIndex].src;
}

function getIndexFor(item) {
	
  var i;
  for (i=0; i<numFeatures; i++) {
    if (item == feature_names[i]) return i;
  }
  return -1;	//not found

}

// END OF TOP_ROLLOVERS.JS
	// START OF ROLLOVERS_ENCYC.JS
/* This file is used by the article page.  This is the only 
 	way to get these rollovers to work with Netscape 3.x
 	All the simpler ways to do this work fine with Netscape 4.1+
 	*/
var toplevel = theQueryString.value("category");
var button_names= new Array("ti", "tf", "th", "tl","te","tr","tg","tc","h-","b-");

var numButtons=button_names.length;

/* The article page builder will put the top level article id in the toplevel variable.
	This array is then searched to obtain the index number to then obtain the corresponding
	button name.  The button_names array and article_names array must be in the same order
	or this doesn't work. */

var topBrowseLevelIndex = getBrowseIndexFor(toplevel);
var imgBrowseDirectory="/images/atb/browse/nav_";

/* The following section creates the 3 different button types.  The base color (blue), the 
	rollover color (red) and the active color (gray/brown).
	Upon demand these will be changed. */
	
var offBrowseImgArray = new Array(numButtons);  //these buttons are blue
var onBrowseImgArray = new Array(numButtons);   //these buttons are red
var activeBrowseImgArray = new Array(numButtons); //these buttons are brown

var i;

function loadBrowseImages() {
	//create the off images (onMouseOut)
	for(i=0;i<numButtons;i++){
		offBrowseImgArray[i] = new Image();
		offBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_a.gif";
	}

	//create the on images (onMouseOver)
	for(i=0;i<numButtons;i++){
		onBrowseImgArray[i] = new Image();
		onBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_b.gif";
	}

	//create the active images (whichever is the topmost ancestor of current article)
	for(i=0;i<numButtons;i++){
		activeBrowseImgArray[i] = new Image();
		activeBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_b.gif";
	}
}
//--------------------------------------------------------------------
// * doBrowseMouseOverButton
//--------------------------------------------------------------------
function doBrowseMouseOverButton(theName){
   thisIndex = getBrowseIndexFor(theName);
   if (thisIndex == topBrowseLevelIndex) {
   	document.images[theName].src = activeBrowseImgArray[thisIndex].src
   }
   else {
		document.images[theName].src = onBrowseImgArray[thisIndex].src
	}
  }

//--------------------------------------------------------------------
// * doBrowseMouseOutButton
//--------------------------------------------------------------------
function doBrowseMouseOutButton(theName){
   thisIndex = getBrowseIndexFor(theName);
   if (thisIndex == topBrowseLevelIndex) {
   	document.images[theName].src = activeBrowseImgArray[thisIndex].src
   }
   else {
   	document.images[theName].src = offBrowseImgArray[thisIndex].src
   }
}

//--------------------------------------------------------------------
// * doActiveBrowseImage
//--------------------------------------------------------------------
function doActiveBrowseImage() {
		loadBrowseImages();
		theName = button_names[topBrowseLevelIndex];
		document.images[theName].src = activeBrowseImgArray[topBrowseLevelIndex].src;
}

function getBrowseIndexFor(item) {
	
  var i;
  for (i=0; i<numButtons; i++) {
    if (item == button_names[i]) return i;
  }
  return -1;	//not found

}

<!-- end atb:rollovers.js -->
