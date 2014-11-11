// START OF ROLLOVERS_ENCYC.JS
/* This file is used by the article page.  This is the only 
 	way to get these rollovers to work with Netscape 3.x
 	All the simpler ways to do this work fine with Netscape 4.1+
 	*/

var button_names= new Array("africa", "asia", "europe", "n_america","c_america",
                                "s_america","islands","australia","oceania",
                                "arctic", "world");

var africa="4041200";
var asia="4046800";
var europe="4054400";
var n_america="4060200";
var c_america="4064900";
var s_america="4064950";
var islands="4061800";
var australia="4052300";
var oceania="4052600";
var arctic="4064955";
var world="4101426";

var numButtons=button_names.length;

/* The article page builder will put the top level article id in the toplevel variable.
	This array is then searched to obtain the index number to then obtain the corresponding
	button name.  The button_names array and article_names array must be in the same order
	or this doesn't work. */
var article_names = new Array(africa, asia, europe, n_america, c_america, s_america,
							islands, australia, oceania, arctic, world);

var topLevelIndex = getIndexFor(toplevel);

var imgDirectory="/images/encyc/";

/* The following section creates the 3 different button types.  The base color (blue), the 
	rollover color (red) and the active color (gray/brown).
	Upon demand these will be changed. */
	
var offImgArray = new Array(numButtons);  //these buttons are blue
var onImgArray = new Array(numButtons);   //these buttons are red
var activeImgArray = new Array(numButtons); //these buttons are brown
var bannerImgArray = new Array(numButtons); //these buttons are brown

var i;
//create the off images (onMouseOut)
for(i=0;i<numButtons;i++){
	offImgArray[i] = new Image();
	offImgArray[i].src = imgDirectory+button_names[i]+"_blue.gif";
}

//create the on images (onMouseOver)
for(i=0;i<numButtons;i++){
	onImgArray[i] = new Image();
	onImgArray[i].src = imgDirectory+button_names[i]+"_red.gif";
}

//create the active images (whichever is the topmost ancestor of current article)
for(i=0;i<numButtons;i++){
	activeImgArray[i] = new Image();
	activeImgArray[i].src = imgDirectory+button_names[i]+"_grey.gif";
}

//create the banner images (whichever is the topmost ancestor of current article)
for(i=0;i<numButtons;i++){
	bannerImgArray[i] = new Image();
	bannerImgArray[i].src = imgDirectory+"continent_"+button_names[topLevelIndex]+".gif";
}


//--------------------------------------------------------------------
// * doMouseOverButton
//--------------------------------------------------------------------
function doMouseOverButton(theName){
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
	/* When at "world" level there are no buttons to be activated */
	if (topLevelIndex != getIndexFor(world)) {
		theName = button_names[topLevelIndex];
		document.images[theName].src = activeImgArray[topLevelIndex].src;
	}
}

//--------------------------------------------------------------------
// * doBannerImage
//--------------------------------------------------------------------
function doBannerImage(){

	document.images["banner"].src = bannerImgArray[topLevelIndex].src;
	
}

function getIndexFor(item) {

  var i;
  for (i=0; i<numButtons; i++) {
    if (item == button_names[i]) return i;
  }
  for (i=0; i<numButtons; i++) {
    if (item == article_names[i]) return i;
  }
  return -1;	//not found

}

// END OF ROLLOVERS_ENCYC.JS
